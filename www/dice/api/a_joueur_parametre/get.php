<?php

    $time_start = microtime(true);

    include __DIR__ . '/../../../../systeme/dice/api_espace_privee.php';

    session_write_close();

    $table_a_joueur_parametre = new a_joueur_parametre();

/*
    +-------+
    |  Get  |
    +-------+
*/
    $Code_joueur = lecture_parametre_api("Code_joueur", $joueur_courant['Code_joueur'] );
    $Code_parametre = lecture_parametre_api("Code_parametre", 0 );
    $retour_json = [];
    $retour_json['get'] = $table_a_joueur_parametre->mf_get($Code_joueur, $Code_parametre, array( 'autocompletion' => true ));
    fermeture_connexion_db();
    $time_end = microtime(true);
    $retour_json['duree'] = round( $time_end-$time_start, 4 );
    vue_api_echo( $retour_json );
