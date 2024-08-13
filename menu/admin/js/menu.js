function submitMenu(id){
	
	if($("#menu_"+id).val().length < 1 ){
		$().alertwindow("請輸入選單名稱","");
		return false;
	}
	
	if($("#folder_selcoltype_"+id).val().length<1 && $("#selcoltype_"+id).val()=='1'){
		$().alertwindow("請輸入內部網址，格式如：news/class/index.php","");
		return false;
	}

	//$("#form_"+id).submit();
	var target = $('#target_'+id).val();
	var ifshow = $('#ifshow_'+id).val();
	var selcoltype = $('#selcoltype_'+id).val();
	var url = $('#url_selcoltype_'+id).val();
	var folder = $('#folder_selcoltype_'+id).val();
	var groupid = $('#gid').val();
	
	
	$('#form_'+id).ajaxSubmit({
		url: 'index.php?target='+target+'&ifshow='+ifshow+'&url='+url+'&folder='+folder+'&selcoltype='+selcoltype+'&groupid='+groupid,
		type: 'POST',
		success: function(msg) {
			self.location='index.php?groupid='+groupid;
		}
	});
}

$(document).ready(function() {
	
	var getObj = $('select.selcoltype');

	getObj.each(function(id) {
		var obj = this.id;
	    switch(this.value){
			case "1" :
				$("input#folder_"+obj).css("display","inline");
				$("input#url_"+obj).css("display","none");
			break;
			case "2" :
				$("input#folder_"+obj).css("display","none");
				$("input#url_"+obj).css("display","inline");
			break;
			case "3" :
				$("input#folder_"+obj).css("display","inline");
				$("input#url_"+obj).css("display","none");
			break;
			case "4" :
				$("input#folder_"+obj).css("display","inline");
				$("input#url_"+obj).css("display","none");
			break;
			default :
				$("input#folder_"+obj).css("display","none");
				$("input#url_"+obj).css("display","none");
			break;
		}
			
		
		$("select#"+obj).change(function() {
			
			switch(this.value){
				case "1" :
					$("input#folder_"+obj)[0].style.display='inline';
					$("input#url_"+obj)[0].style.display='none';
				break;
				case "2" :
					$("input#folder_"+obj)[0].style.display='none';
					$("input#url_"+obj)[0].style.display='inline';
				break;
				case "3" :
					$("input#folder_"+obj)[0].style.display='inline';
					$("input#url_"+obj)[0].style.display='none';
				break;
				case "4" :
					$("input#folder_"+obj)[0].style.display='inline';
					$("input#url_"+obj)[0].style.display='none';
				break;
				default :
					$("input#folder_"+obj)[0].style.display='none';
					$("input#url_"+obj)[0].style.display='none';
				break;

			}
			
		});
	});
});

//添加分組
$(document).ready(function(){
	$('#addgroup').submit(function(){ 
		$('#addgroup').ajaxSubmit({
			url: 'post.php',
			success: function(msg) {
				if(msg=="OK"){
					$("div#notice").hide();
					$().getMenuGroup();
				}else{
					$("div#notice").hide();
					$().alertwindow(msg,"");
				}
			}
		}); 
       return false; 
   }); 
});


//刪除分組
$(document).ready(function(){
	
		$('#delgroup').submit(function(){ 
			
			qus=confirm("確定要刪除目前選單組嗎?")
			if(qus==0){
				return false; 
			}
				$('#delgroup').ajaxSubmit({
					url: 'post.php',
					success: function(msg) {
						if(msg=="OK"){
							$().getMenuGroup();
							self.location='index.php';
						}else{
							$().alertwindow(msg,"");
						}
						
					}
				}); 
			    return false; 
			
			
	   });
   
});