<!--


/**
* 排版管理初始化
*/


$(document).ready(function() {

		//排版狀態輔助線
		$("#top").css({border:"1px #ff0000 dotted"});
		$("#content").css({border:"1px #ff0000 dotted"});
		$("#bottom").css({border:"1px #ff0000 dotted"});
		

		//移動層初始化
		$().initPlus();


		//加入管理輔助層
		$("body").append("<div id='plusWindow'></div>");
		$("body").append("<div id='plus_data' class='plus_data'></div>");
		$("body").append("<div id='contextMenu' class='contextMenu'><UL><LI id='cm_up'>移至頂層</LI><LI id='cm_top'>上移一層</LI><LI id='cm_under'>下移一層</LI><LI id='cm_down'>移至底層</LI><LI id='cm_copy'>複製元件</LI></UL></div>");


		//加入排版選單
		$("body").prepend("<div id='adminbar_showme' class='adminbar_showme'><span>顯示面板</span></div>");
		$("body").prepend("<div id='adminbar' class='adminbar'></div>");
		$("#adminbar").append("<div class='adminmenuleft'></div><div class='adminmenuright'></div>");
		$("#adminbar").append("<div id='adminbarmenu' class='adminbarmenu'></div>");
		$("#adminbarmenu").append("<div class='adminlogo'></div>");
		$("#adminbarmenu").append("<div id='pdv_plusedit' class='adminbutton1'>模組/元件</div>");
		$("#adminbarmenu").append("<div id='pdv_pageset' class='adminbutton1'>頁面背景/佈局</div>");
		$("#adminbarmenu").append("<div id='pdv_pagemeta' class='adminbutton1'>頁面標題/參數<input type='hidden' id='backFollow' value='"+$('body')[0].style.backgroundPosition+"'></div>");
		$("#adminbarmenu").append("<div id='pdv_hide' class='adminhidden'><span>隱藏面板</span></div>");
		$("#adminbarmenu").append("<div id='pdv_exit' class='admincancle'><span>退出</span></div>");
		$("#adminbarmenu").append("<div id='pdv_save' class='adminsave'><span>保存</span></div>");
		

		
		//顯示管理面板
		$("#adminbar").animate({height: 'show',opacity: 'show'}, 'slow');
		


		//模組元件管理
		$("#adminbar").append("<div id='admin_plusbar' class='admin_plusbar'></div>");
		$("#admin_plusbar").append("<div id='admin_pluscolbar' class='admin_pluscolbar'><div class='admin_plusbarleft'></div><div class='admin_plusbarright'></div><div id='admin_pluscol' class='admin_pluscol'></div><div class='admin_plusmemo'>選擇元件類型</div></div>");
		$("#admin_plusbar").append("<div id='admin_plusselbar' class='admin_plusselbar'><div class='admin_plusbarleft'></div><div class='admin_plusbarright'></div><div id='admin_plussel' class='admin_plussel'></div><div class='admin_plusmemo'>選擇可用元件，點選添加</div></div>");
		$("#admin_plusbar").append("<div id='admin_plusnowbar' class='admin_plusnowbar'><div class='admin_plusbarleft'></div><div class='admin_plusbarright'></div><div id='admin_plusnow' class='admin_plusnow'></div><div class='admin_plusmemo'>本頁已有元件</div></div>");
		$("#admin_plusbar").append("<div id='admin_plusplanbar' class='admin_plusplanbar'><div class='admin_plusbarleft'></div><div class='admin_plusbarright'></div><div id='admin_plusplan' class='admin_plusplan'></div><div class='admin_plusmemo'>元件排版方案</div></div>");
		
		//排版方案
		$("#admin_plusplan").append("<div id='plusplanzone' class='plusplanzone'></div>");
		$("#admin_plusplan").append("<div class='plusplanadd'><input type='checkbox' id='plusplansave' value='1' /> 保存排版：<input type='text' maxlength='8' id='plusplanname' class='planname' value='請輸入方案名稱' /></div>");

		$().plusCollist();
		$().plusGetModule(PDV_COLTYPE);
		$().plusNowList();
		$().plusPlanList();
	
		$("#admin_plusbar").show();

	
		//頁面佈局設置
		$("#adminbar").append("<div id='admin_pagebar' class='admin_pagebar'></div>");
		$("#admin_pagebar").append("<div id='admin_pagecontainbar' class='admin_pagecontainbar'><div class='admin_pagebarleft'></div><div class='admin_pagebarright'></div><div id='admin_pagecontain' class='admin_pagecontain'></div><div class='admin_pagememo'>背景風格方案</div></div>");
		
		$("#admin_pagebar").append("<div id='admin_pagebgcolorbar' class='admin_pagebgcolorbar'><div class='admin_pagebarleft'></div><div class='admin_pagebarright'></div><div id='admin_pagebgcolor' class='admin_pagebgcolor'></div><div class='admin_pagememo'>選擇背景顏色</div></div>");
		$("#admin_pagebgcolor").append("<br clear='all' /><select id='pagecolorsel'><option value='pagebgcolor'>網頁背景</option><option value='pagecontainbg'>容器背景</option><option value='pagetopbg'>頂部背景</option><option value='pagetopbgout'>頂外背景</option><option value='pagecontentbg'>中間背景</option><option value='pagecontentbgout'>中外背景</option><option value='pagebottombg'>底部背景</option><option value='pagebottombgout'>底外背景</option></select>");
		$("#admin_pagebgcolor").append("<input type='text'  id='pageshowcolor' maxlength='7' value='"+$("body").css("backgroundColor")+"' />");
		$("#admin_pagebgcolor").append("<span id='pagetransparent'>透明</span>");
		
		$("#admin_pagebar").append("<div id='admin_pagebgimgbar' class='admin_pagebgimgbar'><div class='admin_pagebarleft'></div><div class='admin_pagebarright'></div><div id='admin_pagebgimg' class='admin_pagebgimg'></div><div class='admin_pagememo'>選擇背景圖片 &nbsp; &nbsp; <span id='showbg_big'>[大]</span><span id='showbg_mid'>[中]</span><span id='showbg_small'>[小]</span><span id='showbg_upload'>[上傳圖片]</span></div></div>");
		
		$("#admin_pagebar").append("<div id='admin_pageconsetbar' class='admin_pageconsetbar'><div class='admin_pagebarleft'></div><div class='admin_pagebarright'></div><div id='admin_pageconset' class='admin_pageconset'></div><div class='admin_pagememo'>頁面佈局風格設置</div></div>");
		$("#admin_pageconset").append("<div class='pageconsetitem'>背景定位：<select id='pagebgposition' ><option value='left top'>左上</option><option value='center top'>中上</option><option value='right top'>右上</option><option value='left bottom'>左下</option><option value='center bottom'>中下</option><option value='right bottom'>右下</option></select></div>");
		$("#admin_pageconset").append("<div class='pageconsetitem'>背景重複：<select id='pagebgrepeat' ><option value='repeat'>重複</option><option value='no-repeat'>不重複</option><option value='repeat-x'>水平重複</option><option value='repeat-y'>垂直重複</option></select></div>");
		$("#admin_pageconset").append("<div class='pageconsetitem'>背景滾動：<select id='pagebgatt' ><option value='scroll'>滾動</option><option value='fixed'>不滾動</option></select></div>");
		$("#admin_pageconset").append("<div class='pageconsetitem'>容器寬度：<input type='text' size='3' id='pagecontainwidth' class='input'  value='"+parseInt($("#top").css("width"))+"' /> PX</div>");
		//$("#admin_pageconset").append("<div class='pageconsetitem'>容器寬度：<select id='pagecontainwidth' ><option value='900'>預設(900PX)</option><option value='950'>門戶(950PX)</option><option value='990'>寬幅(990PX)</option><option value='1002'>寬幅(1002PX)</option><option value='850'>中幅(850PX)</option><option value='780'>窄幅(780PX)</option><option value='720'>小窩(720PX)</option><option value='600'>名片(600PX)</option></select></div>");
		$("#admin_pageconset").append("<div class='pageconsetitem'>容器定位：<select id='containcentersel' ><option value='auto'>居中</option><option value='0'>居左</option></select></div>");
		$("#admin_pageconset").append("<div class='pageconsetitem'>上下邊距：<input type='text' size='3' id='containmargin' class='input' maxlength='2' value='"+parseInt($("#contain").css("marginTop"))+"' /> PX</div>");
		//$("#admin_pageconset").append("<div class='pageconsetitem'>容器邊距：<input type='text' size='3' id='containpadding' class='input' maxlength='2' value='"+parseInt($("#contain").css("padding"))+"' /> PX</div>");
		$("#admin_pageconset").append("<div class='pageconsetitem' style='display:none;'>容器邊距：<input type='text' size='3' id='containpadding' class='input' maxlength='2' value='0' /> PX</div>");
		$("#admin_pageconset").append("<div class='pageconsetitem'>容器間距：<input type='text' size='3' id='contentmargin' class='input' maxlength='2' value='"+parseInt($("#content").css("marginTop"))+"' /> PX</div>");
		$("#admin_pageconset").append("<div class='pageconsetglb'><input type='checkbox' id='psetglobal' value='1' /> 複製佈局風格設置到全站</div>");
		$("#admin_pageconset").append("<div class='pageconsetglb'><input type='checkbox' id='pagesavetemp' value='1' /> 將目前設置保存為方案</div>");
		$("#admin_pageconset").append("<div id='pagetempnameset' class='pageconsetitem'>方案名稱：<input type='text' size='10' maxlength='8' id='pagetempname' class='input' value='' /></div><br />");
		
		$("#admin_pagebar").append("<input type='hidden' id='pagesetload' value='none' />");

		//標題標籤參數設置
		$("#adminbar").append("<div id='admin_metabar' class='admin_metabar'></div>");
		$("#admin_metabar").append("<div id='admin_pagemetabar' class='admin_pagemetabar'><div class='admin_pagebarleft'></div><div class='admin_pagebarright'></div><div id='admin_pagemeta' class='admin_pagemeta'></div><div class='admin_pagememo'>頁面標題/參數設置</div></div>");

		$().pageMetaSet();

		
		//排版狀態下背景跟隨
		backFollowIn();


});


//管理選單切換
$(document).ready(function() {
	var getMenu = $('div.adminbutton1');
	getMenu[0].className="adminbutton2";
	
	getMenu.click(function() {
		getMenu.each(function() {	
			var obj = this.id;
			this.className="adminbutton1";
		});
		this.className="adminbutton2";
	});

	$("#pdv_plusedit").click(function () {
		$("#admin_plusbar").show();
		$("#admin_pagebar").hide();
		$("#admin_metabar").hide();
	});

	$("#pdv_pageset").click(function () {
		if($("#pagesetload")[0].value!="load"){
			$().pageStyleSet();
			$().getPageTempList();
			$().colorSelector();
			$().pageBgimgList();
			$("#pagesetload")[0].value="load";
		}

		$("#admin_plusbar").hide();
		$("#admin_metabar").hide();
		$("#admin_pagebar").show();
	});

	$("#pdv_pagemeta").click(function () {
		$("#admin_plusbar").hide();
		$("#admin_pagebar").hide();
		$("#admin_metabar").show();
	});
});

//獲取現有元件排版方案列表
(function($){

	$.fn.plusPlanList = function(){
		$("#plusplanname").click(function(){
			$().unbind('keydown',$.jqDnR.keydrag);
		});
		
		$("#plusplanname").focus(function(){
			if($("#plusplanname")[0].value=="請輸入方案名稱"){
				$("#plusplanname")[0].value="";
			}
		});

		$.ajax({
			type: "POST",
			url: PDV_RP+"base/post.php",
			data: "act=planlist",
			success: function(msg){
				$("#plusplanzone").html(msg);
				$("li.plusplanlist").mouseover(function() {
					this.className="plusplanlistnow";
				});
				$("li.plusplanlist").mouseout(function() {
					this.className="plusplanlist";
				});

				//應用排版方案
				$("div.plusplanuse").click(function(){

					var planid=this.id.substr(12);
					
					$('#plusWindow').empty();
					$('#plusWindow').append("<div class='topBar'>應用排版方案<div class='pwClose'></div></div><div class='border'><div class='ntc'>應用排版方案時，指定頁面容器中的元件將被刪除並更換成方案中的元件(不適合本頁使用的元件除外)。本操作不可恢復，建議先保存目前排版。<br /><br />請選擇應用排版方案的範圍：<br /><br /><input type='radio' name='plusplanselect' value='top'>頂部容器<br /><input type='radio' name='plusplanselect' value='bottom'>底部容器<br /><input type='radio' name='plusplanselect' value='topbottom' checked='true'>頂部和底部容器<br /><input type='radio' name='plusplanselect' value='all'>全頁<br /><input type='radio' name='plusplanselect' value='alltop'>全站頂部容器<br /><input type='radio' name='plusplanselect' value='allbottom'>全站底部容器<br /><input type='radio' name='plusplanselect' value='alltopbottom'>全站頂部和底部容器<br /></div><div class='buttonzone'><input type='button' class='button' id='plusplanusesub' value='確定' /> <input type='button' class='button' id='plusplanuseexit' value='取消' /></div></div>");
			
					$.blockUI({ message: $('#plusWindow'),css:{width:'380px'}}); 

					$('.pwClose').click(function() { 
						$.unblockUI(); 
					}); 

					$('#plusplanuseexit').click(function() { 
						$.unblockUI(); 
					}); 

					$('#plusplanusesub').click(function() {
						var planusezone=$('input[name=plusplanselect]:checked').val();
						
						$.ajax({
							type: "POST",
							url: PDV_RP+"base/post.php",
							data: "act=plusplanuse&planid="+planid+"&planusezone="+planusezone+"&pageid="+PDV_PAGEID,
							success: function(msg){
								if(msg=="OK"){
									window.location.reload();
								}else{
									alert(msg);
								}
							}
						});
						

						$.unblockUI(); 
					});

				});

				//刪除排版方案
				$("div.plusplandel").click(function(){
					var planid=this.id.substr(12);
					$.ajax({
						type: "POST",
						url: PDV_RP+"base/post.php",
						data: "act=plusplandel&planid="+planid,
						success: function(msg){
							if(msg=="OK"){
								$("li#plusplanlist_"+planid).remove();
							}else{
								alert(msg);
							}
						}
					});

				});
			
			}
		});


	};

})(jQuery);


//獲取現有頁面背景方案列表
(function($){

	$.fn.getPageTempList = function(){
		
		
		$("#pagetempname").click(function(){
			$().unbind('keydown',$.jqDnR.keydrag);
		});
		$("#containmargin").click(function(){
			$().unbind('keydown',$.jqDnR.keydrag);
		});
		$("#contentmargin").click(function(){
			$().unbind('keydown',$.jqDnR.keydrag);
		});
		
		$.ajax({
			type: "POST",
			url: PDV_RP+"base/post.php",
			data: "act=pagetemplist&pageid="+PDV_PAGEID,
			success: function(msg){
				$("#admin_pagecontain").html(msg);
				$("li.admin_pagetemplist").mouseover(function() {
					this.className="admin_pagetemplistnow";
				});
				$("li.admin_pagetemplist").mouseout(function() {
					this.className="admin_pagetemplist";
				});

				//選擇方案
				$("span.admin_pagetemplisttext").click(function(){
					var pagetempid=this.id.substr(9);
					$.ajax({
						type: "POST",
						url: PDV_RP+"base/post.php",
						data: "act=getpagetemp&pagetempid="+pagetempid+"&RP="+PDV_RP,
						success: function(msg){
							
							eval(msg);
							//$("#contain")[0].style.width=J.CW;
							$("#contain")[0].style.background=J.CB;
							$("#contain")[0].style.marginTop=J.CM;
							$("#contain")[0].style.marginBottom=J.CM;
							$("#contain")[0].style.padding=J.CP;
							$("#contain")[0].style.marginLeft=J.CC;
							$("#contain")[0].style.marginRight=J.CC;
							$("#content")[0].style.width=J.CW;
							$("#content")[0].style.background=J.NB;
							$("#contentbgout")[0].style.background=J.NBO;
							$("#content")[0].style.marginTop=J.NM;
							$("#content")[0].style.marginBottom=J.NM;
							$("#top")[0].style.width=J.CW;
							$("#top")[0].style.background=J.TB;
							$("#topbgout")[0].style.background=J.TBO;
							$("#bottom")[0].style.width=J.CW;
							$("#bottom")[0].style.background=J.BB;
							$("#bottombgout")[0].style.background=J.BBO;
							$("body")[0].style.backgroundColor=J.BC;
							$("body")[0].style.backgroundImage=J.BI;
							$("body")[0].style.backgroundPosition=J.BP;
							$("body")[0].style.backgroundRepeat=J.BR;
							$("body")[0].style.backgroundAttachment=J.BA;

							$("input#backFollow")[0].value=J.BP;
							backFollowIn();


						}
					});

				});
				

				//刪除方案
				$("div.pagetempdel").click(function(){
					var pagetempid=this.id.substr(12);
					$.ajax({
						type: "POST",
						url: PDV_RP+"base/post.php",
						data: "act=pagetempdel&pagetempid="+pagetempid,
						success: function(msg){
							if(msg=="OK"){
								$("li#pagetemplist_"+pagetempid).remove();
							}else{
								alert(msg);
							}
						}
					});

				});
				


			}
		});

	};

})(jQuery);


//頁面風格設置
(function($){

	$.fn.pageStyleSet = function(){
		

		//網頁佈局風格設置
		
		$("#containcentersel").change(function(){
			$("#contain")[0].style.marginLeft=$("#containcentersel")[0].value;
			$("#contain")[0].style.marginRIght=$("#containcentersel")[0].value;
			$("#top")[0].style.marginLeft=$("#containcentersel")[0].value;
			$("#top")[0].style.marginRIght=$("#containcentersel")[0].value;
			$("#content")[0].style.marginLeft=$("#containcentersel")[0].value;
			$("#content")[0].style.marginRIght=$("#containcentersel")[0].value;
			$("#bottom")[0].style.marginLeft=$("#containcentersel")[0].value;
			$("#bottom")[0].style.marginRIght=$("#containcentersel")[0].value;
		});

		$("#containmargin").blur(function(){
			if($("#containmargin")[0].value=="" || parseInt($("#containmargin")[0].value)==NaN){
				$("#containmargin")[0].value="0";
			}
			$("#contain")[0].style.marginTop=$("#containmargin")[0].value +'px';
			$("#contain")[0].style.marginBottom=$("#containmargin")[0].value +'px';
		});

		$("#containpadding").blur(function(){
			if($("#containpadding")[0].value=="" || parseInt($("#containpadding")[0].value)==NaN){
				$("#containpadding")[0].value="0";
			}
			$("#contain")[0].style.padding=$("#containpadding")[0].value +'px';
			$("#contain")[0].style.padding=$("#containpadding")[0].value +'px';
		});

		$("#contentmargin").blur(function(){
			if($("#contentmargin")[0].value=="" || parseInt($("#contentmargin")[0].value)==NaN){
				$("#contentmargin")[0].value="0";
			}
			$("#content")[0].style.marginTop=$("#contentmargin")[0].value +'px';
			$("#content")[0].style.marginBottom=$("#contentmargin")[0].value +'px';
		});

		//設置背景重複方式
		$("#pagebgrepeat").change(function(){

			//根據目前下拉單指定的容器改變背景特性
			switch($("#pagecolorsel")[0].value){
				case "pagebgcolor":
					$("body")[0].style.backgroundRepeat=$("#pagebgrepeat")[0].value;
				break;
				case "pagecontainbg":
					$("#contain")[0].style.backgroundRepeat=$("#pagebgrepeat")[0].value;
				break;
				case "pagetopbg":
					$("#top")[0].style.backgroundRepeat=$("#pagebgrepeat")[0].value;
				break;
				case "pagetopbgout":
					$("#topbgout")[0].style.backgroundRepeat=$("#pagebgrepeat")[0].value;
				break;
				case "pagecontentbg":
					$("#content")[0].style.backgroundRepeat=$("#pagebgrepeat")[0].value;
				break;
				case "pagecontentbgout":
					$("#contentbgout")[0].style.backgroundRepeat=$("#pagebgrepeat")[0].value;
				break;
				case "pagebottombg":
					$("#bottom")[0].style.backgroundRepeat=$("#pagebgrepeat")[0].value;
				break;
				case "pagebottombgout":
					$("#bottombgout")[0].style.backgroundRepeat=$("#pagebgrepeat")[0].value;
				break;
			}

		});

		//設置背景位置
		$("#pagebgposition").change(function(){
			
			//根據目前下拉單指定的容器改變背景特性
			switch($("#pagecolorsel")[0].value){
				case "pagebgcolor":
					$("body")[0].style.backgroundPosition=$("#pagebgposition")[0].value;
					$("input#backFollow")[0].value=$("#pagebgposition")[0].value;
					backFollowIn();
				break;
				case "pagecontainbg":
					$("#contain")[0].style.backgroundPosition=$("#pagebgposition")[0].value;
				break;
				case "pagetopbg":
					$("#top")[0].style.backgroundPosition=$("#pagebgposition")[0].value;
				break;
				case "pagetopbgout":
					$("#topbgout")[0].style.backgroundPosition=$("#pagebgposition")[0].value;
				break;
				case "pagecontentbg":
					$("#content")[0].style.backgroundPosition=$("#pagebgposition")[0].value;
				break;
				case "pagecontentbgout":
					$("#contentbgout")[0].style.backgroundPosition=$("#pagebgposition")[0].value;
				break;
				case "pagebottombg":
					$("#bottom")[0].style.backgroundPosition=$("#pagebgposition")[0].value;
				break;
				case "pagebottombgout":
					$("#bottombgout")[0].style.backgroundPosition=$("#pagebgposition")[0].value;
				break;
			}

		});

		$("#pagebgatt").change(function(){
			$("body")[0].style.backgroundAttachment=$("#pagebgatt")[0].value;
		});

		//$("#pagecontainwidth").change(function(){
		$("#pagecontainwidth").blur(function(){
			//$("#contain")[0].style.width=$("#pagecontainwidth")[0].value + "px";
			$("#top")[0].style.width=$("#pagecontainwidth")[0].value + "px";
			$("#content")[0].style.width=$("#pagecontainwidth")[0].value + "px";
			$("#bottom")[0].style.width=$("#pagecontainwidth")[0].value + "px";
			
			//切換寬度時重新調取容器背景圖
			//$().containImgList();
		});

		
		//選中

		if($("#contain")[0].style.marginLeft=="auto"){
			$("#containcentersel")[0].options[0].selected=true;
		}else{
			$("#containcentersel")[0].options[1].selected=true;
		}

		/*for(var i=0;i<$("#pagecontainwidth")[0].length;i++){
			if($("#pagecontainwidth")[0].options[i].value==parseInt($("#top")[0].style.width)){
				$("#pagecontainwidth")[0].options[i].selected=true;
			}
		}*/



		for(var i=0;i<$("#pagebgrepeat")[0].length;i++){
			if($("#pagebgrepeat")[0].options[i].value==$("body")[0].style.backgroundRepeat){
				$("#pagebgrepeat")[0].options[i].selected=true;
			}
		}

		for(var i=0;i<$("#pagebgposition")[0].length;i++){
			if($("#pagebgposition")[0].options[i].value==$("input#backFollow")[0].value){
				$("#pagebgposition")[0].options[i].selected=true;
			}
		}

		for(var i=0;i<$("#pagebgatt")[0].length;i++){
			if($("#pagebgatt")[0].options[i].value==$("body")[0].style.backgroundAttachment){
				$("#pagebgatt")[0].options[i].selected=true;
			}
		}

		$("#pagesavetemp").click(function(){
			if($("#pagesavetemp")[0].checked==true){
				$("#pagetempnameset").show();
			}else{
				$("#pagetempnameset").hide();
			}
		});
		
	};

})(jQuery);



//頁面標籤等參數設置
(function($){

	$.fn.pageMetaSet = function(){
		$.ajax({
			type: "POST",
			url: PDV_RP+"base/post.php",
			data: "act=getpagemeta&pageid="+PDV_PAGEID,
			success: function(msg){
				$("#admin_pagemeta").html(msg);
				$("#admin_pagemeta").append("<input id='pagesetauto' type='button' class='pagesetauto' value='清空/自動調用' />");
				$("#pagesetauto").click(function(){
					$("#pagetitle")[0].value='';
					$("#metakey")[0].value='';
					$("#metacon")[0].value='';
				});
				
			}
		});

		
		
	};

})(jQuery);




//選擇背景圖片
(function($){

	$.fn.pageBgimgList = function(){
		
		$.ajax({
			type: "POST",
			url: PDV_RP+"base/post.php",
			data: "act=pagebgimglist&pageid="+PDV_PAGEID+"&RP="+PDV_RP,
			success: function(msg){
				$("#admin_pagebgimg").html(msg);

				$("span#showbg_big").click(function(){
					$(".pagesourcediv").css({width:"248px",height:"190px"});
				});
				$("span#showbg_mid").click(function(){
					$(".pagesourcediv").css({width:"123px",height:"123px"});
				});
				$("span#showbg_small").click(function(){
					$(".pagesourcediv").css({width:"60px",height:"60px"});
				});
				
				$(".pagesourcediv").click(function(){
					
					//根據目前下拉單指定的容器改變背景
					switch($("#pagecolorsel")[0].value){
						case "pagebgcolor":
							$("body")[0].style.backgroundImage=this.style.backgroundImage;
						break;
						case "pagecontainbg":
							$("#contain")[0].style.backgroundImage=this.style.backgroundImage;
						break;
						case "pagetopbg":
							$("#top")[0].style.backgroundImage=this.style.backgroundImage;
						break;
						case "pagetopbgout":									
							$("#topbgout")[0].style.backgroundImage=this.style.backgroundImage;
						break;
						case "pagecontentbg":
							$("#content")[0].style.backgroundImage=this.style.backgroundImage;
						break;
						case "pagecontentbgout":
							$("#contentbgout")[0].style.backgroundImage=this.style.backgroundImage;
						break;
						case "pagebottombg":
							$("#bottom")[0].style.backgroundImage=this.style.backgroundImage;
						break;
						case "pagebottombgout":
							$("#bottombgout")[0].style.backgroundImage=this.style.backgroundImage;
						break;
					}
				});

				//上傳背景圖片
				$("#showbg_upload").click(function(){
					$('#plusWindow').empty();
					$('#plusWindow').append('<div class="topBar">上傳背景圖片<div class="pwClose"></div></div><div class="border"><iframe frameborder="0" scrolling="no" src="'+PDV_RP+'base/admin/upload_bg.php" class="fileUpFrm"></iframe></div>');
					$.blockUI({message:$('#plusWindow'),css:{width:'500px',top:'80px'}});
					$('.pwClose').click(function() { 
						$.unblockUI(); 
					}); 
				});


			}
		});
	};

})(jQuery);



(function($){

	$.fn.colorSelector = function(){


		var colorArr = Array(
			"#ffb6c1","#ffc0cb","#dc143c","#fff0f5","#db7093","#ff69b4","#ff1493","#e10055","#c71585","#da70d6","#d8bfd8","#dda0dd",
			"#ee82ee","#ff00ff","#8b008b","#800080","#ba55d3","#9400d3","#9932cc","#4b0082","#8a2be2","#9370db","#7b68ee","#6a5acd",
			"#483d8b","#e6e6fa","#f8f8ff","#0000ff","#0000cd","#191970","#336699","#2266aa","#0099cc","#00008b","#000080","#4169e1",
			"#6495ed","#b0c4de","#778899","#708090","#1e90ff","#f0f8ff","#4682b4","#87cefa","#87ceeb","#00bfff","#add8e6","#b0e0e6",
			"#5f9ea0","#f0ffff","#e0ffff","#ddeeff","#f7fbfe","#afeeee","#00ffff","#00ced1","#2f4f4f","#008b8b","#009999","#008080",
			"#48d1cc","#20b2aa","#40e0d0","#7fffd4","#66cdaa","#00fa9a","#f5fffa","#00ff7f","#3cb371","#2e8b57","#f0fff0","#90ee90",
			"#98fb98","#8fbc8f","#32cd32","#00ff00","#228b22","#008000","#006400","#7fff00","#7cfc00","#adff2f","#556b2f","#9acd32",
			"#6b8f23","#f5f5dc","#fafad2","#fffff0","#ffffe0","#ffff00","#808000","#bdb76b","#fffacd","#eee8aa","#f0e68c","#ffd700",
			"#fff8dc","#daa520","#b8860b","#fffaf0","#fdf5e6","#f5deb3","#ffe4b5","#ffa500","#ff6600","#ff9900","#ffefd5","#ffebcd",
			"#ffdead","#faebd7","#d2b48c","#deb887","#ffe4c4","#ff8c00","#faf0e6","#cd853f","#ffda89","#f4a460","#d2691e","#8b4513",
			"#fff5ee","#a0522d","#ffa07a","#ff7f50","#ff4500","#e9967a","#ff6347","#ffe4e1","#fa8072","#fffafa","#f08080","#bc8f8f",
			"#cd5c5c","#ff0000","#e60000","#a52a2a","#b22222","#8b0000","#800000","#ffffff","#f5f5f5","#eeeeee","#dcdcdc","#d3d3d3",
			"#c0c0c0","#a9a9a9","#808080","#696969","#cc0000","#000000","#f9f7ed","#ffff88","#cdeb8b","#c3d9ff","#36393d","#ff1a00",
			"#ff7400","#008c00","#006e2e","#4096ee","#ff0084","#b02b2c","#d15600","#d01f3c","#73880a","#6bba70","#3f4c6b","#356aa0"
		);
		for (i = 0; i < colorArr.length; i++) {
			$("#admin_pagebgcolor").prepend('<div class="colorlist" style="background:'+colorArr[i]+'" ></div>');
		}

		$(".colorlist").click(function(){

			$("input#pageshowcolor")[0].value= rgb2hex(this.style.backgroundColor);
			
			//根據目前下拉單指定的容器改變顏色
			switch($("#pagecolorsel")[0].value){
				case "pagebgcolor":
					$("body")[0].style.backgroundColor= rgb2hex(this.style.backgroundColor);
					$("body")[0].style.backgroundImage='';
				break;
				case "pagecontainbg":
					$("#contain")[0].style.backgroundColor= rgb2hex(this.style.backgroundColor);
					$("#contain")[0].style.backgroundImage='';
				break;
				case "pagetopbg":
					$("#top")[0].style.backgroundColor= rgb2hex(this.style.backgroundColor);
					$("#top")[0].style.backgroundImage='';
				break;
				case "pagetopbgout":
					$("#topbgout")[0].style.backgroundColor= rgb2hex(this.style.backgroundColor);
					$("#topbgout")[0].style.backgroundImage='';
				break;
				case "pagecontentbg":
					$("#content")[0].style.backgroundColor= rgb2hex(this.style.backgroundColor);
					$("#content")[0].style.backgroundImage='';
				break;
				case "pagecontentbgout":
					$("#contentbgout")[0].style.backgroundColor= rgb2hex(this.style.backgroundColor);
					$("#contentbgout")[0].style.backgroundImage='';
				break;
				case "pagebottombg":
					$("#bottom")[0].style.backgroundColor= rgb2hex(this.style.backgroundColor);
					$("#bottom")[0].style.backgroundImage='';
				break;
				case "pagebottombgout":
					$("#bottombgout")[0].style.backgroundColor= rgb2hex(this.style.backgroundColor);
					$("#bottombgout")[0].style.backgroundImage='';
				break;
			}
		});




		//設置背景透明
		$("#pagetransparent").click(function(){

			$("input#pageshowcolor")[0].value='transparent';
			
			//根據目前下拉單指定的容器改變顏色
			switch($("#pagecolorsel")[0].value){
				case "pagebgcolor":
					$("body")[0].style.backgroundColor='transparent';
					$("body")[0].style.backgroundImage='';
				break;
				case "pagecontainbg":
					$("#contain")[0].style.backgroundColor='transparent';
					$("#contain")[0].style.backgroundImage='';
				break;
				case "pagetopbg":
					$("#top")[0].style.backgroundColor='transparent';
					$("#top")[0].style.backgroundImage='';
				break;
				case "pagetopbgout":
					$("#topbgout")[0].style.backgroundColor='transparent';
					$("#topbgout")[0].style.backgroundImage='';
				break;
				case "pagecontentbg":
					$("#content")[0].style.backgroundColor='transparent';
					$("#content")[0].style.backgroundImage='';
				break;
				case "pagecontentbgout":
					$("#contentbgout")[0].style.backgroundColor='transparent';
					$("#contentbgout")[0].style.backgroundImage='';
				break;
				case "pagebottombg":
					$("#bottom")[0].style.backgroundColor='transparent';
					$("#bottom")[0].style.backgroundImage='';
				break;
				case "pagebottombgout":
					$("#bottombgout")[0].style.backgroundColor='transparent';
					$("#bottombgout")[0].style.backgroundImage='';
				break;
			}
		});


		

		$("input#pageshowcolor").blur(function () { 

			//根據目前下拉單指定的容器改變顏色
			switch($("#pagecolorsel")[0].value){
				case "pagebgcolor":
					try{$("body")[0].style.backgroundColor=this.value;}catch(e){}
					if($("body")[0].style.backgroundColor!=this.value){this.value=$("body")[0].style.backgroundColor;}
					$("body")[0].style.backgroundImage='';
				break;
				case "pagecontainbg":
					try{$("#contain")[0].style.backgroundColor=this.value;}catch(e){}
					if($("#contain")[0].style.backgroundColor!=this.value){this.value=$("#contain")[0].style.backgroundColor;}
					$("#contain")[0].style.backgroundImage='';
				break;
				case "pagetopbg":
					try{$("#top")[0].style.backgroundColor=this.value;}catch(e){}
					if($("#top")[0].style.backgroundColor!=this.value){this.value=$("#top")[0].style.backgroundColor;}
					$("#top")[0].style.backgroundImage='';
				break;
				case "pagetopbgout":
					try{$("#topbgout")[0].style.backgroundColor=this.value;}catch(e){}
					if($("#topbgout")[0].style.backgroundColor!=this.value){this.value=$("#topbgout")[0].style.backgroundColor;}
					$("#topbgout")[0].style.backgroundImage='';
				break;
				case "pagecontentbg":
					try{$("#content")[0].style.backgroundColor=this.value;}catch(e){}
					if($("#content")[0].style.backgroundColor!=this.value){this.value=$("#content")[0].style.backgroundColor;}
					$("#content")[0].style.backgroundImage='';
				break;
				case "pagecontentbgout":
					try{$("#contentbgout")[0].style.backgroundColor=this.value;}catch(e){}
					if($("#contentbgout")[0].style.backgroundColor!=this.value){this.value=$("#contentbgout")[0].style.backgroundColor;}
					$("#contentbgout")[0].style.backgroundImage='';
				break;
				case "pagebottombg":
					try{$("#bottom")[0].style.backgroundColor=this.value;}catch(e){}
					if($("#bottom")[0].style.backgroundColor!=this.value){this.value=$("#bottom")[0].style.backgroundColor;}
					$("#bottom")[0].style.backgroundImage='';
				break;
				case "pagebottombgout":
					try{$("#bottombgout")[0].style.backgroundColor=this.value;}catch(e){}
					if($("#bottombgout")[0].style.backgroundColor!=this.value){this.value=$("#bottombgout")[0].style.backgroundColor;}
					$("#bottombgout")[0].style.backgroundImage='';
				break;
			}
			
		});


		//選擇背景色位置下拉單
		$("#pagecolorsel").change(function(){
			switch(this.value){
				case "pagebgcolor":
					$("#pageshowcolor")[0].value= rgb2hex($("body")[0].style.backgroundColor);
				break;
				case "pagecontainbg":
					$("#pageshowcolor")[0].value= rgb2hex($("#contain")[0].style.backgroundColor);
				break;
				case "pagetopbg":
					$("#pageshowcolor")[0].value= rgb2hex($("#top")[0].style.backgroundColor);
				break;
				case "pagetopbgout":
					$("#pageshowcolor")[0].value= rgb2hex($("#topbgout")[0].style.backgroundColor);
				break;
				case "pagecontentbg":
					$("#pageshowcolor")[0].value= rgb2hex($("#content")[0].style.backgroundColor);
				break;
				case "pagecontentbgout":
					$("#pageshowcolor")[0].value= rgb2hex($("#contentbgout")[0].style.backgroundColor);
				break;
				case "pagebottombg":
					$("#pageshowcolor")[0].value= rgb2hex($("#bottom")[0].style.backgroundColor);
				break;
				case "pagebottombgout":
					$("#pageshowcolor")[0].value= rgb2hex($("#bottombgout")[0].style.backgroundColor);
				break;
			}
		});
	};

})(jQuery);


//讀取模組清單
(function($){

	$.fn.plusCollist = function(){

		$.ajax({
			type: "POST",
			url: PDV_RP+"base/post.php",
			data: "act=plusgetcol&coltype="+PDV_COLTYPE,
			success: function(msg){
				$("#admin_pluscol").html(msg);
				
				var getObj = $(msg).find('li');
				getObj.each(function(id) {
					var obj = this.id;
					$("li#"+obj).click(function() {
						$('li.admin_collistnow')[0].className="admin_collist";
						$("li#"+obj)[0].className="admin_collistnow";
						$().plusGetModule(obj.substr(9));
					});
					
				});

			}
		});
		
	};

})(jQuery);







//讀取模組對應的元件清單
(function($){

	$.fn.plusGetModule = function(showcoltype){
		$.ajax({
			type: "POST",
			url: PDV_RP+"base/post.php",
			data: "act=plusgetmodule&coltype="+PDV_COLTYPE+"&pagename="+PDV_PAGENAME+"&showcoltype="+showcoltype+"&pdvrp="+PDV_RP,
			success: function(msg){
				$("#admin_plussel").html(msg);
				$(".admin_plussellist").mouseover(function(){
					$(this)[0].className="admin_plussellistnow";
				});
				$(".admin_plussellist").mouseout(function(){
					$(this)[0].className="admin_plussellist";
				});
			}
		});

		document.cookie="SMD"+"="+showcoltype;
		
	};

})(jQuery);


//讀取目前頁已插入元件清單

(function($){

	$.fn.plusNowList = function(){
		$.ajax({
			type: "POST",
			url: PDV_RP+"base/post.php",
			data: "act=plusnowlist&coltype="+PDV_COLTYPE+"&pagename="+PDV_PAGENAME+"&pdvrp="+PDV_RP,
			success: function(msg){
				$("#admin_plusnow").html(msg);

				$(".admin_pluslist").mouseover(function(){
					$(this)[0].className="admin_pluslistnow";
				});
				$(".admin_pluslist").mouseout(function(){
					$(this)[0].className="admin_pluslist";
				});

				var getObj = $('div.admin_pluslistedit');
				getObj.each(function(id) {
					var obj = this.id;
					$("div#"+obj).click(function() {
						pdvid="pd"+obj;
						$().savePlus(0);
						$('#plusWindow').empty();
						$('#plusWindow').append('<div class="topBar">元件設置<div class="pwClose"></div></div><div class="border"><iframe frameborder="0" scrolling="no" src="'+PDV_RP+'base/admin/plusset.php?divid='+pdvid+'" class="plusFrm"></iframe></div>');
						$.blockUI({message:$('#plusWindow'),css:{width:'680px',top:'20px'}}); 
						$('.pwClose').click(function() { 
							$.unblockUI(); 
						}); 
					});
				});

				var getObj = $('div.admin_pluslistdel');
				getObj.each(function(id) {
					var obj = this.id;
					$("div#"+obj).click(function() {
						pdvid="p"+obj;
						$.ajax({
								type: "POST",
								url: PDV_RP+"base/post.php",
								data: "act=plusdel&pdvid="+pdvid,
								success: function(msg){
									if(msg=="OK"){
										$("div#"+pdvid).remove();
										$("li#now"+pdvid.substr(2)).remove();
										$().adminSetBg();
										$().plusGetModule(getCookie("SMD"));
									}else{
										alert("刪除元件失敗，錯誤資訊："+msg);
									}
								
								}
						});
						$().unbind('keydown',$.jqDnR.keydrag);

					});
				});


			}
		});
		
	};

})(jQuery);




/**
* 保存設置
*/
$(document).ready(function(){
    $("#pdv_save").click(function () { 
		$().savePlus(1);
    });
});


/***********隱藏排版控制界面 BY Cyrano*************/
$(document).ready(function(){
    $("#pdv_hide").click(function () { 
		$("#adminbar").hide();
		$("#adminbar_showme").show();
		backFollowOut();
    });
	$("#adminbar_showme").click(function () { 
		$("#adminbar").show();
		$("#adminbar_showme").hide();
		backFollowIn();
    });
});


function mouseMove(ev) { 
	ev= ev || window.event; 
	var mousePos = mouseCoords(ev); 
	if(mousePos.y<=1){
		$("#adminbar").show();
		$("#adminbar_showme").hide();
		backFollowIn();
	}; 
} 
function mouseCoords(ev) { 
	if(ev.pageX || ev.pageY){ 
		return {x:ev.pageX, y:ev.pageY}; 
	} 
	return { 
		x:ev.clientX + document.body.scrollLeft - document.body.clientLeft, 
		y:ev.clientY + document.body.scrollTop - document.body.clientTop 
	}; 
} 
document.onmousemove = mouseMove;

/***********隱藏排版控制界面結束*************/

/**
* 添加元件
*/


function plusAdd(url){
		
		if($.browser.msie && $(".pdv_class").size()>30){
			alert("目前頁面元件已超過30個，由於ie對外聯樣式的限制，過多元件可能會導致樣式丟失");
		}

		$().savePlus(0);
		$('#plusWindow').empty();
		$('#plusWindow').append('<div class="topBar">新增元件<div class="pwClose"></div></div><div class="border"><iframe frameborder="0" scrolling="no" src="'+url+'" class="plusFrm"></iframe></div>');
		$.blockUI({message:$('#plusWindow'),css:{width:'680px',top:'20px'}});
		$('.pwClose').click(function() { 
			$.unblockUI(); 
		}); 
		
}


/**
* 點退出或離開頁面時提示保存

*/
$(document).ready(function(){
       
	$('#pdv_exit').click(function() { 
			
			$('#plusWindow').empty();
			$('#plusWindow').append("<div class='topBar'>提示資訊<div class='pwClose'></div></div><div class='border'><div class='ntc'>是否退出排版模式？<br /><br />保存退出：保存排版位置，切換到瀏覽模式<br />不保存退出：不保存排版位置，切換到瀏覽模式</div><div class='buttonzone'><input type='button' class='button' id='saveexit' value='保存退出' /> <input type='button' class='button' id='exit' value='不保存退出' /> <input type='button' class='button' id='no' value='繼續排版' /></div></div>");
			
			$.blockUI({ message: $('#plusWindow'),css:{width:'380px'}}); 

		
			$('#saveexit').click(function() { 
				
				$.blockUI({ message: "正在保存排版資訊...",css:{backgroundColor:'#fff'}}); 
				$().savePlus(0);
				$.ajax({
					type: "POST",
					url: PDV_RP+"post.php",
					data: "act=plusexit",
					success: function(msg){
						window.location.reload();
					}
				});

			}); 

			 $('#exit').click(function() { 
				
				$.blockUI({ message: "正在退出排版模式...",css:{backgroundColor:'#fff'}}); 
	 
				$.ajax({
					type: "POST",
					url: PDV_RP+"post.php",
					data: "act=plusexit",
					success: function(msg){
						window.location.reload();
					}
				});
			}); 
	 
			$('#no').click(function() { 
				$.unblockUI(); 
			}); 

			$('.pwClose').click(function() { 
				$.unblockUI(); 
			}); 
			

	}); 
         
}); 



/* 離開頁面前提示，暫不用

window.onbeforeunload=checkunload;
function checkunload(){
	return "是否離開頁面?";
}

*/



/** --- 保存佈局--- */


(function($){
	$.fn.savePlus = function(ntc){

		var obj = $('div.pdv_class');
		var id=[],zindex=[],top=[],left=[],width=[],height=[],display=[],zh;
		for(var i=0;i<obj.length;i++){
			
			id[i]      = obj[i].id;
			zindex[i]  = obj[i].style.zIndex;
			top[i]     = obj[i].offsetTop;
			left[i]    = obj[i].offsetLeft;
			width[i]   = obj[i].offsetWidth-2;
			height[i]  = obj[i].offsetHeight-2;
			display[i] = obj[i].style.display;
			
		}


		var th = parseInt($("#top")[0].style.height);
		var ch = parseInt($("#content")[0].style.height);
		var bh = parseInt($("#bottom")[0].style.height);
		var pagecontainwidth=parseInt($("#top")[0].style.width);
		var pagebgcolor=$("body")[0].style.backgroundColor;
		var containbg=$("#contain")[0].style.background;
		var topbg=$("#top")[0].style.background;
		var topbgout=$("#topbgout")[0].style.background;
		var contentbg=$("#content")[0].style.background;
		var contentbgout=$("#contentbgout")[0].style.background;
		var bottombg=$("#bottom")[0].style.background;
		var bottombgout=$("#bottombgout")[0].style.background;

		if(containbg==""){containbg=$("#contain")[0].style.backgroundColor;}
		if(topbg==""){topbg=$("#top")[0].style.backgroundColor;}
		if(topbgout==""){topbgout=$("#topbgout")[0].style.backgroundColor;}
		if(contentbg==""){contentbg=$("#content")[0].style.backgroundColor;}
		if(contentbgout==""){contentbgout=$("#contentbgout")[0].style.backgroundColor;}
		if(bottombg==""){bottombg=$("#bottom")[0].style.backgroundColor;}
		if(bottombgout==""){bottombgout=$("#bottombgout")[0].style.backgroundColor;}
		

		
		var containmargin=$("#contain")[0].style.marginTop;
		//var containpadding=$("#contain")[0].style.padding;
		var containpadding=0;
		var containcenter=$("#contain")[0].style.marginLeft;
		var contentmargin=$("#content")[0].style.marginTop;
		var psetglobal=$("#psetglobal")[0].checked;
		var bgimage=$("body")[0].style.backgroundImage;
		
		//保存正常背景位置，而不是排版時位置 
		var bgposition=$("input#backFollow")[0].value;
		
		var bgrepeat=$("body")[0].style.backgroundRepeat;
		var bgatt=$("body")[0].style.backgroundAttachment;
		var pagecname=$("#pagecname")[0].value;
		var pagetitle=$("#pagetitle")[0].value;
		var metakey=$("#metakey")[0].value;
		var metacon=$("#metacon")[0].value;
		var pagesavetemp=$("#pagesavetemp")[0].checked;
		var pagetempname=$("#pagetempname")[0].value;
		var plusplansave=$("#plusplansave")[0].checked;
		var plusplanname=$("#plusplanname")[0].value;

		if($("#pagesavetemp")[0].checked==true && $("#pagetempname")[0].value==""){
			alert("您選擇了「將目前設置保存為方案」，請輸入方案名稱");
			return false;
		}

		if($("#plusplansave")[0].checked==true && ($("#plusplanname")[0].value=="" || $("#plusplanname")[0].value=="請輸入方案名稱")){
			alert("您選擇了「保存方案」，請輸入排版方案名稱");
			return false;
		}

		
		$.ajax({
			type: "POST",
			url: PDV_RP+"base/post.php",
			data: "act=pluslocat&pageid="+PDV_PAGEID+"&id="+id+"&zindex="+zindex+"&top="+top+"&left="+left+"&width="+width+"&height="+height+"&display="+display+"&th="+th+"&bh="+bh+"&ch="+ch+"&pagecontainwidth="+pagecontainwidth+"&pagebgcolor="+pagebgcolor+"&containbg="+containbg+"&containmargin="+containmargin+"&containpadding="+containpadding+"&containcenter="+containcenter+"&topbg="+topbg+"&contentbg="+contentbg+"&bottombg="+bottombg+"&contentmargin="+contentmargin+"&psetglobal="+psetglobal+"&bgimage="+bgimage+"&bgposition="+bgposition+"&bgrepeat="+bgrepeat+"&bgatt="+bgatt+"&pagecname="+pagecname+"&pagetitle="+pagetitle+"&metakey="+metakey+"&metacon="+metacon+"&pagesavetemp="+pagesavetemp+"&pagetempname="+pagetempname+"&plusplansave="+plusplansave+"&plusplanname="+plusplanname+"&topbgout="+topbgout+"&contentbgout="+contentbgout+"&bottombgout="+bottombgout,
			success: function(msg){
				if(msg=="OK"){
					if(ntc==1){
						$.blockUI({message: "排版資訊已保存",css:{width:'320px',height:'100px',lineHeight:'100px',fontSize:'14px',backgroundColor:'#fff',border:'5px #cbddef solid'}}); 
						setTimeout("$.unblockUI()",1500);
					}

					//保存頁面設置方案
					if($("#pagesavetemp")[0].checked==true){
						$().getPageTempList();
						$("#pagesavetemp")[0].checked=false;
						$("#pagetempnameset").hide();
					}

					//保存排版方案
					if($("#plusplansave")[0].checked==true){
						$("#plusplansave")[0].checked=false;
						$("#plusplanname")[0].value='';
						$().plusPlanList();
					}

				}else{
						alert("頁面資訊保存失敗，錯誤資訊："+msg);
				}
			}
		});

	};
	
})(jQuery);




/** 
--- 設置元件後返回更新
--- 包含的樣式表和JS可能不能支持動態加載
--- */


(function($){

	$.fn.PlusSet = function(pdvid,containdiv){
		
		var PZ=$("div#"+pdvid).css('zIndex');


		//讀取元件內容返回到容器
		$.ajax({
			type: "POST",
			url: window.location.href,
			data: "act=plusset&pdvid="+pdvid,
			success: function(msg){
					$("div#"+pdvid).remove();
					$("div#"+containdiv).append(msg);
					$("div#"+pdvid).css('zIndex',PZ)
					$().initPlus();
					$().adminSetBg();
			}
		});
		
	};

})(jQuery);



/** 
--- 添加元件後返回動態添加
--- 包含的樣式表和JS可能不能支持動態加載
--- */

(function($){

	$.fn.plusAddBack = function(pdvid,containdiv){
		

		//讀取元件內容添加到容器
		$.ajax({
			type: "POST",
			url: window.location.href,
			data: "act=plusset&pdvid="+pdvid,
			success: function(msg){
					$("div#"+containdiv).append(msg);
					$().initPlus();
					$().adminSetBg();
					$().plusGetModule(getCookie("SMD"));
					$().plusNowList();
			}
		});
		
	};

})(jQuery);




/** 
--- 設置視窗內刪除元件後返回
--- */

(function($){

	$.fn.plusDelBack = function(pdvid,containdiv){
		
		$("div#"+pdvid).remove();
		$("li#now"+pdvid.substr(2)).remove();
		$().adminSetBg();
		$().plusGetModule(getCookie("SMD"));
	};

})(jQuery);




/**
* 移動層初始化
* 
*/

(function($){
	$.fn.initPlus = function(ntc){

		
		//清除輔助層
		$('.pdv_drag').remove();
		$('.pdv_resize').remove();
		$('.blue_set').remove();


		var getDrag = $('div.pdv_class');
		
		getDrag.each(function(id) {
				
			//添加輔助邊框
			$(this).css({border:"1px #ccc dotted"});
			
			//添加輔助層
			$(this).append("<div class='pdv_drag'></div><div class='pdv_resize'></div><div class='blue_set'></div>");
			
			$(this).Drag('.pdv_drag').Resize('.pdv_resize');
			
			var obj_id = this.id,obj_set_id = "#"+obj_id+">div.blue_set",obj_sethide = obj_set_id+">span.blue_sethide",obj_setremove = obj_set_id+">span.blue_setremove",obj_setdo = obj_set_id+">span.blue_setdo";
			
			$(obj_set_id).html("<span class='blue_setdo' title='設置'></span><span class='blue_setremove' title='刪除'></span>").hide();
			
			$(this).bind("mouseover", function(){ $(obj_set_id).show(); });
			$(this).bind("mouseout", function(){ $(obj_set_id).hide(); });
			
			$(obj_setdo).click(function() {
				
				var obj = $('div.pdv_class');
				var id=[],zindex=[],top=[],left=[],width=[],height=[],display=[],zh;
				for(var i=0;i<obj.length;i++){
					
					id[i]      = obj[i].id;
					zindex[i]  = obj[i].style.zIndex;
					top[i]     = obj[i].offsetTop;
					left[i]    = obj[i].offsetLeft;
					width[i]   = obj[i].offsetWidth-2;
					height[i]  = obj[i].offsetHeight-2;
					display[i] = obj[i].style.display;
					
				}
				var th = parseInt($("#top")[0].style.height);
				var ch = parseInt($("#content")[0].style.height);
				var bh = parseInt($("#bottom")[0].style.height);
				var pagecontainwidth=parseInt($("#top")[0].style.width);
				var pagebgcolor=$("body")[0].style.backgroundColor;
				var containbg=$("#contain")[0].style.background;
				var topbg=$("#top")[0].style.background;
				var topbgout=$("#topbgout")[0].style.background;
				var contentbg=$("#content")[0].style.background;
				var contentbgout=$("#contentbgout")[0].style.background;
				var bottombg=$("#bottom")[0].style.background;
				var bottombgout=$("#bottombgout")[0].style.background;

				if(containbg==""){containbg=$("#contain")[0].style.backgroundColor;}
				if(topbg==""){topbg=$("#top")[0].style.backgroundColor;}						
				if(topbgout==""){topbgout=$("#topbgout")[0].style.backgroundColor;}
				if(contentbg==""){contentbg=$("#content")[0].style.backgroundColor;}
				if(contentbgout==""){contentbgout=$("#contentbgout")[0].style.backgroundColor;}
				if(bottombg==""){bottombg=$("#bottom")[0].style.backgroundColor;}
				if(bottombgout==""){bottombgout=$("#bottombgout")[0].style.backgroundColor;}


				var containmargin=$("#contain")[0].style.marginTop;
				var containpadding=$("#contain")[0].style.padding;
				var containcenter=$("#contain")[0].style.marginLeft;
				var contentmargin=$("#content")[0].style.marginTop;
				var psetglobal=$("#psetglobal")[0].checked;
				var bgimage=$("body")[0].style.backgroundImage;
				//var bgposition=$("body")[0].style.backgroundPosition;
			
				//保存正常背景位置，而不是排版時位置 
				var bgposition=$("input#backFollow")[0].value;

				var bgrepeat=$("body")[0].style.backgroundRepeat;
				var bgatt=$("body")[0].style.backgroundAttachment;
				var pagecname=$("#pagecname")[0].value;
				var pagetitle=$("#pagetitle")[0].value;
				var metakey=$("#metakey")[0].value;
				var metacon=$("#metacon")[0].value;


				$.ajax({
					type: "POST",
					url: PDV_RP+"base/post.php",
					data: "act=pluslocat&pageid="+PDV_PAGEID+"&id="+id+"&zindex="+zindex+"&top="+top+"&left="+left+"&width="+width+"&height="+height+"&display="+display+"&th="+th+"&bh="+bh+"&ch="+ch+"&pagecontainwidth="+pagecontainwidth+"&pagebgcolor="+pagebgcolor+"&containbg="+containbg+"&containmargin="+containmargin+"&containpadding="+containpadding+"&containcenter="+containcenter+"&topbg="+topbg+"&contentbg="+contentbg+"&bottombg="+bottombg+"&contentmargin="+contentmargin+"&psetglobal="+psetglobal+"&bgimage="+bgimage+"&bgposition="+bgposition+"&bgrepeat="+bgrepeat+"&bgatt="+bgatt+"&pagecname="+pagecname+"&pagetitle="+pagetitle+"&metakey="+metakey+"&metacon="+metacon+"&topbgout="+topbgout+"&contentbgout="+contentbgout+"&bottombgout="+bottombgout,
					success: function(msg){
						if(msg=="OK"){
							$('#plusWindow').empty();
							$('#plusWindow').append('<div class="topBar">元件設置<div class="pwClose"></div></div><div class="border"><iframe frameborder="0" scrolling="no" src="'+PDV_RP+'base/admin/plusset.php?divid='+obj_id+'" class="plusFrm"></iframe></div>');
							$.blockUI({message:$('#plusWindow'),css:{width:'680px',top:'20px'}}); 
							$('.pwClose').click(function() { 
								$.unblockUI(); 
							}); 
						}else{
							alert("頁面資訊保存失敗，錯誤資訊："+msg);
						}
					}
				});

			});

			//刪除元件
			$(obj_setremove).click(function() {
				
				$.ajax({
					type: "POST",
					url: PDV_RP+"base/post.php",
					data: "act=plusdel&pdvid="+obj_id,
					success: function(msg){
						
						if(msg=="OK"){
							$("div#"+obj_id).remove();
							$("li#now"+obj_id.substr(2)).remove();
							$().adminSetBg();
							$().plusGetModule(getCookie("SMD"));
						}else{
							alert("刪除元件失敗，錯誤資訊："+msg);
						}
					
					}
				});
				
				$().unbind('keydown',$.jqDnR.keydrag);

			});
		});


		//右鍵選單初始化

		var getObj = $('div.pdv_class');
	
		$('div.pdv_class').contextMenu('contextMenu', {
		bindings: {
			'cm_up': function(t) {
				var zlen   = getObj.length;
				getObj.each(function(id) {
					if(this.style.zIndex > t.style.zIndex){
						this.style.zIndex--;
					}
				});
				t.style.zIndex = zlen;
			},
			'cm_top': function(t) {
				var tmp=0;
				getObj.each(function(id) {
					if(this.style.zIndex-1 == t.style.zIndex){
						tmp = this.style.zIndex;
						this.style.zIndex--;
					}
				});
				t.style.zIndex = tmp==0?t.style.zIndex:tmp;
			},
			'cm_under': function(t) {
				var tmp=1;
				getObj.each(function(id) {
					if(this.style.zIndex+1 == t.style.zIndex){
						tmp = this.style.zIndex;
						this.style.zIndex++;
					}
				});
				t.style.zIndex = tmp;
			},
			'cm_down': function(t) {
				getObj.each(function(id) {
					if(this.style.zIndex < t.style.zIndex){
						this.style.zIndex++;
					}
				});
				t.style.zIndex = 1;
			},
			'cm_copy': function(t) {
				//$().savePlus(0);
				var copyid=t.id;
				$.ajax({
						type: "POST",
						url: PDV_RP+"base/post.php",
						data: "act=pluscopyme&pdvid="+copyid,
						success: function(msg){
							if(msg.substr(0,2)=="OK"){
								var backpdvid="pdv_"+msg.substr(3);
								var containdiv=$(t).parents()[0].id;
								$().plusAddBack(backpdvid,containdiv);

							}else if(msg=="1000"){
								alert("該元件不存在，可能已經被刪除，請更新頁面再試");
							}else if(msg=="1001"){
								alert("該元件不可重複插入，不能複製");
							}else{
								alert("複製元件失敗，錯誤資訊："+msg);
							}
						}
					});
			},
			'cm_hide': function(t) {
				t.style.display='none';
				$().adminSetBg();
			}
		 }
		});

	
	};
	
})(jQuery);




/**
* Drag+Resize
* 拖動和調整相結合
*/
(function($){
	$.fn.Drag = function(h){
		return i(this,h,'d');
	};
	$.fn.Resize = function(h){
		return i(this,h,'r');
	};
	
	$.jqDnR={
		dnr:{},
		e:0,
		drag:function(v){
			
			var maxR=parseInt(E.parents().css('width'));

			//容器名稱
			var CNT=E.parents()[0].id,CNTNAME,DT,DL;
			switch(CNT){
				case "top":
					CNTNAME="頂部";
				break;
				case "content":
					CNTNAME="中間";
				break;
				case "bottom":
					CNTNAME="底部";
				break;
				case "bodyex":
					CNTNAME="外側";
				break;
			}

				
			//外框高度計算
			var BTOT=2;
			var bbw=TB.css("borderWidth");
			var bbp=TB.css("padding");
			var bbm=TB.css("margin");
			if(bbm=="auto"){bbm=0}
			bbw ? BTOT+=parseInt(bbw)*2 : BTOT+=0 ;
			bbp ? BTOT+=parseInt(bbp)*2 : BTOT+=0 ;
			bbm ? BTOT+=parseInt(bbm)*2 : BTOT+=0 ;
	
			if(M.k == 'd'){
				var EL=M.X+v.pageX-M.pX;
				var ER=EL+M.W;
				if(ER>=maxR){EL=maxR-M.W}
				

				E.css({left:Math.max(0,EL),top:Math.max(0,M.Y+v.pageY-M.pY)});
				TB.css({height:E[0].offsetHeight-BTOT+"px"});

				DT=E.css('top');
				if(ER>=maxR){DL=EL-113}else{DL=ER+3}

				$("#plus_data").appendTo(E.parents()[0]).css({left:DL,top:DT,opacity:0.9});
				$("#plus_data").show().html("編號："+E[0].id.substr(4)+"<br/>容器："+CNTNAME+"<br/>頂距："+E.css('top')+"<br />左距："+E.css('left')+"<br />寬度："+E.css('width')+"<br />高度："+E.css('height')); 

			}else{

				var EW=v.pageX-M.pX+M.W;
				var ER=EW+M.X;
				if(ER>=maxR){EW=maxR-M.X}
				
				E.css({width:Math.max(EW,30),height:Math.max(v.pageY-M.pY+M.H,20)});
				TB.css({height:E[0].offsetHeight-BTOT+"px"});
				
				DT=E.css('top');
				if(ER>=maxR){DL=maxR+3}else{DL=ER+3}

				$("#plus_data").appendTo(E.parents()[0]).css({left:DL,top:DT,opacity:0.9});
				$("#plus_data").show().html("編號："+E[0].id.substr(4)+"<br/>容器："+CNTNAME+"<br/>頂距："+E.css('top')+"<br />左距："+E.css('left')+"<br />寬度："+E.css('width')+"<br />高度："+E.css('height')); 
			}

			return false;
		},

		//鍵盤操作
		keydrag:function(v){
			
			E.css({border:"1px #5e99d5 solid",zIndex:"99"});
			T.css({opacity:"0.6",backgroundColor:"#07aaf8"});

			var maxR=parseInt(E.parents().css('width'));


			//容器名稱
			var CNT=E.parents()[0].id,CNTNAME,DT,DL;
			switch(CNT){
				case "top":
					CNTNAME="頂部";
				break;
				case "content":
					CNTNAME="中間";
				break;
				case "bottom":
					CNTNAME="底部";
				break;
				case "bodyex":
					CNTNAME="外側";
				break;
			}

				
			//外框高度計算
			var BTOT=2;
			var bbw=TB.css("borderWidth");
			var bbp=TB.css("padding");
			var bbm=TB.css("margin");
			if(bbm=="auto"){bbm=0}
			bbw ? BTOT+=parseInt(bbw)*2 : BTOT+=0 ;
			bbp ? BTOT+=parseInt(bbp)*2 : BTOT+=0 ;
			bbm ? BTOT+=parseInt(bbm)*2 : BTOT+=0 ;

			

			//ctrl+箭頭改變尺寸
			if(v.ctrlKey){

				var EW=parseInt(E.css('width'));
				var EH=parseInt(E.css('height'));
				var EL=parseInt(E.css('left'));

				if(v.which == 37){
					EW=EW-1;
				}
				if(v.which == 38){
					EH=EH-1;
				}
				if(v.which == 39){
					EW=EW+1;
				}
				if(v.which == 40){
					EH=EH+1;
				}

				var ER=EW+EL;
				if(ER>=maxR){EW=maxR-EL}
				
				E.css({width:Math.max(EW,30),height:Math.max(EH,20)});
				TB.css({height:E[0].offsetHeight-BTOT+"px"});
				
				DT=E.css('top');
				if(ER>=maxR){DL=maxR+3}else{DL=ER+3}

				$("#plus_data").appendTo(E.parents()[0]).css({left:DL,top:DT,opacity:0.9});
				$("#plus_data").show().html("編號："+E[0].id.substr(4)+"<br/>容器："+CNTNAME+"<br/>頂距："+E.css('top')+"<br />左距："+E.css('left')+"<br />寬度："+E.css('width')+"<br />高度："+E.css('height')); 


			//按箭頭移動
			}else{

				var KC=v.keyCode;
				var EL=parseInt(E.css('left'));
				var ET=parseInt(E.css('top'));
				var EW=parseInt(E.css('width'));

				switch(KC){
					case  37:
						EL=EL-1;
					break;
					case  38:
						ET=ET-1;
					break;
					case  39:
						EL=EL+1;
					break;
					case  40:
						ET=ET+1;
					break;
					case  9:
						EL=EL+30;
					break;
					case  46:
							//刪除元件	
							var delobjid=E[0].id;
							$.ajax({
								type: "POST",
								url: PDV_RP+"base/post.php",
								data: "act=plusdel&pdvid="+delobjid,
								success: function(msg){
									if(msg=="OK"){
										$("div#"+delobjid).remove();
										$("li#now"+delobjid.substr(2)).remove();
										$().adminSetBg();
										$().plusGetModule(getCookie("SMD"));
									}else{
										alert("刪除元件失敗，錯誤資訊："+msg);
									}
								
								}
							});

							$().unbind('keydown',J.keydrag);

					break;

					default:
						return false;
					break;
				}

					var ER=EL+EW;
					if(ER>=maxR){EL=maxR-EW}

					E.css({left:Math.max(0,EL),top:Math.max(0,ET)});
					TB.css({height:E[0].offsetHeight-BTOT+"px"});

					DT=E.css('top');
					if(ER>=maxR){DL=EL-113}else{DL=ER+3}

					$("#plus_data").appendTo(E.parents()[0]).css({left:DL,top:DT,opacity:0.9});
					$("#plus_data").show().html("編號："+E[0].id.substr(4)+"<br/>容器："+CNTNAME+"<br/>頂距："+E.css('top')+"<br />左距："+E.css('left')+"<br />寬度："+E.css('width')+"<br />高度："+E.css('height')); 

			}



			
			return false;
		
		},


		//停止
		stop:function(){
			$().unbind('mousemove',J.drag).unbind('mouseup',J.stop);
			T.css({opacity:1,backgroundColor:''});
			E.css({border:'1px #ccc dotted',zIndex:M.z});
			$("#plus_data").hide();
			$().adminSetBg();
		}
	};


	var J=$.jqDnR,M=J.dnr,E=J.e,H,T,TB,
	i=function(e,h,k){
			return e.each(
				function(){
					h=(h)?$(h,e):e;
					h.bind('mousedown',{e:e,k:k},function(v){
						
						var d=v.data,p={};
						E=d.e;
						T=E.children(".pdv_drag");
						TB=E.children().children(".pdv_border");

						if(E.css('position') != 'relative'){
							try{
								E.position(p);
							}
							catch(e){}
						}
						M={X:p.left||f('left')||0,Y:p.top||f('top')||0,W:f('width')||E[0].scrollWidth||0,H:f('height')||E[0].scrollHeight||0,pX:v.pageX,pY:v.pageY,k:d.k,o:T.css('opacity'),z:E.css('zIndex'),bo:E.css('borderColor'),bs:E.css('borderStyle'),tc:T.css('backgroundColor')};
						
						E.css({border:"1px #5e99d5 solid",zIndex:"99"});
						T.css({opacity:"0.6",backgroundColor:"#07aaf8"});

						H=h;
						
						$().mousemove($.jqDnR.drag).keydown($.jqDnR.keydrag).mouseup($.jqDnR.stop).keyup($.jqDnR.stop);
						return false;
					});

				}
			);
	},
	f=function(k){
		return parseInt(E.css(k))||false;
	};
})(jQuery);



/**
* contextMenu
* 右鍵選單，
*/

(function($) {

  var menu, shadow, trigger, content, hash, currentTarget;
  var defaults = {
    menuStyle: {
      listStyle: 'none',
      padding: '5px',
      margin: '0px',
      backgroundColor: '#fff',
      border: '1px solid #999',
      width: '100px'
    },
    itemStyle: {
      margin: '0px',
      color: '#000',
      display: 'block',
      cursor: 'default',
      padding: '3px',
	  paddingLeft: '28px',
	  lineHeight: '20px',
      border: '1px solid #fff',
      backgroundColor: 'transparent',
	  width: '68px',
	  height: '20px'
    },
    itemHoverStyle: {
      border: '1px solid #0a246a',
      backgroundColor: '#b6bdd2'
    },
    eventPosX: 'pageX',
    eventPosY: 'pageY',
    shadow : true,
    onContextMenu: null,
    onShowMenu: null
 	};

  $.fn.contextMenu = function(id, options) {
    if (!menu) {                                      // 建立單個選單
      menu = $('<div id="jqContextMenu"></div>')
               .hide()
               .css({position:'absolute', zIndex:'500'})
               .appendTo('body')
               .bind('click', function(e) {
                 e.stopPropagation();
               });
    }
    if (!shadow) {
      shadow = $('<div></div>')
                 .css({backgroundColor:'#000',position:'absolute',opacity:0.2,zIndex:499})
                 .appendTo('body')
                 .hide();
    }
    hash = hash || [];
    hash.push({
      id : id,
      menuStyle: $.extend({}, defaults.menuStyle, options.menuStyle || {}),
      itemStyle: $.extend({}, defaults.itemStyle, options.itemStyle || {}),
      itemHoverStyle: $.extend({}, defaults.itemHoverStyle, options.itemHoverStyle || {}),
      bindings: options.bindings || {},
      shadow: options.shadow || options.shadow === false ? options.shadow : defaults.shadow,
      onContextMenu: options.onContextMenu || defaults.onContextMenu,
      onShowMenu: options.onShowMenu || defaults.onShowMenu,
      eventPosX: options.eventPosX || defaults.eventPosX,
      eventPosY: options.eventPosY || defaults.eventPosY
    });

    var index = hash.length - 1;
    $(this).bind('contextmenu', function(e) {
      //檢查onContextMenu()是否定義
      var bShowContext = (!!hash[index].onContextMenu) ? hash[index].onContextMenu(e) : true;
      if (bShowContext) display(index, this, e, options);
      return false;
    });
    return this;
  };

  function display(index, trigger, e, options) {
    var cur = hash[index];
    content = $('#'+cur.id).find('ul:first').clone(true);
    content.css(cur.menuStyle).find('li').css(cur.itemStyle).hover(
      function() {
        $(this).css(cur.itemHoverStyle);
      },
      function(){
        $(this).css(cur.itemStyle);
      }
    ).find('img').css({verticalAlign:'middle',paddingRight:'2px'});

    //把內容添加到選單
    menu.html(content);

    //如果有onShowMenu,馬上運行 -- 必須在內容已添加之後運行
	//如果你想在menu.html()前改變內容, IE6有問題
	//更新內容
    if (!!cur.onShowMenu) menu = cur.onShowMenu(e, menu);

    $.each(cur.bindings, function(id, func) {
      $('#'+id, menu).bind('click', function(e) {
        hide();
        func(trigger, currentTarget);
      });
    });

    menu.css({'left':e[cur.eventPosX],'top':e[cur.eventPosY]}).show();
    if (cur.shadow) shadow.css({width:menu.width(),height:menu.height(),left:e.pageX+2,top:e.pageY+2}).show();
    $(document).one('click', hide);
  }

  function hide() {
    menu.hide();
    shadow.hide();
  }

  //預設應用
  $.contextMenu = {
    defaults : function(userDefaults) {
      $.each(userDefaults, function(i, val) {
        if (typeof val == 'object' && defaults[i]) {
          $.extend(defaults[i], val);
        }
        else defaults[i] = val;
      });
    }
  };

})(jQuery);




/**
* adminSetBg
* 當頁面內容動態變動時,重新調整各層及背景高度
*/
(function($){
	$.fn.adminSetBg = function(){
		var getDrag = $('div.pdv_class');
		getDrag.each(function(id) {
			var obj = this.id;
			if($("#s"+obj)[0].style.overflow=="visible"){
				
				//設置可溢出層拉動時的最小高度
				$("#"+obj)[0].style.minHeight=$("#s"+obj)[0].offsetHeight +"px";
			
			}else{
				
				//設置元件邊框層的高度
				
				var borderH=$("#s"+obj)[0].offsetHeight;
				var bbw=$("#s"+obj).find(".pdv_border").css("borderWidth");
				var bbp=$("#s"+obj).find(".pdv_border").css("padding");
				var bbm=$("#s"+obj).find(".pdv_border").css("margin");

				if(bbm=="auto"){bbm=0}

				bbw ? borderH-=parseInt(bbw)*2 : borderH-=0 ;
				bbp ? borderH-=parseInt(bbp)*2 : borderH-=0 ;
				bbm ? borderH-=parseInt(bbm)*2 : borderH-=0 ;

				$("#s"+obj).children(".pdv_border")[0].style.height=borderH +"px";
				
			}
		});


		//計算三個容器的高度

		var getObj = $('div.pdv_top');
		var th=0,h=0;
		getObj.each(function(id) {
			
			var obj = this.id;
			h=$("#"+obj).parents()[0].offsetTop + $("#"+obj).parents()[0].offsetHeight;
			th = th>h?th:h;
		});
		$("#top")[0].style.height = th + "px";
		$("#topbgout")[0].style.height = th + "px";
		

		var getObj = $('div.pdv_content');
		var ch=0,h=0;
		getObj.each(function(id) {
			var obj = this.id;

			h=$("#"+obj).parents()[0].offsetTop + $("#"+obj).parents()[0].offsetHeight;
			ch = ch>h?ch:h;
		});
		var cp = parseInt($("#content").css("margin-top"))*2;
		var chout = ch + cp;
		$("#content")[0].style.height = ch + "px";
		$("#contentbgout")[0].style.height = chout + "px";


		var getObj = $('div.pdv_bottom');
		var bh=0,h=0;
		getObj.each(function(id) {
			var obj = this.id;
			h=$("#"+obj).parents()[0].offsetTop + $("#"+obj).parents()[0].offsetHeight;
			bh = bh>h?bh:h;
		});
		
		$("#bottom")[0].style.height = bh + "px";
		$("#bottombgout")[0].style.height = bh + "px";
		

	};
})(jQuery);



//排版狀態背景跟隨
function backFollowIn() {
		
		var oldpos=$("input#backFollow")[0].value;

		switch(oldpos){
			case "left top":
				$("body")[0].style.backgroundPosition="left 290px";
			break;
			case "center top":
				$("body")[0].style.backgroundPosition="center 290px";
			break;
			case "right top":
				$("body")[0].style.backgroundPosition="right 290px";
			break;
			case "left bottom":
				return false;
			break;
			case "center bottom":
				return false;
			break;
			case "right bottom":
				return false;
			break;
			default:
				$("body")[0].style.backgroundPosition="left 290px";
			break;
		}
		
}

function backFollowOut() {
		
		var oldpos=$("input#backFollow")[0].value;

		switch(oldpos){
			case "left top":
				$("body")[0].style.backgroundPosition="left 2px";
			break;
			case "center top":
				$("body")[0].style.backgroundPosition="center 2px";
			break;
			case "right top":
				$("body")[0].style.backgroundPosition="right 2px";
			break;
			case "left bottom":
				return false;
			break;
			case "center bottom":
				return false;
			break;
			case "right bottom":
				return false;
			break;
			default:
				$("body")[0].style.backgroundPosition="left 2px";
			break;
		}
}

function rgb2hex(rgb) {
 rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
 function hex(x) {
  return ("0" + parseInt(x).toString(16)).slice(-2);
 }
 return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
}

-->