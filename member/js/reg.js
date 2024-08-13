
//會員表單校驗

$(document).ready(function(){
	$('.forc').hide();
$('#membertypeid2').click(function(){
	$('.forp').hide();
	$('.forc').show();
});
$('#membertypeid1').click(function(){
	$('.forc').hide();
	$('.forp').show();
});

	$('#selcountry').change(function(){ 
		$("#addr").val("");
		$("#postcode").val("");
		$("#zoneid").html("");
		var p = this.value.split("_");
		
		$("#mov").val(p[2]);
		$("#tel").val(p[2]);
		
			$.ajax({
					type: "POST",
					url: PDV_RP+"member/post.php",
					data: "act=getzonelist&pid="+p[1],
					success: function(msg){
						//$.getScript(PDV_RP+"member/js/zone.js");
						pList.data = new Array();
						$("#zonelist").html(msg);
						if(PDV_LAN == "en"){
							$("#Province").html("<option value='s'> Please Select</option>"+pList.getOptionString('s'));
						}else if(PDV_LAN == "zh_cn"){
							$("#Province").html("<option value='s'> 请选择</option>"+pList.getOptionString('s'));
						}else{
							$("#Province").html("<option value='s'> 請選擇</option>"+pList.getOptionString('s'));
						}
							//$('#Province').selectpicker('refresh');
					}
				
			 });
	}); 
	/*$('#repass').blur(function(){ 
		var p=$("#repass")[0].value;
		var w=$("#password")[0].value;
		var patrn=/^(\w){5,20}$/;
		if(!patrn.exec(p)){
			$('#repass').after('<span id="chkRepass" class="label label-danger">登入密碼必須由5-20個英文字母或數字組成</span>');
			alert("登入密碼必須由5-20個英文字母或數字組成");
		}else if(p!=w){
			$('#repass').after('<span id="chkRepass" class="label label-danger">兩次輸入的密碼不一致，請輸入和上面相同的密碼</span>');
			alert("兩次輸入的密碼不一致，請輸入和上面相同的密碼");
		}else{
			$('#repass').after('<span id="chkRepass" class="label label-info">輸入正確</span>');
		}
	}); */

	$('#email').blur(function(){ 
		var p=$("#email")[0].value;
		
			$.ajax({
					type: "POST",
					url: PDV_RP+"member/post.php",
					data: "act=checkmail&email="+p,
					success: function(msg){
						if(msg=="YES"){
							$('#chkEmail').remove();
							if(PDV_LAN == "en"){
								$('#email').after('<span id="chkEmail" class="label label-info">No one has applied, it is available.</span>');
							}else if(PDV_LAN == "zh_cn"){
								$('#email').after('<span id="chkEmail" class="label label-info">无人申请，可以使用</span>');
							}else{
								$('#email').after('<span id="chkEmail" class="label label-info">無人申請，可以使用</span>');
							}
						}else if(msg=="NO"){
							$('#chkEmail').remove();
							if(p == ""){
								if(PDV_LAN == "en"){
									$('#email').after('<span id="chkEmail" class="label label-danger">Please enter the email.</span>');
								}else if(PDV_LAN == "zh_cn"){
									$('#email').after('<span id="chkEmail" class="label label-danger">请填写电子邮件</span>');
								}else{
									$('#email').after('<span id="chkEmail" class="label label-danger">請填寫電子郵件</span>');
								}
								
							}else{
								if(PDV_LAN == "en"){
									$('#email').after('<span id="chkEmail" class="label label-danger">The e-mail has been registered, please try another one.</span>');
									//alert("The e-mail has already been registered, please replace one.");
								}else if(PDV_LAN == "zh_cn"){
									$('#email').after('<span id="chkEmail" class="label label-danger">该电子邮件已经注册过，请更换一个</span>');
									//alert("该电子邮件已经注册过，请更换一个");
								}else{
									$('#email').after('<span id="chkEmail" class="label label-danger">該電子郵件已經註冊過，請更換一個</span>');
									//alert("該電子郵件已經註冊過，請更換一個");
								}
								
							}
						}else{
							$('#chkEmail').remove();
							$('#email').after(msg);
						}
					}
				
			 });
	});
	
	/*$('#addr').blur(function(){ 
		var p=$("#addr")[0].value;
		
			$.ajax({
					type: "POST",
					url: PDV_RP+"member/post.php",
					data: "act=checkaddr&addr="+p,
					success: function(msg){
						if(msg=="NO"){
							alert("請輸入包含 縣市/地區 的詳細地址");
						}
					}
				
			 });
	});*/


	$('#pname').focus(function(){ 
		$('#chkPname').remove();
		if(PDV_LAN == "en"){
			$('#pname').after('<span id="chkPname" class="label label-warning"Nicknames can be Chinese, English or numbers.</span>');
		}else if(PDV_LAN == "zh_cn"){
			$('#pname').after('<span id="chkPname" class="label label-warning">网名昵称可以是中文、英文或数字</span>');
		}else{
			$('#pname').after('<span id="chkPname" class="label label-warning">網名暱稱可以是中文、英文或數字</span>');
		}
		
	}); 

	$('#pname').blur(function(){
		var p=$("#pname")[0].value;
		if(p.length<1){
			$('#chkPname').remove();
			$('#pname').after('<span id="chkPname" class="label label-danger">請輸入網名暱稱</span>');
		}else{
			$('#chkPname').remove();
			$('#pname').after('<span id="chkPname" class="label label-info">輸入正確</span>');
		}

	}); 

	//姓名
	$('#name').focus(function(){ 
		$('#chkName').remove();
		if(PDV_LAN == "en"){
			$('#name').after('<span id="chkName" class="label label-warning">Please enter your name.</span>');
		}else if(PDV_LAN == "zh_cn"){
			$('#name').after('<span id="chkName" class="label label-warning">请输入您的姓名</span>');
		}else{
			$('#name').after('<span id="chkName" class="label label-warning">請輸入您的姓名</span>');
		}
		
	}); 

	$('#name').blur(function(){
		var p=$("#name")[0].value;
		if(p.length<2){
			$('#chkName').remove();
			if(PDV_LAN == "en"){
				$('#name').after('<span id="chkName" class="label label-danger">Please enter your name.</span>');
			}else if(PDV_LAN == "zh_cn"){
				$('#name').after('<span id="chkName" class="label label-danger">请输入您的姓名</span>');
			}else{
				$('#name').after('<span id="chkName" class="label label-danger">請輸入您的姓名</span>');
			}
			
		}else{
			$('#chkName').remove();
			/*if(PDV_LAN == "en"){
				$('#name').after('<span id="chkName" class="label label-info">Correct!</span>');
			}else if(PDV_LAN == "zh_cn"){
				$('#name').after('<span id="chkName" class="label label-info">输入正确</span>');
			}else{
				$('#name').after('<span id="chkName" class="label label-info">輸入正確</span>');
			}*/
		}

	}); 

	/*$('#tel').focus(function(){ 
		$('#chkTel').remove();
		
		if(PDV_LAN == "en"){
			$('#tel').after('<span id="chkTel" class="label label-warning">Please enter a phone number, such as: 02-12345678</span>');
		}else if(PDV_LAN == "zh_cn"){
			$('#tel').after('<span id="chkTel" class="label label-warning">请输入固定电话号码，格式如：02-12345678</span>');
		}else{
			$('#tel').after('<span id="chkTel" class="label label-warning">請輸入市內電話號碼，格式如：02-12345678</span>');
		}
	}); */

	/*$('#tel').blur(function(){
		var p=$("#tel")[0].value;
		if(p==''){
			$('#chkTel').remove();
		}else{
			var patrn=/^[_.0-9a-z-]+-([0-9a-z][0-9a-z-])+[0-9]{4,8}$/;
			if(!patrn.exec(p)){
				$('#chkTel').remove();
				$('#tel').after('<span id="chkTel" class="label label-danger">請輸入正確的室內電話號碼，格式如：02-12345678</span>');
			}else{
				$('#chkTel').remove();
				$('#tel').after('<span id="chkTel" class="label label-info">輸入正確</span>');
				
			}
		}

	});*/
	
	$('#mov').focus(function(){ 
		$('#chkMov').remove();
		
		if(PDV_LAN == "en"){
			$('#mov').after('<span id="chkMov" class="label label-warning">Please enter your mobile number, such as: +886989123678</span>');
		}else if(PDV_LAN == "zh_cn"){
			$('#mov').after('<span id="chkMov" class="label label-warning">请输入手机号码，如：+861122335566</span>');
		}else{
			$('#mov').after('<span id="chkMov" class="label label-warning">請輸入手機號碼，如：0989123678</span>');
		}
	}); 

	$('#mov').blur(function(){
		/*var p=$("#mov")[0].value;
		if(p==''){
			$('#chkMov').remove();
		}else if(p.length<10){
			$('#chkMov').remove();
			$('#mov').after('<span id="chkMov" class="label label-danger">請輸入正確的手機號碼，如：0989123456</span>');
		}else{
			$('#chkMov').remove();
			$('#mov').after('<span id="chkMov" class="label label-info">輸入正確</span>');
		}*/
		$('#chkMov').remove();
	});
	
	/*$("#tongyi").click(function(){
		if($("#tongyi")[0].checked==true){
			$("#tijiao")[0].disabled=false;
		}else{
			$("#tijiao")[0].disabled=true;
		}
	});*/
	
});




//會員註冊表單送出
$(document).ready(function(){

/**/
$('#memberRegFirst').submit(function(){ 
	
		var mty = $("input[name='membertypeid']:checked").val();
	
		var ep=$("#email")[0].value;
		if(ep == ""){
			if(PDV_LAN == "en"){
				alert("Please enter a correct email.");
			}else if(PDV_LAN == "zh_cn"){
				alert("请输入电子邮件");
			}else{
				alert("請輸入電子郵件");
			}
			
			return false;
		}
		
		var pp=$("#password")[0].value;
		if(!pp){
			if(PDV_LAN == "en"){
				alert("Please enter your password.");
			}else if(PDV_LAN == "zh_cn"){
				alert("请填写-密码");
			}else{
				alert("請填寫-密碼");
			}
			
			return false;
		}
		var rpp=$("#repass")[0].value;
		if(!rpp){
			if(PDV_LAN == "en"){
				alert("Please enter a confirm password");
			}else if(PDV_LAN == "zh_cn"){
				alert("请填写-确认密码");
			}else{
				alert("請填寫-確認密碼");
			}
			return false;
		}
		
		var patrn=/^(\w){5,20}$/;
		if(!patrn.exec(pp)){
			if(PDV_LAN == "en"){
				alert("The login password must consist of 5-20 alphanumeric characters.");
			}else if(PDV_LAN == "zh_cn"){
				alert("登入密码必须由5-20个英文字母或数字组成");
			}else{
				alert("登入密碼必須由5-20個英文字母或數字組成");
			}
			
			return false;
		}else if(pp!=rpp){
			if(PDV_LAN == "en"){
				alert("You enter a different password, please enter the same password as above.");
			}else if(PDV_LAN == "zh_cn"){
				alert("两次输入的密码不一致，请输入和上面相同的密码");
			}else{
				alert("兩次輸入的密碼不一致，請輸入和上面相同的密碼");
			}
			
			return false;
		}
		

		/*var sp=$("#sex")[0].value;
		if(sp == 0){
			if(PDV_LAN == "en"){
				alert("Please select a gender.");
			}else if(PDV_LAN == "zh_cn"){
				alert("请选择-性别");
			}else{
				alert("請選擇-性別");
			}
			return false;
		}*/
		if(mty == 2){
			//passcode //company
			var pc=$("#passcode")[0].value;
			if(!pc){
				if(PDV_LAN == "en"){
					alert("Please enter a unified business number.");
				}else if(PDV_LAN == "zh_cn"){
					alert("请填写-统一编号");
				}else{
					alert("請填寫-統一編號");
				}
				
				return false;
			}
			var bn=$("#company")[0].value;
			if(!bn){
				if(PDV_LAN == "en"){
					alert("Please enter a business name.");
				}else if(PDV_LAN == "zh_cn"){
					alert("请填写-公司名称");
				}else{
					alert("請填寫-公司名稱");
				}
				
				return false;
			}
		}
		
			var np=$("#name")[0].value;
			if(!np){
				if(PDV_LAN == "en"){
					alert("Please enter your name.");
				}else if(PDV_LAN == "zh_cn"){
					alert("请填写-姓名");
				}else{
					alert("請填寫-姓名");
				}
				
				return false;
			}
	if(mty == 1){
		var yp=$("#Year_ID")[0].value;
		if(yp == 0){
			
			if(PDV_LAN == "en"){
				alert("Please select a year of birth");
			}else if(PDV_LAN == "zh_cn"){
				alert("请选择-出生年");
			}else{
				alert("請選擇-出生年");
			}
			return false;
		}
		var mp=$("#Month_ID")[0].value;
		if(mp == 0){
			if(PDV_LAN == "en"){
				alert("Please select a month of birth");
			}else if(PDV_LAN == "zh_cn"){
				alert("请选择-出生月");
			}else{
				alert("請選擇-出生月");
			}
			
			return false;
		}
		var dp=$("#Day_ID")[0].value;
		if(dp == 0){
			
			if(PDV_LAN == "en"){
				alert("Please select a day of birth");
			}else if(PDV_LAN == "zh_cn"){
				alert("请选择-出生日");
			}else{
				alert("請選擇-出生日");
			}
			return false;
		}
	}
	//selcountry
		var cy=$("#selcountry")[0].value;
		if(cy == 0){
			if(PDV_LAN == "en"){
				alert("Please select in a country.");
			}else if(PDV_LAN == "zh_cn"){
				alert("请选择-国家");
			}else{
				alert("請選擇-國家");
			}
			
			return false;
		}
	
	
		var ap=$("#addr")[0].value;
		if(ap == 0){
			if(PDV_LAN == "en"){
				alert("Please enter an address.");
			}else if(PDV_LAN == "zh_cn"){
				alert("请填写-地址");
			}else{
				alert("請填寫-地址");
			}
			
			return false;
		}
		var pop=$("#postcode")[0].value;
		if(!pop){
			if(PDV_LAN == "en"){
				alert("Please enter a postal code.");
			}else if(PDV_LAN == "zh_cn"){
				alert("请填写-邮递编号");
			}else{
				alert("請填寫-郵遞區號");
			}
			
			return false;
		}
		var mop=$("#mov")[0].value;
		if(mop == 0){
			if(PDV_LAN == "en"){
				alert("Please enter a phone number.");
			}else if(PDV_LAN == "zh_cn"){
				alert("请填写-手机号码");
			}else{
				alert("請填寫-手機號碼");
			}
			
			return false;
		}
		/*var tp=$("#tel")[0].value;
		if(tp == 0){
			alert("請填寫-其他號碼");
			return false;
		}*/
		
		if( $("input#tongyi").is(':checked') ){
			
		}else{
			if(PDV_LAN == "en"){
				alert("You must agree to the privacy notice to register!");
			}else if(PDV_LAN == "zh_cn"){
				alert("您必须同意隐私权声明才能注册！");
			}else{
				alert("您必須同意隱私權聲明才能註冊！");
			}
			
			return false;
		}
});
/**/
	$('#memberReg').submit(function(){ 
		
		$('#memberReg').ajaxSubmit({
			target: 'div#notice',
			url: PDV_RP+'post.php',
			success: function(msg) {
				switch(msg){
					
					case "OK":
						//$('div#notice').hide();
						if($("#nextstep")[0].value=="enter"){
							
						/*$.blockUI({
						message: "電子信箱確認信已經寄出，<br \/>請註冊完畢後至信箱啟動您的會員帳號。",
						css:{
							width:'320px',height:'100px',lineHeight:'3em',fontSize:'14px',backgroundColor:'#fff',border:'5px #cbddef solid'
							}
						}); 
							setTimeout("$.unblockUI(),window.location='../logout.php';",5000);
						}else if($("#nextstep")[0].value=="person"){

						$.blockUI({
						message: "電子信箱確認信已經寄出，<br \/>請註冊完畢後至信箱啟動您的會員帳號。",
						css:{
							width:'320px',height:'100px',lineHeight:'3em',fontSize:'14px',backgroundColor:'#fff',border:'5px #cbddef solid'
							}
						}); 
						setTimeout("$.unblockUI(),window.location='reg.php?step='+$(\"#nextstep\")[0].value;",5000);*/
						
							window.location='regfins.php';
						
						}else{
							//window.location='reg.php?step='+$("#nextstep")[0].value;
							window.location='regfins.php';
						}
					break;

					case "OK_NOMAIL":
						$('div#notice').hide();
						if($("#nextstep")[0].value=="enter"){
							//alert("會員註冊成功！");
							//window.location='index.php';
							window.location='regfins.php';
						}else{
							//window.location='reg.php?step='+$("#nextstep")[0].value;
							window.location='regfins.php';
						}
					break;

					case "CHECK":
						/*$('div#notice')[0].className='okdiv';
						$('div#notice').html("會員註冊成功！您註冊的會員類型需要審核後才能登入，感謝您的註冊");
						$('div#notice').show();
						$().setBg();*/
						alert("會員註冊成功！您註冊的會員類型需要審核後才能登入，感謝您的註冊");
						window.location = 'login.php';
					break;

					default :
						/*$('div#notice')[0].className='noticediv';
						$('div#notice').show();
						$().setBg();*/
						alert(msg);
					break;
				}
				
			}
		}); 

       return false; 

   }); 
});

//會員註冊分步送出
$(document).ready(function(){
	
	$('#RegStep').submit(function(){ 
		
		$('#RegStep').ajaxSubmit({
			target: 'div#notice',
			url: 'post.php',
			success: function(msg) {

				if(msg=="OK"){
					$('div#notice').hide();
					
					if($("#nextstep")[0].value=="enter"){
						$.blockUI({
						message: "會員註冊成功!<br \/>請至您的註冊信箱啟動會員帳號。",
						css:{
							width:'320px',height:'100px',lineHeight:'3em',fontSize:'14px',backgroundColor:'#fff',border:'5px #cbddef solid'
							}
						}); 
						setTimeout("$.unblockUI(),window.location='../logout.php';",5000);
						//window.location='index.php';
					}else{
						window.location='reg.php?step='+$("#nextstep")[0].value;
					}
				}else if(msg=="OK_NOMAIL"){
					$('div#notice').hide();
					
					if($("#nextstep")[0].value=="enter"){
						
						$.blockUI({
						message: "會員註冊成功!<br \/>歡迎您登入網站。",
						css:{
							width:'320px',height:'100px',lineHeight:'3em',fontSize:'14px',backgroundColor:'#fff',border:'5px #cbddef solid'
							}
						}); 
						setTimeout("$.unblockUI(),window.location='index.php';",5000);
					}else{
						window.location='reg.php?step='+$("#nextstep")[0].value;
					}
				}else{
					$('div#notice')[0].className='noticediv';
					$('div#notice').show();
					$().setBg();
					
				}
			}
		}); 
		
       return false; 

   }); 
});

//頭像設置
$(document).ready(function(){
	$(".selface").click(function(){
		$("input#nowface")[0].value=this.id.substr(8);
		$("img#nowfacepic")[0].src=this.src;
	});
});
