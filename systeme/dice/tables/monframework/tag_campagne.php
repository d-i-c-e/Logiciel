<?php

/*
    +------------------------------+
    |  NE PAS MODIFIER CE FICHIER  |
    +------------------------------+
*/

class tag_campagne_monframework extends entite_monframework
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
            include_once __DIR__ . '/../../erreurs/erreurs__tag_campagne.php';
            self::$initialisation = false;
            Hook_tag_campagne::initialisation();
            self::$cache_db = new Mf_Cachedb('tag_campagne');
        }
        if (!self::$actualisation_en_cours)
        {
            self::$actualisation_en_cours=true;
            Hook_tag_campagne::actualisation();
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

        if ( ! test_si_table_existe(inst('tag_campagne')) )
        {
            executer_requete_mysql('CREATE TABLE '.inst('tag_campagne').'(Code_tag_campagne INT AUTO_INCREMENT NOT NULL, PRIMARY KEY (Code_tag_campagne)) ENGINE=MyISAM;', true);
        }

        $liste_colonnes = lister_les_colonnes(inst('tag_campagne'));

        if ( isset($liste_colonnes['tag_campagne_Libelle']) )
        {
            if ( typeMyql2Sql($liste_colonnes['tag_campagne_Libelle']['Type'])!='VARCHAR' )
            {
                executer_requete_mysql('ALTER TABLE '.inst('tag_campagne').' CHANGE tag_campagne_Libelle tag_campagne_Libelle VARCHAR(255);', true);
            }
            unset($liste_colonnes['tag_campagne_Libelle']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('tag_campagne').' ADD tag_campagne_Libelle VARCHAR(255);', true);
            executer_requete_mysql('UPDATE '.inst('tag_campagne').' SET tag_campagne_Libelle=' . format_sql('tag_campagne_Libelle', $mf_initialisation['tag_campagne_Libelle']) . ';', true);
        }

        if ( isset($liste_colonnes['mf_signature']) )
        {
            unset($liste_colonnes['mf_signature']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('tag_campagne').' ADD mf_signature VARCHAR(255);', true);
            executer_requete_mysql('ALTER TABLE '.inst('tag_campagne').' ADD INDEX( mf_signature );', true);
        }

        if ( isset($liste_colonnes['mf_cle_unique']) )
        {
            unset($liste_colonnes['mf_cle_unique']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('tag_campagne').' ADD mf_cle_unique VARCHAR(255);', true);
            executer_requete_mysql('ALTER TABLE '.inst('tag_campagne').' ADD INDEX( mf_cle_unique );', true);
        }

        if ( isset($liste_colonnes['mf_date_creation']) )
        {
            unset($liste_colonnes['mf_date_creation']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('tag_campagne').' ADD mf_date_creation DATETIME;', true);
            executer_requete_mysql('ALTER TABLE '.inst('tag_campagne').' ADD INDEX( mf_date_creation );', true);
        }

        if ( isset($liste_colonnes['mf_date_modification']) )
        {
            unset($liste_colonnes['mf_date_modification']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('tag_campagne').' ADD mf_date_modification DATETIME;', true);
            executer_requete_mysql('ALTER TABLE '.inst('tag_campagne').' ADD INDEX( mf_date_modification );', true);
        }

        unset($liste_colonnes['Code_tag_campagne']);

        foreach ($liste_colonnes as $field => $value)
        {
            executer_requete_mysql('ALTER TABLE '.inst('tag_campagne').' DROP COLUMN '.$field.';', true);
        }

    }

    public function mf_ajouter($tag_campagne_Libelle, $force=false)
    {
        $Code_tag_campagne = 0;
        $code_erreur = 0;
        Hook_tag_campagne::pre_controller($tag_campagne_Libelle);
        if (!$force)
        {
            if (!self::$maj_droits_ajouter_en_cours)
            {
                self::$maj_droits_ajouter_en_cours = true;
                Hook_tag_campagne::hook_actualiser_les_droits_ajouter();
                self::$maj_droits_ajouter_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['tag_campagne__AJOUTER']) ) $code_erreur = REFUS_TAG_CAMPAGNE__AJOUTER;
        elseif ( !Hook_tag_campagne::autorisation_ajout($tag_campagne_Libelle) ) $code_erreur = REFUS_TAG_CAMPAGNE__AJOUT_BLOQUEE;
        else
        {
            Hook_tag_campagne::data_controller($tag_campagne_Libelle);
            $mf_signature = text_sql(Hook_tag_campagne::calcul_signature($tag_campagne_Libelle));
            $mf_cle_unique = text_sql(Hook_tag_campagne::calcul_cle_unique($tag_campagne_Libelle));
            $tag_campagne_Libelle = text_sql($tag_campagne_Libelle);
            $requete = "INSERT INTO ".inst('tag_campagne')." ( mf_signature, mf_cle_unique, mf_date_creation, mf_date_modification, tag_campagne_Libelle ) VALUES ( '$mf_signature', '$mf_cle_unique', '".get_now()."', '".get_now()."', '$tag_campagne_Libelle' );";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql($requete, true);
            $Code_tag_campagne = requete_mysql_insert_id();
            if ($Code_tag_campagne==0)
            {
                $code_erreur = ERR_TAG_CAMPAGNE__AJOUTER__AJOUT_REFUSE;
                self::$cache_db->reprendre($cle);
            }
            else
            {
                self::$cache_db->clear();
                self::$cache_db->reprendre($cle);
                Hook_tag_campagne::ajouter( $Code_tag_campagne );
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
        return array('code_erreur' => $code_erreur, 'Code_tag_campagne' => $Code_tag_campagne, 'callback' => ( $code_erreur==0 ? Hook_tag_campagne::callback_post($Code_tag_campagne) : null ));
    }

    public function mf_creer($force=false)
    {
        global $mf_initialisation, $mf_droits_defaut;
        $mf_droits_defaut["tag_campagne__AJOUTER"] = $mf_droits_defaut["tag_campagne__CREER"];
        $tag_campagne_Libelle = $mf_initialisation['tag_campagne_Libelle'];
        return $this->mf_ajouter($tag_campagne_Libelle, $force);
    }

    public function mf_ajouter_2($ligne, $force=false) // array('colonne1' => 'valeur1',  [...] )
    {
        global $mf_initialisation;
        $tag_campagne_Libelle = (isset($ligne['tag_campagne_Libelle'])?$ligne['tag_campagne_Libelle']:$mf_initialisation['tag_campagne_Libelle']);
        return $this->mf_ajouter($tag_campagne_Libelle, $force);
    }

    public function mf_ajouter_3($lignes) // array( array( 'colonne1' => 'valeur1', 'colonne2' => 'valeur2',  [...] ), [...] )
    {
        global $mf_initialisation;
        $code_erreur = 0;
        $values = '';
        foreach ($lignes as $ligne)
        {
            $tag_campagne_Libelle = text_sql(isset($ligne['tag_campagne_Libelle'])?$ligne['tag_campagne_Libelle']:$mf_initialisation['tag_campagne_Libelle']);
            $values.=($values!="" ? "," : "")."('$tag_campagne_Libelle')";
        }
        if ($values!='')
        {
            $requete = "INSERT INTO ".inst('tag_campagne')." ( tag_campagne_Libelle ) VALUES $values;";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            $n = requete_mysqli_affected_rows();
            if ($n < count($lignes))
            {
                $code_erreur = ERR_TAG_CAMPAGNE__AJOUTER_3__ECHEC_AJOUT;
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

    public function mf_modifier($Code_tag_campagne, $tag_campagne_Libelle, $force=false)
    {
        $code_erreur = 0;
        $Code_tag_campagne = round($Code_tag_campagne);
        Hook_tag_campagne::pre_controller($tag_campagne_Libelle, $Code_tag_campagne);
        if (!$force)
        {
            if (!self::$maj_droits_modifier_en_cours)
            {
                self::$maj_droits_modifier_en_cours = true;
                Hook_tag_campagne::hook_actualiser_les_droits_modifier($Code_tag_campagne);
                self::$maj_droits_modifier_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['tag_campagne__MODIFIER']) ) $code_erreur = REFUS_TAG_CAMPAGNE__MODIFIER;
        elseif ( !$this->mf_tester_existance_Code_tag_campagne($Code_tag_campagne) ) $code_erreur = ERR_TAG_CAMPAGNE__MODIFIER__CODE_TAG_CAMPAGNE_INEXISTANT;
        elseif ( CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_tag_campagne', $Code_tag_campagne) ) $code_erreur = ACCES_CODE_TAG_CAMPAGNE_REFUSE;
        elseif ( !Hook_tag_campagne::autorisation_modification($Code_tag_campagne, $tag_campagne_Libelle) ) $code_erreur = REFUS_TAG_CAMPAGNE__MODIFICATION_BLOQUEE;
        else
        {
            Hook_tag_campagne::data_controller($tag_campagne_Libelle, $Code_tag_campagne);
            $tag_campagne = $this->mf_get_2( $Code_tag_campagne, array('autocompletion' => false, 'masquer_mdp' => false) );
            $mf_colonnes_a_modifier=[];
            $bool__tag_campagne_Libelle = false; if ( $tag_campagne_Libelle!=$tag_campagne['tag_campagne_Libelle'] ) { Hook_tag_campagne::data_controller__tag_campagne_Libelle($tag_campagne['tag_campagne_Libelle'], $tag_campagne_Libelle, $Code_tag_campagne); if ( $tag_campagne_Libelle!=$tag_campagne['tag_campagne_Libelle'] ) { $mf_colonnes_a_modifier[] = 'tag_campagne_Libelle=' . format_sql('tag_campagne_Libelle', $tag_campagne_Libelle); $bool__tag_campagne_Libelle = true; } }
            if (count($mf_colonnes_a_modifier)>0) {
                $mf_signature = text_sql(Hook_tag_campagne::calcul_signature($tag_campagne_Libelle));
                $mf_cle_unique = text_sql(Hook_tag_campagne::calcul_cle_unique($tag_campagne_Libelle));
                $mf_colonnes_a_modifier[] = 'mf_signature=\'' . $mf_signature . '\'';
                $mf_colonnes_a_modifier[] = 'mf_cle_unique=\'' . $mf_cle_unique . '\'';
                $mf_colonnes_a_modifier[] = 'mf_date_modification=\'' . get_now() . '\'';
                $requete = 'UPDATE '.inst('tag_campagne').' SET ' . enumeration($mf_colonnes_a_modifier) . ' WHERE Code_tag_campagne = ' . $Code_tag_campagne . ';';
                $cle = md5($requete).salt(10);
                self::$cache_db->pause($cle);
                executer_requete_mysql( $requete , true);
                if ( requete_mysqli_affected_rows()==0 )
                {
                    $code_erreur = ERR_TAG_CAMPAGNE__MODIFIER__AUCUN_CHANGEMENT;
                    self::$cache_db->reprendre($cle);
                }
                else
                {
                    self::$cache_db->clear();
                    self::$cache_db->reprendre($cle);
                    Hook_tag_campagne::modifier($Code_tag_campagne, $bool__tag_campagne_Libelle);
                }
            }
            else
            {
                $code_erreur = ERR_TAG_CAMPAGNE__MODIFIER__AUCUN_CHANGEMENT;
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
        return array('code_erreur' => $code_erreur, 'callback' => ( $code_erreur == 0 ? Hook_tag_campagne::callback_put($Code_tag_campagne) : null ));
    }

    public function mf_modifier_2($lignes, $force=false) // array( $Code_tag_campagne => array('colonne1' => 'valeur1',  [...] ) )
    {
        $code_erreur = 0;
        foreach ( $lignes as $Code_tag_campagne => $colonnes )
        {
            if ( $code_erreur==0 )
            {
                $Code_tag_campagne = round($Code_tag_campagne);
                $tag_campagne = $this->mf_get_2($Code_tag_campagne, array('autocompletion' => false));
                if (!$force)
                {
                    if (!self::$maj_droits_modifier_en_cours)
                    {
                        self::$maj_droits_modifier_en_cours = true;
                        Hook_tag_campagne::hook_actualiser_les_droits_modifier($Code_tag_campagne);
                        self::$maj_droits_modifier_en_cours = false;
                    }
                }
                $tag_campagne_Libelle = ( isset($colonnes['tag_campagne_Libelle']) && ( $force || mf_matrice_droits(['api_modifier__tag_campagne_Libelle', 'tag_campagne__MODIFIER']) ) ? $colonnes['tag_campagne_Libelle'] : ( isset($tag_campagne['tag_campagne_Libelle']) ? $tag_campagne['tag_campagne_Libelle'] : '' ) );
                $retour = $this->mf_modifier($Code_tag_campagne, $tag_campagne_Libelle, true);
                if ( $retour['code_erreur']!=0 && $retour['code_erreur'] != ERR_TAG_CAMPAGNE__MODIFIER__AUCUN_CHANGEMENT )
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

    public function mf_modifier_3($lignes) // array( $Code_tag_campagne => array('colonne1' => 'valeur1',  [...] ) )
    {
        $code_erreur = 0;
        $modifs = false;

        // transformation des lignes en colonnes
        $valeurs_en_colonnes=array();
        $indices_par_colonne=array();
        $liste_valeurs_indexees=array();
        foreach ( $lignes as $Code_tag_campagne => $colonnes )
        {
            foreach ($colonnes as $colonne => $valeur)
            {
                if ( $colonne=='tag_campagne_Libelle' )
                {
                    $valeurs_en_colonnes[$colonne][$Code_tag_campagne]=$valeur;
                    $indices_par_colonne[$colonne][]=$Code_tag_campagne;
                    $liste_valeurs_indexees[$colonne][''.$valeur][]=$Code_tag_campagne;
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
                $modification_sql = $colonne . ' = CASE Code_tag_campagne';
                foreach ( $valeurs as $Code_tag_campagne => $valeur )
                {
                    $modification_sql.=' WHEN ' . $Code_tag_campagne . ' THEN ' . format_sql($colonne, $valeur);
                }
                $modification_sql.=' END';
                $perimetre = Sql_Format_Liste($indices_par_colonne[$colonne]);
                executer_requete_mysql('UPDATE ' . inst('tag_campagne') . ' SET ' . $modification_sql . ' WHERE Code_tag_campagne IN ' . $perimetre . ';', true);
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
                    executer_requete_mysql('UPDATE ' . inst('tag_campagne') . ' SET ' . $colonne . ' = ' . format_sql($colonne, $valeur) . ' WHERE Code_tag_campagne IN ' . $perimetre . ';', true);
                    if ( requete_mysqli_affected_rows()!=0 )
                    {
                        $modifs = true;
                    }
                }
            }
        }

        if ( ! $modifs && $code_erreur==0 )
        {
            $code_erreur = ERR_TAG_CAMPAGNE__MODIFIER_3__AUCUN_CHANGEMENT;
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

    public function mf_modifier_4( $data, $options = array( 'cond_mysql' => array() ) ) // $data = array('colonne1' => 'valeur1', ... )
    {
        $code_erreur = 0;
        $mf_colonnes_a_modifier=[];
        if ( isset($data['tag_campagne_Libelle']) ) { $mf_colonnes_a_modifier[] = 'tag_campagne_Libelle = ' . format_sql('tag_campagne_Libelle', $data['tag_campagne_Libelle']); }
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

            $requete = 'UPDATE ' . inst('tag_campagne') . ' SET ' . enumeration($mf_colonnes_a_modifier) . " WHERE 1$argument_cond;";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_TAG_CAMPAGNE__MODIFIER_4__AUCUN_CHANGEMENT;
            }
            else
            {
                self::$cache_db->clear();
            }
            self::$cache_db->reprendre($cle);
        }
        return array('code_erreur' => $code_erreur);
    }

    public function mf_supprimer($Code_tag_campagne, $force=false)
    {
        $code_erreur = 0;
        $Code_tag_campagne = round($Code_tag_campagne);
        if (!$force)
        {
            if (!self::$maj_droits_supprimer_en_cours)
            {
                self::$maj_droits_supprimer_en_cours = true;
                Hook_tag_campagne::hook_actualiser_les_droits_supprimer($Code_tag_campagne);
                self::$maj_droits_supprimer_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['tag_campagne__SUPPRIMER']) ) $code_erreur = REFUS_TAG_CAMPAGNE__SUPPRIMER;
        elseif ( !$this->mf_tester_existance_Code_tag_campagne($Code_tag_campagne) ) $code_erreur = ERR_TAG_CAMPAGNE__SUPPRIMER_2__CODE_TAG_CAMPAGNE_INEXISTANT;
        elseif ( CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_tag_campagne', $Code_tag_campagne) ) $code_erreur = ACCES_CODE_TAG_CAMPAGNE_REFUSE;
        elseif ( !Hook_tag_campagne::autorisation_suppression($Code_tag_campagne) ) $code_erreur = REFUS_TAG_CAMPAGNE__SUPPRESSION_BLOQUEE;
        else
        {
            $copie__tag_campagne = $this->mf_get($Code_tag_campagne, array('autocompletion' => false));
            $this->supprimer_donnes_en_cascade("tag_campagne", array($Code_tag_campagne));
            $requete = "DELETE IGNORE FROM ".inst('tag_campagne')." WHERE Code_tag_campagne=$Code_tag_campagne;";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_TAG_CAMPAGNE__SUPPRIMER__REFUSEE;
                self::$cache_db->reprendre($cle);
            }
            else
            {
                self::$cache_db->clear();
                self::$cache_db->reprendre($cle);
                Hook_tag_campagne::supprimer($copie__tag_campagne);
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

    public function mf_supprimer_2($liste_Code_tag_campagne, $force=false)
    {
        $code_erreur=0;
        $copie__liste_tag_campagne = $this->mf_lister_2($liste_Code_tag_campagne, array('autocompletion' => false));
        $liste_Code_tag_campagne=array();
        foreach ( $copie__liste_tag_campagne as $copie__tag_campagne )
        {
            $Code_tag_campagne = $copie__tag_campagne['Code_tag_campagne'];
            if (!$force)
            {
                if (!self::$maj_droits_supprimer_en_cours)
                {
                    self::$maj_droits_supprimer_en_cours = true;
                    Hook_tag_campagne::hook_actualiser_les_droits_supprimer($Code_tag_campagne);
                    self::$maj_droits_supprimer_en_cours = false;
                }
            }
            if ( !$force && !mf_matrice_droits(['tag_campagne__SUPPRIMER']) ) $code_erreur = REFUS_TAG_CAMPAGNE__SUPPRIMER;
            elseif ( !Hook_tag_campagne::autorisation_suppression($Code_tag_campagne) ) $code_erreur = REFUS_TAG_CAMPAGNE__SUPPRESSION_BLOQUEE;
            {
                $liste_Code_tag_campagne[] = $Code_tag_campagne;
            }
        }
        if ( $code_erreur==0 && count($liste_Code_tag_campagne)>0 )
        {
            $this->supprimer_donnes_en_cascade("tag_campagne", $liste_Code_tag_campagne);
            $requete = "DELETE IGNORE FROM ".inst('tag_campagne')." WHERE Code_tag_campagne IN ".Sql_Format_Liste($liste_Code_tag_campagne).";";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_TAG_CAMPAGNE__SUPPRIMER_2__REFUSEE;
                self::$cache_db->reprendre($cle);
            }
            else
            {
                self::$cache_db->clear();
                self::$cache_db->reprendre($cle);
                Hook_tag_campagne::supprimer_2($copie__liste_tag_campagne);
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

    public function mf_supprimer_3($liste_Code_tag_campagne)
    {
        $code_erreur=0;
        if ( count($liste_Code_tag_campagne)>0 )
        {
            $this->supprimer_donnes_en_cascade("tag_campagne", $liste_Code_tag_campagne);
            $requete = "DELETE IGNORE FROM ".inst('tag_campagne')." WHERE Code_tag_campagne IN ".Sql_Format_Liste($liste_Code_tag_campagne).";";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_TAG_CAMPAGNE__SUPPRIMER_3__REFUSEE;
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

    public function mf_lister_contexte($contexte_parent=true, $options = array( 'cond_mysql' => array(), 'tris' => array(), 'limit' => array(), 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ))
    {
        global $mf_contexte, $est_charge;
        if ( ! $contexte_parent && $mf_contexte['Code_tag_campagne']!=0 )
        {
            $tag_campagne = $this->mf_get( $mf_contexte['Code_tag_campagne'], $options);
            return array( $tag_campagne['Code_tag_campagne'] => $tag_campagne );
        }
        else
        {
            return $this->mf_lister($options);
        }
    }

    public function mf_lister($options = array( 'cond_mysql' => array(), 'tris' => array(), 'limit' => array(), 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ))
    {
        $cle = "tag_campagne__lister";

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
            if ( isset($mf_tri_defaut_table['tag_campagne']) )
            {
                $options['tris'] = $mf_tri_defaut_table['tag_campagne'];
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
                    if ( strpos($argument_cond, 'tag_campagne_Libelle')!==false ) { $liste_colonnes_a_indexer['tag_campagne_Libelle'] = 'tag_campagne_Libelle'; }
                }
                if ( isset($options['tris']) )
                {
                    if ( isset($options['tris']['tag_campagne_Libelle']) ) { $liste_colonnes_a_indexer['tag_campagne_Libelle'] = 'tag_campagne_Libelle'; }
                }
                if ( count($liste_colonnes_a_indexer)>0 )
                {
                    if ( ! $mf_liste_requete_index = self::$cache_db->read('tag_campagne__index') )
                    {
                        $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('tag_campagne').'`;', false);
                        $mf_liste_requete_index = array();
                        while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                        {
                            $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                        }
                        mysqli_free_result($res_requete_index);
                        self::$cache_db->write('tag_campagne__index', $mf_liste_requete_index);
                    }
                    foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                    {
                        if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                    }
                    if ( count($liste_colonnes_a_indexer) > 0 )
                    {
                        self::$cache_db->pause('tag_campagne__index');
                        foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                        {
                            executer_requete_mysql('ALTER TABLE `'.inst('tag_campagne').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                        }
                        self::$cache_db->clear();
                        self::$cache_db->reprendre('tag_campagne__index');
                    }
                }

                $liste = array();
                $liste_tag_campagne_pas_a_jour = array();
                if ($toutes_colonnes)
                {
                    $colonnes='Code_tag_campagne, tag_campagne_Libelle';
                }
                else
                {
                    $colonnes='Code_tag_campagne, tag_campagne_Libelle';
                }
                $res_requete = executer_requete_mysql("SELECT $colonnes FROM ".inst('tag_campagne')." WHERE 1{$argument_cond}{$argument_tris}{$argument_limit};", false);
                while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
                {
                    $liste[$row_requete['Code_tag_campagne']]=$row_requete;
                    if ( $maj && ! Hook_tag_campagne::est_a_jour( $row_requete ) )
                    {
                        $liste_tag_campagne_pas_a_jour[$row_requete['Code_tag_campagne']] = $row_requete;
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
                Hook_tag_campagne::mettre_a_jour( $liste_tag_campagne_pas_a_jour );
            }
        }

        foreach ($liste as $elem)
        {
            if ( $controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_tag_campagne', $elem['Code_tag_campagne']) )
            {
                unset($liste[$elem['Code_tag_campagne']]);
            }
            else
            {
                if (!self::$auto_completion && $autocompletion)
                {
                    self::$auto_completion = true;
                    Hook_tag_campagne::completion($liste[$elem['Code_tag_campagne']]);
                    self::$auto_completion = false;
                }
            }
        }

        return $liste;
    }

    public function mf_lister_2($liste_Code_tag_campagne, $options = array( 'cond_mysql' => array(), 'tris' => array(), 'limit' => array(), 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ))
    {
        if ( count($liste_Code_tag_campagne)>0 )
        {
            $cle = "tag_campagne__mf_lister_2_".Sql_Format_Liste($liste_Code_tag_campagne);

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
                if ( isset($mf_tri_defaut_table['tag_campagne']) )
                {
                    $options['tris'] = $mf_tri_defaut_table['tag_campagne'];
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
                        if ( strpos($argument_cond, 'tag_campagne_Libelle')!==false ) { $liste_colonnes_a_indexer['tag_campagne_Libelle'] = 'tag_campagne_Libelle'; }
                    }
                    if ( isset($options['tris']) )
                    {
                        if ( isset($options['tris']['tag_campagne_Libelle']) ) { $liste_colonnes_a_indexer['tag_campagne_Libelle'] = 'tag_campagne_Libelle'; }
                    }
                    if ( count($liste_colonnes_a_indexer)>0 )
                    {
                        if ( ! $mf_liste_requete_index = self::$cache_db->read('tag_campagne__index') )
                        {
                            $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('tag_campagne').'`;', false);
                            $mf_liste_requete_index = array();
                            while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                            {
                                $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                            }
                            mysqli_free_result($res_requete_index);
                            self::$cache_db->write('tag_campagne__index', $mf_liste_requete_index);
                        }
                        foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                        {
                            if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                        }
                        if ( count($liste_colonnes_a_indexer) > 0 )
                        {
                            self::$cache_db->pause('tag_campagne__index');
                            foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                            {
                                executer_requete_mysql('ALTER TABLE `'.inst('tag_campagne').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                            }
                            self::$cache_db->clear();
                            self::$cache_db->reprendre('tag_campagne__index');
                        }
                    }

                    $liste = array();
                    $liste_tag_campagne_pas_a_jour = array();
                    if ($toutes_colonnes)
                    {
                        $colonnes='Code_tag_campagne, tag_campagne_Libelle';
                    }
                    else
                    {
                        $colonnes='Code_tag_campagne, tag_campagne_Libelle';
                    }
                    $res_requete = executer_requete_mysql("SELECT $colonnes FROM ".inst('tag_campagne')." WHERE 1{$argument_cond} AND Code_tag_campagne IN ".Sql_Format_Liste($liste_Code_tag_campagne)."{$argument_tris}{$argument_limit};", false);
                    while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
                    {
                        $liste[$row_requete['Code_tag_campagne']]=$row_requete;
                        if ( $maj && ! Hook_tag_campagne::est_a_jour( $row_requete ) )
                        {
                            $liste_tag_campagne_pas_a_jour[$row_requete['Code_tag_campagne']] = $row_requete;
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
                    Hook_tag_campagne::mettre_a_jour( $liste_tag_campagne_pas_a_jour );
                }
            }

            foreach ($liste as $elem)
            {
                if ( $controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_tag_campagne', $elem['Code_tag_campagne']) )
                {
                    unset($liste[$elem['Code_tag_campagne']]);
                }
                else
                {
                    if (!self::$auto_completion && $autocompletion)
                    {
                        self::$auto_completion = true;
                        Hook_tag_campagne::completion($liste[$elem['Code_tag_campagne']]);
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

    public function mf_get($Code_tag_campagne, $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ])
    {
        $Code_tag_campagne = round($Code_tag_campagne);
        $retour = array();
        if ( ! CONTROLE_ACCES_DONNEES_DEFAUT || Hook_mf_systeme::controle_acces_donnees('Code_tag_campagne', $Code_tag_campagne) )
        {
            $cle = 'tag_campagne__get_'.$Code_tag_campagne;

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
                        $colonnes='Code_tag_campagne, tag_campagne_Libelle';
                    }
                    else
                    {
                        $colonnes='Code_tag_campagne, tag_campagne_Libelle';
                    }
                    $res_requete = executer_requete_mysql('SELECT ' . $colonnes . ' FROM ' . inst('tag_campagne') . ' WHERE Code_tag_campagne = ' . $Code_tag_campagne . ';', false);
                    if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
                    {
                        $retour=$row_requete;
                        if ( $maj && ! Hook_tag_campagne::est_a_jour( $row_requete ) )
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
                    Hook_tag_campagne::mettre_a_jour( array( $row_requete['Code_tag_campagne'] => $row_requete ) );
                }
            }
            if ( isset( $retour['Code_tag_campagne'] ) )
            {
                if (!self::$auto_completion && $autocompletion)
                {
                    self::$auto_completion = true;
                    Hook_tag_campagne::completion($retour);
                    self::$auto_completion = false;
                }
            }
        }
        return $retour;
    }

    public function mf_get_last($options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ])
    {
        $cle = "tag_campagne__get_last";
        if ( ! $retour = self::$cache_db->read($cle) )
        {
            $Code_tag_campagne = 0;
            $res_requete = executer_requete_mysql('SELECT Code_tag_campagne FROM ' . inst('tag_campagne') . " WHERE 1 ORDER BY mf_date_creation DESC, Code_tag_campagne DESC LIMIT 0 , 1;", false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $Code_tag_campagne = $row_requete['Code_tag_campagne'];
            }
            mysqli_free_result($res_requete);
            $retour = $this->mf_get($Code_tag_campagne, $options);
            self::$cache_db->write($cle, $retour);
        }
        return $retour;
    }

    public function mf_get_2($Code_tag_campagne, $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ])
    {
        $Code_tag_campagne = round($Code_tag_campagne);
        $retour = array();
        $cle = 'tag_campagne__get_'.$Code_tag_campagne;

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
                $colonnes='Code_tag_campagne, tag_campagne_Libelle';
            }
            else
            {
                $colonnes='Code_tag_campagne, tag_campagne_Libelle';
            }
            $res_requete = executer_requete_mysql('SELECT ' . $colonnes . " FROM ".inst('tag_campagne')." WHERE Code_tag_campagne = $Code_tag_campagne;", false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $retour=$row_requete;
            }
            mysqli_free_result($res_requete);
            self::$cache_db->write($cle, $retour);
        }
        if ( isset( $retour['Code_tag_campagne'] ) )
        {
            if (!self::$auto_completion && $autocompletion)
            {
                self::$auto_completion = true;
                Hook_tag_campagne::completion($retour);
                self::$auto_completion = false;
            }
        }
        return $retour;
    }

    public function mf_prec_et_suiv($Code_tag_campagne, $options = array( 'cond_mysql' => array(), 'tris' => array(), 'limit' => array(), 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ))
    {
        $Code_tag_campagne = round($Code_tag_campagne);
        $liste = $this->mf_lister($options);
        return prec_suiv($liste, $Code_tag_campagne);
    }

    public function mf_compter($options = array( 'cond_mysql' => array() ))
    {
        $cle = 'tag_campagne__compter';

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
                if ( strpos($argument_cond, 'tag_campagne_Libelle')!==false ) { $liste_colonnes_a_indexer['tag_campagne_Libelle'] = 'tag_campagne_Libelle'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = self::$cache_db->read('tag_campagne__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('tag_campagne').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    self::$cache_db->write('tag_campagne__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    self::$cache_db->pause('tag_campagne__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('tag_campagne').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    self::$cache_db->clear();
                    self::$cache_db->reprendre('tag_campagne__index');
                }
            }

            $res_requete = executer_requete_mysql("SELECT count(Code_tag_campagne) as nb FROM ".inst('tag_campagne')." WHERE 1{$argument_cond};", false);
            $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC);
            mysqli_free_result($res_requete);
            $nb = round($row_requete['nb']);
            self::$cache_db->write($cle, $nb);
        }
        return $nb;
    }

    public function mfi_compter( $interface, $options = array( 'cond_mysql' => array() ) )
    {
        return $this->mf_compter( $options );
    }

    public function mf_liste_Code_tag_campagne($options = array( 'cond_mysql' => array() ))
    {
        return $this->get_liste_Code_tag_campagne($options);
    }

    public function mf_get_liste_tables_enfants()
    {
        return $this->get_liste_tables_enfants( 'tag_campagne' );
    }

    public function mf_get_liste_tables_parents()
    {
        return array();
    }

    public function mf_search_tag_campagne_Libelle( $tag_campagne_Libelle )
    {
        return $this->rechercher_tag_campagne_Libelle( $tag_campagne_Libelle );
    }

    public function mf_search__colonne( $colonne_db, $recherche )
    {
        switch ($colonne_db) {
            case 'tag_campagne_Libelle': return $this->mf_search_tag_campagne_Libelle( $recherche ); break;
        }
    }

    public function mf_get_next_id()
    {
        $res_requete = executer_requete_mysql('SELECT AUTO_INCREMENT as next_id FROM INFORMATION_SCHEMA.TABLES WHERE table_name = \'tag_campagne\';', false);
        $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC);
        mysqli_free_result($res_requete);
        return round($row_requete['next_id']);
    }

    public function mf_search($ligne) // array('colonne1' => 'valeur1',  [...] )
    {
        global $mf_initialisation;
        $tag_campagne_Libelle = (isset($ligne['tag_campagne_Libelle'])?$ligne['tag_campagne_Libelle']:$mf_initialisation['tag_campagne_Libelle']);
        Hook_tag_campagne::pre_controller($tag_campagne_Libelle);
        $mf_cle_unique = Hook_tag_campagne::calcul_cle_unique($tag_campagne_Libelle);
        $res_requete = executer_requete_mysql('SELECT Code_tag_campagne FROM ' . inst('tag_campagne') . ' WHERE mf_cle_unique = \''.$mf_cle_unique.'\'', false);
        if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
        {
            $r = round($row_requete['Code_tag_campagne']);
        }
        else
        {
            $r = false;
        }
        mysqli_free_result($res_requete);
        return $r;
    }

}
