<?php

    if ($mf_action=='apercu_joueur' || $mf_action<>'' && $Code_joueur!=0)
    {

        $joueur = $table_joueur->mf_get($Code_joueur, array( 'autocompletion' => true ));

        if (isset($joueur['Code_joueur']))
        {

            $fil_ariane->ajouter_titre(get_titre_ligne_table('joueur', $joueur), get_nom_page_courante().'?act=apercu_joueur&Code_joueur='.$Code_joueur);

            $menu_a_droite->raz_boutons();

            if ( ! MULTI_BLOCS ) { $code_html = ''; }

            include __DIR__ . '/_joueur_get.php';

            $code_html.= recuperer_gabarit('main/section.html', array(
                '{fonction}'  => 'apercu',
                '{nom_table}' => 'joueur',
                '{titre}'     => strip_tags(htmlspecialchars_decode(get_titre_ligne_table('joueur', $joueur)), ''),
                '{contenu}'   => recuperer_gabarit('joueur/bloc_apercu.html', $trans),
            ));

        }

    }
    else
    {

        include __DIR__ . '/_joueur_list.php';

        $code_html.=recuperer_gabarit('main/section.html', array(
            '{fonction}'  => 'lister',
            '{nom_table}' => 'joueur',
            '{titre}'     => htmlspecialchars(get_nom_colonne('libelle_liste_joueur')),
            '{contenu}'   => recuperer_gabarit('joueur/bloc_lister.html', $trans),
        ));

    }

    if ($mf_action=="ajouter_joueur")
    {

        $form = new Formulaire('', $mess);
        $form->ajouter_input("joueur_Email", ( isset($_POST['joueur_Email']) ? $_POST['joueur_Email'] : $mf_initialisation['joueur_Email'] ), true);
        $form->ajouter_input("joueur_Identifiant", ( isset($_POST['joueur_Identifiant']) ? $_POST['joueur_Identifiant'] : $mf_initialisation['joueur_Identifiant'] ), true);
        $form->ajouter_input("joueur_Password", ( isset($_POST['joueur_Password']) ? $_POST['joueur_Password'] : $mf_initialisation['joueur_Password'] ), true);
        $form->ajouter_input("joueur_Avatar_Fichier", ( isset($_POST['joueur_Avatar_Fichier']) ? $_POST['joueur_Avatar_Fichier'] : "" ), true, "file");
        $form->ajouter_input("joueur_Date_naissance", ( isset($_POST['joueur_Date_naissance']) ? $_POST['joueur_Date_naissance'] : $mf_initialisation['joueur_Date_naissance'] ), true);
        $form->ajouter_input("joueur_Date_inscription", ( isset($_POST['joueur_Date_inscription']) ? $_POST['joueur_Date_inscription'] : $mf_initialisation['joueur_Date_inscription'] ), true);
        $form->ajouter_select(lister_cles($lang_standard['joueur_Administrateur_']), "joueur_Administrateur", ( isset($_POST['joueur_Administrateur']) ? $_POST['joueur_Administrateur'] : $mf_initialisation['joueur_Administrateur'] ), true);

        $code_html.=recuperer_gabarit('joueur/form_add_joueur.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_add_joueur')), false, true);

    }
    elseif ($mf_action=="modifier_joueur")
    {

        $joueur = $table_joueur->mf_get($Code_joueur, array( 'autocompletion' => true ));
        if (isset($joueur['Code_joueur']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("joueur_Email", ( isset($_POST['joueur_Email']) ? $_POST['joueur_Email'] : $joueur['joueur_Email'] ), true);
            $form->ajouter_input("joueur_Identifiant", ( isset($_POST['joueur_Identifiant']) ? $_POST['joueur_Identifiant'] : $joueur['joueur_Identifiant'] ), true);
            // $form->ajouter_input("joueur_Password", "", true);
            $form->ajouter_input("joueur_Avatar_Fichier", ( isset($_POST['joueur_Avatar_Fichier']) ? $_POST['joueur_Avatar_Fichier'] : "" ), true, "file");
            $form->ajouter_input("joueur_Date_naissance", ( isset($_POST['joueur_Date_naissance']) ? $_POST['joueur_Date_naissance'] : $joueur['joueur_Date_naissance'] ), true);
            $form->ajouter_input("joueur_Date_inscription", ( isset($_POST['joueur_Date_inscription']) ? $_POST['joueur_Date_inscription'] : $joueur['joueur_Date_inscription'] ), true);
            $form->ajouter_select(lister_cles($lang_standard['joueur_Administrateur_']), "joueur_Administrateur", ( isset($_POST['joueur_Administrateur']) ? $_POST['joueur_Administrateur'] : $joueur['joueur_Administrateur'] ), true);

            $code_html.=recuperer_gabarit('joueur/form_edit_joueur.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_joueur')), false, true);

        }

    }
    elseif ($mf_action=='modifier_joueur_Email')
    {

        $joueur = $table_joueur->mf_get($Code_joueur, array( 'autocompletion' => true ));
        if (isset($joueur['Code_joueur']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("joueur_Email", ( isset($_POST['joueur_Email']) ? $_POST['joueur_Email'] : $joueur['joueur_Email'] ), true);

            $code_html.=recuperer_gabarit('joueur/form_edit_joueur_Email.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_joueur_Email')), false, true);

        }

    }
    elseif ($mf_action=='modifier_joueur_Identifiant')
    {

        $joueur = $table_joueur->mf_get($Code_joueur, array( 'autocompletion' => true ));
        if (isset($joueur['Code_joueur']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("joueur_Identifiant", ( isset($_POST['joueur_Identifiant']) ? $_POST['joueur_Identifiant'] : $joueur['joueur_Identifiant'] ), true);

            $code_html.=recuperer_gabarit('joueur/form_edit_joueur_Identifiant.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_joueur_Identifiant')), false, true);

        }

    }
    elseif ($mf_action=='modifier_joueur_Password')
    {

        $joueur = $table_joueur->mf_get($Code_joueur, array( 'autocompletion' => true ));
        if (isset($joueur['Code_joueur']))
        {

            $form = new Formulaire('', $mess);
            // $form->ajouter_input("joueur_Password", "", true);

            $code_html.=recuperer_gabarit('joueur/form_edit_joueur_Password.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_joueur_Password')), false, true);

        }

    }
    elseif ($mf_action=='modifier_joueur_Avatar_Fichier')
    {

        $joueur = $table_joueur->mf_get($Code_joueur, array( 'autocompletion' => true ));
        if (isset($joueur['Code_joueur']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("joueur_Avatar_Fichier", ( isset($_POST['joueur_Avatar_Fichier']) ? $_POST['joueur_Avatar_Fichier'] : "" ), true, "file");

            $code_html.=recuperer_gabarit('joueur/form_edit_joueur_Avatar_Fichier.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_joueur_Avatar_Fichier')), false, true);

        }

    }
    elseif ($mf_action=='modifier_joueur_Date_naissance')
    {

        $joueur = $table_joueur->mf_get($Code_joueur, array( 'autocompletion' => true ));
        if (isset($joueur['Code_joueur']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("joueur_Date_naissance", ( isset($_POST['joueur_Date_naissance']) ? $_POST['joueur_Date_naissance'] : $joueur['joueur_Date_naissance'] ), true);

            $code_html.=recuperer_gabarit('joueur/form_edit_joueur_Date_naissance.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_joueur_Date_naissance')), false, true);

        }

    }
    elseif ($mf_action=='modifier_joueur_Date_inscription')
    {

        $joueur = $table_joueur->mf_get($Code_joueur, array( 'autocompletion' => true ));
        if (isset($joueur['Code_joueur']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("joueur_Date_inscription", ( isset($_POST['joueur_Date_inscription']) ? $_POST['joueur_Date_inscription'] : $joueur['joueur_Date_inscription'] ), true);

            $code_html.=recuperer_gabarit('joueur/form_edit_joueur_Date_inscription.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_joueur_Date_inscription')), false, true);

        }

    }
    elseif ($mf_action=='modifier_joueur_Administrateur')
    {

        $joueur = $table_joueur->mf_get($Code_joueur, array( 'autocompletion' => true ));
        if (isset($joueur['Code_joueur']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_select(lister_cles($lang_standard['joueur_Administrateur_']), "joueur_Administrateur", ( isset($_POST['joueur_Administrateur']) ? $_POST['joueur_Administrateur'] : $joueur['joueur_Administrateur'] ), true);

            $code_html.=recuperer_gabarit('joueur/form_edit_joueur_Administrateur.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_joueur_Administrateur')), false, true);

        }

    }
    elseif ($mf_action=="modpwd")
    {

        $joueur = $table_joueur->mf_get($Code_joueur);
        if (isset($joueur['Code_joueur']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("joueur_Password_old", "", true, "password");
            $form->ajouter_input("joueur_Password_new", "", true, "password");
            $form->ajouter_input("joueur_Password_verif", "", true, "password");

            $code_html.=recuperer_gabarit('joueur/new_password_joueur.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('formulaire_modpwd_joueur')), false, true);

        }

    }
    elseif ($mf_action=="supprimer_joueur")
    {

        $joueur = $table_joueur->mf_get($Code_joueur, array( 'autocompletion' => true ));
        if ( isset($joueur['Code_joueur']) )
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_select(array(0, 1), 'Supprimer', FORM_SUPPR_DEFAUT, true);
            $form->activer_picto_suppression();

            $code_html.=recuperer_gabarit('joueur/form_delete_joueur.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_delete_joueur')), false, true);

        }

    }

