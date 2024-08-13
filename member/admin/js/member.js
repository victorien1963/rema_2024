
//彈出修改會員資料
$(document).ready(function(){
	
	$(".membermodify").click(function(){
	
		var memberid=this.id.substr(13);
		$('#frmWindow').remove();
		$("body").append("<div id='frmWindow'></div>");
		$('#frmWindow').append('<div class="topBar">會員資料<div class="pwClose"></div></div><div class="border"><iframe frameborder="0" scrolling="yes" src="member_modify.php?memberid='+memberid+'" class="Frm"></iframe></div>');
		$.blockUI({message:$('#frmWindow'),css:{width:'850px',top:'10px'}}); 
		$('.pwClose').click(function() { 
			$.unblockUI(); 
		}); 
	});

	$(".membercent").click(function(){
	
		var memberid=this.id.substr(11);
		$('#frmWindow').remove();
		$("body").append("<div id='frmWindow'></div>");
		$('#frmWindow').append('<div class="topBar">會員積分<div class="pwClose"></div></div><div class="border"><iframe frameborder="0" scrolling="yes" src="member_centlog.php?memberid='+memberid+'" class="Frm"></iframe></div>');
		$.blockUI({message:$('#frmWindow'),css:{width:'850px',top:'10px'}}); 
		$('.pwClose').click(function() { 
			$.unblockUI(); 
		}); 
	});


	$(".membermail").click(function(){
	
		var memberid=this.id.substr(11);
		$('#frmWindow').remove();
		$("body").append("<div id='frmWindow'></div>");
		$('#frmWindow').append('<div class="topBar">會員積分<div class="pwClose"></div></div><div class="border"><iframe frameborder="0" scrolling="yes" src="member_email.php?memberid='+memberid+'" class="Frm"></iframe></div>');
		$.blockUI({message:$('#frmWindow'),css:{width:'850px',top:'10px'}}); 
		$('.pwClose').click(function() { 
			$.unblockUI(); 
		}); 
	});


});