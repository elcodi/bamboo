FrontendCore.define('confirm', ['devicePackage' ], function () {
    return {
        onStart: function () {

            var aTargets = FrontendTools.getDataModules('confirm'),
                self = this;

            FrontendTools.trackEvent('JS_Libraries', 'call', 'slug');

            $(aTargets).each(function () {
                self.autobind(this);
            });

        },
        autobind: function (oTarget) {

            var sText = oTarget.getAttribute("data-fc-text") ? oTarget.getAttribute("data-fc-text") : 'Are you sure?',
                sName = oTarget.getAttribute("data-fc-name") ? oTarget.getAttribute("data-fc-name") : 'Delete this item.';

            $(oTarget).on('click', function() {
                if (!confirm("\n"+ sName + ":\n" + sText + "\n")) {
                    return false;
                }
            });
        }
    };
});

