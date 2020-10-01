<script>
    var DatatableBasic = function () {
        //
        // Setup module components
        //
        var _componentNoty = function () {
            if (typeof Noty == 'undefined') {
                console.warn('Warning - noty.min.js is not loaded.');
                return;
            }

            // Override Noty defaults
            Noty.overrideDefaults({
                theme: 'limitless',
                layout: 'topRight',
                type: 'alert',
                timeout: 2500
            });
        };
        // Sweet Alerts
        var _componentSweetAlert = function () {
            if (typeof swal == 'undefined') {
                console.warn('Warning - sweet_alert.min.js is not loaded.');
                return;
            }

            // Defaults
            var setCustomDefaults = function () {
                swal.setDefaults({
                    buttonsStyling: false,
                    confirmButtonClass: 'btn btn-primary',
                    cancelButtonClass: 'btn btn-light'
                });
            }
            setCustomDefaults();
        };
        // Basic Datatable examples
        var _componentDatatableBasic = function () {
            if (!$().DataTable) {
                console.warn('Warning - datatables.min.js is not loaded.');
                return;
            }

            // Setting datatable defaults
            $.extend($.fn.dataTable.defaults, {
                autoWidth: false,
                columnDefs: [{
                    orderable: false,
                    width: 100,
                    targets: [3]
                }],
                dom: '<"datatable-header"fBl><"datatable-scroll-wrap"t><"datatable-footer"ip>',
                language: {
                    search: '<span>Search:</span> _INPUT_',
                    searchPlaceholder: 'Type to filter...',
                    lengthMenu: '<span>Show:</span> _MENU_',
                    paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
                }
            });

            // Basic datatable
            $('.datatable-basic').DataTable({
                columnDefs: [
                    {
                        targets: -1,
                        className: 'noVis'
                    }
                ],
                buttons: [
                    {
                        extend: 'colvis',
                        text: '<i class="icon-grid7"></i>',
                        className: 'btn bg-teal-400 btn-icon dropdown-toggle',
                        postfixButtons: ['colvisRestore'],
                        columns: ':not(.noVis)'
                    },
                    {
                        extend: 'copy',
                        exportOptions: {
                            columns: [':visible:not(:last-child)']
                        },
                        className: 'btn btn-light'
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: [':visible:not(:last-child)']
                        },
                        className: 'btn btn-light'
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [':visible:not(:last-child)']
                        },
                        className: 'btn btn-light'
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [':visible:not(:last-child)']
                        },
                        className: 'btn btn-light'
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [':visible:not(:last-child)']
                        },
                        className: 'btn btn-light'
                    }
                ],
            });
        };

        // Select2 for length menu styling
        var _componentSelect2 = function () {
            if (!$().select2) {
                console.warn('Warning - select2.min.js is not loaded.');
                return;
            }

            // Initialize
            $('.dataTables_length select').select2({
                minimumResultsForSearch: Infinity,
                dropdownAutoWidth: true,
                width: 'auto'
            });

             // Default initialization
             $('.select').select2({
                minimumResultsForSearch: Infinity
            });

            // Select with search
            $('.select-search').select2();
        };

        // Validation config
        var _componentValidation = function () {
            if (!$().validate) {
                console.warn('Warning - validate.min.js is not loaded.');
                return;
            }
            // Initialize
            var validator = $('.form-validate-jquery').validate({
                ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
                errorClass: 'validation-invalid-label',
                successClass: 'validation-valid-label',
                validClass: 'validation-valid-label',
                highlight: function (element, errorClass) {
                    $(element).removeClass(errorClass);
                },
                unhighlight: function (element, errorClass) {
                    $(element).removeClass(errorClass);
                },
                // success: function(label) {
                //     label.addClass('validation-valid-label').text('Success.'); // remove to hide Success message
                // },
            });

            // Reset form
            $('#reset').on('click', function () {
                validator.resetForm();
            });
        };

        // Anytime picker
        var _componentAnytime = function() {
            if (!$().AnyTime_picker) {
                console.warn('Warning - anytime.min.js is not loaded.');
                return;
            }
            $('.anytime-time').AnyTime_picker({
                format: '%H:%i'
            });
            // Time picker
            // var $anytime = $('.anytime-time').AnyTime_picker();

        };

        //Picka date
        var _componentPickADate = function () {
            $('.pickadate').pickadate({
                selectMonths: true,
                selectYears: 75,
                format: 'dd/mm/yyyy',
                formatSubmit: 'yyyy/mm/dd',
                hiddenName: true,
            });
        };

        // Uniform
        var _componentUniform = function() {
            if (!$().uniform) {
                console.warn('Warning - uniform.min.js is not loaded.');
                return;
            }

            // Initialize
            $('.form-input-styled').uniform({
                fileButtonClass: 'action btn bg-pink-400'
            });

            // // Initialize
            // $('.form-input-styled').uniform({
            //     fileButtonClass: 'action btn bg-blue'
            // });

        };

        return {
            init: function () {
                _componentNoty();
                _componentUniform();
                _componentDatatableBasic();
                _componentSelect2();
                _componentPickADate();
                _componentValidation();
                _componentSweetAlert();
                _componentAnytime();
            }
        }
    }();
    // Initialize module
    // ------------------------------
    var dataTable = "";
    var TotalValue = 0;

    document.addEventListener('DOMContentLoaded', function () {
        $(window).keydown(function (event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });

        DatatableBasic.init();

    });

    function FeeGroupDetails(value) {
        return new Promise(resolve => {
            axios.get("/FeeGroupDetails",{params: { "fee_type": value } }).then(response => {
                console.log(response.data);
                $('.FeeGroupDetailsAppendDiv').html(response.data);
                resolve(1)
            }).catch(error => {
                console.log(error);
            })
        })
    }

    function checkAll(ele) {
        var checkboxes = document.getElementsByTagName('input');
        if (ele.checked) {
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].type == 'checkbox') {
                    checkboxes[i].checked = true;
                }
            }
        } else {
            for (var i = 0; i < checkboxes.length; i++) {
                console.log(i)
                if (checkboxes[i].type == 'checkbox') {
                    checkboxes[i].checked = false;
                }
            }
        }
    }

    $("input[name='fee_group[fee_name_id][]']:checked").each(function ()
    {
        TotalValue = parseFloat(TotalValue) + parseFloat($(this).attr("data-on-value"));
    });
    $('.TotalValue').html(TotalValue);

    function gettotalAmount(elem){
        if(elem.checked == true){
            TotalValue = parseFloat(TotalValue) + parseFloat($(elem).attr("data-on-value"));
        }else{
            TotalValue = parseFloat(TotalValue) - parseFloat($(elem).attr("data-on-value"));
        }
        $('.TotalValue').html(TotalValue);
    }
</script>
