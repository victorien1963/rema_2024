

$(document).ready(function(){

	$("div#print_button").click(function(){ 
		$("div#shoporderdetail").printArea({mode: "popup", popClose: false}); 
	}); 

	$("div#print_fahuo_button").click(function(){ 
		$("div#fahuodan").printArea({mode: "popup", popClose: false}); 
	}); 

	$("#chkpaytype").change(function(){
		var orderid=$('#orderid').val();
		var payid=$(this).val();
		var paytype=$("#chkpaytype option:selected").text();
		
		$.blockUI({
			message: '付款方式 已經更改',
			css:{width:'300px',padding:'20px'},
			centerX: true, 
    		centerY: true, 
		});
		$.ajax({
				type: "POST",
				url:"post.php",
				data: "act=ordermodipaytype&orderid="+orderid+"&payid="+payid+"&paytype="+paytype,
				success: function(msg){
					if(msg=="OK"){
						setTimeout($.unblockUI, 500); 
					}else{
						alert(msg);
						setTimeout($.unblockUI, 500); 
					}
				}
			});
	});

	//修改備註
	$("#bztext").focus(function(){
		$("#savebz").show();
		$("#savebz").click(function(){
			var bztext=$("#bztext")[0].value;
			var orderid=$("#orderid")[0].value;
			$.ajax({
				type: "POST",
				url:"post.php",
				data: "act=ordermodibz&orderid="+orderid+"&bztext="+bztext,
				success: function(msg){
					if(msg=="OK"){
						$("#savebz").hide();
					}else{
						alert(msg);
					}
				}
			});
		});
	});
	
	$("#chgsaddr,.chgsaddr").click(function(){
		$('#showchg').show();
		$('#name').attr("disabled",false).addClass("act");
		$('#s_name').attr("disabled",false).addClass("act");
		$('#s_tel').attr("disabled",false).addClass("act");
		$('#mobi').attr("disabled",false).addClass("act");
		$('#s_mobi').attr("disabled",false).addClass("act");
		$('#s_postcode').attr("disabled",false).addClass("act");
		$('#s_addr').attr("disabled",false).addClass("act");
	});
	
	$("#chgaddr").click(function(){
		var orderid=$('#orderid').val();
		var name=$('#name').val();
		var sname=$('#s_name').val();
		var tel=$('#tel').val();
		var stel=$('#s_tel').val();
		var mobi=$("#mobi").val();
		var smobi=$("#s_mobi").val();
		var spostcode=$("#s_postcode").val();
		var saddr=$("#s_addr").val();
		var email=$("#email").val();
		$.ajax({
				type: "POST",
				url:"post.php",
				data: "act=ordermodisaddr&orderid="+orderid+"&name="+name+"&sname="+sname+"&tel="+tel+"&stel="+stel+"&mobi="+mobi+"&smobi="+smobi+"&spostcode="+spostcode+"&saddr="+saddr+"&email="+email,
				success: function(msg){
					if(msg=="OK"){
		
						$.blockUI({
							message: '收件人資訊 已更改',
							css:{width:'300px',padding:'20px'},
							centerX: true, 
				    		centerY: true, 
						});
						setTimeout($.unblockUI, 500);
						$('#name').attr("disabled",true).removeClass("act");
						$('#s_name').attr("disabled",true).removeClass("act");
						$('#tel').attr("disabled",true).removeClass("act");
						$('#s_tel').attr("disabled",true).removeClass("act");
						$('#mobi').attr("disabled",true).removeClass("act");
						$('#s_mobi').attr("disabled",true).removeClass("act");
						$('#s_postcode').attr("disabled",true).removeClass("act");
						$('#s_addr').attr("disabled",true).removeClass("act");
						$('#email').attr("disabled",true).removeClass("act");
						$('#showchg').hide();
					}else{
						$.blockUI({
							message: msg,
							css:{width:'300px',padding:'20px'},
							centerX: true, 
				    		centerY: true, 
						});
						//alert(msg);
						setTimeout($.unblockUI, 500);
						$('#name').attr("disabled",true).removeClass("act");
						$('#s_name').attr("disabled",true).removeClass("act");
						$('#tel').attr("disabled",true).removeClass("act");
						$('#s_tel').attr("disabled",true).removeClass("act");
						$('#mobi').attr("disabled",true).removeClass("act");
						$('#s_mobi').attr("disabled",true).removeClass("act");
						$('#s_postcode').attr("disabled",true).removeClass("act");
						$('#s_addr').attr("disabled",true).removeClass("act");
						$('#email').attr("disabled",true).removeClass("act");
						$('#showchg').hide();
					}
				}
			});
	});
	
	
});


(function($) {
    var counter = 0;
    var modes = { iframe : "iframe", popup : "popup" };
    var defaults = { mode     : modes.iframe,
                     popHt    : 500,
                     popWd    : 400,
                     popX     : 200,
                     popY     : 200,
                     popTitle : '',
                     popClose : false,
                     extraCss : '' };

    var settings = {};//global settings

    $.fn.printArea = function( options )
        {
            $.extend( settings, defaults, options );

            counter++;
            var idPrefix = "printArea_";
            $( "[id^=" + idPrefix + "]" ).remove();
            var ele = getFormData( $(this) );

            settings.id = idPrefix + counter;

            var writeDoc;
            var printWindow;

            switch ( settings.mode )
            {
                case modes.iframe :
                    var f = new Iframe();
                    writeDoc = f.doc;
                    printWindow = f.contentWindow || f;
                    break;
                case modes.popup :
                    printWindow = new Popup();
                    writeDoc = printWindow.doc;
            }

            writeDoc.open();
            writeDoc.write( docType() + "<html>" + getHead() + getBody(ele) + "</html>" );
            writeDoc.close();

            printWindow.focus();
            printWindow.print();

            if ( settings.mode == modes.popup && settings.popClose )
                printWindow.close();
        }

    function docType()
    {
        if ( settings.mode == modes.iframe || !settings.strict ) return "";

        var standard = settings.strict == false ? " Trasitional" : "";
        var dtd = settings.strict == false ? "loose" : "strict";

        return '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01' + standard + '//EN" "http://www.w3.org/TR/html4/' + dtd +  '.dtd">';
    }

    function getHead()
    {
        var head = "<head><title>" + settings.popTitle + "</title>";
        $(document).find("link")
            .filter(function(){ return $(this).attr("rel").toLowerCase() == "stylesheet"; })
            .filter(function(){
                    var media = $(this).attr("media");
                    return (media == undefined || media.toLowerCase() == "" || media.toLowerCase() == "print" || media.toLowerCase() == "all")
                })
            .each(function(){
                    head += '<link type="text/css" rel="stylesheet" href="' + $(this).attr("href") + '" >';
                });

        if ( settings.extraCss ) settings.extraCss.replace( /([^,\s]+)/g, function(m){ head += '<link type="text/css" rel="stylesheet" href="' + m + '">' });

        return head += "</head>";
    }

    function getBody( printElement )
    {
        return '<body><div class="' + $(printElement).attr("class") + '">' + $(printElement).html() + '</div></body>';
    }

    function getFormData( ele )
    {
        var copy = ele.clone();
        var copiedInputs = $("input,select,textarea", copy);
        $("input,select,textarea", ele).each(function( i ){
            var type = $(this).attr("type");
            if (type == undefined) type = $(this).is("select") ? "select" : $(this).is("textarea") ? "textarea" : "";
            var copiedInput = copiedInputs.eq( i );

            if ( type == "radio" || type == "checkbox" ) copiedInput.attr( "checked", $(this).is(":checked") );
            else if ( type == "text" ) copiedInput.attr( "value", $(this).val() );
            else if ( type == "select" )
                $(this).find( "option" ).each( function( i ) {
                    if ( $(this).is(":selected") ) $("option", copiedInput).eq( i ).attr( "selected", true );
                });
            else if ( type == "textarea" ) copiedInput.text( $(this).val() );
        });
        return copy;
    }

    function Iframe()
    {
        var frameId = settings.id;
        var iframeStyle = 'border:0;position:absolute;width:0px;height:0px;left:0px;top:0px;';
        var iframe;

        try
        {
            iframe = document.createElement('iframe');
            document.body.appendChild(iframe);
            $(iframe).attr({ style: iframeStyle, id: frameId, src: "" });
            iframe.doc = null;
            iframe.doc = iframe.contentDocument ? iframe.contentDocument : ( iframe.contentWindow ? iframe.contentWindow.document : iframe.document);
        }
        catch( e ) { throw e + ". iframes may not be supported in this browser."; }

        if ( iframe.doc == null ) throw "Cannot find document.";

        return iframe;
    }

    function Popup()
    {
        var windowAttr = "location=yes,statusbar=no,directories=no,menubar=no,titlebar=no,toolbar=no,dependent=no";
        windowAttr += ",width=" + settings.popWd + ",height=" + settings.popHt;
        windowAttr += ",resizable=yes,screenX=" + settings.popX + ",screenY=" + settings.popY + ",personalbar=no,scrollbars=no";

        var newWin = window.open( "", "_blank",  windowAttr );

        newWin.doc = newWin.document;

        return newWin;
    }
})(jQuery);