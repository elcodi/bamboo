FrontendCore.define('upload-single', [ oGlobalSettings.sPathJs + '../components/plupload/js/plupload.full.min.js','modal' ], function () {
	return {
		modal:  TinyCore.Module.instantiate( 'modal' ),
		onStart: function () {
			var aTargets =  FrontendTools.getDataModules('upload-single'),
				self = this;

			$(aTargets).each(function () {
				self.autoBind(this);
			});

		},
		updateSelect : function( oContainer, nId , nodeName ) {

			if (nodeName === 'SELECT') {
				$('option', oContainer ).filter(function() {
					//may want to use $.trim in here
					return $(this).val() == nId;
				}).prop('selected', true);

			} else {
				$('input', oContainer).each( function() {
					$(this).removeAttr('checked');
				});

				if (nId !== undefined ) {
					$('input[id=elcodi_admin_product_form_type_manufacturer_'+ nId +']', oContainer).click();

				}
			}

		},
		addImageToGallery : function( oContainer, nId) {

			var self = this,
				oOption;

			if (oContainer.nodeName === 'SELECT') {
				oOption = document.createElement('option');
				oOption.id = 'elcodi_admin_product_form_type_manufacturer_' + nId;
				oOption.value = nId;
				oOption.innerHTML = nId;

			} else if ($('#elcodi_admin_product_form_type_manufacturer_images_' + nId , oContainer).length === 0) {

				oOption = document.createElement('input');
				oOption.type = 'checkbox';
				oOption.name = 'elcodi_admin_product_form_type_manufacturer[images][]';
				oOption.id = 'elcodi_admin_product_form_type_manufacturer_' + nId;

			}

			oOption.value = nId;
			$(oContainer).append(oOption);

			self.updateSelect( oContainer, nId, oContainer.nodeName );
		},
		autoBind: function( oTarget ) {

			var self = this,
				sName = oTarget.id,
				oContainer = $(oTarget).closest('.grid').find('.js-images-select')[0],
				uploader = new plupload.Uploader({
					runtimes : 'html5,flash,silverlight,html4',

					browse_button : sName,

					url : document.getElementById(sName).href,

					filters : {
						max_file_size : '20mb',
						mime_types: [
							{title : "Image files", extensions : "jpg,png,gif,jpeg"}
						]
					},

					// Flash settings
					flash_swf_url : oGlobalSettings.sPathJs + '../components/plupload/js/Moxie.swf',

					// Silverlight settings
					silverlight_xap_url : oGlobalSettings.sPathJs + '../components/plupload/js/Moxie.xap',

					init: {

						FilesAdded: function(up, file) {
							$(document.getElementById( sName + '-progress')).attr('value',0).fadeIn();
							up.start();
						},

						FileUploaded: function(up, file, response) {

							var oResponse = $.parseJSON(response.response),
								nId, sFormat, sUrlView, sUrlDelete, sUrlSave, nWidth = 0, nHeight = 0, nType = 2;


							if ( oTarget.getAttribute('data-fc-width') !== null) {
								nWidth = oTarget.getAttribute('data-fc-width');
							}

							if ( oTarget.getAttribute('data-fc-height') !== null) {
								nHeight = oTarget.getAttribute('data-fc-height');
							}

							if ( nHeight === 0 & nWidth === 0  ){
								if ( sName.indexOf('header') !== -1 ) {
									nHeight = 150;
									nWidth = 600;
									nType = 5;
								} else if ( sName.indexOf('background') !== -1 ) {
									nHeight = 400;
									nWidth = 600;
									nType = 4;
								} else {
									nHeight = 100;
									nWidth = 300;
									nType = 4;
								}
							}


							if (oResponse.status === 'ok') {
								nId = oResponse.response.id;
								sFormat = oResponse.response.extension;
								sUrlSave = oTarget.getAttribute('data-url');
								sUrlView = oResponse.response.routes.resize.replace('{height}', nHeight).replace('{width}', nWidth).replace('{type}', nType).replace('{id}', nId).replace('{_format}', sFormat);
								sUrlDelete = oResponse.response.routes['delete'].replace('{id}', nId);
							}

							if (oTarget.getAttribute('data-url') !== null ) {
								if (oResponse.status === 'ok') {
									self.saveImage(oContainer, sName, nId, sUrlSave, sUrlView, sUrlDelete);
								} else {
									alert('Ops! Looks like something is wrong. Sorry, try again later or contact your administrator to inform about the error.');
								}
							} else {
								if (oResponse.status === 'ok') {
									self.addImageToGallery( oContainer, oResponse.response.id  );
									self.updateImage( oContainer, sName, sUrlView, sUrlDelete);
								}
							}



						},

						UploadProgress: function(up, file) {
							document.getElementById( sName + '-progress').value = up.total.percent ;
						},

						UploadComplete: function() {
							$(document.getElementById(sName + '-progress')).fadeOut();
						}
					}
				});

			self.bindDelete( oContainer, sName );

			uploader.init();
		},
		bindDelete : function( oContainer, sName ) {

			var self = this;

			$('#' + sName + '-delete').click( function( e ){

				e.preventDefault();

				var oTarget = this;

					if (oContainer.nodeName === 'SELECT') {
						$('option:first', oContainer).prop('selected', true);
						oTarget.style.display = 'none';
						document.getElementById(sName + '-image').style.display = 'none';
						self.updateSelect(oContainer);
					} else {
						$.ajax({
							url: oTarget.href,
							type: 'post',
							data: {
								value: null
							},
							success: function() {
								oTarget.style.display = 'none';
								document.getElementById(sName + '-image').style.display = 'none';
								self.updateSelect(oContainer);
							}
						});
					}
			});
		},
		updateImage : function( oContainer, sName, sUrlView, sUrlDelete ) {
			$('img', '#' + sName + '-image').attr('src', sUrlView);
			document.getElementById(sName + '-image').style.display = 'block';
			document.getElementById(sName + '-delete').style.display = 'inline-block';
			document.getElementById(sName + '-delete').href = sUrlDelete;
		},
		saveImage : function( oContainer, sName, nId, sUrlSave, sUrlView, sUrlDelete) {

			var self = this;

			$.ajax({
				url: sUrlSave,
				type: 'post',
				data: {
					value: nId
				},
				success: function() {
					self.updateImage(oContainer, sName, sUrlView, sUrlDelete);
				}
			});
		}
	};
});



