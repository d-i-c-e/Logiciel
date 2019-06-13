<?php

    $time_start = microtime(true);

    include __DIR__ . '/../../../../systeme/dice/api_espace_privee.php';

    session_write_close();

    $table_personnage = new personnage();

/*
    +-----------+
    |  Ajouter  |
    +-----------+
*/
    $personnage_Fichier_Fichier = lecture_parametre_api("personnage_Fichier_Fichier", '');
    $personnage_Conservation = lecture_parametre_api("personnage_Conservation", '');
    $Code_joueur = lecture_parametre_api("Code_joueur", $joueur_courant['Code_joueur']);
    $Code_groupe = lecture_parametre_api("Code_groupe", 0);
    $retour = $table_personnage->mf_ajouter($personnage_Fichier_Fichier, $personnage_Conservation, $Code_joueur, $Code_groupe);
    if ( $retour['code_erreur']==0 )
    {
        $cache = new Cachehtml();
        $cache->clear();
    }
    $retour_json = [];
    $retour_json['code_erreur'] = $retour['code_erreur'];
    $retour_json['message_erreur'] = ( (isset($retour) && $retour['code_erreur']>0) ? (isset($mf_libelle_erreur[$retour['code_erreur']]) ? $mf_libelle_erreur[$retour['code_erreur']] : 'ERREUR N_'.$retour['code_erreur'] ) : '' );
    $retour_json['Code_personnage'] = $retour['Code_personnage'];
    fermeture_connexion_db();
    $time_end = microtime(true);
    $retour_json['duree'] = round( $time_end-$time_start, 4 );
    vue_api_echo( $retour_json );
