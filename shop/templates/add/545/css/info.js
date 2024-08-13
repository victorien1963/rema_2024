
$(document).ready(function(){
	$("#receipt_a").click(function(){
  		$("#receipt_info_a").slideDown();
  		$("#receipt_info_b").slideUp();
  		$("#receipt_info_c").slideUp();
	});
	$("#receipt_b").click(function(){
  		$("#receipt_info_b").slideDown();
  		$("#receipt_info_a").slideUp();
  		$("#receipt_info_c").slideUp();
	});
	$("#receipt_c").click(function(){
  		$("#receipt_info_c").slideDown();
  		$("#receipt_info_a").slideUp();
  		$("#receipt_info_b").slideUp();
	});
	
	/*$("#receipt_b_a").click(function(){
		alert("若您尚未歸戶，必須有自然人憑證及晶片卡讀卡機！\n系統會引導至財政部電子發票平台進行歸戶動作！\n無自然人憑證或讀卡機，請選用可線上申請的手機載具。");
	});*/
});