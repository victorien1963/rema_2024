
//添加品牌校驗
$(document).ready(function(){

	$('#addBrandForm').submit(function(){
		if($("#brand")[0].value==""){
			$().alertwindow("請填寫品牌名稱","");
			return false;
		}
		return true;
		
   }); 
});



//品牌關聯分類

$(document).ready(function(){

	$(".brandrelset").click(function(){
		var brandid=this.id.substr(12);
		var $overflow = '';
			var href = '../../shop/admin/brand_relcat.php?brandid='+brandid;
			var colorbox_params = {
				href: href,
				scrolling:true,
				iframe:true,
				close:'<i class="fa fa-times text-primary"></i>',
				width:'60%',
				height:'80%',
				onOpen:function(){
					$overflow = parent.document.body.style.overflow;
					parent.document.body.style.overflow = 'hidden';
				},
				onClosed:function(){
					parent.document.body.style.overflow = $overflow;
				}
			};
			window.parent.$.colorbox(colorbox_params);
	});

	$("input#closerelcat").click(function(){
		parent.$.colorbox.close();
	});

	$("input#selall").click(function(){
		if($(this)[0].checked==true){
			$("[name='c[]']").prop("checked",true);
		}else{
			$("[name='c[]']").prop('checked',false);
		}
	});

	$("input.relcheck").click(function(){
		var myid=this.id;
		if($(this)[0].checked==true){
			$("input.relcheck").each(function(){
				var objId=this.id;
				if(jsstrstr(objId,myid)){
					$(this).prop("checked",true);
				}
			});
			var clen=myid.length;
			if(clen>=10){
				for(i=clen-5;i>=5;i=i-5){
					$("#"+myid.substr(0,i)).prop("checked",true);
				}
			}
		}else{
			$("input.relcheck").each(function(){
				var objId=this.id;
				if(jsstrstr(objId,myid)){
					$(this).prop('checked',false);
				}
			});
		}
	});

	
	$('#brcForm').submit(function(){
	
		$('#brcForm').ajaxSubmit({
				url: 'post.php',
				success: function(msg) {
					if(msg=="OK"){
						parent.$.colorbox.close();
					}else{
						$().alertwindow(msg,"");
					}
				}
			}); 
	 
		return false; 

   }); 


});


function jsstrstr(haystack, needle) {
    var pos = 0;
    haystack += '';
    pos = haystack.indexOf( needle );
    if (pos == -1) {
        return false;
    } else{
       return true;
    }
}
