TinyCore.AMD.define('uploader', [ oGlobalSettings.sPathJs + '../components/plupload/js/plupload.full.min.js' ], function () {
	return {
		onStart: function () {

			var self = this,
				uploader = new plupload.Uploader({
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

						var oResponse = $.parseJSON(response.response),
							nId = oResponse.response.id,
							sUrlEdit = oResponse.response.routes.view.replace('{id}', nId),
							sUrlDelete = oResponse.response.routes['delete'].replace('{id}', nId);

						self.addImageToGallery(nId, sUrlEdit, sUrlDelete);

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
		addImageToGallery : function( nId, sUrlView, sUrlDelete) {

			var self = this,
				oSelect = document.getElementById('elcodi_admin_product_form_type_product_images'),
				oThumbs = document.getElementById('thumb-gallery'),
				oLi = document.createElement('li'),
				oLink = document.createElement('a'),
				oThumb = document.createElement('img'),
				oOption,
				oActions = '<ul class="thumbnail-actions"><li><a href="' + sUrlDelete + '" class="icon-trash-o"></a></li></ul>';


				if ($('option[value='+ nId +']' , oSelect).length === 0) {
					oOption = document.createElement('option');
					oOption.value = oOption.innerHTML = nId;
					$(oSelect).append(oOption);

				}

				oLink.href = sUrlView;
				oLink.className = 'group-images thumbnail';
				oLink.dataset.tcModules = 'modal';

				oThumb.id = nId;
				oThumb.src = sUrlView;
				oThumb.width = 150;

				oLink.innerHTML = oThumb.outerHTML;
				oLi.innerHTML = oLink.outerHTML + oActions;

				oThumbs.appendChild(oLi);

				self.updateSelect();
		}
	};
});



