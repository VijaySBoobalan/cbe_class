(function ($) {
    $.fn.examWizard = function (options) {
        var _defaults = {
            currentQuestionSelector: "#currentQuestionNumber",
            totalOfQuestionSelector: "#totalOfQuestion",
            formSelector: ".OnlineTest-question",
            currentQuestionLabel: "#current-question-number-label",
            alternateNameAttr: "data-alternateName",
            alternateValueAttr: "data-alternateValue",
            alternateTypeAttr: "data-alternateType",
            quickAccessOption: {
                quickAccessSection: "#quick-access-section",
                enableAccessSection: !0,
                quickAccessPagerItem: "Full",
                quickAccessInfoSelector: "#quick-access-info",
                quickAccessPrevSelector: "#quick-access-prev",
                quickAccessNextSelector: "#quick-access-next",
                quickAccessInfoSeperator: "/",
                quickAccessRow: ".question-response-rows",
                quickAccessRowValue: ".question-response-rows-value",
                quickAccessDefaultRowVal: "-",
                quickAccessRowValSeparator: ", ",
                nextCallBack: function () {},
                prevCallBack: function () {},
            },
            nextOption: {
                nextSelector: ".go_to_next_question",
                allowadNext: !0,
                callBack: function () {},
                breakNext: function () {
                    return !1;
                },
            },
            prevOption: {
                prevSelector: ".back_to_prev_question",
                allowadPrev: !0,
                allowadPrevOnQNum: 2,
                callBack: function () {},
                breakPrev: function () {
                    return !1;
                },
            },
            finishOption: {
                enableAndDisableFinshBtn: !0,
                enableFinishButtonAtQNum: "onLastQuestion",
                finishBtnSelector: "#finishExams",
                enableModal: !1,
                finishModalTarget: "#finishExamsModal",
                finishModalAnswerd: ".finishExams-total-answerd",
                finishModalMarked: ".finishExams-total-marked",
                finishModalRemaining: ".finishExams-total-remaining",
                callBack: function () {},
            },
            markOption: {
                markSelector: ".mark-question",
                unmarkSelector: ".unmark-question",
                markedLinkSelector: ".marked-link",
                markedQuestionsSelector: "#markedQuestion",
                markedLabel: "Marked",
                markUnmarkWrapper: ".mark-unmark-wrapper",
                enableMarked: !0,
                markCallBack: function () {},
                unMarkCallBack: function () {},
            },
            cookiesOption: { enableCookie: !1, cookieKey: "", expires: 1 * 24 * 60 * 60 * 1000 },
        };
        var settings = $.extend(!0, {}, _defaults, options);
        function _getMarkedValue() {
            var markedValues = $(settings.markOption.markedQuestionsSelector).val();
            markedValues = JSON.parse(markedValues);
            return markedValues;
        }
        function _getCurrentQuestionNumber() {
            // return parseInt($(settings.currentQuestionSelector).val());
            return parseInt($('#currentQuestionNumber').val());
        }
        function _getPrevQuestionNumber() {
            return _getCurrentQuestionNumber() - 1;
        }
        function _getNextQuestionNumber() {
			// alert(_getCurrentQuestionNumber);
            return _getCurrentQuestionNumber() + 1;
        }
        function _getTotalOfQuestion() {
            return parseInt($(settings.totalOfQuestionSelector).val());
        }
        function _getAllFormData(alternateName = !1) {
            if (alternateName) {
                return $("[" + settings.alternateNameAttr + "]").serializeArray();
            }
            return $(settings.formSelector).serializeArray();
        }
        $(document).on("click", settings.nextOption.nextSelector, function () {
            var currentQuestionNumber = _getCurrentQuestionNumber();
            var currentNextQuestionNumber = _getNextQuestionNumber();
            var totalOfQuestion = _getTotalOfQuestion();
            var breakNext = settings.nextOption.breakNext();
            if (breakNext) {
                return 0;
            }
            if (currentQuestionNumber < totalOfQuestion && settings.nextOption.allowadNext) {
				
                $(settings.currentQuestionSelector).val(currentNextQuestionNumber);
                $(settings.formSelector + ' [data-question="' + currentQuestionNumber + '"]').addClass("hidden");
                $(settings.formSelector + ' [data-question="' + currentNextQuestionNumber + '"]').removeClass("hidden");
                updateCurrentQuestionNumberLabel(currentNextQuestionNumber);
                if (settings.prevOption.allowadPrev && currentNextQuestionNumber >= settings.prevOption.allowadPrevOnQNum) {
                    $(settings.prevOption.prevSelector).removeClass("disabled");
                }
                _enableAndDisableFinishButton();
                markUnMarkWrapperToggle(currentNextQuestionNumber);
                settings.nextOption.callBack();
            }
            if (totalOfQuestion == currentNextQuestionNumber || !settings.nextOption.allowadNext) {
                $(settings.nextOption.nextSelector).addClass();
            }
        });
        $(document).on("click", settings.prevOption.prevSelector, function () {
            var currentQuestionNumber = _getCurrentQuestionNumber();
            var currentPrevQuestionNumber = _getPrevQuestionNumber();
            var breakPrev = settings.prevOption.breakPrev();
            if (breakPrev) {
                return 0;
            }
            if (currentQuestionNumber > 1 && settings.prevOption.allowadPrev) {
                $(settings.currentQuestionSelector).val(currentPrevQuestionNumber);
                $(settings.formSelector + ' [data-question="' + currentQuestionNumber + '"]').addClass("hidden");
                $(settings.formSelector + ' [data-question="' + currentPrevQuestionNumber + '"]').removeClass("hidden");
                updateCurrentQuestionNumberLabel(currentPrevQuestionNumber);
                if (settings.nextOption.allowadNext) {
                    $(settings.nextOption.nextSelector).removeClass("disabled");
                }
                _enableAndDisableFinishButton();
                markUnMarkWrapperToggle(currentPrevQuestionNumber);
                settings.prevOption.callBack();
            }
            if (currentPrevQuestionNumber <= 1 || !settings.prevOption.allowadPrev || currentPrevQuestionNumber < settings.prevOption.allowadPrevOnQNum) {
                $(settings.prevOption.prevSelector).addClass("disabled");
            }
        });
        $(document).on("click", settings.markOption.markSelector, function () {
            var currentQNumber = $(this).data("question");
            updateMarkOnQuickAccess(currentQNumber, 0);
            handlingMarkCookies();
            settings.markOption.markCallBack();
        });
        $(document).on("click", settings.markOption.unmarkSelector, function () {
            var currentQNumber = $(this).data("question");
            updateMarkOnQuickAccess(currentQNumber, 1);
            handlingMarkCookies();
            settings.markOption.unMarkCallBack();
        });
        $(document).on("click", settings.markOption.markedLinkSelector, function () {
            var markedQuestionNumber = $(this).data("question");
            var totalOfQuestion = _getTotalOfQuestion();
            $(settings.currentQuestionSelector).val(markedQuestionNumber);
            $(settings.formSelector + " [data-question]").addClass("hidden");
            $(settings.formSelector + ' [data-question="' + markedQuestionNumber + '"]').removeClass("hidden");
            updateCurrentQuestionNumberLabel(markedQuestionNumber);
            markUnMarkWrapperToggle(markedQuestionNumber);
            if (markedQuestionNumber <= 1 || !settings.prevOption.allowadPrev || markedQuestionNumber < settings.prevOption.allowadPrevOnQNum) {
                $(settings.prevOption.prevSelector).addClass("disabled");
            } else {
                $(settings.prevOption.prevSelector).removeClass("disabled");
            }
            if (totalOfQuestion == markedQuestionNumber || !settings.nextOption.allowadNext) {
                $(settings.nextOption.nextSelector).addClass("disabled");
            } else {
                $(settings.nextOption.nextSelector).removeClass("disabled");
            }
        });
        $(document).on("click", settings.finishOption.finishBtnSelector, function () {
            var totalQuestion = _getTotalOfQuestion();
            var currentQuestionNumber = _getCurrentQuestionNumber();
            if (validateIfIsInteger(settings.finishOption.enableFinishButtonAtQNum)) {
                totalQuestion = settings.finishOption.enableFinishButtonAtQNum;
            }
            if (currentQuestionNumber >= totalQuestion) {
                if (settings.finishOption.enableModal) {
                    $(settings.finishOption.finishModalAnswerd).html(getTotalOfAnswerdQuestion());
                    $(settings.finishOption.finishModalMarked).html(getTotalOfMarkedQuestion());
                    $(settings.finishOption.finishModalRemaining).html(getTotalOfRemainingQuestion());
                    $(settings.finishOption.finishModalTarget).modal("show");
                }
                settings.finishOption.callBack();
            }
        });
        $(document).on("click", settings.quickAccessOption.quickAccessPrevSelector, function () {
            if (settings.quickAccessOption.enableAccessSection) {
                quickAccessAction("Prev");
                setQuickAccessResponseForAllData();
                settings.quickAccessOption.prevCallBack();
            }
        });
        $(document).on("click", settings.quickAccessOption.quickAccessNextSelector, function () {
            if (settings.quickAccessOption.enableAccessSection) {
                quickAccessAction("Next");
                setQuickAccessResponseForAllData();
                settings.quickAccessOption.nextCallBack();
            }
        });
        $(document).on("change select keyup", "[" + settings.alternateNameAttr + "]", function () {
            var currentQNumber = _getCurrentQuestionNumber();
            var answerdValue = getAllAnswerdValue(!0, !0, $(this).attr("name"));
            var markedValues = _getMarkedValue();
            if (!$.isEmptyObject(answerdValue)) {
                _convertAnswerdToReadAnswerd(answerdValue);
                if (settings.cookiesOption.enableCookie) {
                    handlingCookies(answerdValue);
                }
            } else {
                var fieldVal = null;
                if (settings.markOption.enableMarked && markedValues.indexOf(currentQNumber) > -1) {
                    fieldVal = getMarkedLink(currentQNumber);
                }
                setQuickAccessResponseValue(fieldVal, currentQNumber);
                if (settings.cookiesOption.enableCookie) {
                    deleteCookie($(this).attr("name"));
                }
            }
        });
        function getAllAnswerdValue(groupingData = !1, getAlternateAnswerdOnly = !0, fieldName = !1) {
            var formsValue = _getAllFormData(getAlternateAnswerdOnly);
            if (fieldName) {
                formsValue = $('[name="' + fieldName + '"]').serializeArray();
            }
            var result = {};
            var resultCounter = 0;
            for (var i = 0; i < formsValue.length; i++) {
                if (!formsValue[i].value) {
                    continue;
                }
                var tempVal = $("[name='" + formsValue[i].name + "'][value='" + formsValue[i].value.replace(/'/g, '"') + "']");
                if (!tempVal.attr(settings.alternateNameAttr)) {
                    tempVal = $("[name='" + formsValue[i].name + "']");
                }
                if (tempVal.attr(settings.alternateTypeAttr) === "select") {
                    var selectFieldData = tempVal.find("option:selected");
                    selectFieldData.each(function () {
                        if ($(this).val() === formsValue[i].value) {
                            tempVal.attr(settings.alternateValueAttr, $(this).attr(settings.alternateValueAttr));
                        }
                    });
                }
                var currentQNumber = tempVal.parents("[data-question]").data("question");
                var objResult = { name: formsValue[i].name, value: formsValue[i].value, alternateName: tempVal.attr(settings.alternateNameAttr), alternateValue: tempVal.attr(settings.alternateValueAttr), currentQNumber: currentQNumber };
                if (groupingData) {
                    if (!result[formsValue[i].name]) {
                        result[formsValue[i].name] = {};
                    }
                    result[formsValue[i].name][i] = objResult;
                } else {
                    result[resultCounter++] = objResult;
                }
            }
            return result;
        }
        function markUnMarkWrapperToggle(currentQuestionNumber) {
            if (settings.markOption.enableMarked) {
                $(settings.markOption.markUnmarkWrapper).addClass("hidden");
                $(settings.markOption.markUnmarkWrapper + '[data-question="' + currentQuestionNumber + '"]').removeClass("hidden");
            }
        }
        function getMarkedLink(currentQuestionNumber = 0) {
            var markedLinkClass = settings.markOption.markedLinkSelector.substr(1);
            return '<a href="javascript:void(0);" class="' + markedLinkClass + '" data-question="' + currentQuestionNumber + '">' + settings.markOption.markedLabel + "</a>";
        }
        function _enableAndDisableFinishButton() {
            if (settings.finishOption.enableAndDisableFinshBtn === !0) {
                var totalQuestion = _getTotalOfQuestion();
                var currentQuestionNumber = _getCurrentQuestionNumber();
                if (validateIfIsInteger(settings.finishOption.enableFinishButtonAtQNum)) {
                    totalQuestion = settings.finishOption.enableFinishButtonAtQNum;
                }
                if (currentQuestionNumber >= totalQuestion) {
                    $(settings.finishOption.finishBtnSelector).removeClass("disabled");
                } else {
                    $(settings.finishOption.finishBtnSelector).addClass("disabled");
                }
            }
        }
        function updateCurrentQuestionNumberLabel(questionNumber) {
            $(settings.currentQuestionLabel).html(questionNumber);
        }

        if (settings.quickAccessOption.enableAccessSection) {
            controlQuickAccessWithPager();
        }
        function controlQuickAccessWithPager() {
            var group = settings.quickAccessOption.quickAccessPagerItem;
            if (settings.quickAccessOption.quickAccessPagerItem !== "Full" && validateIfIsInteger(group)) {
                var total = _getTotalOfQuestion();
                var numberOfGroub = Math.ceil(total / group);
                var currentPage = $(settings.quickAccessOption.quickAccessInfoSelector).attr("data-current-page");
                if (!currentPage) {
                    currentPage = 1;
                    $(settings.quickAccessOption.quickAccessInfoSelector).attr("data-current-page", currentPage);
                }
                if (currentPage == 1) {
                    $(settings.quickAccessOption.quickAccessPrevSelector).addClass("disabled");
                } else if (currentPage == numberOfGroub) {
                    $(settings.quickAccessOption.quickAccessNextSelector).addClass("disabled");
                }
                updateQuickAccessInfo(currentPage, numberOfGroub);
            }
        }
        function quickAccessAction(action) {
            var currentPage = $(settings.quickAccessOption.quickAccessInfoSelector).attr("data-current-page");
            var total = _getTotalOfQuestion();
            var group = settings.quickAccessOption.quickAccessPagerItem;
            var numberOfGroub = Math.ceil(total / group);
            if (action === "Next") {
                currentPage++;
            } else {
                currentPage--;
            }
            if (currentPage >= numberOfGroub) {
                $(settings.quickAccessOption.quickAccessNextSelector).addClass("disabled");
            } else {
                $(settings.quickAccessOption.quickAccessNextSelector).removeClass("disabled");
            }
            if (currentPage <= 1) {
                $(settings.quickAccessOption.quickAccessPrevSelector).addClass("disabled");
            } else {
                $(settings.quickAccessOption.quickAccessPrevSelector).removeClass("disabled");
            }
            if (currentPage > numberOfGroub || currentPage < 1) {
                return !1;
            }
            $(settings.quickAccessOption.quickAccessInfoSelector).attr("data-current-page", currentPage);
            updateQuickAccessInfo(currentPage, numberOfGroub);
        }
        function updateQuickAccessInfo(start, end, group = 0) {
            if (group === 0) {
                group = settings.quickAccessOption.quickAccessPagerItem;
                if (settings.quickAccessOption.quickAccessPagerItem === "Full" || !validateIfIsInteger(group)) {
                    return;
                }
            }
            var currentPage = $(settings.quickAccessOption.quickAccessInfoSelector).attr("data-current-page");
            $(settings.quickAccessOption.quickAccessSection + " [data-question]").hide();
            $(settings.quickAccessOption.quickAccessSection + " [data-question]:nth-child(-n+" + group * currentPage + ")").show();
            if (currentPage > 1) {
                $(settings.quickAccessOption.quickAccessSection + " [data-question]:nth-child(-n+" + group * (currentPage - 1) + ")").hide();
            }
            $(settings.quickAccessOption.quickAccessInfoSelector).html(start + " " + settings.quickAccessOption.quickAccessInfoSeperator + " " + end);
        }
        function setQuickAccessResponseForAllData() {
            var answerdValue = getAllAnswerdValue(!0);
            var listOfNames = _convertAnswerdToReadAnswerd(answerdValue);
            var allFields = $("[" + settings.alternateNameAttr + "]");
            allFields.each(function (index) {
                var allFieldsName = $(this).attr("name");
                if (!(listOfNames.indexOf(allFieldsName) > -1)) {
                    var currentQNumber = $('[name="' + allFieldsName + '"]')
                        .parents("[data-question]")
                        .data("question");
                    setQuickAccessResponseValue(null, currentQNumber);
                }
            });
            if (settings.markOption.enableMarked) {
                updateAllMarkOnQuickAccess();
            }
        }
        function setQuickAccessResponseValue(fieldVal, currentQuestionNumber) {
            if (!fieldVal) {
                fieldVal = settings.quickAccessOption.quickAccessDefaultRowVal;
            }
            $(settings.quickAccessOption.quickAccessRow + '[data-question="' + currentQuestionNumber + '"]' + " " + settings.quickAccessOption.quickAccessRowValue).html(fieldVal);
        }
        function _convertAnswerdToReadAnswerd(answerdValue, updateResponse = !0, getAnswerdString = !1) {
            var listOfNamesCounter = 0;
            var listOfNames = new Array();
            var listOfAnswerdCounter = 0;
            var listOfAnswerd = new Array();
            var markedValues = _getMarkedValue();
            var flagMarked = !1;
            if (!$.isEmptyObject(answerdValue)) {
                for (var key in answerdValue) {
                    if (answerdValue.hasOwnProperty(key)) {
                        var answerdValue2 = answerdValue[key];
                        var rowValue = new Array();
                        var counter = 0;
                        for (var key2 in answerdValue2) {
                            rowValue[counter] = answerdValue2[key2].alternateValue;
                            listOfNames[listOfNamesCounter++] = answerdValue2[key2].name;
                            var currentQuestionNumber = answerdValue2[key2].currentQNumber;
                            if (!rowValue[counter]) {
                                rowValue[counter] = answerdValue2[key2].value;
                            }
                            counter++;
                        }
                    }
                    var val = rowValue.join(settings.quickAccessOption.quickAccessRowValSeparator);
                    listOfAnswerd[listOfAnswerdCounter++] = val;
                    if (settings.markOption.enableMarked) {
                        flagMarked = markedValues.indexOf(currentQuestionNumber) > -1;
                    }
                    if (updateResponse && !flagMarked) {
                        setQuickAccessResponseValue(val, currentQuestionNumber);
                    } else if (flagMarked) {
                        updateMarkOnQuickAccess(currentQuestionNumber, 2);
                    }
                }
            }
            if (getAnswerdString) {
                return listOfAnswerd;
            }
            return listOfNames;
        }
        function updateMarkOnQuickAccess(currentQNumber, type) {
            var fieldObj = $("[" + settings.alternateNameAttr + '="answer[' + (currentQNumber - 1) + ']"]');
            var answerdValue = getAllAnswerdValue(!0, !0, fieldObj.attr("name"));
            var markedLink = getMarkedLink(currentQNumber);
            var accessObj = $(settings.quickAccessOption.quickAccessRow + '[data-question="' + currentQNumber + '"]' + " " + settings.quickAccessOption.quickAccessRowValue);
            var markButton = $(settings.markOption.markSelector + '[data-question="' + currentQNumber + '"]');
            var unmarkButton = $(settings.markOption.unmarkSelector + '[data-question="' + currentQNumber + '"]');
            var markedValues = _getMarkedValue();
            if (type === 0) {
                markButton.addClass("hidden");
                unmarkButton.removeClass("hidden");
                markedValues.push(currentQNumber);
                $(settings.markOption.markedQuestionsSelector).val(JSON.stringify(markedValues));
                accessObj.html(markedLink);
            } else if (type === 1) {
                markButton.removeClass("hidden");
                unmarkButton.addClass("hidden");
                markedValues.splice(markedValues.indexOf(currentQNumber), 1);
                $(settings.markOption.markedQuestionsSelector).val(JSON.stringify(markedValues));
                if (!$.isEmptyObject(answerdValue)) {
                    _convertAnswerdToReadAnswerd(answerdValue);
                } else {
                    setQuickAccessResponseValue(null, currentQNumber);
                }
            } else if (type === 2) {
                accessObj.html(markedLink);
            }
        }
        function updateAllMarkOnQuickAccess() {
            var markedValues = _getMarkedValue();
            for (var key in markedValues) {
                var currentQNumber = markedValues[key];
                var markedLink = getMarkedLink(currentQNumber);
                var accessObj = $(settings.quickAccessOption.quickAccessRow + '[data-question="' + currentQNumber + '"]' + " " + settings.quickAccessOption.quickAccessRowValue);
                accessObj.html(markedLink);
            }
        }
        function validateIfIsInteger(value) {
            return /^\d+$/.test(value);
        }
        function setCookie(cname, cvalue) {
            cname += settings.cookiesOption.cookieKey;
            var d = new Date();
            d.setTime(d.getTime() + settings.cookiesOption.expires);
            var expires = "expires=" + d.toUTCString();
            document.cookie = cname + "=" + cvalue.replace(/;/g, ",") + "{sep};" + expires + ";path=/";
        }
        function getCookie(allCookies = !0, cname = "") {
            cname += settings.cookiesOption.cookieKey;
            var name = cname + "=";
            var decodedCookie = decodeURIComponent(document.cookie);
            var ca = decodedCookie.split("{sep};");
            var result = new Array();
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == " ") {
                    c = c.substring(1);
                }
                if ((allCookies || c.indexOf(name) == 0) && c.indexOf(settings.cookiesOption.cookieKey) > -1) {
                    c = c.replace(settings.cookiesOption.cookieKey, "");
                    if (allCookies) {
                        var currentQNumber = c.substr(0, c.indexOf("="));
                        result[currentQNumber] = c.substring(c.indexOf("=") + 1, c.length);
                    } else {
                        return c.substring(name.length, c.length);
                    }
                }
            }
            if (allCookies) {
                return result;
            }
            return "";
        }
        function deleteCookie(cname) {
            cname += settings.cookiesOption.cookieKey;
            document.cookie = cname + "=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path=/";
        }
        function handlingCookies(answerdValue) {
            for (var key in answerdValue) {
                var answerdValue2 = answerdValue[key];
                var rowValue = new Array();
                var counter = 0;
                for (var key2 in answerdValue2) {
                    rowValue[counter] = answerdValue2[key2].value;
                    var currentQNumber = answerdValue2[key2].name;
                    counter++;
                }
                var val = rowValue.join("{sep}");
                setCookie(currentQNumber, val);
            }
        }
        function handlingMarkCookies(values) {
            var markedValue = $(settings.markOption.markedQuestionsSelector).val();
            setCookie(settings.markOption.markedQuestionsSelector, markedValue);
        }
        if (settings.cookiesOption.enableCookie) {
            $(settings.currentQuestionSelector).val(1);
            loadAnswersFromCookies();
        }
        function loadAnswersFromCookies() {
            var oldResult = getCookie();
            for (var key in oldResult) {
                var obj = $("[name='" + key + "']");
                if (key == settings.markOption.markedQuestionsSelector && settings.markOption.enableMarked) {
                    var nameQS = $(settings.markOption.markedQuestionsSelector).attr("name");
                    obj = $("[name='" + nameQS + "']");
                }
                var item = oldResult[key].split("{sep}");
                var tempV = new Array();
                var count = 0;
                for (var key2 in item) {
                    if (item[key2] == "") {
                        continue;
                    }
                    tempV[count++] = item[key2];
                    if (obj.data("alternatetype") === "checkbox" || obj.data("alternatetype") === "radio") {
                        $("[name='" + key + "'][value='" + item[key2] + "']").prop("checked", !0);
                    } else {
                        obj.val(item[key2]);
                    }
                }
                if (obj.data("alternatetype") === "select") {
                    obj.val(tempV);
                }
            }
            if (settings.quickAccessOption.enableAccessSection) {
                setQuickAccessResponseForAllData();
            }
            if (settings.markOption.enableMarked) {
                var markedValues = _getMarkedValue();
                for (var keyM in markedValues) {
                    var markButton = $(settings.markOption.markSelector + '[data-question="' + markedValues[keyM] + '"]');
                    var unmarkButton = $(settings.markOption.unmarkSelector + '[data-question="' + markedValues[keyM] + '"]');
                    markButton.addClass("hidden");
                    unmarkButton.removeClass("hidden");
                }
            }
        }
        function getTotalOfAnswerdQuestion() {
            var answers = getAllAnswerdValue(!0, !0);
            return Object.keys(answers).length;
        }
        function getTotalOfMarkedQuestion() {
            var markeds = _getMarkedValue();
            return Object.keys(markeds).length;
        }
        function getTotalOfRemainingQuestion() {
            var total = _getTotalOfQuestion();
            var remaning = total - getTotalOfAnswerdQuestion();
            return remaning;
        }
        return {
            getMarkedQuestion: function () {
                return _getMarkedValue();
            },
            getAnswerdValue: function (groupingData = !0, fieldWithAlternateNameOnly = !0) {
                return getAllAnswerdValue(groupingData, fieldWithAlternateNameOnly);
            },
            getTotalOfAnswerdValue: function () {
                return getTotalOfAnswerdQuestion();
            },
            getTotalOfMarkedValue: function () {
                return getTotalOfMarkedQuestion();
            },
            getTotalOfRemainingValue: function () {
                return getTotalOfRemainingQuestion();
            },
            getCurrentQuestionNumber: function () {
                return _getCurrentQuestionNumber();
            },
            getAllFormData: function () {
                return _getAllFormData();
            },
        };
    };
})(jQuery);
