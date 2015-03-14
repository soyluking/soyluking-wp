jQuery(document).ready(function($){
	function checkFormat(){
		var format = $('#post-formats-select input:checked').attr('value');
		
		//only run on the posts page
		if(typeof format !== 'undefined'){
			
			$('#post-body div[id^=post_meta_]').hide();
			$('#post-body div[id^=post_meta_'+format+']').stop(true,true).fadeIn(500);
					
		}
	
	}
	$('#post-formats-select input').change(checkFormat);
	$(window).load(function(){
		checkFormat();
	});
	
	var importBtn = jQuery('#import-demo-content');
	
	importBtn.bind("click", function(e){
		e.preventDefault();

		
		importBtn.addClass('disabled').attr('disabled', 'disabled').unbind('click');
		
		jQuery.ajax({
			method: "POST",
			url: ajaxurl,
			data: {
				'action':'thb_import_ajax'
			},
			success: function(data){
				jQuery('#option-tree-header-wrap').before('<div id="message" class="updated fade below-h2"><p>'+data+' Theme Options updated.</p></div>');
			},
			complete: function(){
        window.location.href=window.location.href;
			}
		});
	
	});
});