<?php

    $time_start = microtime(true);

    include __DIR__ . '/../../../../systeme/dice/api_espace_privee.php';

    session_write_close();

    $table_a_membre_joueur_groupe = new a_membre_joueur_groupe();

/*
    +-----------+
    |  Ajouter  |
    +-----------+
*/
    $Code_groupe = lecture_parametre_api("Code_groupe", 0);
    $Code_joueur = lecture_parametre_api("Code_joueur", $joueur_courant['Code_joueur']);
    $a_membre_joueur_groupe_Surnom = lecture_parametre_api("a_membre_joueur_groupe_Surnom", '');
    $a_membre_joueur_groupe_Grade = lecture_parametre_api("a_membre_joueur_groupe_Grade", '');
    $a_membre_joueur_groupe_Date_adhesion = lecture_parametre_api("a_membre_joueur_groupe_Date_adhesion", '');
    $retour = $table_a_membre_joueur_groupe->mf_ajouter($Code_groupe, $Code_joueur, $a_membre_joueur_groupe_Surnom, $a_membre_joueur_groupe_Grade, $a_membre_joueur_groupe_Date_adhesion);
    if ( $retour['code_erreur']==0 )
    {
        $cache = new Cachehtml();
        $cache->clear();
    }
    $retour_json = [];
    $retour_json['code_erreur'] = $retour['code_erreur'];
    $retour_json['message_erreur'] = ( (isset($retour) && $retour['code_erreur']>0) ? (isset($mf_libelle_erreur[$retour['code_erreur']]) ? $mf_libelle_erreur[$retour['code_erreur']] : 'ERREUR N_'.$retour['code_erreur'] ) : '' );
    fermeture_connexion_db();
    $time_end = microtime(true);
    $retour_json['duree'] = round( $time_end-$time_start, 4 );
    vue_api_echo( $retour_json );
