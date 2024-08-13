// JavaScript Document
$(document).ready(function(){


	 
	if($('.measure-item-pic').css('display') == 'none'){
		$('.show-measure').click(function(){
			$('.measure-back').fadeIn();
			$('.measure').fadeIn();
			$(document).not($(".measure")).click(function(){
				$(".measure").fadeOut();
			});
		});
		$('.esc').click(function(){
			$('.measure-back').fadeOut();
			$('.measure').fadeOut();
			$('.loding-con').hide();
			$('.measure-fin').hide();
			$('.measure-main-m').show();
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
			$('.measure').addClass("w-act");
		});
		$('.esc').click(function(){
			$('.measure-back').fadeOut();
			$('.measure').fadeOut();
			$('.measure-fin').hide();
			$('.loding-con').hide();
			$('.measure-main').show();
		});
		$('body').click(function(e) {
		  if(e.target.className == 'measure-back' && e.target.className != 'measure'){
			 $('.measure-back').fadeOut();
			 $('.measure').fadeOut();
			 $('.loding-con').hide();
			 $('.measure-fin').hide();
			 $('.measure-main').show();
		  }	 
		});
		
		$('.measure-main form').addClass('action_form');
		
		$(document).on("click",".measure-again",function(){
			$('.measure-fin').hide();
			$('.measure-main').fadeIn();
			checkInput();
		});

		$('.input-num').keypress(function(e) {
			code = e.keyCode ? e.keyCode : e.which; // in case of browser compatibility
			if(code == 13) {
				e.preventDefault();
				// do something
				/* also can use return false; instead. */
				}
		});
	}


		//身高
		$(document).on('input', '#slider-tall', function() {
			var xxx = $("#slider-tall").val();
			$("#tall").val(xxx);
			$(".tall-underline").hide();
			checkInput();
		});
		$("#tall").keyup(function(){
			var xxx = $("#tall").val();
			$("#slider-tall").val(xxx);
			checkInput();
			if($("#tall").val()==""){
				$("#slider-tall").val(0);
				$(".tall-underline").show();
			}else{
				$(".tall-underline").hide();
			}
		});
		//END身高
		
		//體重
		$(document).on('input', '#slider-weight', function() {
			var xxx = $("#slider-weight").val();
			$("#weight").val(xxx);
			checkInput();
			$(".weight-underline").hide();
		});
		$("#weight").keyup(function(){
			var xxx = $("#weight").val();
			$("#slider-weight").val(xxx);
			checkInput();
			if($("#weight").val()==""){
				$(".weight-underline").show();
				$("#slider-weight").val(0);
			}else{
				$(".weight-underline").hide();
			}
			
		});
		//END身高

		//胸圍
		$(document).on('input', '#slider-chest', function() {
			var xxx = $("#slider-chest").val();
			var ich = xxx/2.54;
			var ich2 = ich.toFixed(1); 
			$("#inchchest").val(ich2);
			$("#chest").val(xxx);  
			$(".chest-underline").hide();
		});
		$("#chest").keyup(function(){
			var xxx = $("#chest").val();
			var ich = xxx/2.54;
			var ich2 = ich.toFixed(1); 
			$("#inchchest").val(ich2);
			$("#slider-chest").val(xxx);
			if($("#chest").val()==""){
				$(".chest-underline").show();
				$("#slider-chest").val(0);
			}else{
				$(".chest-underline").hide();
			}
		});
		$("#inchchest").keyup(function(){
			var xxx = $("#inchchest").val();
			var ich = xxx*2.54;
			var ich2 = ich.toFixed(0); 
			$("#chest").val(ich2);
			$("#slider-chest").val(ich2);
			if($("#inchchest").val()==""){
				$(".chest-underline").show();
				$("#slider-chest").val(0);
			}else{
				$(".chest-underline").hide();
			}
		 });
		//END胸圍
		
		//腰圍
		$(document).on('input', '#slider-waist', function() {
			var xxx = $("#slider-waist").val();
			var ich = xxx/2.54;
			var ich2 = ich.toFixed(1); 
			$("#inchwaist").val(ich2);
			$("#waist").val(xxx);
			$(".waist-underline").hide();
		});
		$("#waist").keyup(function(){
			var xxx = $("#waist").val();
			var ich = xxx/2.54;
			var ich2 = ich.toFixed(1); 
			$("#inchwaist").val(ich2);
			$("#slider-waist").val(xxx);
			if($("#waist").val()==""){
				$(".waist-underline").show();
				$("#slider-waist").val(0);
			}else{
				$(".waist-underline").hide();
			}
		});
		$("#inchwaist").keyup(function(){
			var xxx = $("#inchwaist").val();
			var ich = xxx*2.54;
			var ich2 = ich.toFixed(0); 
			$("#waist").val(ich2);
			$("#slider-waist").val(ich2); 
			if($("#inchwaist").val()==""){
				$(".waist-underline").show();
				$("#slider-waist").val(0);
			}else{
				$(".waist-underline").hide();
			}
		});
		//END腰圍
		
		//臀圍
		$(document).on('input', '#slider-hips', function() {
			var xxx = $("#slider-hips").val();
			var ich = xxx/2.54;
			var ich2 = ich.toFixed(1); 
			$("#inchhips").val(ich2);
			$("#hips").val(xxx);
			$(".hips-underline").hide();
		});
		$("#hips").keyup(function(){
			var xxx = $("#hips").val();
			var ich = xxx/2.54;
			var ich2 = ich.toFixed(1); 
			$("#inchhips").val(ich2);
			$("#slider-hips").val(xxx); 
			if($("#hips").val()==""){
				$(".hips-underline").show();
				$("#slider-hips").val(0);
			}else{
				$(".hips-underline").hide();
			}
		});
		$("#inchhips").keyup(function(){
			var xxx = $("#inchhips").val();
			var ich = xxx*2.54;
			var ich2 = ich.toFixed(0); 
			$("#hips").val(ich2);
			$("#slider-hips").val(ich2);
			if($("#inchhips").val()==""){
				$(".hips-underline").show();
				$("#slider-hips").val(0);
			}else{
				$(".hips-underline").hide();
			}
		});
		//END臀圍
		

		
		


});


	  $(document).bind('click', function(e) {  
                var e = e || window.event; //浏览器兼容性   
                var elem = e.target || e.srcElement;  
                while (elem) { //循环判断至跟节点，防止点击的是div子元素   
                    if (elem.id && elem.id == 'test') {  
                        return;  
                    }  
                    elem = elem.parentNode;  
                }  
                $('#test').css('display', 'none'); //点击的不是div或其子元素   
            });
	
	
	function checkInput(){
		if( $("#tall").val()!="" && $("#tall").val()!="0" && $("#weight").val()!="" && $("#weight").val()!="0" && $(".measure-button").hasClass("act")==false ){
			$(".measure-button").addClass("act");
			button_on();
		}
		if( $("#tall").val()=="" || $("#tall").val()=="0" || $("#weight").val()=="" || $("#weight").val()=="0" && $(".measure-button").hasClass("act")==true ){
			$(".measure-button").removeClass("act");
			$('.measure-button').off("click");
		}
	}

	function button_on(){
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
		
	}


