
//商品發佈時獲取會員價列表
$(document).ready(function(){
	$('input#newprice').blur(function(){
		var price=$("#newprice")[0].value;
		
		$.ajax({
			type: "POST",
			url:"post.php",
			data: "act=goodsmemberprice&price="+price,
			success: function(msg){
				$("#tr_memberprice").remove();
				$("#tr_price").after(msg);
			}
		});
	});
	
	//配圖隱藏欄位
	$('#hidepic').click(function(){
		$('.hidepic').hide();
		$('.selsub').attr("data-selsub","seltosubpic");
	});
	$('#showpic').click(function(){
		$('.hidepic').show();
		$('.selsub').attr("data-selsub","seltosub");
	});
	
	$('#seltothpic').click(function(){
		$('.hidepic').hide();
		$('#hidepic').attr("checked","checked");
	});
	
	$("#seltothpic").change(function(){
		var getseid = this.value;

		$.ajax({
			type: "POST",
			url:"post.php",
			data: "act=seltothpic&getseid="+getseid,
			success: function(msg){
				$("#showselothpic").html(msg);
			}
		});
		
		return false; 
	});
	
	$(".selsub").change(function(){
		
		
		var getseid = this.value;
		var getpost = $(".selsub").attr("data-selsub");

		$.ajax({
			type: "POST",
			url:"post.php",
			data: "act="+getpost+"&getseid="+getseid,
			success: function(msg){
				$("#showselsub").html(msg);
			}
		});
		
		return false; 
	});
});


//修改商品時讀取會員價
(function($){
	$.fn.getPriceList = function(){
		
		var gid=$("input#nowid")[0].value;
		var price=$("input#modiprice")[0].value;

		$.ajax({
			type: "POST",
			url:"post.php",
			data: "act=modimemberprice&gid="+gid+"&price="+price,
			success: function(msg){
				
				$("#tr_memberprice").remove();
				$("#tr_price").after(msg);
			}
		});
	};
})(jQuery);


//修改商品時，價格變動重新計算價格
$(document).ready(function(){

	$('input#modiprice').blur(function(){
		
		if($("input#modiprice")[0].value!=$("input#oldprice")[0].value){
		
			var price=$("input#modiprice")[0].value;
		
			$.ajax({
				type: "POST",
				url:"post.php",
				data: "act=goodsmemberprice&price="+price,
				success: function(msg){
					$("#tr_memberprice").remove();
					$("#tr_price").after(msg);
				}
			});
		}
		
	});

});



//讀取參數列
(function($){
	$.fn.getPropList = function(){
		$("div#proplist").empty();
		var catid=$("#selcatid")[0].value;
		var nowid=$("#nowid")[0].value;
		$.ajax({
			type: "POST",
			url:"post.php",
			data: "act=proplist&catid="+catid+"&nowid="+nowid,
			success: function(msg){
				$("div#proplist").append(msg);
			}
		});
	};
})(jQuery);


//讀取分類關聯的品牌
(function($){
	$.fn.getCatRelBrand = function(){
		var catid=$("#selcatid")[0].value;
		var nowid=$("#nowid")[0].value;
		$.ajax({
			type: "POST",
			url:"post.php",
			data: "act=getcatrelbrand&catid="+catid+"&nowid="+nowid,
			success: function(msg){
				$("select#brandid").html(msg);
			}
		});
	};
})(jQuery);



//讀取內容翻頁碼
(function($){
	$.fn.getShopPages = function(p){
		
		$("div#shoppages").empty();
		
		var nowid=$("#nowid")[0].value;

		$.ajax({
			type: "POST",
			url:"post.php",
			data: "act=shoppageslist&nowid="+nowid+"&pageinit="+p,
			success: function(msg){
				$("div#shoppages").append(msg);
				
				var nowpagesid=$("input#shoppagesid")[0].value;
				$("li#p_"+nowpagesid)[0].className='now';

				var getObj = $('li.pages');
				getObj.each(function(id) {
					var obj = this.id;
					
					$("li#"+obj).click(function() {
						
						var clickid=obj.substr(2);
						
						if(clickid==0){
							$(".shopmodizone").show();
							$("input#adminsubmit").show();
							$(".savebutton").hide();
							$().getContent(0);
							$().getShopPages(0);
							$("#jpg_main").replaceWith($("#jpg_main").val('').clone(true));
							window.parent.$("body,html").scrollTop(0);
						}else{
							$(".shopmodizone").hide();
							$("input#adminsubmit").hide();
							$(".savebutton").show();
							$().getContent(clickid);
							$().getShopPages(clickid);
							$("#jpg_main").replaceWith($("#jpg_main").val('').clone(true));
							window.parent.$("body,html").scrollTop(0);
						}
					});
				});

				//返回正常模式
				$("li#backtomodi").click(function() {

					$(".shopmodizone").show();
					$("input#adminsubmit").show();
					$(".savebutton").hide();
					$().getContent(0);
					$().getShopPages(0);
					$("#jpg_main").replaceWith($("#jpg_main").val('').clone(true));
				});
				
				//添加分頁
				$("li#addpage").click(function(){


					$.ajax({
						type: "POST",
						url:"post.php",
						data: "act=addpage&nowid="+nowid,
						success: function(msg){
							$().getShopPages('new');
							$(".shopmodizone").hide();
							$("input#adminsubmit").hide();
							$(".savebutton").show();
							$().getContent(-1);
						}
					});
				});

				//刪除目前頁
				$("li#pagedelete").click(function(){


					var delpagesid=$("input#shoppagesid")[0].value;
					
					$.ajax({
						type: "POST",
						url:"post.php",
						data: "act=pagedelete&nowid="+nowid+"&delpagesid="+delpagesid,
						success: function(msg){
							if(msg=="0"){
								//分頁全部刪除時返回正常模式
								$(".shopmodizone").show();
								$("input#adminsubmit").show();
								$(".savebutton").hide();
								$().getContent(0);
								$().getShopPages(0);
								$("#jpg_main").replaceWith($("#jpg_main").val('').clone(true));
								window.parent.$("body,html").scrollTop(0);
							}else{
								$(".shopmodizone").hide();
								$("input#adminsubmit").hide();
								$(".savebutton").show();
								$().getContent(msg);
								$().getShopPages(msg);
								$("#jpg_main").replaceWith($("#jpg_main").val('').clone(true));
								window.parent.$("body,html").scrollTop(0);
							}
							
						}
					});
				});
			}
		});
	};

	
	

})(jQuery);


//讀取組圖
(function($){
	$.fn.getContent = function(shoppageid){
		
		var nowid=$("#nowid")[0].value;
		$.ajax({
			type: "POST",
			url:"post.php",
			data: "act=getcontent&shoppageid="+shoppageid+"&nowid="+nowid,
			success: function(msg){
				msg = msg.split("|");
				if(msg[0]!=""){
					$("#picpriview")[0].src="../../"+msg[0];
					$("#picpriview").show();
					$("#picpriview")[0].style.width="";
					$("#picpriview").load(function(){
						if($("#picpriview")[0].offsetWidth>500){
							$("#picpriview")[0].style.width="500px";
						}
					});
					
					
				}else{
					$("#picpriview").hide();
				}
				
				/**/
				/*if(msg[1]!=""){
					
					$("#picpriview_body")[0].src="../../"+msg[1];
					$("#picpriview_body").show();
					$("#picpriview_body")[0].style.width="";
					$("#picpriview_body").load(function(){
						if($("#picpriview_body")[0].offsetWidth>160){
							$("#picpriview_body")[0].style.width="160px";
						}
					});
					
					
				}else{
					$("#picpriview_main").hide();
				}*/ 
				/**/
				// 
				
				if(msg[2]!=""){
					
					$("#picpriview_canshu")[0].src="../../"+msg[2];
					$("#picpriview_canshu").show();
					$("#picpriview_canshu")[0].style.width="";
					$("#picpriview_canshu").load(function(){
						if($("#picpriview_canshu")[0].offsetWidth>160){
							$("#picpriview_canshu")[0].style.width="160px";
						}
					});
					
					
				}else{
					$("#picpriview_biga").hide();
				}
				console.log(msg);
				if(msg[3]!=""){
					
					$("#picpriview_shape")[0].src="../../"+msg[3];
					$("#picpriview_shape").show();
					$("#picpriview_shape")[0].style.width="";
					$("#picpriview_shape").load(function(){
						if($("#picpriview_shape")[0].offsetWidth>160){
							$("#picpriview_shape")[0].style.width="160px";
						}
					});
					
					
				}
			}
		});
		
	};
})(jQuery);


//選擇分類時更新屬性列
$(document).ready(function() {
		
		$("#selcatid").change(function(){
			$().getPropList();
			$().getCatRelBrand();
		});
});


//得到kedit目前模式
function disignMode(){

	var length=$("#KE_SOURCE")[0].src.length - 10;
	var image=$("#KE_SOURCE")[0].src.substr(length,10);
	if(image=="design.gif"){
		return 0;
	}
	return 1;
}

//獲取瀏覽器類型
function GetBrowser()
{
	var browser = '';
	var agentInfo = navigator.userAgent.toLowerCase();
	if (agentInfo.indexOf("msie") > -1) {
		var re = new RegExp("msie\\s?([\\d\\.]+)","ig");
		var arr = re.exec(agentInfo);
		if (parseInt(RegExp.$1) >= 5.5) {
			browser = 'IE';
		}
	} else if (agentInfo.indexOf("firefox") > -1) {
		browser = 'FF';
	} else if (agentInfo.indexOf("netscape") > -1) {
		var temp1 = agentInfo.split(' ');
		var temp2 = temp1[temp1.length-1].split('/');
		if (parseInt(temp2[1]) >= 7) {
			browser = 'NS';
		}
	} else if (agentInfo.indexOf("gecko") > -1) {
		browser = 'ML';
	} else if (agentInfo.indexOf("opera") > -1) {
		var temp1 = agentInfo.split(' ');
		var temp2 = temp1[0].split('/');
		if (parseInt(temp2[1]) >= 9) {
			browser = 'OPERA';
		}
	}
	return browser;
}

//商品修改時切換介紹和詳細參數
$(document).ready(function() {

	$("#bt_intro").click(function(){
		
		if($("#text_type")[0].value!="body"){
			
			$("#bt_intro")[0].style.backgroundColor="#e8e8e8";
			$("#bt_canshu")[0].style.backgroundColor="#ffffff";
			$("#text_type")[0].value="body";
			$("#mod_intro")[0].style.display="block";
			$("#mod_canshu")[0].style.display="none";
		}
	});

	$("#bt_canshu").click(function(){

		if($("#text_type")[0].value!="canshu"){


			$("#bt_canshu")[0].style.backgroundColor="#e8e8e8";
			$("#bt_intro")[0].style.backgroundColor="#ffffff";
			$("#text_type")[0].value="canshu";
			$("#mod_intro")[0].style.display="none";
			$("#mod_canshu")[0].style.display="block";

		}
	});
	


	
});


//修改表單送出
$(document).ready(function(){
	
	$('#shopForm').submit(function(){
		

		if($("#shoppagesid")[0].value=="0"){
			
			$("#act")[0].value="shopmodify";
			
			
			$(".filedel").remove();
			
			$.blockUI({message: "資料上傳中，請勿關閉或跳出！",css:{width: '200px',backgroundColor: '#fff',borderColor:'#999999'}}); 

			
			$('#shopForm').ajaxSubmit({
				target: 'div#notice',
				url: 'post.php',
				success: function(msg) {
					if(msg=="OK"){
						$('div#notice').hide();
						$.blockUI({message: "商品修改已保存",css:{width: '200px',backgroundColor: '#fff',borderColor:'#999999'}}); 
						setTimeout('window.location="index.php"',1000);
					}else{
						$.unblockUI();
						$('div#notice').hide();
						$().alertwindow(msg,"");
					}
				}
			}); 
		
		}else{
			
			//組圖更新
			$("#act")[0].value="contentmodify";
			
			$('#shopForm').ajaxSubmit({
				target: 'div#notice',
				url: 'post.php',
				success: function(msg) {
					if(msg=="OK"){
						$('div#notice').hide();
						var nowpagesid=$("input#shoppagesid")[0].value;
						$().getContent(nowpagesid);
						window.parent.$("body,html").scrollTop(0);
						$.unblockUI();
					}else{
						$.unblockUI();
						$('div#notice').hide();
						$().alertwindow(msg,"");
					}
				}
			}); 


		}
       return false; 

   }); 
});



//商品發佈表單送出
$(document).ready(function(){
	
	$('#shopAddForm').submit(function(){
		
		$.blockUI({message: "資料上傳中，請勿關閉或跳出！",css:{width: '200px',backgroundColor: '#fff',borderColor:'#999999'}});
		
		$('#shopAddForm').ajaxSubmit({
			
			target: 'div#notice',
			url: 'post.php',
			success: function(msg) {
				if(msg=="OK"){
					$('div#notice').hide();
						$.blockUI({message: "商品發佈成功",css:{width: '200px',backgroundColor: '#fff',borderColor:'#999999'}}); 
						setTimeout('window.location="index.php"',1000);
				}else{
					$.unblockUI();
					$('div#notice').hide();
					$().alertwindow(msg,"");
				}
			}
		}); 
		
       return false; 

   }); 
});



//分類表單
function catCheckform(theform){

  if(theform.cat.value.length < 1 || theform.cat.value=='請填寫分類名稱'){
    $().alertwindow("請填寫分類名稱","");
    theform.cat.focus();
    return false;
}  
	return true;

}

//彈出對話框
function Dpop(url,w,h){
	res = showModalDialog(url, null, 'dialogWidth: '+w+'px; dialogHeight: '+h+'px; center: yes; resizable: no; scroll: no; status: no;');
 	if(res=="ok"){window.location.reload();}
 
}


//切換到分類排版
$(document).ready(function() {
	
	$(".pr_enter").click(function () { 
		var catid=this.id.substr(3);
		var url=$("#href_"+catid)[0].value;
		$.ajax({
			type: "POST",
			url: "../../post.php",
			data: "act=plusenter",
			success: function(msg){
				if(msg=="OK"){
					self.location=url;
				}else{
					$().alertwindow("目前管理帳號沒有排版權限","");
					return false;
				}
			}
		});
		
	 });

	
});


//開設分類專欄
$(document).ready(function() {
	
	$(".setchannel").click(function () { 
		obj=this.id;
		if($("#"+obj)[0].checked==true){
			qus=confirm("將商品分類設為專欄，將建立一個專欄目錄及專欄首頁，可以單獨對專欄首頁進行排版。確定將此分類設置為專欄嗎？")
			if(qus!=0){
				var catid=obj.substr(11);
				$.ajax({
					type: "POST",
					url:"post.php",
					data: "act=addzl&catid="+catid,
					success: function(msg){
						if(msg=="OK"){
							$.ajax({
								type: "POST",
								url: "../../post.php",
								data: "act=plusenter",
								success: function(msg){
									if(msg=="OK"){
										var url="../class/"+catid+"/";
										$().alertwindow("商品分類專欄開設成功,按確定進入排版模式,對專欄首頁進行排版",url);
									}else{
										$().alertwindow("商品分類專欄開設成功,有排版權限的管理員可以對專欄首頁進行排版","");
										return false;
									}
								}
							});
							
						}else{
							$().alertwindow(msg,"");
						}
					}
				});
				$("#"+obj)[0].checked=true;
			}else{
				$("#"+obj)[0].checked=false;
			}
		}else{
			qus=confirm("取消分類專欄，將刪除專欄首頁及其目錄。確定取消專欄嗎？")
			if(qus!=0){
				var catid=obj.substr(11);
				$.ajax({
					type: "POST",
					url:"post.php",
					data: "act=delzl&catid="+catid,
					success: function(msg){
						if(msg=="OK"){
							var url="../class/?"+catid+".html";
							var str="<a href='"+url+"' target='_blank'>http://.../shop/class/?"+catid+".html</a>";
							$("input#href_"+catid)[0].value=url;
							$("td#url_"+catid).html(str);
						}else{
							$().alertwindow(msg,"");
						}
					}
				});
				$("#"+obj)[0].checked=false;
			}else{
				$("#"+obj)[0].checked=true;
			}
		}
	 });
	
});

//開設分類獨立排版
$(document).ready(function() {
	
	$(".setcattemp").click(function () { 
		obj=this.id;
		if($("#"+obj)[0].checked==true){
			qus=confirm("將分類設為獨立排版模式，可以對此分類之下的頁面進行獨立排版。確定將此分類設置為獨立排版模式嗎？")
			if(qus!=0){
				var catid=obj.substr(11);
				var pro=this.pro;
				$.ajax({
					type: "POST",
					url:"post.php",
					data: "act=addcattemp&catid="+catid,
					success: function(msg){
						if(msg=="OK"){
							$.ajax({
								type: "POST",
								url: "../../post.php",
								data: "act=plusenter",
								success: function(msg){
									if(msg=="OK"){
										var url="../class/?"+catid+".html";
										$().alertwindow("分類獨立排版模式開設成功,按確定進入排版模式,對本分類頁進行排版",url);
									}else{
										$().alertwindow("分類獨立排版模式開設成功,有排版權限的管理員可以對分類頁進行排版","");
										return false;
									}
								}
							});
							
						}else{
							$().alertwindow(msg,"");
						}
					}
				});
				$("#"+obj)[0].checked=true;
			}else{
				$("#"+obj)[0].checked=false;
			}
		}else{
			qus=confirm("取消分類獨立排版，會將此分類的排版刪除。確定取消獨立排版嗎？")
			if(qus!=0){
				var catid=obj.substr(11);
				$.ajax({
					type: "POST",
					url:"post.php",
					data: "act=delcattemp&catid="+catid,
					success: function(msg){
						if(msg=="OK"){
							$().alertwindow("取消分類獨立排版成功!","");
						}else{
							$().alertwindow(msg,"");
						}
					}
				});
				$("#"+obj)[0].checked=false;
			}else{
				$("#"+obj)[0].checked=true;
			}
		}
	 });
	
});

//詳情圖片大小處理
$(document).ready(function(){
	$("#picpriview").each(function(){
		if(this.offsetWidth>500){
			this.style.width="500px";
		}
	});
		
});


//圖片預覽
$(document).ready(function(){


	$('.preview').click(function(id){

		var src=$("input#previewsrc_"+this.id.substr(8))[0].value;
		if(src==""){
			return false;
		}

		$("body").append("<img id='pre' src='../../"+src+"'>");

		var w=$("#pre")[0].offsetWidth;
		var h=$("#pre")[0].offsetHeight;
		
		$.blockUI({  
            message: "<img  src='../../"+src+"' class='closeit'>",  
            css: {  
                top:  ($(window).height() - h) /2 + 'px', 
                left: ($(window).width() - w/2) /2 + 'px', 
                width: $("#pre")[0].offsetWidth + 'px',
				backgroundColor: '#fff',
				borderWidth:'3px',
				borderColor:'#fff'
            }  
        }); 

		$("#pre").remove();
        
		$(".closeit").click(function(){
			$.unblockUI(); 
		}); 

        setTimeout($.unblockUI, 2000); 

	}); 
}); 

//添加專題表單送出
$(document).ready(function(){
	
	$('#addProjForm').submit(function(){

		$('#addProjForm').ajaxSubmit({
			target: 'div#notice',
			url: 'post.php',
			success: function(msg) {
				if(msg=="OK"){
					$('div#notice').hide();
					
					$.ajax({
						type: "POST",
						url: "../../post.php",
						data: "act=plusenter",
						success: function(msg){
							if(msg=="OK"){
								var projpath="../project/"+$("#newfolder")[0].value;
								$().alertwindow("專題添加成功,按確定進入排版模式,對本專題主頁進行排版",projpath);
							}else{
								self.location='shop_proj.php';
							}
						}
					});

				}else{
					$('div#notice').hide();
					$().alertwindow(msg,"");
				}
			}
		}); 
		
       return false; 

   }); 
});

//切換到專題排版
$(document).ready(function() {
	
	$(".pdv_enter").click(function () { 
		
		var folder=this.id.substr(3);
		
		$.ajax({
			type: "POST",
			url: "../../post.php",
			data: "act=plusenter",
			success: function(msg){
				if(msg=="OK"){
					self.location="../project/"+folder+"/index.php";
				}else{
					$().alertwindow("目前管理帳號沒有排版權限","");
					return false;
				}
			}
		});
		
	 });
	
});

/**/
var id=0;
function addinput(){
	id++;
	tr = document.createElement('tr');
	tr.id = 'id_'+id;

	tr.style.cssText = 'text-align:left;';
	td0 = document.createElement('td');
	td1 = document.createElement('td');
	td2 = document.createElement('td');
	td0.innerHTML = '&nbsp;';
	td1.innerHTML = '&nbsp;';
	td2.innerHTML = '<input name="spec[name][]" type="text" id="spec[]" maxlength="12" value="" class="input" style="width:60px" />&nbsp;<input name="spec[stocks][]" type="text" id="stocks[]" maxlength="5" value="" class="input" style="width:60px" /> <span class="style1"> *</span>&nbsp;[<a style="cursor:pointer;" onClick="javascript:delinput(\'id_'+id+'\',\'cate\')">-刪除</a>]';
	tr.appendChild(td0);
	tr.appendChild(td1);
	tr.appendChild(td2);
	document.getElementById('cate').appendChild(tr);
}

function delinput(id,idname){
		document.getElementById(''+idname+'').removeChild(document.getElementById(id));
		return true;
}

function setCookie(name,value,Days){
  var exp=new Date();
  exp.setTime(exp.getTime()+Days*24*60*60*1000);
  document.cookie=name+"="+escape(value)+";expires="+exp.toGMTString();
}
function getCookie(name){
  var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
  if(arr=document.cookie.match(reg)) return unescape(arr[2]);
  else return null;
}

/**/
$(document).ready(function(){
$("#spec_cats").change(function(){

		var catid=this.value;
		if( catid>0 ){
		$('#frmWindow').remove();
		$("body").append("<div id='frmWindow'></div>");
		$('#frmWindow').append('<div class="topBar">選擇關聯的商品<div class="pwClose"></div></div><div class="border"><iframe frameborder="0" scrolling="yes" src="sameitem.php?catid='+catid+'" class="Frm"></iframe></div>');
		$.blockUI({message:$('#frmWindow'),css:{width:'350px',top:'10px'}}); 
		$('.pwClose').click(function() { 
			$.unblockUI(); 
		}); 
	}



	});
	$("input#closerelcat").click(function(){
		parent.$.unblockUI();
	});



	$("input#selall").click(function(){
		if($(this)[0].checked==true){
			$("[name='c[]']").attr("checked",'true');
		}else{
			$("[name='c[]']").removeAttr("checked");
		}
	});


	$("input#saverelcat").click(function(){		
		var chkArray= new Array();
		$("input:checkbox:checked[name='c[]']").each(function(i) { chkArray[i] = this.value; });
		if(chkArray !=""){$("input#sameproduct",window.parent.document)[0].value+=$("input#sameproduct",window.parent.document)[0].value? ","+chkArray:chkArray;}		
		parent.$.unblockUI();
	});

	
});

function showhide(blockid,noneid){
  if(blockid != ''){ $('#'+blockid)[0].style.display='block';}
  if(noneid != ''){ $('#'+noneid)[0].style.display='none';}
}

function addColumn(tblId)
{
	var tblBodyObj = document.getElementById(tblId).tBodies[0];
	for (var i=0; i<tblBodyObj.rows.length; i++) {
		var newCell = tblBodyObj.rows[i].insertCell(-1);
		newCell.innerHTML = '[td] row:' + i + ', cell: ' + (tblBodyObj.rows[i].cells.length - 1)
	}
}
function deleteColumn(tblId)
{
	var allRows = document.getElementById(tblId).rows;
	for (var i=0; i<allRows.length; i++) {
		if (allRows[i].cells.length > 1) {
			allRows[i].deleteCell(-1);
		}
	}
}

//刪除多種規格
$(document).ready(function(){
	$(".delspec").click(function(){
				var specid=this.id.substr(6);
				$.ajax({
					type: "POST",
					url:"post.php",
					data: "act=delspec&specid="+specid,
					success: function(msg){
						if(msg=="OK"){
							delinput('spid_'+specid+'','spcate');
						}else{
							$().alertwindow(msg,"");
						}
					}
				});
	});
		
});

//編輯多種規格
$(document).ready(function(){
	$(".fixspec").click(function(){
				var specid=this.id.substr(6);
				var f_size=$("#size_"+specid).val();
				var f_sprice=$("#sprice_"+specid).val();
				var f_stocks=$("#stocks_"+specid).val();
				var f_colorname=$("#colorname_"+specid).val();
				var f_colorcode=$("#colorcode_"+specid).val();
				var f_iconsrc=$("#iconsrc_"+specid).val();
				var f_posbn=$("#posbn").val();
				
				$.ajax({
					type: "POST",
					url:"post.php",
					data: "act=fixspec&specid="+specid+"&f_size="+f_size+"&f_sprice="+f_sprice+"&f_stocks="+f_stocks+"&f_colorname="+f_colorname+"&f_colorcode="+f_colorcode+"&f_iconsrc="+f_iconsrc+"&f_posbn="+f_posbn,
					success: function(msg){
						if(msg=="OK"){
							$().alertwindow("修改完成","");
						}else{
							$().alertwindow(msg,"");
						}
					}
				});
	});
		
});

//刪除規格小圖
$(document).ready(function(){
	$(".button_zone_del").click(function(){
				var specid=this.id.substr(8);
				$.ajax({
					type: "POST",
					url:"post.php",
					data: "act=delspecicon&specid="+specid,
					success: function(msg){
						if(msg=="OK"){
							$("#specicon_"+specid).attr("src","../");
						}else{
							$().alertwindow(msg,"");
						}
					}
				});
	});
		
});

/*寫入價格*/
$(document).ready(function(){
	$("#newprice").blur(function(){ 
			var thisprice = $("#newprice").val();
			$("#sprice").val(thisprice);
	});
	

	
});