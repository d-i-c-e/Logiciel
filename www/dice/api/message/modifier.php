<?php

    $time_start = microtime(true);

    include __DIR__ . '/../../../../systeme/dice/api_espace_privee.php';

    session_write_close();

    $table_message = new message();

/*
    +------------+
    |  Modifier  |
    +------------+
*/
    $Code_message = lecture_parametre_api("Code_message", 0 );
    $champs = array();
    if ( isset_parametre_api("message_Texte") ) $champs['message_Texte'] = lecture_parametre_api("message_Texte");
    if ( isset_parametre_api("message_Date") ) $champs['message_Date'] = lecture_parametre_api("message_Date");
    if ( isset_parametre_api("Code_messagerie") ) $champs['Code_messagerie'] = lecture_parametre_api("Code_messagerie");
    if ( isset_parametre_api("Code_joueur") ) $champs['Code_joueur'] = lecture_parametre_api("Code_joueur");
    $retour = $table_message->mf_modifier_2( array( $Code_message => $champs ) );
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
