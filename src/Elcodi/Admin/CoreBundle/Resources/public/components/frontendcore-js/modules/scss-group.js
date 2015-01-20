TinyCore.AMD.define('scss-group', ['devicePackage'], function () {
	return {
		oDefault: {
			limit: 12
		},
		onStart: function () {

			var aTargets = FC.getDataModules('scss-group'),
				self = this;

			FC.trackEvent('JS_Libraries', 'call', 'scss-group' );

			$(aTargets).each(function () {
				self.autobind(this);
			});
		},
		autobind: function (oTarget) {

			var sHtml = oTarget.innerHTML.replace('-default :', '-custom :'),
				sGroup = oTarget.getAttribute('data-tc-group'),
				aHtml = sHtml.split('/* @group ' + sGroup + ' */');

			oTarget.innerHTML = aHtml[1];

		},
		onStop: function () {
			this.sPathCss = null;
			this.oDefault = null;
		},
		onDestroy: function () {
			delete this.sPathCss;
			delete this.oDefault;
		}
	};
});