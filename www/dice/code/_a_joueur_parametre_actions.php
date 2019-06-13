<?php

    $est_charge['a_joueur_parametre'] = 1;

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
    if ( $mf_action=='ajouter_a_joueur_parametre' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $mf_add = [];
        $mf_add['Code_joueur'] = ( isset( $_POST['Code_joueur'] ) ? $_POST['Code_joueur'] : $Code_joueur );
        $mf_add['Code_parametre'] = ( isset( $_POST['Code_parametre'] ) ? $_POST['Code_parametre'] : $Code_parametre );
        $retour = $table_a_joueur_parametre->mf_ajouter_2( $mf_add );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_a_joueur_parametre';
            if (!isset($est_charge['joueur']))
            {
                $Code_joueur = ( isset( $_POST['Code_joueur'] ) ?  $_POST['Code_joueur'] : 0 );
            }
            if (!isset($est_charge['parametre']))
            {
                $Code_parametre = ( isset( $_POST['Code_parametre'] ) ?  $_POST['Code_parametre'] : 0 );
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
    if ( $mf_action=="supprimer_a_joueur_parametre" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $Supprimer = round($_POST["Supprimer"]);
        if ($Supprimer==1)
        {
            $retour = $table_a_joueur_parametre->mf_supprimer($Code_joueur, $Code_parametre);
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
            $mf_action = "apercu_a_joueur_parametre";
            $cache->clear_current_page();
        }
    }
