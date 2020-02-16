CKEDITOR.dialog.add( 'iconDialog', function( editor ) {
    return {
        title: 'Propriétés de l\'icone',
        minWidth: 400,
        minHeight: 70,

        contents: [
            {
                id: 'tab-basic',
                label: 'Icon Settings',
                elements: [
                    {
                        type: 'text',
                        id: 'icon',
                        label: 'Classe de l\'icone',
                        validate: CKEDITOR.dialog.validate.notEmpty( "Icon field cannot be empty." )
                    },
                    {
                        type: 'text',
                        id: 'text',
                        label: 'Texte à droite',
                        validate: CKEDITOR.dialog.validate.notEmpty( "Text field cannot be empty." )
                    }
                ]
            }
        ],
        onOk: function() {
            var dialog = this;
            var icon_block = editor.document.createElement( 'div' );
            icon_block.setAttribute('class', 'icon-block');
            var icon = editor.document.createElement( 'div' );
            var icon_text = dialog.getValueOf( 'tab-basic', 'icon');
            var icon_class = icon_text;
            icon.setAttribute('class', icon_class);
            var text = dialog.getValueOf( 'tab-basic', 'text');
            icon_block.append(icon);
            if (text != '') {
                var text_right = editor.document.createElement( 'p' );
                text_right.setText(text);
                icon_block.append(text_right);
                editor.insertElement( icon_block );
            }
            else {
                editor.insertElement( icon );
            }
        }
    };
});