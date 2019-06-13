<?php

    $est_charge['ressource'] = 1;

/*
    +-----------+
    |  Ajouter  |
    +-----------+
*/
    if ( $mf_action=='ajouter_ressource' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $mf_add = [];
        if ( isset( $_POST['ressource_Nom'] ) ) { $mf_add['ressource_Nom'] = $_POST['ressource_Nom']; }
        $retour = $table_ressource->mf_ajouter_2($mf_add);
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = "apercu_ressource";
            $Code_ressource =  $retour['Code_ressource'];
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
    if ( $mf_action=="creer_ressource" )
    {
        $retour = $table_ressource->mf_creer();
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = "apercu_ressource";
            $Code_ressource =  $retour['Code_ressource'];
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
    if ( $mf_action=="modifier_ressource" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $mf_update = [];
        if ( isset( $_POST['ressource_Nom'] ) ) { $mf_update['ressource_Nom'] = $_POST['ressource_Nom']; }
        $retour = $table_ressource->mf_modifier_2( [ $Code_ressource => $mf_update ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_ressource';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_ressource_Nom' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $ressource_Nom = $_POST['ressource_Nom'];
        $retour = $table_ressource->mf_modifier_2( [ $Code_ressource => [ 'ressource_Nom' => $ressource_Nom ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_ressource';
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
    if ( $mf_action=="supprimer_ressource" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $Supprimer = round($_POST["Supprimer"]);
        if ($Supprimer==1)
        {
            $retour = $table_ressource->mf_supprimer($Code_ressource);
            if ( $retour['code_erreur']==0 )
            {
                $mf_action = "-";
                $cache->clear();
                $Code_ressource = 0;
            }
            else
            {
                $cache->clear_current_page();
            }
        }
        else
        {
            $mf_action = "apercu_ressource";
            $cache->clear_current_page();
        }
    }
