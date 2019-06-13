<?php

    $est_charge['a_liste_contact_joueur'] = 1;

    if (!isset($lang_standard['Code_liste_contacts_']))
    {
        $lang_standard['Code_liste_contacts_'] = array();
        $table_liste_contacts = new liste_contacts();
        $liste = $table_liste_contacts->mf_lister_contexte();
        foreach ($liste as $code => $value)
        {
            $lang_standard['Code_liste_contacts_'][$code] = get_titre_ligne_table('liste_contacts', $value);
        }
    }
    if (!isset($lang_standard['Code_joueur_']))
    {
        $lang_standard['Code_joueur_'] = array();
        $table_joueur = new joueur();
        $liste = $table_joueur->mf_lister_contexte();
        foreach ($liste as $code => $value)
        {
            $lang_standard['Code_joueur_'][$code] = get_titre_ligne_table('joueur', $value);
        }
    }

/*
    +-----------+
    |  Ajouter  |
    +-----------+
*/
    if ( $mf_action=='ajouter_a_liste_contact_joueur' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $mf_add = [];
        $mf_add['Code_liste_contacts'] = ( isset( $_POST['Code_liste_contacts'] ) ? $_POST['Code_liste_contacts'] : $Code_liste_contacts );
        $mf_add['Code_joueur'] = ( isset( $_POST['Code_joueur'] ) ? $_POST['Code_joueur'] : $Code_joueur );
        if ( isset( $_POST['a_liste_contact_joueur_Date_creation'] ) ) { $mf_add['a_liste_contact_joueur_Date_creation'] = $_POST['a_liste_contact_joueur_Date_creation']; }
        $retour = $table_a_liste_contact_joueur->mf_ajouter_2( $mf_add );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_a_liste_contact_joueur';
            if (!isset($est_charge['liste_contacts']))
            {
                $Code_liste_contacts = ( isset( $_POST['Code_liste_contacts'] ) ?  $_POST['Code_liste_contacts'] : 0 );
            }
            if (!isset($est_charge['joueur']))
            {
                $Code_joueur = ( isset( $_POST['Code_joueur'] ) ?  $_POST['Code_joueur'] : 0 );
            }
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

/*
    +------------+
    |  Modifier  |
    +------------+
*/
    if ( $mf_action=="modifier_a_liste_contact_joueur" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $mf_update = [];
        $mf_update['Code_liste_contacts'] = $Code_liste_contacts;
        $mf_update['Code_joueur'] = $Code_joueur;
        if ( isset( $_POST['a_liste_contact_joueur_Date_creation'] ) ) { $mf_update['a_liste_contact_joueur_Date_creation'] = $_POST['a_liste_contact_joueur_Date_creation']; }
        $retour = $table_a_liste_contact_joueur->mf_modifier_2( $mf_update );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = "apercu_a_liste_contact_joueur";
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_a_liste_contact_joueur_Date_creation' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $a_liste_contact_joueur_Date_creation = $_POST['a_liste_contact_joueur_Date_creation'];
        $retour = $table_a_liste_contact_joueur -> mf_modifier_2( [ [ 'Code_liste_contacts' => $Code_liste_contacts , 'Code_joueur' => $Code_joueur , 'a_liste_contact_joueur_Date_creation' => $a_liste_contact_joueur_Date_creation ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_a_liste_contact_joueur';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

/*
    +-------------+
    |  Supprimer  |
    +-------------+
*/
    if ( $mf_action=="supprimer_a_liste_contact_joueur" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $Supprimer = round($_POST["Supprimer"]);
        if ($Supprimer==1)
        {
            $retour = $table_a_liste_contact_joueur->mf_supprimer($Code_liste_contacts, $Code_joueur);
            if ( $retour['code_erreur']==0 )
            {
                $mf_action = "-";
                $cache->clear();
            }
            else
            {
                $cache->clear_current_page();
            }
        }
        else
        {
            $mf_action = "apercu_a_liste_contact_joueur";
            $cache->clear_current_page();
        }
    }
