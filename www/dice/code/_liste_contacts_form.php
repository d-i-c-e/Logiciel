<?php

    if ($mf_action=='apercu_liste_contacts' || $mf_action<>'' && $Code_liste_contacts!=0)
    {

        $liste_contacts = $table_liste_contacts->mf_get($Code_liste_contacts, array( 'autocompletion' => true ));

        if (isset($liste_contacts['Code_liste_contacts']))
        {

            $fil_ariane->ajouter_titre(get_titre_ligne_table('liste_contacts', $liste_contacts), get_nom_page_courante().'?act=apercu_liste_contacts&Code_liste_contacts='.$Code_liste_contacts);

            $menu_a_droite->raz_boutons();

            if ( ! MULTI_BLOCS ) { $code_html = ''; }

            include __DIR__ . '/_liste_contacts_get.php';

            $code_html.= recuperer_gabarit('main/section.html', array(
                '{fonction}'  => 'apercu',
                '{nom_table}' => 'liste_contacts',
                '{titre}'     => strip_tags(htmlspecialchars_decode(get_titre_ligne_table('liste_contacts', $liste_contacts)), ''),
                '{contenu}'   => recuperer_gabarit('liste_contacts/bloc_apercu.html', $trans),
            ));

        }

    }
    else
    {

        include __DIR__ . '/_liste_contacts_list.php';

        $code_html.=recuperer_gabarit('main/section.html', array(
            '{fonction}'  => 'lister',
            '{nom_table}' => 'liste_contacts',
            '{titre}'     => htmlspecialchars(get_nom_colonne('libelle_liste_liste_contacts')),
            '{contenu}'   => recuperer_gabarit('liste_contacts/bloc_lister.html', $trans),
        ));

    }

    if ($mf_action=="ajouter_liste_contacts")
    {

        $form = new Formulaire('', $mess);
        $form->ajouter_input("liste_contacts_Nom", ( isset($_POST['liste_contacts_Nom']) ? $_POST['liste_contacts_Nom'] : $mf_initialisation['liste_contacts_Nom'] ), true);
        if (!isset($est_charge['joueur']))
        {
            $form->ajouter_select(lister_cles($lang_standard['Code_joueur_']), "Code_joueur", ( isset($_POST['Code_joueur']) ? $_POST['Code_joueur'] : 0 ), true);
        }

        $code_html.=recuperer_gabarit('liste_contacts/form_add_liste_contacts.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_add_liste_contacts')), false, true);

    }
    elseif ($mf_action=="modifier_liste_contacts")
    {

        $liste_contacts = $table_liste_contacts->mf_get($Code_liste_contacts, array( 'autocompletion' => true ));
        if (isset($liste_contacts['Code_liste_contacts']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("liste_contacts_Nom", ( isset($_POST['liste_contacts_Nom']) ? $_POST['liste_contacts_Nom'] : $liste_contacts['liste_contacts_Nom'] ), true);
            if (!isset($est_charge['joueur']))
            {
                $form->ajouter_select(lister_cles($lang_standard['Code_joueur_']), "Code_joueur", ( isset($_POST['Code_joueur']) ? $_POST['Code_joueur'] : $liste_contacts['Code_joueur'] ), true);
            }

            $code_html.=recuperer_gabarit('liste_contacts/form_edit_liste_contacts.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_liste_contacts')), false, true);

        }

    }
    elseif ($mf_action=='modifier_liste_contacts_Nom')
    {

        $liste_contacts = $table_liste_contacts->mf_get($Code_liste_contacts, array( 'autocompletion' => true ));
        if (isset($liste_contacts['Code_liste_contacts']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("liste_contacts_Nom", ( isset($_POST['liste_contacts_Nom']) ? $_POST['liste_contacts_Nom'] : $liste_contacts['liste_contacts_Nom'] ), true);

            $code_html.=recuperer_gabarit('liste_contacts/form_edit_liste_contacts_Nom.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_liste_contacts_Nom')), false, true);

        }

    }
    elseif ($mf_action=='modifier_liste_contacts__Code_joueur')
    {

        $liste_contacts = $table_liste_contacts->mf_get($Code_liste_contacts, array( 'autocompletion' => true ));
        if (isset($liste_contacts['Code_liste_contacts']))
        {

            $form = new Formulaire('', $mess);
            if (!isset($est_charge['joueur']))
            {
                $form->ajouter_select(lister_cles($lang_standard['Code_joueur_']), "Code_joueur", ( isset($_POST['Code_joueur']) ? $_POST['Code_joueur'] : $liste_contacts['Code_joueur'] ), true);
            }

            $code_html.=recuperer_gabarit('liste_contacts/form_edit__Code_joueur.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_liste_contacts__Code_joueur')), false, true);

        }

    }
    elseif ($mf_action=="supprimer_liste_contacts")
    {

        $liste_contacts = $table_liste_contacts->mf_get($Code_liste_contacts, array( 'autocompletion' => true ));
        if ( isset($liste_contacts['Code_liste_contacts']) )
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_select(array(0, 1), 'Supprimer', FORM_SUPPR_DEFAUT, true);
            $form->activer_picto_suppression();

            $code_html.=recuperer_gabarit('liste_contacts/form_delete_liste_contacts.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_delete_liste_contacts')), false, true);

        }

    }

