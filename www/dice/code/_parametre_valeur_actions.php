<?php

    $est_charge['parametre_valeur'] = 1;

    if (!isset($lang_standard['Code_parametre_']))
    {
        $lang_standard['Code_parametre_'] = array();
        $table_parametre = new parametre();
        $liste = $table_parametre->mf_lister_contexte();
        foreach ($liste as $code => $value)
        {
            $lang_standard['Code_parametre_'][$code] = get_titre_ligne_table('parametre', $value);
        }
    }

/*
    +-----------+
    |  Ajouter  |
    +-----------+
*/
    if ( $mf_action=='ajouter_parametre_valeur' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $mf_add = [];
        if ( isset( $_POST['parametre_valeur_Libelle'] ) ) { $mf_add['parametre_valeur_Libelle'] = $_POST['parametre_valeur_Libelle']; }
        $mf_add['Code_parametre'] = ( isset($_POST['Code_parametre']) ? $_POST['Code_parametre'] : $Code_parametre );
        $retour = $table_parametre_valeur->mf_ajouter_2($mf_add);
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = "apercu_parametre_valeur";
            $Code_parametre_valeur =  $retour['Code_parametre_valeur'];
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
    if ( $mf_action=="creer_parametre_valeur" )
    {
        $retour = $table_parametre_valeur->mf_creer($Code_parametre);
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = "apercu_parametre_valeur";
            $Code_parametre_valeur =  $retour['Code_parametre_valeur'];
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
    if ( $mf_action=="modifier_parametre_valeur" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $mf_update = [];
        if ( isset( $_POST['parametre_valeur_Libelle'] ) ) { $mf_update['parametre_valeur_Libelle'] = $_POST['parametre_valeur_Libelle']; }
        if ( isset($_POST['Code_parametre']) ) { $mf_update['Code_parametre'] = $_POST['Code_parametre']; }
        $retour = $table_parametre_valeur->mf_modifier_2( [ $Code_parametre_valeur => $mf_update ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_parametre_valeur';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_parametre_valeur_Libelle' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $parametre_valeur_Libelle = $_POST['parametre_valeur_Libelle'];
        $retour = $table_parametre_valeur->mf_modifier_2( [ $Code_parametre_valeur => [ 'parametre_valeur_Libelle' => $parametre_valeur_Libelle ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_parametre_valeur';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_parametre_valeur__Code_parametre' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $retour = $table_parametre_valeur->mf_modifier_2( [ $Code_parametre_valeur => [ 'Code_parametre' => ( isset($_POST['Code_parametre']) ? $_POST['Code_parametre'] : $Code_parametre ) ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_parametre_valeur';
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
    if ( $mf_action=="supprimer_parametre_valeur" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $Supprimer = round($_POST["Supprimer"]);
        if ($Supprimer==1)
        {
            $retour = $table_parametre_valeur->mf_supprimer($Code_parametre_valeur);
            if ( $retour['code_erreur']==0 )
            {
                $mf_action = "-";
                $cache->clear();
                $Code_parametre_valeur = 0;
            }
            else
            {
                $cache->clear_current_page();
            }
        }
        else
        {
            $mf_action = "apercu_parametre_valeur";
            $cache->clear_current_page();
        }
    }
