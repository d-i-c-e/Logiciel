<?php

    $est_charge['tag_campagne'] = 1;

/*
    +-----------+
    |  Ajouter  |
    +-----------+
*/
    if ( $mf_action=='ajouter_tag_campagne' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $mf_add = [];
        if ( isset( $_POST['tag_campagne_Libelle'] ) ) { $mf_add['tag_campagne_Libelle'] = $_POST['tag_campagne_Libelle']; }
        $retour = $table_tag_campagne->mf_ajouter_2($mf_add);
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = "apercu_tag_campagne";
            $Code_tag_campagne =  $retour['Code_tag_campagne'];
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
    if ( $mf_action=="creer_tag_campagne" )
    {
        $retour = $table_tag_campagne->mf_creer();
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = "apercu_tag_campagne";
            $Code_tag_campagne =  $retour['Code_tag_campagne'];
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
    if ( $mf_action=="modifier_tag_campagne" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $mf_update = [];
        if ( isset( $_POST['tag_campagne_Libelle'] ) ) { $mf_update['tag_campagne_Libelle'] = $_POST['tag_campagne_Libelle']; }
        $retour = $table_tag_campagne->mf_modifier_2( [ $Code_tag_campagne => $mf_update ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_tag_campagne';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_tag_campagne_Libelle' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $tag_campagne_Libelle = $_POST['tag_campagne_Libelle'];
        $retour = $table_tag_campagne->mf_modifier_2( [ $Code_tag_campagne => [ 'tag_campagne_Libelle' => $tag_campagne_Libelle ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_tag_campagne';
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
    if ( $mf_action=="supprimer_tag_campagne" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $Supprimer = round($_POST["Supprimer"]);
        if ($Supprimer==1)
        {
            $retour = $table_tag_campagne->mf_supprimer($Code_tag_campagne);
            if ( $retour['code_erreur']==0 )
            {
                $mf_action = "-";
                $cache->clear();
                $Code_tag_campagne = 0;
            }
            else
            {
                $cache->clear_current_page();
            }
        }
        else
        {
            $mf_action = "apercu_tag_campagne";
            $cache->clear_current_page();
        }
    }
