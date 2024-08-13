<!--


function initSubMenu(mainMenuDiv,subMenuDiv,n){
	//$("#"+mainMenuDiv+"_"+n)[0].className=mainMenuDiv+"_current";
	$("#"+subMenuDiv).children("ul")[n].style.display="block";
}

function showSubMenu(mainMenuDiv,subMenuDiv,n){
	

	obj=$("#"+subMenuDiv).children("ul");

	for(var i=0;i<obj.length;i++){
		if(i==n){
			obj[i].style.display="block";
			var length=obj[i].getElementsByTagName('li').length;

			$("#"+subMenuDiv)[0].style.left=$("#"+mainMenuDiv+"_"+i)[0].offsetLeft+"px";
			$("#"+mainMenuDiv+"_"+i)[0].className=mainMenuDiv+"_current";
		}else{
			obj[i].style.display="none";
			$("#"+mainMenuDiv+"_"+i)[0].className=mainMenuDiv;

		}
		
	}

}


-->