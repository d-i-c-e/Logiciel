<?php

    $est_charge['message'] = 1;

    if (!isset($lang_standard['Code_messagerie_']))
    {
        $lang_standard['Code_messagerie_'] = array();
        $table_messagerie = new messagerie();
        $liste = $table_messagerie->mf_lister_contexte();
        foreach ($liste as $code => $value)
        {
            $lang_standard['Code_messagerie_'][$code] = get_titre_ligne_table('messagerie', $value);
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
    if ( $mf_action=='ajouter_message' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $mf_add = [];
        if ( isset( $_POST['message_Texte'] ) ) { $mf_add['message_Texte'] = $_POST['message_Texte']; }
        if ( isset( $_POST['message_Date'] ) ) { $mf_add['message_Date'] = $_POST['message_Date']; }
        $mf_add['Code_messagerie'] = ( isset($_POST['Code_messagerie']) ? $_POST['Code_messagerie'] : $Code_messagerie );
        $mf_add['Code_joueur'] = ( isset($_POST['Code_joueur']) ? $_POST['Code_joueur'] : $Code_joueur );
        $retour = $table_message->mf_ajouter_2($mf_add);
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = "apercu_message";
            $Code_message =  $retour['Code_message'];
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
    if ( $mf_action=="creer_message" )
    {
        $retour = $table_message->mf_creer($Code_messagerie, $Code_joueur);
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = "apercu_message";
            $Code_message =  $retour['Code_message'];
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
    if ( $mf_action=="modifier_message" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $mf_update = [];
        if ( isset( $_POST['message_Texte'] ) ) { $mf_update['message_Texte'] = $_POST['message_Texte']; }
        if ( isset( $_POST['message_Date'] ) ) { $mf_update['message_Date'] = $_POST['message_Date']; }
        if ( isset($_POST['Code_messagerie']) ) { $mf_update['Code_messagerie'] = $_POST['Code_messagerie']; }
        if ( isset($_POST['Code_joueur']) ) { $mf_update['Code_joueur'] = $_POST['Code_joueur']; }
        $retour = $table_message->mf_modifier_2( [ $Code_message => $mf_update ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_message';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_message_Texte' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $message_Texte = $_POST['message_Texte'];
        $retour = $table_message->mf_modifier_2( [ $Code_message => [ 'message_Texte' => $message_Texte ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_message';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_message_Date' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $message_Date = $_POST['message_Date'];
        $retour = $table_message->mf_modifier_2( [ $Code_message => [ 'message_Date' => $message_Date ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_message';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_message__Code_messagerie' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $retour = $table_message->mf_modifier_2( [ $Code_message => [ 'Code_messagerie' => ( isset($_POST['Code_messagerie']) ? $_POST['Code_messagerie'] : $Code_messagerie ) ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_message';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_message__Code_joueur' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $retour = $table_message->mf_modifier_2( [ $Code_message => [ 'Code_joueur' => ( isset($_POST['Code_joueur']) ? $_POST['Code_joueur'] : $Code_joueur ) ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_message';
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
    if ( $mf_action=="supprimer_message" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $Supprimer = round($_POST["Supprimer"]);
        if ($Supprimer==1)
        {
            $retour = $table_message->mf_supprimer($Code_message);
            if ( $retour['code_erreur']==0 )
            {
                $mf_action = "-";
                $cache->clear();
                $Code_message = 0;
            }
            else
            {
                $cache->clear_current_page();
            }
        }
        else
        {
            $mf_action = "apercu_message";
            $cache->clear_current_page();
        }
    }
