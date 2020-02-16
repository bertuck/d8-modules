(function($) {
    CKEDITOR.plugins.add( 'accordion', {
        icons: 'accordion',
        init: function( editor ) {
            editor.addCommand( 'accordion', new CKEDITOR.dialogCommand( 'accordionDialog' ) );
            editor.ui.addButton( 'Accordion', {
                label: 'Ajouter un accordion',
                command: 'accordion',
                toolbar: 'accordion'
            });

            CKEDITOR.dialog.add( 'accordionDialog', this.path + 'dialogs/accordion.js' );
        }
    });
})(jQuery);