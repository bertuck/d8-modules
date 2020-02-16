CKEDITOR.dialog.add( 'customlinkDialog', function( editor ) {
    var selection = editor.getSelection();

    if (CKEDITOR.env.ie) {
        selection.unlock(true);
        selectedText = selection.getNative().createRange().text;

    } else {
        selectedText = selection.getSelectedText();
    }

    return {
        title: 'Propriétés du lien',
        minWidth: 400,
        minHeight: 70,

        contents: [
            {
                id: 'tab-basic',
                label: 'Icon Settings',
                elements: [
                    {
                        type: 'text',
                        id: 'label',
                        label: 'Label',
                        default: selectedText,
                        validate: CKEDITOR.dialog.validate.notEmpty( "label field cannot be empty." )
                    },
                    {
                        type: 'text',
                        id: 'uri',
                        label: 'Lien',
                        validate: CKEDITOR.dialog.validate.notEmpty( "uri field cannot be empty." )
                    },
                    {
                        type: 'text',
                        id: 'title',
                        label: 'Attribute title',
                        default: selectedText
                    },
                    {
                        type: 'select',
                        id: 'target',
                        label: 'Target',
                        items: [ [ 'none' ], [ '_blank' ], [ '_self' ],[ '_parent' ],[ '_top' ] ],
                        'default': 'none'
                    }
                ]
            }
        ],
        onOk: function() {
            var dialog = this;

            var link = editor.document.createElement( 'a' );
            var link_label = dialog.getValueOf( 'tab-basic', 'label');
            var link_uri = dialog.getValueOf( 'tab-basic', 'uri');
            var link_title_attr = dialog.getValueOf( 'tab-basic', 'title');
            var link_target = dialog.getValueOf( 'tab-basic', 'target');
            if (link_title_attr === "") { link_title_attr = link_label; }
            if (link_target != 'none') {
                if (link_target == '_blank') {
                    link_title_attr = link_title_attr + " (Nouvelle fenêtre)"
                }
                link.setAttribute('target', link_target);
            }
            link.setAttribute('href', link_uri);
            link.setAttribute('title', link_title_attr);
            link.setText(link_label);
            editor.insertElement( link );
        }
    };
});