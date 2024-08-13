

//讀取參數列
(function($){
	$.fn.getPropList = function(){
		
		$("div#proplist").empty();
		
		var catid=$("#selcatid")[0].value;
		var nowid=$("#nowid")[0].value;
		
		
		$.ajax({
			type: "POST",
			url:"post.php",
			data: "act=proplist&catid="+catid+"&nowid="+nowid,
			success: function(msg){
				$("div#proplist").append(msg);
				setTimeout(function () {
                     window.parent.doIframe();
                 }, 0);
			}
		});
	};
})(jQuery);

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

//讀取內容翻頁碼
(function($){
	$.fn.getNewsPages = function(p){
		
		$("div#newspages").empty();
		
		var nowid=$("#nowid")[0].value;

		$.ajax({
			type: "POST",
			url:"post.php",
			data: "act=newspageslist&nowid="+nowid+"&pageinit="+p,
			success: function(msg){
				$("div#newspages").append(msg);
				
				var nowpagesid=$("input#newspagesid")[0].value;
				$("button#p_"+nowpagesid)[0].className='btn btn-warning';

				var getObj = $('button.pages');
				getObj.each(function(id) {
					var obj = this.id;
					
					$("button#"+obj).click(function() {
						
						var clickid=obj.substr(2);
						
						if(clickid==0){
							//editor.remove();
							$(".newsaddzone").hide();
							var getlanglist = $("#langlist").val();
							var langlist = getlanglist.split(",");
							
							/*for (var i=0; i<langlist.length; i++){
								KindEditor.remove('#sbodys_'+langlist[i]);
							}*/
							$(".newsmodizone").show();
							$("button#adminsubmit").show();
							//$().getContent(0);
							$().getNewsPages(0);
							setTimeout(function () {
				                     window.parent.doIframe();
				                 }, 0);
						}else{
							$(".newsaddzone").show();
							$(".newsmodizone").hide();
							$("button#adminsubmit").hide();
							$().getContent(clickid);
							$().getLanContent(clickid);							
							$().getNewsPages(clickid);
							//if(typeof(editor) != "undefined"){ editor.remove(); }
						}
					});
				});

				//返回正常模式
				$("button#backtomodi").click(function() {
					
					editor.remove();
					var getlanglist = $("#langlist").val();
					var langlist = getlanglist.split(",");
					
					/*for (var i=0; i<langlist.length; i++){
						KindEditor.remove('#sbodys_'+langlist[i]);
					}*/
					$(".newsmodizone").show();
					$("button#adminsubmit").show();
					//$().getContent(0);
					$().getNewsPages(0);
					
					setTimeout(function () {
                     window.parent.doIframe();
                 	}, 0);

				});
				
				//添加分頁
				$("button#addpage").click(function(){

					$.ajax({
						type: "POST",
						url:"post.php",
						data: "act=addpage&nowid="+nowid,
						success: function(msg){
							if(typeof(editor) != "undefined"){ editor.remove(); }
							$().getNewsPages('new');
							$(".newsmodizone").hide();
							$("button#adminsubmit").hide();
							$().getContent(-1);
							$().getLanContent(-1);	
						}
					});
				});

				//刪除目前頁
				$("button#pagedelete").click(function(){

					var delpagesid=$("input#newspagesid")[0].value;
					
					$.ajax({
						type: "POST",
						url:"post.php",
						data: "act=pagedelete&nowid="+nowid+"&delpagesid="+delpagesid,
						success: function(msg){
							if(msg=="0"){
								/*if(typeof(editor) != "undefined"){ editor.remove(); }
								var getlanglist = $("#langlist").val();
								var langlist = getlanglist.split(",");
								
								for (var i=0; i<langlist.length; i++){
									KindEditor.remove('#sbodys_'+langlist[i]);
								}*/
								//分頁全部刪除時返回正常模式
								$(".newsmodizone").show();
								$("button#adminsubmit").show();
								//$().getContent(0);
								$().getNewsPages(0);
								setTimeout(function () {
				                     window.parent.doIframe();
				                 }, 0);
							}else{
								//editor.remove();
								$(".newsaddzone").show();
								var getlanglist = $("#langlist").val();
								var langlist = getlanglist.split(",");
								
								/*for (var i=0; i<langlist.length; i++){
									KindEditor.remove('#sbodys_'+langlist[i]);
								}*/
								$(".newsmodizone").hide();
								$("button#adminsubmit").hide();
								$().getContent(msg);
								$().getLanContent(msg);	
								$().getNewsPages(msg);
							}
							
						}
					});
				});
			}
		});
	};

	
	

})(jQuery);


//讀取詳細內容
(function($){
	$.fn.getContent = function(newspageid){
		
		var nowid=$("#nowid")[0].value;
		$.ajax({
			type: "POST",
			url:"post.php",
			data: "act=getcontent&newspageid="+newspageid+"&nowid="+nowid,
			success: function(msg){
				
				if(msg!=""){
					$("#showsubpic")[0].src="../../"+msg;
					$("#showsubpic").show();
					$("#showsubpic")[0].style.width="";
					$("#showsubpic").load(function(){
						if($("#showsubpic")[0].offsetWidth>500){
							$("#showsubpic")[0].style.width="500px";
						}
					});	
				}else{
					$("#showsubpic").hide();
				}
				/*$.getScript("../../../kedit/kindeditor_up.js", function() {
						editor = KindEditor.create('textarea[name="bodys"]', {
						uploadJson : '../../kedit/php/upload_json.php?attachPath=news/pics/',
						fileManagerJson : '../../kedit/php/file_manager_json.php?attachPath=news/upload/',
						height : 480,
						allowFlashUpload : false,
						allowMediaUpload : false,
						allowFileManager : true,
						langType : 'zh_TW',
						syncType: '',
						afterBlur: function () { editor.sync(); }
						});
						editor.html(msg);
						editor.sync();
								setTimeout(function () {
				                     window.parent.doIframe();
				                 }, 0);
					});*/

					
			}
		});
	};
})(jQuery);

//讀取多國語詳細內容
(function($){
	$.fn.getLanContent = function(newspageid){
		
		var nowid=$("#nowid").val();
		var getlanglist = $("#langlist").val();
		var langlist = getlanglist.split(",");
		
		for (var i=0; i<langlist.length; i++){
			var thislang = langlist[i];
			$.ajax({
				type: "POST",
				url:"post.php",
				data: "act=getlancontent&newspageid="+newspageid+"&nowid="+nowid+"&lang="+thislang,
				success: function(msg){
					eval(msg);
					var editors = new Array();
					$.getScript("../../../kedit/kindeditor_up.js", function() {
							editors[M.LANG] = KindEditor.create('#sbodys_'+M.LANG+'', {
							uploadJson : '../../kedit/php/upload_json.php?attachPath=news/pics/',
							fileManagerJson : '../../kedit/php/file_manager_json.php?attachPath=news/upload/',
							height : 480,
							allowFlashUpload : false,
							allowMediaUpload : false,
							allowFileManager : true,
							langType : 'zh_TW',
							syncType: '',
							afterBlur: function () { editors[M.LANG].sync(); }
							});
							editors[M.LANG].html(M.STR);
							editors[M.LANG].sync();
									setTimeout(function () {
					                     window.parent.doIframe();
					                 }, 0);
						});

						
				}
			});
		}
	};
})(jQuery);


//選擇分類時更新屬性列
$(document).ready(function() {
		$("#selcatid").change(function(){
			$().getPropList();
			$().getLanPropList();
		});
});


//文章修改表單送出
$(document).ready(function(){
	
	$('#newsForm').submit(function(){

		if($("#newspagesid")[0].value=="0"){
			
			//正常送出修改
			
			$("#act").val("newsmodify");
			/*SelectAll('spe_selec[]', 'select[]');*/
				

			$('#newsForm').ajaxSubmit({
				target: 'div#notice',
				url: 'post.php',
				success: function(msg) {
					if(msg=="OK"){
						$('div#notice').hide();
						$().alertwindow("文章修改成功","index.php");
						
					}else{
						$('div#notice').hide();
						$().alertwindow(msg,"");
					}
				}
			}); 
		
		}else{
			
			//翻頁內容只更新body
			$("#act")[0].value="contentmodify";

			$('#newsForm').ajaxSubmit({
				target: 'div#notice',
				url: 'post.php',
				success: function(msg) {
					if(msg=="OK"){
						$('div#notice').hide();
						//$().alertwindow("分頁內容已保存","");
						var nowpagesid=$("input#newspagesid")[0].value;
						$().getContent(nowpagesid);
					}else{
						$('div#notice').hide();
						$().alertwindow(msg,"");
					}
				}
			}); 


		}
       return false; 

   }); 
});



//文章發佈表單送出
$(document).ready(function(){
	
	$('#newsAddForm').submit(function(){
		
		$('#newsAddForm').ajaxSubmit({
			url: 'post.php',
			success: function(msg) {
				if(msg=="OK"){
					$('div#notice').hide();
					$().alertwindow("文章發佈成功","index.php");
					
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
	
	$('#addProjForm').submit(function(){

		$('#addProjForm').ajaxSubmit({
			target: 'div#notice',
			url: 'post.php',
			success: function(msg) {
				if(msg=="OK"){
					$('div#notice').hide();
					
					$.ajax({
						type: "POST",
						url: "../../post.php",
						data: "act=plusenter",
						success: function(msg){
							if(msg=="OK"){
								var projpath="../project/"+$("#newfolder")[0].value;
								$().alertwindow("專題添加成功,按確定進入排版模式,對本專題主頁進行排版",projpath);
							}else{
								self.location='news_proj.php';
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
});

//切換到專題排版
$(document).ready(function() {
	
	$(".pdv_enter").click(function () { 
		
		var folder=this.id.substr(3);
		
		$.ajax({
			type: "POST",
			url: "../../post.php",
			data: "act=plusenter",
			success: function(msg){
				if(msg=="OK"){
					self.location="../project/"+folder+"/index.php";
				}else{
					$().alertwindow("目前管理帳號沒有排版權限","");
					return false;
				}
			}
		});
		
	 });
	
});



//分類表單
function catCheckform(theform){

  if(theform.cat.value.length < 1 || theform.cat.value=='請填寫分類名稱'){
    $().alertwindow("請填寫分類名稱","");
    theform.cat.focus();
    return false;
}  
	return true;

}

//彈出對話框
function Dpop(url,w,h){
	res = showModalDialog(url, null, 'dialogWidth: '+w+'px; dialogHeight: '+h+'px; center: yes; resizable: no; scroll: no; status: no;');
 	if(res=="ok"){window.location.reload();}
 
}


//切換到分類排版
$(document).ready(function() {
	
	$(".pr_enter").click(function () { 
		var catid=this.id.substr(3);
		var url=$("#href_"+catid)[0].value;
		$.ajax({
			type: "POST",
			url: "../../post.php",
			data: "act=plusenter",
			success: function(msg){
				if(msg=="OK"){
					self.location=url;
				}else{
					$().alertwindow("目前管理帳號沒有排版權限","");
					return false;
				}
			}
		});
		
	 });

	
});


//開設分類專欄
$(document).ready(function() {
	
	$(".setchannel").click(function () { 
		obj=this.id;
		if($("#"+obj)[0].checked==true){
			$().confirmwindow("將分類設為專欄，將創建一個專欄目錄及專欄首頁，可以單獨對專欄首頁進行排版。確定將此分類設置為專欄嗎？", function(result) {
				var catid=obj.substr(11);
				$.ajax({
					type: "POST",
					url:"post.php",
					data: "act=addzl&catid="+catid,
					success: function(msg){
						if(msg=="OK"){
							$.ajax({
								type: "POST",
								url: "../../post.php",
								data: "act=plusenter",
								success: function(msg){
									if(msg=="OK"){
										var url="../class/"+catid+"/";
										$().alertwindow("分類專欄開設成功,按確定進入排版模式,對本專欄主頁進行排版",url);
									}else{
										$().alertwindow("分類專欄開設成功,有排版權限的管理員可以對專欄主頁進行排版","");
										return false;
									}
								}
							});
							
						}else{
							$().alertwindow(msg,"");
						}
					}
				});
				$("#"+obj)[0].checked=true;
			});
				$("#"+obj)[0].checked=false;
		}else{
			$().confirmwindow("取消分類專欄，將刪除專欄首頁及其目錄。確定取消專欄嗎？", function(result) {
				var catid=obj.substr(11);
				$.ajax({
					type: "POST",
					url:"post.php",
					data: "act=delzl&catid="+catid,
					success: function(msg){
						if(msg=="OK"){
							var url="../class/?"+catid+".html";
							var str="<a href='"+url+"' target='_blank'>news/class/?"+catid+".html</a>";
							$("input#href_"+catid)[0].value=url;
							$("td#url_"+catid).html(str);
						}else{
							$().alertwindow(msg,"");
						}
					}
				});
				$("#"+obj)[0].checked=false;
			});
				$("#"+obj)[0].checked=true;
		}
	 });
	
});

//開設分類獨立排版
$(document).ready(function() {
	
	$(".setcattemp").click(function () { 
		obj=this.id;
		if($("#"+obj)[0].checked==true){
			$().confirmwindow("將分類設為獨立排版模式，可以對此分類之下的頁面進行獨立排版。確定將此分類設置為獨立排版模式嗎？", function(result) {
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
										$().alertwindow("分類獨立排版模式開設成功,有排版權限的管理員可以對分類頁進行排版","");
										return false;
									}
								}
							});
							
						}else{
							$().alertwindow(msg,"");
						}
					}
				});
				$("#"+obj)[0].checked=true;
			});
				$("#"+obj)[0].checked=false;
		}else{
			$().confirmwindow("取消分類獨立排版，會將此分類的排版刪除。確定取消獨立排版嗎？", function(result) {
				var catid=obj.substr(11);
				$.ajax({
					type: "POST",
					url:"post.php",
					data: "act=delcattemp&catid="+catid,
					success: function(msg){
						if(msg=="OK"){
							$().alertwindow("取消分類獨立排版成功!","");
						}else{
							$().alertwindow(msg,"");
						}
					}
				});
				$("#"+obj)[0].checked=false;
			});
				$("#"+obj)[0].checked=true;
		}
	 });
	
});

//圖片預覽
$(document).ready(function(){

	$('.preview').click(function(id){
		var src=$("input#previewsrc_"+this.id.substr(8))[0].value;
		if(src==""){
			return false;
		}
		$("body").append("<img id='pre' src='../../"+src+"'>");
		var w=$("#pre")[0].offsetWidth;
		var h=$("#pre")[0].offsetHeight;
		$.blockUI({  
            message: "<img  src='../../"+src+"' class='closeit'>",  
            css: {  
                top:  ($(window).height() - h) /2 + 'px', 
                left: ($(window).width() - w/2) /2 + 'px', 
                width: $("#pre")[0].offsetWidth + 'px',
				backgroundColor: '#fff',
				borderWidth:'3px',
				borderColor:'#fff'
            }  
        }); 
        $("#pre").remove();
		$(".closeit").click(function(){
			$.unblockUI(); 
		}); 

        setTimeout($.unblockUI, 2000); 
	}); 
}); 