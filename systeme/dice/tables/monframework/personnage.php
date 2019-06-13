<?php

/*
    +------------------------------+
    |  NE PAS MODIFIER CE FICHIER  |
    +------------------------------+
*/

class personnage_monframework extends entite_monframework
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
            include_once __DIR__ . '/../../erreurs/erreurs__personnage.php';
            self::$initialisation = false;
            Hook_personnage::initialisation();
            self::$cache_db = new Mf_Cachedb('personnage');
        }
        if (!self::$actualisation_en_cours)
        {
            self::$actualisation_en_cours=true;
            Hook_personnage::actualisation();
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

        if ( ! test_si_table_existe(inst('personnage')) )
        {
            executer_requete_mysql('CREATE TABLE '.inst('personnage').'(Code_personnage INT AUTO_INCREMENT NOT NULL, PRIMARY KEY (Code_personnage)) ENGINE=MyISAM;', true);
        }

        $liste_colonnes = lister_les_colonnes(inst('personnage'));

        if ( isset($liste_colonnes['personnage_Fichier_Fichier']) )
        {
            if ( typeMyql2Sql($liste_colonnes['personnage_Fichier_Fichier']['Type'])!='VARCHAR' )
            {
                executer_requete_mysql('ALTER TABLE '.inst('personnage').' CHANGE personnage_Fichier_Fichier personnage_Fichier_Fichier VARCHAR(255);', true);
            }
            unset($liste_colonnes['personnage_Fichier_Fichier']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('personnage').' ADD personnage_Fichier_Fichier VARCHAR(255);', true);
            executer_requete_mysql('UPDATE '.inst('personnage').' SET personnage_Fichier_Fichier=' . format_sql('personnage_Fichier_Fichier', $mf_initialisation['personnage_Fichier_Fichier']) . ';', true);
        }

        if ( isset($liste_colonnes['personnage_Conservation']) )
        {
            if ( typeMyql2Sql($liste_colonnes['personnage_Conservation']['Type'])!='BOOL' )
            {
                executer_requete_mysql('ALTER TABLE '.inst('personnage').' CHANGE personnage_Conservation personnage_Conservation BOOL;', true);
            }
            unset($liste_colonnes['personnage_Conservation']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('personnage').' ADD personnage_Conservation BOOL;', true);
            executer_requete_mysql('UPDATE '.inst('personnage').' SET personnage_Conservation=' . format_sql('personnage_Conservation', $mf_initialisation['personnage_Conservation']) . ';', true);
        }

        if ( isset($liste_colonnes['Code_joueur']) )
        {
            unset($liste_colonnes['Code_joueur']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('personnage').' ADD Code_joueur int NOT NULL;', true);
        }

        if ( isset($liste_colonnes['Code_groupe']) )
        {
            unset($liste_colonnes['Code_groupe']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('personnage').' ADD Code_groupe int NOT NULL;', true);
        }

        if ( isset($liste_colonnes['mf_signature']) )
        {
            unset($liste_colonnes['mf_signature']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('personnage').' ADD mf_signature VARCHAR(255);', true);
            executer_requete_mysql('ALTER TABLE '.inst('personnage').' ADD INDEX( mf_signature );', true);
        }

        if ( isset($liste_colonnes['mf_cle_unique']) )
        {
            unset($liste_colonnes['mf_cle_unique']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('personnage').' ADD mf_cle_unique VARCHAR(255);', true);
            executer_requete_mysql('ALTER TABLE '.inst('personnage').' ADD INDEX( mf_cle_unique );', true);
        }

        if ( isset($liste_colonnes['mf_date_creation']) )
        {
            unset($liste_colonnes['mf_date_creation']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('personnage').' ADD mf_date_creation DATETIME;', true);
            executer_requete_mysql('ALTER TABLE '.inst('personnage').' ADD INDEX( mf_date_creation );', true);
        }

        if ( isset($liste_colonnes['mf_date_modification']) )
        {
            unset($liste_colonnes['mf_date_modification']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('personnage').' ADD mf_date_modification DATETIME;', true);
            executer_requete_mysql('ALTER TABLE '.inst('personnage').' ADD INDEX( mf_date_modification );', true);
        }

        unset($liste_colonnes['Code_personnage']);

        foreach ($liste_colonnes as $field => $value)
        {
            executer_requete_mysql('ALTER TABLE '.inst('personnage').' DROP COLUMN '.$field.';', true);
        }

    }

    public function mfi_ajouter_auto($interface)
    {
        if (isset($interface['Code_joueur'])) { $liste_Code_joueur = array($interface['Code_joueur']); }
        elseif (isset($interface['liste_Code_joueur'])) { $liste_Code_joueur = $interface['liste_Code_joueur']; }
        else { $liste_Code_joueur = $this->get_liste_Code_joueur(); }
        if (isset($interface['Code_groupe'])) { $liste_Code_groupe = array($interface['Code_groupe']); }
        elseif (isset($interface['liste_Code_groupe'])) { $liste_Code_groupe = $interface['liste_Code_groupe']; }
        else { $liste_Code_groupe = $this->get_liste_Code_groupe(); }
        $liste_personnage = array();
        foreach ($liste_Code_joueur as $Code_joueur)
        {
            foreach ($liste_Code_groupe as $Code_groupe)
            {
                $liste_personnage[] = array('Code_joueur'=>$Code_joueur,'Code_groupe'=>$Code_groupe);
            }
        }
        if (isset($interface['personnage_Fichier_Fichier'])) { foreach ($liste_personnage as &$personnage) { $personnage['personnage_Fichier_Fichier'] = $interface['personnage_Fichier_Fichier']; } unset($personnage); }
        if (isset($interface['personnage_Conservation'])) { foreach ($liste_personnage as &$personnage) { $personnage['personnage_Conservation'] = $interface['personnage_Conservation']; } unset($personnage); }
        return $this->mf_ajouter_3($liste_personnage);
    }

    public function mfi_supprimer_auto($interface)
    {
        if (isset($interface['Code_joueur'])) { $liste_Code_joueur = array($interface['Code_joueur']); }
        elseif (isset($interface['liste_Code_joueur'])) { $liste_Code_joueur = $interface['liste_Code_joueur']; }
        else { $liste_Code_joueur = $this->get_liste_Code_joueur(); }
        if (isset($interface['Code_groupe'])) { $liste_Code_groupe = array($interface['Code_groupe']); }
        elseif (isset($interface['liste_Code_groupe'])) { $liste_Code_groupe = $interface['liste_Code_groupe']; }
        else { $liste_Code_groupe = $this->get_liste_Code_groupe(); }
        $liste_Code_personnage = $this->liste_Code_joueur_vers_liste_Code_personnage($liste_Code_joueur);
        $liste_Code_personnage = liste_intersection_A_et_B($liste_Code_personnage,$this->liste_Code_groupe_vers_liste_Code_personnage($liste_Code_groupe));
        $this->mf_supprimer_3($liste_Code_personnage);
    }

    public function mf_ajouter($personnage_Fichier_Fichier, $personnage_Conservation, $Code_joueur, $Code_groupe, $force=false)
    {
        $Code_personnage = 0;
        $code_erreur = 0;
        $Code_joueur = round($Code_joueur);
        $Code_groupe = round($Code_groupe);
        Hook_personnage::pre_controller($personnage_Fichier_Fichier, $personnage_Conservation, $Code_joueur, $Code_groupe);
        if (!$force)
        {
            if (!self::$maj_droits_ajouter_en_cours)
            {
                self::$maj_droits_ajouter_en_cours = true;
                Hook_personnage::hook_actualiser_les_droits_ajouter($Code_joueur, $Code_groupe);
                self::$maj_droits_ajouter_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['personnage__AJOUTER']) ) $code_erreur = REFUS_PERSONNAGE__AJOUTER;
        elseif ( !$this->mf_tester_existance_Code_joueur($Code_joueur) ) $code_erreur = ERR_PERSONNAGE__AJOUTER__CODE_JOUEUR_INEXISTANT;
        elseif ( !$this->mf_tester_existance_Code_groupe($Code_groupe) ) $code_erreur = ERR_PERSONNAGE__AJOUTER__CODE_GROUPE_INEXISTANT;
        elseif ( CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_joueur', $Code_joueur) ) $code_erreur = ACCES_CODE_JOUEUR_REFUSE;
        elseif ( CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_groupe', $Code_groupe) ) $code_erreur = ACCES_CODE_GROUPE_REFUSE;
        elseif ( !Hook_personnage::autorisation_ajout($personnage_Fichier_Fichier, $personnage_Conservation, $Code_joueur, $Code_groupe) ) $code_erreur = REFUS_PERSONNAGE__AJOUT_BLOQUEE;
        else
        {
            Hook_personnage::data_controller($personnage_Fichier_Fichier, $personnage_Conservation, $Code_joueur, $Code_groupe);
            $mf_signature = text_sql(Hook_personnage::calcul_signature($personnage_Fichier_Fichier, $personnage_Conservation, $Code_joueur, $Code_groupe));
            $mf_cle_unique = text_sql(Hook_personnage::calcul_cle_unique($personnage_Fichier_Fichier, $personnage_Conservation, $Code_joueur, $Code_groupe));
            $personnage_Fichier_Fichier = text_sql($personnage_Fichier_Fichier);
            $personnage_Conservation = ($personnage_Conservation==1 ? 1 : 0);
            $requete = "INSERT INTO ".inst('personnage')." ( mf_signature, mf_cle_unique, mf_date_creation, mf_date_modification, personnage_Fichier_Fichier, personnage_Conservation, Code_joueur, Code_groupe ) VALUES ( '$mf_signature', '$mf_cle_unique', '".get_now()."', '".get_now()."', '$personnage_Fichier_Fichier', $personnage_Conservation, $Code_joueur, $Code_groupe );";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql($requete, true);
            $Code_personnage = requete_mysql_insert_id();
            if ($Code_personnage==0)
            {
                $code_erreur = ERR_PERSONNAGE__AJOUTER__AJOUT_REFUSE;
                self::$cache_db->reprendre($cle);
            }
            else
            {
                self::$cache_db->clear();
                self::$cache_db->reprendre($cle);
                Hook_personnage::ajouter( $Code_personnage );
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
        return array('code_erreur' => $code_erreur, 'Code_personnage' => $Code_personnage, 'callback' => ( $code_erreur==0 ? Hook_personnage::callback_post($Code_personnage) : null ));
    }

    public function mf_creer($Code_joueur, $Code_groupe, $force=false)
    {
        global $mf_initialisation, $mf_droits_defaut;
        $mf_droits_defaut["personnage__AJOUTER"] = $mf_droits_defaut["personnage__CREER"];
        $personnage_Fichier_Fichier = $mf_initialisation['personnage_Fichier_Fichier'];
        $personnage_Conservation = $mf_initialisation['personnage_Conservation'];
        return $this->mf_ajouter($personnage_Fichier_Fichier, $personnage_Conservation, $Code_joueur, $Code_groupe, $force);
    }

    public function mf_ajouter_2($ligne, $force=false) // array('colonne1' => 'valeur1',  [...] )
    {
        global $mf_initialisation;
        $Code_joueur = (isset($ligne['Code_joueur'])?round($ligne['Code_joueur']):get_joueur_courant('Code_joueur'));
        $Code_groupe = (isset($ligne['Code_groupe'])?round($ligne['Code_groupe']):0);
        $personnage_Fichier_Fichier = (isset($ligne['personnage_Fichier_Fichier'])?$ligne['personnage_Fichier_Fichier']:$mf_initialisation['personnage_Fichier_Fichier']);
        $personnage_Conservation = (isset($ligne['personnage_Conservation'])?$ligne['personnage_Conservation']:$mf_initialisation['personnage_Conservation']);
        return $this->mf_ajouter($personnage_Fichier_Fichier, $personnage_Conservation, $Code_joueur, $Code_groupe, $force);
    }

    public function mf_ajouter_3($lignes) // array( array( 'colonne1' => 'valeur1', 'colonne2' => 'valeur2',  [...] ), [...] )
    {
        global $mf_initialisation;
        $code_erreur = 0;
        $values = '';
        foreach ($lignes as $ligne)
        {
            $Code_joueur = (isset($ligne['Code_joueur'])?round($ligne['Code_joueur']):0);
            $Code_groupe = (isset($ligne['Code_groupe'])?round($ligne['Code_groupe']):0);
            $personnage_Fichier_Fichier = text_sql(isset($ligne['personnage_Fichier_Fichier'])?$ligne['personnage_Fichier_Fichier']:$mf_initialisation['personnage_Fichier_Fichier']);
            $personnage_Conservation = (isset($ligne['personnage_Conservation'])?$ligne['personnage_Conservation']:$mf_initialisation['personnage_Conservation']==1 ? 1 : 0);
            if ($Code_joueur != 0)
            {
                if ($Code_groupe != 0)
                {
                    $values.=($values!="" ? "," : "")."('$personnage_Fichier_Fichier', $personnage_Conservation, $Code_joueur, $Code_groupe)";
                }
            }
        }
        if ($values!='')
        {
            $requete = "INSERT INTO ".inst('personnage')." ( personnage_Fichier_Fichier, personnage_Conservation, Code_joueur, Code_groupe ) VALUES $values;";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            $n = requete_mysqli_affected_rows();
            if ($n < count($lignes))
            {
                $code_erreur = ERR_PERSONNAGE__AJOUTER_3__ECHEC_AJOUT;
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

    public function mf_modifier($Code_personnage, $personnage_Fichier_Fichier, $personnage_Conservation, $Code_joueur=0, $Code_groupe=0, $force=false)
    {
        $code_erreur = 0;
        $Code_personnage = round($Code_personnage);
        $Code_joueur = round($Code_joueur);
        $Code_groupe = round($Code_groupe);
        Hook_personnage::pre_controller($personnage_Fichier_Fichier, $personnage_Conservation, $Code_joueur, $Code_groupe, $Code_personnage);
        if (!$force)
        {
            if (!self::$maj_droits_modifier_en_cours)
            {
                self::$maj_droits_modifier_en_cours = true;
                Hook_personnage::hook_actualiser_les_droits_modifier($Code_personnage);
                self::$maj_droits_modifier_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['personnage__MODIFIER']) ) $code_erreur = REFUS_PERSONNAGE__MODIFIER;
        elseif ( !$this->mf_tester_existance_Code_personnage($Code_personnage) ) $code_erreur = ERR_PERSONNAGE__MODIFIER__CODE_PERSONNAGE_INEXISTANT;
        elseif ( $Code_joueur!=0 && !$this->mf_tester_existance_Code_joueur($Code_joueur) ) $code_erreur = ERR_PERSONNAGE__MODIFIER__CODE_JOUEUR_INEXISTANT;
        elseif ( $Code_groupe!=0 && !$this->mf_tester_existance_Code_groupe($Code_groupe) ) $code_erreur = ERR_PERSONNAGE__MODIFIER__CODE_GROUPE_INEXISTANT;
        elseif ( CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_personnage', $Code_personnage) ) $code_erreur = ACCES_CODE_PERSONNAGE_REFUSE;
        elseif ( $Code_joueur!=0 && CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_joueur', $Code_joueur) ) $code_erreur = ACCES_CODE_JOUEUR_REFUSE;
        elseif ( $Code_groupe!=0 && CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_groupe', $Code_groupe) ) $code_erreur = ACCES_CODE_GROUPE_REFUSE;
        elseif ( !Hook_personnage::autorisation_modification($Code_personnage, $personnage_Fichier_Fichier, $personnage_Conservation, $Code_joueur, $Code_groupe) ) $code_erreur = REFUS_PERSONNAGE__MODIFICATION_BLOQUEE;
        else
        {
            Hook_personnage::data_controller($personnage_Fichier_Fichier, $personnage_Conservation, $Code_joueur, $Code_groupe, $Code_personnage);
            $personnage = $this->mf_get_2( $Code_personnage, array('autocompletion' => false, 'masquer_mdp' => false) );
            $mf_colonnes_a_modifier=[];
            $bool__personnage_Fichier_Fichier = false; if ( $personnage_Fichier_Fichier!=$personnage['personnage_Fichier_Fichier'] ) { Hook_personnage::data_controller__personnage_Fichier_Fichier($personnage['personnage_Fichier_Fichier'], $personnage_Fichier_Fichier, $Code_personnage); if ( $personnage_Fichier_Fichier!=$personnage['personnage_Fichier_Fichier'] ) { $mf_colonnes_a_modifier[] = 'personnage_Fichier_Fichier=' . format_sql('personnage_Fichier_Fichier', $personnage_Fichier_Fichier); $bool__personnage_Fichier_Fichier = true; } }
            $bool__personnage_Conservation = false; if ( $personnage_Conservation!=$personnage['personnage_Conservation'] ) { Hook_personnage::data_controller__personnage_Conservation($personnage['personnage_Conservation'], $personnage_Conservation, $Code_personnage); if ( $personnage_Conservation!=$personnage['personnage_Conservation'] ) { $mf_colonnes_a_modifier[] = 'personnage_Conservation=' . format_sql('personnage_Conservation', $personnage_Conservation); $bool__personnage_Conservation = true; } }
            $bool__Code_joueur = false; if ( $Code_joueur!=0 && $Code_joueur!=$personnage['Code_joueur'] ) { Hook_personnage::data_controller__Code_joueur($personnage['Code_joueur'], $Code_joueur, $Code_personnage); if ( $Code_joueur!=0 && $Code_joueur!=$personnage['Code_joueur'] ) { $mf_colonnes_a_modifier[] = 'Code_joueur=' . $Code_joueur; $bool__Code_joueur = true; } }
            $bool__Code_groupe = false; if ( $Code_groupe!=0 && $Code_groupe!=$personnage['Code_groupe'] ) { Hook_personnage::data_controller__Code_groupe($personnage['Code_groupe'], $Code_groupe, $Code_personnage); if ( $Code_groupe!=0 && $Code_groupe!=$personnage['Code_groupe'] ) { $mf_colonnes_a_modifier[] = 'Code_groupe=' . $Code_groupe; $bool__Code_groupe = true; } }
            if (count($mf_colonnes_a_modifier)>0) {
                $mf_signature = text_sql(Hook_personnage::calcul_signature($personnage_Fichier_Fichier, $personnage_Conservation, $Code_joueur, $Code_groupe));
                $mf_cle_unique = text_sql(Hook_personnage::calcul_cle_unique($personnage_Fichier_Fichier, $personnage_Conservation, $Code_joueur, $Code_groupe));
                $mf_colonnes_a_modifier[] = 'mf_signature=\'' . $mf_signature . '\'';
                $mf_colonnes_a_modifier[] = 'mf_cle_unique=\'' . $mf_cle_unique . '\'';
                $mf_colonnes_a_modifier[] = 'mf_date_modification=\'' . get_now() . '\'';
                $requete = 'UPDATE '.inst('personnage').' SET ' . enumeration($mf_colonnes_a_modifier) . ' WHERE Code_personnage = ' . $Code_personnage . ';';
                $cle = md5($requete).salt(10);
                self::$cache_db->pause($cle);
                executer_requete_mysql( $requete , true);
                if ( requete_mysqli_affected_rows()==0 )
                {
                    $code_erreur = ERR_PERSONNAGE__MODIFIER__AUCUN_CHANGEMENT;
                    self::$cache_db->reprendre($cle);
                }
                else
                {
                    self::$cache_db->clear();
                    self::$cache_db->reprendre($cle);
                    Hook_personnage::modifier($Code_personnage, $bool__personnage_Fichier_Fichier, $bool__personnage_Conservation, $bool__Code_joueur, $bool__Code_groupe);
                }
            }
            else
            {
                $code_erreur = ERR_PERSONNAGE__MODIFIER__AUCUN_CHANGEMENT;
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
        return array('code_erreur' => $code_erreur, 'callback' => ( $code_erreur == 0 ? Hook_personnage::callback_put($Code_personnage) : null ));
    }

    public function mf_modifier_2($lignes, $force=false) // array( $Code_personnage => array('colonne1' => 'valeur1',  [...] ) )
    {
        $code_erreur = 0;
        foreach ( $lignes as $Code_personnage => $colonnes )
        {
            if ( $code_erreur==0 )
            {
                $Code_personnage = round($Code_personnage);
                $personnage = $this->mf_get_2($Code_personnage, array('autocompletion' => false));
                if (!$force)
                {
                    if (!self::$maj_droits_modifier_en_cours)
                    {
                        self::$maj_droits_modifier_en_cours = true;
                        Hook_personnage::hook_actualiser_les_droits_modifier($Code_personnage);
                        self::$maj_droits_modifier_en_cours = false;
                    }
                }
                $Code_joueur = ( isset($colonnes['Code_joueur']) && ( $force || mf_matrice_droits(['api_modifier_ref__personnage__Code_joueur', 'personnage__MODIFIER']) ) ? $colonnes['Code_joueur'] : (isset($personnage['Code_joueur']) ? $personnage['Code_joueur'] : 0 ));
                $Code_groupe = ( isset($colonnes['Code_groupe']) && ( $force || mf_matrice_droits(['api_modifier_ref__personnage__Code_groupe', 'personnage__MODIFIER']) ) ? $colonnes['Code_groupe'] : (isset($personnage['Code_groupe']) ? $personnage['Code_groupe'] : 0 ));
                $personnage_Fichier_Fichier = ( isset($colonnes['personnage_Fichier_Fichier']) && ( $force || mf_matrice_droits(['api_modifier__personnage_Fichier_Fichier', 'personnage__MODIFIER']) ) ? $colonnes['personnage_Fichier_Fichier'] : ( isset($personnage['personnage_Fichier_Fichier']) ? $personnage['personnage_Fichier_Fichier'] : '' ) );
                $personnage_Conservation = ( isset($colonnes['personnage_Conservation']) && ( $force || mf_matrice_droits(['api_modifier__personnage_Conservation', 'personnage__MODIFIER']) ) ? $colonnes['personnage_Conservation'] : ( isset($personnage['personnage_Conservation']) ? $personnage['personnage_Conservation'] : '' ) );
                $retour = $this->mf_modifier($Code_personnage, $personnage_Fichier_Fichier, $personnage_Conservation, $Code_joueur, $Code_groupe, true);
                if ( $retour['code_erreur']!=0 && $retour['code_erreur'] != ERR_PERSONNAGE__MODIFIER__AUCUN_CHANGEMENT )
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

    public function mf_modifier_3($lignes) // array( $Code_personnage => array('colonne1' => 'valeur1',  [...] ) )
    {
        $code_erreur = 0;
        $modifs = false;

        // transformation des lignes en colonnes
        $valeurs_en_colonnes=array();
        $indices_par_colonne=array();
        $liste_valeurs_indexees=array();
        foreach ( $lignes as $Code_personnage => $colonnes )
        {
            foreach ($colonnes as $colonne => $valeur)
            {
                if ( $colonne=='personnage_Fichier_Fichier' || $colonne=='personnage_Conservation' || $colonne=='Code_joueur' || $colonne=='Code_groupe' )
                {
                    $valeurs_en_colonnes[$colonne][$Code_personnage]=$valeur;
                    $indices_par_colonne[$colonne][]=$Code_personnage;
                    $liste_valeurs_indexees[$colonne][''.$valeur][]=$Code_personnage;
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
                $modification_sql = $colonne . ' = CASE Code_personnage';
                foreach ( $valeurs as $Code_personnage => $valeur )
                {
                    $modification_sql.=' WHEN ' . $Code_personnage . ' THEN ' . format_sql($colonne, $valeur);
                }
                $modification_sql.=' END';
                $perimetre = Sql_Format_Liste($indices_par_colonne[$colonne]);
                executer_requete_mysql('UPDATE ' . inst('personnage') . ' SET ' . $modification_sql . ' WHERE Code_personnage IN ' . $perimetre . ';', true);
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
                    executer_requete_mysql('UPDATE ' . inst('personnage') . ' SET ' . $colonne . ' = ' . format_sql($colonne, $valeur) . ' WHERE Code_personnage IN ' . $perimetre . ';', true);
                    if ( requete_mysqli_affected_rows()!=0 )
                    {
                        $modifs = true;
                    }
                }
            }
        }

        if ( ! $modifs && $code_erreur==0 )
        {
            $code_erreur = ERR_PERSONNAGE__MODIFIER_3__AUCUN_CHANGEMENT;
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

    public function mf_modifier_4( $Code_joueur, $Code_groupe, $data, $options = array( 'cond_mysql' => array() ) ) // $data = array('colonne1' => 'valeur1', ... )
    {
        $code_erreur = 0;
        $Code_joueur = round($Code_joueur);
        $Code_groupe = round($Code_groupe);
        $mf_colonnes_a_modifier=[];
        if ( isset($data['personnage_Fichier_Fichier']) ) { $mf_colonnes_a_modifier[] = 'personnage_Fichier_Fichier = ' . format_sql('personnage_Fichier_Fichier', $data['personnage_Fichier_Fichier']); }
        if ( isset($data['personnage_Conservation']) ) { $mf_colonnes_a_modifier[] = 'personnage_Conservation = ' . format_sql('personnage_Conservation', $data['personnage_Conservation']); }
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

            $requete = 'UPDATE ' . inst('personnage') . ' SET ' . enumeration($mf_colonnes_a_modifier) . " WHERE 1".( $Code_joueur!=0 ? " AND Code_joueur=$Code_joueur" : "" )."".( $Code_groupe!=0 ? " AND Code_groupe=$Code_groupe" : "" )."$argument_cond;";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_PERSONNAGE__MODIFIER_4__AUCUN_CHANGEMENT;
            }
            else
            {
                self::$cache_db->clear();
            }
            self::$cache_db->reprendre($cle);
        }
        return array('code_erreur' => $code_erreur);
    }

    public function mf_supprimer($Code_personnage, $force=false)
    {
        $code_erreur = 0;
        $Code_personnage = round($Code_personnage);
        if (!$force)
        {
            if (!self::$maj_droits_supprimer_en_cours)
            {
                self::$maj_droits_supprimer_en_cours = true;
                Hook_personnage::hook_actualiser_les_droits_supprimer($Code_personnage);
                self::$maj_droits_supprimer_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['personnage__SUPPRIMER']) ) $code_erreur = REFUS_PERSONNAGE__SUPPRIMER;
        elseif ( !$this->mf_tester_existance_Code_personnage($Code_personnage) ) $code_erreur = ERR_PERSONNAGE__SUPPRIMER_2__CODE_PERSONNAGE_INEXISTANT;
        elseif ( CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_personnage', $Code_personnage) ) $code_erreur = ACCES_CODE_PERSONNAGE_REFUSE;
        elseif ( !Hook_personnage::autorisation_suppression($Code_personnage) ) $code_erreur = REFUS_PERSONNAGE__SUPPRESSION_BLOQUEE;
        else
        {
            $copie__personnage = $this->mf_get($Code_personnage, array('autocompletion' => false));
            $this->supprimer_donnes_en_cascade("personnage", array($Code_personnage));
            $requete = "DELETE IGNORE FROM ".inst('personnage')." WHERE Code_personnage=$Code_personnage;";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_PERSONNAGE__SUPPRIMER__REFUSEE;
                self::$cache_db->reprendre($cle);
            }
            else
            {
                self::$cache_db->clear();
                self::$cache_db->reprendre($cle);
                Hook_personnage::supprimer($copie__personnage);
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

    public function mf_supprimer_2($liste_Code_personnage, $force=false)
    {
        $code_erreur=0;
        $copie__liste_personnage = $this->mf_lister_2($liste_Code_personnage, array('autocompletion' => false));
        $liste_Code_personnage=array();
        foreach ( $copie__liste_personnage as $copie__personnage )
        {
            $Code_personnage = $copie__personnage['Code_personnage'];
            if (!$force)
            {
                if (!self::$maj_droits_supprimer_en_cours)
                {
                    self::$maj_droits_supprimer_en_cours = true;
                    Hook_personnage::hook_actualiser_les_droits_supprimer($Code_personnage);
                    self::$maj_droits_supprimer_en_cours = false;
                }
            }
            if ( !$force && !mf_matrice_droits(['personnage__SUPPRIMER']) ) $code_erreur = REFUS_PERSONNAGE__SUPPRIMER;
            elseif ( !Hook_personnage::autorisation_suppression($Code_personnage) ) $code_erreur = REFUS_PERSONNAGE__SUPPRESSION_BLOQUEE;
            {
                $liste_Code_personnage[] = $Code_personnage;
            }
        }
        if ( $code_erreur==0 && count($liste_Code_personnage)>0 )
        {
            $this->supprimer_donnes_en_cascade("personnage", $liste_Code_personnage);
            $requete = "DELETE IGNORE FROM ".inst('personnage')." WHERE Code_personnage IN ".Sql_Format_Liste($liste_Code_personnage).";";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_PERSONNAGE__SUPPRIMER_2__REFUSEE;
                self::$cache_db->reprendre($cle);
            }
            else
            {
                self::$cache_db->clear();
                self::$cache_db->reprendre($cle);
                Hook_personnage::supprimer_2($copie__liste_personnage);
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

    public function mf_supprimer_3($liste_Code_personnage)
    {
        $code_erreur=0;
        if ( count($liste_Code_personnage)>0 )
        {
            $this->supprimer_donnes_en_cascade("personnage", $liste_Code_personnage);
            $requete = "DELETE IGNORE FROM ".inst('personnage')." WHERE Code_personnage IN ".Sql_Format_Liste($liste_Code_personnage).";";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_PERSONNAGE__SUPPRIMER_3__REFUSEE;
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
        if ( ! $contexte_parent && $mf_contexte['Code_personnage']!=0 )
        {
            $personnage = $this->mf_get( $mf_contexte['Code_personnage'], $options);
            return array( $personnage['Code_personnage'] => $personnage );
        }
        else
        {
            return $this->mf_lister(isset($est_charge['joueur']) ? $mf_contexte['Code_joueur'] : 0, isset($est_charge['groupe']) ? $mf_contexte['Code_groupe'] : 0, $options);
        }
    }

    public function mf_lister($Code_joueur=0, $Code_groupe=0, $options = array( 'cond_mysql' => array(), 'tris' => array(), 'limit' => array(), 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ))
    {
        $cle = "personnage__lister";
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

        // tris
        $argument_tris = '';
        if ( ! isset($options['tris']) )
        {
            $options['tris']=array();
        }
        if ( count($options['tris'])==0 )
        {
            global $mf_tri_defaut_table;
            if ( isset($mf_tri_defaut_table['personnage']) )
            {
                $options['tris'] = $mf_tri_defaut_table['personnage'];
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
                    if ( strpos($argument_cond, 'personnage_Fichier_Fichier')!==false ) { $liste_colonnes_a_indexer['personnage_Fichier_Fichier'] = 'personnage_Fichier_Fichier'; }
                    if ( strpos($argument_cond, 'personnage_Conservation')!==false ) { $liste_colonnes_a_indexer['personnage_Conservation'] = 'personnage_Conservation'; }
                }
                if ( isset($options['tris']) )
                {
                    if ( isset($options['tris']['personnage_Fichier_Fichier']) ) { $liste_colonnes_a_indexer['personnage_Fichier_Fichier'] = 'personnage_Fichier_Fichier'; }
                    if ( isset($options['tris']['personnage_Conservation']) ) { $liste_colonnes_a_indexer['personnage_Conservation'] = 'personnage_Conservation'; }
                }
                if ( count($liste_colonnes_a_indexer)>0 )
                {
                    if ( ! $mf_liste_requete_index = self::$cache_db->read('personnage__index') )
                    {
                        $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('personnage').'`;', false);
                        $mf_liste_requete_index = array();
                        while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                        {
                            $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                        }
                        mysqli_free_result($res_requete_index);
                        self::$cache_db->write('personnage__index', $mf_liste_requete_index);
                    }
                    foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                    {
                        if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                    }
                    if ( count($liste_colonnes_a_indexer) > 0 )
                    {
                        self::$cache_db->pause('personnage__index');
                        foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                        {
                            executer_requete_mysql('ALTER TABLE `'.inst('personnage').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                        }
                        self::$cache_db->clear();
                        self::$cache_db->reprendre('personnage__index');
                    }
                }

                $liste = array();
                $liste_personnage_pas_a_jour = array();
                if ($toutes_colonnes)
                {
                    $colonnes='Code_personnage, personnage_Fichier_Fichier, personnage_Conservation, Code_joueur, Code_groupe';
                }
                else
                {
                    $colonnes='Code_personnage, personnage_Fichier_Fichier, personnage_Conservation, Code_joueur, Code_groupe';
                }
                $res_requete = executer_requete_mysql("SELECT $colonnes FROM ".inst('personnage')." WHERE 1{$argument_cond}".( $Code_joueur!=0 ? " AND Code_joueur=$Code_joueur" : "" )."".( $Code_groupe!=0 ? " AND Code_groupe=$Code_groupe" : "" )."{$argument_tris}{$argument_limit};", false);
                while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
                {
                    $liste[$row_requete['Code_personnage']]=$row_requete;
                    if ( $maj && ! Hook_personnage::est_a_jour( $row_requete ) )
                    {
                        $liste_personnage_pas_a_jour[$row_requete['Code_personnage']] = $row_requete;
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
                Hook_personnage::mettre_a_jour( $liste_personnage_pas_a_jour );
            }
        }

        foreach ($liste as $elem)
        {
            if ( $controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_personnage', $elem['Code_personnage']) )
            {
                unset($liste[$elem['Code_personnage']]);
            }
            else
            {
                if (!self::$auto_completion && $autocompletion)
                {
                    self::$auto_completion = true;
                    Hook_personnage::completion($liste[$elem['Code_personnage']]);
                    self::$auto_completion = false;
                }
            }
        }

        return $liste;
    }

    public function mf_lister_2($liste_Code_personnage, $options = array( 'cond_mysql' => array(), 'tris' => array(), 'limit' => array(), 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ))
    {
        if ( count($liste_Code_personnage)>0 )
        {
            $cle = "personnage__mf_lister_2_".Sql_Format_Liste($liste_Code_personnage);

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
                if ( isset($mf_tri_defaut_table['personnage']) )
                {
                    $options['tris'] = $mf_tri_defaut_table['personnage'];
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
                        if ( strpos($argument_cond, 'personnage_Fichier_Fichier')!==false ) { $liste_colonnes_a_indexer['personnage_Fichier_Fichier'] = 'personnage_Fichier_Fichier'; }
                        if ( strpos($argument_cond, 'personnage_Conservation')!==false ) { $liste_colonnes_a_indexer['personnage_Conservation'] = 'personnage_Conservation'; }
                    }
                    if ( isset($options['tris']) )
                    {
                        if ( isset($options['tris']['personnage_Fichier_Fichier']) ) { $liste_colonnes_a_indexer['personnage_Fichier_Fichier'] = 'personnage_Fichier_Fichier'; }
                        if ( isset($options['tris']['personnage_Conservation']) ) { $liste_colonnes_a_indexer['personnage_Conservation'] = 'personnage_Conservation'; }
                    }
                    if ( count($liste_colonnes_a_indexer)>0 )
                    {
                        if ( ! $mf_liste_requete_index = self::$cache_db->read('personnage__index') )
                        {
                            $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('personnage').'`;', false);
                            $mf_liste_requete_index = array();
                            while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                            {
                                $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                            }
                            mysqli_free_result($res_requete_index);
                            self::$cache_db->write('personnage__index', $mf_liste_requete_index);
                        }
                        foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                        {
                            if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                        }
                        if ( count($liste_colonnes_a_indexer) > 0 )
                        {
                            self::$cache_db->pause('personnage__index');
                            foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                            {
                                executer_requete_mysql('ALTER TABLE `'.inst('personnage').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                            }
                            self::$cache_db->clear();
                            self::$cache_db->reprendre('personnage__index');
                        }
                    }

                    $liste = array();
                    $liste_personnage_pas_a_jour = array();
                    if ($toutes_colonnes)
                    {
                        $colonnes='Code_personnage, personnage_Fichier_Fichier, personnage_Conservation, Code_joueur, Code_groupe';
                    }
                    else
                    {
                        $colonnes='Code_personnage, personnage_Fichier_Fichier, personnage_Conservation, Code_joueur, Code_groupe';
                    }
                    $res_requete = executer_requete_mysql("SELECT $colonnes FROM ".inst('personnage')." WHERE 1{$argument_cond} AND Code_personnage IN ".Sql_Format_Liste($liste_Code_personnage)."{$argument_tris}{$argument_limit};", false);
                    while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
                    {
                        $liste[$row_requete['Code_personnage']]=$row_requete;
                        if ( $maj && ! Hook_personnage::est_a_jour( $row_requete ) )
                        {
                            $liste_personnage_pas_a_jour[$row_requete['Code_personnage']] = $row_requete;
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
                    Hook_personnage::mettre_a_jour( $liste_personnage_pas_a_jour );
                }
            }

            foreach ($liste as $elem)
            {
                if ( $controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_personnage', $elem['Code_personnage']) )
                {
                    unset($liste[$elem['Code_personnage']]);
                }
                else
                {
                    if (!self::$auto_completion && $autocompletion)
                    {
                        self::$auto_completion = true;
                        Hook_personnage::completion($liste[$elem['Code_personnage']]);
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

    public function mf_get($Code_personnage, $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ])
    {
        $Code_personnage = round($Code_personnage);
        $retour = array();
        if ( ! CONTROLE_ACCES_DONNEES_DEFAUT || Hook_mf_systeme::controle_acces_donnees('Code_personnage', $Code_personnage) )
        {
            $cle = 'personnage__get_'.$Code_personnage;

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
                        $colonnes='Code_personnage, personnage_Fichier_Fichier, personnage_Conservation, Code_joueur, Code_groupe';
                    }
                    else
                    {
                        $colonnes='Code_personnage, personnage_Fichier_Fichier, personnage_Conservation, Code_joueur, Code_groupe';
                    }
                    $res_requete = executer_requete_mysql('SELECT ' . $colonnes . ' FROM ' . inst('personnage') . ' WHERE Code_personnage = ' . $Code_personnage . ';', false);
                    if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
                    {
                        $retour=$row_requete;
                        if ( $maj && ! Hook_personnage::est_a_jour( $row_requete ) )
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
                    Hook_personnage::mettre_a_jour( array( $row_requete['Code_personnage'] => $row_requete ) );
                }
            }
            if ( isset( $retour['Code_personnage'] ) )
            {
                if (!self::$auto_completion && $autocompletion)
                {
                    self::$auto_completion = true;
                    Hook_personnage::completion($retour);
                    self::$auto_completion = false;
                }
            }
        }
        return $retour;
    }

    public function mf_get_last($Code_joueur=0, $Code_groupe=0, $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ])
    {
        $cle = "personnage__get_last";
        $Code_joueur = round($Code_joueur);
        $cle.='_' . $Code_joueur;
        $Code_groupe = round($Code_groupe);
        $cle.='_' . $Code_groupe;
        if ( ! $retour = self::$cache_db->read($cle) )
        {
            $Code_personnage = 0;
            $res_requete = executer_requete_mysql('SELECT Code_personnage FROM ' . inst('personnage') . " WHERE 1".( $Code_joueur!=0 ? " AND Code_joueur=$Code_joueur" : "" )."".( $Code_groupe!=0 ? " AND Code_groupe=$Code_groupe" : "" )." ORDER BY mf_date_creation DESC, Code_personnage DESC LIMIT 0 , 1;", false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $Code_personnage = $row_requete['Code_personnage'];
            }
            mysqli_free_result($res_requete);
            $retour = $this->mf_get($Code_personnage, $options);
            self::$cache_db->write($cle, $retour);
        }
        return $retour;
    }

    public function mf_get_2($Code_personnage, $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ])
    {
        $Code_personnage = round($Code_personnage);
        $retour = array();
        $cle = 'personnage__get_'.$Code_personnage;

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
                $colonnes='Code_personnage, personnage_Fichier_Fichier, personnage_Conservation, Code_joueur, Code_groupe';
            }
            else
            {
                $colonnes='Code_personnage, personnage_Fichier_Fichier, personnage_Conservation, Code_joueur, Code_groupe';
            }
            $res_requete = executer_requete_mysql('SELECT ' . $colonnes . " FROM ".inst('personnage')." WHERE Code_personnage = $Code_personnage;", false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $retour=$row_requete;
            }
            mysqli_free_result($res_requete);
            self::$cache_db->write($cle, $retour);
        }
        if ( isset( $retour['Code_personnage'] ) )
        {
            if (!self::$auto_completion && $autocompletion)
            {
                self::$auto_completion = true;
                Hook_personnage::completion($retour);
                self::$auto_completion = false;
            }
        }
        return $retour;
    }

    public function mf_prec_et_suiv($Code_personnage, $Code_joueur=0, $Code_groupe=0, $options = array( 'cond_mysql' => array(), 'tris' => array(), 'limit' => array(), 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ))
    {
        $Code_personnage = round($Code_personnage);
        $liste = $this->mf_lister($Code_joueur, $Code_groupe, $options);
        return prec_suiv($liste, $Code_personnage);
    }

    public function mf_compter($Code_joueur=0, $Code_groupe=0, $options = array( 'cond_mysql' => array() ))
    {
        $cle = 'personnage__compter';
        $Code_joueur = round($Code_joueur);
        $cle.='_{'.$Code_joueur.'}';
        $Code_groupe = round($Code_groupe);
        $cle.='_{'.$Code_groupe.'}';

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
                if ( strpos($argument_cond, 'personnage_Fichier_Fichier')!==false ) { $liste_colonnes_a_indexer['personnage_Fichier_Fichier'] = 'personnage_Fichier_Fichier'; }
                if ( strpos($argument_cond, 'personnage_Conservation')!==false ) { $liste_colonnes_a_indexer['personnage_Conservation'] = 'personnage_Conservation'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = self::$cache_db->read('personnage__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('personnage').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    self::$cache_db->write('personnage__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    self::$cache_db->pause('personnage__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('personnage').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    self::$cache_db->clear();
                    self::$cache_db->reprendre('personnage__index');
                }
            }

            $res_requete = executer_requete_mysql("SELECT count(Code_personnage) as nb FROM ".inst('personnage')." WHERE 1{$argument_cond}".( $Code_joueur!=0 ? " AND Code_joueur=$Code_joueur" : "" )."".( $Code_groupe!=0 ? " AND Code_groupe=$Code_groupe" : "" ).";", false);
            $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC);
            mysqli_free_result($res_requete);
            $nb = round($row_requete['nb']);
            self::$cache_db->write($cle, $nb);
        }
        return $nb;
    }

    public function mfi_compter( $interface, $options = array( 'cond_mysql' => array() ) )
    {
        $Code_joueur = isset($interface['Code_joueur']) ? round($interface['Code_joueur']) : 0;
        $Code_groupe = isset($interface['Code_groupe']) ? round($interface['Code_groupe']) : 0;
        return $this->mf_compter( $Code_joueur, $Code_groupe, $options );
    }

    public function mf_liste_Code_personnage($Code_joueur=0, $Code_groupe=0, $options = array( 'cond_mysql' => array() ))
    {
        return $this->get_liste_Code_personnage($Code_joueur, $Code_groupe, $options);
    }

    public function mf_convertir_Code_personnage_vers_Code_joueur( $Code_personnage )
    {
        return $this->Code_personnage_vers_Code_joueur( $Code_personnage );
    }

    public function mf_convertir_Code_personnage_vers_Code_groupe( $Code_personnage )
    {
        return $this->Code_personnage_vers_Code_groupe( $Code_personnage );
    }

    public function mf_liste_Code_joueur_vers_liste_Code_personnage( $liste_Code_joueur, $options = array( 'cond_mysql' => array() ) )
    {
        return $this->liste_Code_joueur_vers_liste_Code_personnage( $liste_Code_joueur, $options );
    }

    public function mf_liste_Code_personnage_vers_liste_Code_joueur( $liste_Code_personnage, $options = array( 'cond_mysql' => array() ) )
    {
        return $this->personnage__liste_Code_personnage_vers_liste_Code_joueur( $liste_Code_personnage, $options );
    }

    public function mf_liste_Code_groupe_vers_liste_Code_personnage( $liste_Code_groupe, $options = array( 'cond_mysql' => array() ) )
    {
        return $this->liste_Code_groupe_vers_liste_Code_personnage( $liste_Code_groupe, $options );
    }

    public function mf_liste_Code_personnage_vers_liste_Code_groupe( $liste_Code_personnage, $options = array( 'cond_mysql' => array() ) )
    {
        return $this->personnage__liste_Code_personnage_vers_liste_Code_groupe( $liste_Code_personnage, $options );
    }

    public function mf_get_liste_tables_enfants()
    {
        return $this->get_liste_tables_enfants( 'personnage' );
    }

    public function mf_get_liste_tables_parents()
    {
        return array('Code_joueur','Code_groupe');
    }

    public function mf_search_personnage_Fichier_Fichier( $personnage_Fichier_Fichier, $Code_joueur=0, $Code_groupe=0 )
    {
        return $this->rechercher_personnage_Fichier_Fichier( $personnage_Fichier_Fichier, $Code_joueur, $Code_groupe );
    }

    public function mf_search_personnage_Conservation( $personnage_Conservation, $Code_joueur=0, $Code_groupe=0 )
    {
        return $this->rechercher_personnage_Conservation( $personnage_Conservation, $Code_joueur, $Code_groupe );
    }

    public function mf_search__colonne( $colonne_db, $recherche, $Code_joueur=0, $Code_groupe=0 )
    {
        switch ($colonne_db) {
            case 'personnage_Fichier_Fichier': return $this->mf_search_personnage_Fichier_Fichier( $recherche, $Code_joueur, $Code_groupe ); break;
            case 'personnage_Conservation': return $this->mf_search_personnage_Conservation( $recherche, $Code_joueur, $Code_groupe ); break;
        }
    }

    public function mf_get_next_id()
    {
        $res_requete = executer_requete_mysql('SELECT AUTO_INCREMENT as next_id FROM INFORMATION_SCHEMA.TABLES WHERE table_name = \'personnage\';', false);
        $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC);
        mysqli_free_result($res_requete);
        return round($row_requete['next_id']);
    }

    public function mf_search($ligne) // array('colonne1' => 'valeur1',  [...] )
    {
        global $mf_initialisation;
        $Code_joueur = (isset($ligne['Code_joueur'])?round($ligne['Code_joueur']):get_joueur_courant('Code_joueur'));
        $Code_groupe = (isset($ligne['Code_groupe'])?round($ligne['Code_groupe']):0);
        $personnage_Fichier_Fichier = (isset($ligne['personnage_Fichier_Fichier'])?$ligne['personnage_Fichier_Fichier']:$mf_initialisation['personnage_Fichier_Fichier']);
        $personnage_Conservation = (isset($ligne['personnage_Conservation'])?$ligne['personnage_Conservation']:$mf_initialisation['personnage_Conservation']);
        Hook_personnage::pre_controller($personnage_Fichier_Fichier, $personnage_Conservation, $Code_joueur, $Code_groupe);
        $mf_cle_unique = Hook_personnage::calcul_cle_unique($personnage_Fichier_Fichier, $personnage_Conservation, $Code_joueur, $Code_groupe);
        $res_requete = executer_requete_mysql('SELECT Code_personnage FROM ' . inst('personnage') . ' WHERE mf_cle_unique = \''.$mf_cle_unique.'\'', false);
        if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
        {
            $r = round($row_requete['Code_personnage']);
        }
        else
        {
            $r = false;
        }
        mysqli_free_result($res_requete);
        return $r;
    }

}
