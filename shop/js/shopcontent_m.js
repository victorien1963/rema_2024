//詳情頁加入購物車
$(document).ready(function(){

	$("#buynums").change(function(){
		if($(this)[0].value=="" || parseInt($(this)[0].value)<1 || isNaN($(this)[0].value) || Math.ceil($(this)[0].value)!=parseInt($(this)[0].value)){
			$(this)[0].value="1";
		}
	});

	/*$("#addtocart").mouseover(function(){
		var gid=$("#gid")[0].value;
		var colorcode=$("input#buycolor").val();
		var bsize = $("#buysize").val();
		var getsize=bsize.split("-");
		var buysize= getsize[0];
		var buyspecid= getsize[1];
		$().getPrice(gid,colorcode,buysize);
	});*/
	
	
	$(document).on("change",".selectpicker",function(){
		var getsize=$(this).val().split("-");
		$("#buysize").val(getsize[0]);
		$("#buyspecid").val(getsize[1]);
		$("input#buyprice").val();
	});

	$("#addtocart").click(function(){
		
		var gid=$("#gid").val();
		var buysize= $("#buysize").val();
		var buyspecid= $("#buyspecid").val();
		var nums = $("#buynums").val();
		var subpicid = $("#subpicid").val();
		
		if(subpicid!=""){
			gid = gid+"-"+subpicid;
		}
		
		if(buysize==""){
			if(PDV_LAN == "en"){
				alert("Please select a size.");
			}else if(PDV_LAN == "zh_cn"){
				alert("请选择尺寸");
			}else{
				alert("請選擇尺寸");
			}
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
			var discat=$("input#discat").val();
			var distype=$("input#distype").val();
			var disnum=$("input#disnum").val();
			var disrate=$("input#disrate").val();
			var disprice=$("input#disprice").val();
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
								
								$.ajax({
				            		url: '../../shop/post.php', // URL to the local file
				            		type: 'POST', // POST or GET
				            		data: 'act=getcartnums', // Data to pass along with your request
				            		success: function(data, status) {
				            			
				            			var showdata = data.split("^");
				            			
				            			var scrollDist=$(window).scrollTop();
										var myTop=(($(window).height()-$('.buyit-dialog').height())/2+scrollDist)-50; 
										$('.buyit-dialog').css({top:myTop}); 
				            			
										$('.buyit-dialog').css({display: 'block'});
										setTimeout(function() {
											 $(".buyit-dialog").fadeOut(700, function() { $(this).css({display: 'none'}); });
										}, 1000 );
										
				            			$('.bag').attr('data-original-title', showdata[1]);
				            			$('.bag').tooltip({animation:'true'}).tooltip('show');
				            			$("#scart").text(showdata[1]);
				            			setTimeout("$('.bag').tooltip('hide').tooltip('destroy');",2000);
				            			
				                		//$("#cartlist").html(showdata[0]);
										//$("#cartnum").html(showdata[1]);
										//$("#cartprice").html(showdata[2]);
										//$("#scart").mouseover();
										//setTimeout('$("#scart").mouseout();',3000);
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



$(document).ready(function(){
	//選擇圖片進入
	(function($){
		$.fn.urlSpecPic = function(gid){
			if(gid>0){
				$().getSpecPic(gid,'');
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
								if(msg != "NULL"){
									msg = msg.split("^");
									$("input#buyprice").val(msg[0]);
									$("#money").html(msg[1]);
								}
							}
						});
					}
				});
			}
		};
	})(jQuery);
	
	$(".selcolor").click(function(){
		$("li").removeClass("active");
		$(this).parent("li").addClass("active");
		
		var gids = this.id.substr(9).split("_");
		var gid = gids[0];
		var subgid = gids[1];
		
		$().getSpecPic(gid, subgid);
		
		$.ajax({
			type: "POST",
			url:PDV_RP+"shop/post.php",
			data: "act=getsizemobi&gid="+gid,
			success: function(msg){
				$("#selsize").empty();
				var splist = msg.split("|");
				$("#selsize").append(splist[0]);
				var specsize = splist[1].substr(5);
				$("input#buyspecid").val(splist[2]);
				$("input#buysize").val("");
				$("input#subpicid").val(subgid);
				/*下拉選單AJAX更新*/
            		$('.selectpicker').selectpicker('refresh');
	        		$('.selectpicker').selectpicker('render');
	        	/**/
				$.ajax({
					type: "POST",
					url:PDV_RP+"shop/post.php",
					data: "act=getprice&specid="+splist[2],
					success: function(msg){
						if(msg != "NULL"){
							msg = msg.split("^");
							$("input#buyprice").val(msg[0]);
							$("#money").html(msg[1]);
						}
					}
				});
			}
		});
	});
	
	//點選顏色更換圖片
	(function($){
		$.fn.getSpecPic = function(shopid,subshopid){
			
			$.ajax({
				type: "POST",
				url:PDV_RP+"shop/post.php",
				data: "act=getcontentmobi&shopid="+shopid+"&subshopid="+subshopid+"&RP="+PDV_RP,
				success: function(msg){
					
							eval(msg);
	  						$("#color1").fadeOut(function() {
	  							
	    						$(this).html(P.M).fadeIn("fast", function() {
    								// Animation complete
	    							var swipers = new Swiper('#swiper-container'+P.U, {
								        zoom: true,
	        							lazyLoading: true,
	        							lazyLoadingInPrevNext: true,
								        pagination: '.swiper-pagination',
								        nextButton: '.swiper-button-next',
								        prevButton: '.swiper-button-prev',
								    });
  								});
	    						

							    
							    //setTimeout('swipers.update();swipers.updatePagination();swipers.slideTo(0);',500);
							    //alert("測試中");
	  						});
	  						$("#body").fadeOut(function() {
	    						$(this).prop("src",P.B).fadeIn("fast");
	  						});
	  						
	  						$("#gid").val(shopid);
	  						$("#shopid").val(shopid);	  						
				}
			});
		};
	})(jQuery);
	
});

			
