<?php

    $time_start = microtime(true);

    include __DIR__ . '/../../../../systeme/dice/api_espace_privee.php';

    session_write_close();

    $table_tag_campagne = new tag_campagne();

/*
    +------------+
    |  Modifier  |
    +------------+
*/
    $Code_tag_campagne = lecture_parametre_api("Code_tag_campagne", 0 );
    $champs = array();
    if ( isset_parametre_api("tag_campagne_Libelle") ) $champs['tag_campagne_Libelle'] = lecture_parametre_api("tag_campagne_Libelle");
    $retour = $table_tag_campagne->mf_modifier_2( array( $Code_tag_campagne => $champs ) );
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
