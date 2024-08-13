function doIframe(){
	o = document.getElementsByTagName('iframe');
	for(i=0;i<o.length;i++){
		if (/\bautoHeight\b/.test(o[i].className)){
			setHeight(o[i]);
			addEvent(o[i],'load', doIframe);
		}
	}
}

function setHeight(e){
	//網頁高度
	var h = $(window).height()-202+25;
	if(e.contentDocument){
		var bh = e.contentDocument.body.offsetHeight;
		if(bh > h){
			var yesH = bh + 20;
		}else{
			var yesH = h;
		}
		$(e).animate({
			height:yesH
		},100);
		//e.height = e.contentDocument.body.offsetHeight + 20;
	} else {
		var bh = e.contentWindow.document.body.scrollHeight;
		if(bh > h){
			var yesH = bh;
		}else{
			var yesH = h;
		}
		$(e).animate({
			height:yesH
		},100);
		//e.height = e.contentWindow.document.body.scrollHeight;
	}
	
	
}


function addEvent(obj, evType, fn){
	if(obj.addEventListener)
	{
	obj.addEventListener(evType, fn,false);
	return true;
	} else if (obj.attachEvent){
	var r = obj.attachEvent("on"+evType, fn);
	return r;
	} else {
	return false;
	}
}

if (document.getElementById && document.createTextNode){
	addEvent(window,'load', doIframe);
	addEvent(window,'resize', doIframe);
	addEvent(window,'click', doIframe);
}

		