jQuery(document).ready(function($) {
	$('body').on( 'click','#csw-upload', function(e){
		e.preventDefault();
		var upload_button = $(this),
		custom_media_uploader = wp.media({
			title: csw_params.upload,
			library : {
				type : 'image'
			},
			button: {
				text: csw_params.use
			},
			multiple: false
		}).on('select', function() {
			var attachment = custom_media_uploader.state().get('selection').first().toJSON();
      document.getElementById('custom_spinner_gif').value = attachment.id;
      document.getElementById('csw-preview').src = attachment.url;
		}).open();

	});

	$('body').on('click', '.custom-upload-remove', function(e){
		e.preventDefault();

	});
});
