<?php

    $est_charge['objet'] = 1;

    if (!isset($lang_standard['Code_type_']))
    {
        $lang_standard['Code_type_'] = array();
        $table_type = new type();
        $liste = $table_type->mf_lister_contexte();
        foreach ($liste as $code => $value)
        {
            $lang_standard['Code_type_'][$code] = get_titre_ligne_table('type', $value);
        }
    }

/*
    +-----------+
    |  Ajouter  |
    +-----------+
*/
    if ( $mf_action=='ajouter_objet' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $mf_add = [];
        if ( isset( $_POST['objet_Libelle'] ) ) { $mf_add['objet_Libelle'] = $_POST['objet_Libelle']; }
        if ( isset( $_FILES['objet_Image_Fichier'] ) ) { $fichier = new Fichier(); $mf_add['objet_Image_Fichier'] = $fichier->importer($_FILES['objet_Image_Fichier']); }
        $mf_add['Code_type'] = ( isset($_POST['Code_type']) ? $_POST['Code_type'] : $Code_type );
        $retour = $table_objet->mf_ajouter_2($mf_add);
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = "apercu_objet";
            $Code_objet =  $retour['Code_objet'];
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
    if ( $mf_action=="creer_objet" )
    {
        $retour = $table_objet->mf_creer($Code_type);
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = "apercu_objet";
            $Code_objet =  $retour['Code_objet'];
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
    if ( $mf_action=="modifier_objet" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $mf_update = [];
        if ( isset( $_POST['objet_Libelle'] ) ) { $mf_update['objet_Libelle'] = $_POST['objet_Libelle']; }
        if ( isset( $_FILES['objet_Image_Fichier'] ) ) { $fichier = new Fichier(); $mf_update['objet_Image_Fichier'] = $fichier->importer($_FILES['objet_Image_Fichier']); }
        if ( isset($_POST['Code_type']) ) { $mf_update['Code_type'] = $_POST['Code_type']; }
        $retour = $table_objet->mf_modifier_2( [ $Code_objet => $mf_update ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_objet';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_objet_Libelle' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $objet_Libelle = $_POST['objet_Libelle'];
        $retour = $table_objet->mf_modifier_2( [ $Code_objet => [ 'objet_Libelle' => $objet_Libelle ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_objet';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_objet_Image_Fichier' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $fichier = new Fichier();
        $objet_Image_Fichier = $fichier->importer($_FILES['objet_Image_Fichier']);
        if ($objet_Image_Fichier=='') { $temp = $table_objet->mf_get($Code_objet); $objet_Image_Fichier = $temp['objet_Image_Fichier']; }
        $retour = $table_objet->mf_modifier_2( [ $Code_objet => [ 'objet_Image_Fichier' => $objet_Image_Fichier ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_objet';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_objet__Code_type' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $retour = $table_objet->mf_modifier_2( [ $Code_objet => [ 'Code_type' => ( isset($_POST['Code_type']) ? $_POST['Code_type'] : $Code_type ) ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_objet';
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
    if ( $mf_action=="supprimer_objet" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $Supprimer = round($_POST["Supprimer"]);
        if ($Supprimer==1)
        {
            $retour = $table_objet->mf_supprimer($Code_objet);
            if ( $retour['code_erreur']==0 )
            {
                $mf_action = "-";
                $cache->clear();
                $Code_objet = 0;
            }
            else
            {
                $cache->clear_current_page();
            }
        }
        else
        {
            $mf_action = "apercu_objet";
            $cache->clear_current_page();
        }
    }
