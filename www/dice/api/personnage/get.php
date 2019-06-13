<?php

    $time_start = microtime(true);

    include __DIR__ . '/../../../../systeme/dice/api_espace_privee.php';

    session_write_close();

    $table_personnage = new personnage();

/*
    +-------+
    |  Get  |
    +-------+
*/
    $Code_personnage = lecture_parametre_api("Code_personnage", 0);
    $retour_json = [];
    $retour_json['get'] = $table_personnage->mf_get( $Code_personnage, array( 'autocompletion' => true ));
    fermeture_connexion_db();
    $time_end = microtime(true);
    $retour_json['duree'] = round( $time_end-$time_start, 4 );
    vue_api_echo( $retour_json );
