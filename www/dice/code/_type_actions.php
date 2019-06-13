<?php

    $est_charge['type'] = 1;

    if (!isset($lang_standard['Code_ressource_']))
    {
        $lang_standard['Code_ressource_'] = array();
        $table_ressource = new ressource();
        $liste = $table_ressource->mf_lister_contexte();
        foreach ($liste as $code => $value)
        {
            $lang_standard['Code_ressource_'][$code] = get_titre_ligne_table('ressource', $value);
        }
    }

/*
    +-----------+
    |  Ajouter  |
    +-----------+
*/
    if ( $mf_action=='ajouter_type' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $mf_add = [];
        if ( isset( $_POST['type_Libelle'] ) ) { $mf_add['type_Libelle'] = $_POST['type_Libelle']; }
        $mf_add['Code_ressource'] = ( isset($_POST['Code_ressource']) ? $_POST['Code_ressource'] : $Code_ressource );
        $retour = $table_type->mf_ajouter_2($mf_add);
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = "apercu_type";
            $Code_type =  $retour['Code_type'];
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
    if ( $mf_action=="creer_type" )
    {
        $retour = $table_type->mf_creer($Code_ressource);
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = "apercu_type";
            $Code_type =  $retour['Code_type'];
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
    if ( $mf_action=="modifier_type" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $mf_update = [];
        if ( isset( $_POST['type_Libelle'] ) ) { $mf_update['type_Libelle'] = $_POST['type_Libelle']; }
        if ( isset($_POST['Code_ressource']) ) { $mf_update['Code_ressource'] = $_POST['Code_ressource']; }
        $retour = $table_type->mf_modifier_2( [ $Code_type => $mf_update ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_type';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_type_Libelle' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $type_Libelle = $_POST['type_Libelle'];
        $retour = $table_type->mf_modifier_2( [ $Code_type => [ 'type_Libelle' => $type_Libelle ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_type';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_type__Code_ressource' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $retour = $table_type->mf_modifier_2( [ $Code_type => [ 'Code_ressource' => ( isset($_POST['Code_ressource']) ? $_POST['Code_ressource'] : $Code_ressource ) ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_type';
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
    if ( $mf_action=="supprimer_type" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $Supprimer = round($_POST["Supprimer"]);
        if ($Supprimer==1)
        {
            $retour = $table_type->mf_supprimer($Code_type);
            if ( $retour['code_erreur']==0 )
            {
                $mf_action = "-";
                $cache->clear();
                $Code_type = 0;
            }
            else
            {
                $cache->clear_current_page();
            }
        }
        else
        {
            $mf_action = "apercu_type";
            $cache->clear_current_page();
        }
    }
