<?php

    if ($mf_action=='apercu_objet' || $mf_action<>'' && $Code_objet!=0)
    {

        $objet = $table_objet->mf_get($Code_objet, array( 'autocompletion' => true ));

        if (isset($objet['Code_objet']))
        {

            $fil_ariane->ajouter_titre(get_titre_ligne_table('objet', $objet), get_nom_page_courante().'?act=apercu_objet&Code_objet='.$Code_objet);

            $menu_a_droite->raz_boutons();

            if ( ! MULTI_BLOCS ) { $code_html = ''; }

            include __DIR__ . '/_objet_get.php';

            $code_html.= recuperer_gabarit('main/section.html', array(
                '{fonction}'  => 'apercu',
                '{nom_table}' => 'objet',
                '{titre}'     => strip_tags(htmlspecialchars_decode(get_titre_ligne_table('objet', $objet)), ''),
                '{contenu}'   => recuperer_gabarit('objet/bloc_apercu.html', $trans),
            ));

        }

    }
    else
    {

        include __DIR__ . '/_objet_list.php';

        $code_html.=recuperer_gabarit('main/section.html', array(
            '{fonction}'  => 'lister',
            '{nom_table}' => 'objet',
            '{titre}'     => htmlspecialchars(get_nom_colonne('libelle_liste_objet')),
            '{contenu}'   => recuperer_gabarit('objet/bloc_lister.html', $trans),
        ));

    }

    if ($mf_action=="ajouter_objet")
    {

        $form = new Formulaire('', $mess);
        $form->ajouter_input("objet_Libelle", ( isset($_POST['objet_Libelle']) ? $_POST['objet_Libelle'] : $mf_initialisation['objet_Libelle'] ), true);
        $form->ajouter_input("objet_Image_Fichier", ( isset($_POST['objet_Image_Fichier']) ? $_POST['objet_Image_Fichier'] : "" ), true, "file");
        if (!isset($est_charge['type']))
        {
            $form->ajouter_select(lister_cles($lang_standard['Code_type_']), "Code_type", ( isset($_POST['Code_type']) ? $_POST['Code_type'] : 0 ), true);
        }

        $code_html.=recuperer_gabarit('objet/form_add_objet.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_add_objet')), false, true);

    }
    elseif ($mf_action=="modifier_objet")
    {

        $objet = $table_objet->mf_get($Code_objet, array( 'autocompletion' => true ));
        if (isset($objet['Code_objet']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("objet_Libelle", ( isset($_POST['objet_Libelle']) ? $_POST['objet_Libelle'] : $objet['objet_Libelle'] ), true);
            $form->ajouter_input("objet_Image_Fichier", ( isset($_POST['objet_Image_Fichier']) ? $_POST['objet_Image_Fichier'] : "" ), true, "file");
            if (!isset($est_charge['type']))
            {
                $form->ajouter_select(lister_cles($lang_standard['Code_type_']), "Code_type", ( isset($_POST['Code_type']) ? $_POST['Code_type'] : $objet['Code_type'] ), true);
            }

            $code_html.=recuperer_gabarit('objet/form_edit_objet.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_objet')), false, true);

        }

    }
    elseif ($mf_action=='modifier_objet_Libelle')
    {

        $objet = $table_objet->mf_get($Code_objet, array( 'autocompletion' => true ));
        if (isset($objet['Code_objet']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("objet_Libelle", ( isset($_POST['objet_Libelle']) ? $_POST['objet_Libelle'] : $objet['objet_Libelle'] ), true);

            $code_html.=recuperer_gabarit('objet/form_edit_objet_Libelle.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_objet_Libelle')), false, true);

        }

    }
    elseif ($mf_action=='modifier_objet_Image_Fichier')
    {

        $objet = $table_objet->mf_get($Code_objet, array( 'autocompletion' => true ));
        if (isset($objet['Code_objet']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("objet_Image_Fichier", ( isset($_POST['objet_Image_Fichier']) ? $_POST['objet_Image_Fichier'] : "" ), true, "file");

            $code_html.=recuperer_gabarit('objet/form_edit_objet_Image_Fichier.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_objet_Image_Fichier')), false, true);

        }

    }
    elseif ($mf_action=='modifier_objet__Code_type')
    {

        $objet = $table_objet->mf_get($Code_objet, array( 'autocompletion' => true ));
        if (isset($objet['Code_objet']))
        {

            $form = new Formulaire('', $mess);
            if (!isset($est_charge['type']))
            {
                $form->ajouter_select(lister_cles($lang_standard['Code_type_']), "Code_type", ( isset($_POST['Code_type']) ? $_POST['Code_type'] : $objet['Code_type'] ), true);
            }

            $code_html.=recuperer_gabarit('objet/form_edit__Code_type.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_objet__Code_type')), false, true);

        }

    }
    elseif ($mf_action=="supprimer_objet")
    {

        $objet = $table_objet->mf_get($Code_objet, array( 'autocompletion' => true ));
        if ( isset($objet['Code_objet']) )
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_select(array(0, 1), 'Supprimer', FORM_SUPPR_DEFAUT, true);
            $form->activer_picto_suppression();

            $code_html.=recuperer_gabarit('objet/form_delete_objet.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_delete_objet')), false, true);

        }

    }

