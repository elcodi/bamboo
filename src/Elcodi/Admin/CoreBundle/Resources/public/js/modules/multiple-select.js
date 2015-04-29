FrontendCore.define('multiple-select', ['devicePackage' ], function () {
    return {
        onStart: function () {

            var aTargets = FrontendTools.getDataModules('multiple-select'),
                self = this,
                oData,
                oSelects;

            FrontendTools.trackEvent('JS_Libraries', 'call', 'multiple-select');

            $('select[multiple="multiple"]', aTargets).each(function (nKey) {
                $(aTargets[nKey]).hide().before(self.createGrid( self.createSelect( self.getElements(this) , aTargets[nKey]) ));
            });

            self.bindSelect();

        },
        bindSelect : function( oTarget ){
            $('select','.js-select-multiple').change( function(){
               var sId = $(this).attr('data-rel'),
                   sValue = this.value,
                   sLabel = $(this).attr('data-group');

                $( 'option', 'optgroup[label="'+ sLabel + '"]').each( function(){
                    if ( this.value == sValue) {
                        this.selected = true;
                    } else {
                        this.selected = false;
                    }
                });
            });
        },
        createGrid : function(oSelects) {

            var oGrid = document.createElement('div'),
                nTotal = oSelects.length,
                nGrid = nTotal < 4 ? nTotal : 4;

            oGrid.className = 'grid js-select-multiple';

            for (var nKey = 0; oSelects.length > nKey; nKey++) {

                var oCol = document.createElement('div');

                oCol.className = 'col-1-' + nTotal;

                oCol.innerHTML = '<div class="pr-l"><label>'+ oSelects[nKey].label + '</label>' + oSelects[nKey].outerHTML + '</div>';

                oGrid.appendChild(oCol);

            }

            return oGrid;

        },
        createSelect: function( oData) {

            var oSelects = [],
                oOption;

            for ( var nCounter = 0; oData.data.length > nCounter; nCounter++ ) {

                oSelects[nCounter] = document.createElement('select');

                oSelects[nCounter].setAttribute('data-rel', oData.properties.id );
                oSelects[nCounter].setAttribute('data-group', oData.data[nCounter].properties.name );
                oSelects[nCounter].setAttribute('id', 'select-' + oData.data[nCounter].properties.name );

                oOption = document.createElement('option');
                oOption.value = '';
                oOption.innerHTML = '---';
                oSelects[nCounter].appendChild(oOption);

                for (var nKey = 0; oData.data[nCounter].data.length > nKey; nKey++) {

                    oOption = document.createElement('option');
                    oOption.value = oData.data[nCounter].data[nKey].value;
                    oOption.innerHTML = oData.data[nCounter].data[nKey].label;
                    if (oData.data[nCounter].data[nKey].selected){
                        oOption.setAttribute('selected','selected');
                    }
                    oSelects[nCounter].appendChild(oOption);

                    oOption = null;
                }

                oSelects[nCounter].label = oData.data[nCounter].properties.name;

            }

            return oSelects;


        },
        getElements: function(oTarget) {

            var oData = [],
                sLabel;

            oData.properties = [];
            oData.properties.name = oTarget.name;
            oData.properties.id = oTarget.id;

            oData.data = [];

            $('optgroup' , oTarget).each( function( nCounter ) {

               sLabel = this.label;

                oData.data[ nCounter ] = [];
                oData.data[ nCounter ].data = [];
                oData.data[ nCounter ].properties = [];
                oData.data[ nCounter ].properties.name = sLabel;


                $('option' , this).each( function( nKey ) {
                    oData.data[ nCounter].data[ nKey ] = [];
                    oData.data[ nCounter].data[ nKey ].value = this.value;
                    oData.data[ nCounter].data[ nKey ].label = this.innerHTML;
                    oData.data[ nCounter].data[ nKey ].selected = this.selected;
                });
            });

            return oData;

        }
    };
});

