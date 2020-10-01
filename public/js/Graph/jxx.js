// JavaScript Document

taskTag = 'jxx'; // use find & replace to change this throughout the file
initialiseTaskVariables();
loadHandler[taskId] = function() {}
backgroundLoadHandler[taskId] = function() {}

for (var jxxi = 0; jxxi < holderButton.length; jxxi++) {hideObj(holderButton[jxxi], holderButtonData[jxxi])};
if (userInfoText.parentNode == container) {container.removeChild(userInfoText)};

var jxxgrid = {
	left:75,
	top:75,
	width:770,
	height:550,
	xMin:-14,
	xMax:14,
	yMin:-10,
	yMax:10,
	xMajorStep:2,
	xMinorStep:1,
	yMajorStep:2,
	yMinorStep:1,
	path:[],
	mode:'none', // modes: none, point, line, lineSegment, function, resizeRect
	buttons:[],
	color:'#000',
	axesColor:'#000',
	minorColor:'#666',
	majorColor:'#666',
	showGrid:true,
	showScales:true,
	showLabels:true,
	showAxes:true,
	pointSize:9,
	pointWidth:3,
	lineWidth:3,
	angleMode:'deg',
	lockStepX:false,
	lockStepY:false
};

createKeyboard({
	keySize:45,
	fontSize:24,
	keyPadding:4,
	keyArray:[
		[7,8,9,'+','-',times,divide],
		[4,5,6,'(',')','='],
		[1,2,3,'frac','power','sqrt','root'],
		['.',0,'x','y','leftArrow','rightArrow','delete']
	],
	align:'left',
	keyButtonLeft:jxxgrid.left+jxxgrid.width+50+3*55,
	keyButtonTop:625,
	left:810,
	top:215,
	dragArea:[12,12,12,12],
});

addDrawTools({
	pen:{buttonPos:[jxxgrid.left+jxxgrid.width+50+1*55,625]},
	undoPen:{buttonPos:[jxxgrid.left+jxxgrid.width+50+2*55,625]},
	color:'#000',
	thickness:5,
	buttonSize:50
});

var jxxgridCanvas1 = createButton(0,0,0,1200,700,true,false,false,2);
var jxxgridCanvas2 = createButton(1,jxxgrid.left,jxxgrid.top,jxxgrid.width,jxxgrid.height,true,false,true,2);
var jxxintersectionPoints = [];
jxxdrawGrid();
addListenerStart(jxxgridCanvas2,jxxgridStart);

var jxxbuttonLeft = [jxxgrid.left+jxxgrid.width+50,jxxgrid.left+jxxgrid.width+50+1*55,jxxgrid.left+jxxgrid.width+50+2*55,jxxgrid.left+jxxgrid.width+50+3*55,jxxgrid.left+jxxgrid.width+50+4*55];
var jxxbuttonTop = [30,85];

var jxxrect = [jxxgrid.left+jxxgrid.width+45,155,1170-(jxxgrid.left+jxxgrid.width+50),460];
var jxxfunctionListCanvas = createButton(2,jxxrect[0],jxxrect[1],jxxrect[2],jxxrect[3],true,false,true,2);
jxxfunctionListCanvas.rect = jxxrect;
jxxfunctionListCanvas.draw = function() {
	var count = 0;
	var cells = [
		[{minWidth:(this.rect[2]-60),maxWidth:(this.rect[2]-60)},{minWidth:50,maxWidth:50,color:'#493d55'}] //row 0
	];
	for (var p = 0; p < Math.min(jxxgrid.path.length,7); p++) {
		var obj = jxxgrid.path[p];
		switch (obj.type) {
			case 'point':
				break;
			case 'line':
			case 'lineSegment':			
				break;
			case 'function':
			case 'function2':
				cells.push([{text:obj.text},{}]);
				count++;
				break;				
		}
	}
	if (count == 0) {
		hideObj(jxxclearFuncs);
	} else {
		showObj(jxxclearFuncs);
	}
	this.ctx.clearRect(0,0,1200,700);
	roundedRect(this.ctx,2,2,this.rect[2]-4,this.rect[3]-4,4,4,'#000',mainCanvasFillStyle);	
	this.table = drawTable2({
		ctx:this.ctx,
		cells:cells,
		left:5,
		top:5,
		horizAlign:'left',
		vertAlign:'middle',
		minCellHeight:50,
		minCellWidth:40,
		outerBorder:{show:false,width:2,color:'#000'},
		innerBorder:{show:false,width:1,color:'#666'},		
	});
	var pos = [(this.table.xPos[1]+this.table.xPos[2])/2,(this.table.yPos[0]+this.table.yPos[1])/2];
	this.ctx.lineWidth = 3;
	this.ctx.lineJoin = 'round';
	this.ctx.lineCap = 'round';
	this.ctx.strokeStyle = '#000';
	this.ctx.beginPath();
	this.ctx.moveTo(pos[0]-10,pos[1]);
	this.ctx.lineTo(pos[0]+10,pos[1]);
	this.ctx.moveTo(pos[0],pos[1]-10);
	this.ctx.lineTo(pos[0],pos[1]+10);
	this.ctx.stroke();
	this.ctx.lineWidth = 2;	
	this.ctx.strokeRect(this.table.xPos[1],this.table.yPos[0],this.table.xPos[2]-this.table.xPos[1],this.table.yPos[1]-this.table.yPos[0]);
	for (var r = 1; r < cells.length; r++) {
		pos[1] = (this.table.yPos[r]+this.table.yPos[r+1])/2;
		this.ctx.lineWidth = 3;
		this.ctx.strokeStyle = '#F00';
		this.ctx.beginPath();
		this.ctx.moveTo(pos[0]-8,pos[1]-8);
		this.ctx.lineTo(pos[0]+8,pos[1]+8);
		this.ctx.moveTo(pos[0]-8,pos[1]+8);
		this.ctx.lineTo(pos[0]+8,pos[1]-8);
		this.ctx.stroke();
		this.ctx.lineWidth = 1;
		this.ctx.strokeStyle = '#666';
		this.ctx.beginPath();
		this.ctx.moveTo(this.table.xPos[0],this.table.yPos[r+1]);
		this.ctx.lineTo(this.table.xPos[2],this.table.yPos[r+1]);
		this.ctx.stroke();
		
	}
}
jxxfunctionListCanvas.draw();

var jxxfuncInput = createMathsInput2({left:jxxrect[0]+5,top:jxxrect[1]+4,width:jxxrect[2]-63,height:49.25,textAlign:'left',fontSize:26,algText:true});
jxxfuncInput.angleMode = jxxgrid.angleMode;
setMathsInputColor(jxxfuncInput,jxxgrid.color);
jxxfuncInput.onInputEnd = function(e) {
	if (jxxfuncInput.stringJS !== '') {
		jxxaddFunction(jxxfuncInput);
		setMathsInputText(jxxfuncInput,'');
		setMathsInputColor(jxxfuncInput,jxxgrid.color);
		if (typeof e !== 'undefined' && e.type == 'keydown') {
			startMathsInput(jxxfuncInput,0);
		}
	}
}
var jxxfuncInputPlaceholder = createButton(2,jxxrect[0]+5,jxxrect[1]+4,jxxrect[2]-63,49.25,true,false,false,10);
text({ctx:jxxfuncInputPlaceholder.ctx,textArray:['<<font:algebra>><<color:#999>><<fontSize:26>>y=2x+1'],vertAlign:'middle',left:10});
addListener(jxxfuncInput.cursorCanvas,jxxremovePlaceholder);
function jxxremovePlaceholder() {
	hideObj(jxxfuncInputPlaceholder);
	removeListener(jxxfuncInput.cursorCanvas,jxxremovePlaceholder);
}

function jxxfuncTableMove(e) {
	updateMouse(e);
	var x = mouse.x - jxxfunctionListCanvas.rect[0];
	var y = mouse.y - jxxfunctionListCanvas.rect[1];
	var table = jxxfunctionListCanvas.table;
	if (x >= table.xPos[1] && x <= table.xPos[2]) {
		if (y >= table.yPos[0] && y <= table.yPos[table.yPos.length-1]) {
			jxxfunctionListCanvas.style.cursor = 'pointer';
			return;
		}
	}
	jxxfunctionListCanvas.style.cursor = 'default';
}
function jxxfuncTableClick(e) {
	updateMouse(e);
	var x = mouse.x - jxxfunctionListCanvas.rect[0];
	var y = mouse.y - jxxfunctionListCanvas.rect[1];
	var table = jxxfunctionListCanvas.table;
	if (x >= table.xPos[1] && x <= table.xPos[2]) {
		/*if (y >= table.yPos[0] && y <= table.yPos[1]) {
			jxxaddFunction(jxxfuncInput);
			setMathsInputText(jxxfuncInput,'');
			setMathsInputColor(jxxfuncInput,jxxgrid.color);
			return;
		}*/
		for (var r = 1; r < table.yPos.length-1; r++) {
			if (y >= table.yPos[r] && y <= table.yPos[r+1]) {
				var count = 0;
				for (var p = 0; p < jxxgrid.path.length; p++) {
					if (jxxgrid.path[p].type == 'function' || jxxgrid.path[p].type == 'function2') {
						if (count == r-1) {
							jxxgrid.path.splice(p,1);
							jxxdrawGrid();
							jxxfunctionListCanvas.draw();
							return;							
						} else {
							count++;
						}
					}
				}
			}			
		}
	}
}
addListenerMove(jxxfunctionListCanvas,jxxfuncTableMove);
addListener(jxxfunctionListCanvas,jxxfuncTableClick);

function png(sf,marginFactor) {
	if (typeof sf !== 'number') sf = 1;
	if (typeof marginFactor !== 'number') marginFactor = 35;
	var margin = marginFactor*sf;
	var tempgrid = clone(jxxgrid);
	var saveMainCanvasFillStyle = mainCanvasFillStyle;
	mainCanvasFillStyle = '#FFF';
	tempgrid.left = margin;
	tempgrid.top = margin;
	tempgrid.width = jxxgrid.width*sf;
	tempgrid.height = jxxgrid.height*sf;
	tempgrid.lineWidth = jxxgrid.lineWidth*sf;
	tempgrid.pointSize = jxxgrid.pointSize*sf;
	tempgrid.pointWidth = jxxgrid.pointWidth*sf;
	tempgrid.sf = sf;
	console.log(tempgrid)
	var tempCanvas = newcanvas({width:tempgrid.width+2*margin,height:tempgrid.height+2*margin,visible:false});
	
	tempCanvas.ctx.fillStyle = '#FFF';
	tempCanvas.ctx.fillRect(0,0,tempCanvas.width,tempCanvas.height);
	jxxdrawGrid(tempCanvas.ctx,tempgrid,false);
	window.open(tempCanvas.toDataURL("image/png"),'_blank');
	mainCanvasFillStyle = saveMainCanvasFillStyle;
}

/*
function floodFill(ctx,left,top,width,height,startX,startY,fillColor) {
	var imgData = ctx.getImageData(left, top, width, height);
	var pixelPos = startY * width * 4 + startX * 4;
	var startColor = [imgData[pixelPos],imgData[pixelPos+1],imgData[pixelPos+2]];
	console.log(imgData,imgData[0]);
	
	var pixelStack = [[startX, startY]];

	while(pixelStack.length)
	{
	  var newPos, x, y, pixelPos, reachLeft, reachRight;
	  newPos = pixelStack.pop();
	  x = newPos[0];
	  y = newPos[1];
	  
	  pixelPos = (y*width + x) * 4;
	  while(y-- >= 0 && matchStartColor(pixelPos))
	  {
		pixelPos -= width * 4;
	  }
	  pixelPos += width * 4;
	  ++y;
	  reachLeft = false;
	  reachRight = false;
	  while(y++ < height-1 && matchStartColor(pixelPos))
	  {
		colorPixel(pixelPos);

		if(x > 0)
		{
		  if(matchStartColor(pixelPos - 4))
		  {
			if(!reachLeft){
			  pixelStack.push([x - 1, y]);
			  reachLeft = true;
			}
		  }
		  else if(reachLeft)
		  {
			reachLeft = false;
		  }
		}
		
		if(x < width-1)
		{
		  if(matchStartColor(pixelPos + 4))
		  {
			if(!reachRight)
			{
			  pixelStack.push([x + 1, y]);
			  reachRight = true;
			}
		  }
		  else if(reachRight)
		  {
			reachRight = false;
		  }
		}
				
		pixelPos += width * 4;
	  }
	}
	ctx.putImageData(imgData, left, top);
	  
	function matchStartColor(pixelPos)
	{
	  var r = imgData[pixelPos];	
	  var g = imgData[pixelPos+1];	
	  var b = imgData[pixelPos+2];

	  return (r == startColor[0] && g == startColor[1] && b == startColor[2]);
	}

	function colorPixel(pixelPos)
	{
	  imgData[pixelPos] = fillColor[0];
	  imgData[pixelPos+1] = fillColor[1];
	  imgData[pixelPos+2] = fillColor[2];
	  imgData[pixelPos+3] = fillColor[3];
	}	
}
*/

function jxxfindIntersectionPoints() {
	jxxintersectionPoints = [];
	for (var i = 0; i < jxxgrid.path.length; i++) {
		var obj1 = jxxgrid.path[i];
		if (obj1.type == 'point') continue;
		if (obj1.type == 'line' && typeof obj1.endPos == 'undefined') continue;	
		if (obj1.type == 'lineSegment' && obj1.pos.length < 2) continue;
		switch (obj1.type) {
			case 'lineSegment':
				var pos1 = [getPosOfCoordX2(obj1.pos[0][0],jxxgrid.left,jxxgrid.width,jxxgrid.xMin,jxxgrid.xMax),getPosOfCoordY2(obj1.pos[0][1],jxxgrid.top,jxxgrid.height,jxxgrid.yMin,jxxgrid.yMax)];
				var pos2 = [getPosOfCoordX2(obj1.pos[1][0],jxxgrid.left,jxxgrid.width,jxxgrid.xMin,jxxgrid.xMax),getPosOfCoordY2(obj1.pos[1][1],jxxgrid.top,jxxgrid.height,jxxgrid.yMin,jxxgrid.yMax)];
				break;
			case 'line':
				var pos1 = obj1.endPos[0];
				var pos2 = obj1.endPos[1];
				break;
		}
		for (var j = i + 1; j < jxxgrid.path.length; j++) {
			var obj2 = jxxgrid.path[j];
			if (obj2.type == 'point') continue;
			if (obj2.type == 'line' && typeof obj2.endPos == 'undefined') continue;
			if (obj2.type == 'lineSegment' && obj2.pos.length < 2) continue;				
			switch (obj2.type) {
				case 'lineSegment':
					var pos3 = [getPosOfCoordX2(obj2.pos[0][0],jxxgrid.left,jxxgrid.width,jxxgrid.xMin,jxxgrid.xMax),getPosOfCoordY2(obj2.pos[0][1],jxxgrid.top,jxxgrid.height,jxxgrid.yMin,jxxgrid.yMax)];
					var pos4 = [getPosOfCoordX2(obj2.pos[1][0],jxxgrid.left,jxxgrid.width,jxxgrid.xMin,jxxgrid.xMax),getPosOfCoordY2(obj2.pos[1][1],jxxgrid.top,jxxgrid.height,jxxgrid.yMin,jxxgrid.yMax)];
					break;
				case 'line':
					var pos3 = obj2.endPos[0];
					var pos4 = obj2.endPos[1];					
					break;
			}
			//console.log(pos1,pos2,pos3,pos4);			
			switch (obj1.type) {
				case 'lineSegment':
				case 'line':
					switch (obj2.type) {
						case 'lineSegment':				
						case 'line':
							if (intersects2(pos1[0],pos1[1],pos2[0],pos2[1],pos3[0],pos3[1],pos4[0],pos4[1])) {
								var inter = intersection(pos1[0],pos1[1],pos2[0],pos2[1],pos3[0],pos3[1],pos4[0],pos4[1]);
								jxxintersectionPoints.push({pos:inter,a:i,b:j});
							}
							break;
						case 'function':
							for (var p1 = 0; p1 < obj2.pos.length; p1++) {
								if (obj2.pos[p1].length < 2) continue;
								for (var p2 = 0; p2 < obj2.pos[p1].length - 1; p2++) {
									var pos3 = obj2.pos[p1][p2];
									var pos4 = obj2.pos[p1][p2+1];
									if (intersects2(pos1[0],pos1[1],pos2[0],pos2[1],pos3[0],pos3[1],pos4[0],pos4[1])) {
										var inter = intersection(pos1[0],pos1[1],pos2[0],pos2[1],pos3[0],pos3[1],pos4[0],pos4[1]);
										jxxintersectionPoints.push({pos:inter,a:i,b:j});
									}									
								}
							}
							break;
						case 'function2':
							break;									
					}					
					break;
				case 'function':
					switch (obj2.type) {
						case 'lineSegment':				
						case 'line':
							for (var p1 = 0; p1 < obj1.pos.length; p1++) {
								if (obj1.pos[p1].length < 2) continue;
								for (var p2 = 0; p2 < obj1.pos[p1].length - 1; p2++) {
									var pos1 = obj1.pos[p1][p2];
									var pos2 = obj1.pos[p1][p2+1];
									if (intersects2(pos1[0],pos1[1],pos2[0],pos2[1],pos3[0],pos3[1],pos4[0],pos4[1])) {
										var inter = intersection(pos1[0],pos1[1],pos2[0],pos2[1],pos3[0],pos3[1],pos4[0],pos4[1]);
										jxxintersectionPoints.push({pos:inter,a:i,b:j});
									}									
								}
							}
							break;
						case 'function':
							for (var p1 = 0; p1 < obj1.pos.length; p1++) {
								if (obj1.pos[p1].length < 2) continue;
								for (var p2 = 0; p2 < obj1.pos[p1].length - 1; p2++) {
									var pos1 = obj1.pos[p1][p2];
									var pos2 = obj1.pos[p1][p2+1];	
									for (var p3 = 0; p3 < obj2.pos.length; p3++) {
										if (obj2.pos[p3].length < 2) continue;
										for (var p4 = 0; p4 < obj2.pos[p3].length - 1; p4++) {
											var pos3 = obj2.pos[p3][p4];
											var pos4 = obj2.pos[p3][p4+1];
											if (intersects2(pos1[0],pos1[1],pos2[0],pos2[1],pos3[0],pos3[1],pos4[0],pos4[1])) {
												var inter = intersection(pos1[0],pos1[1],pos2[0],pos2[1],pos3[0],pos3[1],pos4[0],pos4[1]);
												jxxintersectionPoints.push({pos:inter,a:i,b:j});
											}									
										}
									}	
								}
							}								
							break;
						case 'function2':
							break;									
					}					
					break;
				case 'function2':
					switch (obj2.type) {
						case 'lineSegment':				
						case 'line':
							break;
						case 'function':
							break;
						case 'function2':
							break;									
					}					
					break;					
			}
		}
	}
	jxxgridCanvas1.ctx.fillStyle = '#F00';	
	for (var i = 0; i < jxxintersectionPoints.length; i++) {
		jxxgridCanvas1.ctx.beginPath();
		jxxgridCanvas1.ctx.arc(jxxintersectionPoints[i].pos[0],jxxintersectionPoints[i].pos[1],8,0,2*Math.PI);;
		jxxgridCanvas1.ctx.fill();
	}
}

function jxxresetAxes() {
	jxxresetXScale();
	jxxresetYScale();
	jxxdrawGrid();
}
function jxxresetXScale() {
	if (jxxgrid.lockStepX == true) return;
	if (jxxgrid.mode == 'deg' || typeof jxxgrid.xMin == 'number') {
		var xDiff = jxxgrid.xMax - jxxgrid.xMin;
		var xMag = Math.log(xDiff)/Math.log(10);
		var xMag1 = Math.floor(xMag);
		var xMag2 = xMag - xMag1;
		if (xDiff % 180 == 0) { // assume degrees
			jxxgrid.xMinorStep = Math.pow(10,xMag1-2)*30;
			jxxgrid.xMajorStep = Math.pow(10,xMag1-2)*90;
		} else {
			if (xMag2 < 0.35) {
				jxxgrid.xMinorStep = Math.pow(10,xMag1-2)*10;
				jxxgrid.xMajorStep = Math.pow(10,xMag1-1)*2;		
			} else if (xMag2 < 0.5) {
				jxxgrid.xMinorStep = Math.pow(10,xMag1-1);
				jxxgrid.xMajorStep = Math.pow(10,xMag1)/2;		
			} else if (xMag2 < 0.65) {
				jxxgrid.xMinorStep = Math.pow(10,xMag1-1);
				jxxgrid.xMajorStep = Math.pow(10,xMag1-1)*2;		
			} else {
				jxxgrid.xMinorStep = Math.pow(10,xMag1-1)*5;
				jxxgrid.xMajorStep = Math.pow(10,xMag1);		
			}
		}
		jxxxScaleMenu.setInputs();
	} else {
		var xDiff = jxxgrid.xMax[0]/jxxgrid.xMax[1] - jxxgrid.xMin[0]/jxxgrid.xMin[1]; // as mult of pi
		var xMag1 = Math.log(xDiff)/Math.log(2);
		var xMag2 = Math.pow(2,Math.round(xMag1));
		var rem = xMag1 - Math.floor(xMag1);
		if (xMag1 > 2) {
			jxxgrid.xMajorStep = [xMag2,8];
			jxxgrid.xMinorStep = [xMag2,16];		
		} else {
			jxxgrid.xMajorStep = [xMag2,8];
			jxxgrid.xMinorStep = [xMag2,24];			
		}
	}
}
function jxxresetYScale() {
	if (jxxgrid.lockStepY == true) return;	
	var yDiff = jxxgrid.yMax - jxxgrid.yMin;
	var yMag = Math.log(yDiff)/Math.log(10);
	var yMag1 = Math.floor(yMag);
	var yMag2 = yMag - yMag1;
	if (yDiff % 180 == 0) { // assume degrees
		jxxgrid.yMinorStep = Math.pow(10,yMag1-2)*30;
		jxxgrid.yMajorStep = Math.pow(10,yMag1-2)*90;
	} else {
		if (yMag2 < 0.35) {
			jxxgrid.yMinorStep = Math.pow(10,yMag1-2)*10;
			jxxgrid.yMajorStep = Math.pow(10,yMag1-1)*2;		
		} else if (yMag2 < 0.5) {
			jxxgrid.yMinorStep = Math.pow(10,yMag1-1);
			jxxgrid.yMajorStep = Math.pow(10,yMag1)/2;		
		} else if (yMag2 < 0.65) {
			jxxgrid.yMinorStep = Math.pow(10,yMag1-1)*2;
			jxxgrid.yMajorStep = Math.pow(10,yMag1);		
		} else {
			jxxgrid.yMinorStep = Math.pow(10,yMag1-1)*5;
			jxxgrid.yMajorStep = Math.pow(10,yMag1);		
		}
	}
	jxxyScaleMenu.setInputs();	
}
function jxxdrawGrid(gridctx,gridDetails,clear) {
	if (typeof gridctx == 'undefined') gridctx = jxxgridCanvas1.ctx;
	if (typeof gridDetails == 'undefined') gridDetails = jxxgrid;
	if (boolean(clear,true) == true) gridctx.clearRect(0,0,1200,700);
	drawGrid3(gridctx,0,0,gridDetails);
	for (var p = 0; p < gridDetails.path.length; p++) {
		var obj = gridDetails.path[p];
		switch (obj.type) {
			case 'point':
				drawCoord(gridctx,0,0,gridDetails,obj.pos[0],obj.pos[1],obj.color);
				break;
			case 'line':
			case 'lineSegment':			
				if (obj.pos[0].length == 0) {
					if (obj.pos[1].length == 0) {
						continue;	
					} else {
						drawCoord(gridctx,0,0,gridDetails,obj.pos[1][0],obj.pos[1][1],obj.color);
					}
				} else if (obj.pos[1].length == 0) {
					drawCoord(gridctx,0,0,gridDetails,obj.pos[0][0],obj.pos[0][1],obj.color);	
				}
				if (obj.pos[0][0] == obj.pos[1][0] && obj.pos[0][1] == obj.pos[1][1]) {
					drawCoord(gridctx,0,0,gridDetails,obj.pos[0][0],obj.pos[0][1],obj.color);	
				} else {
					if (typeof obj.dashSize == 'undefined') obj.dashSize = [0,0];
					if (obj.type == 'line') {
						obj.endPos = drawLine(gridctx,0,0,gridDetails,obj.pos[0][0],obj.pos[0][1],obj.pos[1][0],obj.pos[1][1],obj.color,3,false,false,true,obj.dashSize[0],obj.dashSize[1]);
					} else if (obj.type == 'lineSegment') {
						drawLine(gridctx,0,0,gridDetails,obj.pos[0][0],obj.pos[0][1],obj.pos[1][0],obj.pos[1][1],obj.color,3,false,true,true,obj.dashSize[0],obj.dashSize[1]);
					}
				}			
				break;
			case 'function':
				if (gridDetails.angleMode == 'rad') {
					obj.funcPos = calcFunc2(gridDetails,obj.funcRad);
				} else {
					obj.funcPos = calcFunc2(gridDetails,obj.funcDeg);
				}
				obj.pos = drawFunc(gridctx,0,0,gridDetails,obj.funcPos,obj.color);
				break;
			case 'function2':
				if (gridDetails.angleMode == 'rad') {
					jxxplotFunc4(gridctx,gridDetails,obj.funcRad,10,obj.color);
				} else {
					jxxplotFunc4(gridctx,gridDetails,obj.funcDeg,10,obj.color);
				}			
				break;				
		}
	}
	//jxxfindIntersectionPoints()
}

function jxxgridStart(e) {
	if (jxxgrid.mode == 'none') return;
	updateMouse(e);
	var pos = getCoordAtMousePos(jxxgrid);
	if (jxxgrid.angleMode == 'deg') {
		var xPos = roundToNearest(pos[0],jxxgrid.xMinorStep);
	} else if (typeof jxxgrid.xMinorStep == 'number') {
		var xPos = roundToNearest(pos[0],Math.PI*jxxgrid.xMinorStep);
	} else {
		var xPos = roundToNearest(pos[0],Math.PI*(jxxgrid.xMinorStep[0]/jxxgrid.xMinorStep[1]));
	}
	var yPos = roundToNearest(pos[1],jxxgrid.yMinorStep);
	switch (jxxgrid.mode) {
		case 'point':
			var found = false;
			for (var p = 0; p < jxxgrid.path.length; p++) {
				var obj = jxxgrid.path[p];
				if (obj.type == 'point' && obj.pos[0] == xPos && obj.pos[1] == yPos) {
					jxxgrid.path.splice(p,1);
					found = true;
					break;	
				}
			}
			if (found == false) jxxgrid.path.push({type:'point',pos:[xPos,yPos],color:jxxgrid.color,time:Date.parse(new Date())});
			jxxdrawGrid();
			break;
		case 'line':
		case 'lineSegment':
			var matchFound = false;
			for (var p = 0; p < jxxgrid.path.length; p++) {
				var obj = jxxgrid.path[p];
				if (obj.type == jxxgrid.mode) {
					if (obj.pos[0][0] == xPos && obj.pos[0][1] == yPos) {
						jxxgrid.path.push({type:jxxgrid.mode,pos:[obj.pos[1],obj.pos[0]],color:jxxgrid.color,time:Date.parse(new Date())});
						jxxgrid.path.splice(p,1);
						matchFound = true;
						break;
					} else if (obj.pos[1][0] == xPos && obj.pos[1][1] == yPos) {
						jxxgrid.path.push({type:jxxgrid.mode,pos:[obj.pos[0],obj.pos[1]],color:jxxgrid.color,time:Date.parse(new Date())});					
						jxxgrid.path.splice(p,1);			
						matchFound = true;
						break;
					}
				}
			}
			if (matchFound == false) {
				jxxgrid.path.push({type:jxxgrid.mode,pos:[[xPos,yPos],[xPos,yPos]],color:jxxgrid.color,time:Date.parse(new Date())});
			}
			jxxdrawGrid();
			addListenerMove(window,jxxlineDrawMove)
			addListenerEnd(window,jxxlineDrawEnd)		
			break;
		case 'function':
			break;
		case 'move':
			jxxgrid.dragX = [mouse.x];
			jxxgrid.dragY = [mouse.y];
			if (jxxgrid.mode == 'deg' || typeof jxxgrid.xMin == 'number') {
				jxxgrid.dragXDiff = jxxgrid.xMax - jxxgrid.xMin;
			} else {
				jxxgrid.dragXDiff = Math.PI*jxxgrid.xMax[0]/jxxgrid.xMax[1] - Math.PI*jxxgrid.xMin[0]/jxxgrid.xMin[1];
			}
			jxxgrid.dragYDiff = jxxgrid.yMax - jxxgrid.yMin;
			jxxgridCanvas2.style.cursor = 'url("../images/cursors/closedhand.cur"), auto';
			addListenerMove(window,jxxgridMoveMove);
			addListenerEnd(window,jxxgridMoveEnd);
			break;
		case 'zoomRect':
			jxxgrid.dragX = [mouse.x];
			jxxgrid.dragY = [mouse.y];
			if (typeof jxxgridCanvas2.ctx.setLineDash == 'undefined') jxxgridCanvas2.ctx.setLineDash = function(){};
			jxxgridCanvas2.ctx.setLineDash([8,8]);
			jxxgridCanvas2.ctx.lineCap = 'round';
			jxxgridCanvas2.ctx.lineJoin = 'round';
			jxxgridCanvas2.ctx.lineWidth = 2;
			jxxgridCanvas2.ctx.strokeStyle = '#000';
			addListenerMove(window,jxxgridzoomSelMove);
			addListenerEnd(window,jxxgridzoomSelEnd);		
			break;
		case 'resize' :
			if (jxxgrid.angleMode == 'deg' || typeof jxxgrid.xMin == 'number') {
				jxxgrid.rescaleX = Number(roundSF(jxxgrid.xMin + (jxxgrid.xMax - jxxgrid.xMin) * (mouse.x - jxxgrid.left) / jxxgrid.width, 2));
			} else {
				var xMin = Math.PI*jxxgrid.xMin[0]/jxxgrid.xMin[1];
				var xMax = Math.PI*jxxgrid.xMax[0]/jxxgrid.xMax[1];
				jxxgrid.rescaleX = Number(roundSF(xMin + (xMax - xMin) * (mouse.x - jxxgrid.left) / jxxgrid.width, 2));
			}
			jxxgrid.rescaleY = Number(roundSF(jxxgrid.yMax - (jxxgrid.yMax - jxxgrid.yMin) * (mouse.y - jxxgrid.top) / jxxgrid.height, 2));
			jxxgrid.lockStepX = false;
			jxxgrid.lockStepY = false;
			addListenerMove(window, jxxgridRescaleMove);
			addListenerEnd(window, jxxgridRescaleStop);			
			break;			
	}
}

function jxxdrawButtons() {
	for (var b = 0; b < jxxgrid.buttons.length; b++) {
		var button = jxxgrid.buttons[b];
		if (jxxgrid.mode !== button.selectedMode) {
			var color = '#FFF';
		} else {
			var color = mainCanvasFillStyle;
		}
		button.ctx.clearRect(0,0,50,50);
		roundedRect(button.ctx,3,3,44,44,8,6,'#FFF',color);
		button.ctx.lineJoin = 'round';
		button.ctx.lineCap = 'round';
		button.ctx.strokeStyle = jxxgrid.color;
		button.ctx.fillStyle = mainCanvasFillStyle;			
		button.draw();
	}
}

function jxxAddButton(selectedMode,drawFunc,clickFunc) {
	var num = jxxgrid.buttons.length;
	var button = createButton(0,jxxbuttonLeft[num%5],jxxbuttonTop[Math.floor(num/5)],50,50,true,false,true);
	button.selectedMode = selectedMode;
	button.draw = drawFunc;
	button.click = clickFunc;
	jxxgrid.buttons.push(button);	
}

function jxxchangeMode(mode) {
	if (jxxgrid.mode == mode) {
		jxxgrid.mode = 'move'; //default
	} else {
		jxxgrid.mode = mode;
	}
	jxxdrawButtons();
	switch (jxxgrid.mode) {
		case 'move' :
			jxxgridCanvas2.style.pointerEvents = 'auto';
			jxxgridCanvas2.style.cursor = 'url("../images/cursors/openhand.cur"), auto'
			break;
		case 'zoomRect' :
			jxxgridCanvas2.style.pointerEvents = 'auto';
			jxxgridCanvas2.style.cursor = 'pointer'		
			break;
		case 'resize' :
			jxxgridCanvas2.style.pointerEvents = 'auto';
			if (jxxgrid.mode == 'deg' || typeof jxxgrid.xMin == 'number') {
				jxxgrid.originPos = [getPosOfCoordX2(0,jxxgrid.left,jxxgrid.width,jxxgrid.xMin,jxxgrid.xMax),getPosOfCoordY2(0,jxxgrid.top,jxxgrid.height,jxxgrid.yMin,jxxgrid.yMax)];
			} else {
				jxxgrid.originPos = [getPosOfCoordX2(0,jxxgrid.left,jxxgrid.width,Math.PI*jxxgrid.xMin[0]/jxxgrid.xMin[1],Math.PI*jxxgrid.xMax[0]/jxxgrid.xMax[1]),getPosOfCoordY2(0,jxxgrid.top,jxxgrid.height,jxxgrid.yMin,jxxgrid.yMax)];
			}
			addListenerMove(jxxgridCanvas2,jxxresizeMove1);
			break;
		case 'point' :
			jxxgridCanvas2.style.pointerEvents = 'auto';
			jxxgridCanvas2.style.cursor = 'pointer'
			break;
		case 'lineSegment' :
		case 'line' :
			jxxgridCanvas2.style.pointerEvents = 'auto';
			jxxgridCanvas2.style.cursor = 'pointer'
			break;					
		default :
			jxxgridCanvas2.style.pointerEvents = 'none';
			break;
	}
	if (jxxgrid.mode !== 'resize') {
		removeListenerMove(jxxgridCanvas2,jxxresizeMove1);
	}
}
function jxxresizeMove1(e) {
	updateMouse(e);
	//console.log([mouse.x,mouse.y],jxxgrid.originPos);
	if (mouse.x >= jxxgrid.originPos[0]) {
		if (mouse.y >= jxxgrid.originPos[1]) {
			jxxgridCanvas2.style.cursor = 'nw-resize';
		} else {
			jxxgridCanvas2.style.cursor = 'ne-resize';
		}
	} else {
		if (mouse.y >= jxxgrid.originPos[1]) {
			jxxgridCanvas2.style.cursor = 'ne-resize';
		} else {
			jxxgridCanvas2.style.cursor = 'nw-resize';
		}
	}
}

jxxchangeMode('move');

jxxAddButton('move',
	function() {
		if (typeof jxxe !== 'undefined') this.ctx.drawImage(jxxe,13,13,jxxe.w,jxxe.h);	
	},
	function() {
		jxxchangeMode('move');
	}
);
jxxAddButton('zoomIn',
	function() {
		this.ctx.strokeStyle = '#000';
		this.ctx.fillStyle = mainCanvasFillStyle;	
		this.ctx.lineWidth = 6;
		this.ctx.beginPath();
		this.ctx.moveTo(20,20);
		this.ctx.lineTo(35,35);
		this.ctx.stroke();
		this.ctx.lineWidth = 2;	
		this.ctx.beginPath();
		this.ctx.arc(20,20,10,0,2*Math.PI);
		this.ctx.fill();
		this.ctx.stroke();
		this.ctx.beginPath();
		this.ctx.moveTo(16,20);
		this.ctx.lineTo(24,20);
		this.ctx.moveTo(20,16);
		this.ctx.lineTo(20,24);	
		this.ctx.stroke();
	},
	function() {
		var jxxgridDragYDiff = jxxgrid.yMax - jxxgrid.yMin;
		var y = (jxxgrid.yMin + jxxgrid.yMax) / 2;
		jxxgrid.yMin = y - jxxgridDragYDiff/3;
		jxxgrid.yMax = y + jxxgridDragYDiff/3;		
		if (jxxgrid.mode == 'deg' || typeof jxxgrid.xMin == 'number') {
			var jxxgridDragXDiff = jxxgrid.xMax - jxxgrid.xMin;
			var x = (jxxgrid.xMin + jxxgrid.xMax) / 2;
			jxxgrid.xMin = x - jxxgridDragXDiff/3;
			jxxgrid.xMax = x + jxxgridDragXDiff/3;			
		} else {
			var jxxgridDragXDiff = (Math.PI*jxxgrid.xMax[0]/jxxgrid.xMax[1]) - (Math.PI*jxxgrid.xMin[0]/jxxgrid.xMin[1]);
			var x = ((Math.PI*jxxgrid.xMax[0]/jxxgrid.xMax[1]) + (Math.PI*jxxgrid.xMin[0]/jxxgrid.xMin[1])) / 2;
			jxxgrid.xMin = roundToFraction((x-jxxgridDragXDiff)/(3*Math.PI),jxxgrid.xMinorStep);
			jxxgrid.xMax = roundToFraction((x+jxxgridDragXDiff)/(3*Math.PI),jxxgrid.xMinorStep);
		}
		jxxgrid.lockStepX = false;
		jxxgrid.lockStepY = false;		
		jxxresetAxes();		
	}
);
jxxAddButton('zoomOut',
	function() {
		this.ctx.strokeStyle = '#000';
		this.ctx.fillStyle = mainCanvasFillStyle;	
		this.ctx.lineWidth = 6;
		this.ctx.beginPath();
		this.ctx.moveTo(20,20);
		this.ctx.lineTo(35,35);
		this.ctx.stroke();
		this.ctx.lineWidth = 2;	
		this.ctx.beginPath();
		this.ctx.arc(20,20,10,0,2*Math.PI);
		this.ctx.fill();
		this.ctx.stroke();
		this.ctx.beginPath();
		this.ctx.moveTo(16,20);
		this.ctx.lineTo(24,20);
		this.ctx.stroke();	
	},
	function() {
		var jxxgridDragYDiff = jxxgrid.yMax - jxxgrid.yMin;
		var y = (jxxgrid.yMin + jxxgrid.yMax) / 2;
		jxxgrid.yMin = y - jxxgridDragYDiff*0.75;
		jxxgrid.yMax = y + jxxgridDragYDiff*0.75;
		if (jxxgrid.mode == 'deg' || typeof jxxgrid.xMin == 'number') {
			var jxxgridDragXDiff = jxxgrid.xMax - jxxgrid.xMin;
			var x = (jxxgrid.xMin + jxxgrid.xMax) / 2;
			jxxgrid.xMin = x - jxxgridDragXDiff;
			jxxgrid.xMax = x + jxxgridDragXDiff;
		} else {
			var jxxgridDragXDiff = (Math.PI*jxxgrid.xMax[0]/jxxgrid.xMax[1]) - (Math.PI*jxxgrid.xMin[0]/jxxgrid.xMin[1]);
			var x = ((Math.PI*jxxgrid.xMax[0]/jxxgrid.xMax[1]) + (Math.PI*jxxgrid.xMin[0]/jxxgrid.xMin[1])) / 2;
			jxxgrid.xMin = roundToFraction((x-jxxgridDragXDiff*0.75)/Math.PI,jxxgrid.xMinorStep);
			jxxgrid.xMax = roundToFraction((x+jxxgridDragXDiff*0.75)/Math.PI,jxxgrid.xMinorStep);		
		}
		jxxgrid.lockStepX = false;
		jxxgrid.lockStepY = false;		
		jxxresetAxes();			
	}
);
jxxAddButton('zoomRect',
	function() {
		this.ctx.strokeStyle = '#000';
		this.ctx.fillStyle = mainCanvasFillStyle;
		if (typeof this.ctx.setLineDash == 'undefined') this.ctx.setLineDash = function(){};
		this.ctx.setLineDash([5,5]);
		this.ctx.lineWidth = 2;
		this.ctx.strokeRect(10,10,22,22);
		this.ctx.lineWidth = 4;
		this.ctx.setLineDash([]);
		this.ctx.beginPath();
		this.ctx.moveTo(30,30);
		this.ctx.lineTo(40,40);
		this.ctx.stroke();
		this.ctx.lineWidth = 2;	
		this.ctx.beginPath();
		this.ctx.arc(30,30,6.66,0,2*Math.PI);
		this.ctx.fill();
		this.ctx.stroke();
	},
	function() {
		jxxchangeMode('zoomRect');
	}
);
jxxAddButton('resize',
	function() {
		this.ctx.strokeStyle = '#000';
		this.ctx.fillStyle = mainCanvasFillStyle;
		drawArrow({ctx:this.ctx,startX:15,startY:35,finX:35,finY:15,doubleEnded:true,arrowLength:8,angleBetweenLinesRads:0.8,fillArrow:true,lineWidth:4});
	},
	function() {
		jxxchangeMode('resize');
	}
);
jxxAddButton('point',
	function() {
		this.ctx.lineWidth = 2;
		var size = 6;
		this.ctx.beginPath();
		this.ctx.moveTo(25-size,25-size);
		this.ctx.lineTo(25+size,25+size);
		this.ctx.moveTo(25+size,25-size);
		this.ctx.lineTo(25-size,25+size);	
		this.ctx.stroke();	
	},
	function() {
		jxxchangeMode('point');
	}
);
jxxAddButton('lineSegment',
	function() {
		this.ctx.lineWidth = 2;
		this.ctx.beginPath();
		this.ctx.moveTo(13,17);
		this.ctx.lineTo(37,32);
		this.ctx.stroke();
		this.ctx.lineWidth = 1.4;
		var size = 3;
		this.ctx.beginPath();
		this.ctx.moveTo(13-size,17-size);
		this.ctx.lineTo(13+size,17+size);
		this.ctx.moveTo(13+size,17-size);
		this.ctx.lineTo(13-size,17+size);
		this.ctx.moveTo(37-size,32-size);
		this.ctx.lineTo(37+size,32+size);
		this.ctx.moveTo(37+size,32-size);
		this.ctx.lineTo(37-size,32+size);			
		this.ctx.stroke()			
	},
	function() {
		jxxchangeMode('lineSegment');
	}
);
jxxAddButton('line',
	function() {
		this.ctx.lineWidth = 2;
		this.ctx.beginPath();
		this.ctx.moveTo(0,12);
		this.ctx.lineTo(50,37);
		this.ctx.stroke();		
	},
	function() {
		jxxchangeMode('line');
	}
);

var jxxadvanced = false;
var jxxadvancedButtonSize = 50;
var jxxadvancedButton = createButton(0,jxxgrid.left+jxxgrid.width+50+4*55,625,50,50,true,false,true,99999999);
jxxadvancedButton.draw = function() {
	if (jxxadvanced == true) {
		roundedRect(this.ctx,3,3,50-6,50-6,6,4,'#000',mainCanvasFillStyle);	
	} else {
		roundedRect(this.ctx,3,3,50-6,50-6,6,4,'#000','#FFF');	
	}
	this.ctx.strokeStyle = '#333';
	this.ctx.lineWidth = 1;
	this.ctx.beginPath();
	this.ctx.moveTo(jxxadvancedButtonSize*1/5,jxxadvancedButtonSize*1/5);
	this.ctx.lineTo(jxxadvancedButtonSize*4/5,jxxadvancedButtonSize*1/5);
	this.ctx.moveTo(jxxadvancedButtonSize*1/5,jxxadvancedButtonSize*2/5);
	this.ctx.lineTo(jxxadvancedButtonSize*4/5,jxxadvancedButtonSize*2/5);
	this.ctx.moveTo(jxxadvancedButtonSize*1/5,jxxadvancedButtonSize*3/5);
	this.ctx.lineTo(jxxadvancedButtonSize*4/5,jxxadvancedButtonSize*3/5);
	this.ctx.moveTo(jxxadvancedButtonSize*1/5,jxxadvancedButtonSize*4/5);
	this.ctx.lineTo(jxxadvancedButtonSize*4/5,jxxadvancedButtonSize*4/5);	
	this.ctx.moveTo(jxxadvancedButtonSize*1/5,jxxadvancedButtonSize*1/5);
	this.ctx.lineTo(jxxadvancedButtonSize*1/5,jxxadvancedButtonSize*4/5);
	this.ctx.moveTo(jxxadvancedButtonSize*2/5,jxxadvancedButtonSize*1/5);
	this.ctx.lineTo(jxxadvancedButtonSize*2/5,jxxadvancedButtonSize*4/5);
	this.ctx.moveTo(jxxadvancedButtonSize*3/5,jxxadvancedButtonSize*1/5);
	this.ctx.lineTo(jxxadvancedButtonSize*3/5,jxxadvancedButtonSize*4/5);
	this.ctx.moveTo(jxxadvancedButtonSize*4/5,jxxadvancedButtonSize*1/5);
	this.ctx.lineTo(jxxadvancedButtonSize*4/5,jxxadvancedButtonSize*4/5);	
	this.ctx.stroke();
};
jxxadvancedButton.draw();
jxxadvancedButton.click = function() {
	jxxadvanced = !jxxadvanced;
	if (jxxadvanced == true) {
		showObj(jxxshowScaleButton);
		showObj(jxxshowAxesButton);
		showObj(jxxshowGridButton);
		showObj(jxxangleModeButton);
		if (jxxgrid.angleMode == 'deg') showObj(jxxequalizeButton);
		showObj(jxxyScaleMenu);
		showObj(jxxxScaleMenu);
	} else {
		hideObj(jxxshowScaleButton);
		hideObj(jxxshowAxesButton);
		hideObj(jxxshowGridButton);
		hideObj(jxxangleModeButton);
		hideObj(jxxequalizeButton);
		hideObj(jxxyScaleMenu);
		hideObj(jxxxScaleMenu);		
	}
	jxxadvancedButton.draw();
};
addListener(jxxadvancedButton,jxxadvancedButton.click);

var jxxshowScaleButtonSize = 40;
var jxxshowScaleButton = createButton(0,jxxgrid.left+jxxgrid.width*2/3+0*40,jxxgrid.top-55,jxxshowScaleButtonSize,jxxshowScaleButtonSize,false,false,true);
jxxshowScaleButton.draw = function() {
	if (jxxgrid.showScales == false) {
		roundedRect(this.ctx,3,3,jxxshowScaleButtonSize-6,jxxshowScaleButtonSize-6,6,4,'#000',mainCanvasFillStyle);	
	} else {
		roundedRect(this.ctx,3,3,jxxshowScaleButtonSize-6,jxxshowScaleButtonSize-6,6,4,'#000','#FFF');	
	}
	this.ctx.strokeStyle = '#000';
	this.ctx.lineWidth = 1;
	text({ctx:this.ctx,align:'center',vertAlign:'middle',textArray:['<<font:algebra>><<fontSize:18>>xy']});
};
jxxshowScaleButton.draw();
jxxshowScaleButton.click = function() {
	jxxgrid.showScales = !jxxgrid.showScales;
	if (jxxgrid.showScales == true) {
		jxxgrid.showLabels = true;
		jxxgrid.showAxes = true;
	} else {
		jxxgrid.showLabels = false;
	}
	jxxdrawGrid();
	jxxshowAxesButton.draw();	
	jxxshowScaleButton.draw();
};
addListener(jxxshowScaleButton,jxxshowScaleButton.click);

var jxxshowAxesButtonSize = 40;
var jxxshowAxesButton = createButton(0,jxxgrid.left+jxxgrid.width*2/3+1*40,jxxgrid.top-55,jxxshowAxesButtonSize,jxxshowAxesButtonSize,false,false,true);
jxxshowAxesButton.draw = function() {
	if (jxxgrid.showAxes == false) {
		roundedRect(this.ctx,3,3,jxxshowAxesButtonSize-6,jxxshowAxesButtonSize-6,6,4,'#000',mainCanvasFillStyle);	
	} else {
		roundedRect(this.ctx,3,3,jxxshowAxesButtonSize-6,jxxshowAxesButtonSize-6,6,4,'#000','#FFF');	
	}
	this.ctx.strokeStyle = '#000';
	this.ctx.lineWidth = 2;
	this.ctx.beginPath();
	this.ctx.moveTo(jxxshowAxesButtonSize*1/5,jxxshowAxesButtonSize*1/2);
	this.ctx.lineTo(jxxshowAxesButtonSize*4/5,jxxshowAxesButtonSize*1/2);
	this.ctx.moveTo(jxxshowAxesButtonSize*1/2,jxxshowAxesButtonSize*1/5);
	this.ctx.lineTo(jxxshowAxesButtonSize*1/2,jxxshowAxesButtonSize*4/5);
	this.ctx.stroke();
};
jxxshowAxesButton.draw();
jxxshowAxesButton.click = function() {
	jxxgrid.showAxes = !jxxgrid.showAxes;
	if (jxxgrid.showAxes == false) {
		jxxgrid.showScales = false;
		jxxgrid.showLabels = false;
	}
	jxxdrawGrid();
	jxxshowAxesButton.draw();
	jxxshowScaleButton.draw();	
};
addListener(jxxshowAxesButton,jxxshowAxesButton.click);

var jxxshowGridButtonSize = 40;
var jxxshowGridButton = createButton(0,jxxgrid.left+jxxgrid.width*2/3+2*40,jxxgrid.top-55,jxxshowGridButtonSize,jxxshowGridButtonSize,false,false,true);
jxxshowGridButton.draw = function() {
	if (jxxgrid.showGrid == false) {
		roundedRect(this.ctx,3,3,jxxshowGridButtonSize-6,jxxshowGridButtonSize-6,6,4,'#000',mainCanvasFillStyle);	
	} else {
		roundedRect(this.ctx,3,3,jxxshowGridButtonSize-6,jxxshowGridButtonSize-6,6,4,'#000','#FFF');	
	}
	this.ctx.strokeStyle = '#333';
	this.ctx.lineWidth = 1;
	this.ctx.beginPath();
	this.ctx.moveTo(jxxshowGridButtonSize*1/5,jxxshowGridButtonSize*1/5);
	this.ctx.lineTo(jxxshowGridButtonSize*4/5,jxxshowGridButtonSize*1/5);
	this.ctx.moveTo(jxxshowGridButtonSize*1/5,jxxshowGridButtonSize*2/5);
	this.ctx.lineTo(jxxshowGridButtonSize*4/5,jxxshowGridButtonSize*2/5);
	this.ctx.moveTo(jxxshowGridButtonSize*1/5,jxxshowGridButtonSize*3/5);
	this.ctx.lineTo(jxxshowGridButtonSize*4/5,jxxshowGridButtonSize*3/5);
	this.ctx.moveTo(jxxshowGridButtonSize*1/5,jxxshowGridButtonSize*4/5);
	this.ctx.lineTo(jxxshowGridButtonSize*4/5,jxxshowGridButtonSize*4/5);	
	this.ctx.moveTo(jxxshowGridButtonSize*1/5,jxxshowGridButtonSize*1/5);
	this.ctx.lineTo(jxxshowGridButtonSize*1/5,jxxshowGridButtonSize*4/5);
	this.ctx.moveTo(jxxshowGridButtonSize*2/5,jxxshowGridButtonSize*1/5);
	this.ctx.lineTo(jxxshowGridButtonSize*2/5,jxxshowGridButtonSize*4/5);
	this.ctx.moveTo(jxxshowGridButtonSize*3/5,jxxshowGridButtonSize*1/5);
	this.ctx.lineTo(jxxshowGridButtonSize*3/5,jxxshowGridButtonSize*4/5);
	this.ctx.moveTo(jxxshowGridButtonSize*4/5,jxxshowGridButtonSize*1/5);
	this.ctx.lineTo(jxxshowGridButtonSize*4/5,jxxshowGridButtonSize*4/5);	
	this.ctx.stroke();
};
jxxshowGridButton.draw();
jxxshowGridButton.click = function() {
	jxxgrid.showGrid = !jxxgrid.showGrid;
	jxxdrawGrid();
	jxxshowGridButton.draw();
};
addListener(jxxshowGridButton,jxxshowGridButton.click);

var jxxangleModeButtonSize = 40;
var jxxangleModeButton = createButton(0,jxxgrid.left+jxxgrid.width*2/3+3*40,jxxgrid.top-55,jxxangleModeButtonSize,jxxangleModeButtonSize,false,false,true);
jxxangleModeButton.draw = function() {
	roundedRect(this.ctx,3,3,jxxangleModeButtonSize-6,jxxangleModeButtonSize-6,6,4,'#000','#FFF');
	if (jxxgrid.angleMode == 'rad') {
		text({ctx:this.ctx,align:'center',vertAlign:'middle',textArray:['<<fontSize:12>>RAD']});
	} else {
		text({ctx:this.ctx,align:'center',vertAlign:'middle',textArray:['<<fontSize:12>>DEG']});
	}
};
jxxangleModeButton.draw();
jxxangleModeButton.click = function() {
	if (jxxgrid.angleMode == 'deg') {
		jxxgrid.angleMode = 'rad'
		jxxgrid.xMin = [-2,1];
		jxxgrid.xMax = [2,1];
		jxxgrid.xMajorStep = [1,2]; 
		jxxgrid.xMinorStep = [1,6];
		jxxgrid.yMin = -3;
		jxxgrid.yMax = 3;
		jxxgrid.yMajorStep = 1;
		jxxgrid.yMinorStep = 0.5;	
		hideObj(jxxequalizeButton);
	} else {
		jxxgrid.angleMode = 'deg'
		jxxgrid.xMin = -360;
		jxxgrid.xMax = 360;
		jxxgrid.xMajorStep = 90; 
		jxxgrid.xMinorStep = 30;
		jxxgrid.yMin = -3;
		jxxgrid.yMax = 3;
		jxxgrid.yMajorStep = 1;
		jxxgrid.yMinorStep = 0.5;
		showObj(jxxequalizeButton);		
	}
	this.draw();
	jxxfuncInput.angleMode = jxxgrid.angleMode;
	jxxdrawGrid();
};
addListener(jxxangleModeButton,jxxangleModeButton.click);

var jxxequalizeButtonSize = 40;
var jxxequalizeButton = createButton(0,jxxgrid.left+jxxgrid.width*2/3+4*40,jxxgrid.top-55,jxxequalizeButtonSize,jxxequalizeButtonSize,false,false,true);
jxxequalizeButton.draw = function() {
	roundedRect(this.ctx,3,3,jxxequalizeButtonSize-6,jxxequalizeButtonSize-6,6,4,'#000','#FFF');	
	text({ctx:this.ctx,align:'center',vertAlign:'middle',textArray:['<<font:algebra>><<fontSize:18>>1:1']});

};
jxxequalizeButton.draw();
jxxequalizeButton.click = function() {
	if (jxxgrid.angleMode == 'rad') return;
	var xDiff = jxxgrid.xMax - jxxgrid.xMin;
	var yDiff = xDiff * (jxxgrid.height / jxxgrid.width);
	if (jxxgrid.yMin <= 0 && jxxgrid.yMax >= 0) {
		var negProportion = -jxxgrid.yMin / (jxxgrid.yMax - jxxgrid.yMin);
		var posProportion = jxxgrid.yMax / (jxxgrid.yMax - jxxgrid.yMin);
		jxxgrid.yMin = -(yDiff * negProportion);
		jxxgrid.yMax = yDiff * posProportion;
	} else {
		jxxgrid.yMax = jxxgrid.yMin + yDiff;
	}
	jxxresetAxes();
	jxxdrawGrid();
};
addListener(jxxequalizeButton,jxxequalizeButton.click);

var jxxcolorPickMenuOpen = false;
var jxxcolorPick = createButton(0,jxxbuttonLeft[3],jxxbuttonTop[1],50,50,true,false,true);
jxxcolorPick.selectedMode = 'colorPick';
jxxcolorPick.colors = ['#9c27b0','#00bcd4','#e91e63','#01579b','#f44336','#4caf50','#ffeb3b','#ff9800', '#004d40', '#000'];
jxxcolorPick.draw = function() {
	if (jxxcolorPickMenuOpen == true) {
		roundedRect(this.ctx,3,3,44,44,8,6,'#000',mainCanvasFillStyle);	
	} else {
		roundedRect(this.ctx,3,3,44,44,8,6,'#FFF','#FFF');	
	}
	for (var i = 0; i < 4; i++) {
		this.ctx.fillStyle = this.colors[i] || '#FFF';
		this.ctx.fillRect(10+15*(i%2),10+15*Math.floor(i/2),15,15);
	}
	this.ctx.strokeStyle = '#000';
	this.ctx.lineWidth = 1;
	this.ctx.strokeRect(10,10,30,30);	
	this.ctx.beginPath();
	this.ctx.moveTo(10,25);
	this.ctx.lineTo(40,25);
	this.ctx.moveTo(25,10);
	this.ctx.lineTo(25,40);
	this.ctx.stroke();
};
jxxcolorPick.draw();
jxxcolorPick.click = function() {
	jxxcolorPickMenuOpen = !jxxcolorPickMenuOpen;
	if (jxxcolorPickMenuOpen == true) {
		for (var b = 0; b < jxxcolorPick.buttons.length; b++) {
			showObj(jxxcolorPick.buttons[b]);
		}
		addListenerStart(window,jxxcloseColorPicker);
	} else {
		for (var b = 0; b < jxxcolorPick.buttons.length; b++) {
			hideObj(jxxcolorPick.buttons[b]);
		}
		removeListenerStart(window,jxxcloseColorPicker);
	}
	jxxcolorPick.draw();
};
addListener(jxxcolorPick,jxxcolorPick.click);
jxxcolorPick.buttons = [];

var l = jxxbuttonLeft[3] - 32.5;
var t = jxxbuttonTop[1] + 55;
var colorBackButton = createCanvas(l,t,120,330,false,false,false,999999999);
roundedRect(colorBackButton.getContext('2d'),3,3,114,264,2,6,'#000','#FFF');
jxxcolorPick.buttons.push(colorBackButton);
for (var i = 0; i < jxxcolorPick.colors.length; i++) {
	var left2 = l + 10 + 50 * (i % 2);
	var top2 = t + 10 + 50 * Math.floor(i / 2);	
	var colorButton = createCanvas(left2,top2,50,80,false,false,true,999999999);
	colorButton.color = jxxcolorPick.colors[i];
	colorButton.ctx.lineCap = 'round';
	colorButton.ctx.lineJoin = 'round';
	colorButton.ctx.lineWidth = 4;
	colorButton.ctx.strokeStyle = '#fff';		
	colorButton.ctx.fillStyle = jxxcolorPick.colors[i];
	colorButton.ctx.fillRect(0,0,50,50);
	colorButton.ctx.strokeRect(0,0,50,50);
	addListener(colorButton,function() {
		jxxgrid.color = this.color;
		jxxdrawButtons();
		setMathsInputColor(jxxfuncInput,jxxgrid.color);	
		draw[taskId].color = this.color;
		draw[taskId].cursors.update();
		redrawButtons();
		drawCanvasPaths();
		jxxcloseColorPicker();
	})
	jxxcolorPick.buttons.push(colorButton);
}

function jxxcloseColorPicker(e) {
	if (typeof e !== 'undefined' && (e.target == jxxcolorPick || jxxcolorPick.buttons.indexOf(e.target) > -1)) return;
	if (jxxcolorPickMenuOpen == false) return;
	jxxcolorPickMenuOpen = false;
	for (var b = 0; b < jxxcolorPick.buttons.length; b++) {
		hideObj(jxxcolorPick.buttons[b]);
	}	
	jxxcolorPick.draw();
	removeListener(window,jxxcloseColorPicker);
}

var jxxscaleButtonSize = 40
var jxxyScaleMenuOpen = false;
var jxxyScaleMenu = createButton(0,jxxgrid.left-55,jxxgrid.top-55,jxxscaleButtonSize,jxxscaleButtonSize,false,false,true);
jxxyScaleMenu.draw = function() {
	if (jxxyScaleMenuOpen == true) {
		roundedRect(this.ctx,3,3,jxxscaleButtonSize-6,jxxscaleButtonSize-6,6,4,'#000',mainCanvasFillStyle);	
	} else {
		roundedRect(this.ctx,3,3,jxxscaleButtonSize-6,jxxscaleButtonSize-6,6,4,'#000','#FFF');	
	}
	this.ctx.strokeStyle = '#000';
	this.ctx.lineWidth = 1;
	this.ctx.beginPath();
	this.ctx.moveTo(jxxscaleButtonSize/2,jxxscaleButtonSize*1/5);
	this.ctx.lineTo(jxxscaleButtonSize/2,jxxscaleButtonSize*4/5);
	this.ctx.moveTo(jxxscaleButtonSize*2/5,jxxscaleButtonSize*1/5);
	this.ctx.lineTo(jxxscaleButtonSize*3/5,jxxscaleButtonSize*1/5);
	this.ctx.moveTo(jxxscaleButtonSize*9/20,jxxscaleButtonSize*7/20);
	this.ctx.lineTo(jxxscaleButtonSize*11/20,jxxscaleButtonSize*7/20);	
	this.ctx.moveTo(jxxscaleButtonSize*2/5,jxxscaleButtonSize*1/2);
	this.ctx.lineTo(jxxscaleButtonSize*3/5,jxxscaleButtonSize*1/2);
	this.ctx.moveTo(jxxscaleButtonSize*9/20,jxxscaleButtonSize*13/20);
	this.ctx.lineTo(jxxscaleButtonSize*11/20,jxxscaleButtonSize*13/20);	
	this.ctx.moveTo(jxxscaleButtonSize*2/5,jxxscaleButtonSize*4/5);
	this.ctx.lineTo(jxxscaleButtonSize*3/5,jxxscaleButtonSize*4/5);	
	this.ctx.stroke();
};
jxxyScaleMenu.buttonRect = [jxxgrid.left-55,jxxgrid.top-55,jxxscaleButtonSize,jxxscaleButtonSize];
jxxyScaleMenu.draw();
jxxyScaleMenu.click = function() {
	jxxyScaleMenuOpen = !jxxyScaleMenuOpen;
	if (jxxyScaleMenuOpen == true) {
		jxxyScaleMenu.setInputs();
		showObj(this.backCanvas);
		showMathsInput(this.inputMin);
		showMathsInput(this.inputMax);
		showMathsInput(this.inputMinor);
		showMathsInput(this.inputMajor);
		addListenerStart(window,jxxyScaleMenuClose);
	} else {
		hideObj(this.backCanvas);
		hideMathsInput(this.inputMin);
		hideMathsInput(this.inputMax);
		hideMathsInput(this.inputMinor);
		hideMathsInput(this.inputMajor);
	}
	jxxyScaleMenu.draw();
};
addListener(jxxyScaleMenu,jxxyScaleMenu.click);
function jxxyScaleMenuClose(e) {
	if (typeof e !== 'undefined' && typeof e.target !== 'undefined') {
		if ([jxxyScaleMenu,jxxyScaleMenu.backCanvas,jxxyScaleMenu.inputMin.cursorCanvas,jxxyScaleMenu.inputMax.cursorCanvas,jxxyScaleMenu.inputMinor.cursorCanvas,jxxyScaleMenu.inputMajor.cursorCanvas].indexOf(e.target) > -1) {
			return;
		}
		if (e.target == keyboard[taskNum]) return;
		for (i = 0; i < key1[taskNum].length; i++) {
			if (e.target == key1[taskNum][i]) return;
		}		
	}
	jxxyScaleMenuOpen = false;
	jxxyScaleMenu.draw();
	hideObj(jxxyScaleMenu.backCanvas);
	hideMathsInput(jxxyScaleMenu.inputMin);
	hideMathsInput(jxxyScaleMenu.inputMax);
	hideMathsInput(jxxyScaleMenu.inputMinor);
	hideMathsInput(jxxyScaleMenu.inputMajor);	
	removeListenerStart(window,jxxyScaleMenuClose);
}

jxxyScaleMenu.backRect = [jxxgrid.left-55,jxxgrid.top-55+jxxscaleButtonSize+5,225,170];
jxxyScaleMenu.backCanvas = createButton(0,jxxyScaleMenu.backRect[0],jxxyScaleMenu.backRect[1],jxxyScaleMenu.backRect[2],jxxyScaleMenu.backRect[3],false,false,true);
jxxyScaleMenu.backCanvas.style.cursor = 'default';
jxxyScaleMenu.backCanvas.draw = function() {
	roundedRect(this.ctx,3,3,jxxyScaleMenu.backRect[2]-6,jxxyScaleMenu.backRect[3]-6,8,6,'#000','#493d55');
	text({ctx:this.ctx,left:12,width:200,top:10,height:45,align:'center',vertAlign:'middle',textArray:['<<font:algebra>><<fontSize:26>>'+lessThanEq+' y '+lessThanEq]});
	text({ctx:this.ctx,left:30,width:240,top:60,height:50,vertAlign:'middle',textArray:['<<font:Arial>><<fontSize:20>>Major step:']});
	text({ctx:this.ctx,left:30,width:240,top:110,height:50,vertAlign:'middle',textArray:['<<font:Arial>><<fontSize:20>>Minor step:']});
}
jxxyScaleMenu.backCanvas.draw();

jxxyScaleMenu.inputMin = createMathsInput2({left:jxxyScaleMenu.backRect[0]+10,top:jxxyScaleMenu.backRect[1]+10,width:55,height:40,visible:false,selectable:false});
jxxyScaleMenu.inputMin.onInputEnd = function() {
	var num = Number(this.stringJS);
	if (isNaN(num) || num >= jxxgrid.yMax) {
		setMathsInputText(this,[String(jxxgrid.yMin)]);
	} else {
		jxxgrid.yMin = num;
		jxxresetYScale();
		jxxdrawGrid();
	}
};
jxxyScaleMenu.inputMax = createMathsInput2({left:jxxyScaleMenu.backRect[0]+155,top:jxxyScaleMenu.backRect[1]+10,width:55,height:40,visible:false,selectable:false});
jxxyScaleMenu.inputMax.onInputEnd = function() {
	var num = Number(this.stringJS);
	if (isNaN(num) || num <= jxxgrid.yMin) {
		setMathsInputText(this,[String(jxxgrid.yMax)]);
	} else {
		jxxgrid.yMax = num;
		jxxresetYScale();
		jxxdrawGrid();
	}
};
jxxyScaleMenu.inputMinor = createMathsInput2({left:jxxyScaleMenu.backRect[0]+140,top:jxxyScaleMenu.backRect[1]+115,width:50,height:40,visible:false,selectable:false});
jxxyScaleMenu.inputMinor.onInputEnd = function() {
	var num = Number(this.stringJS);
	if (isNaN(num) || num > jxxgrid.yMajorStep) {
		setMathsInputText(this,[String(jxxgrid.yMinorStep)]);
	} else {
		jxxgrid.yMinorStep = num;
		jxxgrid.lockStepY = true;
		jxxdrawGrid();
	}
};
jxxyScaleMenu.inputMajor = createMathsInput2({left:jxxyScaleMenu.backRect[0]+140,top:jxxyScaleMenu.backRect[1]+65,width:50,height:40,visible:false,selectable:false});
jxxyScaleMenu.inputMajor.onInputEnd = function() {
	var num = Number(this.stringJS);
	if (isNaN(num) || num < jxxgrid.yMinorStep) {
		setMathsInputText(this,[String(jxxgrid.yMajorStep)]);
	} else {
		jxxgrid.yMajorStep = num;
		jxxgrid.lockStepY = true;
		jxxdrawGrid();
	}
};

jxxyScaleMenu.setInputs = function() {
	setMathsInputText(this.inputMin,[String(Number(roundSF(jxxgrid.yMin,2)))]);
	setMathsInputText(this.inputMax,[String(Number(roundSF(jxxgrid.yMax,2)))]);
	setMathsInputText(this.inputMinor,[String(Number(roundSF(jxxgrid.yMinorStep,2)))]);
	setMathsInputText(this.inputMajor,[String(Number(roundSF(jxxgrid.yMajorStep,2)))]);
}
jxxyScaleMenu.setInputs();

var jxxxScaleMenuOpen = false;
var jxxxScaleMenu = createButton(0,jxxgrid.left+jxxgrid.width+55-jxxscaleButtonSize,jxxgrid.top+jxxgrid.height+55-jxxscaleButtonSize,jxxscaleButtonSize,jxxscaleButtonSize,false,false,true);
jxxxScaleMenu.draw = function() {
	if (jxxxScaleMenuOpen == true) {
		roundedRect(this.ctx,3,3,jxxscaleButtonSize-6,jxxscaleButtonSize-6,6,4,'#000',mainCanvasFillStyle);	
	} else {
		roundedRect(this.ctx,3,3,jxxscaleButtonSize-6,jxxscaleButtonSize-6,6,4,'#000','#FFF');	
	}
	this.ctx.strokeStyle = '#000';
	this.ctx.lineWidth = 1;
	this.ctx.beginPath();
	this.ctx.moveTo(jxxscaleButtonSize*1/5,jxxscaleButtonSize/2);
	this.ctx.lineTo(jxxscaleButtonSize*4/5,jxxscaleButtonSize/2);
	this.ctx.moveTo(jxxscaleButtonSize*1/5,jxxscaleButtonSize*2/5);
	this.ctx.lineTo(jxxscaleButtonSize*1/5,jxxscaleButtonSize*3/5);
	this.ctx.moveTo(jxxscaleButtonSize*7/20,jxxscaleButtonSize*9/20);
	this.ctx.lineTo(jxxscaleButtonSize*7/20,jxxscaleButtonSize*11/20);	
	this.ctx.moveTo(jxxscaleButtonSize*1/2,jxxscaleButtonSize*2/5);
	this.ctx.lineTo(jxxscaleButtonSize*1/2,jxxscaleButtonSize*3/5);
	this.ctx.moveTo(jxxscaleButtonSize*13/20,jxxscaleButtonSize*9/20);
	this.ctx.lineTo(jxxscaleButtonSize*13/20,jxxscaleButtonSize*11/20);	
	this.ctx.moveTo(jxxscaleButtonSize*4/5,jxxscaleButtonSize*2/5);
	this.ctx.lineTo(jxxscaleButtonSize*4/5,jxxscaleButtonSize*3/5);	
	this.ctx.stroke();
};
jxxxScaleMenu.buttonRect = [jxxgrid.left+jxxgrid.width+55-jxxscaleButtonSize,jxxgrid.top+jxxgrid.height+55-jxxscaleButtonSize,jxxscaleButtonSize,jxxscaleButtonSize];
jxxxScaleMenu.draw();
jxxxScaleMenu.click = function() {
	jxxxScaleMenuOpen = !jxxxScaleMenuOpen;
	if (jxxxScaleMenuOpen == true) {
		jxxxScaleMenu.setInputs();
		if (jxxgrid.angleMode == 'deg') {
			showObj(this.backCanvas);
			showMathsInput(this.inputMin);
			showMathsInput(this.inputMax);
			showMathsInput(this.inputMinor);
			showMathsInput(this.inputMajor);
		} else {
			showObj(jxxxScaleMenuRad.backCanvas);
			showMathsInput(jxxxScaleMenuRad.inputMin);
			showMathsInput(jxxxScaleMenuRad.inputMax);
			showMathsInput(jxxxScaleMenuRad.inputMinor);
			showMathsInput(jxxxScaleMenuRad.inputMajor);
		}
		addListenerStart(window,jxxxScaleMenuClose);
	} else {
		hideObj(this.backCanvas);
		hideMathsInput(this.inputMin);
		hideMathsInput(this.inputMax);
		hideMathsInput(this.inputMinor);
		hideMathsInput(this.inputMajor);
		hideObj(jxxxScaleMenuRad.backCanvas);
		hideMathsInput(jxxxScaleMenuRad.inputMin);
		hideMathsInput(jxxxScaleMenuRad.inputMax);
		hideMathsInput(jxxxScaleMenuRad.inputMinor);
		hideMathsInput(jxxxScaleMenuRad.inputMajor);		
	}
	jxxxScaleMenu.draw();
};
addListener(jxxxScaleMenu,jxxxScaleMenu.click);
function jxxxScaleMenuClose(e) {
	if (typeof e !== 'undefined' && typeof e.target !== 'undefined') {
		if ([jxxxScaleMenu,jxxxScaleMenu.backCanvas,jxxxScaleMenu.inputMin.cursorCanvas,jxxxScaleMenu.inputMax.cursorCanvas,jxxxScaleMenu.inputMinor.cursorCanvas,jxxxScaleMenu.inputMajor.cursorCanvas].indexOf(e.target) > -1) {
			return;
		}
		if ([jxxxScaleMenuRad.backCanvas,jxxxScaleMenuRad.inputMin.cursorCanvas,jxxxScaleMenuRad.inputMax.cursorCanvas,jxxxScaleMenuRad.inputMinor.cursorCanvas,jxxxScaleMenuRad.inputMajor.cursorCanvas].indexOf(e.target) > -1) {
			return;
		}		
		if (e.target == keyboard[taskNum]) return;
		for (i = 0; i < key1[taskNum].length; i++) {
			if (e.target == key1[taskNum][i]) return;
		}		
	}
	jxxxScaleMenuOpen = false;
	jxxxScaleMenu.draw();
	hideObj(jxxxScaleMenu.backCanvas);
	hideMathsInput(jxxxScaleMenu.inputMin);
	hideMathsInput(jxxxScaleMenu.inputMax);
	hideMathsInput(jxxxScaleMenu.inputMinor);
	hideMathsInput(jxxxScaleMenu.inputMajor);	
	hideObj(jxxxScaleMenuRad.backCanvas);
	hideMathsInput(jxxxScaleMenuRad.inputMin);
	hideMathsInput(jxxxScaleMenuRad.inputMax);
	hideMathsInput(jxxxScaleMenuRad.inputMinor);
	hideMathsInput(jxxxScaleMenuRad.inputMajor);		
	removeListenerStart(window,jxxxScaleMenuClose);
}

jxxxScaleMenu.backRect = [jxxgrid.left+jxxgrid.width+55-225,jxxgrid.top+jxxgrid.height+55-jxxscaleButtonSize-175,225,170];
jxxxScaleMenu.backCanvas = createButton(0,jxxxScaleMenu.backRect[0],jxxxScaleMenu.backRect[1],jxxxScaleMenu.backRect[2],jxxxScaleMenu.backRect[3],false,false,true);
jxxxScaleMenu.backCanvas.style.cursor = 'default';
jxxxScaleMenu.backCanvas.draw = function() {
	roundedRect(this.ctx,3,3,jxxxScaleMenu.backRect[2]-6,jxxxScaleMenu.backRect[3]-6,8,6,'#000','#493d55');
	text({ctx:this.ctx,left:12,width:200,top:10,height:45,align:'center',vertAlign:'middle',textArray:['<<font:algebra>><<fontSize:26>>'+lessThanEq+' x '+lessThanEq]});
	text({ctx:this.ctx,left:30,width:240,top:60,height:50,vertAlign:'middle',textArray:['<<font:Arial>><<fontSize:20>>Major step:']});
	text({ctx:this.ctx,left:30,width:240,top:110,height:50,vertAlign:'middle',textArray:['<<font:Arial>><<fontSize:20>>Minor step:']});
}
jxxxScaleMenu.backCanvas.draw();

jxxxScaleMenu.inputMin = createMathsInput2({left:jxxxScaleMenu.backRect[0]+10,top:jxxxScaleMenu.backRect[1]+10,width:55,height:40,visible:false});
jxxxScaleMenu.inputMin.onInputEnd = function() {
	var num = Number(this.stringJS);
	if (isNaN(num) || num >= jxxgrid.xMax) {
		setMathsInputText(this,[String(jxxgrid.xMin)]);
	} else {
		jxxgrid.xMin = num;
		jxxresetXScale();
		jxxdrawGrid();
	}
};
jxxxScaleMenu.inputMax = createMathsInput2({left:jxxxScaleMenu.backRect[0]+155,top:jxxxScaleMenu.backRect[1]+10,width:55,height:40,visible:false});
jxxxScaleMenu.inputMax.onInputEnd = function() {
	var num = Number(this.stringJS);
	if (isNaN(num) || num <= jxxgrid.xMin) {
		setMathsInputText(this,[String(jxxgrid.xMax)]);
	} else {
		jxxgrid.xMax = num;
		jxxresetXScale();
		jxxdrawGrid();
	}
};
jxxxScaleMenu.inputMinor = createMathsInput2({left:jxxxScaleMenu.backRect[0]+140,top:jxxxScaleMenu.backRect[1]+115,width:50,height:40,visible:false});
jxxxScaleMenu.inputMinor.onInputEnd = function() {
	var num = Number(this.stringJS);
	if (isNaN(num) || num > jxxgrid.xMajorStep) {
		setMathsInputText(this,[String(jxxgrid.xMinorStep)]);
	} else {
		jxxgrid.xMinorStep = num;
		jxxgrid.lockStepX = true;
		jxxdrawGrid();
	}
};
jxxxScaleMenu.inputMajor = createMathsInput2({left:jxxxScaleMenu.backRect[0]+140,top:jxxxScaleMenu.backRect[1]+65,width:50,height:40,visible:false});
jxxxScaleMenu.inputMajor.onInputEnd = function() {
	var num = Number(this.stringJS);
	if (isNaN(num) || num < jxxgrid.xMinorStep) {
		setMathsInputText(this,[String(jxxgrid.xMajorStep)]);
	} else {
		jxxgrid.xMajorStep = num;
		jxxgrid.lockStepX = true;
		jxxdrawGrid();
	}
};
jxxxScaleMenu.setInputs = function() {
	if (jxxgrid.angleMode == 'deg') {
		setMathsInputText(this.inputMin,[String(Number(roundSF(jxxgrid.xMin,2)))]);
		setMathsInputText(this.inputMax,[String(Number(roundSF(jxxgrid.xMax,2)))]);
		setMathsInputText(this.inputMinor,[String(Number(roundSF(jxxgrid.xMinorStep,2)))]);
		setMathsInputText(this.inputMajor,[String(Number(roundSF(jxxgrid.xMajorStep,2)))]);
	} else {
		var xMinText = jxxtoMathsText(jxxgrid.xMin[0],jxxgrid.xMin[1]);
		setMathsInputText(jxxxScaleMenuRad.inputMin,xMinText);
		var xMaxText = jxxtoMathsText(jxxgrid.xMax[0],jxxgrid.xMax[1]);
		setMathsInputText(jxxxScaleMenuRad.inputMax,xMaxText);
		var xMinorText = jxxtoMathsText(jxxgrid.xMinorStep[0],jxxgrid.xMinorStep[1]);
		setMathsInputText(jxxxScaleMenuRad.inputMinor,xMinorText);
		var xMajorText = jxxtoMathsText(jxxgrid.xMajorStep[0],jxxgrid.xMajorStep[1]);
		setMathsInputText(jxxxScaleMenuRad.inputMajor,xMajorText);		
	}
}
jxxxScaleMenu.setInputs();

function jxxtoMathsText(num, num2) {
	if (typeof num2 == 'undefined') {
		return [String(num)];	
	} else {
		if (num == 0) return '0';
		var pos = true;
		if (num/num2 < 0) pos = false;
		num = Math.abs(num)
		num2 = Math.abs(num2);
		var divisor = hcf(num, num2);
		num = num / divisor;
		num2 = num2 / divisor;
		if (num2 == 1) {
			if (pos == true) {
				return [String(num)];
			} else {
				return ["-"+String(num)];
			}
		} else {
			if (pos == true) {
				return [['frac', [String(num)], [String(num2)]]];
			} else {
				return ['-',['frac', [String(num)], [String(num2)]]];				
			}
		}
	}
}

var jxxxScaleMenuRad = {};
jxxxScaleMenuRad.backRect = [jxxgrid.left+jxxgrid.width+55-265,jxxgrid.top+jxxgrid.height+55-jxxscaleButtonSize-175,260,170];
jxxxScaleMenuRad.backCanvas = createButton(0,jxxxScaleMenuRad.backRect[0],jxxxScaleMenuRad.backRect[1],jxxxScaleMenuRad.backRect[2],jxxxScaleMenuRad.backRect[3],false,false,true);
jxxxScaleMenuRad.backCanvas.style.cursor = 'default';
jxxxScaleMenuRad.backCanvas.draw = function() {
	roundedRect(this.ctx,3,3,jxxxScaleMenuRad.backRect[2]-6,jxxxScaleMenuRad.backRect[3]-6,8,6,'#000','#493d55');
	text({ctx:this.ctx,left:75,width:200,top:10,height:45,align:'left',vertAlign:'middle',textArray:['<<font:algebra>><<fontSize:26>>'+pi+' '+lessThanEq+' x '+lessThanEq+'          '+pi]});
	text({ctx:this.ctx,left:30,width:240,top:60,height:50,vertAlign:'middle',textArray:['<<font:Arial>><<fontSize:20>>Major step:            <<font:algebra>><<fontSize:26>>'+pi]});
	text({ctx:this.ctx,left:30,width:240,top:110,height:50,vertAlign:'middle',textArray:['<<font:Arial>><<fontSize:20>>Minor step:            <<font:algebra>><<fontSize:26>>'+pi]});
}
jxxxScaleMenuRad.backCanvas.draw();

jxxxScaleMenuRad.inputMin = createMathsInput2({left:jxxxScaleMenuRad.backRect[0]+10,top:jxxxScaleMenuRad.backRect[1]+10,width:55,height:40,visible:false});
jxxxScaleMenuRad.inputMin.onInputEnd = function() {
	var num = eval(this.stringJS);
	if (isNaN(num) || num >= jxxgrid.xMax) {
		var xMinText = jxxtoMathsText(jxxgrid.xMin[0],jxxgrid.xMin[1]);
		setMathsInputText(jxxxScaleMenuRad.inputMin,xMinText);
	} else {
		jxxgrid.xMin = roundToFraction(num,[1,3600]);
		jxxresetXScale();
		jxxdrawGrid();
	}
};
jxxxScaleMenuRad.inputMax = createMathsInput2({left:jxxxScaleMenuRad.backRect[0]+170,top:jxxxScaleMenuRad.backRect[1]+10,width:55,height:40,visible:false});
jxxxScaleMenuRad.inputMax.onInputEnd = function() {
	var num = eval(this.stringJS);
	if (isNaN(num) || num <= jxxgrid.xMin) {
		var xMaxText = jxxtoMathsText(jxxgrid.xMax[0],jxxgrid.xMax[1]);
		setMathsInputText(jxxxScaleMenuRad.inputMax,xMaxText);	} else {
		jxxgrid.xMax = roundToFraction(num,[1,3600]);
		jxxresetXScale();
		jxxdrawGrid();
	}
};
jxxxScaleMenuRad.inputMinor = createMathsInput2({left:jxxxScaleMenuRad.backRect[0]+135,top:jxxxScaleMenuRad.backRect[1]+115,width:50,height:40,visible:false});
jxxxScaleMenuRad.inputMinor.onInputEnd = function() {
	try {
		var num = eval(this.stringJS);
		if (isNaN(num) || num > jxxgrid.xMajorStep) {
			var xMinorText = jxxtoMathsText(jxxgrid.xMinorStep[0],jxxgrid.xMinorStep[1]);
			setMathsInputText(jxxxScaleMenuRad.inputMinor,xMinorText);
		} else {
			jxxgrid.xMinorStep = roundToFraction(num,[1,3600]);
			jxxgrid.lockStepX = true;
			jxxdrawGrid();
		}
	}
	catch(err) {
		var xMinorText = jxxtoMathsText(jxxgrid.xMinorStep[0],jxxgrid.xMinorStep[1]);
		setMathsInputText(jxxxScaleMenuRad.inputMinor,xMinorText);		
	}
};
jxxxScaleMenuRad.inputMajor = createMathsInput2({left:jxxxScaleMenuRad.backRect[0]+135,top:jxxxScaleMenuRad.backRect[1]+65,width:50,height:40,visible:false});
jxxxScaleMenuRad.inputMajor.onInputEnd = function() {
	try {
		var num = eval(this.stringJS);
		if (isNaN(num) || num < jxxgrid.xMinorStep) {
			var xMajorText = jxxtoMathsText(jxxgrid.xMajorStep[0],jxxgrid.xMajorStep[1]);
			setMathsInputText(jxxxScaleMenuRad.inputMajor,xMajorText);	
		} else {
			jxxgrid.xMajorStep = roundToFraction(num,[1,3600]);
			jxxgrid.lockStepX = true;
			jxxdrawGrid();
		}
	}
	catch(err) {
		var xMajorText = jxxtoMathsText(jxxgrid.xMajorStep[0],jxxgrid.xMajorStep[1]);
		setMathsInputText(jxxxScaleMenuRad.inputMajor,xMajorText);		
	}
};

setMathsInputText(jxxxScaleMenuRad.inputMin,[""]);
setMathsInputText(jxxxScaleMenuRad.inputMax,[""]);
setMathsInputText(jxxxScaleMenuRad.inputMinor,[""]);
setMathsInputText(jxxxScaleMenuRad.inputMajor,[""]);


var jxxclear = createButton(0,jxxgrid.left+jxxgrid.width+50+4*55,jxxbuttonTop[1],50,50,true,false,true);
jxxclear.draw = function() {
	roundedRect(this.ctx,3,3,44,44,8,6,'#FFF','#FFF');	
	text({context:this.ctx,left:0,width:50,top:12,textArray:['<<font:Arial>><<fontSize:17>><<align:center>>CLR']});			
};
jxxclear.draw();
jxxclear.click = function() {
	if (jxxgrid.path.length == 0) return;
	for (var p = jxxgrid.path.length-1; p >=0; p--) {
		if (jxxgrid.path[p].type == 'point' || jxxgrid.path[p].type == 'line' ||jxxgrid.path[p].type == 'lineSegment') {
			jxxgrid.path.splice(p,1);
		}		
	}
	jxxdrawGrid();
	jxxfunctionListCanvas.draw();
};
addListener(jxxclear,jxxclear.click);

var jxxclearFuncs = createButton(0,1170-100,155+460-25,100,20,false,false,true,999999);
jxxclearFuncs.draw = function() {
	text({context:this.ctx,left:0,width:100,top:0,textArray:['<<font:Arial>><<fontSize:17>><<align:center>><<color:#F00>>Clear All']});			
};
jxxclearFuncs.draw();
jxxclearFuncs.click = function() {
	if (jxxgrid.path.length == 0) return;
	for (var p = jxxgrid.path.length-1; p >=0; p--) {
		if (jxxgrid.path[p].type == 'function' || jxxgrid.path[p].type == 'function2') {
			jxxgrid.path.splice(p,1);
		}		
	}
	jxxdrawGrid();
	jxxfunctionListCanvas.draw();
};
addListener(jxxclearFuncs,jxxclearFuncs.click);

/*var jxxundo = createButton(0,jxxgrid.left+jxxgrid.width+50+3*55,625,50,50,true,false,true);
jxxundo.draw = function() {
	roundedRect(this.ctx,3,3,44,44,8,6,'#000','#C9F');	
	var s = 50;
	this.ctx.strokeStyle = '#000';
	this.ctx.lineCap = 'round';
	this.ctx.lineJoin = 'round';	
	this.ctx.lineWidth = 4;
	this.ctx.beginPath();
	this.ctx.arc(s/2,s/2,12*s/55,-Math.PI,0.7*Math.PI);
	this.ctx.moveTo(13.5*s/55,27.5*s/55);
	this.ctx.lineTo(13.5*s/55-10*s/55*Math.sin(1*Math.PI),27.5*s/55+10*s/55*Math.cos(1*Math.PI));
	this.ctx.lineTo(13.5*s/55-10*s/55*Math.cos(0.95*Math.PI),27.5*s/55-10*s/55*Math.sin(0.95*Math.PI));
	this.ctx.lineTo(13.5*s/55,27.5*s/55);		
	this.ctx.stroke();	
};
jxxundo.draw();
jxxundo.click = function() {
	if (jxxgrid.path.length == 0) return;
	jxxgrid.path.pop();
	jxxdrawGrid();
	jxxfunctionListCanvas.draw();
};
addListener(jxxundo,jxxundo.click);*/

function jxxaddFunction(input) {
	var funcDeg = jxxcreateJSString(input.text,'deg');
	var funcRad = jxxcreateJSString(input.text,'rad');
	var stringCopy = funcDeg;
	var exceptions = ['Math.pow','Math.sqrt','Math.PI','Math.sin','Math.cos','Math.tan','Math.asin','Math.acos','Math.atan','Math.e','Math.log','Math.abs'];
	for (var i = 0; i < exceptions.length; i++) {
		stringCopy = replaceAll(stringCopy,exceptions[i],'');
	}
	if (/[a-wzA-WZ]/g.test(stringCopy) == true || (stringCopy.match(/=/g) || []).length !== 1 || stringCopy.charAt(0) == "=" || stringCopy.charAt(stringCopy.length-1) == "=") {
		jxxalertInvalid();
		return;
	}
	if (funcDeg.indexOf("y=") == 0) {
		try {
			eval('var funcDeg2 = function(x) {return '+funcDeg.slice(2)+'};');
			eval('var funcRad2 = function(x) {return '+funcRad.slice(2)+'};');
		}
		catch(err) {
			jxxalertInvalid();
			return;	
		}
		jxxgrid.path.push({type:'function',funcDeg:funcDeg2,funcRad:funcRad2,color:jxxgrid.color,text:clone(input.richText),time:Date.parse(new Date())});		
	} else {
		var splitFuncDeg = funcDeg.split("=");
		var splitFuncRad = funcRad.split("=");
		if (splitFuncDeg.length !== 2 || splitFuncRad.length !== 2) return;		
		try {
			eval('var funcDeg2 = function(x,y) {return ('+splitFuncDeg[0]+')-('+splitFuncDeg[1]+')};');
			eval('var funcRad2 = function(x,y) {return ('+splitFuncRad[0]+')-('+splitFuncRad[1]+')};');
		}
		catch(err) {
			jxxalertInvalid();
			return;	
		}	
		jxxgrid.path.push({type:'function2',funcDeg:funcDeg2,funcRad:funcRad2,color:jxxgrid.color,text:clone(input.richText),time:Date.parse(new Date())});		
	}
	jxxdrawGrid();
	jxxfunctionListCanvas.draw();
}

function jxxcreateJSString(textArray, angleMode) {

	var depth = 0;
	var jsArray = [''];
	var js = '';
	var algArray = [''];
	var alg = '';
	var exceptions = ['Math.pow','Math.sqrt','Math.PI','Math.sin','Math.cos','Math.tan','Math.asin','Math.acos','Math.atan','Math.e','Math.log','Math.abs','sin','cos','tan'];
	var position = [0];
		
	for (var p = 0; p < textArray.length; p++) {
		//console.log('Before ' + p + ' base element(s):', jsArray);
		subJS(textArray[p],true);
		position[depth]++;
		//console.log('After ' + p + ' base elements:', jsArray);
	}
	
	js = jsArray[0];
	alg = algArray[0];
	//console.log(js);
	
	function removeAllTagsFromString(str) {
		for (var char = str.length-1; char > -1; char--) {
			if (str.slice(char).indexOf('>>') == 0 && str.slice(char-1).indexOf('>>>') !== 0) {
				for (var char2 = char-2; char2 > -1; char2--) {
					if (str.slice(char2).indexOf('<<') == 0) {
						str = str.slice(0,char2) + str.slice(char+2);
						char = char2;
						break;	
					}
				}
			}
		}		
		return str;
	}
	
	function subJS(elem, addMultIfNecc) {
		if (typeof addMultIfNecc !== 'boolean') addMultIfNecc = true;
		//console.log('subJS', elem);
		if (typeof elem == 'string') {
			//console.log('string');
			var subText = replaceAll(elem, ' ', ''); // remove white space
			subText = removeAllTagsFromString(subText);

			subText = subText.replace(/\u00D7/g, '*'); // replace multiplications signs with *
			subText = subText.replace(/\u00F7/g, '/'); // replace division signs with /
			subText = subText.replace(/\u2264/g, '<='); // replace  signs with <=
			subText = subText.replace(/\u2265/g, '>='); // replace  signs with >=
			for (var c = 0; c < subText.length - 2; c++) {
				if (subText.slice(c).indexOf('sin') == 0 || subText.slice(c).indexOf('cos') == 0 || subText.slice(c).indexOf('tan') == 0) {
					if (subText.slice(c).indexOf('(') == 3) {
						if (angleMode == 'rad') {
							subText = subText.slice(0,c)+'Math.'+subText.slice(c);
							c += 5;
						} else {
							subText = subText.slice(0,c)+'Math.'+subText.slice(c,c+4)+'(Math.PI/180)*'+subText.slice(c+4);
							c += 19;
						}
					}
				}
			}
			subText = timesBeforeLetters(subText);
			// if following frac or power, add * if necessary
			if (addMultIfNecc == true && jsArray[depth] !== '' && elem !== '' && /[ \+\-\=\u00D7\u00F7\u2264\u2265\<\>\])]/.test(elem.charAt(0)) == false) subText = '*' + subText;
			jsArray[depth] += subText;
			algArray[depth] += subText;
			return;
		} else if (elem[0] == 'frac') {
			//console.log('frac');
			var subText = '';
			var subText2 = '';
			// if not proceeded by an operator, put a times sign in
			if (jsArray[depth] !== '' && /[\+\-\u00D7\u00F7\*\/\=\[(]/.test(jsArray[depth].slice(-1)) == false) subText += "*";
			depth++;
			position.push(0);
			jsArray[depth] = '';
			subJS(elem[1], false);
			jsArray[depth] = replaceAll(jsArray[depth], ' ', ''); // remove white space 
			subText += '((' + jsArray[depth] + ')/';
			subText2 += 'frac(' + jsArray[depth] + ',';
			jsArray[depth] = '';
			subJS(elem[2], false);
			jsArray[depth] = replaceAll(jsArray[depth], ' ', ''); // remove white space
			subText += '(' + jsArray[depth] + '))';
			subText2 += jsArray[depth] + ')';
			jsArray[depth] = '';
			depth--;
			position.pop();
			jsArray[depth] += subText;
			algArray[depth] += subText2;
			return;
		} else if (elem[0] == 'sqrt') {
			//console.log('sqrt');
			var subText = '';
			var subText2 = '';
			// if not proceeded by an operator, put a times sign in
			if (jsArray[depth] !== '' && /[\+\-\u00D7\u00F7\*\/\=\[(]/.test(jsArray[depth].slice(-1)) == false) subText += "*";
			depth++;
			position.push(0);
			jsArray[depth] = '';
			subJS(elem[1], false);
			jsArray[depth] = replaceAll(jsArray[depth], ' ', ''); // remove white space
			subText += 'Math.sqrt('+ jsArray[depth] +')';
			subText2 += 'sqrt('+jsArray[depth]+')';
			jsArray[depth] = '';
			depth--;
			position.pop();
			jsArray[depth] += subText;
			algArray[depth] += subText2;			
			return;
		} else if (elem[0] == 'root') {
			//console.log(elem[0]);
			var subText = '';
			var subText2 = '';
			// if not proceeded by an operator, put a times sign in
			if (jsArray[depth] !== '' && /[\+\-\u00D7\u00F7\*\/\=\[(]/.test(jsArray[depth].slice(-1)) == false) subText += "*";
			depth++;
			position.push(0);
			jsArray[depth] = '';
			subJS(elem[2], false);
			jsArray[depth] = replaceAll(jsArray[depth], ' ', ''); // remove white space
			subText += '(Math.pow('+jsArray[depth]+',';
			subText2 += 'root('+jsArray[depth]+',';
			jsArray[depth] = '';
			subJS(elem[1], false);
			jsArray[depth] = replaceAll(jsArray[depth], ' ', ''); // remove white space
			subText += '(1/('+jsArray[depth]+'))))';
			subText2 += jsArray[depth]+')';
			jsArray[depth] = '';
			depth--;
			position.pop();
			jsArray[depth] += subText;
			algArray[depth] += subText2;
			return;
		} else if (elem[0] == 'sin' || elem[0] == 'cos' || elem[0] == 'tan') {
			//console.log(elem[0]);
			var subText = '';
			// if not proceeded by an operator, put a times sign in
			if (jsArray[depth] !== '' && /[\+\-\u00D7\u00F7\*\/\=\[(]/.test(jsArray[depth].slice(-1)) == false) subText += "*";
			depth++;
			position.push(0);
			jsArray[depth] = '';
			subJS(elem[1], false);
			jsArray[depth] = replaceAll(jsArray[depth], ' ', ''); // remove white space
			var convertText1 = '';
			var convertText2 = '';
			if (angleMode == 'deg' || angleMode == 'degrees') {
				convertText1 = '(';
				convertText2 = ')*Math.PI/180';
			}
			subText += 'Math.'+ elem[0] +'('+convertText1+jsArray[depth]+convertText2+')';
			jsArray[depth] = '';
			depth--;
			position.pop();
			jsArray[depth] += subText;
			algArray[depth] += subText;
			return;
		} else if (elem[0] == 'sin-1' || elem[0] == 'cos-1' || elem[0] == 'tan-1') {
			//console.log(elem[0]);
			var subText = '';
			// if not proceeded by an operator, put a times sign in
			if (jsArray[depth] !== '' && /[\+\-\u00D7\u00F7\*\/\=\[(]/.test(jsArray[depth].slice(-1)) == false) subText += "*";
			depth++;
			position.push(0);
			jsArray[depth] = '';
			subJS(elem[1], false);
			jsArray[depth] = replaceAll(jsArray[depth], ' ', ''); // remove white space
			var convertText1 = '';
			var convertText2 = '';
			if (angleMode == 'deg' || angleMode == 'degrees') {
				convertText1 = '((';
				convertText2 = ')*180/Math.PI)';
			}
			subText += convertText1+'Math.a'+elem[0].slice(0,3)+'('+jsArray[depth]+')'+convertText2;;
			jsArray[depth] = '';
			depth--;
			position.pop();
			jsArray[depth] += subText;
			algArray[depth] += subText;			
			return;
		} else if (elem[0] == 'ln') {
			//console.log(elem[0]);
			var subText = '';
			// if not proceeded by an operator, put a times sign in
			if (jsArray[depth] !== '' && /[\+\-\u00D7\u00F7\*\/\=\[(]/.test(jsArray[depth].slice(-1)) == false) subText += "*";
			depth++;
			position.push(0);
			jsArray[depth] = '';
			subJS(elem[1], false);
			jsArray[depth] = replaceAll(jsArray[depth], ' ', ''); // remove white space
			subText += 'Math.log('+jsArray[depth]+')';
			jsArray[depth] = '';
			position.pop();
			depth--;
			jsArray[depth] += subText;
			algArray[depth] += subText;
			return;
		} else if (elem[0] == 'log') {
			//console.log(elem[0]);
			var subText = '';
			// if not proceeded by an operator, put a times sign in
			if (jsArray[depth] !== '' && /[\+\-\u00D7\u00F7\*\/\=\[(]/.test(jsArray[depth].slice(-1)) == false) subText += "*";
			depth++;
			position.push(0);
			jsArray[depth] = '';
			subJS(elem[1], false);
			jsArray[depth] = replaceAll(jsArray[depth], ' ', ''); // remove white space
			subText += '((Math.log('+jsArray[depth]+'))/(Math.log(10)))';
			jsArray[depth] = '';
			depth--;
			position.pop();
			jsArray[depth] += subText;
			algArray[depth] += subText;
			return;
		} else if (elem[0] == 'logBase') {
			//console.log(elem[0]);
			var subText = '';
			// if not proceeded by an operator, put a times sign in
			if (jsArray[depth] !== '' && /[\+\-\u00D7\u00F7\*\/\=\[(]/.test(jsArray[depth].slice(-1)) == false) subText += "*";
			depth++;
			position.push(0);		
			jsArray[depth] = '';
			subJS(elem[2], false);
			jsArray[depth] = replaceAll(jsArray[depth], ' ', ''); // remove white space
			subText += '((Math.log('+jsArray[depth]+'))/';
			jsArray[depth] = '';
			subJS(elem[1], false);
			jsArray[depth] = replaceAll(jsArray[depth], ' ', ''); // remove white space
			subText += '(Math.log('+jsArray[depth]+')))';
			jsArray[depth] = '';
			depth--;
			position.pop();
			jsArray[depth] += subText;
			algArray[depth] += subText;
			return;
		} else if (elem[0] == 'abs') {
			//console.log(elem[0]);
			var subText = '';
			// if not proceeded by an operator, put a times sign in
			if (jsArray[depth] !== '' && /[\+\-\u00D7\u00F7\*\/\=\[(]/.test(jsArray[depth].slice(-1)) == false) subText += "*";
			depth++;
			position.push(0);			
			jsArray[depth] = '';
			subJS(elem[1], false);
			jsArray[depth] = replaceAll(jsArray[depth], ' ', ''); // remove white space
			subText += 'Math.abs('+jsArray[depth]+')';
			jsArray[depth] = '';
			depth--;
			position.pop();
			jsArray[depth] += subText;
			algArray[depth] += subText;
			return;
		} else if (elem[0] == 'power' || elem[0] == 'pow') {
			//console.log('power');
		
			var baseSplitPoint = 0;
			var trigPower = false;
			//if the power is after a close bracket
			if (jsArray[depth] !== '') {
				if (jsArray[depth].charAt(jsArray[depth].length - 1) == ')') {
					var bracketCount = 1
					for (jsChar = jsArray[depth].length - 2; jsChar >= 0; jsChar--) {
						if (jsArray[depth].charAt(jsChar) == ')') {bracketCount++}
						if (jsArray[depth].charAt(jsChar) == '(') {bracketCount--}
						if (bracketCount == 0 && !baseSplitPoint) {
							baseSplitPoint = jsChar;
							break;
						}
					}
				//if the power is after sin, cos or tan
				
				} else if (jsArray[depth].slice(jsArray[depth].length-3) == 'sin' || jsArray[depth].slice(jsArray[depth].length-3) == 'coa' || jsArray[depth].slice(jsArray[depth].length-3) == 'tan') {
					trigPower = true;
				//if the power is after a letter
				} else if (/[A-Za-z]/g.test(jsArray[depth].charAt(jsArray[depth].length - 1)) == true) {
					baseSplitPoint = jsArray[depth].length - 1;
				//if the power is after a numerical digit
				} else if (/[0-9]/g.test(jsArray[depth].charAt(jsArray[depth].length - 1)) == true) {
					var decPoint = false;
					for (jsChar = jsArray[depth].length - 2; jsChar >= 0; jsChar--) {
						if (decPoint == false && jsArray[depth].charAt(jsChar) == '.') {
							decPoint = true;
						} else if (decPoint == true && jsArray[depth].charAt(jsChar) == '.') {
							baseSplitPoint = jsChar + 1;
							break;						
						} else if (/[0-9]/g.test(jsArray[depth].charAt(jsChar)) == false) {
							baseSplitPoint = jsChar + 1;
							break;
						}
					}
				} else {
					return ''; // error
				}
			}
			
			/*if (trigPower == true) {
				var power = elem[2];
				if (typeof power == 'string') {
					power = removeAllTagsFromString(power);
					console.log(power);
					if (power == '-1') {
						jsArray[depth] = jsArray[depth].slice(0,-3) + 'Math.a' + jsArray[depth].slice(-3);
					} else if (power == '2') {
						
					}
				}
				
			}*/

			var base = jsArray[depth].slice(baseSplitPoint);
			jsArray[depth] = jsArray[depth].slice(0, baseSplitPoint);
			depth++;
			position.push(0);			
			jsArray[depth] = '';
			subJS(elem[2], false)
			jsArray[depth] = replaceAll(jsArray[depth], ' ', '');
			if (trigPower == true) {
				console.log(jsArray,jsArray[depth-1],jsArray[depth]);
				if (jsArray[depth] == '-1') {
					jsArray[depth-1] = jsArray[depth-1].slice(0,-3) + 'Math.a' + jsArray[depth-1].slice(-3);
				}
			} else {
				var subText = 'Math.pow(' + base + ',' + jsArray[depth] + ')';
				var subText2 = base + '^' + jsArray[depth];
			}
			jsArray[depth] = '';
			depth--;
			position.pop();
			jsArray[depth] += subText;
			algArray[depth] += subText2;
			return;
		} else if (typeof elem == 'object') {
			//console.log('array');
			depth++;
			position.push(0);			
			jsArray[depth] = '';
			for (var sub = 0; sub < elem.length; sub++) {
				//console.log('depth:', depth);
				//console.log('Before ' + sub + ' sub element(s):', jsArray);
				subJS(elem[sub], addMultIfNecc);
				//console.log('After ' + sub + ' sub element(s):', jsArray);				
			}
			jsArray[depth-1] += jsArray[depth];
			algArray[depth-1] += algArray[depth];
			jsArray[depth] = '';
			depth--;
			position.pop();
			//console.log('endOfArray', jsArray);
			return;
		}
	}
	
	function timesBeforeLetters(testText) {
		// find instances of letters - if proceeded by a number, add *
		for (q = 0; q < testText.length; q++) {
			if (q > 0) {
				if (/[a-zA-Z]/g.test(testText.charAt(q)) == true && /[a-zA-Z0-9)]/.test(testText.charAt(q - 1)) == true) {
					testText = testText.slice(0, q) + '*' + testText.slice(q);
				}
				// if an open bracket is proceeded by a letter, number or ), add *
				if (/[\[(]/g.test(testText.charAt(q)) == true && testText.length > q && /[A-Za-z0-9)]/g.test(testText.charAt(q - 1)) == true) {
					testText = testText.slice(0, q) + '*' + testText.slice(q);
				}
			}
			for (var i = 0; i < exceptions.length; i++) {
				if (testText.slice(q).indexOf(exceptions[i]) == 0) {
					q += exceptions[i].length;
				}
			}
		}
		return testText;
	}

	return js;	
}

function jxxalertInvalid() {
	//alert('Invalid function.');
}

//jxxplotFunc3(jxxgrid,"Math.pow(x,2)+Math.pow(y,2)=25",25);

function jxxplotFunc3(ctx,gridDetails,func,density,color) {
	if (typeof density == 'undefined') density = 10; // density is the width of each square
	if (typeof color == 'undefined') color = '#00F';
	ctx.strokeStyle = color;
	ctx.beginPath();
	var xInc = (gridDetails.xMax - gridDetails.xMin) / (gridDetails.width / density);
	var yInc = (gridDetails.yMax - gridDetails.yMin) / (gridDetails.height / density);
	var yPos = gridDetails.top + gridDetails.height;
	for (var y = gridDetails.yMin; y < gridDetails.yMax; y += yInc) {
		var xPos = gridDetails.left;
		for (var x = gridDetails.xMin; x < gridDetails.xMax; x += xInc) {
			var x2 = Math.min(x+xInc,gridDetails.xMax);
			var y2 = Math.min(y+yInc,gridDetails.yMax);
			var NW = func(x,y);
			var NE = func(x2,y);
			var SW = func(x,y2);
			var SE = func(x2,y2);
			var lines = getLines(SW,SE,NW,NE);
			while (lines.length > 1) {
				var pos = [];
				for (var i = 0; i < 2; i++) {
					var xPos2 = Math.min(xPos+density,gridDetails.left+gridDetails.width);
					var yPos2 = Math.max(yPos-density,gridDetails.top);
					var px = [xPos,xPos,xPos,xPos2][lines[i]];
					var py = [yPos,yPos,yPos2,yPos][lines[i]];
					var pf = [NW,NW,SW,NE][lines[i]];			
					var qx = [xPos2,xPos,xPos2,xPos2][lines[i]];
					var qy = [yPos,yPos2,yPos2,yPos2][lines[i]];
					var qf = [NE,SW,SE,SE][lines[i]];
					pos[i] = [px,py];
					if (px !== qx) pos[i][0] = px + density * ((1 - pf) / (qf - pf));
					if (py !== qy) pos[i][1] = py - density * ((1 - pf) / (qf - pf));
				}
				ctx.moveTo(pos[0][0],pos[0][1]);
				ctx.lineTo(pos[1][0],pos[1][1]);
				lines.shift();
				lines.shift();
			}
			xPos += density;
		}
		yPos -= density;
	}
	ctx.stroke();
	
	function getLines(SW,SE,NW,NE) { // returns 0=S,1=W,2=N,3=E
		if (SW < 1) {
			if (SE < 1) {
				if (NE < 1) {
					if (NW < 1) { //return [];
						// ..
						// ..
						return [];
					} else { //return [];
						// ..
						// x.
						return [0,1];
					}
				} else {
					if (NW < 1) { //return [];
						// ..
						// .x
						return [0,3];
					} else { //return [];				
						// ..
						// xx
						return [1,3];
					}
				}					
			} else {			
				if (NE < 1) {
					if (NW < 1) { //return [];	
						// .x
						// ..
						return [2,3];							
					} else { //return [];
						// .x
						// x.
						return [0,1,2,3];							
					}									
				} else {			
					if (NW < 1) { //return [];
						// .x
						// .x
						return [0,2];					
					} else { //return [];
						// .x
						// xx
						return [1,2];							
					}									
				}					
			}				
		} else {
			if (SE < 1) {
				if (NE < 1) {
					if (NW < 1) { //return [];
						// x.
						// ..
						return [1,2];							
					} else { //return [];
						// x.
						// x.
						return [0,2];							
					}
				} else {
					if (NW < 1) { //return [];
						// x.
						// .x
						return [1,2,0,3];
					} else { //return [];
						// x.
						// xx
						return [2,3];							
					}			
				}
			} else {
				if (NE < 1) {
					if (NW < 1) { //return [];
						// ..
						// xx
						return [1,3];							
					} else { //return [];
						// xx
						// x.
						return [0,3];
					}									
				} else {
					if (NW < 1) { //return [];
						// xx
						// .x
						return [0,1];					
					} else { //return [];
						// xx
						// xx
						return [];						
					}									
				}					
			}				
		}		
	}
}

function jxxplotFunc4(ctx,gridDetails,func,density,color) {
	function getLines(SW,SE,NW,NE) { // returns 0=S,1=W,2=N,3=E
		if (SW < 0) {
			if (SE < 0) {
				if (NE < 0) {
					if (NW < 0) { //return [];
						// ..
						// ..
						return [];
					} else { //return [];
						// ..
						// x.
						return [0,1];
					}
				} else {
					if (NW < 0) { //return [];
						// ..
						// .x
						return [0,3];
					} else { //return [];				
						// ..
						// xx
						return [1,3];
					}
				}					
			} else {			
				if (NE < 0) {
					if (NW < 0) { //return [];	
						// .x
						// ..
						return [2,3];							
					} else { //return [];
						// .x
						// x.
						return [0,1,2,3];							
					}									
				} else {			
					if (NW < 0) { //return [];
						// .x
						// .x
						return [0,2];					
					} else { //return [];
						// .x
						// xx
						return [1,2];							
					}									
				}					
			}				
		} else {
			if (SE < 0) {
				if (NE < 0) {
					if (NW < 0) { //return [];
						// x.
						// ..
						return [1,2];							
					} else { //return [];
						// x.
						// x.
						return [0,2];							
					}
				} else {
					if (NW < 0) { //return [];
						// x.
						// .x
						return [1,2,0,3];
					} else { //return [];
						// x.
						// xx
						return [2,3];							
					}			
				}
			} else {
				if (NE < 0) {
					if (NW < 0) { //return [];
						// ..
						// xx
						return [1,3];							
					} else { //return [];
						// xx
						// x.
						return [0,3];
					}									
				} else {
					if (NW < 0) { //return [];
						// xx
						// .x
						return [0,1];					
					} else { //return [];
						// xx
						// xx
						return [];						
					}									
				}					
			}				
		}		
	}
	
	if (typeof density == 'undefined') density = 5; // density is the width of each square
	var angleMode = gridDetails.angleMode || 'deg';	
	var yMin = gridDetails.yMin;
	var yMax = gridDetails.yMax;
	if (angleMode == 'deg' || typeof gridDetails.xMin == 'number') {
		var xMin = gridDetails.xMin;
		var xMax = gridDetails.xMax;
	} else {
		var xMin = Math.PI*gridDetails.xMin[0]/gridDetails.xMin[1];
		var xMax = Math.PI*gridDetails.xMax[0]/gridDetails.xMax[1]
	}
	
	if (typeof color == 'undefined') color = '#00F';
	ctx.strokeStyle = color;
	ctx.beginPath();
	var xInc = (xMax - xMin) / (gridDetails.width / density);
	var yInc = (yMax - yMin) / (gridDetails.height / density);
	var yPos = gridDetails.top + gridDetails.height;
	for (var y = yMin; y < yMax; y += yInc) {
		var xPos = gridDetails.left;
		for (var x = xMin; x < xMax; x += xInc) {
			var x2 = Math.min(x+xInc,xMax);
			var y2 = Math.min(y+yInc,yMax);
			var NW = func(x,y);
			var NE = func(x2,y);
			var SW = func(x,y2);
			var SE = func(x2,y2);
			var lines = getLines(SW,SE,NW,NE);
			while (lines.length > 1) {
				var pos = [];
				for (var i = 0; i < 2; i++) {
					var xPos2 = Math.min(xPos+density,gridDetails.left+gridDetails.width);
					var yPos2 = Math.max(yPos-density,gridDetails.top);
					var px = [xPos,xPos,xPos,xPos2][lines[i]];
					var py = [yPos,yPos,yPos2,yPos][lines[i]];
					var pf = [NW,NW,SW,NE][lines[i]];			
					var qx = [xPos2,xPos,xPos2,xPos2][lines[i]];
					var qy = [yPos,yPos2,yPos2,yPos2][lines[i]];
					var qf = [NE,SW,SE,SE][lines[i]];
					pos[i] = [px,py];
					if (px !== qx) pos[i][0] = px + density * ((0 - pf) / (qf - pf));
					if (py !== qy) pos[i][1] = py - density * ((0 - pf) / (qf - pf));
				}
				ctx.moveTo(pos[0][0],pos[0][1]);
				ctx.lineTo(pos[1][0],pos[1][1]);
				lines.shift();
				lines.shift();
			}
			xPos += density;
		}
		yPos -= density;
	}
	ctx.stroke();
}

jxxdrawButtons();
for (var b = 0; b < jxxgrid.buttons.length; b++) {
	addListener(jxxgrid.buttons[b],jxxgrid.buttons[b].click);
	addListener(jxxgrid.buttons[b],jxxdrawButtons);	
}
var jxxe = new Image;
jxxe.src = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAADCElEQVRYR+2WT0iacRjHvw3qBTMmMj0M8a0uC3FMSkKa8dJ7aYaSUMRYULguscTsZvCOOgzcybcJxS4yL0EwwT+7jYgOHXSXvYY4grfloYPUNshDDAI3fpLxrqz3tUaD4XOR1/f5/X4fv8/3efw1QVkwABIANACiADzKlslnNdVIeQ7gIYAfACIAeq1W6/jY2JirubmZEkUxv7y8/FGyTjzN+yl/3MUMKcBdAGabzfaaoih7uVwu7u3tcfv7+08YhhlNJBLQaDSIRqOYnp6G2WyGWq3GycmJIAgCd3x8nAbwvV4IKUBF5ng8rnG73SgUCiCf2WwWDMNACrC4uFh5tlgs2NzcrOQdHR25AST/NUAJwFMAQQAFJTBSBR4A8HEc5xwcHDR2dXUhHA4jFotBr9crUSDc19enam9vd2cymfDu7m4MwBc5iFomjE9OTrpJrUn4/X4IgiAL0NLSgomJCXi93mrp/ADe3BrAwsICRkZGUC6XrwVADERMSOKAYRgzy7LPpqamIIoiDg8P4XK5QFEU8vk80ul05Vmn052ZkCh2zryKFWCsVqu3tbV1lJxeLBa5nZ0dNU3TgarTr5KRlIfjOAQCAdjtdmn3KAb4xfN8pdYkyK9IJpOgafqs1eTqKH0vad/rAWQyGayuriKVStUNsLGxAZ7nD3K5XLBQKKQAfJWDJ13wbmZmptfpdJpYlgVx89bWVuVwn88Ho9Eot8fZe+IDj8dD+p94KqtkYbUNX/b3979YWVnRd3Z23lGpVErWXsi5CcB9g8Hg0Gq1/NLSUtvAwMCtA5AD//gvqJcgEolgfX3909ra2lsAHwB8U7KHdBI+AvAqFArZHA7HPTKK64nT7qn7riA7ipVC/E2A3p6envHu7m7f/Pw8Ojo6rmTI5XIIBoMgrbe9vf0ewGel0CSvlgLk+8cGg8E/OzvLDg0NaU0m06V7/s37wPlDaHJB4XneUp2StSj+a4A2AK5QKKSbm5u7sgTDw8MolUqk9WRH7/mNLvNAPT66UW4DoKFAQ4GGAr8B6HWSMOjcjREAAAAASUVORK5CYII=";
jxxe.onload = function() {
	jxxe.w = jxxe.naturalWidth;
	jxxe.h = jxxe.naturalHeight;
	jxxdrawButtons();
};


function jxxgridMoveMove(e) {
	updateMouse(e);
	jxxgrid.dragX.unshift(mouse.x);
	jxxgrid.dragY.unshift(mouse.y);
	var dx = (jxxgrid.dragX[0] - jxxgrid.dragX[1]) * jxxgrid.dragXDiff / jxxgrid.width;
	if (jxxgrid.mode == 'deg' || typeof jxxgrid.xMin == 'number') {
		jxxgrid.xMin -= dx;
		jxxgrid.xMax -= dx;
	} else {
		var prevMin = Math.PI*jxxgrid.xMin[0]/jxxgrid.xMin[1];
		var newMin = prevMin - dx;
		jxxgrid.xMin = [newMin/Math.PI,1];
		var prevMax = Math.PI*jxxgrid.xMax[0]/jxxgrid.xMax[1];
		var newMax = prevMax - dx;
		jxxgrid.xMax = [newMax/Math.PI,1];		
	}
	var dy = (jxxgrid.dragY[0] - jxxgrid.dragY[1]) * jxxgrid.dragYDiff / jxxgrid.height;
	jxxgrid.yMin += dy;
	jxxgrid.yMax += dy;
	jxxdrawGrid();
}
function jxxgridMoveEnd(e) {
	jxxgridCanvas2.style.cursor = 'url("../images/cursors/openhand.cur"), auto';
	if (jxxgrid.mode == 'deg' || typeof jxxgrid.xMin == 'number') {
		jxxgrid.xMin = roundToNearest(jxxgrid.xMin,jxxgrid.xMinorStep);
		jxxgrid.xMax = roundToNearest(jxxgrid.xMax,jxxgrid.xMinorStep);
	} else {
		jxxgrid.xMin = roundToFraction(jxxgrid.xMin[0]/jxxgrid.xMin[1],jxxgrid.xMinorStep);
		jxxgrid.xMax = roundToFraction(jxxgrid.xMax[0]/jxxgrid.xMax[1],jxxgrid.xMinorStep);
	}
	jxxgrid.yMin = roundToNearest(jxxgrid.yMin,jxxgrid.yMinorStep);
	jxxgrid.yMax = roundToNearest(jxxgrid.yMax,jxxgrid.yMinorStep);
	jxxdrawGrid();	
	removeListenerMove(window,jxxgridMoveMove);
	removeListenerEnd(window,jxxgridMoveEnd);	
}
function roundToFraction(num,frac) {
	if (typeof num == 'object') num = num[0]/num[1];
	return [Math.round(num*frac[1]/frac[0])*frac[0],frac[1]];
}

function jxxgridzoomSelMove(e) {
	updateMouse(e);
	jxxgrid.dragX[1] = Math.max(Math.min(mouse.x-jxxgrid.dragX[0],jxxgrid.left+jxxgrid.width-jxxgrid.dragX[0]),jxxgrid.left-jxxgrid.dragX[0]);
	jxxgrid.dragY[1] = Math.max(Math.min(mouse.y-jxxgrid.dragY[0],jxxgrid.top+jxxgrid.height-jxxgrid.dragY[0]),jxxgrid.top-jxxgrid.dragY[0]);
	jxxgridCanvas2.ctx.clearRect(0,0,1200,700);
	jxxgridCanvas2.ctx.strokeRect(jxxgrid.dragX[0]-jxxgrid.left,jxxgrid.dragY[0]-jxxgrid.top,jxxgrid.dragX[1],jxxgrid.dragY[1]);
}
function jxxgridzoomSelEnd(e) {
	jxxgridCanvas2.ctx.clearRect(0,0,1200,700);
	if (jxxgrid.mode == 'deg' || typeof jxxgrid.xMin == 'number') {
		jxxgrid.xMin = getCoordX2(Math.min(jxxgrid.dragX[0],jxxgrid.dragX[0]+jxxgrid.dragX[1]),jxxgrid.left,jxxgrid.width,jxxgrid.xMin,jxxgrid.xMax);
		jxxgrid.xMax = getCoordX2(Math.max(jxxgrid.dragX[0],jxxgrid.dragX[0]+jxxgrid.dragX[1]),jxxgrid.left,jxxgrid.width,jxxgrid.xMin,jxxgrid.xMax);
	} else {
		var xMin = getCoordX2(Math.min(jxxgrid.dragX[0],jxxgrid.dragX[0]+jxxgrid.dragX[1]),jxxgrid.left,jxxgrid.width,Math.PI*jxxgrid.xMin[0]/jxxgrid.xMin[1],Math.PI*jxxgrid.xMax[0]/jxxgrid.xMax[1]);
		var xMax = getCoordX2(Math.max(jxxgrid.dragX[0],jxxgrid.dragX[0]+jxxgrid.dragX[1]),jxxgrid.left,jxxgrid.width,Math.PI*jxxgrid.xMin[0]/jxxgrid.xMin[1],Math.PI*jxxgrid.xMax[0]/jxxgrid.xMax[1]);
		jxxgrid.xMin = [xMin/Math.PI,1];
		jxxgrid.xMax = [xMax/Math.PI,1];
	}
	jxxgrid.yMax = getCoordY2(Math.min(jxxgrid.dragY[0],jxxgrid.dragY[0]+jxxgrid.dragY[1]),jxxgrid.top,jxxgrid.height,jxxgrid.yMin,jxxgrid.yMax);
	jxxgrid.yMin = getCoordY2(Math.max(jxxgrid.dragY[0],jxxgrid.dragY[0]+jxxgrid.dragY[1]),jxxgrid.top,jxxgrid.height,jxxgrid.yMin,jxxgrid.yMax);
	jxxgrid.lockStepX = false;
	jxxgrid.lockStepY = false;
	jxxresetAxes();
	removeListenerMove(window,jxxgridzoomSelMove);
	removeListenerEnd(window,jxxgridzoomSelEnd);	
}

function jxxlineDrawMove(e) {
	var pos = getCoordAtMousePos(jxxgrid);
	if (jxxgrid.mode == 'deg') {
		var xPos = roundToNearest(pos[0],0.1*jxxgrid.xMinorStep);
	} else if (typeof jxxgrid.xMinorStep == 'number') {
		var xPos = roundToNearest(pos[0],0.1*Math.PI*jxxgrid.xMinorStep);
	} else {
		var xPos = roundToNearest(pos[0],0.1*Math.PI*(jxxgrid.xMinorStep[0]/jxxgrid.xMinorStep[1]));
	}	
	var yPos = roundToNearest(pos[1],0.1*jxxgrid.yMinorStep);
	jxxgrid.path[jxxgrid.path.length-1].pos[1] = [xPos,yPos];
	jxxdrawGrid();
}
function jxxlineDrawEnd(e) {
	removeListenerMove(window, jxxlineDrawMove);
	removeListenerEnd(window, jxxlineDrawEnd);
	var pos = getCoordAtMousePos(jxxgrid);
	if (jxxgrid.angleMode == 'deg') {
		var xPos = roundToNearest(pos[0],jxxgrid.xMinorStep);
	} else if (typeof jxxgrid.xMinorStep == 'number') {
		var xPos = roundToNearest(pos[0],Math.PI*jxxgrid.xMinorStep);
	} else {
		var xPos = roundToNearest(pos[0],Math.PI*(jxxgrid.xMinorStep[0]/jxxgrid.xMinorStep[1]));
	}
	var yPos = roundToNearest(pos[1],jxxgrid.yMinorStep);
	var path = jxxgrid.path[jxxgrid.path.length-1];
	path.pos[1] = [xPos,yPos];
	if (path.pos[0][0] == path.pos[1][0] && path.pos[0][1] == path.pos[1][1]) {
		jxxgrid.path.pop();
	}
	jxxdrawGrid();	
}

function jxxgridRescaleMove(e) {
	updateMouse(e);
	var changed = false;
	
	var gridxRescaleMin = jxxgrid.rescaleX * (1 + (mouse.x - jxxgrid.left) / (jxxgrid.originPos[0] - mouse.x));
	var gridxRescaleMax = jxxgrid.rescaleX * (1 + (mouse.x - jxxgrid.left - jxxgrid.width) / (jxxgrid.originPos[0] - mouse.x));
	if ((jxxgrid.rescaleX > 0 && mouse.x - jxxgrid.originPos[0] > 30) || (jxxgrid.rescaleX < 0 && jxxgrid.originPos[0] - mouse.x > 30)) {
		if (((gridxRescaleMax - gridxRescaleMin <= jxxgrid.width * 10) || Math.abs(mouse.x - jxxgrid.originPos[0]) > Math.abs(jxxgrid.rescalePrev[0] - jxxgrid.originPos[0])) && (jxxgrid.rescaleX > 0 && mouse.x > jxxgrid.originPos[0]) || (jxxgrid.rescaleX < 0 && mouse.x < jxxgrid.originPos[0])) {
			if (jxxgrid.mode == 'deg' || typeof jxxgrid.xMin == 'number') {
				jxxgrid.xMin = Number(gridxRescaleMin);
				jxxgrid.xMax = Number(gridxRescaleMax);
			} else {
				jxxgrid.xMin = [Number(gridxRescaleMin)/Math.PI,1];
				jxxgrid.xMax = [Number(gridxRescaleMax)/Math.PI,1];
			}
			changed = true;
		}
	}

	var gridyRescaleMin = jxxgrid.rescaleY * (1 + (mouse.y - jxxgrid.top - jxxgrid.height) / (jxxgrid.originPos[1] - mouse.y));
	var gridyRescaleMax = jxxgrid.rescaleY * (1 + (mouse.y - jxxgrid.top) / (jxxgrid.originPos[1] - mouse.y));
	if ((jxxgrid.rescaleY < 0 && mouse.y - jxxgrid.originPos[1] > 30) || (jxxgrid.rescaleY > 0 && jxxgrid.originPos[1] - mouse.y > 30)) {
		if (((gridyRescaleMax - gridyRescaleMin <= jxxgrid.height * 10) || Math.abs(mouse.y - jxxgrid.originPos[1]) > Math.abs(jxxgrid.rescalePrev[1] - jxxgrid.originPos[1])) && ((jxxgrid.rescaleY > 0 && mouse.y < jxxgrid.originPos[1]) || (jxxgrid.rescaleY < 0 && mouse.y > jxxgrid.originPos[1]))) {
			jxxgrid.yMin = Number(gridyRescaleMin);
			jxxgrid.yMax = Number(gridyRescaleMax);
			
			changed = true;
		}
	}
	
	if (changed == true) jxxresetAxes();
	jxxgrid.rescalePrev = [mouse.x,mouse.y];
}
function jxxgridRescaleStop(e) {
	if (jxxgrid.mode == 'deg' || typeof jxxgrid.xMin == 'number') {
		jxxgrid.xMin = roundToNearest(jxxgrid.xMin,jxxgrid.xMinorStep);
		jxxgrid.xMax = roundToNearest(jxxgrid.xMax,jxxgrid.xMinorStep);
	} else {
		jxxgrid.xMin = roundToFraction(jxxgrid.xMin[0]/jxxgrid.xMin[1],jxxgrid.xMinorStep);
		jxxgrid.xMax = roundToFraction(jxxgrid.xMax[0]/jxxgrid.xMax[1],jxxgrid.xMinorStep);
	}	
	jxxgrid.yMin = roundToNearest(jxxgrid.yMin,jxxgrid.yMinorStep);
	jxxgrid.yMax = roundToNearest(jxxgrid.yMax,jxxgrid.yMinorStep);
	jxxdrawGrid();		
	removeListenerMove(window,jxxgridRescaleMove);
	removeListenerEnd(window,jxxgridRescaleStop);
}
