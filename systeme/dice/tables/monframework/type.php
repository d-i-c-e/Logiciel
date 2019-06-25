<?php

/*
    +------------------------------+
    |  NE PAS MODIFIER CE FICHIER  |
    +------------------------------+
*/

class type_monframework extends entite_monframework
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
            include_once __DIR__ . '/../../erreurs/erreurs__type.php';
            self::$initialisation = false;
            Hook_type::initialisation();
            self::$cache_db = new Mf_Cachedb('type');
        }
        if (!self::$actualisation_en_cours)
        {
            self::$actualisation_en_cours=true;
            Hook_type::actualisation();
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

        if ( ! test_si_table_existe(inst('type')) )
        {
            executer_requete_mysql('CREATE TABLE '.inst('type').'(Code_type INT AUTO_INCREMENT NOT NULL, PRIMARY KEY (Code_type)) ENGINE=MyISAM;', true);
        }

        $liste_colonnes = lister_les_colonnes(inst('type'));

        if ( isset($liste_colonnes['type_Libelle']) )
        {
            if ( typeMyql2Sql($liste_colonnes['type_Libelle']['Type'])!='VARCHAR' )
            {
                executer_requete_mysql('ALTER TABLE '.inst('type').' CHANGE type_Libelle type_Libelle VARCHAR(255);', true);
            }
            unset($liste_colonnes['type_Libelle']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('type').' ADD type_Libelle VARCHAR(255);', true);
            executer_requete_mysql('UPDATE '.inst('type').' SET type_Libelle=' . format_sql('type_Libelle', $mf_initialisation['type_Libelle']) . ';', true);
        }

        if ( isset($liste_colonnes['Code_ressource']) )
        {
            unset($liste_colonnes['Code_ressource']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('type').' ADD Code_ressource int NOT NULL;', true);
        }

        if ( isset($liste_colonnes['mf_signature']) )
        {
            unset($liste_colonnes['mf_signature']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('type').' ADD mf_signature VARCHAR(255);', true);
            executer_requete_mysql('ALTER TABLE '.inst('type').' ADD INDEX( mf_signature );', true);
        }

        if ( isset($liste_colonnes['mf_cle_unique']) )
        {
            unset($liste_colonnes['mf_cle_unique']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('type').' ADD mf_cle_unique VARCHAR(255);', true);
            executer_requete_mysql('ALTER TABLE '.inst('type').' ADD INDEX( mf_cle_unique );', true);
        }

        if ( isset($liste_colonnes['mf_date_creation']) )
        {
            unset($liste_colonnes['mf_date_creation']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('type').' ADD mf_date_creation DATETIME;', true);
            executer_requete_mysql('ALTER TABLE '.inst('type').' ADD INDEX( mf_date_creation );', true);
        }

        if ( isset($liste_colonnes['mf_date_modification']) )
        {
            unset($liste_colonnes['mf_date_modification']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('type').' ADD mf_date_modification DATETIME;', true);
            executer_requete_mysql('ALTER TABLE '.inst('type').' ADD INDEX( mf_date_modification );', true);
        }

        unset($liste_colonnes['Code_type']);

        foreach ($liste_colonnes as $field => $value)
        {
            executer_requete_mysql('ALTER TABLE '.inst('type').' DROP COLUMN '.$field.';', true);
        }

    }

    public function mf_ajouter(string $type_Libelle, int $Code_ressource, ?bool $force=false)
    {
        if ( $force===null ) { $force=false; }
        $Code_type = 0;
        $code_erreur = 0;
        $Code_ressource = round($Code_ressource);
        Hook_type::pre_controller($type_Libelle, $Code_ressource);
        if (!$force)
        {
            if (!self::$maj_droits_ajouter_en_cours)
            {
                self::$maj_droits_ajouter_en_cours = true;
                Hook_type::hook_actualiser_les_droits_ajouter($Code_ressource);
                self::$maj_droits_ajouter_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['type__AJOUTER']) ) $code_erreur = REFUS_TYPE__AJOUTER;
        elseif ( !$this->mf_tester_existance_Code_ressource($Code_ressource) ) $code_erreur = ERR_TYPE__AJOUTER__CODE_RESSOURCE_INEXISTANT;
        elseif ( CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_ressource', $Code_ressource) ) $code_erreur = ACCES_CODE_RESSOURCE_REFUSE;
        elseif ( !Hook_type::autorisation_ajout($type_Libelle, $Code_ressource) ) $code_erreur = REFUS_TYPE__AJOUT_BLOQUEE;
        else
        {
            Hook_type::data_controller($type_Libelle, $Code_ressource);
            $mf_signature = text_sql(Hook_type::calcul_signature($type_Libelle, $Code_ressource));
            $mf_cle_unique = text_sql(Hook_type::calcul_cle_unique($type_Libelle, $Code_ressource));
            $type_Libelle = text_sql($type_Libelle);
            $requete = "INSERT INTO ".inst('type')." ( mf_signature, mf_cle_unique, mf_date_creation, mf_date_modification, type_Libelle, Code_ressource ) VALUES ( '$mf_signature', '$mf_cle_unique', '".get_now()."', '".get_now()."', '$type_Libelle', $Code_ressource );";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql($requete, true);
            $Code_type = requete_mysql_insert_id();
            if ($Code_type==0)
            {
                $code_erreur = ERR_TYPE__AJOUTER__AJOUT_REFUSE;
                self::$cache_db->reprendre($cle);
            }
            else
            {
                self::$cache_db->clear();
                self::$cache_db->reprendre($cle);
                Hook_type::ajouter( $Code_type );
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
        return array('code_erreur' => $code_erreur, 'Code_type' => $Code_type, 'callback' => ( $code_erreur==0 ? Hook_type::callback_post($Code_type) : null ));
    }

    public function mf_creer(int $Code_ressource, ?bool $force=null)
    {
        if ( $force===null ) { $force=false; }
        global $mf_initialisation, $mf_droits_defaut;
        $mf_droits_defaut["type__AJOUTER"] = $mf_droits_defaut["type__CREER"];
        $type_Libelle = $mf_initialisation['type_Libelle'];
        return $this->mf_ajouter($type_Libelle, $Code_ressource, $force);
    }

    public function mf_ajouter_2(array $ligne, bool $force=null) // array('colonne1' => 'valeur1',  [...] )
    {
        if ( $force===null ) { $force=false; }
        global $mf_initialisation;
        $Code_ressource = (int)(isset($ligne['Code_ressource'])?round($ligne['Code_ressource']):0);
        $type_Libelle = (string)(isset($ligne['type_Libelle'])?$ligne['type_Libelle']:$mf_initialisation['type_Libelle']);
        return $this->mf_ajouter($type_Libelle, $Code_ressource, $force);
    }

    public function mf_ajouter_3(array $lignes) // array( array( 'colonne1' => 'valeur1', 'colonne2' => 'valeur2',  [...] ), [...] )
    {
        global $mf_initialisation;
        $code_erreur = 0;
        $values = '';
        foreach ($lignes as $ligne)
        {
            $Code_ressource = (int)(isset($ligne['Code_ressource'])?round($ligne['Code_ressource']):0);
            $type_Libelle = text_sql(isset($ligne['type_Libelle'])?$ligne['type_Libelle']:$mf_initialisation['type_Libelle']);
            if ($Code_ressource != 0)
            {
                $values.=($values!="" ? "," : "")."('$type_Libelle', $Code_ressource)";
            }
        }
        if ($values!='')
        {
            $requete = "INSERT INTO ".inst('type')." ( type_Libelle, Code_ressource ) VALUES $values;";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            $n = requete_mysqli_affected_rows();
            if ($n < count($lignes))
            {
                $code_erreur = ERR_TYPE__AJOUTER_3__ECHEC_AJOUT;
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

    public function mf_modifier( int $Code_type, string $type_Libelle, ?int $Code_ressource=null, ?bool $force=null)
    {
        if ( $force===null ) { $force=false; }
        $code_erreur = 0;
        $Code_type = round($Code_type);
        $Code_ressource = round($Code_ressource);
        Hook_type::pre_controller($type_Libelle, $Code_ressource, $Code_type);
        if (!$force)
        {
            if (!self::$maj_droits_modifier_en_cours)
            {
                self::$maj_droits_modifier_en_cours = true;
                Hook_type::hook_actualiser_les_droits_modifier($Code_type);
                self::$maj_droits_modifier_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['type__MODIFIER']) ) $code_erreur = REFUS_TYPE__MODIFIER;
        elseif ( !$this->mf_tester_existance_Code_type($Code_type) ) $code_erreur = ERR_TYPE__MODIFIER__CODE_TYPE_INEXISTANT;
        elseif ( $Code_ressource!=0 && !$this->mf_tester_existance_Code_ressource($Code_ressource) ) $code_erreur = ERR_TYPE__MODIFIER__CODE_RESSOURCE_INEXISTANT;
        elseif ( CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_type', $Code_type) ) $code_erreur = ACCES_CODE_TYPE_REFUSE;
        elseif ( $Code_ressource!=0 && CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_ressource', $Code_ressource) ) $code_erreur = ACCES_CODE_RESSOURCE_REFUSE;
        elseif ( !Hook_type::autorisation_modification($Code_type, $type_Libelle, $Code_ressource) ) $code_erreur = REFUS_TYPE__MODIFICATION_BLOQUEE;
        else
        {
            Hook_type::data_controller($type_Libelle, $Code_ressource, $Code_type);
            $type = $this->mf_get_2( $Code_type, array('autocompletion' => false, 'masquer_mdp' => false) );
            $mf_colonnes_a_modifier=[];
            $bool__type_Libelle = false; if ( $type_Libelle!=$type['type_Libelle'] ) { Hook_type::data_controller__type_Libelle($type['type_Libelle'], $type_Libelle, $Code_type); if ( $type_Libelle!=$type['type_Libelle'] ) { $mf_colonnes_a_modifier[] = 'type_Libelle=' . format_sql('type_Libelle', $type_Libelle); $bool__type_Libelle = true; } }
            $bool__Code_ressource = false; if ( $Code_ressource!=0 && $Code_ressource!=$type['Code_ressource'] ) { Hook_type::data_controller__Code_ressource($type['Code_ressource'], $Code_ressource, $Code_type); if ( $Code_ressource!=0 && $Code_ressource!=$type['Code_ressource'] ) { $mf_colonnes_a_modifier[] = 'Code_ressource=' . $Code_ressource; $bool__Code_ressource = true; } }
            if (count($mf_colonnes_a_modifier)>0) {
                $mf_signature = text_sql(Hook_type::calcul_signature($type_Libelle, $Code_ressource));
                $mf_cle_unique = text_sql(Hook_type::calcul_cle_unique($type_Libelle, $Code_ressource));
                $mf_colonnes_a_modifier[] = 'mf_signature=\'' . $mf_signature . '\'';
                $mf_colonnes_a_modifier[] = 'mf_cle_unique=\'' . $mf_cle_unique . '\'';
                $mf_colonnes_a_modifier[] = 'mf_date_modification=\'' . get_now() . '\'';
                $requete = 'UPDATE '.inst('type').' SET ' . enumeration($mf_colonnes_a_modifier) . ' WHERE Code_type = ' . $Code_type . ';';
                $cle = md5($requete).salt(10);
                self::$cache_db->pause($cle);
                executer_requete_mysql( $requete , true);
                if ( requete_mysqli_affected_rows()==0 )
                {
                    $code_erreur = ERR_TYPE__MODIFIER__AUCUN_CHANGEMENT;
                    self::$cache_db->reprendre($cle);
                }
                else
                {
                    self::$cache_db->clear();
                    self::$cache_db->reprendre($cle);
                    Hook_type::modifier($Code_type, $bool__type_Libelle, $bool__Code_ressource);
                }
            }
            else
            {
                $code_erreur = ERR_TYPE__MODIFIER__AUCUN_CHANGEMENT;
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
        return array('code_erreur' => $code_erreur, 'callback' => ( $code_erreur == 0 ? Hook_type::callback_put($Code_type) : null ));
    }

    public function mf_modifier_2(array $lignes, ?bool $force=null) // array( $Code_type => array('colonne1' => 'valeur1',  [...] ) )
    {
        if ( $force===null ) { $force=false; }
        $code_erreur = 0;
        foreach ( $lignes as $Code_type => $colonnes )
        {
            if ( $code_erreur==0 )
            {
                $Code_type = (int)round($Code_type);
                $type = $this->mf_get_2($Code_type, array('autocompletion' => false));
                if (!$force)
                {
                    if (!self::$maj_droits_modifier_en_cours)
                    {
                        self::$maj_droits_modifier_en_cours = true;
                        Hook_type::hook_actualiser_les_droits_modifier($Code_type);
                        self::$maj_droits_modifier_en_cours = false;
                    }
                }
                $Code_ressource = ( isset($colonnes['Code_ressource']) && ( $force || mf_matrice_droits(['api_modifier_ref__type__Code_ressource', 'type__MODIFIER']) ) ? $colonnes['Code_ressource'] : (isset($type['Code_ressource']) ? $type['Code_ressource'] : 0 ));
                $type_Libelle = (string)( isset($colonnes['type_Libelle']) && ( $force || mf_matrice_droits(['api_modifier__type_Libelle', 'type__MODIFIER']) ) ? $colonnes['type_Libelle'] : ( isset($type['type_Libelle']) ? $type['type_Libelle'] : '' ) );
                $retour = $this->mf_modifier($Code_type, $type_Libelle, $Code_ressource, true);
                if ( $retour['code_erreur']!=0 && $retour['code_erreur'] != ERR_TYPE__MODIFIER__AUCUN_CHANGEMENT )
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

    public function mf_modifier_3(array $lignes) // array( $Code_type => array('colonne1' => 'valeur1',  [...] ) )
    {
        $code_erreur = 0;
        $modifs = false;

        // transformation des lignes en colonnes
        $valeurs_en_colonnes=array();
        $indices_par_colonne=array();
        $liste_valeurs_indexees=array();
        foreach ( $lignes as $Code_type => $colonnes )
        {
            foreach ($colonnes as $colonne => $valeur)
            {
                if ( $colonne=='type_Libelle' || $colonne=='Code_ressource' )
                {
                    $valeurs_en_colonnes[$colonne][$Code_type]=$valeur;
                    $indices_par_colonne[$colonne][]=$Code_type;
                    $liste_valeurs_indexees[$colonne][''.$valeur][]=$Code_type;
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
                $modification_sql = $colonne . ' = CASE Code_type';
                foreach ( $valeurs as $Code_type => $valeur )
                {
                    $modification_sql.=' WHEN ' . $Code_type . ' THEN ' . format_sql($colonne, $valeur);
                }
                $modification_sql.=' END';
                $perimetre = Sql_Format_Liste($indices_par_colonne[$colonne]);
                executer_requete_mysql('UPDATE ' . inst('type') . ' SET ' . $modification_sql . ' WHERE Code_type IN ' . $perimetre . ';', true);
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
                    executer_requete_mysql('UPDATE ' . inst('type') . ' SET ' . $colonne . ' = ' . format_sql($colonne, $valeur) . ' WHERE Code_type IN ' . $perimetre . ';', true);
                    if ( requete_mysqli_affected_rows()!=0 )
                    {
                        $modifs = true;
                    }
                }
            }
        }

        if ( ! $modifs && $code_erreur==0 )
        {
            $code_erreur = ERR_TYPE__MODIFIER_3__AUCUN_CHANGEMENT;
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

    public function mf_modifier_4( int $Code_ressource, array $data, ?array $options = null /* $options = array( 'cond_mysql' => array(), 'limit' => 0 ) */ ) // $data = array('colonne1' => 'valeur1', ... )
    {
        if ( $options===null ) { $force=[]; }
        $code_erreur = 0;
        $Code_ressource = round($Code_ressource);
        $mf_colonnes_a_modifier=[];
        if ( isset($data['type_Libelle']) ) { $mf_colonnes_a_modifier[] = 'type_Libelle = ' . format_sql('type_Libelle', $data['type_Libelle']); }
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

            $requete = 'UPDATE ' . inst('type') . ' SET ' . enumeration($mf_colonnes_a_modifier) . " WHERE 1".( $Code_ressource!=0 ? " AND Code_ressource=$Code_ressource" : "" )."$argument_cond" . ( $limit>0 ? ' LIMIT ' . $limit : '' ) . ";";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_TYPE__MODIFIER_4__AUCUN_CHANGEMENT;
            }
            else
            {
                self::$cache_db->clear();
            }
            self::$cache_db->reprendre($cle);
        }
        return array('code_erreur' => $code_erreur);
    }

    public function mf_supprimer( int $Code_type, ?bool $force=null )
    {
        if ( $force===null ) { $force=false; }
        $code_erreur = 0;
        $Code_type = round($Code_type);
        if (!$force)
        {
            if (!self::$maj_droits_supprimer_en_cours)
            {
                self::$maj_droits_supprimer_en_cours = true;
                Hook_type::hook_actualiser_les_droits_supprimer($Code_type);
                self::$maj_droits_supprimer_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['type__SUPPRIMER']) ) $code_erreur = REFUS_TYPE__SUPPRIMER;
        elseif ( !$this->mf_tester_existance_Code_type($Code_type) ) $code_erreur = ERR_TYPE__SUPPRIMER_2__CODE_TYPE_INEXISTANT;
        elseif ( CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_type', $Code_type) ) $code_erreur = ACCES_CODE_TYPE_REFUSE;
        elseif ( !Hook_type::autorisation_suppression($Code_type) ) $code_erreur = REFUS_TYPE__SUPPRESSION_BLOQUEE;
        else
        {
            $copie__type = $this->mf_get($Code_type, array('autocompletion' => false));
            $this->supprimer_donnes_en_cascade("type", array($Code_type));
            $requete = "DELETE IGNORE FROM ".inst('type')." WHERE Code_type=$Code_type;";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_TYPE__SUPPRIMER__REFUSEE;
                self::$cache_db->reprendre($cle);
            }
            else
            {
                self::$cache_db->clear();
                self::$cache_db->reprendre($cle);
                Hook_type::supprimer($copie__type);
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

    public function mf_supprimer_2(array $liste_Code_type, ?bool $force=null)
    {
        if ( $force===null ) { $force=false; }
        $code_erreur=0;
        $copie__liste_type = $this->mf_lister_2($liste_Code_type, array('autocompletion' => false));
        $liste_Code_type=array();
        foreach ( $copie__liste_type as $copie__type )
        {
            $Code_type = $copie__type['Code_type'];
            if (!$force)
            {
                if (!self::$maj_droits_supprimer_en_cours)
                {
                    self::$maj_droits_supprimer_en_cours = true;
                    Hook_type::hook_actualiser_les_droits_supprimer($Code_type);
                    self::$maj_droits_supprimer_en_cours = false;
                }
            }
            if ( !$force && !mf_matrice_droits(['type__SUPPRIMER']) ) $code_erreur = REFUS_TYPE__SUPPRIMER;
            elseif ( !Hook_type::autorisation_suppression($Code_type) ) $code_erreur = REFUS_TYPE__SUPPRESSION_BLOQUEE;
            {
                $liste_Code_type[] = $Code_type;
            }
        }
        if ( $code_erreur==0 && count($liste_Code_type)>0 )
        {
            $this->supprimer_donnes_en_cascade("type", $liste_Code_type);
            $requete = "DELETE IGNORE FROM ".inst('type')." WHERE Code_type IN ".Sql_Format_Liste($liste_Code_type).";";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_TYPE__SUPPRIMER_2__REFUSEE;
                self::$cache_db->reprendre($cle);
            }
            else
            {
                self::$cache_db->clear();
                self::$cache_db->reprendre($cle);
                Hook_type::supprimer_2($copie__liste_type);
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

    public function mf_supprimer_3(array $liste_Code_type)
    {
        $code_erreur=0;
        if ( count($liste_Code_type)>0 )
        {
            $this->supprimer_donnes_en_cascade("type", $liste_Code_type);
            $requete = "DELETE IGNORE FROM ".inst('type')." WHERE Code_type IN ".Sql_Format_Liste($liste_Code_type).";";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_TYPE__SUPPRIMER_3__REFUSEE;
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
        if ( ! $contexte_parent && $mf_contexte['Code_type']!=0 )
        {
            $type = $this->mf_get( $mf_contexte['Code_type'], $options);
            return array( $type['Code_type'] => $type );
        }
        else
        {
            return $this->mf_lister(isset($est_charge['ressource']) ? $mf_contexte['Code_ressource'] : 0, $options);
        }
    }

    public function mf_lister(?int $Code_ressource=null, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cle = "type__lister";
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

        // tris
        $argument_tris = '';
        if ( ! isset($options['tris']) )
        {
            $options['tris']=array();
        }
        if ( count($options['tris'])==0 )
        {
            global $mf_tri_defaut_table;
            if ( isset($mf_tri_defaut_table['type']) )
            {
                $options['tris'] = $mf_tri_defaut_table['type'];
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
                    if ( strpos($argument_cond, 'type_Libelle')!==false ) { $liste_colonnes_a_indexer['type_Libelle'] = 'type_Libelle'; }
                }
                if ( isset($options['tris']) )
                {
                    if ( isset($options['tris']['type_Libelle']) ) { $liste_colonnes_a_indexer['type_Libelle'] = 'type_Libelle'; }
                }
                if ( count($liste_colonnes_a_indexer)>0 )
                {
                    if ( ! $mf_liste_requete_index = self::$cache_db->read('type__index') )
                    {
                        $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('type').'`;', false);
                        $mf_liste_requete_index = array();
                        while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                        {
                            $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                        }
                        mysqli_free_result($res_requete_index);
                        self::$cache_db->write('type__index', $mf_liste_requete_index);
                    }
                    foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                    {
                        if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                    }
                    if ( count($liste_colonnes_a_indexer) > 0 )
                    {
                        self::$cache_db->pause('type__index');
                        foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                        {
                            executer_requete_mysql('ALTER TABLE `'.inst('type').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                        }
                        self::$cache_db->clear();
                        self::$cache_db->reprendre('type__index');
                    }
                }

                $liste = array();
                $liste_type_pas_a_jour = array();
                if ($toutes_colonnes)
                {
                    $colonnes='Code_type, type_Libelle, Code_ressource';
                }
                else
                {
                    $colonnes='Code_type, type_Libelle, Code_ressource';
                }
                $res_requete = executer_requete_mysql("SELECT $colonnes FROM ".inst('type')." WHERE 1{$argument_cond}".( $Code_ressource!=0 ? " AND Code_ressource=$Code_ressource" : "" )."{$argument_tris}{$argument_limit};", false);
                while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
                {
                    mf_formatage_db_type_php($row_requete);
                    $liste[$row_requete['Code_type']] = $row_requete;
                    if ( $maj && ! Hook_type::est_a_jour( $row_requete ) )
                    {
                        $liste_type_pas_a_jour[$row_requete['Code_type']] = $row_requete;
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
                Hook_type::mettre_a_jour( $liste_type_pas_a_jour );
            }
        }

        foreach ($liste as $elem)
        {
            if ( $controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_type', $elem['Code_type']) )
            {
                unset($liste[$elem['Code_type']]);
            }
            else
            {
                if (!self::$auto_completion && $autocompletion)
                {
                    self::$auto_completion = true;
                    Hook_type::completion($liste[$elem['Code_type']]);
                    self::$auto_completion = false;
                }
            }
        }

        return $liste;
    }

    public function mf_lister_2(array $liste_Code_type, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        if ( count($liste_Code_type)>0 )
        {
            $cle = "type__mf_lister_2_".Sql_Format_Liste($liste_Code_type);

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
                if ( isset($mf_tri_defaut_table['type']) )
                {
                    $options['tris'] = $mf_tri_defaut_table['type'];
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
                        if ( strpos($argument_cond, 'type_Libelle')!==false ) { $liste_colonnes_a_indexer['type_Libelle'] = 'type_Libelle'; }
                    }
                    if ( isset($options['tris']) )
                    {
                        if ( isset($options['tris']['type_Libelle']) ) { $liste_colonnes_a_indexer['type_Libelle'] = 'type_Libelle'; }
                    }
                    if ( count($liste_colonnes_a_indexer)>0 )
                    {
                        if ( ! $mf_liste_requete_index = self::$cache_db->read('type__index') )
                        {
                            $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('type').'`;', false);
                            $mf_liste_requete_index = array();
                            while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                            {
                                $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                            }
                            mysqli_free_result($res_requete_index);
                            self::$cache_db->write('type__index', $mf_liste_requete_index);
                        }
                        foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                        {
                            if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                        }
                        if ( count($liste_colonnes_a_indexer) > 0 )
                        {
                            self::$cache_db->pause('type__index');
                            foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                            {
                                executer_requete_mysql('ALTER TABLE `'.inst('type').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                            }
                            self::$cache_db->clear();
                            self::$cache_db->reprendre('type__index');
                        }
                    }

                    $liste = array();
                    $liste_type_pas_a_jour = array();
                    if ($toutes_colonnes)
                    {
                        $colonnes='Code_type, type_Libelle, Code_ressource';
                    }
                    else
                    {
                        $colonnes='Code_type, type_Libelle, Code_ressource';
                    }
                    $res_requete = executer_requete_mysql("SELECT $colonnes FROM ".inst('type')." WHERE 1{$argument_cond} AND Code_type IN ".Sql_Format_Liste($liste_Code_type)."{$argument_tris}{$argument_limit};", false);
                    while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
                    {
                        mf_formatage_db_type_php($row_requete);
                        $liste[$row_requete['Code_type']] = $row_requete;
                        if ( $maj && ! Hook_type::est_a_jour( $row_requete ) )
                        {
                            $liste_type_pas_a_jour[$row_requete['Code_type']] = $row_requete;
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
                    Hook_type::mettre_a_jour( $liste_type_pas_a_jour );
                }
            }

            foreach ($liste as $elem)
            {
                if ( $controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_type', $elem['Code_type']) )
                {
                    unset($liste[$elem['Code_type']]);
                }
                else
                {
                    if (!self::$auto_completion && $autocompletion)
                    {
                        self::$auto_completion = true;
                        Hook_type::completion($liste[$elem['Code_type']]);
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

    public function mf_get(int $Code_type, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $Code_type = round($Code_type);
        $retour = array();
        if ( ! CONTROLE_ACCES_DONNEES_DEFAUT || Hook_mf_systeme::controle_acces_donnees('Code_type', $Code_type) )
        {
            $cle = 'type__get_'.$Code_type;

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
                        $colonnes='Code_type, type_Libelle, Code_ressource';
                    }
                    else
                    {
                        $colonnes='Code_type, type_Libelle, Code_ressource';
                    }
                    $res_requete = executer_requete_mysql('SELECT ' . $colonnes . ' FROM ' . inst('type') . ' WHERE Code_type = ' . $Code_type . ';', false);
                    if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
                    {
                        mf_formatage_db_type_php($row_requete);
                        $retour = $row_requete;
                        if ( $maj && ! Hook_type::est_a_jour( $row_requete ) )
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
                    Hook_type::mettre_a_jour( array( $row_requete['Code_type'] => $row_requete ) );
                }
            }
            if ( isset( $retour['Code_type'] ) )
            {
                if (!self::$auto_completion && $autocompletion)
                {
                    self::$auto_completion = true;
                    Hook_type::completion($retour);
                    self::$auto_completion = false;
                }
            }
        }
        return $retour;
    }

    public function mf_get_last(?int $Code_ressource=null, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cle = "type__get_last";
        $Code_ressource = round($Code_ressource);
        $cle.='_' . $Code_ressource;
        if ( ! $retour = self::$cache_db->read($cle) )
        {
            $Code_type = 0;
            $res_requete = executer_requete_mysql('SELECT Code_type FROM ' . inst('type') . " WHERE 1".( $Code_ressource!=0 ? " AND Code_ressource=$Code_ressource" : "" )." ORDER BY mf_date_creation DESC, Code_type DESC LIMIT 0 , 1;", false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $Code_type = $row_requete['Code_type'];
            }
            mysqli_free_result($res_requete);
            $retour = $this->mf_get($Code_type, $options);
            self::$cache_db->write($cle, $retour);
        }
        return $retour;
    }

    public function mf_get_2(int $Code_type, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $Code_type = round($Code_type);
        $retour = array();
        $cle = 'type__get_'.$Code_type;

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
                $colonnes='Code_type, type_Libelle, Code_ressource';
            }
            else
            {
                $colonnes='Code_type, type_Libelle, Code_ressource';
            }
            $res_requete = executer_requete_mysql('SELECT ' . $colonnes . " FROM ".inst('type')." WHERE Code_type = $Code_type;", false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                mf_formatage_db_type_php($row_requete);
                $retour = $row_requete;
            }
            mysqli_free_result($res_requete);
            self::$cache_db->write($cle, $retour);
        }
        if ( isset( $retour['Code_type'] ) )
        {
            if (!self::$auto_completion && $autocompletion)
            {
                self::$auto_completion = true;
                Hook_type::completion($retour);
                self::$auto_completion = false;
            }
        }
        return $retour;
    }

    public function mf_prec_et_suiv( int $Code_type, ?int $Code_ressource=null, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $Code_type = round($Code_type);
        $liste = $this->mf_lister($Code_ressource, $options);
        return prec_suiv($liste, $Code_type);
    }

    public function mf_compter(?int $Code_ressource=null, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cle = 'type__compter';
        $Code_ressource = round($Code_ressource);
        $cle.='_{'.$Code_ressource.'}';

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
                if ( strpos($argument_cond, 'type_Libelle')!==false ) { $liste_colonnes_a_indexer['type_Libelle'] = 'type_Libelle'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = self::$cache_db->read('type__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('type').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    self::$cache_db->write('type__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    self::$cache_db->pause('type__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('type').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    self::$cache_db->clear();
                    self::$cache_db->reprendre('type__index');
                }
            }

            $res_requete = executer_requete_mysql('SELECT count(Code_type) as nb FROM ' . inst('type')." WHERE 1{$argument_cond}".( $Code_ressource!=0 ? " AND Code_ressource=$Code_ressource" : "" ).";", false);
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
        $Code_ressource = isset($interface['Code_ressource']) ? round($interface['Code_ressource']) : 0;
        return $this->mf_compter( $Code_ressource, $options );
    }

    public function mf_liste_Code_type(?int $Code_ressource=null, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ( $options===null ) { $options=[]; }
        return $this->get_liste_Code_type($Code_ressource, $options);
    }

    public function mf_convertir_Code_type_vers_Code_ressource( int $Code_type )
    {
        return $this->Code_type_vers_Code_ressource( $Code_type );
    }

    public function mf_liste_Code_ressource_vers_liste_Code_type( array $liste_Code_ressource, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ( $options===null ) { $options=[]; }
        return $this->liste_Code_ressource_vers_liste_Code_type( $liste_Code_ressource, $options );
    }

    public function mf_liste_Code_type_vers_liste_Code_ressource( array $liste_Code_type, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ( $options===null ) { $options=[]; }
        return $this->type__liste_Code_type_vers_liste_Code_ressource( $liste_Code_type, $options );
    }

    public function mf_get_liste_tables_enfants()
    {
        return $this->get_liste_tables_enfants( 'type' );
    }

    public function mf_get_liste_tables_parents()
    {
        return array('Code_ressource');
    }

    public function mf_search_type_Libelle( string $type_Libelle, ?int $Code_ressource=null )
    {
        return $this->rechercher_type_Libelle( $type_Libelle, $Code_ressource );
    }

    public function mf_search__colonne( string $colonne_db, $recherche, ?int $Code_ressource=null )
    {
        switch ($colonne_db) {
            case 'type_Libelle': return $this->mf_search_type_Libelle( $recherche, $Code_ressource ); break;
        }
    }

    public function mf_get_next_id()
    {
        $res_requete = executer_requete_mysql('SELECT AUTO_INCREMENT as next_id FROM INFORMATION_SCHEMA.TABLES WHERE table_name = \'type\';', false);
        $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC);
        mysqli_free_result($res_requete);
        return round($row_requete['next_id']);
    }

    public function mf_search(array $ligne) // array('colonne1' => 'valeur1',  [...] )
    {
        global $mf_initialisation;
        $Code_ressource = (int)(isset($ligne['Code_ressource'])?round($ligne['Code_ressource']):0);
        $type_Libelle = (string)(isset($ligne['type_Libelle'])?$ligne['type_Libelle']:$mf_initialisation['type_Libelle']);
        Hook_type::pre_controller($type_Libelle, $Code_ressource);
        $mf_cle_unique = Hook_type::calcul_cle_unique($type_Libelle, $Code_ressource);
        $res_requete = executer_requete_mysql('SELECT Code_type FROM ' . inst('type') . ' WHERE mf_cle_unique = \''.$mf_cle_unique.'\'', false);
        if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
        {
            $r = round($row_requete['Code_type']);
        }
        else
        {
            $r = false;
        }
        mysqli_free_result($res_requete);
        return $r;
    }

}
