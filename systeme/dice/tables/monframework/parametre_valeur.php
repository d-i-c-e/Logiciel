<?php

/*
    +------------------------------+
    |  NE PAS MODIFIER CE FICHIER  |
    +------------------------------+
*/

class parametre_valeur_monframework extends entite_monframework
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
            include_once __DIR__ . '/../../erreurs/erreurs__parametre_valeur.php';
            self::$initialisation = false;
            Hook_parametre_valeur::initialisation();
            self::$cache_db = new Mf_Cachedb('parametre_valeur');
        }
        if (!self::$actualisation_en_cours)
        {
            self::$actualisation_en_cours=true;
            Hook_parametre_valeur::actualisation();
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

        if ( ! test_si_table_existe(inst('parametre_valeur')) )
        {
            executer_requete_mysql('CREATE TABLE '.inst('parametre_valeur').'(Code_parametre_valeur INT AUTO_INCREMENT NOT NULL, PRIMARY KEY (Code_parametre_valeur)) ENGINE=MyISAM;', true);
        }

        $liste_colonnes = lister_les_colonnes(inst('parametre_valeur'));

        if ( isset($liste_colonnes['parametre_valeur_Libelle']) )
        {
            if ( typeMyql2Sql($liste_colonnes['parametre_valeur_Libelle']['Type'])!='VARCHAR' )
            {
                executer_requete_mysql('ALTER TABLE '.inst('parametre_valeur').' CHANGE parametre_valeur_Libelle parametre_valeur_Libelle VARCHAR(255);', true);
            }
            unset($liste_colonnes['parametre_valeur_Libelle']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('parametre_valeur').' ADD parametre_valeur_Libelle VARCHAR(255);', true);
            executer_requete_mysql('UPDATE '.inst('parametre_valeur').' SET parametre_valeur_Libelle=' . format_sql('parametre_valeur_Libelle', $mf_initialisation['parametre_valeur_Libelle']) . ';', true);
        }

        if ( isset($liste_colonnes['Code_parametre']) )
        {
            unset($liste_colonnes['Code_parametre']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('parametre_valeur').' ADD Code_parametre int NOT NULL;', true);
        }

        if ( isset($liste_colonnes['mf_signature']) )
        {
            unset($liste_colonnes['mf_signature']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('parametre_valeur').' ADD mf_signature VARCHAR(255);', true);
            executer_requete_mysql('ALTER TABLE '.inst('parametre_valeur').' ADD INDEX( mf_signature );', true);
        }

        if ( isset($liste_colonnes['mf_cle_unique']) )
        {
            unset($liste_colonnes['mf_cle_unique']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('parametre_valeur').' ADD mf_cle_unique VARCHAR(255);', true);
            executer_requete_mysql('ALTER TABLE '.inst('parametre_valeur').' ADD INDEX( mf_cle_unique );', true);
        }

        if ( isset($liste_colonnes['mf_date_creation']) )
        {
            unset($liste_colonnes['mf_date_creation']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('parametre_valeur').' ADD mf_date_creation DATETIME;', true);
            executer_requete_mysql('ALTER TABLE '.inst('parametre_valeur').' ADD INDEX( mf_date_creation );', true);
        }

        if ( isset($liste_colonnes['mf_date_modification']) )
        {
            unset($liste_colonnes['mf_date_modification']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('parametre_valeur').' ADD mf_date_modification DATETIME;', true);
            executer_requete_mysql('ALTER TABLE '.inst('parametre_valeur').' ADD INDEX( mf_date_modification );', true);
        }

        unset($liste_colonnes['Code_parametre_valeur']);

        foreach ($liste_colonnes as $field => $value)
        {
            executer_requete_mysql('ALTER TABLE '.inst('parametre_valeur').' DROP COLUMN '.$field.';', true);
        }

    }

    public function mf_ajouter(string $parametre_valeur_Libelle, int $Code_parametre, ?bool $force=false)
    {
        if ( $force===null ) { $force=false; }
        $Code_parametre_valeur = 0;
        $code_erreur = 0;
        $Code_parametre = round($Code_parametre);
        Hook_parametre_valeur::pre_controller($parametre_valeur_Libelle, $Code_parametre);
        if (!$force)
        {
            if (!self::$maj_droits_ajouter_en_cours)
            {
                self::$maj_droits_ajouter_en_cours = true;
                Hook_parametre_valeur::hook_actualiser_les_droits_ajouter($Code_parametre);
                self::$maj_droits_ajouter_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['parametre_valeur__AJOUTER']) ) $code_erreur = REFUS_PARAMETRE_VALEUR__AJOUTER;
        elseif ( !$this->mf_tester_existance_Code_parametre($Code_parametre) ) $code_erreur = ERR_PARAMETRE_VALEUR__AJOUTER__CODE_PARAMETRE_INEXISTANT;
        elseif ( CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_parametre', $Code_parametre) ) $code_erreur = ACCES_CODE_PARAMETRE_REFUSE;
        elseif ( !Hook_parametre_valeur::autorisation_ajout($parametre_valeur_Libelle, $Code_parametre) ) $code_erreur = REFUS_PARAMETRE_VALEUR__AJOUT_BLOQUEE;
        else
        {
            Hook_parametre_valeur::data_controller($parametre_valeur_Libelle, $Code_parametre);
            $mf_signature = text_sql(Hook_parametre_valeur::calcul_signature($parametre_valeur_Libelle, $Code_parametre));
            $mf_cle_unique = text_sql(Hook_parametre_valeur::calcul_cle_unique($parametre_valeur_Libelle, $Code_parametre));
            $parametre_valeur_Libelle = text_sql($parametre_valeur_Libelle);
            $requete = "INSERT INTO ".inst('parametre_valeur')." ( mf_signature, mf_cle_unique, mf_date_creation, mf_date_modification, parametre_valeur_Libelle, Code_parametre ) VALUES ( '$mf_signature', '$mf_cle_unique', '".get_now()."', '".get_now()."', '$parametre_valeur_Libelle', $Code_parametre );";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql($requete, true);
            $Code_parametre_valeur = requete_mysql_insert_id();
            if ($Code_parametre_valeur==0)
            {
                $code_erreur = ERR_PARAMETRE_VALEUR__AJOUTER__AJOUT_REFUSE;
                self::$cache_db->reprendre($cle);
            }
            else
            {
                self::$cache_db->clear();
                self::$cache_db->reprendre($cle);
                Hook_parametre_valeur::ajouter( $Code_parametre_valeur );
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
        return array('code_erreur' => $code_erreur, 'Code_parametre_valeur' => $Code_parametre_valeur, 'callback' => ( $code_erreur==0 ? Hook_parametre_valeur::callback_post($Code_parametre_valeur) : null ));
    }

    public function mf_creer(int $Code_parametre, ?bool $force=null)
    {
        if ( $force===null ) { $force=false; }
        global $mf_initialisation, $mf_droits_defaut;
        $mf_droits_defaut["parametre_valeur__AJOUTER"] = $mf_droits_defaut["parametre_valeur__CREER"];
        $parametre_valeur_Libelle = $mf_initialisation['parametre_valeur_Libelle'];
        return $this->mf_ajouter($parametre_valeur_Libelle, $Code_parametre, $force);
    }

    public function mf_ajouter_2(array $ligne, bool $force=null) // array('colonne1' => 'valeur1',  [...] )
    {
        if ( $force===null ) { $force=false; }
        global $mf_initialisation;
        $Code_parametre = (int)(isset($ligne['Code_parametre'])?round($ligne['Code_parametre']):0);
        $parametre_valeur_Libelle = (string)(isset($ligne['parametre_valeur_Libelle'])?$ligne['parametre_valeur_Libelle']:$mf_initialisation['parametre_valeur_Libelle']);
        return $this->mf_ajouter($parametre_valeur_Libelle, $Code_parametre, $force);
    }

    public function mf_ajouter_3(array $lignes) // array( array( 'colonne1' => 'valeur1', 'colonne2' => 'valeur2',  [...] ), [...] )
    {
        global $mf_initialisation;
        $code_erreur = 0;
        $values = '';
        foreach ($lignes as $ligne)
        {
            $Code_parametre = (int)(isset($ligne['Code_parametre'])?round($ligne['Code_parametre']):0);
            $parametre_valeur_Libelle = text_sql(isset($ligne['parametre_valeur_Libelle'])?$ligne['parametre_valeur_Libelle']:$mf_initialisation['parametre_valeur_Libelle']);
            if ($Code_parametre != 0)
            {
                $values.=($values!="" ? "," : "")."('$parametre_valeur_Libelle', $Code_parametre)";
            }
        }
        if ($values!='')
        {
            $requete = "INSERT INTO ".inst('parametre_valeur')." ( parametre_valeur_Libelle, Code_parametre ) VALUES $values;";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            $n = requete_mysqli_affected_rows();
            if ($n < count($lignes))
            {
                $code_erreur = ERR_PARAMETRE_VALEUR__AJOUTER_3__ECHEC_AJOUT;
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

    public function mf_modifier( int $Code_parametre_valeur, string $parametre_valeur_Libelle, ?int $Code_parametre=null, ?bool $force=null)
    {
        if ( $force===null ) { $force=false; }
        $code_erreur = 0;
        $Code_parametre_valeur = round($Code_parametre_valeur);
        $Code_parametre = round($Code_parametre);
        Hook_parametre_valeur::pre_controller($parametre_valeur_Libelle, $Code_parametre, $Code_parametre_valeur);
        if (!$force)
        {
            if (!self::$maj_droits_modifier_en_cours)
            {
                self::$maj_droits_modifier_en_cours = true;
                Hook_parametre_valeur::hook_actualiser_les_droits_modifier($Code_parametre_valeur);
                self::$maj_droits_modifier_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['parametre_valeur__MODIFIER']) ) $code_erreur = REFUS_PARAMETRE_VALEUR__MODIFIER;
        elseif ( !$this->mf_tester_existance_Code_parametre_valeur($Code_parametre_valeur) ) $code_erreur = ERR_PARAMETRE_VALEUR__MODIFIER__CODE_PARAMETRE_VALEUR_INEXISTANT;
        elseif ( $Code_parametre!=0 && !$this->mf_tester_existance_Code_parametre($Code_parametre) ) $code_erreur = ERR_PARAMETRE_VALEUR__MODIFIER__CODE_PARAMETRE_INEXISTANT;
        elseif ( CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_parametre_valeur', $Code_parametre_valeur) ) $code_erreur = ACCES_CODE_PARAMETRE_VALEUR_REFUSE;
        elseif ( $Code_parametre!=0 && CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_parametre', $Code_parametre) ) $code_erreur = ACCES_CODE_PARAMETRE_REFUSE;
        elseif ( !Hook_parametre_valeur::autorisation_modification($Code_parametre_valeur, $parametre_valeur_Libelle, $Code_parametre) ) $code_erreur = REFUS_PARAMETRE_VALEUR__MODIFICATION_BLOQUEE;
        else
        {
            Hook_parametre_valeur::data_controller($parametre_valeur_Libelle, $Code_parametre, $Code_parametre_valeur);
            $parametre_valeur = $this->mf_get_2( $Code_parametre_valeur, array('autocompletion' => false, 'masquer_mdp' => false) );
            $mf_colonnes_a_modifier=[];
            $bool__parametre_valeur_Libelle = false; if ( $parametre_valeur_Libelle!=$parametre_valeur['parametre_valeur_Libelle'] ) { Hook_parametre_valeur::data_controller__parametre_valeur_Libelle($parametre_valeur['parametre_valeur_Libelle'], $parametre_valeur_Libelle, $Code_parametre_valeur); if ( $parametre_valeur_Libelle!=$parametre_valeur['parametre_valeur_Libelle'] ) { $mf_colonnes_a_modifier[] = 'parametre_valeur_Libelle=' . format_sql('parametre_valeur_Libelle', $parametre_valeur_Libelle); $bool__parametre_valeur_Libelle = true; } }
            $bool__Code_parametre = false; if ( $Code_parametre!=0 && $Code_parametre!=$parametre_valeur['Code_parametre'] ) { Hook_parametre_valeur::data_controller__Code_parametre($parametre_valeur['Code_parametre'], $Code_parametre, $Code_parametre_valeur); if ( $Code_parametre!=0 && $Code_parametre!=$parametre_valeur['Code_parametre'] ) { $mf_colonnes_a_modifier[] = 'Code_parametre=' . $Code_parametre; $bool__Code_parametre = true; } }
            if (count($mf_colonnes_a_modifier)>0) {
                $mf_signature = text_sql(Hook_parametre_valeur::calcul_signature($parametre_valeur_Libelle, $Code_parametre));
                $mf_cle_unique = text_sql(Hook_parametre_valeur::calcul_cle_unique($parametre_valeur_Libelle, $Code_parametre));
                $mf_colonnes_a_modifier[] = 'mf_signature=\'' . $mf_signature . '\'';
                $mf_colonnes_a_modifier[] = 'mf_cle_unique=\'' . $mf_cle_unique . '\'';
                $mf_colonnes_a_modifier[] = 'mf_date_modification=\'' . get_now() . '\'';
                $requete = 'UPDATE '.inst('parametre_valeur').' SET ' . enumeration($mf_colonnes_a_modifier) . ' WHERE Code_parametre_valeur = ' . $Code_parametre_valeur . ';';
                $cle = md5($requete).salt(10);
                self::$cache_db->pause($cle);
                executer_requete_mysql( $requete , true);
                if ( requete_mysqli_affected_rows()==0 )
                {
                    $code_erreur = ERR_PARAMETRE_VALEUR__MODIFIER__AUCUN_CHANGEMENT;
                    self::$cache_db->reprendre($cle);
                }
                else
                {
                    self::$cache_db->clear();
                    self::$cache_db->reprendre($cle);
                    Hook_parametre_valeur::modifier($Code_parametre_valeur, $bool__parametre_valeur_Libelle, $bool__Code_parametre);
                }
            }
            else
            {
                $code_erreur = ERR_PARAMETRE_VALEUR__MODIFIER__AUCUN_CHANGEMENT;
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
        return array('code_erreur' => $code_erreur, 'callback' => ( $code_erreur == 0 ? Hook_parametre_valeur::callback_put($Code_parametre_valeur) : null ));
    }

    public function mf_modifier_2(array $lignes, ?bool $force=null) // array( $Code_parametre_valeur => array('colonne1' => 'valeur1',  [...] ) )
    {
        if ( $force===null ) { $force=false; }
        $code_erreur = 0;
        foreach ( $lignes as $Code_parametre_valeur => $colonnes )
        {
            if ( $code_erreur==0 )
            {
                $Code_parametre_valeur = (int)round($Code_parametre_valeur);
                $parametre_valeur = $this->mf_get_2($Code_parametre_valeur, array('autocompletion' => false));
                if (!$force)
                {
                    if (!self::$maj_droits_modifier_en_cours)
                    {
                        self::$maj_droits_modifier_en_cours = true;
                        Hook_parametre_valeur::hook_actualiser_les_droits_modifier($Code_parametre_valeur);
                        self::$maj_droits_modifier_en_cours = false;
                    }
                }
                $Code_parametre = ( isset($colonnes['Code_parametre']) && ( $force || mf_matrice_droits(['api_modifier_ref__parametre_valeur__Code_parametre', 'parametre_valeur__MODIFIER']) ) ? $colonnes['Code_parametre'] : (isset($parametre_valeur['Code_parametre']) ? $parametre_valeur['Code_parametre'] : 0 ));
                $parametre_valeur_Libelle = (string)( isset($colonnes['parametre_valeur_Libelle']) && ( $force || mf_matrice_droits(['api_modifier__parametre_valeur_Libelle', 'parametre_valeur__MODIFIER']) ) ? $colonnes['parametre_valeur_Libelle'] : ( isset($parametre_valeur['parametre_valeur_Libelle']) ? $parametre_valeur['parametre_valeur_Libelle'] : '' ) );
                $retour = $this->mf_modifier($Code_parametre_valeur, $parametre_valeur_Libelle, $Code_parametre, true);
                if ( $retour['code_erreur']!=0 && $retour['code_erreur'] != ERR_PARAMETRE_VALEUR__MODIFIER__AUCUN_CHANGEMENT )
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

    public function mf_modifier_3(array $lignes) // array( $Code_parametre_valeur => array('colonne1' => 'valeur1',  [...] ) )
    {
        $code_erreur = 0;
        $modifs = false;

        // transformation des lignes en colonnes
        $valeurs_en_colonnes=array();
        $indices_par_colonne=array();
        $liste_valeurs_indexees=array();
        foreach ( $lignes as $Code_parametre_valeur => $colonnes )
        {
            foreach ($colonnes as $colonne => $valeur)
            {
                if ( $colonne=='parametre_valeur_Libelle' || $colonne=='Code_parametre' )
                {
                    $valeurs_en_colonnes[$colonne][$Code_parametre_valeur]=$valeur;
                    $indices_par_colonne[$colonne][]=$Code_parametre_valeur;
                    $liste_valeurs_indexees[$colonne][''.$valeur][]=$Code_parametre_valeur;
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
                $modification_sql = $colonne . ' = CASE Code_parametre_valeur';
                foreach ( $valeurs as $Code_parametre_valeur => $valeur )
                {
                    $modification_sql.=' WHEN ' . $Code_parametre_valeur . ' THEN ' . format_sql($colonne, $valeur);
                }
                $modification_sql.=' END';
                $perimetre = Sql_Format_Liste($indices_par_colonne[$colonne]);
                executer_requete_mysql('UPDATE ' . inst('parametre_valeur') . ' SET ' . $modification_sql . ' WHERE Code_parametre_valeur IN ' . $perimetre . ';', true);
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
                    executer_requete_mysql('UPDATE ' . inst('parametre_valeur') . ' SET ' . $colonne . ' = ' . format_sql($colonne, $valeur) . ' WHERE Code_parametre_valeur IN ' . $perimetre . ';', true);
                    if ( requete_mysqli_affected_rows()!=0 )
                    {
                        $modifs = true;
                    }
                }
            }
        }

        if ( ! $modifs && $code_erreur==0 )
        {
            $code_erreur = ERR_PARAMETRE_VALEUR__MODIFIER_3__AUCUN_CHANGEMENT;
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

    public function mf_modifier_4( int $Code_parametre, array $data, ?array $options = null /* $options = array( 'cond_mysql' => array(), 'limit' => 0 ) */ ) // $data = array('colonne1' => 'valeur1', ... )
    {
        if ( $options===null ) { $force=[]; }
        $code_erreur = 0;
        $Code_parametre = round($Code_parametre);
        $mf_colonnes_a_modifier=[];
        if ( isset($data['parametre_valeur_Libelle']) ) { $mf_colonnes_a_modifier[] = 'parametre_valeur_Libelle = ' . format_sql('parametre_valeur_Libelle', $data['parametre_valeur_Libelle']); }
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

            $requete = 'UPDATE ' . inst('parametre_valeur') . ' SET ' . enumeration($mf_colonnes_a_modifier) . " WHERE 1".( $Code_parametre!=0 ? " AND Code_parametre=$Code_parametre" : "" )."$argument_cond" . ( $limit>0 ? ' LIMIT ' . $limit : '' ) . ";";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_PARAMETRE_VALEUR__MODIFIER_4__AUCUN_CHANGEMENT;
            }
            else
            {
                self::$cache_db->clear();
            }
            self::$cache_db->reprendre($cle);
        }
        return array('code_erreur' => $code_erreur);
    }

    public function mf_supprimer( int $Code_parametre_valeur, ?bool $force=null )
    {
        if ( $force===null ) { $force=false; }
        $code_erreur = 0;
        $Code_parametre_valeur = round($Code_parametre_valeur);
        if (!$force)
        {
            if (!self::$maj_droits_supprimer_en_cours)
            {
                self::$maj_droits_supprimer_en_cours = true;
                Hook_parametre_valeur::hook_actualiser_les_droits_supprimer($Code_parametre_valeur);
                self::$maj_droits_supprimer_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['parametre_valeur__SUPPRIMER']) ) $code_erreur = REFUS_PARAMETRE_VALEUR__SUPPRIMER;
        elseif ( !$this->mf_tester_existance_Code_parametre_valeur($Code_parametre_valeur) ) $code_erreur = ERR_PARAMETRE_VALEUR__SUPPRIMER_2__CODE_PARAMETRE_VALEUR_INEXISTANT;
        elseif ( CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_parametre_valeur', $Code_parametre_valeur) ) $code_erreur = ACCES_CODE_PARAMETRE_VALEUR_REFUSE;
        elseif ( !Hook_parametre_valeur::autorisation_suppression($Code_parametre_valeur) ) $code_erreur = REFUS_PARAMETRE_VALEUR__SUPPRESSION_BLOQUEE;
        else
        {
            $copie__parametre_valeur = $this->mf_get($Code_parametre_valeur, array('autocompletion' => false));
            $this->supprimer_donnes_en_cascade("parametre_valeur", array($Code_parametre_valeur));
            $requete = "DELETE IGNORE FROM ".inst('parametre_valeur')." WHERE Code_parametre_valeur=$Code_parametre_valeur;";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_PARAMETRE_VALEUR__SUPPRIMER__REFUSEE;
                self::$cache_db->reprendre($cle);
            }
            else
            {
                self::$cache_db->clear();
                self::$cache_db->reprendre($cle);
                Hook_parametre_valeur::supprimer($copie__parametre_valeur);
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

    public function mf_supprimer_2(array $liste_Code_parametre_valeur, ?bool $force=null)
    {
        if ( $force===null ) { $force=false; }
        $code_erreur=0;
        $copie__liste_parametre_valeur = $this->mf_lister_2($liste_Code_parametre_valeur, array('autocompletion' => false));
        $liste_Code_parametre_valeur=array();
        foreach ( $copie__liste_parametre_valeur as $copie__parametre_valeur )
        {
            $Code_parametre_valeur = $copie__parametre_valeur['Code_parametre_valeur'];
            if (!$force)
            {
                if (!self::$maj_droits_supprimer_en_cours)
                {
                    self::$maj_droits_supprimer_en_cours = true;
                    Hook_parametre_valeur::hook_actualiser_les_droits_supprimer($Code_parametre_valeur);
                    self::$maj_droits_supprimer_en_cours = false;
                }
            }
            if ( !$force && !mf_matrice_droits(['parametre_valeur__SUPPRIMER']) ) $code_erreur = REFUS_PARAMETRE_VALEUR__SUPPRIMER;
            elseif ( !Hook_parametre_valeur::autorisation_suppression($Code_parametre_valeur) ) $code_erreur = REFUS_PARAMETRE_VALEUR__SUPPRESSION_BLOQUEE;
            {
                $liste_Code_parametre_valeur[] = $Code_parametre_valeur;
            }
        }
        if ( $code_erreur==0 && count($liste_Code_parametre_valeur)>0 )
        {
            $this->supprimer_donnes_en_cascade("parametre_valeur", $liste_Code_parametre_valeur);
            $requete = "DELETE IGNORE FROM ".inst('parametre_valeur')." WHERE Code_parametre_valeur IN ".Sql_Format_Liste($liste_Code_parametre_valeur).";";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_PARAMETRE_VALEUR__SUPPRIMER_2__REFUSEE;
                self::$cache_db->reprendre($cle);
            }
            else
            {
                self::$cache_db->clear();
                self::$cache_db->reprendre($cle);
                Hook_parametre_valeur::supprimer_2($copie__liste_parametre_valeur);
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

    public function mf_supprimer_3(array $liste_Code_parametre_valeur)
    {
        $code_erreur=0;
        if ( count($liste_Code_parametre_valeur)>0 )
        {
            $this->supprimer_donnes_en_cascade("parametre_valeur", $liste_Code_parametre_valeur);
            $requete = "DELETE IGNORE FROM ".inst('parametre_valeur')." WHERE Code_parametre_valeur IN ".Sql_Format_Liste($liste_Code_parametre_valeur).";";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_PARAMETRE_VALEUR__SUPPRIMER_3__REFUSEE;
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
        if ( ! $contexte_parent && $mf_contexte['Code_parametre_valeur']!=0 )
        {
            $parametre_valeur = $this->mf_get( $mf_contexte['Code_parametre_valeur'], $options);
            return array( $parametre_valeur['Code_parametre_valeur'] => $parametre_valeur );
        }
        else
        {
            return $this->mf_lister(isset($est_charge['parametre']) ? $mf_contexte['Code_parametre'] : 0, $options);
        }
    }

    public function mf_lister(?int $Code_parametre=null, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cle = "parametre_valeur__lister";
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

        // tris
        $argument_tris = '';
        if ( ! isset($options['tris']) )
        {
            $options['tris']=array();
        }
        if ( count($options['tris'])==0 )
        {
            global $mf_tri_defaut_table;
            if ( isset($mf_tri_defaut_table['parametre_valeur']) )
            {
                $options['tris'] = $mf_tri_defaut_table['parametre_valeur'];
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
                    if ( strpos($argument_cond, 'parametre_valeur_Libelle')!==false ) { $liste_colonnes_a_indexer['parametre_valeur_Libelle'] = 'parametre_valeur_Libelle'; }
                }
                if ( isset($options['tris']) )
                {
                    if ( isset($options['tris']['parametre_valeur_Libelle']) ) { $liste_colonnes_a_indexer['parametre_valeur_Libelle'] = 'parametre_valeur_Libelle'; }
                }
                if ( count($liste_colonnes_a_indexer)>0 )
                {
                    if ( ! $mf_liste_requete_index = self::$cache_db->read('parametre_valeur__index') )
                    {
                        $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('parametre_valeur').'`;', false);
                        $mf_liste_requete_index = array();
                        while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                        {
                            $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                        }
                        mysqli_free_result($res_requete_index);
                        self::$cache_db->write('parametre_valeur__index', $mf_liste_requete_index);
                    }
                    foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                    {
                        if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                    }
                    if ( count($liste_colonnes_a_indexer) > 0 )
                    {
                        self::$cache_db->pause('parametre_valeur__index');
                        foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                        {
                            executer_requete_mysql('ALTER TABLE `'.inst('parametre_valeur').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                        }
                        self::$cache_db->clear();
                        self::$cache_db->reprendre('parametre_valeur__index');
                    }
                }

                $liste = array();
                $liste_parametre_valeur_pas_a_jour = array();
                if ($toutes_colonnes)
                {
                    $colonnes='Code_parametre_valeur, parametre_valeur_Libelle, Code_parametre';
                }
                else
                {
                    $colonnes='Code_parametre_valeur, parametre_valeur_Libelle, Code_parametre';
                }
                $res_requete = executer_requete_mysql("SELECT $colonnes FROM ".inst('parametre_valeur')." WHERE 1{$argument_cond}".( $Code_parametre!=0 ? " AND Code_parametre=$Code_parametre" : "" )."{$argument_tris}{$argument_limit};", false);
                while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
                {
                    mf_formatage_db_type_php($row_requete);
                    $liste[$row_requete['Code_parametre_valeur']] = $row_requete;
                    if ( $maj && ! Hook_parametre_valeur::est_a_jour( $row_requete ) )
                    {
                        $liste_parametre_valeur_pas_a_jour[$row_requete['Code_parametre_valeur']] = $row_requete;
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
                Hook_parametre_valeur::mettre_a_jour( $liste_parametre_valeur_pas_a_jour );
            }
        }

        foreach ($liste as $elem)
        {
            if ( $controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_parametre_valeur', $elem['Code_parametre_valeur']) )
            {
                unset($liste[$elem['Code_parametre_valeur']]);
            }
            else
            {
                if (!self::$auto_completion && $autocompletion)
                {
                    self::$auto_completion = true;
                    Hook_parametre_valeur::completion($liste[$elem['Code_parametre_valeur']]);
                    self::$auto_completion = false;
                }
            }
        }

        return $liste;
    }

    public function mf_lister_2(array $liste_Code_parametre_valeur, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        if ( count($liste_Code_parametre_valeur)>0 )
        {
            $cle = "parametre_valeur__mf_lister_2_".Sql_Format_Liste($liste_Code_parametre_valeur);

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
                if ( isset($mf_tri_defaut_table['parametre_valeur']) )
                {
                    $options['tris'] = $mf_tri_defaut_table['parametre_valeur'];
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
                        if ( strpos($argument_cond, 'parametre_valeur_Libelle')!==false ) { $liste_colonnes_a_indexer['parametre_valeur_Libelle'] = 'parametre_valeur_Libelle'; }
                    }
                    if ( isset($options['tris']) )
                    {
                        if ( isset($options['tris']['parametre_valeur_Libelle']) ) { $liste_colonnes_a_indexer['parametre_valeur_Libelle'] = 'parametre_valeur_Libelle'; }
                    }
                    if ( count($liste_colonnes_a_indexer)>0 )
                    {
                        if ( ! $mf_liste_requete_index = self::$cache_db->read('parametre_valeur__index') )
                        {
                            $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('parametre_valeur').'`;', false);
                            $mf_liste_requete_index = array();
                            while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                            {
                                $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                            }
                            mysqli_free_result($res_requete_index);
                            self::$cache_db->write('parametre_valeur__index', $mf_liste_requete_index);
                        }
                        foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                        {
                            if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                        }
                        if ( count($liste_colonnes_a_indexer) > 0 )
                        {
                            self::$cache_db->pause('parametre_valeur__index');
                            foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                            {
                                executer_requete_mysql('ALTER TABLE `'.inst('parametre_valeur').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                            }
                            self::$cache_db->clear();
                            self::$cache_db->reprendre('parametre_valeur__index');
                        }
                    }

                    $liste = array();
                    $liste_parametre_valeur_pas_a_jour = array();
                    if ($toutes_colonnes)
                    {
                        $colonnes='Code_parametre_valeur, parametre_valeur_Libelle, Code_parametre';
                    }
                    else
                    {
                        $colonnes='Code_parametre_valeur, parametre_valeur_Libelle, Code_parametre';
                    }
                    $res_requete = executer_requete_mysql("SELECT $colonnes FROM ".inst('parametre_valeur')." WHERE 1{$argument_cond} AND Code_parametre_valeur IN ".Sql_Format_Liste($liste_Code_parametre_valeur)."{$argument_tris}{$argument_limit};", false);
                    while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
                    {
                        mf_formatage_db_type_php($row_requete);
                        $liste[$row_requete['Code_parametre_valeur']] = $row_requete;
                        if ( $maj && ! Hook_parametre_valeur::est_a_jour( $row_requete ) )
                        {
                            $liste_parametre_valeur_pas_a_jour[$row_requete['Code_parametre_valeur']] = $row_requete;
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
                    Hook_parametre_valeur::mettre_a_jour( $liste_parametre_valeur_pas_a_jour );
                }
            }

            foreach ($liste as $elem)
            {
                if ( $controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_parametre_valeur', $elem['Code_parametre_valeur']) )
                {
                    unset($liste[$elem['Code_parametre_valeur']]);
                }
                else
                {
                    if (!self::$auto_completion && $autocompletion)
                    {
                        self::$auto_completion = true;
                        Hook_parametre_valeur::completion($liste[$elem['Code_parametre_valeur']]);
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

    public function mf_get(int $Code_parametre_valeur, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $Code_parametre_valeur = round($Code_parametre_valeur);
        $retour = array();
        if ( ! CONTROLE_ACCES_DONNEES_DEFAUT || Hook_mf_systeme::controle_acces_donnees('Code_parametre_valeur', $Code_parametre_valeur) )
        {
            $cle = 'parametre_valeur__get_'.$Code_parametre_valeur;

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
                        $colonnes='Code_parametre_valeur, parametre_valeur_Libelle, Code_parametre';
                    }
                    else
                    {
                        $colonnes='Code_parametre_valeur, parametre_valeur_Libelle, Code_parametre';
                    }
                    $res_requete = executer_requete_mysql('SELECT ' . $colonnes . ' FROM ' . inst('parametre_valeur') . ' WHERE Code_parametre_valeur = ' . $Code_parametre_valeur . ';', false);
                    if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
                    {
                        mf_formatage_db_type_php($row_requete);
                        $retour = $row_requete;
                        if ( $maj && ! Hook_parametre_valeur::est_a_jour( $row_requete ) )
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
                    Hook_parametre_valeur::mettre_a_jour( array( $row_requete['Code_parametre_valeur'] => $row_requete ) );
                }
            }
            if ( isset( $retour['Code_parametre_valeur'] ) )
            {
                if (!self::$auto_completion && $autocompletion)
                {
                    self::$auto_completion = true;
                    Hook_parametre_valeur::completion($retour);
                    self::$auto_completion = false;
                }
            }
        }
        return $retour;
    }

    public function mf_get_last(?int $Code_parametre=null, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cle = "parametre_valeur__get_last";
        $Code_parametre = round($Code_parametre);
        $cle.='_' . $Code_parametre;
        if ( ! $retour = self::$cache_db->read($cle) )
        {
            $Code_parametre_valeur = 0;
            $res_requete = executer_requete_mysql('SELECT Code_parametre_valeur FROM ' . inst('parametre_valeur') . " WHERE 1".( $Code_parametre!=0 ? " AND Code_parametre=$Code_parametre" : "" )." ORDER BY mf_date_creation DESC, Code_parametre_valeur DESC LIMIT 0 , 1;", false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $Code_parametre_valeur = $row_requete['Code_parametre_valeur'];
            }
            mysqli_free_result($res_requete);
            $retour = $this->mf_get($Code_parametre_valeur, $options);
            self::$cache_db->write($cle, $retour);
        }
        return $retour;
    }

    public function mf_get_2(int $Code_parametre_valeur, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $Code_parametre_valeur = round($Code_parametre_valeur);
        $retour = array();
        $cle = 'parametre_valeur__get_'.$Code_parametre_valeur;

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
                $colonnes='Code_parametre_valeur, parametre_valeur_Libelle, Code_parametre';
            }
            else
            {
                $colonnes='Code_parametre_valeur, parametre_valeur_Libelle, Code_parametre';
            }
            $res_requete = executer_requete_mysql('SELECT ' . $colonnes . " FROM ".inst('parametre_valeur')." WHERE Code_parametre_valeur = $Code_parametre_valeur;", false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                mf_formatage_db_type_php($row_requete);
                $retour = $row_requete;
            }
            mysqli_free_result($res_requete);
            self::$cache_db->write($cle, $retour);
        }
        if ( isset( $retour['Code_parametre_valeur'] ) )
        {
            if (!self::$auto_completion && $autocompletion)
            {
                self::$auto_completion = true;
                Hook_parametre_valeur::completion($retour);
                self::$auto_completion = false;
            }
        }
        return $retour;
    }

    public function mf_prec_et_suiv( int $Code_parametre_valeur, ?int $Code_parametre=null, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $Code_parametre_valeur = round($Code_parametre_valeur);
        $liste = $this->mf_lister($Code_parametre, $options);
        return prec_suiv($liste, $Code_parametre_valeur);
    }

    public function mf_compter(?int $Code_parametre=null, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cle = 'parametre_valeur__compter';
        $Code_parametre = round($Code_parametre);
        $cle.='_{'.$Code_parametre.'}';

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
                if ( strpos($argument_cond, 'parametre_valeur_Libelle')!==false ) { $liste_colonnes_a_indexer['parametre_valeur_Libelle'] = 'parametre_valeur_Libelle'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = self::$cache_db->read('parametre_valeur__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('parametre_valeur').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    self::$cache_db->write('parametre_valeur__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    self::$cache_db->pause('parametre_valeur__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('parametre_valeur').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    self::$cache_db->clear();
                    self::$cache_db->reprendre('parametre_valeur__index');
                }
            }

            $res_requete = executer_requete_mysql('SELECT count(Code_parametre_valeur) as nb FROM ' . inst('parametre_valeur')." WHERE 1{$argument_cond}".( $Code_parametre!=0 ? " AND Code_parametre=$Code_parametre" : "" ).";", false);
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
        $Code_parametre = isset($interface['Code_parametre']) ? round($interface['Code_parametre']) : 0;
        return $this->mf_compter( $Code_parametre, $options );
    }

    public function mf_liste_Code_parametre_valeur(?int $Code_parametre=null, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ( $options===null ) { $options=[]; }
        return $this->get_liste_Code_parametre_valeur($Code_parametre, $options);
    }

    public function mf_convertir_Code_parametre_valeur_vers_Code_parametre( int $Code_parametre_valeur )
    {
        return $this->Code_parametre_valeur_vers_Code_parametre( $Code_parametre_valeur );
    }

    public function mf_liste_Code_parametre_vers_liste_Code_parametre_valeur( array $liste_Code_parametre, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ( $options===null ) { $options=[]; }
        return $this->liste_Code_parametre_vers_liste_Code_parametre_valeur( $liste_Code_parametre, $options );
    }

    public function mf_liste_Code_parametre_valeur_vers_liste_Code_parametre( array $liste_Code_parametre_valeur, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ( $options===null ) { $options=[]; }
        return $this->parametre_valeur__liste_Code_parametre_valeur_vers_liste_Code_parametre( $liste_Code_parametre_valeur, $options );
    }

    public function mf_get_liste_tables_enfants()
    {
        return $this->get_liste_tables_enfants( 'parametre_valeur' );
    }

    public function mf_get_liste_tables_parents()
    {
        return array('Code_parametre');
    }

    public function mf_search_parametre_valeur_Libelle( string $parametre_valeur_Libelle, ?int $Code_parametre=null )
    {
        return $this->rechercher_parametre_valeur_Libelle( $parametre_valeur_Libelle, $Code_parametre );
    }

    public function mf_search__colonne( string $colonne_db, $recherche, ?int $Code_parametre=null )
    {
        switch ($colonne_db) {
            case 'parametre_valeur_Libelle': return $this->mf_search_parametre_valeur_Libelle( $recherche, $Code_parametre ); break;
        }
    }

    public function mf_get_next_id()
    {
        $res_requete = executer_requete_mysql('SELECT AUTO_INCREMENT as next_id FROM INFORMATION_SCHEMA.TABLES WHERE table_name = \'parametre_valeur\';', false);
        $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC);
        mysqli_free_result($res_requete);
        return round($row_requete['next_id']);
    }

    public function mf_search(array $ligne) // array('colonne1' => 'valeur1',  [...] )
    {
        global $mf_initialisation;
        $Code_parametre = (int)(isset($ligne['Code_parametre'])?round($ligne['Code_parametre']):0);
        $parametre_valeur_Libelle = (string)(isset($ligne['parametre_valeur_Libelle'])?$ligne['parametre_valeur_Libelle']:$mf_initialisation['parametre_valeur_Libelle']);
        Hook_parametre_valeur::pre_controller($parametre_valeur_Libelle, $Code_parametre);
        $mf_cle_unique = Hook_parametre_valeur::calcul_cle_unique($parametre_valeur_Libelle, $Code_parametre);
        $res_requete = executer_requete_mysql('SELECT Code_parametre_valeur FROM ' . inst('parametre_valeur') . ' WHERE mf_cle_unique = \''.$mf_cle_unique.'\'', false);
        if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
        {
            $r = round($row_requete['Code_parametre_valeur']);
        }
        else
        {
            $r = false;
        }
        mysqli_free_result($res_requete);
        return $r;
    }

}
