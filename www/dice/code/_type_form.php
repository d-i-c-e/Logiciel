<?php

    if ($mf_action=='apercu_type' || $mf_action<>'' && $Code_type!=0)
    {

        $type = $table_type->mf_get($Code_type, array( 'autocompletion' => true ));

        if (isset($type['Code_type']))
        {

            $fil_ariane->ajouter_titre(get_titre_ligne_table('type', $type), get_nom_page_courante().'?act=apercu_type&Code_type='.$Code_type);

            $menu_a_droite->raz_boutons();

            if ( ! MULTI_BLOCS ) { $code_html = ''; }

            include __DIR__ . '/_type_get.php';

            $code_html.= recuperer_gabarit('main/section.html', array(
                '{fonction}'  => 'apercu',
                '{nom_table}' => 'type',
                '{titre}'     => strip_tags(htmlspecialchars_decode(get_titre_ligne_table('type', $type)), ''),
                '{contenu}'   => recuperer_gabarit('type/bloc_apercu.html', $trans),
            ));

        }

    }
    else
    {

        include __DIR__ . '/_type_list.php';

        $code_html.=recuperer_gabarit('main/section.html', array(
            '{fonction}'  => 'lister',
            '{nom_table}' => 'type',
            '{titre}'     => htmlspecialchars(get_nom_colonne('libelle_liste_type')),
            '{contenu}'   => recuperer_gabarit('type/bloc_lister.html', $trans),
        ));

    }

    if ($mf_action=="ajouter_type")
    {

        $form = new Formulaire('', $mess);
        $form->ajouter_input("type_Libelle", ( isset($_POST['type_Libelle']) ? $_POST['type_Libelle'] : $mf_initialisation['type_Libelle'] ), true);
        if (!isset($est_charge['ressource']))
        {
            $form->ajouter_select(lister_cles($lang_standard['Code_ressource_']), "Code_ressource", ( isset($_POST['Code_ressource']) ? $_POST['Code_ressource'] : 0 ), true);
        }

        $code_html.=recuperer_gabarit('type/form_add_type.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_add_type')), false, true);

    }
    elseif ($mf_action=="modifier_type")
    {

        $type = $table_type->mf_get($Code_type, array( 'autocompletion' => true ));
        if (isset($type['Code_type']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("type_Libelle", ( isset($_POST['type_Libelle']) ? $_POST['type_Libelle'] : $type['type_Libelle'] ), true);
            if (!isset($est_charge['ressource']))
            {
                $form->ajouter_select(lister_cles($lang_standard['Code_ressource_']), "Code_ressource", ( isset($_POST['Code_ressource']) ? $_POST['Code_ressource'] : $type['Code_ressource'] ), true);
            }

            $code_html.=recuperer_gabarit('type/form_edit_type.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_type')), false, true);

        }

    }
    elseif ($mf_action=='modifier_type_Libelle')
    {

        $type = $table_type->mf_get($Code_type, array( 'autocompletion' => true ));
        if (isset($type['Code_type']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("type_Libelle", ( isset($_POST['type_Libelle']) ? $_POST['type_Libelle'] : $type['type_Libelle'] ), true);

            $code_html.=recuperer_gabarit('type/form_edit_type_Libelle.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_type_Libelle')), false, true);

        }

    }
    elseif ($mf_action=='modifier_type__Code_ressource')
    {

        $type = $table_type->mf_get($Code_type, array( 'autocompletion' => true ));
        if (isset($type['Code_type']))
        {

            $form = new Formulaire('', $mess);
            if (!isset($est_charge['ressource']))
            {
                $form->ajouter_select(lister_cles($lang_standard['Code_ressource_']), "Code_ressource", ( isset($_POST['Code_ressource']) ? $_POST['Code_ressource'] : $type['Code_ressource'] ), true);
            }

            $code_html.=recuperer_gabarit('type/form_edit__Code_ressource.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_type__Code_ressource')), false, true);

        }

    }
    elseif ($mf_action=="supprimer_type")
    {

        $type = $table_type->mf_get($Code_type, array( 'autocompletion' => true ));
        if ( isset($type['Code_type']) )
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_select(array(0, 1), 'Supprimer', FORM_SUPPR_DEFAUT, true);
            $form->activer_picto_suppression();

            $code_html.=recuperer_gabarit('type/form_delete_type.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_delete_type')), false, true);

        }

    }

