
//添加分組表單送出
$(document).ready(function(){
	
	$('#addGroupForm').submit(function(){
		$('#addGroupForm').ajaxSubmit({
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
								var projpath="../"+$("#newfolder")[0].value;
								$().alertwindow("網頁分組添加成功,按 OK進入排版模式,對本組網頁進行排版",projpath);
							}else{
								self.location='group.php';
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

//切換到分組排版
$(document).ready(function() {
	
	$(".pdv_enter").click(function () { 
		
		var folder=this.id.substr(3);
		
		$.ajax({
			type: "POST",
			url: "../../post.php",
			data: "act=plusenter",
			success: function(msg){
				if(msg=="OK"){
					//self.location="../"+folder;
					window.open("../"+folder);
				}else{
					$().alertwindow("目前管理帳號沒有排版權限","");
					return false;
				}
			}
		});
		
	 });
	
});


//添加網頁校驗
$(document).ready(function(){

	$("#addselmodle").change(function(){
		if($("#addselmodle")[0].value=="1"){
			$("#tr_fold").show();
		}else{
			$("#tr_fold").hide();
			$("#pagefolder")[0].value="";

		}
	});

	
	$('#addPageForm').submit(function(){

		if($("#addselmodle")[0].value=="1"){

			if($("#pagefolder")[0].value==""){
				$().alertwindow("採用獨立自訂排版時，需要建立一個網頁文件，請輸入文件名稱","");
				return false;
			}

			if($("#pagefolder")[0].value.length<1 || $("#pagefolder")[0].value.length>16){
				$().alertwindow("網頁文件名稱必須是1-16位英文字母或數字","");
				return false;
			}

			var patrn=/^[a-zA-Z0-9][a-zA-Z0-9]{0,15}$/;
			if(!patrn.exec($("#pagefolder")[0].value)){
				$().alertwindow("網頁文件名稱必須是1-16位英文字母或數字","");
				return false;
			}
			
		}

		if($("#title")[0].value==""){
			$().alertwindow("請輸入網頁標題","");
			return false;
		}
		
   }); 
});


//修改網頁校驗
$(document).ready(function(){

	$("#modiselmodle").change(function(){
		if($("#modiselmodle")[0].value=="1"){
			$("#tr_fold").show();
		}else{
			var qus=confirm("將獨立排版的網頁改為共享排版，該網頁原來的排版將被刪除(建議保留獨立排版)。確定要這樣做嗎？");
			if(qus){
				$("#tr_fold").hide();
				$("#pagefolder")[0].value="";
			}else{
				$("#modiselmodle").attr("value",'1');
			}
		}
	});
	
	$('#modiPageForm').submit(function(){

		if($("#title")[0].value==""){
			$().alertwindow("請輸入網頁標題","");
			return false;
		}

		if($("#modiselmodle")[0].value=="1"){

			if($("#pagefolder")[0].value==""){
				$().alertwindow("採用獨立自訂排版時，需要建立一個網頁文件，請輸入文件名稱","");
				return false;
			}
		
			if($("#pagefolder")[0].value.length<1 || $("#pagefolder")[0].value.length>16){
				$().alertwindow("網頁文件名稱必須是1-16位英文字母或數字","");
				return false;
			}

			var patrn=/^[a-zA-Z0-9][a-zA-Z0-9]{0,15}$/;
			if(!patrn.exec($("#pagefolder")[0].value)){
				$().alertwindow("網頁文件名稱必須是1-16位英文字母或數字","");
				return false;
			}

		}
		

		if($("#pagefolder")[0].value!=$("#old_pagefolder")[0].value && $("#groupid")[0].value!=$("#old_groupid")[0].value){
				$().alertwindow("不可同時更改網頁分組和排版方式(或網頁文件)，請分次修改","");
				return false;
		}


		
   }); 
});


$(document).ready(function(){

	$('#addsubbutton').click(function(id){
		 $.ajax({
			type: "POST",
			url: "../../base/admin/post.php",
			data: "act=pchkModule",
			success: function(msg){
			}
		});
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


