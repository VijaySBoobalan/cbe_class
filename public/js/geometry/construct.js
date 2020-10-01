// JavaScript Document

/*
addDrawTools({
	compassHelp:{buttonPos:[30,30],helpBoxPos:[100,30]},
	thicknessSelect:{buttonPos:[30,140],expandTo:'right'},
	colorSelect:{buttonPos:[30,200],expandTo:'right'},
	line:{buttonPos:[30,260]},
	pen:{buttonPos:[30,320]},
	compass:{buttonPos:[30,380]},
	ruler:{buttonPos:[30,440]},
	protractor:{buttonPos:[30,500]},
	undo:{buttonPos:[30,560]},
	clear:{buttonPos:[30,620]},
	snapLinesTogether:true,
	drawArea:[0,0,1200,700],
	retainCursorCanvas:true,
	zIndex:10,
	thickness:3
});
draw.drawArcCenter = true;
var snapToObj2Mode = 'all';
var snapToObj2On = true;
//*/

addDrawTools({
	snapLinesTogether:true,
	drawArea:[0,0,1200,700],
	retainCursorCanvas:true,
	zIndex:10,
	thickness:3
});
draw.drawArcCenter = true;
var snapToObj2Mode = 'all';
var snapToObj2On = true;
draw.mode = 'interact';
//var disabled = (['teacher','pupil','super'].indexOf(user) == -1) ? true : false;
var disabled = false;
draw.path = [{
	// 	obj: [{
	// 			type: "buttonCompassHelp",
	// 			left: 30,
	// 			top: 30,
	// 			interact: {
	// 				click: function (obj) {
	// 					draw[obj.type].click(obj)
	// 				},
	// 				overlay: true
	// 			}
	// 		}
	// 	],
	// 	_deletable: false
	// }, {
	// 	obj: [{
	// 			type: "compassHelp",
	// 			left: 115,
	// 			top: 20,
	// 			interact: {
	// 				overlay: true
	// 			}
	// 		}
	// 	],
	// 	_deletable: false
	// }, 
	// {
		obj: [{
				type: "buttonColorPicker",
				left: 30,
				top: 172.211,
				interact: {
					click: function (obj) {
						draw[obj.type].click(obj)
					},
					overlay: true
				},
				_disabled:disabled
			}
		],
		_deletable: false
	}, {
		obj: [{
				type: "colorPicker",
				colors: ['#9c27b0','#00bcd4','#e91e63','#f44336','#ffeb3b','#ff9800', '#004d40', '#000'],
				left: 95,
				top: 174.086,
				interact: {
					click: function (obj) {
						draw[obj.type].click(obj)
					},
					overlay: true
				},
			}
		],
		_deletable: false
	}, {
		obj: [{
				type: "buttonLine",
				left: 30,
				top: 235.467,
				interact: {
					click: function (obj) {
						draw[obj.type].click(obj)
					},
					overlay: true
				}
			}
		],
		_deletable: false
	}, {
		obj: [{
				type: "buttonPen",
				left: 30,
				top: 298.722,
				interact: {
					click: function (obj) {
						draw[obj.type].click(obj)
					},
					overlay: true
				}
			}
		],
		_deletable: false
	}, {
		obj: [{
				type: "buttonCompass",
				left: 30,
				top: 361.978,
				interact: {
					click: function (obj) {
						draw[obj.type].click(obj)
					},
					overlay: true
				}
			}
		],
		_deletable: false
	}, {
		obj: [{
				type: "buttonProtractor",
				left: 30,
				top: 425.233,
				interact: {
					click: function (obj) {
						draw[obj.type].click(obj);
						if (draw.protractorVisible === true) {
							o('protractorBox').visible = true;
							o('protractorSlider').visible = true;
							o('protractorButton').visible = true;
						} else {
							o('protractorBox').visible = false;
							o('protractorSlider').visible = false;
							o('protractorButton').visible = false;
						}
					},
					overlay: true
				}
			}
		],
		_deletable: false
	}, {
		obj: [{
				type: "buttonRuler",
				left: 30,
				top: 488.489,
				interact: {
					click: function (obj) {
						draw[obj.type].click(obj)
					},
					overlay: true
				}
			}
		],
		_deletable: false
	}, {
		obj: [{
				type: "buttonUndo",
				left: 30,
				top: 551.744,
				interact: {
					click: function (obj) {
						draw[obj.type].click(obj)
					},
					overlay: true
				}
			}
		],
		_deletable: false
	}, {
		obj: [{
				type: "buttonClear",
				left: 30,
				top: 615,
				interact: {
					click: function (obj) {
						draw[obj.type].click(obj)
					},
					overlay: true
				}
			}
		],
		_deletable: false
	}, {
		obj: [{
				type: "buttonLineWidthPicker",
				left: 30,
				top: 108.956,
				interact: {
					click: function (obj) {
						draw[obj.type].click(obj)
					},
					overlay: true
				},
				_disabled:disabled
			}
		],
		_deletable: false
	}, {
		obj: [{
				type: "lineWidthSelect",
				left: 95,
				top: 108.956,
				interact: {
					click: function (obj) {
						draw[obj.type].click(obj)
					},
					overlay: true
				},
				_disabled:disabled
			}
		],
		_deletable: false
	}, {
		"obj": [{
				"type":"text2",
				"rect":[870,565,310,115],
				"text":["Protractor"],
				"align":"center",
				"fontSize":24,
				"box":{"type":"loose","borderColor":"#000","borderWidth":3,"radius":0,"color":"#E1F6FE"},
				"bold":true,
				id:'protractorBox',
				visible:false
		}],
		_deletable: false
	},{
		"obj":[{
			"type":"slider",
			"left":1050,
			"top":625,
			"width":120,
			"radius":15,
			"value":1/8,
			"lineWidth":4,
			"color":"#000",
			"fillColor":"#00F",
			"interact":{
				"onchange":function(obj) {
					if (un(draw.protractor)) return;
					draw.protractor.radius = 200+400*obj.value;
					drawToolsCanvas();
				}
			},
			id:'protractorSlider',
				visible:false
		}],
		_deletable: false
	},{
		"obj": [{
			"type":"text2",
			"rect":[900,615,120,50],
			"text":["Numbers"],
			"align":[0,0],
			"fontSize":24,
			"box":{"type":"loose","borderColor":"#000","borderWidth":3,"radius":15,color:'#F90'},
			id:'protractorButton',
			interact:{
				click:function() {
					if (un(draw.protractor)) return;
					draw.protractor.numbers = !draw.protractor.numbers;
					o('protractorButton').box.color = draw.protractor.numbers === true ? '#F90' : '#FFC';
					drawToolsCanvas();
				}
			},
			visible:false
		}],
		_deletable: false
	}
];
drawCanvasPaths();
calcCursorPositions();

// var linkMenu = dropMenu({
// 	title:'<<align:center>><<fontSize:24>>Lessons',
// 	data:[
// 		'<<align:center>><<fontSize:24>>Constructing Triangles',
// 		'<<align:center>><<fontSize:24>>Constructing Bisectors',
// 		'<<align:center>><<fontSize:24>>Loci'
// 	],
// 	buttonRect:[1200-320,20,300,40],
// 	listRect:[1200-320,60,300,40],
// 	func:function() {
// 		window.open('/i2/teach.php?id='+['constructingTriangles','constructingBisectors','loci'][linkMenu.selected],'_blank');
// 	}	
// });

// var loginTrayButton, loginBox = [], pleaseSubscribeTrayButton, pleaseSubscribeButton, hidden, visibilityChange, lastLoginCheckTime, loginCheckCount;
// buildLoginBox();
// buildPleaseSubscribeButtons();
// if (user == 'guest' || user == 'teacherUnverified') {
// 	enableVisibilityChangeLoginMonitor();
// }
// function buildLoginBox() {
// 	var vis = user == 'guest' ? true : false;
// 	loginTrayButton = newctx({rect:[0,0,120,40],z:200000000000,vis:vis,pE:true}).canvas;
// 	resizeCanvas(loginTrayButton,1200-320-130,20);
// 	var paths = [{obj:[{type:"text2",rect:[1,1,118,38],text:[""],box:{type:"loose",borderColor:"#000",color:'#FFF',borderWidth:2,radius:5}}]},{obj:[{type:"text2",rect:[48,0,60,40],text:["<<align:center>><<font:Hobo>><<fontSize:28>><<color:#00F>>Login"],align:[0,0]}]}];
// 	drawPathsToCanvas(loginTrayButton,paths);
// 	addListener(loginTrayButton,function() {
// 		if (loginBox[0].parentNode == container) {
// 			hideObj(loginBox);
// 		} else {
// 			showObj(loginBox);
// 		}
// 	});
	
// 	loginBox = [];
// 	function style(element,styles) {
// 		for (var key in styles) element.style[key] = styles[key];
// 	}
// 	var loginCanvas = document.createElement('canvas');
// 	style(loginCanvas,{
// 		zIndex: '10000000000',
// 		position: 'absolute',
// 		backgroundColor: 'rgb(255, 255, 255)',
// 		border: '2px solid rgb(0, 0, 0)',
// 		borderRadius: '15px'
// 	});
// 	loginCanvas.width = 400;
// 	loginCanvas.height = 300;
// 	loginCanvas.data = [400,200,400,300];
// 	resizeCanvas(loginCanvas,400,200,400,300);
// 	loginBox.push(loginCanvas);
// 	loginCanvas.draw = function() {
// 		var ctx = this.getContext('2d');
// 		ctx.clearRect(0,0,400,300);
// 		ctx.putImageData(homeImage.imageData,25,25);
		
// 		text({ctx:ctx,text:['<<font:Hobo>><<fontSize:36>>Login to MathsPad'],rect:[75,25,300,50],align:[0,0]});
			
// 		text({ctx:ctx,text:['<<fontSize:20>><<bold:true>>Username'],rect:[30,110,100,30],align:[0,0]});
// 		text({ctx:ctx,text:['<<fontSize:20>><<bold:true>>Password'],rect:[30,150,100,30],align:[0,0]});
		
// 		ctx.beginPath();
// 		ctx.fillStyle = '#00F';
// 		ctx.arc(204,273,3,0,2*Math.PI);
// 		ctx.fill();
// 	}
		
// 	var homeImage = new Image;
// 	homeImage.onload = function() {
// 		draw.hiddenCanvas.ctx.clear();
// 		draw.hiddenCanvas.ctx.drawImage(homeImage,0,0,50,50);
// 		homeImage.imageData = draw.hiddenCanvas.ctx.getImageData(0,0,50,50);
// 		var length = homeImage.imageData.length;
// 		for (var i=0; i < length; i+=4) {
// 			if (homeImage.imageData[i] >= 245 && homeImage.imageData[i+1] >= 245 && homeImage.imageData[i+2] >= 245) {
// 				homeImage.imageData[i+3] = 0;
// 			}
// 		}
// 		loginCanvas.draw();
		
// 		draw.hiddenCanvas.ctx.clear();
// 		draw.hiddenCanvas.ctx.drawImage(homeImage,0,0,34,34);
// 		homeImage.imageData2 = draw.hiddenCanvas.ctx.getImageData(0,0,34,34);
// 		var length = homeImage.imageData2.length;
// 		for (var i=0; i < length; i+=4) {
// 			if (homeImage.imageData2[i] >= 245 && homeImage.imageData2[i+1] >= 245 && homeImage.imageData2[i+2] >= 245) {
// 				homeImage.imageData2[i+2] = 204;
// 			}
// 		}
// 		loginTrayButton.ctx.putImageData(homeImage.imageData2,6,3);
		
// 		draw.hiddenCanvas.ctx.clear();
// 	}
// 	homeImage.src = "/Images/logoSmall.PNG";
	
	
// 	var form = document.createElement('form');
// 	form.action = '';
// 	form.method = 'POST';
// 	loginBox.push(form);
// 	form.addEventListener('submit', function(e) {
// 		e.preventDefault();
// 		e.stopPropagation();
// 		loginFromPage();
// 	});
	
// 	var label1 = document.createElement('label');
// 	form.appendChild(label1);
// 	label1.innerHTML = 'Username';
// 	label1.setAttribute('for','input-username');
// 	label1.style.display = 'none';
	
// 	var input1 = document.createElement('input');
// 	input1.id = 'input-username';
// 	style(input1,{
// 		zIndex: '10000000001',
// 		position: 'absolute',
// 		backgroundColor: '#FFC'
// 	});
// 	input1.setAttribute('autocomplete','username');
// 	input1.setAttribute('type','text');
// 	input1.setAttribute('name','username');
// 	input1.setAttribute('required',1);
// 	input1.allowDefault = true;
// 	input1.data = [550,312,200,22];
// 	resizeCanvas(input1,550,312,200,22);
// 	form.appendChild(input1);
	
// 	var label2 = document.createElement('label');
// 	form.appendChild(label2);
// 	label2.innerHTML = 'Password';
// 	label2.setAttribute('for','input-password');
// 	label2.style.display = 'none';
	
// 	var input2 = document.createElement('input');
// 	input2.id = 'input-password';
// 	style(input2,{
// 		zIndex: '10000000001',
// 		position: 'absolute',
// 		backgroundColor: '#FFC'
// 	});
// 	input2.setAttribute('autocomplete','password');
// 	input2.setAttribute('type','password');
// 	input2.setAttribute('name','password');
// 	input2.setAttribute('required',1);
// 	input2.allowDefault = true;
// 	input2.data = [550,352,200,22];
// 	resizeCanvas(input2,550,352,200,22);
// 	form.appendChild(input2);
	
// 	var loginButton = document.createElement('button');
// 	style(loginButton,{
// 		zIndex: '10000000001',
// 		position: 'absolute',
// 		pointerEvents: 'auto',
// 		cursor: 'pointer',
// 		backgroundColor: '#FCF',
// 		borderStyle: 'solid',
// 		borderColor: '#666',
// 		borderWidth: '1.5px',
// 		fontWeight: 'bold'
// 	});	
// 	loginButton.data = [670,395,80,35];
// 	resizeCanvas(loginButton,670,395,80,35);
// 	loginButton.innerHTML = 'Login';
// 	loginButton.setAttribute('type','submit');
// 	form.appendChild(loginButton);
	
// 	form.resize = function() {
// 		var children = [input1,input2,loginButton];
// 		for (var c = 0; c < children.length; c++) {
// 			resizeCanvas(children[c]);
// 		}
// 	}
		
// 	var createAccountButton = document.createElement('canvas');
// 	loginBox.push(createAccountButton);
// 	style(createAccountButton,{
// 		zIndex: '10000000001',
// 		position: 'absolute',
// 		pointerEvents: 'auto',
// 		cursor: 'pointer'
// 	});	
// 	addListener(createAccountButton, function() {
// 		window.open('/pleaseSubscribe.php','_blank');
// 	});
// 	createAccountButton.width = 150;
// 	createAccountButton.height = 50;
// 	createAccountButton.data = [450,450,150,50];
// 	resizeCanvas(createAccountButton,450,450,150,50);
// 	loginBox.push(createAccountButton);
// 	text({ctx:createAccountButton.getContext('2d'),text:['<<fontSize:16>><<color:#00F>><<bold:true>>Create Account'],rect:[0,0,150,50],align:[0,0]});
	
// 	var remindMeButton = document.createElement('canvas');
// 	loginBox.push(remindMeButton);
// 	style(remindMeButton,{
// 		zIndex: '10000000001',
// 		position: 'absolute',
// 		pointerEvents: 'auto',
// 		cursor: 'pointer'
// 	});	
// 	addListener(remindMeButton, function() {
// 		window.open('/resendDetails2.php','_blank');
// 	});
// 	remindMeButton.width = 150;
// 	remindMeButton.height = 50;
// 	remindMeButton.data = [600,450,150,50];
// 	resizeCanvas(remindMeButton,600,450,150,50);
// 	loginBox.push(remindMeButton);
// 	text({ctx:remindMeButton.getContext('2d'),text:['<<fontSize:16>><<color:#00F>><<bold:true>>Remind Me'],rect:[0,0,150,50],align:[0,0]});
// }
// function buildPleaseSubscribeButtons() {
// 	var vis = user == 'teacherUnverified' ? true : false;
// 	pleaseSubscribeTrayButton = newctx({rect:[0,0,160,40],z:200000000000,vis:vis,pE:true}).canvas;
// 	resizeCanvas(pleaseSubscribeTrayButton,1200-320-170,20);
// 	var paths = [{obj:[{type:"text2",rect:[1,1,158,38],text:[""],box:{type:"loose",borderColor:"#000",color:'#FFF',borderWidth:2,radius:5}}]},{obj:[{type:"text2",rect:[48,0,105,40],text:["<<align:center>><<font:Hobo>><<fontSize:28>><<color:#00F>>Subscribe"],align:[0,0]}]}];
// 	drawPathsToCanvas(pleaseSubscribeTrayButton,paths);
// 	addListener(pleaseSubscribeTrayButton,function() {
// 		window.open('/pleaseSubscribe.php','_blank');
// 	});
	
// 	pleaseSubscribeButton = newctx({z:2000,vis:false,pE:true}).canvas;
// 	var paths = [{obj:[{type:"text2",rect:[416.976,287.592,366.048,122.92],text:[""],box:{type:"loose",borderColor:"#000",color:"#FFC",borderWidth:4,radius:10}},{type:"text2",rect:[510.924,299.885,266.304,100],text:["<<fontSize:40>><<align:center>><<font:Hobo>><<color:#00F>>Please click here to subscribe"],align:[0,0]}]}];
// 	drawPathsToCanvas(pleaseSubscribeButton,paths);
// 	addListener(pleaseSubscribeButton,function() {
// 		if (personal == 1) {
// 			window.open('/phpPages/paymentPersonalAccount.php','_blank');
// 		} else {
// 			window.open('/phpPages/paymentSchoolAccount.php','_blank');
// 		}
// 	});
	
// 	var homeImage = new Image;
// 	homeImage.onload = function() {
// 		/*pleaseSubscribeButton.ctx.drawImage(homeImage,0,0,60,60);
// 		var image = pleaseSubscribeButton.ctx.getImageData(0,0,60,60);
// 		var imageData = image.data,
// 		length = imageData.length;
// 		for (var i=0; i < length; i+=4) {
// 			if (imageData[i] >= 245 && imageData[i+1] >= 245 && imageData[i+2] >= 245) {
// 				imageData[i+2] = 204;
// 			}
// 		}
// 		image.data = imageData;
// 		pleaseSubscribeButton.ctx.clearRect(0,0,60,60);
// 		pleaseSubscribeButton.ctx.putImageData(image,438,320);*/
		
// 		pleaseSubscribeButton.ctx.drawImage(homeImage,0,0,34,34);
// 		var image = pleaseSubscribeButton.ctx.getImageData(0,0,34,34);
// 		/*var imageData = image.data,
// 		length = imageData.length;
// 		for (var i=0; i < length; i+=4) {
// 			if (imageData[i] >= 245 && imageData[i+1] >= 245 && imageData[i+2] >= 245) {
// 				imageData[i+2] = 204;
// 			}
// 		}
// 		image.data = imageData;*/
// 		pleaseSubscribeButton.ctx.clearRect(0,0,50,50);
// 		pleaseSubscribeTrayButton.ctx.putImageData(image,6,3);
// 	}
// 	homeImage.src = "/Images/logoSmall.PNG";
// }
// function loginFromPage() {
// 	var d = Date.parse(new Date());
// 	if (!un(window.lastLoginAttemptTime) && d-window.lastLoginAttemptTime < 5000) {
// 		//console.log('too soon');
// 		return;
// 	}
// 	window.lastLoginAttemptTime = d;
	
// 	var inputUsername = document.getElementById('input-username').value;
// 	var inputPassword = document.getElementById('input-password').value;
// 	var params = 'auserName='+inputUsername+'&apassword='+inputPassword+'&reload=false';
	
// 	var xmlHttp = new XMLHttpRequest();
// 	xmlHttp.open("POST", "/sessionVariables/sessionLogin.php", true);
// 	xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
// 	xmlHttp.onreadystatechange = function() {
// 		if (this.readyState == 4) {
// 			//console.log(this.responseText);
// 			var userInfo = JSON.parse(this.responseText);
// 			//console.log(userInfo);
// 			if (userInfo.info == 'invalid') {
// 				Notifier.notify('Sorry! We did not recognise that username and password combination.','','/Images/logoSmall.PNG');
// 			}
// 			user = userInfo.user;
// 			personal = userInfo.personal;
// 			if (user == 'teacher' || user == 'super' || user == 'pupil') {
// 				hideObj(loginTrayButton);
// 				hideObj(loginBox);
// 				Notifier.notify("Welcome "+userInfo.name+", you have logged in to MathsPad.",'','/Images/logoSmall.PNG');
// 				disableVisibilityChangeLoginMonitor();
// 				for (var p = 0; p < draw.path.length; p++) {
// 					var path = draw.path[p];
// 					for (var o = 0; o < path.obj.length; o++) {
// 						var obj = path.obj[o];
// 						delete obj._disabled;
// 					}
// 				}
// 				drawCanvasPaths();
// 			} else if (user == 'teacherUnverified') {
// 				Notifier.notify("Welcome "+userInfo.name+", please subscribe to activate your account.",'','/Images/logoSmall.PNG');
// 				hideObj(loginTrayButton);
// 				hideObj(loginBox);
// 				showObj(pleaseSubscribeTrayButton);
// 				enableVisibilityChangeLoginMonitor();
// 			} else if (user == 'pupilUnverified') {
// 				hideObj(loginTrayButton);
// 				hideObj(loginBox);
// 			}
// 		}
// 	}
// 	xmlHttp.send(params);
// };
// function enableVisibilityChangeLoginMonitor() {
// 	// Set the name of the hidden property and the change event for visibility
// 	hidden, visibilityChange;
// 	lastLoginCheckTime = Date.parse(new Date());
// 	loginCheckCount = 0;
// 	if (typeof document.hidden !== "undefined") { // Opera 12.10 and Firefox 18 and later support 
// 		hidden = "hidden";
// 		visibilityChange = "visibilitychange";
// 	} else if (typeof document.msHidden !== "undefined") {
// 		hidden = "msHidden";
// 		visibilityChange = "msvisibilitychange";
// 	} else if (typeof document.webkitHidden !== "undefined") {
// 		hidden = "webkitHidden";
// 		visibilityChange = "webkitvisibilitychange";
// 	}
	 
// 	if (typeof document.addEventListener === "undefined" || hidden === undefined) {
// 	} else {
// 		document.addEventListener(visibilityChange, handleVisibilityChange, false);
// 	}
// }
// function disableVisibilityChangeLoginMonitor() {
// 	document.removeEventListener(visibilityChange, handleVisibilityChange, false);
// }
// function handleVisibilityChange() {
// 	if (document[hidden]) return;
// 	var d = Date.parse(new Date());
// 	if (loginCheckCount == 0 || d-lastLoginCheckTime >= 6000) {
// 		lastLoginCheckTime = d;
// 		loginCheckCount++;
		
// 		var xmlHttp = new XMLHttpRequest();
// 		xmlHttp.open("post", "teach_checkLoginStatus.php", true);
// 		xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
// 		xmlHttp.onreadystatechange = function() {
// 			if (this.readyState == 4) {
// 				//console.log(this.responseText);
// 				var userInfo = JSON.parse(this.responseText);
// 				if (user == userInfo.user) return;
// 				user = userInfo.user;
// 				personal = userInfo.personal;
// 				if (user == 'teacher' || user == 'super' || user == 'pupil') {
// 					Notifier.notify("Welcome "+userInfo.name+", you have logged in to MathsPad.",'','/Images/logoSmall.PNG');
// 					hideObj(loginBox);
// 					disableVisibilityChangeLoginMonitor();
// 					for (var p = 0; p < draw.path.length; p++) {
// 						var path = draw.path[p];
// 						for (var o = 0; o < path.obj.length; o++) {
// 							var obj = path.obj[o];
// 							delete obj._disabled;
// 						}
// 					}
// 					drawCanvasPaths();
// 				} else if (user == 'teacherUnverified') {
// 					Notifier.notify("Welcome "+userInfo.name+", please subscribe to activate your account.",'','/Images/logoSmall.PNG');
// 					hideObj(loginTrayButton);
// 					hideObj(loginBox);
// 					showObj(pleaseSubscribeTrayButton);
// 				} else if (user == 'pupilUnverified') {
// 					hideObj(loginTrayButton);
// 					hideObj(loginBox);
// 				}
// 			}
// 		}
// 		xmlHttp.send();
// 	}
// }


/*
var j227imgctx = newctx({rect:[920,30,250,100],pE:true,z:20});
text({ctx:j227imgctx,left:2,top:2,width:250-4,height:100-4,text:['Drag and drop <<br>>any image to use it as a background.'],align:'center',vertAlign:'middle',box:{type:'loose',color:'#9CF',radius:8,borderWidth:4,borderColor:'#000'}});
j227imgctx.strokeStyle = '#F00';
j227imgctx.lineWidth = 2;
j227imgctx.beginPath();
var j227x = 235;
var j227y = 15;
j227imgctx.moveTo(j227x-8,j227y-8);
j227imgctx.lineTo(j227x+8,j227y+8);
j227imgctx.moveTo(j227x-8,j227y+8);
j227imgctx.lineTo(j227x+8,j227y-8);
j227imgctx.stroke();
addListener(j227imgctx.canvas,function() {
	hideObj(this);
});
*/
var j227backImgAdded = false;
var j227imgSlider;
var j227imgScale = 1;
function j227imgScaleChange() {
	var obj = draw.path[0].obj[0];
	if (obj.type !== 'image') return;
	obj.width = j227imgScale * obj.naturalWidth;
	obj.height = j227imgScale * obj.naturalHeight;
	obj.left = 600 - obj.width / 2;
	obj.top = 350 - obj.height / 2;
	drawCanvasPaths();
}
var j227dropZone = draw.cursorCanvas;
j227dropZone.addEventListener("dragenter", handleDragEnter, false);
j227dropZone.addEventListener("dragover", handleDragOver, false);
j227dropZone.addEventListener("drop", handleDrop, false);
function handleDragEnter(e){e.stopPropagation();e.preventDefault();}
function handleDragOver(e){e.stopPropagation();e.preventDefault();}
function handleDrop(e){
	e.stopPropagation();
	e.preventDefault();
	/*if (['super','teacher','pupil'].indexOf (user) == -1) {
		Notifier.notify('Please subscribe to use this feature.','','/Images/logoSmall.PNG');
		return;
	}*/
	handleFiles(e.dataTransfer.files);
	if (e.dataTransfer.files.length == 0) {
		var img = e.dataTransfer.getData('text/html');
		var div = document.createElement("div");
		div.innerHTML = img;
		if (un(div.getElementsByTagName('img')[0]) || un(div.getElementsByTagName('img')[0].src)) {
			return;
		}
		
		var aImg = document.createElement("img");
		aImg.classList.add("obj");
		aImg.onload = function() {
			var width = aImg.naturalWidth;
			var height = aImg.naturalHeight;
			if (!un(draw.path) && !un(draw.path[0]) && !un(draw.path[0].obj) && !un(draw.path[0].obj[0]) && draw.path[0].obj[0].type == 'image') {
				draw.path.shift();
			}
			draw.path.unshift({obj:[{
				type:'image',
				image:aImg,
				src:aImg.src,
				thickness:draw.thickness,
				color:draw.color,
				left:600-width/2,
				top:350-height/2,
				width:width,
				height:height,
				naturalWidth:aImg.naturalWidth,
				naturalHeight:aImg.naturalHeight,
				scaleFactor:2,
				edit:false
			}],selected:false,_deletable:false});
			drawCanvasPaths();
			//hideObj(j227imgctx.canvas);
			if (j227backImgAdded == false) {
				j227imgSlider = createSlider({left:1020,width:150,height:60,top:700-60-20,min:0.1,max:1.5,linkedVar:'j227imgScale',varChangeListener:'j227imgScaleChange',startNum:1,label:false,zIndex:1000});
			} else {
				showSlider(j227imgSlider);
				setSliderValue(j227imgSlider,1);
			}
			j227backImgAdded = true;
		}
		aImg.src = div.getElementsByTagName('img')[0].src;
	}
}
function handleFiles(files) { // read & create an image from the image file
	for (var i = 0; i < files.length; i++) {
	  var file = files[i];
	  var imageType = /image.*/;
	  if (!file.type.match(imageType)) continue;
	  var img = document.createElement("img");
	  img.classList.add("obj");
	  img.file = file;
	  var reader = new FileReader();
	  reader.onload = (function(aImg) {
		  return function(e) {
			  aImg.onload = function() {
			  	var width = aImg.naturalWidth;
				var height = aImg.naturalHeight;
				if (!un(draw.path) && !un(draw.path[0]) && !un(draw.path[0].obj) && !un(draw.path[0].obj[0]) && draw.path[0].obj[0].type == 'image') {
					draw.path.shift();
				}
				draw.path.unshift({obj:[{
					type:'image',
					image:aImg,
					src:aImg.src,
					thickness:draw.thickness,
					color:draw.color,
					left:600-width/2,
					top:350-height/2,
					width:width,
					height:height,
					naturalWidth:aImg.naturalWidth,
					naturalHeight:aImg.naturalHeight,
					scaleFactor:2,
					edit:false
				}],selected:false,_deletable:false});
				drawCanvasPaths();
				//hideObj(j227imgctx.canvas);
				if (j227backImgAdded == false) {
					j227imgSlider = createSlider({left:1020,width:150,height:60,top:700-60-20,min:0.1,max:1.5,linkedVar:'j227imgScale',varChangeListener:'j227imgScaleChange',startNum:1,label:false,zIndex:1000});
				} else {
					showSlider(j227imgSlider);
					setSliderValue(j227imgSlider,1);
				}
				j227backImgAdded = true;
			  }
			  // e.target.result is a dataURL for the image
			  aImg.src = e.target.result;
		  }; 
	  })(img);
	  reader.readAsDataURL(file);      
	}
}
