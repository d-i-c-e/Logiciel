<?php

    $est_charge['groupe'] = 1;

    if (!isset($lang_standard['Code_campagne_']))
    {
        $lang_standard['Code_campagne_'] = array();
        $table_campagne = new campagne();
        $liste = $table_campagne->mf_lister_contexte();
        foreach ($liste as $code => $value)
        {
            $lang_standard['Code_campagne_'][$code] = get_titre_ligne_table('campagne', $value);
        }
    }

/*
    +-----------+
    |  Ajouter  |
    +-----------+
*/
    if ( $mf_action=='ajouter_groupe' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $mf_add = [];
        if ( isset( $_POST['groupe_Nom'] ) ) { $mf_add['groupe_Nom'] = $_POST['groupe_Nom']; }
        if ( isset( $_POST['groupe_Description'] ) ) { $mf_add['groupe_Description'] = $_POST['groupe_Description']; }
        if ( isset( $_FILES['groupe_Logo_Fichier'] ) ) { $fichier = new Fichier(); $mf_add['groupe_Logo_Fichier'] = $fichier->importer($_FILES['groupe_Logo_Fichier']); }
        if ( isset( $_POST['groupe_Effectif'] ) ) { $mf_add['groupe_Effectif'] = $_POST['groupe_Effectif']; }
        if ( isset( $_POST['groupe_Actif'] ) ) { $mf_add['groupe_Actif'] = $_POST['groupe_Actif']; }
        if ( isset( $_POST['groupe_Date_creation'] ) ) { $mf_add['groupe_Date_creation'] = $_POST['groupe_Date_creation']; }
        if ( isset( $_POST['groupe_Delai_suppression_jour'] ) ) { $mf_add['groupe_Delai_suppression_jour'] = $_POST['groupe_Delai_suppression_jour']; }
        if ( isset( $_POST['groupe_Suppression_active'] ) ) { $mf_add['groupe_Suppression_active'] = $_POST['groupe_Suppression_active']; }
        $mf_add['Code_campagne'] = ( isset($_POST['Code_campagne']) ? $_POST['Code_campagne'] : $Code_campagne );
        $retour = $table_groupe->mf_ajouter_2($mf_add);
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = "apercu_groupe";
            $Code_groupe =  $retour['Code_groupe'];
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
    if ( $mf_action=="creer_groupe" )
    {
        $retour = $table_groupe->mf_creer($Code_campagne);
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = "apercu_groupe";
            $Code_groupe =  $retour['Code_groupe'];
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
    if ( $mf_action=="modifier_groupe" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $mf_update = [];
        if ( isset( $_POST['groupe_Nom'] ) ) { $mf_update['groupe_Nom'] = $_POST['groupe_Nom']; }
        if ( isset( $_POST['groupe_Description'] ) ) { $mf_update['groupe_Description'] = $_POST['groupe_Description']; }
        if ( isset( $_FILES['groupe_Logo_Fichier'] ) ) { $fichier = new Fichier(); $mf_update['groupe_Logo_Fichier'] = $fichier->importer($_FILES['groupe_Logo_Fichier']); }
        if ( isset( $_POST['groupe_Effectif'] ) ) { $mf_update['groupe_Effectif'] = $_POST['groupe_Effectif']; }
        if ( isset( $_POST['groupe_Actif'] ) ) { $mf_update['groupe_Actif'] = $_POST['groupe_Actif']; }
        if ( isset( $_POST['groupe_Date_creation'] ) ) { $mf_update['groupe_Date_creation'] = $_POST['groupe_Date_creation']; }
        if ( isset( $_POST['groupe_Delai_suppression_jour'] ) ) { $mf_update['groupe_Delai_suppression_jour'] = $_POST['groupe_Delai_suppression_jour']; }
        if ( isset( $_POST['groupe_Suppression_active'] ) ) { $mf_update['groupe_Suppression_active'] = $_POST['groupe_Suppression_active']; }
        if ( isset($_POST['Code_campagne']) ) { $mf_update['Code_campagne'] = $_POST['Code_campagne']; }
        $retour = $table_groupe->mf_modifier_2( [ $Code_groupe => $mf_update ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_groupe';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_groupe_Nom' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $groupe_Nom = $_POST['groupe_Nom'];
        $retour = $table_groupe->mf_modifier_2( [ $Code_groupe => [ 'groupe_Nom' => $groupe_Nom ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_groupe';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_groupe_Description' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $groupe_Description = $_POST['groupe_Description'];
        $retour = $table_groupe->mf_modifier_2( [ $Code_groupe => [ 'groupe_Description' => $groupe_Description ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_groupe';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_groupe_Logo_Fichier' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $fichier = new Fichier();
        $groupe_Logo_Fichier = $fichier->importer($_FILES['groupe_Logo_Fichier']);
        if ($groupe_Logo_Fichier=='') { $temp = $table_groupe->mf_get($Code_groupe); $groupe_Logo_Fichier = $temp['groupe_Logo_Fichier']; }
        $retour = $table_groupe->mf_modifier_2( [ $Code_groupe => [ 'groupe_Logo_Fichier' => $groupe_Logo_Fichier ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_groupe';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_groupe_Effectif' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $groupe_Effectif = $_POST['groupe_Effectif'];
        $retour = $table_groupe->mf_modifier_2( [ $Code_groupe => [ 'groupe_Effectif' => $groupe_Effectif ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_groupe';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_groupe_Actif' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $groupe_Actif = $_POST['groupe_Actif'];
        $retour = $table_groupe->mf_modifier_2( [ $Code_groupe => [ 'groupe_Actif' => $groupe_Actif ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_groupe';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_groupe_Date_creation' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $groupe_Date_creation = $_POST['groupe_Date_creation'];
        $retour = $table_groupe->mf_modifier_2( [ $Code_groupe => [ 'groupe_Date_creation' => $groupe_Date_creation ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_groupe';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_groupe_Delai_suppression_jour' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $groupe_Delai_suppression_jour = $_POST['groupe_Delai_suppression_jour'];
        $retour = $table_groupe->mf_modifier_2( [ $Code_groupe => [ 'groupe_Delai_suppression_jour' => $groupe_Delai_suppression_jour ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_groupe';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_groupe_Suppression_active' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $groupe_Suppression_active = $_POST['groupe_Suppression_active'];
        $retour = $table_groupe->mf_modifier_2( [ $Code_groupe => [ 'groupe_Suppression_active' => $groupe_Suppression_active ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_groupe';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_groupe__Code_campagne' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $retour = $table_groupe->mf_modifier_2( [ $Code_groupe => [ 'Code_campagne' => ( isset($_POST['Code_campagne']) ? $_POST['Code_campagne'] : $Code_campagne ) ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_groupe';
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
    if ( $mf_action=="supprimer_groupe" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $Supprimer = round($_POST["Supprimer"]);
        if ($Supprimer==1)
        {
            $retour = $table_groupe->mf_supprimer($Code_groupe);
            if ( $retour['code_erreur']==0 )
            {
                $mf_action = "-";
                $cache->clear();
                $Code_groupe = 0;
            }
            else
            {
                $cache->clear_current_page();
            }
        }
        else
        {
            $mf_action = "apercu_groupe";
            $cache->clear_current_page();
        }
    }
