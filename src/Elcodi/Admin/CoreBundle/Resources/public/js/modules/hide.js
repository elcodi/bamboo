FrontendCore.define('hide', [], function () {
	return {
		onStart: function () {

			var aTargets = FrontendTools.getDataModules('hide'),
				self = this;

			FrontendTools.trackEvent('JS_Libraries', 'call', 'hide');

			$(aTargets).each(function () {
				self.autobind(this);
			});

		},
		autobind: function (oTarget) {

			setTimeout( function(){
				oTarget.style.display = 'none';
			}, 1000);
		}
	};
});

