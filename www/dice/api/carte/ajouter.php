<?php

    $time_start = microtime(true);

    include __DIR__ . '/../../../../systeme/dice/api_espace_privee.php';

    session_write_close();

    $table_carte = new carte();

/*
    +-----------+
    |  Ajouter  |
    +-----------+
*/
    $carte_Nom = lecture_parametre_api("carte_Nom", '');
    $carte_Hauteur = lecture_parametre_api("carte_Hauteur", '');
    $carte_Largeur = lecture_parametre_api("carte_Largeur", '');
    $carte_Fichier = lecture_parametre_api("carte_Fichier", '');
    $Code_groupe = lecture_parametre_api("Code_groupe", 0);
    $retour = $table_carte->mf_ajouter($carte_Nom, $carte_Hauteur, $carte_Largeur, $carte_Fichier, $Code_groupe);
    if ( $retour['code_erreur']==0 )
    {
        $cache = new Cachehtml();
        $cache->clear();
    }
    $retour_json = [];
    $retour_json['code_erreur'] = $retour['code_erreur'];
    $retour_json['message_erreur'] = ( (isset($retour) && $retour['code_erreur']>0) ? (isset($mf_libelle_erreur[$retour['code_erreur']]) ? $mf_libelle_erreur[$retour['code_erreur']] : 'ERREUR N_'.$retour['code_erreur'] ) : '' );
    $retour_json['Code_carte'] = $retour['Code_carte'];
    fermeture_connexion_db();
    $time_end = microtime(true);
    $retour_json['duree'] = round( $time_end-$time_start, 4 );
    vue_api_echo( $retour_json );
