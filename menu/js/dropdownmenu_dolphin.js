<!--


//下拉菜单
$(document).ready(function() {
	
	var getObj = $('div.dorpmenu_dolphin');
	getObj.each(function(id) {
		var obj = this.id;
		var n=parseInt(obj.substr(16));

		$("#"+obj).mouseover(function () {
			if($("div#subdorpmenu_dolphin"+n)[0].style.display!="block"){
				$("div.subdorpmenu_dolphin").hide();
			}
			$("div#subdorpmenu_dolphin"+n)[0].style.top=$("#"+obj)[0].offsetTop+$("#"+obj)[0].offsetHeight+"px";
			$("div#subdorpmenu_dolphin"+n).show();


			if(id==0){
				//$("div#subdorpmenu_dolphin"+n).find("ul")[0].className="firstdrop";
				$("div#subdorpmenu_dolphin"+n)[0].style.left=$("#"+obj)[0].offsetLeft+1 + "px";
			}else{
				$("div#subdorpmenu_dolphin"+n)[0].style.left=$("#"+obj)[0].offsetLeft + "px";
			}
			

			$("div#subdorpmenu_dolphin"+n).find("li").mouseout(function () {
				this.className="";
			});
			
			$("div#subdorpmenu_dolphin"+n).find("li").mouseover(function () {
				this.className="current";
				$("div.subdorpmenu_dolphin").hide();
				$("div#subdorpmenu_dolphin"+n).show();
			});
			
			
		});

		$("#"+obj).mouseout(function () {
			//$("div.subdorpmenu").hide();  //ie6不兼容
		});

		

	});

	$("body").click(function () {
		$("div.subdorpmenu_dolphin").hide();
	});


});

-->