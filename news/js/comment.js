
//如果沒有評論，隱藏最新評論層
$(document).ready(function(){
	if($("#commentUl").find("li").html()=="" || $("#commentUl").find("li").html()==null){
		$("#commentList").hide();
	}
});


//根據是否登入顯示發佈表單時的登入資訊
$(document).ready(function(){
	
	$.ajax({
		type: "POST",
		url:PDV_RP+"post.php",
		data: "act=isLogin",
		success: function(msg){
			if(msg=="1"){
				$("div#notLogin").hide();
				$("div#isLogin").show();
				$("span#username").html(getCookie("MUSER"));
				$("input#nomember")[0].checked=false;
			}else{
				$("div#isLogin").hide();
				$("div#notLogin").show();
				$('.loginlink').click(function() { 
					$().popLogin(1);
				});
				$("input#nomember").click(function() { 
					if(this.checked==false){
						$().popLogin(1);
					}
				});
			}
		}
	});
});


//會員退出
$(document).ready(function(){
	
	$('.logoutlink').click(function(){ 
		
		$.ajax({
			type: "POST",
			url: PDV_RP+"post.php",
			data: "act=memberlogout",
			success: function(msg){
				if(msg=="OK"){

					$("div#isLogin").hide();
					$("div#notLogin").show();
					$("input#nomember")[0].checked=true;

					$('.loginlink').click(function() { 
						$().popLogin(1);
					});
					$("input#nomember").click(function() { 
						if(this.checked==false){
							$().popLogin(1);
						}
					});

				}else{
					alert(msg);
				}
			}
		});
	

   }); 
});



//評論發佈表單送出
$(document).ready(function(){
	$('#commentSend').submit(function(){ 
		$('#commentSend').ajaxSubmit({
			target: 'div#notice',
			url: PDV_RP+'comment/post.php',
			success: function(msg) {
				
				switch(msg){
					
					case "NOTLOGIN":
						$('div#notice').hide();
						$().popLogin(1);
					break;
					
					case "CHK":
						$('div#notice').hide();
						$().alertwindow("評論發表成功！<br>您的評論需要審核後才能顯示","");
					break;


					default:
						if(msg.substr(0,2)=="OK"){
							$('div#notice').hide();
							$().alertwindow("評論發表成功","");
							var rid=$("input#rid")[0].value;
							$.ajax({
								type: "POST",
								url: PDV_RP+"news/post.php",
								data: "act=getnewcomment&RP="+PDV_RP+"&rid="+rid,
								success: function(msg){
										$("#commentList").show();
										$("#commentUl").prepend(msg);
										$().setBg();
								}
							});


						}else{
							$('div#notice')[0].className='noticediv';
							$('div#notice').show();
							$().setBg();
						}
					break;
				}
			}
		}); 
       return false; 

   }); 
});


//評分星級
$(document).ready(function(){
	$("img.pstar").mouseover(function(){
		var obj=this.id;
		var num=obj.substr(4);
		for(var i=1;i<=num; i++) {
			$("img#star"+i)[0].src=PDV_RP+"news/templates/images/icon_star_2.gif";
		}
	});

	$("img.pstar").click(function(){
		var obj=this.id;
		var num=obj.substr(4);
		$("input#pj1")[0].value=num;
	});

	$("img.pstar").mouseout(function(){
		
		var nowvalue=$("input#pj1")[0].value;

		for(var i=1;i<=nowvalue; i++) {
			$("img#star"+i)[0].src=PDV_RP+"news/templates/images/icon_star_2.gif";
		}
		var start=parseInt(nowvalue)+1;
		for(var i=start;i<=5;i++) {
			$("img#star"+i)[0].src=PDV_RP+"news/templates/images/icon_star_1.gif";
		}
	});
});

