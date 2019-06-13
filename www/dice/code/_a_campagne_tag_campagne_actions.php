<?php

    $est_charge['a_campagne_tag_campagne'] = 1;

    if (!isset($lang_standard['Code_tag_campagne_']))
    {
        $lang_standard['Code_tag_campagne_'] = array();
        $table_tag_campagne = new tag_campagne();
        $liste = $table_tag_campagne->mf_lister_contexte();
        foreach ($liste as $code => $value)
        {
            $lang_standard['Code_tag_campagne_'][$code] = get_titre_ligne_table('tag_campagne', $value);
        }
    }
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
    if ( $mf_action=='ajouter_a_campagne_tag_campagne' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $mf_add = [];
        $mf_add['Code_tag_campagne'] = ( isset( $_POST['Code_tag_campagne'] ) ? $_POST['Code_tag_campagne'] : $Code_tag_campagne );
        $mf_add['Code_campagne'] = ( isset( $_POST['Code_campagne'] ) ? $_POST['Code_campagne'] : $Code_campagne );
        $retour = $table_a_campagne_tag_campagne->mf_ajouter_2( $mf_add );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_a_campagne_tag_campagne';
            if (!isset($est_charge['tag_campagne']))
            {
                $Code_tag_campagne = ( isset( $_POST['Code_tag_campagne'] ) ?  $_POST['Code_tag_campagne'] : 0 );
            }
            if (!isset($est_charge['campagne']))
            {
                $Code_campagne = ( isset( $_POST['Code_campagne'] ) ?  $_POST['Code_campagne'] : 0 );
            }
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
    if ( $mf_action=="supprimer_a_campagne_tag_campagne" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $Supprimer = round($_POST["Supprimer"]);
        if ($Supprimer==1)
        {
            $retour = $table_a_campagne_tag_campagne->mf_supprimer($Code_tag_campagne, $Code_campagne);
            if ( $retour['code_erreur']==0 )
            {
                $mf_action = "-";
                $cache->clear();
            }
            else
            {
                $cache->clear_current_page();
            }
        }
        else
        {
            $mf_action = "apercu_a_campagne_tag_campagne";
            $cache->clear_current_page();
        }
    }
