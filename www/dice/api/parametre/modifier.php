<?php

    $time_start = microtime(true);

    include __DIR__ . '/../../../../systeme/dice/api_espace_privee.php';

    session_write_close();

    $table_parametre = new parametre();

/*
    +------------+
    |  Modifier  |
    +------------+
*/
    $Code_parametre = lecture_parametre_api("Code_parametre", 0 );
    $champs = array();
    if ( isset_parametre_api("parametre_Libelle") ) $champs['parametre_Libelle'] = lecture_parametre_api("parametre_Libelle");
    if ( isset_parametre_api("parametre_Activable") ) $champs['parametre_Activable'] = lecture_parametre_api("parametre_Activable");
    $retour = $table_parametre->mf_modifier_2( array( $Code_parametre => $champs ) );
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
