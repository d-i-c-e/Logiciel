<?php

    if ($mf_action=='apercu_personnage' || $mf_action<>'' && $Code_personnage!=0)
    {

        $personnage = $table_personnage->mf_get($Code_personnage, array( 'autocompletion' => true ));

        if (isset($personnage['Code_personnage']))
        {

            $fil_ariane->ajouter_titre(get_titre_ligne_table('personnage', $personnage), get_nom_page_courante().'?act=apercu_personnage&Code_personnage='.$Code_personnage);

            $menu_a_droite->raz_boutons();

            if ( ! MULTI_BLOCS ) { $code_html = ''; }

            include __DIR__ . '/_personnage_get.php';

            $code_html.= recuperer_gabarit('main/section.html', array(
                '{fonction}'  => 'apercu',
                '{nom_table}' => 'personnage',
                '{titre}'     => strip_tags(htmlspecialchars_decode(get_titre_ligne_table('personnage', $personnage)), ''),
                '{contenu}'   => recuperer_gabarit('personnage/bloc_apercu.html', $trans),
            ));

        }

    }
    else
    {

        include __DIR__ . '/_personnage_list.php';

        $code_html.=recuperer_gabarit('main/section.html', array(
            '{fonction}'  => 'lister',
            '{nom_table}' => 'personnage',
            '{titre}'     => htmlspecialchars(get_nom_colonne('libelle_liste_personnage')),
            '{contenu}'   => recuperer_gabarit('personnage/bloc_lister.html', $trans),
        ));

    }

    if ($mf_action=="ajouter_personnage")
    {

        $form = new Formulaire('', $mess);
        $form->ajouter_input("personnage_Fichier_Fichier", ( isset($_POST['personnage_Fichier_Fichier']) ? $_POST['personnage_Fichier_Fichier'] : "" ), true, "file");
        $form->ajouter_select(lister_cles($lang_standard['personnage_Conservation_']), "personnage_Conservation", ( isset($_POST['personnage_Conservation']) ? $_POST['personnage_Conservation'] : $mf_initialisation['personnage_Conservation'] ), true);
        if (!isset($est_charge['joueur']))
        {
            $form->ajouter_select(lister_cles($lang_standard['Code_joueur_']), "Code_joueur", ( isset($_POST['Code_joueur']) ? $_POST['Code_joueur'] : 0 ), true);
        }
        if (!isset($est_charge['groupe']))
        {
            $form->ajouter_select(lister_cles($lang_standard['Code_groupe_']), "Code_groupe", ( isset($_POST['Code_groupe']) ? $_POST['Code_groupe'] : 0 ), true);
        }

        $code_html.=recuperer_gabarit('personnage/form_add_personnage.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_add_personnage')), false, true);

    }
    elseif ($mf_action=="modifier_personnage")
    {

        $personnage = $table_personnage->mf_get($Code_personnage, array( 'autocompletion' => true ));
        if (isset($personnage['Code_personnage']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("personnage_Fichier_Fichier", ( isset($_POST['personnage_Fichier_Fichier']) ? $_POST['personnage_Fichier_Fichier'] : "" ), true, "file");
            $form->ajouter_select(lister_cles($lang_standard['personnage_Conservation_']), "personnage_Conservation", ( isset($_POST['personnage_Conservation']) ? $_POST['personnage_Conservation'] : $personnage['personnage_Conservation'] ), true);
            if (!isset($est_charge['joueur']))
            {
                $form->ajouter_select(lister_cles($lang_standard['Code_joueur_']), "Code_joueur", ( isset($_POST['Code_joueur']) ? $_POST['Code_joueur'] : $personnage['Code_joueur'] ), true);
            }
            if (!isset($est_charge['groupe']))
            {
                $form->ajouter_select(lister_cles($lang_standard['Code_groupe_']), "Code_groupe", ( isset($_POST['Code_groupe']) ? $_POST['Code_groupe'] : $personnage['Code_groupe'] ), true);
            }

            $code_html.=recuperer_gabarit('personnage/form_edit_personnage.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_personnage')), false, true);

        }

    }
    elseif ($mf_action=='modifier_personnage_Fichier_Fichier')
    {

        $personnage = $table_personnage->mf_get($Code_personnage, array( 'autocompletion' => true ));
        if (isset($personnage['Code_personnage']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("personnage_Fichier_Fichier", ( isset($_POST['personnage_Fichier_Fichier']) ? $_POST['personnage_Fichier_Fichier'] : "" ), true, "file");

            $code_html.=recuperer_gabarit('personnage/form_edit_personnage_Fichier_Fichier.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_personnage_Fichier_Fichier')), false, true);

        }

    }
    elseif ($mf_action=='modifier_personnage_Conservation')
    {

        $personnage = $table_personnage->mf_get($Code_personnage, array( 'autocompletion' => true ));
        if (isset($personnage['Code_personnage']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_select(lister_cles($lang_standard['personnage_Conservation_']), "personnage_Conservation", ( isset($_POST['personnage_Conservation']) ? $_POST['personnage_Conservation'] : $personnage['personnage_Conservation'] ), true);

            $code_html.=recuperer_gabarit('personnage/form_edit_personnage_Conservation.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_personnage_Conservation')), false, true);

        }

    }
    elseif ($mf_action=='modifier_personnage__Code_joueur')
    {

        $personnage = $table_personnage->mf_get($Code_personnage, array( 'autocompletion' => true ));
        if (isset($personnage['Code_personnage']))
        {

            $form = new Formulaire('', $mess);
            if (!isset($est_charge['joueur']))
            {
                $form->ajouter_select(lister_cles($lang_standard['Code_joueur_']), "Code_joueur", ( isset($_POST['Code_joueur']) ? $_POST['Code_joueur'] : $personnage['Code_joueur'] ), true);
            }

            $code_html.=recuperer_gabarit('personnage/form_edit__Code_joueur.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_personnage__Code_joueur')), false, true);

        }

    }
    elseif ($mf_action=='modifier_personnage__Code_groupe')
    {

        $personnage = $table_personnage->mf_get($Code_personnage, array( 'autocompletion' => true ));
        if (isset($personnage['Code_personnage']))
        {

            $form = new Formulaire('', $mess);
            if (!isset($est_charge['groupe']))
            {
                $form->ajouter_select(lister_cles($lang_standard['Code_groupe_']), "Code_groupe", ( isset($_POST['Code_groupe']) ? $_POST['Code_groupe'] : $personnage['Code_groupe'] ), true);
            }

            $code_html.=recuperer_gabarit('personnage/form_edit__Code_groupe.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_personnage__Code_groupe')), false, true);

        }

    }
    elseif ($mf_action=="supprimer_personnage")
    {

        $personnage = $table_personnage->mf_get($Code_personnage, array( 'autocompletion' => true ));
        if ( isset($personnage['Code_personnage']) )
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_select(array(0, 1), 'Supprimer', FORM_SUPPR_DEFAUT, true);
            $form->activer_picto_suppression();

            $code_html.=recuperer_gabarit('personnage/form_delete_personnage.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_delete_personnage')), false, true);

        }

    }

