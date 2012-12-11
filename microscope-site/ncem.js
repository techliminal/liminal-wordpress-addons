jQuery(document).ready(function($){
	$(".archive.category-microscopes .entry-content").each(function () {
		var $this = $(this);
    
	$this.hover(function () {
		$('p', $this).slideToggle(1000);
	
	});
	});
});