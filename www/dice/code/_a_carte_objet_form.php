<?php

    if ($mf_action=='apercu_a_carte_objet' && $_GET['act']!='ajouter_a_carte_objet' && $_GET['act']!='supprimer_a_carte_objet')
    {

        if (isset($Code_carte) && $Code_carte!=0 && isset($Code_objet) && $Code_objet!=0)
        {
            $a_carte_objet = $table_a_carte_objet->mf_get($Code_carte, $Code_objet, array( 'autocompletion' => true ));
        }

        if (isset($a_carte_objet['Code_carte']))
        {

            $fil_ariane->ajouter_titre(get_titre_ligne_table('a_carte_objet', $a_carte_objet), get_nom_page_courante().'?act=apercu_a_carte_objet&Code_carte='.$Code_carte.'&Code_objet='.$Code_objet.'');

            if ( ! MULTI_BLOCS ) { $code_html = ''; }

            include __DIR__ . '/_a_carte_objet_get.php';

            $code_html.=recuperer_gabarit('main/section.html', array(
                '{fonction}'  => 'apercu',
                '{nom_table}' => 'a_carte_objet',
                '{titre}'     => htmlspecialchars(get_titre_ligne_table('a_carte_objet', $a_carte_objet)),
                '{contenu}'   => recuperer_gabarit('a_carte_objet/bloc_apercu.html', $trans),
            ));

        }

    }
    else
    {

        include __DIR__ . '/_a_carte_objet_list.php';

        $code_html.=recuperer_gabarit('main/section.html', array(
            '{fonction}'  => 'lister',
            '{nom_table}' => 'a_carte_objet',
            '{titre}'     => htmlspecialchars(get_nom_colonne('libelle_liste_a_carte_objet')),
            '{contenu}'   => recuperer_gabarit('a_carte_objet/bloc_lister.html', $trans),
        ));

    }

    if ($mf_action=="ajouter_a_carte_objet")
    {

        $form = new Formulaire('', $mess);
        if (!isset($est_charge['carte']))
        {
            $form->ajouter_select(lister_cles($lang_standard['Code_carte_']), "Code_carte", ( isset($_POST['Code_carte']) ? $_POST['Code_carte'] : 0 ), true);
        }
        if (!isset($est_charge['objet']))
        {
            $form->ajouter_select(lister_cles($lang_standard['Code_objet_']), "Code_objet", ( isset($_POST['Code_objet']) ? $_POST['Code_objet'] : 0 ), true);
        }

        $code_html.=recuperer_gabarit('a_carte_objet/form_add_a_carte_objet.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_add_a_carte_objet')), false, true);

    }
    elseif ($mf_action=="supprimer_a_carte_objet")
    {

        $a_carte_objet = $table_a_carte_objet->mf_get($Code_carte, $Code_objet, array( 'autocompletion' => true ));
        if ( isset($a_carte_objet['Code_carte']) )
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_select(array(0, 1), 'Supprimer', FORM_SUPPR_DEFAUT, true);
            $form->activer_picto_suppression();

            $code_html.=recuperer_gabarit('a_carte_objet/form_delete_a_carte_objet.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_delete_a_carte_objet')), false, true);

        }

    }
