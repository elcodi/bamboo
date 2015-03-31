FrontendCore.define('slug', ['devicePackage'], function () {
	return {
		onStart: function () {

			var aTargets = FrontendTools.getDataModules('slug'),
				self = this;

			FrontendTools.trackEvent('JS_Libraries', 'call', 'slug');

				$(aTargets).each(function () {
					if ($('#' + this.getAttribute("data-fc-parent")).val() === '') {
						self.autobind(this);
					}
				});
		},
		slugify: function ( sSlug ) {
			return sSlug.replace(/_/g, '-')
				.replace(/ /g, '-')
				.replace(/:/g, '-')
				.replace(/\\/g, '-')
				.replace(/\//g, '-')
				.replace(/[^a-zA-Z0-9\-]+/g, '')
				.replace(/-{2,}/g, '-')
				.toLowerCase();
		},
		autobind: function (oTarget) {

			var oParent = document.getElementById(oTarget.getAttribute("data-fc-parent")),
				self = this;

			$(oParent).on('change', function() {
				oTarget.value = self.slugify(this.value);
			});
		}
	};
});

