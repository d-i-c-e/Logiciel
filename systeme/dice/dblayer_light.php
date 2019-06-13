<?php

    if ( ! session_start() ) { exit; }

    //http://php.net/manual/fr/security.magicquotes.disabling.php
    if (get_magic_quotes_gpc()) {
        $process = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
        while (list($key, $val) = each($process)) {
            foreach ($val as $k => $v) {
                unset($process[$key][$k]);
                if (is_array($v)) {
                    $process[$key][stripslashes($k)] = $v;
                    $process[] = &$process[$key][stripslashes($k)];
                } else {
                    $process[$key][stripslashes($k)] = stripslashes($v);
                }
            }
        }
        unset($process);
    }

    if ($_SERVER['HTTP_HOST']=='localhost')
    {
        include __DIR__ . '/config_localhost.php';
    }
    else
    {
        include __DIR__ . '/config.php';
    }

    include __DIR__ . '/constantes_systeme.php';

    //chargement de l'instance
    $_SESSION[PREFIXE_SESSION]['mf_instance'] = round( isset_parametre_api('mf_instance') ? lecture_parametre_api('mf_instance') : ( isset($_SESSION[PREFIXE_SESSION]['mf_instance']) ? $_SESSION[PREFIXE_SESSION]['mf_instance'] : 0 ) );
    function get_instance() { return $_SESSION[PREFIXE_SESSION]['mf_instance']; }
    $inst=[];
    function inst($table)
    {
        if (TABLE_INSTANCE=='')
        {
            return $table;
        }
        else
        {
            global $inst;
            if ( ! isset($inst[$table]) )
            {
                $inst[$table] = ( TABLE_INSTANCE == $table ? $table : ( get_instance()!=0 ? PREFIXE_DB_INSTANCE.'_'.get_instance().'_'.$table : $table ) );
            }
            return $inst[$table];
        }
    }

    function new_instance()
    {
        $db = new DB();
        $_SESSION[PREFIXE_SESSION]['mf_instance'] = $db -> mf_table(TABLE_INSTANCE) -> mf_get_next_id();
        $r = $db -> mf_table(TABLE_INSTANCE) -> mf_creer(true);
        $_SESSION[PREFIXE_SESSION]['mf_instance'] = $r[ 'Code_' . strtolower(TABLE_INSTANCE) ];
        if ( $_SESSION[PREFIXE_SESSION]['mf_instance']!=0 )
        {
            global $inst;
            $inst = [];
            generer_la_base();
        }
        db::mf_raz_instance();
    }

    $secure_connection = false;
    if (isset($_SERVER['HTTPS']))
    {
        if ($_SERVER['HTTPS'] == 'on')
        {
            $secure_connection = true;
        }
    }
    if ( !$secure_connection && HTTPS_ON )
    {
        header('Location: https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
        exit();
    }

    $_mf_get_adresse_url_base=null;
    function get_adresse_url_base()
    {
        global $_mf_get_adresse_url_base;
        if ( $_mf_get_adresse_url_base===null )
        {
            $racine = ( HTTPS_ON ? 'https://' : 'http://' ) . $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'];
            $p=0; $i=0;
            while ( $i = stripos( $racine , FIN_ADRESSE_RACINE.'/', $i+1 ) ) { $p = $i; }
            $_mf_get_adresse_url_base = substr( $racine , 0 , $p+strlen(FIN_ADRESSE_RACINE.'/') );
        }
        return $_mf_get_adresse_url_base;
    }

    if ( get_adresse_url_base() != ADRESSE_SITE && get_adresse_url_base() != ADRESSE_API )
    {
        header( 'Location: ' . ADRESSE_SITE );
        exit();
    }

    $cle_aleatoire = ''.salt(10); function mf_cle_aleatoire() { global $cle_aleatoire; return $cle_aleatoire; }
    if ( isset($_GET['secur']) )
    {
        $secur = ''.$_GET['secur'];
        if ( $secur!='' )
        {
            if ( ! isset($_SESSION[PREFIXE_SESSION]['valid_form'][$secur]) )
            {
                $_SESSION[PREFIXE_SESSION]['valid_form'][$secur] = $cle_aleatoire;
            }
            else
            {
                $cle_aleatoire = $_SESSION[PREFIXE_SESSION]['valid_form'][$secur];
            }
        }
        if ( isset($_SESSION[PREFIXE_SESSION]['valid_form']) )
        {
            $i = 0;
            $n = count($_SESSION[PREFIXE_SESSION]['valid_form'])-5;
            foreach ( $_SESSION[PREFIXE_SESSION]['valid_form'] as $key => &$value )
            {
                if ( $i<$n )
                {
                    unset( $_SESSION[PREFIXE_SESSION]['valid_form'][$key] );
                }
                $i++;
            }
            unset( $value );
        }
    }

    function get_dossier_data($dossier)
    {
        $dossier_sauvegarde = __DIR__ . '/../../data/';
        if ( ! file_exists($dossier_sauvegarde ) ) { mkdir($dossier_sauvegarde); }
        $dossier_sauvegarde.= NOM_PROJET.'/';
        if ( ! file_exists($dossier_sauvegarde ) ) { mkdir($dossier_sauvegarde); }
        if (TABLE_INSTANCE!='')
        {
            $dossier_sauvegarde.= 'inst_'.get_instance().'/';
            if ( ! file_exists($dossier_sauvegarde ) ) { mkdir($dossier_sauvegarde); }
        }
        $dossier_sauvegarde.= $dossier.'/';
        if ( ! file_exists($dossier_sauvegarde ) ) { mkdir($dossier_sauvegarde); }
        return $dossier_sauvegarde;
    }

    $now_microtime = microtime(true); function get_now_microtime() { global $now_microtime; return $now_microtime; } //microtime
    $now = date('Y-m-d H:i:s'); function get_now() { global $now; return $now; } // horloge

    class Autoloader{
        /**
         * Enregistre notre autoloader
         */
        static function register(){
            spl_autoload_register(array(__CLASS__, 'autoload'));
        }
        /**
         * Inclue le fichier correspondant à notre classe
         * @param $class string Le nom de la classe à charger
         */
        static function autoload($class){
            if (substr($class, -13)=='_monframework')
            {
                require __DIR__ . '/tables/monframework/' . substr($class, 0, strlen($class)-13) . '.php';
            }
            elseif (substr($class, 0, 5)=='Hook_')
            {
                require __DIR__ . '/tables/monframework/hooks/' . $class . '.php';
            }
            elseif (file_exists( __DIR__ . '/fonctions/' . strtolower($class) . '.php' ))
            {
                require __DIR__ . '/fonctions/' . strtolower($class) . '.php';
            }
            else
            {
                require __DIR__ . '/tables/' . strtolower($class) . '.php';
            }
        }
    }
    Autoloader::register();

    class Mf_cache_volatil //cache en ram qui dure le temps de l'exécution du script
    {
        private $mf_cache_colatil_var = array();
        private $memory_limit;

        function __construct()
        {
            $this->memory_limit = round( 0.75 * return_bytes( ini_get('memory_limit') ) );
        }

        function is_set($dossier, $cle)
        {
            return ( isset( $this->mf_cache_colatil_var[$dossier][$cle] ) );
        }

        function get($dossier, $cle)
        {
            return $this->mf_cache_colatil_var[$dossier][$cle];
        }

        function set($dossier, $cle, $contenu)
        {
            if ( memory_get_usage() >= $this->memory_limit )
            {
                $this->mf_cache_colatil_var = array();
            }
            $this->mf_cache_colatil_var[$dossier][$cle] = $contenu;
        }

        function clear($dossier)
        {
            if (isset($this->mf_cache_colatil_var[$dossier]))
            {
                unset($this->mf_cache_colatil_var[$dossier]);
            }
        }
    }
    $mf_cache_volatil = new Mf_cache_volatil();

    include __DIR__ . '/cache_systeme.php';

    $lang_standard = array();
    $mf_titre_ligne_table = array();
    $mf_tri_defaut_table = array();
    $mf_initialisation = array();
    $mf_droits_defaut = array();
    $mf_dictionnaire_db = array();
    $mf_libelle_erreur = array();

    function read_variable_systeme()
    {
        global $lang_standard, $mf_titre_ligne_table, $mf_tri_defaut_table, $mf_initialisation, $mf_droits_defaut, $mf_dictionnaire_db, $mf_libelle_erreur;
        $cache_systeme = new Mf_Cache_systeme();
        if (($variables_systeme = $cache_systeme->read('variables_systeme')) && MODE_PROD)
        {
            $lang_standard = $variables_systeme['lang_standard'];
            $mf_titre_ligne_table = $variables_systeme['mf_titre_ligne_table'];
            $mf_tri_defaut_table = $variables_systeme['mf_tri_defaut_table'];
            $mf_initialisation = $variables_systeme['mf_initialisation'];
            $mf_droits_defaut = $variables_systeme['mf_droits_defaut'];
            $mf_dictionnaire_db = $variables_systeme['mf_dictionnaire_db'];
            $mf_libelle_erreur = $variables_systeme['mf_libelle_erreur'];
        }
        else
        {
            $lang_standard = array();
            $mf_titre_ligne_table = array();
            $mf_tri_defaut_table = array();
            $mf_initialisation = array();
            $mf_droits_defaut = array();
            $mf_dictionnaire_db = array();
            $mf_libelle_erreur = array();

            include __DIR__ . '/langues/fr/systeme.php';
            include __DIR__ . '/chargement_variables_systemes.php';
            include __DIR__ . '/tables/monframework/mf_dictionnaire_db.php';

            if (MODE_PROD)
            {
                $cache_systeme->write('variables_systeme', array( 'lang_standard'=>$lang_standard, 'mf_titre_ligne_table'=>$mf_titre_ligne_table, 'mf_tri_defaut_table'=>$mf_tri_defaut_table, 'mf_initialisation'=>$mf_initialisation, 'mf_droits_defaut'=>$mf_droits_defaut, 'mf_dictionnaire_db'=>$mf_dictionnaire_db, 'mf_libelle_erreur'=>$mf_libelle_erreur ));
            }
        }
    }
    read_variable_systeme();

    define('OPTION_COND_MYSQL', 'cond_mysql');
    define('OPTION_TRI', 'tris');
    define('OPTION_LIMIT', 'limit');
    define('OPTION_AUTOCOMPLETION', 'autocompletion');
    define('OPTION_TOUTES_COLONNES', 'toutes_colonnes');
    define('OPTION_MAJ', 'maj');

    include_once __DIR__ . '/tables/entite.php';
    include_once __DIR__ . '/tables/monframework/entite.php';

    include __DIR__ . '/tables/monframework/mf_connexion.php';

    $mf_message_erreur_personalise = '';
    function mf_personaliser_le_message($message_erreur)
    {
        global $mf_message_erreur_personalise;
        $mf_message_erreur_personalise = $message_erreur;
    }

/* Fonctions mysql */

    $link = null; //connexion uniquement si besoin ...

    $sauvegarde_base = true;

    function connexion_db(&$link)
    {
        $link = @mysqli_connect( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT );
        if (mysqli_connect_errno())
        {
            echo '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Connexion à la base de données</title></head><body>Failed to connect to MySQL:' . utf8_encode(mysqli_connect_error()) . '</body></html>';
            exit;
        }
    }

    function executer_requete_mysql($query, $log=true)
    {
        global $link, $now, $sauvegarde_base;
        if ( $link==null )
        {
            connexion_db($link);
        }

        $ln = "\r\n";

        /* sauvegarde de la base de données */
        if ( $sauvegarde_base )
        {
            $adresse_dossier_sauvegarde = get_dossier_data('dump');
            $nom_fichier_sauvegarde = 'db_dump_'.substr($now, 0, 10).'.sql.gz';
            if ( ! file_exists( $adresse_dossier_sauvegarde.$nom_fichier_sauvegarde ) )
            {
                if (DB_PORT!=null)
                {
                    system('mysqldump --host='.DB_HOST.' --user='.DB_USER.' --port='.DB_PORT.' --password='.DB_PASSWORD.' '.DB_NAME.' '.get_liste_dump().' | gzip > '.$adresse_dossier_sauvegarde.$nom_fichier_sauvegarde);
                }
                else
                {
                    system('mysqldump --host='.DB_HOST.' --user='.DB_USER.' --password='.DB_PASSWORD.' '.DB_NAME.' '.get_liste_dump().' | gzip > '.$adresse_dossier_sauvegarde.$nom_fichier_sauvegarde);
                }
            }

            $files = glob($adresse_dossier_sauvegarde.'*');
            foreach ( $files as $file )
            {
                if ( time() - filemtime($file) > DUREE_HISTORIQUE*86400 )
                {
                    $r = unlink($file);
                }
            }

            $sauvegarde_base = false;
        }

        $time_1 = microtime(true);
        $req = mysqli_query($link, $query);
        $time_2 = microtime(true);

        $duree = 1000*round( $time_2-$time_1, 6 );
        $erreur_sql_Num_erreur = round(mysqli_errno( $link ));

        $requete_update = ( $log ? test_requete_update($query) : false );

        $affected_rows = 0;
        $sql_Emplacement = '';

        if ( $requete_update )
        {
            if ( $erreur_sql_Num_erreur==0 || test_requete_system($query) ) /*requete update*/
            {
                $affected_rows = round(mysqli_affected_rows($link));
                if ( $affected_rows>0 || test_requete_system($query) )
                {
                    $debug = debug_backtrace();
                    foreach ($debug as $t) {
                        if ($sql_Emplacement!='') $sql_Emplacement=$ln.'                 '.$sql_Emplacement;
                        $sql_Emplacement = $t['file'].' # '.$t['function'].' (Ligne '.$t['line'].')'.$sql_Emplacement;
                    }
                    $adresse_fichier_log = get_dossier_data('update').'update_'.substr($now, 0, 10).'.sql';
                    $fichier_log = fopen($adresse_fichier_log, 'a+');
                    fputs($fichier_log, '/*'.$ln.identification_log().' Date          : '.$now.$ln.' Duree         : '.$duree.'ms'.$ln.' Affected rows : '.$affected_rows.$ln.' Emplacement   : '.$sql_Emplacement.$ln.' Adresse IP    : '.get_ip().$ln.'*/'.$ln.$query.$ln.$ln);
                    fclose($fichier_log);
                }
            }

            if ( $duree>=100 && $erreur_sql_Num_erreur==0 ) /*requete lente (au dela de 100ms)*/
            {
                if ($sql_Emplacement=='')
                {
                    $debug = debug_backtrace();
                    foreach ($debug as $t) {
                        if ($sql_Emplacement!='') $sql_Emplacement=$ln.'                 '.$sql_Emplacement;
                        $sql_Emplacement = $t['file'].' # '.$t['function'].' (Ligne '.$t['line'].')'.$sql_Emplacement;
                    }
                }
                $adresse_fichier_log = get_dossier_data('slow_query').'slow_query_'.substr($now, 0, 10).'.sql';
                $fichier_log = fopen($adresse_fichier_log, 'a+');
                fputs($fichier_log, '/*'.$ln.identification_log().' Date          : '.$now.$ln.' Duree         : '.$duree.'ms'.$ln.' Affected rows : '.$affected_rows.$ln.' Emplacement   : '.$sql_Emplacement.$ln.' Adresse IP    : '.get_ip().$ln.'*/'.$ln.$query.$ln.$ln);
                fclose($fichier_log);
            }
        }

        if ( $erreur_sql_Num_erreur!=0 ) /*Erreurs SQL*/
        {
            $debug = debug_backtrace();
            foreach ($debug as $t) {
                if ($sql_Emplacement!='') $sql_Emplacement=$ln.'                 '.$sql_Emplacement;
                $sql_Emplacement = $t['file'].' # '.$t['function'].' (Ligne '.$t['line'].')'.$sql_Emplacement;
            }
            $error = mysqli_error($link);
            $adresse_fichier_log = get_dossier_data('error').'error_'.substr($now, 0, 10).'.sql';
            $fichier_log = fopen($adresse_fichier_log, 'a+');
            $error_str = '/*'.$ln.identification_log().' Date          : '.$now.$ln.' Duree         : '.$duree.'ms'.$ln.' Code erreur   : '.$erreur_sql_Num_erreur.$ln.' Description   : '.$error.$ln.' Emplacement   : '.$sql_Emplacement.$ln.' Adresse IP    : '.get_ip().$ln.'*/'.$ln.$query.$ln.$ln;
            fputs($fichier_log, $error_str);
            fclose($fichier_log);
            sendemail(MAIL_ADMIN, 'Erreur '.$erreur_sql_Num_erreur.' - '.NOM_PROJET, text_html_br($error_str));
        }

        return $req;
    }

    function set_log($txt)
    {
        if ( ! MODE_PROD )
        {
            $ln = "\r\n";
            $adresse_fichier_log = get_dossier_data('log').'log_'.substr(get_now(), 0, 10).'.txt';
            $fichier_log = fopen($adresse_fichier_log, 'a+');
            fputs($fichier_log, ':'.$txt.$ln);
            fclose($fichier_log);
        }
    }

    function log_api($txt)
    {
        global $now;
        $ln = "\r\n";
        $adresse_fichier_log = get_dossier_data('log_api').'/log_api_'.substr(get_now(), 0, 10).'.txt';
        $fichier_log = fopen($adresse_fichier_log, 'a+');
        fputs($fichier_log, $now.$ln.$txt.$ln.'---'.$ln);
        fclose($fichier_log);
    }

    function fermeture_connexion_db()
    {
        global $link;
        if ($link!=null)
        {
            mysqli_close($link);
        }
    }

    function get_ip()
    {
        return isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
    }

    function identification_log()
    {
        global $joueur_courant;
        $identifiant = '';
        if (isset($joueur_courant['Code_joueur']))
        {
            $identifiant = ' Code_joueur : '.$joueur_courant['Code_joueur']."\r\n";
        }
        else
        {
            $identifiant = ' Non connecté'."\r\n";
        }
        return $identifiant;
    }

    function test_requete_update($query) {
        $query=' '.$query;
        $pos = stripos($query, ' UPDATE ');
        if ($pos===false) $pos = stripos($query, ' INSERT ');
        if ($pos===false) $pos = stripos($query, ' DELETE ');
        if ($pos===false) $pos = stripos($query, ' REPLACE ');
        if ($pos===false) $pos = stripos($query, ' ADD ');
        return ($pos!==false);
    }

    function test_requete_system($query) {
        $query=' '.$query;
        $pos = stripos($query, ' CREATE TABLE ');
        if ($pos===false) $pos = stripos($query, ' ALTER TABLE ');
        return ($pos!==false);
    }

    function requete_mysql_insert_id()
    {
        global $link;
        return mysqli_insert_id($link);
    }

    function requete_mysqli_affected_rows()
    {
        global $link;
        return mysqli_affected_rows($link);
    }

    function db_mysqli_close()
    {
        global $link;
        if ($link!=null) { mysqli_close($link); $link=null; };
    }

    function test_si_table_existe($nom_table)
    {
        $res_requete = executer_requete_mysql('show tables');
        while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_NUM) )
        {
            if ( $row_requete[0]==$nom_table )
            {
                return true;
            }
        }
        return false;
    }

    function lister_les_colonnes($nom_table)
    {
        $res_requete = executer_requete_mysql('SHOW COLUMNS FROM '.$nom_table.';');
        $liste = array();
        while( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
        {
            $liste[$row_requete['Field']] = $row_requete;
        }
        return $liste; // Field, Type, Null, Key, Default, Extra
    }

    function typeMyql2Sql($type_mysql)
    {
        $type_sql = '';
        if ( substr($type_mysql, 0, 4)=='int(' )
        {
            $type_sql = 'INT';
        }
        elseif ( $type_mysql=='time' )
        {
            $type_sql = 'TIME';
        }
        elseif ( $type_mysql=='tinytext' )
        {
            $type_sql = 'TINYTEXT';
        }
        elseif ( $type_mysql=='text' )
        {
            $type_sql = 'TEXT';
        }
        elseif ( $type_mysql=='mediumtext' )
        {
            $type_sql = 'MEDIUMTEXT';
        }
        elseif ( $type_mysql=='longtext' )
        {
            $type_sql = 'LONGTEXT';
        }
        elseif ( substr($type_mysql, 0, 8)=='varchar(' )
        {
            $type_sql = 'VARCHAR';
        }
        elseif ( $type_mysql=='date' )
        {
            $type_sql = 'DATE';
        }
        elseif ( $type_mysql=='double' )
        {
            $type_sql = 'DOUBLE';
        }
        elseif ($type_mysql=='datetime' )
        {
            $type_sql = 'DATETIME';
        }
        elseif ($type_mysql=='tinyint(1)')
        {
            $type_sql = 'BOOL';
        }
        return $type_sql;
    }

    function generer_la_base()
    {
        $cache_systeme = new Mf_Cache_systeme();
        if ( ! $cache_systeme->read('generer_base_ok') )
        {
            include __DIR__ . '/tables/monframework/mf_generer_db.php';
            $cache_systeme->write('generer_base_ok', true);
        }
    }
    generer_la_base();

    function format_sql($colonne, $valeur)
    {
        $script_sql = '';
        global $mf_dictionnaire_db;
        if ( isset( $mf_dictionnaire_db[$colonne] ) )
        {
            switch ( $mf_dictionnaire_db[$colonne]['type'] )
            {
                case 'INT': $script_sql = round($valeur); break;
                case 'VARCHAR': $script_sql = '\''.text_sql($valeur).'\''; break;
                case 'BOOL': $script_sql = ( $valeur==1 ? 1 : 0 ); break;
                case 'DATETIME':
                    $valeur = format_datetime($valeur);
                    $script_sql = ( $valeur!='' ? '\''.$valeur.'\'' : 'NULL' ); break;
                case 'TIMESTAMP':
                    $valeur = format_datetime($valeur);
                    $script_sql = ( $valeur!='' ? '\''.$valeur.'\'' : 'NULL' ); break;
                case 'TINYTEXT': $script_sql = '\''.text_sql($valeur).'\''; break;
                case 'TEXT': $script_sql = '\''.text_sql($valeur).'\''; break;
                case 'MEDIUMTEXT': $script_sql = '\''.text_sql($valeur).'\''; break;
                case 'LONGTEXT': $script_sql = '\''.text_sql($valeur).'\''; break;
                case 'DOUBLE': $script_sql = floatval(str_replace(',','.',$valeur)); break;
                case 'FLOAT': $script_sql = floatval(str_replace(',','.',$valeur)); break;
                case 'DATE':
                    $valeur = format_date($valeur);
                    $script_sql = ( $valeur!='' ? '\''.$valeur.'\'' : 'NULL' ); break;
                case 'PASSWORD':
                    $salt = salt(100);
                    $script_sql = '\''.md5($valeur.$salt).':'.$salt.'\''; break;
                case 'TIME':
                    $valeur = format_time($valeur);
                    $script_sql = ( $valeur!='' ? '\''.$valeur.'\'' : 'NULL' ); break;
            }
        }
        return $script_sql;
    }

    $etsl_colonne_tri = '';
    $etsl_mode_colonne_tri = '';
    $etsl_position_dans_langue;
    $etsl_initialisation;
    function effectuer_tri_suivant_langue(&$liste, $colonne, $tri)
    {
        global $etsl_colonne_tri, $etsl_mode_colonne_tri, $etsl_initialisation;
        $etsl_colonne_tri = $colonne;
        $etsl_mode_colonne_tri = $tri;
        $etsl_initialisation = false;
        if (!function_exists('cmp'))
        {
            function cmp($a, $b)
            {
                global $lang_standard, $etsl_colonne_tri, $etsl_mode_colonne_tri, $etsl_position_dans_langue, $etsl_initialisation;
                if (!$etsl_initialisation)
                {
                    $etsl_position_dans_langue = array();
                    if (isset($lang_standard[$etsl_colonne_tri.'_']))
                    {
                        $i = 0;
                        foreach ($lang_standard[$etsl_colonne_tri.'_'] as $code => $val)
                        {
                            $etsl_position_dans_langue[$code] = $i;
                            $i++;
                        }
                    }
                    $etsl_initialisation = true;
                }
                $v_a = isset($etsl_position_dans_langue[$a[$etsl_colonne_tri]]) ? $etsl_position_dans_langue[$a[$etsl_colonne_tri]] : 0;
                $v_b = isset($etsl_position_dans_langue[$b[$etsl_colonne_tri]]) ? $etsl_position_dans_langue[$b[$etsl_colonne_tri]] : 0;
                if ( $v_a==$v_b )
                {
                    return 0;
                }
                if ($etsl_mode_colonne_tri=='ASC')
                {
                    return ( $v_a > $v_b ) ? +1 : -1;
                }
                else
                {
                    return ( $v_a > $v_b ) ? -1 : +1;
                }
            }
        }
        uasort($liste, 'cmp');
    }

/* autres fonctions */

    $ttsuc_colonne = '';
    $ttsuc_tri = '';
    function trier_tableau_suivant_une_colonne(&$liste, $colonne, $tri)
    {
        global $ttsuc_colonne, $ttsuc_tri;
        $ttsuc_colonne = $colonne;
        $ttsuc_tri = $tri;
        if (!function_exists('ttsc_cmp'))
        {
            function ttsc_cmp($a, $b)
            {
                global $ttsuc_colonne, $ttsuc_tri;
                $v_a = $a[$ttsuc_colonne];
                $v_b = $b[$ttsuc_colonne];
                if ( $v_a==$v_b )
                {
                    return 0;
                }
                if ($ttsuc_tri=='ASC')
                {
                    return ( $v_a > $v_b ) ? +1 : -1;
                }
                else
                {
                    return ( $v_a > $v_b ) ? -1 : +1;
                }
            }
        }
        uasort($liste, 'ttsc_cmp');
    }

    $ttspc_colonnes = '';
    function trier_tableau_suivant_plusieurs_colonnes(&$liste, $colonnes) // $colonnes = [ 'Colonne A' => ASC, 'Colonne B' => ASC, ... ]
    {
        global $ttspc_colonnes;
        $ttspc_colonnes = $colonnes;
        if (!function_exists('ttsc_cmp'))
        {
            function ttsc_cmp($a, $b)
            {
                global $ttspc_colonnes;
                foreach ($ttspc_colonnes as $colonne => $tri)
                {
                    $v_a = $a[$colonne];
                    $v_b = $b[$colonne];
                    if ( $v_a!=$v_b ) // si $a != $b alors, on a un résultat non null, sinon, on passe à la colonne suivante
                    {
                        if ($tri=='ASC')
                        {
                            return ( $v_a > $v_b ) ? +1 : -1;
                        }
                        else
                        {
                            return ( $v_a > $v_b ) ? -1 : +1;
                        }
                    }
                }
                return 0;
            }
        }
        uasort($liste, 'ttsc_cmp');
    }

    function lecture_parametre_api($nom, $val_non_lue=null)
    {
        return ( isset($_GET[$nom]) ? $_GET[$nom] : ( isset($_POST[$nom]) ? $_POST[$nom] : $val_non_lue ) );
    }

    function isset_parametre_api($nom)
    {
        return ( isset($_GET[$nom]) || isset($_POST[$nom]) );
    }

    function prec_suiv(&$liste, $code_central)
    {
        $prec = array();
        $suiv = array();
        $trouve = false;
        $suiv_a_initialiser = false;
        $prec_initialiser = false;
        foreach ($liste as $Code_temp => &$value )
        {
            $trouve = ( $Code_temp == $code_central );
            if ($trouve) { $prec_initialiser = true; }
            if (!$prec_initialiser) { $prec = $value; }
            if ($suiv_a_initialiser) { $suiv = $value; }
            $suiv_a_initialiser = $trouve;
        }
        return array('prec'=>$prec, 'suiv'=>$suiv);
    }

    function vue_api_echo(&$donnees)
    {
        $vue = lecture_parametre_api('vue', 'json');
        switch ($vue)
        {
            case 'json': header('Content-Type: application/json'); echo json_encode($donnees); break;
            case 'tableau': echo '<!DOCTYPE html><html><head><meta charset=\'UTF-8\'><title></title></head><body>'.vue_tableau_html($donnees).'</body></html>'; break;
            default: echo json_encode($donnees); break;
        }
    }

    function mf_matrice_droits($fonctions)
    {
        global $mf_droits_defaut;
        if ( ! MODE_PROD )
        {
            $test = false;
            foreach ( $fonctions as &$fonction )
            {
                if ( $mf_droits_defaut[$fonction] )
                {
                    $test = true;
                }
            }
            if ( ! $test )
            {
                if ( strpos( $_SERVER['PHP_SELF'] , '/api.rest/' )===false )
                {
                    $debug = debug_backtrace();
                    foreach ( $debug as $t )
                    {
                        echo $t['file'] . ' # ' . $t['function'] . ' (Ligne ' . $t['line'] . ')<br>';
                    }
                    foreach ( $fonctions as &$fonction )
                    {
                        echo ' > ' . $fonction . '<br>';
                    }
                    echo '<br>';
                }
            }
        }
        foreach ($fonctions as &$fonction) { if ($mf_droits_defaut[$fonction]) return true; } unset($fonction);
        return false;
    }

    function controle_parametre($DB_name, $valeur)
    {
        global $lang_standard;
        $valeur = round($valeur);
        if ( isset($lang_standard[$DB_name.'_']) )
        {
            foreach ( $lang_standard[$DB_name.'_'] as $key => $value )
            {
                if ( $key==$valeur )
                    return true;
            }
        }
        return false;
    }

    function text_sql($txt) {
        global $link;
        if ( $link==null )
        {
            connexion_db($link);
        }

        return mysqli_real_escape_string($link, $txt);
    }

    function nom_fichier_formate($txt) {
        $trans = array('\\'=>'', '/'=>'', ':'=>'', '*'=>'', '?'=>'', '"'=>'', '<'=>'', '>'=>'', '|'=>'');
        return strtr($txt, $trans);
    }

    function format_date($date) {
        $d = explode ( '-' , $date );
        $AAAA = ( isset($d[0]) ? round($d[0]) : 0 );
        $MM= ( isset($d[1]) ? round($d[1]) : 0 );
        $JJ= ( isset($d[2]) ? round($d[2]) : 0 );
        if (strlen($MM) == 1) $MM='0'.$MM;
        if (strlen($JJ) == 1) $JJ='0'.$JJ;
        if ( 10000>$AAAA && $AAAA>999 && 13>$MM && $MM>0 && 32>$JJ && $JJ>0 && checkdate($MM, $JJ, $AAAA))
            return $AAAA.'-'.$MM.'-'.$JJ;
        else
            return '';
    }

    function Sql_Format_Liste($liste) {
        $retour = '(-1';
        foreach ($liste as &$value) {
            $retour.=','.round($value);
        }
        $retour.=')';
        return $retour;
    }

    function enumeration($liste, $sep=',') {
        $retour = '';
        foreach ($liste as &$value) {
            $retour.=( $retour!='' ? $sep : '' ) . $value;
        }
        return $retour;
    }

    function format_datetime($datetime) {
        $p = strrpos($datetime, ' ');
        if ($p==0)
            $p = strrpos($datetime, 'T');
        if ($p>0) {
            $date = substr($datetime, 0, $p);
            $time = substr($datetime, $p+1);
        } else {
            return '';
        }
        $date = format_date($date);
        $time = format_time($time);
        if ( $date!='' && $time!='' )
            return $date.' '.$time;
        else
            return '';
    }

    function format_time($time) {
        $time = substr($time, -8);
        $d = explode ( ':' , $time );
        $hh = ( isset($d[0]) ? round($d[0]) : 0 );
        $mm= ( isset($d[1]) ? round($d[1]) : 0 );
        $ss= ( isset($d[2]) ? round($d[2]) : 0 );
        if (strlen($hh) == 1) $hh='0'.$hh;
        if (strlen($mm) == 1) $mm='0'.$mm;
        if (strlen($ss) == 1) $ss='0'.$ss;
        if ( 24>$hh && $hh>=0 && 60>$mm && $mm>=0 && 60>$ss && $ss>=0 )
            return $hh.':'.$mm.':'.$ss;
        else
            return '';
    }

    function conversion_heure_vers_secondes( $heure_str )
    {
        $heure_str = format_time( $heure_str );
        if ( $heure_str!='' )
        {
            $h = round(substr($heure_str, 0, 2));
            $m = round(substr($heure_str, 3, 2));
            $s = round(substr($heure_str, 6, 2));
            return ($h*3600 + $m*60 + $s);
        }
        return false;
    }

    function conversion_secondes_vers_heure( $nb_secondes )
    {
        $nb_secondes = round( $nb_secondes );
        if ( $nb_secondes<0 ) $nb_secondes = 0;
        if ( $nb_secondes>86399 ) $nb_secondes = 86399;

        $ss = $nb_secondes % 60;
        $nb_secondes = ($nb_secondes-$ss)/60;
        $mm = $nb_secondes % 60;
        $nb_secondes = ($nb_secondes-$mm)/60;
        $hh = $nb_secondes;

        if ( $hh<10 ) $hh='0'.$hh;
        if ( $mm<10 ) $mm='0'.$mm;
        if ( $ss<10 ) $ss='0'.$ss;

        return $hh.':'.$mm.':'.$ss;
    }

    function date_debut_annee($date_str)
    {
        $date_str = format_date($date_str);
        $date_str = substr($date_str, 0, 5).'01-01';
        return format_date($date_str);
    }

    function date_fin_annee($date_str)
    {
        $date_str = format_date($date_str);
        $date_str = substr($date_str, 0, 5).'12-31';
        return format_date($date_str);
    }

    function date_debut_mois($date_str)
    {
        $date_str = format_date($date_str);
        $date_str = substr($date_str, 0, 8).'01'; // pour etre certain de prendre le premier jour du mois
        return $date_str;
    }

    function date_fin_mois($date_str)
    {
        $date_str = format_date($date_str);
        if ($date_str!='')
        {
            $date_str = substr($date_str, 0, 8).'01'; // pour etre certain de prendre le premier jour du mois
            $date = new DateTime($date_str);
            $diff1Month = new DateInterval('P1M');
            $date->add($diff1Month); //on ajouter un mois
            $diff1Day = new DateInterval('P1D');
            $date->sub($diff1Day); // on retire un jour
            return $date->format('Y-m-d');
        }
        return '';
    }

    function date_debut_semaine($date_str)
    {
        $date_str = format_date($date_str);
        $date = new DateTime($date_str);
        $diff1Day = new DateInterval('P1D');
        while ($date->format('w')!=1)
        {
            $date->sub($diff1Day);
        }
        return $date->format('Y-m-d');
    }

    function date_fin_semaine($date_str)
    {
        $date_str = format_date($date_str);
        $date = new DateTime($date_str);
        $diff1Day = new DateInterval('P1D');
        while ($date->format('w')!=0)
        {
            $date->add($diff1Day);
        }
        return $date->format('Y-m-d');
    }

    function date_ajouter_nb_jours($date_str, $nb_jours)
    {
        if ($nb_jours<0)
        {
            return date_soustraire_nb_jours($date_str, -$nb_jours);
        }
        $date = new DateTime(format_date($date_str));
        $diff1Day = new DateInterval('P1D');
        $nb_jours = round($nb_jours);
        for ($n=0; $n<$nb_jours; $n++)
        {
            $date->add($diff1Day);
        }
        return $date->format('Y-m-d');
    }

    function date_soustraire_nb_jours($date_str, $nb_jours)
    {
        if ($nb_jours<0)
        {
            return date_ajouter_nb_jours($date_str, -$nb_jours);
        }
        $date = new DateTime(format_date($date_str));
        $diff1Day = new DateInterval('P1D');
        $nb_jours = round($nb_jours);
        for ($n=0; $n<$nb_jours; $n++)
        {
            $date->sub($diff1Day);
        }
        return $date->format('Y-m-d');
    }

    function datetime_ajouter_nb_jours($datetime_str, $nb_jours)
    {
        if ($nb_jours<0)
        {
            return datetime_soustraire_nb_jours($datetime_str, -$nb_jours);
        }
        $date = new DateTime(format_datetime($datetime_str));
        $diff1Day = new DateInterval('P1D');
        $nb_jours = round($nb_jours);
        for ($n=0; $n<$nb_jours; $n++)
        {
            $date->add($diff1Day);
        }
        return $date->format('Y-m-d H:i:s');
    }

    function datetime_soustraire_nb_jours($datetime_str, $nb_jours)
    {
        if ($nb_jours<0)
        {
            return datetime_ajouter_nb_jours($datetime_str, -$nb_jours);
        }
        $date = new DateTime(format_datetime($datetime_str));
        $diff1Day = new DateInterval('P1D');
        $nb_jours = round($nb_jours);
        for ($n=0; $n<$nb_jours; $n++)
        {
            $date->sub($diff1Day);
        }
        return $date->format('Y-m-d H:i:s');
    }

    function datetime_tronquer_a_la_minute($datetime_str)
    {
        $datetime_str = format_datetime($datetime_str);
        return substr($datetime_str, 0, 17) . '00';
    }

    function datetime_ajouter_time($datetime_str, $time)
    {
        $date = new DateTime(format_datetime($datetime_str));
        $diff = new DateInterval('PT'.conversion_heure_vers_secondes($time).'S');
        $date->add($diff);
        return $date->format('Y-m-d H:i:s');
    }

    function datetime_ajouter_sec($datetime_str, $sec)
    {
        $date = new DateTime(format_datetime($datetime_str));
        $sec = round($sec);
        $diff = new DateInterval('PT'.$sec.'S');
        $date->add($diff);
        return $date->format('Y-m-d H:i:s');
    }

    function datetime_soustraire_sec($datetime_str, $sec)
    {
        $date = new DateTime(format_datetime($datetime_str));
        $sec = round($sec);
        $diff = new DateInterval('PT'.$sec.'S');
        $date->sub($diff);
        return $date->format('Y-m-d H:i:s');
    }

    function datetime_soustraire_time($datetime_str, $time)
    {
        $date = new DateTime(format_datetime($datetime_str));
        $diff = new DateInterval('PT'.conversion_heure_vers_secondes($time).'S');
        $date->sub($diff);
        return $date->format('Y-m-d H:i:s');
    }

    function datetime_vers_secondes_unix($datetime_str)
    {
        $date = new DateTime(format_datetime($datetime_str));
        return $date->format('U');
    }

    function get_nom_valeur($DB_name, $valeur)
    {
        global $lang_standard;
        if ( isset($lang_standard[$DB_name.'_'][$valeur]) )
            return $lang_standard[$DB_name.'_'][$valeur];
        else
            return '…';
    }

    function get_titre_ligne_table($libelle_table, $entite)
    {
        global $mf_titre_ligne_table;
        global $lang_standard;
        if ($libelle_table=='__instance')
        {
            $expr = TITRE_DB_INSTANCE;
            $retour = TITRE_DB_INSTANCE;
        }
        else
        {
            $expr = $mf_titre_ligne_table[$libelle_table];
            $retour = $mf_titre_ligne_table[$libelle_table];
        }
        while (stripos($expr, '}')>0)
        {
            $p1 = stripos($expr, '{');
            $p2 = stripos($expr, '}');
            $cle = substr($expr, $p1+1, $p2-$p1-1);
            $expr = substr($expr, $p2+1);
            if (isset($entite[$cle]))
            {
                if (isset($lang_standard[$cle.'_']))
                {
                    $retour = str_replace('{'.$cle.'}', get_nom_valeur($cle, $entite[$cle]), $retour);
                }
                else
                {
                    $retour = str_replace('{'.$cle.'}',  get_valeur_formate($cle, $entite[$cle]), $retour);
                }
            }
        }
        if ( str_replace(' ', '', $retour) =='' )
            $retour = '…';
        return $retour;
    }

    function get_valeur_formate($DB_name, $valeur)
    {
        global $mf_dictionnaire_db;

        switch ($mf_dictionnaire_db[$DB_name]['type']) {
            case 'DATE': return format_date_fr($valeur); break;
            case 'DATETIME': return format_datetime_fr($valeur); break;
            case 'TIME': return format_time_fr($valeur); break;
            case 'TEXT': return ''.$valeur; break;
            case 'MEDIUMTEXT': return ''.$valeur; break;
            case 'VARCHAR': return ''.$valeur; break;
            default: return htmlspecialchars($valeur); break;
        }
    }

    function format_date_fr($date)
    {
        $date = format_date($date);
        if ($date!='')
        {
            $d = explode ( '-' , $date );
            $AAAA = ''.( isset($d[0]) ? round($d[0]) : 0 );
            $MM= ''.( isset($d[1]) ? round($d[1]) : 0 );
            $JJ= ''.( isset($d[2]) ? round($d[2]) : 0 );
            if (strlen($JJ)==1) { $JJ = '0'.$JJ; }
            if (strlen($MM)==1) { $MM = '0'.$MM; }
            return $JJ.'/'.$MM.'/'.$AAAA;
        }
        else
        {
            return '';
        }
    }

    function format_date_fr_en_lettre($date, $abrege=false)
    {
        $date = format_date($date);
        if ($date!='')
        {
            global $lang_standard;
            $date = new DateTime($date);
            if ( $abrege )
                return $lang_standard['liste_jours_2'][$date->format('w')] . ' ' . $date->format('j') . ' ' . $lang_standard['liste_mois_2'][$date->format('n')] . ' ' . $date->format('Y');
            else
                return $lang_standard['liste_jours'][$date->format('w')] . ' ' . $date->format('j') . ' ' . $lang_standard['liste_mois'][$date->format('n')] . ' ' . $date->format('Y');
        }
        else
        {
            return '';
        }
    }

    function format_datetime_fr($datetime) {
        $p = strrpos($datetime, ' ');
        if ($p==0)
            $p = strrpos($datetime, 'T');
        if ($p>0) {
            $date = substr($datetime, 0, $p);
            $time = substr($datetime, $p+1);
        } else {
            return '';
        }
        $date = format_date_fr($date);
        if (substr(format_time($time), 5)==':00')
            $time = substr(format_time($time), 0, 5);
        if ( $date!='' && $time!='' )
            return $date.' à '.$time;
        else
            return '';
    }

    function get_valeur_auto($DB_name, $valeur) {
        global $lang_standard;
        if (isset($lang_standard[$DB_name.'_']))
        {
            return get_nom_valeur($DB_name, $valeur);
        }
        else
        {
            return get_valeur_formate($DB_name, $valeur);
        }
    }

    function get_nom_colonne($DB_name)
    {
        global $lang_standard;
        if ( isset($lang_standard[$DB_name]) )
            return $lang_standard[$DB_name];
        else
            return $DB_name;
    }

    function text_html_br($txt)
    {
        return strtr( htmlspecialchars($txt), array("\r\n"=>'<br>',chr(13)=>'<br>',"\n"=>'<br>') );
    }

    function salt($len)
    {
        $list = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $l = strlen($list);
        mt_srand(10000000*(double)microtime());
        $salt = ''; for ($i = 0; $i < $len; $i++) $salt .= $list[mt_rand(0, $l - 1)];
        return $salt;
    }

    function salt_minuscules($len)
    {
        $list = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $l = strlen($list);
        mt_srand(10000000*(double)microtime());
        $salt = '';
        while (strlen($salt)<$len)
        {
            $salt_temp = ''; for ($i = 0; $i < 10000; $i++) $salt_temp.= $list[mt_rand(0, $l - 1)];
            $salt.= md5($salt_temp);
        }
        return substr($salt, 0, $len);
    }

    function vue_tableau_html($donnees, $prefixe='')
    {
        $txt = '';
        if ( is_array($donnees) )
        {
            $txt.='<table border="1" style="border-collapse: collapse; border-color: #ddd;">';
            foreach ($donnees as $key => $value)
            {
                $txt.='<tr><td>' . $key . '</td><td>'.vue_tableau_html($value, $prefixe).'</td></tr>';
            }
            $txt.='</table>';
        }
        else
        {
            $txt.= $prefixe . htmlspecialchars($donnees);
        }
        return $txt;
    }

    function definir_colonne_completion($ratachement_table, $nom_colonne, $db_type, $libelle_langue)
    {
        global $lang_standard, $mf_dictionnaire_db;
        if ( ! MODE_PROD )
        {
            global $mf_titre_ligne_table;
            if ( ! isset($mf_titre_ligne_table[$ratachement_table]) )
            {
                echo '<b><i>ATTENTION : l\'entité "<u>'.$ratachement_table.'</u>" n\'existe pas !</i></b>';
            }
        }
        $lang_standard[$nom_colonne] = $libelle_langue;
        $mf_dictionnaire_db[$nom_colonne]['type']=$db_type;
        $mf_dictionnaire_db[$nom_colonne]['entite']=$ratachement_table;
    }

    function hex2rgb($color)
    {
        if(strlen($color) > 1 && $color[0] == '#')
        {
            $color = substr($color, 1);
        }
        if(strlen($color) == 6)
        {
            list($r, $g, $b) = array( $color[0].$color[1], $color[2].$color[3], $color[4].$color[5] );
        }
        elseif(strlen($color) == 3)
        {
            list($r, $g, $b) = array( $color[0].$color[0], $color[1].$color[1], $color[2].$color[2] );
        }
        else
        {
            return false;
        }
        return array( 'r' => hexdec($r), 'g' => hexdec($g), 'b' => hexdec($b) );
    }

    function luminosite_rgb( $r, $g, $b )
    {
        return ( 0.212671 * $r + 0.715160 * $g + 0.072169 * $b ) / 255;
    }

    function luminosite_hex( $color )
    {
        if ( $rgb = hex2rgb( $color ) )
        {
            return luminosite_rgb( $rgb['r'], $rgb['g'], $rgb['b'] );
        }
        return 0;
    }

    function set_luminosite_rgb( $r, $g, $b, $new_lum )
    {
        if ($r==0) $r = 1;
        if ($g==0) $g = 1;
        if ($b==0) $b = 1;
        $r_old = -1; $g_old = -1; $b_old = -1;
        while( $r_old!=$r || $g_old!=$g || $b_old!=$b )
        {
            $r_old = $r;
            $g_old = $g;
            $b_old = $b;
            $lum = luminosite_rgb( $r, $g, $b );
            $r = min( array( round($r*$new_lum/$lum,2) , 255 ) );
            $g = min( array( round($g*$new_lum/$lum,2) , 255 ) );
            $b = min( array( round($b*$new_lum/$lum,2) , 255 ) );
        }
        return array( 'r' => round($r), 'g' => round($g), 'b' => round($b) );
    }

    function maj_plage_horaire( &$debut_new, &$fin_new, &$duree_new, $debut_old, $fin_old, $duree_old )
    {
        $debut_new = arrondir_date_minute($debut_new);
        $fin_new = arrondir_date_minute($fin_new);
        if ($debut_new=='') { $debut_new = $debut_old; }
        if ($fin_new=='') { $fin_new = $fin_old; }
        if ($duree_new<=0) { $duree_new = $duree_old; }
        if ($duree_new!=$duree_old || $debut_new!=$debut_old)
        {
            $date = new DateTime($debut_new);
            $date->add(new DateInterval('PT'.round(3600*$duree_new).'S'));
            $fin_new = $date->format('Y-m-d H:i:s');
        }
        elseif ($fin_new!=$fin_old)
        {
            if ($fin_new>$debut_new)
            {
                $datetime1 = new DateTime($debut_new);
                $datetime2 = new DateTime($fin_new);
                $secondes = $datetime2->getTimestamp() - $datetime1->getTimestamp();
                $duree_new = round($secondes/3600, 2);
            }
            else
            {
                $fin_new = $debut_old;
            }
        }
        $debut_new = arrondir_date_minute($debut_new);
        $fin_new = arrondir_date_minute($fin_new);
    }

    function arrondir_date_minute($date_str)
    {
        return format_datetime(substr($date_str, 0, 16).':00');
    }

    function lister_cles($liste)
    {
        $liste_key = array();
        foreach ($liste as $code => &$value)
        {
            $liste_key[] = $code;
        }
        return $liste_key;
    }

    function liste_A_moins_B($liste_cle_A, $liste_cle_B)
    {
        $a_inxex = array();
        foreach ($liste_cle_A as $akey)
        {
            $a_inxex[$akey]=$akey;
        }
        foreach ($liste_cle_B as $bkey)
        {
            if (isset($a_inxex[$bkey]))
            {
                unset($a_inxex[$bkey]);
            }
        }
        $retour = array();
        foreach ($a_inxex as $key)
        {
            $retour[] = $key;
        }
        return $retour;
    }

    function liste_intersection_A_et_B($liste_cle_A, $liste_cle_B)
    {
        $a_inxex = array();
        foreach ($liste_cle_A as $akey)
        {
            $a_inxex[$akey]=$akey;
        }
        $retour = array();
        foreach ($liste_cle_B as $bkey)
        {
            if (isset($a_inxex[$bkey]))
            {
                $retour[]=$bkey;
            }
        }
        return $retour;
    }

    function get_image($valeur, $width=IMAGES_LARGEUR_MAXI, $height=IMAGES_HAUTEUR_MAXI, $mode_remplissage=true, $alt='', $format_png=false, $style='', $class='', $rotate=0)
    {
        if ($valeur!='')
        {
            return '<img class="'.$class.'" alt="'.htmlspecialchars($alt).'" title="'.htmlspecialchars($alt).'" src="mf_fichier.php?n='.$valeur.( $format_png ? '&format_png=1' : '&format_png=0' ).'&width='.( MODE_RETINA ? 2*$width : $width ).'&height='.( MODE_RETINA ? 2*$height : $height ).( $mode_remplissage ? '&troncage=1' : '' ).'&rotate='.$rotate.'" class="fichier_photo" style="max-width: ' . $width . 'px; max-height: ' . $height . 'px; '.$style.'">';
        }
        else
        {
            return '…';
        }
    }

    $num_sendemail = 1;
    function sendemail($to, $title, $content, $from=MAIL_NOREPLY, $attachement_str='', $replyto=MAIL_NOREPLY, $gabarit='main.html')
    {

        $verif_email = false;

        if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $to))
        {
            $rn = "\r\n";
        }
        else
        {
            $rn = "\n";
        }

        $caracteres_parasites = ["\n" => '', "\r" => '', "\t" => ''];

        // Contenu du mail (version text et HTML)
        $content = strtr( $content , $caracteres_parasites );
        $title = strtr( $title , $caracteres_parasites );
        $message_txt = strip_tags( strtr( $content , ['<br>'=> $rn ,'<br />'=> $rn ,'</p>'=> $rn , '</li>'=> $rn ] ) );
        $content_html = strtr( get_gabarit( 'gabarits-e-mail/' . $gabarit, [ '{title}' => $title, '{content}' => $content, '{website_adress}' => ADRESSE_SITE ] ) , $caracteres_parasites );
        while (substr($content_html, 0, 1)==' ') { $content_html = substr($content_html, 1); }
        while (substr($content_html, -1)==' ') { $content_html = substr($content_html, 0, strlen($content_html)-1); }
        $title = strip_tags($title);

        if ($_SERVER['HTTP_HOST']!='localhost')
        {

            if ($attachement_str=='')
            {
                // Création du boundary
                $boundary = md5(uniqid(microtime(), TRUE));

                // Header le l'email
                $header = 'From: ' . $from . $rn;
                $header.= 'Reply-to: ' . $replyto . $rn;
                $header.= 'MIME-Version: 1.0' . $rn;
                $header.= 'Content-Type: multipart/alternative;boundary="' . $boundary . '"' . $rn;

                // Message format texte
                $message = $rn . '--' . $boundary . $rn;
                $message.= 'Content-Type: text/plain; charset="utf-8"' . $rn;
                $message.= 'Content-Transfer-Encoding: 8bit' . $rn;
                $message.= $message_txt . $rn;

                // Message en HTML
                $message.= $rn . '--' . $boundary . $rn;
                $message.= 'Content-Type: text/html; charset="utf-8"' . $rn;
                $message.= 'Content-Transfer-Encoding: 8bit' . $rn;
                $message.= $content_html . $rn;

                // Fin
                $message.= $rn . '--' . $boundary . '--' . $rn;

                // Envoi de l'email
                $verif_email = @mail($to,$title,$message,$header);
            }
            else
            {

                if ( ! file_exists($attachement_str) )
                {
                    $attachement_folder = __DIR__ . '/../../fichiers/'.NOM_PROJET.'/';
                    if (TABLE_INSTANCE!='')
                    {
                        $instance = 'inst_'.get_instance();
                        $attachement_folder.= $instance.'/';
                    }
                    $attachement_str = $attachement_folder . $attachement_str;
                }

                $file = new Fichier();
                $ext = $file->get_extention($attachement_str);
                $mine_type = $file->get_mine_type($ext);
                if ( $mine_type!='' )
                {

                    // Lecture de la pièce jointe
                    $fichier   = fopen($attachement_str, 'r');
                    $attachement = fread($fichier, filesize($attachement_str));
                    $attachement = chunk_split(base64_encode($attachement));
                    fclose($fichier);

                    // Génération des boundarys
                    $boundary = md5(uniqid(microtime(), TRUE));
                    $boundary_content = md5(uniqid(microtime(), TRUE));

                    // Header
                    $header = 'From: ' . $from . $rn;
                    $header.= 'Reply-to: ' . $replyto . $rn;
                    $header.= 'MIME-Version: 1.0' . $rn;
                    $header.= 'Content-Type: multipart/mixed;boundary="' . $boundary . '"' . $rn;

                    // Début message
                    $message = $rn . '--' . $boundary . $rn;
                    $message.= 'Content-Type: multipart/alternative;boundary="' . $boundary_content . '"' . $rn;

                    // Message texte
                    $message.= $rn . '--' . $boundary_content . $rn;
                    $message.= 'Content-Type: text/plain; charset="utf-8"' . $rn;
                    $message.= 'Content-Transfer-Encoding: 8bit' . $rn;
                    $message.= $message_txt . $rn;

                    // Message HTML
                    $message.= $rn . '--' . $boundary_content . $rn;
                    $message.= 'Content-Type: text/html; charset="utf-8"' . $rn;
                    $message.= 'Content-Transfer-Encoding: 8bit' . $rn;
                    $message.= $content_html . $rn;

                    // Fin content
                    $message.= $rn . '--' . $boundary_content . '--' . $rn;

                    // Pièce jointe
                    $message.= $rn . '--' . $boundary . $rn;
                    $message.= 'Content-Type: '.$mine_type.'; name="piece-jointe.' . $ext . '"' . $rn;
                    $message.= 'Content-Transfer-Encoding: base64' . $rn;
                    $message.= 'Content-Disposition: attachment; filename="piece-jointe.' . $ext . '"' . $rn;
                    $message.= $attachement . $rn;

                    // Fin
                    $message.= $rn . '--' . $boundary . '--' . $rn;

                    // Envoi de l'email
                    $verif_email = @mail($to,$title,$message,$header);

                }

            }

        }
        else
        {
            $verif_email = true;
        }

        if ($verif_email)
        {
            global $num_sendemail, $cle_aleatoire;

            $dossier_sauvegarde = get_dossier_data('email');
            if (!file_exists($dossier_sauvegarde))
            {
                mkdir($dossier_sauvegarde);
            }
            $fichier = $dossier_sauvegarde.'email_'.str_replace(':', '-', get_now()).' '.$num_sendemail.' '.$cle_aleatoire.'.html';
            $fichier_html_local = '__email_'.str_replace(':', '-', get_now()).' '.$num_sendemail.' '.$cle_aleatoire.'.html';
            $fichier_html = $dossier_sauvegarde . $fichier_html_local;
            $num_sendemail++;

            $message_html = '<html><head><meta charset="utf-8"><title>'.htmlspecialchars( 'Message envoyé le ' . format_datetime_fr(get_now()) . ' à ' . $to ).'</title></head><body>';
            $tyle_contenant = ' style="float:none;clear:both"';
            $tyle_label = ' style="float:left; padding: 11px 0;"';
            $tyle_div = ' style="float:right; width: 75%; border: 1px solid #aaa; padding: 10px; margin-bottom: 10px;"';
            $message_html.= '<div'.$tyle_contenant.'><label'.$tyle_label.'>Destinataire :</label><div'.$tyle_div.'>' . htmlspecialchars($to) . '</div></div>';
            $message_html.= '<div'.$tyle_contenant.'><label'.$tyle_label.'>Titre :</label><div'.$tyle_div.'>' . htmlspecialchars($title) . '</div></div>';
            $message_html.= '<div'.$tyle_contenant.'><label'.$tyle_label.'>Message :</label><div'.$tyle_div.'><iframe style="width: 100%; height: 600px; border: none;" src="'.$fichier_html_local.'"></iframe></div></div>';
            $message_html.= '<div'.$tyle_contenant.'><label'.$tyle_label.'>Texte :</label><div'.$tyle_div.'><textarea style="width:100%; height:300px; border:none; resize:vertical;">'.$message_txt.'</textarea></div></div>';
            $message_html.= '</body></html>';

            file_put_contents($fichier, $message_html);
            file_put_contents($fichier_html, $content_html);
        }

        return $verif_email;
    }

    function get_gabarit($filename, $trans)
    {
        $adress = __DIR__ . '/../../www/' . NOM_PROJET . '/gabarits/' . $filename;
        if ( ! file_exists( $adress ) )
        {
            file_put_contents( $adress , '');
        }
        return strtr(file_get_contents( $adress ), $trans);
    }

    function format_nombre($nombre, $html = false)
    {
        return number_format($nombre, 2, ',', ( $html ? '&nbsp;' : ' ' ));
    }

    function format_nombre_euro($nombre, $html = false)
    {
        return number_format($nombre, 2, ',', ( $html ? '&nbsp;' : ' ' )).( $html ? '&nbsp;' : ' ' ).( $html ? '&euro;' : '€' );
    }

    function format_caractere_csv($txt) {
        $trans = array(chr(92) => ' ', "\n" => ' ', ';' => ' ', '<br>' => '');
        return utf8_decode(strtr($txt, $trans));
    }

    function text_html($txt) {
        return strtr( htmlspecialchars($txt), array(' ' => '&nbsp;') );
    }

    function formatage_MAJUSCULE($txt) {
        return strtoupper($txt);
    }

    function formatage_Majmots($txt) {
        return ucwords($txt);
    }

    function suppr_accents($str, $encoding='utf-8')
    {
        $str = htmlentities($str, ENT_NOQUOTES, $encoding);
        $str = preg_replace('#&([A-za-z])(?:acute|grave|cedil|circ|orn|ring|slash|th|tilde|uml);#', '\1', $str);
        $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str);
        $str = preg_replace('#&[^;]+;#', '', $str);
        return $str;
    }

    function formatage_telephone($tel) {

        $d = strlen($tel);
        $temp = '';
        for ( $i=0; $i<$d; $i++ )
        {
            $o = ord($tel[$i]);
            if ( $o==43 || (48<=$o && $o<=57) )
                $temp.=$tel[$i];
        }

        $d = strlen($temp);
        $res = '';
        for ( $i=$d-1; $i>=0; $i-- )
        {
            $res = $temp[$i].( $res!='' && ( ( ($d-$i-1) % 2 ) == 0 ) ? ' ' : '' ).$res;
        }

        return $res;

    }

    function conserver_uniquement_chiffres($str)
    {
        $d = strlen($str);
        $temp = '';
        for ( $i=0; $i<$d; $i++ )
        {
            $o = ord($str[$i]);
            if ( 48<=$o && $o<=57 )
                $temp.=$str[$i];
        }
        return $temp;
    }

    function Sql_StdDev_Pond( $X, $W ) {
        return "SQRT(ABS(SUM($W*POW($X,2))/SUM($W)-POW(SUM($X*$W)/SUM($W),2)))";
    }

    function Sql_StdDev_Stat( $X, $S, $N ) {    //$X : moyenne[i], $S : sigma[i], $N : nb[i]
        return "SQRT(ABS(SUM($N*(POW($S,2)+POW($X,2)))/SUM($N)-POW(SUM($N*$X)/SUM($N),2)))";
    }

    function test_email_valide($email) {
        return strlen($email)<256 && filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    function test_mot_de_passe_valide($mdp) {
        return preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])#', $mdp) && strlen($mdp)>7;
    }

    function format_date_fr_en_lettre_reduit($date, $abrege=false)
    {
        $date = format_date($date);
        if ( $date!='' )
        {
            global $lang_standard;
            $date = new DateTime($date);
            if ( $abrege )
                return $lang_standard['liste_jours_2'][$date->format('w')].' '.$date->format('j').' '.$lang_standard['liste_mois_2'][$date->format('n')];
            else
                return $lang_standard['liste_jours'][$date->format('w')].' '.$date->format('j').' '.$lang_standard['liste_mois'][$date->format('n')];
        }
        else
        {
            return '';
        }
    }

    function format_date_fr_get_libelle_mois($date_str)
    {
        $date_str = format_date($date_str);
        if ( $date_str!='' )
        {
            global $lang_standard;
            $date = new DateTime($date_str);
            return $lang_standard['liste_mois'][$date->format('n')].' '.$date->format('Y');
        }
        else
        {
            return '';
        }
    }

    function format_time_fr($time) { return str_replace(':','h',substr(format_time($time),0,5)); }

    function rrmdir($dir) //https://secure.php.net/manual/en/function.rmdir.php
    {
        if (is_dir($dir))
        {
            $objects = scandir($dir);
            foreach ($objects as $object)
            {
                if ($object != "." && $object != "..")
                {
                    if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
                }
            }
            reset($objects);
            rmdir($dir);
        }
    }

    function return_bytes ($size_str)
    {
        switch (substr ($size_str, -1))
        {
            case 'M': case 'm': return (int)$size_str * 1048576;
            case 'K': case 'k': return (int)$size_str * 1024;
            case 'G': case 'g': return (int)$size_str * 1073741824;
            default: return $size_str;
        }
    }

    // http://www.php.net/manual/en/function.fopen.php
    // "UTF-8", "ASCII", "Windows-1252", "ISO-8859-15", "ISO-8859-1", "ISO-8859-6", "CP1256"
    function utf8_fopen_read($fileName, $in_charset = 'Windows-1252')
    {
        $fc = iconv($in_charset, 'UTF-8//IGNORE', file_get_contents($fileName));
        $handle=fopen("php://memory", "rw");
        fwrite($handle, $fc);
        fseek($handle, 0);
        return $handle;
    }

    // Transformer image
    function transformer_image($nom_fichier_image, $format_png=false, $width=IMAGES_LARGEUR_MAXI, $height=IMAGES_HAUTEUR_MAXI, $troncage=false, $rotate=0, $zoom=100, $xpos=50, $ypos=50, $qualite=75, $ecraser_fichier=false)
    {
        $fichier = new Fichier();
        $ext = $fichier->get_extention($nom_fichier_image);
        //adresse de l'image
        $filename = $fichier->get_adresse($nom_fichier_image);
        //chargement de l'image
        switch ($ext)
        {
            case 'png':
                $image = imagecreatefrompng($filename);
                imageAlphaBlending($image, true);
                imageSaveAlpha($image, true);
                break;
            case 'jpg':
                $image = imagecreatefromjpeg($filename);
                break;
            case 'jpeg':
                $image = imagecreatefromjpeg($filename);
                break;
            default:
                return false;
                break;
        }
        //dimentions de l'image
        if ($width<1) { $width = 1; }
        if ($height<1) { $height = 1; }
        if ($width>IMAGES_LARGEUR_MAXI) { $width = IMAGES_LARGEUR_MAXI; }
        if ($height>IMAGES_HAUTEUR_MAXI) { $height = IMAGES_HAUTEUR_MAXI; }
        //Rotation éventuelle
        if ($rotate!=0)
        {
            $old_width = imagesx($image);
            $old_height = imagesy($image);
            $image_p = imagecreatetruecolor($old_width, $old_height);
            imageAlphaBlending($image_p, false);
            imageSaveAlpha($image_p, true);
            $transparent = imagecolorallocatealpha($image_p, 255, 255, 255, 127);
            $image = imagerotate($image, $rotate, $transparent);
            imagedestroy($image_p);
        }
        //dimentions actuelles
        $old_width = imagesx($image);
        $old_height = imagesy($image);
        //choix du zoom
        if ($troncage)
        {
            if ( $width/$old_width > $height/$old_height ) $r = $width/$old_width; else $r = $height/$old_height;
        }
        else
        {
            if ( $width/$old_width < $height/$old_height ) $r = $width/$old_width; else $r = $height/$old_height;
        }
        //
        $dst_x=0; $dst_y=0; $src_x=0; $src_y=0;
        if ($troncage)
        {
            //troncage
            if ( $width/$old_width < $height/$old_height )
            {
                $largeur_origine_calcule = round($width/$r);
                $distance_a_tronquer = $old_width-$largeur_origine_calcule;
                $src_x = round($distance_a_tronquer/2);
                $old_width = $largeur_origine_calcule;
            }
            elseif ( $width/$old_width > $height/$old_height )
            {
                $hauteur_origine_calcule = round($height/$r);
                $distance_a_tronquer = $old_height-$hauteur_origine_calcule;
                $src_y = round($distance_a_tronquer/2);
                $old_height = $hauteur_origine_calcule;
            }
        }
        else
        {
            //redimentionnement (sans troncage)
            $width = round($old_width * $r);
            $height = round($old_height * $r);
        }
        // Zoom
        if ($zoom<100) { $zoom = 100; }
        if ($zoom>1000) { $zoom = 1000; }
        $coef_zoom = 100/$zoom;
        $old_width_2 = round($old_width * $coef_zoom);
        $old_height_2 = round($old_height * $coef_zoom);
        $src_x = round($src_x + ($old_width - $old_width_2) / 2);
        $src_y = round($src_y + ($old_height - $old_height_2) / 2);
        // déplacement du cadre
        if ($xpos<0) { $xpos = 0; } if ($xpos>100) { $xpos = 100; }
        if ($ypos<0) { $ypos = 0; } if ($ypos>100) { $ypos = 100; }
        $src_x = round($src_x * $xpos / 50);
        $src_y = round($src_y * $ypos / 50);
        //redimentionnement
        $image_p = imagecreatetruecolor($width, $height);
        if ($format_png)
        {
            //affichage en png
            imageAlphaBlending($image_p, false);
            imageSaveAlpha($image_p, true);
            $transparent = imagecolorallocatealpha($image_p, 255, 255, 255, 127);
            imagefilledrectangle($image_p, 0, 0, $width, $height, $transparent);
            imagecopyresampled($image_p, $image, $dst_x, $dst_y, $src_x, $src_y, $width, $height, $old_width_2, $old_height_2);
            if ($ecraser_fichier)
            {
                imagepng($image_p, $filename);
            }
            else
            {
                imagepng($image_p);
            }
        }
        else
        {
            //affichage en jpeg quelque soit le fichier d'origine
            imagecopyresampled($image_p, $image, $dst_x, $dst_y, $src_x, $src_y, $width, $height, $old_width_2, $old_height_2);
            if ($ecraser_fichier)
            {
                imagejpeg($image_p, $filename);
            }
            else
            {
                imagejpeg($image_p);
            }
        }
        imagedestroy($image_p);
        imagedestroy($image);
    }

    // Appel du worker
    function mf_execution_worker()
    {
        $dossier_cache_worker = __DIR__ . '/cache_worker/';
        if ( ! file_exists($dossier_cache_worker) ) { @mkdir($dossier_cache_worker); }
        if ( TABLE_INSTANCE!='' )
        {
            $dossier_cache_worker.= 'inst_' . get_instance() . '/';
            if ( ! file_exists( $dossier_cache_worker ) ) { @mkdir($dossier_cache_worker); }
        }
        $worker_en_cours = $dossier_cache_worker . 'execution_en_cours';
        if ( ! file_exists( $worker_en_cours ) && file_put_contents( $worker_en_cours , get_now(), LOCK_EX ) !== false )
        {
            $time_start = microtime(true);
            Hook_mf_systeme::worker();
            $time_end = microtime(true);
            $execution_time = round( $time_end-$time_start, 3);
            $ln = "\r\n";
            $adresse_fichier_log = get_dossier_data('log_worker') . 'log_' . substr(get_now(), 0, 10) . '.txt';
            $fichier_log = fopen($adresse_fichier_log, 'a+');
            fputs($fichier_log, ': Worker at '.get_now() . ' in ' . $execution_time . 's' . $ln);
            fclose($fichier_log);
        }
        elseif ( file_exists($worker_en_cours) )
        {
            $last = file_get_contents($worker_en_cours);
            $limit = datetime_ajouter_sec($last, DELAI_EXECUTION_WORKER);
            if ( $limit<get_now() )
            {
                @unlink($worker_en_cours);
            }
        }
    }

    function mf_get_value_session($name, $undifundefined_value = null)
    {
        return ( isset($_SESSION[PREFIXE_SESSION]['parametres'][$name]) ? $_SESSION[PREFIXE_SESSION]['parametres'][$name] : $undifundefined_value );
    }

    function mf_get_trace_session()
    {
        if ( isset($_SESSION[PREFIXE_SESSION]['parametres']) )
        {
            $trace = '';
            foreach ($_SESSION[PREFIXE_SESSION]['parametres'] as &$value)
            {
                $trace.='-'.$value;
            }
            return md5($trace);
        }
        else
        {
            return '';
        }
    }

/* Colonnes de la base de données */

    // JOUEUR
    define('MF_JOUEUR__ID', 'Code_joueur');
    define('MF_JOUEUR_EMAIL', 'joueur_Email');
    define('MF_JOUEUR_IDENTIFIANT', 'joueur_Identifiant');
    define('MF_JOUEUR_PASSWORD', 'joueur_Password');
    define('MF_JOUEUR_AVATAR_FICHIER', 'joueur_Avatar_Fichier');
    define('MF_JOUEUR_DATE_NAISSANCE', 'joueur_Date_naissance');
    define('MF_JOUEUR_DATE_INSCRIPTION', 'joueur_Date_inscription');

    // MESSAGE
    define('MF_MESSAGE__ID', 'Code_message');
    define('MF_MESSAGE_TEXTE', 'message_Texte');
    define('MF_MESSAGE_DATE', 'message_Date');
    define('MF_MESSAGE_CODE_MESSAGERIE', 'Code_messagerie');
    define('MF_MESSAGE_CODE_JOUEUR', 'Code_joueur');

    // PARAMETRE
    define('MF_PARAMETRE__ID', 'Code_parametre');
    define('MF_PARAMETRE_LIBELLE', 'parametre_Libelle');
    define('MF_PARAMETRE_VALEUR', 'parametre_Valeur');
    define('MF_PARAMETRE_ACTIVABLE', 'parametre_Activable');
    define('MF_PARAMETRE_ACTIF', 'parametre_Actif');

    // GROUPE
    define('MF_GROUPE__ID', 'Code_groupe');
    define('MF_GROUPE_NOM', 'groupe_Nom');
    define('MF_GROUPE_DESCRIPTION', 'groupe_Description');
    define('MF_GROUPE_LOGO_FICHIER', 'groupe_Logo_Fichier');
    define('MF_GROUPE_EFFECTIF', 'groupe_Effectif');
    define('MF_GROUPE_ACTIF', 'groupe_Actif');
    define('MF_GROUPE_DATE_CREATION', 'groupe_Date_creation');
    define('MF_GROUPE_DELAI_SUPPRESSION_JOUR', 'groupe_Delai_suppression_jour');
    define('MF_GROUPE_SUPPRESSION_ACTIVE', 'groupe_Suppression_active');
    define('MF_GROUPE_CODE_CAMPAGNE', 'Code_campagne');

    // PERSONNAGE
    define('MF_PERSONNAGE__ID', 'Code_personnage');
    define('MF_PERSONNAGE_FICHIER_FICHIER', 'personnage_Fichier_Fichier');
    define('MF_PERSONNAGE_CONSERVATION', 'personnage_Conservation');
    define('MF_PERSONNAGE_CODE_JOUEUR', 'Code_joueur');
    define('MF_PERSONNAGE_CODE_GROUPE', 'Code_groupe');

    // CAMPAGNE
    define('MF_CAMPAGNE__ID', 'Code_campagne');
    define('MF_CAMPAGNE_NOM', 'campagne_Nom');
    define('MF_CAMPAGNE_DESCRIPTION', 'campagne_Description');
    define('MF_CAMPAGNE_IMAGE_FICHIER', 'campagne_Image_Fichier');
    define('MF_CAMPAGNE_NOMBRE_JOUEUR', 'campagne_Nombre_joueur');
    define('MF_CAMPAGNE_NOMBRE_MJ', 'campagne_Nombre_mj');

    // TAG_CAMPAGNE
    define('MF_TAG_CAMPAGNE__ID', 'Code_tag_campagne');
    define('MF_TAG_CAMPAGNE_LIBELLE', 'tag_campagne_Libelle');

    // CARTE
    define('MF_CARTE__ID', 'Code_carte');
    define('MF_CARTE_NOM', 'carte_Nom');
    define('MF_CARTE_HAUTEUR', 'carte_Hauteur');
    define('MF_CARTE_LARGEUR', 'carte_Largeur');
    define('MF_CARTE_FICHIER', 'carte_Fichier');
    define('MF_CARTE_CODE_GROUPE', 'Code_groupe');

    // OBJET
    define('MF_OBJET__ID', 'Code_objet');
    define('MF_OBJET_LIBELLE', 'objet_Libelle');
    define('MF_OBJET_IMAGE_FICHIER', 'objet_Image_Fichier');
    define('MF_OBJET_CODE_TYPE', 'Code_type');

    // TYPE
    define('MF_TYPE__ID', 'Code_type');
    define('MF_TYPE_LIBELLE', 'type_Libelle');
    define('MF_TYPE_CODE_RESSOURCE', 'Code_ressource');

    // RESSOURCE
    define('MF_RESSOURCE__ID', 'Code_ressource');
    define('MF_RESSOURCE_NOM', 'ressource_Nom');

    // TAG_RESSOURCE
    define('MF_TAG_RESSOURCE__ID', 'Code_tag_ressource');
    define('MF_TAG_RESSOURCE_LIBELLE', 'tag_ressource_Libelle');

    // MESSAGERIE
    define('MF_MESSAGERIE__ID', 'Code_messagerie');
    define('MF_MESSAGERIE_CODE_JOUEUR', 'Code_joueur');

    // LISTE_CONTACTS
    define('MF_LISTE_CONTACTS__ID', 'Code_liste_contacts');
    define('MF_LISTE_CONTACTS_NOM', 'liste_contacts_Nom');
    define('MF_LISTE_CONTACTS_CODE_JOUEUR', 'Code_joueur');

    // A_JOUEUR_PARAMETRE
    define('MF_A_JOUEUR_PARAMETRE_CODE_JOUEUR', 'Code_joueur');
    define('MF_A_JOUEUR_PARAMETRE_CODE_PARAMETRE', 'Code_parametre');

    // A_CANDIDATURE_JOUEUR_GROUPE
    define('MF_A_CANDIDATURE_JOUEUR_GROUPE_CODE_JOUEUR', 'Code_joueur');
    define('MF_A_CANDIDATURE_JOUEUR_GROUPE_CODE_GROUPE', 'Code_groupe');
    define('MF_A_CANDIDATURE_JOUEUR_GROUPE_MESSAGE', 'a_candidature_joueur_groupe_Message');
    define('MF_A_CANDIDATURE_JOUEUR_GROUPE_DATE_ENVOI', 'a_candidature_joueur_groupe_Date_envoi');

    // A_MEMBRE_JOUEUR_GROUPE
    define('MF_A_MEMBRE_JOUEUR_GROUPE_CODE_GROUPE', 'Code_groupe');
    define('MF_A_MEMBRE_JOUEUR_GROUPE_CODE_JOUEUR', 'Code_joueur');
    define('MF_A_MEMBRE_JOUEUR_GROUPE_SURNOM', 'a_membre_joueur_groupe_Surnom');
    define('MF_A_MEMBRE_JOUEUR_GROUPE_GRADE', 'a_membre_joueur_groupe_Grade');
    define('MF_A_MEMBRE_JOUEUR_GROUPE_DATE_ADHESION', 'a_membre_joueur_groupe_Date_adhesion');

    // A_INVITATION_JOUEUR_GROUPE
    define('MF_A_INVITATION_JOUEUR_GROUPE_CODE_JOUEUR', 'Code_joueur');
    define('MF_A_INVITATION_JOUEUR_GROUPE_CODE_GROUPE', 'Code_groupe');
    define('MF_A_INVITATION_JOUEUR_GROUPE_MESSAGE', 'a_invitation_joueur_groupe_Message');
    define('MF_A_INVITATION_JOUEUR_GROUPE_DATE_ENVOI', 'a_invitation_joueur_groupe_Date_envoi');

    // A_CARTE_OBJET
    define('MF_A_CARTE_OBJET_CODE_CARTE', 'Code_carte');
    define('MF_A_CARTE_OBJET_CODE_OBJET', 'Code_objet');

    // A_CAMPAGNE_TAG_CAMPAGNE
    define('MF_A_CAMPAGNE_TAG_CAMPAGNE_CODE_TAG_CAMPAGNE', 'Code_tag_campagne');
    define('MF_A_CAMPAGNE_TAG_CAMPAGNE_CODE_CAMPAGNE', 'Code_campagne');

    // A_RESSOURCE_TAG_RESSOURCE
    define('MF_A_RESSOURCE_TAG_RESSOURCE_CODE_TAG_RESSOURCE', 'Code_tag_ressource');
    define('MF_A_RESSOURCE_TAG_RESSOURCE_CODE_RESSOURCE', 'Code_ressource');

    // A_LISTE_CONTACT_JOUEUR
    define('MF_A_LISTE_CONTACT_JOUEUR_CODE_LISTE_CONTACTS', 'Code_liste_contacts');
    define('MF_A_LISTE_CONTACT_JOUEUR_CODE_JOUEUR', 'Code_joueur');
    define('MF_A_LISTE_CONTACT_JOUEUR_DATE_CREATION', 'a_liste_contact_joueur_Date_creation');

    include __DIR__ . '/fonctions_additionnelles.php';

    function get_liste_dump()
    {
        return inst('joueur').' '.inst('message').' '.inst('parametre').' '.inst('groupe').' '.inst('personnage').' '.inst('campagne').' '.inst('tag_campagne').' '.inst('carte').' '.inst('objet').' '.inst('type').' '.inst('ressource').' '.inst('tag_ressource').' '.inst('messagerie').' '.inst('liste_contacts').' '.inst('a_joueur_parametre').' '.inst('a_candidature_joueur_groupe').' '.inst('a_membre_joueur_groupe').' '.inst('a_invitation_joueur_groupe').' '.inst('a_carte_objet').' '.inst('a_campagne_tag_campagne').' '.inst('a_ressource_tag_ressource').' '.inst('a_liste_contact_joueur');
    }

    Hook_mf_systeme::initialisation();
    mf_execution_worker();
