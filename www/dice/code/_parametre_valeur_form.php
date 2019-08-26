<?php

    if ($mf_action=='apercu_parametre_valeur' || $mf_action<>'' && $Code_parametre_valeur!=0)
    {

        $parametre_valeur = $table_parametre_valeur->mf_get($Code_parametre_valeur, array( 'autocompletion' => true ));

        if (isset($parametre_valeur['Code_parametre_valeur']))
        {

            $fil_ariane->ajouter_titre(get_titre_ligne_table('parametre_valeur', $parametre_valeur), get_nom_page_courante().'?act=apercu_parametre_valeur&Code_parametre_valeur='.$Code_parametre_valeur);

            $menu_a_droite->raz_boutons();

            if ( ! MULTI_BLOCS ) { $code_html = ''; }

            include __DIR__ . '/_parametre_valeur_get.php';

            $code_html.= recuperer_gabarit('main/section.html', array(
                '{fonction}'  => 'apercu',
                '{nom_table}' => 'parametre_valeur',
                '{titre}'     => strip_tags(htmlspecialchars_decode(get_titre_ligne_table('parametre_valeur', $parametre_valeur)), ''),
                '{contenu}'   => recuperer_gabarit('parametre_valeur/bloc_apercu.html', $trans),
            ));

        }

    }
    else
    {

        /* debut developpement */
//         include __DIR__ . '/_parametre_valeur_list.php';

//         $code_html.=recuperer_gabarit('main/section.html', array(
//             '{fonction}'  => 'lister',
//             '{nom_table}' => 'parametre_valeur',
//             '{titre}'     => htmlspecialchars(get_nom_colonne('libelle_liste_parametre_valeur')),
//             '{contenu}'   => recuperer_gabarit('parametre_valeur/bloc_lister.html', $trans),
//         ));
        /* fin developpement */

    }

    if ($mf_action=="ajouter_parametre_valeur")
    {

        $form = new Formulaire('', $mess);
        $form->ajouter_input("parametre_valeur_Libelle", ( isset($_POST['parametre_valeur_Libelle']) ? $_POST['parametre_valeur_Libelle'] : $mf_initialisation['parametre_valeur_Libelle'] ), true);
        if (!isset($est_charge['parametre']))
        {
            $form->ajouter_select(lister_cles($lang_standard['Code_parametre_']), "Code_parametre", ( isset($_POST['Code_parametre']) ? $_POST['Code_parametre'] : 0 ), true);
        }

        $code_html.=recuperer_gabarit('parametre_valeur/form_add_parametre_valeur.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_add_parametre_valeur')), false, true);

    }
    elseif ($mf_action=="modifier_parametre_valeur")
    {

        $parametre_valeur = $table_parametre_valeur->mf_get($Code_parametre_valeur, array( 'autocompletion' => true ));
        if (isset($parametre_valeur['Code_parametre_valeur']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("parametre_valeur_Libelle", ( isset($_POST['parametre_valeur_Libelle']) ? $_POST['parametre_valeur_Libelle'] : $parametre_valeur['parametre_valeur_Libelle'] ), true);
            if (!isset($est_charge['parametre']))
            {
                $form->ajouter_select(lister_cles($lang_standard['Code_parametre_']), "Code_parametre", ( isset($_POST['Code_parametre']) ? $_POST['Code_parametre'] : $parametre_valeur['Code_parametre'] ), true);
            }

            $code_html.=recuperer_gabarit('parametre_valeur/form_edit_parametre_valeur.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_parametre_valeur')), false, true);

        }

    }
    elseif ($mf_action=='modifier_parametre_valeur_Libelle')
    {

        $parametre_valeur = $table_parametre_valeur->mf_get($Code_parametre_valeur, array( 'autocompletion' => true ));
        if (isset($parametre_valeur['Code_parametre_valeur']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("parametre_valeur_Libelle", ( isset($_POST['parametre_valeur_Libelle']) ? $_POST['parametre_valeur_Libelle'] : $parametre_valeur['parametre_valeur_Libelle'] ), true);

            $code_html.=recuperer_gabarit('parametre_valeur/form_edit_parametre_valeur_Libelle.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_parametre_valeur_Libelle')), false, true);

        }

    }
    elseif ($mf_action=='modifier_parametre_valeur__Code_parametre')
    {

        $parametre_valeur = $table_parametre_valeur->mf_get($Code_parametre_valeur, array( 'autocompletion' => true ));
        if (isset($parametre_valeur['Code_parametre_valeur']))
        {

            $form = new Formulaire('', $mess);
            if (!isset($est_charge['parametre']))
            {
                $form->ajouter_select(lister_cles($lang_standard['Code_parametre_']), "Code_parametre", ( isset($_POST['Code_parametre']) ? $_POST['Code_parametre'] : $parametre_valeur['Code_parametre'] ), true);
            }

            $code_html.=recuperer_gabarit('parametre_valeur/form_edit__Code_parametre.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_parametre_valeur__Code_parametre')), false, true);

        }

    }
    elseif ($mf_action=="supprimer_parametre_valeur")
    {

        $parametre_valeur = $table_parametre_valeur->mf_get($Code_parametre_valeur, array( 'autocompletion' => true ));
        if ( isset($parametre_valeur['Code_parametre_valeur']) )
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_select(array(0, 1), 'Supprimer', FORM_SUPPR_DEFAUT, true);
            $form->activer_picto_suppression();

            $code_html.=recuperer_gabarit('parametre_valeur/form_delete_parametre_valeur.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_delete_parametre_valeur')), false, true);

        }

    }

