TinyCore.AMD.define('modal-content', ['devicePackage','modal' ], function () {
	return {
		oModal:  TinyCore.Module.instantiate( 'modal' ),
		onStart: function () {

			var aTargets = FC.getDataModules('modal-content'),
				self = this;

			FC.trackEvent('JS_Libraries', 'call', 'modal-content');

			$(aTargets).each(function () {
				self.autobind(this);
			});

		},
		autobind: function( oTarget ){

			var self = this;

			$(oTarget).on('click',function(event) {
				event.preventDefault();

				// 4.Open in a modal this href
				self.oModal.open({
					href: this.href,
					iframe: true,
					fastIframe : false,
					width: '90%',
					height: '80%',
					onOpen: function() {
						$("#cboxContent").hide();
						console.log('va');
					},
					onComplete: function() {
						$("iframe").contents().find(".sidebar").remove();
						$("iframe").contents().find(".col-4-5.pull-right").attr('class','col-1-1');
						$("#cboxContent").fadeIn();
					}
				});
			});
		}
	};
});

