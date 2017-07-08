jQuery(document).ready(function(){
    jQuery(window).scroll(function() {
    	if(jQuery(this).scrollTop() > 100) { // this refers to window
	        jQuery('.footer-sec').show();
	    }else{
	    	jQuery('.footer-sec').hide();
	    }
	});
});