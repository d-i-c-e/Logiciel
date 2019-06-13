<?php

    if ($mf_action=='apercu_messagerie' || $mf_action<>'' && $Code_messagerie!=0)
    {

        $messagerie = $table_messagerie->mf_get($Code_messagerie, array( 'autocompletion' => true ));

        if (isset($messagerie['Code_messagerie']))
        {

            $fil_ariane->ajouter_titre(get_titre_ligne_table('messagerie', $messagerie), get_nom_page_courante().'?act=apercu_messagerie&Code_messagerie='.$Code_messagerie);

            $menu_a_droite->raz_boutons();

            if ( ! MULTI_BLOCS ) { $code_html = ''; }

            include __DIR__ . '/_messagerie_get.php';

            $code_html.= recuperer_gabarit('main/section.html', array(
                '{fonction}'  => 'apercu',
                '{nom_table}' => 'messagerie',
                '{titre}'     => strip_tags(htmlspecialchars_decode(get_titre_ligne_table('messagerie', $messagerie)), ''),
                '{contenu}'   => recuperer_gabarit('messagerie/bloc_apercu.html', $trans),
            ));

        }

    }
    else
    {

        include __DIR__ . '/_messagerie_list.php';

        $code_html.=recuperer_gabarit('main/section.html', array(
            '{fonction}'  => 'lister',
            '{nom_table}' => 'messagerie',
            '{titre}'     => htmlspecialchars(get_nom_colonne('libelle_liste_messagerie')),
            '{contenu}'   => recuperer_gabarit('messagerie/bloc_lister.html', $trans),
        ));

    }

    if ($mf_action=="ajouter_messagerie")
    {

        $form = new Formulaire('', $mess);
        if (!isset($est_charge['joueur']))
        {
            $form->ajouter_select(lister_cles($lang_standard['Code_joueur_']), "Code_joueur", ( isset($_POST['Code_joueur']) ? $_POST['Code_joueur'] : 0 ), true);
        }

        $code_html.=recuperer_gabarit('messagerie/form_add_messagerie.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_add_messagerie')), false, true);

    }
    elseif ($mf_action=="modifier_messagerie")
    {

        $messagerie = $table_messagerie->mf_get($Code_messagerie, array( 'autocompletion' => true ));
        if (isset($messagerie['Code_messagerie']))
        {

            $form = new Formulaire('', $mess);
            if (!isset($est_charge['joueur']))
            {
                $form->ajouter_select(lister_cles($lang_standard['Code_joueur_']), "Code_joueur", ( isset($_POST['Code_joueur']) ? $_POST['Code_joueur'] : $messagerie['Code_joueur'] ), true);
            }

            $code_html.=recuperer_gabarit('messagerie/form_edit_messagerie.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_messagerie')), false, true);

        }

    }
    elseif ($mf_action=='modifier_messagerie__Code_joueur')
    {

        $messagerie = $table_messagerie->mf_get($Code_messagerie, array( 'autocompletion' => true ));
        if (isset($messagerie['Code_messagerie']))
        {

            $form = new Formulaire('', $mess);
            if (!isset($est_charge['joueur']))
            {
                $form->ajouter_select(lister_cles($lang_standard['Code_joueur_']), "Code_joueur", ( isset($_POST['Code_joueur']) ? $_POST['Code_joueur'] : $messagerie['Code_joueur'] ), true);
            }

            $code_html.=recuperer_gabarit('messagerie/form_edit__Code_joueur.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_messagerie__Code_joueur')), false, true);

        }

    }
    elseif ($mf_action=="supprimer_messagerie")
    {

        $messagerie = $table_messagerie->mf_get($Code_messagerie, array( 'autocompletion' => true ));
        if ( isset($messagerie['Code_messagerie']) )
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_select(array(0, 1), 'Supprimer', FORM_SUPPR_DEFAUT, true);
            $form->activer_picto_suppression();

            $code_html.=recuperer_gabarit('messagerie/form_delete_messagerie.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_delete_messagerie')), false, true);

        }

    }

