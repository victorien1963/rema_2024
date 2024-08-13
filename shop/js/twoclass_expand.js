$(document).ready(function(){
	$("ul[id^='twoclass_']").hide();
	$("ul#twoclass_1").show();
	$().setBg();
	$(".shoptwoclass_expand_top").toggle(
	  function () {
		var catid=this.id.substr(12);
		$("ul#twoclass_"+catid).hide();
		$().setBg();
	  },
	  function () {
		var catid=this.id.substr(12);
		$("ul#twoclass_"+catid).show();
		$().setBg();
	  }
	);
}); 