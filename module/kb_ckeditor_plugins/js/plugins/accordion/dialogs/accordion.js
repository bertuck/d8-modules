CKEDITOR.dialog.add( 'accordionDialog', function( editor ) {
    return {
        title: 'Propriétés de l\'accordion',
        minWidth: 400,
        minHeight: 70,

        contents: [
            {
                id: 'tab-basic',
                label: 'Accordion Settings',
                elements: [
                    {
                        type: 'text',
                        id: 'title',
                        label: 'Titre',
                        validate: CKEDITOR.dialog.validate.notEmpty( "Title field cannot be empty." )
                    },
                    {
                        type: 'select',
                        id: 'collapsed',
                        label: 'Fermé',
                        items: [ [ 'Oui' ], [ 'Non' ] ],
                        'default': 'Non',
                    }
                ]
            },
        ],
        onOk: function() {
            var dialog = this;
            var id = Math.random().toString(36).substr(2, 9);
            var accordion = editor.document.createElement( 'div' );

            accordion.setAttribute('class', "panel-group tabbed-data-list accordion");
            accordion.setAttribute("aria-multiselectable", "true");
            // accordion.setAttribute("role", "tablist");
            accordion.setAttribute("aria-multiselectable", "true");

            var accordion_subdiv = editor.document.createElement( 'div' );
            accordion_subdiv.setAttribute('class', "panel panel-default");

            var accordion_title = editor.document.createElement( 'div' );
            accordion_title.setAttribute('class', "panel-heading");

            accordion_title.setAttribute("id", "tabbeddata-list-"+id+"-head-01");

            var accordion_title_p = editor.document.createElement( 'h2' );
            accordion_title_p.setAttribute('class', "panel-title");
            accordion_title_p.setAttribute("role", "heading");



            var accordion_title_button = editor.document.createElement( 'button' );
            accordion_title_button.setAttribute("data-toggle", "collapse");
            if (dialog.getValueOf( 'tab-basic', 'collapsed') == 'Oui') {
                accordion_title_button.setAttribute('class', "collapse");
                accordion_title_button.setAttribute("aria-expanded", "false");
            }
            else {
                accordion_title_button.setAttribute("class", "collapse in");
                accordion_title_button.setAttribute("aria-expanded", "true");
            }
            accordion_title_button.setAttribute("role", "button");
            accordion_title_button.setAttribute("data-parent", "#tabbeddata-list-"+id);
            accordion_title_button.setAttribute("href", "#tabbeddata-list-"+id+"-body-01");
            accordion_title_button.setText(dialog.getValueOf( 'tab-basic', 'title'));

            accordion_title_p.append(accordion_title_button);
            accordion_title.append(accordion_title_p);

            var accordion_body = editor.document.createElement( 'div' );
            accordion_body.setAttribute('class', "panel-collapse collapse");
            accordion_body.setAttribute("id", "tabbeddata-list-"+id+"-body-01");
            accordion_body.setAttribute("aria-labelledby", "tabbeddata-list-"+id+"-head-01");

            var accordion_body_panel = editor.document.createElement( 'div' );
            accordion_body_panel.setAttribute('class', "panel-body");

            var accordion_body_inner = editor.document.createElement( 'p' );

            accordion_body_inner.setText('ENTREZ VOTRE TEXTE ICI !');

            accordion_body_panel.append(accordion_body_inner);
            accordion_body.append(accordion_body_panel);

            accordion_subdiv.append(accordion_title);
            accordion_subdiv.append(accordion_body);
            accordion.append(accordion_subdiv);

            editor.insertElement( accordion );
        }
    };
});