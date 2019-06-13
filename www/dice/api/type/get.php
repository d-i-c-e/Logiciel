<?php

    $time_start = microtime(true);

    include __DIR__ . '/../../../../systeme/dice/api_espace_privee.php';

    session_write_close();

    $table_type = new type();

/*
    +-------+
    |  Get  |
    +-------+
*/
    $Code_type = lecture_parametre_api("Code_type", 0);
    $retour_json = [];
    $retour_json['get'] = $table_type->mf_get( $Code_type, array( 'autocompletion' => true ));
    fermeture_connexion_db();
    $time_end = microtime(true);
    $retour_json['duree'] = round( $time_end-$time_start, 4 );
    vue_api_echo( $retour_json );
