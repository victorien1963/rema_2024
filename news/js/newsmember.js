
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

//文章發佈表單送出
$(document).ready(function(){
	$('#newsfabu').submit(function(){ 
		SelectAll('spe_selec[]', 'select[]');
		$('#newsfabu').ajaxSubmit({
			target: 'div#notice',
			url: 'post.php',
			success: function(msg) {
				if(msg=="OK"){
					$('div#notice').hide();
					$().alertwindow("發佈成功","news_gl.php");
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

//文章修改表單送出
$(document).ready(function(){
	
	$('#newsModify').submit(function(){ 

		if($("#newspagesid")[0].value=="0"){
			
			//正常送出修改
			$("#act")[0].value="newsmodify";
			SelectAll('spe_selec[]', 'select[]');

			$('#newsModify').ajaxSubmit({
				target: 'div#notice',
				url: 'post.php',
				success: function(msg) {
					if(msg=="OK"){
						$('div#notice').hide();
						$().alertwindow("修改成功","news_gl.php");
					}else{
						$('div#notice')[0].className='noticediv';
						$('div#notice').show();
						$().setBg();
					}
				}
			}); 
		
		}else{
			
			//翻頁內容只更新body
			$("#act")[0].value="contentmodify";

			$('#newsModify').ajaxSubmit({
				target: 'div#notice',
				url: 'post.php',
				success: function(msg) {
					
					if(msg=="OK"){
						$('div#notice').hide();
						$().alertwindow("分頁內容已保存","");
						
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


//得到kedit目前模式
function disignMode(){

	var length=$("#KE_SOURCE")[0].src.length - 10;
	var image=$("#KE_SOURCE")[0].src.substr(length,10);
	if(image=="design.gif"){
		return 0;
	}
	return 1;
}


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
				$("li#p_"+nowpagesid)[0].className='now';

				var getObj = $('li.pages');
				getObj.each(function(id) {
					var obj = this.id;
					
					$("li#"+obj).click(function() {
						
						//kedit源碼模式禁止操作
						if(disignMode()==0){alert("只有在設計模式下才能進行分頁操作");return false;}
						
						var clickid=obj.substr(2);
						
						if(clickid==0){
							$(".newsmodizone").show();
							$().getContent(0);
							$().getNewsPages(0);
						}else{
							$(".newsmodizone").hide();
							$().getContent(clickid);
							$().getNewsPages(clickid);
						}
					});
				});

				//返回正常模式
				$("li#backtomodi").click(function() {

					//kedit源碼模式禁止操作
					if(disignMode()==0){alert("只有在設計模式下才能進行分頁操作");return false;}

					$(".newsmodizone").show();
					$().getContent(0);
					$().getNewsPages(0);

				});
				
				//添加分頁
				$("li#addpage").click(function(){

					//kedit源碼模式禁止操作
					if(disignMode()==0){alert("只有在設計模式下才能進行分頁操作");return false;}

					$.ajax({
						type: "POST",
						url:"post.php",
						data: "act=addpage&nowid="+nowid,
						success: function(msg){
							if(msg=="OK"){
								$().getNewsPages('new');
								$(".newsmodizone").hide();
								$().getContent(-1);
							}else{
								$().alertwindow(msg,"");
							}
						}
					});
				});

				//刪除目前頁
				$("li#pagedelete").click(function(){

					//kedit源碼模式禁止操作
					if(disignMode()==0){alert("只有在設計模式下才能進行分頁操作");return false;}

					var delpagesid=$("input#newspagesid")[0].value;
					
					$.ajax({
						type: "POST",
						url:"post.php",
						data: "act=pagedelete&nowid="+nowid+"&delpagesid="+delpagesid,
						success: function(msg){
							if(msg=="NORIGHTS"){
								$().alertwindow("無權操作","");
							}else if(msg=="0"){
								//分頁全部刪除時返回正常模式
								$(".newsmodizone").show();
								$().getContent(0);
								$().getNewsPages(0);
							}else{
								$(".newsmodizone").hide();
								$().getContent(msg);
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
		var broweser = GetBrowser();
		if (broweser == 'IE') {
			var editzone = document.frames("KindEditorForm").document;
		} else {
			var editzone = document.getElementById('KindEditorForm').contentDocument;
		}		
		$.ajax({
			type: "POST",
			url:"post.php",
			data: "act=getbody&newspageid="+newspageid+"&nowid="+nowid,
			success: function(msg){
				editzone.body.innerHTML=msg;
			}
		});
	};
})(jQuery);

//獲取瀏覽器類型
function GetBrowser()
{
	var browser = '';
	var agentInfo = navigator.userAgent.toLowerCase();
	if (agentInfo.indexOf("msie") > -1) {
		var re = new RegExp("msie\\s?([\\d\\.]+)","ig");
		var arr = re.exec(agentInfo);
		if (parseInt(RegExp.$1) >= 5.5) {
			browser = 'IE';
		}
	} else if (agentInfo.indexOf("firefox") > -1) {
		browser = 'FF';
	} else if (agentInfo.indexOf("netscape") > -1) {
		var temp1 = agentInfo.split(' ');
		var temp2 = temp1[temp1.length-1].split('/');
		if (parseInt(temp2[1]) >= 7) {
			browser = 'NS';
		}
	} else if (agentInfo.indexOf("gecko") > -1) {
		browser = 'ML';
	} else if (agentInfo.indexOf("opera") > -1) {
		var temp1 = agentInfo.split(' ');
		var temp2 = temp1[0].split('/');
		if (parseInt(temp2[1]) >= 9) {
			browser = 'OPERA';
		}
	}
	return browser;
}


//添加分類
$(document).ready(function(){

	$('#addnewscat').click(function(){ 
		var newcat=$("#newcat")[0].value;
		$.ajax({
			type: "POST",
			url:"post.php",
			data: "act=addcat&newcat="+newcat,
			success: function(msg){
				if(msg=="0"){
					$().alertwindow("您的會員帳號沒有自訂分類的權限","");
				}else{
					$("#newsmycat").append(msg);
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