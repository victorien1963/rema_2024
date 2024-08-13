$(document).ready(function() {

	$("#shoplist_dolphinpic_0").show();
	setInterval("$().shoplistdolphin()", 4000);


	(function($){

		$.fn.shoplistdolphin = function(){
	
			var rollobj=$(".shoplist_dolphin");
			var rolltotal=parseInt(rollobj.size())-1;
			var nextId,nowId;
			$(".shoplist_dolphin").each(function(){

				if(this.style.display=='block' || this.style.display=='inline'){
					nowId=parseInt(this.id.substr(20));
					
					if(nowId>=rolltotal){
						nextId=0;
					}else{
						nextId=nowId+1;
					}
				}
			});
			
			$("#shoplist_dolphinpic_"+nextId).fadeIn('slow').show('slow');
			$("#shoplist_dolphinpic_"+nowId).fadeOut('slow').hide();

		};

	})(jQuery);

});
