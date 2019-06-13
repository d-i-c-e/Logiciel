<?php

include __DIR__ . '/../../../systeme/dice/acces_api_rest/type.php';

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
        if ( API_REST_ACCESS_GET_TYPE=='none' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
        elseif ( API_REST_ACCESS_GET_TYPE=='user' )
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
        elseif ( API_REST_ACCESS_GET_TYPE!='all' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
    }

    session_write_close();

    $id = round($id);
    $table_type = new type();
    if ($id==0)
    {
        $code_ressource = isset($options['code_ressource']) ? $options['code_ressource'] : 0;
        return array_merge( array_values($table_type->mf_lister($code_ressource, array( 'autocompletion' => true ))), ['code_erreur' => 0] );
    }
    else
    {
        $r = $table_type->mf_get($id, array( 'autocompletion' => true ));
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
        if ( API_REST_ACCESS_POST_TYPE=='none' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
        elseif ( API_REST_ACCESS_POST_TYPE=='user' )
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
        elseif ( API_REST_ACCESS_POST_TYPE!='all' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
    }

    session_write_close();

    $table_type = new type();
    if ( is_array(current($data)) )
    {
        $liste_Code_type = $table_type->mf_liste_Code_type( ( isset($options['code_ressource']) ? $options['code_ressource'] : 0 ) );
        $retour = $table_type -> mf_supprimer_2($liste_Code_type);
        if ( $retour['code_erreur']==0 )
        {
            foreach ( $data as $value )
            {
                if (isset($options['code_ressource'])) $value['Code_ressource'] = $options['code_ressource'];
                $retour = $table_type->mf_ajouter_2($value);
                unset($retour['Code_type']);
                if ( $retour['code_erreur']!=0 )
                {
                    return $retour;
                }
            }
        }
    }
    else
    {
        if (isset($options['code_ressource'])) $data['Code_ressource'] = $options['code_ressource'];
        if ( $retour['Code_type'] = $table_type->mf_search($data) )
        {
            $retour['code_erreur'] = 0;
            $table_type->mf_modifier_2([$retour['Code_type']=>$data]);
            $retour['callback'] = Hook_type::callback_post($retour['Code_type']);
        }
        else
        {
            $retour = $table_type->mf_ajouter_2($data);
        }
        $retour['id'] = ( $retour['Code_type']!=0 ? $retour['Code_type'] : '' );
        unset($retour['Code_type']);
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
        if ( API_REST_ACCESS_PUT_TYPE=='none' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
        elseif ( API_REST_ACCESS_PUT_TYPE=='user' )
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
        elseif ( API_REST_ACCESS_PUT_TYPE!='all' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
    }

    session_write_close();

    $table_type = new type();
    return $table_type->mf_modifier_2([$id=>$data]);
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
        if ( API_REST_ACCESS_DELETE_TYPE=='none' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
        elseif ( API_REST_ACCESS_DELETE_TYPE=='user' )
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
        elseif ( API_REST_ACCESS_DELETE_TYPE!='all' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
    }

    session_write_close();

    if ( $id!='' )
    {
        $table_type = new type();
        return $table_type->mf_supprimer($id);
    }
    else
    {
        $table_type = new type();
        $Code_ressource = ( isset($options['code_ressource']) ? $options['code_ressource'] : 0 );
        $liste_type = $table_type->mf_lister($Code_ressource, array( 'autocompletion' => false ));
        return $table_type->mf_supprimer_2(lister_cles($liste_type));
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
        if ( API_REST_ACCESS_OPTIONS_TYPE=='none' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
        elseif ( API_REST_ACCESS_OPTIONS_TYPE=='user' )
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
        elseif ( API_REST_ACCESS_OPTIONS_TYPE!='all' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
    }

    session_write_close();

    $id = round($id);
    $table_type = new type();
    $code_ressource = isset($options['code_ressource']) ? $options['code_ressource'] : 0;
    Hook_type::hook_actualiser_les_droits_ajouter($code_ressource);
    Hook_type::hook_actualiser_les_droits_modifier($id);
    Hook_type::hook_actualiser_les_droits_supprimer($id);
    $authorization = array();
    global $mf_droits_defaut;
    $authorization['POST'] = $mf_droits_defaut['type__AJOUTER'];
    $authorization['PUT'] = $mf_droits_defaut['type__MODIFIER'];
    $authorization['PUT:type_Libelle'] = $mf_droits_defaut['api_modifier__type_Libelle'];
    $authorization['PUT:Code_ressource'] = $mf_droits_defaut['api_modifier__Code_ressource'];
    $authorization['DELETE'] = $mf_droits_defaut['type__SUPPRIMER'];
    return array('code_erreur' => 0, 'authorization' => $authorization);
}
