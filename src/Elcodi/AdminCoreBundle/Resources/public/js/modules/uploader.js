TinyCore.AMD.define('uploader', [ oGlobalSettings.sPathJs + '../components/plupload/js/plupload.full.min.js' ], function () {
	return {
		onStart: function () {

			var uploader = new plupload.Uploader({
				runtimes : 'html5,flash,silverlight,html4',

				browse_button : 'pickfiles',

				url : document.getElementById('pickfiles').href,

				filters : {
					max_file_size : '100mb',
					mime_types: [
						{title : "Image files", extensions : "jpg,gif,png"}
					]
				},

				// Flash settings
				flash_swf_url : oGlobalSettings.sPathJs + '../components/plupload/js/Moxie.swf',

				// Silverlight settings
				silverlight_xap_url : oGlobalSettings.sPathJs + '../components/plupload/js/Moxie.xap',

				init: {

					FilesAdded: function(up, file) {
						$(document.getElementById('progresBar')).attr('value',0).fadeIn();
						up.start();
					},

					FileUploaded: function(up, file, response) {
						self.addImageToGallery(File.id, File, Response.response);

					},

					UploadProgress: function(up, file) {
						document.getElementById('progresBar').value = up.total.percent ;
					},

					UploadComplete: function() {
						$(document.getElementById('progresBar')).fadeOut();
					},

					Error: function(up, err) {
						console.log(err.code);
					}
				}
			});

			this.updateSelect();

			uploader.init();

		},
		updateSelect : function() {

			console.log('dentro');

			var oSelect = document.getElementById('elcodi_admin_product_form_type_product_images'),
				oThumbs = document.getElementById('thumb-gallery'),
				sName;

			$('option' , oSelect).each( function() {
				$(this).removeAttr('selected');
			});

			$('img' , oThumbs).each( function() {
				sName = parseInt(this.id.replace('image-',''), 10);

				$('option[value='+ sName +']', oSelect).attr('selected','selected');

			});
		},
		addImageToGallery : function( sId, sPath, oResponse) {
			var oSelect = document.getElementById('elcodi_admin_product_form_type_product_images');
		}
	};
});



