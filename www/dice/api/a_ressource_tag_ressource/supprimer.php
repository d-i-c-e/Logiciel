<?php

    $time_start = microtime(true);

    include __DIR__ . '/../../../../systeme/dice/api_espace_privee.php';

    session_write_close();

    $table_a_ressource_tag_ressource = new a_ressource_tag_ressource();

/*
    +-------------+
    |  Supprimer  |
    +-------------+
*/
    $Code_tag_ressource = lecture_parametre_api("Code_tag_ressource", 0 );
    $Code_ressource = lecture_parametre_api("Code_ressource", 0 );
    $retour = $table_a_ressource_tag_ressource->mf_supprimer($Code_tag_ressource, $Code_ressource);
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
