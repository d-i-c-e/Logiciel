<?php

    $time_start = microtime(true);

    include __DIR__ . '/../../../../systeme/dice/api_espace_privee.php';

    session_write_close();

    $table_joueur = new joueur();

/*
    +------------+
    |  Modifier  |
    +------------+
*/
    $Code_joueur = lecture_parametre_api("Code_joueur", 0 );
    $champs = array();
    if ( isset_parametre_api("joueur_Email") ) $champs['joueur_Email'] = lecture_parametre_api("joueur_Email");
    if ( isset_parametre_api("joueur_Identifiant") ) $champs['joueur_Identifiant'] = lecture_parametre_api("joueur_Identifiant");
    if ( isset_parametre_api("joueur_Avatar_Fichier") ) $champs['joueur_Avatar_Fichier'] = lecture_parametre_api("joueur_Avatar_Fichier");
    if ( isset_parametre_api("joueur_Date_naissance") ) $champs['joueur_Date_naissance'] = lecture_parametre_api("joueur_Date_naissance");
    if ( isset_parametre_api("joueur_Date_inscription") ) $champs['joueur_Date_inscription'] = lecture_parametre_api("joueur_Date_inscription");
    $retour = $table_joueur->mf_modifier_2( array( $Code_joueur => $champs ) );
    if ( $retour['code_erreur']==0 )
    {
        $cache = new Cachehtml();
        $cache->clear();
    }
    $retour_json = [];
    $retour_json['code_erreur'] = $retour['code_erreur'];
    $retour_json['message_erreur'] = ( (isset($retour) && $retour['code_erreur']>0) ? (isset($mf_libelle_erreur[$retour['code_erreur']]) ? $mf_libelle_erreur[$retour['code_erreur']] : 'ERREUR N_'.$retour['code_erreur'] ) : '' );
    fermeture_connexion_db();
    $time_end = microtime(true);
    $retour_json['duree'] = round( $time_end-$time_start, 4 );
    vue_api_echo( $retour_json );
