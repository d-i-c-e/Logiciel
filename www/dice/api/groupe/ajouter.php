<?php

    $time_start = microtime(true);

    include __DIR__ . '/../../../../systeme/dice/api_espace_privee.php';

    session_write_close();

    $table_groupe = new groupe();

/*
    +-----------+
    |  Ajouter  |
    +-----------+
*/
    $groupe_Nom = lecture_parametre_api("groupe_Nom", '');
    $groupe_Description = lecture_parametre_api("groupe_Description", '');
    $groupe_Logo_Fichier = lecture_parametre_api("groupe_Logo_Fichier", '');
    $groupe_Effectif = lecture_parametre_api("groupe_Effectif", '');
    $groupe_Actif = lecture_parametre_api("groupe_Actif", '');
    $groupe_Date_creation = lecture_parametre_api("groupe_Date_creation", '');
    $groupe_Delai_suppression_jour = lecture_parametre_api("groupe_Delai_suppression_jour", '');
    $groupe_Suppression_active = lecture_parametre_api("groupe_Suppression_active", '');
    $Code_campagne = lecture_parametre_api("Code_campagne", 0);
    $retour = $table_groupe->mf_ajouter($groupe_Nom, $groupe_Description, $groupe_Logo_Fichier, $groupe_Effectif, $groupe_Actif, $groupe_Date_creation, $groupe_Delai_suppression_jour, $groupe_Suppression_active, $Code_campagne);
    if ( $retour['code_erreur']==0 )
    {
        $cache = new Cachehtml();
        $cache->clear();
    }
    $retour_json = [];
    $retour_json['code_erreur'] = $retour['code_erreur'];
    $retour_json['message_erreur'] = ( (isset($retour) && $retour['code_erreur']>0) ? (isset($mf_libelle_erreur[$retour['code_erreur']]) ? $mf_libelle_erreur[$retour['code_erreur']] : 'ERREUR N_'.$retour['code_erreur'] ) : '' );
    $retour_json['Code_groupe'] = $retour['Code_groupe'];
    fermeture_connexion_db();
    $time_end = microtime(true);
    $retour_json['duree'] = round( $time_end-$time_start, 4 );
    vue_api_echo( $retour_json );
