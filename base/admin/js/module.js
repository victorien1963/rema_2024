<!--
	
$(document).ready(function(){
	
//修改模組簡稱
	$("input.modiname").mouseover(function(){
		var nowname,oldname,snameid;
		$(this)[0].className="modiname_now";
		$(this).removeAttr("readonly");
		
		$(this).mouseout(function(){
			$(this)[0].className="modiname";
			$(this).attr("readonly","readonly");
		});
		$(this).focus(function(){
			oldname=$(this)[0].value;
		});
		$(this).blur(function(){
			nowname=$(this)[0].value;
			$(this).unbind('blur');
			if(oldname!=nowname){
				snameid=this.id.substr(6);

				$.ajax({
					type: "POST",
					url:"post.php",
					data: "act=modiname&id="+snameid+"&nowname="+nowname,
					success: function(msg){
						if(msg=="OK"){
							$.blockUI({message: "新簡稱已經設定完成",css:{width: '200px',backgroundColor: '#fff',borderColor:'#999999'}}); 
							setTimeout('$.unblockUI();',500);
						}else{
							alert(msg);
						}
					}
				});
				
			}
		});

	});
	
	$(".setmoduleconfig").click(function(){	
	var modid=this.id.substr(6);
	$('#frmWindow').remove();
	$("body").append("<div id='frmWindow'></div>");
	$('#frmWindow').append('<div class="topBar">元件參數修改<div class="pwClose"></div></div><div class="border"><iframe frameborder="0" scrolling="yes" src="plus_config.php?modid='+modid+'" class="Frm" style="width:760px;height:460px;"></iframe></div>');
	$.blockUI({message:$('#frmWindow'),css:{top:  ($(window).height() - 500) /2 + 'px',width:'760px'}});
	$('.pwClose').click(function() {
	 			$.unblockUI();
	 			 		}); 
	});
	$(".setmoduleedit").click(function(){	
	var modname=this.id.split("_");
	var modnamefile = modname[1].substr(3);
	$('#frmWindow').remove();
	$("body").append("<div id='frmWindow'></div>");
	$('#frmWindow').append('<div class="topBar">元件PHP修改<div class="pwClose"></div></div><div class="border"><iframe frameborder="0" scrolling="no" src="plus_edit.php?col='+modname[0]+'&gfile='+modnamefile+'" class="Frm" style="width:760px;height:460px;"></iframe></div>');
	$.blockUI({message:$('#frmWindow'),css:{top:  ($(window).height() - 500) /2 + 'px',width:'760px'}});
	$('.pwClose').click(function() {
	 			$.unblockUI();
	 			 		}); 
	});

	//模版刪除
	$(".tempdel").click(function(){
		var tempid=this.id.substr(4);
		delItem(tempid);
	});

	//自訂模版刪除
	$(".tempmydel").click(function(){
		var tempid=this.id.substr(4);
		var coltype=this.name;
		delMyItem(tempid,coltype);
	});
	
	//添加模版
	$("#addtemp").click(function(){
		var pluslable=$("#addtemppluslable")[0].value;
		var cname=$("#addtempcname")[0].value;
		var tempname=$("#addtempname")[0].value;
		if(cname=="" || tempname==""){
			alert("請填寫模版名稱和模版文件名");
			return false;
		}

		$.ajax({
			type: "POST",
			url: "post.php",
			data: "act=tempadd&pluslable="+pluslable+"&cname="+cname+"&tempname="+tempname,
			success: function(msg){
					$("#plustemplist").append(msg);
					$(".tempdel").click(function(){
						var tempid=this.id.substr(4);
						delItem(tempid);
					});
			}
		});
	});
	
	/*匯入模版*/
	$('#plusTempInput').submit(function(){
		var cname=$("#inputtempname")[0].value;		
		if(cname==""){
			alert("請填寫模版名稱");
			return false;
		}

		$('#plusTempInput').ajaxSubmit({
			target: 'div#notice',
			url: 'post.php',
			success: function(msg) {
				switch(msg){
					case "1001":
						alert("您的檔案中未包含模版檔(*.htm)，模板檔需以「.htm」為附檔名");
						return false;
					break;
					case "1002":
						alert("您的壓縮檔中只能有一個.htm模版檔");
						return false;
					break;
					case "ZIP":
						alert("請上傳「ZIP」模版壓縮檔");
						return false;
					break;
					default :
						//$("#plustemplist").append(msg);
						window.location.reload();
						$(".tempdel").click(function(){
							var tempid=this.id.substr(4);
							delItem(tempid);
						});
					break;
				}
			}
		}); 
       return false; 
	});

	//添加自訂模版
	$(".tempmycopy").click(function(){
		var tempid=this.id.substr(5);
		var coltype=this.name;
		$.ajax({
			type: "POST",
			url: "post.php",
			data: "act=getmytempid",
			success: function(msg){
				addtempname.value=msg+".htm";
			}
		});
		
		$("#frmWindow").remove();
		$("body").append("<div id='frmWindow'></div>");
		$("#frmWindow").append("<div class='topBar'>複製模板<div class='pwClose'></div></div><div class='border'><div id='copyborder' style='background:#fff;padding:10px;'>模版名稱:<input type='text' id='addtempcname' class='input' size='18' value=''/> 模版文件:<input type='text' id='addtempname' class='input' size='18' value='' readonly/> <input type='button' id='or_"+tempid+"' name='"+coltype+"'  value='複製模板' class='addmytemp' /></div></div>");

		$.blockUI({message:$("#frmWindow"),css:{top:  ($(window).height() - 500) /2 + 'px',width:'460px'}}); 
		$(".pwClose").click(function() { 
			$.unblockUI(); 
		});
	$(".addmytemp").click(function(){
		var pluslable=$("#addtemppluslable")[0].value;
		var cname=$("#addtempcname")[0].value;
		var tempname=$("#addtempname")[0].value;
		var coltype=this.name;
		if(cname=="" || tempname==""){
			alert("請填寫模版名稱和模版文件名");
			return false;
		}
		if(tempname.substr(0,4) == "tpl_"){
			alert("模版文件名開頭不需填寫: tpl_");
			return false;
		}
		
		$.ajax({
			type: "POST",
			url: "post.php",
			data: "act=mytempadd&pluslable="+pluslable+"&cname="+cname+"&tempname=tpl_p_"+tempname+"&coltype="+coltype+"&tempid="+tempid,
			success: function(msg){
					//$("#plustemplist").append(msg);
					$.unblockUI(); 
					window.location.reload();
					$(".tempmydel").click(function(){
						var tempid=this.id.substr(4);
						var coltype=this.name;
						delMyItem(tempid,coltype);
					});
			}
		});
		});
	});
	//導出元件
	$(".plusoutput").click(function(){
		var pluslable=this.id.substr(3);
		window.location='plusoutput.php?pluslable='+pluslable;
	});


	//導入元件
	$('#plusInput').submit(function(){

		$('#plusInput').ajaxSubmit({
			target: 'div#notice',
			url: 'post.php',
			success: function(msg) {
				
				switch(msg){
					case "1001":
						alert("您的檔案中未包含元件記錄檔(plusIntall_*.dat)\n\n或您的壓縮檔檔名與元件記錄檔不符合");
						return false;
					break;
					case "1002":
						alert("元件安裝文件內容格式不正確");
						return false;
					break;
					case "1003":
						alert("您導入的元件記錄已存在");
						return false;
					break;
					case "ZIP":
						alert("請上傳「ZIP」元件壓縮檔");
						return false;
					break;
					case "OK":
						alert("元件記錄導入成功");
						window.location.reload();
					break;
					default :
						alert(msg);
					break;



				}
				
			}
		}); 
		
       return false; 

   }); 



   //模組安裝
   $("#instbutton").click(function(){
		var icoltype=$("#instcoltype")[0].value;
		
		$.ajax({
			type: "POST",
			url: "post.php",
			data: "act=colinstall&coltype="+icoltype,
			success: function(msg){
				if(msg=="OK"){
					alert("模組安裝成功，請更新管理系統視窗！如果有打開的排版視窗，請關閉並在登入後重新進入排版模式");
					window.top.location="index.php";
				}else if(msg=="1000"){
					alert("缺少模組原始碼");
				}else if(msg=="1001"){
					alert("模組已存在，不能重複安裝");
				}else if(msg=="1002"){
					alert("模組安裝資料文件不存在，請檢查模組是否上傳");
				}else if(msg=="1003"){
					alert("模組安裝資料文件格式錯誤");
				}else if(msg=="1009"){
					alert("模組版本高於目前系統版本，請先升級系統");
				}else{
					alert(msg);
				}
			}
		});
	});


   //模組卸載
   $(".uninstall").click(function(){

		var icoltype=this.id.substr(10);

				$.ajax({
					type: "POST",
					url: "post.php",
					data: "act=coluninstallcheck",
					success: function(msg){
						if(msg=="OK"){
							$.ajax({
								type: "POST",
								url: "post.php",
								data: "act=uninstall&coltype="+icoltype,
								success: function(msg){
									if(msg=="OK"){
										if(icoltype=="member"){
											alert("會員模組是一個特殊關聯模組,卸載僅刪除後台選單和相關管理權限,其他模組中和會員相關的元件和模板連結可能需要人工刪除");
										}
										if(icoltype=="comment"){
											alert("評論模組是一個特殊關聯模組,卸載僅刪除後台選單和相關管理權限,其他模組中和評論相關的元件和模板連結可能需要人工刪除");
										}
										alert("模組已卸載，請更新管理系統視窗！如果有打開的排版視窗，請關閉並在登入後重新進入排版模式");
										$.unblockUI(); 
										$("#tr_"+icoltype).remove();
										window.top.location="index.php";
									}else if(msg=="0000"){
										alert("缺少模組原始碼");
									}else if(msg=="1000"){
										alert("模組不存在");
									}else if(msg=="1001"){
										alert("該模組不可卸載");
									}else if(msg=="1002"){
										alert("資料卸載文件不存在");
									}else if(msg=="1003"){
										alert("資料卸載文件格式錯誤");
									}else{
										alert(msg);
									}
								}
							});


						}else if(msg=="1005"){
							alert("軟體授權校驗無法連接遠端伺服器");
						}else if(msg=="1006"){
							alert("授權用戶名或密碼錯誤，軟體授權校驗未通過");
						}else if(msg=="ERROR"){
							alert("軟體授權校驗失敗，未獲得遠端伺服器預期回應");
						}else{
							alert(msg);
						}
						$.unblockUI(); 
					}
				});

		
   });


	//刪除邊框
	$(".borderdel").click(function(){
		var tempid=this.id.substr(4);
		delBorder(tempid);
	});
	//刪除自訂邊框
	$(".bordercopydel").click(function(){
		var tempid=this.id.substr(4);
		delCopyBorder(tempid);
	});
	
	//預覽邊框
	$(".borderprev").click(function(){
		var pretempid=this.id.substr(5);
			var pretempid = "A"+pretempid;
		$("#frmWindow").remove();
		$("body").append("<div id='frmWindow'></div>");
		$("#frmWindow").append("<div class='topBar'>邊框預覽<div class='pwClose'></div></div><div class='border'><div id='previewborder' style='background:#fff'></div></div>");

		$.blockUI({message:$("#frmWindow"),css:{top:  ($(window).height() - 500) /2 + 'px',width:'360px'}}); 
		$(".pwClose").click(function() { 
			$.unblockUI(); 
		});

		$.ajax({
			type: "POST",
			url: "post.php",
			data: "act=previewborder&borderid="+pretempid+"&coltitle=邊框預覽",
			success: function(msg){
				$("#previewborder").html(msg);
			}
		});
		
	});

	//編輯邊框
	$(".bordermodi").click(function(){
		var pretempid=this.id.substr(7);

		window.open( "../../editpro/ref.php?mode=border&indir="+pretempid , "邊框編輯" , "toolbar=no,location=no,directories=no,status=no,menubar=no,resizable=yes,scrollbars=yes,width=860,height=500"); 
		
	});
	$(".sysbordermodi").click(function(){
		var pretempid=this.id.substr(5);

		window.open( "../../editpro/ref.php?mode=../base/border/&indir="+pretempid , "邊框編輯" , "toolbar=no,location=no,directories=no,status=no,menubar=no,resizable=yes,scrollbars=yes,width=860,height=500"); 
		
	});
	//編輯模板
	$(".tempmymodi").click(function(){
		var moditempid=this.id.substr(5);
		var tempath = this.name;

		window.open( "../../editpro/ref.php?mode=temp&indir="+moditempid+"&tempath="+tempath , "邊框模板" , "toolbar=no,location=no,directories=no,status=no,menubar=no,resizable=yes,scrollbars=yes,width=860,height=500"); 
		
	});
	
	//添加邊框
	$("#addborder").click(function(){
		var tempid=$("#bordertempid")[0].value;
		var tempname=$("#bordertempname")[0].value;
		var bordertype=$("#bordertype")[0].value;
		var borderselcolor=$("#borderselcolor")[0].value;
		var bordertname=$("#bordertype option[@selected]").text();

		if(tempid=="" || tempname==""){
			alert("請填寫邊框編號和邊框描述");
			return false;
		}
		

		if(bordertype=="lable"){
			if(borderselcolor=="yes" && (tempid.substr(0,1)!="0" || tempid=="0" ||parseInt(tempid.substr(1))<51 || parseInt(tempid.substr(1))>99)){
				alert("可選顏色標籤邊框的可用編號範圍是051-099,必須以0開頭");
				return false;
			}
			if(borderselcolor=="no" && (parseInt(tempid)<201 || parseInt(tempid)>499)){
				alert("不可選顏色標籤邊框的可用編號範圍是201-499");
				return false;
			}
		}


		if(bordertype=="border"){
			if(borderselcolor=="yes" && (tempid.substr(0,1)!="0" || tempid=="0" || parseInt(tempid.substr(1))<1 || parseInt(tempid.substr(1))>50)){
				alert("可選顏色元件邊框的可用編號範圍是001-050,必須以0開頭");
				return false;
			}
			if(borderselcolor=="no" && (parseInt(tempid)<500 || parseInt(tempid)>999)){
				alert("不可選顏色元件邊框的可用編號範圍是500-999");
				return false;
			}
		}


		$.ajax({
			type: "POST",
			url: "post.php",
			data: "act=borderadd&tempid="+tempid+"&tempname="+tempname+"&bordertype="+bordertype,
			success: function(msg){
				if(msg=="1001"){
					alert("同樣的邊框編號已存在");
					return false;
				}else if(msg=="OK"){
					alert("邊框添加成功");
					$("#borderlist").append("<tr id='tr_"+tempid+"'><td height='22'>"+bordertname+"</td><td height='22'>"+tempid+"</td><td>"+tempname+"</td><td width='60' ><img id='del_"+tempid+"' src='images/delete.png' class='borderdel' /> </td></tr>");
					$(".borderdel").click(function(){
						var tempid=this.id.substr(4);
						delBorder(tempid);
					});
				}else{
					alert(msg);
				}
				
			}
		});
	});

//添加特約商複製邊框
	$(".bordercopy").click(function(){
		var tempid=this.id.substr(5);
		var bordertype=this.name;
		
		
		$("#frmWindow").remove();
		$("body").append("<div id='frmWindow'></div>");
		$("#frmWindow").append("<div class='topBar'>複製邊框<div class='pwClose'></div></div><div class='border'><div id='copyborder' style='background:#fff;padding:10px;'>邊框號碼:<input type='text' id='co_"+tempid+"' class='input' size='3' value=''/> 邊框名稱:<input type='text' id='id_"+tempid+"' class='input' size='10' value='複製_"+tempid+"'/> <input type='button' id='or_"+tempid+"' name='"+bordertype+"'  value='複製邊框' class='copyborder' /></div></div>");

		$.blockUI({message:$("#frmWindow"),css:{top:  ($(window).height() - 500) /2 + 'px',width:'360px'}}); 
		$(".pwClose").click(function() { 
			$.unblockUI(); 
		});
$(".copyborder").click(function(){
		
		var copyid=this.id.substr(3);
		var tempid=$("#co_"+copyid)[0].value;
		var bordertype=this.name;
		var tempname=$("#id_"+copyid)[0].value;
		
		if(bordertype=="lable"){
			if(copyid>50 && copyid<100 && (tempid.substr(0,1)!="0" || tempid=="0" ||parseInt(tempid.substr(1))<51 || parseInt(tempid.substr(1))>99)){
				alert("可選顏色標籤邊框的可用編號範圍是051-099,必須以0開頭");
				return false;
			}
			if(copyid>200 && copyid<500 && (parseInt(tempid)<201 || parseInt(tempid)>499)){
				alert("不可選顏色標籤邊框的可用編號範圍是201-499");
				return false;
			}
		}


		if(bordertype=="border"){
			if(copyid>0 && copyid<51 && (tempid.substr(0,1)!="0" || tempid=="0" || parseInt(tempid.substr(1))<1 || parseInt(tempid.substr(1))>50)){
				alert("可選顏色元件邊框的可用編號範圍是001-050,必須以0開頭");
				return false;
			}
			if(copyid>499 && copyid<1000 && (parseInt(tempid)<500 || parseInt(tempid)>999)){
				alert("不可選顏色元件邊框的可用編號範圍是500-999");
				return false;
			}
		}
		
		$.ajax({
			type: "POST",
			url: "post.php",
			data: "act=bordercopy&copyid="+copyid+"&tempid="+tempid+"&tempname="+tempname+"&bordertype="+bordertype,
			success: function(msg){
				if(msg=="1001"){
					alert("同樣的邊框編號已存在");
					return false;
				}else if(msg=="OK"){
					alert("邊框添加成功");
					$.unblockUI();
					window.location.reload();
					$(".borderdel").click(function(){
						var tempid=this.id.substr(4);
						delBorder(tempid);
					});
				}else{
					alert(msg);
				}
				
			}
		});
	});
		
});

	function delItem(tempid){
		var qus=confirm("刪除模版記錄需要人工添加恢復!確定刪除元件模版記錄嗎?")
		if(qus!=0){
			$.ajax({
				type: "POST",
				url: "post.php",
				data: "act=tempdel&tempid="+tempid,
				success: function(msg){
					if(msg=="OK"){
						$("#tr_"+tempid).remove();
					}else{
						alert(msg);
					}
					
				}
			});
		}
	}
	
	function delMyItem(tempid,coltype){
		var qus=confirm("刪除自訂模版記錄會將所有文件一併刪除!\r\n\r\n確定刪除元件模版記錄嗎?")
		if(qus!=0){
			$.ajax({
				type: "POST",
				url: "post.php",
				data: "act=tempmydel&tempid="+tempid+"&coltype="+coltype,
				success: function(msg){
					if(msg=="OK"){
						$("#tr_"+tempid).remove();
					}else if(msg =="1001"){
						alert("目前有使用這個模板的元件，無法刪除!");
					}else{
						alert(msg);
					}
					
				}
			});
		}
	}

	function delBorder(tempid){
		var qus=confirm("刪除邊框記錄需要人工添加恢復!確定刪除邊框記錄嗎?")
		if(qus!=0){
			$.ajax({
				type: "POST",
				url: "post.php",
				data: "act=borderdel&tempid="+tempid,
				success: function(msg){
					if(msg=="OK"){
						$("#tr_"+tempid).remove();
					}else{
						alert(msg);
					}
					
				}
			});
		}
	}
	function delCopyBorder(tempid){
		var qus=confirm("刪除自訂邊框會將檔案和記錄全部清除!確定刪除自訂邊框嗎?")
		if(qus!=0){
			$.ajax({
				type: "POST",
				url: "post.php",
				data: "act=bordercopydel&tempid="+tempid,
				success: function(msg){
					if(msg=="1001"){
						alert("目前有套用此邊框的元件，不能刪除!");
						return false;
					}else if(msg=="OK"){
						$("#tr_"+tempid).remove();
					}else{
						alert(msg);
					}
					
				}
			});
		}
	}
	
});


-->