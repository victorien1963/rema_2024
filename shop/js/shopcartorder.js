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