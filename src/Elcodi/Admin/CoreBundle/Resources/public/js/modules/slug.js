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
		autobind: function (oTarget) {

			var oParent = document.getElementById(oTarget.getAttribute("data-fc-parent")),
				sSlug;

			$(oParent).on('change', function() {
				sSlug = this.value;
				oTarget.value = sSlug.replace(/\s+/g, '-').toLowerCase();
			});
		}
	};
});

