<?php

    $est_charge['a_ressource_tag_ressource'] = 1;

    if (!isset($lang_standard['Code_tag_ressource_']))
    {
        $lang_standard['Code_tag_ressource_'] = array();
        $table_tag_ressource = new tag_ressource();
        $liste = $table_tag_ressource->mf_lister_contexte();
        foreach ($liste as $code => $value)
        {
            $lang_standard['Code_tag_ressource_'][$code] = get_titre_ligne_table('tag_ressource', $value);
        }
    }
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
    if ( $mf_action=='ajouter_a_ressource_tag_ressource' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $mf_add = [];
        $mf_add['Code_tag_ressource'] = ( isset( $_POST['Code_tag_ressource'] ) ? $_POST['Code_tag_ressource'] : $Code_tag_ressource );
        $mf_add['Code_ressource'] = ( isset( $_POST['Code_ressource'] ) ? $_POST['Code_ressource'] : $Code_ressource );
        $retour = $table_a_ressource_tag_ressource->mf_ajouter_2( $mf_add );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_a_ressource_tag_ressource';
            if (!isset($est_charge['tag_ressource']))
            {
                $Code_tag_ressource = ( isset( $_POST['Code_tag_ressource'] ) ?  $_POST['Code_tag_ressource'] : 0 );
            }
            if (!isset($est_charge['ressource']))
            {
                $Code_ressource = ( isset( $_POST['Code_ressource'] ) ?  $_POST['Code_ressource'] : 0 );
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
    if ( $mf_action=="supprimer_a_ressource_tag_ressource" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $Supprimer = round($_POST["Supprimer"]);
        if ($Supprimer==1)
        {
            $retour = $table_a_ressource_tag_ressource->mf_supprimer($Code_tag_ressource, $Code_ressource);
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
            $mf_action = "apercu_a_ressource_tag_ressource";
            $cache->clear_current_page();
        }
    }
