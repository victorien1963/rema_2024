$(document).ready(function(){
	if($("input[name='membertypeid']:checked").val() == 1){
		$('.forc').hide();
		$('.forp').show();
	}else{
		$('.forp').hide();
		$('.forc').show();
	}
	$('#membertypeid2').click(function(){
		$('.forp').hide();
		$('.forc').show();
	});
	$('#membertypeid1').click(function(){
		$('.forc').hide();
		$('.forp').show();
	});
	
	$(document).on("change", "#selcountry", function () {
		$("#addr").val("");
		$("#postcode").val("");
		$("#zoneid").html("");
		var p = this.value.split("_");
			$.ajax({
					type: "POST",
					url: PDV_RP+"member/post.php",
					data: "act=getzonelist&pid="+p[1],
					success: function(msg){
						pList.data = new Array();
						$("#zonelist").html(msg);
						if(PDV_LAN == "en"){
							var constr = "Please Select";
						}else if(PDV_LAN == "zh_cn"){
							var constr = "请选择";
						}else{
							var constr = "請選擇";
						}
						$("#Province").html("<option value='s'> "+constr+"</option>"+pList.getOptionString('s'));
						//$('#Province').selectpicker('refresh');
					}
				
			 });
	});
	
	$(document).on("change", "#selcountry2", function () {
		$("#saddr").val("");
		$("#spostcode").val("");
		$("#szoneid").html("");
		var p = this.value.split("_");
		
			$.ajax({
					type: "POST",
					url: PDV_RP+"member/post.php",
					data: "act=getzonelist&pid="+p[1],
					success: function(msg){
						pList.data = new Array();
						$("#zonelist").html(msg);
						if(PDV_LAN == "en"){
							var constr = "Please Select";
						}else if(PDV_LAN == "zh_cn"){
							var constr = "请选择";
						}else{
							var constr = "請選擇";
						}
						$("#sProvince").html("<option value='s'> "+constr+"</option>"+pList.getOptionString('s'));
						//$('#Province').selectpicker('refresh');
					}
				
			 });
	});
	
	$(document).on("click", ".deltaddr", function () {
		
		var aid = this.id.substr(5);
		
		if(PDV_LAN == "en"){
			var constr = "Are you sure to delete this contact?";
		}else if(PDV_LAN == "zh_cn"){
			var constr = "确实删除这个地址？";
		}else{
			var constr = "確定刪除這個地址？";
		}
		
		
		
		if(confirm(constr))
		{
			$.ajax({
					type: "POST",
					url: PDV_RP+"member/post.php",
					data: "act=deltaddr&aid="+aid,
					success: function(msg){
						if(msg=="OK"){
							$('#ad_'+aid).remove();
						}else{
							alert(msg);
						}
					}
			 });
		}
		else
		{
			
		}
	});
	
	$(document).on("click", ".modiaddr", function () {
		$('div#addrnotice').hide();
		var aid = this.id.substr(5);
		$.ajax({
				type: "POST",
				url: PDV_RP+"member/post.php",
				data: "act=modiaddr&aid="+aid,
				success: function(msg){
					eval(msg);
					pList.data = new Array();
					$("#zonelist").html(M.H);
					$("#sname")[0].value=M.N;
					$("#stel")[0].value=M.T;
					$("#smov")[0].value=M.M;
					$("#saddr")[0].value=M.A;
					$("#spostcode")[0].value=M.P;
					$("#aid")[0].value=M.D;
					$("#selcountry2").html(M.C);
					$("#sProvince").html(pList.getOptionString(M.V));
					$("#szoneid").html(pList.getOptionAreasString(addrform.sProvince.value,addrform.szoneid,M.Z,1));
				}
		 });
		
	});
	
});
//會員表單校驗

$(document).ready(function(){

	$('#user').focus(function(){ 
		$('#chkUser').remove();
		//$('#user').after('<span id="chkUser" class="msgdiv">登入帳號由5-20個英文字母或數字組成</span>');
	}); 
	
	$('#user').blur(function(){ 
		var p=$("#user")[0].value;
		var patrn=/^(\w){5,20}$/;
		if(!patrn.exec(p)){
			$('#chkUser').remove();
			//$('#user').after('<span id="chkUser" class="errdiv">登入帳號必須由5-20個英文字母或數字組成</span>');
		}else{

			$.ajax({
					type: "POST",
					url: PDV_RP+"member/post.php",
					data: "act=checkuser&user="+p,
					success: function(msg){
						
						if(msg=="1"){
							$('#chkUser').remove();
							//$('#user').after('<span id="chkUser" class="rightdiv">該登入帳號可以使用</span>');
						}else{
							$('#chkUser').remove();
							//$('#user').after('<span id="chkUser" class="errdiv">該登入帳號已經被使用，請更換一個</span>');
						}
					}
				
			 });
			
		}
	}); 


	$('#password').focus(function(){ 
		$('#chkPass').remove();
		//$('#password').after('<span id="chkPass" class="msgdiv">登入密碼由5-20個英文字母或數字組成</span>');
	}); 


	$('#password').blur(function(){ 
		var p=$("#password")[0].value;
		var patrn=/^(\w){5,20}$/;
		if(!patrn.exec(p)){
			$('#chkPass').remove();
			//$('#password').after('<span id="chkPass" class="errdiv">登入密碼必須由5-20個英文字母或數字組成</span>');
		}else{
			$('#chkPass').remove();
			//$('#password').after('<span id="chkPass" class="rightdiv">該登入密碼可以使用</span>');
		}
	}); 

	$('#repass').focus(function(){ 
		$('#chkRepass').remove();
		//$('#repass').after('<span id="chkRepass" class="msgdiv">請重複輸入和上面相同的密碼</span>');
	}); 

	$('#repass').blur(function(){ 
		var p=$("#repass")[0].value;
		var w=$("#password")[0].value;
		var patrn=/^(\w){5,20}$/;
		if(!patrn.exec(p)){
			$('#chkRepass').remove();
			//$('#repass').after('<span id="chkRepass" class="errdiv">登入密碼必須由5-20個英文字母或數字組成</span>');
		}else if(p!=w){
			$('#chkRepass').remove();
			//$('#repass').after('<span id="chkRepass" class="errdiv">兩次輸入的密碼不一致，請輸入和上面相同的密碼</span>');
		}else{
			$('#chkRepass').remove();
			//$('#repass').after('<span id="chkRepass" class="rightdiv">輸入正確</span>');
		}
	}); 

	$('#email').focus(function(){ 
		$('#chkEmail').remove();
		//$('#email').after('<span id="chkEmail" class="msgdiv">請輸入正確的電子郵件</span>');
	}); 

	$('#email').blur(function(){ 
		var p=$("#email")[0].value;
		var patrn=/^[_.0-9a-z-]+@([0-9a-z][0-9a-z-]+.)+[a-z]{2,3}$/;
		if(!patrn.exec(p)){
			$('#chkEmail').remove();
			//$('#email').after('<span id="chkEmail" class="errdiv">電子郵件格式不正確，請輸入正確的電子郵件</span>');
		}else{
			$('#chkEmail').remove();
			//$('#email').after('<span id="chkEmail" class="rightdiv">輸入正確</span>');
		}
	}); 


	$('#ImgCode').focus(function(){ 
		$('#chkCode').remove();
		//$('#getImgCode').after('<span id="chkCode" class="msgdiv">請輸入和圖片上一致的驗證碼</span>');
	}); 

	$('#ImgCode').blur(function(){
		var p=$("#ImgCode")[0].value;
		if(p==''){
			$('#chkCode').remove();
			$('#getImgCode').after('<span id="chkCode" class="errdiv">請輸入和圖片上一致的驗證碼</span>');
		}else{

			$.ajax({
					type: "POST",
					url: PDV_RP+"post.php",
					data: "act=imgcode&codenum="+p,
					success: function(msg){
						if(msg=="1"){
							$('#chkCode').remove();
							$('#getImgCode').after('<span id="chkCode" class="rightdiv">輸入正確</span>');
						}else{
							$('#chkCode').remove();
							$('#getImgCode').after('<span id="chkCode" class="errdiv">請輸入和圖片上一致的驗證碼</span>');
						}
					}
				
			 });

		}
	}); 



	$('#pname').focus(function(){ 
		$('#chkPname').remove();
		//$('#pname').after('<span id="chkPname" class="msgdiv">網名暱稱可以是中文、英文或數字</span>');
	}); 

	$('#pname').blur(function(){
		var p=$("#pname")[0].value;
		if(p.length<1){
			$('#chkPname').remove();
			//$('#pname').after('<span id="chkPname" class="errdiv">請輸入網名暱稱</span>');
		}else{
			$('#chkPname').remove();
			//$('#pname').after('<span id="chkPname" class="rightdiv">輸入正確</span>');
		}

	}); 


	$('#name').focus(function(){ 
		$('#chkName').remove();
		//$('#name').after('<span id="chkName" class="msgdiv">請輸入您的姓名</span>');
	}); 

	$('#name').blur(function(){
		var p=$("#name")[0].value;
		if(p.length<4){
			$('#chkName').remove();
			//$('#name').after('<span id="chkName" class="errdiv">請輸入您的姓名</span>');
		}else{
			$('#chkName').remove();
			//$('#name').after('<span id="chkName" class="rightdiv">輸入正確</span>');
		}

	}); 

	//公司
	$('#company').focus(function(){ 
		$('#chkCompany').remove();
		//$('#company').after('<span id="chkCompany" class="msgdiv">請填寫公司名稱,個人用戶請填姓名</span>');
	}); 

	$('#company').blur(function(){
		var p=$("#company")[0].value;
		if(p.length<2){
			$('#chkCompany').remove();
			//$('#company').after('<span id="chkCompany" class="errdiv">請填寫公司名稱,個人用戶請填姓名</span>');
		}else{
			$('#chkCompany').remove();
			//$('#company').after('<span id="chkCompany" class="rightdiv">輸入正確</span>');
		}

	}); 



	$('#tel').focus(function(){ 
		$('#chkTel').remove();
		//$('#tel').after('<span id="chkTel" class="msgdiv">請輸入室內電話號碼，格式如：02-12345678</span>');
	}); 

	$('#tel').blur(function(){
		var p=$("#tel")[0].value;
		if(p==''){
			$('#chkTel').remove();
		}else{
			var patrn=/^[_.0-9a-z-]+-([0-9a-z][0-9a-z-])+[0-9]{4,8}$/;
			if(!patrn.exec(p)){
				$('#chkTel').remove();
				//$('#tel').after('<span id="chkTel" class="errdiv">請輸入正確的室內電話號碼，格式如：02-12345678</span>');
			}else{
				$('#chkTel').remove();
				//$('#tel').after('<span id="chkTel" class="rightdiv">輸入正確</span>');
				
			}
		}

	}); 
	
	$('#mov').focus(function(){ 
		$('#chkMov').remove();
		//$('#mov').after('<span id="chkMov" class="msgdiv">請輸入手機號碼，如：0989123456</span>');
	}); 

	$('#mov').blur(function(){
		var p=$("#mov")[0].value;
		if(p==''){
			$('#chkMov').remove();
		}else if(p.length<10){
			$('#chkMov').remove();
			//$('#mov').after('<span id="chkMov" class="errdiv">請輸入正確的手機號碼，如：0989123456</span>');
		}else{
			$('#chkMov').remove();
			//$('#mov').after('<span id="chkMov" class="rightdiv">輸入正確</span>');
		}

	}); 
  
});



//會員資料修改表單送出
$(document).ready(function(){
	
	$('#memberModifyFirst').submit(function(){ 
		var p=$("#password")[0].value;
		if(p.length<1){
			alert("請輸入密碼！");
			return false;
		}
	});
	
	
	//$('#memberModify').submit(function(){ 
	$(document).on("submit", "#memberModify", function () {
		$('#memberModify').ajaxSubmit({
			url: PDV_RP+"member/post.php",
			success: function(msg) {
				if(msg=="OK"){
					if(PDV_LAN == "en"){
						LoadMsg("Modify Successful!");
					}else if(PDV_LAN == "zh_cn"){
						LoadMsg("信息修改成功！");
					}else{
						LoadMsg("資料修改成功！");
					}
					if( $("#mov").val() != "" ){
						$("#showmov").text($("#mov").val());
					}
					$(".inputsy").val("");
				}else if(msg=="OKADD"){
					var REF = $("#REF").val();
					$('div#notice')[0].className='alert alert-success';
					if(PDV_LAN == "en"){
						LoadMsg("Add Successful!");
						if(REF != ""){
							window.location = REF;
						}
					}else if(PDV_LAN == "zh_cn"){
						LoadMsg("通讯录新增成功！");
						if(REF != ""){
							window.location = REF;
						}
					}else{
						LoadMsg("通訊錄新增成功！");
						if(REF != ""){
							window.location = REF;
						}
					}
					if(REF == ""){
						//setTimeout('window.location=PDV_RP+\'member/member_contact.php\';',500);
					}
				}else{
					LoadMsg(msg);
				}
			}
		}); 
       return false; 
   });
   
   	//改由 popupwindows.js執行
	/*$(document).on("submit", "#AddAddr", function () {
		
		var G_addr = $("#addr").val();
		var G_name = $("#name").val();
		var G_mov = $("#mov").val();
		
		if(G_addr==""){
			alert("請填寫地址");
			return false;
		}
		if(G_name==""){
			alert("請填寫姓名");
			return false;
		}
		if(G_mov==""){
			alert("請填寫手機號碼");
			return false;
		}
		
		$('#AddAddr').ajaxSubmit({
			url: PDV_RP+"member/post.php",
			success: function(msg) {
				if(msg=="OK"){
					if(PDV_LAN == "en"){
						LoadMsg("Modify Successful!");
					}else if(PDV_LAN == "zh_cn"){
						LoadMsg("信息修改成功！");
					}else{
						LoadMsg("資料修改成功！");
					}
				}else if(msg=="OKADD"){
					if(PDV_LAN == "en"){
						LoadMsg("Add Successful!");
						 window.location.reload();
					}else if(PDV_LAN == "zh_cn"){
						LoadMsg("通讯录新增成功！");
						 window.location.reload();
					}else{
						LoadMsg("通訊錄新增成功！");
						 window.location.reload();
					}
					if(REF == ""){
						//setTimeout('window.location=PDV_RP+\'member/member_contact.php\';',500);
					}
				}else{
					LoadMsg(msg);
				}
			}
		}); 
       return false; 
   });*/
   
	$('#memberModifyPass').submit(function(){ 
		$('#memberModifyPass').ajaxSubmit({
			url: PDV_RP+"member/post.php",
			success: function(msg) {
				if(msg=="OK"){
					if(PDV_LAN == "en"){
						LoadMsg("Modify Successful!");
					}else if(PDV_LAN == "zh_cn"){
						LoadMsg("信息修改成功！");
					}else{
						LoadMsg("資料修改成功！");
					}
					$(".inputsy").val("");
				}else{
					LoadMsg(msg);
				}
			}
		}); 
       return false; 
   });
   
	$('#memberModifyEmail').submit(function(){ 
		$('#memberModifyEmail').ajaxSubmit({
			url: PDV_RP+"member/post.php",
			success: function(msg) {
				if(msg=="OK"){
					if(PDV_LAN == "en"){
						LoadMsg("Modify Successful!");
					}else if(PDV_LAN == "zh_cn"){
						LoadMsg("信息修改成功！");
					}else{
						LoadMsg("資料修改成功！");
					}
					if( $("#newemail").val() != "" ){
						$("#smail").text($("#newemail").val());
					}
					$(".inputsy").val("");
				}else{
					LoadMsg(msg);
				}
			}
		}); 
       return false; 
   });
   
	$('#memberModifymobi').submit(function(){
		var REF = $("#REF").prop("href");
		$('#memberModifymobi').ajaxSubmit({
			target: 'div#notice',
			url: PDV_RP+"member/post.php",
			success: function(msg) {
				if(msg=="OK"){
					$('div#notice')[0].className='alert alert-success';
					if(PDV_LAN == "en"){
						LoadMsg("Modify Successful!");
						if(REF != ""){
							window.location = REF;
						}
					}else if(PDV_LAN == "zh_cn"){
						LoadMsg("信息修改成功！");
						if(REF != ""){
							window.location = REF;
						}
					}else{
						LoadMsg("資料修改成功！");
						if(REF != ""){
							window.location = REF;
						}
					}
					$('div#notice').show();
					if(REF == ""){
						setTimeout('$(\'div#notice\').fadeOut(1000);',500);
					}
				}else if(msg=="OKADD"){
					$('div#notice')[0].className='alert alert-success';
					if(PDV_LAN == "en"){
						LoadMsg("Add Successful!");
						if(REF != ""){
							window.location = REF;
						}
					}else if(PDV_LAN == "zh_cn"){
						LoadMsg("通讯录新增成功！");
						if(REF != ""){
							window.location = REF;
						}
					}else{
						LoadMsg("通訊錄新增成功！");
						if(REF != ""){
							window.location = REF;
						}
					}
					
					
					$('div#notice').show();	
					if(REF == ""){				
						setTimeout('window.location=PDV_RP+\'member/member_contact.php\';',500);
					}
				}else{
					$('div#notice')[0].className='alert alert-danger';
					$('div#notice').show();
				}
			}
		}); 
       return false; 
   });
   
	/*$(document).on("submit", "#memberAddrModify", function () {

		$('#memberAddrModify').ajaxSubmit({
			url: PDV_RP+"member/post.php",
			success: function(msg) {
				if(msg=="OK"){
					if(PDV_LAN == "en"){
						LoadPopup("ModifyOk");
						$("#seladdr").trigger('change');
					}else if(PDV_LAN == "zh_cn"){
						LoadPopup("ModifyOk");
						$("#seladdr").trigger('change');
					}else{
						LoadPopup("ModifyOk");
						$("#seladdr").trigger('change');
					}
				}else{
					alert(msg);
				}
			}
		}); 
       return false; 
   }); */
   
});


//頭像設置
$(document).ready(function(){
	$(".selface").click(function(){
		$("input#nowface")[0].value=this.id.substr(8);
		$("img#nowfacepic")[0].src=this.src;
	});
});

