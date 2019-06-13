<?php

    $time_start = microtime(true);

    include __DIR__ . '/../../../../systeme/dice/api_espace_privee.php';

    session_write_close();

    $table_a_liste_contact_joueur = new a_liste_contact_joueur();

/*
    +----------+
    |  Lister  |
    +----------+
*/
    $Code_liste_contacts = lecture_parametre_api("Code_liste_contacts", 0 );
    $Code_joueur = lecture_parametre_api("Code_joueur", $joueur_courant['Code_joueur'] );
    $retour_json = [];
    $retour_json['liste'] = $table_a_liste_contact_joueur->mf_lister($Code_liste_contacts, $Code_joueur, array( 'autocompletion' => true ));
    fermeture_connexion_db();
    $time_end = microtime(true);
    $retour_json['duree'] = round( $time_end-$time_start, 4 );
    vue_api_echo( $retour_json );
