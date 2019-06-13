<?php

    if ($mf_action=='apercu_campagne' || $mf_action<>'' && $Code_campagne!=0)
    {

        $campagne = $table_campagne->mf_get($Code_campagne, array( 'autocompletion' => true ));

        if (isset($campagne['Code_campagne']))
        {

            $fil_ariane->ajouter_titre(get_titre_ligne_table('campagne', $campagne), get_nom_page_courante().'?act=apercu_campagne&Code_campagne='.$Code_campagne);

            $menu_a_droite->raz_boutons();

            if ( ! MULTI_BLOCS ) { $code_html = ''; }

            include __DIR__ . '/_campagne_get.php';

            $code_html.= recuperer_gabarit('main/section.html', array(
                '{fonction}'  => 'apercu',
                '{nom_table}' => 'campagne',
                '{titre}'     => strip_tags(htmlspecialchars_decode(get_titre_ligne_table('campagne', $campagne)), ''),
                '{contenu}'   => recuperer_gabarit('campagne/bloc_apercu.html', $trans),
            ));

        }

    }
    else
    {

        include __DIR__ . '/_campagne_list.php';

        $code_html.=recuperer_gabarit('main/section.html', array(
            '{fonction}'  => 'lister',
            '{nom_table}' => 'campagne',
            '{titre}'     => htmlspecialchars(get_nom_colonne('libelle_liste_campagne')),
            '{contenu}'   => recuperer_gabarit('campagne/bloc_lister.html', $trans),
        ));

    }

    if ($mf_action=="ajouter_campagne")
    {

        $form = new Formulaire('', $mess);
        $form->ajouter_input("campagne_Nom", ( isset($_POST['campagne_Nom']) ? $_POST['campagne_Nom'] : $mf_initialisation['campagne_Nom'] ), true);
        $form->ajouter_textarea("campagne_Description", ( isset($_POST['campagne_Description']) ? $_POST['campagne_Description'] : $mf_initialisation['campagne_Description'] ), true);
        $form->ajouter_input("campagne_Image_Fichier", ( isset($_POST['campagne_Image_Fichier']) ? $_POST['campagne_Image_Fichier'] : "" ), true, "file");
        $form->ajouter_input("campagne_Nombre_joueur", ( isset($_POST['campagne_Nombre_joueur']) ? $_POST['campagne_Nombre_joueur'] : $mf_initialisation['campagne_Nombre_joueur'] ), true);
        $form->ajouter_input("campagne_Nombre_mj", ( isset($_POST['campagne_Nombre_mj']) ? $_POST['campagne_Nombre_mj'] : $mf_initialisation['campagne_Nombre_mj'] ), true);

        $code_html.=recuperer_gabarit('campagne/form_add_campagne.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_add_campagne')), false, true);

    }
    elseif ($mf_action=="modifier_campagne")
    {

        $campagne = $table_campagne->mf_get($Code_campagne, array( 'autocompletion' => true ));
        if (isset($campagne['Code_campagne']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("campagne_Nom", ( isset($_POST['campagne_Nom']) ? $_POST['campagne_Nom'] : $campagne['campagne_Nom'] ), true);
            $form->ajouter_textarea("campagne_Description", ( isset($_POST['campagne_Description']) ? $_POST['campagne_Description'] : $campagne['campagne_Description'] ), true);
            $form->ajouter_input("campagne_Image_Fichier", ( isset($_POST['campagne_Image_Fichier']) ? $_POST['campagne_Image_Fichier'] : "" ), true, "file");
            $form->ajouter_input("campagne_Nombre_joueur", ( isset($_POST['campagne_Nombre_joueur']) ? $_POST['campagne_Nombre_joueur'] : $campagne['campagne_Nombre_joueur'] ), true);
            $form->ajouter_input("campagne_Nombre_mj", ( isset($_POST['campagne_Nombre_mj']) ? $_POST['campagne_Nombre_mj'] : $campagne['campagne_Nombre_mj'] ), true);

            $code_html.=recuperer_gabarit('campagne/form_edit_campagne.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_campagne')), false, true);

        }

    }
    elseif ($mf_action=='modifier_campagne_Nom')
    {

        $campagne = $table_campagne->mf_get($Code_campagne, array( 'autocompletion' => true ));
        if (isset($campagne['Code_campagne']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("campagne_Nom", ( isset($_POST['campagne_Nom']) ? $_POST['campagne_Nom'] : $campagne['campagne_Nom'] ), true);

            $code_html.=recuperer_gabarit('campagne/form_edit_campagne_Nom.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_campagne_Nom')), false, true);

        }

    }
    elseif ($mf_action=='modifier_campagne_Description')
    {

        $campagne = $table_campagne->mf_get($Code_campagne, array( 'autocompletion' => true ));
        if (isset($campagne['Code_campagne']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_textarea("campagne_Description", ( isset($_POST['campagne_Description']) ? $_POST['campagne_Description'] : $campagne['campagne_Description'] ), true);

            $code_html.=recuperer_gabarit('campagne/form_edit_campagne_Description.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_campagne_Description')), false, true);

        }

    }
    elseif ($mf_action=='modifier_campagne_Image_Fichier')
    {

        $campagne = $table_campagne->mf_get($Code_campagne, array( 'autocompletion' => true ));
        if (isset($campagne['Code_campagne']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("campagne_Image_Fichier", ( isset($_POST['campagne_Image_Fichier']) ? $_POST['campagne_Image_Fichier'] : "" ), true, "file");

            $code_html.=recuperer_gabarit('campagne/form_edit_campagne_Image_Fichier.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_campagne_Image_Fichier')), false, true);

        }

    }
    elseif ($mf_action=='modifier_campagne_Nombre_joueur')
    {

        $campagne = $table_campagne->mf_get($Code_campagne, array( 'autocompletion' => true ));
        if (isset($campagne['Code_campagne']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("campagne_Nombre_joueur", ( isset($_POST['campagne_Nombre_joueur']) ? $_POST['campagne_Nombre_joueur'] : $campagne['campagne_Nombre_joueur'] ), true);

            $code_html.=recuperer_gabarit('campagne/form_edit_campagne_Nombre_joueur.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_campagne_Nombre_joueur')), false, true);

        }

    }
    elseif ($mf_action=='modifier_campagne_Nombre_mj')
    {

        $campagne = $table_campagne->mf_get($Code_campagne, array( 'autocompletion' => true ));
        if (isset($campagne['Code_campagne']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("campagne_Nombre_mj", ( isset($_POST['campagne_Nombre_mj']) ? $_POST['campagne_Nombre_mj'] : $campagne['campagne_Nombre_mj'] ), true);

            $code_html.=recuperer_gabarit('campagne/form_edit_campagne_Nombre_mj.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_campagne_Nombre_mj')), false, true);

        }

    }
    elseif ($mf_action=="supprimer_campagne")
    {

        $campagne = $table_campagne->mf_get($Code_campagne, array( 'autocompletion' => true ));
        if ( isset($campagne['Code_campagne']) )
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_select(array(0, 1), 'Supprimer', FORM_SUPPR_DEFAUT, true);
            $form->activer_picto_suppression();

            $code_html.=recuperer_gabarit('campagne/form_delete_campagne.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_delete_campagne')), false, true);

        }

    }

