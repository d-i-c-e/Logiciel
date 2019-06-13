<?php

    $est_charge['a_invitation_joueur_groupe'] = 1;

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
    if (!isset($lang_standard['Code_groupe_']))
    {
        $lang_standard['Code_groupe_'] = array();
        $table_groupe = new groupe();
        $liste = $table_groupe->mf_lister_contexte();
        foreach ($liste as $code => $value)
        {
            $lang_standard['Code_groupe_'][$code] = get_titre_ligne_table('groupe', $value);
        }
    }

/*
    +-----------+
    |  Ajouter  |
    +-----------+
*/
    if ( $mf_action=='ajouter_a_invitation_joueur_groupe' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $mf_add = [];
        $mf_add['Code_joueur'] = ( isset( $_POST['Code_joueur'] ) ? $_POST['Code_joueur'] : $Code_joueur );
        $mf_add['Code_groupe'] = ( isset( $_POST['Code_groupe'] ) ? $_POST['Code_groupe'] : $Code_groupe );
        if ( isset( $_POST['a_invitation_joueur_groupe_Message'] ) ) { $mf_add['a_invitation_joueur_groupe_Message'] = $_POST['a_invitation_joueur_groupe_Message']; }
        if ( isset( $_POST['a_invitation_joueur_groupe_Date_envoi'] ) ) { $mf_add['a_invitation_joueur_groupe_Date_envoi'] = $_POST['a_invitation_joueur_groupe_Date_envoi']; }
        $retour = $table_a_invitation_joueur_groupe->mf_ajouter_2( $mf_add );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_a_invitation_joueur_groupe';
            if (!isset($est_charge['joueur']))
            {
                $Code_joueur = ( isset( $_POST['Code_joueur'] ) ?  $_POST['Code_joueur'] : 0 );
            }
            if (!isset($est_charge['groupe']))
            {
                $Code_groupe = ( isset( $_POST['Code_groupe'] ) ?  $_POST['Code_groupe'] : 0 );
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
    if ( $mf_action=="modifier_a_invitation_joueur_groupe" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $mf_update = [];
        $mf_update['Code_joueur'] = $Code_joueur;
        $mf_update['Code_groupe'] = $Code_groupe;
        if ( isset( $_POST['a_invitation_joueur_groupe_Message'] ) ) { $mf_update['a_invitation_joueur_groupe_Message'] = $_POST['a_invitation_joueur_groupe_Message']; }
        if ( isset( $_POST['a_invitation_joueur_groupe_Date_envoi'] ) ) { $mf_update['a_invitation_joueur_groupe_Date_envoi'] = $_POST['a_invitation_joueur_groupe_Date_envoi']; }
        $retour = $table_a_invitation_joueur_groupe->mf_modifier_2( $mf_update );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = "apercu_a_invitation_joueur_groupe";
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_a_invitation_joueur_groupe_Message' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $a_invitation_joueur_groupe_Message = $_POST['a_invitation_joueur_groupe_Message'];
        $retour = $table_a_invitation_joueur_groupe -> mf_modifier_2( [ [ 'Code_joueur' => $Code_joueur , 'Code_groupe' => $Code_groupe , 'a_invitation_joueur_groupe_Message' => $a_invitation_joueur_groupe_Message ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_a_invitation_joueur_groupe';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_a_invitation_joueur_groupe_Date_envoi' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $a_invitation_joueur_groupe_Date_envoi = $_POST['a_invitation_joueur_groupe_Date_envoi'];
        $retour = $table_a_invitation_joueur_groupe -> mf_modifier_2( [ [ 'Code_joueur' => $Code_joueur , 'Code_groupe' => $Code_groupe , 'a_invitation_joueur_groupe_Date_envoi' => $a_invitation_joueur_groupe_Date_envoi ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_a_invitation_joueur_groupe';
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
    if ( $mf_action=="supprimer_a_invitation_joueur_groupe" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $Supprimer = round($_POST["Supprimer"]);
        if ($Supprimer==1)
        {
            $retour = $table_a_invitation_joueur_groupe->mf_supprimer($Code_joueur, $Code_groupe);
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
            $mf_action = "apercu_a_invitation_joueur_groupe";
            $cache->clear_current_page();
        }
    }
