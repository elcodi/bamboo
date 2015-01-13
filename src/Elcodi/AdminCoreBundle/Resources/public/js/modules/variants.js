TinyCore.AMD.define('variants', ['devicePackage','modal' ], function () {
    return {
        modal:  TinyCore.Module.instantiate( 'modal' ),
        mediator : TinyCore.Toolbox.request( 'mediator' ),
        onStart: function () {


            if (TinyCore !== undefined) {
                TinyCore.AMD.requireAndStart('notification');
            }

            this.mediator.subscribe( ['response:success'], this.updateVariants, this );

        },
        bindLinks: function() {

            var self = this;

            $('a' , '#variants-list').on('click',function(event) {

                if ( this.className.indexOf('icon-trash-o') == -1 ) {

                    event.preventDefault();

                    self.modal.open({
                        iframe: true,
                        href: this.href,
                        width: '90%',
                        height: '90%'
                    });
                } else {

                    var sText = this.getAttribute("data-tc-text") ? this.getAttribute("data-tc-text") : 'Are you sure?',
                        sName = this.getAttribute("data-tc-name") ? this.getAttribute("data-tc-name") : 'Delete this item.';

                    if (!confirm("\n"+ sName + ":\n" + sText + "\n")) {
                        return false;
                    }
                }
            });
        },
        updateVariants: function( oResponse ) {

            var self = this;

            self.mediator.publish( 'notification', { type : 'ok', message: document.getElementById('variants-message-ok').value } );

            document.getElementById('variants-list').innerHTML = '<p class="ta-c pa-xl"><i class="icon-spin icon-spinner fz-xl"></i></p>';

            $.get(oResponse.data.url, function( sHtml ) {

                document.getElementById('variants-list').innerHTML = sHtml;

                self.bindLinks();

            });


            this.modal.close();
        }
    };
});

