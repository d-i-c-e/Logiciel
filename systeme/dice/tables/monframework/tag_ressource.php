<?php

/*
    +------------------------------+
    |  NE PAS MODIFIER CE FICHIER  |
    +------------------------------+
*/

class tag_ressource_monframework extends entite_monframework
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
            include_once __DIR__ . '/../../erreurs/erreurs__tag_ressource.php';
            self::$initialisation = false;
            Hook_tag_ressource::initialisation();
            self::$cache_db = new Mf_Cachedb('tag_ressource');
        }
        if (!self::$actualisation_en_cours)
        {
            self::$actualisation_en_cours=true;
            Hook_tag_ressource::actualisation();
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

        if ( ! test_si_table_existe(inst('tag_ressource')) )
        {
            executer_requete_mysql('CREATE TABLE '.inst('tag_ressource').'(Code_tag_ressource INT AUTO_INCREMENT NOT NULL, PRIMARY KEY (Code_tag_ressource)) ENGINE=MyISAM;', true);
        }

        $liste_colonnes = lister_les_colonnes(inst('tag_ressource'));

        if ( isset($liste_colonnes['tag_ressource_Libelle']) )
        {
            if ( typeMyql2Sql($liste_colonnes['tag_ressource_Libelle']['Type'])!='VARCHAR' )
            {
                executer_requete_mysql('ALTER TABLE '.inst('tag_ressource').' CHANGE tag_ressource_Libelle tag_ressource_Libelle VARCHAR(255);', true);
            }
            unset($liste_colonnes['tag_ressource_Libelle']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('tag_ressource').' ADD tag_ressource_Libelle VARCHAR(255);', true);
            executer_requete_mysql('UPDATE '.inst('tag_ressource').' SET tag_ressource_Libelle=' . format_sql('tag_ressource_Libelle', $mf_initialisation['tag_ressource_Libelle']) . ';', true);
        }

        if ( isset($liste_colonnes['mf_signature']) )
        {
            unset($liste_colonnes['mf_signature']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('tag_ressource').' ADD mf_signature VARCHAR(255);', true);
            executer_requete_mysql('ALTER TABLE '.inst('tag_ressource').' ADD INDEX( mf_signature );', true);
        }

        if ( isset($liste_colonnes['mf_cle_unique']) )
        {
            unset($liste_colonnes['mf_cle_unique']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('tag_ressource').' ADD mf_cle_unique VARCHAR(255);', true);
            executer_requete_mysql('ALTER TABLE '.inst('tag_ressource').' ADD INDEX( mf_cle_unique );', true);
        }

        if ( isset($liste_colonnes['mf_date_creation']) )
        {
            unset($liste_colonnes['mf_date_creation']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('tag_ressource').' ADD mf_date_creation DATETIME;', true);
            executer_requete_mysql('ALTER TABLE '.inst('tag_ressource').' ADD INDEX( mf_date_creation );', true);
        }

        if ( isset($liste_colonnes['mf_date_modification']) )
        {
            unset($liste_colonnes['mf_date_modification']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('tag_ressource').' ADD mf_date_modification DATETIME;', true);
            executer_requete_mysql('ALTER TABLE '.inst('tag_ressource').' ADD INDEX( mf_date_modification );', true);
        }

        unset($liste_colonnes['Code_tag_ressource']);

        foreach ($liste_colonnes as $field => $value)
        {
            executer_requete_mysql('ALTER TABLE '.inst('tag_ressource').' DROP COLUMN '.$field.';', true);
        }

    }

    public function mf_ajouter(string $tag_ressource_Libelle, ?bool $force=false)
    {
        if ( $force===null ) { $force=false; }
        $Code_tag_ressource = 0;
        $code_erreur = 0;
        Hook_tag_ressource::pre_controller($tag_ressource_Libelle);
        if (!$force)
        {
            if (!self::$maj_droits_ajouter_en_cours)
            {
                self::$maj_droits_ajouter_en_cours = true;
                Hook_tag_ressource::hook_actualiser_les_droits_ajouter();
                self::$maj_droits_ajouter_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['tag_ressource__AJOUTER']) ) $code_erreur = REFUS_TAG_RESSOURCE__AJOUTER;
        elseif ( !Hook_tag_ressource::autorisation_ajout($tag_ressource_Libelle) ) $code_erreur = REFUS_TAG_RESSOURCE__AJOUT_BLOQUEE;
        else
        {
            Hook_tag_ressource::data_controller($tag_ressource_Libelle);
            $mf_signature = text_sql(Hook_tag_ressource::calcul_signature($tag_ressource_Libelle));
            $mf_cle_unique = text_sql(Hook_tag_ressource::calcul_cle_unique($tag_ressource_Libelle));
            $tag_ressource_Libelle = text_sql($tag_ressource_Libelle);
            $requete = "INSERT INTO ".inst('tag_ressource')." ( mf_signature, mf_cle_unique, mf_date_creation, mf_date_modification, tag_ressource_Libelle ) VALUES ( '$mf_signature', '$mf_cle_unique', '".get_now()."', '".get_now()."', '$tag_ressource_Libelle' );";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql($requete, true);
            $Code_tag_ressource = requete_mysql_insert_id();
            if ($Code_tag_ressource==0)
            {
                $code_erreur = ERR_TAG_RESSOURCE__AJOUTER__AJOUT_REFUSE;
                self::$cache_db->reprendre($cle);
            }
            else
            {
                self::$cache_db->clear();
                self::$cache_db->reprendre($cle);
                Hook_tag_ressource::ajouter( $Code_tag_ressource );
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
        return array('code_erreur' => $code_erreur, 'Code_tag_ressource' => $Code_tag_ressource, 'callback' => ( $code_erreur==0 ? Hook_tag_ressource::callback_post($Code_tag_ressource) : null ));
    }

    public function mf_creer(?bool $force=null)
    {
        if ( $force===null ) { $force=false; }
        global $mf_initialisation, $mf_droits_defaut;
        $mf_droits_defaut["tag_ressource__AJOUTER"] = $mf_droits_defaut["tag_ressource__CREER"];
        $tag_ressource_Libelle = $mf_initialisation['tag_ressource_Libelle'];
        return $this->mf_ajouter($tag_ressource_Libelle, $force);
    }

    public function mf_ajouter_2(array $ligne, bool $force=null) // array('colonne1' => 'valeur1',  [...] )
    {
        if ( $force===null ) { $force=false; }
        global $mf_initialisation;
        $tag_ressource_Libelle = (string)(isset($ligne['tag_ressource_Libelle'])?$ligne['tag_ressource_Libelle']:$mf_initialisation['tag_ressource_Libelle']);
        return $this->mf_ajouter($tag_ressource_Libelle, $force);
    }

    public function mf_ajouter_3(array $lignes) // array( array( 'colonne1' => 'valeur1', 'colonne2' => 'valeur2',  [...] ), [...] )
    {
        global $mf_initialisation;
        $code_erreur = 0;
        $values = '';
        foreach ($lignes as $ligne)
        {
            $tag_ressource_Libelle = text_sql(isset($ligne['tag_ressource_Libelle'])?$ligne['tag_ressource_Libelle']:$mf_initialisation['tag_ressource_Libelle']);
            $values.=($values!="" ? "," : "")."('$tag_ressource_Libelle')";
        }
        if ($values!='')
        {
            $requete = "INSERT INTO ".inst('tag_ressource')." ( tag_ressource_Libelle ) VALUES $values;";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            $n = requete_mysqli_affected_rows();
            if ($n < count($lignes))
            {
                $code_erreur = ERR_TAG_RESSOURCE__AJOUTER_3__ECHEC_AJOUT;
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

    public function mf_modifier( int $Code_tag_ressource, string $tag_ressource_Libelle, ?bool $force=null)
    {
        if ( $force===null ) { $force=false; }
        $code_erreur = 0;
        $Code_tag_ressource = round($Code_tag_ressource);
        Hook_tag_ressource::pre_controller($tag_ressource_Libelle, $Code_tag_ressource);
        if (!$force)
        {
            if (!self::$maj_droits_modifier_en_cours)
            {
                self::$maj_droits_modifier_en_cours = true;
                Hook_tag_ressource::hook_actualiser_les_droits_modifier($Code_tag_ressource);
                self::$maj_droits_modifier_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['tag_ressource__MODIFIER']) ) $code_erreur = REFUS_TAG_RESSOURCE__MODIFIER;
        elseif ( !$this->mf_tester_existance_Code_tag_ressource($Code_tag_ressource) ) $code_erreur = ERR_TAG_RESSOURCE__MODIFIER__CODE_TAG_RESSOURCE_INEXISTANT;
        elseif ( CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_tag_ressource', $Code_tag_ressource) ) $code_erreur = ACCES_CODE_TAG_RESSOURCE_REFUSE;
        elseif ( !Hook_tag_ressource::autorisation_modification($Code_tag_ressource, $tag_ressource_Libelle) ) $code_erreur = REFUS_TAG_RESSOURCE__MODIFICATION_BLOQUEE;
        else
        {
            Hook_tag_ressource::data_controller($tag_ressource_Libelle, $Code_tag_ressource);
            $tag_ressource = $this->mf_get_2( $Code_tag_ressource, array('autocompletion' => false, 'masquer_mdp' => false) );
            $mf_colonnes_a_modifier=[];
            $bool__tag_ressource_Libelle = false; if ( $tag_ressource_Libelle!=$tag_ressource['tag_ressource_Libelle'] ) { Hook_tag_ressource::data_controller__tag_ressource_Libelle($tag_ressource['tag_ressource_Libelle'], $tag_ressource_Libelle, $Code_tag_ressource); if ( $tag_ressource_Libelle!=$tag_ressource['tag_ressource_Libelle'] ) { $mf_colonnes_a_modifier[] = 'tag_ressource_Libelle=' . format_sql('tag_ressource_Libelle', $tag_ressource_Libelle); $bool__tag_ressource_Libelle = true; } }
            if (count($mf_colonnes_a_modifier)>0) {
                $mf_signature = text_sql(Hook_tag_ressource::calcul_signature($tag_ressource_Libelle));
                $mf_cle_unique = text_sql(Hook_tag_ressource::calcul_cle_unique($tag_ressource_Libelle));
                $mf_colonnes_a_modifier[] = 'mf_signature=\'' . $mf_signature . '\'';
                $mf_colonnes_a_modifier[] = 'mf_cle_unique=\'' . $mf_cle_unique . '\'';
                $mf_colonnes_a_modifier[] = 'mf_date_modification=\'' . get_now() . '\'';
                $requete = 'UPDATE '.inst('tag_ressource').' SET ' . enumeration($mf_colonnes_a_modifier) . ' WHERE Code_tag_ressource = ' . $Code_tag_ressource . ';';
                $cle = md5($requete).salt(10);
                self::$cache_db->pause($cle);
                executer_requete_mysql( $requete , true);
                if ( requete_mysqli_affected_rows()==0 )
                {
                    $code_erreur = ERR_TAG_RESSOURCE__MODIFIER__AUCUN_CHANGEMENT;
                    self::$cache_db->reprendre($cle);
                }
                else
                {
                    self::$cache_db->clear();
                    self::$cache_db->reprendre($cle);
                    Hook_tag_ressource::modifier($Code_tag_ressource, $bool__tag_ressource_Libelle);
                }
            }
            else
            {
                $code_erreur = ERR_TAG_RESSOURCE__MODIFIER__AUCUN_CHANGEMENT;
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
        return array('code_erreur' => $code_erreur, 'callback' => ( $code_erreur == 0 ? Hook_tag_ressource::callback_put($Code_tag_ressource) : null ));
    }

    public function mf_modifier_2(array $lignes, ?bool $force=null) // array( $Code_tag_ressource => array('colonne1' => 'valeur1',  [...] ) )
    {
        if ( $force===null ) { $force=false; }
        $code_erreur = 0;
        foreach ( $lignes as $Code_tag_ressource => $colonnes )
        {
            if ( $code_erreur==0 )
            {
                $Code_tag_ressource = (int)round($Code_tag_ressource);
                $tag_ressource = $this->mf_get_2($Code_tag_ressource, array('autocompletion' => false));
                if (!$force)
                {
                    if (!self::$maj_droits_modifier_en_cours)
                    {
                        self::$maj_droits_modifier_en_cours = true;
                        Hook_tag_ressource::hook_actualiser_les_droits_modifier($Code_tag_ressource);
                        self::$maj_droits_modifier_en_cours = false;
                    }
                }
                $tag_ressource_Libelle = (string)( isset($colonnes['tag_ressource_Libelle']) && ( $force || mf_matrice_droits(['api_modifier__tag_ressource_Libelle', 'tag_ressource__MODIFIER']) ) ? $colonnes['tag_ressource_Libelle'] : ( isset($tag_ressource['tag_ressource_Libelle']) ? $tag_ressource['tag_ressource_Libelle'] : '' ) );
                $retour = $this->mf_modifier($Code_tag_ressource, $tag_ressource_Libelle, true);
                if ( $retour['code_erreur']!=0 && $retour['code_erreur'] != ERR_TAG_RESSOURCE__MODIFIER__AUCUN_CHANGEMENT )
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

    public function mf_modifier_3(array $lignes) // array( $Code_tag_ressource => array('colonne1' => 'valeur1',  [...] ) )
    {
        $code_erreur = 0;
        $modifs = false;

        // transformation des lignes en colonnes
        $valeurs_en_colonnes=array();
        $indices_par_colonne=array();
        $liste_valeurs_indexees=array();
        foreach ( $lignes as $Code_tag_ressource => $colonnes )
        {
            foreach ($colonnes as $colonne => $valeur)
            {
                if ( $colonne=='tag_ressource_Libelle' )
                {
                    $valeurs_en_colonnes[$colonne][$Code_tag_ressource]=$valeur;
                    $indices_par_colonne[$colonne][]=$Code_tag_ressource;
                    $liste_valeurs_indexees[$colonne][''.$valeur][]=$Code_tag_ressource;
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
                $modification_sql = $colonne . ' = CASE Code_tag_ressource';
                foreach ( $valeurs as $Code_tag_ressource => $valeur )
                {
                    $modification_sql.=' WHEN ' . $Code_tag_ressource . ' THEN ' . format_sql($colonne, $valeur);
                }
                $modification_sql.=' END';
                $perimetre = Sql_Format_Liste($indices_par_colonne[$colonne]);
                executer_requete_mysql('UPDATE ' . inst('tag_ressource') . ' SET ' . $modification_sql . ' WHERE Code_tag_ressource IN ' . $perimetre . ';', true);
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
                    executer_requete_mysql('UPDATE ' . inst('tag_ressource') . ' SET ' . $colonne . ' = ' . format_sql($colonne, $valeur) . ' WHERE Code_tag_ressource IN ' . $perimetre . ';', true);
                    if ( requete_mysqli_affected_rows()!=0 )
                    {
                        $modifs = true;
                    }
                }
            }
        }

        if ( ! $modifs && $code_erreur==0 )
        {
            $code_erreur = ERR_TAG_RESSOURCE__MODIFIER_3__AUCUN_CHANGEMENT;
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
        if ( isset($data['tag_ressource_Libelle']) ) { $mf_colonnes_a_modifier[] = 'tag_ressource_Libelle = ' . format_sql('tag_ressource_Libelle', $data['tag_ressource_Libelle']); }
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

            $requete = 'UPDATE ' . inst('tag_ressource') . ' SET ' . enumeration($mf_colonnes_a_modifier) . " WHERE 1$argument_cond" . ( $limit>0 ? ' LIMIT ' . $limit : '' ) . ";";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_TAG_RESSOURCE__MODIFIER_4__AUCUN_CHANGEMENT;
            }
            else
            {
                self::$cache_db->clear();
            }
            self::$cache_db->reprendre($cle);
        }
        return array('code_erreur' => $code_erreur);
    }

    public function mf_supprimer( int $Code_tag_ressource, ?bool $force=null )
    {
        if ( $force===null ) { $force=false; }
        $code_erreur = 0;
        $Code_tag_ressource = round($Code_tag_ressource);
        if (!$force)
        {
            if (!self::$maj_droits_supprimer_en_cours)
            {
                self::$maj_droits_supprimer_en_cours = true;
                Hook_tag_ressource::hook_actualiser_les_droits_supprimer($Code_tag_ressource);
                self::$maj_droits_supprimer_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['tag_ressource__SUPPRIMER']) ) $code_erreur = REFUS_TAG_RESSOURCE__SUPPRIMER;
        elseif ( !$this->mf_tester_existance_Code_tag_ressource($Code_tag_ressource) ) $code_erreur = ERR_TAG_RESSOURCE__SUPPRIMER_2__CODE_TAG_RESSOURCE_INEXISTANT;
        elseif ( CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_tag_ressource', $Code_tag_ressource) ) $code_erreur = ACCES_CODE_TAG_RESSOURCE_REFUSE;
        elseif ( !Hook_tag_ressource::autorisation_suppression($Code_tag_ressource) ) $code_erreur = REFUS_TAG_RESSOURCE__SUPPRESSION_BLOQUEE;
        else
        {
            $copie__tag_ressource = $this->mf_get($Code_tag_ressource, array('autocompletion' => false));
            $this->supprimer_donnes_en_cascade("tag_ressource", array($Code_tag_ressource));
            $requete = "DELETE IGNORE FROM ".inst('tag_ressource')." WHERE Code_tag_ressource=$Code_tag_ressource;";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_TAG_RESSOURCE__SUPPRIMER__REFUSEE;
                self::$cache_db->reprendre($cle);
            }
            else
            {
                self::$cache_db->clear();
                self::$cache_db->reprendre($cle);
                Hook_tag_ressource::supprimer($copie__tag_ressource);
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

    public function mf_supprimer_2(array $liste_Code_tag_ressource, ?bool $force=null)
    {
        if ( $force===null ) { $force=false; }
        $code_erreur=0;
        $copie__liste_tag_ressource = $this->mf_lister_2($liste_Code_tag_ressource, array('autocompletion' => false));
        $liste_Code_tag_ressource=array();
        foreach ( $copie__liste_tag_ressource as $copie__tag_ressource )
        {
            $Code_tag_ressource = $copie__tag_ressource['Code_tag_ressource'];
            if (!$force)
            {
                if (!self::$maj_droits_supprimer_en_cours)
                {
                    self::$maj_droits_supprimer_en_cours = true;
                    Hook_tag_ressource::hook_actualiser_les_droits_supprimer($Code_tag_ressource);
                    self::$maj_droits_supprimer_en_cours = false;
                }
            }
            if ( !$force && !mf_matrice_droits(['tag_ressource__SUPPRIMER']) ) $code_erreur = REFUS_TAG_RESSOURCE__SUPPRIMER;
            elseif ( !Hook_tag_ressource::autorisation_suppression($Code_tag_ressource) ) $code_erreur = REFUS_TAG_RESSOURCE__SUPPRESSION_BLOQUEE;
            {
                $liste_Code_tag_ressource[] = $Code_tag_ressource;
            }
        }
        if ( $code_erreur==0 && count($liste_Code_tag_ressource)>0 )
        {
            $this->supprimer_donnes_en_cascade("tag_ressource", $liste_Code_tag_ressource);
            $requete = "DELETE IGNORE FROM ".inst('tag_ressource')." WHERE Code_tag_ressource IN ".Sql_Format_Liste($liste_Code_tag_ressource).";";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_TAG_RESSOURCE__SUPPRIMER_2__REFUSEE;
                self::$cache_db->reprendre($cle);
            }
            else
            {
                self::$cache_db->clear();
                self::$cache_db->reprendre($cle);
                Hook_tag_ressource::supprimer_2($copie__liste_tag_ressource);
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

    public function mf_supprimer_3(array $liste_Code_tag_ressource)
    {
        $code_erreur=0;
        if ( count($liste_Code_tag_ressource)>0 )
        {
            $this->supprimer_donnes_en_cascade("tag_ressource", $liste_Code_tag_ressource);
            $requete = "DELETE IGNORE FROM ".inst('tag_ressource')." WHERE Code_tag_ressource IN ".Sql_Format_Liste($liste_Code_tag_ressource).";";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_TAG_RESSOURCE__SUPPRIMER_3__REFUSEE;
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
        if ( ! $contexte_parent && $mf_contexte['Code_tag_ressource']!=0 )
        {
            $tag_ressource = $this->mf_get( $mf_contexte['Code_tag_ressource'], $options);
            return array( $tag_ressource['Code_tag_ressource'] => $tag_ressource );
        }
        else
        {
            return $this->mf_lister($options);
        }
    }

    public function mf_lister(?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cle = "tag_ressource__lister";

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
            if ( isset($mf_tri_defaut_table['tag_ressource']) )
            {
                $options['tris'] = $mf_tri_defaut_table['tag_ressource'];
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
                    if ( strpos($argument_cond, 'tag_ressource_Libelle')!==false ) { $liste_colonnes_a_indexer['tag_ressource_Libelle'] = 'tag_ressource_Libelle'; }
                }
                if ( isset($options['tris']) )
                {
                    if ( isset($options['tris']['tag_ressource_Libelle']) ) { $liste_colonnes_a_indexer['tag_ressource_Libelle'] = 'tag_ressource_Libelle'; }
                }
                if ( count($liste_colonnes_a_indexer)>0 )
                {
                    if ( ! $mf_liste_requete_index = self::$cache_db->read('tag_ressource__index') )
                    {
                        $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('tag_ressource').'`;', false);
                        $mf_liste_requete_index = array();
                        while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                        {
                            $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                        }
                        mysqli_free_result($res_requete_index);
                        self::$cache_db->write('tag_ressource__index', $mf_liste_requete_index);
                    }
                    foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                    {
                        if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                    }
                    if ( count($liste_colonnes_a_indexer) > 0 )
                    {
                        self::$cache_db->pause('tag_ressource__index');
                        foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                        {
                            executer_requete_mysql('ALTER TABLE `'.inst('tag_ressource').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                        }
                        self::$cache_db->clear();
                        self::$cache_db->reprendre('tag_ressource__index');
                    }
                }

                $liste = array();
                $liste_tag_ressource_pas_a_jour = array();
                if ($toutes_colonnes)
                {
                    $colonnes='Code_tag_ressource, tag_ressource_Libelle';
                }
                else
                {
                    $colonnes='Code_tag_ressource, tag_ressource_Libelle';
                }
                $res_requete = executer_requete_mysql("SELECT $colonnes FROM ".inst('tag_ressource')." WHERE 1{$argument_cond}{$argument_tris}{$argument_limit};", false);
                while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
                {
                    mf_formatage_db_type_php($row_requete);
                    $liste[$row_requete['Code_tag_ressource']] = $row_requete;
                    if ( $maj && ! Hook_tag_ressource::est_a_jour( $row_requete ) )
                    {
                        $liste_tag_ressource_pas_a_jour[$row_requete['Code_tag_ressource']] = $row_requete;
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
                Hook_tag_ressource::mettre_a_jour( $liste_tag_ressource_pas_a_jour );
            }
        }

        foreach ($liste as $elem)
        {
            if ( $controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_tag_ressource', $elem['Code_tag_ressource']) )
            {
                unset($liste[$elem['Code_tag_ressource']]);
            }
            else
            {
                if (!self::$auto_completion && $autocompletion)
                {
                    self::$auto_completion = true;
                    Hook_tag_ressource::completion($liste[$elem['Code_tag_ressource']]);
                    self::$auto_completion = false;
                }
            }
        }

        return $liste;
    }

    public function mf_lister_2(array $liste_Code_tag_ressource, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        if ( count($liste_Code_tag_ressource)>0 )
        {
            $cle = "tag_ressource__mf_lister_2_".Sql_Format_Liste($liste_Code_tag_ressource);

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
                if ( isset($mf_tri_defaut_table['tag_ressource']) )
                {
                    $options['tris'] = $mf_tri_defaut_table['tag_ressource'];
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
                        if ( strpos($argument_cond, 'tag_ressource_Libelle')!==false ) { $liste_colonnes_a_indexer['tag_ressource_Libelle'] = 'tag_ressource_Libelle'; }
                    }
                    if ( isset($options['tris']) )
                    {
                        if ( isset($options['tris']['tag_ressource_Libelle']) ) { $liste_colonnes_a_indexer['tag_ressource_Libelle'] = 'tag_ressource_Libelle'; }
                    }
                    if ( count($liste_colonnes_a_indexer)>0 )
                    {
                        if ( ! $mf_liste_requete_index = self::$cache_db->read('tag_ressource__index') )
                        {
                            $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('tag_ressource').'`;', false);
                            $mf_liste_requete_index = array();
                            while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                            {
                                $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                            }
                            mysqli_free_result($res_requete_index);
                            self::$cache_db->write('tag_ressource__index', $mf_liste_requete_index);
                        }
                        foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                        {
                            if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                        }
                        if ( count($liste_colonnes_a_indexer) > 0 )
                        {
                            self::$cache_db->pause('tag_ressource__index');
                            foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                            {
                                executer_requete_mysql('ALTER TABLE `'.inst('tag_ressource').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                            }
                            self::$cache_db->clear();
                            self::$cache_db->reprendre('tag_ressource__index');
                        }
                    }

                    $liste = array();
                    $liste_tag_ressource_pas_a_jour = array();
                    if ($toutes_colonnes)
                    {
                        $colonnes='Code_tag_ressource, tag_ressource_Libelle';
                    }
                    else
                    {
                        $colonnes='Code_tag_ressource, tag_ressource_Libelle';
                    }
                    $res_requete = executer_requete_mysql("SELECT $colonnes FROM ".inst('tag_ressource')." WHERE 1{$argument_cond} AND Code_tag_ressource IN ".Sql_Format_Liste($liste_Code_tag_ressource)."{$argument_tris}{$argument_limit};", false);
                    while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
                    {
                        mf_formatage_db_type_php($row_requete);
                        $liste[$row_requete['Code_tag_ressource']] = $row_requete;
                        if ( $maj && ! Hook_tag_ressource::est_a_jour( $row_requete ) )
                        {
                            $liste_tag_ressource_pas_a_jour[$row_requete['Code_tag_ressource']] = $row_requete;
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
                    Hook_tag_ressource::mettre_a_jour( $liste_tag_ressource_pas_a_jour );
                }
            }

            foreach ($liste as $elem)
            {
                if ( $controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_tag_ressource', $elem['Code_tag_ressource']) )
                {
                    unset($liste[$elem['Code_tag_ressource']]);
                }
                else
                {
                    if (!self::$auto_completion && $autocompletion)
                    {
                        self::$auto_completion = true;
                        Hook_tag_ressource::completion($liste[$elem['Code_tag_ressource']]);
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

    public function mf_get(int $Code_tag_ressource, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $Code_tag_ressource = round($Code_tag_ressource);
        $retour = array();
        if ( ! CONTROLE_ACCES_DONNEES_DEFAUT || Hook_mf_systeme::controle_acces_donnees('Code_tag_ressource', $Code_tag_ressource) )
        {
            $cle = 'tag_ressource__get_'.$Code_tag_ressource;

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
                        $colonnes='Code_tag_ressource, tag_ressource_Libelle';
                    }
                    else
                    {
                        $colonnes='Code_tag_ressource, tag_ressource_Libelle';
                    }
                    $res_requete = executer_requete_mysql('SELECT ' . $colonnes . ' FROM ' . inst('tag_ressource') . ' WHERE Code_tag_ressource = ' . $Code_tag_ressource . ';', false);
                    if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
                    {
                        mf_formatage_db_type_php($row_requete);
                        $retour = $row_requete;
                        if ( $maj && ! Hook_tag_ressource::est_a_jour( $row_requete ) )
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
                    Hook_tag_ressource::mettre_a_jour( array( $row_requete['Code_tag_ressource'] => $row_requete ) );
                }
            }
            if ( isset( $retour['Code_tag_ressource'] ) )
            {
                if (!self::$auto_completion && $autocompletion)
                {
                    self::$auto_completion = true;
                    Hook_tag_ressource::completion($retour);
                    self::$auto_completion = false;
                }
            }
        }
        return $retour;
    }

    public function mf_get_last(?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cle = "tag_ressource__get_last";
        if ( ! $retour = self::$cache_db->read($cle) )
        {
            $Code_tag_ressource = 0;
            $res_requete = executer_requete_mysql('SELECT Code_tag_ressource FROM ' . inst('tag_ressource') . " WHERE 1 ORDER BY mf_date_creation DESC, Code_tag_ressource DESC LIMIT 0 , 1;", false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $Code_tag_ressource = $row_requete['Code_tag_ressource'];
            }
            mysqli_free_result($res_requete);
            $retour = $this->mf_get($Code_tag_ressource, $options);
            self::$cache_db->write($cle, $retour);
        }
        return $retour;
    }

    public function mf_get_2(int $Code_tag_ressource, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $Code_tag_ressource = round($Code_tag_ressource);
        $retour = array();
        $cle = 'tag_ressource__get_'.$Code_tag_ressource;

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
                $colonnes='Code_tag_ressource, tag_ressource_Libelle';
            }
            else
            {
                $colonnes='Code_tag_ressource, tag_ressource_Libelle';
            }
            $res_requete = executer_requete_mysql('SELECT ' . $colonnes . " FROM ".inst('tag_ressource')." WHERE Code_tag_ressource = $Code_tag_ressource;", false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                mf_formatage_db_type_php($row_requete);
                $retour = $row_requete;
            }
            mysqli_free_result($res_requete);
            self::$cache_db->write($cle, $retour);
        }
        if ( isset( $retour['Code_tag_ressource'] ) )
        {
            if (!self::$auto_completion && $autocompletion)
            {
                self::$auto_completion = true;
                Hook_tag_ressource::completion($retour);
                self::$auto_completion = false;
            }
        }
        return $retour;
    }

    public function mf_prec_et_suiv( int $Code_tag_ressource, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $Code_tag_ressource = round($Code_tag_ressource);
        $liste = $this->mf_lister($options);
        return prec_suiv($liste, $Code_tag_ressource);
    }

    public function mf_compter(?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cle = 'tag_ressource__compter';

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
                if ( strpos($argument_cond, 'tag_ressource_Libelle')!==false ) { $liste_colonnes_a_indexer['tag_ressource_Libelle'] = 'tag_ressource_Libelle'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = self::$cache_db->read('tag_ressource__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('tag_ressource').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    self::$cache_db->write('tag_ressource__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    self::$cache_db->pause('tag_ressource__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('tag_ressource').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    self::$cache_db->clear();
                    self::$cache_db->reprendre('tag_ressource__index');
                }
            }

            $res_requete = executer_requete_mysql('SELECT count(Code_tag_ressource) as nb FROM ' . inst('tag_ressource')." WHERE 1{$argument_cond};", false);
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

    public function mf_liste_Code_tag_ressource(?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ( $options===null ) { $options=[]; }
        return $this->get_liste_Code_tag_ressource($options);
    }

    public function mf_get_liste_tables_enfants()
    {
        return $this->get_liste_tables_enfants( 'tag_ressource' );
    }

    public function mf_get_liste_tables_parents()
    {
        return array();
    }

    public function mf_search_tag_ressource_Libelle( string $tag_ressource_Libelle )
    {
        return $this->rechercher_tag_ressource_Libelle( $tag_ressource_Libelle );
    }

    public function mf_search__colonne( string $colonne_db, $recherche )
    {
        switch ($colonne_db) {
            case 'tag_ressource_Libelle': return $this->mf_search_tag_ressource_Libelle( $recherche ); break;
        }
    }

    public function mf_get_next_id()
    {
        $res_requete = executer_requete_mysql('SELECT AUTO_INCREMENT as next_id FROM INFORMATION_SCHEMA.TABLES WHERE table_name = \'tag_ressource\';', false);
        $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC);
        mysqli_free_result($res_requete);
        return round($row_requete['next_id']);
    }

    public function mf_search(array $ligne) // array('colonne1' => 'valeur1',  [...] )
    {
        global $mf_initialisation;
        $tag_ressource_Libelle = (string)(isset($ligne['tag_ressource_Libelle'])?$ligne['tag_ressource_Libelle']:$mf_initialisation['tag_ressource_Libelle']);
        Hook_tag_ressource::pre_controller($tag_ressource_Libelle);
        $mf_cle_unique = Hook_tag_ressource::calcul_cle_unique($tag_ressource_Libelle);
        $res_requete = executer_requete_mysql('SELECT Code_tag_ressource FROM ' . inst('tag_ressource') . ' WHERE mf_cle_unique = \''.$mf_cle_unique.'\'', false);
        if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
        {
            $r = round($row_requete['Code_tag_ressource']);
        }
        else
        {
            $r = false;
        }
        mysqli_free_result($res_requete);
        return $r;
    }

}
