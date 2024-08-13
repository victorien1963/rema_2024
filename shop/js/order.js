

//訂單查詢
$(document).ready(function(){

	/*$("img.paystat").each(function(){
		var oldsrc=$(this)[0].src;
		var imgname=oldsrc.substr((oldsrc.length-6),2);
		if(imgname=="ok"){
			$(this).css({cursor:"default"});
		}
	});

	$("img.paystat").mouseover(function(){
		var oldsrc=$(this)[0].src;
		var imgname=oldsrc.substr((oldsrc.length-6),2);
		if(imgname=="no"){
			$(this)[0].src=PDV_RP+"shop/templates/images/payit.gif";
			$(this).mouseout(function(){
				$(this)[0].src=oldsrc;
			});
			$(this).click(function(){
				var orderid=this.id.substr(8);
				window.location='orderpay.php?orderid='+orderid;
			});
		}
	});

	$("#showpay").attr("value",$("#nowshowpay")[0].value);
	$("#showyun").attr("value",$("#nowshowyun")[0].value);
	$("#showok").attr("value",$("#nowshowok")[0].value);

	if($("#key")[0].value==""){
		$("#key")[0].value="商品名稱/訂單號";
		$("#key").css({color:'#909090'});
		$("#key").click(function(){
			if($("#key")[0].value=="商品名稱/訂單號"){
				$("#key")[0].value="";
				$("#key").css({color:'#505050'});
			}
		});
	}

	$("#searchbutton").mouseover(function(){
		if($("#key")[0].value=="商品名稱/訂單號"){
			$("#key")[0].value="";
			$("#key").css({color:'#505050'});
		}
	});*/
	
	$(".delchk").click(function(){
		var getdelid = this.id.substr(7);
		//alert("刪除訂單編號"+getdelid);
		
		if(PDV_LAN == "en"){
			var cText = "Are You Sure You Want To Cancel?";
		}else if(PDV_LAN == "zh_cn"){
			var cText = "你确定要删除这笔订单？";
		}else{
			var cText = "你確定要刪除這筆訂單？";
		}
		
		if(confirm(cText))
		{
				$.ajax({
					type: "POST",
					url:PDV_RP+"shop/post.php",
					data: "act=ordertui&orderid="+getdelid,
					success: function(msg){
						if(msg=="OK"){
							alert("訂單已經取消！");
							location.reload();
						}else if(msg=="1000"){
							alert("訂單不存在");
							$.fancybox.close();
						}else if(msg=="1001"){
							alert("訂單已付款，不能取消");
							$.fancybox.close();
						}else if(msg=="1002"){
							alert("訂單已配送，不能取消");
							$.fancybox.close();
						}else if(msg=="1003"){
							alert("訂單已完成，不能取消");
							$.fancybox.close();
						}else if(msg=="1004"){
							alert("訂單中部分商品已配送，不能取消");
							$.fancybox.close();
						}else{
							alert(msg);
						}
					}
				});
			}
		
	});
	
	$(".repay").click(function(){
		var getorderid = this.id.substr(6);
		//alert("刪除訂單編號"+getdelid);
		window.location='orderpay.php?orderid='+getorderid;
	});

});

