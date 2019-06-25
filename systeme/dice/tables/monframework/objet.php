<?php

/*
    +------------------------------+
    |  NE PAS MODIFIER CE FICHIER  |
    +------------------------------+
*/

class objet_monframework extends entite_monframework
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
            include_once __DIR__ . '/../../erreurs/erreurs__objet.php';
            self::$initialisation = false;
            Hook_objet::initialisation();
            self::$cache_db = new Mf_Cachedb('objet');
        }
        if (!self::$actualisation_en_cours)
        {
            self::$actualisation_en_cours=true;
            Hook_objet::actualisation();
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

        if ( ! test_si_table_existe(inst('objet')) )
        {
            executer_requete_mysql('CREATE TABLE '.inst('objet').'(Code_objet INT AUTO_INCREMENT NOT NULL, PRIMARY KEY (Code_objet)) ENGINE=MyISAM;', true);
        }

        $liste_colonnes = lister_les_colonnes(inst('objet'));

        if ( isset($liste_colonnes['objet_Libelle']) )
        {
            if ( typeMyql2Sql($liste_colonnes['objet_Libelle']['Type'])!='VARCHAR' )
            {
                executer_requete_mysql('ALTER TABLE '.inst('objet').' CHANGE objet_Libelle objet_Libelle VARCHAR(255);', true);
            }
            unset($liste_colonnes['objet_Libelle']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('objet').' ADD objet_Libelle VARCHAR(255);', true);
            executer_requete_mysql('UPDATE '.inst('objet').' SET objet_Libelle=' . format_sql('objet_Libelle', $mf_initialisation['objet_Libelle']) . ';', true);
        }

        if ( isset($liste_colonnes['objet_Image_Fichier']) )
        {
            if ( typeMyql2Sql($liste_colonnes['objet_Image_Fichier']['Type'])!='VARCHAR' )
            {
                executer_requete_mysql('ALTER TABLE '.inst('objet').' CHANGE objet_Image_Fichier objet_Image_Fichier VARCHAR(255);', true);
            }
            unset($liste_colonnes['objet_Image_Fichier']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('objet').' ADD objet_Image_Fichier VARCHAR(255);', true);
            executer_requete_mysql('UPDATE '.inst('objet').' SET objet_Image_Fichier=' . format_sql('objet_Image_Fichier', $mf_initialisation['objet_Image_Fichier']) . ';', true);
        }

        if ( isset($liste_colonnes['Code_type']) )
        {
            unset($liste_colonnes['Code_type']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('objet').' ADD Code_type int NOT NULL;', true);
        }

        if ( isset($liste_colonnes['mf_signature']) )
        {
            unset($liste_colonnes['mf_signature']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('objet').' ADD mf_signature VARCHAR(255);', true);
            executer_requete_mysql('ALTER TABLE '.inst('objet').' ADD INDEX( mf_signature );', true);
        }

        if ( isset($liste_colonnes['mf_cle_unique']) )
        {
            unset($liste_colonnes['mf_cle_unique']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('objet').' ADD mf_cle_unique VARCHAR(255);', true);
            executer_requete_mysql('ALTER TABLE '.inst('objet').' ADD INDEX( mf_cle_unique );', true);
        }

        if ( isset($liste_colonnes['mf_date_creation']) )
        {
            unset($liste_colonnes['mf_date_creation']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('objet').' ADD mf_date_creation DATETIME;', true);
            executer_requete_mysql('ALTER TABLE '.inst('objet').' ADD INDEX( mf_date_creation );', true);
        }

        if ( isset($liste_colonnes['mf_date_modification']) )
        {
            unset($liste_colonnes['mf_date_modification']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('objet').' ADD mf_date_modification DATETIME;', true);
            executer_requete_mysql('ALTER TABLE '.inst('objet').' ADD INDEX( mf_date_modification );', true);
        }

        unset($liste_colonnes['Code_objet']);

        foreach ($liste_colonnes as $field => $value)
        {
            executer_requete_mysql('ALTER TABLE '.inst('objet').' DROP COLUMN '.$field.';', true);
        }

    }

    public function mf_ajouter(string $objet_Libelle, string $objet_Image_Fichier, int $Code_type, ?bool $force=false)
    {
        if ( $force===null ) { $force=false; }
        $Code_objet = 0;
        $code_erreur = 0;
        $Code_type = round($Code_type);
        Hook_objet::pre_controller($objet_Libelle, $objet_Image_Fichier, $Code_type);
        if (!$force)
        {
            if (!self::$maj_droits_ajouter_en_cours)
            {
                self::$maj_droits_ajouter_en_cours = true;
                Hook_objet::hook_actualiser_les_droits_ajouter($Code_type);
                self::$maj_droits_ajouter_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['objet__AJOUTER']) ) $code_erreur = REFUS_OBJET__AJOUTER;
        elseif ( !$this->mf_tester_existance_Code_type($Code_type) ) $code_erreur = ERR_OBJET__AJOUTER__CODE_TYPE_INEXISTANT;
        elseif ( CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_type', $Code_type) ) $code_erreur = ACCES_CODE_TYPE_REFUSE;
        elseif ( !Hook_objet::autorisation_ajout($objet_Libelle, $objet_Image_Fichier, $Code_type) ) $code_erreur = REFUS_OBJET__AJOUT_BLOQUEE;
        else
        {
            Hook_objet::data_controller($objet_Libelle, $objet_Image_Fichier, $Code_type);
            $mf_signature = text_sql(Hook_objet::calcul_signature($objet_Libelle, $objet_Image_Fichier, $Code_type));
            $mf_cle_unique = text_sql(Hook_objet::calcul_cle_unique($objet_Libelle, $objet_Image_Fichier, $Code_type));
            $objet_Libelle = text_sql($objet_Libelle);
            $objet_Image_Fichier = text_sql($objet_Image_Fichier);
            $requete = "INSERT INTO ".inst('objet')." ( mf_signature, mf_cle_unique, mf_date_creation, mf_date_modification, objet_Libelle, objet_Image_Fichier, Code_type ) VALUES ( '$mf_signature', '$mf_cle_unique', '".get_now()."', '".get_now()."', '$objet_Libelle', '$objet_Image_Fichier', $Code_type );";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql($requete, true);
            $Code_objet = requete_mysql_insert_id();
            if ($Code_objet==0)
            {
                $code_erreur = ERR_OBJET__AJOUTER__AJOUT_REFUSE;
                self::$cache_db->reprendre($cle);
            }
            else
            {
                self::$cache_db->clear();
                self::$cache_db->reprendre($cle);
                Hook_objet::ajouter( $Code_objet );
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
        return array('code_erreur' => $code_erreur, 'Code_objet' => $Code_objet, 'callback' => ( $code_erreur==0 ? Hook_objet::callback_post($Code_objet) : null ));
    }

    public function mf_creer(int $Code_type, ?bool $force=null)
    {
        if ( $force===null ) { $force=false; }
        global $mf_initialisation, $mf_droits_defaut;
        $mf_droits_defaut["objet__AJOUTER"] = $mf_droits_defaut["objet__CREER"];
        $objet_Libelle = $mf_initialisation['objet_Libelle'];
        $objet_Image_Fichier = $mf_initialisation['objet_Image_Fichier'];
        return $this->mf_ajouter($objet_Libelle, $objet_Image_Fichier, $Code_type, $force);
    }

    public function mf_ajouter_2(array $ligne, bool $force=null) // array('colonne1' => 'valeur1',  [...] )
    {
        if ( $force===null ) { $force=false; }
        global $mf_initialisation;
        $Code_type = (int)(isset($ligne['Code_type'])?round($ligne['Code_type']):0);
        $objet_Libelle = (string)(isset($ligne['objet_Libelle'])?$ligne['objet_Libelle']:$mf_initialisation['objet_Libelle']);
        $objet_Image_Fichier = (string)(isset($ligne['objet_Image_Fichier'])?$ligne['objet_Image_Fichier']:$mf_initialisation['objet_Image_Fichier']);
        return $this->mf_ajouter($objet_Libelle, $objet_Image_Fichier, $Code_type, $force);
    }

    public function mf_ajouter_3(array $lignes) // array( array( 'colonne1' => 'valeur1', 'colonne2' => 'valeur2',  [...] ), [...] )
    {
        global $mf_initialisation;
        $code_erreur = 0;
        $values = '';
        foreach ($lignes as $ligne)
        {
            $Code_type = (int)(isset($ligne['Code_type'])?round($ligne['Code_type']):0);
            $objet_Libelle = text_sql(isset($ligne['objet_Libelle'])?$ligne['objet_Libelle']:$mf_initialisation['objet_Libelle']);
            $objet_Image_Fichier = text_sql(isset($ligne['objet_Image_Fichier'])?$ligne['objet_Image_Fichier']:$mf_initialisation['objet_Image_Fichier']);
            if ($Code_type != 0)
            {
                $values.=($values!="" ? "," : "")."('$objet_Libelle', '$objet_Image_Fichier', $Code_type)";
            }
        }
        if ($values!='')
        {
            $requete = "INSERT INTO ".inst('objet')." ( objet_Libelle, objet_Image_Fichier, Code_type ) VALUES $values;";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            $n = requete_mysqli_affected_rows();
            if ($n < count($lignes))
            {
                $code_erreur = ERR_OBJET__AJOUTER_3__ECHEC_AJOUT;
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

    public function mf_modifier( int $Code_objet, string $objet_Libelle, string $objet_Image_Fichier, ?int $Code_type=null, ?bool $force=null)
    {
        if ( $force===null ) { $force=false; }
        $code_erreur = 0;
        $Code_objet = round($Code_objet);
        $Code_type = round($Code_type);
        Hook_objet::pre_controller($objet_Libelle, $objet_Image_Fichier, $Code_type, $Code_objet);
        if (!$force)
        {
            if (!self::$maj_droits_modifier_en_cours)
            {
                self::$maj_droits_modifier_en_cours = true;
                Hook_objet::hook_actualiser_les_droits_modifier($Code_objet);
                self::$maj_droits_modifier_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['objet__MODIFIER']) ) $code_erreur = REFUS_OBJET__MODIFIER;
        elseif ( !$this->mf_tester_existance_Code_objet($Code_objet) ) $code_erreur = ERR_OBJET__MODIFIER__CODE_OBJET_INEXISTANT;
        elseif ( $Code_type!=0 && !$this->mf_tester_existance_Code_type($Code_type) ) $code_erreur = ERR_OBJET__MODIFIER__CODE_TYPE_INEXISTANT;
        elseif ( CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_objet', $Code_objet) ) $code_erreur = ACCES_CODE_OBJET_REFUSE;
        elseif ( $Code_type!=0 && CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_type', $Code_type) ) $code_erreur = ACCES_CODE_TYPE_REFUSE;
        elseif ( !Hook_objet::autorisation_modification($Code_objet, $objet_Libelle, $objet_Image_Fichier, $Code_type) ) $code_erreur = REFUS_OBJET__MODIFICATION_BLOQUEE;
        else
        {
            Hook_objet::data_controller($objet_Libelle, $objet_Image_Fichier, $Code_type, $Code_objet);
            $objet = $this->mf_get_2( $Code_objet, array('autocompletion' => false, 'masquer_mdp' => false) );
            $mf_colonnes_a_modifier=[];
            $bool__objet_Libelle = false; if ( $objet_Libelle!=$objet['objet_Libelle'] ) { Hook_objet::data_controller__objet_Libelle($objet['objet_Libelle'], $objet_Libelle, $Code_objet); if ( $objet_Libelle!=$objet['objet_Libelle'] ) { $mf_colonnes_a_modifier[] = 'objet_Libelle=' . format_sql('objet_Libelle', $objet_Libelle); $bool__objet_Libelle = true; } }
            $bool__objet_Image_Fichier = false; if ( $objet_Image_Fichier!=$objet['objet_Image_Fichier'] ) { Hook_objet::data_controller__objet_Image_Fichier($objet['objet_Image_Fichier'], $objet_Image_Fichier, $Code_objet); if ( $objet_Image_Fichier!=$objet['objet_Image_Fichier'] ) { $mf_colonnes_a_modifier[] = 'objet_Image_Fichier=' . format_sql('objet_Image_Fichier', $objet_Image_Fichier); $bool__objet_Image_Fichier = true; } }
            $bool__Code_type = false; if ( $Code_type!=0 && $Code_type!=$objet['Code_type'] ) { Hook_objet::data_controller__Code_type($objet['Code_type'], $Code_type, $Code_objet); if ( $Code_type!=0 && $Code_type!=$objet['Code_type'] ) { $mf_colonnes_a_modifier[] = 'Code_type=' . $Code_type; $bool__Code_type = true; } }
            if (count($mf_colonnes_a_modifier)>0) {
                $mf_signature = text_sql(Hook_objet::calcul_signature($objet_Libelle, $objet_Image_Fichier, $Code_type));
                $mf_cle_unique = text_sql(Hook_objet::calcul_cle_unique($objet_Libelle, $objet_Image_Fichier, $Code_type));
                $mf_colonnes_a_modifier[] = 'mf_signature=\'' . $mf_signature . '\'';
                $mf_colonnes_a_modifier[] = 'mf_cle_unique=\'' . $mf_cle_unique . '\'';
                $mf_colonnes_a_modifier[] = 'mf_date_modification=\'' . get_now() . '\'';
                $requete = 'UPDATE '.inst('objet').' SET ' . enumeration($mf_colonnes_a_modifier) . ' WHERE Code_objet = ' . $Code_objet . ';';
                $cle = md5($requete).salt(10);
                self::$cache_db->pause($cle);
                executer_requete_mysql( $requete , true);
                if ( requete_mysqli_affected_rows()==0 )
                {
                    $code_erreur = ERR_OBJET__MODIFIER__AUCUN_CHANGEMENT;
                    self::$cache_db->reprendre($cle);
                }
                else
                {
                    self::$cache_db->clear();
                    self::$cache_db->reprendre($cle);
                    Hook_objet::modifier($Code_objet, $bool__objet_Libelle, $bool__objet_Image_Fichier, $bool__Code_type);
                }
            }
            else
            {
                $code_erreur = ERR_OBJET__MODIFIER__AUCUN_CHANGEMENT;
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
        return array('code_erreur' => $code_erreur, 'callback' => ( $code_erreur == 0 ? Hook_objet::callback_put($Code_objet) : null ));
    }

    public function mf_modifier_2(array $lignes, ?bool $force=null) // array( $Code_objet => array('colonne1' => 'valeur1',  [...] ) )
    {
        if ( $force===null ) { $force=false; }
        $code_erreur = 0;
        foreach ( $lignes as $Code_objet => $colonnes )
        {
            if ( $code_erreur==0 )
            {
                $Code_objet = (int)round($Code_objet);
                $objet = $this->mf_get_2($Code_objet, array('autocompletion' => false));
                if (!$force)
                {
                    if (!self::$maj_droits_modifier_en_cours)
                    {
                        self::$maj_droits_modifier_en_cours = true;
                        Hook_objet::hook_actualiser_les_droits_modifier($Code_objet);
                        self::$maj_droits_modifier_en_cours = false;
                    }
                }
                $Code_type = ( isset($colonnes['Code_type']) && ( $force || mf_matrice_droits(['api_modifier_ref__objet__Code_type', 'objet__MODIFIER']) ) ? $colonnes['Code_type'] : (isset($objet['Code_type']) ? $objet['Code_type'] : 0 ));
                $objet_Libelle = (string)( isset($colonnes['objet_Libelle']) && ( $force || mf_matrice_droits(['api_modifier__objet_Libelle', 'objet__MODIFIER']) ) ? $colonnes['objet_Libelle'] : ( isset($objet['objet_Libelle']) ? $objet['objet_Libelle'] : '' ) );
                $objet_Image_Fichier = (string)( isset($colonnes['objet_Image_Fichier']) && ( $force || mf_matrice_droits(['api_modifier__objet_Image_Fichier', 'objet__MODIFIER']) ) ? $colonnes['objet_Image_Fichier'] : ( isset($objet['objet_Image_Fichier']) ? $objet['objet_Image_Fichier'] : '' ) );
                $retour = $this->mf_modifier($Code_objet, $objet_Libelle, $objet_Image_Fichier, $Code_type, true);
                if ( $retour['code_erreur']!=0 && $retour['code_erreur'] != ERR_OBJET__MODIFIER__AUCUN_CHANGEMENT )
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

    public function mf_modifier_3(array $lignes) // array( $Code_objet => array('colonne1' => 'valeur1',  [...] ) )
    {
        $code_erreur = 0;
        $modifs = false;

        // transformation des lignes en colonnes
        $valeurs_en_colonnes=array();
        $indices_par_colonne=array();
        $liste_valeurs_indexees=array();
        foreach ( $lignes as $Code_objet => $colonnes )
        {
            foreach ($colonnes as $colonne => $valeur)
            {
                if ( $colonne=='objet_Libelle' || $colonne=='objet_Image_Fichier' || $colonne=='Code_type' )
                {
                    $valeurs_en_colonnes[$colonne][$Code_objet]=$valeur;
                    $indices_par_colonne[$colonne][]=$Code_objet;
                    $liste_valeurs_indexees[$colonne][''.$valeur][]=$Code_objet;
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
                $modification_sql = $colonne . ' = CASE Code_objet';
                foreach ( $valeurs as $Code_objet => $valeur )
                {
                    $modification_sql.=' WHEN ' . $Code_objet . ' THEN ' . format_sql($colonne, $valeur);
                }
                $modification_sql.=' END';
                $perimetre = Sql_Format_Liste($indices_par_colonne[$colonne]);
                executer_requete_mysql('UPDATE ' . inst('objet') . ' SET ' . $modification_sql . ' WHERE Code_objet IN ' . $perimetre . ';', true);
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
                    executer_requete_mysql('UPDATE ' . inst('objet') . ' SET ' . $colonne . ' = ' . format_sql($colonne, $valeur) . ' WHERE Code_objet IN ' . $perimetre . ';', true);
                    if ( requete_mysqli_affected_rows()!=0 )
                    {
                        $modifs = true;
                    }
                }
            }
        }

        if ( ! $modifs && $code_erreur==0 )
        {
            $code_erreur = ERR_OBJET__MODIFIER_3__AUCUN_CHANGEMENT;
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

    public function mf_modifier_4( int $Code_type, array $data, ?array $options = null /* $options = array( 'cond_mysql' => array(), 'limit' => 0 ) */ ) // $data = array('colonne1' => 'valeur1', ... )
    {
        if ( $options===null ) { $force=[]; }
        $code_erreur = 0;
        $Code_type = round($Code_type);
        $mf_colonnes_a_modifier=[];
        if ( isset($data['objet_Libelle']) ) { $mf_colonnes_a_modifier[] = 'objet_Libelle = ' . format_sql('objet_Libelle', $data['objet_Libelle']); }
        if ( isset($data['objet_Image_Fichier']) ) { $mf_colonnes_a_modifier[] = 'objet_Image_Fichier = ' . format_sql('objet_Image_Fichier', $data['objet_Image_Fichier']); }
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

            $requete = 'UPDATE ' . inst('objet') . ' SET ' . enumeration($mf_colonnes_a_modifier) . " WHERE 1".( $Code_type!=0 ? " AND Code_type=$Code_type" : "" )."$argument_cond" . ( $limit>0 ? ' LIMIT ' . $limit : '' ) . ";";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_OBJET__MODIFIER_4__AUCUN_CHANGEMENT;
            }
            else
            {
                self::$cache_db->clear();
            }
            self::$cache_db->reprendre($cle);
        }
        return array('code_erreur' => $code_erreur);
    }

    public function mf_supprimer( int $Code_objet, ?bool $force=null )
    {
        if ( $force===null ) { $force=false; }
        $code_erreur = 0;
        $Code_objet = round($Code_objet);
        if (!$force)
        {
            if (!self::$maj_droits_supprimer_en_cours)
            {
                self::$maj_droits_supprimer_en_cours = true;
                Hook_objet::hook_actualiser_les_droits_supprimer($Code_objet);
                self::$maj_droits_supprimer_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['objet__SUPPRIMER']) ) $code_erreur = REFUS_OBJET__SUPPRIMER;
        elseif ( !$this->mf_tester_existance_Code_objet($Code_objet) ) $code_erreur = ERR_OBJET__SUPPRIMER_2__CODE_OBJET_INEXISTANT;
        elseif ( CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_objet', $Code_objet) ) $code_erreur = ACCES_CODE_OBJET_REFUSE;
        elseif ( !Hook_objet::autorisation_suppression($Code_objet) ) $code_erreur = REFUS_OBJET__SUPPRESSION_BLOQUEE;
        else
        {
            $copie__objet = $this->mf_get($Code_objet, array('autocompletion' => false));
            $this->supprimer_donnes_en_cascade("objet", array($Code_objet));
            $requete = "DELETE IGNORE FROM ".inst('objet')." WHERE Code_objet=$Code_objet;";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_OBJET__SUPPRIMER__REFUSEE;
                self::$cache_db->reprendre($cle);
            }
            else
            {
                self::$cache_db->clear();
                self::$cache_db->reprendre($cle);
                Hook_objet::supprimer($copie__objet);
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

    public function mf_supprimer_2(array $liste_Code_objet, ?bool $force=null)
    {
        if ( $force===null ) { $force=false; }
        $code_erreur=0;
        $copie__liste_objet = $this->mf_lister_2($liste_Code_objet, array('autocompletion' => false));
        $liste_Code_objet=array();
        foreach ( $copie__liste_objet as $copie__objet )
        {
            $Code_objet = $copie__objet['Code_objet'];
            if (!$force)
            {
                if (!self::$maj_droits_supprimer_en_cours)
                {
                    self::$maj_droits_supprimer_en_cours = true;
                    Hook_objet::hook_actualiser_les_droits_supprimer($Code_objet);
                    self::$maj_droits_supprimer_en_cours = false;
                }
            }
            if ( !$force && !mf_matrice_droits(['objet__SUPPRIMER']) ) $code_erreur = REFUS_OBJET__SUPPRIMER;
            elseif ( !Hook_objet::autorisation_suppression($Code_objet) ) $code_erreur = REFUS_OBJET__SUPPRESSION_BLOQUEE;
            {
                $liste_Code_objet[] = $Code_objet;
            }
        }
        if ( $code_erreur==0 && count($liste_Code_objet)>0 )
        {
            $this->supprimer_donnes_en_cascade("objet", $liste_Code_objet);
            $requete = "DELETE IGNORE FROM ".inst('objet')." WHERE Code_objet IN ".Sql_Format_Liste($liste_Code_objet).";";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_OBJET__SUPPRIMER_2__REFUSEE;
                self::$cache_db->reprendre($cle);
            }
            else
            {
                self::$cache_db->clear();
                self::$cache_db->reprendre($cle);
                Hook_objet::supprimer_2($copie__liste_objet);
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

    public function mf_supprimer_3(array $liste_Code_objet)
    {
        $code_erreur=0;
        if ( count($liste_Code_objet)>0 )
        {
            $this->supprimer_donnes_en_cascade("objet", $liste_Code_objet);
            $requete = "DELETE IGNORE FROM ".inst('objet')." WHERE Code_objet IN ".Sql_Format_Liste($liste_Code_objet).";";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_OBJET__SUPPRIMER_3__REFUSEE;
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
        if ( ! $contexte_parent && $mf_contexte['Code_objet']!=0 )
        {
            $objet = $this->mf_get( $mf_contexte['Code_objet'], $options);
            return array( $objet['Code_objet'] => $objet );
        }
        else
        {
            return $this->mf_lister(isset($est_charge['type']) ? $mf_contexte['Code_type'] : 0, $options);
        }
    }

    public function mf_lister(?int $Code_type=null, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cle = "objet__lister";
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

        // tris
        $argument_tris = '';
        if ( ! isset($options['tris']) )
        {
            $options['tris']=array();
        }
        if ( count($options['tris'])==0 )
        {
            global $mf_tri_defaut_table;
            if ( isset($mf_tri_defaut_table['objet']) )
            {
                $options['tris'] = $mf_tri_defaut_table['objet'];
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
                    if ( strpos($argument_cond, 'objet_Libelle')!==false ) { $liste_colonnes_a_indexer['objet_Libelle'] = 'objet_Libelle'; }
                    if ( strpos($argument_cond, 'objet_Image_Fichier')!==false ) { $liste_colonnes_a_indexer['objet_Image_Fichier'] = 'objet_Image_Fichier'; }
                }
                if ( isset($options['tris']) )
                {
                    if ( isset($options['tris']['objet_Libelle']) ) { $liste_colonnes_a_indexer['objet_Libelle'] = 'objet_Libelle'; }
                    if ( isset($options['tris']['objet_Image_Fichier']) ) { $liste_colonnes_a_indexer['objet_Image_Fichier'] = 'objet_Image_Fichier'; }
                }
                if ( count($liste_colonnes_a_indexer)>0 )
                {
                    if ( ! $mf_liste_requete_index = self::$cache_db->read('objet__index') )
                    {
                        $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('objet').'`;', false);
                        $mf_liste_requete_index = array();
                        while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                        {
                            $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                        }
                        mysqli_free_result($res_requete_index);
                        self::$cache_db->write('objet__index', $mf_liste_requete_index);
                    }
                    foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                    {
                        if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                    }
                    if ( count($liste_colonnes_a_indexer) > 0 )
                    {
                        self::$cache_db->pause('objet__index');
                        foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                        {
                            executer_requete_mysql('ALTER TABLE `'.inst('objet').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                        }
                        self::$cache_db->clear();
                        self::$cache_db->reprendre('objet__index');
                    }
                }

                $liste = array();
                $liste_objet_pas_a_jour = array();
                if ($toutes_colonnes)
                {
                    $colonnes='Code_objet, objet_Libelle, objet_Image_Fichier, Code_type';
                }
                else
                {
                    $colonnes='Code_objet, objet_Libelle, objet_Image_Fichier, Code_type';
                }
                $res_requete = executer_requete_mysql("SELECT $colonnes FROM ".inst('objet')." WHERE 1{$argument_cond}".( $Code_type!=0 ? " AND Code_type=$Code_type" : "" )."{$argument_tris}{$argument_limit};", false);
                while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
                {
                    mf_formatage_db_type_php($row_requete);
                    $liste[$row_requete['Code_objet']] = $row_requete;
                    if ( $maj && ! Hook_objet::est_a_jour( $row_requete ) )
                    {
                        $liste_objet_pas_a_jour[$row_requete['Code_objet']] = $row_requete;
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
                Hook_objet::mettre_a_jour( $liste_objet_pas_a_jour );
            }
        }

        foreach ($liste as $elem)
        {
            if ( $controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_objet', $elem['Code_objet']) )
            {
                unset($liste[$elem['Code_objet']]);
            }
            else
            {
                if (!self::$auto_completion && $autocompletion)
                {
                    self::$auto_completion = true;
                    Hook_objet::completion($liste[$elem['Code_objet']]);
                    self::$auto_completion = false;
                }
            }
        }

        return $liste;
    }

    public function mf_lister_2(array $liste_Code_objet, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        if ( count($liste_Code_objet)>0 )
        {
            $cle = "objet__mf_lister_2_".Sql_Format_Liste($liste_Code_objet);

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
                if ( isset($mf_tri_defaut_table['objet']) )
                {
                    $options['tris'] = $mf_tri_defaut_table['objet'];
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
                        if ( strpos($argument_cond, 'objet_Libelle')!==false ) { $liste_colonnes_a_indexer['objet_Libelle'] = 'objet_Libelle'; }
                        if ( strpos($argument_cond, 'objet_Image_Fichier')!==false ) { $liste_colonnes_a_indexer['objet_Image_Fichier'] = 'objet_Image_Fichier'; }
                    }
                    if ( isset($options['tris']) )
                    {
                        if ( isset($options['tris']['objet_Libelle']) ) { $liste_colonnes_a_indexer['objet_Libelle'] = 'objet_Libelle'; }
                        if ( isset($options['tris']['objet_Image_Fichier']) ) { $liste_colonnes_a_indexer['objet_Image_Fichier'] = 'objet_Image_Fichier'; }
                    }
                    if ( count($liste_colonnes_a_indexer)>0 )
                    {
                        if ( ! $mf_liste_requete_index = self::$cache_db->read('objet__index') )
                        {
                            $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('objet').'`;', false);
                            $mf_liste_requete_index = array();
                            while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                            {
                                $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                            }
                            mysqli_free_result($res_requete_index);
                            self::$cache_db->write('objet__index', $mf_liste_requete_index);
                        }
                        foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                        {
                            if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                        }
                        if ( count($liste_colonnes_a_indexer) > 0 )
                        {
                            self::$cache_db->pause('objet__index');
                            foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                            {
                                executer_requete_mysql('ALTER TABLE `'.inst('objet').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                            }
                            self::$cache_db->clear();
                            self::$cache_db->reprendre('objet__index');
                        }
                    }

                    $liste = array();
                    $liste_objet_pas_a_jour = array();
                    if ($toutes_colonnes)
                    {
                        $colonnes='Code_objet, objet_Libelle, objet_Image_Fichier, Code_type';
                    }
                    else
                    {
                        $colonnes='Code_objet, objet_Libelle, objet_Image_Fichier, Code_type';
                    }
                    $res_requete = executer_requete_mysql("SELECT $colonnes FROM ".inst('objet')." WHERE 1{$argument_cond} AND Code_objet IN ".Sql_Format_Liste($liste_Code_objet)."{$argument_tris}{$argument_limit};", false);
                    while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
                    {
                        mf_formatage_db_type_php($row_requete);
                        $liste[$row_requete['Code_objet']] = $row_requete;
                        if ( $maj && ! Hook_objet::est_a_jour( $row_requete ) )
                        {
                            $liste_objet_pas_a_jour[$row_requete['Code_objet']] = $row_requete;
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
                    Hook_objet::mettre_a_jour( $liste_objet_pas_a_jour );
                }
            }

            foreach ($liste as $elem)
            {
                if ( $controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_objet', $elem['Code_objet']) )
                {
                    unset($liste[$elem['Code_objet']]);
                }
                else
                {
                    if (!self::$auto_completion && $autocompletion)
                    {
                        self::$auto_completion = true;
                        Hook_objet::completion($liste[$elem['Code_objet']]);
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

    public function mf_get(int $Code_objet, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $Code_objet = round($Code_objet);
        $retour = array();
        if ( ! CONTROLE_ACCES_DONNEES_DEFAUT || Hook_mf_systeme::controle_acces_donnees('Code_objet', $Code_objet) )
        {
            $cle = 'objet__get_'.$Code_objet;

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
                        $colonnes='Code_objet, objet_Libelle, objet_Image_Fichier, Code_type';
                    }
                    else
                    {
                        $colonnes='Code_objet, objet_Libelle, objet_Image_Fichier, Code_type';
                    }
                    $res_requete = executer_requete_mysql('SELECT ' . $colonnes . ' FROM ' . inst('objet') . ' WHERE Code_objet = ' . $Code_objet . ';', false);
                    if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
                    {
                        mf_formatage_db_type_php($row_requete);
                        $retour = $row_requete;
                        if ( $maj && ! Hook_objet::est_a_jour( $row_requete ) )
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
                    Hook_objet::mettre_a_jour( array( $row_requete['Code_objet'] => $row_requete ) );
                }
            }
            if ( isset( $retour['Code_objet'] ) )
            {
                if (!self::$auto_completion && $autocompletion)
                {
                    self::$auto_completion = true;
                    Hook_objet::completion($retour);
                    self::$auto_completion = false;
                }
            }
        }
        return $retour;
    }

    public function mf_get_last(?int $Code_type=null, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cle = "objet__get_last";
        $Code_type = round($Code_type);
        $cle.='_' . $Code_type;
        if ( ! $retour = self::$cache_db->read($cle) )
        {
            $Code_objet = 0;
            $res_requete = executer_requete_mysql('SELECT Code_objet FROM ' . inst('objet') . " WHERE 1".( $Code_type!=0 ? " AND Code_type=$Code_type" : "" )." ORDER BY mf_date_creation DESC, Code_objet DESC LIMIT 0 , 1;", false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $Code_objet = $row_requete['Code_objet'];
            }
            mysqli_free_result($res_requete);
            $retour = $this->mf_get($Code_objet, $options);
            self::$cache_db->write($cle, $retour);
        }
        return $retour;
    }

    public function mf_get_2(int $Code_objet, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $Code_objet = round($Code_objet);
        $retour = array();
        $cle = 'objet__get_'.$Code_objet;

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
                $colonnes='Code_objet, objet_Libelle, objet_Image_Fichier, Code_type';
            }
            else
            {
                $colonnes='Code_objet, objet_Libelle, objet_Image_Fichier, Code_type';
            }
            $res_requete = executer_requete_mysql('SELECT ' . $colonnes . " FROM ".inst('objet')." WHERE Code_objet = $Code_objet;", false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                mf_formatage_db_type_php($row_requete);
                $retour = $row_requete;
            }
            mysqli_free_result($res_requete);
            self::$cache_db->write($cle, $retour);
        }
        if ( isset( $retour['Code_objet'] ) )
        {
            if (!self::$auto_completion && $autocompletion)
            {
                self::$auto_completion = true;
                Hook_objet::completion($retour);
                self::$auto_completion = false;
            }
        }
        return $retour;
    }

    public function mf_prec_et_suiv( int $Code_objet, ?int $Code_type=null, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $Code_objet = round($Code_objet);
        $liste = $this->mf_lister($Code_type, $options);
        return prec_suiv($liste, $Code_objet);
    }

    public function mf_compter(?int $Code_type=null, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cle = 'objet__compter';
        $Code_type = round($Code_type);
        $cle.='_{'.$Code_type.'}';

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
                if ( strpos($argument_cond, 'objet_Libelle')!==false ) { $liste_colonnes_a_indexer['objet_Libelle'] = 'objet_Libelle'; }
                if ( strpos($argument_cond, 'objet_Image_Fichier')!==false ) { $liste_colonnes_a_indexer['objet_Image_Fichier'] = 'objet_Image_Fichier'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = self::$cache_db->read('objet__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('objet').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    self::$cache_db->write('objet__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    self::$cache_db->pause('objet__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('objet').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    self::$cache_db->clear();
                    self::$cache_db->reprendre('objet__index');
                }
            }

            $res_requete = executer_requete_mysql('SELECT count(Code_objet) as nb FROM ' . inst('objet')." WHERE 1{$argument_cond}".( $Code_type!=0 ? " AND Code_type=$Code_type" : "" ).";", false);
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
        $Code_type = isset($interface['Code_type']) ? round($interface['Code_type']) : 0;
        return $this->mf_compter( $Code_type, $options );
    }

    public function mf_liste_Code_objet(?int $Code_type=null, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ( $options===null ) { $options=[]; }
        return $this->get_liste_Code_objet($Code_type, $options);
    }

    public function mf_convertir_Code_objet_vers_Code_type( int $Code_objet )
    {
        return $this->Code_objet_vers_Code_type( $Code_objet );
    }

    public function mf_liste_Code_type_vers_liste_Code_objet( array $liste_Code_type, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ( $options===null ) { $options=[]; }
        return $this->liste_Code_type_vers_liste_Code_objet( $liste_Code_type, $options );
    }

    public function mf_liste_Code_objet_vers_liste_Code_type( array $liste_Code_objet, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ( $options===null ) { $options=[]; }
        return $this->objet__liste_Code_objet_vers_liste_Code_type( $liste_Code_objet, $options );
    }

    public function mf_get_liste_tables_enfants()
    {
        return $this->get_liste_tables_enfants( 'objet' );
    }

    public function mf_get_liste_tables_parents()
    {
        return array('Code_type');
    }

    public function mf_search_objet_Libelle( string $objet_Libelle, ?int $Code_type=null )
    {
        return $this->rechercher_objet_Libelle( $objet_Libelle, $Code_type );
    }

    public function mf_search_objet_Image_Fichier( string $objet_Image_Fichier, ?int $Code_type=null )
    {
        return $this->rechercher_objet_Image_Fichier( $objet_Image_Fichier, $Code_type );
    }

    public function mf_search__colonne( string $colonne_db, $recherche, ?int $Code_type=null )
    {
        switch ($colonne_db) {
            case 'objet_Libelle': return $this->mf_search_objet_Libelle( $recherche, $Code_type ); break;
            case 'objet_Image_Fichier': return $this->mf_search_objet_Image_Fichier( $recherche, $Code_type ); break;
        }
    }

    public function mf_get_next_id()
    {
        $res_requete = executer_requete_mysql('SELECT AUTO_INCREMENT as next_id FROM INFORMATION_SCHEMA.TABLES WHERE table_name = \'objet\';', false);
        $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC);
        mysqli_free_result($res_requete);
        return round($row_requete['next_id']);
    }

    public function mf_search(array $ligne) // array('colonne1' => 'valeur1',  [...] )
    {
        global $mf_initialisation;
        $Code_type = (int)(isset($ligne['Code_type'])?round($ligne['Code_type']):0);
        $objet_Libelle = (string)(isset($ligne['objet_Libelle'])?$ligne['objet_Libelle']:$mf_initialisation['objet_Libelle']);
        $objet_Image_Fichier = (string)(isset($ligne['objet_Image_Fichier'])?$ligne['objet_Image_Fichier']:$mf_initialisation['objet_Image_Fichier']);
        Hook_objet::pre_controller($objet_Libelle, $objet_Image_Fichier, $Code_type);
        $mf_cle_unique = Hook_objet::calcul_cle_unique($objet_Libelle, $objet_Image_Fichier, $Code_type);
        $res_requete = executer_requete_mysql('SELECT Code_objet FROM ' . inst('objet') . ' WHERE mf_cle_unique = \''.$mf_cle_unique.'\'', false);
        if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
        {
            $r = round($row_requete['Code_objet']);
        }
        else
        {
            $r = false;
        }
        mysqli_free_result($res_requete);
        return $r;
    }

}
