
/*左側選單*/
(function($){

	$.fn.getMenuGroup = function(gid){
		$("ul.menulist").empty();
		
		$.ajax({
			type: "POST",
			url:"post.php",
			data: "act=menugrouplist&groupid="+gid,
			success: function(msg){
				
				$('#thiscoltype', window.parent.document).val('adminmenu');
				
				$("ul.menulist", window.parent.document).html(msg);
				
				var getObj = $('a.menulist', window.parent.document);
				
				getObj.each(function(id) {
					var obj = this.id;
					$("a#"+obj, window.parent.document).click(function() {
						getObj.each(function(id) {
							this.className="menulist";
						});
						this.className="active";
					});
				});
				
			}
		});
	};
})(jQuery);