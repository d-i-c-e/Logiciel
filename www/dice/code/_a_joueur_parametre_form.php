<?php

    if ($mf_action=='apercu_a_joueur_parametre' && $_GET['act']!='ajouter_a_joueur_parametre' && $_GET['act']!='supprimer_a_joueur_parametre')
    {

        if (isset($Code_joueur) && $Code_joueur!=0 && isset($Code_parametre) && $Code_parametre!=0)
        {
            $a_joueur_parametre = $table_a_joueur_parametre->mf_get($Code_joueur, $Code_parametre, array( 'autocompletion' => true ));
        }

        if (isset($a_joueur_parametre['Code_joueur']))
        {

            $fil_ariane->ajouter_titre(get_titre_ligne_table('a_joueur_parametre', $a_joueur_parametre), get_nom_page_courante().'?act=apercu_a_joueur_parametre&Code_joueur='.$Code_joueur.'&Code_parametre='.$Code_parametre.'');

            if ( ! MULTI_BLOCS ) { $code_html = ''; }

            include __DIR__ . '/_a_joueur_parametre_get.php';

            $code_html.=recuperer_gabarit('main/section.html', array(
                '{fonction}'  => 'apercu',
                '{nom_table}' => 'a_joueur_parametre',
                '{titre}'     => htmlspecialchars(get_titre_ligne_table('a_joueur_parametre', $a_joueur_parametre)),
                '{contenu}'   => recuperer_gabarit('a_joueur_parametre/bloc_apercu.html', $trans),
            ));

        }

    }
    else
    {

        include __DIR__ . '/_a_joueur_parametre_list.php';

        $code_html.=recuperer_gabarit('main/section.html', array(
            '{fonction}'  => 'lister',
            '{nom_table}' => 'a_joueur_parametre',
            '{titre}'     => htmlspecialchars(get_nom_colonne('libelle_liste_a_joueur_parametre')),
            '{contenu}'   => recuperer_gabarit('a_joueur_parametre/bloc_lister.html', $trans),
        ));

    }

    if ($mf_action=="ajouter_a_joueur_parametre")
    {

        $form = new Formulaire('', $mess);
        if (!isset($est_charge['joueur']))
        {
            $form->ajouter_select(lister_cles($lang_standard['Code_joueur_']), "Code_joueur", ( isset($_POST['Code_joueur']) ? $_POST['Code_joueur'] : 0 ), true);
        }
        if (!isset($est_charge['parametre']))
        {
            $form->ajouter_select(lister_cles($lang_standard['Code_parametre_']), "Code_parametre", ( isset($_POST['Code_parametre']) ? $_POST['Code_parametre'] : 0 ), true);
        }
        $form->ajouter_input("a_joueur_parametre_Valeur_choisie", ( isset($_POST['a_joueur_parametre_Valeur_choisie']) ? $_POST['a_joueur_parametre_Valeur_choisie'] : $mf_initialisation['a_joueur_parametre_Valeur_choisie'] ), true);
        $form->ajouter_select(lister_cles($lang_standard['a_joueur_parametre_Actif_']), "a_joueur_parametre_Actif", ( isset($_POST['a_joueur_parametre_Actif']) ? $_POST['a_joueur_parametre_Actif'] : $mf_initialisation['a_joueur_parametre_Actif'] ), true);

        $code_html.=recuperer_gabarit('a_joueur_parametre/form_add_a_joueur_parametre.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_add_a_joueur_parametre')), false, true);

    }
    elseif ($mf_action=="modifier_a_joueur_parametre")
    {

        $a_joueur_parametre = $table_a_joueur_parametre->mf_get($Code_joueur, $Code_parametre, array( 'autocompletion' => true ));
        if (isset($a_joueur_parametre['Code_joueur']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("a_joueur_parametre_Valeur_choisie", ( isset($_POST['a_joueur_parametre_Valeur_choisie']) ? $_POST['a_joueur_parametre_Valeur_choisie'] : $a_joueur_parametre['a_joueur_parametre_Valeur_choisie'] ), true);
            $form->ajouter_select(lister_cles($lang_standard['a_joueur_parametre_Actif_']), "a_joueur_parametre_Actif", ( isset($_POST['a_joueur_parametre_Actif']) ? $_POST['a_joueur_parametre_Actif'] : $a_joueur_parametre['a_joueur_parametre_Actif'] ), true);

            $code_html.=recuperer_gabarit('a_joueur_parametre/form_edit_a_joueur_parametre.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_a_joueur_parametre')), false, true);

        }

    }
    elseif ($mf_action=='modifier_a_joueur_parametre_Valeur_choisie')
    {

        $a_joueur_parametre = $table_a_joueur_parametre->mf_get($Code_joueur, $Code_parametre, array( 'autocompletion' => true ));
        if (isset($a_joueur_parametre['Code_joueur']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("a_joueur_parametre_Valeur_choisie", ( isset($_POST['a_joueur_parametre_Valeur_choisie']) ? $_POST['a_joueur_parametre_Valeur_choisie'] : $a_joueur_parametre['a_joueur_parametre_Valeur_choisie'] ), true);

            $code_html.=recuperer_gabarit('a_joueur_parametre/form_edit_a_joueur_parametre_Valeur_choisie.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_a_joueur_parametre_Valeur_choisie')), false, true);

        }

    }
    elseif ($mf_action=='modifier_a_joueur_parametre_Actif')
    {

        $a_joueur_parametre = $table_a_joueur_parametre->mf_get($Code_joueur, $Code_parametre, array( 'autocompletion' => true ));
        if (isset($a_joueur_parametre['Code_joueur']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_select(lister_cles($lang_standard['a_joueur_parametre_Actif_']), "a_joueur_parametre_Actif", ( isset($_POST['a_joueur_parametre_Actif']) ? $_POST['a_joueur_parametre_Actif'] : $a_joueur_parametre['a_joueur_parametre_Actif'] ), true);

            $code_html.=recuperer_gabarit('a_joueur_parametre/form_edit_a_joueur_parametre_Actif.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_a_joueur_parametre_Actif')), false, true);

        }

    }
    elseif ($mf_action=="supprimer_a_joueur_parametre")
    {

        $a_joueur_parametre = $table_a_joueur_parametre->mf_get($Code_joueur, $Code_parametre, array( 'autocompletion' => true ));
        if ( isset($a_joueur_parametre['Code_joueur']) )
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_select(array(0, 1), 'Supprimer', FORM_SUPPR_DEFAUT, true);
            $form->activer_picto_suppression();

            $code_html.=recuperer_gabarit('a_joueur_parametre/form_delete_a_joueur_parametre.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_delete_a_joueur_parametre')), false, true);

        }

    }
