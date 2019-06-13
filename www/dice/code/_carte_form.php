<?php

    if ($mf_action=='apercu_carte' || $mf_action<>'' && $Code_carte!=0)
    {

        $carte = $table_carte->mf_get($Code_carte, array( 'autocompletion' => true ));

        if (isset($carte['Code_carte']))
        {

            $fil_ariane->ajouter_titre(get_titre_ligne_table('carte', $carte), get_nom_page_courante().'?act=apercu_carte&Code_carte='.$Code_carte);

            $menu_a_droite->raz_boutons();

            if ( ! MULTI_BLOCS ) { $code_html = ''; }

            include __DIR__ . '/_carte_get.php';

            $code_html.= recuperer_gabarit('main/section.html', array(
                '{fonction}'  => 'apercu',
                '{nom_table}' => 'carte',
                '{titre}'     => strip_tags(htmlspecialchars_decode(get_titre_ligne_table('carte', $carte)), ''),
                '{contenu}'   => recuperer_gabarit('carte/bloc_apercu.html', $trans),
            ));

        }

    }
    else
    {

        include __DIR__ . '/_carte_list.php';

        $code_html.=recuperer_gabarit('main/section.html', array(
            '{fonction}'  => 'lister',
            '{nom_table}' => 'carte',
            '{titre}'     => htmlspecialchars(get_nom_colonne('libelle_liste_carte')),
            '{contenu}'   => recuperer_gabarit('carte/bloc_lister.html', $trans),
        ));

    }

    if ($mf_action=="ajouter_carte")
    {

        $form = new Formulaire('', $mess);
        $form->ajouter_input("carte_Nom", ( isset($_POST['carte_Nom']) ? $_POST['carte_Nom'] : $mf_initialisation['carte_Nom'] ), true);
        $form->ajouter_input("carte_Hauteur", ( isset($_POST['carte_Hauteur']) ? $_POST['carte_Hauteur'] : $mf_initialisation['carte_Hauteur'] ), true);
        $form->ajouter_input("carte_Largeur", ( isset($_POST['carte_Largeur']) ? $_POST['carte_Largeur'] : $mf_initialisation['carte_Largeur'] ), true);
        $form->ajouter_input("carte_Fichier", ( isset($_POST['carte_Fichier']) ? $_POST['carte_Fichier'] : "" ), true, "file");
        if (!isset($est_charge['groupe']))
        {
            $form->ajouter_select(lister_cles($lang_standard['Code_groupe_']), "Code_groupe", ( isset($_POST['Code_groupe']) ? $_POST['Code_groupe'] : 0 ), true);
        }

        $code_html.=recuperer_gabarit('carte/form_add_carte.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_add_carte')), false, true);

    }
    elseif ($mf_action=="modifier_carte")
    {

        $carte = $table_carte->mf_get($Code_carte, array( 'autocompletion' => true ));
        if (isset($carte['Code_carte']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("carte_Nom", ( isset($_POST['carte_Nom']) ? $_POST['carte_Nom'] : $carte['carte_Nom'] ), true);
            $form->ajouter_input("carte_Hauteur", ( isset($_POST['carte_Hauteur']) ? $_POST['carte_Hauteur'] : $carte['carte_Hauteur'] ), true);
            $form->ajouter_input("carte_Largeur", ( isset($_POST['carte_Largeur']) ? $_POST['carte_Largeur'] : $carte['carte_Largeur'] ), true);
            $form->ajouter_input("carte_Fichier", ( isset($_POST['carte_Fichier']) ? $_POST['carte_Fichier'] : "" ), true, "file");
            if (!isset($est_charge['groupe']))
            {
                $form->ajouter_select(lister_cles($lang_standard['Code_groupe_']), "Code_groupe", ( isset($_POST['Code_groupe']) ? $_POST['Code_groupe'] : $carte['Code_groupe'] ), true);
            }

            $code_html.=recuperer_gabarit('carte/form_edit_carte.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_carte')), false, true);

        }

    }
    elseif ($mf_action=='modifier_carte_Nom')
    {

        $carte = $table_carte->mf_get($Code_carte, array( 'autocompletion' => true ));
        if (isset($carte['Code_carte']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("carte_Nom", ( isset($_POST['carte_Nom']) ? $_POST['carte_Nom'] : $carte['carte_Nom'] ), true);

            $code_html.=recuperer_gabarit('carte/form_edit_carte_Nom.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_carte_Nom')), false, true);

        }

    }
    elseif ($mf_action=='modifier_carte_Hauteur')
    {

        $carte = $table_carte->mf_get($Code_carte, array( 'autocompletion' => true ));
        if (isset($carte['Code_carte']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("carte_Hauteur", ( isset($_POST['carte_Hauteur']) ? $_POST['carte_Hauteur'] : $carte['carte_Hauteur'] ), true);

            $code_html.=recuperer_gabarit('carte/form_edit_carte_Hauteur.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_carte_Hauteur')), false, true);

        }

    }
    elseif ($mf_action=='modifier_carte_Largeur')
    {

        $carte = $table_carte->mf_get($Code_carte, array( 'autocompletion' => true ));
        if (isset($carte['Code_carte']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("carte_Largeur", ( isset($_POST['carte_Largeur']) ? $_POST['carte_Largeur'] : $carte['carte_Largeur'] ), true);

            $code_html.=recuperer_gabarit('carte/form_edit_carte_Largeur.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_carte_Largeur')), false, true);

        }

    }
    elseif ($mf_action=='modifier_carte_Fichier')
    {

        $carte = $table_carte->mf_get($Code_carte, array( 'autocompletion' => true ));
        if (isset($carte['Code_carte']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("carte_Fichier", ( isset($_POST['carte_Fichier']) ? $_POST['carte_Fichier'] : "" ), true, "file");

            $code_html.=recuperer_gabarit('carte/form_edit_carte_Fichier.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_carte_Fichier')), false, true);

        }

    }
    elseif ($mf_action=='modifier_carte__Code_groupe')
    {

        $carte = $table_carte->mf_get($Code_carte, array( 'autocompletion' => true ));
        if (isset($carte['Code_carte']))
        {

            $form = new Formulaire('', $mess);
            if (!isset($est_charge['groupe']))
            {
                $form->ajouter_select(lister_cles($lang_standard['Code_groupe_']), "Code_groupe", ( isset($_POST['Code_groupe']) ? $_POST['Code_groupe'] : $carte['Code_groupe'] ), true);
            }

            $code_html.=recuperer_gabarit('carte/form_edit__Code_groupe.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_carte__Code_groupe')), false, true);

        }

    }
    elseif ($mf_action=="supprimer_carte")
    {

        $carte = $table_carte->mf_get($Code_carte, array( 'autocompletion' => true ));
        if ( isset($carte['Code_carte']) )
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_select(array(0, 1), 'Supprimer', FORM_SUPPR_DEFAUT, true);
            $form->activer_picto_suppression();

            $code_html.=recuperer_gabarit('carte/form_delete_carte.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_delete_carte')), false, true);

        }

    }

