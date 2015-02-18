TinyCore.AMD.define('hide', [], function () {
	return {
		onStart: function () {

			var aTargets = oTools.getDataModules('hide'),
				self = this;

			oTools.trackEvent('JS_Libraries', 'call', 'hide');

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

