(function($) {
    CKEDITOR.plugins.add( 'icon', {
        icons: 'icon',
        init: function( editor ) {
            editor.addCommand( 'icon', new CKEDITOR.dialogCommand( 'iconDialog' ) );
            editor.ui.addButton( 'icon', {
                label: 'Ajouter une icone',
                command: 'icon',
                toolbar: 'icon'
            });

            CKEDITOR.dialog.add( 'iconDialog', this.path + 'dialogs/icon.js' );
        }
    });
})(jQuery);