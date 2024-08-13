
/*
//讀取詳情翻頁
(function($){
	$.fn.contentPages = function(shopid){
	
	$("div#contentpages").empty();
		
		$.ajax({
			type: "POST",
			url:PDV_RP+"shop/post.php",
			//data: "act=contentpages&shopid="+shopid,
			data: "act=contentpagespic&shopid="+shopid,
			success: function(msg){
				$("div#contentpages").append("<ul>");
				$("div#contentpages").append("<li id='pl' class='cbutton'>上一張</li>");
				$("div#contentpages").append(msg);
				$("div#contentpages").append("<li id='pn' class='pbutton'>下一張</li>");
				$("div#contentpages").append("</ul>");
				
				
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
						$().getContent(shopid,clickid);
						if($(".pagesnow").next()[0].id=="pn"){$("li#pn")[0].className="cbutton";}else{$("li#pn")[0].className="pbutton";}
						if($(".pagesnow").prev()[0].id=="pl"){$("li#pl")[0].className="cbutton";}else{$("li#pl")[0].className="pbutton";}
						
					});

				});

				
				//上一頁
				$("li#pl").click(function() {
					if($("li#pl")[0].className=="pbutton"){
						var nowObj=$(".pagesnow").prev()[0].id;
						var nextpageid=nowObj.substr(2);
						$().getContent(shopid,nextpageid);
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
						$().getContent(shopid,nextpageid);
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


/*
//讀取圖片

(function($){
	$.fn.getContent = function(shopid,shoppageid){

		$("#shoploading").show();
		$("img#shoppic").remove();
		$("#shoppic").remove();
		$("div[class *= 'featuredimagezoomerhidden']").remove();
		
		$.ajax({
			type: "POST",
			url:PDV_RP+"shop/post.php",
			data: "act=getcontent&shoppageid="+shoppageid+"&shopid="+shopid+"&RP="+PDV_RP,
			success: function(msg){
				
					var msgstr= msg.split("#");
				
				  $("body").append("<img id='shoppic' class='shoppic' show='"+msgstr[0]+"'  src='"+PDV_RP+msgstr[1]+"'>"); 
				   
				  $("img#shoppic").load(function(){
					  var outw=parseInt($("div.piczone").css("width"));
					  var outh=parseInt($("div.piczone").css("height"));

					  var w=$("img#shoppic")[0].offsetWidth;
					  var h=$("img#shoppic")[0].offsetHeight;

					  if(w>=h){
						if(w>outw){$("img#shoppic")[0].style.width=outw+"px";}
					  }else{
						if(h>outh){$("img#shoppic")[0].style.height=outh+"px";}
					  }
					  
						$("img#showpad").fadeOut(function() {
 							$("img#showpad").attr("src",PDV_RP+msg).fadeIn('fast');
						});
						$("img#shoppic").appendTo($("#shopview"));
						$('#shoppic').addimagezoom({
							zoomrange: [2, 4],
							magnifiersize: [400,400],
							magnifierpos: 'right',
							cursorshadecolor: '#fdffd5',
							cursorshade: true //<-- No comma after last option!
						});
						var newh=$("img#shoppic")[0].offsetHeight;
						var neww=$("img#shoppic")[0].offsetWidth;
						
						var newh=$("img#shoppic")[0].offsetHeight;
						var mtop=(350-newh)/2; 
						$("div[class *= 'magnifyarea']").css('margin-top', -mtop);

					    $().setBg();
				  });

				 
				
			}
		});
	};
})(jQuery);
*/

//詳情頁加入購物車
$(document).ready(function(){

	$("#buynums").change(function(){
		if($(this)[0].value=="" || parseInt($(this)[0].value)<1 || isNaN($(this)[0].value) || Math.ceil($(this)[0].value)!=parseInt($(this)[0].value)){
			$(this)[0].value="1";
		}
	});

	$("#addtocart").click(function(){
		var gid=$("#gid")[0].value;
		var nums=$("#buynums")[0].value;
		var buycolorname=$("input#buycolorname").val();
		var buysize=$("input#buysize").val();
		var buyprice=$("input#buyprice").val();
		var buyspecid=$("input#buyspecid").val();
		var isadd=$("input#isadd").val();
		var fz=buycolorname+"^"+buysize+"^"+buyprice+"^"+buyspecid+"^"+isadd;
			
		//檢查庫存

		$.ajax({
			type: "POST",
			url:PDV_RP+"shop/post.php",
			data: "act=chkkucun&gid="+gid+"&nums="+nums+"&specid="+buyspecid,
			success: function(msg){
				if(msg=="OK"){

					$.ajax({
						type: "POST",
						url:PDV_RP+"post.php",
						data: "act=setcookie&getnums=1&cookietype=add&cookiename=SHOPCART&gid="+gid+"&nums="+nums+"&fz="+fz,
						success: function(msg){
							var shownums = msg.split("_");
							if(shownums[0]=="OK"){
								window.parent.location=PDV_RP+'shop/cart.php';
								//csscody.alert('<h1>購物車提示訊息</h1><span class="cartalert">商品已經加入購物車，您目前訂購了[ '+shownums[1]+' ]項商品！</span>');
							}else if(shownums[0]=="1000"){
								alert("訂購數量錯誤");
							}else{
								alert(shownums[0]);
								
							}
						}
					});

				}else if(msg=="1000"){
					alert("該商品缺貨或剩餘數量不足");
				}else{
					alert(msg);
					
				}
			}
		});
	});

});

/*
//初始化獲取翻頁和圖片
$(document).ready(function(){
	var shopid=$("input#shopid")[0].value;
	$().contentPages(shopid);
	$().getContent(shopid,0);
});*/


//切換介紹和參數
$(document).ready(function(){
	$("#switch_body").click(function(){
		$("#switch_body")[0].className="bodyzone_cap_now";
		$("#switch_canshu")[0].className="bodyzone_cap_list";
		$("#bodyzone").show();
		$("#canshuzone").hide();
		$().setBg();
	});
	$("#switch_canshu").click(function(){
		$("#switch_body")[0].className="bodyzone_cap_list";
		$("#switch_canshu")[0].className="bodyzone_cap_now";
		$("#bodyzone").hide();
		$("#canshuzone").show();
		$().setBg();
	});
});



//支持反對投票
$(document).ready(function(){

	$("span#zhichi").click(function(){
		
		var shopid=$("input#shopid")[0].value;

		$.ajax({
			type: "POST",
			url:PDV_RP+"shop/post.php",
			data: "act=zhichi&shopid="+shopid,
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
		
		var shopid=$("input#shopid")[0].value;

		$.ajax({
			type: "POST",
			url:PDV_RP+"shop/post.php",
			data: "act=fandui&shopid="+shopid,
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

	$("span#addfav").click(function(){
		
		var shopid=$("input#shopid")[0].value;

		$.ajax({
			type: "POST",
			url:PDV_RP+"shop/post.php",
			data: "act=addfav&shopid="+shopid+"&url="+window.location.href,
			success: function(msg){
				if(msg=="L0"){
					$().popLogin(0);
				}else if(msg=="L1"){
					$().alertwindow("您已經收藏了目前網址","");
				}else if(msg=="OK"){
					$().alertwindow("已經加入到收藏夾",PDV_RP+"member/member_fav.php");
				}else{
					alert(msg);
				}
			}
		});
	});

	$("img#addtofav").click(function(){
		
		var shopid=$("input#shopid")[0].value;

		$.ajax({
			type: "POST",
			url:PDV_RP+"shop/post.php",
			data: "act=addfav&shopid="+shopid+"&url="+window.location.href,
			success: function(msg){
				if(msg=="L0"){
					$().popLogin(0);
				}else if(msg=="L1"){
					$().alertwindow("您已經收藏了目前網址","");
				}else if(msg=="OK"){
					$().alertwindow("已經加入到收藏夾",PDV_RP+"member/member_fav.php");
				}else{
					alert(msg);
				}
			}
		});
	});
		
});

//全圖載入後再設置頁面 
$(window).load(function(){ $().setBg(); });