<?php

    $time_start = microtime(true);

    include __DIR__ . '/../../../../systeme/dice/api_espace_privee.php';

    session_write_close();

    $table_a_joueur_parametre = new a_joueur_parametre();

/*
    +------------+
    |  Modifier  |
    +------------+
*/
    $Code_joueur = lecture_parametre_api("Code_joueur", $joueur_courant['Code_joueur'] );
    $Code_parametre = lecture_parametre_api("Code_parametre", 0 );
    $champs = array('Code_joueur'=>$Code_joueur, 'Code_parametre'=>$Code_parametre);
    if ( isset_parametre_api("a_joueur_parametre_Valeur_choisie") ) $champs['a_joueur_parametre_Valeur_choisie'] = lecture_parametre_api("a_joueur_parametre_Valeur_choisie");
    if ( isset_parametre_api("a_joueur_parametre_Actif") ) $champs['a_joueur_parametre_Actif'] = lecture_parametre_api("a_joueur_parametre_Actif");
    $retour = $table_a_joueur_parametre->mf_modifier_2( array($champs) );
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
