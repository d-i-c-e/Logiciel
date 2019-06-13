<?php

/*
    +------------------------------+
    |  NE PAS MODIFIER CE FICHIER  |
    +------------------------------+
*/

class parametre_monframework extends entite_monframework
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
            include_once __DIR__ . '/../../erreurs/erreurs__parametre.php';
            self::$initialisation = false;
            Hook_parametre::initialisation();
            self::$cache_db = new Mf_Cachedb('parametre');
        }
        if (!self::$actualisation_en_cours)
        {
            self::$actualisation_en_cours=true;
            Hook_parametre::actualisation();
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

        if ( ! test_si_table_existe(inst('parametre')) )
        {
            executer_requete_mysql('CREATE TABLE '.inst('parametre').'(Code_parametre INT AUTO_INCREMENT NOT NULL, PRIMARY KEY (Code_parametre)) ENGINE=MyISAM;', true);
        }

        $liste_colonnes = lister_les_colonnes(inst('parametre'));

        if ( isset($liste_colonnes['parametre_Libelle']) )
        {
            if ( typeMyql2Sql($liste_colonnes['parametre_Libelle']['Type'])!='VARCHAR' )
            {
                executer_requete_mysql('ALTER TABLE '.inst('parametre').' CHANGE parametre_Libelle parametre_Libelle VARCHAR(255);', true);
            }
            unset($liste_colonnes['parametre_Libelle']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('parametre').' ADD parametre_Libelle VARCHAR(255);', true);
            executer_requete_mysql('UPDATE '.inst('parametre').' SET parametre_Libelle=' . format_sql('parametre_Libelle', $mf_initialisation['parametre_Libelle']) . ';', true);
        }

        if ( isset($liste_colonnes['parametre_Valeur']) )
        {
            if ( typeMyql2Sql($liste_colonnes['parametre_Valeur']['Type'])!='INT' )
            {
                executer_requete_mysql('ALTER TABLE '.inst('parametre').' CHANGE parametre_Valeur parametre_Valeur INT;', true);
            }
            unset($liste_colonnes['parametre_Valeur']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('parametre').' ADD parametre_Valeur INT;', true);
            executer_requete_mysql('UPDATE '.inst('parametre').' SET parametre_Valeur=' . format_sql('parametre_Valeur', $mf_initialisation['parametre_Valeur']) . ';', true);
        }

        if ( isset($liste_colonnes['parametre_Activable']) )
        {
            if ( typeMyql2Sql($liste_colonnes['parametre_Activable']['Type'])!='BOOL' )
            {
                executer_requete_mysql('ALTER TABLE '.inst('parametre').' CHANGE parametre_Activable parametre_Activable BOOL;', true);
            }
            unset($liste_colonnes['parametre_Activable']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('parametre').' ADD parametre_Activable BOOL;', true);
            executer_requete_mysql('UPDATE '.inst('parametre').' SET parametre_Activable=' . format_sql('parametre_Activable', $mf_initialisation['parametre_Activable']) . ';', true);
        }

        if ( isset($liste_colonnes['parametre_Actif']) )
        {
            if ( typeMyql2Sql($liste_colonnes['parametre_Actif']['Type'])!='BOOL' )
            {
                executer_requete_mysql('ALTER TABLE '.inst('parametre').' CHANGE parametre_Actif parametre_Actif BOOL;', true);
            }
            unset($liste_colonnes['parametre_Actif']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('parametre').' ADD parametre_Actif BOOL;', true);
            executer_requete_mysql('UPDATE '.inst('parametre').' SET parametre_Actif=' . format_sql('parametre_Actif', $mf_initialisation['parametre_Actif']) . ';', true);
        }

        if ( isset($liste_colonnes['mf_signature']) )
        {
            unset($liste_colonnes['mf_signature']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('parametre').' ADD mf_signature VARCHAR(255);', true);
            executer_requete_mysql('ALTER TABLE '.inst('parametre').' ADD INDEX( mf_signature );', true);
        }

        if ( isset($liste_colonnes['mf_cle_unique']) )
        {
            unset($liste_colonnes['mf_cle_unique']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('parametre').' ADD mf_cle_unique VARCHAR(255);', true);
            executer_requete_mysql('ALTER TABLE '.inst('parametre').' ADD INDEX( mf_cle_unique );', true);
        }

        if ( isset($liste_colonnes['mf_date_creation']) )
        {
            unset($liste_colonnes['mf_date_creation']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('parametre').' ADD mf_date_creation DATETIME;', true);
            executer_requete_mysql('ALTER TABLE '.inst('parametre').' ADD INDEX( mf_date_creation );', true);
        }

        if ( isset($liste_colonnes['mf_date_modification']) )
        {
            unset($liste_colonnes['mf_date_modification']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('parametre').' ADD mf_date_modification DATETIME;', true);
            executer_requete_mysql('ALTER TABLE '.inst('parametre').' ADD INDEX( mf_date_modification );', true);
        }

        unset($liste_colonnes['Code_parametre']);

        foreach ($liste_colonnes as $field => $value)
        {
            executer_requete_mysql('ALTER TABLE '.inst('parametre').' DROP COLUMN '.$field.';', true);
        }

    }

    public function mf_ajouter($parametre_Libelle, $parametre_Valeur, $parametre_Activable, $parametre_Actif, $force=false)
    {
        $Code_parametre = 0;
        $code_erreur = 0;
        $parametre_Valeur = round($parametre_Valeur);
        Hook_parametre::pre_controller($parametre_Libelle, $parametre_Valeur, $parametre_Activable, $parametre_Actif);
        if (!$force)
        {
            if (!self::$maj_droits_ajouter_en_cours)
            {
                self::$maj_droits_ajouter_en_cours = true;
                Hook_parametre::hook_actualiser_les_droits_ajouter();
                self::$maj_droits_ajouter_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['parametre__AJOUTER']) ) $code_erreur = REFUS_PARAMETRE__AJOUTER;
        elseif ( !Hook_parametre::autorisation_ajout($parametre_Libelle, $parametre_Valeur, $parametre_Activable, $parametre_Actif) ) $code_erreur = REFUS_PARAMETRE__AJOUT_BLOQUEE;
        else
        {
            Hook_parametre::data_controller($parametre_Libelle, $parametre_Valeur, $parametre_Activable, $parametre_Actif);
            $mf_signature = text_sql(Hook_parametre::calcul_signature($parametre_Libelle, $parametre_Valeur, $parametre_Activable, $parametre_Actif));
            $mf_cle_unique = text_sql(Hook_parametre::calcul_cle_unique($parametre_Libelle, $parametre_Valeur, $parametre_Activable, $parametre_Actif));
            $parametre_Libelle = text_sql($parametre_Libelle);
            $parametre_Valeur = round($parametre_Valeur);
            $parametre_Activable = ($parametre_Activable==1 ? 1 : 0);
            $parametre_Actif = ($parametre_Actif==1 ? 1 : 0);
            $requete = "INSERT INTO ".inst('parametre')." ( mf_signature, mf_cle_unique, mf_date_creation, mf_date_modification, parametre_Libelle, parametre_Valeur, parametre_Activable, parametre_Actif ) VALUES ( '$mf_signature', '$mf_cle_unique', '".get_now()."', '".get_now()."', '$parametre_Libelle', $parametre_Valeur, $parametre_Activable, $parametre_Actif );";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql($requete, true);
            $Code_parametre = requete_mysql_insert_id();
            if ($Code_parametre==0)
            {
                $code_erreur = ERR_PARAMETRE__AJOUTER__AJOUT_REFUSE;
                self::$cache_db->reprendre($cle);
            }
            else
            {
                self::$cache_db->clear();
                self::$cache_db->reprendre($cle);
                Hook_parametre::ajouter( $Code_parametre );
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
        return array('code_erreur' => $code_erreur, 'Code_parametre' => $Code_parametre, 'callback' => ( $code_erreur==0 ? Hook_parametre::callback_post($Code_parametre) : null ));
    }

    public function mf_creer($force=false)
    {
        global $mf_initialisation, $mf_droits_defaut;
        $mf_droits_defaut["parametre__AJOUTER"] = $mf_droits_defaut["parametre__CREER"];
        $parametre_Libelle = $mf_initialisation['parametre_Libelle'];
        $parametre_Valeur = $mf_initialisation['parametre_Valeur'];
        $parametre_Activable = $mf_initialisation['parametre_Activable'];
        $parametre_Actif = $mf_initialisation['parametre_Actif'];
        return $this->mf_ajouter($parametre_Libelle, $parametre_Valeur, $parametre_Activable, $parametre_Actif, $force);
    }

    public function mf_ajouter_2($ligne, $force=false) // array('colonne1' => 'valeur1',  [...] )
    {
        global $mf_initialisation;
        $parametre_Libelle = (isset($ligne['parametre_Libelle'])?$ligne['parametre_Libelle']:$mf_initialisation['parametre_Libelle']);
        $parametre_Valeur = (isset($ligne['parametre_Valeur'])?$ligne['parametre_Valeur']:$mf_initialisation['parametre_Valeur']);
        $parametre_Activable = (isset($ligne['parametre_Activable'])?$ligne['parametre_Activable']:$mf_initialisation['parametre_Activable']);
        $parametre_Actif = (isset($ligne['parametre_Actif'])?$ligne['parametre_Actif']:$mf_initialisation['parametre_Actif']);
        return $this->mf_ajouter($parametre_Libelle, $parametre_Valeur, $parametre_Activable, $parametre_Actif, $force);
    }

    public function mf_ajouter_3($lignes) // array( array( 'colonne1' => 'valeur1', 'colonne2' => 'valeur2',  [...] ), [...] )
    {
        global $mf_initialisation;
        $code_erreur = 0;
        $values = '';
        foreach ($lignes as $ligne)
        {
            $parametre_Libelle = text_sql(isset($ligne['parametre_Libelle'])?$ligne['parametre_Libelle']:$mf_initialisation['parametre_Libelle']);
            $parametre_Valeur = round(isset($ligne['parametre_Valeur'])?$ligne['parametre_Valeur']:$mf_initialisation['parametre_Valeur']);
            $parametre_Activable = (isset($ligne['parametre_Activable'])?$ligne['parametre_Activable']:$mf_initialisation['parametre_Activable']==1 ? 1 : 0);
            $parametre_Actif = (isset($ligne['parametre_Actif'])?$ligne['parametre_Actif']:$mf_initialisation['parametre_Actif']==1 ? 1 : 0);
            $values.=($values!="" ? "," : "")."('$parametre_Libelle', $parametre_Valeur, $parametre_Activable, $parametre_Actif)";
        }
        if ($values!='')
        {
            $requete = "INSERT INTO ".inst('parametre')." ( parametre_Libelle, parametre_Valeur, parametre_Activable, parametre_Actif ) VALUES $values;";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            $n = requete_mysqli_affected_rows();
            if ($n < count($lignes))
            {
                $code_erreur = ERR_PARAMETRE__AJOUTER_3__ECHEC_AJOUT;
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

    public function mf_modifier($Code_parametre, $parametre_Libelle, $parametre_Valeur, $parametre_Activable, $parametre_Actif, $force=false)
    {
        $code_erreur = 0;
        $Code_parametre = round($Code_parametre);
        $parametre_Valeur = round($parametre_Valeur);
        Hook_parametre::pre_controller($parametre_Libelle, $parametre_Valeur, $parametre_Activable, $parametre_Actif, $Code_parametre);
        if (!$force)
        {
            if (!self::$maj_droits_modifier_en_cours)
            {
                self::$maj_droits_modifier_en_cours = true;
                Hook_parametre::hook_actualiser_les_droits_modifier($Code_parametre);
                self::$maj_droits_modifier_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['parametre__MODIFIER']) ) $code_erreur = REFUS_PARAMETRE__MODIFIER;
        elseif ( !$this->mf_tester_existance_Code_parametre($Code_parametre) ) $code_erreur = ERR_PARAMETRE__MODIFIER__CODE_PARAMETRE_INEXISTANT;
        elseif ( CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_parametre', $Code_parametre) ) $code_erreur = ACCES_CODE_PARAMETRE_REFUSE;
        elseif ( !Hook_parametre::autorisation_modification($Code_parametre, $parametre_Libelle, $parametre_Valeur, $parametre_Activable, $parametre_Actif) ) $code_erreur = REFUS_PARAMETRE__MODIFICATION_BLOQUEE;
        else
        {
            Hook_parametre::data_controller($parametre_Libelle, $parametre_Valeur, $parametre_Activable, $parametre_Actif, $Code_parametre);
            $parametre = $this->mf_get_2( $Code_parametre, array('autocompletion' => false, 'masquer_mdp' => false) );
            $mf_colonnes_a_modifier=[];
            $bool__parametre_Libelle = false; if ( $parametre_Libelle!=$parametre['parametre_Libelle'] ) { Hook_parametre::data_controller__parametre_Libelle($parametre['parametre_Libelle'], $parametre_Libelle, $Code_parametre); if ( $parametre_Libelle!=$parametre['parametre_Libelle'] ) { $mf_colonnes_a_modifier[] = 'parametre_Libelle=' . format_sql('parametre_Libelle', $parametre_Libelle); $bool__parametre_Libelle = true; } }
            $bool__parametre_Valeur = false; if ( $parametre_Valeur!=$parametre['parametre_Valeur'] ) { Hook_parametre::data_controller__parametre_Valeur($parametre['parametre_Valeur'], $parametre_Valeur, $Code_parametre); if ( $parametre_Valeur!=$parametre['parametre_Valeur'] ) { $mf_colonnes_a_modifier[] = 'parametre_Valeur=' . format_sql('parametre_Valeur', $parametre_Valeur); $bool__parametre_Valeur = true; } }
            $bool__parametre_Activable = false; if ( $parametre_Activable!=$parametre['parametre_Activable'] ) { Hook_parametre::data_controller__parametre_Activable($parametre['parametre_Activable'], $parametre_Activable, $Code_parametre); if ( $parametre_Activable!=$parametre['parametre_Activable'] ) { $mf_colonnes_a_modifier[] = 'parametre_Activable=' . format_sql('parametre_Activable', $parametre_Activable); $bool__parametre_Activable = true; } }
            $bool__parametre_Actif = false; if ( $parametre_Actif!=$parametre['parametre_Actif'] ) { Hook_parametre::data_controller__parametre_Actif($parametre['parametre_Actif'], $parametre_Actif, $Code_parametre); if ( $parametre_Actif!=$parametre['parametre_Actif'] ) { $mf_colonnes_a_modifier[] = 'parametre_Actif=' . format_sql('parametre_Actif', $parametre_Actif); $bool__parametre_Actif = true; } }
            if (count($mf_colonnes_a_modifier)>0) {
                $mf_signature = text_sql(Hook_parametre::calcul_signature($parametre_Libelle, $parametre_Valeur, $parametre_Activable, $parametre_Actif));
                $mf_cle_unique = text_sql(Hook_parametre::calcul_cle_unique($parametre_Libelle, $parametre_Valeur, $parametre_Activable, $parametre_Actif));
                $mf_colonnes_a_modifier[] = 'mf_signature=\'' . $mf_signature . '\'';
                $mf_colonnes_a_modifier[] = 'mf_cle_unique=\'' . $mf_cle_unique . '\'';
                $mf_colonnes_a_modifier[] = 'mf_date_modification=\'' . get_now() . '\'';
                $requete = 'UPDATE '.inst('parametre').' SET ' . enumeration($mf_colonnes_a_modifier) . ' WHERE Code_parametre = ' . $Code_parametre . ';';
                $cle = md5($requete).salt(10);
                self::$cache_db->pause($cle);
                executer_requete_mysql( $requete , true);
                if ( requete_mysqli_affected_rows()==0 )
                {
                    $code_erreur = ERR_PARAMETRE__MODIFIER__AUCUN_CHANGEMENT;
                    self::$cache_db->reprendre($cle);
                }
                else
                {
                    self::$cache_db->clear();
                    self::$cache_db->reprendre($cle);
                    Hook_parametre::modifier($Code_parametre, $bool__parametre_Libelle, $bool__parametre_Valeur, $bool__parametre_Activable, $bool__parametre_Actif);
                }
            }
            else
            {
                $code_erreur = ERR_PARAMETRE__MODIFIER__AUCUN_CHANGEMENT;
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
        return array('code_erreur' => $code_erreur, 'callback' => ( $code_erreur == 0 ? Hook_parametre::callback_put($Code_parametre) : null ));
    }

    public function mf_modifier_2($lignes, $force=false) // array( $Code_parametre => array('colonne1' => 'valeur1',  [...] ) )
    {
        $code_erreur = 0;
        foreach ( $lignes as $Code_parametre => $colonnes )
        {
            if ( $code_erreur==0 )
            {
                $Code_parametre = round($Code_parametre);
                $parametre = $this->mf_get_2($Code_parametre, array('autocompletion' => false));
                if (!$force)
                {
                    if (!self::$maj_droits_modifier_en_cours)
                    {
                        self::$maj_droits_modifier_en_cours = true;
                        Hook_parametre::hook_actualiser_les_droits_modifier($Code_parametre);
                        self::$maj_droits_modifier_en_cours = false;
                    }
                }
                $parametre_Libelle = ( isset($colonnes['parametre_Libelle']) && ( $force || mf_matrice_droits(['api_modifier__parametre_Libelle', 'parametre__MODIFIER']) ) ? $colonnes['parametre_Libelle'] : ( isset($parametre['parametre_Libelle']) ? $parametre['parametre_Libelle'] : '' ) );
                $parametre_Valeur = ( isset($colonnes['parametre_Valeur']) && ( $force || mf_matrice_droits(['api_modifier__parametre_Valeur', 'parametre__MODIFIER']) ) ? $colonnes['parametre_Valeur'] : ( isset($parametre['parametre_Valeur']) ? $parametre['parametre_Valeur'] : '' ) );
                $parametre_Activable = ( isset($colonnes['parametre_Activable']) && ( $force || mf_matrice_droits(['api_modifier__parametre_Activable', 'parametre__MODIFIER']) ) ? $colonnes['parametre_Activable'] : ( isset($parametre['parametre_Activable']) ? $parametre['parametre_Activable'] : '' ) );
                $parametre_Actif = ( isset($colonnes['parametre_Actif']) && ( $force || mf_matrice_droits(['api_modifier__parametre_Actif', 'parametre__MODIFIER']) ) ? $colonnes['parametre_Actif'] : ( isset($parametre['parametre_Actif']) ? $parametre['parametre_Actif'] : '' ) );
                $retour = $this->mf_modifier($Code_parametre, $parametre_Libelle, $parametre_Valeur, $parametre_Activable, $parametre_Actif, true);
                if ( $retour['code_erreur']!=0 && $retour['code_erreur'] != ERR_PARAMETRE__MODIFIER__AUCUN_CHANGEMENT )
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

    public function mf_modifier_3($lignes) // array( $Code_parametre => array('colonne1' => 'valeur1',  [...] ) )
    {
        $code_erreur = 0;
        $modifs = false;

        // transformation des lignes en colonnes
        $valeurs_en_colonnes=array();
        $indices_par_colonne=array();
        $liste_valeurs_indexees=array();
        foreach ( $lignes as $Code_parametre => $colonnes )
        {
            foreach ($colonnes as $colonne => $valeur)
            {
                if ( $colonne=='parametre_Libelle' || $colonne=='parametre_Valeur' || $colonne=='parametre_Activable' || $colonne=='parametre_Actif' )
                {
                    $valeurs_en_colonnes[$colonne][$Code_parametre]=$valeur;
                    $indices_par_colonne[$colonne][]=$Code_parametre;
                    $liste_valeurs_indexees[$colonne][''.$valeur][]=$Code_parametre;
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
                $modification_sql = $colonne . ' = CASE Code_parametre';
                foreach ( $valeurs as $Code_parametre => $valeur )
                {
                    $modification_sql.=' WHEN ' . $Code_parametre . ' THEN ' . format_sql($colonne, $valeur);
                }
                $modification_sql.=' END';
                $perimetre = Sql_Format_Liste($indices_par_colonne[$colonne]);
                executer_requete_mysql('UPDATE ' . inst('parametre') . ' SET ' . $modification_sql . ' WHERE Code_parametre IN ' . $perimetre . ';', true);
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
                    executer_requete_mysql('UPDATE ' . inst('parametre') . ' SET ' . $colonne . ' = ' . format_sql($colonne, $valeur) . ' WHERE Code_parametre IN ' . $perimetre . ';', true);
                    if ( requete_mysqli_affected_rows()!=0 )
                    {
                        $modifs = true;
                    }
                }
            }
        }

        if ( ! $modifs && $code_erreur==0 )
        {
            $code_erreur = ERR_PARAMETRE__MODIFIER_3__AUCUN_CHANGEMENT;
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
        if ( isset($data['parametre_Libelle']) ) { $mf_colonnes_a_modifier[] = 'parametre_Libelle = ' . format_sql('parametre_Libelle', $data['parametre_Libelle']); }
        if ( isset($data['parametre_Valeur']) ) { $mf_colonnes_a_modifier[] = 'parametre_Valeur = ' . format_sql('parametre_Valeur', $data['parametre_Valeur']); }
        if ( isset($data['parametre_Activable']) ) { $mf_colonnes_a_modifier[] = 'parametre_Activable = ' . format_sql('parametre_Activable', $data['parametre_Activable']); }
        if ( isset($data['parametre_Actif']) ) { $mf_colonnes_a_modifier[] = 'parametre_Actif = ' . format_sql('parametre_Actif', $data['parametre_Actif']); }
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

            $requete = 'UPDATE ' . inst('parametre') . ' SET ' . enumeration($mf_colonnes_a_modifier) . " WHERE 1$argument_cond;";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_PARAMETRE__MODIFIER_4__AUCUN_CHANGEMENT;
            }
            else
            {
                self::$cache_db->clear();
            }
            self::$cache_db->reprendre($cle);
        }
        return array('code_erreur' => $code_erreur);
    }

    public function mf_supprimer($Code_parametre, $force=false)
    {
        $code_erreur = 0;
        $Code_parametre = round($Code_parametre);
        if (!$force)
        {
            if (!self::$maj_droits_supprimer_en_cours)
            {
                self::$maj_droits_supprimer_en_cours = true;
                Hook_parametre::hook_actualiser_les_droits_supprimer($Code_parametre);
                self::$maj_droits_supprimer_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['parametre__SUPPRIMER']) ) $code_erreur = REFUS_PARAMETRE__SUPPRIMER;
        elseif ( !$this->mf_tester_existance_Code_parametre($Code_parametre) ) $code_erreur = ERR_PARAMETRE__SUPPRIMER_2__CODE_PARAMETRE_INEXISTANT;
        elseif ( CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_parametre', $Code_parametre) ) $code_erreur = ACCES_CODE_PARAMETRE_REFUSE;
        elseif ( !Hook_parametre::autorisation_suppression($Code_parametre) ) $code_erreur = REFUS_PARAMETRE__SUPPRESSION_BLOQUEE;
        else
        {
            $copie__parametre = $this->mf_get($Code_parametre, array('autocompletion' => false));
            $this->supprimer_donnes_en_cascade("parametre", array($Code_parametre));
            $requete = "DELETE IGNORE FROM ".inst('parametre')." WHERE Code_parametre=$Code_parametre;";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_PARAMETRE__SUPPRIMER__REFUSEE;
                self::$cache_db->reprendre($cle);
            }
            else
            {
                self::$cache_db->clear();
                self::$cache_db->reprendre($cle);
                Hook_parametre::supprimer($copie__parametre);
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

    public function mf_supprimer_2($liste_Code_parametre, $force=false)
    {
        $code_erreur=0;
        $copie__liste_parametre = $this->mf_lister_2($liste_Code_parametre, array('autocompletion' => false));
        $liste_Code_parametre=array();
        foreach ( $copie__liste_parametre as $copie__parametre )
        {
            $Code_parametre = $copie__parametre['Code_parametre'];
            if (!$force)
            {
                if (!self::$maj_droits_supprimer_en_cours)
                {
                    self::$maj_droits_supprimer_en_cours = true;
                    Hook_parametre::hook_actualiser_les_droits_supprimer($Code_parametre);
                    self::$maj_droits_supprimer_en_cours = false;
                }
            }
            if ( !$force && !mf_matrice_droits(['parametre__SUPPRIMER']) ) $code_erreur = REFUS_PARAMETRE__SUPPRIMER;
            elseif ( !Hook_parametre::autorisation_suppression($Code_parametre) ) $code_erreur = REFUS_PARAMETRE__SUPPRESSION_BLOQUEE;
            {
                $liste_Code_parametre[] = $Code_parametre;
            }
        }
        if ( $code_erreur==0 && count($liste_Code_parametre)>0 )
        {
            $this->supprimer_donnes_en_cascade("parametre", $liste_Code_parametre);
            $requete = "DELETE IGNORE FROM ".inst('parametre')." WHERE Code_parametre IN ".Sql_Format_Liste($liste_Code_parametre).";";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_PARAMETRE__SUPPRIMER_2__REFUSEE;
                self::$cache_db->reprendre($cle);
            }
            else
            {
                self::$cache_db->clear();
                self::$cache_db->reprendre($cle);
                Hook_parametre::supprimer_2($copie__liste_parametre);
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

    public function mf_supprimer_3($liste_Code_parametre)
    {
        $code_erreur=0;
        if ( count($liste_Code_parametre)>0 )
        {
            $this->supprimer_donnes_en_cascade("parametre", $liste_Code_parametre);
            $requete = "DELETE IGNORE FROM ".inst('parametre')." WHERE Code_parametre IN ".Sql_Format_Liste($liste_Code_parametre).";";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_PARAMETRE__SUPPRIMER_3__REFUSEE;
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
        if ( ! $contexte_parent && $mf_contexte['Code_parametre']!=0 )
        {
            $parametre = $this->mf_get( $mf_contexte['Code_parametre'], $options);
            return array( $parametre['Code_parametre'] => $parametre );
        }
        else
        {
            return $this->mf_lister($options);
        }
    }

    public function mf_lister($options = array( 'cond_mysql' => array(), 'tris' => array(), 'limit' => array(), 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ))
    {
        $cle = "parametre__lister";

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
            if ( isset($mf_tri_defaut_table['parametre']) )
            {
                $options['tris'] = $mf_tri_defaut_table['parametre'];
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
                    if ( strpos($argument_cond, 'parametre_Libelle')!==false ) { $liste_colonnes_a_indexer['parametre_Libelle'] = 'parametre_Libelle'; }
                    if ( strpos($argument_cond, 'parametre_Valeur')!==false ) { $liste_colonnes_a_indexer['parametre_Valeur'] = 'parametre_Valeur'; }
                    if ( strpos($argument_cond, 'parametre_Activable')!==false ) { $liste_colonnes_a_indexer['parametre_Activable'] = 'parametre_Activable'; }
                    if ( strpos($argument_cond, 'parametre_Actif')!==false ) { $liste_colonnes_a_indexer['parametre_Actif'] = 'parametre_Actif'; }
                }
                if ( isset($options['tris']) )
                {
                    if ( isset($options['tris']['parametre_Libelle']) ) { $liste_colonnes_a_indexer['parametre_Libelle'] = 'parametre_Libelle'; }
                    if ( isset($options['tris']['parametre_Valeur']) ) { $liste_colonnes_a_indexer['parametre_Valeur'] = 'parametre_Valeur'; }
                    if ( isset($options['tris']['parametre_Activable']) ) { $liste_colonnes_a_indexer['parametre_Activable'] = 'parametre_Activable'; }
                    if ( isset($options['tris']['parametre_Actif']) ) { $liste_colonnes_a_indexer['parametre_Actif'] = 'parametre_Actif'; }
                }
                if ( count($liste_colonnes_a_indexer)>0 )
                {
                    if ( ! $mf_liste_requete_index = self::$cache_db->read('parametre__index') )
                    {
                        $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('parametre').'`;', false);
                        $mf_liste_requete_index = array();
                        while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                        {
                            $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                        }
                        mysqli_free_result($res_requete_index);
                        self::$cache_db->write('parametre__index', $mf_liste_requete_index);
                    }
                    foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                    {
                        if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                    }
                    if ( count($liste_colonnes_a_indexer) > 0 )
                    {
                        self::$cache_db->pause('parametre__index');
                        foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                        {
                            executer_requete_mysql('ALTER TABLE `'.inst('parametre').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                        }
                        self::$cache_db->clear();
                        self::$cache_db->reprendre('parametre__index');
                    }
                }

                $liste = array();
                $liste_parametre_pas_a_jour = array();
                if ($toutes_colonnes)
                {
                    $colonnes='Code_parametre, parametre_Libelle, parametre_Valeur, parametre_Activable, parametre_Actif';
                }
                else
                {
                    $colonnes='Code_parametre, parametre_Libelle, parametre_Valeur, parametre_Activable, parametre_Actif';
                }
                $res_requete = executer_requete_mysql("SELECT $colonnes FROM ".inst('parametre')." WHERE 1{$argument_cond}{$argument_tris}{$argument_limit};", false);
                while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
                {
                    $liste[$row_requete['Code_parametre']]=$row_requete;
                    if ( $maj && ! Hook_parametre::est_a_jour( $row_requete ) )
                    {
                        $liste_parametre_pas_a_jour[$row_requete['Code_parametre']] = $row_requete;
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
                Hook_parametre::mettre_a_jour( $liste_parametre_pas_a_jour );
            }
        }

        foreach ($liste as $elem)
        {
            if ( $controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_parametre', $elem['Code_parametre']) )
            {
                unset($liste[$elem['Code_parametre']]);
            }
            else
            {
                if (!self::$auto_completion && $autocompletion)
                {
                    self::$auto_completion = true;
                    Hook_parametre::completion($liste[$elem['Code_parametre']]);
                    self::$auto_completion = false;
                }
            }
        }

        return $liste;
    }

    public function mf_lister_2($liste_Code_parametre, $options = array( 'cond_mysql' => array(), 'tris' => array(), 'limit' => array(), 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ))
    {
        if ( count($liste_Code_parametre)>0 )
        {
            $cle = "parametre__mf_lister_2_".Sql_Format_Liste($liste_Code_parametre);

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
                if ( isset($mf_tri_defaut_table['parametre']) )
                {
                    $options['tris'] = $mf_tri_defaut_table['parametre'];
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
                        if ( strpos($argument_cond, 'parametre_Libelle')!==false ) { $liste_colonnes_a_indexer['parametre_Libelle'] = 'parametre_Libelle'; }
                        if ( strpos($argument_cond, 'parametre_Valeur')!==false ) { $liste_colonnes_a_indexer['parametre_Valeur'] = 'parametre_Valeur'; }
                        if ( strpos($argument_cond, 'parametre_Activable')!==false ) { $liste_colonnes_a_indexer['parametre_Activable'] = 'parametre_Activable'; }
                        if ( strpos($argument_cond, 'parametre_Actif')!==false ) { $liste_colonnes_a_indexer['parametre_Actif'] = 'parametre_Actif'; }
                    }
                    if ( isset($options['tris']) )
                    {
                        if ( isset($options['tris']['parametre_Libelle']) ) { $liste_colonnes_a_indexer['parametre_Libelle'] = 'parametre_Libelle'; }
                        if ( isset($options['tris']['parametre_Valeur']) ) { $liste_colonnes_a_indexer['parametre_Valeur'] = 'parametre_Valeur'; }
                        if ( isset($options['tris']['parametre_Activable']) ) { $liste_colonnes_a_indexer['parametre_Activable'] = 'parametre_Activable'; }
                        if ( isset($options['tris']['parametre_Actif']) ) { $liste_colonnes_a_indexer['parametre_Actif'] = 'parametre_Actif'; }
                    }
                    if ( count($liste_colonnes_a_indexer)>0 )
                    {
                        if ( ! $mf_liste_requete_index = self::$cache_db->read('parametre__index') )
                        {
                            $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('parametre').'`;', false);
                            $mf_liste_requete_index = array();
                            while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                            {
                                $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                            }
                            mysqli_free_result($res_requete_index);
                            self::$cache_db->write('parametre__index', $mf_liste_requete_index);
                        }
                        foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                        {
                            if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                        }
                        if ( count($liste_colonnes_a_indexer) > 0 )
                        {
                            self::$cache_db->pause('parametre__index');
                            foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                            {
                                executer_requete_mysql('ALTER TABLE `'.inst('parametre').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                            }
                            self::$cache_db->clear();
                            self::$cache_db->reprendre('parametre__index');
                        }
                    }

                    $liste = array();
                    $liste_parametre_pas_a_jour = array();
                    if ($toutes_colonnes)
                    {
                        $colonnes='Code_parametre, parametre_Libelle, parametre_Valeur, parametre_Activable, parametre_Actif';
                    }
                    else
                    {
                        $colonnes='Code_parametre, parametre_Libelle, parametre_Valeur, parametre_Activable, parametre_Actif';
                    }
                    $res_requete = executer_requete_mysql("SELECT $colonnes FROM ".inst('parametre')." WHERE 1{$argument_cond} AND Code_parametre IN ".Sql_Format_Liste($liste_Code_parametre)."{$argument_tris}{$argument_limit};", false);
                    while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
                    {
                        $liste[$row_requete['Code_parametre']]=$row_requete;
                        if ( $maj && ! Hook_parametre::est_a_jour( $row_requete ) )
                        {
                            $liste_parametre_pas_a_jour[$row_requete['Code_parametre']] = $row_requete;
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
                    Hook_parametre::mettre_a_jour( $liste_parametre_pas_a_jour );
                }
            }

            foreach ($liste as $elem)
            {
                if ( $controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_parametre', $elem['Code_parametre']) )
                {
                    unset($liste[$elem['Code_parametre']]);
                }
                else
                {
                    if (!self::$auto_completion && $autocompletion)
                    {
                        self::$auto_completion = true;
                        Hook_parametre::completion($liste[$elem['Code_parametre']]);
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

    public function mf_get($Code_parametre, $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ])
    {
        $Code_parametre = round($Code_parametre);
        $retour = array();
        if ( ! CONTROLE_ACCES_DONNEES_DEFAUT || Hook_mf_systeme::controle_acces_donnees('Code_parametre', $Code_parametre) )
        {
            $cle = 'parametre__get_'.$Code_parametre;

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
                        $colonnes='Code_parametre, parametre_Libelle, parametre_Valeur, parametre_Activable, parametre_Actif';
                    }
                    else
                    {
                        $colonnes='Code_parametre, parametre_Libelle, parametre_Valeur, parametre_Activable, parametre_Actif';
                    }
                    $res_requete = executer_requete_mysql('SELECT ' . $colonnes . ' FROM ' . inst('parametre') . ' WHERE Code_parametre = ' . $Code_parametre . ';', false);
                    if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
                    {
                        $retour=$row_requete;
                        if ( $maj && ! Hook_parametre::est_a_jour( $row_requete ) )
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
                    Hook_parametre::mettre_a_jour( array( $row_requete['Code_parametre'] => $row_requete ) );
                }
            }
            if ( isset( $retour['Code_parametre'] ) )
            {
                if (!self::$auto_completion && $autocompletion)
                {
                    self::$auto_completion = true;
                    Hook_parametre::completion($retour);
                    self::$auto_completion = false;
                }
            }
        }
        return $retour;
    }

    public function mf_get_last($options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ])
    {
        $cle = "parametre__get_last";
        if ( ! $retour = self::$cache_db->read($cle) )
        {
            $Code_parametre = 0;
            $res_requete = executer_requete_mysql('SELECT Code_parametre FROM ' . inst('parametre') . " WHERE 1 ORDER BY mf_date_creation DESC, Code_parametre DESC LIMIT 0 , 1;", false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $Code_parametre = $row_requete['Code_parametre'];
            }
            mysqli_free_result($res_requete);
            $retour = $this->mf_get($Code_parametre, $options);
            self::$cache_db->write($cle, $retour);
        }
        return $retour;
    }

    public function mf_get_2($Code_parametre, $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ])
    {
        $Code_parametre = round($Code_parametre);
        $retour = array();
        $cle = 'parametre__get_'.$Code_parametre;

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
                $colonnes='Code_parametre, parametre_Libelle, parametre_Valeur, parametre_Activable, parametre_Actif';
            }
            else
            {
                $colonnes='Code_parametre, parametre_Libelle, parametre_Valeur, parametre_Activable, parametre_Actif';
            }
            $res_requete = executer_requete_mysql('SELECT ' . $colonnes . " FROM ".inst('parametre')." WHERE Code_parametre = $Code_parametre;", false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $retour=$row_requete;
            }
            mysqli_free_result($res_requete);
            self::$cache_db->write($cle, $retour);
        }
        if ( isset( $retour['Code_parametre'] ) )
        {
            if (!self::$auto_completion && $autocompletion)
            {
                self::$auto_completion = true;
                Hook_parametre::completion($retour);
                self::$auto_completion = false;
            }
        }
        return $retour;
    }

    public function mf_prec_et_suiv($Code_parametre, $options = array( 'cond_mysql' => array(), 'tris' => array(), 'limit' => array(), 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ))
    {
        $Code_parametre = round($Code_parametre);
        $liste = $this->mf_lister($options);
        return prec_suiv($liste, $Code_parametre);
    }

    public function mf_compter($options = array( 'cond_mysql' => array() ))
    {
        $cle = 'parametre__compter';

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
                if ( strpos($argument_cond, 'parametre_Libelle')!==false ) { $liste_colonnes_a_indexer['parametre_Libelle'] = 'parametre_Libelle'; }
                if ( strpos($argument_cond, 'parametre_Valeur')!==false ) { $liste_colonnes_a_indexer['parametre_Valeur'] = 'parametre_Valeur'; }
                if ( strpos($argument_cond, 'parametre_Activable')!==false ) { $liste_colonnes_a_indexer['parametre_Activable'] = 'parametre_Activable'; }
                if ( strpos($argument_cond, 'parametre_Actif')!==false ) { $liste_colonnes_a_indexer['parametre_Actif'] = 'parametre_Actif'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = self::$cache_db->read('parametre__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('parametre').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    self::$cache_db->write('parametre__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    self::$cache_db->pause('parametre__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('parametre').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    self::$cache_db->clear();
                    self::$cache_db->reprendre('parametre__index');
                }
            }

            $res_requete = executer_requete_mysql("SELECT count(Code_parametre) as nb FROM ".inst('parametre')." WHERE 1{$argument_cond};", false);
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

    public function mf_liste_Code_parametre($options = array( 'cond_mysql' => array() ))
    {
        return $this->get_liste_Code_parametre($options);
    }

    public function mf_get_liste_tables_enfants()
    {
        return $this->get_liste_tables_enfants( 'parametre' );
    }

    public function mf_get_liste_tables_parents()
    {
        return array();
    }

    public function mf_search_parametre_Libelle( $parametre_Libelle )
    {
        return $this->rechercher_parametre_Libelle( $parametre_Libelle );
    }

    public function mf_search_parametre_Valeur( $parametre_Valeur )
    {
        return $this->rechercher_parametre_Valeur( $parametre_Valeur );
    }

    public function mf_search_parametre_Activable( $parametre_Activable )
    {
        return $this->rechercher_parametre_Activable( $parametre_Activable );
    }

    public function mf_search_parametre_Actif( $parametre_Actif )
    {
        return $this->rechercher_parametre_Actif( $parametre_Actif );
    }

    public function mf_search__colonne( $colonne_db, $recherche )
    {
        switch ($colonne_db) {
            case 'parametre_Libelle': return $this->mf_search_parametre_Libelle( $recherche ); break;
            case 'parametre_Valeur': return $this->mf_search_parametre_Valeur( $recherche ); break;
            case 'parametre_Activable': return $this->mf_search_parametre_Activable( $recherche ); break;
            case 'parametre_Actif': return $this->mf_search_parametre_Actif( $recherche ); break;
        }
    }

    public function mf_get_next_id()
    {
        $res_requete = executer_requete_mysql('SELECT AUTO_INCREMENT as next_id FROM INFORMATION_SCHEMA.TABLES WHERE table_name = \'parametre\';', false);
        $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC);
        mysqli_free_result($res_requete);
        return round($row_requete['next_id']);
    }

    public function mf_search($ligne) // array('colonne1' => 'valeur1',  [...] )
    {
        global $mf_initialisation;
        $parametre_Libelle = (isset($ligne['parametre_Libelle'])?$ligne['parametre_Libelle']:$mf_initialisation['parametre_Libelle']);
        $parametre_Valeur = (isset($ligne['parametre_Valeur'])?$ligne['parametre_Valeur']:$mf_initialisation['parametre_Valeur']);
        $parametre_Activable = (isset($ligne['parametre_Activable'])?$ligne['parametre_Activable']:$mf_initialisation['parametre_Activable']);
        $parametre_Actif = (isset($ligne['parametre_Actif'])?$ligne['parametre_Actif']:$mf_initialisation['parametre_Actif']);
        $parametre_Valeur = round($parametre_Valeur);
        Hook_parametre::pre_controller($parametre_Libelle, $parametre_Valeur, $parametre_Activable, $parametre_Actif);
        $mf_cle_unique = Hook_parametre::calcul_cle_unique($parametre_Libelle, $parametre_Valeur, $parametre_Activable, $parametre_Actif);
        $res_requete = executer_requete_mysql('SELECT Code_parametre FROM ' . inst('parametre') . ' WHERE mf_cle_unique = \''.$mf_cle_unique.'\'', false);
        if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
        {
            $r = round($row_requete['Code_parametre']);
        }
        else
        {
            $r = false;
        }
        mysqli_free_result($res_requete);
        return $r;
    }

}
