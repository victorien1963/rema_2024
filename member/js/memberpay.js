

//充值
$(document).ready(function(){
	$("#memberpayform").submit(function(){
		if($("#payid")[0].value==""){
			alert("請選擇線上支付接口");
			return false;
		}
		if($("#paytotal")[0].value=="" || Number($("#paytotal")[0].value)<0.01 || isNaN($("#paytotal")[0].value)){
			alert("請填寫充值金額");
			return false;
		}
		return true;
	});
});

