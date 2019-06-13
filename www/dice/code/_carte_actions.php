<?php

    $est_charge['carte'] = 1;

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
    if ( $mf_action=='ajouter_carte' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $mf_add = [];
        if ( isset( $_POST['carte_Nom'] ) ) { $mf_add['carte_Nom'] = $_POST['carte_Nom']; }
        if ( isset( $_POST['carte_Hauteur'] ) ) { $mf_add['carte_Hauteur'] = $_POST['carte_Hauteur']; }
        if ( isset( $_POST['carte_Largeur'] ) ) { $mf_add['carte_Largeur'] = $_POST['carte_Largeur']; }
        if ( isset( $_FILES['carte_Fichier'] ) ) { $fichier = new Fichier(); $mf_add['carte_Fichier'] = $fichier->importer($_FILES['carte_Fichier']); }
        $mf_add['Code_groupe'] = ( isset($_POST['Code_groupe']) ? $_POST['Code_groupe'] : $Code_groupe );
        $retour = $table_carte->mf_ajouter_2($mf_add);
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = "apercu_carte";
            $Code_carte =  $retour['Code_carte'];
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
    if ( $mf_action=="creer_carte" )
    {
        $retour = $table_carte->mf_creer($Code_groupe);
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = "apercu_carte";
            $Code_carte =  $retour['Code_carte'];
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
    if ( $mf_action=="modifier_carte" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $mf_update = [];
        if ( isset( $_POST['carte_Nom'] ) ) { $mf_update['carte_Nom'] = $_POST['carte_Nom']; }
        if ( isset( $_POST['carte_Hauteur'] ) ) { $mf_update['carte_Hauteur'] = $_POST['carte_Hauteur']; }
        if ( isset( $_POST['carte_Largeur'] ) ) { $mf_update['carte_Largeur'] = $_POST['carte_Largeur']; }
        if ( isset( $_FILES['carte_Fichier'] ) ) { $fichier = new Fichier(); $mf_update['carte_Fichier'] = $fichier->importer($_FILES['carte_Fichier']); }
        if ( isset($_POST['Code_groupe']) ) { $mf_update['Code_groupe'] = $_POST['Code_groupe']; }
        $retour = $table_carte->mf_modifier_2( [ $Code_carte => $mf_update ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_carte';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_carte_Nom' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $carte_Nom = $_POST['carte_Nom'];
        $retour = $table_carte->mf_modifier_2( [ $Code_carte => [ 'carte_Nom' => $carte_Nom ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_carte';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_carte_Hauteur' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $carte_Hauteur = $_POST['carte_Hauteur'];
        $retour = $table_carte->mf_modifier_2( [ $Code_carte => [ 'carte_Hauteur' => $carte_Hauteur ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_carte';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_carte_Largeur' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $carte_Largeur = $_POST['carte_Largeur'];
        $retour = $table_carte->mf_modifier_2( [ $Code_carte => [ 'carte_Largeur' => $carte_Largeur ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_carte';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_carte_Fichier' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $fichier = new Fichier();
        $carte_Fichier = $fichier->importer($_FILES['carte_Fichier']);
        if ($carte_Fichier=='') { $temp = $table_carte->mf_get($Code_carte); $carte_Fichier = $temp['carte_Fichier']; }
        $retour = $table_carte->mf_modifier_2( [ $Code_carte => [ 'carte_Fichier' => $carte_Fichier ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_carte';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_carte__Code_groupe' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $retour = $table_carte->mf_modifier_2( [ $Code_carte => [ 'Code_groupe' => ( isset($_POST['Code_groupe']) ? $_POST['Code_groupe'] : $Code_groupe ) ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_carte';
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
    if ( $mf_action=="supprimer_carte" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $Supprimer = round($_POST["Supprimer"]);
        if ($Supprimer==1)
        {
            $retour = $table_carte->mf_supprimer($Code_carte);
            if ( $retour['code_erreur']==0 )
            {
                $mf_action = "-";
                $cache->clear();
                $Code_carte = 0;
            }
            else
            {
                $cache->clear_current_page();
            }
        }
        else
        {
            $mf_action = "apercu_carte";
            $cache->clear_current_page();
        }
    }
