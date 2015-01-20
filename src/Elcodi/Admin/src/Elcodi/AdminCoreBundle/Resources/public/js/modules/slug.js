TinyCore.AMD.define('slug', ['devicePackage'], function () {
	return {
		onStart: function () {

			var aTargets = FC.getDataModules('slug'),
				self = this;

			FC.trackEvent('JS_Libraries', 'call', 'slug');

			if (document.getElementById('breadcrumb').innerHTML.indexOf('Create new Category') !== -1) {
				$(aTargets).each(function () {
					self.autobind(this);
				});
			}

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

