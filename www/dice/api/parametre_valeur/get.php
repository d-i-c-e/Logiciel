<?php

    $time_start = microtime(true);

    include __DIR__ . '/../../../../systeme/dice/api_espace_privee.php';

    session_write_close();

    $table_parametre_valeur = new parametre_valeur();

/*
    +-------+
    |  Get  |
    +-------+
*/
    $Code_parametre_valeur = lecture_parametre_api("Code_parametre_valeur", 0);
    $retour_json = [];
    $retour_json['get'] = $table_parametre_valeur->mf_get( $Code_parametre_valeur, array( 'autocompletion' => true ));
    fermeture_connexion_db();
    $time_end = microtime(true);
    $retour_json['duree'] = round( $time_end-$time_start, 4 );
    vue_api_echo( $retour_json );
