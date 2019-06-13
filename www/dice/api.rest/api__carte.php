<?php

include __DIR__ . '/../../../systeme/dice/acces_api_rest/carte.php';

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
        if ( API_REST_ACCESS_GET_CARTE=='none' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
        elseif ( API_REST_ACCESS_GET_CARTE=='user' )
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
        elseif ( API_REST_ACCESS_GET_CARTE!='all' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
    }

    session_write_close();

    $id = round($id);
    $table_carte = new carte();
    if ($id==0)
    {
        $code_groupe = isset($options['code_groupe']) ? $options['code_groupe'] : 0;
        return array_merge( array_values($table_carte->mf_lister($code_groupe, array( 'autocompletion' => true ))), ['code_erreur' => 0] );
    }
    else
    {
        $r = $table_carte->mf_get($id, array( 'autocompletion' => true ));
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
        if ( API_REST_ACCESS_POST_CARTE=='none' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
        elseif ( API_REST_ACCESS_POST_CARTE=='user' )
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
        elseif ( API_REST_ACCESS_POST_CARTE!='all' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
    }

    session_write_close();

    $table_carte = new carte();
    if ( is_array(current($data)) )
    {
        $liste_Code_carte = $table_carte->mf_liste_Code_carte( ( isset($options['code_groupe']) ? $options['code_groupe'] : 0 ) );
        $retour = $table_carte -> mf_supprimer_2($liste_Code_carte);
        if ( $retour['code_erreur']==0 )
        {
            foreach ( $data as $value )
            {
                if (isset($options['code_groupe'])) $value['Code_groupe'] = $options['code_groupe'];
                if (isset($value['carte_Fichier']))
                {
                    $fichier = new Fichier();
                    $value['carte_Fichier'] = $fichier->set( base64_decode( $value['carte_Fichier'] ) );
                }
                $retour = $table_carte->mf_ajouter_2($value);
                unset($retour['Code_carte']);
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
        if (isset($data['carte_Fichier']))
        {
            $fichier = new Fichier();
            $data['carte_Fichier'] = $fichier->set( base64_decode( $data['carte_Fichier'] ) );
        }
        if ( $retour['Code_carte'] = $table_carte->mf_search($data) )
        {
            $retour['code_erreur'] = 0;
            $table_carte->mf_modifier_2([$retour['Code_carte']=>$data]);
            $retour['callback'] = Hook_carte::callback_post($retour['Code_carte']);
        }
        else
        {
            $retour = $table_carte->mf_ajouter_2($data);
        }
        $retour['id'] = ( $retour['Code_carte']!=0 ? $retour['Code_carte'] : '' );
        unset($retour['Code_carte']);
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
        if ( API_REST_ACCESS_PUT_CARTE=='none' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
        elseif ( API_REST_ACCESS_PUT_CARTE=='user' )
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
        elseif ( API_REST_ACCESS_PUT_CARTE!='all' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
    }

    session_write_close();

    $table_carte = new carte();
    return $table_carte->mf_modifier_2([$id=>$data]);
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
        if ( API_REST_ACCESS_DELETE_CARTE=='none' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
        elseif ( API_REST_ACCESS_DELETE_CARTE=='user' )
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
        elseif ( API_REST_ACCESS_DELETE_CARTE!='all' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
    }

    session_write_close();

    if ( $id!='' )
    {
        $table_carte = new carte();
        return $table_carte->mf_supprimer($id);
    }
    else
    {
        $table_carte = new carte();
        $Code_groupe = ( isset($options['code_groupe']) ? $options['code_groupe'] : 0 );
        $liste_carte = $table_carte->mf_lister($Code_groupe, array( 'autocompletion' => false ));
        return $table_carte->mf_supprimer_2(lister_cles($liste_carte));
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
        if ( API_REST_ACCESS_OPTIONS_CARTE=='none' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
        elseif ( API_REST_ACCESS_OPTIONS_CARTE=='user' )
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
        elseif ( API_REST_ACCESS_OPTIONS_CARTE!='all' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
    }

    session_write_close();

    $id = round($id);
    $table_carte = new carte();
    $code_groupe = isset($options['code_groupe']) ? $options['code_groupe'] : 0;
    Hook_carte::hook_actualiser_les_droits_ajouter($code_groupe);
    Hook_carte::hook_actualiser_les_droits_modifier($id);
    Hook_carte::hook_actualiser_les_droits_supprimer($id);
    $authorization = array();
    global $mf_droits_defaut;
    $authorization['POST'] = $mf_droits_defaut['carte__AJOUTER'];
    $authorization['PUT'] = $mf_droits_defaut['carte__MODIFIER'];
    $authorization['PUT:carte_Nom'] = $mf_droits_defaut['api_modifier__carte_Nom'];
    $authorization['PUT:carte_Hauteur'] = $mf_droits_defaut['api_modifier__carte_Hauteur'];
    $authorization['PUT:carte_Largeur'] = $mf_droits_defaut['api_modifier__carte_Largeur'];
    $authorization['PUT:carte_Fichier'] = $mf_droits_defaut['api_modifier__carte_Fichier'];
    $authorization['PUT:Code_groupe'] = $mf_droits_defaut['api_modifier__Code_groupe'];
    $authorization['DELETE'] = $mf_droits_defaut['carte__SUPPRIMER'];
    return array('code_erreur' => 0, 'authorization' => $authorization);
}
