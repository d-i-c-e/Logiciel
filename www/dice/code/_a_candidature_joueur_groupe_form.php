<?php

    if ($mf_action=='apercu_a_candidature_joueur_groupe' && $_GET['act']!='ajouter_a_candidature_joueur_groupe' && $_GET['act']!='supprimer_a_candidature_joueur_groupe')
    {

        if (isset($Code_joueur) && $Code_joueur!=0 && isset($Code_groupe) && $Code_groupe!=0)
        {
            $a_candidature_joueur_groupe = $table_a_candidature_joueur_groupe->mf_get($Code_joueur, $Code_groupe, array( 'autocompletion' => true ));
        }

        if (isset($a_candidature_joueur_groupe['Code_joueur']))
        {

            $fil_ariane->ajouter_titre(get_titre_ligne_table('a_candidature_joueur_groupe', $a_candidature_joueur_groupe), get_nom_page_courante().'?act=apercu_a_candidature_joueur_groupe&Code_joueur='.$Code_joueur.'&Code_groupe='.$Code_groupe.'');

            if ( ! MULTI_BLOCS ) { $code_html = ''; }

            include __DIR__ . '/_a_candidature_joueur_groupe_get.php';

            $code_html.=recuperer_gabarit('main/section.html', array(
                '{fonction}'  => 'apercu',
                '{nom_table}' => 'a_candidature_joueur_groupe',
                '{titre}'     => htmlspecialchars(get_titre_ligne_table('a_candidature_joueur_groupe', $a_candidature_joueur_groupe)),
                '{contenu}'   => recuperer_gabarit('a_candidature_joueur_groupe/bloc_apercu.html', $trans),
            ));

        }

    }
    else
    {

        include __DIR__ . '/_a_candidature_joueur_groupe_list.php';

        $code_html.=recuperer_gabarit('main/section.html', array(
            '{fonction}'  => 'lister',
            '{nom_table}' => 'a_candidature_joueur_groupe',
            '{titre}'     => htmlspecialchars(get_nom_colonne('libelle_liste_a_candidature_joueur_groupe')),
            '{contenu}'   => recuperer_gabarit('a_candidature_joueur_groupe/bloc_lister.html', $trans),
        ));

    }

    if ($mf_action=="ajouter_a_candidature_joueur_groupe")
    {

        $form = new Formulaire('', $mess);
        if (!isset($est_charge['joueur']))
        {
            $form->ajouter_select(lister_cles($lang_standard['Code_joueur_']), "Code_joueur", ( isset($_POST['Code_joueur']) ? $_POST['Code_joueur'] : 0 ), true);
        }
        if (!isset($est_charge['groupe']))
        {
            $form->ajouter_select(lister_cles($lang_standard['Code_groupe_']), "Code_groupe", ( isset($_POST['Code_groupe']) ? $_POST['Code_groupe'] : 0 ), true);
        }
        $form->ajouter_textarea("a_candidature_joueur_groupe_Message", ( isset($_POST['a_candidature_joueur_groupe_Message']) ? $_POST['a_candidature_joueur_groupe_Message'] : $mf_initialisation['a_candidature_joueur_groupe_Message'] ), true);
        $form->ajouter_input("a_candidature_joueur_groupe_Date_envoi", ( isset($_POST['a_candidature_joueur_groupe_Date_envoi']) ? $_POST['a_candidature_joueur_groupe_Date_envoi'] : $mf_initialisation['a_candidature_joueur_groupe_Date_envoi'] ), true);

        $code_html.=recuperer_gabarit('a_candidature_joueur_groupe/form_add_a_candidature_joueur_groupe.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_add_a_candidature_joueur_groupe')), false, true);

    }
    elseif ($mf_action=="modifier_a_candidature_joueur_groupe")
    {

        $a_candidature_joueur_groupe = $table_a_candidature_joueur_groupe->mf_get($Code_joueur, $Code_groupe, array( 'autocompletion' => true ));
        if (isset($a_candidature_joueur_groupe['Code_joueur']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_textarea("a_candidature_joueur_groupe_Message", ( isset($_POST['a_candidature_joueur_groupe_Message']) ? $_POST['a_candidature_joueur_groupe_Message'] : $a_candidature_joueur_groupe['a_candidature_joueur_groupe_Message'] ), true);
            $form->ajouter_input("a_candidature_joueur_groupe_Date_envoi", ( isset($_POST['a_candidature_joueur_groupe_Date_envoi']) ? $_POST['a_candidature_joueur_groupe_Date_envoi'] : $a_candidature_joueur_groupe['a_candidature_joueur_groupe_Date_envoi'] ), true);

            $code_html.=recuperer_gabarit('a_candidature_joueur_groupe/form_edit_a_candidature_joueur_groupe.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_a_candidature_joueur_groupe')), false, true);

        }

    }
    elseif ($mf_action=='modifier_a_candidature_joueur_groupe_Message')
    {

        $a_candidature_joueur_groupe = $table_a_candidature_joueur_groupe->mf_get($Code_joueur, $Code_groupe, array( 'autocompletion' => true ));
        if (isset($a_candidature_joueur_groupe['Code_joueur']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_textarea("a_candidature_joueur_groupe_Message", ( isset($_POST['a_candidature_joueur_groupe_Message']) ? $_POST['a_candidature_joueur_groupe_Message'] : $a_candidature_joueur_groupe['a_candidature_joueur_groupe_Message'] ), true);

            $code_html.=recuperer_gabarit('a_candidature_joueur_groupe/form_edit_a_candidature_joueur_groupe_Message.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_a_candidature_joueur_groupe_Message')), false, true);

        }

    }
    elseif ($mf_action=='modifier_a_candidature_joueur_groupe_Date_envoi')
    {

        $a_candidature_joueur_groupe = $table_a_candidature_joueur_groupe->mf_get($Code_joueur, $Code_groupe, array( 'autocompletion' => true ));
        if (isset($a_candidature_joueur_groupe['Code_joueur']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("a_candidature_joueur_groupe_Date_envoi", ( isset($_POST['a_candidature_joueur_groupe_Date_envoi']) ? $_POST['a_candidature_joueur_groupe_Date_envoi'] : $a_candidature_joueur_groupe['a_candidature_joueur_groupe_Date_envoi'] ), true);

            $code_html.=recuperer_gabarit('a_candidature_joueur_groupe/form_edit_a_candidature_joueur_groupe_Date_envoi.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_a_candidature_joueur_groupe_Date_envoi')), false, true);

        }

    }
    elseif ($mf_action=="supprimer_a_candidature_joueur_groupe")
    {

        $a_candidature_joueur_groupe = $table_a_candidature_joueur_groupe->mf_get($Code_joueur, $Code_groupe, array( 'autocompletion' => true ));
        if ( isset($a_candidature_joueur_groupe['Code_joueur']) )
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_select(array(0, 1), 'Supprimer', FORM_SUPPR_DEFAUT, true);
            $form->activer_picto_suppression();

            $code_html.=recuperer_gabarit('a_candidature_joueur_groupe/form_delete_a_candidature_joueur_groupe.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_delete_a_candidature_joueur_groupe')), false, true);

        }

    }
