<?php

    $time_start = microtime(true);

    include __DIR__ . '/../../../../systeme/dice/api_espace_privee.php';

    session_write_close();

    $table_objet = new objet();

/*
    +-----------+
    |  Ajouter  |
    +-----------+
*/
    $objet_Libelle = lecture_parametre_api("objet_Libelle", '');
    $objet_Image_Fichier = lecture_parametre_api("objet_Image_Fichier", '');
    $Code_type = lecture_parametre_api("Code_type", 0);
    $retour = $table_objet->mf_ajouter($objet_Libelle, $objet_Image_Fichier, $Code_type);
    if ( $retour['code_erreur']==0 )
    {
        $cache = new Cachehtml();
        $cache->clear();
    }
    $retour_json = [];
    $retour_json['code_erreur'] = $retour['code_erreur'];
    $retour_json['message_erreur'] = ( (isset($retour) && $retour['code_erreur']>0) ? (isset($mf_libelle_erreur[$retour['code_erreur']]) ? $mf_libelle_erreur[$retour['code_erreur']] : 'ERREUR N_'.$retour['code_erreur'] ) : '' );
    $retour_json['Code_objet'] = $retour['Code_objet'];
    fermeture_connexion_db();
    $time_end = microtime(true);
    $retour_json['duree'] = round( $time_end-$time_start, 4 );
    vue_api_echo( $retour_json );
