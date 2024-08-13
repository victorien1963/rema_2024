/*左側選單*/
(function($){

	$.fn.getMenuGroup = function(coltype){
		
		//偵測目前選單是否與 coltype相符
		var thiscoltype = $('#thiscoltype', window.parent.document).val();
				
		if(thiscoltype != coltype){
			$("ul.menulist").empty();
			$.ajax({
				type: "POST",
				url:"post.php",
				data: "act=menugrouplist&coltype="+coltype,
				success: function(msg){
					
					$('#thiscoltype', window.parent.document).val(coltype);
					
					$("ul.menulist", window.parent.document).html(msg);
					
					var getObj = $('a.menulist', window.parent.document);
					
					$("a#m1", window.parent.document).attr('class', 'active');
					
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
		}
	};
})(jQuery);