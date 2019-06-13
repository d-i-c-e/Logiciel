<?php

    $est_charge['messagerie'] = 1;

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
    if ( $mf_action=='ajouter_messagerie' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $mf_add = [];
        $mf_add['Code_joueur'] = ( isset($_POST['Code_joueur']) ? $_POST['Code_joueur'] : $Code_joueur );
        $retour = $table_messagerie->mf_ajouter_2($mf_add);
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = "apercu_messagerie";
            $Code_messagerie =  $retour['Code_messagerie'];
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
    if ( $mf_action=="creer_messagerie" )
    {
        $retour = $table_messagerie->mf_creer($Code_joueur);
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = "apercu_messagerie";
            $Code_messagerie =  $retour['Code_messagerie'];
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
    if ( $mf_action=="modifier_messagerie" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $mf_update = [];
        if ( isset($_POST['Code_joueur']) ) { $mf_update['Code_joueur'] = $_POST['Code_joueur']; }
        $retour = $table_messagerie->mf_modifier_2( [ $Code_messagerie => $mf_update ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_messagerie';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_messagerie__Code_joueur' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $retour = $table_messagerie->mf_modifier_2( [ $Code_messagerie => [ 'Code_joueur' => ( isset($_POST['Code_joueur']) ? $_POST['Code_joueur'] : $Code_joueur ) ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_messagerie';
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
    if ( $mf_action=="supprimer_messagerie" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $Supprimer = round($_POST["Supprimer"]);
        if ($Supprimer==1)
        {
            $retour = $table_messagerie->mf_supprimer($Code_messagerie);
            if ( $retour['code_erreur']==0 )
            {
                $mf_action = "-";
                $cache->clear();
                $Code_messagerie = 0;
            }
            else
            {
                $cache->clear_current_page();
            }
        }
        else
        {
            $mf_action = "apercu_messagerie";
            $cache->clear_current_page();
        }
    }
