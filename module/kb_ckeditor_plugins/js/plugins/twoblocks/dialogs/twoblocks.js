CKEDITOR.dialog.add( 'twoblocksDialog', function( editor ) {
    return {
        title: 'Propriétés des blocs',
        minWidth: 400,
        minHeight: 70,

        contents: [
            {
                id: 'tab-basic',
                label: 'Block Left Settings',
                elements: [
                    {
                        type: 'text',
                        id: 'text',
                        label: 'Texte Gauche',
                        validate: CKEDITOR.dialog.validate.notEmpty( "Title field cannot be empty." )
                    }
                ]
            },
            {
                id: 'tab-basic2',
                label: 'Block Right Settings',
                elements: [
                    {
                        type: 'text',
                        id: 'text',
                        label: 'Texte Droite',
                        validate: CKEDITOR.dialog.validate.notEmpty( "Title field cannot be empty." )
                    }
                ]
            }
        ],
        onOk: function() {
            var dialog = this;

            var blocks = editor.document.createElement( 'div' );
            blocks.setAttribute('class', 'ckeditor-blocks');

            var block_left = editor.document.createElement( 'div' );
            block_left.setAttribute('class', "left");
            var text_left = dialog.getValueOf( 'tab-basic', 'text');

            var block_text_inner_left = editor.document.createElement( 'p' );
            block_text_inner_left.setText(text_left);
            block_left.append(block_text_inner_left);


            var block_right = editor.document.createElement( 'div' );
            block_right.setAttribute('class', "right");
            var text_right = dialog.getValueOf( 'tab-basic2', 'text');

            var block_text_inner_right = editor.document.createElement( 'p' );
            block_text_inner_right.setText(text_right);
            block_right.append(block_text_inner_right);

            blocks.append(block_left);
            blocks.append(block_right);

            editor.insertElement( blocks );
        }
    };
});