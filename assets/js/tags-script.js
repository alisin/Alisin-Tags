jQuery(function($){ 
    $('.tagscloud .codfront-tag').each(function(i) {
    	setTimeout(function() {
    		$('.tagscloud .codfront-tag:eq('+i+')').css({ display: 'block', opacity: 0 }).stop().animate({ opacity: 1 }, 'easeInOutExpo'); 
    	}, 250 * (i + 1))
    });

	$('.tagscloud .codfront-tag').hover(function() {
		$(this).stop().animate({ paddingRight: ($('.tag_count', this).outerWidth() - 5) }, 'easeInOutExpo');
	}, function() {
		$(this).stop().animate({ paddingRight: 5 }, 'easeInOutExpo');
	});

	$('.tagscloud .codfront-tag').click(false);
});