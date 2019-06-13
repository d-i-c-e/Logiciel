<?php

    $est_charge['personnage'] = 1;

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
    if ( $mf_action=='ajouter_personnage' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $mf_add = [];
        if ( isset( $_FILES['personnage_Fichier_Fichier'] ) ) { $fichier = new Fichier(); $mf_add['personnage_Fichier_Fichier'] = $fichier->importer($_FILES['personnage_Fichier_Fichier']); }
        if ( isset( $_POST['personnage_Conservation'] ) ) { $mf_add['personnage_Conservation'] = $_POST['personnage_Conservation']; }
        $mf_add['Code_joueur'] = ( isset($_POST['Code_joueur']) ? $_POST['Code_joueur'] : $Code_joueur );
        $mf_add['Code_groupe'] = ( isset($_POST['Code_groupe']) ? $_POST['Code_groupe'] : $Code_groupe );
        $retour = $table_personnage->mf_ajouter_2($mf_add);
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = "apercu_personnage";
            $Code_personnage =  $retour['Code_personnage'];
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
    if ( $mf_action=="creer_personnage" )
    {
        $retour = $table_personnage->mf_creer($Code_joueur, $Code_groupe);
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = "apercu_personnage";
            $Code_personnage =  $retour['Code_personnage'];
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
    if ( $mf_action=="modifier_personnage" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $mf_update = [];
        if ( isset( $_FILES['personnage_Fichier_Fichier'] ) ) { $fichier = new Fichier(); $mf_update['personnage_Fichier_Fichier'] = $fichier->importer($_FILES['personnage_Fichier_Fichier']); }
        if ( isset( $_POST['personnage_Conservation'] ) ) { $mf_update['personnage_Conservation'] = $_POST['personnage_Conservation']; }
        if ( isset($_POST['Code_joueur']) ) { $mf_update['Code_joueur'] = $_POST['Code_joueur']; }
        if ( isset($_POST['Code_groupe']) ) { $mf_update['Code_groupe'] = $_POST['Code_groupe']; }
        $retour = $table_personnage->mf_modifier_2( [ $Code_personnage => $mf_update ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_personnage';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_personnage_Fichier_Fichier' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $fichier = new Fichier();
        $personnage_Fichier_Fichier = $fichier->importer($_FILES['personnage_Fichier_Fichier']);
        if ($personnage_Fichier_Fichier=='') { $temp = $table_personnage->mf_get($Code_personnage); $personnage_Fichier_Fichier = $temp['personnage_Fichier_Fichier']; }
        $retour = $table_personnage->mf_modifier_2( [ $Code_personnage => [ 'personnage_Fichier_Fichier' => $personnage_Fichier_Fichier ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_personnage';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_personnage_Conservation' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $personnage_Conservation = $_POST['personnage_Conservation'];
        $retour = $table_personnage->mf_modifier_2( [ $Code_personnage => [ 'personnage_Conservation' => $personnage_Conservation ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_personnage';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_personnage__Code_joueur' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $retour = $table_personnage->mf_modifier_2( [ $Code_personnage => [ 'Code_joueur' => ( isset($_POST['Code_joueur']) ? $_POST['Code_joueur'] : $Code_joueur ) ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_personnage';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_personnage__Code_groupe' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $retour = $table_personnage->mf_modifier_2( [ $Code_personnage => [ 'Code_groupe' => ( isset($_POST['Code_groupe']) ? $_POST['Code_groupe'] : $Code_groupe ) ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_personnage';
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
    if ( $mf_action=="supprimer_personnage" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $Supprimer = round($_POST["Supprimer"]);
        if ($Supprimer==1)
        {
            $retour = $table_personnage->mf_supprimer($Code_personnage);
            if ( $retour['code_erreur']==0 )
            {
                $mf_action = "-";
                $cache->clear();
                $Code_personnage = 0;
            }
            else
            {
                $cache->clear_current_page();
            }
        }
        else
        {
            $mf_action = "apercu_personnage";
            $cache->clear_current_page();
        }
    }
