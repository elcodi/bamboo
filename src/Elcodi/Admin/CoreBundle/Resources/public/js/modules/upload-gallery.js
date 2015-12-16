FrontendCore.define('upload-gallery', [ oGlobalSettings.sPathJs + '../components/plupload/js/plupload.full.min.js','modal' ], function () {
	return {
		modal:  TinyCore.Module.instantiate( 'modal' ),
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
							nId, sFormat, sUrlEdit, sUrlDelete;

						if (oResponse.status === 'ok') {
							nId = oResponse.response.id;
							sFormat = oResponse.response.extension;
							sUrlEdit = oResponse.response.routes.resize.replace('{height}', '150').replace('{width}', '150').replace('{type}', '5').replace('{id}', nId).replace('{_format}', sFormat);
							sUrlDelete = oResponse.response.routes['delete'].replace('{id}', nId);
							self.addImageToGallery(nId, sUrlEdit, sUrlDelete);

						} else {
							alert('Ops! Looks like something is wrong. Sorry, try again later or contact your administrator to inform about the error.');
						}

					},

					UploadProgress: function(up, file) {
						document.getElementById('progresBar').value = up.total.percent ;
					},

					UploadComplete: function() {
						$(document.getElementById('progresBar')).fadeOut();
					},

					Error: function(up, err) {
						//console.log(err.code);
					}
				}
			});

			this.updateSelect();

			uploader.init();

		},
		updateSelect : function() {

			var oContainer = document.getElementById('thumb-gallery-select'),
				oThumbs = document.getElementById('thumb-gallery'),
				nId;

			$('input', oContainer).each( function() {
				$(this).removeAttr('checked');
			});

			$('img' , oThumbs).each( function() {
				nId = parseInt(this.id.replace('image-',''), 10);

				$('input[id=elcodi_admin_product_form_type_product_images_'+ nId +']', oContainer).click();
				$('input[id=elcodi_admin_product_form_type_product_variant_images_'+ nId +']', oContainer).click();
				$('input[id=elcodi_admin_product_form_type_purchasable_pack_images_'+ nId +']', oContainer).click();

			});

		},
		addImageToGallery : function( nId, sUrlView, sUrlDelete) {

			var self = this,
				oContainer = $('.js-images-select')[0],
				oThumbs = document.getElementById('thumb-gallery'),
				oLi = document.createElement('li'),
				oLink = document.createElement('a'),
				oThumb = document.createElement('img'),
				oOption,
				oActions = '<ul class="thumbnail-actions"><li><a href="' + sUrlDelete + '" class="icon-trash-o" data-fc-modules="ajax-link" data-fc-delete="'+ nId +'"></a></li></ul>';


				if ($('#elcodi_admin_product_form_type_product_images_' + nId , oContainer).length === 0) {
					oOption = document.createElement('input');
					oOption.type = 'checkbox';
					oOption.name = 'elcodi_admin_product_form_type_product[images][]';
					oOption.id = 'elcodi_admin_product_form_type_product_images_' + nId;
					oOption.value = nId;
					$(oContainer).append(oOption);
				}

				if ($('#elcodi_admin_product_form_type_product_variant_images_' + nId , oContainer).length === 0) {
					oOption = document.createElement('input');
					oOption.type = 'checkbox';
					oOption.name = 'elcodi_admin_product_form_type_product_variant[images][]';
					oOption.id = 'elcodi_admin_product_form_type_product_variant_images_' + nId;
					oOption.value = nId;
					$(oContainer).append(oOption);
				}

				if ($('#elcodi_admin_product_form_type_purchasable_pack_images_' + nId , oContainer).length === 0) {
					oOption = document.createElement('input');
					oOption.type = 'checkbox';
					oOption.name = 'elcodi_admin_product_form_type_purchasable_pack[images][]';
					oOption.id = 'elcodi_admin_product_form_type_purchasable_pack_images_' + nId;
					oOption.value = nId;
					$(oContainer).append(oOption);
				}

				oLi.id = nId;
				oLi.className = 'animated fadeIn';
				oLi.setAttribute('draggable','true');

				oLink.id = 'link-' + nId;
				oLink.href = sUrlView;
				oLink.className = 'group-images thumbnail';
				oLink.dataset.tcModules = 'modal';

				oThumb.id = nId;
				oThumb.src = sUrlView;
				oThumb.width = 150;

				oLink.innerHTML = oThumb.outerHTML;

				oLi.innerHTML = oLink.outerHTML + oActions;

				oThumbs.appendChild(oLi);

				$(document.getElementById('link-' + nId)).on('click',function(e) {
					e.preventDefault();
					self.modal.open({ href: this.href});
				});

				if ( $('.js-image-order').val() === '') {
					$('.js-image-order').val( $('input:checked', '#thumb-gallery-select').val() + ',' +  nId + ',' );
				} else {

					$('.js-image-order').val( $('.js-image-order').val().replace('undefined,','') + nId + ',' );
				}
			
				self.updateSelect();
		}
	};
});



