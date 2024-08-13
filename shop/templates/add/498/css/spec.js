$(document).ready(function(){
	$('div[class*="inputS"]').bind("mouseover", function(){
		var data;
		data = this.id.split("_");
		$('#inputBig_' + data[1]).show();
		$('#inputBig_' + data[1]).bind("mouseover", function(){
			$('#'+this.id).show();
		});
	});
	$('div[class*="inputS"]').bind("mouseleave", function(){
		var data;
		data = this.id.split("_");
		$('#inputBig_' + data[1]).hide();
		$('#inputBig_' + data[1]).bind("mouseleave", function(){
			$('#'+this.id).hide();
		});
	});
	
	$('#devicepic_demo').bind("mouseover", function(){
		$('#demo_info').show();
		$('#demo_info').bind("mouseover", function(){
			$('#'+this.id).show();
		});
	}).bind("mouseleave", function(){
		$('#demo_info').hide();
		$('#demo_info').bind("mouseleave", function(){
			$('#'+this.id).hide();
		});
	});
});