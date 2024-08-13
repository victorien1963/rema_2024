// JavaScript Document
$(document).ready(function(){
	if($('.measure-item-pic').css('display') == 'none'){
		$('.show-measure').click(function(){
			$('.measure-back').fadeIn();
			$('.measure').fadeIn();
		});
		$('.esc').click(function(){
			$('.measure-back').hide();
			$('.measure').hide();
		});
		$('.measure-main-m form').addClass('action_form');
		
		$(document).on("click",".measure-again",function(){
			$('.measure-fin').hide();
			$('.measure-main-m').fadeIn();
		});
		
	}else{
		$('.show-measure').click(function(){
			$('.measure-back').fadeIn();
			$('.measure').fadeIn();
		});
		$('.esc').click(function(){
			$('.measure-back').hide();
			$('.measure').hide();
			$('.measure-fin').hide();
			$('.measure-main').show();
		});
		$('body').click(function(e) {
		  if(e.target.className != 'measure-back' && e.target.className != 'measure')
		   if ( $('.measure').is('.visible') ) {
			 $('.measure').hide();
		   }
		})
		$('.measure-button').click(function(){
			$('.measure-main').hide();
			$('.loding-con').show();
		});
		$('.measure-main form').addClass('action_form');
		
		$(document).on("click",".measure-again",function(){
			$('.measure-fin').hide();
			$('.measure-main').fadeIn();
		});


		var tall_slider = $("#slider-tall");
		var tall_output = $("#tall");
		function formatFloat(num, pos){
			  var size = Math.pow(10, pos);
			  return Math.round(num * size) / size;
		}
		tall_output.html( "身高 " + tall_slider.val() + " cm   ");

		tall_slider.bind('input propertychange', function() { 
			tall_output.html( "身高 " + this.value + " cm   ");
		});

		var weight_slider = $("#slider-weight");
		var weight_output = $("#weight");
		weight_output.html( "體重 " + weight_slider.val() + " kg");

		weight_slider.bind('input propertychange', function() { 
			weight_output.html( "體重 " + this.value + " kg");
		});

		var chest_slider = $("#slider-chest");
		var chest_output = $("#chest");
		var chest_inch = chest_slider.val()/2.54;
		chest_output.html( "胸圍 " + chest_slider.val() + " cm " + formatFloat(chest_inch, 1) + "吋");

		chest_slider.bind('input propertychange', function() { 
			var chest_inch = chest_slider.val()/2.54;
			chest_output.html( "胸圍 " + this.value + " cm " + formatFloat(chest_inch, 1) + "吋");
		});
		
		var waist_slider = $("#slider-waist");
		var waist_output = $("#waist");
		var waist_inch = waist_slider.val()/2.54;
		waist_output.html( "腰圍 " + chest_slider.val() + " cm " + formatFloat(waist_inch, 1) + "吋");

		waist_slider.bind('input propertychange', function() { 
			var waist_inch = waist_slider.val()/2.54;
			waist_output.html( "腰圍 " + this.value + " cm " + formatFloat(waist_inch, 1) + "吋");
		});
		
		var hips_slider = $("#slider-hips");
		var hips_output = $("#hips");
		var hips_inch = hips_slider.val()/2.54;
		hips_output.html( "臀圍 " + hips_slider.val() + " cm " + formatFloat(hips_inch, 1) + "吋");

		hips_slider.bind('input propertychange', function() { 
			var hips_inch = hips_slider.val()/2.54;
			hips_output.html(  "臀圍 " + this.value + " cm " + formatFloat(hips_inch, 1) + "吋");
		});
	}
		
	$('.measure-button').click(function(){
		$('.measure-main').hide();
		$('.measure-main-m').hide();
		var $form = $('.action_form');
		$.ajax({
			url: PDV_RP+"shop/post.php",
			type:$form.attr("method"),
			data:$form.serialize(),
			datatype:'text',
			success:function(data){
				$('.measure-fin').html(data);
				$('.measure-fin').fadeIn();
			},
			beforeSend:function(){
				$('.loding-con').show();
			},
			complete:function(){
				$('.loding-con').hide();
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
            $("#XMLHttpRequest").html("XMLHttpRequest : " + XMLHttpRequest.status);
            $("#textStatus").html("textStatus : " + textStatus);
            $("#errorThrown").html("errorThrown : " + errorThrown.message);
         	}
		});

	});
		

	
	

});