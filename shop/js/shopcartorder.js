$(document).ready(function(){
	
	// 參考 cart.js $(".gostart").click
	
	$("#checked_continue_btn_step3_JohnStopWork").click(function(){
				
		

		var getpaytotal = (orderInfo.oritjine+orderInfo.yunfei-orderInfo.disaccount);
		var payid = $('input[name=delivery]:checked').val();
		var sourceyun = $('input[name=delivery_method]:checked').val();
		var sourceyunfei = orderInfo.yunfei
		var sourcediscount = orderInfo.disaccount;
		var promocode=jdepromocode;

		//ad5df3FKLMrti-zMegUK1r-6i5xp_UVtaZdsEPx_Qy-gHY0smK5PZw
		//c8c0dh-YkYYlwK04uEy2oXHzg9PzI2dIDNkPNB8fkQHLWoTNiAp9UQ
		alert(getpaytotal);
		alert(sourceyun);
		alert(jdepromocode);
		/*
		var payid = $('input[name=payment]:checked').val();
		var source = $('input[name=source]:checked').val();
		var sourceyun = $('input[name=sourceyun]:checked').val();
		var sourceyunfei = $('#sourceyunfei').val();
		var sourcediscount = $('#sourcediscount').val();

		if( payid == 2  ){
			if(getpaytotal >0){
				var promocode = $("#promocode2").val();
			}else{
				var promocode = this.id;
			}
		}else{
			var promocode = this.id;
		}
			$.ajax({
				type: "POST",
				url:PDV_RP+"post.php",
				data: "act=setcookie&cookietype=addnew&cookiename=PAYMENT&getnums="+payid,
				success: function(msg){
					if(typeof source=="undefined"){
						window.location=PDV_RP+'shop/startorder.php?promocode='+promocode;
					}else{
						window.location=PDV_RP+'shop/startorder.php?source='+source+'&sourceyun='+sourceyun+'&sourceyunfei='+sourceyunfei+'&sourcediscount='+sourcediscount+'&promocode='+promocode;
					}
				}
			});
*/

		/*  20241216 後續結合優惠需要用到
		var promotype = $('#promotype').val();
		var promotypecode = $('#promotypecode').val();
		
		if(typeof payid == "undefined"){
			LoadMsg("請選擇付款方式");
			return false
		}
		if(promotype == 2){
			$("#Attention2").css({display:"block"});
			$("#autostart2").fancybox({padding:0, 'showCloseButton':false}).trigger('click');
			$("#fancybox-wrap").css({width:"780px"});
			$("#fancybox-content").css({width:"780px"});
			$("#gopromo2").click(function(){
				window.location=PDV_RP+'shop/cart.php?promotypecode='+promotypecode+'&payid='+payid;
			});
			return false
		}else if(promotype == 3){
			$("#Attention3").css({display:"block"});
			$("#autostart3").fancybox({padding:0, 'showCloseButton':false}).trigger('click');
			$("#fancybox-wrap").css({width:"780px"});
			$("#fancybox-content").css({width:"780px"});
			$("#gopromo3").click(function(){
				window.location=PDV_RP+'shop/cart.php?promotypecode='+promotypecode+'&payid='+payid;
			});
			return false
		}else if(promotype == 1){
			$("#Attention1").css({display:"block"});
			$("#autostart1").fancybox({padding:0, 'showCloseButton':false}).trigger('click');
			$("#fancybox-wrap").css({width:"780px"});
			$("#fancybox-content").css({width:"780px"});
			$("#gopromo1").click(function(){
				var promosize = $('#promosize').val();
				if(promosize == 0){
					alert("請選擇贈品尺寸！");
					return false
				}
				window.location=PDV_RP+'shop/cart.php?promotypecode='+promotypecode+'&promospec='+promosize+'&payid='+payid;
			});
			return false
		}else{
			var getpaytotal = $("#tjine").val();
			var payid = $('input[name=payment]:checked').val();
			var source = $('input[name=source]:checked').val();
			var sourceyun = $('input[name=sourceyun]:checked').val();
			var sourceyunfei = $('#sourceyunfei').val();
			var sourcediscount = $('#sourcediscount').val();
			
			if( payid == 2  ){
				if(getpaytotal >0){
					var promocode = $("#promocode2").val();
				}else{
					var promocode = this.id;
				}
			}else{
				var promocode = this.id;
			}
				$.ajax({
					type: "POST",
					url:PDV_RP+"post.php",
					data: "act=setcookie&cookietype=addnew&cookiename=PAYMENT&getnums="+payid,
					success: function(msg){
						if(typeof source=="undefined"){
							window.location=PDV_RP+'shop/startorder.php?promocode='+promocode;
						}else{
							window.location=PDV_RP+'shop/startorder.php?source='+source+'&sourceyun='+sourceyun+'&sourceyunfei='+sourceyunfei+'&sourcediscount='+sourcediscount+'&promocode='+promocode;
						}
					}
				});
			}
	*/});
	

});


$(document).ready(function(){
	$('#OrderForm').submit(function(){

		//urlstr  就等於 jdepromocode =>是從shopcart 傳到startorder

		var sourceyun = $("#s_name").val();

		alert(sourceyun);




	}); 
});
function order_data_set() {
	return {
	  showOrderListLayout: true,
	  orderList: orderList,
	  orderInfo: orderInfo,
	  deliveryInfo: deliveryInfo,
	  jdepromocode :jdepromocode,
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