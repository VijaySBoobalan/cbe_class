var server = null;

if (window.location.protocol === 'http:')
    server = "http://" + "ttsvle.in" + ":8088/janus";
else
    server = "https://" + "ttsvle.in" + ":8089/janus";
var janus = null;
var mixertest = null;
var opaqueId = "audiobridgetest-" + Janus.randomString(12);

var spinner = null;

var myroom = null; // Demo room
var myusername = null;
var myid = null;
var webrtcUp = false;
var audioenabled = false;


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
                        // Attach to AudioBridge plugin
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
                                $('#register').click(createdynamicroom);//registerUsername
                                // $('#joinclass').click(joinaudioroom);//registerUsername
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
								alert(state);
                                Janus.log("ICE state changed to " + state);
								if(state === "disconnected"){
									alert('this is disconnected');
									mixertest.createOffer({												
													iceRestart: true,
                                                    media: { video: false }, // This is an audio only room
                                                    success: function(jsep) {
                                                        Janus.debug("Got SDP!", jsep);
														// var mediaConstraints = {
														// }
														// mediaConstraints.iceRestart = true;
                                                        var publish = { request: "configure", muted: true};
                                                        mixertest.send({ message: publish, jsep: jsep });
                                                    },
                                                    error: function(error) {
                                                        Janus.error("WebRTC error:", error);
                                                        bootbox.alert("WebRTC error... " + error.message);
                                                    }
                                                });
								}
								
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
                                            Janus.log("Successfully joined room " + msg["room"] + " with ID " + myid);
                                            if (!webrtcUp) {
                                                webrtcUp = true;
                                                // Publish our stream
											
                                                mixertest.createOffer({												
													iceRestart: true,
                                                    media: { video: false }, // This is an audio only room
                                                    success: function(jsep) {
                                                        Janus.debug("Got SDP!", jsep);
														// var mediaConstraints = {
														// }
														// mediaConstraints.iceRestart = true;
                                                        var publish = { request: "configure", muted: true};
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
                                                    $('#list').append('<li id="rp' + id + '" class="list-group-item">' + display +
                                                        ' <i class="absetup fa fa-chain-broken"></i>' +
                                                        ' <i class="abmuted fa fa-microphone-slash"></i></li>');
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
                                                    $('#list').append('<li id="rp' + id + '" class="list-group-item">' + display +
                                                        ' <i class="absetup fa fa-chain-broken"></i>' +
                                                        ' <i class="abmuted fa fa-microphone-slash"></i></li>');
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
                                                    $('#list').append('<li id="rp' + id + '" class="list-group-item">' + display +
                                                        ' <i class="absetup fa fa-chain-broken"></i>' +
                                                        ' <i class="abmuted fa fa-microphone-slash"></i></li>');
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
								
								 mixertest.send({ message: { request: "configure", muted: !audioenabled ,iceRestart: true } });	
                                // $('#room').hide();
                            }
                        });
                    },
                    error: function(error) {
                        Janus.error(error);
                        bootbox.alert(error, function() {
                            window.location.reload();
                        });
                    },
                    destroyed: function() {
                        window.location.reload();
                    }
                });
            });
        }
    });
});

function checkEnter(field, event) {
    var theCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
    if (theCode == 13) {
        createdynamicroom();
        return false;
    } else {
        return true;
    }
}
function createdynamicroom() {
    username = getURLParameter("username");
    var register = { request: "create",ptype: "publisher", display: username };
	var create = {
		request: "create",
		description: "cusotm room",
		sampling: 16000,
	};
	mixertest.send({ message: create, success: function(result) {
		var event = result["audiobridge"];
		Janus.debug("Event: " + event);
		if(event) {
			// Our own screen sharing session has been created, join it
			room = result["room"];
			alert(room);
			$('#audioroom_id').val(room);
			send_notify();
			Janus.log("Audio Room created: " + room);
			// joinaudioroom(room);
			myusername = "rubesh";
			var register = {
				request: "join",
				room: room,
				ptype: "listener",
				display: myusername
			};
			mixertest.send({ message: register });
		}
	}});
}
function joinaudioroom(){
	var roomid = $('#joinroomaudioid').val();
	room = parseInt(roomid);
	role = "listener";
	myusername = $('#studentname').val();
	var register = {
				request: "join",
				room: room,
				ptype: "listener",
				display: myusername
			};
			mixertest.send({ message: register , iceRestart: true });
}
function registerUsername() {
    if ($('#username').length === 0) {
        // Create fields to register
        $('#register').click(registerUsername);
        $('#username').focus();
    } else {
        // Try a registration
        $('#username').attr('disabled', true);
        $('#register').attr('disabled', true).unbind('click');
        var username = $('#username').val();
        if (username === "") {
            $('#you')
                .removeClass().addClass('label label-warning')
                .html("Insert your display name (e.g., pippo)");
            $('#username').removeAttr('disabled');
            $('#register').removeAttr('disabled').click(registerUsername);
            return;
        }
        if (/[^a-zA-Z0-9]/.test(username)) {
            $('#you')
                .removeClass().addClass('label label-warning')
                .html('Input is not alphanumeric');
            $('#username').removeAttr('disabled').val("");
            $('#register').removeAttr('disabled').click(registerUsername);
            return;
        }
        var register = { request: "join", room: myroom, display: username };
        myusername = username;
        mixertest.send({ message: register });
    }
}