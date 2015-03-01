TinyCore.AMD.define('slug', ['devicePackage'], function () {
	return {
		onStart: function () {

			var aTargets = oTools.getDataModules('slug'),
				self = this;

			oTools.trackEvent('JS_Libraries', 'call', 'slug');

				$(aTargets).each(function () {
					if ($('#' + this.getAttribute("data-tc-parent")).val() === '') {
						console.log('dentro');
						self.autobind(this);
					}
				});
		},
		autobind: function (oTarget) {

			var oParent = document.getElementById(oTarget.getAttribute("data-tc-parent")),
				sSlug;

			$(oParent).on('change', function() {
				sSlug = this.value;
				oTarget.value = sSlug.replace(/\s+/g, '-').toLowerCase();
			});
		}
	};
});

