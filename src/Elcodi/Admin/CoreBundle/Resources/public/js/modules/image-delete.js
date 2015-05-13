FrontendCore.define('image-delete', [], function () {
	return {
		uploader: TinyCore.Module.instantiate('upload-gallery'),
		onStart: function () {

			var aTargets = FrontendTools.getDataModules('image-delete'),
				self = this;

			FrontendTools.trackEvent('JS_Libraries', 'call', 'image-delete');


			$(aTargets).each(function () {
				self.autobind(this);
			});

		},
		autobind: function (oTarget) {


			var self = this;

			$(oTarget).on('click', function (event) {

				var sClassName = event.target.className + ' ' + $(event.target).closest('a').attr('class');

				if (sClassName.indexOf('icon-trash-o') !== -1) {

					event.preventDefault();

					var sHref = event.target.href,
						sIdDelete = event.target.getAttribute('data-fc-delete'),
						sMessage = event.target.getAttribute('data-fc-message');

					$('#' + sIdDelete).addClass('animated').addClass('fade-out');

					$.ajax({
						url: sHref
					}).done(function () {

						if (sIdDelete !== null) {
							$('#' + sIdDelete).remove();

							self.uploader.updateSelect();
						}

						if (sMessage !== null) {
							FrontendMediator.publish('notification', {type: 'ok', message: sMessage});
						}

					});

				}

			});
		}
	};
});

