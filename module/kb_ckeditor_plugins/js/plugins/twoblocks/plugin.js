(function($) {
    CKEDITOR.plugins.add( 'twoblocks', {
        icons: 'twoblocks',
        init: function( editor ) {
            editor.addCommand( 'twoblocks', new CKEDITOR.dialogCommand( 'twoblocksDialog' ) );
            editor.ui.addButton( 'twoblocks', {
                label: 'Ajouter 2 blocs',
                command: 'twoblocks',
                toolbar: 'twoblocks'
            });

            CKEDITOR.dialog.add( 'twoblocksDialog', this.path + 'dialogs/twoblocks.js' );
        }
    });
})(jQuery);