<?php

    $time_start = microtime(true);

    include __DIR__ . '/../../../../systeme/dice/api_espace_privee.php';

    session_write_close();

    $table_liste_contacts = new liste_contacts();

/*
    +------------+
    |  Modifier  |
    +------------+
*/
    $Code_liste_contacts = lecture_parametre_api("Code_liste_contacts", 0 );
    $champs = array();
    if ( isset_parametre_api("liste_contacts_Nom") ) $champs['liste_contacts_Nom'] = lecture_parametre_api("liste_contacts_Nom");
    if ( isset_parametre_api("Code_joueur") ) $champs['Code_joueur'] = lecture_parametre_api("Code_joueur");
    $retour = $table_liste_contacts->mf_modifier_2( array( $Code_liste_contacts => $champs ) );
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
