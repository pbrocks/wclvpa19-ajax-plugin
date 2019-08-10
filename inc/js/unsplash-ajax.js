jQuery(document).ready(function($) {
	function getRandomColor() {
		let letters = '0123456789ABCDEF';
		let color = '#';
		for (let i = 0; i < 6; i++) {
			color += letters[Math.floor(Math.random() * 16)];
		}
		return color;
	}

	$("#unsplash-ajax").click(function(e) {
		e.preventDefault();
        // We'll pass this variable to the PHP function example_ajax_request
        var fruit = 'Banana';
        // // This does the ajax request
        $.ajax({
        	type: "POST",
        	url: unsplash_ajax_object.unsplash_ajaxurl,
            // url: ajaxurl, // or example_ajax_obj.ajaxurl if using on unsplash
            data: {
            	'action': 'unsplash_ajax_request',
            	'fruit' : fruit,
            	'unsplash_ajaxurl' : unsplash_ajax_object.unsplash_ajaxurl,
            	'unsplash_nonce' : unsplash_ajax_object.unsplash_nonce,
            	'random_number' : unsplash_ajax_object.random_number,
            },
            success:function(data) {
            	$( '#return-unsplash' ).html(data);
            	document.getElementById('page').style.background=getRandomColor();
                // document.getElementById('page').style.background='repeating-linear-gradient(45deg, purple, transparent 10rem)';
                // , 'url(//unsplash.it/900/600)';
                // This outputs the result of the ajax request
                console.log(data);
            },
            error: function(jqXHR, textStatus, errorThrown){
            	$( '#return-unsplash' ).html(errorThrown);
            	console.log(errorThrown);
            }
        });  
    });      
});