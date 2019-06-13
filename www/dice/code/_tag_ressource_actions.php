<?php

    $est_charge['tag_ressource'] = 1;

/*
    +-----------+
    |  Ajouter  |
    +-----------+
*/
    if ( $mf_action=='ajouter_tag_ressource' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $mf_add = [];
        if ( isset( $_POST['tag_ressource_Libelle'] ) ) { $mf_add['tag_ressource_Libelle'] = $_POST['tag_ressource_Libelle']; }
        $retour = $table_tag_ressource->mf_ajouter_2($mf_add);
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = "apercu_tag_ressource";
            $Code_tag_ressource =  $retour['Code_tag_ressource'];
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
    if ( $mf_action=="creer_tag_ressource" )
    {
        $retour = $table_tag_ressource->mf_creer();
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = "apercu_tag_ressource";
            $Code_tag_ressource =  $retour['Code_tag_ressource'];
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
    if ( $mf_action=="modifier_tag_ressource" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $mf_update = [];
        if ( isset( $_POST['tag_ressource_Libelle'] ) ) { $mf_update['tag_ressource_Libelle'] = $_POST['tag_ressource_Libelle']; }
        $retour = $table_tag_ressource->mf_modifier_2( [ $Code_tag_ressource => $mf_update ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_tag_ressource';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_tag_ressource_Libelle' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $tag_ressource_Libelle = $_POST['tag_ressource_Libelle'];
        $retour = $table_tag_ressource->mf_modifier_2( [ $Code_tag_ressource => [ 'tag_ressource_Libelle' => $tag_ressource_Libelle ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_tag_ressource';
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
    if ( $mf_action=="supprimer_tag_ressource" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $Supprimer = round($_POST["Supprimer"]);
        if ($Supprimer==1)
        {
            $retour = $table_tag_ressource->mf_supprimer($Code_tag_ressource);
            if ( $retour['code_erreur']==0 )
            {
                $mf_action = "-";
                $cache->clear();
                $Code_tag_ressource = 0;
            }
            else
            {
                $cache->clear_current_page();
            }
        }
        else
        {
            $mf_action = "apercu_tag_ressource";
            $cache->clear_current_page();
        }
    }
