
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
				$().setBg();
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

//圖片預覽
$(document).ready(function(){

	$('.preview').click(function(id){

		var src=$("input#previewsrc_"+this.id.substr(8))[0].value;
		if(src==""){
			return false;
		}

		$("body").append("<img id='pre' src='"+src+"'>");
		var w=$("#pre")[0].offsetWidth;
		var h=$("#pre")[0].offsetHeight;
		
		$.blockUI({  
            message: "<img  src='"+src+"' class='closeit'>",  
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



//產品發佈表單送出
$(document).ready(function(){
	$('#productfabu').submit(function(){ 
		SelectAll('spe_selec[]', 'select[]');
		$('#productfabu').ajaxSubmit({
			target: 'div#notice',
			url: 'post.php',
			success: function(msg) {
				if(msg=="OK"){
					$('div#notice').hide();
					$().alertwindow("產品發佈成功","product_gl.php");
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




//產品修改表單送出
$(document).ready(function(){
	
	$('#productModify').submit(function(){ 

		if($("#productpagesid")[0].value=="0"){
			
			//正常送出修改
			$("#act")[0].value="productmodify";
			SelectAll('spe_selec[]', 'select[]');

			$('#productModify').ajaxSubmit({
				target: 'div#notice',
				url: 'post.php',
				success: function(msg) {
					if(msg=="OK"){
						$('div#notice').hide();
						$().alertwindow("產品修改成功","product_gl.php");
						
					}else{
						$('div#notice')[0].className='noticediv';
						$('div#notice').show();
						$().setBg();
					}
				}
			}); 
		
		}else{
			
			//組圖更新
			$("#act")[0].value="contentmodify";

			$('#productModify').ajaxSubmit({
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
							$(".savebutton").hide();
							$().getContent(0);
							$().getProductPages(0);
						}else{
							$(".productmodizone").hide();
							$(".savebutton").show();
							$().getContent(clickid);
							$().getProductPages(clickid);
						}
					});
				});

				//返回正常模式
				$("li#backtomodi").click(function() {

					$(".productmodizone").show();
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
							if(msg=="OK"){
								$().getProductPages('new');
								$(".productmodizone").hide();
								$(".savebutton").show();
								$().getContent(-1);
							}else{
								$().alertwindow(msg,"");
							}
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
							if(msg=="NORIGHTS"){
								$().alertwindow("無權操作","");
							}else if(msg=="0"){
								//分頁全部刪除時返回正常模式
								$(".productmodizone").show();
								$(".savebutton").hide();
								$().getContent(0);
								$().getProductPages(0);
							}else{
								$(".productmodizone").hide();
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
			data: "act=getimg&productpageid="+productpageid+"&nowid="+nowid,
			success: function(msg){
				
				if(msg!=""){
					$("#picpriview").hide();
					$("#picpriview")[0].src="../../"+msg;
					$("#picpriview")[0].style.width="";
					$("#picpriview").load(function(){
						$("#picpriview").show();
						if($("#picpriview")[0].offsetWidth>500){
							$("#picpriview")[0].style.width="500px";
						}
						$().setBg();
					});
					
					
				}else{
					$("#picpriview").hide();
					$().setBg();
				}
			}
		});
	};
})(jQuery);


//添加分類
$(document).ready(function(){

	$('#addproductcat').click(function(){ 
		var newcat=$("#newcat")[0].value;
		$.ajax({
			type: "POST",
			url:"post.php",
			data: "act=addcat&newcat="+newcat,
			success: function(msg){

				if(msg=="0"){
					$().alertwindow("您的會員帳號沒有自訂分類的權限","");
				}else{
					$("#productmycat").append(msg);
					$().setBg();
				}				


				$('.cat_modify').click(function(){ 
					var catid=this.id.substr(5);
					var cat=$("#cat_"+catid)[0].value;
					var xuhao=$("#catxuhao_"+catid)[0].value;
					$.ajax({
						type: "POST",
						url:"post.php",
						data: "act=modicat&catid="+catid+"&cat="+cat+"&xuhao="+xuhao,
						success: function(msg){
							if(msg=="OK"){
								self.location.reload();
							}else{
								alert(msg);
							}
						}
					});
			   }); 

				$('.cat_del').click(function(){ 
					var catid=this.id.substr(5);
					$.ajax({
						type: "POST",
						url:"post.php",
						data: "act=delcat&catid="+catid,
						success: function(msg){
							if(msg=="OK"){
								$("#tr_"+catid).remove();
								$().setBg();
							}else{
								alert(msg);
							}
						}
					});
			   }); 


			}
		});
   }); 

});


//修改分類
$(document).ready(function(){

	$('.cat_modify').click(function(){ 
		var catid=this.id.substr(5);
		var cat=$("#cat_"+catid)[0].value;
		var xuhao=$("#catxuhao_"+catid)[0].value;
		$.ajax({
			type: "POST",
			url:"post.php",
			data: "act=modicat&catid="+catid+"&cat="+cat+"&xuhao="+xuhao,
			success: function(msg){
				if(msg=="OK"){
					self.location.reload();
				}else{
					alert(msg);
				}
			}
		});
   }); 

});


//刪除分類
$(document).ready(function(){

	$('.cat_del').click(function(){ 
		var catid=this.id.substr(5);
		$.ajax({
			type: "POST",
			url:"post.php",
			data: "act=delcat&catid="+catid,
			success: function(msg){
				if(msg=="OK"){
					$("#tr_"+catid).remove();
					$().setBg();
				}else{
					alert(msg);
				}
			}
		});
   }); 

});