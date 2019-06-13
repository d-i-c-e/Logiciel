<?php

    $time_start = microtime(true);

    include __DIR__ . '/../../../../systeme/dice/api_espace_privee.php';

    session_write_close();

    $table_message = new message();

/*
    +----------+
    |  Lister  |
    +----------+
*/
    $Code_messagerie = lecture_parametre_api("Code_messagerie", 0 );
    $Code_joueur = lecture_parametre_api("Code_joueur", $joueur_courant['Code_joueur'] );
    $retour_json = [];
    $retour_json['liste'] = $table_message->mf_lister($Code_messagerie, $Code_joueur, array( 'autocompletion' => true ));
    fermeture_connexion_db();
    $time_end = microtime(true);
    $retour_json['duree'] = round( $time_end-$time_start, 4 );
    vue_api_echo( $retour_json );
