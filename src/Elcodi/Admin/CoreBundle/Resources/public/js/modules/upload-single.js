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
		autoBind: function( oTarget ) {

			var self = this,
				sName = oTarget.id,
				uploader = new plupload.Uploader({
					runtimes : 'html5,flash,silverlight,html4',

					browse_button : sName,

					url : document.getElementById(sName).href,

					filters : {
						max_file_size : '20mb',
						mime_types: [
							{title : "Image files", extensions : "jpg,png"}
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
								nId, sFormat, sUrlView, sUrlDelete, sUrlSave, nWidth, nHeight, nType;

							if (sName.indexOf('header') !== -1 ) {
								nHeight = 150;
								nWidth = 600;
								nType = 5;
							} else {
								nHeight = 100;
								nWidth = 300;
								nType = 4;
							}

							if (oResponse.status === 'ok') {
								nId = oResponse.response.id;
								sFormat = oResponse.response.extension;
								sUrlSave = oTarget.getAttribute('data-url');
								sUrlView = oResponse.response.routes.resize.replace('{height}', nHeight ).replace('{width}',nWidth).replace('{type}', nType ).replace('{id}', nId).replace('{_format}', sFormat);
								sUrlDelete = oResponse.response.routes['delete'].replace('{id}', nId);
								self.saveImage(sName, nId, sUrlSave, sUrlView, sUrlDelete);

							} else {
								alert('Ops! Looks like something is wrong. Sorry, try again later or contact your administrator to inform about the error.');
							}

						},

						UploadProgress: function(up, file) {
							document.getElementById( sName + '-progress').value = up.total.percent ;
						},

						UploadComplete: function() {
							$('#thumb-no-items').slideUp('fast');
							$(document.getElementById(sName + '-progress')).fadeOut();
						}
					}
				});

			self.bindDelete( sName );

			uploader.init();
		},
		bindDelete : function( sName ) {

			$('#' + sName + '-delete').click( function( e ){

				e.preventDefault();

				var oTarget = this;

				$.ajax({
					url: oTarget.href,
					type: 'post',
					data: {
						value: null
					},
					success: function() {
						oTarget.style.display = 'none';
						document.getElementById(sName + '-image').style.display = 'none';
					}
				});
			});
		},
		saveImage : function( sName, nId, sUrlSave, sUrlView, sUrlDelete) {

			$.ajax({
				url: sUrlSave,
				type: 'post',
				data: {
					value: nId
				},
				success: function() {
					$('img', '#' + sName + '-image').attr('src', sUrlView);
					document.getElementById(sName + '-image').style.display = 'block';
					document.getElementById(sName + '-delete').style.display = 'inline-block';
				}
			});

		}
	};
});



