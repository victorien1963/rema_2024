//讀取參數列(function($){	$.fn.getPropList = function(){				$("div#proplist").empty();				var catid=$("#selcatid")[0].value;		var nowid=$("#nowid")[0].value;						$.ajax({			type: "POST",			url:"post.php",			data: "act=proplist&catid="+catid+"&nowid="+nowid,			success: function(msg){				$("div#proplist").append(msg);				setTimeout(function () {                     window.parent.doIframe();                 }, 0);			}		});	};})(jQuery);

//讀取多語言參數列
(function($){
	$.fn.getLanPropList = function(){
			
		var catid=$("#selcatid").val();
		var nowid=$("#nowid").val();
		
		var getlanglist = $("#langlist").val();
		var langlist = getlanglist.split(",");
		
		for (var i=0; i<langlist.length; i++){
			$("div#proplist_"+langlist[i]).empty();
			var thislang = langlist[i];
			$.ajax({
				type: "POST",
				url:"post.php",
				data: "act=lanproplist&catid="+catid+"&nowid="+nowid+"&lang="+thislang,
				success: function(msg){
					eval(msg);
					$("div#proplist_"+M.LANG).append(M.STR);
					setTimeout(function () {
	                     window.parent.doIframe();
	                 }, 0);
				}
			});
		}
	};
})(jQuery);

//選擇分類時更新屬性列$(document).ready(function() {		$("#selcatid").change(function(){			$().getPropList();			$().getLanPropList();		});});//電子報修改表單送出$(document).ready(function(){
	$('#paperForm').submit(function(){
			//正常送出修改
			$("#act")[0].value="papermodify";
				
			$('#paperForm').ajaxSubmit({
				target: 'div#notice',
				url: 'post.php',
				success: function(msg) {
					if(msg=="OK"){
						$('div#notice').hide();
						$().alertwindow("電子報修改成功","index.php");
					}else{
						$('div#notice').hide();
						$().alertwindow(msg,"");
					}
				}
			});        return false; 
   });
});

//電子報發佈表單送出$(document).ready(function(){
	$('#paperAddForm').submit(function(){
		/*SelectAll('spe_selec[]', 'select[]');*/
		$('#paperAddForm').ajaxSubmit({			target: 'div#notice',
			url: 'post.php',
			success: function(msg) {
				if(msg=="OK"){
					$('div#notice').hide();
					$().alertwindow("電子報新增成功","index.php");
				}else{
					$('div#notice').hide();
					$().alertwindow(msg,"");
				}
			}
		}); 
       return false; 
   }); 
});
//添加專題表單送出
$(document).ready(function(){
	$('#addProjForm').submit(function(){		$('#addProjForm').ajaxSubmit({			target: 'div#notice',
			url: 'post.php',			success: function(msg) {
				if(msg=="OK"){					$('div#notice').hide();
					$.ajax({
						type: "POST",
						url: "../../post.php",
						data: "act=plusenter",
						success: function(msg){							if(msg=="OK"){
								var projpath="../project/"+$("#newfolder")[0].value;
								$().alertwindow("專題添加成功,按確定進入排版模式,對本專題主頁進行排版",projpath);
							}else{
								self.location='paper_proj.php';
							}
						}
					});
				}else{
					$('div#notice').hide();
					$().alertwindow(msg,"");
				}
			}
		}); 
       return false; 
   }); 
});//切換到專題排版$(document).ready(function() {
	$(".pdv_enter").click(function () { 
		var folder=this.id.substr(3);
		var pro=this.pro;
		$.ajax({
			type: "POST",
			url: "../../post.php",
			data: "act=plusenter",
			success: function(msg){
				if(msg=="OK"){
					self.location="../project/"+folder+"/index.php";
				}else{
					$().alertwindow("目前的管理帳戶沒有排版權限","");
					return false;
				}
			}
		});
	 });
});//發送電子報$(document).ready(function(){	$(".papermail").click(function(){			var paperid=this.id.substr(10);		$('#frmWindow').remove();		$("body").append("<div id='frmWindow'></div>");		$('#frmWindow').append('<div class="topBar">電子報發送<div class="pwClose"></div></div><div class="border"><iframe frameborder="0" scrolling="yes" src="paper_email.php?paperid='+paperid+'" class="Frm"></iframe></div>');		$.blockUI({message:$('#frmWindow'),css:{width:'650px',top:'10px'}}); 		$('.pwClose').click(function() { 			$.unblockUI(); 		}); 	});});//分類表單
function catCheckform(theform){
  if(theform.cat.value.length < 1 || theform.cat.value=='請填寫分類名稱'){
	$().alertwindow("請填寫分類名稱","");
    theform.cat.focus();
    return false;
}  	return true;
}
//彈出對話框
function Dpop(url,w,h){
	res = showModalDialog(url, null, 'dialogWidth: '+w+'px; dialogHeight: '+h+'px; center: yes; resizable: no; scroll: no; status: no;');
 	if(res=="ok"){window.location.reload();}
}//切換到分類排版$(document).ready(function() {		$(".pr_enter").click(function () { 		var catid=this.id.substr(3);		var url=$("#href_"+catid)[0].value;		$.ajax({			type: "POST",			url: "../../post.php",			data: "act=plusenter",			success: function(msg){				if(msg=="OK"){					self.location=url;				}else{					$().alertwindow("目前的管理帳戶沒有排版權限","");					return false;				}			}		});			 });	});//開設分類專欄$(document).ready(function() {		$(".setchannel").click(function () { 		obj=this.id;		if($("#"+obj)[0].checked==true){			$().confirmwindow("將分類設為專欄，將創建一個專欄目錄及專欄首頁，可以單獨對專欄首頁進行排版。確定將此分類設置為專欄嗎？", function(result) {				var catid=obj.substr(11);				var pro=this.pro;				$.ajax({					type: "POST",					url:"post.php",					data: "act=addzl&catid="+catid,					success: function(msg){						if(msg=="OK"){							$.ajax({								type: "POST",								url: "../../post.php",								data: "act=plusenter",								success: function(msg){									if(msg=="OK"){										var url="../class/"+pro+"/"+catid+"/";										$().alertwindow("分類專欄開設成功,按確定進入排版模式,對本專欄主頁進行排版",url);									}else{										$().alertwindow("分類專欄開設成功,按確定進入排版模式,對本專欄主頁進行排版","");										return false;									}								}							});													}else{							$().alertwindow(msg,"");						}					}				});				$("#"+obj)[0].checked=true;			});				$("#"+obj)[0].checked=false;		}else{			$().confirmwindow("取消分類專欄，將刪除專欄首頁及其目錄。確定取消專欄嗎？", function(result) {				var catid=obj.substr(11);				$.ajax({					type: "POST",					url:"post.php",					data: "act=delzl&catid="+catid,					success: function(msg){						if(msg=="OK"){							var url="../class/?"+catid+".html";							var str="<a href='"+url+"' target='_blank'>paper/class/?"+catid+".html</a>";							$("input#href_"+catid)[0].value=url;							$("td#url_"+catid).html(str);						}else{							$().alertwindow(msg,"");						}					}				});				$("#"+obj)[0].checked=false;			});				$("#"+obj)[0].checked=true;		}	 });	});//開設分類獨立排版$(document).ready(function() {		$(".setcattemp").click(function () { 		obj=this.id;		if($("#"+obj)[0].checked==true){			$().confirmwindow("將分類設為獨立排版模式，可以對此分類之下的頁面進行獨立排版。確定將此分類設置為獨立排版模式嗎？", function(result) {				var catid=obj.substr(11);				var pro=this.pro;				$.ajax({					type: "POST",					url:"post.php",					data: "act=addcattemp&catid="+catid,					success: function(msg){						if(msg=="OK"){							$.ajax({								type: "POST",								url: "../../post.php",								data: "act=plusenter",								success: function(msg){									if(msg=="OK"){										var url="../class/?"+catid+".html";										$().alertwindow("分類獨立排版模式開設成功,按確定進入排版模式,對本分類頁進行排版",url);									}else{										$().alertwindow("分類獨立排版模式開設成功,有排版權限的管理員可以對分類頁進行排版","");										return false;									}								}							});													}else{							$().alertwindow(msg,"");						}					}				});				$("#"+obj)[0].checked=true;							});			$("#"+obj)[0].checked=false;					}else{			$().confirmwindow("取消分類獨立排版，會將此分類的排版刪除。確定取消獨立排版嗎？", function(result) {				var catid=obj.substr(11);				$.ajax({					type: "POST",					url:"post.php",					data: "act=delcattemp&catid="+catid,					success: function(msg){						if(msg=="OK"){							$().alertwindow("取消分類獨立排版成功!","");						}else{							$().alertwindow(msg,"");						}					}				});				$("#"+obj)[0].checked=false;			});				$("#"+obj)[0].checked=true;		}	 });	});//停止 / 繼續 寄信排程
$(document).ready(function(){
	$('.stopcron').click(function(){
		var cid = $(this).val();
		if(confirm("確定要停止寄信排程嗎？\n停止後再繼續，會延遲 3分鐘動作")){
			
			$.ajax({
				type: "POST",
				url:"post.php",
				data: "act=stopcron&cid="+cid,
				success: function(msg){
					if(msg=="OK"){
						$().alertwindow("本排程已停止","paper_cron.php");
					}else if(msg=="1001"){
						$().alertwindow("遠端伺服器無資料，排程停止","paper_cron.php");
					}else{
						$().alertwindow(msg,"paper_cron.php");
					}
				}
			});
		}else{
			return false; 
		}
		
		return false;
   });
   
   $('.conticron').click(function(){
		var cid = $(this).val();
		if(confirm("確定要繼續寄信排程嗎？\n繼續後，會在下一個小時繼續執行...")){
			
			$.ajax({
				type: "POST",
				url:"post.php",
				data: "act=conticron&cid="+cid,
				success: function(msg){
					if(msg=="OK"){
						$().alertwindow("本排程會在下一個小時繼續執行","paper_cron.php");
					}else if(msg=="1001"){
						$().alertwindow("目前有其他排程進行中，無法繼續排程","paper_cron.php");
					}else if(msg=="1002"){
						$().alertwindow("該篇電子報已經刪除，無法繼續排程","paper_cron.php");
					}else{
						$().alertwindow(msg,"paper_cron.php");
					}
				}
			});
		}else{
			return false; 
		}
		
		return false;
   }); 
});