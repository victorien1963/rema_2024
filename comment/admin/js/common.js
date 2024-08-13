<!--

function Dpop(url,w,h){
	res = showModalDialog(url, null, 'dialogWidth: '+w+'px; dialogHeight: '+h+'px; center: yes; resizable: no; scroll: no; status: no;');
 	if(res=="ok"){window.location.reload();}
 
}

//開設分類獨立排版
$(document).ready(function() {
	
	$(".setcattemp").click(function () { 
		obj=this.id;
		if($("#"+obj)[0].checked==true){
			qus=confirm("將分類設為獨立排版模式，可以對此分類之下的頁面進行獨立排版。確定將此分類設置為獨立排版模式嗎？")
			if(qus!=0){
				var catid=obj.substr(11);
				var pro=this.pro;
				$.ajax({
					type: "POST",
					url:"post.php",
					data: "act=addcattemp&catid="+catid,
					success: function(msg){
						if(msg=="OK"){
							$.ajax({
								type: "POST",
								url: "../../post.php",
								data: "act=plusenter",
								success: function(msg){
									if(msg=="OK"){
										var url="../class/?"+catid+".html";
										$().alertwindow("分類獨立排版模式開設成功,按確定進入排版模式,對本分類頁進行排版",url);
									}else{
										alert("分類獨立排版模式開設成功,有排版權限的管理員可以對分類頁進行排版");
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
			qus=confirm("取消分類獨立排版，會將此分類含下級分類排版刪除。確定取消獨立排版嗎？")
			if(qus!=0){
				var catid=obj.substr(11);
				$.ajax({
					type: "POST",
					url:"post.php",
					data: "act=delcattemp&catid="+catid,
					success: function(msg){
						if(msg=="OK"){
							alert("取消分類獨立排版成功!");
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
	
});


-->