// JavaScript Document
$(document).ready(function(){
		$('.show-measure').click(function(){
			$('.measure-back').fadeIn();
			$('.measure').fadeIn();
		});
		$('.esc').click(function(){
			$('.measure-back').hide();
			$('.measure').hide();
			$('.measure-fin').hide();
			$('.measure-main-m').show();
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
		$('.measure-main-m form').addClass('action_form');
		
		$(document).on("click",".measure-again",function(){
			$('.measure-fin').hide();
			$('.measure-main-m').fadeIn();
		});

		
	$('.measure-button').click(function(){
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