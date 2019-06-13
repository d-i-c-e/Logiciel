<?php

include __DIR__ . '/../../../systeme/dice/acces_api_rest/a_membre_joueur_groupe.php';

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
        if ( API_REST_ACCESS_GET_A_MEMBRE_JOUEUR_GROUPE=='none' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
        elseif ( API_REST_ACCESS_GET_A_MEMBRE_JOUEUR_GROUPE=='user' )
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
        elseif ( API_REST_ACCESS_GET_A_MEMBRE_JOUEUR_GROUPE!='all' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
    }

    session_write_close();

    $table_a_membre_joueur_groupe = new a_membre_joueur_groupe();
    if ($id!='')
    {
        $table_id = explode('-', $id);
        $code_groupe = isset($table_id[0]) ? $table_id[0] : -1;
        $code_joueur = isset($table_id[1]) ? $table_id[1] : -1;
    }
    else
    {
        $code_groupe = isset($options['code_groupe']) ? $options['code_groupe'] : 0;
        $code_joueur = isset($options['code_joueur']) ? $options['code_joueur'] : 0;
    }
    $l = $table_a_membre_joueur_groupe->mf_lister($code_groupe, $code_joueur, array( 'autocompletion' => true ));
    foreach ($l as $k => &$v)
    {
        $v = array_merge(['Code_a_membre_joueur_groupe'=>$k], $v);
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
        if ( API_REST_ACCESS_POST_A_MEMBRE_JOUEUR_GROUPE=='none' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
        elseif ( API_REST_ACCESS_POST_A_MEMBRE_JOUEUR_GROUPE=='user' )
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
        elseif ( API_REST_ACCESS_POST_A_MEMBRE_JOUEUR_GROUPE!='all' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
    }

    session_write_close();

    $table_a_membre_joueur_groupe = new a_membre_joueur_groupe();
    if ( is_array(current($data)) )
    {
        $retour = $table_a_membre_joueur_groupe -> mf_supprimer( ( isset($options['code_groupe']) ? $options['code_groupe'] : 0 ), ( isset($options['code_joueur']) ? $options['code_joueur'] : 0 ) );
        if ( $retour['code_erreur']==0 )
        {
            foreach ( $data as $value )
            {
                if (isset($options['code_groupe'])) $value['Code_groupe'] = $options['code_groupe'];
                if (isset($options['code_joueur'])) $value['Code_joueur'] = $options['code_joueur'];
                $retour = $table_a_membre_joueur_groupe->mf_ajouter_2($value);
                if ( $retour['code_erreur']!=0 )
                {
                    return $retour;
                }
            }
        }
    }
    else
    {
        if (isset($options['code_groupe'])) $data['Code_groupe'] = $options['code_groupe'];
        if (isset($options['code_joueur'])) $data['Code_joueur'] = $options['code_joueur'];
        $a_membre_joueur_groupe = $table_a_membre_joueur_groupe->mf_get( $data['Code_groupe'], $data['Code_joueur'] );
        if ( isset($a_membre_joueur_groupe['Code_groupe']) )
        {
            $retour['code_erreur'] = 0;
            $table_a_membre_joueur_groupe->mf_modifier_2([$id=>$data]);
            $retour['callback'] = Hook_a_membre_joueur_groupe::callback_post( $data['Code_groupe'], $data['Code_joueur'] );
        }
        else
        {
            $retour = $table_a_membre_joueur_groupe->mf_ajouter_2($data);
        }
        if ( $retour['code_erreur']==0 )
        {
            $retour['id'] = $data['Code_groupe'].'-'.$data['Code_joueur'];
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
        if ( API_REST_ACCESS_PUT_A_MEMBRE_JOUEUR_GROUPE=='none' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
        elseif ( API_REST_ACCESS_PUT_A_MEMBRE_JOUEUR_GROUPE=='user' )
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
        elseif ( API_REST_ACCESS_PUT_A_MEMBRE_JOUEUR_GROUPE!='all' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
    }

    session_write_close();

    $table_a_membre_joueur_groupe = new a_membre_joueur_groupe();
    $codes = explode('-', $id);
    $data['Code_groupe']=$codes[0];
    $data['Code_joueur']=$codes[1];
    return $table_a_membre_joueur_groupe->mf_modifier_2([$data]);
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
        if ( API_REST_ACCESS_DELETE_A_MEMBRE_JOUEUR_GROUPE=='none' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
        elseif ( API_REST_ACCESS_DELETE_A_MEMBRE_JOUEUR_GROUPE=='user' )
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
        elseif ( API_REST_ACCESS_DELETE_A_MEMBRE_JOUEUR_GROUPE!='all' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
    }

    session_write_close();

    if ( $id!='' )
    {
        $table_a_membre_joueur_groupe = new a_membre_joueur_groupe();
        $codes = explode('-', $id);
        return $table_a_membre_joueur_groupe->mf_supprimer((isset($codes[0]) && round($codes[0])!=0 ? $codes[0] : -1), (isset($codes[1]) && round($codes[1])!=0 ? $codes[1] : -1));
    }
    else
    {
        $table_a_membre_joueur_groupe = new a_membre_joueur_groupe();
        $Code_groupe = ( isset($options['code_groupe']) ? $options['code_groupe'] : 0 );
        $Code_joueur = ( isset($options['code_joueur']) ? $options['code_joueur'] : 0 );
        return $table_a_membre_joueur_groupe->mf_supprimer($Code_groupe, $Code_joueur, array( 'autocompletion' => false ));
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
        if ( API_REST_ACCESS_OPTIONS_A_MEMBRE_JOUEUR_GROUPE=='none' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
        elseif ( API_REST_ACCESS_OPTIONS_A_MEMBRE_JOUEUR_GROUPE=='user' )
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
        elseif ( API_REST_ACCESS_OPTIONS_A_MEMBRE_JOUEUR_GROUPE!='all' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
    }

    session_write_close();

    $table_a_membre_joueur_groupe = new a_membre_joueur_groupe();
    if ($id!='')
    {
        $table_id = explode('-', $id);
        $code_groupe = isset($table_id[0]) ? $table_id[0] : -1;
        $code_joueur = isset($table_id[1]) ? $table_id[1] : -1;
    }
    else
    {
        $code_groupe = isset($options['code_groupe']) ? $options['code_groupe'] : 0;
        $code_joueur = isset($options['code_joueur']) ? $options['code_joueur'] : 0;
    }
    Hook_a_membre_joueur_groupe::hook_actualiser_les_droits_ajouter($code_groupe, $code_joueur);
    Hook_a_membre_joueur_groupe::hook_actualiser_les_droits_modifier($code_groupe, $code_joueur);
    Hook_a_membre_joueur_groupe::hook_actualiser_les_droits_supprimer($code_groupe, $code_joueur);
    $authorization = array();
    global $mf_droits_defaut;
    $authorization['POST'] = $mf_droits_defaut['a_membre_joueur_groupe__AJOUTER'];
    $authorization['PUT'] = $mf_droits_defaut['a_membre_joueur_groupe__MODIFIER'];
    $authorization['PUT:a_membre_joueur_groupe_Surnom'] = $mf_droits_defaut['api_modifier__a_membre_joueur_groupe_Surnom'];
    $authorization['PUT:a_membre_joueur_groupe_Grade'] = $mf_droits_defaut['api_modifier__a_membre_joueur_groupe_Grade'];
    $authorization['PUT:a_membre_joueur_groupe_Date_adhesion'] = $mf_droits_defaut['api_modifier__a_membre_joueur_groupe_Date_adhesion'];
    $authorization['DELETE'] = $mf_droits_defaut['a_membre_joueur_groupe__SUPPRIMER'];
    return array('code_erreur' => 0, 'authorization' => $authorization);
}
