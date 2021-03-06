<?php

    $time_start = microtime(true);

    include __DIR__ . '/../../../../systeme/dice/api_espace_privee.php';

    session_write_close();

    $table_a_carte_objet = new a_carte_objet();

/*
    +----------+
    |  Lister  |
    +----------+
*/
    $Code_carte = lecture_parametre_api("Code_carte", 0 );
    $Code_objet = lecture_parametre_api("Code_objet", 0 );
    $retour_json = [];
    $retour_json['liste'] = $table_a_carte_objet->mf_lister($Code_carte, $Code_objet, array( 'autocompletion' => true ));
    fermeture_connexion_db();
    $time_end = microtime(true);
    $retour_json['duree'] = round( $time_end-$time_start, 4 );
    vue_api_echo( $retour_json );
