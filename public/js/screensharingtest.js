var server = null;

if (window.location.protocol === 'http:')
    server = "http://" + "ttsvle.in" + ":8088/janus";
else
    server = "https://" + "ttsvle.in" + ":8089/janus";

var janus = null;
var screentest = null;
var opaqueId = "screensharingtest-" + Janus.randomString(12);

var mixertest = null;
var myusername = null;
var myid = null;
let blobs;
let blob;
var capture = null;
var role = null;
var room = null;
var source = null;
var myroom = null; // AUDIO
var webrtcUp = false; // AUDIO
var spinner = null;
var audioenabled = false;


// Just an helper to generate random usernames
function randomString(len, charSet) {
    charSet = charSet || 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var randomString = '';
    for (var i = 0; i < len; i++) {
        var randomPoz = Math.floor(Math.random() * charSet.length);
        randomString += charSet.substring(randomPoz, randomPoz + 1);
    }
    return randomString;
}


$(document).ready(function() {
    // Initialize the library (all console debuggers enabled)
    Janus.init({
        debug: "all",
        callback: function() {
            // Use a button to start the demo
            $('#start').one('click', function() {
                $(this).attr('disabled', true).unbind('click');
                // Make sure the browser supports WebRTC
                if (!Janus.isWebrtcSupported()) {

                    bootbox.alert("No WebRTC support... ");
                    return;
                }
                // Create session
                janus = new Janus({
                    server: server,
                    success: function() {
                        // Attach to VideoRoom plugin
                        janus.attach({
                            plugin: "janus.plugin.videoroom",
                            opaqueId: opaqueId,
                            success: function(pluginHandle) {
                                $('#details').remove();
                                screentest = pluginHandle;
                                Janus.log("Plugin attached! (" + screentest.getPlugin() + ", id=" + screentest.getId() + ")");
                                // Prepare the username registration
                                $('#screenmenu').removeClass('hide').show();
                                $('#createnow').removeClass('hide').show();
                                $('#create').click(preShareScreen);
                                $('#joinnow').removeClass('hide').show();
                                $('#join').click(joinScreen);
                                $('#desc').focus();
                                $("#create").trigger('click');
                                $('#start').removeAttr('disabled').html("Stop")
                                    .click(function() {
                                        stop_live();
                                        $(this).attr('disabled', true);
                                        janus.destroy();
                                    });
                            },
                            error: function(error) {
                                Janus.error("  -- Error attaching plugin...", error);

                                bootbox.alert("Error attaching plugin... " + error);
                            },
                            consentDialog: function(on) {
                                Janus.debug("Consent dialog should be " + (on ? "on" : "off") + " now");
                                if (on) {

                                    $.blockUI({
                                        message: '',
                                        css: {
                                            border: 'none',
                                            padding: '15px',
                                            backgroundColor: 'transparent',
                                            color: '#aaa'
                                        }
                                    });
                                } else {

                                    $.unblockUI();
                                }
                            },
                            iceState: function(state) {

                                Janus.log("ICE state changed to " + state);
                            },
                            mediaState: function(medium, on) {
                                Janus.log("Janus " + (on ? "started" : "stopped") + " receiving our " + medium);
                            },
                            webrtcState: function(on) {
                                Janus.log("Janus says our WebRTC PeerConnection is " + (on ? "up" : "down") + " now");
                                $("#screencapture").parent().unblock();
                                if (on) {
                                    $('#session_id').val(room);
                                    $("#register").trigger('click'); //AUDIO USE
                                    StaffAttendence();
                                } else {
                                    // bootbox.alert("Please Try Again.", function() {
                                        // janus.destroy();
										// preShareScreen();
                                        // window.location.reload();
										var display=randomString(12);
										newRemoteFeed(room, display);
                                    // });
                                }
                            },
                            onmessage: function(msg, jsep) {
                                Janus.debug(" ::: Got a message (publisher) :::", msg);
                                var event = msg["videoroom"];
                                Janus.debug("Event: " + event);
                                if (event) {
                                    if (event === "joined") {
                                        myid = msg["id"];
                                        $('#session').html(room);
                                        $('#title').html(msg["description"]);
                                        Janus.log("Successfully joined room " + msg["room"] + " with ID " + myid);
                                        if (role === "publisher") {
                                            // This is our session, publish our stream
                                            Janus.debug("Negotiating WebRTC stream for our screen (capture " + capture + ")");
                                            screentest.createOffer({
                                                media: { video: capture, audioSend: true, videoRecv: true }, // Screen sharing Publishers are sendonly
                                                success: function(jsep) {
                                                    Janus.debug("Got publisher SDP!", jsep);
                                                    var publish = { request: "configure", audio: true, video: true };
                                                    screentest.send({ message: publish, jsep: jsep });
                                                },
                                                error: function(error) {
                                                    Janus.error("WebRTC error:", error);

                                                    bootbox.alert("WebRTC error... " + error.message);
                                                }
                                            });
                                        } else {
                                            // We're just watching a session, any feed to attach to?
                                            if (msg["publishers"]) {
                                                var list = msg["publishers"];
                                                Janus.debug("Got a list of available publishers/feeds:", list);
                                                for (var f in list) {
                                                    var id = list[f]["id"];
                                                    var display = list[f]["display"];
                                                    Janus.debug("  >> [" + id + "] " + display);
                                                    newRemoteFeed(id, display)
                                                }
                                            }
                                        }
                                    } else if (event === "event") {
                                        // Any feed to attach to?
                                        if (role === "listener" && msg["publishers"]) {
                                            var list = msg["publishers"];
                                            Janus.debug("Got a list of available publishers/feeds:", list);
                                            for (var f in list) {
                                                var id = list[f]["id"];
                                                var display = list[f]["display"];
                                                Janus.debug("  >> [" + id + "] " + display);
                                                newRemoteFeed(id, display)
                                            }
                                        } else if (msg["leaving"]) {
                                            // One of the publishers has gone away?
                                            var leaving = msg["leaving"];
											
                                            Janus.log("Publisher left: " + leaving);
                                            if (role === "listener" && msg["leaving"] === source) {
                                                bootbox.alert("The Class is over", function() {
                                                    window.location.reload();
                                                });
                                            }
                                        } else if (msg["error"]) {

                                            bootbox.alert(msg["error"]);
                                        }
                                    }
                                }
                                if (jsep) {
                                    Janus.debug("Handling SDP as well...", jsep);
                                    screentest.handleRemoteJsep({ jsep: jsep });
                                }
                            },
                            onlocalstream: function(stream) {
                                Janus.debug(" ::: Got a local stream :::", stream);
                                janus_stream(stream);
                                $('#screenmenu').hide();
                                $('#room').removeClass('hide').show();
                                if ($('#screenvideo').length === 0) {
                                    $('#screencapture').append('<video class="rounded centered" id="screenvideo" width="100%" height="100%" autoplay playsinline muted="muted"/>');
                                }
                                Janus.attachMediaStream($('#screenvideo').get(0), stream);
                                if (screentest.webrtcStuff.pc.iceConnectionState !== "completed" &&
                                    screentest.webrtcStuff.pc.iceConnectionState !== "connected") {
                                    $("#screencapture").parent().block({
                                        message: '<b>Publishing...</b>',
                                        css: {
                                            border: 'none',
                                            backgroundColor: 'transparent',
                                            color: 'white'
                                        }
                                    });
                                }
                            },
                            onremotestream: function(stream) {
                                // The publisher stream is sendonly, we don't expect anything here
                            },
                            oncleanup: function() {
                                Janus.log(" ::: Got a cleanup notification :::");
                                $('#screencapture').empty();
                                $("#screencapture").parent().unblock();


                                $('#room').hide();
                            }
                        });
                        //AUDIO janus
                        janus.attach({
                            plugin: "janus.plugin.audiobridge",
                            opaqueId: opaqueId,
                            success: function(pluginHandle) {
                                $('#details').remove();
                                mixertest = pluginHandle;
                                Janus.log("Plugin attached! (" + mixertest.getPlugin() + ", id=" + mixertest.getId() + ")");
                                // Prepare the username registration
                                $('#audiojoin').removeClass('hide').show();
                                $('#registernow').removeClass('hide').show();
                                $('#register').click(createdynamicroom);
                                $('#joinclass').click(joinaudioroom);
                                $('#username').focus();
                            },
                            error: function(error) {
                                Janus.error("  -- Error attaching plugin...", error);
                                bootbox.alert("Error attaching plugin... " + error);
                            },
                            consentDialog: function(on) {
                                Janus.debug("Consent dialog should be " + (on ? "on" : "off") + " now");
                                if (on) {
                                    // Darken screen and show hint
                                    $.blockUI({
                                        message: '<div><img src="up_arrow.png"/></div>',
                                        css: {
                                            border: 'none',
                                            padding: '15px',
                                            backgroundColor: 'transparent',
                                            color: '#aaa',
                                            top: '10px',
                                            left: (navigator.mozGetUserMedia ? '-100px' : '300px')
                                        }
                                    });
                                } else {
                                    // Restore screen
                                    $.unblockUI();
                                }
                            },
                            iceState: function(state) {
                                Janus.log("ICE state changed to audio " + state);
                            },
                            mediaState: function(medium, on) {
                                // alert(medium);// checks the format type audio or video
                                Janus.log("Janus " + (on ? "started" : "stopped") + " receiving our dynamic " + medium);
                            },
                            webrtcState: function(on) {
                                Janus.log("Janus says our WebRTC PeerConnection is " + (on ? "up" : "down") + " now");
                            },
                            onmessage: function(msg, jsep) {
                                Janus.debug(" ::: Got a message :::", msg);
                                var event = msg["audiobridge"];
                                Janus.debug("Event: " + event);
                                if (event) {
                                    if (event === "joined") {
                                        // Successfully joined, negotiate WebRTC now
                                        if (msg["id"]) {
                                            myid = msg["id"];
											$('#myaudioid').val(myid);
                                            Janus.log("Successfully joined room " + msg["room"] + " with ID " + myid);
                                            if (!webrtcUp) {
                                                webrtcUp = true;
                                                // Publish our stream

                                                mixertest.createOffer({

                                                    media: { video: false }, // This is an audio only room
                                                    success: function(jsep) {
                                                        Janus.debug("Got SDP!", jsep);
                                                        var publish = { request: "configure", muted: true };
                                                        mixertest.send({ message: publish, jsep: jsep });
                                                    },
                                                    error: function(error) {
                                                        Janus.error("WebRTC error:", error);
                                                        bootbox.alert("WebRTC error... " + error.message);
                                                    }
                                                });
                                            }
                                        }
                                        // Any room participant?


                                        if (msg["participants"]) {
                                            var list = msg["participants"];
                                            Janus.debug("Got a list of participants:", list);
                                            for (var f in list) {
                                                var id = list[f]["id"];
                                                var display = list[f]["display"];
                                                var setup = list[f]["setup"];
                                                var muted = list[f]["muted"];

                                                Janus.debug("  >> [" + id + "] " + display + " (setup=" + setup + ", muted=" + muted + ")");
                                                if ($('#rp' + id).length === 0) {
                                                    // Add to the participants list
                                                    $('#list').append("<li id='rp" + id + "'class='listening_list'><div class='media'> <div class='media-body'>" +
													"<span class='media-heading student_name'><strong>" + display + "</strong></span>" +
													"</div><input type='checkbox'data-student_name='" + display + "'data-user_id='" + id + "'data-toggle='toggle'class='micstatus'checked></div></li>");
                                                     $('.micstatus').bootstrapToggle();
													 var student_counts = $('#list').children('li').length;
													$('.listening-count').html(student_counts);
													$('#rp' + id + ' > i').hide();
													
                                                }
                                                if (muted === true || muted === "true")
                                                    $('#rp' + id + ' > i.abmuted').removeClass('hide').show();
                                                else
                                                    $('#rp' + id + ' > i.abmuted').hide();
                                                if (setup === true || setup === "true")
                                                    $('#rp' + id + ' > i.absetup').hide();
                                                else
                                                    $('#rp' + id + ' > i.absetup').removeClass('hide').show();
                                            }
                                        }
                                    } else if (event === "roomchanged") {
                                        // The user switched to a different room
                                        myid = msg["id"];
                                        Janus.log("Moved to room " + msg["room"] + ", new ID: " + myid);
                                        // Any room participant?
                                        $('#list').empty();
                                        if (msg["participants"]) {
                                            var list = msg["participants"];
                                            Janus.debug("Got a list of participants:", list);
                                            for (var f in list) {
                                                var id = list[f]["id"];
                                                var display = list[f]["display"];
                                                var setup = list[f]["setup"];
                                                var muted = list[f]["muted"];
                                                Janus.debug("  >> [" + id + "] " + display + " (setup=" + setup + ", muted=" + muted + ")");
                                                if ($('#rp' + id).length === 0) {
                                                    // Add to the participants list
                                                    $('#list').append("<li id='rp" + id + "'class='listening_list'><div class='media'> <div class='media-body'>" +
													"<span class='media-heading student_name'><strong>" + display + "</strong></span>" +
													"</div><input type='checkbox'data-student_name='" + display + "'data-user_id='" + id + "'data-toggle='toggle'class='micstatus'checked></div></li>");
													 $('.micstatus').bootstrapToggle();
													 var student_counts = $('#list').children('li').length;
													$('.listening-count').html(student_counts);
                                                    $('#rp' + id + ' > i').hide();
													
                                                }
                                                if (muted === true || muted === "true")
                                                    $('#rp' + id + ' > i.abmuted').removeClass('hide').show();
                                                else
                                                    $('#rp' + id + ' > i.abmuted').hide();
                                                if (setup === true || setup === "true")
                                                    $('#rp' + id + ' > i.absetup').hide();
                                                else
                                                    $('#rp' + id + ' > i.absetup').removeClass('hide').show();
                                            }
                                        }
                                    } else if (event === "destroyed") {
                                        // The room has been destroyed
                                        Janus.warn("The room has been destroyed!");
                                        bootbox.alert("The room has been destroyed", function() {
                                            window.location.reload();
                                        });
                                    } else if (event === "event") {
                                        if (msg["participants"]) {
                                            var list = msg["participants"];
                                            Janus.debug("Got a list of participants:", list);
                                            for (var f in list) {
                                                var id = list[f]["id"];
                                                var display = list[f]["display"];
                                                var setup = list[f]["setup"];
                                                var muted = list[f]["muted"];
                                                Janus.debug("  >> [" + id + "] " + display + " (setup=" + setup + ", muted=" + muted + ")");
                                                if ($('#rp' + id).length === 0) {
                                                    // Add to the participants list 
                                                    $('#list').append("<li id='rp" + id + "'class='listening_list'><div class='media'> <div class='media-body'>" +
													"<span class='media-heading student_name'><strong>" + display + "</strong></span>" +
													"</div><input type='checkbox'data-student_name='" + display + "'data-user_id='" + id + "'data-toggle='toggle'class='micstatus'checked></div></li>");
													$('.micstatus').bootstrapToggle();
													var student_counts = $('#list').children('li').length;
													$('.listening-count').html(student_counts);
                                                    $('#rp' + id + ' > i').hide();
													
                                                }
                                                if (muted === true || muted === "true")
                                                    $('#rp' + id + ' > i.abmuted').removeClass('hide').show();
                                                else
                                                    $('#rp' + id + ' > i.abmuted').hide();
                                                if (setup === true || setup === "true")
                                                    $('#rp' + id + ' > i.absetup').hide();
                                                else
                                                    $('#rp' + id + ' > i.absetup').removeClass('hide').show();
                                            }
                                        } else if (msg["error"]) {
                                            if (msg["error_code"] === 485) {
                                                // This is a "no such room" error: give a more meaningful description
                                                bootbox.alert(
                                                    "<p>Apparently room <code>" + myroom + "</code> (the one this demo uses as a test room) " +
                                                    "does not exist...</p><p>Do you have an updated <code>janus.plugin.audiobridge.jcfg</code> " +
                                                    "configuration file? If not, make sure you copy the details of room <code>" + myroom + "</code> " +
                                                    "from that sample in your current configuration file, then restart Janus and try again."
                                                );
                                            } else {
                                                bootbox.alert(msg["error"]);
                                            }
                                            return;
                                        }
                                        // Any new feed to attach to?
                                        if (msg["leaving"]) {
                                            // One of the participants has gone away?
                                            var leaving = msg["leaving"];
                                            Janus.log("Participant left: " + leaving + " (we have " + $('#rp' + leaving).length + " elements with ID #rp" + leaving + ")");
                                            $('#rp' + leaving).remove();
											var student_counts = $('#list').children('li').length;
											$('.listening-count').html(student_counts);
                                        }
                                    }
                                }
                                if (jsep) {
                                    Janus.debug("Handling SDP as well...", jsep);
                                    mixertest.handleRemoteJsep({ jsep: jsep });
                                }
                            },
                            onlocalstream: function(stream) {
                                Janus.debug(" ::: Got a local stream :::", stream);
                                console.log("janus stream audio", stream);
                                // We're not going to attach the local audio stream
                                $('#audiojoin').hide();
                                $('#room').removeClass('hide').show();
                                $('#participant').removeClass('hide').html(myusername).show();
                            },
                            onremotestream: function(stream) {
                                $('#room').removeClass('hide').show();
                                var addButtons = false;

                                if ($('#roomaudio').length === 0) {
                                    addButtons = true;
                                    $('#mixedaudio').append('<audio class="rounded centered" id="roomaudio" width="100%" height="100%" autoplay/>');
                                }
                                Janus.attachMediaStream($('#roomaudio').get(0), stream);
                                if (!addButtons)
                                    return;
                                // Mute button


                                audioenabled = false;
                                $('#toggleaudio').click(
                                    function() {
                                        audioenabled = !audioenabled;
                                        if (audioenabled)
                                            $('#toggleaudio').html("Mute").removeClass("btn-success").addClass("btn-danger");
                                        else
                                            $('#toggleaudio').html("Unmute").removeClass("btn-danger").addClass("btn-success");
                                        mixertest.send({ message: { request: "configure", muted: !audioenabled } });

                                    }).removeClass('hide').show();

                            },
                            oncleanup: function() {
                                webrtcUp = false;
                                Janus.log(" ::: Got a cleanup notification :::");
                                $('#participant').empty().hide();
                                $('#list').empty();
                                $('#mixedaudio').empty();
                                $('#room').hide();
                                reattach_remote_plugin();
                            }
                        });
                        //AUDIO END janus
                    },
                    error: function(error) {
                        Janus.error(error);

                        bootbox.alert(error, function() {
                            window.location.reload();
                        });
                    },
                    destroyed: function() {
                        // bootbox.alert("Test", function() {
                        localDownload(recorderBlob)
                            // .then(function(){
                        window.location.reload();

                        // });

                        // });
                    }
                });
            });
        }
    });
});

function getURLParameter(name) {
    return decodeURI(
        (RegExp(name + '=' + '(.+?)(&|$)').exec(location.search) || [, null])[1]
    );
}

function checkEnterShare(field, event) {
    var theCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
    if (theCode == 13) {
        preShareScreen();
        return false;
    } else {
        return true;
    }
}
// AUDIO
function createdynamicroom() {
    username = getURLParameter("username");
    var register = { request: "create", ptype: "publisher", display: username };
    var create = {
        request: "create",
        description: "cusotm room",
        sampling: 16000,
    };
    mixertest.send({
        message: create,
        success: function(result) {
            var event = result["audiobridge"];
            Janus.debug("Event: " + event);
            if (event) {
                // Our own screen sharing session has been created, join it
                myroom = result["room"];

                $('#audioroom_id').val(myroom);
                send_notify();
                Janus.log("Audio Room created: " + myroom);

                myusername = "staff";
                var register = {
                    request: "join",
                    room: myroom,
                    ptype: "publisher",
                    display: myusername
                };
                mixertest.send({ message: register });
            }
        }
    });
}

function joinaudioroom() {
    var roomid = $('#joinroomaudioid').val();
    myroom = parseInt(roomid);
    role = "publisher";
    myusername = $('#studentname').val();
    var register = {
        request: "join",
        room: myroom,
        ptype: "publisher",
        display: myusername
    };
    mixertest.send({ message: register });
}

// AUDIO





function preShareScreen() {
    // Create a new room
    $('#desc').attr('disabled', true);
    $('#create').attr('disabled', true).unbind('click');
    $('#roomid').attr('disabled', true);
    $('#join').attr('disabled', true).unbind('click');
    if ($('#desc').val() === "") {
        bootbox.alert("Please insert a description for the room");
        $('#desc').removeAttr('disabled', true);
        $('#create').removeAttr('disabled', true).click(preShareScreen);
        $('#roomid').removeAttr('disabled', true);
        $('#join').removeAttr('disabled', true).click(joinScreen);
        return;
    }
    capture = "screen";
    if (navigator.mozGetUserMedia) {
        // Firefox needs a different constraint for screen and window sharing

        bootbox.dialog({
            title: "Share whole screen or a window?",
            message: "Firefox handles screensharing in a different way: are you going to share the whole screen, or would you rather pick a single window/application to share instead?",
            buttons: {
                screen: {
                    label: "Share screen",
                    className: "btn-primary",
                    callback: function() {
                        capture = "screen";
                        shareScreen();
                    }
                },
                window: {
                    label: "Pick a window",
                    className: "btn-success",
                    callback: function() {
                        capture = "window";
                        shareScreen();
                    }
                }
            },
            onEscape: function() {
                $('#desc').removeAttr('disabled', true);
                $('#create').removeAttr('disabled', true).click(preShareScreen);
                $('#roomid').removeAttr('disabled', true);
                $('#join').removeAttr('disabled', true).click(joinScreen);
            }
        });
    } else {
        shareScreen();
    }
}

function shareScreen() {
    // Create a new room
    var desc = $('#desc').val();
    role = "publisher";
    var create = {
        request: "create",
        description: desc,
        bitrate: 100000,
        publishers: 1
    };
    screentest.send({
        message: create,
        success: function(result) {
            var event = result["videoroom"];
            Janus.debug("Event: " + event);
            if (event) {
                // Our own screen sharing session has been created, join it
                room = result["room"];
                Janus.log("Screen sharing session created: " + room);
                myusername = randomString(12);
                var register = {
                    request: "join",
                    room: room,
                    ptype: "publisher",
                    display: myusername
                };
                screentest.send({ message: register });
            }
        }
    });
}

function checkEnterJoin(field, event) {
    var theCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
    if (theCode == 13) {
        joinScreen();
        return false;
    } else {
        return true;
    }
}

function joinScreen() {
    // Join an existing screen sharing session
    $('#desc').attr('disabled', true);
    $('#create').attr('disabled', true).unbind('click');
    $('#roomid').attr('disabled', true);
    $('#join').attr('disabled', true).unbind('click');
    var roomid = $('#roomid').val();
    if (isNaN(roomid)) {
        bootbox.alert("Session identifiers are numeric only");
        $('#desc').removeAttr('disabled', true);
        $('#create').removeAttr('disabled', true).click(preShareScreen);
        $('#roomid').removeAttr('disabled', true);
        $('#join').removeAttr('disabled', true).click(joinScreen);
        return;
    }
    room = parseInt(roomid);
    role = "listener";
    myusername = randomString(12);
    var register = {
        request: "join",
        room: room,
        ptype: "publisher",
        display: myusername
    };
    screentest.send({ message: register });
}

function reattach_remote_plugin() {
    janus.attach({
        plugin: "janus.plugin.audiobridge",
        opaqueId: opaqueId,
        success: function(pluginHandle) {
            $('#details').remove();
            mixertest = pluginHandle;
            Janus.log("Plugin attached! (" + mixertest.getPlugin() + ", id=" + mixertest.getId() + ")");
            // Prepare the username registration
            myusername = $('#studentname').val();
            var listen = {
                request: "join",
                room: myroom,
                ptype: "listener",
                display: myusername
            };
            mixertest.send({ message: listen });
        },
        error: function(error) {
            Janus.error("  -- Error attaching plugin...", error);
            bootbox.alert("Error attaching plugin... " + error);
        },
        consentDialog: function(on) {
            Janus.debug("Consent dialog should be " + (on ? "on" : "off") + " now");
            if (on) {
                // Darken screen and show hint
                $.blockUI({
                    message: '<div><img src="up_arrow.png"/></div>',
                    css: {
                        border: 'none',
                        padding: '15px',
                        backgroundColor: 'transparent',
                        color: '#aaa',
                        top: '10px',
                        left: (navigator.mozGetUserMedia ? '-100px' : '300px')
                    }
                });
            } else {
                // Restore screen
                $.unblockUI();
            }
        },
        onmessage: function(msg, jsep) {
            Janus.debug(" ::: Got a message :::", msg);
            var event = msg["audiobridge"];
            Janus.debug("Event: " + event);
            if (event) {
                if (event === "joined") {
                    // Successfully joined, negotiate WebRTC now
                    if (msg["id"]) {
                        myid = msg["id"];
						$('#myaudioid').val(myid);
                        Janus.log("Successfully joined room " + msg["room"] + " with ID " + myid);
                        if (!webrtcUp) {
                            webrtcUp = true;
                            // Publish our stream
                            mixertest.createOffer({
                                media: { video: false }, // This is an audio only room
                                success: function(jsep) {
                                    Janus.debug("Got SDP!", jsep);
                                    var publish = { request: "configure", muted: true };
                                    mixertest.send({ message: publish, jsep: jsep });
                                },
                                error: function(error) {
                                    Janus.error("WebRTC error:", error);
                                    bootbox.alert("WebRTC error... " + error.message);
                                }
                            });
                        }
                    }
                    // Any room participant?
                    if (msg["participants"]) {
                        var list = msg["participants"];
                        Janus.debug("Got a list of participants:", list);
                        for (var f in list) {
                            var id = list[f]["id"];
                            var display = list[f]["display"];
                            var setup = list[f]["setup"];
                            var muted = list[f]["muted"];
                            Janus.debug("  >> [" + id + "] " + display + " (setup=" + setup + ", muted=" + muted + ")");
                            if ($('#rp' + id).length === 0) {
                                // Add to the participants list
                                $('#list').append("<li id='rp" + id + "'class='listening_list'><div class='media'> <div class='media-body'>" +
								"<span class='media-heading student_name'><strong>" + display + "</strong></span>" +
								"</div><input type='checkbox'data-student_name='" + display + "'data-user_id='" + id + "'data-toggle='toggle'class='micstatus'checked></div></li>");
                                 $('.micstatus').bootstrapToggle();
								var student_counts = $('#list').children('li').length;
								$('.listening-count').html(student_counts);
								$('#rp' + id + ' > i').hide();
								
                            }
                            if (muted === true || muted === "true")
                                $('#rp' + id + ' > i.abmuted').removeClass('hide').show();
                            else
                                $('#rp' + id + ' > i.abmuted').hide();
                            if (setup === true || setup === "true")
                                $('#rp' + id + ' > i.absetup').hide();
                            else
                                $('#rp' + id + ' > i.absetup').removeClass('hide').show();
                        }
                    }
                } else if (event === "roomchanged") {
                    // The user switched to a different room
                    myid = msg["id"];
                    Janus.log("Moved to room " + msg["room"] + ", new ID: " + myid);
                    // Any room participant?
                    $('#list').empty();
                    if (msg["participants"]) {
                        var list = msg["participants"];
                        Janus.debug("Got a list of participants:", list);
                        for (var f in list) {
                            var id = list[f]["id"];
                            var display = list[f]["display"];
                            var setup = list[f]["setup"];
                            var muted = list[f]["muted"];
                            Janus.debug("  >> [" + id + "] " + display + " (setup=" + setup + ", muted=" + muted + ")");
                            if ($('#rp' + id).length === 0) {
                                // Add to the participants list
                                $('#list').append("<li id='rp" + id + "'class='listening_list'><div class='media'> <div class='media-body'>" +
								"<span class='media-heading student_name'><strong>" + display + "</strong></span>" +
								"</div><input type='checkbox'data-student_name='" + display + "'data-user_id='" + id + "'data-toggle='toggle'class='micstatus'checked></div></li>");
                                $('.micstatus').bootstrapToggle();
								var student_counts = $('#list').children('li').length;
								$('.listening-count').html(student_counts);
								$('#rp' + id + ' > i').hide();
								
                            }
                            if (muted === true || muted === "true")
                                $('#rp' + id + ' > i.abmuted').removeClass('hide').show();
                            else
                                $('#rp' + id + ' > i.abmuted').hide();
                            if (setup === true || setup === "true")
                                $('#rp' + id + ' > i.absetup').hide();
                            else
                                $('#rp' + id + ' > i.absetup').removeClass('hide').show();
                        }
                    }
                } else if (event === "destroyed") {
                    // The room has been destroyed
                    Janus.warn("The room has been destroyed!");
                    bootbox.alert("The room has been destroyed", function() {
                        window.location.reload();
                    });
                } else if (event === "event") {
                    if (msg["participants"]) {
                        var list = msg["participants"];
                        Janus.debug("Got a list of participants:", list);
                        for (var f in list) {
                            var id = list[f]["id"];
                            var display = list[f]["display"];
                            var setup = list[f]["setup"];
                            var muted = list[f]["muted"];
                            Janus.debug("  >> [" + id + "] " + display + " (setup=" + setup + ", muted=" + muted + ")");
                            if ($('#rp' + id).length === 0) {
                                // Add to the participants list
								
                                $('#list').append("<li id='rp" + id + "'class='listening_list'><div class='media'> <div class='media-body'>" +
								"<span class='media-heading student_name'><strong>" + display + "</strong></span>" +
								"</div><input type='checkbox'data-student_name='" + display + "'data-user_id='" + id + "'data-toggle='toggle'class='micstatus'checked></div></li>");
								 $('.micstatus').bootstrapToggle();
								  var student_counts = $('#list').children('li').length;
								$('.listening-count').html(student_counts);
								$('#rp' + id + ' > i').hide();
								
                            }
                            if (muted === true || muted === "true")
                                $('#rp' + id + ' > i.abmuted').removeClass('hide').show();
                            else
                                $('#rp' + id + ' > i.abmuted').hide();
                            if (setup === true || setup === "true")
                                $('#rp' + id + ' > i.absetup').hide();
                            else
                                $('#rp' + id + ' > i.absetup').removeClass('hide').show();
                        }
                    } else if (msg["error"]) {
                        if (msg["error_code"] === 485) {
                            // This is a "no such room" error: give a more meaningful description
                            bootbox.alert(
                                "<p>Apparently room <code>" + myroom + "</code> (the one this demo uses as a test room) " +
                                "does not exist...</p><p>Do you have an updated <code>janus.plugin.audiobridge.jcfg</code> " +
                                "configuration file? If not, make sure you copy the details of room <code>" + myroom + "</code> " +
                                "from that sample in your current configuration file, then restart Janus and try again."
                            );
                        } else {
                            bootbox.alert(msg["error"]);
                        }
                        return;
                    }
                    // Any new feed to attach to?
                    if (msg["leaving"]) {
                        // One of the participants has gone away?
                        var leaving = msg["leaving"];
                        Janus.log("Participant left: " + leaving + " (we have " + $('#rp' + leaving).length + " elements with ID #rp" + leaving + ")");
                        $('#rp' + leaving).remove();
						var student_counts = $('#list').children('li').length;
						$('.listening-count').html(student_counts);
                    }
                }
            }
            if (jsep) {
                Janus.debug("Handling SDP as well...", jsep);
                mixertest.handleRemoteJsep({ jsep: jsep });
            }
        },
        onlocalstream: function(stream) {
            Janus.debug(" ::: Got a local stream :::", stream);
            // We're not going to attach the local audio stream
            $('#audiojoin').hide();
            $('#room').removeClass('hide').show();
            $('#participant').removeClass('hide').html(myusername).show();
        },
        onremotestream: function(stream) {
            $('#room').removeClass('hide').show();
            var addButtons = false;
            if ($('#roomaudio').length === 0) {
                addButtons = true;
                $('#mixedaudio').append('<audio class="rounded centered" id="roomaudio" width="100%" height="100%" autoplay/>');
            }
            Janus.attachMediaStream($('#roomaudio').get(0), stream);
            if (!addButtons)
                return;
        },
        oncleanup: function() {
            webrtcUp = false;
            Janus.log(" ::: Got a cleanup notification :::");
            $('#participant').empty().hide();
            $('#list').empty();
            $('#mixedaudio').empty();
            $('#room').hide();
			reattach_remote_plugin();
        }
    });
}
function newRemoteFeed(id, display) {
    // A new feed has been published, create a new plugin handle and attach to it as a listener
    source = id;
    var remoteFeed = null;
    janus.attach({
        plugin: "janus.plugin.videoroom",
        opaqueId: opaqueId,
        success: function(pluginHandle) {
            remoteFeed = pluginHandle;
            Janus.log("Plugin attached! (" + remoteFeed.getPlugin() + ", id=" + remoteFeed.getId() + ")");
            Janus.log("  -- This is a subscriber");
            // We wait for the plugin to send us an offer
            var listen = {
                request: "join",
                room: room,
                ptype: "listener",
                feed: id
            };
            remoteFeed.send({ message: listen });
        },
        error: function(error) {
            Janus.error("  -- Error attaching plugin...", error);

            bootbox.alert("Error attaching plugin... " + error);
        },
        onmessage: function(msg, jsep) {
            Janus.debug(" ::: Got a message (listener) :::", msg);
            var event = msg["videoroom"];
            Janus.debug("Event: " + event);
            if (event) {
                if (event === "attached") {
                    // Subscriber created and attached
                    if (!spinner) {
                        var target = document.getElementById('#screencapture');
                        spinner = new Spinner({ top: 100 }).spin(target);
                    } else {
                        spinner.spin();
                    }
                    Janus.log("Successfully attached to feed " + id + " (" + display + ") in room " + msg["room"]);
                    $('#screenmenu').hide();
                    $('#room').removeClass('hide').show();
                } else {
                    // What has just happened?
                }
            }
            if (jsep) {
                Janus.debug("Handling SDP as well...", jsep);
                // Answer and attach
                remoteFeed.createAnswer({
                    jsep: jsep,
                    media: { audioSend: true, videoSend: false }, // We want recvonly audio/video
                    success: function(jsep) {
                        Janus.debug("Got SDP!", jsep);
                        var body = { request: "start", room: room };
                        remoteFeed.send({ message: body, jsep: jsep });
                    },
                    error: function(error) {
                        Janus.error("WebRTC error:", error);

                        bootbox.alert("WebRTC error... " + error.message);
                    }
                });
            }
        },
        onlocalstream: function(stream) {
            // The subscriber stream is recvonly, we don't expect anything here
        },
        onremotestream: function(stream) {
            if ($('#screenvideo').length === 0) {
                // No remote video yet
                $('#screencapture').append('<video class="rounded centered" id="waitingvideo" width="100%" height="100%" />');
                $('#screencapture').append('<video class="rounded centered hide" id="screenvideo" width="100%" height="100%" autoplay playsinline/>');
                // Show the video, hide the spinner and show the resolution when we get a playing event
                $("#screenvideo").bind("playing", function() {
                    $('#waitingvideo').remove();
                    $('#screenvideo').removeClass('hide');
                    if (spinner)
                        spinner.stop();
                    spinner = null;
                });
            }
            Janus.attachMediaStream($('#screenvideo').get(0), stream);
        },
        oncleanup: function() {
            Janus.log(" ::: Got a cleanup notification (remote feed " + id + ") :::");
            $('#waitingvideo').remove();
            if (spinner)
                spinner.stop();
            spinner = null;
        }
    });
}