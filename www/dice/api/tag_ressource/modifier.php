<?php

    $time_start = microtime(true);

    include __DIR__ . '/../../../../systeme/dice/api_espace_privee.php';

    session_write_close();

    $table_tag_ressource = new tag_ressource();

/*
    +------------+
    |  Modifier  |
    +------------+
*/
    $Code_tag_ressource = lecture_parametre_api("Code_tag_ressource", 0 );
    $champs = array();
    if ( isset_parametre_api("tag_ressource_Libelle") ) $champs['tag_ressource_Libelle'] = lecture_parametre_api("tag_ressource_Libelle");
    $retour = $table_tag_ressource->mf_modifier_2( array( $Code_tag_ressource => $champs ) );
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
