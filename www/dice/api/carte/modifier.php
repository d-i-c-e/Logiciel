<?php

    $time_start = microtime(true);

    include __DIR__ . '/../../../../systeme/dice/api_espace_privee.php';

    session_write_close();

    $table_carte = new carte();

/*
    +------------+
    |  Modifier  |
    +------------+
*/
    $Code_carte = lecture_parametre_api("Code_carte", 0 );
    $champs = array();
    if ( isset_parametre_api("carte_Nom") ) $champs['carte_Nom'] = lecture_parametre_api("carte_Nom");
    if ( isset_parametre_api("carte_Hauteur") ) $champs['carte_Hauteur'] = lecture_parametre_api("carte_Hauteur");
    if ( isset_parametre_api("carte_Largeur") ) $champs['carte_Largeur'] = lecture_parametre_api("carte_Largeur");
    if ( isset_parametre_api("carte_Fichier") ) $champs['carte_Fichier'] = lecture_parametre_api("carte_Fichier");
    if ( isset_parametre_api("Code_groupe") ) $champs['Code_groupe'] = lecture_parametre_api("Code_groupe");
    $retour = $table_carte->mf_modifier_2( array( $Code_carte => $champs ) );
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
