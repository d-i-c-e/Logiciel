<?php

    if ($mf_action=='apercu_a_liste_contact_joueur' && $_GET['act']!='ajouter_a_liste_contact_joueur' && $_GET['act']!='supprimer_a_liste_contact_joueur')
    {

        if (isset($Code_liste_contacts) && $Code_liste_contacts!=0 && isset($Code_joueur) && $Code_joueur!=0)
        {
            $a_liste_contact_joueur = $table_a_liste_contact_joueur->mf_get($Code_liste_contacts, $Code_joueur, array( 'autocompletion' => true ));
        }

        if (isset($a_liste_contact_joueur['Code_liste_contacts']))
        {

            $fil_ariane->ajouter_titre(get_titre_ligne_table('a_liste_contact_joueur', $a_liste_contact_joueur), get_nom_page_courante().'?act=apercu_a_liste_contact_joueur&Code_liste_contacts='.$Code_liste_contacts.'&Code_joueur='.$Code_joueur.'');

            if ( ! MULTI_BLOCS ) { $code_html = ''; }

            include __DIR__ . '/_a_liste_contact_joueur_get.php';

            $code_html.=recuperer_gabarit('main/section.html', array(
                '{fonction}'  => 'apercu',
                '{nom_table}' => 'a_liste_contact_joueur',
                '{titre}'     => htmlspecialchars(get_titre_ligne_table('a_liste_contact_joueur', $a_liste_contact_joueur)),
                '{contenu}'   => recuperer_gabarit('a_liste_contact_joueur/bloc_apercu.html', $trans),
            ));

        }

    }
    else
    {

        include __DIR__ . '/_a_liste_contact_joueur_list.php';

        $code_html.=recuperer_gabarit('main/section.html', array(
            '{fonction}'  => 'lister',
            '{nom_table}' => 'a_liste_contact_joueur',
            '{titre}'     => htmlspecialchars(get_nom_colonne('libelle_liste_a_liste_contact_joueur')),
            '{contenu}'   => recuperer_gabarit('a_liste_contact_joueur/bloc_lister.html', $trans),
        ));

    }

    if ($mf_action=="ajouter_a_liste_contact_joueur")
    {

        $form = new Formulaire('', $mess);
        if (!isset($est_charge['liste_contacts']))
        {
            $form->ajouter_select(lister_cles($lang_standard['Code_liste_contacts_']), "Code_liste_contacts", ( isset($_POST['Code_liste_contacts']) ? $_POST['Code_liste_contacts'] : 0 ), true);
        }
        if (!isset($est_charge['joueur']))
        {
            $form->ajouter_select(lister_cles($lang_standard['Code_joueur_']), "Code_joueur", ( isset($_POST['Code_joueur']) ? $_POST['Code_joueur'] : 0 ), true);
        }
        $form->ajouter_input("a_liste_contact_joueur_Date_creation", ( isset($_POST['a_liste_contact_joueur_Date_creation']) ? $_POST['a_liste_contact_joueur_Date_creation'] : $mf_initialisation['a_liste_contact_joueur_Date_creation'] ), true);

        $code_html.=recuperer_gabarit('a_liste_contact_joueur/form_add_a_liste_contact_joueur.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_add_a_liste_contact_joueur')), false, true);

    }
    elseif ($mf_action=="modifier_a_liste_contact_joueur")
    {

        $a_liste_contact_joueur = $table_a_liste_contact_joueur->mf_get($Code_liste_contacts, $Code_joueur, array( 'autocompletion' => true ));
        if (isset($a_liste_contact_joueur['Code_liste_contacts']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("a_liste_contact_joueur_Date_creation", ( isset($_POST['a_liste_contact_joueur_Date_creation']) ? $_POST['a_liste_contact_joueur_Date_creation'] : $a_liste_contact_joueur['a_liste_contact_joueur_Date_creation'] ), true);

            $code_html.=recuperer_gabarit('a_liste_contact_joueur/form_edit_a_liste_contact_joueur.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_a_liste_contact_joueur')), false, true);

        }

    }
    elseif ($mf_action=='modifier_a_liste_contact_joueur_Date_creation')
    {

        $a_liste_contact_joueur = $table_a_liste_contact_joueur->mf_get($Code_liste_contacts, $Code_joueur, array( 'autocompletion' => true ));
        if (isset($a_liste_contact_joueur['Code_liste_contacts']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("a_liste_contact_joueur_Date_creation", ( isset($_POST['a_liste_contact_joueur_Date_creation']) ? $_POST['a_liste_contact_joueur_Date_creation'] : $a_liste_contact_joueur['a_liste_contact_joueur_Date_creation'] ), true);

            $code_html.=recuperer_gabarit('a_liste_contact_joueur/form_edit_a_liste_contact_joueur_Date_creation.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_a_liste_contact_joueur_Date_creation')), false, true);

        }

    }
    elseif ($mf_action=="supprimer_a_liste_contact_joueur")
    {

        $a_liste_contact_joueur = $table_a_liste_contact_joueur->mf_get($Code_liste_contacts, $Code_joueur, array( 'autocompletion' => true ));
        if ( isset($a_liste_contact_joueur['Code_liste_contacts']) )
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_select(array(0, 1), 'Supprimer', FORM_SUPPR_DEFAUT, true);
            $form->activer_picto_suppression();

            $code_html.=recuperer_gabarit('a_liste_contact_joueur/form_delete_a_liste_contact_joueur.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_delete_a_liste_contact_joueur')), false, true);

        }

    }
