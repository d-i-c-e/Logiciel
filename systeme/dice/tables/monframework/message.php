<?php

/*
    +------------------------------+
    |  NE PAS MODIFIER CE FICHIER  |
    +------------------------------+
*/

class message_monframework extends entite_monframework
{

    private static $initialisation = true;
    private static $auto_completion = false;
    private static $actualisation_en_cours = false;
    private static $cache_db;
    private static $maj_droits_ajouter_en_cours = false;
    private static $maj_droits_modifier_en_cours = false;
    private static $maj_droits_supprimer_en_cours = false;

    public function __construct()
    {
        if (self::$initialisation)
        {
            include_once __DIR__ . '/../../erreurs/erreurs__message.php';
            self::$initialisation = false;
            Hook_message::initialisation();
            self::$cache_db = new Mf_Cachedb('message');
        }
        if (!self::$actualisation_en_cours)
        {
            self::$actualisation_en_cours=true;
            Hook_message::actualisation();
            self::$actualisation_en_cours=false;
        }
    }

    static function mf_raz_instance()
    {
        self::$initialisation = true;
    }

    static function initialiser_structure()
    {
        global $mf_initialisation;

        if ( ! test_si_table_existe(inst('message')) )
        {
            executer_requete_mysql('CREATE TABLE '.inst('message').'(Code_message INT AUTO_INCREMENT NOT NULL, PRIMARY KEY (Code_message)) ENGINE=MyISAM;', true);
        }

        $liste_colonnes = lister_les_colonnes(inst('message'));

        if ( isset($liste_colonnes['message_Texte']) )
        {
            if ( typeMyql2Sql($liste_colonnes['message_Texte']['Type'])!='TEXT' )
            {
                executer_requete_mysql('ALTER TABLE '.inst('message').' CHANGE message_Texte message_Texte TEXT;', true);
            }
            unset($liste_colonnes['message_Texte']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('message').' ADD message_Texte TEXT;', true);
            executer_requete_mysql('UPDATE '.inst('message').' SET message_Texte=' . format_sql('message_Texte', $mf_initialisation['message_Texte']) . ';', true);
        }

        if ( isset($liste_colonnes['message_Date']) )
        {
            if ( typeMyql2Sql($liste_colonnes['message_Date']['Type'])!='DATETIME' )
            {
                executer_requete_mysql('ALTER TABLE '.inst('message').' CHANGE message_Date message_Date DATETIME;', true);
            }
            unset($liste_colonnes['message_Date']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('message').' ADD message_Date DATETIME;', true);
            executer_requete_mysql('UPDATE '.inst('message').' SET message_Date=' . format_sql('message_Date', $mf_initialisation['message_Date']) . ';', true);
        }

        if ( isset($liste_colonnes['Code_messagerie']) )
        {
            unset($liste_colonnes['Code_messagerie']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('message').' ADD Code_messagerie int NOT NULL;', true);
        }

        if ( isset($liste_colonnes['Code_joueur']) )
        {
            unset($liste_colonnes['Code_joueur']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('message').' ADD Code_joueur int NOT NULL;', true);
        }

        if ( isset($liste_colonnes['mf_signature']) )
        {
            unset($liste_colonnes['mf_signature']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('message').' ADD mf_signature VARCHAR(255);', true);
            executer_requete_mysql('ALTER TABLE '.inst('message').' ADD INDEX( mf_signature );', true);
        }

        if ( isset($liste_colonnes['mf_cle_unique']) )
        {
            unset($liste_colonnes['mf_cle_unique']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('message').' ADD mf_cle_unique VARCHAR(255);', true);
            executer_requete_mysql('ALTER TABLE '.inst('message').' ADD INDEX( mf_cle_unique );', true);
        }

        if ( isset($liste_colonnes['mf_date_creation']) )
        {
            unset($liste_colonnes['mf_date_creation']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('message').' ADD mf_date_creation DATETIME;', true);
            executer_requete_mysql('ALTER TABLE '.inst('message').' ADD INDEX( mf_date_creation );', true);
        }

        if ( isset($liste_colonnes['mf_date_modification']) )
        {
            unset($liste_colonnes['mf_date_modification']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('message').' ADD mf_date_modification DATETIME;', true);
            executer_requete_mysql('ALTER TABLE '.inst('message').' ADD INDEX( mf_date_modification );', true);
        }

        unset($liste_colonnes['Code_message']);

        foreach ($liste_colonnes as $field => $value)
        {
            executer_requete_mysql('ALTER TABLE '.inst('message').' DROP COLUMN '.$field.';', true);
        }

    }

    public function mfi_ajouter_auto(array $interface)
    {
        if (isset($interface['Code_messagerie'])) { $liste_Code_messagerie = array($interface['Code_messagerie']); }
        elseif (isset($interface['liste_Code_messagerie'])) { $liste_Code_messagerie = $interface['liste_Code_messagerie']; }
        else { $liste_Code_messagerie = $this->get_liste_Code_messagerie(); }
        if (isset($interface['Code_joueur'])) { $liste_Code_joueur = array($interface['Code_joueur']); }
        elseif (isset($interface['liste_Code_joueur'])) { $liste_Code_joueur = $interface['liste_Code_joueur']; }
        else { $liste_Code_joueur = $this->get_liste_Code_joueur(); }
        $liste_message = array();
        foreach ($liste_Code_messagerie as $Code_messagerie)
        {
            foreach ($liste_Code_joueur as $Code_joueur)
            {
                $liste_message[] = array('Code_messagerie'=>$Code_messagerie,'Code_joueur'=>$Code_joueur);
            }
        }
        if (isset($interface['message_Texte'])) { foreach ($liste_message as &$message) { $message['message_Texte'] = $interface['message_Texte']; } unset($message); }
        if (isset($interface['message_Date'])) { foreach ($liste_message as &$message) { $message['message_Date'] = $interface['message_Date']; } unset($message); }
        return $this->mf_ajouter_3($liste_message);
    }

    public function mfi_supprimer_auto(array $interface)
    {
        if (isset($interface['Code_messagerie'])) { $liste_Code_messagerie = array($interface['Code_messagerie']); }
        elseif (isset($interface['liste_Code_messagerie'])) { $liste_Code_messagerie = $interface['liste_Code_messagerie']; }
        else { $liste_Code_messagerie = $this->get_liste_Code_messagerie(); }
        if (isset($interface['Code_joueur'])) { $liste_Code_joueur = array($interface['Code_joueur']); }
        elseif (isset($interface['liste_Code_joueur'])) { $liste_Code_joueur = $interface['liste_Code_joueur']; }
        else { $liste_Code_joueur = $this->get_liste_Code_joueur(); }
        $liste_Code_message = $this->liste_Code_messagerie_vers_liste_Code_message($liste_Code_messagerie);
        $liste_Code_message = liste_intersection_A_et_B($liste_Code_message,$this->liste_Code_joueur_vers_liste_Code_message($liste_Code_joueur));
        $this->mf_supprimer_3($liste_Code_message);
    }

    public function mf_ajouter(string $message_Texte, string $message_Date, int $Code_messagerie, int $Code_joueur, ?bool $force=false)
    {
        if ( $force===null ) { $force=false; }
        $Code_message = 0;
        $code_erreur = 0;
        $Code_messagerie = round($Code_messagerie);
        $Code_joueur = round($Code_joueur);
        $message_Date = format_datetime($message_Date);
        Hook_message::pre_controller($message_Texte, $message_Date, $Code_messagerie, $Code_joueur);
        if (!$force)
        {
            if (!self::$maj_droits_ajouter_en_cours)
            {
                self::$maj_droits_ajouter_en_cours = true;
                Hook_message::hook_actualiser_les_droits_ajouter($Code_messagerie, $Code_joueur);
                self::$maj_droits_ajouter_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['message__AJOUTER']) ) $code_erreur = REFUS_MESSAGE__AJOUTER;
        elseif ( !$this->mf_tester_existance_Code_messagerie($Code_messagerie) ) $code_erreur = ERR_MESSAGE__AJOUTER__CODE_MESSAGERIE_INEXISTANT;
        elseif ( !$this->mf_tester_existance_Code_joueur($Code_joueur) ) $code_erreur = ERR_MESSAGE__AJOUTER__CODE_JOUEUR_INEXISTANT;
        elseif ( CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_messagerie', $Code_messagerie) ) $code_erreur = ACCES_CODE_MESSAGERIE_REFUSE;
        elseif ( CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_joueur', $Code_joueur) ) $code_erreur = ACCES_CODE_JOUEUR_REFUSE;
        elseif ( !Hook_message::autorisation_ajout($message_Texte, $message_Date, $Code_messagerie, $Code_joueur) ) $code_erreur = REFUS_MESSAGE__AJOUT_BLOQUEE;
        else
        {
            Hook_message::data_controller($message_Texte, $message_Date, $Code_messagerie, $Code_joueur);
            $mf_signature = text_sql(Hook_message::calcul_signature($message_Texte, $message_Date, $Code_messagerie, $Code_joueur));
            $mf_cle_unique = text_sql(Hook_message::calcul_cle_unique($message_Texte, $message_Date, $Code_messagerie, $Code_joueur));
            $message_Texte = text_sql($message_Texte);
            $message_Date = format_datetime($message_Date);
            $requete = "INSERT INTO ".inst('message')." ( mf_signature, mf_cle_unique, mf_date_creation, mf_date_modification, message_Texte, message_Date, Code_messagerie, Code_joueur ) VALUES ( '$mf_signature', '$mf_cle_unique', '".get_now()."', '".get_now()."', '$message_Texte', ".( $message_Date!='' ? "'$message_Date'" : 'NULL' ).", $Code_messagerie, $Code_joueur );";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql($requete, true);
            $Code_message = requete_mysql_insert_id();
            if ($Code_message==0)
            {
                $code_erreur = ERR_MESSAGE__AJOUTER__AJOUT_REFUSE;
                self::$cache_db->reprendre($cle);
            }
            else
            {
                self::$cache_db->clear();
                self::$cache_db->reprendre($cle);
                Hook_message::ajouter( $Code_message );
            }
        }
        if ( $code_erreur!=0 )
        {
            global $mf_message_erreur_personalise, $mf_libelle_erreur;
            if ($mf_message_erreur_personalise!='')
            {
                $mf_libelle_erreur[$code_erreur]=$mf_message_erreur_personalise;
                $mf_message_erreur_personalise='';
            }
        }
        return array('code_erreur' => $code_erreur, 'Code_message' => $Code_message, 'callback' => ( $code_erreur==0 ? Hook_message::callback_post($Code_message) : null ));
    }

    public function mf_creer(int $Code_messagerie, int $Code_joueur, ?bool $force=null)
    {
        if ( $force===null ) { $force=false; }
        global $mf_initialisation, $mf_droits_defaut;
        $mf_droits_defaut["message__AJOUTER"] = $mf_droits_defaut["message__CREER"];
        $message_Texte = $mf_initialisation['message_Texte'];
        $message_Date = $mf_initialisation['message_Date'];
        return $this->mf_ajouter($message_Texte, $message_Date, $Code_messagerie, $Code_joueur, $force);
    }

    public function mf_ajouter_2(array $ligne, bool $force=null) // array('colonne1' => 'valeur1',  [...] )
    {
        if ( $force===null ) { $force=false; }
        global $mf_initialisation;
        $Code_messagerie = (int)(isset($ligne['Code_messagerie'])?round($ligne['Code_messagerie']):0);
        $Code_joueur = (int)(isset($ligne['Code_joueur'])?round($ligne['Code_joueur']):get_joueur_courant('Code_joueur'));
        $message_Texte = (string)(isset($ligne['message_Texte'])?$ligne['message_Texte']:$mf_initialisation['message_Texte']);
        $message_Date = (string)(isset($ligne['message_Date'])?$ligne['message_Date']:$mf_initialisation['message_Date']);
        return $this->mf_ajouter($message_Texte, $message_Date, $Code_messagerie, $Code_joueur, $force);
    }

    public function mf_ajouter_3(array $lignes) // array( array( 'colonne1' => 'valeur1', 'colonne2' => 'valeur2',  [...] ), [...] )
    {
        global $mf_initialisation;
        $code_erreur = 0;
        $values = '';
        foreach ($lignes as $ligne)
        {
            $Code_messagerie = (int)(isset($ligne['Code_messagerie'])?round($ligne['Code_messagerie']):0);
            $Code_joueur = (int)(isset($ligne['Code_joueur'])?round($ligne['Code_joueur']):0);
            $message_Texte = text_sql(isset($ligne['message_Texte'])?$ligne['message_Texte']:$mf_initialisation['message_Texte']);
            $message_Date = format_datetime(isset($ligne['message_Date'])?$ligne['message_Date']:$mf_initialisation['message_Date']);
            if ($Code_messagerie != 0)
            {
                if ($Code_joueur != 0)
                {
                    $values.=($values!="" ? "," : "")."('$message_Texte', ".( $message_Date!='' ? "'$message_Date'" : 'NULL' ).", $Code_messagerie, $Code_joueur)";
                }
            }
        }
        if ($values!='')
        {
            $requete = "INSERT INTO ".inst('message')." ( message_Texte, message_Date, Code_messagerie, Code_joueur ) VALUES $values;";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            $n = requete_mysqli_affected_rows();
            if ($n < count($lignes))
            {
                $code_erreur = ERR_MESSAGE__AJOUTER_3__ECHEC_AJOUT;
            }
            if ($n > 0)
            {
                self::$cache_db->clear();
            }
            self::$cache_db->reprendre($cle);
        }
        if ( $code_erreur!=0 )
        {
            global $mf_message_erreur_personalise, $mf_libelle_erreur;
            if ($mf_message_erreur_personalise!='')
            {
                $mf_libelle_erreur[$code_erreur]=$mf_message_erreur_personalise;
                $mf_message_erreur_personalise='';
            }
        }
        return array('code_erreur' => $code_erreur);
    }

    public function mf_modifier( int $Code_message, string $message_Texte, string $message_Date, ?int $Code_messagerie=null, ?int $Code_joueur=null, ?bool $force=null)
    {
        if ( $force===null ) { $force=false; }
        $code_erreur = 0;
        $Code_message = round($Code_message);
        $Code_messagerie = round($Code_messagerie);
        $Code_joueur = round($Code_joueur);
        $message_Date = format_datetime($message_Date);
        Hook_message::pre_controller($message_Texte, $message_Date, $Code_messagerie, $Code_joueur, $Code_message);
        if (!$force)
        {
            if (!self::$maj_droits_modifier_en_cours)
            {
                self::$maj_droits_modifier_en_cours = true;
                Hook_message::hook_actualiser_les_droits_modifier($Code_message);
                self::$maj_droits_modifier_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['message__MODIFIER']) ) $code_erreur = REFUS_MESSAGE__MODIFIER;
        elseif ( !$this->mf_tester_existance_Code_message($Code_message) ) $code_erreur = ERR_MESSAGE__MODIFIER__CODE_MESSAGE_INEXISTANT;
        elseif ( $Code_messagerie!=0 && !$this->mf_tester_existance_Code_messagerie($Code_messagerie) ) $code_erreur = ERR_MESSAGE__MODIFIER__CODE_MESSAGERIE_INEXISTANT;
        elseif ( $Code_joueur!=0 && !$this->mf_tester_existance_Code_joueur($Code_joueur) ) $code_erreur = ERR_MESSAGE__MODIFIER__CODE_JOUEUR_INEXISTANT;
        elseif ( CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_message', $Code_message) ) $code_erreur = ACCES_CODE_MESSAGE_REFUSE;
        elseif ( $Code_messagerie!=0 && CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_messagerie', $Code_messagerie) ) $code_erreur = ACCES_CODE_MESSAGERIE_REFUSE;
        elseif ( $Code_joueur!=0 && CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_joueur', $Code_joueur) ) $code_erreur = ACCES_CODE_JOUEUR_REFUSE;
        elseif ( !Hook_message::autorisation_modification($Code_message, $message_Texte, $message_Date, $Code_messagerie, $Code_joueur) ) $code_erreur = REFUS_MESSAGE__MODIFICATION_BLOQUEE;
        else
        {
            Hook_message::data_controller($message_Texte, $message_Date, $Code_messagerie, $Code_joueur, $Code_message);
            $message = $this->mf_get_2( $Code_message, array('autocompletion' => false, 'masquer_mdp' => false) );
            $mf_colonnes_a_modifier=[];
            $bool__message_Texte = false; if ( $message_Texte!=$message['message_Texte'] ) { Hook_message::data_controller__message_Texte($message['message_Texte'], $message_Texte, $Code_message); if ( $message_Texte!=$message['message_Texte'] ) { $mf_colonnes_a_modifier[] = 'message_Texte=' . format_sql('message_Texte', $message_Texte); $bool__message_Texte = true; } }
            $bool__message_Date = false; if ( $message_Date!=$message['message_Date'] ) { Hook_message::data_controller__message_Date($message['message_Date'], $message_Date, $Code_message); if ( $message_Date!=$message['message_Date'] ) { $mf_colonnes_a_modifier[] = 'message_Date=' . format_sql('message_Date', $message_Date); $bool__message_Date = true; } }
            $bool__Code_messagerie = false; if ( $Code_messagerie!=0 && $Code_messagerie!=$message['Code_messagerie'] ) { Hook_message::data_controller__Code_messagerie($message['Code_messagerie'], $Code_messagerie, $Code_message); if ( $Code_messagerie!=0 && $Code_messagerie!=$message['Code_messagerie'] ) { $mf_colonnes_a_modifier[] = 'Code_messagerie=' . $Code_messagerie; $bool__Code_messagerie = true; } }
            $bool__Code_joueur = false; if ( $Code_joueur!=0 && $Code_joueur!=$message['Code_joueur'] ) { Hook_message::data_controller__Code_joueur($message['Code_joueur'], $Code_joueur, $Code_message); if ( $Code_joueur!=0 && $Code_joueur!=$message['Code_joueur'] ) { $mf_colonnes_a_modifier[] = 'Code_joueur=' . $Code_joueur; $bool__Code_joueur = true; } }
            if (count($mf_colonnes_a_modifier)>0) {
                $mf_signature = text_sql(Hook_message::calcul_signature($message_Texte, $message_Date, $Code_messagerie, $Code_joueur));
                $mf_cle_unique = text_sql(Hook_message::calcul_cle_unique($message_Texte, $message_Date, $Code_messagerie, $Code_joueur));
                $mf_colonnes_a_modifier[] = 'mf_signature=\'' . $mf_signature . '\'';
                $mf_colonnes_a_modifier[] = 'mf_cle_unique=\'' . $mf_cle_unique . '\'';
                $mf_colonnes_a_modifier[] = 'mf_date_modification=\'' . get_now() . '\'';
                $requete = 'UPDATE '.inst('message').' SET ' . enumeration($mf_colonnes_a_modifier) . ' WHERE Code_message = ' . $Code_message . ';';
                $cle = md5($requete).salt(10);
                self::$cache_db->pause($cle);
                executer_requete_mysql( $requete , true);
                if ( requete_mysqli_affected_rows()==0 )
                {
                    $code_erreur = ERR_MESSAGE__MODIFIER__AUCUN_CHANGEMENT;
                    self::$cache_db->reprendre($cle);
                }
                else
                {
                    self::$cache_db->clear();
                    self::$cache_db->reprendre($cle);
                    Hook_message::modifier($Code_message, $bool__message_Texte, $bool__message_Date, $bool__Code_messagerie, $bool__Code_joueur);
                }
            }
            else
            {
                $code_erreur = ERR_MESSAGE__MODIFIER__AUCUN_CHANGEMENT;
            }
        }
        if ( $code_erreur!=0 )
        {
            global $mf_message_erreur_personalise, $mf_libelle_erreur;
            if ($mf_message_erreur_personalise!='')
            {
                $mf_libelle_erreur[$code_erreur]=$mf_message_erreur_personalise;
                $mf_message_erreur_personalise='';
            }
        }
        return array('code_erreur' => $code_erreur, 'callback' => ( $code_erreur == 0 ? Hook_message::callback_put($Code_message) : null ));
    }

    public function mf_modifier_2(array $lignes, ?bool $force=null) // array( $Code_message => array('colonne1' => 'valeur1',  [...] ) )
    {
        if ( $force===null ) { $force=false; }
        $code_erreur = 0;
        foreach ( $lignes as $Code_message => $colonnes )
        {
            if ( $code_erreur==0 )
            {
                $Code_message = (int)round($Code_message);
                $message = $this->mf_get_2($Code_message, array('autocompletion' => false));
                if (!$force)
                {
                    if (!self::$maj_droits_modifier_en_cours)
                    {
                        self::$maj_droits_modifier_en_cours = true;
                        Hook_message::hook_actualiser_les_droits_modifier($Code_message);
                        self::$maj_droits_modifier_en_cours = false;
                    }
                }
                $Code_messagerie = ( isset($colonnes['Code_messagerie']) && ( $force || mf_matrice_droits(['api_modifier_ref__message__Code_messagerie', 'message__MODIFIER']) ) ? $colonnes['Code_messagerie'] : (isset($message['Code_messagerie']) ? $message['Code_messagerie'] : 0 ));
                $Code_joueur = ( isset($colonnes['Code_joueur']) && ( $force || mf_matrice_droits(['api_modifier_ref__message__Code_joueur', 'message__MODIFIER']) ) ? $colonnes['Code_joueur'] : (isset($message['Code_joueur']) ? $message['Code_joueur'] : 0 ));
                $message_Texte = (string)( isset($colonnes['message_Texte']) && ( $force || mf_matrice_droits(['api_modifier__message_Texte', 'message__MODIFIER']) ) ? $colonnes['message_Texte'] : ( isset($message['message_Texte']) ? $message['message_Texte'] : '' ) );
                $message_Date = (string)( isset($colonnes['message_Date']) && ( $force || mf_matrice_droits(['api_modifier__message_Date', 'message__MODIFIER']) ) ? $colonnes['message_Date'] : ( isset($message['message_Date']) ? $message['message_Date'] : '' ) );
                $retour = $this->mf_modifier($Code_message, $message_Texte, $message_Date, $Code_messagerie, $Code_joueur, true);
                if ( $retour['code_erreur']!=0 && $retour['code_erreur'] != ERR_MESSAGE__MODIFIER__AUCUN_CHANGEMENT )
                {
                    $code_erreur = $retour['code_erreur'];
                }
                if (count($lignes)==1)
                {
                    return $retour;
                }
            }
        }
        if ( $code_erreur!=0 )
        {
            global $mf_message_erreur_personalise, $mf_libelle_erreur;
            if ($mf_message_erreur_personalise!='')
            {
                $mf_libelle_erreur[$code_erreur]=$mf_message_erreur_personalise;
                $mf_message_erreur_personalise='';
            }
        }
        return array('code_erreur' => $code_erreur);
    }

    public function mf_modifier_3(array $lignes) // array( $Code_message => array('colonne1' => 'valeur1',  [...] ) )
    {
        $code_erreur = 0;
        $modifs = false;

        // transformation des lignes en colonnes
        $valeurs_en_colonnes=array();
        $indices_par_colonne=array();
        $liste_valeurs_indexees=array();
        foreach ( $lignes as $Code_message => $colonnes )
        {
            foreach ($colonnes as $colonne => $valeur)
            {
                if ( $colonne=='message_Texte' || $colonne=='message_Date' || $colonne=='Code_messagerie' || $colonne=='Code_joueur' )
                {
                    $valeurs_en_colonnes[$colonne][$Code_message]=$valeur;
                    $indices_par_colonne[$colonne][]=$Code_message;
                    $liste_valeurs_indexees[$colonne][''.$valeur][]=$Code_message;
                }
            }
        }

        // fabrication des requetes
        $cle = md5('mf_modifier_3').salt(10);
        self::$cache_db->pause($cle);
        foreach ( $valeurs_en_colonnes as $colonne => $valeurs )
        {
            if ( count($liste_valeurs_indexees[$colonne]) > 3 )
            {
                $modification_sql = $colonne . ' = CASE Code_message';
                foreach ( $valeurs as $Code_message => $valeur )
                {
                    $modification_sql.=' WHEN ' . $Code_message . ' THEN ' . format_sql($colonne, $valeur);
                }
                $modification_sql.=' END';
                $perimetre = Sql_Format_Liste($indices_par_colonne[$colonne]);
                executer_requete_mysql('UPDATE ' . inst('message') . ' SET ' . $modification_sql . ' WHERE Code_message IN ' . $perimetre . ';', true);
                if ( requete_mysqli_affected_rows()!=0 )
                {
                    $modifs = true;
                }
            }
            else
            {
                foreach ( $liste_valeurs_indexees[$colonne] as $valeur => $indices_par_valeur )
                {
                    $perimetre = Sql_Format_Liste($indices_par_valeur);
                    executer_requete_mysql('UPDATE ' . inst('message') . ' SET ' . $colonne . ' = ' . format_sql($colonne, $valeur) . ' WHERE Code_message IN ' . $perimetre . ';', true);
                    if ( requete_mysqli_affected_rows()!=0 )
                    {
                        $modifs = true;
                    }
                }
            }
        }

        if ( ! $modifs && $code_erreur==0 )
        {
            $code_erreur = ERR_MESSAGE__MODIFIER_3__AUCUN_CHANGEMENT;
        }
        if ($modifs)
        {
            self::$cache_db->clear();
        }
        self::$cache_db->reprendre($cle);
        if ( $code_erreur!=0 )
        {
            global $mf_message_erreur_personalise, $mf_libelle_erreur;
            if ($mf_message_erreur_personalise!='')
            {
                $mf_libelle_erreur[$code_erreur]=$mf_message_erreur_personalise;
                $mf_message_erreur_personalise='';
            }
        }
        return array('code_erreur' => $code_erreur);
    }

    public function mf_modifier_4( int $Code_messagerie, int $Code_joueur, array $data, ?array $options = null /* $options = array( 'cond_mysql' => array(), 'limit' => 0 ) */ ) // $data = array('colonne1' => 'valeur1', ... )
    {
        if ( $options===null ) { $force=[]; }
        $code_erreur = 0;
        $Code_messagerie = round($Code_messagerie);
        $Code_joueur = round($Code_joueur);
        $mf_colonnes_a_modifier=[];
        if ( isset($data['message_Texte']) ) { $mf_colonnes_a_modifier[] = 'message_Texte = ' . format_sql('message_Texte', $data['message_Texte']); }
        if ( isset($data['message_Date']) ) { $mf_colonnes_a_modifier[] = 'message_Date = ' . format_sql('message_Date', $data['message_Date']); }
        if ( count($mf_colonnes_a_modifier)>0 )
        {
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

            // limit
            $limit = 0;
            if (isset($options['limit']))
            {
                $limit = round($options['limit']);
            }

            $requete = 'UPDATE ' . inst('message') . ' SET ' . enumeration($mf_colonnes_a_modifier) . " WHERE 1".( $Code_messagerie!=0 ? " AND Code_messagerie=$Code_messagerie" : "" )."".( $Code_joueur!=0 ? " AND Code_joueur=$Code_joueur" : "" )."$argument_cond" . ( $limit>0 ? ' LIMIT ' . $limit : '' ) . ";";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_MESSAGE__MODIFIER_4__AUCUN_CHANGEMENT;
            }
            else
            {
                self::$cache_db->clear();
            }
            self::$cache_db->reprendre($cle);
        }
        return array('code_erreur' => $code_erreur);
    }

    public function mf_supprimer( int $Code_message, ?bool $force=null )
    {
        if ( $force===null ) { $force=false; }
        $code_erreur = 0;
        $Code_message = round($Code_message);
        if (!$force)
        {
            if (!self::$maj_droits_supprimer_en_cours)
            {
                self::$maj_droits_supprimer_en_cours = true;
                Hook_message::hook_actualiser_les_droits_supprimer($Code_message);
                self::$maj_droits_supprimer_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['message__SUPPRIMER']) ) $code_erreur = REFUS_MESSAGE__SUPPRIMER;
        elseif ( !$this->mf_tester_existance_Code_message($Code_message) ) $code_erreur = ERR_MESSAGE__SUPPRIMER_2__CODE_MESSAGE_INEXISTANT;
        elseif ( CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_message', $Code_message) ) $code_erreur = ACCES_CODE_MESSAGE_REFUSE;
        elseif ( !Hook_message::autorisation_suppression($Code_message) ) $code_erreur = REFUS_MESSAGE__SUPPRESSION_BLOQUEE;
        else
        {
            $copie__message = $this->mf_get($Code_message, array('autocompletion' => false));
            $this->supprimer_donnes_en_cascade("message", array($Code_message));
            $requete = "DELETE IGNORE FROM ".inst('message')." WHERE Code_message=$Code_message;";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_MESSAGE__SUPPRIMER__REFUSEE;
                self::$cache_db->reprendre($cle);
            }
            else
            {
                self::$cache_db->clear();
                self::$cache_db->reprendre($cle);
                Hook_message::supprimer($copie__message);
            }
        }
        if ( $code_erreur!=0 )
        {
            global $mf_message_erreur_personalise, $mf_libelle_erreur;
            if ($mf_message_erreur_personalise!='')
            {
                $mf_libelle_erreur[$code_erreur]=$mf_message_erreur_personalise;
                $mf_message_erreur_personalise='';
            }
        }
        return array('code_erreur' => $code_erreur);
    }

    public function mf_supprimer_2(array $liste_Code_message, ?bool $force=null)
    {
        if ( $force===null ) { $force=false; }
        $code_erreur=0;
        $copie__liste_message = $this->mf_lister_2($liste_Code_message, array('autocompletion' => false));
        $liste_Code_message=array();
        foreach ( $copie__liste_message as $copie__message )
        {
            $Code_message = $copie__message['Code_message'];
            if (!$force)
            {
                if (!self::$maj_droits_supprimer_en_cours)
                {
                    self::$maj_droits_supprimer_en_cours = true;
                    Hook_message::hook_actualiser_les_droits_supprimer($Code_message);
                    self::$maj_droits_supprimer_en_cours = false;
                }
            }
            if ( !$force && !mf_matrice_droits(['message__SUPPRIMER']) ) $code_erreur = REFUS_MESSAGE__SUPPRIMER;
            elseif ( !Hook_message::autorisation_suppression($Code_message) ) $code_erreur = REFUS_MESSAGE__SUPPRESSION_BLOQUEE;
            {
                $liste_Code_message[] = $Code_message;
            }
        }
        if ( $code_erreur==0 && count($liste_Code_message)>0 )
        {
            $this->supprimer_donnes_en_cascade("message", $liste_Code_message);
            $requete = "DELETE IGNORE FROM ".inst('message')." WHERE Code_message IN ".Sql_Format_Liste($liste_Code_message).";";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_MESSAGE__SUPPRIMER_2__REFUSEE;
                self::$cache_db->reprendre($cle);
            }
            else
            {
                self::$cache_db->clear();
                self::$cache_db->reprendre($cle);
                Hook_message::supprimer_2($copie__liste_message);
            }
        }
        if ( $code_erreur!=0 )
        {
            global $mf_message_erreur_personalise, $mf_libelle_erreur;
            if ($mf_message_erreur_personalise!='')
            {
                $mf_libelle_erreur[$code_erreur]=$mf_message_erreur_personalise;
                $mf_message_erreur_personalise='';
            }
        }
        return array('code_erreur' => $code_erreur);
    }

    public function mf_supprimer_3(array $liste_Code_message)
    {
        $code_erreur=0;
        if ( count($liste_Code_message)>0 )
        {
            $this->supprimer_donnes_en_cascade("message", $liste_Code_message);
            $requete = "DELETE IGNORE FROM ".inst('message')." WHERE Code_message IN ".Sql_Format_Liste($liste_Code_message).";";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_MESSAGE__SUPPRIMER_3__REFUSEE;
            }
            else
            {
                self::$cache_db->clear();
            }
            self::$cache_db->reprendre($cle);
        }
        if ( $code_erreur!=0 )
        {
            global $mf_message_erreur_personalise, $mf_libelle_erreur;
            if ($mf_message_erreur_personalise!='')
            {
                $mf_libelle_erreur[$code_erreur]=$mf_message_erreur_personalise;
                $mf_message_erreur_personalise='';
            }
        }
        return array('code_erreur' => $code_erreur);
    }

    public function mf_lister_contexte(?bool $contexte_parent=null, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ( $contexte_parent===null ) { $contexte_parent=true; }
        if ( $options===null ) { $options=[]; }
        global $mf_contexte, $est_charge;
        if ( ! $contexte_parent && $mf_contexte['Code_message']!=0 )
        {
            $message = $this->mf_get( $mf_contexte['Code_message'], $options);
            return array( $message['Code_message'] => $message );
        }
        else
        {
            return $this->mf_lister(isset($est_charge['messagerie']) ? $mf_contexte['Code_messagerie'] : 0, isset($est_charge['joueur']) ? $mf_contexte['Code_joueur'] : 0, $options);
        }
    }

    public function mf_lister(?int $Code_messagerie=null, ?int $Code_joueur=null, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cle = "message__lister";
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

        // tris
        $argument_tris = '';
        if ( ! isset($options['tris']) )
        {
            $options['tris']=array();
        }
        if ( count($options['tris'])==0 )
        {
            global $mf_tri_defaut_table;
            if ( isset($mf_tri_defaut_table['message']) )
            {
                $options['tris'] = $mf_tri_defaut_table['message'];
            }
        }
        foreach ($options['tris'] as $colonne => $tri)
        {
            if ( $colonne != 'message_Texte' )
            {
                if ( $argument_tris=='' ) { $argument_tris = ' ORDER BY '; } else { $argument_tris .= ', '; }
                if ( $tri!='DESC' ) $tri = 'ASC';
                $argument_tris.=$colonne.' '.$tri;
            }
        }
        $cle.='_'.$argument_tris;

        // limit
        $argument_limit = '';
        if (isset($options['limit'][0]) && isset($options['limit'][1]))
        {
            $argument_limit = ' LIMIT '.$options['limit'][0].','.$options['limit'][1];
        }
        $cle.='_'.$argument_limit;

        // autocompletion
        $autocompletion = AUTOCOMPLETION_DEFAUT;
        if (isset($options['autocompletion']))
        {
            $autocompletion = ( $options['autocompletion']==true );
        }

        // controle_acces_donnees
        $controle_acces_donnees = CONTROLE_ACCES_DONNEES_DEFAUT;
        if (isset($options['controle_acces_donnees']))
        {
            $controle_acces_donnees = ( $options['controle_acces_donnees']==true );
        }

        // afficher toutes les colonnes
        $toutes_colonnes = TOUTES_COLONNES_DEFAUT;
        if (isset($options['toutes_colonnes']))
        {
            $toutes_colonnes = ( $options['toutes_colonnes']==true );
        }
        $cle.='_'.( $toutes_colonnes ? '1' : '0' );

        // maj
        $maj = true;
        if (isset($options['maj']))
        {
            $maj = ( $options['maj']==true );
        }
        $cle.='_'.( $maj ? '1' : '0' );

        $nouvelle_lecture = true;
        while ( $nouvelle_lecture )
        {
            $nouvelle_lecture = false;
            if ( ! $liste = self::$cache_db->read($cle) )
            {

                // Indexes
                $liste_colonnes_a_indexer = [];
                if ( $argument_cond!='' )
                {
                    if ( strpos($argument_cond, 'message_Date')!==false ) { $liste_colonnes_a_indexer['message_Date'] = 'message_Date'; }
                }
                if ( isset($options['tris']) )
                {
                    if ( isset($options['tris']['message_Date']) ) { $liste_colonnes_a_indexer['message_Date'] = 'message_Date'; }
                }
                if ( count($liste_colonnes_a_indexer)>0 )
                {
                    if ( ! $mf_liste_requete_index = self::$cache_db->read('message__index') )
                    {
                        $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('message').'`;', false);
                        $mf_liste_requete_index = array();
                        while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                        {
                            $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                        }
                        mysqli_free_result($res_requete_index);
                        self::$cache_db->write('message__index', $mf_liste_requete_index);
                    }
                    foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                    {
                        if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                    }
                    if ( count($liste_colonnes_a_indexer) > 0 )
                    {
                        self::$cache_db->pause('message__index');
                        foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                        {
                            executer_requete_mysql('ALTER TABLE `'.inst('message').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                        }
                        self::$cache_db->clear();
                        self::$cache_db->reprendre('message__index');
                    }
                }

                $liste = array();
                $liste_message_pas_a_jour = array();
                if ($toutes_colonnes)
                {
                    $colonnes='Code_message, message_Texte, message_Date, Code_messagerie, Code_joueur';
                }
                else
                {
                    $colonnes='Code_message, message_Date, Code_messagerie, Code_joueur';
                }
                $res_requete = executer_requete_mysql("SELECT $colonnes FROM ".inst('message')." WHERE 1{$argument_cond}".( $Code_messagerie!=0 ? " AND Code_messagerie=$Code_messagerie" : "" )."".( $Code_joueur!=0 ? " AND Code_joueur=$Code_joueur" : "" )."{$argument_tris}{$argument_limit};", false);
                while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
                {
                    mf_formatage_db_type_php($row_requete);
                    $liste[$row_requete['Code_message']] = $row_requete;
                    if ( $maj && ! Hook_message::est_a_jour( $row_requete ) )
                    {
                        $liste_message_pas_a_jour[$row_requete['Code_message']] = $row_requete;
                        $nouvelle_lecture = true;
                    }
                }
                mysqli_free_result($res_requete);
                if (count($options['tris'])==1 && ! $nouvelle_lecture)
                {
                    foreach ($options['tris'] as $colonne => $tri)
                    {
                        global $lang_standard;
                        if (isset($lang_standard[$colonne.'_']))
                        {
                            effectuer_tri_suivant_langue($liste, $colonne, $tri);
                        }
                    }
                }
                if ( ! $nouvelle_lecture )
                {
                    self::$cache_db->write($cle, $liste);
                }
            }
            if ( $nouvelle_lecture )
            {
                Hook_message::mettre_a_jour( $liste_message_pas_a_jour );
            }
        }

        foreach ($liste as $elem)
        {
            if ( $controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_message', $elem['Code_message']) )
            {
                unset($liste[$elem['Code_message']]);
            }
            else
            {
                if (!self::$auto_completion && $autocompletion)
                {
                    self::$auto_completion = true;
                    Hook_message::completion($liste[$elem['Code_message']]);
                    self::$auto_completion = false;
                }
            }
        }

        return $liste;
    }

    public function mf_lister_2(array $liste_Code_message, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        if ( count($liste_Code_message)>0 )
        {
            $cle = "message__mf_lister_2_".Sql_Format_Liste($liste_Code_message);

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

            // tris
            $argument_tris = '';
            if ( ! isset($options['tris']) )
            {
                $options['tris']=array();
            }
            if ( count($options['tris'])==0 )
            {
                global $mf_tri_defaut_table;
                if ( isset($mf_tri_defaut_table['message']) )
                {
                    $options['tris'] = $mf_tri_defaut_table['message'];
                }
            }
            foreach ($options['tris'] as $colonne => $tri)
            {
                if ( $colonne != 'message_Texte' )
                {
                    if ( $argument_tris=='' ) { $argument_tris = ' ORDER BY '; } else { $argument_tris .= ', '; }
                    if ( $tri!='DESC' ) $tri = 'ASC';
                    $argument_tris.=$colonne.' '.$tri;
                }
            }
            $cle.='_'.$argument_tris;

            // limit
            $argument_limit = '';
            if (isset($options['limit'][0]) && isset($options['limit'][1]))
            {
                $argument_limit = ' LIMIT '.$options['limit'][0].','.$options['limit'][1];
            }
            $cle.='_'.$argument_limit;

            // autocompletion
            $autocompletion = AUTOCOMPLETION_DEFAUT;
            if (isset($options['autocompletion']))
            {
                $autocompletion = ( $options['autocompletion']==true );
            }

            // controle_acces_donnees
            $controle_acces_donnees = CONTROLE_ACCES_DONNEES_DEFAUT;
            if (isset($options['controle_acces_donnees']))
            {
                $controle_acces_donnees = ( $options['controle_acces_donnees']==true );
            }

            // afficher toutes les colonnes
            $toutes_colonnes = TOUTES_COLONNES_DEFAUT;
            if (isset($options['toutes_colonnes']))
            {
                $toutes_colonnes = ( $options['toutes_colonnes']==true );
            }
            $cle.='_'.( $toutes_colonnes ? '1' : '0' );

            // maj
            $maj = true;
            if (isset($options['maj']))
            {
                $maj = ( $options['maj']==true );
            }
            $cle.='_'.( $maj ? '1' : '0' );

            $nouvelle_lecture = true;
            while ( $nouvelle_lecture )
            {
                $nouvelle_lecture = false;
                if ( ! $liste = self::$cache_db->read($cle) )
                {

                    // Indexes
                    $liste_colonnes_a_indexer = [];
                    if ( $argument_cond!='' )
                    {
                        if ( strpos($argument_cond, 'message_Date')!==false ) { $liste_colonnes_a_indexer['message_Date'] = 'message_Date'; }
                    }
                    if ( isset($options['tris']) )
                    {
                        if ( isset($options['tris']['message_Date']) ) { $liste_colonnes_a_indexer['message_Date'] = 'message_Date'; }
                    }
                    if ( count($liste_colonnes_a_indexer)>0 )
                    {
                        if ( ! $mf_liste_requete_index = self::$cache_db->read('message__index') )
                        {
                            $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('message').'`;', false);
                            $mf_liste_requete_index = array();
                            while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                            {
                                $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                            }
                            mysqli_free_result($res_requete_index);
                            self::$cache_db->write('message__index', $mf_liste_requete_index);
                        }
                        foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                        {
                            if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                        }
                        if ( count($liste_colonnes_a_indexer) > 0 )
                        {
                            self::$cache_db->pause('message__index');
                            foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                            {
                                executer_requete_mysql('ALTER TABLE `'.inst('message').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                            }
                            self::$cache_db->clear();
                            self::$cache_db->reprendre('message__index');
                        }
                    }

                    $liste = array();
                    $liste_message_pas_a_jour = array();
                    if ($toutes_colonnes)
                    {
                        $colonnes='Code_message, message_Texte, message_Date, Code_messagerie, Code_joueur';
                    }
                    else
                    {
                        $colonnes='Code_message, message_Date, Code_messagerie, Code_joueur';
                    }
                    $res_requete = executer_requete_mysql("SELECT $colonnes FROM ".inst('message')." WHERE 1{$argument_cond} AND Code_message IN ".Sql_Format_Liste($liste_Code_message)."{$argument_tris}{$argument_limit};", false);
                    while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
                    {
                        mf_formatage_db_type_php($row_requete);
                        $liste[$row_requete['Code_message']] = $row_requete;
                        if ( $maj && ! Hook_message::est_a_jour( $row_requete ) )
                        {
                            $liste_message_pas_a_jour[$row_requete['Code_message']] = $row_requete;
                            $nouvelle_lecture = true;
                        }
                    }
                    mysqli_free_result($res_requete);
                    if (count($options['tris'])==1 && ! $nouvelle_lecture)
                    {
                        foreach ($options['tris'] as $colonne => $tri)
                        {
                            global $lang_standard;
                            if (isset($lang_standard[$colonne.'_']))
                            {
                                effectuer_tri_suivant_langue($liste, $colonne, $tri);
                            }
                        }
                    }
                    if ( ! $nouvelle_lecture )
                    {
                        self::$cache_db->write($cle, $liste);
                    }
                }
                if ( $nouvelle_lecture )
                {
                    Hook_message::mettre_a_jour( $liste_message_pas_a_jour );
                }
            }

            foreach ($liste as $elem)
            {
                if ( $controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_message', $elem['Code_message']) )
                {
                    unset($liste[$elem['Code_message']]);
                }
                else
                {
                    if (!self::$auto_completion && $autocompletion)
                    {
                        self::$auto_completion = true;
                        Hook_message::completion($liste[$elem['Code_message']]);
                        self::$auto_completion = false;
                    }
                }
            }

            return $liste;
        }
        else
        {
            return array();
        }
    }

    public function mf_get(int $Code_message, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $Code_message = round($Code_message);
        $retour = array();
        if ( ! CONTROLE_ACCES_DONNEES_DEFAUT || Hook_mf_systeme::controle_acces_donnees('Code_message', $Code_message) )
        {
            $cle = 'message__get_'.$Code_message;

            // autocompletion
            $autocompletion = AUTOCOMPLETION_DEFAUT;
            if (isset($options['autocompletion']))
            {
                $autocompletion = ( $options['autocompletion']==true );
            }

            // afficher toutes les colonnes
            $toutes_colonnes = true;
            if (isset($options['toutes_colonnes']))
            {
                $toutes_colonnes = ( $options['toutes_colonnes']==true );
            }
            $cle.='_'.( $toutes_colonnes ? '1' : '0' );

            // maj
            $maj = true;
            if (isset($options['maj']))
            {
                $maj = ( $options['maj']==true );
            }
            $cle.='_'.( $maj ? '1' : '0' );

            $nouvelle_lecture = true;
            while ( $nouvelle_lecture )
            {
                $nouvelle_lecture = false;
                if ( ! $retour = self::$cache_db->read($cle) )
                {
                    if ($toutes_colonnes)
                    {
                        $colonnes='Code_message, message_Texte, message_Date, Code_messagerie, Code_joueur';
                    }
                    else
                    {
                        $colonnes='Code_message, message_Date, Code_messagerie, Code_joueur';
                    }
                    $res_requete = executer_requete_mysql('SELECT ' . $colonnes . ' FROM ' . inst('message') . ' WHERE Code_message = ' . $Code_message . ';', false);
                    if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
                    {
                        mf_formatage_db_type_php($row_requete);
                        $retour = $row_requete;
                        if ( $maj && ! Hook_message::est_a_jour( $row_requete ) )
                        {
                            $nouvelle_lecture = true;
                        }
                    }
                    mysqli_free_result($res_requete);
                    if ( ! $nouvelle_lecture )
                    {
                        self::$cache_db->write($cle, $retour);
                    }
                }
                if ( $nouvelle_lecture )
                {
                    Hook_message::mettre_a_jour( array( $row_requete['Code_message'] => $row_requete ) );
                }
            }
            if ( isset( $retour['Code_message'] ) )
            {
                if (!self::$auto_completion && $autocompletion)
                {
                    self::$auto_completion = true;
                    Hook_message::completion($retour);
                    self::$auto_completion = false;
                }
            }
        }
        return $retour;
    }

    public function mf_get_last(?int $Code_messagerie=null, ?int $Code_joueur=null, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cle = "message__get_last";
        $Code_messagerie = round($Code_messagerie);
        $cle.='_' . $Code_messagerie;
        $Code_joueur = round($Code_joueur);
        $cle.='_' . $Code_joueur;
        if ( ! $retour = self::$cache_db->read($cle) )
        {
            $Code_message = 0;
            $res_requete = executer_requete_mysql('SELECT Code_message FROM ' . inst('message') . " WHERE 1".( $Code_messagerie!=0 ? " AND Code_messagerie=$Code_messagerie" : "" )."".( $Code_joueur!=0 ? " AND Code_joueur=$Code_joueur" : "" )." ORDER BY mf_date_creation DESC, Code_message DESC LIMIT 0 , 1;", false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $Code_message = $row_requete['Code_message'];
            }
            mysqli_free_result($res_requete);
            $retour = $this->mf_get($Code_message, $options);
            self::$cache_db->write($cle, $retour);
        }
        return $retour;
    }

    public function mf_get_2(int $Code_message, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $Code_message = round($Code_message);
        $retour = array();
        $cle = 'message__get_'.$Code_message;

        // autocompletion
        $autocompletion = AUTOCOMPLETION_DEFAUT;
        if (isset($options['autocompletion']))
        {
            $autocompletion = ( $options['autocompletion']==true );
        }

        // afficher toutes les colonnes
        $toutes_colonnes = true;
        if (isset($options['toutes_colonnes']))
        {
            $toutes_colonnes = ( $options['toutes_colonnes']==true );
        }
        $cle.='_'.( $toutes_colonnes ? '1' : '0' );

        // maj
        $maj = true;
        if (isset($options['maj']))
        {
            $maj = ( $options['maj']==true );
        }
        $cle.='_'.( $maj ? '1' : '0' );

        if ( ! $retour = self::$cache_db->read($cle) )
        {
            if ($toutes_colonnes)
            {
                $colonnes='Code_message, message_Texte, message_Date, Code_messagerie, Code_joueur';
            }
            else
            {
                $colonnes='Code_message, message_Date, Code_messagerie, Code_joueur';
            }
            $res_requete = executer_requete_mysql('SELECT ' . $colonnes . " FROM ".inst('message')." WHERE Code_message = $Code_message;", false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                mf_formatage_db_type_php($row_requete);
                $retour = $row_requete;
            }
            mysqli_free_result($res_requete);
            self::$cache_db->write($cle, $retour);
        }
        if ( isset( $retour['Code_message'] ) )
        {
            if (!self::$auto_completion && $autocompletion)
            {
                self::$auto_completion = true;
                Hook_message::completion($retour);
                self::$auto_completion = false;
            }
        }
        return $retour;
    }

    public function mf_prec_et_suiv( int $Code_message, ?int $Code_messagerie=null, ?int $Code_joueur=null, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $Code_message = round($Code_message);
        $liste = $this->mf_lister($Code_messagerie, $Code_joueur, $options);
        return prec_suiv($liste, $Code_message);
    }

    public function mf_compter(?int $Code_messagerie=null, ?int $Code_joueur=null, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cle = 'message__compter';
        $Code_messagerie = round($Code_messagerie);
        $cle.='_{'.$Code_messagerie.'}';
        $Code_joueur = round($Code_joueur);
        $cle.='_{'.$Code_joueur.'}';

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

        if ( ! $nb = self::$cache_db->read($cle) )
        {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ( $argument_cond!='' )
            {
                if ( strpos($argument_cond, 'message_Date')!==false ) { $liste_colonnes_a_indexer['message_Date'] = 'message_Date'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = self::$cache_db->read('message__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('message').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    self::$cache_db->write('message__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    self::$cache_db->pause('message__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('message').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    self::$cache_db->clear();
                    self::$cache_db->reprendre('message__index');
                }
            }

            $res_requete = executer_requete_mysql('SELECT count(Code_message) as nb FROM ' . inst('message')." WHERE 1{$argument_cond}".( $Code_messagerie!=0 ? " AND Code_messagerie=$Code_messagerie" : "" )."".( $Code_joueur!=0 ? " AND Code_joueur=$Code_joueur" : "" ).";", false);
            $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC);
            mysqli_free_result($res_requete);
            $nb = (int) $row_requete['nb'];
            self::$cache_db->write($cle, $nb);
        }
        return $nb;
    }

    public function mfi_compter( array $interface, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ( $options===null ) { $options=[]; }
        $Code_messagerie = isset($interface['Code_messagerie']) ? round($interface['Code_messagerie']) : 0;
        $Code_joueur = isset($interface['Code_joueur']) ? round($interface['Code_joueur']) : 0;
        return $this->mf_compter( $Code_messagerie, $Code_joueur, $options );
    }

    public function mf_liste_Code_message(?int $Code_messagerie=null, ?int $Code_joueur=null, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ( $options===null ) { $options=[]; }
        return $this->get_liste_Code_message($Code_messagerie, $Code_joueur, $options);
    }

    public function mf_convertir_Code_message_vers_Code_messagerie( int $Code_message )
    {
        return $this->Code_message_vers_Code_messagerie( $Code_message );
    }

    public function mf_convertir_Code_message_vers_Code_joueur( int $Code_message )
    {
        return $this->Code_message_vers_Code_joueur( $Code_message );
    }

    public function mf_liste_Code_messagerie_vers_liste_Code_message( array $liste_Code_messagerie, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ( $options===null ) { $options=[]; }
        return $this->liste_Code_messagerie_vers_liste_Code_message( $liste_Code_messagerie, $options );
    }

    public function mf_liste_Code_message_vers_liste_Code_messagerie( array $liste_Code_message, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ( $options===null ) { $options=[]; }
        return $this->message__liste_Code_message_vers_liste_Code_messagerie( $liste_Code_message, $options );
    }

    public function mf_liste_Code_joueur_vers_liste_Code_message( array $liste_Code_joueur, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ( $options===null ) { $options=[]; }
        return $this->liste_Code_joueur_vers_liste_Code_message( $liste_Code_joueur, $options );
    }

    public function mf_liste_Code_message_vers_liste_Code_joueur( array $liste_Code_message, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ( $options===null ) { $options=[]; }
        return $this->message__liste_Code_message_vers_liste_Code_joueur( $liste_Code_message, $options );
    }

    public function mf_get_liste_tables_enfants()
    {
        return $this->get_liste_tables_enfants( 'message' );
    }

    public function mf_get_liste_tables_parents()
    {
        return array('Code_messagerie','Code_joueur');
    }

    public function mf_search_message_Date( string $message_Date, ?int $Code_messagerie=null, ?int $Code_joueur=null )
    {
        return $this->rechercher_message_Date( $message_Date, $Code_messagerie, $Code_joueur );
    }

    public function mf_search__colonne( string $colonne_db, $recherche, ?int $Code_messagerie=null, ?int $Code_joueur=null )
    {
        switch ($colonne_db) {
            case 'message_Date': return $this->mf_search_message_Date( $recherche, $Code_messagerie, $Code_joueur ); break;
        }
    }

    public function mf_get_next_id()
    {
        $res_requete = executer_requete_mysql('SELECT AUTO_INCREMENT as next_id FROM INFORMATION_SCHEMA.TABLES WHERE table_name = \'message\';', false);
        $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC);
        mysqli_free_result($res_requete);
        return round($row_requete['next_id']);
    }

    public function mf_search(array $ligne) // array('colonne1' => 'valeur1',  [...] )
    {
        global $mf_initialisation;
        $Code_messagerie = (int)(isset($ligne['Code_messagerie'])?round($ligne['Code_messagerie']):0);
        $Code_joueur = (int)(isset($ligne['Code_joueur'])?round($ligne['Code_joueur']):get_joueur_courant('Code_joueur'));
        $message_Texte = (string)(isset($ligne['message_Texte'])?$ligne['message_Texte']:$mf_initialisation['message_Texte']);
        $message_Date = (string)(isset($ligne['message_Date'])?$ligne['message_Date']:$mf_initialisation['message_Date']);
        $message_Date = format_datetime($message_Date);
        Hook_message::pre_controller($message_Texte, $message_Date, $Code_messagerie, $Code_joueur);
        $mf_cle_unique = Hook_message::calcul_cle_unique($message_Texte, $message_Date, $Code_messagerie, $Code_joueur);
        $res_requete = executer_requete_mysql('SELECT Code_message FROM ' . inst('message') . ' WHERE mf_cle_unique = \''.$mf_cle_unique.'\'', false);
        if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
        {
            $r = round($row_requete['Code_message']);
        }
        else
        {
            $r = false;
        }
        mysqli_free_result($res_requete);
        return $r;
    }

}
