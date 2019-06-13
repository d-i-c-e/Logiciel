<?php

    $time_start = microtime(true);

    include __DIR__ . '/../../../../systeme/dice/api_espace_privee.php';

    session_write_close();

    $table_campagne = new campagne();

/*
    +------------+
    |  Modifier  |
    +------------+
*/
    $Code_campagne = lecture_parametre_api("Code_campagne", 0 );
    $champs = array();
    if ( isset_parametre_api("campagne_Nom") ) $champs['campagne_Nom'] = lecture_parametre_api("campagne_Nom");
    if ( isset_parametre_api("campagne_Description") ) $champs['campagne_Description'] = lecture_parametre_api("campagne_Description");
    if ( isset_parametre_api("campagne_Image_Fichier") ) $champs['campagne_Image_Fichier'] = lecture_parametre_api("campagne_Image_Fichier");
    if ( isset_parametre_api("campagne_Nombre_joueur") ) $champs['campagne_Nombre_joueur'] = lecture_parametre_api("campagne_Nombre_joueur");
    if ( isset_parametre_api("campagne_Nombre_mj") ) $champs['campagne_Nombre_mj'] = lecture_parametre_api("campagne_Nombre_mj");
    $retour = $table_campagne->mf_modifier_2( array( $Code_campagne => $champs ) );
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
