<?php

    $est_charge['liste_contacts'] = 1;

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
    if ( $mf_action=='ajouter_liste_contacts' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $mf_add = [];
        if ( isset( $_POST['liste_contacts_Nom'] ) ) { $mf_add['liste_contacts_Nom'] = $_POST['liste_contacts_Nom']; }
        $mf_add['Code_joueur'] = ( isset($_POST['Code_joueur']) ? $_POST['Code_joueur'] : $Code_joueur );
        $retour = $table_liste_contacts->mf_ajouter_2($mf_add);
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = "apercu_liste_contacts";
            $Code_liste_contacts =  $retour['Code_liste_contacts'];
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

/*
    +---------+
    |  Creer  |
    +---------+
*/
    if ( $mf_action=="creer_liste_contacts" )
    {
        $retour = $table_liste_contacts->mf_creer($Code_joueur);
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = "apercu_liste_contacts";
            $Code_liste_contacts =  $retour['Code_liste_contacts'];
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
    if ( $mf_action=="modifier_liste_contacts" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $mf_update = [];
        if ( isset( $_POST['liste_contacts_Nom'] ) ) { $mf_update['liste_contacts_Nom'] = $_POST['liste_contacts_Nom']; }
        if ( isset($_POST['Code_joueur']) ) { $mf_update['Code_joueur'] = $_POST['Code_joueur']; }
        $retour = $table_liste_contacts->mf_modifier_2( [ $Code_liste_contacts => $mf_update ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_liste_contacts';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_liste_contacts_Nom' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $liste_contacts_Nom = $_POST['liste_contacts_Nom'];
        $retour = $table_liste_contacts->mf_modifier_2( [ $Code_liste_contacts => [ 'liste_contacts_Nom' => $liste_contacts_Nom ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_liste_contacts';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_liste_contacts__Code_joueur' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $retour = $table_liste_contacts->mf_modifier_2( [ $Code_liste_contacts => [ 'Code_joueur' => ( isset($_POST['Code_joueur']) ? $_POST['Code_joueur'] : $Code_joueur ) ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_liste_contacts';
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
    if ( $mf_action=="supprimer_liste_contacts" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $Supprimer = round($_POST["Supprimer"]);
        if ($Supprimer==1)
        {
            $retour = $table_liste_contacts->mf_supprimer($Code_liste_contacts);
            if ( $retour['code_erreur']==0 )
            {
                $mf_action = "-";
                $cache->clear();
                $Code_liste_contacts = 0;
            }
            else
            {
                $cache->clear_current_page();
            }
        }
        else
        {
            $mf_action = "apercu_liste_contacts";
            $cache->clear_current_page();
        }
    }
