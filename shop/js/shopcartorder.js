$(document).ready(function(){
	
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
	

});
function order_data_set() {
	return {
	  showOrderListLayout: true,
	  orderList: orderList,
	  orderInfo: orderInfo,
	  minusItem(orderIndex) {
		if(this.orderList[orderIndex].orderdata.acc>1)
		{
			var tempnum =Number(this.orderList[orderIndex].orderdata.acc);
			this.orderList[orderIndex].orderdata.acc=String(tempnum-1);
			var tempjline =Number(this.orderList[orderIndex].orderdata.jine.replace(/,/g, ""));
			this.orderInfo.oritjine=this.orderInfo.oritjine-tempjline;
		}
	  },
	  addItem(orderIndex) {
		var tempnum =Number(this.orderList[orderIndex].orderdata.acc);
		this.orderList[orderIndex].orderdata.acc=String(tempnum+1);
		var tempjline =Number(this.orderList[orderIndex].orderdata.jine.replace(/,/g, ""));
		this.orderInfo.oritjine=this.orderInfo.oritjine+tempjline;
	  }}
  }


  function order_data_init() {}