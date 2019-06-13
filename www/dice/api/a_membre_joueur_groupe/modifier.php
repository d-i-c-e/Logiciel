<?php

    $time_start = microtime(true);

    include __DIR__ . '/../../../../systeme/dice/api_espace_privee.php';

    session_write_close();

    $table_a_membre_joueur_groupe = new a_membre_joueur_groupe();

/*
    +------------+
    |  Modifier  |
    +------------+
*/
    $Code_groupe = lecture_parametre_api("Code_groupe", 0 );
    $Code_joueur = lecture_parametre_api("Code_joueur", $joueur_courant['Code_joueur'] );
    $champs = array('Code_groupe'=>$Code_groupe, 'Code_joueur'=>$Code_joueur);
    if ( isset_parametre_api("a_membre_joueur_groupe_Surnom") ) $champs['a_membre_joueur_groupe_Surnom'] = lecture_parametre_api("a_membre_joueur_groupe_Surnom");
    if ( isset_parametre_api("a_membre_joueur_groupe_Grade") ) $champs['a_membre_joueur_groupe_Grade'] = lecture_parametre_api("a_membre_joueur_groupe_Grade");
    if ( isset_parametre_api("a_membre_joueur_groupe_Date_adhesion") ) $champs['a_membre_joueur_groupe_Date_adhesion'] = lecture_parametre_api("a_membre_joueur_groupe_Date_adhesion");
    $retour = $table_a_membre_joueur_groupe->mf_modifier_2( array($champs) );
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
