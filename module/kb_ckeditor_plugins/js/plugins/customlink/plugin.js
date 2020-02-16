(function($) {
    CKEDITOR.plugins.add( 'customlink', {
        icons: 'customlink',
        init: function( editor ) {
            editor.addCommand( 'customlink', new CKEDITOR.dialogCommand( 'customlinkDialog' ) );
            editor.ui.addButton( 'customlink', {
                label: 'Ajouter un lien',
                command: 'customlink',
                toolbar: 'customlink'
            });

            CKEDITOR.dialog.add( 'customlinkDialog', this.path + 'dialogs/customlink.js' );
        }
    });
})(jQuery);