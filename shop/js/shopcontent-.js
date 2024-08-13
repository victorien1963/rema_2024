//詳情頁加入購物車
$(document).ready(function(){

	$("#buynums").change(function(){
		if($(this)[0].value=="" || parseInt($(this)[0].value)<1 || isNaN($(this)[0].value) || Math.ceil($(this)[0].value)!=parseInt($(this)[0].value)){
			$(this)[0].value="1";
		}
	});

	$("#addtocart").mouseover(function(){
		
		var gid=$("#gid")[0].value;
		var colorcode=$("input#buycolor").val();
		var bsize = $("#buysize").val();
		var getsize=bsize.split("-");
		var buysize= getsize[0];
		var buyspecid= getsize[1];
		$().getPrice(gid,colorcode,buysize);
	});

	$("#addtocart").click(function(){
		var gid=$("#gid")[0].value;
		var buycolorname=$("input#buycolorname").val();
		var colorcode=$("input#buycolor").val();
		var nums=$("#buynums")[0].value;
		var bsize = $("#buysize").val();
		var getsize=bsize.split("-");
		var buysize= getsize[0];
		var buyspecid= getsize[1];
		
		if(buysize=="0"){
					alert("請選擇尺寸");
					return false;
		}
		if(nums=="0"){
					alert("請選擇數量");
					return false;
		}

		var buyprice=$("input#buyprice").val();
		
		if(buyprice==0 || buyprice == ""){
			alert("傳送資料錯誤，請再試一次！");
			return false;
		}
		
		//var fz=buycolorname+"^"+buysize+"^"+buyprice+"^"+buyspecid;
		var fz=buysize+"^"+buyprice+"^"+buyspecid;
		
		var usedis=0;

		if(usedis == '0'){
			var discat=0;
			var distype=0;
			var disnum=0;
			var disrate=0;
			var disprice=0;
		}else{
			var discat=$("input#discat")[0].value;
			var distype=$("input#distype")[0].value;
			var disnum=$("input#disnum")[0].value;
			var disrate=$("input#disrate")[0].value;
			var disprice=$("input#disprice")[0].value;
		}
		var disc = discat+"^"+distype+"^"+disnum+"^"+disrate+"^"+disprice
		//檢查庫存
		
		/*alert(fz);
		return false;*/

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
								//window.location=PDV_RP+'shop/cart.php';
								/*顯示TIP*/
									$('a#cart_tip').qtip({
        	 prerender: true,
             content: {
        		text: '載入中...',
        		ajax: {
            		url: '../../shop/post.php', // URL to the local file
            		type: 'POST', // POST or GET
            		data: 'act=getcartnums', // Data to pass along with your request
            		success: function(data, status) {
            			var showdata = data.split("^");
            			
            			
							$("#tnumsa").text(showdata[1]);
							$("#topcart").text(showdata[1]);
							
						if(showdata[1]>9){
							$("#topcart").attr("className","topcart2");
							$("#topcart")[0].className="topcart2";
						}else if(showdata[1]>99){
							$("#topcart").attr("className","topcar3");
							$("#topcart")[0].className="topcart3";
						}else{
							$("#topcart").fadeIn().css('display','block');
							$("#topcart").attr("className","topcart");
							$("#topcart")[0].className="topcart";
						}
                		// Process the data

                		// Set the content manually (required!)
                		this.set('content.text', showdata[0]);
            		}
        		}

    		},
    		position: {
        		my: 'top center',  // Position my top left...
        		at: 'bottom right', // at the bottom right of...
        		target: $('div#rot_ctr1_bod_ctr3_bod_wrp1_blk1_blk1_custom_blk1_custom_blk1_custom_blk2_custom_blk4_custom'), // my target
        		adjust: {
            		x: -11,
            		y: 5
        		}

    		},
    		style: {
        		classes: 'qtip-slob qtip-rounded'
    		},
    		show: {
        		ready: true,
        		solo: true
    		},
    		hide: {
        		inactive: 5000,
        		fixed: true,
    			target: $('#rot_ctr1_bod_ctr3_bod_wrp1_blk1_blk1_custom_blk2_custom')
    		}

         });
								/**/
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

//更換款式以及顏色-20130410
$(document).ready(function(){
	
	$(".selcolor").click(function(){
		var gid = this.id.substr(9);
		$().getSpecPic(gid);
		$.ajax({
			type: "POST",
			url:PDV_RP+"shop/post.php",
			data: "act=getsize&gid="+gid,
			success: function(msg){
				$("div#selsize").empty();
				var splist = msg.split("|");
				$("div#selsize").append(splist[0]);
				var specsize = splist[1].substr(5);
				$("input#buyspecid").val(splist[2]);
				$.ajax({
					type: "POST",
					url:PDV_RP+"shop/post.php",
					data: "act=getprice&specid="+splist[2],
					success: function(msg){
							msg = msg.split("^");
							$("input#buyprice").val(msg[0]);
							$("#money").html(msg[1]);
					}
				});
			}
		});
	});
});



/*(function($){
	$.fn.getPrice: function(specid){
	    $.ajax({
				type: "POST",
				url:PDV_RP+"shop/post.php",
				data: "act=getprice&specid="+specid,
				success: function(msg){
					alert(msg);
					var usedis=$("input#usedis").val();
					var distype=$("input#distype").val();
					if( usedis == "1" && distype == "1" ){
						var disrate = $("input#disrate").val();
						var newprice = Math.round(msg*disrate);
					}else{
						var newprice = msg;
					}
					mag = msg.split("^");
					$("input#buyprice").val(msg[0]);
					$("#money").html(msg[1]);
				}
			});
	  });
})(jQuery);*/


/*尺寸對應價格*/
	/*
(function($){
	$.fn.getPrice = function(specid){
		$.ajax({
			type: "POST",
			url:PDV_RP+"shop/post.php",
			data: "act=getprice&specid="+specid,
			success: function(msg){
				var newprice = msg;
				$("input#buyprice").val(newprice);
			}
		});
	};
})(jQuery);
*/

//點選顏色更換圖片
(function($){
	$.fn.getSpecPic = function(shopid){
		$.ajax({
			type: "POST",
			url:PDV_RP+"shop/post.php",
			data: "act=getcontent&shopid="+shopid+"&RP="+PDV_RP,
			success: function(msg){
				//alert(msg);
					var msgstr= msg.split("#");
  						$("#mainsrc").fadeOut(function() {
    						$(this).attr("src",PDV_RP+msgstr[1]).fadeIn();
  						});
						$("#smalla").fadeOut(function() {
    						$(this).attr("src",PDV_RP+msgstr[2]).fadeIn();
  						});
						$("#smallb").fadeOut(function() {
    						$(this).attr("src",PDV_RP+msgstr[3]).fadeIn();
  						});
						$("#smallc").fadeOut(function() {
    						$(this).attr("src",PDV_RP+msgstr[4]).fadeIn();
  						});
					$("#biga").attr("href",PDV_RP+msgstr[5]);
					$("#bigb").attr("href",PDV_RP+msgstr[6]);
					$("#bigc").attr("href",PDV_RP+msgstr[7]);
			}
		});
	};
})(jQuery);