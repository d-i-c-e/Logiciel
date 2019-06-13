<?php

    $time_start = microtime(true);

    include __DIR__ . '/../../../../systeme/dice/api_espace_privee.php';

    session_write_close();

    $table_groupe = new groupe();

/*
    +------------+
    |  Modifier  |
    +------------+
*/
    $Code_groupe = lecture_parametre_api("Code_groupe", 0 );
    $champs = array();
    if ( isset_parametre_api("groupe_Nom") ) $champs['groupe_Nom'] = lecture_parametre_api("groupe_Nom");
    if ( isset_parametre_api("groupe_Description") ) $champs['groupe_Description'] = lecture_parametre_api("groupe_Description");
    if ( isset_parametre_api("groupe_Logo_Fichier") ) $champs['groupe_Logo_Fichier'] = lecture_parametre_api("groupe_Logo_Fichier");
    if ( isset_parametre_api("groupe_Effectif") ) $champs['groupe_Effectif'] = lecture_parametre_api("groupe_Effectif");
    if ( isset_parametre_api("groupe_Actif") ) $champs['groupe_Actif'] = lecture_parametre_api("groupe_Actif");
    if ( isset_parametre_api("groupe_Date_creation") ) $champs['groupe_Date_creation'] = lecture_parametre_api("groupe_Date_creation");
    if ( isset_parametre_api("groupe_Delai_suppression_jour") ) $champs['groupe_Delai_suppression_jour'] = lecture_parametre_api("groupe_Delai_suppression_jour");
    if ( isset_parametre_api("groupe_Suppression_active") ) $champs['groupe_Suppression_active'] = lecture_parametre_api("groupe_Suppression_active");
    if ( isset_parametre_api("Code_campagne") ) $champs['Code_campagne'] = lecture_parametre_api("Code_campagne");
    $retour = $table_groupe->mf_modifier_2( array( $Code_groupe => $champs ) );
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
