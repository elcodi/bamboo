// Defines the name of the module and the dependencies using RequireJS AMD standard definition
FrontendCore.define('print-to-blue', [], function () {
	return {

		// Uses oTools to get all the DOM elements
		// with the "data-tc-modules" attributes as print-to-blue
		aTargets : oTools.getDataModules('print-to-blue'),

		// This is the method called when the module is required
		onStart: function () {

			var self = this;

			// Uses Jquery to iterate all the elements and call the method printBlue for each one
			$(aTargets).each(function () {
				self.printBlue(this);
			});

		},
		printBlue: function (oTarget) {

			// Changes the color to blue
			$(oTarget).css('color','blue')

		},
		onStop: function () {

			// Clear aTargets if the module is stopped
			this.aTargets = null;
		},
		onDestroy: function () {

			// Liberates some memory if the module is destroyed
			delete this.aTargets;
		}
	};
});