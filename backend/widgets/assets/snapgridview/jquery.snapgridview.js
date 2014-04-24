(function ($) {
	
	$.fn.snapGridView = {};
	$.fn.snapGridView.init = function () {
		$(".snap-gv-column-options input").each(function(){
			if($(this).prop("checked")) {
				$(this).prev().addClass("active");
			}
		});
	}
	
	$.fn.snapGridView.init();
	
})(jQuery);