$(document).ready(function(){
	$('#user').blur(function(){ 
		var user=$("#user")[0].value;
		if(user==""){
			$('#msg').html("请输入邮箱用户名");
		}
		else{
			$('#msg').html("");
		}
	});

	$('#pass').blur(function(){ 
		var pass=$("#pass")[0].value;
		if(pass==""){
			$('#msg').html("请输入邮箱密码");
		}
		else{
			$('#msg').html("");
		}
	});

	$('#cancel').click(function(){
		$("#user").attr("value",'');
		$("#pass").attr("value",'');
		$('#msg').html("");
		return false;
	});

	$('#submit').click(function(){
		if($("#user")[0].value=="" || $("#pass")[0].value==""){
			$('#msg').html("请输入邮箱用户名或密码")
			return false;
		}
		else{
			$('#msg').html("");
			var user = $('#user')[0].value;
		}
	});
});