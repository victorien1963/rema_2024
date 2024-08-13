

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
			}
		});
	};
})(jQuery);





//讀取內容翻頁碼
(function($){
	$.fn.getProductPages = function(p){
		
		$("div#productpages").empty();
		
		var nowid=$("#nowid")[0].value;

		$.ajax({
			type: "POST",
			url:"post.php",
			data: "act=productpageslist&nowid="+nowid+"&pageinit="+p,
			success: function(msg){
				$("div#productpages").append(msg);
				
				var nowpagesid=$("input#productpagesid")[0].value;
				$("li#p_"+nowpagesid)[0].className='now';

				var getObj = $('li.pages');
				getObj.each(function(id) {
					var obj = this.id;
					
					$("li#"+obj).click(function() {
						
						var clickid=obj.substr(2);
						
						if(clickid==0){
							$(".productmodizone").show();
							$("input#adminsubmit").show();
							$(".savebutton").hide();
							$().getContent(0);
							$().getProductPages(0);
						}else{
							$(".productmodizone").hide();
							$("input#adminsubmit").hide();
							$(".savebutton").show();
							$().getContent(clickid);
							$().getProductPages(clickid);
						}
					});
				});

				//返回正常模式
				$("li#backtomodi").click(function() {

					$(".productmodizone").show();
					$("input#adminsubmit").show();
					$(".savebutton").hide();
					$().getContent(0);
					$().getProductPages(0);

				});
				
				//添加分頁
				$("li#addpage").click(function(){


					$.ajax({
						type: "POST",
						url:"post.php",
						data: "act=addpage&nowid="+nowid,
						success: function(msg){
							$().getProductPages('new');
							$(".productmodizone").hide();
							$("input#adminsubmit").hide();
							$(".savebutton").show();
							$().getContent(-1);
						}
					});
				});

				//刪除目前頁
				$("li#pagedelete").click(function(){


					var delpagesid=$("input#productpagesid")[0].value;
					
					$.ajax({
						type: "POST",
						url:"post.php",
						data: "act=pagedelete&nowid="+nowid+"&delpagesid="+delpagesid,
						success: function(msg){
							if(msg=="0"){
								//分頁全部刪除時返回正常模式
								$(".productmodizone").show();
								$("input#adminsubmit").show();
								$(".savebutton").hide();
								$().getContent(0);
								$().getProductPages(0);
							}else{
								$(".productmodizone").hide();
								$("input#adminsubmit").hide();
								$(".savebutton").show();
								$().getContent(msg);
								$().getProductPages(msg);
							}
							
						}
					});
				});
			}
		});
	};

	
	

})(jQuery);


//讀取組圖
(function($){
	$.fn.getContent = function(productpageid){
		
		var nowid=$("#nowid")[0].value;
		$.ajax({
			type: "POST",
			url:"post.php",
			data: "act=getcontent&productpageid="+productpageid+"&nowid="+nowid,
			success: function(msg){
				
				if(msg!=""){
					
					$("#picpriview")[0].src="../../"+msg;
					$("#picpriview").show();
					$("#picpriview")[0].style.width="";
					$("#picpriview").load(function(){
						if($("#picpriview")[0].offsetWidth>500){
							$("#picpriview")[0].style.width="500px";
						}
					});
					
					
				}else{
					$("#picpriview").hide();
				}
			}
		});
	};
})(jQuery);


//選擇分類時更新屬性列
$(document).ready(function() {
		
		$("#selcatid").change(function(){
			$().getPropList();
		});


});





//修改表單送出
$(document).ready(function(){
	
	$('#productForm').submit(function(){

		if($("#productpagesid")[0].value=="0"){
			
			//正常送出修改
			
			$("#act")[0].value="productmodify";
			SelectAll('spe_selec[]', 'select[]');

			$('#productForm').ajaxSubmit({
				target: 'div#notice',
				url: 'post.php',
				success: function(msg) {
					if(msg=="OK"){
						$('div#notice').hide();
						$().alertwindow("產品修改成功","product_con.php");
						
					}else{
						$('div#notice').hide();
						$().alertwindow(msg,"");
					}
				}
			}); 
		
		}else{
			
			//組圖更新
			$("#act")[0].value="contentmodify";

			$('#productForm').ajaxSubmit({
				target: 'div#notice',
				url: 'post.php',
				success: function(msg) {
					if(msg=="OK"){
						$('div#notice').hide();
						var nowpagesid=$("input#productpagesid")[0].value;
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



//產品發佈表單送出
$(document).ready(function(){
	
	$('#productAddForm').submit(function(){

		SelectAll('spe_selec[]', 'select[]');

		$('#productAddForm').ajaxSubmit({
			target: 'div#notice',
			url: 'post.php',
			success: function(msg) {
				if(msg=="OK"){
					$('div#notice').hide();
					$().alertwindow("產品發佈成功","product_con.php");
					
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
								$().alertwindow("專題添加成功,按確定進入排版模式,對專題首頁進行排版",projpath);
							}else{
								self.location='product_proj.php';
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
					alert("目前管理帳號沒有排版權限");
					return false;
				}
			}
		});
		
	 });
	
});



//分類表單
function catCheckform(theform){

  if(theform.cat.value.length < 1 || theform.cat.value=='請填寫分類名稱'){
    alert("請填寫分類名稱");
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
					alert("目前管理帳號沒有排版權限");
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
			qus=confirm("將分類設為專欄，將建立一個專欄目錄及專欄首頁，可以單獨對專欄首頁進行排版。確定將此分類設置為專欄嗎？")
			if(qus!=0){
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
										$().alertwindow("分類專欄開設成功,按確定進入排版模式,對專欄首頁進行排版",url);
									}else{
										alert("分類專欄開設成功,有排版權限的管理員可以對專欄首頁進行排版");
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
			qus=confirm("取消分類專欄，將刪除專欄首頁及其目錄。確定取消專欄嗎？")
			if(qus!=0){
				var catid=obj.substr(11);
				$.ajax({
					type: "POST",
					url:"post.php",
					data: "act=delzl&catid="+catid,
					success: function(msg){
						if(msg=="OK"){
							var url="../class/?"+catid+".html";
							var str="<a href='"+url+"' target='_blank'>http://.../product/class/?"+catid+".html</a>";
							$("input#href_"+catid)[0].value=url;
							$("td#url_"+catid).html(str);
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
			qus=confirm("取消分類獨立排版，會將此分類的排版刪除。確定取消獨立排版嗎？")
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

//詳情圖片大小處理
$(document).ready(function(){
	$("#picpriview").each(function(){
		if(this.offsetWidth>500){
			this.style.width="500px";
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