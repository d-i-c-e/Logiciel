<?php

    if ($mf_action=='apercu_groupe' || $mf_action<>'' && $Code_groupe!=0)
    {

        $groupe = $table_groupe->mf_get($Code_groupe, array( 'autocompletion' => true ));

        if (isset($groupe['Code_groupe']))
        {

            $fil_ariane->ajouter_titre(get_titre_ligne_table('groupe', $groupe), get_nom_page_courante().'?act=apercu_groupe&Code_groupe='.$Code_groupe);

            $menu_a_droite->raz_boutons();

            if ( ! MULTI_BLOCS ) { $code_html = ''; }

            include __DIR__ . '/_groupe_get.php';

            $code_html.= recuperer_gabarit('main/section.html', array(
                '{fonction}'  => 'apercu',
                '{nom_table}' => 'groupe',
                '{titre}'     => strip_tags(htmlspecialchars_decode(get_titre_ligne_table('groupe', $groupe)), ''),
                '{contenu}'   => recuperer_gabarit('groupe/bloc_apercu.html', $trans),
            ));

        }

    }
    else
    {

        include __DIR__ . '/_groupe_list.php';

        $code_html.=recuperer_gabarit('main/section.html', array(
            '{fonction}'  => 'lister',
            '{nom_table}' => 'groupe',
            '{titre}'     => htmlspecialchars(get_nom_colonne('libelle_liste_groupe')),
            '{contenu}'   => recuperer_gabarit('groupe/bloc_lister.html', $trans),
        ));

    }

    if ($mf_action=="ajouter_groupe")
    {

        $form = new Formulaire('', $mess);
        $form->ajouter_input("groupe_Nom", ( isset($_POST['groupe_Nom']) ? $_POST['groupe_Nom'] : $mf_initialisation['groupe_Nom'] ), true);
        $form->ajouter_textarea("groupe_Description", ( isset($_POST['groupe_Description']) ? $_POST['groupe_Description'] : $mf_initialisation['groupe_Description'] ), true);
        $form->ajouter_input("groupe_Logo_Fichier", ( isset($_POST['groupe_Logo_Fichier']) ? $_POST['groupe_Logo_Fichier'] : "" ), true, "file");
        /* debut developpement */
//         $form->ajouter_input("groupe_Effectif", ( isset($_POST['groupe_Effectif']) ? $_POST['groupe_Effectif'] : $mf_initialisation['groupe_Effectif'] ), true);
//         $form->ajouter_select(lister_cles($lang_standard['groupe_Actif_']), "groupe_Actif", ( isset($_POST['groupe_Actif']) ? $_POST['groupe_Actif'] : $mf_initialisation['groupe_Actif'] ), true);
//         $form->ajouter_input("groupe_Date_creation", ( isset($_POST['groupe_Date_creation']) ? $_POST['groupe_Date_creation'] : $mf_initialisation['groupe_Date_creation'] ), true);
//         $form->ajouter_input("groupe_Delai_suppression_jour", ( isset($_POST['groupe_Delai_suppression_jour']) ? $_POST['groupe_Delai_suppression_jour'] : $mf_initialisation['groupe_Delai_suppression_jour'] ), true);
//         $form->ajouter_select(lister_cles($lang_standard['groupe_Suppression_active_']), "groupe_Suppression_active", ( isset($_POST['groupe_Suppression_active']) ? $_POST['groupe_Suppression_active'] : $mf_initialisation['groupe_Suppression_active'] ), true);
        /* fin developpement */
        if (!isset($est_charge['campagne']))
        {
            $form->ajouter_select(lister_cles($lang_standard['Code_campagne_']), "Code_campagne", ( isset($_POST['Code_campagne']) ? $_POST['Code_campagne'] : 0 ), true);
        }

        $code_html.=recuperer_gabarit('groupe/form_add_groupe.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_add_groupe')), false, true);

    }
    elseif ($mf_action=="modifier_groupe")
    {

        $groupe = $table_groupe->mf_get($Code_groupe, array( 'autocompletion' => true ));
        if (isset($groupe['Code_groupe']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("groupe_Nom", ( isset($_POST['groupe_Nom']) ? $_POST['groupe_Nom'] : $groupe['groupe_Nom'] ), true);
            $form->ajouter_textarea("groupe_Description", ( isset($_POST['groupe_Description']) ? $_POST['groupe_Description'] : $groupe['groupe_Description'] ), true);
            $form->ajouter_input("groupe_Logo_Fichier", ( isset($_POST['groupe_Logo_Fichier']) ? $_POST['groupe_Logo_Fichier'] : "" ), true, "file");
            $form->ajouter_input("groupe_Effectif", ( isset($_POST['groupe_Effectif']) ? $_POST['groupe_Effectif'] : $groupe['groupe_Effectif'] ), true);
            $form->ajouter_select(lister_cles($lang_standard['groupe_Actif_']), "groupe_Actif", ( isset($_POST['groupe_Actif']) ? $_POST['groupe_Actif'] : $groupe['groupe_Actif'] ), true);
            $form->ajouter_input("groupe_Date_creation", ( isset($_POST['groupe_Date_creation']) ? $_POST['groupe_Date_creation'] : $groupe['groupe_Date_creation'] ), true);
            $form->ajouter_input("groupe_Delai_suppression_jour", ( isset($_POST['groupe_Delai_suppression_jour']) ? $_POST['groupe_Delai_suppression_jour'] : $groupe['groupe_Delai_suppression_jour'] ), true);
            $form->ajouter_select(lister_cles($lang_standard['groupe_Suppression_active_']), "groupe_Suppression_active", ( isset($_POST['groupe_Suppression_active']) ? $_POST['groupe_Suppression_active'] : $groupe['groupe_Suppression_active'] ), true);
            if (!isset($est_charge['campagne']))
            {
                $form->ajouter_select(lister_cles($lang_standard['Code_campagne_']), "Code_campagne", ( isset($_POST['Code_campagne']) ? $_POST['Code_campagne'] : $groupe['Code_campagne'] ), true);
            }

            $code_html.=recuperer_gabarit('groupe/form_edit_groupe.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_groupe')), false, true);

        }

    }
    elseif ($mf_action=='modifier_groupe_Nom')
    {

        $groupe = $table_groupe->mf_get($Code_groupe, array( 'autocompletion' => true ));
        if (isset($groupe['Code_groupe']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("groupe_Nom", ( isset($_POST['groupe_Nom']) ? $_POST['groupe_Nom'] : $groupe['groupe_Nom'] ), true);

            $code_html.=recuperer_gabarit('groupe/form_edit_groupe_Nom.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_groupe_Nom')), false, true);

        }

    }
    elseif ($mf_action=='modifier_groupe_Description')
    {

        $groupe = $table_groupe->mf_get($Code_groupe, array( 'autocompletion' => true ));
        if (isset($groupe['Code_groupe']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_textarea("groupe_Description", ( isset($_POST['groupe_Description']) ? $_POST['groupe_Description'] : $groupe['groupe_Description'] ), true);

            $code_html.=recuperer_gabarit('groupe/form_edit_groupe_Description.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_groupe_Description')), false, true);

        }

    }
    elseif ($mf_action=='modifier_groupe_Logo_Fichier')
    {

        $groupe = $table_groupe->mf_get($Code_groupe, array( 'autocompletion' => true ));
        if (isset($groupe['Code_groupe']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("groupe_Logo_Fichier", ( isset($_POST['groupe_Logo_Fichier']) ? $_POST['groupe_Logo_Fichier'] : "" ), true, "file");

            $code_html.=recuperer_gabarit('groupe/form_edit_groupe_Logo_Fichier.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_groupe_Logo_Fichier')), false, true);

        }

    }
    elseif ($mf_action=='modifier_groupe_Effectif')
    {

        $groupe = $table_groupe->mf_get($Code_groupe, array( 'autocompletion' => true ));
        if (isset($groupe['Code_groupe']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("groupe_Effectif", ( isset($_POST['groupe_Effectif']) ? $_POST['groupe_Effectif'] : $groupe['groupe_Effectif'] ), true);

            $code_html.=recuperer_gabarit('groupe/form_edit_groupe_Effectif.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_groupe_Effectif')), false, true);

        }

    }
    elseif ($mf_action=='modifier_groupe_Actif')
    {

        $groupe = $table_groupe->mf_get($Code_groupe, array( 'autocompletion' => true ));
        if (isset($groupe['Code_groupe']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_select(lister_cles($lang_standard['groupe_Actif_']), "groupe_Actif", ( isset($_POST['groupe_Actif']) ? $_POST['groupe_Actif'] : $groupe['groupe_Actif'] ), true);

            $code_html.=recuperer_gabarit('groupe/form_edit_groupe_Actif.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_groupe_Actif')), false, true);

        }

    }
    elseif ($mf_action=='modifier_groupe_Date_creation')
    {

        $groupe = $table_groupe->mf_get($Code_groupe, array( 'autocompletion' => true ));
        if (isset($groupe['Code_groupe']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("groupe_Date_creation", ( isset($_POST['groupe_Date_creation']) ? $_POST['groupe_Date_creation'] : $groupe['groupe_Date_creation'] ), true);

            $code_html.=recuperer_gabarit('groupe/form_edit_groupe_Date_creation.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_groupe_Date_creation')), false, true);

        }

    }
    elseif ($mf_action=='modifier_groupe_Delai_suppression_jour')
    {

        $groupe = $table_groupe->mf_get($Code_groupe, array( 'autocompletion' => true ));
        if (isset($groupe['Code_groupe']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("groupe_Delai_suppression_jour", ( isset($_POST['groupe_Delai_suppression_jour']) ? $_POST['groupe_Delai_suppression_jour'] : $groupe['groupe_Delai_suppression_jour'] ), true);

            $code_html.=recuperer_gabarit('groupe/form_edit_groupe_Delai_suppression_jour.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_groupe_Delai_suppression_jour')), false, true);

        }

    }
    elseif ($mf_action=='modifier_groupe_Suppression_active')
    {

        $groupe = $table_groupe->mf_get($Code_groupe, array( 'autocompletion' => true ));
        if (isset($groupe['Code_groupe']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_select(lister_cles($lang_standard['groupe_Suppression_active_']), "groupe_Suppression_active", ( isset($_POST['groupe_Suppression_active']) ? $_POST['groupe_Suppression_active'] : $groupe['groupe_Suppression_active'] ), true);

            $code_html.=recuperer_gabarit('groupe/form_edit_groupe_Suppression_active.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_groupe_Suppression_active')), false, true);

        }

    }
    elseif ($mf_action=='modifier_groupe__Code_campagne')
    {

        $groupe = $table_groupe->mf_get($Code_groupe, array( 'autocompletion' => true ));
        if (isset($groupe['Code_groupe']))
        {

            $form = new Formulaire('', $mess);
            if (!isset($est_charge['campagne']))
            {
                $form->ajouter_select(lister_cles($lang_standard['Code_campagne_']), "Code_campagne", ( isset($_POST['Code_campagne']) ? $_POST['Code_campagne'] : $groupe['Code_campagne'] ), true);
            }

            $code_html.=recuperer_gabarit('groupe/form_edit__Code_campagne.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_groupe__Code_campagne')), false, true);

        }

    }
    elseif ($mf_action=="supprimer_groupe")
    {

        $groupe = $table_groupe->mf_get($Code_groupe, array( 'autocompletion' => true ));
        if ( isset($groupe['Code_groupe']) )
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_select(array(0, 1), 'Supprimer', FORM_SUPPR_DEFAUT, true);
            $form->activer_picto_suppression();

            $code_html.=recuperer_gabarit('groupe/form_delete_groupe.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_delete_groupe')), false, true);

        }

    }

