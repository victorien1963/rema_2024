
//配送
$(document).ready(function(){
	
	$(".doyun").click(function(){
		var itemid=this.id.substr(6);
		var nowstat=$("#doyun_"+itemid)[0].value;
		if(nowstat=="發貨"){
				$.ajax({
					type: "POST",
					url:"post.php",
					data: "act=orderitemyun&itemid="+itemid,
					success: function(msg){
						if(msg=="OK"){
							$("#yunstat_"+itemid)[0].src="images/toolbar_ok.gif";
							//var yu=Number($("#kucun_"+itemid).html())-Number($("#nums_"+itemid).html());
							if(yu==""){yu="0"}
							//$("#kucun_"+itemid).html(yu);
							$("#doyun_"+itemid)[0].value="退貨";
						}else if(msg=="1000"){
							alert("訂購記錄不存在");
						}else if(msg=="1001"){
							alert("訂單已退訂，不能進行發貨確認");
						}else if(msg=="1002"){
							alert("訂單已完成，不能進行發貨確認");
						}else if(msg=="1003"){
							alert("訂單不存在");
						}else if(msg=="1004"){
							alert("商品庫存不足");
						}else if(msg=="1005"){
							$("#yunstat_"+itemid)[0].src="images/toolbar_ok.gif";
							$("#doyun_"+itemid)[0].value="退貨";
						}else{
							alert(msg);
						}
						return false;
					}
				});

		}else{
				$.ajax({
					type: "POST",
					url:"post.php",
					data: "act=orderitemtui&itemid="+itemid,
					success: function(msg){
						if(msg=="OK"){
							$("#yunstat_"+itemid)[0].src="images/toolbar_no.gif";
							//var yu=Number($("#kucun_"+itemid).html())+Number($("#nums_"+itemid).html());
							if(yu==""){yu="0"}
							//$("#kucun_"+itemid).html(yu);
							$("#doyun_"+itemid)[0].value="發貨";
						}else if(msg=="1000"){
							alert("訂購記錄不存在");
						}else if(msg=="1001"){
							alert("訂單已退訂，不能進行退貨確認");
						}else if(msg=="1002"){
							alert("訂單已完成，不能進行退貨確認");
						}else if(msg=="1003"){
							alert("訂單不存在");
						}else if(msg=="1005"){
							$("#yunstat_"+itemid)[0].src="images/toolbar_no.gif";
							$("#doyun_"+itemid)[0].value="發貨";
						}else{
							alert(msg);
						}
						return false;
					}
				});
		
		}
	});
});


