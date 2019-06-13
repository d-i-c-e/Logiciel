<?php

    $time_start = microtime(true);

    include __DIR__ . '/../../../../systeme/dice/api_espace_privee.php';

    session_write_close();

    $table_carte = new carte();

/*
    +----------+
    |  Lister  |
    +----------+
*/
    $Code_groupe = lecture_parametre_api("Code_groupe", 0 );
    $retour_json = [];
    $retour_json['liste'] = $table_carte->mf_lister($Code_groupe, array( 'autocompletion' => true ));
    fermeture_connexion_db();
    $time_end = microtime(true);
    $retour_json['duree'] = round( $time_end-$time_start, 4 );
    vue_api_echo( $retour_json );
