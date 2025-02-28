/*!
//Description: //Core scripts to handle the entire theme// This file should be included in all pages
 !**/
 
function swapStyle(e) {
	document.getElementById("qstyle").setAttribute("href",e);var t=e;localStorage.setItem("ektheme",t)
}

if($(document).ready(function() {
	localStorage.getItem("fixedTop")&&($(".navbar-top").addClass("fixed"),$("#fixed-navbar").prop("checked",!0)),$("#fixed-navbar").click(function(){if(this.checked){$(".navbar-top").addClass("fixed");var e="fixed"
}

else if(!this.checked) {
	$(".navbar-top").removeClass("fixed");var e=""
}

localStorage.setItem("fixedTop",e)
}),""!=localStorage.getItem("fixedsiderbar")&&($(".navbar-top, .navbar-side, #page-wrapper, .breadcrumbs").addClass("fixed"),$("#fixed-sidebar").prop("checked",!0),$("#fixed-navbar").prop("checked",!0)),$("#fixed-sidebar").click(function() {
if(this.checked){$(".navbar-top, .navbar-side, #page-wrapper, .breadcrumbs").addClass("fixed");var e="fixed"
}

else if(!this.checked) {
$(".navbar-side,  #page-wrapper, .breadcrumbs").removeClass("fixed");var e=""
}

localStorage.setItem("fixedsiderbar",e)
}),localStorage.getItem("sidetoggle")&&($(".navbar-side, #page-wrapper, .footer-inner, .breadcrumbs").addClass("collapsed"),$("#sidebar-toggle").prop("checked",!0)),$("#sidebar-toggle").click(function() {
if(this.checked){$(".navbar-side, #page-wrapper, .footer-inner, .breadcrumbs").addClass("collapsed");var e="collapsed"
}

else if(!this.checked) {
$(".navbar-side, #page-wrapper, .footer-inner, .breadcrumbs").removeClass("collapsed");var e=""
}

localStorage.setItem("sidetoggle",e)
}),localStorage.getItem("insidecontainer")&&($("#main-container, .navbar-top").addClass("container"),$("#in-container").prop("checked",!0)),$("#in-container").click(function() {
if(this.checked){$("#main-container, .navbar-top").addClass("container");var e="container"
}

else if(!this.checked) {
$("#main-container, .navbar-top").removeClass("container");var e=""
}

localStorage.setItem("insidecontainer",e)
}),localStorage.getItem("SideBarLight")&&($(".navbar-side").addClass("sidebar-light"),$("#side-bar-color").prop("checked",!0)),$("#side-bar-color").click(function() {
if(this.checked){$(".navbar-side").addClass("sidebar-light");var e="sidebar-light"
}

else if(!this.checked) {
$(".navbar-side").removeClass("sidebar-light");var e=""
}

localStorage.setItem("SideBarLight",e)
}),$(function() {
function e(){windowHeight=$(window).height(),jQuery(window).width()<991?$(".sidebar-collapse").css("max-height",windowHeight-110): $(".navbar-side").hasClass("fixed")?$(".sidebar-collapse").css("max-height",windowHeight):$(".sidebar-collapse").css("max-height",5e3)
}

e(),$(window).resize(function() {
e()
}),$(".sidebar-collapse").slimScroll( {
height: "100%",width:"100%",size:"1px"
})}),$(".portlet-widgets .fa-chevron-down, .portlet-widgets .fa-chevron-up").click(function() {
$(this).toggleClass("fa-chevron-down fa-chevron-up")
}),$(".box-close").click(function() {
$(this).closest(".portlet").hide("slow")
}),$(function() {
$("[data-rel='tooltip']").tooltip()
}),$("[data-toggle=popover]").popover( {
html: !0
}),$("#qs-setting-btn").click(function() {
$(this).toggleClass("open"),$("#qs-setting-box").toggleClass("open")
}),$("#fo-btn").click(function(e) {
e.preventDefault(),$(".footer-warp").toggleClass("open")
}),$(".task-lists li input").on("click",function() {
$(this).parent().toggleClass("todo-done")
}),$(".collapse").on("show.bs.collapse",function() {
var e=$(this).attr("id");$('a[href="#'+e+'"]').closest(".panel-heading").addClass("accordion-active"),$('a[href="#'+e+'"] .panel-title span').html('<i class="fa fa-angle-down bigger-110"></i>')
}),$(".collapse").on("hide.bs.collapse",function() {
var e=$(this).attr("id");$('a[href="#'+e+'"]').closest(".panel-heading").removeClass("accordion-active"),$('a[href="#'+e+'"] .panel-title span').html('<i class="fa fa-angle-right bigger-110"></i>')
}),$(".toggle").on("click",function() {
var e=$("#"+$(this).data("toggle"));return e.is(":visible")?e.addClass("hide").removeClass("show"): e.addClass("show").removeClass("hide"),!1
}),$("body").on("hide.bs.modal",function() {
$(".modal:visible").size()>1&&$("html").hasClass("modal-open")===!1?$("html").addClass("modal-open"): $(".modal:visible").size()<=1&&$("html").removeClass("modal-open")
}),$("body").on("show.bs.modal",".modal",function() {
$(this).hasClass("modal-scroll")&&$("body").addClass("modal-open-noscroll")
}),$("body").on("hide.bs.modal",".modal",function() {
$("body").removeClass("modal-open-noscroll")
}),$("body").on("hidden.bs.modal",".modal:not(.modal-cached)",function() {
$(this).removeData("bs.modal")
}),$("body").on("click",".dropdown-menu.hold-on-click",function(e) {
e.stopPropagation()
}),$(function() {
$("#btn-loading").click(function(){$(this).button("loading").delay(2e3).queue(function(){$(this).button("reset"),$(this).dequeue()
})})}),$("li.dropdown").addClass("show-on-hover"),$(window).scroll(function() {
$(this).scrollTop()>50?$("#back-to-top").fadeIn(): $("#back-to-top").fadeOut()
}),$("#back-to-top").click(function() {
return $("body,html").animate({scrollTop: 0
},800),!1
}),$(function() {
$("#input-items").on("keyup",function(){var e=new RegExp($(this).val(),"i");$(".side-nav li").hide(),$(".side-nav li").filter(function(){return e.test($(this).text())
}).show()
})}),$(function() {
$("#side").eKMenu()
})}),function(e) {
function t(t,o){this.element=t,this.settings=e.extend({
},a,o),this._defaults=a,this._name=n,this.init()
}

var n="eKMenu",a= {
toggle: !0
};

t.prototype= {
init: function(){var t=e(this.element),n=this.settings.toggle;
t.find("li.open").has("ul").children("ul").addClass("collapse in"),t.find("li").not(".open").has("ul").children("ul").addClass("collapse"),t.find("li").has("ul").children("a").on("click",function(t){t.preventDefault(),e(this).parent("li").toggleClass("open").children("ul").collapse("toggle"),n&&e(this).parent("li").siblings().removeClass("open").children("ul.in").collapse("hide")
})}},e.fn[n]=function(a) {
return this.each(function(){e.data(this,"plugin_"+n)||e.data(this,"plugin_"+n,new t(this,a))
})}}(jQuery,window,document),localStorage.getItem("ektheme")) {
var sheet=localStorage.getItem("ektheme");$("#qstyle").attr("href",sheet)
}

var App=function() {
var e=[];if("webkitSpeechRecognition"in window)var t=new webkitSpeechRecognition;var n=function(n){if("webkitSpeechRecognition"in window)if("start"==n)t.start();else if("stop"==n)t.stop();else{var a={continuous: !0,interim:!0,lang:!1,onEnd:!1,onResult:!1,onNoMatch:!1,onSpeechStart:!1,onSpeechEnd:!1
};$.extend(a,n),a.continuous&&(t.continuous=!0),a.interim&&(t.interimResults=!0),a.lang&&(t.lang=a.lang);var o=!1,i="";t.onresult=function(t) {
for(var n=t.resultIndex;n<t.results.length;++n)if(t.results[n].isFinal){var s=t.results[n][0].transcript;s=s.toLowerCase(),s=s.replace(/^\s+|\s+$/g,""),console.log(s),a.onResult&&a.onResult(s),$.each(e,function(e,t){o?i==t.command&&(t.dictation?s==t.dictationEndCommand?(o=!1,t.dictationEnd(s)): t.listen(s):(o=!1,t.listen(s))):t.command==s&&(t.action(s),t.listen&&(o=!0,i=t.command))
})}

else {
var l=t.results[n][0].transcript;$.each(e,function(e,t){t.interim!==!1&&o&&i==t.command&&t.interim(l)
})}},a.onNoMatch&&(t.onnomatch=function() {
a.onNoMatch()
}),a.onSpeechStart&&(t.onspeechstart=function() {
a.onSpeechStart()
}),a.onSpeechEnd&&(t.onspeechend=function() {
a.onSpeechEnd()
}),t.onaudiostart=function() {
$(".speech-button i").addClass("blur")
},t.onend=function() {
$(".speech-button i").removeClass("blur"),a.onEnd&&a.onEnd()
}}

else alert("Only Chrome25+ browser support voice recognition.")
},a=function(t,n) {
var a={action: !1,dictation:!1,interim:!1,dictationEnd:!1,dictationEndCommand:"final.",listen:!1
};$.extend(a,n),t?a.action?e.push( {
command: t,dictation:a.dictation,dictationEnd:a.dictationEnd,dictationEndCommand:a.dictationEndCommand,interim:a.interim,action:a.action,listen:a.listen
}):alert("Must have an action function"):alert("Must have a command text")
};

return {
speech: function(e){n(e)
},speechCommand:function(e,t) {
a(e,t)
}}}(),Apps=function() {
return{init: function(){handleNavTopBar()
},initNavTopBar:function() {
$(window).scroll(function(){$(".top-navbar").offset().top>50?$(".navbar-fixed-top, .navbar-brand").addClass("top-nav-collapse"): $(".navbar-fixed-top, .navbar-brand").removeClass("top-nav-collapse")
})}}}();

/*!
//end
 !**/
