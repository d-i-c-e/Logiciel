<?php

include __DIR__ . '/../../../systeme/dice/acces_api_rest/a_ressource_tag_ressource.php';

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
        if ( API_REST_ACCESS_GET_A_RESSOURCE_TAG_RESSOURCE=='none' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
        elseif ( API_REST_ACCESS_GET_A_RESSOURCE_TAG_RESSOURCE=='user' )
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
        elseif ( API_REST_ACCESS_GET_A_RESSOURCE_TAG_RESSOURCE!='all' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
    }

    session_write_close();

    $table_a_ressource_tag_ressource = new a_ressource_tag_ressource();
    if ($id!='')
    {
        $table_id = explode('-', $id);
        $code_tag_ressource = isset($table_id[0]) ? $table_id[0] : -1;
        $code_ressource = isset($table_id[1]) ? $table_id[1] : -1;
    }
    else
    {
        $code_tag_ressource = isset($options['code_tag_ressource']) ? $options['code_tag_ressource'] : 0;
        $code_ressource = isset($options['code_ressource']) ? $options['code_ressource'] : 0;
    }
    $l = $table_a_ressource_tag_ressource->mf_lister($code_tag_ressource, $code_ressource, array( 'autocompletion' => true ));
    foreach ($l as $k => &$v)
    {
        $v = array_merge(['Code_a_ressource_tag_ressource'=>$k], $v);
    }
    unset($v);
    $l = array_values($l);
    $l['code_erreur'] = 0;
    return $l;
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
        if ( API_REST_ACCESS_POST_A_RESSOURCE_TAG_RESSOURCE=='none' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
        elseif ( API_REST_ACCESS_POST_A_RESSOURCE_TAG_RESSOURCE=='user' )
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
        elseif ( API_REST_ACCESS_POST_A_RESSOURCE_TAG_RESSOURCE!='all' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
    }

    session_write_close();

    $table_a_ressource_tag_ressource = new a_ressource_tag_ressource();
    if ( is_array(current($data)) )
    {
        $retour = $table_a_ressource_tag_ressource -> mf_supprimer( ( isset($options['code_tag_ressource']) ? $options['code_tag_ressource'] : 0 ), ( isset($options['code_ressource']) ? $options['code_ressource'] : 0 ) );
        if ( $retour['code_erreur']==0 )
        {
            foreach ( $data as $value )
            {
                if (isset($options['code_tag_ressource'])) $value['Code_tag_ressource'] = $options['code_tag_ressource'];
                if (isset($options['code_ressource'])) $value['Code_ressource'] = $options['code_ressource'];
                $retour = $table_a_ressource_tag_ressource->mf_ajouter_2($value);
                if ( $retour['code_erreur']!=0 )
                {
                    return $retour;
                }
            }
        }
    }
    else
    {
        if (isset($options['code_tag_ressource'])) $data['Code_tag_ressource'] = $options['code_tag_ressource'];
        if (isset($options['code_ressource'])) $data['Code_ressource'] = $options['code_ressource'];
        $a_ressource_tag_ressource = $table_a_ressource_tag_ressource->mf_get( $data['Code_tag_ressource'], $data['Code_ressource'] );
        if ( isset($a_ressource_tag_ressource['Code_tag_ressource']) )
        {
            $retour['code_erreur'] = 0;
            $table_a_ressource_tag_ressource->mf_modifier_2([$id=>$data]);
            $retour['callback'] = Hook_a_ressource_tag_ressource::callback_post( $data['Code_tag_ressource'], $data['Code_ressource'] );
        }
        else
        {
            $retour = $table_a_ressource_tag_ressource->mf_ajouter_2($data);
        }
        if ( $retour['code_erreur']==0 )
        {
            $retour['id'] = $data['Code_tag_ressource'].'-'.$data['Code_ressource'];
        }
        else
        {
            $retour['id'] = '';
        }
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
        if ( API_REST_ACCESS_PUT_A_RESSOURCE_TAG_RESSOURCE=='none' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
        elseif ( API_REST_ACCESS_PUT_A_RESSOURCE_TAG_RESSOURCE=='user' )
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
        elseif ( API_REST_ACCESS_PUT_A_RESSOURCE_TAG_RESSOURCE!='all' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
    }

    session_write_close();

    return array('code_erreur'=>0);
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
        if ( API_REST_ACCESS_DELETE_A_RESSOURCE_TAG_RESSOURCE=='none' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
        elseif ( API_REST_ACCESS_DELETE_A_RESSOURCE_TAG_RESSOURCE=='user' )
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
        elseif ( API_REST_ACCESS_DELETE_A_RESSOURCE_TAG_RESSOURCE!='all' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
    }

    session_write_close();

    if ( $id!='' )
    {
        $table_a_ressource_tag_ressource = new a_ressource_tag_ressource();
        $codes = explode('-', $id);
        return $table_a_ressource_tag_ressource->mf_supprimer((isset($codes[0]) && round($codes[0])!=0 ? $codes[0] : -1), (isset($codes[1]) && round($codes[1])!=0 ? $codes[1] : -1));
    }
    else
    {
        $table_a_ressource_tag_ressource = new a_ressource_tag_ressource();
        $Code_tag_ressource = ( isset($options['code_tag_ressource']) ? $options['code_tag_ressource'] : 0 );
        $Code_ressource = ( isset($options['code_ressource']) ? $options['code_ressource'] : 0 );
        return $table_a_ressource_tag_ressource->mf_supprimer($Code_tag_ressource, $Code_ressource, array( 'autocompletion' => false ));
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
        if ( API_REST_ACCESS_OPTIONS_A_RESSOURCE_TAG_RESSOURCE=='none' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
        elseif ( API_REST_ACCESS_OPTIONS_A_RESSOURCE_TAG_RESSOURCE=='user' )
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
        elseif ( API_REST_ACCESS_OPTIONS_A_RESSOURCE_TAG_RESSOURCE!='all' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
    }

    session_write_close();

    $table_a_ressource_tag_ressource = new a_ressource_tag_ressource();
    if ($id!='')
    {
        $table_id = explode('-', $id);
        $code_tag_ressource = isset($table_id[0]) ? $table_id[0] : -1;
        $code_ressource = isset($table_id[1]) ? $table_id[1] : -1;
    }
    else
    {
        $code_tag_ressource = isset($options['code_tag_ressource']) ? $options['code_tag_ressource'] : 0;
        $code_ressource = isset($options['code_ressource']) ? $options['code_ressource'] : 0;
    }
    Hook_a_ressource_tag_ressource::hook_actualiser_les_droits_ajouter($code_tag_ressource, $code_ressource);
    Hook_a_ressource_tag_ressource::hook_actualiser_les_droits_modifier($code_tag_ressource, $code_ressource);
    Hook_a_ressource_tag_ressource::hook_actualiser_les_droits_supprimer($code_tag_ressource, $code_ressource);
    $authorization = array();
    global $mf_droits_defaut;
    $authorization['POST'] = $mf_droits_defaut['a_ressource_tag_ressource__AJOUTER'];
    $authorization['PUT'] = $mf_droits_defaut['a_ressource_tag_ressource__MODIFIER'];
    $authorization['DELETE'] = $mf_droits_defaut['a_ressource_tag_ressource__SUPPRIMER'];
    return array('code_erreur' => 0, 'authorization' => $authorization);
}
