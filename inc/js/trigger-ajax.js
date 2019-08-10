jQuery(document).ready(function($) {
	let this_filename = 'trigger-ajax.js';
	$("#trigger-ajax-button").click(function(e) {
		e.preventDefault();

		$.ajax({
			type: "POST",
			url: trigger_ajax_object.trigger_ajaxurl,
			data: {
				'action': 'trigger_ajax_request',
				'ajax_filename'   : this_filename,
				'trigger_ajaxurl' : trigger_ajax_object.trigger_ajaxurl,
				'trigger_nonce'   : trigger_ajax_object.trigger_nonce,
				'input1_ajax'     : $('#input1-ajax').val(),
				'hidden_input'    : $('#hidden-input').val(),
				'explanation_one' : trigger_ajax_object.explanation_one,
				'explanation_two' : 'Grab info from javascript and include here (' + this_filename + ').',
			},
			success:function(data) {
				$( '#return-trigger' ).html(data);
				console.log(data);
			},
			error: function(jqXHR, textStatus, errorThrown){
				$( '#return-trigger' ).html(errorThrown);
				console.log(errorThrown);
			}
		});  
	});      
});