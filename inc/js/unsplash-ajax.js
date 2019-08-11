jQuery(document).ready(function($) {
	function getRandomColor() {
		let letters = '0123456789ABCDEF';
		let color = '#';
		for (let i = 0; i < 6; i++) {
			color += letters[Math.floor(Math.random() * 16)];
		}
		return color;
	}
    function getRandomNumber() {
        var number = Math.floor((Math.random() * 10) + 1);
        return number;
    }
	$("#unsplash-ajax").click(function(e) {
		e.preventDefault();
        $.ajax({
        	type: "POST",
        	url: unsplash_ajax_object.unsplash_ajaxurl,
            // url: ajaxurl, // or example_ajax_obj.ajaxurl if using on unsplash
            data: {
            	'action': 'unsplash_ajax_request',
            	'unsplash_ajaxurl' : unsplash_ajax_object.unsplash_ajaxurl,
            	'unsplash_nonce' : unsplash_ajax_object.unsplash_nonce,
            	'random_number' : unsplash_ajax_object.random_number,
            },
            success:function(data) {
            	// $( '#return-unsplash' ).html(data);
                let ran = getRandomNumber();
                document.getElementById('page').style.background = 'aliceblue url("https://picsum.photos/1800/1200?random=' + ran + '") no-repeat fixed center center';
                document.querySelector('.wp-block-column h3.again-click').className += " was-clicked";
                document.querySelector('.wp-block-columns').className += " was-clicked";
                document.querySelector('.wp-block-column h3.again-click.was-clicked').innerHTML = "Click AGAIN to Change!";
                document.querySelector('.site-branding').style.opacity = 0;
                document.querySelector('#colophon .site-info').style.opacity = 0;
            	// document.getElementById('page').style.background=getRandomColor();
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