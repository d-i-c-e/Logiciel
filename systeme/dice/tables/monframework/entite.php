<?php

include __DIR__ . '/mf_cachedb.php';

class entite_monframework extends entite
{

    private $mf_dupliquer_table_de_conversion;
    private $mf_dupliquer_tables_a_dupliquer;

/*
    +----------+
    |  joueur  |
    +----------+
*/

    protected function mf_tester_existance_Code_joueur( int $Code_joueur )
    {
        $Code_joueur = round($Code_joueur);
        $requete_sql = "SELECT Code_joueur FROM ".inst('joueur')." WHERE Code_joueur = $Code_joueur;";
        $cache_db = new Mf_Cachedb('joueur');
        if ( ! $r = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) $r = 'o'; else $r = 'n';
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $r);
        }
        return $r=='o';
    }

    protected function rechercher_joueur_Email( string $joueur_Email )
    {
        $Code_joueur = 0;
        $joueur_Email = format_sql('joueur_Email', $joueur_Email);
        $requete_sql = 'SELECT Code_joueur FROM '.inst('joueur')." WHERE joueur_Email = $joueur_Email LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('joueur');
        if ( ! $Code_joueur = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $Code_joueur = (int) $row_requete['Code_joueur'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_joueur);
        }
        return $Code_joueur;
    }

    protected function rechercher_joueur_Identifiant( string $joueur_Identifiant )
    {
        $Code_joueur = 0;
        $joueur_Identifiant = format_sql('joueur_Identifiant', $joueur_Identifiant);
        $requete_sql = 'SELECT Code_joueur FROM '.inst('joueur').' WHERE joueur_Identifiant = ' . $joueur_Identifiant . ' LIMIT 0, 1;';
        $cache_db = new Mf_Cachedb('joueur');
        if ( ! $Code_joueur = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $Code_joueur = (int) $row_requete['Code_joueur'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_joueur);
        }
        return $Code_joueur;
    }

    protected function rechercher_joueur_Password( string $joueur_Password )
    {
        $Code_joueur = 0;
        $joueur_Password = format_sql('joueur_Password', $joueur_Password);
        $requete_sql = 'SELECT Code_joueur FROM '.inst('joueur')." WHERE joueur_Password = $joueur_Password LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('joueur');
        if ( ! $Code_joueur = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $Code_joueur = (int) $row_requete['Code_joueur'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_joueur);
        }
        return $Code_joueur;
    }

    protected function rechercher_joueur_Avatar_Fichier( string $joueur_Avatar_Fichier )
    {
        $Code_joueur = 0;
        $joueur_Avatar_Fichier = format_sql('joueur_Avatar_Fichier', $joueur_Avatar_Fichier);
        $requete_sql = 'SELECT Code_joueur FROM '.inst('joueur')." WHERE joueur_Avatar_Fichier = $joueur_Avatar_Fichier LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('joueur');
        if ( ! $Code_joueur = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $Code_joueur = (int) $row_requete['Code_joueur'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_joueur);
        }
        return $Code_joueur;
    }

    protected function rechercher_joueur_Date_naissance( string $joueur_Date_naissance )
    {
        $Code_joueur = 0;
        $joueur_Date_naissance = format_sql('joueur_Date_naissance', $joueur_Date_naissance);
        $requete_sql = 'SELECT Code_joueur FROM '.inst('joueur')." WHERE joueur_Date_naissance = $joueur_Date_naissance LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('joueur');
        if ( ! $Code_joueur = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $Code_joueur = (int) $row_requete['Code_joueur'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_joueur);
        }
        return $Code_joueur;
    }

    protected function rechercher_joueur_Date_inscription( string $joueur_Date_inscription )
    {
        $Code_joueur = 0;
        $joueur_Date_inscription = format_sql('joueur_Date_inscription', $joueur_Date_inscription);
        $requete_sql = 'SELECT Code_joueur FROM '.inst('joueur')." WHERE joueur_Date_inscription = $joueur_Date_inscription LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('joueur');
        if ( ! $Code_joueur = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $Code_joueur = (int) $row_requete['Code_joueur'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_joueur);
        }
        return $Code_joueur;
    }

    protected function rechercher_joueur_Administrateur( bool $joueur_Administrateur )
    {
        $Code_joueur = 0;
        $joueur_Administrateur = format_sql('joueur_Administrateur', $joueur_Administrateur);
        $requete_sql = 'SELECT Code_joueur FROM '.inst('joueur')." WHERE joueur_Administrateur = $joueur_Administrateur LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('joueur');
        if ( ! $Code_joueur = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $Code_joueur = (int) $row_requete['Code_joueur'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_joueur);
        }
        return $Code_joueur;
    }

    protected function get_liste_Code_joueur(?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cache_db = new Mf_Cachedb("joueur");
        $cle = "joueur__lister_cles";

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql']))
        {
            foreach ($options['cond_mysql'] as &$condition)
            {
                $argument_cond.= ' AND ('.$condition.')';
            }
            unset($condition);
        }
        $cle.='_'.$argument_cond;

        if ( ! $liste = $cache_db->read($cle) )
        {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ( $argument_cond!='' )
            {
                if ( strpos($argument_cond, 'joueur_Email')!==false ) { $liste_colonnes_a_indexer['joueur_Email'] = 'joueur_Email'; }
                if ( strpos($argument_cond, 'joueur_Identifiant')!==false ) { $liste_colonnes_a_indexer['joueur_Identifiant'] = 'joueur_Identifiant'; }
                if ( strpos($argument_cond, 'joueur_Password')!==false ) { $liste_colonnes_a_indexer['joueur_Password'] = 'joueur_Password'; }
                if ( strpos($argument_cond, 'joueur_Avatar_Fichier')!==false ) { $liste_colonnes_a_indexer['joueur_Avatar_Fichier'] = 'joueur_Avatar_Fichier'; }
                if ( strpos($argument_cond, 'joueur_Date_naissance')!==false ) { $liste_colonnes_a_indexer['joueur_Date_naissance'] = 'joueur_Date_naissance'; }
                if ( strpos($argument_cond, 'joueur_Date_inscription')!==false ) { $liste_colonnes_a_indexer['joueur_Date_inscription'] = 'joueur_Date_inscription'; }
                if ( strpos($argument_cond, 'joueur_Administrateur')!==false ) { $liste_colonnes_a_indexer['joueur_Administrateur'] = 'joueur_Administrateur'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = $cache_db->read('joueur__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('joueur').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('joueur__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    $cache_db->pause('joueur__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('joueur').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                    $cache_db->reprendre('joueur__index');
                }
            }

            $liste = array();
            $res_requete = executer_requete_mysql("SELECT Code_joueur FROM ".inst('joueur')." WHERE 1".$argument_cond.";", false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $liste[] = (int) $row_requete['Code_joueur'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste);
        }
        return $liste;
    }

    private function mf_dupliquer_joueur( int $Code_joueur )
    {
        $code_erreur = 0;
        $Code_new_joueur = 0;
        $Code_joueur = round($Code_joueur);
        if ( !$this->mf_tester_existance_Code_joueur($Code_joueur) ) $code_erreur = 1;
        else
        {
            $donnees_a_copier = $this->mf_get($Code_joueur, array('autocompletion' => false));
            $joueur_Email = $donnees_a_copier['joueur_Email'];
            $joueur_Identifiant = $donnees_a_copier['joueur_Identifiant'];
            $joueur_Password = $donnees_a_copier['joueur_Password'];
            $joueur_Avatar_Fichier = $donnees_a_copier['joueur_Avatar_Fichier'];
            $joueur_Date_naissance = $donnees_a_copier['joueur_Date_naissance'];
            $joueur_Date_inscription = $donnees_a_copier['joueur_Date_inscription'];
            $joueur_Administrateur = $donnees_a_copier['joueur_Administrateur'];
            $joueur_Email = text_sql($joueur_Email);
            $joueur_Identifiant = text_sql($joueur_Identifiant);
            $salt = salt(100);
            $joueur_Password = md5($joueur_Password.$salt).':'.$salt;
            $joueur_Avatar_Fichier = text_sql($joueur_Avatar_Fichier);
            $joueur_Date_naissance = format_date($joueur_Date_naissance);
            $joueur_Date_inscription = format_datetime($joueur_Date_inscription);
            $joueur_Administrateur = ($joueur_Administrateur==1 ? 1 : 0);
            executer_requete_mysql("INSERT INTO joueur ( joueur_Email, joueur_Identifiant, joueur_Password, joueur_Avatar_Fichier, joueur_Date_naissance, joueur_Date_inscription, joueur_Administrateur ) VALUES ( '$joueur_Email', '$joueur_Identifiant', '$joueur_Password', '$joueur_Avatar_Fichier', ".( $joueur_Date_naissance!='' ? "'$joueur_Date_naissance'" : 'NULL' ).", ".( $joueur_Date_inscription!='' ? "'$joueur_Date_inscription'" : 'NULL' ).", $joueur_Administrateur );", true);
            $Code_new_joueur = requete_mysql_insert_id();
            if ($Code_new_joueur==0)
            {
                $code_erreur = 999999;
            }
            else
            {
                $cache_db = new Mf_Cachedb("joueur");
                $cache_db->clear();
                $liste_Code_message = $this->liste_Code_joueur_vers_liste_Code_message( array($Code_joueur) );
                foreach ($liste_Code_message as $Code_message)
                {
                    $this->mf_dupliquer_tables_a_dupliquer["message_$Code_message"]=array('message', $Code_message);
                }
                $liste_Code_personnage = $this->liste_Code_joueur_vers_liste_Code_personnage( array($Code_joueur) );
                foreach ($liste_Code_personnage as $Code_personnage)
                {
                    $this->mf_dupliquer_tables_a_dupliquer["personnage_$Code_personnage"]=array('personnage', $Code_personnage);
                }
                $liste_Code_messagerie = $this->liste_Code_joueur_vers_liste_Code_messagerie( array($Code_joueur) );
                foreach ($liste_Code_messagerie as $Code_messagerie)
                {
                    $this->mf_dupliquer_tables_a_dupliquer["messagerie_$Code_messagerie"]=array('messagerie', $Code_messagerie);
                }
                $liste_Code_liste_contacts = $this->liste_Code_joueur_vers_liste_Code_liste_contacts( array($Code_joueur) );
                foreach ($liste_Code_liste_contacts as $Code_liste_contacts)
                {
                    $this->mf_dupliquer_tables_a_dupliquer["liste_contacts_$Code_liste_contacts"]=array('liste_contacts', $Code_liste_contacts);
                }
                $this->mf_dupliquer_table_de_conversion['Code_joueur'][$Code_joueur] = $Code_new_joueur;
            }
        }
        return array('code_erreur' => $code_erreur, "Code_joueur" => $Code_new_joueur);
    }

/*
    +-----------+
    |  message  |
    +-----------+
*/

    protected function mf_tester_existance_Code_message( int $Code_message )
    {
        $Code_message = round($Code_message);
        $requete_sql = "SELECT Code_message FROM ".inst('message')." WHERE Code_message = $Code_message;";
        $cache_db = new Mf_Cachedb('message');
        if ( ! $r = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) $r = 'o'; else $r = 'n';
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $r);
        }
        return $r=='o';
    }

    protected function rechercher_message_Date( string $message_Date, ?int $Code_messagerie=null, ?int $Code_joueur=null )
    {
        $Code_message = 0;
        $message_Date = format_sql('message_Date', $message_Date);
        $Code_messagerie = round($Code_messagerie);
        $Code_joueur = round($Code_joueur);
        $requete_sql = 'SELECT Code_message FROM '.inst('message')." WHERE message_Date = $message_Date".( $Code_messagerie!=0 ? " AND Code_messagerie=$Code_messagerie" : "" )."".( $Code_joueur!=0 ? " AND Code_joueur=$Code_joueur" : "" )." LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('message');
        if ( ! $Code_message = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $Code_message = (int) $row_requete['Code_message'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_message);
        }
        return $Code_message;
    }

    protected function get_liste_Code_message(?int $Code_messagerie=null, ?int $Code_joueur=null, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cache_db = new Mf_Cachedb("message");
        $cle = "message__lister_cles";
        $Code_messagerie = round($Code_messagerie);
        $cle.="_{$Code_messagerie}";
        $Code_joueur = round($Code_joueur);
        $cle.="_{$Code_joueur}";

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql']))
        {
            foreach ($options['cond_mysql'] as &$condition)
            {
                $argument_cond.= ' AND ('.$condition.')';
            }
            unset($condition);
        }
        $cle.='_'.$argument_cond;

        if ( ! $liste = $cache_db->read($cle) )
        {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ( $argument_cond!='' )
            {
                if ( strpos($argument_cond, 'message_Date')!==false ) { $liste_colonnes_a_indexer['message_Date'] = 'message_Date'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = $cache_db->read('message__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('message').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('message__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    $cache_db->pause('message__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('message').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                    $cache_db->reprendre('message__index');
                }
            }

            $liste = array();
            $res_requete = executer_requete_mysql("SELECT Code_message FROM ".inst('message')." WHERE 1".( $Code_messagerie!=0 ? " AND Code_messagerie=$Code_messagerie" : "" )."".( $Code_joueur!=0 ? " AND Code_joueur=$Code_joueur" : "" )."".$argument_cond.";", false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $liste[] = (int) $row_requete['Code_message'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste);
        }
        return $liste;
    }

    protected function Code_message_vers_Code_messagerie( int $Code_message )
    {
        $Code_message = round($Code_message);
        if ($Code_message<0) $Code_message = 0;
        $p = floor($Code_message/100);
        $start = $p*100;
        $end = ($p+1)*100;
        $cache_db = new Mf_Cachedb('message');
        $cle = 'Code_message_vers_Code_messagerie__'.$start.'__'.$end;
        if ( ! $conversion = $cache_db->read($cle) )
        {
            $res_requete = executer_requete_mysql('SELECT Code_message, Code_messagerie FROM '.inst('message').' WHERE '.$start.' <= Code_message AND Code_message < '.$end.';', false);
            $conversion = array();
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $conversion[(int) $row_requete['Code_message']] = (int) $row_requete['Code_messagerie'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $conversion);
        }
        return ( isset($conversion[$Code_message]) ? $conversion[$Code_message] : 0 );
    }

    protected function Code_message_vers_Code_joueur( int $Code_message )
    {
        $Code_message = round($Code_message);
        if ($Code_message<0) $Code_message = 0;
        $p = floor($Code_message/100);
        $start = $p*100;
        $end = ($p+1)*100;
        $cache_db = new Mf_Cachedb('message');
        $cle = 'Code_message_vers_Code_joueur__'.$start.'__'.$end;
        if ( ! $conversion = $cache_db->read($cle) )
        {
            $res_requete = executer_requete_mysql('SELECT Code_message, Code_joueur FROM '.inst('message').' WHERE '.$start.' <= Code_message AND Code_message < '.$end.';', false);
            $conversion = array();
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $conversion[(int) $row_requete['Code_message']] = (int) $row_requete['Code_joueur'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $conversion);
        }
        return ( isset($conversion[$Code_message]) ? $conversion[$Code_message] : 0 );
    }

    protected function liste_Code_messagerie_vers_liste_Code_message( array $liste_Code_messagerie, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ( $options===null ) { $options=[]; }
        $cache_db = new Mf_Cachedb("message");
        $cle = "liste_Code_messagerie_vers_liste_Code_message__".Sql_Format_Liste($liste_Code_messagerie);

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql']))
        {
            foreach ($options['cond_mysql'] as &$condition)
            {
                $argument_cond.= ' AND ('.$condition.')';
            }
            unset($condition);
        }
        $cle.='_'.$argument_cond;

        if ( ! $liste_Code_message = $cache_db->read($cle) )
        {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ( $argument_cond!='' )
            {
                if ( strpos($argument_cond, 'message_Date')!==false ) { $liste_colonnes_a_indexer['message_Date'] = 'message_Date'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = $cache_db->read('message__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('message').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('message__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    $cache_db->pause('message__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('message').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                    $cache_db->reprendre('message__index');
                }
            }

            $liste_Code_message = array();
            $res_requete = executer_requete_mysql('SELECT Code_message FROM '.inst('message')." WHERE Code_messagerie IN ".Sql_Format_Liste($liste_Code_messagerie).$argument_cond.";", false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $liste_Code_message[] = (int) $row_requete['Code_message'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste_Code_message);
        }
        return $liste_Code_message;
    }

    protected function message__liste_Code_message_vers_liste_Code_messagerie( array $liste_Code_message, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ( $options===null ) { $options=[]; }
        $cache_db = new Mf_Cachedb("message");
        $cle = "liste_Code_message_vers_liste_Code_messagerie__".Sql_Format_Liste($liste_Code_message);

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql']))
        {
            foreach ($options['cond_mysql'] as &$condition)
            {
                $argument_cond.= ' AND ('.$condition.')';
            }
            unset($condition);
        }
        $cle.='_'.$argument_cond;

        if ( ! $liste_Code_messagerie = $cache_db->read($cle) )
        {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ( $argument_cond!='' )
            {
                if ( strpos($argument_cond, 'message_Date')!==false ) { $liste_colonnes_a_indexer['message_Date'] = 'message_Date'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = $cache_db->read('message__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('message').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('message__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    $cache_db->pause('message__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('message').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                    $cache_db->reprendre('message__index');
                }
            }

            $controle_doublons = array();
            $liste_Code_messagerie = array();
            $res_requete = executer_requete_mysql("SELECT Code_messagerie FROM ".inst('message')." WHERE Code_message IN ".Sql_Format_Liste($liste_Code_message).$argument_cond.";", false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                if ( ! isset($controle_doublons[(int) $row_requete['Code_messagerie']]) )
                {
                    $controle_doublons[(int) $row_requete['Code_messagerie']] = 1;
                    $liste_Code_messagerie[] = (int) $row_requete['Code_messagerie'];
                }
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste_Code_messagerie);
        }
        return $liste_Code_messagerie;
    }

    protected function liste_Code_joueur_vers_liste_Code_message( array $liste_Code_joueur, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ( $options===null ) { $options=[]; }
        $cache_db = new Mf_Cachedb("message");
        $cle = "liste_Code_joueur_vers_liste_Code_message__".Sql_Format_Liste($liste_Code_joueur);

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql']))
        {
            foreach ($options['cond_mysql'] as &$condition)
            {
                $argument_cond.= ' AND ('.$condition.')';
            }
            unset($condition);
        }
        $cle.='_'.$argument_cond;

        if ( ! $liste_Code_message = $cache_db->read($cle) )
        {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ( $argument_cond!='' )
            {
                if ( strpos($argument_cond, 'message_Date')!==false ) { $liste_colonnes_a_indexer['message_Date'] = 'message_Date'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = $cache_db->read('message__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('message').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('message__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    $cache_db->pause('message__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('message').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                    $cache_db->reprendre('message__index');
                }
            }

            $liste_Code_message = array();
            $res_requete = executer_requete_mysql('SELECT Code_message FROM '.inst('message')." WHERE Code_joueur IN ".Sql_Format_Liste($liste_Code_joueur).$argument_cond.";", false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $liste_Code_message[] = (int) $row_requete['Code_message'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste_Code_message);
        }
        return $liste_Code_message;
    }

    protected function message__liste_Code_message_vers_liste_Code_joueur( array $liste_Code_message, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ( $options===null ) { $options=[]; }
        $cache_db = new Mf_Cachedb("message");
        $cle = "liste_Code_message_vers_liste_Code_joueur__".Sql_Format_Liste($liste_Code_message);

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql']))
        {
            foreach ($options['cond_mysql'] as &$condition)
            {
                $argument_cond.= ' AND ('.$condition.')';
            }
            unset($condition);
        }
        $cle.='_'.$argument_cond;

        if ( ! $liste_Code_joueur = $cache_db->read($cle) )
        {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ( $argument_cond!='' )
            {
                if ( strpos($argument_cond, 'message_Date')!==false ) { $liste_colonnes_a_indexer['message_Date'] = 'message_Date'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = $cache_db->read('message__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('message').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('message__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    $cache_db->pause('message__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('message').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                    $cache_db->reprendre('message__index');
                }
            }

            $controle_doublons = array();
            $liste_Code_joueur = array();
            $res_requete = executer_requete_mysql("SELECT Code_joueur FROM ".inst('message')." WHERE Code_message IN ".Sql_Format_Liste($liste_Code_message).$argument_cond.";", false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                if ( ! isset($controle_doublons[(int) $row_requete['Code_joueur']]) )
                {
                    $controle_doublons[(int) $row_requete['Code_joueur']] = 1;
                    $liste_Code_joueur[] = (int) $row_requete['Code_joueur'];
                }
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste_Code_joueur);
        }
        return $liste_Code_joueur;
    }

    private function mf_dupliquer_message( int $Code_message )
    {
        $code_erreur = 0;
        $Code_new_message = 0;
        $Code_message = round($Code_message);
        if ( !$this->mf_tester_existance_Code_message($Code_message) ) $code_erreur = 1;
        else
        {
            $donnees_a_copier = $this->mf_get($Code_message, array('autocompletion' => false));
            $message_Texte = $donnees_a_copier['message_Texte'];
            $message_Date = $donnees_a_copier['message_Date'];
            $message_Texte = text_sql($message_Texte);
            $message_Date = format_datetime($message_Date);
            $Code_messagerie = round($donnees_a_copier['Code_messagerie']);
            if ( isset($this->mf_dupliquer_table_de_conversion['Code_messagerie'][$Code_messagerie]) ) $Code_messagerie = $this->mf_dupliquer_table_de_conversion['Code_messagerie'][$Code_messagerie];
            elseif ( isset($this->mf_dupliquer_table_de_conversion['Code_messagerie'][0]) ) $Code_messagerie = $this->mf_dupliquer_table_de_conversion['Code_messagerie'][0];
            $Code_joueur = round($donnees_a_copier['Code_joueur']);
            if ( isset($this->mf_dupliquer_table_de_conversion['Code_joueur'][$Code_joueur]) ) $Code_joueur = $this->mf_dupliquer_table_de_conversion['Code_joueur'][$Code_joueur];
            elseif ( isset($this->mf_dupliquer_table_de_conversion['Code_joueur'][0]) ) $Code_joueur = $this->mf_dupliquer_table_de_conversion['Code_joueur'][0];
            executer_requete_mysql("INSERT INTO message ( message_Texte, message_Date, Code_messagerie, Code_joueur ) VALUES ( '$message_Texte', ".( $message_Date!='' ? "'$message_Date'" : 'NULL' ).", $Code_messagerie, $Code_joueur );", true);
            $Code_new_message = requete_mysql_insert_id();
            if ($Code_new_message==0)
            {
                $code_erreur = 999999;
            }
            else
            {
                $cache_db = new Mf_Cachedb("message");
                $cache_db->clear();
                $this->mf_dupliquer_table_de_conversion['Code_message'][$Code_message] = $Code_new_message;
            }
        }
        return array('code_erreur' => $code_erreur, "Code_message" => $Code_new_message);
    }

/*
    +-------------+
    |  parametre  |
    +-------------+
*/

    protected function mf_tester_existance_Code_parametre( int $Code_parametre )
    {
        $Code_parametre = round($Code_parametre);
        $requete_sql = "SELECT Code_parametre FROM ".inst('parametre')." WHERE Code_parametre = $Code_parametre;";
        $cache_db = new Mf_Cachedb('parametre');
        if ( ! $r = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) $r = 'o'; else $r = 'n';
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $r);
        }
        return $r=='o';
    }

    protected function rechercher_parametre_Libelle( string $parametre_Libelle )
    {
        $Code_parametre = 0;
        $parametre_Libelle = format_sql('parametre_Libelle', $parametre_Libelle);
        $requete_sql = 'SELECT Code_parametre FROM '.inst('parametre')." WHERE parametre_Libelle = $parametre_Libelle LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('parametre');
        if ( ! $Code_parametre = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $Code_parametre = (int) $row_requete['Code_parametre'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_parametre);
        }
        return $Code_parametre;
    }

    protected function rechercher_parametre_Activable( bool $parametre_Activable )
    {
        $Code_parametre = 0;
        $parametre_Activable = format_sql('parametre_Activable', $parametre_Activable);
        $requete_sql = 'SELECT Code_parametre FROM '.inst('parametre')." WHERE parametre_Activable = $parametre_Activable LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('parametre');
        if ( ! $Code_parametre = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $Code_parametre = (int) $row_requete['Code_parametre'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_parametre);
        }
        return $Code_parametre;
    }

    protected function get_liste_Code_parametre(?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cache_db = new Mf_Cachedb("parametre");
        $cle = "parametre__lister_cles";

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql']))
        {
            foreach ($options['cond_mysql'] as &$condition)
            {
                $argument_cond.= ' AND ('.$condition.')';
            }
            unset($condition);
        }
        $cle.='_'.$argument_cond;

        if ( ! $liste = $cache_db->read($cle) )
        {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ( $argument_cond!='' )
            {
                if ( strpos($argument_cond, 'parametre_Libelle')!==false ) { $liste_colonnes_a_indexer['parametre_Libelle'] = 'parametre_Libelle'; }
                if ( strpos($argument_cond, 'parametre_Activable')!==false ) { $liste_colonnes_a_indexer['parametre_Activable'] = 'parametre_Activable'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = $cache_db->read('parametre__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('parametre').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('parametre__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    $cache_db->pause('parametre__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('parametre').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                    $cache_db->reprendre('parametre__index');
                }
            }

            $liste = array();
            $res_requete = executer_requete_mysql("SELECT Code_parametre FROM ".inst('parametre')." WHERE 1".$argument_cond.";", false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $liste[] = (int) $row_requete['Code_parametre'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste);
        }
        return $liste;
    }

    private function mf_dupliquer_parametre( int $Code_parametre )
    {
        $code_erreur = 0;
        $Code_new_parametre = 0;
        $Code_parametre = round($Code_parametre);
        if ( !$this->mf_tester_existance_Code_parametre($Code_parametre) ) $code_erreur = 1;
        else
        {
            $donnees_a_copier = $this->mf_get($Code_parametre, array('autocompletion' => false));
            $parametre_Libelle = $donnees_a_copier['parametre_Libelle'];
            $parametre_Activable = $donnees_a_copier['parametre_Activable'];
            $parametre_Libelle = text_sql($parametre_Libelle);
            $parametre_Activable = ($parametre_Activable==1 ? 1 : 0);
            executer_requete_mysql("INSERT INTO parametre ( parametre_Libelle, parametre_Activable ) VALUES ( '$parametre_Libelle', $parametre_Activable );", true);
            $Code_new_parametre = requete_mysql_insert_id();
            if ($Code_new_parametre==0)
            {
                $code_erreur = 999999;
            }
            else
            {
                $cache_db = new Mf_Cachedb("parametre");
                $cache_db->clear();
                $liste_Code_parametre_valeur = $this->liste_Code_parametre_vers_liste_Code_parametre_valeur( array($Code_parametre) );
                foreach ($liste_Code_parametre_valeur as $Code_parametre_valeur)
                {
                    $this->mf_dupliquer_tables_a_dupliquer["parametre_valeur_$Code_parametre_valeur"]=array('parametre_valeur', $Code_parametre_valeur);
                }
                $this->mf_dupliquer_table_de_conversion['Code_parametre'][$Code_parametre] = $Code_new_parametre;
            }
        }
        return array('code_erreur' => $code_erreur, "Code_parametre" => $Code_new_parametre);
    }

/*
    +----------+
    |  groupe  |
    +----------+
*/

    protected function mf_tester_existance_Code_groupe( int $Code_groupe )
    {
        $Code_groupe = round($Code_groupe);
        $requete_sql = "SELECT Code_groupe FROM ".inst('groupe')." WHERE Code_groupe = $Code_groupe;";
        $cache_db = new Mf_Cachedb('groupe');
        if ( ! $r = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) $r = 'o'; else $r = 'n';
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $r);
        }
        return $r=='o';
    }

    protected function rechercher_groupe_Nom( string $groupe_Nom, ?int $Code_campagne=null )
    {
        $Code_groupe = 0;
        $groupe_Nom = format_sql('groupe_Nom', $groupe_Nom);
        $Code_campagne = round($Code_campagne);
        $requete_sql = 'SELECT Code_groupe FROM '.inst('groupe')." WHERE groupe_Nom = $groupe_Nom".( $Code_campagne!=0 ? " AND Code_campagne=$Code_campagne" : "" )." LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('groupe');
        if ( ! $Code_groupe = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $Code_groupe = (int) $row_requete['Code_groupe'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_groupe);
        }
        return $Code_groupe;
    }

    protected function rechercher_groupe_Logo_Fichier( string $groupe_Logo_Fichier, ?int $Code_campagne=null )
    {
        $Code_groupe = 0;
        $groupe_Logo_Fichier = format_sql('groupe_Logo_Fichier', $groupe_Logo_Fichier);
        $Code_campagne = round($Code_campagne);
        $requete_sql = 'SELECT Code_groupe FROM '.inst('groupe')." WHERE groupe_Logo_Fichier = $groupe_Logo_Fichier".( $Code_campagne!=0 ? " AND Code_campagne=$Code_campagne" : "" )." LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('groupe');
        if ( ! $Code_groupe = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $Code_groupe = (int) $row_requete['Code_groupe'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_groupe);
        }
        return $Code_groupe;
    }

    protected function rechercher_groupe_Effectif( int $groupe_Effectif, ?int $Code_campagne=null )
    {
        $Code_groupe = 0;
        $groupe_Effectif = format_sql('groupe_Effectif', $groupe_Effectif);
        $Code_campagne = round($Code_campagne);
        $requete_sql = 'SELECT Code_groupe FROM '.inst('groupe')." WHERE groupe_Effectif = $groupe_Effectif".( $Code_campagne!=0 ? " AND Code_campagne=$Code_campagne" : "" )." LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('groupe');
        if ( ! $Code_groupe = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $Code_groupe = (int) $row_requete['Code_groupe'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_groupe);
        }
        return $Code_groupe;
    }

    protected function rechercher_groupe_Actif( bool $groupe_Actif, ?int $Code_campagne=null )
    {
        $Code_groupe = 0;
        $groupe_Actif = format_sql('groupe_Actif', $groupe_Actif);
        $Code_campagne = round($Code_campagne);
        $requete_sql = 'SELECT Code_groupe FROM '.inst('groupe')." WHERE groupe_Actif = $groupe_Actif".( $Code_campagne!=0 ? " AND Code_campagne=$Code_campagne" : "" )." LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('groupe');
        if ( ! $Code_groupe = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $Code_groupe = (int) $row_requete['Code_groupe'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_groupe);
        }
        return $Code_groupe;
    }

    protected function rechercher_groupe_Date_creation( string $groupe_Date_creation, ?int $Code_campagne=null )
    {
        $Code_groupe = 0;
        $groupe_Date_creation = format_sql('groupe_Date_creation', $groupe_Date_creation);
        $Code_campagne = round($Code_campagne);
        $requete_sql = 'SELECT Code_groupe FROM '.inst('groupe')." WHERE groupe_Date_creation = $groupe_Date_creation".( $Code_campagne!=0 ? " AND Code_campagne=$Code_campagne" : "" )." LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('groupe');
        if ( ! $Code_groupe = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $Code_groupe = (int) $row_requete['Code_groupe'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_groupe);
        }
        return $Code_groupe;
    }

    protected function rechercher_groupe_Delai_suppression_jour( int $groupe_Delai_suppression_jour, ?int $Code_campagne=null )
    {
        $Code_groupe = 0;
        $groupe_Delai_suppression_jour = format_sql('groupe_Delai_suppression_jour', $groupe_Delai_suppression_jour);
        $Code_campagne = round($Code_campagne);
        $requete_sql = 'SELECT Code_groupe FROM '.inst('groupe')." WHERE groupe_Delai_suppression_jour = $groupe_Delai_suppression_jour".( $Code_campagne!=0 ? " AND Code_campagne=$Code_campagne" : "" )." LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('groupe');
        if ( ! $Code_groupe = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $Code_groupe = (int) $row_requete['Code_groupe'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_groupe);
        }
        return $Code_groupe;
    }

    protected function rechercher_groupe_Suppression_active( bool $groupe_Suppression_active, ?int $Code_campagne=null )
    {
        $Code_groupe = 0;
        $groupe_Suppression_active = format_sql('groupe_Suppression_active', $groupe_Suppression_active);
        $Code_campagne = round($Code_campagne);
        $requete_sql = 'SELECT Code_groupe FROM '.inst('groupe')." WHERE groupe_Suppression_active = $groupe_Suppression_active".( $Code_campagne!=0 ? " AND Code_campagne=$Code_campagne" : "" )." LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('groupe');
        if ( ! $Code_groupe = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $Code_groupe = (int) $row_requete['Code_groupe'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_groupe);
        }
        return $Code_groupe;
    }

    protected function get_liste_Code_groupe(?int $Code_campagne=null, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cache_db = new Mf_Cachedb("groupe");
        $cle = "groupe__lister_cles";
        $Code_campagne = round($Code_campagne);
        $cle.="_{$Code_campagne}";

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql']))
        {
            foreach ($options['cond_mysql'] as &$condition)
            {
                $argument_cond.= ' AND ('.$condition.')';
            }
            unset($condition);
        }
        $cle.='_'.$argument_cond;

        if ( ! $liste = $cache_db->read($cle) )
        {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ( $argument_cond!='' )
            {
                if ( strpos($argument_cond, 'groupe_Nom')!==false ) { $liste_colonnes_a_indexer['groupe_Nom'] = 'groupe_Nom'; }
                if ( strpos($argument_cond, 'groupe_Logo_Fichier')!==false ) { $liste_colonnes_a_indexer['groupe_Logo_Fichier'] = 'groupe_Logo_Fichier'; }
                if ( strpos($argument_cond, 'groupe_Effectif')!==false ) { $liste_colonnes_a_indexer['groupe_Effectif'] = 'groupe_Effectif'; }
                if ( strpos($argument_cond, 'groupe_Actif')!==false ) { $liste_colonnes_a_indexer['groupe_Actif'] = 'groupe_Actif'; }
                if ( strpos($argument_cond, 'groupe_Date_creation')!==false ) { $liste_colonnes_a_indexer['groupe_Date_creation'] = 'groupe_Date_creation'; }
                if ( strpos($argument_cond, 'groupe_Delai_suppression_jour')!==false ) { $liste_colonnes_a_indexer['groupe_Delai_suppression_jour'] = 'groupe_Delai_suppression_jour'; }
                if ( strpos($argument_cond, 'groupe_Suppression_active')!==false ) { $liste_colonnes_a_indexer['groupe_Suppression_active'] = 'groupe_Suppression_active'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = $cache_db->read('groupe__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('groupe').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('groupe__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    $cache_db->pause('groupe__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('groupe').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                    $cache_db->reprendre('groupe__index');
                }
            }

            $liste = array();
            $res_requete = executer_requete_mysql("SELECT Code_groupe FROM ".inst('groupe')." WHERE 1".( $Code_campagne!=0 ? " AND Code_campagne=$Code_campagne" : "" )."".$argument_cond.";", false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $liste[] = (int) $row_requete['Code_groupe'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste);
        }
        return $liste;
    }

    protected function Code_groupe_vers_Code_campagne( int $Code_groupe )
    {
        $Code_groupe = round($Code_groupe);
        if ($Code_groupe<0) $Code_groupe = 0;
        $p = floor($Code_groupe/100);
        $start = $p*100;
        $end = ($p+1)*100;
        $cache_db = new Mf_Cachedb('groupe');
        $cle = 'Code_groupe_vers_Code_campagne__'.$start.'__'.$end;
        if ( ! $conversion = $cache_db->read($cle) )
        {
            $res_requete = executer_requete_mysql('SELECT Code_groupe, Code_campagne FROM '.inst('groupe').' WHERE '.$start.' <= Code_groupe AND Code_groupe < '.$end.';', false);
            $conversion = array();
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $conversion[(int) $row_requete['Code_groupe']] = (int) $row_requete['Code_campagne'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $conversion);
        }
        return ( isset($conversion[$Code_groupe]) ? $conversion[$Code_groupe] : 0 );
    }

    protected function liste_Code_campagne_vers_liste_Code_groupe( array $liste_Code_campagne, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ( $options===null ) { $options=[]; }
        $cache_db = new Mf_Cachedb("groupe");
        $cle = "liste_Code_campagne_vers_liste_Code_groupe__".Sql_Format_Liste($liste_Code_campagne);

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql']))
        {
            foreach ($options['cond_mysql'] as &$condition)
            {
                $argument_cond.= ' AND ('.$condition.')';
            }
            unset($condition);
        }
        $cle.='_'.$argument_cond;

        if ( ! $liste_Code_groupe = $cache_db->read($cle) )
        {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ( $argument_cond!='' )
            {
                if ( strpos($argument_cond, 'groupe_Nom')!==false ) { $liste_colonnes_a_indexer['groupe_Nom'] = 'groupe_Nom'; }
                if ( strpos($argument_cond, 'groupe_Logo_Fichier')!==false ) { $liste_colonnes_a_indexer['groupe_Logo_Fichier'] = 'groupe_Logo_Fichier'; }
                if ( strpos($argument_cond, 'groupe_Effectif')!==false ) { $liste_colonnes_a_indexer['groupe_Effectif'] = 'groupe_Effectif'; }
                if ( strpos($argument_cond, 'groupe_Actif')!==false ) { $liste_colonnes_a_indexer['groupe_Actif'] = 'groupe_Actif'; }
                if ( strpos($argument_cond, 'groupe_Date_creation')!==false ) { $liste_colonnes_a_indexer['groupe_Date_creation'] = 'groupe_Date_creation'; }
                if ( strpos($argument_cond, 'groupe_Delai_suppression_jour')!==false ) { $liste_colonnes_a_indexer['groupe_Delai_suppression_jour'] = 'groupe_Delai_suppression_jour'; }
                if ( strpos($argument_cond, 'groupe_Suppression_active')!==false ) { $liste_colonnes_a_indexer['groupe_Suppression_active'] = 'groupe_Suppression_active'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = $cache_db->read('groupe__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('groupe').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('groupe__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    $cache_db->pause('groupe__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('groupe').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                    $cache_db->reprendre('groupe__index');
                }
            }

            $liste_Code_groupe = array();
            $res_requete = executer_requete_mysql('SELECT Code_groupe FROM '.inst('groupe')." WHERE Code_campagne IN ".Sql_Format_Liste($liste_Code_campagne).$argument_cond.";", false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $liste_Code_groupe[] = (int) $row_requete['Code_groupe'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste_Code_groupe);
        }
        return $liste_Code_groupe;
    }

    protected function groupe__liste_Code_groupe_vers_liste_Code_campagne( array $liste_Code_groupe, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ( $options===null ) { $options=[]; }
        $cache_db = new Mf_Cachedb("groupe");
        $cle = "liste_Code_groupe_vers_liste_Code_campagne__".Sql_Format_Liste($liste_Code_groupe);

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql']))
        {
            foreach ($options['cond_mysql'] as &$condition)
            {
                $argument_cond.= ' AND ('.$condition.')';
            }
            unset($condition);
        }
        $cle.='_'.$argument_cond;

        if ( ! $liste_Code_campagne = $cache_db->read($cle) )
        {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ( $argument_cond!='' )
            {
                if ( strpos($argument_cond, 'groupe_Nom')!==false ) { $liste_colonnes_a_indexer['groupe_Nom'] = 'groupe_Nom'; }
                if ( strpos($argument_cond, 'groupe_Logo_Fichier')!==false ) { $liste_colonnes_a_indexer['groupe_Logo_Fichier'] = 'groupe_Logo_Fichier'; }
                if ( strpos($argument_cond, 'groupe_Effectif')!==false ) { $liste_colonnes_a_indexer['groupe_Effectif'] = 'groupe_Effectif'; }
                if ( strpos($argument_cond, 'groupe_Actif')!==false ) { $liste_colonnes_a_indexer['groupe_Actif'] = 'groupe_Actif'; }
                if ( strpos($argument_cond, 'groupe_Date_creation')!==false ) { $liste_colonnes_a_indexer['groupe_Date_creation'] = 'groupe_Date_creation'; }
                if ( strpos($argument_cond, 'groupe_Delai_suppression_jour')!==false ) { $liste_colonnes_a_indexer['groupe_Delai_suppression_jour'] = 'groupe_Delai_suppression_jour'; }
                if ( strpos($argument_cond, 'groupe_Suppression_active')!==false ) { $liste_colonnes_a_indexer['groupe_Suppression_active'] = 'groupe_Suppression_active'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = $cache_db->read('groupe__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('groupe').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('groupe__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    $cache_db->pause('groupe__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('groupe').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                    $cache_db->reprendre('groupe__index');
                }
            }

            $controle_doublons = array();
            $liste_Code_campagne = array();
            $res_requete = executer_requete_mysql("SELECT Code_campagne FROM ".inst('groupe')." WHERE Code_groupe IN ".Sql_Format_Liste($liste_Code_groupe).$argument_cond.";", false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                if ( ! isset($controle_doublons[(int) $row_requete['Code_campagne']]) )
                {
                    $controle_doublons[(int) $row_requete['Code_campagne']] = 1;
                    $liste_Code_campagne[] = (int) $row_requete['Code_campagne'];
                }
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste_Code_campagne);
        }
        return $liste_Code_campagne;
    }

    private function mf_dupliquer_groupe( int $Code_groupe )
    {
        $code_erreur = 0;
        $Code_new_groupe = 0;
        $Code_groupe = round($Code_groupe);
        if ( !$this->mf_tester_existance_Code_groupe($Code_groupe) ) $code_erreur = 1;
        else
        {
            $donnees_a_copier = $this->mf_get($Code_groupe, array('autocompletion' => false));
            $groupe_Nom = $donnees_a_copier['groupe_Nom'];
            $groupe_Description = $donnees_a_copier['groupe_Description'];
            $groupe_Logo_Fichier = $donnees_a_copier['groupe_Logo_Fichier'];
            $groupe_Effectif = $donnees_a_copier['groupe_Effectif'];
            $groupe_Actif = $donnees_a_copier['groupe_Actif'];
            $groupe_Date_creation = $donnees_a_copier['groupe_Date_creation'];
            $groupe_Delai_suppression_jour = $donnees_a_copier['groupe_Delai_suppression_jour'];
            $groupe_Suppression_active = $donnees_a_copier['groupe_Suppression_active'];
            $groupe_Nom = text_sql($groupe_Nom);
            $groupe_Description = text_sql($groupe_Description);
            $groupe_Logo_Fichier = text_sql($groupe_Logo_Fichier);
            $groupe_Effectif = round($groupe_Effectif);
            $groupe_Actif = ($groupe_Actif==1 ? 1 : 0);
            $groupe_Date_creation = format_datetime($groupe_Date_creation);
            $groupe_Delai_suppression_jour = round($groupe_Delai_suppression_jour);
            $groupe_Suppression_active = ($groupe_Suppression_active==1 ? 1 : 0);
            $Code_campagne = round($donnees_a_copier['Code_campagne']);
            if ( isset($this->mf_dupliquer_table_de_conversion['Code_campagne'][$Code_campagne]) ) $Code_campagne = $this->mf_dupliquer_table_de_conversion['Code_campagne'][$Code_campagne];
            elseif ( isset($this->mf_dupliquer_table_de_conversion['Code_campagne'][0]) ) $Code_campagne = $this->mf_dupliquer_table_de_conversion['Code_campagne'][0];
            executer_requete_mysql("INSERT INTO groupe ( groupe_Nom, groupe_Description, groupe_Logo_Fichier, groupe_Effectif, groupe_Actif, groupe_Date_creation, groupe_Delai_suppression_jour, groupe_Suppression_active, Code_campagne ) VALUES ( '$groupe_Nom', '$groupe_Description', '$groupe_Logo_Fichier', $groupe_Effectif, $groupe_Actif, ".( $groupe_Date_creation!='' ? "'$groupe_Date_creation'" : 'NULL' ).", $groupe_Delai_suppression_jour, $groupe_Suppression_active, $Code_campagne );", true);
            $Code_new_groupe = requete_mysql_insert_id();
            if ($Code_new_groupe==0)
            {
                $code_erreur = 999999;
            }
            else
            {
                $cache_db = new Mf_Cachedb("groupe");
                $cache_db->clear();
                $liste_Code_personnage = $this->liste_Code_groupe_vers_liste_Code_personnage( array($Code_groupe) );
                foreach ($liste_Code_personnage as $Code_personnage)
                {
                    $this->mf_dupliquer_tables_a_dupliquer["personnage_$Code_personnage"]=array('personnage', $Code_personnage);
                }
                $liste_Code_carte = $this->liste_Code_groupe_vers_liste_Code_carte( array($Code_groupe) );
                foreach ($liste_Code_carte as $Code_carte)
                {
                    $this->mf_dupliquer_tables_a_dupliquer["carte_$Code_carte"]=array('carte', $Code_carte);
                }
                $this->mf_dupliquer_table_de_conversion['Code_groupe'][$Code_groupe] = $Code_new_groupe;
            }
        }
        return array('code_erreur' => $code_erreur, "Code_groupe" => $Code_new_groupe);
    }

/*
    +--------------+
    |  personnage  |
    +--------------+
*/

    protected function mf_tester_existance_Code_personnage( int $Code_personnage )
    {
        $Code_personnage = round($Code_personnage);
        $requete_sql = "SELECT Code_personnage FROM ".inst('personnage')." WHERE Code_personnage = $Code_personnage;";
        $cache_db = new Mf_Cachedb('personnage');
        if ( ! $r = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) $r = 'o'; else $r = 'n';
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $r);
        }
        return $r=='o';
    }

    protected function rechercher_personnage_Fichier_Fichier( string $personnage_Fichier_Fichier, ?int $Code_joueur=null, ?int $Code_groupe=null )
    {
        $Code_personnage = 0;
        $personnage_Fichier_Fichier = format_sql('personnage_Fichier_Fichier', $personnage_Fichier_Fichier);
        $Code_joueur = round($Code_joueur);
        $Code_groupe = round($Code_groupe);
        $requete_sql = 'SELECT Code_personnage FROM '.inst('personnage')." WHERE personnage_Fichier_Fichier = $personnage_Fichier_Fichier".( $Code_joueur!=0 ? " AND Code_joueur=$Code_joueur" : "" )."".( $Code_groupe!=0 ? " AND Code_groupe=$Code_groupe" : "" )." LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('personnage');
        if ( ! $Code_personnage = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $Code_personnage = (int) $row_requete['Code_personnage'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_personnage);
        }
        return $Code_personnage;
    }

    protected function rechercher_personnage_Conservation( bool $personnage_Conservation, ?int $Code_joueur=null, ?int $Code_groupe=null )
    {
        $Code_personnage = 0;
        $personnage_Conservation = format_sql('personnage_Conservation', $personnage_Conservation);
        $Code_joueur = round($Code_joueur);
        $Code_groupe = round($Code_groupe);
        $requete_sql = 'SELECT Code_personnage FROM '.inst('personnage')." WHERE personnage_Conservation = $personnage_Conservation".( $Code_joueur!=0 ? " AND Code_joueur=$Code_joueur" : "" )."".( $Code_groupe!=0 ? " AND Code_groupe=$Code_groupe" : "" )." LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('personnage');
        if ( ! $Code_personnage = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $Code_personnage = (int) $row_requete['Code_personnage'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_personnage);
        }
        return $Code_personnage;
    }

    protected function get_liste_Code_personnage(?int $Code_joueur=null, ?int $Code_groupe=null, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cache_db = new Mf_Cachedb("personnage");
        $cle = "personnage__lister_cles";
        $Code_joueur = round($Code_joueur);
        $cle.="_{$Code_joueur}";
        $Code_groupe = round($Code_groupe);
        $cle.="_{$Code_groupe}";

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql']))
        {
            foreach ($options['cond_mysql'] as &$condition)
            {
                $argument_cond.= ' AND ('.$condition.')';
            }
            unset($condition);
        }
        $cle.='_'.$argument_cond;

        if ( ! $liste = $cache_db->read($cle) )
        {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ( $argument_cond!='' )
            {
                if ( strpos($argument_cond, 'personnage_Fichier_Fichier')!==false ) { $liste_colonnes_a_indexer['personnage_Fichier_Fichier'] = 'personnage_Fichier_Fichier'; }
                if ( strpos($argument_cond, 'personnage_Conservation')!==false ) { $liste_colonnes_a_indexer['personnage_Conservation'] = 'personnage_Conservation'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = $cache_db->read('personnage__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('personnage').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('personnage__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    $cache_db->pause('personnage__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('personnage').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                    $cache_db->reprendre('personnage__index');
                }
            }

            $liste = array();
            $res_requete = executer_requete_mysql("SELECT Code_personnage FROM ".inst('personnage')." WHERE 1".( $Code_joueur!=0 ? " AND Code_joueur=$Code_joueur" : "" )."".( $Code_groupe!=0 ? " AND Code_groupe=$Code_groupe" : "" )."".$argument_cond.";", false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $liste[] = (int) $row_requete['Code_personnage'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste);
        }
        return $liste;
    }

    protected function Code_personnage_vers_Code_joueur( int $Code_personnage )
    {
        $Code_personnage = round($Code_personnage);
        if ($Code_personnage<0) $Code_personnage = 0;
        $p = floor($Code_personnage/100);
        $start = $p*100;
        $end = ($p+1)*100;
        $cache_db = new Mf_Cachedb('personnage');
        $cle = 'Code_personnage_vers_Code_joueur__'.$start.'__'.$end;
        if ( ! $conversion = $cache_db->read($cle) )
        {
            $res_requete = executer_requete_mysql('SELECT Code_personnage, Code_joueur FROM '.inst('personnage').' WHERE '.$start.' <= Code_personnage AND Code_personnage < '.$end.';', false);
            $conversion = array();
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $conversion[(int) $row_requete['Code_personnage']] = (int) $row_requete['Code_joueur'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $conversion);
        }
        return ( isset($conversion[$Code_personnage]) ? $conversion[$Code_personnage] : 0 );
    }

    protected function Code_personnage_vers_Code_groupe( int $Code_personnage )
    {
        $Code_personnage = round($Code_personnage);
        if ($Code_personnage<0) $Code_personnage = 0;
        $p = floor($Code_personnage/100);
        $start = $p*100;
        $end = ($p+1)*100;
        $cache_db = new Mf_Cachedb('personnage');
        $cle = 'Code_personnage_vers_Code_groupe__'.$start.'__'.$end;
        if ( ! $conversion = $cache_db->read($cle) )
        {
            $res_requete = executer_requete_mysql('SELECT Code_personnage, Code_groupe FROM '.inst('personnage').' WHERE '.$start.' <= Code_personnage AND Code_personnage < '.$end.';', false);
            $conversion = array();
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $conversion[(int) $row_requete['Code_personnage']] = (int) $row_requete['Code_groupe'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $conversion);
        }
        return ( isset($conversion[$Code_personnage]) ? $conversion[$Code_personnage] : 0 );
    }

    protected function liste_Code_joueur_vers_liste_Code_personnage( array $liste_Code_joueur, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ( $options===null ) { $options=[]; }
        $cache_db = new Mf_Cachedb("personnage");
        $cle = "liste_Code_joueur_vers_liste_Code_personnage__".Sql_Format_Liste($liste_Code_joueur);

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql']))
        {
            foreach ($options['cond_mysql'] as &$condition)
            {
                $argument_cond.= ' AND ('.$condition.')';
            }
            unset($condition);
        }
        $cle.='_'.$argument_cond;

        if ( ! $liste_Code_personnage = $cache_db->read($cle) )
        {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ( $argument_cond!='' )
            {
                if ( strpos($argument_cond, 'personnage_Fichier_Fichier')!==false ) { $liste_colonnes_a_indexer['personnage_Fichier_Fichier'] = 'personnage_Fichier_Fichier'; }
                if ( strpos($argument_cond, 'personnage_Conservation')!==false ) { $liste_colonnes_a_indexer['personnage_Conservation'] = 'personnage_Conservation'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = $cache_db->read('personnage__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('personnage').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('personnage__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    $cache_db->pause('personnage__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('personnage').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                    $cache_db->reprendre('personnage__index');
                }
            }

            $liste_Code_personnage = array();
            $res_requete = executer_requete_mysql('SELECT Code_personnage FROM '.inst('personnage')." WHERE Code_joueur IN ".Sql_Format_Liste($liste_Code_joueur).$argument_cond.";", false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $liste_Code_personnage[] = (int) $row_requete['Code_personnage'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste_Code_personnage);
        }
        return $liste_Code_personnage;
    }

    protected function personnage__liste_Code_personnage_vers_liste_Code_joueur( array $liste_Code_personnage, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ( $options===null ) { $options=[]; }
        $cache_db = new Mf_Cachedb("personnage");
        $cle = "liste_Code_personnage_vers_liste_Code_joueur__".Sql_Format_Liste($liste_Code_personnage);

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql']))
        {
            foreach ($options['cond_mysql'] as &$condition)
            {
                $argument_cond.= ' AND ('.$condition.')';
            }
            unset($condition);
        }
        $cle.='_'.$argument_cond;

        if ( ! $liste_Code_joueur = $cache_db->read($cle) )
        {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ( $argument_cond!='' )
            {
                if ( strpos($argument_cond, 'personnage_Fichier_Fichier')!==false ) { $liste_colonnes_a_indexer['personnage_Fichier_Fichier'] = 'personnage_Fichier_Fichier'; }
                if ( strpos($argument_cond, 'personnage_Conservation')!==false ) { $liste_colonnes_a_indexer['personnage_Conservation'] = 'personnage_Conservation'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = $cache_db->read('personnage__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('personnage').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('personnage__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    $cache_db->pause('personnage__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('personnage').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                    $cache_db->reprendre('personnage__index');
                }
            }

            $controle_doublons = array();
            $liste_Code_joueur = array();
            $res_requete = executer_requete_mysql("SELECT Code_joueur FROM ".inst('personnage')." WHERE Code_personnage IN ".Sql_Format_Liste($liste_Code_personnage).$argument_cond.";", false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                if ( ! isset($controle_doublons[(int) $row_requete['Code_joueur']]) )
                {
                    $controle_doublons[(int) $row_requete['Code_joueur']] = 1;
                    $liste_Code_joueur[] = (int) $row_requete['Code_joueur'];
                }
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste_Code_joueur);
        }
        return $liste_Code_joueur;
    }

    protected function liste_Code_groupe_vers_liste_Code_personnage( array $liste_Code_groupe, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ( $options===null ) { $options=[]; }
        $cache_db = new Mf_Cachedb("personnage");
        $cle = "liste_Code_groupe_vers_liste_Code_personnage__".Sql_Format_Liste($liste_Code_groupe);

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql']))
        {
            foreach ($options['cond_mysql'] as &$condition)
            {
                $argument_cond.= ' AND ('.$condition.')';
            }
            unset($condition);
        }
        $cle.='_'.$argument_cond;

        if ( ! $liste_Code_personnage = $cache_db->read($cle) )
        {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ( $argument_cond!='' )
            {
                if ( strpos($argument_cond, 'personnage_Fichier_Fichier')!==false ) { $liste_colonnes_a_indexer['personnage_Fichier_Fichier'] = 'personnage_Fichier_Fichier'; }
                if ( strpos($argument_cond, 'personnage_Conservation')!==false ) { $liste_colonnes_a_indexer['personnage_Conservation'] = 'personnage_Conservation'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = $cache_db->read('personnage__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('personnage').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('personnage__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    $cache_db->pause('personnage__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('personnage').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                    $cache_db->reprendre('personnage__index');
                }
            }

            $liste_Code_personnage = array();
            $res_requete = executer_requete_mysql('SELECT Code_personnage FROM '.inst('personnage')." WHERE Code_groupe IN ".Sql_Format_Liste($liste_Code_groupe).$argument_cond.";", false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $liste_Code_personnage[] = (int) $row_requete['Code_personnage'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste_Code_personnage);
        }
        return $liste_Code_personnage;
    }

    protected function personnage__liste_Code_personnage_vers_liste_Code_groupe( array $liste_Code_personnage, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ( $options===null ) { $options=[]; }
        $cache_db = new Mf_Cachedb("personnage");
        $cle = "liste_Code_personnage_vers_liste_Code_groupe__".Sql_Format_Liste($liste_Code_personnage);

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql']))
        {
            foreach ($options['cond_mysql'] as &$condition)
            {
                $argument_cond.= ' AND ('.$condition.')';
            }
            unset($condition);
        }
        $cle.='_'.$argument_cond;

        if ( ! $liste_Code_groupe = $cache_db->read($cle) )
        {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ( $argument_cond!='' )
            {
                if ( strpos($argument_cond, 'personnage_Fichier_Fichier')!==false ) { $liste_colonnes_a_indexer['personnage_Fichier_Fichier'] = 'personnage_Fichier_Fichier'; }
                if ( strpos($argument_cond, 'personnage_Conservation')!==false ) { $liste_colonnes_a_indexer['personnage_Conservation'] = 'personnage_Conservation'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = $cache_db->read('personnage__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('personnage').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('personnage__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    $cache_db->pause('personnage__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('personnage').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                    $cache_db->reprendre('personnage__index');
                }
            }

            $controle_doublons = array();
            $liste_Code_groupe = array();
            $res_requete = executer_requete_mysql("SELECT Code_groupe FROM ".inst('personnage')." WHERE Code_personnage IN ".Sql_Format_Liste($liste_Code_personnage).$argument_cond.";", false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                if ( ! isset($controle_doublons[(int) $row_requete['Code_groupe']]) )
                {
                    $controle_doublons[(int) $row_requete['Code_groupe']] = 1;
                    $liste_Code_groupe[] = (int) $row_requete['Code_groupe'];
                }
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste_Code_groupe);
        }
        return $liste_Code_groupe;
    }

    private function mf_dupliquer_personnage( int $Code_personnage )
    {
        $code_erreur = 0;
        $Code_new_personnage = 0;
        $Code_personnage = round($Code_personnage);
        if ( !$this->mf_tester_existance_Code_personnage($Code_personnage) ) $code_erreur = 1;
        else
        {
            $donnees_a_copier = $this->mf_get($Code_personnage, array('autocompletion' => false));
            $personnage_Fichier_Fichier = $donnees_a_copier['personnage_Fichier_Fichier'];
            $personnage_Conservation = $donnees_a_copier['personnage_Conservation'];
            $personnage_Fichier_Fichier = text_sql($personnage_Fichier_Fichier);
            $personnage_Conservation = ($personnage_Conservation==1 ? 1 : 0);
            $Code_joueur = round($donnees_a_copier['Code_joueur']);
            if ( isset($this->mf_dupliquer_table_de_conversion['Code_joueur'][$Code_joueur]) ) $Code_joueur = $this->mf_dupliquer_table_de_conversion['Code_joueur'][$Code_joueur];
            elseif ( isset($this->mf_dupliquer_table_de_conversion['Code_joueur'][0]) ) $Code_joueur = $this->mf_dupliquer_table_de_conversion['Code_joueur'][0];
            $Code_groupe = round($donnees_a_copier['Code_groupe']);
            if ( isset($this->mf_dupliquer_table_de_conversion['Code_groupe'][$Code_groupe]) ) $Code_groupe = $this->mf_dupliquer_table_de_conversion['Code_groupe'][$Code_groupe];
            elseif ( isset($this->mf_dupliquer_table_de_conversion['Code_groupe'][0]) ) $Code_groupe = $this->mf_dupliquer_table_de_conversion['Code_groupe'][0];
            executer_requete_mysql("INSERT INTO personnage ( personnage_Fichier_Fichier, personnage_Conservation, Code_joueur, Code_groupe ) VALUES ( '$personnage_Fichier_Fichier', $personnage_Conservation, $Code_joueur, $Code_groupe );", true);
            $Code_new_personnage = requete_mysql_insert_id();
            if ($Code_new_personnage==0)
            {
                $code_erreur = 999999;
            }
            else
            {
                $cache_db = new Mf_Cachedb("personnage");
                $cache_db->clear();
                $this->mf_dupliquer_table_de_conversion['Code_personnage'][$Code_personnage] = $Code_new_personnage;
            }
        }
        return array('code_erreur' => $code_erreur, "Code_personnage" => $Code_new_personnage);
    }

/*
    +------------+
    |  campagne  |
    +------------+
*/

    protected function mf_tester_existance_Code_campagne( int $Code_campagne )
    {
        $Code_campagne = round($Code_campagne);
        $requete_sql = "SELECT Code_campagne FROM ".inst('campagne')." WHERE Code_campagne = $Code_campagne;";
        $cache_db = new Mf_Cachedb('campagne');
        if ( ! $r = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) $r = 'o'; else $r = 'n';
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $r);
        }
        return $r=='o';
    }

    protected function rechercher_campagne_Nom( string $campagne_Nom )
    {
        $Code_campagne = 0;
        $campagne_Nom = format_sql('campagne_Nom', $campagne_Nom);
        $requete_sql = 'SELECT Code_campagne FROM '.inst('campagne')." WHERE campagne_Nom = $campagne_Nom LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('campagne');
        if ( ! $Code_campagne = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $Code_campagne = (int) $row_requete['Code_campagne'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_campagne);
        }
        return $Code_campagne;
    }

    protected function rechercher_campagne_Image_Fichier( string $campagne_Image_Fichier )
    {
        $Code_campagne = 0;
        $campagne_Image_Fichier = format_sql('campagne_Image_Fichier', $campagne_Image_Fichier);
        $requete_sql = 'SELECT Code_campagne FROM '.inst('campagne')." WHERE campagne_Image_Fichier = $campagne_Image_Fichier LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('campagne');
        if ( ! $Code_campagne = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $Code_campagne = (int) $row_requete['Code_campagne'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_campagne);
        }
        return $Code_campagne;
    }

    protected function rechercher_campagne_Nombre_joueur( int $campagne_Nombre_joueur )
    {
        $Code_campagne = 0;
        $campagne_Nombre_joueur = format_sql('campagne_Nombre_joueur', $campagne_Nombre_joueur);
        $requete_sql = 'SELECT Code_campagne FROM '.inst('campagne')." WHERE campagne_Nombre_joueur = $campagne_Nombre_joueur LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('campagne');
        if ( ! $Code_campagne = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $Code_campagne = (int) $row_requete['Code_campagne'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_campagne);
        }
        return $Code_campagne;
    }

    protected function rechercher_campagne_Nombre_mj( int $campagne_Nombre_mj )
    {
        $Code_campagne = 0;
        $campagne_Nombre_mj = format_sql('campagne_Nombre_mj', $campagne_Nombre_mj);
        $requete_sql = 'SELECT Code_campagne FROM '.inst('campagne')." WHERE campagne_Nombre_mj = $campagne_Nombre_mj LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('campagne');
        if ( ! $Code_campagne = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $Code_campagne = (int) $row_requete['Code_campagne'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_campagne);
        }
        return $Code_campagne;
    }

    protected function get_liste_Code_campagne(?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cache_db = new Mf_Cachedb("campagne");
        $cle = "campagne__lister_cles";

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql']))
        {
            foreach ($options['cond_mysql'] as &$condition)
            {
                $argument_cond.= ' AND ('.$condition.')';
            }
            unset($condition);
        }
        $cle.='_'.$argument_cond;

        if ( ! $liste = $cache_db->read($cle) )
        {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ( $argument_cond!='' )
            {
                if ( strpos($argument_cond, 'campagne_Nom')!==false ) { $liste_colonnes_a_indexer['campagne_Nom'] = 'campagne_Nom'; }
                if ( strpos($argument_cond, 'campagne_Image_Fichier')!==false ) { $liste_colonnes_a_indexer['campagne_Image_Fichier'] = 'campagne_Image_Fichier'; }
                if ( strpos($argument_cond, 'campagne_Nombre_joueur')!==false ) { $liste_colonnes_a_indexer['campagne_Nombre_joueur'] = 'campagne_Nombre_joueur'; }
                if ( strpos($argument_cond, 'campagne_Nombre_mj')!==false ) { $liste_colonnes_a_indexer['campagne_Nombre_mj'] = 'campagne_Nombre_mj'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = $cache_db->read('campagne__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('campagne').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('campagne__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    $cache_db->pause('campagne__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('campagne').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                    $cache_db->reprendre('campagne__index');
                }
            }

            $liste = array();
            $res_requete = executer_requete_mysql("SELECT Code_campagne FROM ".inst('campagne')." WHERE 1".$argument_cond.";", false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $liste[] = (int) $row_requete['Code_campagne'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste);
        }
        return $liste;
    }

    private function mf_dupliquer_campagne( int $Code_campagne )
    {
        $code_erreur = 0;
        $Code_new_campagne = 0;
        $Code_campagne = round($Code_campagne);
        if ( !$this->mf_tester_existance_Code_campagne($Code_campagne) ) $code_erreur = 1;
        else
        {
            $donnees_a_copier = $this->mf_get($Code_campagne, array('autocompletion' => false));
            $campagne_Nom = $donnees_a_copier['campagne_Nom'];
            $campagne_Description = $donnees_a_copier['campagne_Description'];
            $campagne_Image_Fichier = $donnees_a_copier['campagne_Image_Fichier'];
            $campagne_Nombre_joueur = $donnees_a_copier['campagne_Nombre_joueur'];
            $campagne_Nombre_mj = $donnees_a_copier['campagne_Nombre_mj'];
            $campagne_Nom = text_sql($campagne_Nom);
            $campagne_Description = text_sql($campagne_Description);
            $campagne_Image_Fichier = text_sql($campagne_Image_Fichier);
            $campagne_Nombre_joueur = round($campagne_Nombre_joueur);
            $campagne_Nombre_mj = round($campagne_Nombre_mj);
            executer_requete_mysql("INSERT INTO campagne ( campagne_Nom, campagne_Description, campagne_Image_Fichier, campagne_Nombre_joueur, campagne_Nombre_mj ) VALUES ( '$campagne_Nom', '$campagne_Description', '$campagne_Image_Fichier', $campagne_Nombre_joueur, $campagne_Nombre_mj );", true);
            $Code_new_campagne = requete_mysql_insert_id();
            if ($Code_new_campagne==0)
            {
                $code_erreur = 999999;
            }
            else
            {
                $cache_db = new Mf_Cachedb("campagne");
                $cache_db->clear();
                $liste_Code_groupe = $this->liste_Code_campagne_vers_liste_Code_groupe( array($Code_campagne) );
                foreach ($liste_Code_groupe as $Code_groupe)
                {
                    $this->mf_dupliquer_tables_a_dupliquer["groupe_$Code_groupe"]=array('groupe', $Code_groupe);
                }
                $this->mf_dupliquer_table_de_conversion['Code_campagne'][$Code_campagne] = $Code_new_campagne;
            }
        }
        return array('code_erreur' => $code_erreur, "Code_campagne" => $Code_new_campagne);
    }

/*
    +----------------+
    |  tag_campagne  |
    +----------------+
*/

    protected function mf_tester_existance_Code_tag_campagne( int $Code_tag_campagne )
    {
        $Code_tag_campagne = round($Code_tag_campagne);
        $requete_sql = "SELECT Code_tag_campagne FROM ".inst('tag_campagne')." WHERE Code_tag_campagne = $Code_tag_campagne;";
        $cache_db = new Mf_Cachedb('tag_campagne');
        if ( ! $r = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) $r = 'o'; else $r = 'n';
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $r);
        }
        return $r=='o';
    }

    protected function rechercher_tag_campagne_Libelle( string $tag_campagne_Libelle )
    {
        $Code_tag_campagne = 0;
        $tag_campagne_Libelle = format_sql('tag_campagne_Libelle', $tag_campagne_Libelle);
        $requete_sql = 'SELECT Code_tag_campagne FROM '.inst('tag_campagne')." WHERE tag_campagne_Libelle = $tag_campagne_Libelle LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('tag_campagne');
        if ( ! $Code_tag_campagne = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $Code_tag_campagne = (int) $row_requete['Code_tag_campagne'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_tag_campagne);
        }
        return $Code_tag_campagne;
    }

    protected function get_liste_Code_tag_campagne(?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cache_db = new Mf_Cachedb("tag_campagne");
        $cle = "tag_campagne__lister_cles";

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql']))
        {
            foreach ($options['cond_mysql'] as &$condition)
            {
                $argument_cond.= ' AND ('.$condition.')';
            }
            unset($condition);
        }
        $cle.='_'.$argument_cond;

        if ( ! $liste = $cache_db->read($cle) )
        {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ( $argument_cond!='' )
            {
                if ( strpos($argument_cond, 'tag_campagne_Libelle')!==false ) { $liste_colonnes_a_indexer['tag_campagne_Libelle'] = 'tag_campagne_Libelle'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = $cache_db->read('tag_campagne__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('tag_campagne').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('tag_campagne__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    $cache_db->pause('tag_campagne__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('tag_campagne').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                    $cache_db->reprendre('tag_campagne__index');
                }
            }

            $liste = array();
            $res_requete = executer_requete_mysql("SELECT Code_tag_campagne FROM ".inst('tag_campagne')." WHERE 1".$argument_cond.";", false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $liste[] = (int) $row_requete['Code_tag_campagne'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste);
        }
        return $liste;
    }

    private function mf_dupliquer_tag_campagne( int $Code_tag_campagne )
    {
        $code_erreur = 0;
        $Code_new_tag_campagne = 0;
        $Code_tag_campagne = round($Code_tag_campagne);
        if ( !$this->mf_tester_existance_Code_tag_campagne($Code_tag_campagne) ) $code_erreur = 1;
        else
        {
            $donnees_a_copier = $this->mf_get($Code_tag_campagne, array('autocompletion' => false));
            $tag_campagne_Libelle = $donnees_a_copier['tag_campagne_Libelle'];
            $tag_campagne_Libelle = text_sql($tag_campagne_Libelle);
            executer_requete_mysql("INSERT INTO tag_campagne ( tag_campagne_Libelle ) VALUES ( '$tag_campagne_Libelle' );", true);
            $Code_new_tag_campagne = requete_mysql_insert_id();
            if ($Code_new_tag_campagne==0)
            {
                $code_erreur = 999999;
            }
            else
            {
                $cache_db = new Mf_Cachedb("tag_campagne");
                $cache_db->clear();
                $this->mf_dupliquer_table_de_conversion['Code_tag_campagne'][$Code_tag_campagne] = $Code_new_tag_campagne;
            }
        }
        return array('code_erreur' => $code_erreur, "Code_tag_campagne" => $Code_new_tag_campagne);
    }

/*
    +---------+
    |  carte  |
    +---------+
*/

    protected function mf_tester_existance_Code_carte( int $Code_carte )
    {
        $Code_carte = round($Code_carte);
        $requete_sql = "SELECT Code_carte FROM ".inst('carte')." WHERE Code_carte = $Code_carte;";
        $cache_db = new Mf_Cachedb('carte');
        if ( ! $r = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) $r = 'o'; else $r = 'n';
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $r);
        }
        return $r=='o';
    }

    protected function rechercher_carte_Nom( string $carte_Nom, ?int $Code_groupe=null )
    {
        $Code_carte = 0;
        $carte_Nom = format_sql('carte_Nom', $carte_Nom);
        $Code_groupe = round($Code_groupe);
        $requete_sql = 'SELECT Code_carte FROM '.inst('carte')." WHERE carte_Nom = $carte_Nom".( $Code_groupe!=0 ? " AND Code_groupe=$Code_groupe" : "" )." LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('carte');
        if ( ! $Code_carte = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $Code_carte = (int) $row_requete['Code_carte'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_carte);
        }
        return $Code_carte;
    }

    protected function rechercher_carte_Hauteur( int $carte_Hauteur, ?int $Code_groupe=null )
    {
        $Code_carte = 0;
        $carte_Hauteur = format_sql('carte_Hauteur', $carte_Hauteur);
        $Code_groupe = round($Code_groupe);
        $requete_sql = 'SELECT Code_carte FROM '.inst('carte')." WHERE carte_Hauteur = $carte_Hauteur".( $Code_groupe!=0 ? " AND Code_groupe=$Code_groupe" : "" )." LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('carte');
        if ( ! $Code_carte = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $Code_carte = (int) $row_requete['Code_carte'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_carte);
        }
        return $Code_carte;
    }

    protected function rechercher_carte_Largeur( int $carte_Largeur, ?int $Code_groupe=null )
    {
        $Code_carte = 0;
        $carte_Largeur = format_sql('carte_Largeur', $carte_Largeur);
        $Code_groupe = round($Code_groupe);
        $requete_sql = 'SELECT Code_carte FROM '.inst('carte')." WHERE carte_Largeur = $carte_Largeur".( $Code_groupe!=0 ? " AND Code_groupe=$Code_groupe" : "" )." LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('carte');
        if ( ! $Code_carte = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $Code_carte = (int) $row_requete['Code_carte'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_carte);
        }
        return $Code_carte;
    }

    protected function rechercher_carte_Fichier( string $carte_Fichier, ?int $Code_groupe=null )
    {
        $Code_carte = 0;
        $carte_Fichier = format_sql('carte_Fichier', $carte_Fichier);
        $Code_groupe = round($Code_groupe);
        $requete_sql = 'SELECT Code_carte FROM '.inst('carte')." WHERE carte_Fichier = $carte_Fichier".( $Code_groupe!=0 ? " AND Code_groupe=$Code_groupe" : "" )." LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('carte');
        if ( ! $Code_carte = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $Code_carte = (int) $row_requete['Code_carte'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_carte);
        }
        return $Code_carte;
    }

    protected function get_liste_Code_carte(?int $Code_groupe=null, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cache_db = new Mf_Cachedb("carte");
        $cle = "carte__lister_cles";
        $Code_groupe = round($Code_groupe);
        $cle.="_{$Code_groupe}";

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql']))
        {
            foreach ($options['cond_mysql'] as &$condition)
            {
                $argument_cond.= ' AND ('.$condition.')';
            }
            unset($condition);
        }
        $cle.='_'.$argument_cond;

        if ( ! $liste = $cache_db->read($cle) )
        {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ( $argument_cond!='' )
            {
                if ( strpos($argument_cond, 'carte_Nom')!==false ) { $liste_colonnes_a_indexer['carte_Nom'] = 'carte_Nom'; }
                if ( strpos($argument_cond, 'carte_Hauteur')!==false ) { $liste_colonnes_a_indexer['carte_Hauteur'] = 'carte_Hauteur'; }
                if ( strpos($argument_cond, 'carte_Largeur')!==false ) { $liste_colonnes_a_indexer['carte_Largeur'] = 'carte_Largeur'; }
                if ( strpos($argument_cond, 'carte_Fichier')!==false ) { $liste_colonnes_a_indexer['carte_Fichier'] = 'carte_Fichier'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = $cache_db->read('carte__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('carte').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('carte__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    $cache_db->pause('carte__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('carte').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                    $cache_db->reprendre('carte__index');
                }
            }

            $liste = array();
            $res_requete = executer_requete_mysql("SELECT Code_carte FROM ".inst('carte')." WHERE 1".( $Code_groupe!=0 ? " AND Code_groupe=$Code_groupe" : "" )."".$argument_cond.";", false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $liste[] = (int) $row_requete['Code_carte'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste);
        }
        return $liste;
    }

    protected function Code_carte_vers_Code_groupe( int $Code_carte )
    {
        $Code_carte = round($Code_carte);
        if ($Code_carte<0) $Code_carte = 0;
        $p = floor($Code_carte/100);
        $start = $p*100;
        $end = ($p+1)*100;
        $cache_db = new Mf_Cachedb('carte');
        $cle = 'Code_carte_vers_Code_groupe__'.$start.'__'.$end;
        if ( ! $conversion = $cache_db->read($cle) )
        {
            $res_requete = executer_requete_mysql('SELECT Code_carte, Code_groupe FROM '.inst('carte').' WHERE '.$start.' <= Code_carte AND Code_carte < '.$end.';', false);
            $conversion = array();
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $conversion[(int) $row_requete['Code_carte']] = (int) $row_requete['Code_groupe'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $conversion);
        }
        return ( isset($conversion[$Code_carte]) ? $conversion[$Code_carte] : 0 );
    }

    protected function liste_Code_groupe_vers_liste_Code_carte( array $liste_Code_groupe, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ( $options===null ) { $options=[]; }
        $cache_db = new Mf_Cachedb("carte");
        $cle = "liste_Code_groupe_vers_liste_Code_carte__".Sql_Format_Liste($liste_Code_groupe);

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql']))
        {
            foreach ($options['cond_mysql'] as &$condition)
            {
                $argument_cond.= ' AND ('.$condition.')';
            }
            unset($condition);
        }
        $cle.='_'.$argument_cond;

        if ( ! $liste_Code_carte = $cache_db->read($cle) )
        {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ( $argument_cond!='' )
            {
                if ( strpos($argument_cond, 'carte_Nom')!==false ) { $liste_colonnes_a_indexer['carte_Nom'] = 'carte_Nom'; }
                if ( strpos($argument_cond, 'carte_Hauteur')!==false ) { $liste_colonnes_a_indexer['carte_Hauteur'] = 'carte_Hauteur'; }
                if ( strpos($argument_cond, 'carte_Largeur')!==false ) { $liste_colonnes_a_indexer['carte_Largeur'] = 'carte_Largeur'; }
                if ( strpos($argument_cond, 'carte_Fichier')!==false ) { $liste_colonnes_a_indexer['carte_Fichier'] = 'carte_Fichier'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = $cache_db->read('carte__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('carte').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('carte__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    $cache_db->pause('carte__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('carte').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                    $cache_db->reprendre('carte__index');
                }
            }

            $liste_Code_carte = array();
            $res_requete = executer_requete_mysql('SELECT Code_carte FROM '.inst('carte')." WHERE Code_groupe IN ".Sql_Format_Liste($liste_Code_groupe).$argument_cond.";", false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $liste_Code_carte[] = (int) $row_requete['Code_carte'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste_Code_carte);
        }
        return $liste_Code_carte;
    }

    protected function carte__liste_Code_carte_vers_liste_Code_groupe( array $liste_Code_carte, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ( $options===null ) { $options=[]; }
        $cache_db = new Mf_Cachedb("carte");
        $cle = "liste_Code_carte_vers_liste_Code_groupe__".Sql_Format_Liste($liste_Code_carte);

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql']))
        {
            foreach ($options['cond_mysql'] as &$condition)
            {
                $argument_cond.= ' AND ('.$condition.')';
            }
            unset($condition);
        }
        $cle.='_'.$argument_cond;

        if ( ! $liste_Code_groupe = $cache_db->read($cle) )
        {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ( $argument_cond!='' )
            {
                if ( strpos($argument_cond, 'carte_Nom')!==false ) { $liste_colonnes_a_indexer['carte_Nom'] = 'carte_Nom'; }
                if ( strpos($argument_cond, 'carte_Hauteur')!==false ) { $liste_colonnes_a_indexer['carte_Hauteur'] = 'carte_Hauteur'; }
                if ( strpos($argument_cond, 'carte_Largeur')!==false ) { $liste_colonnes_a_indexer['carte_Largeur'] = 'carte_Largeur'; }
                if ( strpos($argument_cond, 'carte_Fichier')!==false ) { $liste_colonnes_a_indexer['carte_Fichier'] = 'carte_Fichier'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = $cache_db->read('carte__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('carte').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('carte__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    $cache_db->pause('carte__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('carte').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                    $cache_db->reprendre('carte__index');
                }
            }

            $controle_doublons = array();
            $liste_Code_groupe = array();
            $res_requete = executer_requete_mysql("SELECT Code_groupe FROM ".inst('carte')." WHERE Code_carte IN ".Sql_Format_Liste($liste_Code_carte).$argument_cond.";", false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                if ( ! isset($controle_doublons[(int) $row_requete['Code_groupe']]) )
                {
                    $controle_doublons[(int) $row_requete['Code_groupe']] = 1;
                    $liste_Code_groupe[] = (int) $row_requete['Code_groupe'];
                }
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste_Code_groupe);
        }
        return $liste_Code_groupe;
    }

    private function mf_dupliquer_carte( int $Code_carte )
    {
        $code_erreur = 0;
        $Code_new_carte = 0;
        $Code_carte = round($Code_carte);
        if ( !$this->mf_tester_existance_Code_carte($Code_carte) ) $code_erreur = 1;
        else
        {
            $donnees_a_copier = $this->mf_get($Code_carte, array('autocompletion' => false));
            $carte_Nom = $donnees_a_copier['carte_Nom'];
            $carte_Hauteur = $donnees_a_copier['carte_Hauteur'];
            $carte_Largeur = $donnees_a_copier['carte_Largeur'];
            $carte_Fichier = $donnees_a_copier['carte_Fichier'];
            $carte_Nom = text_sql($carte_Nom);
            $carte_Hauteur = round($carte_Hauteur);
            $carte_Largeur = round($carte_Largeur);
            $carte_Fichier = text_sql($carte_Fichier);
            $Code_groupe = round($donnees_a_copier['Code_groupe']);
            if ( isset($this->mf_dupliquer_table_de_conversion['Code_groupe'][$Code_groupe]) ) $Code_groupe = $this->mf_dupliquer_table_de_conversion['Code_groupe'][$Code_groupe];
            elseif ( isset($this->mf_dupliquer_table_de_conversion['Code_groupe'][0]) ) $Code_groupe = $this->mf_dupliquer_table_de_conversion['Code_groupe'][0];
            executer_requete_mysql("INSERT INTO carte ( carte_Nom, carte_Hauteur, carte_Largeur, carte_Fichier, Code_groupe ) VALUES ( '$carte_Nom', $carte_Hauteur, $carte_Largeur, '$carte_Fichier', $Code_groupe );", true);
            $Code_new_carte = requete_mysql_insert_id();
            if ($Code_new_carte==0)
            {
                $code_erreur = 999999;
            }
            else
            {
                $cache_db = new Mf_Cachedb("carte");
                $cache_db->clear();
                $this->mf_dupliquer_table_de_conversion['Code_carte'][$Code_carte] = $Code_new_carte;
            }
        }
        return array('code_erreur' => $code_erreur, "Code_carte" => $Code_new_carte);
    }

/*
    +---------+
    |  objet  |
    +---------+
*/

    protected function mf_tester_existance_Code_objet( int $Code_objet )
    {
        $Code_objet = round($Code_objet);
        $requete_sql = "SELECT Code_objet FROM ".inst('objet')." WHERE Code_objet = $Code_objet;";
        $cache_db = new Mf_Cachedb('objet');
        if ( ! $r = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) $r = 'o'; else $r = 'n';
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $r);
        }
        return $r=='o';
    }

    protected function rechercher_objet_Libelle( string $objet_Libelle, ?int $Code_type=null )
    {
        $Code_objet = 0;
        $objet_Libelle = format_sql('objet_Libelle', $objet_Libelle);
        $Code_type = round($Code_type);
        $requete_sql = 'SELECT Code_objet FROM '.inst('objet')." WHERE objet_Libelle = $objet_Libelle".( $Code_type!=0 ? " AND Code_type=$Code_type" : "" )." LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('objet');
        if ( ! $Code_objet = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $Code_objet = (int) $row_requete['Code_objet'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_objet);
        }
        return $Code_objet;
    }

    protected function rechercher_objet_Image_Fichier( string $objet_Image_Fichier, ?int $Code_type=null )
    {
        $Code_objet = 0;
        $objet_Image_Fichier = format_sql('objet_Image_Fichier', $objet_Image_Fichier);
        $Code_type = round($Code_type);
        $requete_sql = 'SELECT Code_objet FROM '.inst('objet')." WHERE objet_Image_Fichier = $objet_Image_Fichier".( $Code_type!=0 ? " AND Code_type=$Code_type" : "" )." LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('objet');
        if ( ! $Code_objet = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $Code_objet = (int) $row_requete['Code_objet'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_objet);
        }
        return $Code_objet;
    }

    protected function get_liste_Code_objet(?int $Code_type=null, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cache_db = new Mf_Cachedb("objet");
        $cle = "objet__lister_cles";
        $Code_type = round($Code_type);
        $cle.="_{$Code_type}";

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql']))
        {
            foreach ($options['cond_mysql'] as &$condition)
            {
                $argument_cond.= ' AND ('.$condition.')';
            }
            unset($condition);
        }
        $cle.='_'.$argument_cond;

        if ( ! $liste = $cache_db->read($cle) )
        {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ( $argument_cond!='' )
            {
                if ( strpos($argument_cond, 'objet_Libelle')!==false ) { $liste_colonnes_a_indexer['objet_Libelle'] = 'objet_Libelle'; }
                if ( strpos($argument_cond, 'objet_Image_Fichier')!==false ) { $liste_colonnes_a_indexer['objet_Image_Fichier'] = 'objet_Image_Fichier'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = $cache_db->read('objet__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('objet').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('objet__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    $cache_db->pause('objet__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('objet').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                    $cache_db->reprendre('objet__index');
                }
            }

            $liste = array();
            $res_requete = executer_requete_mysql("SELECT Code_objet FROM ".inst('objet')." WHERE 1".( $Code_type!=0 ? " AND Code_type=$Code_type" : "" )."".$argument_cond.";", false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $liste[] = (int) $row_requete['Code_objet'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste);
        }
        return $liste;
    }

    protected function Code_objet_vers_Code_type( int $Code_objet )
    {
        $Code_objet = round($Code_objet);
        if ($Code_objet<0) $Code_objet = 0;
        $p = floor($Code_objet/100);
        $start = $p*100;
        $end = ($p+1)*100;
        $cache_db = new Mf_Cachedb('objet');
        $cle = 'Code_objet_vers_Code_type__'.$start.'__'.$end;
        if ( ! $conversion = $cache_db->read($cle) )
        {
            $res_requete = executer_requete_mysql('SELECT Code_objet, Code_type FROM '.inst('objet').' WHERE '.$start.' <= Code_objet AND Code_objet < '.$end.';', false);
            $conversion = array();
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $conversion[(int) $row_requete['Code_objet']] = (int) $row_requete['Code_type'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $conversion);
        }
        return ( isset($conversion[$Code_objet]) ? $conversion[$Code_objet] : 0 );
    }

    protected function liste_Code_type_vers_liste_Code_objet( array $liste_Code_type, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ( $options===null ) { $options=[]; }
        $cache_db = new Mf_Cachedb("objet");
        $cle = "liste_Code_type_vers_liste_Code_objet__".Sql_Format_Liste($liste_Code_type);

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql']))
        {
            foreach ($options['cond_mysql'] as &$condition)
            {
                $argument_cond.= ' AND ('.$condition.')';
            }
            unset($condition);
        }
        $cle.='_'.$argument_cond;

        if ( ! $liste_Code_objet = $cache_db->read($cle) )
        {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ( $argument_cond!='' )
            {
                if ( strpos($argument_cond, 'objet_Libelle')!==false ) { $liste_colonnes_a_indexer['objet_Libelle'] = 'objet_Libelle'; }
                if ( strpos($argument_cond, 'objet_Image_Fichier')!==false ) { $liste_colonnes_a_indexer['objet_Image_Fichier'] = 'objet_Image_Fichier'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = $cache_db->read('objet__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('objet').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('objet__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    $cache_db->pause('objet__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('objet').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                    $cache_db->reprendre('objet__index');
                }
            }

            $liste_Code_objet = array();
            $res_requete = executer_requete_mysql('SELECT Code_objet FROM '.inst('objet')." WHERE Code_type IN ".Sql_Format_Liste($liste_Code_type).$argument_cond.";", false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $liste_Code_objet[] = (int) $row_requete['Code_objet'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste_Code_objet);
        }
        return $liste_Code_objet;
    }

    protected function objet__liste_Code_objet_vers_liste_Code_type( array $liste_Code_objet, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ( $options===null ) { $options=[]; }
        $cache_db = new Mf_Cachedb("objet");
        $cle = "liste_Code_objet_vers_liste_Code_type__".Sql_Format_Liste($liste_Code_objet);

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql']))
        {
            foreach ($options['cond_mysql'] as &$condition)
            {
                $argument_cond.= ' AND ('.$condition.')';
            }
            unset($condition);
        }
        $cle.='_'.$argument_cond;

        if ( ! $liste_Code_type = $cache_db->read($cle) )
        {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ( $argument_cond!='' )
            {
                if ( strpos($argument_cond, 'objet_Libelle')!==false ) { $liste_colonnes_a_indexer['objet_Libelle'] = 'objet_Libelle'; }
                if ( strpos($argument_cond, 'objet_Image_Fichier')!==false ) { $liste_colonnes_a_indexer['objet_Image_Fichier'] = 'objet_Image_Fichier'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = $cache_db->read('objet__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('objet').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('objet__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    $cache_db->pause('objet__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('objet').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                    $cache_db->reprendre('objet__index');
                }
            }

            $controle_doublons = array();
            $liste_Code_type = array();
            $res_requete = executer_requete_mysql("SELECT Code_type FROM ".inst('objet')." WHERE Code_objet IN ".Sql_Format_Liste($liste_Code_objet).$argument_cond.";", false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                if ( ! isset($controle_doublons[(int) $row_requete['Code_type']]) )
                {
                    $controle_doublons[(int) $row_requete['Code_type']] = 1;
                    $liste_Code_type[] = (int) $row_requete['Code_type'];
                }
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste_Code_type);
        }
        return $liste_Code_type;
    }

    private function mf_dupliquer_objet( int $Code_objet )
    {
        $code_erreur = 0;
        $Code_new_objet = 0;
        $Code_objet = round($Code_objet);
        if ( !$this->mf_tester_existance_Code_objet($Code_objet) ) $code_erreur = 1;
        else
        {
            $donnees_a_copier = $this->mf_get($Code_objet, array('autocompletion' => false));
            $objet_Libelle = $donnees_a_copier['objet_Libelle'];
            $objet_Image_Fichier = $donnees_a_copier['objet_Image_Fichier'];
            $objet_Libelle = text_sql($objet_Libelle);
            $objet_Image_Fichier = text_sql($objet_Image_Fichier);
            $Code_type = round($donnees_a_copier['Code_type']);
            if ( isset($this->mf_dupliquer_table_de_conversion['Code_type'][$Code_type]) ) $Code_type = $this->mf_dupliquer_table_de_conversion['Code_type'][$Code_type];
            elseif ( isset($this->mf_dupliquer_table_de_conversion['Code_type'][0]) ) $Code_type = $this->mf_dupliquer_table_de_conversion['Code_type'][0];
            executer_requete_mysql("INSERT INTO objet ( objet_Libelle, objet_Image_Fichier, Code_type ) VALUES ( '$objet_Libelle', '$objet_Image_Fichier', $Code_type );", true);
            $Code_new_objet = requete_mysql_insert_id();
            if ($Code_new_objet==0)
            {
                $code_erreur = 999999;
            }
            else
            {
                $cache_db = new Mf_Cachedb("objet");
                $cache_db->clear();
                $this->mf_dupliquer_table_de_conversion['Code_objet'][$Code_objet] = $Code_new_objet;
            }
        }
        return array('code_erreur' => $code_erreur, "Code_objet" => $Code_new_objet);
    }

/*
    +--------+
    |  type  |
    +--------+
*/

    protected function mf_tester_existance_Code_type( int $Code_type )
    {
        $Code_type = round($Code_type);
        $requete_sql = "SELECT Code_type FROM ".inst('type')." WHERE Code_type = $Code_type;";
        $cache_db = new Mf_Cachedb('type');
        if ( ! $r = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) $r = 'o'; else $r = 'n';
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $r);
        }
        return $r=='o';
    }

    protected function rechercher_type_Libelle( string $type_Libelle, ?int $Code_ressource=null )
    {
        $Code_type = 0;
        $type_Libelle = format_sql('type_Libelle', $type_Libelle);
        $Code_ressource = round($Code_ressource);
        $requete_sql = 'SELECT Code_type FROM '.inst('type')." WHERE type_Libelle = $type_Libelle".( $Code_ressource!=0 ? " AND Code_ressource=$Code_ressource" : "" )." LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('type');
        if ( ! $Code_type = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $Code_type = (int) $row_requete['Code_type'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_type);
        }
        return $Code_type;
    }

    protected function get_liste_Code_type(?int $Code_ressource=null, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cache_db = new Mf_Cachedb("type");
        $cle = "type__lister_cles";
        $Code_ressource = round($Code_ressource);
        $cle.="_{$Code_ressource}";

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql']))
        {
            foreach ($options['cond_mysql'] as &$condition)
            {
                $argument_cond.= ' AND ('.$condition.')';
            }
            unset($condition);
        }
        $cle.='_'.$argument_cond;

        if ( ! $liste = $cache_db->read($cle) )
        {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ( $argument_cond!='' )
            {
                if ( strpos($argument_cond, 'type_Libelle')!==false ) { $liste_colonnes_a_indexer['type_Libelle'] = 'type_Libelle'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = $cache_db->read('type__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('type').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('type__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    $cache_db->pause('type__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('type').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                    $cache_db->reprendre('type__index');
                }
            }

            $liste = array();
            $res_requete = executer_requete_mysql("SELECT Code_type FROM ".inst('type')." WHERE 1".( $Code_ressource!=0 ? " AND Code_ressource=$Code_ressource" : "" )."".$argument_cond.";", false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $liste[] = (int) $row_requete['Code_type'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste);
        }
        return $liste;
    }

    protected function Code_type_vers_Code_ressource( int $Code_type )
    {
        $Code_type = round($Code_type);
        if ($Code_type<0) $Code_type = 0;
        $p = floor($Code_type/100);
        $start = $p*100;
        $end = ($p+1)*100;
        $cache_db = new Mf_Cachedb('type');
        $cle = 'Code_type_vers_Code_ressource__'.$start.'__'.$end;
        if ( ! $conversion = $cache_db->read($cle) )
        {
            $res_requete = executer_requete_mysql('SELECT Code_type, Code_ressource FROM '.inst('type').' WHERE '.$start.' <= Code_type AND Code_type < '.$end.';', false);
            $conversion = array();
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $conversion[(int) $row_requete['Code_type']] = (int) $row_requete['Code_ressource'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $conversion);
        }
        return ( isset($conversion[$Code_type]) ? $conversion[$Code_type] : 0 );
    }

    protected function liste_Code_ressource_vers_liste_Code_type( array $liste_Code_ressource, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ( $options===null ) { $options=[]; }
        $cache_db = new Mf_Cachedb("type");
        $cle = "liste_Code_ressource_vers_liste_Code_type__".Sql_Format_Liste($liste_Code_ressource);

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql']))
        {
            foreach ($options['cond_mysql'] as &$condition)
            {
                $argument_cond.= ' AND ('.$condition.')';
            }
            unset($condition);
        }
        $cle.='_'.$argument_cond;

        if ( ! $liste_Code_type = $cache_db->read($cle) )
        {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ( $argument_cond!='' )
            {
                if ( strpos($argument_cond, 'type_Libelle')!==false ) { $liste_colonnes_a_indexer['type_Libelle'] = 'type_Libelle'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = $cache_db->read('type__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('type').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('type__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    $cache_db->pause('type__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('type').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                    $cache_db->reprendre('type__index');
                }
            }

            $liste_Code_type = array();
            $res_requete = executer_requete_mysql('SELECT Code_type FROM '.inst('type')." WHERE Code_ressource IN ".Sql_Format_Liste($liste_Code_ressource).$argument_cond.";", false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $liste_Code_type[] = (int) $row_requete['Code_type'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste_Code_type);
        }
        return $liste_Code_type;
    }

    protected function type__liste_Code_type_vers_liste_Code_ressource( array $liste_Code_type, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ( $options===null ) { $options=[]; }
        $cache_db = new Mf_Cachedb("type");
        $cle = "liste_Code_type_vers_liste_Code_ressource__".Sql_Format_Liste($liste_Code_type);

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql']))
        {
            foreach ($options['cond_mysql'] as &$condition)
            {
                $argument_cond.= ' AND ('.$condition.')';
            }
            unset($condition);
        }
        $cle.='_'.$argument_cond;

        if ( ! $liste_Code_ressource = $cache_db->read($cle) )
        {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ( $argument_cond!='' )
            {
                if ( strpos($argument_cond, 'type_Libelle')!==false ) { $liste_colonnes_a_indexer['type_Libelle'] = 'type_Libelle'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = $cache_db->read('type__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('type').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('type__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    $cache_db->pause('type__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('type').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                    $cache_db->reprendre('type__index');
                }
            }

            $controle_doublons = array();
            $liste_Code_ressource = array();
            $res_requete = executer_requete_mysql("SELECT Code_ressource FROM ".inst('type')." WHERE Code_type IN ".Sql_Format_Liste($liste_Code_type).$argument_cond.";", false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                if ( ! isset($controle_doublons[(int) $row_requete['Code_ressource']]) )
                {
                    $controle_doublons[(int) $row_requete['Code_ressource']] = 1;
                    $liste_Code_ressource[] = (int) $row_requete['Code_ressource'];
                }
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste_Code_ressource);
        }
        return $liste_Code_ressource;
    }

    private function mf_dupliquer_type( int $Code_type )
    {
        $code_erreur = 0;
        $Code_new_type = 0;
        $Code_type = round($Code_type);
        if ( !$this->mf_tester_existance_Code_type($Code_type) ) $code_erreur = 1;
        else
        {
            $donnees_a_copier = $this->mf_get($Code_type, array('autocompletion' => false));
            $type_Libelle = $donnees_a_copier['type_Libelle'];
            $type_Libelle = text_sql($type_Libelle);
            $Code_ressource = round($donnees_a_copier['Code_ressource']);
            if ( isset($this->mf_dupliquer_table_de_conversion['Code_ressource'][$Code_ressource]) ) $Code_ressource = $this->mf_dupliquer_table_de_conversion['Code_ressource'][$Code_ressource];
            elseif ( isset($this->mf_dupliquer_table_de_conversion['Code_ressource'][0]) ) $Code_ressource = $this->mf_dupliquer_table_de_conversion['Code_ressource'][0];
            executer_requete_mysql("INSERT INTO type ( type_Libelle, Code_ressource ) VALUES ( '$type_Libelle', $Code_ressource );", true);
            $Code_new_type = requete_mysql_insert_id();
            if ($Code_new_type==0)
            {
                $code_erreur = 999999;
            }
            else
            {
                $cache_db = new Mf_Cachedb("type");
                $cache_db->clear();
                $liste_Code_objet = $this->liste_Code_type_vers_liste_Code_objet( array($Code_type) );
                foreach ($liste_Code_objet as $Code_objet)
                {
                    $this->mf_dupliquer_tables_a_dupliquer["objet_$Code_objet"]=array('objet', $Code_objet);
                }
                $this->mf_dupliquer_table_de_conversion['Code_type'][$Code_type] = $Code_new_type;
            }
        }
        return array('code_erreur' => $code_erreur, "Code_type" => $Code_new_type);
    }

/*
    +-------------+
    |  ressource  |
    +-------------+
*/

    protected function mf_tester_existance_Code_ressource( int $Code_ressource )
    {
        $Code_ressource = round($Code_ressource);
        $requete_sql = "SELECT Code_ressource FROM ".inst('ressource')." WHERE Code_ressource = $Code_ressource;";
        $cache_db = new Mf_Cachedb('ressource');
        if ( ! $r = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) $r = 'o'; else $r = 'n';
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $r);
        }
        return $r=='o';
    }

    protected function rechercher_ressource_Nom( string $ressource_Nom )
    {
        $Code_ressource = 0;
        $ressource_Nom = format_sql('ressource_Nom', $ressource_Nom);
        $requete_sql = 'SELECT Code_ressource FROM '.inst('ressource')." WHERE ressource_Nom = $ressource_Nom LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('ressource');
        if ( ! $Code_ressource = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $Code_ressource = (int) $row_requete['Code_ressource'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_ressource);
        }
        return $Code_ressource;
    }

    protected function get_liste_Code_ressource(?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cache_db = new Mf_Cachedb("ressource");
        $cle = "ressource__lister_cles";

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql']))
        {
            foreach ($options['cond_mysql'] as &$condition)
            {
                $argument_cond.= ' AND ('.$condition.')';
            }
            unset($condition);
        }
        $cle.='_'.$argument_cond;

        if ( ! $liste = $cache_db->read($cle) )
        {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ( $argument_cond!='' )
            {
                if ( strpos($argument_cond, 'ressource_Nom')!==false ) { $liste_colonnes_a_indexer['ressource_Nom'] = 'ressource_Nom'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = $cache_db->read('ressource__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('ressource').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('ressource__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    $cache_db->pause('ressource__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('ressource').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                    $cache_db->reprendre('ressource__index');
                }
            }

            $liste = array();
            $res_requete = executer_requete_mysql("SELECT Code_ressource FROM ".inst('ressource')." WHERE 1".$argument_cond.";", false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $liste[] = (int) $row_requete['Code_ressource'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste);
        }
        return $liste;
    }

    private function mf_dupliquer_ressource( int $Code_ressource )
    {
        $code_erreur = 0;
        $Code_new_ressource = 0;
        $Code_ressource = round($Code_ressource);
        if ( !$this->mf_tester_existance_Code_ressource($Code_ressource) ) $code_erreur = 1;
        else
        {
            $donnees_a_copier = $this->mf_get($Code_ressource, array('autocompletion' => false));
            $ressource_Nom = $donnees_a_copier['ressource_Nom'];
            $ressource_Nom = text_sql($ressource_Nom);
            executer_requete_mysql("INSERT INTO ressource ( ressource_Nom ) VALUES ( '$ressource_Nom' );", true);
            $Code_new_ressource = requete_mysql_insert_id();
            if ($Code_new_ressource==0)
            {
                $code_erreur = 999999;
            }
            else
            {
                $cache_db = new Mf_Cachedb("ressource");
                $cache_db->clear();
                $liste_Code_type = $this->liste_Code_ressource_vers_liste_Code_type( array($Code_ressource) );
                foreach ($liste_Code_type as $Code_type)
                {
                    $this->mf_dupliquer_tables_a_dupliquer["type_$Code_type"]=array('type', $Code_type);
                }
                $this->mf_dupliquer_table_de_conversion['Code_ressource'][$Code_ressource] = $Code_new_ressource;
            }
        }
        return array('code_erreur' => $code_erreur, "Code_ressource" => $Code_new_ressource);
    }

/*
    +-----------------+
    |  tag_ressource  |
    +-----------------+
*/

    protected function mf_tester_existance_Code_tag_ressource( int $Code_tag_ressource )
    {
        $Code_tag_ressource = round($Code_tag_ressource);
        $requete_sql = "SELECT Code_tag_ressource FROM ".inst('tag_ressource')." WHERE Code_tag_ressource = $Code_tag_ressource;";
        $cache_db = new Mf_Cachedb('tag_ressource');
        if ( ! $r = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) $r = 'o'; else $r = 'n';
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $r);
        }
        return $r=='o';
    }

    protected function rechercher_tag_ressource_Libelle( string $tag_ressource_Libelle )
    {
        $Code_tag_ressource = 0;
        $tag_ressource_Libelle = format_sql('tag_ressource_Libelle', $tag_ressource_Libelle);
        $requete_sql = 'SELECT Code_tag_ressource FROM '.inst('tag_ressource')." WHERE tag_ressource_Libelle = $tag_ressource_Libelle LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('tag_ressource');
        if ( ! $Code_tag_ressource = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $Code_tag_ressource = (int) $row_requete['Code_tag_ressource'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_tag_ressource);
        }
        return $Code_tag_ressource;
    }

    protected function get_liste_Code_tag_ressource(?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cache_db = new Mf_Cachedb("tag_ressource");
        $cle = "tag_ressource__lister_cles";

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql']))
        {
            foreach ($options['cond_mysql'] as &$condition)
            {
                $argument_cond.= ' AND ('.$condition.')';
            }
            unset($condition);
        }
        $cle.='_'.$argument_cond;

        if ( ! $liste = $cache_db->read($cle) )
        {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ( $argument_cond!='' )
            {
                if ( strpos($argument_cond, 'tag_ressource_Libelle')!==false ) { $liste_colonnes_a_indexer['tag_ressource_Libelle'] = 'tag_ressource_Libelle'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = $cache_db->read('tag_ressource__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('tag_ressource').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('tag_ressource__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    $cache_db->pause('tag_ressource__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('tag_ressource').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                    $cache_db->reprendre('tag_ressource__index');
                }
            }

            $liste = array();
            $res_requete = executer_requete_mysql("SELECT Code_tag_ressource FROM ".inst('tag_ressource')." WHERE 1".$argument_cond.";", false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $liste[] = (int) $row_requete['Code_tag_ressource'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste);
        }
        return $liste;
    }

    private function mf_dupliquer_tag_ressource( int $Code_tag_ressource )
    {
        $code_erreur = 0;
        $Code_new_tag_ressource = 0;
        $Code_tag_ressource = round($Code_tag_ressource);
        if ( !$this->mf_tester_existance_Code_tag_ressource($Code_tag_ressource) ) $code_erreur = 1;
        else
        {
            $donnees_a_copier = $this->mf_get($Code_tag_ressource, array('autocompletion' => false));
            $tag_ressource_Libelle = $donnees_a_copier['tag_ressource_Libelle'];
            $tag_ressource_Libelle = text_sql($tag_ressource_Libelle);
            executer_requete_mysql("INSERT INTO tag_ressource ( tag_ressource_Libelle ) VALUES ( '$tag_ressource_Libelle' );", true);
            $Code_new_tag_ressource = requete_mysql_insert_id();
            if ($Code_new_tag_ressource==0)
            {
                $code_erreur = 999999;
            }
            else
            {
                $cache_db = new Mf_Cachedb("tag_ressource");
                $cache_db->clear();
                $this->mf_dupliquer_table_de_conversion['Code_tag_ressource'][$Code_tag_ressource] = $Code_new_tag_ressource;
            }
        }
        return array('code_erreur' => $code_erreur, "Code_tag_ressource" => $Code_new_tag_ressource);
    }

/*
    +--------------+
    |  messagerie  |
    +--------------+
*/

    protected function mf_tester_existance_Code_messagerie( int $Code_messagerie )
    {
        $Code_messagerie = round($Code_messagerie);
        $requete_sql = "SELECT Code_messagerie FROM ".inst('messagerie')." WHERE Code_messagerie = $Code_messagerie;";
        $cache_db = new Mf_Cachedb('messagerie');
        if ( ! $r = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) $r = 'o'; else $r = 'n';
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $r);
        }
        return $r=='o';
    }

    protected function rechercher_messagerie_Nom( string $messagerie_Nom, ?int $Code_joueur=null )
    {
        $Code_messagerie = 0;
        $messagerie_Nom = format_sql('messagerie_Nom', $messagerie_Nom);
        $Code_joueur = round($Code_joueur);
        $requete_sql = 'SELECT Code_messagerie FROM '.inst('messagerie')." WHERE messagerie_Nom = $messagerie_Nom".( $Code_joueur!=0 ? " AND Code_joueur=$Code_joueur" : "" )." LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('messagerie');
        if ( ! $Code_messagerie = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $Code_messagerie = (int) $row_requete['Code_messagerie'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_messagerie);
        }
        return $Code_messagerie;
    }

    protected function get_liste_Code_messagerie(?int $Code_joueur=null, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cache_db = new Mf_Cachedb("messagerie");
        $cle = "messagerie__lister_cles";
        $Code_joueur = round($Code_joueur);
        $cle.="_{$Code_joueur}";

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql']))
        {
            foreach ($options['cond_mysql'] as &$condition)
            {
                $argument_cond.= ' AND ('.$condition.')';
            }
            unset($condition);
        }
        $cle.='_'.$argument_cond;

        if ( ! $liste = $cache_db->read($cle) )
        {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ( $argument_cond!='' )
            {
                if ( strpos($argument_cond, 'messagerie_Nom')!==false ) { $liste_colonnes_a_indexer['messagerie_Nom'] = 'messagerie_Nom'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = $cache_db->read('messagerie__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('messagerie').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('messagerie__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    $cache_db->pause('messagerie__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('messagerie').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                    $cache_db->reprendre('messagerie__index');
                }
            }

            $liste = array();
            $res_requete = executer_requete_mysql("SELECT Code_messagerie FROM ".inst('messagerie')." WHERE 1".( $Code_joueur!=0 ? " AND Code_joueur=$Code_joueur" : "" )."".$argument_cond.";", false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $liste[] = (int) $row_requete['Code_messagerie'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste);
        }
        return $liste;
    }

    protected function Code_messagerie_vers_Code_joueur( int $Code_messagerie )
    {
        $Code_messagerie = round($Code_messagerie);
        if ($Code_messagerie<0) $Code_messagerie = 0;
        $p = floor($Code_messagerie/100);
        $start = $p*100;
        $end = ($p+1)*100;
        $cache_db = new Mf_Cachedb('messagerie');
        $cle = 'Code_messagerie_vers_Code_joueur__'.$start.'__'.$end;
        if ( ! $conversion = $cache_db->read($cle) )
        {
            $res_requete = executer_requete_mysql('SELECT Code_messagerie, Code_joueur FROM '.inst('messagerie').' WHERE '.$start.' <= Code_messagerie AND Code_messagerie < '.$end.';', false);
            $conversion = array();
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $conversion[(int) $row_requete['Code_messagerie']] = (int) $row_requete['Code_joueur'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $conversion);
        }
        return ( isset($conversion[$Code_messagerie]) ? $conversion[$Code_messagerie] : 0 );
    }

    protected function liste_Code_joueur_vers_liste_Code_messagerie( array $liste_Code_joueur, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ( $options===null ) { $options=[]; }
        $cache_db = new Mf_Cachedb("messagerie");
        $cle = "liste_Code_joueur_vers_liste_Code_messagerie__".Sql_Format_Liste($liste_Code_joueur);

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql']))
        {
            foreach ($options['cond_mysql'] as &$condition)
            {
                $argument_cond.= ' AND ('.$condition.')';
            }
            unset($condition);
        }
        $cle.='_'.$argument_cond;

        if ( ! $liste_Code_messagerie = $cache_db->read($cle) )
        {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ( $argument_cond!='' )
            {
                if ( strpos($argument_cond, 'messagerie_Nom')!==false ) { $liste_colonnes_a_indexer['messagerie_Nom'] = 'messagerie_Nom'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = $cache_db->read('messagerie__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('messagerie').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('messagerie__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    $cache_db->pause('messagerie__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('messagerie').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                    $cache_db->reprendre('messagerie__index');
                }
            }

            $liste_Code_messagerie = array();
            $res_requete = executer_requete_mysql('SELECT Code_messagerie FROM '.inst('messagerie')." WHERE Code_joueur IN ".Sql_Format_Liste($liste_Code_joueur).$argument_cond.";", false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $liste_Code_messagerie[] = (int) $row_requete['Code_messagerie'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste_Code_messagerie);
        }
        return $liste_Code_messagerie;
    }

    protected function messagerie__liste_Code_messagerie_vers_liste_Code_joueur( array $liste_Code_messagerie, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ( $options===null ) { $options=[]; }
        $cache_db = new Mf_Cachedb("messagerie");
        $cle = "liste_Code_messagerie_vers_liste_Code_joueur__".Sql_Format_Liste($liste_Code_messagerie);

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql']))
        {
            foreach ($options['cond_mysql'] as &$condition)
            {
                $argument_cond.= ' AND ('.$condition.')';
            }
            unset($condition);
        }
        $cle.='_'.$argument_cond;

        if ( ! $liste_Code_joueur = $cache_db->read($cle) )
        {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ( $argument_cond!='' )
            {
                if ( strpos($argument_cond, 'messagerie_Nom')!==false ) { $liste_colonnes_a_indexer['messagerie_Nom'] = 'messagerie_Nom'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = $cache_db->read('messagerie__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('messagerie').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('messagerie__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    $cache_db->pause('messagerie__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('messagerie').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                    $cache_db->reprendre('messagerie__index');
                }
            }

            $controle_doublons = array();
            $liste_Code_joueur = array();
            $res_requete = executer_requete_mysql("SELECT Code_joueur FROM ".inst('messagerie')." WHERE Code_messagerie IN ".Sql_Format_Liste($liste_Code_messagerie).$argument_cond.";", false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                if ( ! isset($controle_doublons[(int) $row_requete['Code_joueur']]) )
                {
                    $controle_doublons[(int) $row_requete['Code_joueur']] = 1;
                    $liste_Code_joueur[] = (int) $row_requete['Code_joueur'];
                }
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste_Code_joueur);
        }
        return $liste_Code_joueur;
    }

    private function mf_dupliquer_messagerie( int $Code_messagerie )
    {
        $code_erreur = 0;
        $Code_new_messagerie = 0;
        $Code_messagerie = round($Code_messagerie);
        if ( !$this->mf_tester_existance_Code_messagerie($Code_messagerie) ) $code_erreur = 1;
        else
        {
            $donnees_a_copier = $this->mf_get($Code_messagerie, array('autocompletion' => false));
            $messagerie_Nom = $donnees_a_copier['messagerie_Nom'];
            $messagerie_Nom = text_sql($messagerie_Nom);
            $Code_joueur = round($donnees_a_copier['Code_joueur']);
            if ( isset($this->mf_dupliquer_table_de_conversion['Code_joueur'][$Code_joueur]) ) $Code_joueur = $this->mf_dupliquer_table_de_conversion['Code_joueur'][$Code_joueur];
            elseif ( isset($this->mf_dupliquer_table_de_conversion['Code_joueur'][0]) ) $Code_joueur = $this->mf_dupliquer_table_de_conversion['Code_joueur'][0];
            executer_requete_mysql("INSERT INTO messagerie ( messagerie_Nom, Code_joueur ) VALUES ( '$messagerie_Nom', $Code_joueur );", true);
            $Code_new_messagerie = requete_mysql_insert_id();
            if ($Code_new_messagerie==0)
            {
                $code_erreur = 999999;
            }
            else
            {
                $cache_db = new Mf_Cachedb("messagerie");
                $cache_db->clear();
                $liste_Code_message = $this->liste_Code_messagerie_vers_liste_Code_message( array($Code_messagerie) );
                foreach ($liste_Code_message as $Code_message)
                {
                    $this->mf_dupliquer_tables_a_dupliquer["message_$Code_message"]=array('message', $Code_message);
                }
                $this->mf_dupliquer_table_de_conversion['Code_messagerie'][$Code_messagerie] = $Code_new_messagerie;
            }
        }
        return array('code_erreur' => $code_erreur, "Code_messagerie" => $Code_new_messagerie);
    }

/*
    +------------------+
    |  liste_contacts  |
    +------------------+
*/

    protected function mf_tester_existance_Code_liste_contacts( int $Code_liste_contacts )
    {
        $Code_liste_contacts = round($Code_liste_contacts);
        $requete_sql = "SELECT Code_liste_contacts FROM ".inst('liste_contacts')." WHERE Code_liste_contacts = $Code_liste_contacts;";
        $cache_db = new Mf_Cachedb('liste_contacts');
        if ( ! $r = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) $r = 'o'; else $r = 'n';
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $r);
        }
        return $r=='o';
    }

    protected function rechercher_liste_contacts_Nom( string $liste_contacts_Nom, ?int $Code_joueur=null )
    {
        $Code_liste_contacts = 0;
        $liste_contacts_Nom = format_sql('liste_contacts_Nom', $liste_contacts_Nom);
        $Code_joueur = round($Code_joueur);
        $requete_sql = 'SELECT Code_liste_contacts FROM '.inst('liste_contacts')." WHERE liste_contacts_Nom = $liste_contacts_Nom".( $Code_joueur!=0 ? " AND Code_joueur=$Code_joueur" : "" )." LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('liste_contacts');
        if ( ! $Code_liste_contacts = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $Code_liste_contacts = (int) $row_requete['Code_liste_contacts'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_liste_contacts);
        }
        return $Code_liste_contacts;
    }

    protected function get_liste_Code_liste_contacts(?int $Code_joueur=null, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cache_db = new Mf_Cachedb("liste_contacts");
        $cle = "liste_contacts__lister_cles";
        $Code_joueur = round($Code_joueur);
        $cle.="_{$Code_joueur}";

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql']))
        {
            foreach ($options['cond_mysql'] as &$condition)
            {
                $argument_cond.= ' AND ('.$condition.')';
            }
            unset($condition);
        }
        $cle.='_'.$argument_cond;

        if ( ! $liste = $cache_db->read($cle) )
        {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ( $argument_cond!='' )
            {
                if ( strpos($argument_cond, 'liste_contacts_Nom')!==false ) { $liste_colonnes_a_indexer['liste_contacts_Nom'] = 'liste_contacts_Nom'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = $cache_db->read('liste_contacts__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('liste_contacts').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('liste_contacts__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    $cache_db->pause('liste_contacts__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('liste_contacts').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                    $cache_db->reprendre('liste_contacts__index');
                }
            }

            $liste = array();
            $res_requete = executer_requete_mysql("SELECT Code_liste_contacts FROM ".inst('liste_contacts')." WHERE 1".( $Code_joueur!=0 ? " AND Code_joueur=$Code_joueur" : "" )."".$argument_cond.";", false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $liste[] = (int) $row_requete['Code_liste_contacts'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste);
        }
        return $liste;
    }

    protected function Code_liste_contacts_vers_Code_joueur( int $Code_liste_contacts )
    {
        $Code_liste_contacts = round($Code_liste_contacts);
        if ($Code_liste_contacts<0) $Code_liste_contacts = 0;
        $p = floor($Code_liste_contacts/100);
        $start = $p*100;
        $end = ($p+1)*100;
        $cache_db = new Mf_Cachedb('liste_contacts');
        $cle = 'Code_liste_contacts_vers_Code_joueur__'.$start.'__'.$end;
        if ( ! $conversion = $cache_db->read($cle) )
        {
            $res_requete = executer_requete_mysql('SELECT Code_liste_contacts, Code_joueur FROM '.inst('liste_contacts').' WHERE '.$start.' <= Code_liste_contacts AND Code_liste_contacts < '.$end.';', false);
            $conversion = array();
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $conversion[(int) $row_requete['Code_liste_contacts']] = (int) $row_requete['Code_joueur'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $conversion);
        }
        return ( isset($conversion[$Code_liste_contacts]) ? $conversion[$Code_liste_contacts] : 0 );
    }

    protected function liste_Code_joueur_vers_liste_Code_liste_contacts( array $liste_Code_joueur, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ( $options===null ) { $options=[]; }
        $cache_db = new Mf_Cachedb("liste_contacts");
        $cle = "liste_Code_joueur_vers_liste_Code_liste_contacts__".Sql_Format_Liste($liste_Code_joueur);

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql']))
        {
            foreach ($options['cond_mysql'] as &$condition)
            {
                $argument_cond.= ' AND ('.$condition.')';
            }
            unset($condition);
        }
        $cle.='_'.$argument_cond;

        if ( ! $liste_Code_liste_contacts = $cache_db->read($cle) )
        {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ( $argument_cond!='' )
            {
                if ( strpos($argument_cond, 'liste_contacts_Nom')!==false ) { $liste_colonnes_a_indexer['liste_contacts_Nom'] = 'liste_contacts_Nom'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = $cache_db->read('liste_contacts__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('liste_contacts').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('liste_contacts__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    $cache_db->pause('liste_contacts__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('liste_contacts').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                    $cache_db->reprendre('liste_contacts__index');
                }
            }

            $liste_Code_liste_contacts = array();
            $res_requete = executer_requete_mysql('SELECT Code_liste_contacts FROM '.inst('liste_contacts')." WHERE Code_joueur IN ".Sql_Format_Liste($liste_Code_joueur).$argument_cond.";", false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $liste_Code_liste_contacts[] = (int) $row_requete['Code_liste_contacts'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste_Code_liste_contacts);
        }
        return $liste_Code_liste_contacts;
    }

    protected function liste_contacts__liste_Code_liste_contacts_vers_liste_Code_joueur( array $liste_Code_liste_contacts, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ( $options===null ) { $options=[]; }
        $cache_db = new Mf_Cachedb("liste_contacts");
        $cle = "liste_Code_liste_contacts_vers_liste_Code_joueur__".Sql_Format_Liste($liste_Code_liste_contacts);

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql']))
        {
            foreach ($options['cond_mysql'] as &$condition)
            {
                $argument_cond.= ' AND ('.$condition.')';
            }
            unset($condition);
        }
        $cle.='_'.$argument_cond;

        if ( ! $liste_Code_joueur = $cache_db->read($cle) )
        {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ( $argument_cond!='' )
            {
                if ( strpos($argument_cond, 'liste_contacts_Nom')!==false ) { $liste_colonnes_a_indexer['liste_contacts_Nom'] = 'liste_contacts_Nom'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = $cache_db->read('liste_contacts__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('liste_contacts').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('liste_contacts__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    $cache_db->pause('liste_contacts__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('liste_contacts').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                    $cache_db->reprendre('liste_contacts__index');
                }
            }

            $controle_doublons = array();
            $liste_Code_joueur = array();
            $res_requete = executer_requete_mysql("SELECT Code_joueur FROM ".inst('liste_contacts')." WHERE Code_liste_contacts IN ".Sql_Format_Liste($liste_Code_liste_contacts).$argument_cond.";", false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                if ( ! isset($controle_doublons[(int) $row_requete['Code_joueur']]) )
                {
                    $controle_doublons[(int) $row_requete['Code_joueur']] = 1;
                    $liste_Code_joueur[] = (int) $row_requete['Code_joueur'];
                }
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste_Code_joueur);
        }
        return $liste_Code_joueur;
    }

    private function mf_dupliquer_liste_contacts( int $Code_liste_contacts )
    {
        $code_erreur = 0;
        $Code_new_liste_contacts = 0;
        $Code_liste_contacts = round($Code_liste_contacts);
        if ( !$this->mf_tester_existance_Code_liste_contacts($Code_liste_contacts) ) $code_erreur = 1;
        else
        {
            $donnees_a_copier = $this->mf_get($Code_liste_contacts, array('autocompletion' => false));
            $liste_contacts_Nom = $donnees_a_copier['liste_contacts_Nom'];
            $liste_contacts_Nom = text_sql($liste_contacts_Nom);
            $Code_joueur = round($donnees_a_copier['Code_joueur']);
            if ( isset($this->mf_dupliquer_table_de_conversion['Code_joueur'][$Code_joueur]) ) $Code_joueur = $this->mf_dupliquer_table_de_conversion['Code_joueur'][$Code_joueur];
            elseif ( isset($this->mf_dupliquer_table_de_conversion['Code_joueur'][0]) ) $Code_joueur = $this->mf_dupliquer_table_de_conversion['Code_joueur'][0];
            executer_requete_mysql("INSERT INTO liste_contacts ( liste_contacts_Nom, Code_joueur ) VALUES ( '$liste_contacts_Nom', $Code_joueur );", true);
            $Code_new_liste_contacts = requete_mysql_insert_id();
            if ($Code_new_liste_contacts==0)
            {
                $code_erreur = 999999;
            }
            else
            {
                $cache_db = new Mf_Cachedb("liste_contacts");
                $cache_db->clear();
                $this->mf_dupliquer_table_de_conversion['Code_liste_contacts'][$Code_liste_contacts] = $Code_new_liste_contacts;
            }
        }
        return array('code_erreur' => $code_erreur, "Code_liste_contacts" => $Code_new_liste_contacts);
    }

/*
    +--------------------+
    |  parametre_valeur  |
    +--------------------+
*/

    protected function mf_tester_existance_Code_parametre_valeur( int $Code_parametre_valeur )
    {
        $Code_parametre_valeur = round($Code_parametre_valeur);
        $requete_sql = "SELECT Code_parametre_valeur FROM ".inst('parametre_valeur')." WHERE Code_parametre_valeur = $Code_parametre_valeur;";
        $cache_db = new Mf_Cachedb('parametre_valeur');
        if ( ! $r = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) $r = 'o'; else $r = 'n';
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $r);
        }
        return $r=='o';
    }

    protected function rechercher_parametre_valeur_Libelle( string $parametre_valeur_Libelle, ?int $Code_parametre=null )
    {
        $Code_parametre_valeur = 0;
        $parametre_valeur_Libelle = format_sql('parametre_valeur_Libelle', $parametre_valeur_Libelle);
        $Code_parametre = round($Code_parametre);
        $requete_sql = 'SELECT Code_parametre_valeur FROM '.inst('parametre_valeur')." WHERE parametre_valeur_Libelle = $parametre_valeur_Libelle".( $Code_parametre!=0 ? " AND Code_parametre=$Code_parametre" : "" )." LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('parametre_valeur');
        if ( ! $Code_parametre_valeur = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $Code_parametre_valeur = (int) $row_requete['Code_parametre_valeur'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_parametre_valeur);
        }
        return $Code_parametre_valeur;
    }

    protected function get_liste_Code_parametre_valeur(?int $Code_parametre=null, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cache_db = new Mf_Cachedb("parametre_valeur");
        $cle = "parametre_valeur__lister_cles";
        $Code_parametre = round($Code_parametre);
        $cle.="_{$Code_parametre}";

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql']))
        {
            foreach ($options['cond_mysql'] as &$condition)
            {
                $argument_cond.= ' AND ('.$condition.')';
            }
            unset($condition);
        }
        $cle.='_'.$argument_cond;

        if ( ! $liste = $cache_db->read($cle) )
        {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ( $argument_cond!='' )
            {
                if ( strpos($argument_cond, 'parametre_valeur_Libelle')!==false ) { $liste_colonnes_a_indexer['parametre_valeur_Libelle'] = 'parametre_valeur_Libelle'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = $cache_db->read('parametre_valeur__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('parametre_valeur').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('parametre_valeur__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    $cache_db->pause('parametre_valeur__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('parametre_valeur').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                    $cache_db->reprendre('parametre_valeur__index');
                }
            }

            $liste = array();
            $res_requete = executer_requete_mysql("SELECT Code_parametre_valeur FROM ".inst('parametre_valeur')." WHERE 1".( $Code_parametre!=0 ? " AND Code_parametre=$Code_parametre" : "" )."".$argument_cond.";", false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $liste[] = (int) $row_requete['Code_parametre_valeur'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste);
        }
        return $liste;
    }

    protected function Code_parametre_valeur_vers_Code_parametre( int $Code_parametre_valeur )
    {
        $Code_parametre_valeur = round($Code_parametre_valeur);
        if ($Code_parametre_valeur<0) $Code_parametre_valeur = 0;
        $p = floor($Code_parametre_valeur/100);
        $start = $p*100;
        $end = ($p+1)*100;
        $cache_db = new Mf_Cachedb('parametre_valeur');
        $cle = 'Code_parametre_valeur_vers_Code_parametre__'.$start.'__'.$end;
        if ( ! $conversion = $cache_db->read($cle) )
        {
            $res_requete = executer_requete_mysql('SELECT Code_parametre_valeur, Code_parametre FROM '.inst('parametre_valeur').' WHERE '.$start.' <= Code_parametre_valeur AND Code_parametre_valeur < '.$end.';', false);
            $conversion = array();
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $conversion[(int) $row_requete['Code_parametre_valeur']] = (int) $row_requete['Code_parametre'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $conversion);
        }
        return ( isset($conversion[$Code_parametre_valeur]) ? $conversion[$Code_parametre_valeur] : 0 );
    }

    protected function liste_Code_parametre_vers_liste_Code_parametre_valeur( array $liste_Code_parametre, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ( $options===null ) { $options=[]; }
        $cache_db = new Mf_Cachedb("parametre_valeur");
        $cle = "liste_Code_parametre_vers_liste_Code_parametre_valeur__".Sql_Format_Liste($liste_Code_parametre);

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql']))
        {
            foreach ($options['cond_mysql'] as &$condition)
            {
                $argument_cond.= ' AND ('.$condition.')';
            }
            unset($condition);
        }
        $cle.='_'.$argument_cond;

        if ( ! $liste_Code_parametre_valeur = $cache_db->read($cle) )
        {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ( $argument_cond!='' )
            {
                if ( strpos($argument_cond, 'parametre_valeur_Libelle')!==false ) { $liste_colonnes_a_indexer['parametre_valeur_Libelle'] = 'parametre_valeur_Libelle'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = $cache_db->read('parametre_valeur__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('parametre_valeur').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('parametre_valeur__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    $cache_db->pause('parametre_valeur__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('parametre_valeur').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                    $cache_db->reprendre('parametre_valeur__index');
                }
            }

            $liste_Code_parametre_valeur = array();
            $res_requete = executer_requete_mysql('SELECT Code_parametre_valeur FROM '.inst('parametre_valeur')." WHERE Code_parametre IN ".Sql_Format_Liste($liste_Code_parametre).$argument_cond.";", false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $liste_Code_parametre_valeur[] = (int) $row_requete['Code_parametre_valeur'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste_Code_parametre_valeur);
        }
        return $liste_Code_parametre_valeur;
    }

    protected function parametre_valeur__liste_Code_parametre_valeur_vers_liste_Code_parametre( array $liste_Code_parametre_valeur, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ( $options===null ) { $options=[]; }
        $cache_db = new Mf_Cachedb("parametre_valeur");
        $cle = "liste_Code_parametre_valeur_vers_liste_Code_parametre__".Sql_Format_Liste($liste_Code_parametre_valeur);

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql']))
        {
            foreach ($options['cond_mysql'] as &$condition)
            {
                $argument_cond.= ' AND ('.$condition.')';
            }
            unset($condition);
        }
        $cle.='_'.$argument_cond;

        if ( ! $liste_Code_parametre = $cache_db->read($cle) )
        {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ( $argument_cond!='' )
            {
                if ( strpos($argument_cond, 'parametre_valeur_Libelle')!==false ) { $liste_colonnes_a_indexer['parametre_valeur_Libelle'] = 'parametre_valeur_Libelle'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = $cache_db->read('parametre_valeur__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('parametre_valeur').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('parametre_valeur__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    $cache_db->pause('parametre_valeur__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('parametre_valeur').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                    $cache_db->reprendre('parametre_valeur__index');
                }
            }

            $controle_doublons = array();
            $liste_Code_parametre = array();
            $res_requete = executer_requete_mysql("SELECT Code_parametre FROM ".inst('parametre_valeur')." WHERE Code_parametre_valeur IN ".Sql_Format_Liste($liste_Code_parametre_valeur).$argument_cond.";", false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                if ( ! isset($controle_doublons[(int) $row_requete['Code_parametre']]) )
                {
                    $controle_doublons[(int) $row_requete['Code_parametre']] = 1;
                    $liste_Code_parametre[] = (int) $row_requete['Code_parametre'];
                }
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste_Code_parametre);
        }
        return $liste_Code_parametre;
    }

    private function mf_dupliquer_parametre_valeur( int $Code_parametre_valeur )
    {
        $code_erreur = 0;
        $Code_new_parametre_valeur = 0;
        $Code_parametre_valeur = round($Code_parametre_valeur);
        if ( !$this->mf_tester_existance_Code_parametre_valeur($Code_parametre_valeur) ) $code_erreur = 1;
        else
        {
            $donnees_a_copier = $this->mf_get($Code_parametre_valeur, array('autocompletion' => false));
            $parametre_valeur_Libelle = $donnees_a_copier['parametre_valeur_Libelle'];
            $parametre_valeur_Libelle = text_sql($parametre_valeur_Libelle);
            $Code_parametre = round($donnees_a_copier['Code_parametre']);
            if ( isset($this->mf_dupliquer_table_de_conversion['Code_parametre'][$Code_parametre]) ) $Code_parametre = $this->mf_dupliquer_table_de_conversion['Code_parametre'][$Code_parametre];
            elseif ( isset($this->mf_dupliquer_table_de_conversion['Code_parametre'][0]) ) $Code_parametre = $this->mf_dupliquer_table_de_conversion['Code_parametre'][0];
            executer_requete_mysql("INSERT INTO parametre_valeur ( parametre_valeur_Libelle, Code_parametre ) VALUES ( '$parametre_valeur_Libelle', $Code_parametre );", true);
            $Code_new_parametre_valeur = requete_mysql_insert_id();
            if ($Code_new_parametre_valeur==0)
            {
                $code_erreur = 999999;
            }
            else
            {
                $cache_db = new Mf_Cachedb("parametre_valeur");
                $cache_db->clear();
                $this->mf_dupliquer_table_de_conversion['Code_parametre_valeur'][$Code_parametre_valeur] = $Code_new_parametre_valeur;
            }
        }
        return array('code_erreur' => $code_erreur, "Code_parametre_valeur" => $Code_new_parametre_valeur);
    }

/*
    +----------------------+
    |  a_joueur_parametre  |
    +----------------------+
*/

    protected function mf_tester_existance_a_joueur_parametre( int $Code_joueur, int $Code_parametre )
    {
        $Code_joueur = round($Code_joueur);
        $Code_parametre = round($Code_parametre);
        $requete_sql = "SELECT * FROM ".inst('a_joueur_parametre')." WHERE Code_joueur=$Code_joueur AND Code_parametre=$Code_parametre;";
        $cache_db = new Mf_Cachedb('a_joueur_parametre');
        if ( ! $r = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) $r = 'o'; else $r = 'n';
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $r);
        }
        return $r=='o';
    }

    private function mf_dupliquer_a_joueur_parametre(int $Code_joueur, int $Code_parametre)
    {
        $code_erreur = 0;
        $Code_joueur = round($Code_joueur);
        $Code_parametre = round($Code_parametre);
        if ( !$this->mf_tester_existance_a_joueur_parametre( $Code_joueur, $Code_parametre ) ) $code_erreur = 999999;
        else
        {
            $donnees_a_copier = $this->mf_get($Code_joueur, $Code_parametre, array('autocompletion' => false));
            $a_joueur_parametre_Valeur_choisie = $donnees_a_copier['a_joueur_parametre_Valeur_choisie'];
            $a_joueur_parametre_Actif = $donnees_a_copier['a_joueur_parametre_Actif'];
            $a_joueur_parametre_Valeur_choisie = round($a_joueur_parametre_Valeur_choisie);
            $a_joueur_parametre_Actif = ($a_joueur_parametre_Actif==1 ? 1 : 0);
            if ( isset($this->mf_dupliquer_table_de_conversion['Code_joueur'][$Code_joueur]) ) $Code_joueur = $this->mf_dupliquer_table_de_conversion['Code_joueur'][$Code_joueur];
            elseif ( isset($this->mf_dupliquer_table_de_conversion['Code_joueur'][0]) ) $Code_joueur = $this->mf_dupliquer_table_de_conversion['Code_joueur'][0];
            if ( isset($this->mf_dupliquer_table_de_conversion['Code_parametre'][$Code_parametre]) ) $Code_parametre = $this->mf_dupliquer_table_de_conversion['Code_parametre'][$Code_parametre];
            elseif ( isset($this->mf_dupliquer_table_de_conversion['Code_parametre'][0]) ) $Code_parametre = $this->mf_dupliquer_table_de_conversion['Code_parametre'][0];
            executer_requete_mysql('INSERT INTO '.inst('a_joueur_parametre')." ( a_joueur_parametre_Valeur_choisie, a_joueur_parametre_Actif, Code_joueur, Code_parametre ) VALUES ( $a_joueur_parametre_Valeur_choisie, $a_joueur_parametre_Actif, $Code_joueur, $Code_parametre );", true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = 999999;
            }
            else
            {
                $cache_db = new Mf_Cachedb("a_joueur_parametre");
                $cache_db->clear();
            }
        }
        return array('code_erreur' => $code_erreur);
    }

    protected function a_joueur_parametre_liste_Code_joueur_vers_liste_Code_parametre(  array $liste_Code_joueur, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ( $options===null ) { $options=[]; }
        $cache_db = new Mf_Cachedb("a_joueur_parametre");
        $cle = "liste_Code_joueur_vers_liste_Code_parametre__".Sql_Format_Liste($liste_Code_joueur);

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql']))
        {
            foreach ($options['cond_mysql'] as &$condition)
            {
                $argument_cond.= ' AND ('.$condition.')';
            }
            unset($condition);
        }
        $cle.='_'.$argument_cond;

        if ( ! $liste_Code_parametre = $cache_db->read($cle) )
        {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ( $argument_cond!='' )
            {
                if ( strpos($argument_cond, 'a_joueur_parametre_Valeur_choisie')!==false ) { $liste_colonnes_a_indexer['a_joueur_parametre_Valeur_choisie'] = 'a_joueur_parametre_Valeur_choisie'; }
                if ( strpos($argument_cond, 'a_joueur_parametre_Actif')!==false ) { $liste_colonnes_a_indexer['a_joueur_parametre_Actif'] = 'a_joueur_parametre_Actif'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = $cache_db->read('a_joueur_parametre__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('a_joueur_parametre').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('a_joueur_parametre__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    $cache_db->pause('a_joueur_parametre__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('a_joueur_parametre').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                    $cache_db->reprendre('a_joueur_parametre__index');
                }
            }

            $liste_Code_parametre = array();
            $res_requete = executer_requete_mysql('SELECT Code_parametre FROM '.inst('a_joueur_parametre')." WHERE Code_joueur IN ".Sql_Format_Liste($liste_Code_joueur).$argument_cond.';', false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $liste_Code_parametre[(int) $row_requete['Code_parametre']] = (int) $row_requete['Code_parametre'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste_Code_parametre);
        }
        return $liste_Code_parametre;
    }

    protected function a_joueur_parametre_liste_Code_parametre_vers_liste_Code_joueur(  array $liste_Code_parametre, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ( $options===null ) { $options=[]; }
        $cache_db = new Mf_Cachedb("a_joueur_parametre");
        $cle = "liste_Code_parametre_vers_liste_Code_joueur__".Sql_Format_Liste($liste_Code_parametre);

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql']))
        {
            foreach ($options['cond_mysql'] as &$condition)
            {
                $argument_cond.= ' AND ('.$condition.')';
            }
            unset($condition);
        }
        $cle.='_'.$argument_cond;

        if ( ! $liste_Code_joueur = $cache_db->read($cle) )
        {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ( $argument_cond!='' )
            {
                if ( strpos($argument_cond, 'a_joueur_parametre_Valeur_choisie')!==false ) { $liste_colonnes_a_indexer['a_joueur_parametre_Valeur_choisie'] = 'a_joueur_parametre_Valeur_choisie'; }
                if ( strpos($argument_cond, 'a_joueur_parametre_Actif')!==false ) { $liste_colonnes_a_indexer['a_joueur_parametre_Actif'] = 'a_joueur_parametre_Actif'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = $cache_db->read('a_joueur_parametre__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('a_joueur_parametre').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('a_joueur_parametre__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    $cache_db->pause('a_joueur_parametre__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('a_joueur_parametre').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                    $cache_db->reprendre('a_joueur_parametre__index');
                }
            }

            $liste_Code_joueur = array();
            $res_requete = executer_requete_mysql('SELECT Code_joueur FROM '.inst('a_joueur_parametre')." WHERE Code_parametre IN ".Sql_Format_Liste($liste_Code_parametre).$argument_cond.';', false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $liste_Code_joueur[(int) $row_requete['Code_joueur']] = (int) $row_requete['Code_joueur'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste_Code_joueur);
        }
        return $liste_Code_joueur;
    }

/*
    +-------------------------------+
    |  a_candidature_joueur_groupe  |
    +-------------------------------+
*/

    protected function mf_tester_existance_a_candidature_joueur_groupe( int $Code_joueur, int $Code_groupe )
    {
        $Code_joueur = round($Code_joueur);
        $Code_groupe = round($Code_groupe);
        $requete_sql = "SELECT * FROM ".inst('a_candidature_joueur_groupe')." WHERE Code_joueur=$Code_joueur AND Code_groupe=$Code_groupe;";
        $cache_db = new Mf_Cachedb('a_candidature_joueur_groupe');
        if ( ! $r = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) $r = 'o'; else $r = 'n';
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $r);
        }
        return $r=='o';
    }

    private function mf_dupliquer_a_candidature_joueur_groupe(int $Code_joueur, int $Code_groupe)
    {
        $code_erreur = 0;
        $Code_joueur = round($Code_joueur);
        $Code_groupe = round($Code_groupe);
        if ( !$this->mf_tester_existance_a_candidature_joueur_groupe( $Code_joueur, $Code_groupe ) ) $code_erreur = 999999;
        else
        {
            $donnees_a_copier = $this->mf_get($Code_joueur, $Code_groupe, array('autocompletion' => false));
            $a_candidature_joueur_groupe_Message = $donnees_a_copier['a_candidature_joueur_groupe_Message'];
            $a_candidature_joueur_groupe_Date_envoi = $donnees_a_copier['a_candidature_joueur_groupe_Date_envoi'];
            $a_candidature_joueur_groupe_Message = text_sql($a_candidature_joueur_groupe_Message);
            $a_candidature_joueur_groupe_Date_envoi = format_datetime($a_candidature_joueur_groupe_Date_envoi);
            if ( isset($this->mf_dupliquer_table_de_conversion['Code_joueur'][$Code_joueur]) ) $Code_joueur = $this->mf_dupliquer_table_de_conversion['Code_joueur'][$Code_joueur];
            elseif ( isset($this->mf_dupliquer_table_de_conversion['Code_joueur'][0]) ) $Code_joueur = $this->mf_dupliquer_table_de_conversion['Code_joueur'][0];
            if ( isset($this->mf_dupliquer_table_de_conversion['Code_groupe'][$Code_groupe]) ) $Code_groupe = $this->mf_dupliquer_table_de_conversion['Code_groupe'][$Code_groupe];
            elseif ( isset($this->mf_dupliquer_table_de_conversion['Code_groupe'][0]) ) $Code_groupe = $this->mf_dupliquer_table_de_conversion['Code_groupe'][0];
            executer_requete_mysql('INSERT INTO '.inst('a_candidature_joueur_groupe')." ( a_candidature_joueur_groupe_Message, a_candidature_joueur_groupe_Date_envoi, Code_joueur, Code_groupe ) VALUES ( '$a_candidature_joueur_groupe_Message', ".( $a_candidature_joueur_groupe_Date_envoi!='' ? "'$a_candidature_joueur_groupe_Date_envoi'" : 'NULL' ).", $Code_joueur, $Code_groupe );", true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = 999999;
            }
            else
            {
                $cache_db = new Mf_Cachedb("a_candidature_joueur_groupe");
                $cache_db->clear();
            }
        }
        return array('code_erreur' => $code_erreur);
    }

    protected function a_candidature_joueur_groupe_liste_Code_joueur_vers_liste_Code_groupe(  array $liste_Code_joueur, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ( $options===null ) { $options=[]; }
        $cache_db = new Mf_Cachedb("a_candidature_joueur_groupe");
        $cle = "liste_Code_joueur_vers_liste_Code_groupe__".Sql_Format_Liste($liste_Code_joueur);

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql']))
        {
            foreach ($options['cond_mysql'] as &$condition)
            {
                $argument_cond.= ' AND ('.$condition.')';
            }
            unset($condition);
        }
        $cle.='_'.$argument_cond;

        if ( ! $liste_Code_groupe = $cache_db->read($cle) )
        {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ( $argument_cond!='' )
            {
                if ( strpos($argument_cond, 'a_candidature_joueur_groupe_Date_envoi')!==false ) { $liste_colonnes_a_indexer['a_candidature_joueur_groupe_Date_envoi'] = 'a_candidature_joueur_groupe_Date_envoi'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = $cache_db->read('a_candidature_joueur_groupe__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('a_candidature_joueur_groupe').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('a_candidature_joueur_groupe__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    $cache_db->pause('a_candidature_joueur_groupe__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('a_candidature_joueur_groupe').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                    $cache_db->reprendre('a_candidature_joueur_groupe__index');
                }
            }

            $liste_Code_groupe = array();
            $res_requete = executer_requete_mysql('SELECT Code_groupe FROM '.inst('a_candidature_joueur_groupe')." WHERE Code_joueur IN ".Sql_Format_Liste($liste_Code_joueur).$argument_cond.';', false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $liste_Code_groupe[(int) $row_requete['Code_groupe']] = (int) $row_requete['Code_groupe'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste_Code_groupe);
        }
        return $liste_Code_groupe;
    }

    protected function a_candidature_joueur_groupe_liste_Code_groupe_vers_liste_Code_joueur(  array $liste_Code_groupe, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ( $options===null ) { $options=[]; }
        $cache_db = new Mf_Cachedb("a_candidature_joueur_groupe");
        $cle = "liste_Code_groupe_vers_liste_Code_joueur__".Sql_Format_Liste($liste_Code_groupe);

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql']))
        {
            foreach ($options['cond_mysql'] as &$condition)
            {
                $argument_cond.= ' AND ('.$condition.')';
            }
            unset($condition);
        }
        $cle.='_'.$argument_cond;

        if ( ! $liste_Code_joueur = $cache_db->read($cle) )
        {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ( $argument_cond!='' )
            {
                if ( strpos($argument_cond, 'a_candidature_joueur_groupe_Date_envoi')!==false ) { $liste_colonnes_a_indexer['a_candidature_joueur_groupe_Date_envoi'] = 'a_candidature_joueur_groupe_Date_envoi'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = $cache_db->read('a_candidature_joueur_groupe__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('a_candidature_joueur_groupe').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('a_candidature_joueur_groupe__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    $cache_db->pause('a_candidature_joueur_groupe__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('a_candidature_joueur_groupe').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                    $cache_db->reprendre('a_candidature_joueur_groupe__index');
                }
            }

            $liste_Code_joueur = array();
            $res_requete = executer_requete_mysql('SELECT Code_joueur FROM '.inst('a_candidature_joueur_groupe')." WHERE Code_groupe IN ".Sql_Format_Liste($liste_Code_groupe).$argument_cond.';', false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $liste_Code_joueur[(int) $row_requete['Code_joueur']] = (int) $row_requete['Code_joueur'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste_Code_joueur);
        }
        return $liste_Code_joueur;
    }

/*
    +--------------------------+
    |  a_membre_joueur_groupe  |
    +--------------------------+
*/

    protected function mf_tester_existance_a_membre_joueur_groupe( int $Code_groupe, int $Code_joueur )
    {
        $Code_groupe = round($Code_groupe);
        $Code_joueur = round($Code_joueur);
        $requete_sql = "SELECT * FROM ".inst('a_membre_joueur_groupe')." WHERE Code_groupe=$Code_groupe AND Code_joueur=$Code_joueur;";
        $cache_db = new Mf_Cachedb('a_membre_joueur_groupe');
        if ( ! $r = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) $r = 'o'; else $r = 'n';
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $r);
        }
        return $r=='o';
    }

    private function mf_dupliquer_a_membre_joueur_groupe(int $Code_groupe, int $Code_joueur)
    {
        $code_erreur = 0;
        $Code_groupe = round($Code_groupe);
        $Code_joueur = round($Code_joueur);
        if ( !$this->mf_tester_existance_a_membre_joueur_groupe( $Code_groupe, $Code_joueur ) ) $code_erreur = 999999;
        else
        {
            $donnees_a_copier = $this->mf_get($Code_groupe, $Code_joueur, array('autocompletion' => false));
            $a_membre_joueur_groupe_Surnom = $donnees_a_copier['a_membre_joueur_groupe_Surnom'];
            $a_membre_joueur_groupe_Grade = $donnees_a_copier['a_membre_joueur_groupe_Grade'];
            $a_membre_joueur_groupe_Date_adhesion = $donnees_a_copier['a_membre_joueur_groupe_Date_adhesion'];
            $a_membre_joueur_groupe_Surnom = text_sql($a_membre_joueur_groupe_Surnom);
            $a_membre_joueur_groupe_Grade = round($a_membre_joueur_groupe_Grade);
            $a_membre_joueur_groupe_Date_adhesion = format_datetime($a_membre_joueur_groupe_Date_adhesion);
            if ( isset($this->mf_dupliquer_table_de_conversion['Code_groupe'][$Code_groupe]) ) $Code_groupe = $this->mf_dupliquer_table_de_conversion['Code_groupe'][$Code_groupe];
            elseif ( isset($this->mf_dupliquer_table_de_conversion['Code_groupe'][0]) ) $Code_groupe = $this->mf_dupliquer_table_de_conversion['Code_groupe'][0];
            if ( isset($this->mf_dupliquer_table_de_conversion['Code_joueur'][$Code_joueur]) ) $Code_joueur = $this->mf_dupliquer_table_de_conversion['Code_joueur'][$Code_joueur];
            elseif ( isset($this->mf_dupliquer_table_de_conversion['Code_joueur'][0]) ) $Code_joueur = $this->mf_dupliquer_table_de_conversion['Code_joueur'][0];
            executer_requete_mysql('INSERT INTO '.inst('a_membre_joueur_groupe')." ( a_membre_joueur_groupe_Surnom, a_membre_joueur_groupe_Grade, a_membre_joueur_groupe_Date_adhesion, Code_groupe, Code_joueur ) VALUES ( '$a_membre_joueur_groupe_Surnom', $a_membre_joueur_groupe_Grade, ".( $a_membre_joueur_groupe_Date_adhesion!='' ? "'$a_membre_joueur_groupe_Date_adhesion'" : 'NULL' ).", $Code_groupe, $Code_joueur );", true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = 999999;
            }
            else
            {
                $cache_db = new Mf_Cachedb("a_membre_joueur_groupe");
                $cache_db->clear();
            }
        }
        return array('code_erreur' => $code_erreur);
    }

    protected function a_membre_joueur_groupe_liste_Code_groupe_vers_liste_Code_joueur(  array $liste_Code_groupe, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ( $options===null ) { $options=[]; }
        $cache_db = new Mf_Cachedb("a_membre_joueur_groupe");
        $cle = "liste_Code_groupe_vers_liste_Code_joueur__".Sql_Format_Liste($liste_Code_groupe);

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql']))
        {
            foreach ($options['cond_mysql'] as &$condition)
            {
                $argument_cond.= ' AND ('.$condition.')';
            }
            unset($condition);
        }
        $cle.='_'.$argument_cond;

        if ( ! $liste_Code_joueur = $cache_db->read($cle) )
        {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ( $argument_cond!='' )
            {
                if ( strpos($argument_cond, 'a_membre_joueur_groupe_Surnom')!==false ) { $liste_colonnes_a_indexer['a_membre_joueur_groupe_Surnom'] = 'a_membre_joueur_groupe_Surnom'; }
                if ( strpos($argument_cond, 'a_membre_joueur_groupe_Grade')!==false ) { $liste_colonnes_a_indexer['a_membre_joueur_groupe_Grade'] = 'a_membre_joueur_groupe_Grade'; }
                if ( strpos($argument_cond, 'a_membre_joueur_groupe_Date_adhesion')!==false ) { $liste_colonnes_a_indexer['a_membre_joueur_groupe_Date_adhesion'] = 'a_membre_joueur_groupe_Date_adhesion'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = $cache_db->read('a_membre_joueur_groupe__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('a_membre_joueur_groupe').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('a_membre_joueur_groupe__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    $cache_db->pause('a_membre_joueur_groupe__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('a_membre_joueur_groupe').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                    $cache_db->reprendre('a_membre_joueur_groupe__index');
                }
            }

            $liste_Code_joueur = array();
            $res_requete = executer_requete_mysql('SELECT Code_joueur FROM '.inst('a_membre_joueur_groupe')." WHERE Code_groupe IN ".Sql_Format_Liste($liste_Code_groupe).$argument_cond.';', false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $liste_Code_joueur[(int) $row_requete['Code_joueur']] = (int) $row_requete['Code_joueur'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste_Code_joueur);
        }
        return $liste_Code_joueur;
    }

    protected function a_membre_joueur_groupe_liste_Code_joueur_vers_liste_Code_groupe(  array $liste_Code_joueur, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ( $options===null ) { $options=[]; }
        $cache_db = new Mf_Cachedb("a_membre_joueur_groupe");
        $cle = "liste_Code_joueur_vers_liste_Code_groupe__".Sql_Format_Liste($liste_Code_joueur);

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql']))
        {
            foreach ($options['cond_mysql'] as &$condition)
            {
                $argument_cond.= ' AND ('.$condition.')';
            }
            unset($condition);
        }
        $cle.='_'.$argument_cond;

        if ( ! $liste_Code_groupe = $cache_db->read($cle) )
        {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ( $argument_cond!='' )
            {
                if ( strpos($argument_cond, 'a_membre_joueur_groupe_Surnom')!==false ) { $liste_colonnes_a_indexer['a_membre_joueur_groupe_Surnom'] = 'a_membre_joueur_groupe_Surnom'; }
                if ( strpos($argument_cond, 'a_membre_joueur_groupe_Grade')!==false ) { $liste_colonnes_a_indexer['a_membre_joueur_groupe_Grade'] = 'a_membre_joueur_groupe_Grade'; }
                if ( strpos($argument_cond, 'a_membre_joueur_groupe_Date_adhesion')!==false ) { $liste_colonnes_a_indexer['a_membre_joueur_groupe_Date_adhesion'] = 'a_membre_joueur_groupe_Date_adhesion'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = $cache_db->read('a_membre_joueur_groupe__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('a_membre_joueur_groupe').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('a_membre_joueur_groupe__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    $cache_db->pause('a_membre_joueur_groupe__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('a_membre_joueur_groupe').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                    $cache_db->reprendre('a_membre_joueur_groupe__index');
                }
            }

            $liste_Code_groupe = array();
            $res_requete = executer_requete_mysql('SELECT Code_groupe FROM '.inst('a_membre_joueur_groupe')." WHERE Code_joueur IN ".Sql_Format_Liste($liste_Code_joueur).$argument_cond.';', false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $liste_Code_groupe[(int) $row_requete['Code_groupe']] = (int) $row_requete['Code_groupe'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste_Code_groupe);
        }
        return $liste_Code_groupe;
    }

/*
    +------------------------------+
    |  a_invitation_joueur_groupe  |
    +------------------------------+
*/

    protected function mf_tester_existance_a_invitation_joueur_groupe( int $Code_joueur, int $Code_groupe )
    {
        $Code_joueur = round($Code_joueur);
        $Code_groupe = round($Code_groupe);
        $requete_sql = "SELECT * FROM ".inst('a_invitation_joueur_groupe')." WHERE Code_joueur=$Code_joueur AND Code_groupe=$Code_groupe;";
        $cache_db = new Mf_Cachedb('a_invitation_joueur_groupe');
        if ( ! $r = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) $r = 'o'; else $r = 'n';
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $r);
        }
        return $r=='o';
    }

    private function mf_dupliquer_a_invitation_joueur_groupe(int $Code_joueur, int $Code_groupe)
    {
        $code_erreur = 0;
        $Code_joueur = round($Code_joueur);
        $Code_groupe = round($Code_groupe);
        if ( !$this->mf_tester_existance_a_invitation_joueur_groupe( $Code_joueur, $Code_groupe ) ) $code_erreur = 999999;
        else
        {
            $donnees_a_copier = $this->mf_get($Code_joueur, $Code_groupe, array('autocompletion' => false));
            $a_invitation_joueur_groupe_Message = $donnees_a_copier['a_invitation_joueur_groupe_Message'];
            $a_invitation_joueur_groupe_Date_envoi = $donnees_a_copier['a_invitation_joueur_groupe_Date_envoi'];
            $a_invitation_joueur_groupe_Message = text_sql($a_invitation_joueur_groupe_Message);
            $a_invitation_joueur_groupe_Date_envoi = format_datetime($a_invitation_joueur_groupe_Date_envoi);
            if ( isset($this->mf_dupliquer_table_de_conversion['Code_joueur'][$Code_joueur]) ) $Code_joueur = $this->mf_dupliquer_table_de_conversion['Code_joueur'][$Code_joueur];
            elseif ( isset($this->mf_dupliquer_table_de_conversion['Code_joueur'][0]) ) $Code_joueur = $this->mf_dupliquer_table_de_conversion['Code_joueur'][0];
            if ( isset($this->mf_dupliquer_table_de_conversion['Code_groupe'][$Code_groupe]) ) $Code_groupe = $this->mf_dupliquer_table_de_conversion['Code_groupe'][$Code_groupe];
            elseif ( isset($this->mf_dupliquer_table_de_conversion['Code_groupe'][0]) ) $Code_groupe = $this->mf_dupliquer_table_de_conversion['Code_groupe'][0];
            executer_requete_mysql('INSERT INTO '.inst('a_invitation_joueur_groupe')." ( a_invitation_joueur_groupe_Message, a_invitation_joueur_groupe_Date_envoi, Code_joueur, Code_groupe ) VALUES ( '$a_invitation_joueur_groupe_Message', ".( $a_invitation_joueur_groupe_Date_envoi!='' ? "'$a_invitation_joueur_groupe_Date_envoi'" : 'NULL' ).", $Code_joueur, $Code_groupe );", true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = 999999;
            }
            else
            {
                $cache_db = new Mf_Cachedb("a_invitation_joueur_groupe");
                $cache_db->clear();
            }
        }
        return array('code_erreur' => $code_erreur);
    }

    protected function a_invitation_joueur_groupe_liste_Code_joueur_vers_liste_Code_groupe(  array $liste_Code_joueur, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ( $options===null ) { $options=[]; }
        $cache_db = new Mf_Cachedb("a_invitation_joueur_groupe");
        $cle = "liste_Code_joueur_vers_liste_Code_groupe__".Sql_Format_Liste($liste_Code_joueur);

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql']))
        {
            foreach ($options['cond_mysql'] as &$condition)
            {
                $argument_cond.= ' AND ('.$condition.')';
            }
            unset($condition);
        }
        $cle.='_'.$argument_cond;

        if ( ! $liste_Code_groupe = $cache_db->read($cle) )
        {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ( $argument_cond!='' )
            {
                if ( strpos($argument_cond, 'a_invitation_joueur_groupe_Date_envoi')!==false ) { $liste_colonnes_a_indexer['a_invitation_joueur_groupe_Date_envoi'] = 'a_invitation_joueur_groupe_Date_envoi'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = $cache_db->read('a_invitation_joueur_groupe__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('a_invitation_joueur_groupe').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('a_invitation_joueur_groupe__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    $cache_db->pause('a_invitation_joueur_groupe__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('a_invitation_joueur_groupe').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                    $cache_db->reprendre('a_invitation_joueur_groupe__index');
                }
            }

            $liste_Code_groupe = array();
            $res_requete = executer_requete_mysql('SELECT Code_groupe FROM '.inst('a_invitation_joueur_groupe')." WHERE Code_joueur IN ".Sql_Format_Liste($liste_Code_joueur).$argument_cond.';', false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $liste_Code_groupe[(int) $row_requete['Code_groupe']] = (int) $row_requete['Code_groupe'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste_Code_groupe);
        }
        return $liste_Code_groupe;
    }

    protected function a_invitation_joueur_groupe_liste_Code_groupe_vers_liste_Code_joueur(  array $liste_Code_groupe, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ( $options===null ) { $options=[]; }
        $cache_db = new Mf_Cachedb("a_invitation_joueur_groupe");
        $cle = "liste_Code_groupe_vers_liste_Code_joueur__".Sql_Format_Liste($liste_Code_groupe);

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql']))
        {
            foreach ($options['cond_mysql'] as &$condition)
            {
                $argument_cond.= ' AND ('.$condition.')';
            }
            unset($condition);
        }
        $cle.='_'.$argument_cond;

        if ( ! $liste_Code_joueur = $cache_db->read($cle) )
        {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ( $argument_cond!='' )
            {
                if ( strpos($argument_cond, 'a_invitation_joueur_groupe_Date_envoi')!==false ) { $liste_colonnes_a_indexer['a_invitation_joueur_groupe_Date_envoi'] = 'a_invitation_joueur_groupe_Date_envoi'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = $cache_db->read('a_invitation_joueur_groupe__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('a_invitation_joueur_groupe').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('a_invitation_joueur_groupe__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    $cache_db->pause('a_invitation_joueur_groupe__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('a_invitation_joueur_groupe').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                    $cache_db->reprendre('a_invitation_joueur_groupe__index');
                }
            }

            $liste_Code_joueur = array();
            $res_requete = executer_requete_mysql('SELECT Code_joueur FROM '.inst('a_invitation_joueur_groupe')." WHERE Code_groupe IN ".Sql_Format_Liste($liste_Code_groupe).$argument_cond.';', false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $liste_Code_joueur[(int) $row_requete['Code_joueur']] = (int) $row_requete['Code_joueur'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste_Code_joueur);
        }
        return $liste_Code_joueur;
    }

/*
    +-----------------+
    |  a_carte_objet  |
    +-----------------+
*/

    protected function mf_tester_existance_a_carte_objet( int $Code_carte, int $Code_objet )
    {
        $Code_carte = round($Code_carte);
        $Code_objet = round($Code_objet);
        $requete_sql = "SELECT * FROM ".inst('a_carte_objet')." WHERE Code_carte=$Code_carte AND Code_objet=$Code_objet;";
        $cache_db = new Mf_Cachedb('a_carte_objet');
        if ( ! $r = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) $r = 'o'; else $r = 'n';
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $r);
        }
        return $r=='o';
    }

    private function mf_dupliquer_a_carte_objet(int $Code_carte, int $Code_objet)
    {
        $code_erreur = 0;
        $Code_carte = round($Code_carte);
        $Code_objet = round($Code_objet);
        if ( !$this->mf_tester_existance_a_carte_objet( $Code_carte, $Code_objet ) ) $code_erreur = 999999;
        else
        {
            if ( isset($this->mf_dupliquer_table_de_conversion['Code_carte'][$Code_carte]) ) $Code_carte = $this->mf_dupliquer_table_de_conversion['Code_carte'][$Code_carte];
            elseif ( isset($this->mf_dupliquer_table_de_conversion['Code_carte'][0]) ) $Code_carte = $this->mf_dupliquer_table_de_conversion['Code_carte'][0];
            if ( isset($this->mf_dupliquer_table_de_conversion['Code_objet'][$Code_objet]) ) $Code_objet = $this->mf_dupliquer_table_de_conversion['Code_objet'][$Code_objet];
            elseif ( isset($this->mf_dupliquer_table_de_conversion['Code_objet'][0]) ) $Code_objet = $this->mf_dupliquer_table_de_conversion['Code_objet'][0];
            executer_requete_mysql('INSERT INTO '.inst('a_carte_objet')." ( Code_carte, Code_objet ) VALUES ( $Code_carte, $Code_objet );", true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = 999999;
            }
            else
            {
                $cache_db = new Mf_Cachedb("a_carte_objet");
                $cache_db->clear();
            }
        }
        return array('code_erreur' => $code_erreur);
    }

    protected function a_carte_objet_liste_Code_carte_vers_liste_Code_objet(  array $liste_Code_carte, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ( $options===null ) { $options=[]; }
        $cache_db = new Mf_Cachedb("a_carte_objet");
        $cle = "liste_Code_carte_vers_liste_Code_objet__".Sql_Format_Liste($liste_Code_carte);

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql']))
        {
            foreach ($options['cond_mysql'] as &$condition)
            {
                $argument_cond.= ' AND ('.$condition.')';
            }
            unset($condition);
        }
        $cle.='_'.$argument_cond;

        if ( ! $liste_Code_objet = $cache_db->read($cle) )
        {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ( $argument_cond!='' )
            {
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = $cache_db->read('a_carte_objet__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('a_carte_objet').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('a_carte_objet__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    $cache_db->pause('a_carte_objet__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('a_carte_objet').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                    $cache_db->reprendre('a_carte_objet__index');
                }
            }

            $liste_Code_objet = array();
            $res_requete = executer_requete_mysql('SELECT Code_objet FROM '.inst('a_carte_objet')." WHERE Code_carte IN ".Sql_Format_Liste($liste_Code_carte).$argument_cond.';', false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $liste_Code_objet[(int) $row_requete['Code_objet']] = (int) $row_requete['Code_objet'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste_Code_objet);
        }
        return $liste_Code_objet;
    }

    protected function a_carte_objet_liste_Code_objet_vers_liste_Code_carte(  array $liste_Code_objet, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ( $options===null ) { $options=[]; }
        $cache_db = new Mf_Cachedb("a_carte_objet");
        $cle = "liste_Code_objet_vers_liste_Code_carte__".Sql_Format_Liste($liste_Code_objet);

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql']))
        {
            foreach ($options['cond_mysql'] as &$condition)
            {
                $argument_cond.= ' AND ('.$condition.')';
            }
            unset($condition);
        }
        $cle.='_'.$argument_cond;

        if ( ! $liste_Code_carte = $cache_db->read($cle) )
        {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ( $argument_cond!='' )
            {
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = $cache_db->read('a_carte_objet__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('a_carte_objet').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('a_carte_objet__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    $cache_db->pause('a_carte_objet__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('a_carte_objet').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                    $cache_db->reprendre('a_carte_objet__index');
                }
            }

            $liste_Code_carte = array();
            $res_requete = executer_requete_mysql('SELECT Code_carte FROM '.inst('a_carte_objet')." WHERE Code_objet IN ".Sql_Format_Liste($liste_Code_objet).$argument_cond.';', false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $liste_Code_carte[(int) $row_requete['Code_carte']] = (int) $row_requete['Code_carte'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste_Code_carte);
        }
        return $liste_Code_carte;
    }

/*
    +---------------------------+
    |  a_campagne_tag_campagne  |
    +---------------------------+
*/

    protected function mf_tester_existance_a_campagne_tag_campagne( int $Code_tag_campagne, int $Code_campagne )
    {
        $Code_tag_campagne = round($Code_tag_campagne);
        $Code_campagne = round($Code_campagne);
        $requete_sql = "SELECT * FROM ".inst('a_campagne_tag_campagne')." WHERE Code_tag_campagne=$Code_tag_campagne AND Code_campagne=$Code_campagne;";
        $cache_db = new Mf_Cachedb('a_campagne_tag_campagne');
        if ( ! $r = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) $r = 'o'; else $r = 'n';
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $r);
        }
        return $r=='o';
    }

    private function mf_dupliquer_a_campagne_tag_campagne(int $Code_tag_campagne, int $Code_campagne)
    {
        $code_erreur = 0;
        $Code_tag_campagne = round($Code_tag_campagne);
        $Code_campagne = round($Code_campagne);
        if ( !$this->mf_tester_existance_a_campagne_tag_campagne( $Code_tag_campagne, $Code_campagne ) ) $code_erreur = 999999;
        else
        {
            if ( isset($this->mf_dupliquer_table_de_conversion['Code_tag_campagne'][$Code_tag_campagne]) ) $Code_tag_campagne = $this->mf_dupliquer_table_de_conversion['Code_tag_campagne'][$Code_tag_campagne];
            elseif ( isset($this->mf_dupliquer_table_de_conversion['Code_tag_campagne'][0]) ) $Code_tag_campagne = $this->mf_dupliquer_table_de_conversion['Code_tag_campagne'][0];
            if ( isset($this->mf_dupliquer_table_de_conversion['Code_campagne'][$Code_campagne]) ) $Code_campagne = $this->mf_dupliquer_table_de_conversion['Code_campagne'][$Code_campagne];
            elseif ( isset($this->mf_dupliquer_table_de_conversion['Code_campagne'][0]) ) $Code_campagne = $this->mf_dupliquer_table_de_conversion['Code_campagne'][0];
            executer_requete_mysql('INSERT INTO '.inst('a_campagne_tag_campagne')." ( Code_tag_campagne, Code_campagne ) VALUES ( $Code_tag_campagne, $Code_campagne );", true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = 999999;
            }
            else
            {
                $cache_db = new Mf_Cachedb("a_campagne_tag_campagne");
                $cache_db->clear();
            }
        }
        return array('code_erreur' => $code_erreur);
    }

    protected function a_campagne_tag_campagne_liste_Code_tag_campagne_vers_liste_Code_campagne(  array $liste_Code_tag_campagne, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ( $options===null ) { $options=[]; }
        $cache_db = new Mf_Cachedb("a_campagne_tag_campagne");
        $cle = "liste_Code_tag_campagne_vers_liste_Code_campagne__".Sql_Format_Liste($liste_Code_tag_campagne);

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql']))
        {
            foreach ($options['cond_mysql'] as &$condition)
            {
                $argument_cond.= ' AND ('.$condition.')';
            }
            unset($condition);
        }
        $cle.='_'.$argument_cond;

        if ( ! $liste_Code_campagne = $cache_db->read($cle) )
        {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ( $argument_cond!='' )
            {
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = $cache_db->read('a_campagne_tag_campagne__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('a_campagne_tag_campagne').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('a_campagne_tag_campagne__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    $cache_db->pause('a_campagne_tag_campagne__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('a_campagne_tag_campagne').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                    $cache_db->reprendre('a_campagne_tag_campagne__index');
                }
            }

            $liste_Code_campagne = array();
            $res_requete = executer_requete_mysql('SELECT Code_campagne FROM '.inst('a_campagne_tag_campagne')." WHERE Code_tag_campagne IN ".Sql_Format_Liste($liste_Code_tag_campagne).$argument_cond.';', false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $liste_Code_campagne[(int) $row_requete['Code_campagne']] = (int) $row_requete['Code_campagne'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste_Code_campagne);
        }
        return $liste_Code_campagne;
    }

    protected function a_campagne_tag_campagne_liste_Code_campagne_vers_liste_Code_tag_campagne(  array $liste_Code_campagne, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ( $options===null ) { $options=[]; }
        $cache_db = new Mf_Cachedb("a_campagne_tag_campagne");
        $cle = "liste_Code_campagne_vers_liste_Code_tag_campagne__".Sql_Format_Liste($liste_Code_campagne);

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql']))
        {
            foreach ($options['cond_mysql'] as &$condition)
            {
                $argument_cond.= ' AND ('.$condition.')';
            }
            unset($condition);
        }
        $cle.='_'.$argument_cond;

        if ( ! $liste_Code_tag_campagne = $cache_db->read($cle) )
        {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ( $argument_cond!='' )
            {
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = $cache_db->read('a_campagne_tag_campagne__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('a_campagne_tag_campagne').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('a_campagne_tag_campagne__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    $cache_db->pause('a_campagne_tag_campagne__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('a_campagne_tag_campagne').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                    $cache_db->reprendre('a_campagne_tag_campagne__index');
                }
            }

            $liste_Code_tag_campagne = array();
            $res_requete = executer_requete_mysql('SELECT Code_tag_campagne FROM '.inst('a_campagne_tag_campagne')." WHERE Code_campagne IN ".Sql_Format_Liste($liste_Code_campagne).$argument_cond.';', false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $liste_Code_tag_campagne[(int) $row_requete['Code_tag_campagne']] = (int) $row_requete['Code_tag_campagne'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste_Code_tag_campagne);
        }
        return $liste_Code_tag_campagne;
    }

/*
    +-----------------------------+
    |  a_ressource_tag_ressource  |
    +-----------------------------+
*/

    protected function mf_tester_existance_a_ressource_tag_ressource( int $Code_tag_ressource, int $Code_ressource )
    {
        $Code_tag_ressource = round($Code_tag_ressource);
        $Code_ressource = round($Code_ressource);
        $requete_sql = "SELECT * FROM ".inst('a_ressource_tag_ressource')." WHERE Code_tag_ressource=$Code_tag_ressource AND Code_ressource=$Code_ressource;";
        $cache_db = new Mf_Cachedb('a_ressource_tag_ressource');
        if ( ! $r = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) $r = 'o'; else $r = 'n';
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $r);
        }
        return $r=='o';
    }

    private function mf_dupliquer_a_ressource_tag_ressource(int $Code_tag_ressource, int $Code_ressource)
    {
        $code_erreur = 0;
        $Code_tag_ressource = round($Code_tag_ressource);
        $Code_ressource = round($Code_ressource);
        if ( !$this->mf_tester_existance_a_ressource_tag_ressource( $Code_tag_ressource, $Code_ressource ) ) $code_erreur = 999999;
        else
        {
            if ( isset($this->mf_dupliquer_table_de_conversion['Code_tag_ressource'][$Code_tag_ressource]) ) $Code_tag_ressource = $this->mf_dupliquer_table_de_conversion['Code_tag_ressource'][$Code_tag_ressource];
            elseif ( isset($this->mf_dupliquer_table_de_conversion['Code_tag_ressource'][0]) ) $Code_tag_ressource = $this->mf_dupliquer_table_de_conversion['Code_tag_ressource'][0];
            if ( isset($this->mf_dupliquer_table_de_conversion['Code_ressource'][$Code_ressource]) ) $Code_ressource = $this->mf_dupliquer_table_de_conversion['Code_ressource'][$Code_ressource];
            elseif ( isset($this->mf_dupliquer_table_de_conversion['Code_ressource'][0]) ) $Code_ressource = $this->mf_dupliquer_table_de_conversion['Code_ressource'][0];
            executer_requete_mysql('INSERT INTO '.inst('a_ressource_tag_ressource')." ( Code_tag_ressource, Code_ressource ) VALUES ( $Code_tag_ressource, $Code_ressource );", true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = 999999;
            }
            else
            {
                $cache_db = new Mf_Cachedb("a_ressource_tag_ressource");
                $cache_db->clear();
            }
        }
        return array('code_erreur' => $code_erreur);
    }

    protected function a_ressource_tag_ressource_liste_Code_tag_ressource_vers_liste_Code_ressource(  array $liste_Code_tag_ressource, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ( $options===null ) { $options=[]; }
        $cache_db = new Mf_Cachedb("a_ressource_tag_ressource");
        $cle = "liste_Code_tag_ressource_vers_liste_Code_ressource__".Sql_Format_Liste($liste_Code_tag_ressource);

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql']))
        {
            foreach ($options['cond_mysql'] as &$condition)
            {
                $argument_cond.= ' AND ('.$condition.')';
            }
            unset($condition);
        }
        $cle.='_'.$argument_cond;

        if ( ! $liste_Code_ressource = $cache_db->read($cle) )
        {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ( $argument_cond!='' )
            {
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = $cache_db->read('a_ressource_tag_ressource__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('a_ressource_tag_ressource').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('a_ressource_tag_ressource__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    $cache_db->pause('a_ressource_tag_ressource__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('a_ressource_tag_ressource').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                    $cache_db->reprendre('a_ressource_tag_ressource__index');
                }
            }

            $liste_Code_ressource = array();
            $res_requete = executer_requete_mysql('SELECT Code_ressource FROM '.inst('a_ressource_tag_ressource')." WHERE Code_tag_ressource IN ".Sql_Format_Liste($liste_Code_tag_ressource).$argument_cond.';', false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $liste_Code_ressource[(int) $row_requete['Code_ressource']] = (int) $row_requete['Code_ressource'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste_Code_ressource);
        }
        return $liste_Code_ressource;
    }

    protected function a_ressource_tag_ressource_liste_Code_ressource_vers_liste_Code_tag_ressource(  array $liste_Code_ressource, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ( $options===null ) { $options=[]; }
        $cache_db = new Mf_Cachedb("a_ressource_tag_ressource");
        $cle = "liste_Code_ressource_vers_liste_Code_tag_ressource__".Sql_Format_Liste($liste_Code_ressource);

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql']))
        {
            foreach ($options['cond_mysql'] as &$condition)
            {
                $argument_cond.= ' AND ('.$condition.')';
            }
            unset($condition);
        }
        $cle.='_'.$argument_cond;

        if ( ! $liste_Code_tag_ressource = $cache_db->read($cle) )
        {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ( $argument_cond!='' )
            {
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = $cache_db->read('a_ressource_tag_ressource__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('a_ressource_tag_ressource').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('a_ressource_tag_ressource__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    $cache_db->pause('a_ressource_tag_ressource__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('a_ressource_tag_ressource').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                    $cache_db->reprendre('a_ressource_tag_ressource__index');
                }
            }

            $liste_Code_tag_ressource = array();
            $res_requete = executer_requete_mysql('SELECT Code_tag_ressource FROM '.inst('a_ressource_tag_ressource')." WHERE Code_ressource IN ".Sql_Format_Liste($liste_Code_ressource).$argument_cond.';', false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $liste_Code_tag_ressource[(int) $row_requete['Code_tag_ressource']] = (int) $row_requete['Code_tag_ressource'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste_Code_tag_ressource);
        }
        return $liste_Code_tag_ressource;
    }

/*
    +--------------------------+
    |  a_liste_contact_joueur  |
    +--------------------------+
*/

    protected function mf_tester_existance_a_liste_contact_joueur( int $Code_liste_contacts, int $Code_joueur )
    {
        $Code_liste_contacts = round($Code_liste_contacts);
        $Code_joueur = round($Code_joueur);
        $requete_sql = "SELECT * FROM ".inst('a_liste_contact_joueur')." WHERE Code_liste_contacts=$Code_liste_contacts AND Code_joueur=$Code_joueur;";
        $cache_db = new Mf_Cachedb('a_liste_contact_joueur');
        if ( ! $r = $cache_db->read($requete_sql) )
        {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) $r = 'o'; else $r = 'n';
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $r);
        }
        return $r=='o';
    }

    private function mf_dupliquer_a_liste_contact_joueur(int $Code_liste_contacts, int $Code_joueur)
    {
        $code_erreur = 0;
        $Code_liste_contacts = round($Code_liste_contacts);
        $Code_joueur = round($Code_joueur);
        if ( !$this->mf_tester_existance_a_liste_contact_joueur( $Code_liste_contacts, $Code_joueur ) ) $code_erreur = 999999;
        else
        {
            $donnees_a_copier = $this->mf_get($Code_liste_contacts, $Code_joueur, array('autocompletion' => false));
            $a_liste_contact_joueur_Date_creation = $donnees_a_copier['a_liste_contact_joueur_Date_creation'];
            $a_liste_contact_joueur_Date_creation = format_datetime($a_liste_contact_joueur_Date_creation);
            if ( isset($this->mf_dupliquer_table_de_conversion['Code_liste_contacts'][$Code_liste_contacts]) ) $Code_liste_contacts = $this->mf_dupliquer_table_de_conversion['Code_liste_contacts'][$Code_liste_contacts];
            elseif ( isset($this->mf_dupliquer_table_de_conversion['Code_liste_contacts'][0]) ) $Code_liste_contacts = $this->mf_dupliquer_table_de_conversion['Code_liste_contacts'][0];
            if ( isset($this->mf_dupliquer_table_de_conversion['Code_joueur'][$Code_joueur]) ) $Code_joueur = $this->mf_dupliquer_table_de_conversion['Code_joueur'][$Code_joueur];
            elseif ( isset($this->mf_dupliquer_table_de_conversion['Code_joueur'][0]) ) $Code_joueur = $this->mf_dupliquer_table_de_conversion['Code_joueur'][0];
            executer_requete_mysql('INSERT INTO '.inst('a_liste_contact_joueur')." ( a_liste_contact_joueur_Date_creation, Code_liste_contacts, Code_joueur ) VALUES ( ".( $a_liste_contact_joueur_Date_creation!='' ? "'$a_liste_contact_joueur_Date_creation'" : 'NULL' ).", $Code_liste_contacts, $Code_joueur );", true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = 999999;
            }
            else
            {
                $cache_db = new Mf_Cachedb("a_liste_contact_joueur");
                $cache_db->clear();
            }
        }
        return array('code_erreur' => $code_erreur);
    }

    protected function a_liste_contact_joueur_liste_Code_liste_contacts_vers_liste_Code_joueur(  array $liste_Code_liste_contacts, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ( $options===null ) { $options=[]; }
        $cache_db = new Mf_Cachedb("a_liste_contact_joueur");
        $cle = "liste_Code_liste_contacts_vers_liste_Code_joueur__".Sql_Format_Liste($liste_Code_liste_contacts);

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql']))
        {
            foreach ($options['cond_mysql'] as &$condition)
            {
                $argument_cond.= ' AND ('.$condition.')';
            }
            unset($condition);
        }
        $cle.='_'.$argument_cond;

        if ( ! $liste_Code_joueur = $cache_db->read($cle) )
        {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ( $argument_cond!='' )
            {
                if ( strpos($argument_cond, 'a_liste_contact_joueur_Date_creation')!==false ) { $liste_colonnes_a_indexer['a_liste_contact_joueur_Date_creation'] = 'a_liste_contact_joueur_Date_creation'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = $cache_db->read('a_liste_contact_joueur__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('a_liste_contact_joueur').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('a_liste_contact_joueur__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    $cache_db->pause('a_liste_contact_joueur__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('a_liste_contact_joueur').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                    $cache_db->reprendre('a_liste_contact_joueur__index');
                }
            }

            $liste_Code_joueur = array();
            $res_requete = executer_requete_mysql('SELECT Code_joueur FROM '.inst('a_liste_contact_joueur')." WHERE Code_liste_contacts IN ".Sql_Format_Liste($liste_Code_liste_contacts).$argument_cond.';', false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $liste_Code_joueur[(int) $row_requete['Code_joueur']] = (int) $row_requete['Code_joueur'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste_Code_joueur);
        }
        return $liste_Code_joueur;
    }

    protected function a_liste_contact_joueur_liste_Code_joueur_vers_liste_Code_liste_contacts(  array $liste_Code_joueur, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ( $options===null ) { $options=[]; }
        $cache_db = new Mf_Cachedb("a_liste_contact_joueur");
        $cle = "liste_Code_joueur_vers_liste_Code_liste_contacts__".Sql_Format_Liste($liste_Code_joueur);

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql']))
        {
            foreach ($options['cond_mysql'] as &$condition)
            {
                $argument_cond.= ' AND ('.$condition.')';
            }
            unset($condition);
        }
        $cle.='_'.$argument_cond;

        if ( ! $liste_Code_liste_contacts = $cache_db->read($cle) )
        {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ( $argument_cond!='' )
            {
                if ( strpos($argument_cond, 'a_liste_contact_joueur_Date_creation')!==false ) { $liste_colonnes_a_indexer['a_liste_contact_joueur_Date_creation'] = 'a_liste_contact_joueur_Date_creation'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = $cache_db->read('a_liste_contact_joueur__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('a_liste_contact_joueur').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('a_liste_contact_joueur__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    $cache_db->pause('a_liste_contact_joueur__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('a_liste_contact_joueur').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                    $cache_db->reprendre('a_liste_contact_joueur__index');
                }
            }

            $liste_Code_liste_contacts = array();
            $res_requete = executer_requete_mysql('SELECT Code_liste_contacts FROM '.inst('a_liste_contact_joueur')." WHERE Code_joueur IN ".Sql_Format_Liste($liste_Code_joueur).$argument_cond.';', false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $liste_Code_liste_contacts[(int) $row_requete['Code_liste_contacts']] = (int) $row_requete['Code_liste_contacts'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste_Code_liste_contacts);
        }
        return $liste_Code_liste_contacts;
    }

/*
    +-------+
    |  ###  |
    +-------+
*/

    private $gestion_cache=['joueur'=>true,'message'=>true,'parametre'=>true,'groupe'=>true,'personnage'=>true,'campagne'=>true,'tag_campagne'=>true,'carte'=>true,'objet'=>true,'type'=>true,'ressource'=>true,'tag_ressource'=>true,'messagerie'=>true,'liste_contacts'=>true,'a_joueur_parametre'=>true,'a_candidature_joueur_groupe'=>true,'a_membre_joueur_groupe'=>true,'a_invitation_joueur_groupe'=>true,'a_carte_objet'=>true,'a_campagne_tag_campagne'=>true,'a_ressource_tag_ressource'=>true,'a_liste_contact_joueur'=>true,'parametre_valeur'=>true,];

/*
    +-------+
    |  ###  |
    +-------+
*/

    private $mf_dependances=null;
    private $mf_type_table_enfant;

    private function initialisation_dependances()
    {
        $this->mf_dependances=array();
        $this->mf_dependances['messagerie'][]='message';
        $this->mf_dependances['joueur'][]='message';
        $this->mf_dependances['campagne'][]='groupe';
        $this->mf_dependances['joueur'][]='personnage';
        $this->mf_dependances['groupe'][]='personnage';
        $this->mf_dependances['groupe'][]='carte';
        $this->mf_dependances['type'][]='objet';
        $this->mf_dependances['ressource'][]='type';
        $this->mf_dependances['joueur'][]='messagerie';
        $this->mf_dependances['joueur'][]='liste_contacts';
        $this->mf_dependances['parametre'][]='parametre_valeur';
        $this->mf_dependances['joueur'][]='a_joueur_parametre';
        $this->mf_dependances['parametre'][]='a_joueur_parametre';
        $this->mf_dependances['joueur'][]='a_candidature_joueur_groupe';
        $this->mf_dependances['groupe'][]='a_candidature_joueur_groupe';
        $this->mf_dependances['groupe'][]='a_membre_joueur_groupe';
        $this->mf_dependances['joueur'][]='a_membre_joueur_groupe';
        $this->mf_dependances['joueur'][]='a_invitation_joueur_groupe';
        $this->mf_dependances['groupe'][]='a_invitation_joueur_groupe';
        $this->mf_dependances['carte'][]='a_carte_objet';
        $this->mf_dependances['objet'][]='a_carte_objet';
        $this->mf_dependances['tag_campagne'][]='a_campagne_tag_campagne';
        $this->mf_dependances['campagne'][]='a_campagne_tag_campagne';
        $this->mf_dependances['tag_ressource'][]='a_ressource_tag_ressource';
        $this->mf_dependances['ressource'][]='a_ressource_tag_ressource';
        $this->mf_dependances['liste_contacts'][]='a_liste_contact_joueur';
        $this->mf_dependances['joueur'][]='a_liste_contact_joueur';

        $this->mf_type_table_enfant=array();
        $this->mf_type_table_enfant['message']='entite';
        $this->mf_type_table_enfant['groupe']='entite';
        $this->mf_type_table_enfant['personnage']='entite';
        $this->mf_type_table_enfant['carte']='entite';
        $this->mf_type_table_enfant['objet']='entite';
        $this->mf_type_table_enfant['type']='entite';
        $this->mf_type_table_enfant['messagerie']='entite';
        $this->mf_type_table_enfant['liste_contacts']='entite';
        $this->mf_type_table_enfant['parametre_valeur']='entite';
        $this->mf_type_table_enfant['a_joueur_parametre']='association';
        $this->mf_type_table_enfant['a_candidature_joueur_groupe']='association';
        $this->mf_type_table_enfant['a_membre_joueur_groupe']='association';
        $this->mf_type_table_enfant['a_invitation_joueur_groupe']='association';
        $this->mf_type_table_enfant['a_carte_objet']='association';
        $this->mf_type_table_enfant['a_campagne_tag_campagne']='association';
        $this->mf_type_table_enfant['a_ressource_tag_ressource']='association';
        $this->mf_type_table_enfant['a_liste_contact_joueur']='association';
    }

    protected function get_liste_tables_enfants( string $table )
    {
        $liste_tables_enfants = array();
        if ( isset($this->mf_dependances[$table]) )
        {
            foreach ($this->mf_dependances[$table] as $table_fille)
            {
                $liste_tables_enfants[] = $table_fille;
            }
        }
        return $liste_tables_enfants;
    }

    private function get_liste_tables_parents( string $table )
    {
        $liste_tables_parents = array();
        foreach ( $this->mf_dependances as $table_parent => $tables_enfants )
        {
            foreach ( $tables_enfants as $table_enfant )
            {
                if ( $table==$table_enfant )
                {
                    $liste_tables_parents[$table_parent] = $table_parent;
                }
            }
        }
        return $liste_tables_parents;
    }

    private function test_table_ancetre( string $table_enfant, string $table_ancetre )
    {
        $liste_table=array();
        $liste_table[$table_ancetre]=$table_ancetre;
        do
        {
            $liste_table_2 = array();
            foreach ( $liste_table as $table )
            {
                if ( $table==$table_enfant )
                {
                    return true;
                }
                $liste_table_t = $this->get_liste_tables_enfants($table);
                foreach ( $liste_table_t as $table )
                {
                    $liste_table_2[$table]=$table;
                }
            }
            $liste_table = $liste_table_2;
        } while ( count($liste_table)>0 );
    }

    protected function supprimer_donnes_en_cascade( string $nom_table, array $liste_codes )
    {
        if ($this->mf_dependances==null)
        {
            $this->initialisation_dependances();
        }

        $liste_tables_enfants = $this->get_liste_tables_enfants($nom_table);
        foreach ( $liste_tables_enfants as $table_enfant )
        {
            if ($this->mf_type_table_enfant[$table_enfant]=="entite")
            {
                $liste_codes_enfants=array();
                $res_requete = executer_requete_mysql('SELECT Code_'.$table_enfant.' FROM '.inst($table_enfant).' WHERE Code_'.$nom_table.' IN '.Sql_Format_Liste($liste_codes).';', false);
                while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
                {
                    $liste_codes_enfants[]=$row_requete['Code_'.$table_enfant];
                }
                mysqli_free_result($res_requete);
                if ( count($liste_codes_enfants)>0 )
                {
                    $this->supprimer_donnes_en_cascade($table_enfant, $liste_codes_enfants);
                    executer_requete_mysql('DELETE IGNORE FROM '.inst($table_enfant).' WHERE Code_'.$table_enfant.' IN '.Sql_Format_Liste($liste_codes_enfants).';', $this->gestion_cache[$table_enfant]);
                    $cache_db = new Mf_Cachedb($table_enfant);
                    $cache_db->clear();
                }
            }
            else
            {
                executer_requete_mysql('DELETE IGNORE FROM '.inst($table_enfant).' WHERE Code_'.$nom_table.' IN '.Sql_Format_Liste($liste_codes).';', $this->gestion_cache[$table_enfant]);
                if ( requete_mysqli_affected_rows()>0 )
                {
                    $cache_db = new Mf_Cachedb($table_enfant);
                    $cache_db->clear();
                }
            }
        }
    }

    private $liste_cles_dupliques;

    private function mf_dupliquer_table($libelle_table, $code_table, $liste_Codes_parents)
    {
        $this->mf_dupliquer_table_de_conversion = array();
        $this->mf_dupliquer_tables_a_dupliquer = array();
        $this->liste_cles_dupliques = array();
        foreach ($liste_Codes_parents as $Table)
        {
            $code_table_parent = $Table[0];
            $valeur_code_table_parent = $Table[1];
            $this->mf_dupliquer_table_de_conversion[$code_table_parent][0] = $valeur_code_table_parent;
        }
        $this->mf_dupliquer_tables_a_dupliquer["{$libelle_table}_{$code_table}"] = array($libelle_table, $code_table);

        $this->mf_type_table_enfant[$libelle_table]=='entite';

        while ( count($this->mf_dupliquer_tables_a_dupliquer)>count($this->liste_cles_dupliques) )
        {
            foreach ( $this->mf_dupliquer_tables_a_dupliquer as $cle => $tables_a_dupliquer_passe )
            {
                if ( ! isset($this->liste_cles_dupliques[$cle]) )
                {
                    $libelle_table_a_dupliquer = $tables_a_dupliquer_passe[0];
                    $code_table_a_dupliquer = $tables_a_dupliquer_passe[1];
                    $this->mf_dupliquer_table_($libelle_table_a_dupliquer, $code_table_a_dupliquer);
                    $this->liste_cles_dupliques[$cle]=1;
                }
            }
        }















































        $this->mf_dupliquer_table_($libelle_table, $code_table, $liste_Codes_parents);
        foreach ( $this->tables_a_dupliquer as $table_libelle )
        {
            
            
            
            
            
            
            
            
            $liste_tables_parents = $this->get_liste_tables_parents($table);
            foreach ( $this->tables_a_dupliquer as $table )
            {
                $liste_tables_parents = $this->get_liste_tables_parents($table);
                $integrite_codes_parents = true;
                foreach ( $liste_tables_parents as $table_parent )
                {
                    if ( ! isset($this->mf_dupliquer_table_de_conversion[$table_parent]) )
                    {
                        $integrite_codes_parents = false;
                    }
                }
                if ( $integrite_codes_parents )
                {
                }
            }
        }
    }

    private function mf_dupliquer_table_($libelle_table, $code_table)
    {
        switch ($libelle_table)
        {
            case "joueur": $this->mf_dupliquer_joueur($code_table); break;
            case "message": $this->mf_dupliquer_message($code_table); break;
            case "parametre": $this->mf_dupliquer_parametre($code_table); break;
            case "groupe": $this->mf_dupliquer_groupe($code_table); break;
            case "personnage": $this->mf_dupliquer_personnage($code_table); break;
            case "campagne": $this->mf_dupliquer_campagne($code_table); break;
            case "tag_campagne": $this->mf_dupliquer_tag_campagne($code_table); break;
            case "carte": $this->mf_dupliquer_carte($code_table); break;
            case "objet": $this->mf_dupliquer_objet($code_table); break;
            case "type": $this->mf_dupliquer_type($code_table); break;
            case "ressource": $this->mf_dupliquer_ressource($code_table); break;
            case "tag_ressource": $this->mf_dupliquer_tag_ressource($code_table); break;
            case "messagerie": $this->mf_dupliquer_messagerie($code_table); break;
            case "liste_contacts": $this->mf_dupliquer_liste_contacts($code_table); break;
            case "parametre_valeur": $this->mf_dupliquer_parametre_valeur($code_table); break;
        }
    }
}
