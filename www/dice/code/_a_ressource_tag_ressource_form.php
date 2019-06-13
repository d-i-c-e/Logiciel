<?php

    if ($mf_action=='apercu_a_ressource_tag_ressource' && $_GET['act']!='ajouter_a_ressource_tag_ressource' && $_GET['act']!='supprimer_a_ressource_tag_ressource')
    {

        if (isset($Code_tag_ressource) && $Code_tag_ressource!=0 && isset($Code_ressource) && $Code_ressource!=0)
        {
            $a_ressource_tag_ressource = $table_a_ressource_tag_ressource->mf_get($Code_tag_ressource, $Code_ressource, array( 'autocompletion' => true ));
        }

        if (isset($a_ressource_tag_ressource['Code_tag_ressource']))
        {

            $fil_ariane->ajouter_titre(get_titre_ligne_table('a_ressource_tag_ressource', $a_ressource_tag_ressource), get_nom_page_courante().'?act=apercu_a_ressource_tag_ressource&Code_tag_ressource='.$Code_tag_ressource.'&Code_ressource='.$Code_ressource.'');

            if ( ! MULTI_BLOCS ) { $code_html = ''; }

            include __DIR__ . '/_a_ressource_tag_ressource_get.php';

            $code_html.=recuperer_gabarit('main/section.html', array(
                '{fonction}'  => 'apercu',
                '{nom_table}' => 'a_ressource_tag_ressource',
                '{titre}'     => htmlspecialchars(get_titre_ligne_table('a_ressource_tag_ressource', $a_ressource_tag_ressource)),
                '{contenu}'   => recuperer_gabarit('a_ressource_tag_ressource/bloc_apercu.html', $trans),
            ));

        }

    }
    else
    {

        include __DIR__ . '/_a_ressource_tag_ressource_list.php';

        $code_html.=recuperer_gabarit('main/section.html', array(
            '{fonction}'  => 'lister',
            '{nom_table}' => 'a_ressource_tag_ressource',
            '{titre}'     => htmlspecialchars(get_nom_colonne('libelle_liste_a_ressource_tag_ressource')),
            '{contenu}'   => recuperer_gabarit('a_ressource_tag_ressource/bloc_lister.html', $trans),
        ));

    }

    if ($mf_action=="ajouter_a_ressource_tag_ressource")
    {

        $form = new Formulaire('', $mess);
        if (!isset($est_charge['tag_ressource']))
        {
            $form->ajouter_select(lister_cles($lang_standard['Code_tag_ressource_']), "Code_tag_ressource", ( isset($_POST['Code_tag_ressource']) ? $_POST['Code_tag_ressource'] : 0 ), true);
        }
        if (!isset($est_charge['ressource']))
        {
            $form->ajouter_select(lister_cles($lang_standard['Code_ressource_']), "Code_ressource", ( isset($_POST['Code_ressource']) ? $_POST['Code_ressource'] : 0 ), true);
        }

        $code_html.=recuperer_gabarit('a_ressource_tag_ressource/form_add_a_ressource_tag_ressource.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_add_a_ressource_tag_ressource')), false, true);

    }
    elseif ($mf_action=="supprimer_a_ressource_tag_ressource")
    {

        $a_ressource_tag_ressource = $table_a_ressource_tag_ressource->mf_get($Code_tag_ressource, $Code_ressource, array( 'autocompletion' => true ));
        if ( isset($a_ressource_tag_ressource['Code_tag_ressource']) )
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_select(array(0, 1), 'Supprimer', FORM_SUPPR_DEFAUT, true);
            $form->activer_picto_suppression();

            $code_html.=recuperer_gabarit('a_ressource_tag_ressource/form_delete_a_ressource_tag_ressource.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_delete_a_ressource_tag_ressource')), false, true);

        }

    }
