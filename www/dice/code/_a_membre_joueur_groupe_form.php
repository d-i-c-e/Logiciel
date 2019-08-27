<?php

    if ($mf_action=='apercu_a_membre_joueur_groupe' && $_GET['act']!='ajouter_a_membre_joueur_groupe' && $_GET['act']!='supprimer_a_membre_joueur_groupe')
    {

        if (isset($Code_groupe) && $Code_groupe!=0 && isset($Code_joueur) && $Code_joueur!=0)
        {
            $a_membre_joueur_groupe = $table_a_membre_joueur_groupe->mf_get($Code_groupe, $Code_joueur, array( 'autocompletion' => true ));
        }

        if (isset($a_membre_joueur_groupe['Code_groupe']))
        {

            $fil_ariane->ajouter_titre(get_titre_ligne_table('a_membre_joueur_groupe', $a_membre_joueur_groupe), get_nom_page_courante().'?act=apercu_a_membre_joueur_groupe&Code_groupe='.$Code_groupe.'&Code_joueur='.$Code_joueur.'');

            if ( ! MULTI_BLOCS ) { $code_html = ''; }

            include __DIR__ . '/_a_membre_joueur_groupe_get.php';

            $code_html.=recuperer_gabarit('main/section.html', array(
                '{fonction}'  => 'apercu',
                '{nom_table}' => 'a_membre_joueur_groupe',
                '{titre}'     => htmlspecialchars(get_titre_ligne_table('a_membre_joueur_groupe', $a_membre_joueur_groupe)),
                '{contenu}'   => recuperer_gabarit('a_membre_joueur_groupe/bloc_apercu.html', $trans),
            ));

        }

    }
    else
    {

        /* debut developpement */
//         include __DIR__ . '/_a_membre_joueur_groupe_list.php';

//         $code_html.=recuperer_gabarit('main/section.html', array(
//             '{fonction}'  => 'lister',
//             '{nom_table}' => 'a_membre_joueur_groupe',
//             '{titre}'     => htmlspecialchars(get_nom_colonne('libelle_liste_a_membre_joueur_groupe')),
//             '{contenu}'   => recuperer_gabarit('a_membre_joueur_groupe/bloc_lister.html', $trans),
//         ));
        /* fin developpement */

    }

    if ($mf_action=="ajouter_a_membre_joueur_groupe")
    {

        $form = new Formulaire('', $mess);
        if (!isset($est_charge['groupe']))
        {
            $form->ajouter_select(lister_cles($lang_standard['Code_groupe_']), "Code_groupe", ( isset($_POST['Code_groupe']) ? $_POST['Code_groupe'] : 0 ), true);
        }
        if (!isset($est_charge['joueur']))
        {
            $form->ajouter_select(lister_cles($lang_standard['Code_joueur_']), "Code_joueur", ( isset($_POST['Code_joueur']) ? $_POST['Code_joueur'] : 0 ), true);
        }
        $form->ajouter_input("a_membre_joueur_groupe_Surnom", ( isset($_POST['a_membre_joueur_groupe_Surnom']) ? $_POST['a_membre_joueur_groupe_Surnom'] : $mf_initialisation['a_membre_joueur_groupe_Surnom'] ), true);
        $form->ajouter_input("a_membre_joueur_groupe_Grade", ( isset($_POST['a_membre_joueur_groupe_Grade']) ? $_POST['a_membre_joueur_groupe_Grade'] : $mf_initialisation['a_membre_joueur_groupe_Grade'] ), true);
        $form->ajouter_input("a_membre_joueur_groupe_Date_adhesion", ( isset($_POST['a_membre_joueur_groupe_Date_adhesion']) ? $_POST['a_membre_joueur_groupe_Date_adhesion'] : $mf_initialisation['a_membre_joueur_groupe_Date_adhesion'] ), true);

        $code_html.=recuperer_gabarit('a_membre_joueur_groupe/form_add_a_membre_joueur_groupe.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_add_a_membre_joueur_groupe')), false, true);

    }
    elseif ($mf_action=="modifier_a_membre_joueur_groupe")
    {

        $a_membre_joueur_groupe = $table_a_membre_joueur_groupe->mf_get($Code_groupe, $Code_joueur, array( 'autocompletion' => true ));
        if (isset($a_membre_joueur_groupe['Code_groupe']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("a_membre_joueur_groupe_Surnom", ( isset($_POST['a_membre_joueur_groupe_Surnom']) ? $_POST['a_membre_joueur_groupe_Surnom'] : $a_membre_joueur_groupe['a_membre_joueur_groupe_Surnom'] ), true);
            $form->ajouter_input("a_membre_joueur_groupe_Grade", ( isset($_POST['a_membre_joueur_groupe_Grade']) ? $_POST['a_membre_joueur_groupe_Grade'] : $a_membre_joueur_groupe['a_membre_joueur_groupe_Grade'] ), true);
            $form->ajouter_input("a_membre_joueur_groupe_Date_adhesion", ( isset($_POST['a_membre_joueur_groupe_Date_adhesion']) ? $_POST['a_membre_joueur_groupe_Date_adhesion'] : $a_membre_joueur_groupe['a_membre_joueur_groupe_Date_adhesion'] ), true);

            $code_html.=recuperer_gabarit('a_membre_joueur_groupe/form_edit_a_membre_joueur_groupe.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_a_membre_joueur_groupe')), false, true);

        }

    }
    elseif ($mf_action=='modifier_a_membre_joueur_groupe_Surnom')
    {

        $a_membre_joueur_groupe = $table_a_membre_joueur_groupe->mf_get($Code_groupe, $Code_joueur, array( 'autocompletion' => true ));
        if (isset($a_membre_joueur_groupe['Code_groupe']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("a_membre_joueur_groupe_Surnom", ( isset($_POST['a_membre_joueur_groupe_Surnom']) ? $_POST['a_membre_joueur_groupe_Surnom'] : $a_membre_joueur_groupe['a_membre_joueur_groupe_Surnom'] ), true);

            $code_html.=recuperer_gabarit('a_membre_joueur_groupe/form_edit_a_membre_joueur_groupe_Surnom.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_a_membre_joueur_groupe_Surnom')), false, true);

        }

    }
    elseif ($mf_action=='modifier_a_membre_joueur_groupe_Grade')
    {

        $a_membre_joueur_groupe = $table_a_membre_joueur_groupe->mf_get($Code_groupe, $Code_joueur, array( 'autocompletion' => true ));
        if (isset($a_membre_joueur_groupe['Code_groupe']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("a_membre_joueur_groupe_Grade", ( isset($_POST['a_membre_joueur_groupe_Grade']) ? $_POST['a_membre_joueur_groupe_Grade'] : $a_membre_joueur_groupe['a_membre_joueur_groupe_Grade'] ), true);

            $code_html.=recuperer_gabarit('a_membre_joueur_groupe/form_edit_a_membre_joueur_groupe_Grade.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_a_membre_joueur_groupe_Grade')), false, true);

        }

    }
    elseif ($mf_action=='modifier_a_membre_joueur_groupe_Date_adhesion')
    {

        $a_membre_joueur_groupe = $table_a_membre_joueur_groupe->mf_get($Code_groupe, $Code_joueur, array( 'autocompletion' => true ));
        if (isset($a_membre_joueur_groupe['Code_groupe']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("a_membre_joueur_groupe_Date_adhesion", ( isset($_POST['a_membre_joueur_groupe_Date_adhesion']) ? $_POST['a_membre_joueur_groupe_Date_adhesion'] : $a_membre_joueur_groupe['a_membre_joueur_groupe_Date_adhesion'] ), true);

            $code_html.=recuperer_gabarit('a_membre_joueur_groupe/form_edit_a_membre_joueur_groupe_Date_adhesion.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_a_membre_joueur_groupe_Date_adhesion')), false, true);

        }

    }
    elseif ($mf_action=="supprimer_a_membre_joueur_groupe")
    {

        $a_membre_joueur_groupe = $table_a_membre_joueur_groupe->mf_get($Code_groupe, $Code_joueur, array( 'autocompletion' => true ));
        if ( isset($a_membre_joueur_groupe['Code_groupe']) )
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_select(array(0, 1), 'Supprimer', FORM_SUPPR_DEFAUT, true);
            $form->activer_picto_suppression();

            $code_html.=recuperer_gabarit('a_membre_joueur_groupe/form_delete_a_membre_joueur_groupe.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_delete_a_membre_joueur_groupe')), false, true);

        }

    }
