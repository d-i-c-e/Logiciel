<?php

    $time_start = microtime(true);

    include __DIR__ . '/../../../../systeme/dice/api_espace_privee.php';

    session_write_close();

    $table_joueur = new joueur();

/*
    +-----------+
    |  Ajouter  |
    +-----------+
*/
    $joueur_Email = lecture_parametre_api("joueur_Email", '');
    $joueur_Identifiant = lecture_parametre_api("joueur_Identifiant", '');
    $joueur_Password = lecture_parametre_api("joueur_Password", '');
    $joueur_Avatar_Fichier = lecture_parametre_api("joueur_Avatar_Fichier", '');
    $joueur_Date_naissance = lecture_parametre_api("joueur_Date_naissance", '');
    $joueur_Date_inscription = lecture_parametre_api("joueur_Date_inscription", '');
    $joueur_Administrateur = lecture_parametre_api("joueur_Administrateur", '');
    $retour = $table_joueur->mf_ajouter($joueur_Email, $joueur_Identifiant, $joueur_Password, $joueur_Avatar_Fichier, $joueur_Date_naissance, $joueur_Date_inscription, $joueur_Administrateur);
    if ( $retour['code_erreur']==0 )
    {
        $cache = new Cachehtml();
        $cache->clear();
    }
    $retour_json = [];
    $retour_json['code_erreur'] = $retour['code_erreur'];
    $retour_json['message_erreur'] = ( (isset($retour) && $retour['code_erreur']>0) ? (isset($mf_libelle_erreur[$retour['code_erreur']]) ? $mf_libelle_erreur[$retour['code_erreur']] : 'ERREUR N_'.$retour['code_erreur'] ) : '' );
    $retour_json['Code_joueur'] = $retour['Code_joueur'];
    fermeture_connexion_db();
    $time_end = microtime(true);
    $retour_json['duree'] = round( $time_end-$time_start, 4 );
    vue_api_echo( $retour_json );
