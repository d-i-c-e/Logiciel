<?php

/*
    +------------------------------+
    |  NE PAS MODIFIER CE FICHIER  |
    +------------------------------+
*/

class joueur_monframework extends entite_monframework
{

    protected static $initialisation = true;
    private static $auto_completion = false;
    private static $actualisation_en_cours = false;
    protected static $cache_db;
    private static $maj_droits_ajouter_en_cours = false;
    private static $maj_droits_modifier_en_cours = false;
    private static $maj_droits_supprimer_en_cours = false;

    public function __construct()
    {
        if (self::$initialisation)
        {
            include_once __DIR__ . '/../../erreurs/erreurs__joueur.php';
            self::$initialisation = false;
            Hook_joueur::initialisation();
            self::$cache_db = new Mf_Cachedb('joueur');
        }
        if (!self::$actualisation_en_cours)
        {
            self::$actualisation_en_cours=true;
            Hook_joueur::actualisation();
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

        if ( ! test_si_table_existe(inst('joueur')) )
        {
            executer_requete_mysql('CREATE TABLE '.inst('joueur').'(Code_joueur INT AUTO_INCREMENT NOT NULL, PRIMARY KEY (Code_joueur)) ENGINE=MyISAM;', true);
        }

        $liste_colonnes = lister_les_colonnes(inst('joueur'));

        if ( isset($liste_colonnes['joueur_Email']) )
        {
            if ( typeMyql2Sql($liste_colonnes['joueur_Email']['Type'])!='VARCHAR' )
            {
                executer_requete_mysql('ALTER TABLE '.inst('joueur').' CHANGE joueur_Email joueur_Email VARCHAR(255);', true);
            }
            unset($liste_colonnes['joueur_Email']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('joueur').' ADD joueur_Email VARCHAR(255);', true);
            executer_requete_mysql('UPDATE '.inst('joueur').' SET joueur_Email=' . format_sql('joueur_Email', $mf_initialisation['joueur_Email']) . ';', true);
        }

        if ( isset($liste_colonnes['joueur_Identifiant']) )
        {
            if ( typeMyql2Sql($liste_colonnes['joueur_Identifiant']['Type'])!='VARCHAR' )
            {
                executer_requete_mysql('ALTER TABLE '.inst('joueur').' CHANGE joueur_Identifiant joueur_Identifiant VARCHAR(255);', true);
            }
            unset($liste_colonnes['joueur_Identifiant']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('joueur').' ADD joueur_Identifiant VARCHAR(255);', true);
            executer_requete_mysql('UPDATE '.inst('joueur').' SET joueur_Identifiant=' . format_sql('joueur_Identifiant', $mf_initialisation['joueur_Identifiant']) . ';', true);
        }

        if ( isset($liste_colonnes['joueur_Password']) )
        {
            if ( typeMyql2Sql($liste_colonnes['joueur_Password']['Type'])!='VARCHAR' )
            {
                executer_requete_mysql('ALTER TABLE '.inst('joueur').' CHANGE joueur_Password joueur_Password VARCHAR(255);', true);
            }
            unset($liste_colonnes['joueur_Password']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('joueur').' ADD joueur_Password VARCHAR(255);', true);
            executer_requete_mysql('UPDATE '.inst('joueur').' SET joueur_Password=' . format_sql('joueur_Password', $mf_initialisation['joueur_Password']) . ';', true);
        }

        if ( isset($liste_colonnes['joueur_Avatar_Fichier']) )
        {
            if ( typeMyql2Sql($liste_colonnes['joueur_Avatar_Fichier']['Type'])!='VARCHAR' )
            {
                executer_requete_mysql('ALTER TABLE '.inst('joueur').' CHANGE joueur_Avatar_Fichier joueur_Avatar_Fichier VARCHAR(255);', true);
            }
            unset($liste_colonnes['joueur_Avatar_Fichier']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('joueur').' ADD joueur_Avatar_Fichier VARCHAR(255);', true);
            executer_requete_mysql('UPDATE '.inst('joueur').' SET joueur_Avatar_Fichier=' . format_sql('joueur_Avatar_Fichier', $mf_initialisation['joueur_Avatar_Fichier']) . ';', true);
        }

        if ( isset($liste_colonnes['joueur_Date_naissance']) )
        {
            if ( typeMyql2Sql($liste_colonnes['joueur_Date_naissance']['Type'])!='DATE' )
            {
                executer_requete_mysql('ALTER TABLE '.inst('joueur').' CHANGE joueur_Date_naissance joueur_Date_naissance DATE;', true);
            }
            unset($liste_colonnes['joueur_Date_naissance']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('joueur').' ADD joueur_Date_naissance DATE;', true);
            executer_requete_mysql('UPDATE '.inst('joueur').' SET joueur_Date_naissance=' . format_sql('joueur_Date_naissance', $mf_initialisation['joueur_Date_naissance']) . ';', true);
        }

        if ( isset($liste_colonnes['joueur_Date_inscription']) )
        {
            if ( typeMyql2Sql($liste_colonnes['joueur_Date_inscription']['Type'])!='DATETIME' )
            {
                executer_requete_mysql('ALTER TABLE '.inst('joueur').' CHANGE joueur_Date_inscription joueur_Date_inscription DATETIME;', true);
            }
            unset($liste_colonnes['joueur_Date_inscription']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('joueur').' ADD joueur_Date_inscription DATETIME;', true);
            executer_requete_mysql('UPDATE '.inst('joueur').' SET joueur_Date_inscription=' . format_sql('joueur_Date_inscription', $mf_initialisation['joueur_Date_inscription']) . ';', true);
        }

        if ( isset($liste_colonnes['mf_signature']) )
        {
            unset($liste_colonnes['mf_signature']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('joueur').' ADD mf_signature VARCHAR(255);', true);
            executer_requete_mysql('ALTER TABLE '.inst('joueur').' ADD INDEX( mf_signature );', true);
        }

        if ( isset($liste_colonnes['mf_cle_unique']) )
        {
            unset($liste_colonnes['mf_cle_unique']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('joueur').' ADD mf_cle_unique VARCHAR(255);', true);
            executer_requete_mysql('ALTER TABLE '.inst('joueur').' ADD INDEX( mf_cle_unique );', true);
        }

        if ( isset($liste_colonnes['mf_date_creation']) )
        {
            unset($liste_colonnes['mf_date_creation']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('joueur').' ADD mf_date_creation DATETIME;', true);
            executer_requete_mysql('ALTER TABLE '.inst('joueur').' ADD INDEX( mf_date_creation );', true);
        }

        if ( isset($liste_colonnes['mf_date_modification']) )
        {
            unset($liste_colonnes['mf_date_modification']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('joueur').' ADD mf_date_modification DATETIME;', true);
            executer_requete_mysql('ALTER TABLE '.inst('joueur').' ADD INDEX( mf_date_modification );', true);
        }

        unset($liste_colonnes['Code_joueur']);

        foreach ($liste_colonnes as $field => $value)
        {
            executer_requete_mysql('ALTER TABLE '.inst('joueur').' DROP COLUMN '.$field.';', true);
        }

    }

    public function mf_ajouter(string $joueur_Email, string $joueur_Identifiant, string $joueur_Password, string $joueur_Avatar_Fichier, string $joueur_Date_naissance, string $joueur_Date_inscription, ?bool $force=false)
    {
        if ( $force===null ) { $force=false; }
        $Code_joueur = 0;
        $code_erreur = 0;
        $joueur_Date_naissance = format_date($joueur_Date_naissance);
        $joueur_Date_inscription = format_datetime($joueur_Date_inscription);
        Hook_joueur::pre_controller($joueur_Email, $joueur_Identifiant, $joueur_Password, $joueur_Avatar_Fichier, $joueur_Date_naissance, $joueur_Date_inscription);
        if (!$force)
        {
            if (!self::$maj_droits_ajouter_en_cours)
            {
                self::$maj_droits_ajouter_en_cours = true;
                Hook_joueur::hook_actualiser_les_droits_ajouter();
                self::$maj_droits_ajouter_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['joueur__AJOUTER']) ) $code_erreur = REFUS_JOUEUR__AJOUTER;
        elseif ( !Hook_joueur::autorisation_ajout($joueur_Email, $joueur_Identifiant, $joueur_Password, $joueur_Avatar_Fichier, $joueur_Date_naissance, $joueur_Date_inscription) ) $code_erreur = REFUS_JOUEUR__AJOUT_BLOQUEE;
        elseif ( ACTIVER_CONNEXION_EMAIL && $this->rechercher_joueur_Email($joueur_Email)!=0 ) $code_erreur = ERR_JOUEUR__AJOUTER__JOUEUR_EMAIL_DOUBLON;
        elseif ( $this->rechercher_joueur_Identifiant($joueur_Identifiant)!=0 ) $code_erreur = ERR_JOUEUR__AJOUTER__JOUEUR_IDENTIFIANT_DOUBLON;
        else
        {
            Hook_joueur::data_controller($joueur_Email, $joueur_Identifiant, $joueur_Password, $joueur_Avatar_Fichier, $joueur_Date_naissance, $joueur_Date_inscription);
            $mf_signature = text_sql(Hook_joueur::calcul_signature($joueur_Email, $joueur_Identifiant, $joueur_Password, $joueur_Avatar_Fichier, $joueur_Date_naissance, $joueur_Date_inscription));
            $mf_cle_unique = text_sql(Hook_joueur::calcul_cle_unique($joueur_Email, $joueur_Identifiant, $joueur_Password, $joueur_Avatar_Fichier, $joueur_Date_naissance, $joueur_Date_inscription));
            $joueur_Email = text_sql($joueur_Email);
            $joueur_Identifiant = text_sql($joueur_Identifiant);
            $salt = salt(100);
            $joueur_Password = md5($joueur_Password.$salt).':'.$salt;
            $joueur_Avatar_Fichier = text_sql($joueur_Avatar_Fichier);
            $joueur_Date_naissance = format_date($joueur_Date_naissance);
            $joueur_Date_inscription = format_datetime($joueur_Date_inscription);
            $requete = "INSERT INTO ".inst('joueur')." ( mf_signature, mf_cle_unique, mf_date_creation, mf_date_modification, joueur_Email, joueur_Identifiant, joueur_Password, joueur_Avatar_Fichier, joueur_Date_naissance, joueur_Date_inscription ) VALUES ( '$mf_signature', '$mf_cle_unique', '".get_now()."', '".get_now()."', '$joueur_Email', '$joueur_Identifiant', '$joueur_Password', '$joueur_Avatar_Fichier', ".( $joueur_Date_naissance!='' ? "'$joueur_Date_naissance'" : 'NULL' ).", ".( $joueur_Date_inscription!='' ? "'$joueur_Date_inscription'" : 'NULL' )." );";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql($requete, true);
            $Code_joueur = requete_mysql_insert_id();
            if ($Code_joueur==0)
            {
                $code_erreur = ERR_JOUEUR__AJOUTER__AJOUT_REFUSE;
                self::$cache_db->reprendre($cle);
            }
            else
            {
                self::$cache_db->clear();
                self::$cache_db->reprendre($cle);
                Hook_joueur::ajouter( $Code_joueur );
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
        return array('code_erreur' => $code_erreur, 'Code_joueur' => $Code_joueur, 'callback' => ( $code_erreur==0 ? Hook_joueur::callback_post($Code_joueur) : null ));
    }

    public function mf_ajouter_2(array $ligne, bool $force=null) // array('colonne1' => 'valeur1',  [...] )
    {
        if ( $force===null ) { $force=false; }
        global $mf_initialisation;
        $joueur_Email = (string)(isset($ligne['joueur_Email'])?$ligne['joueur_Email']:$mf_initialisation['joueur_Email']);
        $joueur_Identifiant = (string)(isset($ligne['joueur_Identifiant'])?$ligne['joueur_Identifiant']:$mf_initialisation['joueur_Identifiant']);
        $joueur_Password = (string)(isset($ligne['joueur_Password'])?$ligne['joueur_Password']:$mf_initialisation['joueur_Password']);
        $joueur_Avatar_Fichier = (string)(isset($ligne['joueur_Avatar_Fichier'])?$ligne['joueur_Avatar_Fichier']:$mf_initialisation['joueur_Avatar_Fichier']);
        $joueur_Date_naissance = (string)(isset($ligne['joueur_Date_naissance'])?$ligne['joueur_Date_naissance']:$mf_initialisation['joueur_Date_naissance']);
        $joueur_Date_inscription = (string)(isset($ligne['joueur_Date_inscription'])?$ligne['joueur_Date_inscription']:$mf_initialisation['joueur_Date_inscription']);
        return $this->mf_ajouter($joueur_Email, $joueur_Identifiant, $joueur_Password, $joueur_Avatar_Fichier, $joueur_Date_naissance, $joueur_Date_inscription, $force);
    }

    public function mf_ajouter_3(array $lignes) // array( array( 'colonne1' => 'valeur1', 'colonne2' => 'valeur2',  [...] ), [...] )
    {
        global $mf_initialisation;
        $code_erreur = 0;
        $values = '';
        foreach ($lignes as $ligne)
        {
            $joueur_Email = text_sql(isset($ligne['joueur_Email'])?$ligne['joueur_Email']:$mf_initialisation['joueur_Email']);
            $joueur_Identifiant = text_sql(isset($ligne['joueur_Identifiant'])?$ligne['joueur_Identifiant']:$mf_initialisation['joueur_Identifiant']);
            $salt = salt(100);
            $joueur_Password = md5(isset($ligne['joueur_Password'])?$ligne['joueur_Password']:$mf_initialisation['joueur_Password'].$salt).':'.$salt;
            $joueur_Avatar_Fichier = text_sql(isset($ligne['joueur_Avatar_Fichier'])?$ligne['joueur_Avatar_Fichier']:$mf_initialisation['joueur_Avatar_Fichier']);
            $joueur_Date_naissance = format_date(isset($ligne['joueur_Date_naissance'])?$ligne['joueur_Date_naissance']:$mf_initialisation['joueur_Date_naissance']);
            $joueur_Date_inscription = format_datetime(isset($ligne['joueur_Date_inscription'])?$ligne['joueur_Date_inscription']:$mf_initialisation['joueur_Date_inscription']);
            $values.=($values!="" ? "," : "")."('$joueur_Email', '$joueur_Identifiant', '$joueur_Password', '$joueur_Avatar_Fichier', ".( $joueur_Date_naissance!='' ? "'$joueur_Date_naissance'" : 'NULL' ).", ".( $joueur_Date_inscription!='' ? "'$joueur_Date_inscription'" : 'NULL' ).")";
        }
        if ($values!='')
        {
            $requete = "INSERT INTO ".inst('joueur')." ( joueur_Email, joueur_Identifiant, joueur_Password, joueur_Avatar_Fichier, joueur_Date_naissance, joueur_Date_inscription ) VALUES $values;";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            $n = requete_mysqli_affected_rows();
            if ($n < count($lignes))
            {
                $code_erreur = ERR_JOUEUR__AJOUTER_3__ECHEC_AJOUT;
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

    public function mf_modifier( int $Code_joueur, string $joueur_Email, string $joueur_Identifiant, string $joueur_Password, string $joueur_Avatar_Fichier, string $joueur_Date_naissance, string $joueur_Date_inscription, ?bool $force=null)
    {
        if ( $force===null ) { $force=false; }
        $code_erreur = 0;
        $Code_joueur = round($Code_joueur);
        $joueur_Date_naissance = format_date($joueur_Date_naissance);
        $joueur_Date_inscription = format_datetime($joueur_Date_inscription);
        Hook_joueur::pre_controller($joueur_Email, $joueur_Identifiant, $joueur_Password, $joueur_Avatar_Fichier, $joueur_Date_naissance, $joueur_Date_inscription, $Code_joueur);
        if (!$force)
        {
            if (!self::$maj_droits_modifier_en_cours)
            {
                self::$maj_droits_modifier_en_cours = true;
                Hook_joueur::hook_actualiser_les_droits_modifier($Code_joueur);
                self::$maj_droits_modifier_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['joueur__MODIFIER']) ) $code_erreur = REFUS_JOUEUR__MODIFIER;
        elseif ( !$this->mf_tester_existance_Code_joueur($Code_joueur) ) $code_erreur = ERR_JOUEUR__MODIFIER__CODE_JOUEUR_INEXISTANT;
        elseif ( CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_joueur', $Code_joueur) ) $code_erreur = ACCES_CODE_JOUEUR_REFUSE;
        elseif ( !Hook_joueur::autorisation_modification($Code_joueur, $joueur_Email, $joueur_Identifiant, $joueur_Password, $joueur_Avatar_Fichier, $joueur_Date_naissance, $joueur_Date_inscription) ) $code_erreur = REFUS_JOUEUR__MODIFICATION_BLOQUEE;
        elseif ( $this->rechercher_joueur_Identifiant($joueur_Identifiant)!=0 && $this->rechercher_joueur_Identifiant($joueur_Identifiant)!=$Code_joueur ) $code_erreur = ERR_JOUEUR__AJOUTER__JOUEUR_IDENTIFIANT_DOUBLON;
        else
        {
            Hook_joueur::data_controller($joueur_Email, $joueur_Identifiant, $joueur_Password, $joueur_Avatar_Fichier, $joueur_Date_naissance, $joueur_Date_inscription, $Code_joueur);
            $joueur = $this->mf_get_2( $Code_joueur, array('autocompletion' => false, 'masquer_mdp' => false) );
            $mf_colonnes_a_modifier=[];
            $bool__joueur_Email = false; if ( $joueur_Email!=$joueur['joueur_Email'] ) { Hook_joueur::data_controller__joueur_Email($joueur['joueur_Email'], $joueur_Email, $Code_joueur); if ( $joueur_Email!=$joueur['joueur_Email'] ) { $mf_colonnes_a_modifier[] = 'joueur_Email=' . format_sql('joueur_Email', $joueur_Email); $bool__joueur_Email = true; } }
            $bool__joueur_Identifiant = false; if ( $joueur_Identifiant!=$joueur['joueur_Identifiant'] ) { Hook_joueur::data_controller__joueur_Identifiant($joueur['joueur_Identifiant'], $joueur_Identifiant, $Code_joueur); if ( $joueur_Identifiant!=$joueur['joueur_Identifiant'] ) { $mf_colonnes_a_modifier[] = 'joueur_Identifiant=' . format_sql('joueur_Identifiant', $joueur_Identifiant); $bool__joueur_Identifiant = true; } }
            $bool__joueur_Password = false; if ( $joueur_Password!='' ) { $mf_colonnes_a_modifier[] = 'joueur_Password = ' . format_sql('joueur_Password', $joueur_Password); $bool__joueur_Password = true; }
            $bool__joueur_Avatar_Fichier = false; if ( $joueur_Avatar_Fichier!=$joueur['joueur_Avatar_Fichier'] ) { Hook_joueur::data_controller__joueur_Avatar_Fichier($joueur['joueur_Avatar_Fichier'], $joueur_Avatar_Fichier, $Code_joueur); if ( $joueur_Avatar_Fichier!=$joueur['joueur_Avatar_Fichier'] ) { $mf_colonnes_a_modifier[] = 'joueur_Avatar_Fichier=' . format_sql('joueur_Avatar_Fichier', $joueur_Avatar_Fichier); $bool__joueur_Avatar_Fichier = true; } }
            $bool__joueur_Date_naissance = false; if ( $joueur_Date_naissance!=$joueur['joueur_Date_naissance'] ) { Hook_joueur::data_controller__joueur_Date_naissance($joueur['joueur_Date_naissance'], $joueur_Date_naissance, $Code_joueur); if ( $joueur_Date_naissance!=$joueur['joueur_Date_naissance'] ) { $mf_colonnes_a_modifier[] = 'joueur_Date_naissance=' . format_sql('joueur_Date_naissance', $joueur_Date_naissance); $bool__joueur_Date_naissance = true; } }
            $bool__joueur_Date_inscription = false; if ( $joueur_Date_inscription!=$joueur['joueur_Date_inscription'] ) { Hook_joueur::data_controller__joueur_Date_inscription($joueur['joueur_Date_inscription'], $joueur_Date_inscription, $Code_joueur); if ( $joueur_Date_inscription!=$joueur['joueur_Date_inscription'] ) { $mf_colonnes_a_modifier[] = 'joueur_Date_inscription=' . format_sql('joueur_Date_inscription', $joueur_Date_inscription); $bool__joueur_Date_inscription = true; } }
            if (count($mf_colonnes_a_modifier)>0) {
                $mf_signature = text_sql(Hook_joueur::calcul_signature($joueur_Email, $joueur_Identifiant, $joueur_Password, $joueur_Avatar_Fichier, $joueur_Date_naissance, $joueur_Date_inscription));
                $mf_cle_unique = text_sql(Hook_joueur::calcul_cle_unique($joueur_Email, $joueur_Identifiant, $joueur_Password, $joueur_Avatar_Fichier, $joueur_Date_naissance, $joueur_Date_inscription));
                $mf_colonnes_a_modifier[] = 'mf_signature=\'' . $mf_signature . '\'';
                $mf_colonnes_a_modifier[] = 'mf_cle_unique=\'' . $mf_cle_unique . '\'';
                $mf_colonnes_a_modifier[] = 'mf_date_modification=\'' . get_now() . '\'';
                $requete = 'UPDATE '.inst('joueur').' SET ' . enumeration($mf_colonnes_a_modifier) . ' WHERE Code_joueur = ' . $Code_joueur . ';';
                $cle = md5($requete).salt(10);
                self::$cache_db->pause($cle);
                executer_requete_mysql( $requete , true);
                if ( requete_mysqli_affected_rows()==0 )
                {
                    $code_erreur = ERR_JOUEUR__MODIFIER__AUCUN_CHANGEMENT;
                    self::$cache_db->reprendre($cle);
                }
                else
                {
                    self::$cache_db->clear();
                    self::$cache_db->reprendre($cle);
                    Hook_joueur::modifier($Code_joueur, $bool__joueur_Email, $bool__joueur_Identifiant, $bool__joueur_Password, $bool__joueur_Avatar_Fichier, $bool__joueur_Date_naissance, $bool__joueur_Date_inscription);
                }
            }
            else
            {
                $code_erreur = ERR_JOUEUR__MODIFIER__AUCUN_CHANGEMENT;
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
        return array('code_erreur' => $code_erreur, 'callback' => ( $code_erreur == 0 ? Hook_joueur::callback_put($Code_joueur) : null ));
    }

    public function mf_modifier_2(array $lignes, ?bool $force=null) // array( $Code_joueur => array('colonne1' => 'valeur1',  [...] ) )
    {
        if ( $force===null ) { $force=false; }
        $code_erreur = 0;
        foreach ( $lignes as $Code_joueur => $colonnes )
        {
            if ( $code_erreur==0 )
            {
                $Code_joueur = (int)round($Code_joueur);
                $joueur = $this->mf_get_2($Code_joueur, array('autocompletion' => false));
                if (!$force)
                {
                    if (!self::$maj_droits_modifier_en_cours)
                    {
                        self::$maj_droits_modifier_en_cours = true;
                        Hook_joueur::hook_actualiser_les_droits_modifier($Code_joueur);
                        self::$maj_droits_modifier_en_cours = false;
                    }
                }
                $joueur_Email = (string)( isset($colonnes['joueur_Email']) && ( $force || mf_matrice_droits(['api_modifier__joueur_Email', 'joueur__MODIFIER']) ) ? $colonnes['joueur_Email'] : ( isset($joueur['joueur_Email']) ? $joueur['joueur_Email'] : '' ) );
                $joueur_Identifiant = (string)( isset($colonnes['joueur_Identifiant']) && ( $force || mf_matrice_droits(['api_modifier__joueur_Identifiant', 'joueur__MODIFIER']) ) ? $colonnes['joueur_Identifiant'] : ( isset($joueur['joueur_Identifiant']) ? $joueur['joueur_Identifiant'] : '' ) );
                $joueur_Password = (string)( isset($colonnes['joueur_Password']) && ( $force || mf_matrice_droits(['api_modifier__joueur_Password', 'joueur__MODIFIER']) ) ? $colonnes['joueur_Password'] : '' );
                $joueur_Avatar_Fichier = (string)( isset($colonnes['joueur_Avatar_Fichier']) && ( $force || mf_matrice_droits(['api_modifier__joueur_Avatar_Fichier', 'joueur__MODIFIER']) ) ? $colonnes['joueur_Avatar_Fichier'] : ( isset($joueur['joueur_Avatar_Fichier']) ? $joueur['joueur_Avatar_Fichier'] : '' ) );
                $joueur_Date_naissance = (string)( isset($colonnes['joueur_Date_naissance']) && ( $force || mf_matrice_droits(['api_modifier__joueur_Date_naissance', 'joueur__MODIFIER']) ) ? $colonnes['joueur_Date_naissance'] : ( isset($joueur['joueur_Date_naissance']) ? $joueur['joueur_Date_naissance'] : '' ) );
                $joueur_Date_inscription = (string)( isset($colonnes['joueur_Date_inscription']) && ( $force || mf_matrice_droits(['api_modifier__joueur_Date_inscription', 'joueur__MODIFIER']) ) ? $colonnes['joueur_Date_inscription'] : ( isset($joueur['joueur_Date_inscription']) ? $joueur['joueur_Date_inscription'] : '' ) );
                $retour = $this->mf_modifier($Code_joueur, $joueur_Email, $joueur_Identifiant, $joueur_Password, $joueur_Avatar_Fichier, $joueur_Date_naissance, $joueur_Date_inscription, true);
                if ( $retour['code_erreur']!=0 && $retour['code_erreur'] != ERR_JOUEUR__MODIFIER__AUCUN_CHANGEMENT )
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

    public function mf_modifier_3(array $lignes) // array( $Code_joueur => array('colonne1' => 'valeur1',  [...] ) )
    {
        $code_erreur = 0;
        $modifs = false;

        // transformation des lignes en colonnes
        $valeurs_en_colonnes=array();
        $indices_par_colonne=array();
        $liste_valeurs_indexees=array();
        foreach ( $lignes as $Code_joueur => $colonnes )
        {
            foreach ($colonnes as $colonne => $valeur)
            {
                if ( $colonne=='joueur_Email' || $colonne=='joueur_Identifiant' || $colonne=='joueur_Password' || $colonne=='joueur_Avatar_Fichier' || $colonne=='joueur_Date_naissance' || $colonne=='joueur_Date_inscription' )
                {
                    $valeurs_en_colonnes[$colonne][$Code_joueur]=$valeur;
                    $indices_par_colonne[$colonne][]=$Code_joueur;
                    $liste_valeurs_indexees[$colonne][''.$valeur][]=$Code_joueur;
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
                $modification_sql = $colonne . ' = CASE Code_joueur';
                foreach ( $valeurs as $Code_joueur => $valeur )
                {
                    $modification_sql.=' WHEN ' . $Code_joueur . ' THEN ' . format_sql($colonne, $valeur);
                }
                $modification_sql.=' END';
                $perimetre = Sql_Format_Liste($indices_par_colonne[$colonne]);
                executer_requete_mysql('UPDATE ' . inst('joueur') . ' SET ' . $modification_sql . ' WHERE Code_joueur IN ' . $perimetre . ';', true);
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
                    executer_requete_mysql('UPDATE ' . inst('joueur') . ' SET ' . $colonne . ' = ' . format_sql($colonne, $valeur) . ' WHERE Code_joueur IN ' . $perimetre . ';', true);
                    if ( requete_mysqli_affected_rows()!=0 )
                    {
                        $modifs = true;
                    }
                }
            }
        }

        if ( ! $modifs && $code_erreur==0 )
        {
            $code_erreur = ERR_JOUEUR__MODIFIER_3__AUCUN_CHANGEMENT;
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

    public function mf_modifier_4( array $data, ?array $options = null /* $options = array( 'cond_mysql' => array(), 'limit' => 0 ) */ ) // $data = array('colonne1' => 'valeur1', ... )
    {
        if ( $options===null ) { $force=[]; }
        $code_erreur = 0;
        $mf_colonnes_a_modifier=[];
        if ( isset($data['joueur_Email']) ) { $mf_colonnes_a_modifier[] = 'joueur_Email = ' . format_sql('joueur_Email', $data['joueur_Email']); }
        if ( isset($data['joueur_Identifiant']) ) { $mf_colonnes_a_modifier[] = 'joueur_Identifiant = ' . format_sql('joueur_Identifiant', $data['joueur_Identifiant']); }
        if ( isset($data['joueur_Password']) ) { $mf_colonnes_a_modifier[] = 'joueur_Password = ' . format_sql('joueur_Password', $data['joueur_Password']); }
        if ( isset($data['joueur_Avatar_Fichier']) ) { $mf_colonnes_a_modifier[] = 'joueur_Avatar_Fichier = ' . format_sql('joueur_Avatar_Fichier', $data['joueur_Avatar_Fichier']); }
        if ( isset($data['joueur_Date_naissance']) ) { $mf_colonnes_a_modifier[] = 'joueur_Date_naissance = ' . format_sql('joueur_Date_naissance', $data['joueur_Date_naissance']); }
        if ( isset($data['joueur_Date_inscription']) ) { $mf_colonnes_a_modifier[] = 'joueur_Date_inscription = ' . format_sql('joueur_Date_inscription', $data['joueur_Date_inscription']); }
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

            $requete = 'UPDATE ' . inst('joueur') . ' SET ' . enumeration($mf_colonnes_a_modifier) . " WHERE 1$argument_cond" . ( $limit>0 ? ' LIMIT ' . $limit : '' ) . ";";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_JOUEUR__MODIFIER_4__AUCUN_CHANGEMENT;
            }
            else
            {
                self::$cache_db->clear();
            }
            self::$cache_db->reprendre($cle);
        }
        return array('code_erreur' => $code_erreur);
    }

    public function mf_supprimer( int $Code_joueur, ?bool $force=null )
    {
        if ( $force===null ) { $force=false; }
        $code_erreur = 0;
        $Code_joueur = round($Code_joueur);
        if (!$force)
        {
            if (!self::$maj_droits_supprimer_en_cours)
            {
                self::$maj_droits_supprimer_en_cours = true;
                Hook_joueur::hook_actualiser_les_droits_supprimer($Code_joueur);
                self::$maj_droits_supprimer_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['joueur__SUPPRIMER']) ) $code_erreur = REFUS_JOUEUR__SUPPRIMER;
        elseif ( !$this->mf_tester_existance_Code_joueur($Code_joueur) ) $code_erreur = ERR_JOUEUR__SUPPRIMER_2__CODE_JOUEUR_INEXISTANT;
        elseif ( CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_joueur', $Code_joueur) ) $code_erreur = ACCES_CODE_JOUEUR_REFUSE;
        elseif ( !Hook_joueur::autorisation_suppression($Code_joueur) ) $code_erreur = REFUS_JOUEUR__SUPPRESSION_BLOQUEE;
        else
        {
            $copie__joueur = $this->mf_get($Code_joueur, array('autocompletion' => false));
            $this->supprimer_donnes_en_cascade("joueur", array($Code_joueur));
            $requete = "DELETE IGNORE FROM ".inst('joueur')." WHERE Code_joueur=$Code_joueur;";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_JOUEUR__SUPPRIMER__REFUSEE;
                self::$cache_db->reprendre($cle);
            }
            else
            {
                self::$cache_db->clear();
                self::$cache_db->reprendre($cle);
                Hook_joueur::supprimer($copie__joueur);
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

    public function mf_supprimer_2(array $liste_Code_joueur, ?bool $force=null)
    {
        if ( $force===null ) { $force=false; }
        $code_erreur=0;
        $copie__liste_joueur = $this->mf_lister_2($liste_Code_joueur, array('autocompletion' => false));
        $liste_Code_joueur=array();
        foreach ( $copie__liste_joueur as $copie__joueur )
        {
            $Code_joueur = $copie__joueur['Code_joueur'];
            if (!$force)
            {
                if (!self::$maj_droits_supprimer_en_cours)
                {
                    self::$maj_droits_supprimer_en_cours = true;
                    Hook_joueur::hook_actualiser_les_droits_supprimer($Code_joueur);
                    self::$maj_droits_supprimer_en_cours = false;
                }
            }
            if ( !$force && !mf_matrice_droits(['joueur__SUPPRIMER']) ) $code_erreur = REFUS_JOUEUR__SUPPRIMER;
            elseif ( !Hook_joueur::autorisation_suppression($Code_joueur) ) $code_erreur = REFUS_JOUEUR__SUPPRESSION_BLOQUEE;
            {
                $liste_Code_joueur[] = $Code_joueur;
            }
        }
        if ( $code_erreur==0 && count($liste_Code_joueur)>0 )
        {
            $this->supprimer_donnes_en_cascade("joueur", $liste_Code_joueur);
            $requete = "DELETE IGNORE FROM ".inst('joueur')." WHERE Code_joueur IN ".Sql_Format_Liste($liste_Code_joueur).";";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_JOUEUR__SUPPRIMER_2__REFUSEE;
                self::$cache_db->reprendre($cle);
            }
            else
            {
                self::$cache_db->clear();
                self::$cache_db->reprendre($cle);
                Hook_joueur::supprimer_2($copie__liste_joueur);
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

    public function mf_supprimer_3(array $liste_Code_joueur)
    {
        $code_erreur=0;
        if ( count($liste_Code_joueur)>0 )
        {
            $this->supprimer_donnes_en_cascade("joueur", $liste_Code_joueur);
            $requete = "DELETE IGNORE FROM ".inst('joueur')." WHERE Code_joueur IN ".Sql_Format_Liste($liste_Code_joueur).";";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_JOUEUR__SUPPRIMER_3__REFUSEE;
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
        if ( ! $contexte_parent && $mf_contexte['Code_joueur']!=0 )
        {
            $joueur = $this->mf_get( $mf_contexte['Code_joueur'], $options);
            return array( $joueur['Code_joueur'] => $joueur );
        }
        else
        {
            return $this->mf_lister($options);
        }
    }

    public function mf_lister(?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cle = "joueur__lister";

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
            if ( isset($mf_tri_defaut_table['joueur']) )
            {
                $options['tris'] = $mf_tri_defaut_table['joueur'];
            }
        }
        foreach ($options['tris'] as $colonne => $tri)
        {
            if ( $argument_tris=='' ) { $argument_tris = ' ORDER BY '; } else { $argument_tris .= ', '; }
            if ( $tri!='DESC' ) $tri = 'ASC';
            $argument_tris.=$colonne.' '.$tri;
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
                    if ( strpos($argument_cond, 'joueur_Email')!==false ) { $liste_colonnes_a_indexer['joueur_Email'] = 'joueur_Email'; }
                    if ( strpos($argument_cond, 'joueur_Identifiant')!==false ) { $liste_colonnes_a_indexer['joueur_Identifiant'] = 'joueur_Identifiant'; }
                    if ( strpos($argument_cond, 'joueur_Password')!==false ) { $liste_colonnes_a_indexer['joueur_Password'] = 'joueur_Password'; }
                    if ( strpos($argument_cond, 'joueur_Avatar_Fichier')!==false ) { $liste_colonnes_a_indexer['joueur_Avatar_Fichier'] = 'joueur_Avatar_Fichier'; }
                    if ( strpos($argument_cond, 'joueur_Date_naissance')!==false ) { $liste_colonnes_a_indexer['joueur_Date_naissance'] = 'joueur_Date_naissance'; }
                    if ( strpos($argument_cond, 'joueur_Date_inscription')!==false ) { $liste_colonnes_a_indexer['joueur_Date_inscription'] = 'joueur_Date_inscription'; }
                }
                if ( isset($options['tris']) )
                {
                    if ( isset($options['tris']['joueur_Email']) ) { $liste_colonnes_a_indexer['joueur_Email'] = 'joueur_Email'; }
                    if ( isset($options['tris']['joueur_Identifiant']) ) { $liste_colonnes_a_indexer['joueur_Identifiant'] = 'joueur_Identifiant'; }
                    if ( isset($options['tris']['joueur_Password']) ) { $liste_colonnes_a_indexer['joueur_Password'] = 'joueur_Password'; }
                    if ( isset($options['tris']['joueur_Avatar_Fichier']) ) { $liste_colonnes_a_indexer['joueur_Avatar_Fichier'] = 'joueur_Avatar_Fichier'; }
                    if ( isset($options['tris']['joueur_Date_naissance']) ) { $liste_colonnes_a_indexer['joueur_Date_naissance'] = 'joueur_Date_naissance'; }
                    if ( isset($options['tris']['joueur_Date_inscription']) ) { $liste_colonnes_a_indexer['joueur_Date_inscription'] = 'joueur_Date_inscription'; }
                }
                if ( count($liste_colonnes_a_indexer)>0 )
                {
                    if ( ! $mf_liste_requete_index = self::$cache_db->read('joueur__index') )
                    {
                        $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('joueur').'`;', false);
                        $mf_liste_requete_index = array();
                        while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                        {
                            $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                        }
                        mysqli_free_result($res_requete_index);
                        self::$cache_db->write('joueur__index', $mf_liste_requete_index);
                    }
                    foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                    {
                        if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                    }
                    if ( count($liste_colonnes_a_indexer) > 0 )
                    {
                        self::$cache_db->pause('joueur__index');
                        foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                        {
                            executer_requete_mysql('ALTER TABLE `'.inst('joueur').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                        }
                        self::$cache_db->clear();
                        self::$cache_db->reprendre('joueur__index');
                    }
                }

                $liste = array();
                $liste_joueur_pas_a_jour = array();
                if ($toutes_colonnes)
                {
                    $colonnes='Code_joueur, joueur_Email, joueur_Identifiant, joueur_Password, joueur_Avatar_Fichier, joueur_Date_naissance, joueur_Date_inscription';
                }
                else
                {
                    $colonnes='Code_joueur, joueur_Email, joueur_Identifiant, joueur_Password, joueur_Avatar_Fichier, joueur_Date_naissance, joueur_Date_inscription';
                }
                $res_requete = executer_requete_mysql("SELECT $colonnes FROM ".inst('joueur')." WHERE 1{$argument_cond}{$argument_tris}{$argument_limit};", false);
                while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
                {
                    unset($row_requete['joueur_Password']);
                    mf_formatage_db_type_php($row_requete);
                    $liste[$row_requete['Code_joueur']] = $row_requete;
                    if ( $maj && ! Hook_joueur::est_a_jour( $row_requete ) )
                    {
                        $liste_joueur_pas_a_jour[$row_requete['Code_joueur']] = $row_requete;
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
                Hook_joueur::mettre_a_jour( $liste_joueur_pas_a_jour );
            }
        }

        foreach ($liste as $elem)
        {
            if ( $controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_joueur', $elem['Code_joueur']) )
            {
                unset($liste[$elem['Code_joueur']]);
            }
            else
            {
                if (!self::$auto_completion && $autocompletion)
                {
                    self::$auto_completion = true;
                    Hook_joueur::completion($liste[$elem['Code_joueur']]);
                    self::$auto_completion = false;
                }
            }
        }

        return $liste;
    }

    public function mf_lister_2(array $liste_Code_joueur, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        if ( count($liste_Code_joueur)>0 )
        {
            $cle = "joueur__mf_lister_2_".Sql_Format_Liste($liste_Code_joueur);

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
                if ( isset($mf_tri_defaut_table['joueur']) )
                {
                    $options['tris'] = $mf_tri_defaut_table['joueur'];
                }
            }
            foreach ($options['tris'] as $colonne => $tri)
            {
                if ( $argument_tris=='' ) { $argument_tris = ' ORDER BY '; } else { $argument_tris .= ', '; }
                if ( $tri!='DESC' ) $tri = 'ASC';
                $argument_tris.=$colonne.' '.$tri;
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
                        if ( strpos($argument_cond, 'joueur_Email')!==false ) { $liste_colonnes_a_indexer['joueur_Email'] = 'joueur_Email'; }
                        if ( strpos($argument_cond, 'joueur_Identifiant')!==false ) { $liste_colonnes_a_indexer['joueur_Identifiant'] = 'joueur_Identifiant'; }
                        if ( strpos($argument_cond, 'joueur_Password')!==false ) { $liste_colonnes_a_indexer['joueur_Password'] = 'joueur_Password'; }
                        if ( strpos($argument_cond, 'joueur_Avatar_Fichier')!==false ) { $liste_colonnes_a_indexer['joueur_Avatar_Fichier'] = 'joueur_Avatar_Fichier'; }
                        if ( strpos($argument_cond, 'joueur_Date_naissance')!==false ) { $liste_colonnes_a_indexer['joueur_Date_naissance'] = 'joueur_Date_naissance'; }
                        if ( strpos($argument_cond, 'joueur_Date_inscription')!==false ) { $liste_colonnes_a_indexer['joueur_Date_inscription'] = 'joueur_Date_inscription'; }
                    }
                    if ( isset($options['tris']) )
                    {
                        if ( isset($options['tris']['joueur_Email']) ) { $liste_colonnes_a_indexer['joueur_Email'] = 'joueur_Email'; }
                        if ( isset($options['tris']['joueur_Identifiant']) ) { $liste_colonnes_a_indexer['joueur_Identifiant'] = 'joueur_Identifiant'; }
                        if ( isset($options['tris']['joueur_Password']) ) { $liste_colonnes_a_indexer['joueur_Password'] = 'joueur_Password'; }
                        if ( isset($options['tris']['joueur_Avatar_Fichier']) ) { $liste_colonnes_a_indexer['joueur_Avatar_Fichier'] = 'joueur_Avatar_Fichier'; }
                        if ( isset($options['tris']['joueur_Date_naissance']) ) { $liste_colonnes_a_indexer['joueur_Date_naissance'] = 'joueur_Date_naissance'; }
                        if ( isset($options['tris']['joueur_Date_inscription']) ) { $liste_colonnes_a_indexer['joueur_Date_inscription'] = 'joueur_Date_inscription'; }
                    }
                    if ( count($liste_colonnes_a_indexer)>0 )
                    {
                        if ( ! $mf_liste_requete_index = self::$cache_db->read('joueur__index') )
                        {
                            $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('joueur').'`;', false);
                            $mf_liste_requete_index = array();
                            while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                            {
                                $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                            }
                            mysqli_free_result($res_requete_index);
                            self::$cache_db->write('joueur__index', $mf_liste_requete_index);
                        }
                        foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                        {
                            if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                        }
                        if ( count($liste_colonnes_a_indexer) > 0 )
                        {
                            self::$cache_db->pause('joueur__index');
                            foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                            {
                                executer_requete_mysql('ALTER TABLE `'.inst('joueur').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                            }
                            self::$cache_db->clear();
                            self::$cache_db->reprendre('joueur__index');
                        }
                    }

                    $liste = array();
                    $liste_joueur_pas_a_jour = array();
                    if ($toutes_colonnes)
                    {
                        $colonnes='Code_joueur, joueur_Email, joueur_Identifiant, joueur_Password, joueur_Avatar_Fichier, joueur_Date_naissance, joueur_Date_inscription';
                    }
                    else
                    {
                        $colonnes='Code_joueur, joueur_Email, joueur_Identifiant, joueur_Password, joueur_Avatar_Fichier, joueur_Date_naissance, joueur_Date_inscription';
                    }
                    $res_requete = executer_requete_mysql("SELECT $colonnes FROM ".inst('joueur')." WHERE 1{$argument_cond} AND Code_joueur IN ".Sql_Format_Liste($liste_Code_joueur)."{$argument_tris}{$argument_limit};", false);
                    while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
                    {
                        unset($row_requete['joueur_Password']);
                        mf_formatage_db_type_php($row_requete);
                        $liste[$row_requete['Code_joueur']] = $row_requete;
                        if ( $maj && ! Hook_joueur::est_a_jour( $row_requete ) )
                        {
                            $liste_joueur_pas_a_jour[$row_requete['Code_joueur']] = $row_requete;
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
                    Hook_joueur::mettre_a_jour( $liste_joueur_pas_a_jour );
                }
            }

            foreach ($liste as $elem)
            {
                if ( $controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_joueur', $elem['Code_joueur']) )
                {
                    unset($liste[$elem['Code_joueur']]);
                }
                else
                {
                    if (!self::$auto_completion && $autocompletion)
                    {
                        self::$auto_completion = true;
                        Hook_joueur::completion($liste[$elem['Code_joueur']]);
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

    public function mf_get(int $Code_joueur, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $masquer_mdp = true;
        if ( isset($options['masquer_mdp']) )
        {
            $masquer_mdp = ( $options['masquer_mdp']==true );
        }
        $Code_joueur = round($Code_joueur);
        $retour = array();
        if ( ! CONTROLE_ACCES_DONNEES_DEFAUT || Hook_mf_systeme::controle_acces_donnees('Code_joueur', $Code_joueur) )
        {
            $cle = 'joueur__get_'.$Code_joueur.'_'.( $masquer_mdp ? 'masquer=1' : 'masquer=0' );

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
                        $colonnes='Code_joueur, joueur_Email, joueur_Identifiant, joueur_Password, joueur_Avatar_Fichier, joueur_Date_naissance, joueur_Date_inscription';
                    }
                    else
                    {
                        $colonnes='Code_joueur, joueur_Email, joueur_Identifiant, joueur_Password, joueur_Avatar_Fichier, joueur_Date_naissance, joueur_Date_inscription';
                    }
                    $res_requete = executer_requete_mysql('SELECT ' . $colonnes . ' FROM ' . inst('joueur') . ' WHERE Code_joueur = ' . $Code_joueur . ';', false);
                    if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
                    {
                        if ( $masquer_mdp )
                        {
                            unset($row_requete['joueur_Password']);
                        }
                        mf_formatage_db_type_php($row_requete);
                        $retour = $row_requete;
                        if ( $maj && ! Hook_joueur::est_a_jour( $row_requete ) )
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
                    Hook_joueur::mettre_a_jour( array( $row_requete['Code_joueur'] => $row_requete ) );
                }
            }
            if ( isset( $retour['Code_joueur'] ) )
            {
                if (!self::$auto_completion && $autocompletion)
                {
                    self::$auto_completion = true;
                    Hook_joueur::completion($retour);
                    self::$auto_completion = false;
                }
            }
        }
        return $retour;
    }

    public function mf_get_last(?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cle = "joueur__get_last";
        if ( ! $retour = self::$cache_db->read($cle) )
        {
            $Code_joueur = 0;
            $res_requete = executer_requete_mysql('SELECT Code_joueur FROM ' . inst('joueur') . " WHERE 1 ORDER BY mf_date_creation DESC, Code_joueur DESC LIMIT 0 , 1;", false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $Code_joueur = $row_requete['Code_joueur'];
            }
            mysqli_free_result($res_requete);
            $retour = $this->mf_get($Code_joueur, $options);
            self::$cache_db->write($cle, $retour);
        }
        return $retour;
    }

    protected function mf_get_connexion(int $Code_joueur, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $Code_joueur = round($Code_joueur);
        $retour = array();
        $cle = "joueur__get_connexion_{$Code_joueur}";

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
                $colonnes='Code_joueur, joueur_Email, joueur_Identifiant, joueur_Password, joueur_Avatar_Fichier, joueur_Date_naissance, joueur_Date_inscription';
            }
            else
            {
                $colonnes='Code_joueur, joueur_Email, joueur_Identifiant, joueur_Password, joueur_Avatar_Fichier, joueur_Date_naissance, joueur_Date_inscription';
            }
            $res_requete = executer_requete_mysql('SELECT ' . $colonnes . " FROM ".inst('joueur')." WHERE Code_joueur = $Code_joueur;", false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                mf_formatage_db_type_php($row_requete);
                $retour = $row_requete;
            }
            mysqli_free_result($res_requete);
            self::$cache_db->write($cle, $retour);
        }
        if ( isset( $retour['Code_joueur'] ) )
        {
            if (!self::$auto_completion && $autocompletion)
            {
                self::$auto_completion = true;
                Hook_joueur::completion($retour);
                self::$auto_completion = false;
            }
        }
        return $retour;
    }

    public function mf_get_2(int $Code_joueur, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $masquer_mdp = true;
        if ( isset($options['masquer_mdp']) )
        {
            $masquer_mdp = ( $options['masquer_mdp']==true );
        }
        $Code_joueur = round($Code_joueur);
        $retour = array();
        $cle = 'joueur__get_'.$Code_joueur.'_'.( $masquer_mdp ? 'masquer=1' : 'masquer=0' );

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
                $colonnes='Code_joueur, joueur_Email, joueur_Identifiant, joueur_Password, joueur_Avatar_Fichier, joueur_Date_naissance, joueur_Date_inscription';
            }
            else
            {
                $colonnes='Code_joueur, joueur_Email, joueur_Identifiant, joueur_Password, joueur_Avatar_Fichier, joueur_Date_naissance, joueur_Date_inscription';
            }
            $res_requete = executer_requete_mysql('SELECT ' . $colonnes . " FROM ".inst('joueur')." WHERE Code_joueur = $Code_joueur;", false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                if ( $masquer_mdp )
                {
                    unset($row_requete['joueur_Password']);
                }
                mf_formatage_db_type_php($row_requete);
                $retour = $row_requete;
            }
            mysqli_free_result($res_requete);
            self::$cache_db->write($cle, $retour);
        }
        if ( isset( $retour['Code_joueur'] ) )
        {
            if (!self::$auto_completion && $autocompletion)
            {
                self::$auto_completion = true;
                Hook_joueur::completion($retour);
                self::$auto_completion = false;
            }
        }
        return $retour;
    }

    public function mf_prec_et_suiv( int $Code_joueur, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $Code_joueur = round($Code_joueur);
        $liste = $this->mf_lister($options);
        return prec_suiv($liste, $Code_joueur);
    }

    public function mf_compter(?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cle = 'joueur__compter';

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
                if ( strpos($argument_cond, 'joueur_Email')!==false ) { $liste_colonnes_a_indexer['joueur_Email'] = 'joueur_Email'; }
                if ( strpos($argument_cond, 'joueur_Identifiant')!==false ) { $liste_colonnes_a_indexer['joueur_Identifiant'] = 'joueur_Identifiant'; }
                if ( strpos($argument_cond, 'joueur_Password')!==false ) { $liste_colonnes_a_indexer['joueur_Password'] = 'joueur_Password'; }
                if ( strpos($argument_cond, 'joueur_Avatar_Fichier')!==false ) { $liste_colonnes_a_indexer['joueur_Avatar_Fichier'] = 'joueur_Avatar_Fichier'; }
                if ( strpos($argument_cond, 'joueur_Date_naissance')!==false ) { $liste_colonnes_a_indexer['joueur_Date_naissance'] = 'joueur_Date_naissance'; }
                if ( strpos($argument_cond, 'joueur_Date_inscription')!==false ) { $liste_colonnes_a_indexer['joueur_Date_inscription'] = 'joueur_Date_inscription'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = self::$cache_db->read('joueur__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('joueur').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    self::$cache_db->write('joueur__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    self::$cache_db->pause('joueur__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('joueur').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    self::$cache_db->clear();
                    self::$cache_db->reprendre('joueur__index');
                }
            }

            $res_requete = executer_requete_mysql('SELECT count(Code_joueur) as nb FROM ' . inst('joueur')." WHERE 1{$argument_cond};", false);
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
        return $this->mf_compter( $options );
    }

    public function mf_liste_Code_joueur(?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ( $options===null ) { $options=[]; }
        return $this->get_liste_Code_joueur($options);
    }

    public function mf_get_liste_tables_enfants()
    {
        return $this->get_liste_tables_enfants( 'joueur' );
    }

    public function mf_get_liste_tables_parents()
    {
        return array();
    }

    public function mf_search_joueur_Email( string $joueur_Email )
    {
        return $this->rechercher_joueur_Email( $joueur_Email );
    }

    public function mf_search_joueur_Identifiant( string $joueur_Identifiant )
    {
        return $this->rechercher_joueur_Identifiant( $joueur_Identifiant );
    }

    public function mf_search_joueur_Password( string $joueur_Password )
    {
        return $this->rechercher_joueur_Password( $joueur_Password );
    }

    public function mf_search_joueur_Avatar_Fichier( string $joueur_Avatar_Fichier )
    {
        return $this->rechercher_joueur_Avatar_Fichier( $joueur_Avatar_Fichier );
    }

    public function mf_search_joueur_Date_naissance( string $joueur_Date_naissance )
    {
        return $this->rechercher_joueur_Date_naissance( $joueur_Date_naissance );
    }

    public function mf_search_joueur_Date_inscription( string $joueur_Date_inscription )
    {
        return $this->rechercher_joueur_Date_inscription( $joueur_Date_inscription );
    }

    public function mf_search__colonne( string $colonne_db, $recherche )
    {
        switch ($colonne_db) {
            case 'joueur_Email': return $this->mf_search_joueur_Email( $recherche ); break;
            case 'joueur_Identifiant': return $this->mf_search_joueur_Identifiant( $recherche ); break;
            case 'joueur_Password': return $this->mf_search_joueur_Password( $recherche ); break;
            case 'joueur_Avatar_Fichier': return $this->mf_search_joueur_Avatar_Fichier( $recherche ); break;
            case 'joueur_Date_naissance': return $this->mf_search_joueur_Date_naissance( $recherche ); break;
            case 'joueur_Date_inscription': return $this->mf_search_joueur_Date_inscription( $recherche ); break;
        }
    }

    public function mf_get_next_id()
    {
        $res_requete = executer_requete_mysql('SELECT AUTO_INCREMENT as next_id FROM INFORMATION_SCHEMA.TABLES WHERE table_name = \'joueur\';', false);
        $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC);
        mysqli_free_result($res_requete);
        return round($row_requete['next_id']);
    }

    public function mf_search(array $ligne) // array('colonne1' => 'valeur1',  [...] )
    {
        global $mf_initialisation;
        $joueur_Email = (string)(isset($ligne['joueur_Email'])?$ligne['joueur_Email']:$mf_initialisation['joueur_Email']);
        $joueur_Identifiant = (string)(isset($ligne['joueur_Identifiant'])?$ligne['joueur_Identifiant']:$mf_initialisation['joueur_Identifiant']);
        $joueur_Password = (string)(isset($ligne['joueur_Password'])?$ligne['joueur_Password']:$mf_initialisation['joueur_Password']);
        $joueur_Avatar_Fichier = (string)(isset($ligne['joueur_Avatar_Fichier'])?$ligne['joueur_Avatar_Fichier']:$mf_initialisation['joueur_Avatar_Fichier']);
        $joueur_Date_naissance = (string)(isset($ligne['joueur_Date_naissance'])?$ligne['joueur_Date_naissance']:$mf_initialisation['joueur_Date_naissance']);
        $joueur_Date_inscription = (string)(isset($ligne['joueur_Date_inscription'])?$ligne['joueur_Date_inscription']:$mf_initialisation['joueur_Date_inscription']);
        $joueur_Date_naissance = format_date($joueur_Date_naissance);
        $joueur_Date_inscription = format_datetime($joueur_Date_inscription);
        Hook_joueur::pre_controller($joueur_Email, $joueur_Identifiant, $joueur_Password, $joueur_Avatar_Fichier, $joueur_Date_naissance, $joueur_Date_inscription);
        $mf_cle_unique = Hook_joueur::calcul_cle_unique($joueur_Email, $joueur_Identifiant, $joueur_Password, $joueur_Avatar_Fichier, $joueur_Date_naissance, $joueur_Date_inscription);
        $res_requete = executer_requete_mysql('SELECT Code_joueur FROM ' . inst('joueur') . ' WHERE mf_cle_unique = \''.$mf_cle_unique.'\'', false);
        if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
        {
            $r = round($row_requete['Code_joueur']);
        }
        else
        {
            $r = false;
        }
        mysqli_free_result($res_requete);
        return $r;
    }

}
