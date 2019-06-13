<?php

    $est_charge['a_carte_objet'] = 1;

    if (!isset($lang_standard['Code_carte_']))
    {
        $lang_standard['Code_carte_'] = array();
        $table_carte = new carte();
        $liste = $table_carte->mf_lister_contexte();
        foreach ($liste as $code => $value)
        {
            $lang_standard['Code_carte_'][$code] = get_titre_ligne_table('carte', $value);
        }
    }
    if (!isset($lang_standard['Code_objet_']))
    {
        $lang_standard['Code_objet_'] = array();
        $table_objet = new objet();
        $liste = $table_objet->mf_lister_contexte();
        foreach ($liste as $code => $value)
        {
            $lang_standard['Code_objet_'][$code] = get_titre_ligne_table('objet', $value);
        }
    }

/*
    +-----------+
    |  Ajouter  |
    +-----------+
*/
    if ( $mf_action=='ajouter_a_carte_objet' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $mf_add = [];
        $mf_add['Code_carte'] = ( isset( $_POST['Code_carte'] ) ? $_POST['Code_carte'] : $Code_carte );
        $mf_add['Code_objet'] = ( isset( $_POST['Code_objet'] ) ? $_POST['Code_objet'] : $Code_objet );
        $retour = $table_a_carte_objet->mf_ajouter_2( $mf_add );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_a_carte_objet';
            if (!isset($est_charge['carte']))
            {
                $Code_carte = ( isset( $_POST['Code_carte'] ) ?  $_POST['Code_carte'] : 0 );
            }
            if (!isset($est_charge['objet']))
            {
                $Code_objet = ( isset( $_POST['Code_objet'] ) ?  $_POST['Code_objet'] : 0 );
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
    if ( $mf_action=="supprimer_a_carte_objet" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $Supprimer = round($_POST["Supprimer"]);
        if ($Supprimer==1)
        {
            $retour = $table_a_carte_objet->mf_supprimer($Code_carte, $Code_objet);
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
            $mf_action = "apercu_a_carte_objet";
            $cache->clear_current_page();
        }
    }
