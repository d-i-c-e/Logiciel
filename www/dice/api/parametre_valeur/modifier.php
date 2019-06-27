<?php

    $time_start = microtime(true);

    include __DIR__ . '/../../../../systeme/dice/api_espace_privee.php';

    session_write_close();

    $table_parametre_valeur = new parametre_valeur();

/*
    +------------+
    |  Modifier  |
    +------------+
*/
    $Code_parametre_valeur = lecture_parametre_api("Code_parametre_valeur", 0 );
    $champs = array();
    if ( isset_parametre_api("parametre_valeur_Libelle") ) $champs['parametre_valeur_Libelle'] = lecture_parametre_api("parametre_valeur_Libelle");
    if ( isset_parametre_api("Code_parametre") ) $champs['Code_parametre'] = lecture_parametre_api("Code_parametre");
    $retour = $table_parametre_valeur->mf_modifier_2( array( $Code_parametre_valeur => $champs ) );
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
