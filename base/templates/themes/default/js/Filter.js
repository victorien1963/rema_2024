// JavaScript Document
$(document).ready(function() {
	
	
	
	
	$(".filter-bn").click(function(){
		$filter_category_item = $(this).next();
		$(".filter-category-item").slideUp();
		$(".filter-icon-span").removeClass("icon-minus");
		$(".filter-icon-span").addClass("icon-plus");
		$icon_minus = $(this).find(".filter-icon-span");
		if ($filter_category_item.css("display") == "none"){
			$filter_category_item.slideDown();
			$icon_minus.removeClass("icon-plus");
			$icon_minus.addClass("icon-minus");
		}
	});
	
	Sticky.Init();

});

class Sticky{

	// 整體初始化
	static Init() {
		Sticky.list = [];

		// 建立Sticky物件並增加至清單中
		$(".sticky").each((i, s) => {
			Sticky.list.push(new Sticky($(s)));
		});

		// 更新１次以初始化
		Sticky.UpdateAll();

		// 註冊捲動事件
		$(window).on("scroll", Sticky.UpdateAll);
	}

	// 整體更新
	static UpdateAll() {
		console.log(window.innerHeight);
		Sticky.footerOffset = $("#footer").offset().top;
		Sticky.list.forEach((sticky) => sticky.Update());
	}

	// 個別初始化
	constructor(jqueryObj) {
		this.jqueryObj = jqueryObj;
		this.UpdateTop();
		OnMobileModeChanged(() => {
			this.UpdateTop();
			this.Update();
		});
	}

	// 個別更新
	Update() {
		if (window.pageYOffset >= this.offsetAbs) {
			this.jqueryObj.css("position", "absolute");
			this.jqueryObj.css("top", mobile_mode ? "auto" : 
				Sticky.footerOffset - this.parentTop - this.jqueryObj.outerHeight(true));
		}
		else {
			this.jqueryObj.css("position", "fixed");
			this.jqueryObj.css("top", mobile_mode ? "auto" : this.top);
		}
	}

	// 更新Top值
	UpdateTop() {
		this.parentTop = this.jqueryObj.parent().offset().top;
		this.top = parseInt(this.jqueryObj.css("top"));
	}

	get offsetAbs() {
		if (mobile_mode) {
			return Sticky.footerOffset - window.innerHeight;
		}
		else {
			return Sticky.footerOffset - (this.top + this.jqueryObj.outerHeight(true));
		}
	}

}

