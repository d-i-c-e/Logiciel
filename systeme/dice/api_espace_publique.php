<?php

include __DIR__ . '/dblayer_light.php';

$mf_token = lecture_parametre_api("mf_token", '');

$retour_json = array('code_erreur' => 0); //pas d'erreur par defaut

if ($mf_token!="")
{
    $mf_connexion = new Mf_Connexion(true);
    if ( ! $mf_connexion->est_connecte($mf_token) )
    {
        $retour_json['code_erreur'] = 1;
        vue_api_echo( $retour_json );
        exit;
    }
}
