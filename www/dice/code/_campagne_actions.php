<?php

    $est_charge['campagne'] = 1;

/*
    +-----------+
    |  Ajouter  |
    +-----------+
*/
    if ( $mf_action=='ajouter_campagne' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $mf_add = [];
        if ( isset( $_POST['campagne_Nom'] ) ) { $mf_add['campagne_Nom'] = $_POST['campagne_Nom']; }
        if ( isset( $_POST['campagne_Description'] ) ) { $mf_add['campagne_Description'] = $_POST['campagne_Description']; }
        if ( isset( $_FILES['campagne_Image_Fichier'] ) ) { $fichier = new Fichier(); $mf_add['campagne_Image_Fichier'] = $fichier->importer($_FILES['campagne_Image_Fichier']); }
        if ( isset( $_POST['campagne_Nombre_joueur'] ) ) { $mf_add['campagne_Nombre_joueur'] = $_POST['campagne_Nombre_joueur']; }
        if ( isset( $_POST['campagne_Nombre_mj'] ) ) { $mf_add['campagne_Nombre_mj'] = $_POST['campagne_Nombre_mj']; }
        $retour = $table_campagne->mf_ajouter_2($mf_add);
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = "apercu_campagne";
            $Code_campagne =  $retour['Code_campagne'];
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
    if ( $mf_action=="creer_campagne" )
    {
        $retour = $table_campagne->mf_creer();
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = "apercu_campagne";
            $Code_campagne =  $retour['Code_campagne'];
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
    if ( $mf_action=="modifier_campagne" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $mf_update = [];
        if ( isset( $_POST['campagne_Nom'] ) ) { $mf_update['campagne_Nom'] = $_POST['campagne_Nom']; }
        if ( isset( $_POST['campagne_Description'] ) ) { $mf_update['campagne_Description'] = $_POST['campagne_Description']; }
        if ( isset( $_FILES['campagne_Image_Fichier'] ) ) { $fichier = new Fichier(); $mf_update['campagne_Image_Fichier'] = $fichier->importer($_FILES['campagne_Image_Fichier']); }
        if ( isset( $_POST['campagne_Nombre_joueur'] ) ) { $mf_update['campagne_Nombre_joueur'] = $_POST['campagne_Nombre_joueur']; }
        if ( isset( $_POST['campagne_Nombre_mj'] ) ) { $mf_update['campagne_Nombre_mj'] = $_POST['campagne_Nombre_mj']; }
        $retour = $table_campagne->mf_modifier_2( [ $Code_campagne => $mf_update ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_campagne';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_campagne_Nom' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $campagne_Nom = $_POST['campagne_Nom'];
        $retour = $table_campagne->mf_modifier_2( [ $Code_campagne => [ 'campagne_Nom' => $campagne_Nom ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_campagne';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_campagne_Description' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $campagne_Description = $_POST['campagne_Description'];
        $retour = $table_campagne->mf_modifier_2( [ $Code_campagne => [ 'campagne_Description' => $campagne_Description ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_campagne';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_campagne_Image_Fichier' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $fichier = new Fichier();
        $campagne_Image_Fichier = $fichier->importer($_FILES['campagne_Image_Fichier']);
        if ($campagne_Image_Fichier=='') { $temp = $table_campagne->mf_get($Code_campagne); $campagne_Image_Fichier = $temp['campagne_Image_Fichier']; }
        $retour = $table_campagne->mf_modifier_2( [ $Code_campagne => [ 'campagne_Image_Fichier' => $campagne_Image_Fichier ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_campagne';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_campagne_Nombre_joueur' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $campagne_Nombre_joueur = $_POST['campagne_Nombre_joueur'];
        $retour = $table_campagne->mf_modifier_2( [ $Code_campagne => [ 'campagne_Nombre_joueur' => $campagne_Nombre_joueur ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_campagne';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_campagne_Nombre_mj' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $campagne_Nombre_mj = $_POST['campagne_Nombre_mj'];
        $retour = $table_campagne->mf_modifier_2( [ $Code_campagne => [ 'campagne_Nombre_mj' => $campagne_Nombre_mj ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_campagne';
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
    if ( $mf_action=="supprimer_campagne" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $Supprimer = round($_POST["Supprimer"]);
        if ($Supprimer==1)
        {
            $retour = $table_campagne->mf_supprimer($Code_campagne);
            if ( $retour['code_erreur']==0 )
            {
                $mf_action = "-";
                $cache->clear();
                $Code_campagne = 0;
            }
            else
            {
                $cache->clear_current_page();
            }
        }
        else
        {
            $mf_action = "apercu_campagne";
            $cache->clear_current_page();
        }
    }
