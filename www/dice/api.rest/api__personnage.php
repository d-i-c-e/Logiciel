<?php

include __DIR__ . '/../../../systeme/dice/acces_api_rest/personnage.php';

function get($id, $options)
{
    if ( isset($options['mf_connector_token']) && $options['mf_connector_token']!='' )
    {
        $db = new DB();
        $code = $db -> mf_table(CONNECTEUR_API_TABLE) -> mf_search__colonne(CONNECTEUR_API_COLONNE_TOKEN, $options['mf_connector_token']);
        $r = $db -> mf_table(CONNECTEUR_API_TABLE) -> mf_get($code);
        $totay = substr(get_now(), 0, 10);
        if ( ! ( $code!=0 && $r[CONNECTEUR_API_COLONNE_DATE_START] <= $totay && $totay <= $r[CONNECTEUR_API_COLONNE_DATE_STOP] ) )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
        if ( isset($r['Code_joueur']) )
        {
            global $joueur_courant;
            $joueur_courant = $db -> joueur() -> mf_get_2($r['Code_joueur']);
        }
    }
    else
    {
        if ( API_REST_ACCESS_GET_PERSONNAGE=='none' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
        elseif ( API_REST_ACCESS_GET_PERSONNAGE=='user' )
        {
            $auth = isset($_GET['auth']) ? $_GET['auth'] : 'api';
            if ( $auth=='api' )
            {
                $mf_connexion = new Mf_Connexion(true);
                $mf_token = isset($options['mf_token']) ? $options['mf_token'] : '';
                if ( ! $mf_connexion->est_connecte($mf_token) )
                {
                    return array('code_erreur' => 1); // erreur de connexion
                }
                if ( ! isset($options['code_joueur']) )
                {
                    $options['code_joueur'] = get_joueur_courant('Code_joueur');
                }
            }
            elseif ( $auth=='main' )
            {
                $mf_connexion = new Mf_Connexion();
                if ( isset($_SESSION[PREFIXE_SESSION]['token']) )
                {
                    if ( ! $mf_connexion->est_connecte($_SESSION[PREFIXE_SESSION]['token']) )
                    {
                        unset($_SESSION[PREFIXE_SESSION]['token']);
                    }
                }
                if ( ! isset($_SESSION[PREFIXE_SESSION]['token']) )
                {
                    return array('code_erreur' => 1); // erreur de connexion
                }
            }
        }
        elseif ( API_REST_ACCESS_GET_PERSONNAGE!='all' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
    }

    session_write_close();

    $id = round($id);
    $table_personnage = new personnage();
    if ($id==0)
    {
        $code_joueur = isset($options['code_joueur']) ? $options['code_joueur'] : 0;
        $code_groupe = isset($options['code_groupe']) ? $options['code_groupe'] : 0;
        return array_merge( array_values($table_personnage->mf_lister($code_joueur, $code_groupe, array( 'autocompletion' => true ))), ['code_erreur' => 0] );
    }
    else
    {
        $r = $table_personnage->mf_get($id, array( 'autocompletion' => true ));
        if ( $r===false ) { return array(); } else { return array_merge( array($r), ['code_erreur' => 0] ); }
    }
}

function post($data, $options)
{
    if ( isset($options['mf_connector_token']) && $options['mf_connector_token']!='' )
    {
        $db = new DB();
        $code = $db -> mf_table(CONNECTEUR_API_TABLE) -> mf_search__colonne(CONNECTEUR_API_COLONNE_TOKEN, $options['mf_connector_token']);
        $r = $db -> mf_table(CONNECTEUR_API_TABLE) -> mf_get($code);
        $totay = substr(get_now(), 0, 10);
        if ( ! ( $code!=0 && $r[CONNECTEUR_API_COLONNE_DATE_START] <= $totay && $totay <= $r[CONNECTEUR_API_COLONNE_DATE_STOP] ) )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
        if ( isset($r['Code_joueur']) )
        {
            global $joueur_courant;
            $joueur_courant = $db -> joueur() -> mf_get_2($r['Code_joueur']);
        }
    }
    else
    {
        if ( API_REST_ACCESS_POST_PERSONNAGE=='none' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
        elseif ( API_REST_ACCESS_POST_PERSONNAGE=='user' )
        {
            $auth = isset($_GET['auth']) ? $_GET['auth'] : 'api';
            if ( $auth=='api' )
            {
                $mf_connexion = new Mf_Connexion(true);
                $mf_token = isset($options['mf_token']) ? $options['mf_token'] : '';
                if ( ! $mf_connexion->est_connecte($mf_token) )
                {
                    return array('code_erreur' => 1); // erreur de connexion
                }
                if ( ! isset($options['code_joueur']) )
                {
                    $options['code_joueur'] = get_joueur_courant('Code_joueur');
                }
            }
            elseif ( $auth=='main' )
            {
                $mf_connexion = new Mf_Connexion();
                if ( isset($_SESSION[PREFIXE_SESSION]['token']) )
                {
                    if ( ! $mf_connexion->est_connecte($_SESSION[PREFIXE_SESSION]['token']) )
                    {
                        unset($_SESSION[PREFIXE_SESSION]['token']);
                    }
                }
                if ( ! isset($_SESSION[PREFIXE_SESSION]['token']) )
                {
                    return array('code_erreur' => 1); // erreur de connexion
                }
            }
        }
        elseif ( API_REST_ACCESS_POST_PERSONNAGE!='all' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
    }

    session_write_close();

    $table_personnage = new personnage();
    if ( is_array(current($data)) )
    {
        $liste_Code_personnage = $table_personnage->mf_liste_Code_personnage( ( isset($options['code_joueur']) ? $options['code_joueur'] : 0 ), ( isset($options['code_groupe']) ? $options['code_groupe'] : 0 ) );
        $retour = $table_personnage -> mf_supprimer_2($liste_Code_personnage);
        if ( $retour['code_erreur']==0 )
        {
            foreach ( $data as $value )
            {
                if (isset($options['code_joueur'])) $value['Code_joueur'] = $options['code_joueur'];
                if (isset($options['code_groupe'])) $value['Code_groupe'] = $options['code_groupe'];
                if (isset($value['personnage_Fichier_Fichier']))
                {
                    $fichier = new Fichier();
                    $value['personnage_Fichier_Fichier'] = $fichier->set( base64_decode( $value['personnage_Fichier_Fichier'] ) );
                }
                $retour = $table_personnage->mf_ajouter_2($value);
                unset($retour['Code_personnage']);
                if ( $retour['code_erreur']!=0 )
                {
                    return $retour;
                }
            }
        }
    }
    else
    {
        if (isset($options['code_joueur'])) $data['Code_joueur'] = $options['code_joueur'];
        if (isset($options['code_groupe'])) $data['Code_groupe'] = $options['code_groupe'];
        if (isset($data['personnage_Fichier_Fichier']))
        {
            $fichier = new Fichier();
            $data['personnage_Fichier_Fichier'] = $fichier->set( base64_decode( $data['personnage_Fichier_Fichier'] ) );
        }
        if ( $retour['Code_personnage'] = $table_personnage->mf_search($data) )
        {
            $retour['code_erreur'] = 0;
            $table_personnage->mf_modifier_2([$retour['Code_personnage']=>$data]);
            $retour['callback'] = Hook_personnage::callback_post($retour['Code_personnage']);
        }
        else
        {
            $retour = $table_personnage->mf_ajouter_2($data);
        }
        $retour['id'] = ( $retour['Code_personnage']!=0 ? $retour['Code_personnage'] : '' );
        unset($retour['Code_personnage']);
    }
    return $retour;
}

function put($id, $data, $options)
{
    if ( isset($options['mf_connector_token']) && $options['mf_connector_token']!='' )
    {
        $db = new DB();
        $code = $db -> mf_table(CONNECTEUR_API_TABLE) -> mf_search__colonne(CONNECTEUR_API_COLONNE_TOKEN, $options['mf_connector_token']);
        $r = $db -> mf_table(CONNECTEUR_API_TABLE) -> mf_get($code);
        $totay = substr(get_now(), 0, 10);
        if ( ! ( $code!=0 && $r[CONNECTEUR_API_COLONNE_DATE_START] <= $totay && $totay <= $r[CONNECTEUR_API_COLONNE_DATE_STOP] ) )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
        if ( isset($r['Code_joueur']) )
        {
            global $joueur_courant;
            $joueur_courant = $db -> joueur() -> mf_get_2($r['Code_joueur']);
        }
    }
    else
    {
        if ( API_REST_ACCESS_PUT_PERSONNAGE=='none' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
        elseif ( API_REST_ACCESS_PUT_PERSONNAGE=='user' )
        {
            $auth = isset($_GET['auth']) ? $_GET['auth'] : 'api';
            if ( $auth=='api' )
            {
                $mf_connexion = new Mf_Connexion(true);
                $mf_token = isset($options['mf_token']) ? $options['mf_token'] : '';
                if ( ! $mf_connexion->est_connecte($mf_token) )
                {
                    return array('code_erreur' => 1); // erreur de connexion
                }
                if ( ! isset($options['code_joueur']) )
                {
                    $options['code_joueur'] = get_joueur_courant('Code_joueur');
                }
            }
            elseif ( $auth=='main' )
            {
                $mf_connexion = new Mf_Connexion();
                if ( isset($_SESSION[PREFIXE_SESSION]['token']) )
                {
                    if ( ! $mf_connexion->est_connecte($_SESSION[PREFIXE_SESSION]['token']) )
                    {
                        unset($_SESSION[PREFIXE_SESSION]['token']);
                    }
                }
                if ( ! isset($_SESSION[PREFIXE_SESSION]['token']) )
                {
                    return array('code_erreur' => 1); // erreur de connexion
                }
            }
        }
        elseif ( API_REST_ACCESS_PUT_PERSONNAGE!='all' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
    }

    session_write_close();

    $table_personnage = new personnage();
    return $table_personnage->mf_modifier_2([$id=>$data]);
}

function delete($id, $options)
{
    if ( isset($options['mf_connector_token']) && $options['mf_connector_token']!='' )
    {
        $db = new DB();
        $code = $db -> mf_table(CONNECTEUR_API_TABLE) -> mf_search__colonne(CONNECTEUR_API_COLONNE_TOKEN, $options['mf_connector_token']);
        $r = $db -> mf_table(CONNECTEUR_API_TABLE) -> mf_get($code);
        $totay = substr(get_now(), 0, 10);
        if ( ! ( $code!=0 && $r[CONNECTEUR_API_COLONNE_DATE_START] <= $totay && $totay <= $r[CONNECTEUR_API_COLONNE_DATE_STOP] ) )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
        if ( isset($r['Code_joueur']) )
        {
            global $joueur_courant;
            $joueur_courant = $db -> joueur() -> mf_get_2($r['Code_joueur']);
        }
    }
    else
    {
        if ( API_REST_ACCESS_DELETE_PERSONNAGE=='none' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
        elseif ( API_REST_ACCESS_DELETE_PERSONNAGE=='user' )
        {
            $auth = isset($_GET['auth']) ? $_GET['auth'] : 'api';
            if ( $auth=='api' )
            {
                $mf_connexion = new Mf_Connexion(true);
                $mf_token = isset($options['mf_token']) ? $options['mf_token'] : '';
                if ( ! $mf_connexion->est_connecte($mf_token) )
                {
                    return array('code_erreur' => 1); // erreur de connexion
                }
                if ( ! isset($options['code_joueur']) )
                {
                    $options['code_joueur'] = get_joueur_courant('Code_joueur');
                }
            }
            elseif ( $auth=='main' )
            {
                $mf_connexion = new Mf_Connexion();
                if ( isset($_SESSION[PREFIXE_SESSION]['token']) )
                {
                    if ( ! $mf_connexion->est_connecte($_SESSION[PREFIXE_SESSION]['token']) )
                    {
                        unset($_SESSION[PREFIXE_SESSION]['token']);
                    }
                }
                if ( ! isset($_SESSION[PREFIXE_SESSION]['token']) )
                {
                    return array('code_erreur' => 1); // erreur de connexion
                }
            }
        }
        elseif ( API_REST_ACCESS_DELETE_PERSONNAGE!='all' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
    }

    session_write_close();

    if ( $id!='' )
    {
        $table_personnage = new personnage();
        return $table_personnage->mf_supprimer($id);
    }
    else
    {
        $table_personnage = new personnage();
        $Code_joueur = ( isset($options['code_joueur']) ? $options['code_joueur'] : 0 );
        $Code_groupe = ( isset($options['code_groupe']) ? $options['code_groupe'] : 0 );
        $liste_personnage = $table_personnage->mf_lister($Code_joueur, $Code_groupe, array( 'autocompletion' => false ));
        return $table_personnage->mf_supprimer_2(lister_cles($liste_personnage));
    }
}

function options($id, $options)
{
    if ( isset($options['mf_connector_token']) && $options['mf_connector_token']!='' )
    {
        $db = new DB();
        $code = $db -> mf_table(CONNECTEUR_API_TABLE) -> mf_search__colonne(CONNECTEUR_API_COLONNE_TOKEN, $options['mf_connector_token']);
        $r = $db -> mf_table(CONNECTEUR_API_TABLE) -> mf_get($code);
        $totay = substr(get_now(), 0, 10);
        if ( ! ( $code!=0 && $r[CONNECTEUR_API_COLONNE_DATE_START] <= $totay && $totay <= $r[CONNECTEUR_API_COLONNE_DATE_STOP] ) )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
        if ( isset($r['Code_joueur']) )
        {
            global $joueur_courant;
            $joueur_courant = $db -> joueur() -> mf_get_2($r['Code_joueur']);
        }
    }
    else
    {
        if ( API_REST_ACCESS_OPTIONS_PERSONNAGE=='none' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
        elseif ( API_REST_ACCESS_OPTIONS_PERSONNAGE=='user' )
        {
            $auth = isset($_GET['auth']) ? $_GET['auth'] : 'api';
            if ( $auth=='api' )
            {
                $mf_connexion = new Mf_Connexion(true);
                $mf_token = isset($options['mf_token']) ? $options['mf_token'] : '';
                if ( ! $mf_connexion->est_connecte($mf_token) )
                {
                    return array('code_erreur' => 1); // erreur de connexion
                }
                if ( ! isset($options['code_joueur']) )
                {
                    $options['code_joueur'] = get_joueur_courant('Code_joueur');
                }
            }
            elseif ( $auth=='main' )
            {
                $mf_connexion = new Mf_Connexion();
                if ( isset($_SESSION[PREFIXE_SESSION]['token']) )
                {
                    if ( ! $mf_connexion->est_connecte($_SESSION[PREFIXE_SESSION]['token']) )
                    {
                        unset($_SESSION[PREFIXE_SESSION]['token']);
                    }
                }
                if ( ! isset($_SESSION[PREFIXE_SESSION]['token']) )
                {
                    return array('code_erreur' => 1); // erreur de connexion
                }
            }
        }
        elseif ( API_REST_ACCESS_OPTIONS_PERSONNAGE!='all' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
    }

    session_write_close();

    $id = round($id);
    $table_personnage = new personnage();
    $code_joueur = isset($options['code_joueur']) ? $options['code_joueur'] : 0;
    $code_groupe = isset($options['code_groupe']) ? $options['code_groupe'] : 0;
    Hook_personnage::hook_actualiser_les_droits_ajouter($code_joueur, $code_groupe);
    Hook_personnage::hook_actualiser_les_droits_modifier($id);
    Hook_personnage::hook_actualiser_les_droits_supprimer($id);
    $authorization = array();
    global $mf_droits_defaut;
    $authorization['POST'] = $mf_droits_defaut['personnage__AJOUTER'];
    $authorization['PUT'] = $mf_droits_defaut['personnage__MODIFIER'];
    $authorization['PUT:personnage_Fichier_Fichier'] = $mf_droits_defaut['api_modifier__personnage_Fichier_Fichier'];
    $authorization['PUT:personnage_Conservation'] = $mf_droits_defaut['api_modifier__personnage_Conservation'];
    $authorization['PUT:Code_joueur'] = $mf_droits_defaut['api_modifier__Code_joueur'];
    $authorization['PUT:Code_groupe'] = $mf_droits_defaut['api_modifier__Code_groupe'];
    $authorization['DELETE'] = $mf_droits_defaut['personnage__SUPPRIMER'];
    return array('code_erreur' => 0, 'authorization' => $authorization);
}
