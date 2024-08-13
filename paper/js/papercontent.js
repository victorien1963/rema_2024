
//文字大小切換

function fontZoom(size)
{
   document.getElementById('con').style.fontSize=size+'px';
}


//讀取詳情翻頁
(function($){
	$.fn.contentPages = function(paperid){
	
	$("div#contentpages").empty();
		
		$.ajax({
			type: "POST",
			url:PDV_RP+"paper/post.php",
			data: "act=contentpages&paperid="+paperid,
			success: function(msg){
				$("div#contentpages").append("<ul>");
				$("div#contentpages").append("<li id='pl' class='cbutton'>上一頁</li>");
				$("div#contentpages").append(msg);
				$("div#contentpages").append("<li id='pn' class='pbutton'>下一頁</li>");
				$("div#contentpages").append("</ul>");
				//$("li#pl").hide();
				
				
				var getObj = $('li.pages');

				if(getObj.length<2){
					$("div#contentpages").hide();
					$().setBg();
					return false;
				}
				
				$('li.pages')[0].className='pagesnow';
				
				getObj.each(function(id) {
					
					var obj = this.id;
					
					$("li#"+obj).click(function() {
						
						$('li.pagesnow')[0].className="pages";
						this.className='pagesnow';
						var clickid=obj.substr(2);
						$().getContent(paperid,clickid);
						if($(".pagesnow").next()[0].id=="pn"){$("li#pn")[0].className="cbutton";}else{$("li#pn")[0].className="pbutton";}
						if($(".pagesnow").prev()[0].id=="pl"){$("li#pl")[0].className="cbutton";}else{$("li#pl")[0].className="pbutton";}
						
						
					});

				});

				
				//上一頁
				$("li#pl").click(function() {
					if($("li#pl")[0].className=="pbutton"){
						var nowObj=$(".pagesnow").prev()[0].id;
						var nextpageid=nowObj.substr(2);
						$().getContent(paperid,nextpageid);
						$('li.pagesnow')[0].className="pages";
						$("#"+nowObj)[0].className="pagesnow";
						if($(".pagesnow").prev()[0].id=="pl"){$("li#pl")[0].className="cbutton";}else{$("li#pl")[0].className="pbutton";}
						if($(".pagesnow").next()[0].id=="pn"){$("li#pn")[0].className="cbutton";}else{$("li#pn")[0].className="pbutton";}
						
					}else{
						return false;
					}
					
					
				});

				
				//下一頁
				$("li#pn").click(function() {
					if($("li#pn")[0].className=="pbutton"){
						var nowObj=$(".pagesnow").next()[0].id;
						var nextpageid=nowObj.substr(2);
						$().getContent(paperid,nextpageid);
						$('li.pagesnow')[0].className="pages";
						$("#"+nowObj)[0].className="pagesnow";
						if($(".pagesnow").prev()[0].id=="pl"){$("li#pl")[0].className="cbutton";}else{$("li#pl")[0].className="pbutton";}
						if($(".pagesnow").next()[0].id=="pn"){$("li#pn")[0].className="cbutton";}else{$("li#pn")[0].className="pbutton";}
						
					}else{
						return false;
					}
				});

			}
		});
	};
})(jQuery);


//讀取詳細內容

(function($){
	$.fn.getContent = function(paperid,paperpageid){
		
		$.ajax({
			type: "POST",
			url:PDV_RP+"paper/post.php",
			data: "act=getcontent&paperpageid="+paperpageid+"&paperid="+paperid+"&RP="+PDV_RP,
			success: function(msg){
				$("#con").html(msg);
				$("#con").find("img").each(function(){
					if(this.offsetWidth>600){
						this.style.width="600px";
					}
				});
				$().setBg();
			}
		});
	};
})(jQuery);


//詳情圖片尺寸處理
$(document).ready(function(){
	$("#con").find("img").hide();
	var w=$("#con")[0].offsetWidth;
	$("#con").find("img").each(function(){
		$(this).show();
		if(this.offsetWidth>w){
			this.style.width=w + "px";
			$().setBg();
		}
	});
		
});


//支持反對投票
$(document).ready(function(){

	$("span#zhichi").click(function(){
		
		var paperid=$("input#paperid")[0].value;

		$.ajax({
			type: "POST",
			url:PDV_RP+"paper/post.php",
			data: "act=zhichi&paperid="+paperid,
			success: function(msg){
				if(msg=="L0"){
					$().popLogin(0);
				}else if(msg=="L1"){
					$().alertwindow("對不起，您已經投過票了","");
				}else{
					$("span#zhichinum").html(msg);
				}
			}
		});
	});


	$("span#fandui").click(function(){
		
		var paperid=$("input#paperid")[0].value;

		$.ajax({
			type: "POST",
			url:PDV_RP+"paper/post.php",
			data: "act=fandui&paperid="+paperid,
			success: function(msg){
				if(msg=="L0"){
					$().popLogin(0);
				}else if(msg=="L1"){
					$().alertwindow("對不起，您已經投過票了","");
				}else{
					$("span#fanduinum").html(msg);
				}
			}
		});
	});
		
});


//加入收藏
$(document).ready(function(){

	$("div#addfav").click(function(){
		
		var paperid=$("input#paperid")[0].value;

		$.ajax({
			type: "POST",
			url:PDV_RP+"paper/post.php",
			data: "act=addfav&paperid="+paperid+"&url="+window.location.href,
			success: function(msg){
				if(msg=="L0"){
					$().popLogin(0);
				}else if(msg=="L1"){
					$().alertwindow("您已經收藏了目前的網址","");
				}else if(msg=="OK"){
					$().alertwindow("已經加入到收藏夾",PDV_RP+"member/member_fav.php");
				}else{
					alert(msg);
				}
			}
		});
	});
		
});


//附件下載扣點
$(document).ready(function(){
	var downcentstr=$("input#downcent")[0].value;
	if(downcentstr!=""){
		$("#downcentnotice").html("(下載本附件需要"+downcentstr+")");
	}
	$("#downlink").click(function(){
		var paperid=$("input#paperid")[0].value;

		$.ajax({
			type: "POST",
			url:PDV_RP+"paper/post.php",
			data: "act=download&paperid="+paperid+"&RP="+PDV_RP,
			success: function(msg){
				if(msg=="1000"){
					alert("下載本附件請先登入");
				}else if(msg=="1001"){
					alert("下載本附件需要"+downcentstr);
				}else{
					window.location=msg;
				}
			}
		});

	});
});


//版主管理
$(document).ready(function(){

		var paperid=$("input#paperid")[0].value;

		$.ajax({
			type: "POST",
			url:PDV_RP+"paper/post.php",
			data: "act=ifbanzhu&paperid="+paperid,
			success: function(msg){
				if(msg=="YES"){
					$("#banzhu").append("版主管理 | <span id='banzhutj'>推薦</span> | <span id='banzhudel'>刪除</span> | <span id='banzhudelmincent'>刪除並扣分</span> |").show();
					$().setBg();

					//推薦操作
					$("#banzhutj").click(function(){
						$.ajax({
							type: "POST",
							url:PDV_RP+"paper/post.php",
							data: "act=banzhutj&paperid="+paperid,
							success: function(msg){
								if(msg=="OK"){
									$().alertwindow("推薦成功","");
								}else{
									alert(msg);
								}
							}
						});
						
					});

					//刪除操作
					$("#banzhudel").click(function(){
						$.ajax({
							type: "POST",
							url:PDV_RP+"paper/post.php",
							data: "act=banzhudel&paperid="+paperid,
							success: function(msg){
								if(msg=="OK"){
									$().alertwindow("刪除成功","../class/");
								}else{
									alert(msg);
								}
							}
						});
						
					});


					//刪除並扣分操作
					$("#banzhudelmincent").click(function(){
						$.ajax({
							type: "POST",
							url:PDV_RP+"paper/post.php",
							data: "act=banzhudel&koufen=yes&paperid="+paperid,
							success: function(msg){
								if(msg=="OK"){
									$().alertwindow("刪除並扣分成功","../class/");
								}else{
									alert(msg);
								}
							}
						});
						
					});
				
				}else{
					$("#banzhu").empty().hide();
				}
			}
		});

});


