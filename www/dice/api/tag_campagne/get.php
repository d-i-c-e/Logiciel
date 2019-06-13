<?php

    $time_start = microtime(true);

    include __DIR__ . '/../../../../systeme/dice/api_espace_privee.php';

    session_write_close();

    $table_tag_campagne = new tag_campagne();

/*
    +-------+
    |  Get  |
    +-------+
*/
    $Code_tag_campagne = lecture_parametre_api("Code_tag_campagne", 0);
    $retour_json = [];
    $retour_json['get'] = $table_tag_campagne->mf_get( $Code_tag_campagne, array( 'autocompletion' => true ));
    fermeture_connexion_db();
    $time_end = microtime(true);
    $retour_json['duree'] = round( $time_end-$time_start, 4 );
    vue_api_echo( $retour_json );
