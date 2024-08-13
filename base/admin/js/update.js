<!--

$(document).ready(function(){


	//獲取更新列表
	$.ajax({
		type: "POST",
		url: "../../includes/update.php",
		data: "act=getUpdateList",
		success: function(msg){
			$("#noupdateed").html(msg);

			if($(".update_ok").size()>0){
				$(".update_ok").appendTo($("#updateed"));
				$("#updateed").show();
			}

			//if($(".update_no").size()==0){
				//$("#noupdateed").hide();
			//}

			$(".update_ok").toggle(function(){
				$(this).after($("#s"+this.id).show());
				$(this).children(".u_open")[0].className="u_close";
			},function(){
				$("#s"+this.id).hide();
				$(this).children(".u_close")[0].className="u_open";
			});

		
			$(".update_no").toggle(function(){
				$(this).after($("#s"+this.id).show());
				$(this).children(".u_open")[0].className="u_close";
			},function(){
				$("#s"+this.id).hide();
				$(this).children(".u_close")[0].className="u_open";
			});
			
				
			//安裝更新
			$(".u_inst").click(function(){
				
				var r=this.id.substr(5);
				var re=this.id.substr(0,4);
				if($("#caninstall")[0].value!="1"){
					alert("由於升級包上傳或安裝錯誤導致升級不完整，文件系統版本早於已安裝的資料庫升級，繼續安裝升級將導致資料庫錯誤，無法繼續安裝升級");
					return false;
				}
				$('#frmWindow').remove();
				$('body').append('<div id="frmWindow"><div class="topBar">升級服務驗證<div class="pwClose"></div></div><div class="border"><div class="ntc">請輸入軟體授權用戶帳號和升級密碼，若有疑問請洽詢您的服務人員：</div><div class="ntc">授權用戶：<input id="user" type="text" class="input" value="'+$('#phpwebUser')[0].value+'" /><br />授權密碼：<input id="passwd" type="password" class="input" /><br /><input id="updatebutton" type="button" class="button" value="送出"></div></div></div>');
				$.blockUI({message:$('#frmWindow'),css:{width:'320px',top:'100px'}}); 

				$('.pwClose').click(function() { 
					$.unblockUI(); 
				});

				$("#updatebutton").click(function(){
					var user=$("#user")[0].value;
					var passwd=$("#passwd")[0].value;
					if(user=="" || passwd==""){
						alert("請輸入軟體授權用戶名和密碼");
						return false;
					}else{
						$.unblockUI();
						$.blockUI({message:"<div style='background-color:#ffffff;width:260px;height:50px;text-valign:center;line-height:50px;'><img src='images/update.png' style='vertical-align:middle;'/> &nbsp;軟體系統更新中.....",css:{width:'260px',top:'100px'}});
						$.ajax({
							type: "POST",
							url: "../../includes/update.php",
							data: "act=installUpdate&r="+r+"&user="+user+"&passwd="+passwd+"&reinstall="+re,
							success: function(msg){
								if(msg=="OK"){
									window.location.reload();	
								}else{
									$.unblockUI(); 
									$(".update_err").remove();
									$("#noupdateed").prepend(msg);
								}
							}
						});

					}

				});

			});

			
			//下載伺服器更新檔
			$(".download").click(function(){
				var d=this.id.substr(5);
$('#frmWindow').remove();
				$('body').append('<div id="frmWindow"><div class="topBar">升級服務驗證<div class="pwClose"></div></div><div class="border"><div class="ntc">請輸入軟體授權用戶帳號和升級密碼，若有疑問請洽詢您的服務人員：</div><div class="ntc">授權用戶：<input id="user" type="text" class="input" value="'+$('#phpwebUser')[0].value+'" /><br />授權密碼：<input id="passwd" type="password" class="input" /><br /><input id="downloadbutton" type="button" class="button" value="送出"></div></div></div>');
				$.blockUI({message:$('#frmWindow'),css:{width:'320px',top:'100px'}}); 

				$('.pwClose').click(function() { 
					$.unblockUI(); 
				});

				$("#downloadbutton").click(function(){
					var user=$("#user")[0].value;
					var passwd=$("#passwd")[0].value;
					if(user=="" || passwd==""){
						alert("請輸入軟體授權用戶名和密碼");
						return false;
					}else{
						$.unblockUI();
						$.blockUI({message:"<div style='background-color:#ffffff;width:260px;height:50px;text-valign:center;line-height:50px;'><img src='images/update.png' style='vertical-align:middle;'/> &nbsp;更新檔文件下載中.....",css:{width:'260px',top:'100px'}}); 
						$.ajax({
							type: "POST",
							url: "../../includes/update.php",
							data: "act=downloadUpdate&r="+d+"&user="+user+"&passwd="+passwd,
							success: function(msg){
								if(msg=="OK"){
									window.location.reload();	
								}else{
									$.unblockUI();
									$(".update_err").remove();
									$("#noupdateed").prepend(msg);
								}
							}
						});

					}

				});
				
			});
		}
	});

		 


	


});




-->