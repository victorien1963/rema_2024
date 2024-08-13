

//檢索頁橫豎圖片自適應
function picFit(theImg,x){

  theImg.style.visibility="hidden";

  var w = theImg.offsetWidth;
  var h = theImg.offsetHeight;
  
  if(h>w){
  	theImg.style.height=x+"px";
  	theImg.style.width='';
  }else{
  	theImg.style.height='';
  	theImg.style.width=x+"px";
	theImg.style.marginTop=(x-theImg.offsetHeight)/2+"px";

  }
  
  theImg.style.visibility="visible";
}



