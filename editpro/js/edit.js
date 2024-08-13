/*
*#########################################
* PHPCMS File Manager
* Copyright (c) 2004-2007 Longbill.cn
* By Longbill ( http://www.longbill.cn )
* longbill.cn@gmail.com
*#########################################
*/
window.debug = 0;
function repon()
{
	var o = replacediv.style;
	o.display = (o.display == "none" )?"":"none";
}

function breakline(b)
{
	if (b)
	{
		$('txt_ln').style.width = "2px";
		var a=$('txt_main');
		a.style.wordWrap = "break-word";
	}
	else
	{
		$('txt_ln').style.width = "35px";
		var a=$('txt_main');
		a.style.wordWrap = "normal";
	}
}


var lg_strback='';
function str_undo()
{
	var str;
	if(lg_strback=='') alert('Cannot return');
	str=window.editform.content.innerText;
	window.editform.content.innerText=lg_strback;
	lg_strback=str;
}

function repit(mstr,sstr,tstr)
{
	var i;
	i=0;
	if(mstr==''||sstr=='')
		return '';
	while(1)
	{
		i=mstr.indexOf(sstr,i);
		if(i<0)break;
		mstr=mstr.replace(sstr,tstr);
		i+=tstr.length;
	}
	return mstr;
}

function str_replace()
{
	var i1,i2,str,strLeft,strRight,strMid;
	strLeft=window.editform.repLeft.innerText;
	strRight=window.editform.repRight.innerText;
	strMid=window.editform.repMid.innerText;
	str=window.editform.content.innerText;
	lg_strback=str;
	i1=0;
	i2=0;
	if(strLeft=='') return;

	if(strRight=='')
	{
		strMid=repit(strMid,'[$]',strLeft);
		str=repit(str,strLeft,strMid);
	}
	else
	while(1)
	{
		i1=str.indexOf(strLeft,i1);
		if(i1<0) break;
		i2=str.indexOf(strRight,i1+strLeft.length);
		if(i2<0) break;
		str1=str.substring(i1+strLeft.length,i2);
		str2=repit(strMid,'[$]',str1);
		str1=strLeft+str1+strRight;
		if(!window.editform.isRemove.checked)
		{
			str2=strLeft+str2;
			str=str.replace(str1,str2+strRight);
		}
		else str=str.replace(str1,str2);
		i1+=str2.length;
	}
	window.editform.content.innerText=str;
}


var ctrlon = false;

function editTab(a,obj)
{
	if (!a) a = window.event;
	var code, sel, tmp, r;
	var tabs='';
	a.returnValue = false;
	if (document.all)
	{
		sel = obj.document.selection.createRange(); 
		r = obj.createTextRange(); 
	}
	if (a.keyCode == 17)
	{
		window.ctrlon = true;
		return false;
	}
	switch (a.keyCode)
	{
		case (9) :
			if (document.all)
			{
				if (sel.getClientRects().length > 1)
				{
					code = sel.text;
					tmp = sel.duplicate();
					tmp.moveToPoint(r.getBoundingClientRect().left, sel.getClientRects()[0].top);
					sel.setEndPoint('startToStart', tmp);
					sel.text = '\t'+sel.text.replace(/\r\n/g, '\r\t');
					code = code.replace(/\r\n/g, '\r\t');
					r.findText(code);
					r.select();
				}else
				{
					sel.text = '\t';
					sel.select();
				}
			}
			else	//firefox	
			{
				var orig_top = obj.scrollTop;
				var rangeStart = obj.selectionStart;
				var rangeEnd = rangeStart;
				var tempStr1 = obj.value.substring(0,rangeStart);
				tempStr1 += '\t';
 				var tempStr2 = obj.value.substring(rangeEnd);
				obj.value = tempStr1+ tempStr2;
				obj.selectionStart = rangeEnd+1;
				obj.selectionEnd  = obj.selectionStart;
				obj.scrollTop = orig_top;
				return false;
			}
			break;
		case (13) :
			if (document.all)
			{
				tmp = sel.duplicate();
				tmp.moveToPoint(r.getBoundingClientRect().left, sel.getClientRects()[0].top);
				tmp.setEndPoint('endToEnd', sel);
				for (var i=0; tmp.text.match(/^[\t]+/g) && i<tmp.text.match(/^[\t]+/g)[0].length; i++) tabs += '\t';
				sel.text = '\r\n'+tabs;
				sel.select();
			}
			else // firefox
			{
				var orig_top = obj.scrollTop;
				var rangeStart = obj.selectionStart;
				var rangeEnd = rangeStart;
				var tempStr1 = obj.value.substring(0,rangeStart);
				var tabs = "";
				if(tempStr1.indexOf('\t') != -1)
				{
					var arr = tempStr1.split('\n');
					var ts = arr[arr.length-1];
					for (var i=0; ts.match(/^[\t]+/g) && i<ts.match(/^[\t]+/g)[0].length; i++) tabs += '\t';
				}
 				var tempStr2 = obj.value.substring(rangeEnd);
				obj.value = tempStr1+ "\r\n" + tabs+ tempStr2;
				obj.selectionStart = rangeEnd+tabs.length+1;
				obj.selectionEnd  = obj.selectionStart;
				obj.scrollTop = orig_top + parseInt(obj.style.lineHeight);
				return false;
			}
			break;
		case (83) :
			if (a.ctrlKey || a.metaKey)
			{

				editform_submit();
				a.returnValue = false;
				return false;
			}
		default  :
			a.returnValue = true;
			break;
	}
	return true;
}


function $(obj)
{
	return document.getElementById(obj);
}

function show_ln()
{
	document.getElementById('txt_ln').scrollTop = parseInt(document.getElementById('txt_main').scrollTop);
}

function runme()
{
	var openwin=window.open("","_blank","");
	openwin.document.write($('txt_main').value);
}


function resize_text()
{
	var h = parseInt(document.body.clientHeight) - 150;
	$('txt_ln').style.height = h;
	$('txt_main').style.height = h;
}

function save_if_close(o)
{
	//document.editform.target = o.checked?'_self':'inwin';
	if (o.checked)
		document.cookie = "if_close=true;";
	else
		document.cookie = "if_close=false;";
}


function set_charset(charset)
{
	var url = window.location.toString();
	url.replace("charset=","");
	url += "&charset="+charset;
	window.location = url;
}

window.onload = function ()
{
	if (debug) alert('on load');
	$("loading").style.display = "none";
	$('topdiv').style.width = window.screen.availWidth;
	if (!(document.all))
	{
		setInterval(show_ln,100);
	}
	document.body.onmousemove = show_ln;
	resize_text();
	window.onresize = resize_text;
}
if (debug) alert('edit.js loaded');
