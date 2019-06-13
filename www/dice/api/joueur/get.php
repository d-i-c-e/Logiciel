<?php

    $time_start = microtime(true);

    include __DIR__ . '/../../../../systeme/dice/api_espace_privee.php';

    session_write_close();

    $table_joueur = new joueur();

/*
    +-------+
    |  Get  |
    +-------+
*/
    $Code_joueur = lecture_parametre_api("Code_joueur", $joueur_courant['Code_joueur']);
    $retour_json = [];
    $retour_json['get'] = $table_joueur->mf_get( $Code_joueur, array( 'autocompletion' => true ));
    unset($retour_json['get']['joueur_Password']);
    fermeture_connexion_db();
    $time_end = microtime(true);
    $retour_json['duree'] = round( $time_end-$time_start, 4 );
    vue_api_echo( $retour_json );
