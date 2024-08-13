<!--


//開設分類獨立排版
$(document).ready(function() {
	
	$(".setcattemp").click(function () { 
		obj=this.id;
		if($("#"+obj)[0].checked==true){
			qus=confirm("將表單頁面設為獨立排版模式，可以對此表單的頁面進行獨立排版。確定將此表單設置為獨立排版模式嗎？")
			if(qus!=0){
				var groupid=obj.substr(11);
				var pro=this.pro;
				$.ajax({
					type: "POST",
					url:"post.php",
					data: "act=addcattemp&groupid="+groupid,
					success: function(msg){
						if(msg=="OK"){
							$.ajax({
								type: "POST",
								url: "../../post.php",
								data: "act=plusenter",
								success: function(msg){
									if(msg=="OK"){
										var url="../index.php?groupid="+groupid;
										$().alertwindow("表單獨立排版模式開設成功,按確定進入排版模式,對本表單頁進行排版",url);
									}else{
										alert("表單獨立排版模式開設成功,有排版權限的管理員可以對表單頁進行排版");
										return false;
									}
								}
							});
							
						}else{
							alert(msg);
						}
					}
				});
				$("#"+obj)[0].checked=true;
			}else{
				$("#"+obj)[0].checked=false;
			}
		}else{
			qus=confirm("取消表單獨立排版，則此表單排版將一律刪除。確定取消獨立排版嗎？")
			if(qus!=0){
				var groupid=obj.substr(11);
				$.ajax({
					type: "POST",
					url:"post.php",
					data: "act=delcattemp&groupid="+groupid,
					success: function(msg){
						if(msg=="OK"){
							alert("取消表單獨立排版成功!");
						}else{
							alert(msg);
						}
					}
				});
				$("#"+obj)[0].checked=false;
			}else{
				$("#"+obj)[0].checked=true;
			}
		}
	 });
	

$(".membermail").click(function(){
	
		var fid=this.id.substr(11);
		$('#frmWindow').remove();
		$("body").append("<div id='frmWindow'></div>");
		$('#frmWindow').append('<div class="topBar">聯絡表單信件傳送<div class="pwClose"></div></div><div class="border"><iframe frameborder="0" scrolling="yes" src="fb_email.php?fid='+fid+'" class="Frm"></iframe></div>');
		$.blockUI({message:$('#frmWindow'),css:{width:'850px',top:'10px'}}); 
		$('.pwClose').click(function() { 
			$.unblockUI(); 
		}); 
	});
	
	
	
});
-->