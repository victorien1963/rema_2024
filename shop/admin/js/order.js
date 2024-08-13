
//訂單管理
$(document).ready(function(){
	//處理中
	/*$("img.orderlook").mouseover(function(){
		var oldsrc=$(this)[0].src;
		var imgname=oldsrc.substr((oldsrc.length-6),2);
		
		$(this)[0].src="images/modi.png";
		$(this).mouseout(function(){
			$(this)[0].src=oldsrc;
			$(this).unbind('click');
		});
		
			//處理、未處理 更換
			$(this).bind('click',function(){
				var orderid=this.id.substr(10);
				if(imgname=="no"){
					$(this)[0].src="images/toolbar_ok.gif";
				}else{
					$(this)[0].src="images/toolbar_no.gif";
				}
				
				$.ajax({
					type: "POST",
					url:"post.php",
					data: "act=orderlook&orderid="+orderid,
					success: function(msg){
						if(msg=="OK"){
							$("#orderlook_"+orderid).attr("src","images/toolbar_ok.gif");
							$("#orderlook_"+orderid).mouseout(function(){
								$("#orderlook_"+orderid).attr("src","images/toolbar_ok.gif");
								$("#orderlook_"+orderid).unbind('click');
							});
						}else if(msg=="NO"){
							$("#orderlook_"+orderid).attr("src","images/toolbar_no.gif");
							$("#orderlook_"+orderid).mouseout(function(){
								$("#orderlook_"+orderid).attr("src","images/toolbar_no.gif");
								$("#orderlook_"+orderid).unbind('click');
							});
						}else if(msg=="1000"){
							alert("訂單不存在");
						}else{
							alert(msg);
						}
						return false;
					}
				});
				
			});
	});*/
	
	//退貨快遞派遣
	$("img.ordertuiyun").mouseover(function(){
		var oldsrc=$(this)[0].src;
		var imgname=oldsrc.substr((oldsrc.length-6),2);
		if(imgname=="no"){
			$(this)[0].src="images/fukuan.png";
			var poptext="已處理";
		}else{
			$(this)[0].src="images/tuikuan.png";
			var poptext="未處理";
		}
		$(this).mouseout(function(){
			$(this)[0].src=oldsrc;
			$(this).unbind('click');
		});

		$(this).bind('click',function(){
			var orderid=this.id.substr(7);
			$.ajax({
					type: "POST",
					url:"post.php",
					data: "act=ordertuiyun&orderid="+orderid,
					success: function(msg){
						
						var msgs = msg.split("_");
						if(msgs[0]=="OK"){
							if(msgs[1] == "0"){
								$("#tuiyun_"+orderid).attr("src","images/toolbar_no.gif");
							}else{
								$("#tuiyun_"+orderid).attr("src","images/toolbar_ok.gif");
							}
							$("#tuiyun_"+orderid).unbind('mouseout');
						}else{
							alert(msg);
						}
						return false;
					}
				});
			
		});
	});
	//收到退貨
	$("img.ordergettui").mouseover(function(){
		var oldsrc=$(this)[0].src;
		var imgname=oldsrc.substr((oldsrc.length-6),2);
		if(imgname=="no"){
			$(this)[0].src="images/fukuan.png";
			var poptext="已處理";
		}else{
			$(this)[0].src="images/tuikuan.png";
			var poptext="未處理";
		}
		$(this).mouseout(function(){
			$(this)[0].src=oldsrc;
			$(this).unbind('click');
		});

		$(this).bind('click',function(){
			var orderid=this.id.substr(7);
			$.ajax({
					type: "POST",
					url:"post.php",
					data: "act=ordergettui&orderid="+orderid,
					success: function(msg){
						
						var msgs = msg.split("_");
						if(msgs[0]=="OK"){
							if(msgs[1] == "0"){
								$("#gettui_"+orderid).attr("src","images/toolbar_no.gif");
							}else{
								$("#gettui_"+orderid).attr("src","images/toolbar_ok.gif");
							}
							$("#gettui_"+orderid).unbind('mouseout');
						}else{
							alert(msg);
						}
						return false;
					}
				});
			
		});
	});
	
	//銷售員切換
	$(".chgsales").focus(function () {
        oldvalue = $(this).val();
    }).change(function(){
		var getID = this.id.substr(3);
		var getVAR = $(this).val();
		var r=confirm("確定要更改銷售員嗎？")
		if (r==true)
		{
			$.ajax({
				type: "POST",
				url:"post.php",
				data: "act=chgsales&orderid="+getID+"&source="+getVAR,
				success: function(msg){
					if(msg=="OK"){
						alert("銷售員已更改");
					}else{
						alert(msg);
					}
					return false;
				}
			});	
		}else{
			$(this).val(oldvalue); 
		}
	});
	//來源切換
	$(".chgsource").change(function(){
		var getID = this.id.substr(3);
		var getVAR = $(this).val();
		var r=confirm("確定要更改訂單來源嗎？")
		if (r==true)
		{
			$.ajax({
				type: "POST",
				url:"post.php",
				data: "act=chgsource&orderid="+getID+"&source="+getVAR,
				success: function(msg){
					if(msg=="OK"){
						alert("來源已更改");
					}else{
						alert(msg);
					}
					return false;
				}
			});	
		}
	});
	
	/*匯入托運單*/
	$("#insertecat").click(function(){
			$('#frmWindow').remove();
			$("body").append("<div id='frmWindow'></div>");
			$('#frmWindow').append('<div class="topBar">新竹托運單號匯入<div class="pwClose"></div></div><div class="border"><iframe frameborder="0" scrolling="yes" src="ecatyun.php" class="Frm"></iframe></div>');
			$.blockUI({message:$('#frmWindow'),css:{width:'750px',top:'10px'}}); 
			$('.pwClose').click(function() { 
				$('#frmWindow').remove();
				$.unblockUI(); 
			}); 
		});
	/**/
	$("#showok").change(function(){
		$("#isok").val( $("#showok").val() );		
	});
	$("#subreceipt").click(function(){
		$("#sd").val($("#startday").val());
		$("#ed").val($("#endday").val());
		$("#source").val($("#showsource").val());
		$("#city").val($("#showcity").val());
		receiptform.submit();
	});
	
	$("#bankstatement").click(function(){
		$("#bsd").val($("#startday").val());
		$("#bed").val($("#endday").val());
		$("#bsource").val($("#showsource").val());
		$("#bcity").val($("#showcity").val());
		statementform.submit();
	});
	//完成確認
	$("img.orderok").each(function(){
		var oldsrc=$(this)[0].src;
		var imgname=oldsrc.substr((oldsrc.length-6),2);
		if(imgname=="ok"){
			$(this).css({cursor:"default"});
		}
	});

	$("img.orderok").mouseover(function(){
		var oldsrc=$(this)[0].src;
		var imgname=oldsrc.substr((oldsrc.length-6),2);
			$(this)[0].src="images/modi.png";
			$(this).mouseout(function(){
				$(this)[0].src=oldsrc;
				$(this).unbind('click');
			});
			$(this).bind('click',function(){
				var orderid=this.id.substr(8);

				$.ajax({
					type: "POST",
					url:"post.php",
					data: "act=orderok&orderid="+orderid,
					success: function(msg){
						if(msg=="OK"){
							$("#tr_"+orderid).remove();
						}else if(msg=="1000"){
							alert("訂單不存在");
						}else if(msg=="1001"){
							alert("訂單未付款，不能標注為完成狀態");
						}else if(msg=="1002"){
							alert("訂單未配送，不能標注為完成狀態");
						}else if(msg=="1003"){
							alert("訂單已退訂，不能標注為完成狀態");
						}else if(msg=="1004"){
							alert("訂單中部分商品未配送，不能標注為完成狀態");
						}else if(msg=="1005"){
							alert("訂單未超過七天鑑賞期限，不能標注為完成狀態");
						}else if(msg=="1006"){
							window.location.reload();
						}else{
							$().alertwindow(msg,"");
						}
						return false;
					}
				});
				
			});
	});
	
	$("img.orderre").mouseover(function(){
		var oldsrc=$(this)[0].src;
		var imgname=oldsrc.substr((oldsrc.length-6),2);
		if(imgname=="no"){
			$(this)[0].src="images/modi.png";
			var poptext="已處理";
		}else{
			$(this)[0].src="images/tuikuan.png";
			var poptext="未處理";
		}
			$(this).mouseout(function(){
				$(this)[0].src=oldsrc;
				$(this).unbind('click');
			});
			
			$(this).bind('click',function(){
				var orderid=this.id.substr(8);
				
				if(imgname=="no"){
					var r=confirm("確定要開立發票嗎？")
	  				if (r==true)
	    			{
						$.ajax({
							type: "POST",
							url:"post.php",
							data: "act=orderre&orderid="+orderid,
							success: function(msg){
								var msgs = msg.split("_");
								if(msgs[0]=="OK"){
									
									alert("發票已開立："+msgs[1]);
									$("#orderre_"+orderid).attr("src","images/toolbar_ok.gif");
									$("#orderre_"+orderid).unbind('mouseout');
									/*if(msgs[1] == "0"){
										$("#orderre_"+orderid).attr("src","images/toolbar_no.gif");
									}else{
										$("#orderre_"+orderid).attr("src","images/toolbar_ok.gif");
									}
									$("#orderre_"+orderid).unbind('mouseout');*/
								}else{
									alert(msg);
								}
								return false;
							}
						});	
					}
				}else{
					//作廢發票
					var r=confirm("確定要作廢這筆訂單的發票嗎？")
	  				if (r==true)
	    			{
	    				$.ajax({
							type: "POST",
							url:"post.php",
							data: "act=orderretui&orderid="+orderid,
							success: function(msg){
								var msgs = msg.split("_");
								if(msgs[0]=="OK"){
									
									alert("發票已作廢："+msgs[1]);
									$("#orderre_"+orderid).attr("src","images/toolbar_no.gif");
									$("#orderre_"+orderid).unbind('mouseout');
								}else{
									alert(msg);
								}
								return false;
							}
						});	
	    			}
				}
			});
	});

	//配送管理

	$("img.orderyun").mouseover(function(){
		var oldsrc=$(this)[0].src;
		$(this)[0].src="images/modi.png";
		$(this).mouseout(function(){
			$(this)[0].src=oldsrc;
			$(this).unbind('click');
		});
		$(this).bind('click',function(){
			var orderid=this.id.substr(9);
			$('#frmWindow').remove();
			$("body").append("<div id='frmWindow'></div>");
			$('#frmWindow').append('<div class="topBar">訂單配送管理<div class="pwClose"></div></div><div class="border"><iframe frameborder="0" scrolling="yes" src="order_yun.php?orderid='+orderid+'" class="Frm"></iframe></div>');
			$.blockUI({message:$('#frmWindow'),css:{width:'750px',top:'10px'}}); 
			$('.pwClose').click(function() { 
				$('#frmWindow').remove();
				window.location.reload();
			}); 
		});
	});
	
	//處理確認	
	$("img.orderlook").mouseover(function(){
		var oldsrc=$(this)[0].src;
		var imgname=oldsrc.substr((oldsrc.length-6),2);
		if(imgname=="no"){
			$(this)[0].src="images/fukuan.png";
			var poptext="已處理";
		}else{
			$(this)[0].src="images/tuikuan.png";
			var poptext="未處理";
		}
		$(this).mouseout(function(){
			$(this)[0].src=oldsrc;
			$(this).unbind('click');
		});

		$(this).bind('click',function(){
			var orderid=this.id.substr(10);
			$.ajax({
					type: "POST",
					url:"post.php",
					data: "act=orderlook&orderid="+orderid,
					success: function(msg){
						
						var msgs = msg.split("_");
						if(msgs[0]=="OK"){
							if(msgs[1] == "0"){
								$("#orderlook_"+orderid).attr("src","images/toolbar_no.gif");
							}else{
								$("#orderlook_"+orderid).attr("src","images/toolbar_ok.gif");
							}
							$("#orderlook_"+orderid).unbind('mouseout');
						}else{
							alert(msg);
						}
						return false;
					}
				});
			
		});
	});

	//付款確認
	
	$("img.orderpay").mouseover(function(){
		var oldsrc=$(this)[0].src;
		var imgname=oldsrc.substr((oldsrc.length-6),2);
		if(imgname=="no"){
			$(this)[0].src="images/fukuan.png";
			var purl="order_pay.php";
			var poptext="訂單付款";
		}else{
			$(this)[0].src="images/tuikuan.png";
			var purl="order_unpay.php";
			var poptext="訂單退款";
		}
		$(this).mouseout(function(){
			$(this)[0].src=oldsrc;
			$(this).unbind('click');

		});

		$(this).bind('click',function(){
			var orderid=this.id.substr(9);
			
			$('#frmWindow').remove();
			$("body").append("<div id='frmWindow'></div>");
			$('#frmWindow').append('<div class="topBar">'+poptext+'<div class="pwClose"></div></div><div class="border"><iframe frameborder="0" scrolling="yes" src="'+purl+'?orderid='+orderid+'" class="Frm"></iframe></div>');
			$.blockUI({message:$('#frmWindow'),css:{width:'600px',top:'10px'}}); 
			$('.pwClose').click(function() { 
				$('#frmWindow').remove();
				window.location.reload();
			}); 
		});
	});

//取消退訂
	$(".orderthis").click(function(){
		
		var r=confirm("取消退訂會以系統重新訂購產生訂單方式處理，確定要重新訂購嗎？")
  if (r==true)
    {
	    	var orderid=this.id.substr(6);
			$.ajax({
				type: "POST",
				url:"post.php",
				data: "act=orderthis&orderid="+orderid,
				success: function(msg){
					if(msg=="OK"){
						$("#tr_"+orderid).remove();
					}else if(msg=="1000"){
						alert("訂單不存在");
					}else{
						$().alertwindow(msg,"");
					}
				}
			});
    }
  else
    {
    	return false;
    }
		
		
		
	});


	//退訂
	$(".ordertuithis").click(function(){
		
		var r=confirm("確定要退訂該筆訂單嗎？")
  if (r==true)
    {
	    	var orderid=this.id.substr(9);
	    	
				$.ajax({
					type: "POST",
					url:"post.php",
					data: "act=ordertui&orderid="+orderid+"&postui=no",
					success: function(msg){
						if(msg=="OK"){
							$("#tr_"+orderid).remove();
						}else if(msg=="1000"){
							alert("訂單不存在");
						}else if(msg=="1001"){
							alert("訂單已付款，不能退訂");
						}else if(msg=="1002"){
							alert("訂單已配送，不能退訂");
						}else if(msg=="1003"){
							alert("訂單已完成，不能退訂");
						}else if(msg=="1004"){
							alert("訂單中部分商品已配送，不能退訂");
						}else{
							$().alertwindow(msg,"");
						}
					}
				});
	    }
	  else
	    {
	    	return false;
	    }
		
		
		
	});
	
	
	//退訂--20130828
	$(".ordertui").click(function(){
		var orderid=this.id.substr(9);
			
			$('#frmWindow').remove();
			$("body").append("<div id='frmWindow'></div>");
			$('#frmWindow').append('<div class="topBar">商品退貨管理<div class="pwClose"></div></div><div class="border"><iframe frameborder="0" scrolling="yes" src="order_tui.php?orderid='+orderid+'" class="Frm" style="height:370px;"></iframe></div>');
			$.blockUI({message:$('#frmWindow'),css:{width:'860px',height:'400px',top:'20px'}}); 
			$('.pwClose').click(function() { 
				$('#frmWindow').remove();
				window.location.reload();
			}); 

	});
	
	//修改商品總價
	$("input.modiprice").mouseover(function(){
		var nowprice,oldprice,orderid;
		$(this)[0].className="modiprice_now";
		$(this).removeAttr("readonly");
		
		$(this).mouseout(function(){
			$(this)[0].className="modiprice";
			$(this).attr("readonly","readonly");
		});
		$(this).focus(function(){
			oldprice=$(this)[0].value;
		});
		$(this).blur(function(){
			nowprice=$(this)[0].value;
			$(this).unbind('blur');
			if(oldprice!=nowprice){
				orderid=this.id.substr(11);

				$.ajax({
					type: "POST",
					url:"post.php",
					data: "act=modigoodstotal&orderid="+orderid+"&nowprice="+nowprice,
					success: function(msg){
						if(msg.substr(0,2)=="OK"){
							var newtotal=msg.substr(3);
							$("td#paytotal_"+orderid).html(newtotal);

							$.blockUI({message: "商品總價和訂單總金額已更新",css:{width: '200px',backgroundColor: '#fff',borderColor:'#999999'}}); 
							setTimeout('$.unblockUI();',500);
						
						}else if(msg=="1000"){
							alert("訂單不存在");
						}else if(msg=="1001"){
							alert("訂單已付款，不能修改訂單中的商品價格");
						}else if(msg=="1002"){
							alert("訂單已完成，不能修改訂單中的商品價格");
						}else if(msg=="1003"){
							lert("訂單已退訂，不能修改訂單中的商品價格");
						}else{
							$().alertwindow(msg,"");
						}

						$("#goodstotal_"+orderid)[0].className="modiprice";
						$("#goodstotal_"+orderid).attr("readonly","readonly");
					}
				});
				
			}
		});


	});



	//修改運費
	$("input.modiyunfei").mouseover(function(){
		var nowprice,oldprice,orderid;
		$(this)[0].className="modiyunfei_now";
		$(this).removeAttr("readonly");
		
		$(this).mouseout(function(){
			$(this)[0].className="modiyunfei";
			$(this).attr("readonly","readonly");
		});
		$(this).focus(function(){
			oldprice=$(this)[0].value;
		});
		$(this).blur(function(){
			nowprice=$(this)[0].value;
			$(this).unbind('blur');
			if(oldprice!=nowprice){
				orderid=this.id.substr(7);

				$.ajax({
					type: "POST",
					url:"post.php",
					data: "act=modiyunfei&orderid="+orderid+"&nowprice="+nowprice,
					success: function(msg){
						if(msg.substr(0,2)=="OK"){
							var newtotal=msg.substr(3);
							$("td#paytotal_"+orderid).html(newtotal);

							$.blockUI({message: "運費和訂單總金額已更新",css:{width: '200px',backgroundColor: '#fff',borderColor:'#999999'}}); 
							setTimeout('$.unblockUI();',500);
						
						}else if(msg=="1000"){
							alert("訂單不存在");
						}else if(msg=="1001"){
							alert("訂單已付款，不能修改運費");
						}else if(msg=="1002"){
							alert("訂單已完成，不能修改運費");
						}else if(msg=="1003"){
							lert("訂單已退訂，不能修改運費");
						}else{
							$().alertwindow(msg,"");
						}

						$("#yunfei_"+orderid)[0].className="modiyunfei";
						$("#yunfei_"+orderid).attr("readonly","readonly");
					}
				});
				
			}
		});
	});
	
	//修改折價金額
	$("input.modipromoprice").mouseover(function(){
		var nowprice,oldprice,orderid;
		$(this)[0].className="modipromoprice_now";
		$(this).removeAttr("readonly");
		
		$(this).mouseout(function(){
			$(this)[0].className="modipromoprice";
			$(this).attr("readonly","readonly");
		});
		$(this).focus(function(){
			oldpromoprice=$(this)[0].value;
		});
		$(this).blur(function(){
			nowpromoprice=$(this)[0].value;
			$(this).unbind('blur');
			if(oldprice!=nowpromoprice){
				orderid=this.id.substr(14);

				$.ajax({
					type: "POST",
					url:"post.php",
					data: "act=modipromoprice&orderid="+orderid+"&nowpromoprice="+nowpromoprice,
					success: function(msg){
						if(msg.substr(0,2)=="OK"){
							var newtotal=msg.substr(3);
							$("td#paytotal_"+orderid).html(newtotal);

							$.blockUI({message: "折價金和訂單總金額已更新",css:{width: '200px',backgroundColor: '#fff',borderColor:'#999999'}}); 
							setTimeout('$.unblockUI();',500);
						
						}else if(msg=="1000"){
							alert("訂單不存在");
						}else if(msg=="1001"){
							alert("訂單已付款，不能修改折價金");
						}else if(msg=="1002"){
							alert("訂單已完成，不能修改折價金");
						}else if(msg=="1003"){
							lert("訂單已退訂，不能修改折價金");
						}else{
							$().alertwindow(msg,"");
						}

						$("#newpromoprice_"+orderid)[0].className="modipromoprice";
						$("#newpromoprice_"+orderid).attr("readonly","readonly");
					}
				});
				
			}
		});
	});


});


