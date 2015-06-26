jQuery(function($){ 
    $('.tagscloud .sliding-tag').each(function(i) {
    	setTimeout(function() {
    		$('.tagscloud .sliding-tag:eq('+i+')').css({ display: 'block', opacity: 0 }).stop().animate({ opacity: 1 }, 'easeInOutExpo'); 
    	}, 100 * (i + 1))
    });

	$('.tagscloud .sliding-tag').hover(function() {
		$(this).stop().animate({ paddingRight: ($('.tag_count', this).outerWidth() - 5) }, 'easeInOutExpo');
	}, function() {
		$(this).stop().animate({ paddingRight: 5 }, 'easeInOutExpo');
	});

	$('.tagscloud .sliding-tag').click(false);
});
