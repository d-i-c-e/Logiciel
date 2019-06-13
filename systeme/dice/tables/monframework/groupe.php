<?php

/*
    +------------------------------+
    |  NE PAS MODIFIER CE FICHIER  |
    +------------------------------+
*/

class groupe_monframework extends entite_monframework
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
            include_once __DIR__ . '/../../erreurs/erreurs__groupe.php';
            self::$initialisation = false;
            Hook_groupe::initialisation();
            self::$cache_db = new Mf_Cachedb('groupe');
        }
        if (!self::$actualisation_en_cours)
        {
            self::$actualisation_en_cours=true;
            Hook_groupe::actualisation();
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

        if ( ! test_si_table_existe(inst('groupe')) )
        {
            executer_requete_mysql('CREATE TABLE '.inst('groupe').'(Code_groupe INT AUTO_INCREMENT NOT NULL, PRIMARY KEY (Code_groupe)) ENGINE=MyISAM;', true);
        }

        $liste_colonnes = lister_les_colonnes(inst('groupe'));

        if ( isset($liste_colonnes['groupe_Nom']) )
        {
            if ( typeMyql2Sql($liste_colonnes['groupe_Nom']['Type'])!='VARCHAR' )
            {
                executer_requete_mysql('ALTER TABLE '.inst('groupe').' CHANGE groupe_Nom groupe_Nom VARCHAR(255);', true);
            }
            unset($liste_colonnes['groupe_Nom']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('groupe').' ADD groupe_Nom VARCHAR(255);', true);
            executer_requete_mysql('UPDATE '.inst('groupe').' SET groupe_Nom=' . format_sql('groupe_Nom', $mf_initialisation['groupe_Nom']) . ';', true);
        }

        if ( isset($liste_colonnes['groupe_Description']) )
        {
            if ( typeMyql2Sql($liste_colonnes['groupe_Description']['Type'])!='TEXT' )
            {
                executer_requete_mysql('ALTER TABLE '.inst('groupe').' CHANGE groupe_Description groupe_Description TEXT;', true);
            }
            unset($liste_colonnes['groupe_Description']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('groupe').' ADD groupe_Description TEXT;', true);
            executer_requete_mysql('UPDATE '.inst('groupe').' SET groupe_Description=' . format_sql('groupe_Description', $mf_initialisation['groupe_Description']) . ';', true);
        }

        if ( isset($liste_colonnes['groupe_Logo_Fichier']) )
        {
            if ( typeMyql2Sql($liste_colonnes['groupe_Logo_Fichier']['Type'])!='VARCHAR' )
            {
                executer_requete_mysql('ALTER TABLE '.inst('groupe').' CHANGE groupe_Logo_Fichier groupe_Logo_Fichier VARCHAR(255);', true);
            }
            unset($liste_colonnes['groupe_Logo_Fichier']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('groupe').' ADD groupe_Logo_Fichier VARCHAR(255);', true);
            executer_requete_mysql('UPDATE '.inst('groupe').' SET groupe_Logo_Fichier=' . format_sql('groupe_Logo_Fichier', $mf_initialisation['groupe_Logo_Fichier']) . ';', true);
        }

        if ( isset($liste_colonnes['groupe_Effectif']) )
        {
            if ( typeMyql2Sql($liste_colonnes['groupe_Effectif']['Type'])!='BOOL' )
            {
                executer_requete_mysql('ALTER TABLE '.inst('groupe').' CHANGE groupe_Effectif groupe_Effectif BOOL;', true);
            }
            unset($liste_colonnes['groupe_Effectif']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('groupe').' ADD groupe_Effectif BOOL;', true);
            executer_requete_mysql('UPDATE '.inst('groupe').' SET groupe_Effectif=' . format_sql('groupe_Effectif', $mf_initialisation['groupe_Effectif']) . ';', true);
        }

        if ( isset($liste_colonnes['groupe_Actif']) )
        {
            if ( typeMyql2Sql($liste_colonnes['groupe_Actif']['Type'])!='INT' )
            {
                executer_requete_mysql('ALTER TABLE '.inst('groupe').' CHANGE groupe_Actif groupe_Actif INT;', true);
            }
            unset($liste_colonnes['groupe_Actif']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('groupe').' ADD groupe_Actif INT;', true);
            executer_requete_mysql('UPDATE '.inst('groupe').' SET groupe_Actif=' . format_sql('groupe_Actif', $mf_initialisation['groupe_Actif']) . ';', true);
        }

        if ( isset($liste_colonnes['groupe_Date_creation']) )
        {
            if ( typeMyql2Sql($liste_colonnes['groupe_Date_creation']['Type'])!='DATETIME' )
            {
                executer_requete_mysql('ALTER TABLE '.inst('groupe').' CHANGE groupe_Date_creation groupe_Date_creation DATETIME;', true);
            }
            unset($liste_colonnes['groupe_Date_creation']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('groupe').' ADD groupe_Date_creation DATETIME;', true);
            executer_requete_mysql('UPDATE '.inst('groupe').' SET groupe_Date_creation=' . format_sql('groupe_Date_creation', $mf_initialisation['groupe_Date_creation']) . ';', true);
        }

        if ( isset($liste_colonnes['groupe_Delai_suppression_jour']) )
        {
            if ( typeMyql2Sql($liste_colonnes['groupe_Delai_suppression_jour']['Type'])!='INT' )
            {
                executer_requete_mysql('ALTER TABLE '.inst('groupe').' CHANGE groupe_Delai_suppression_jour groupe_Delai_suppression_jour INT;', true);
            }
            unset($liste_colonnes['groupe_Delai_suppression_jour']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('groupe').' ADD groupe_Delai_suppression_jour INT;', true);
            executer_requete_mysql('UPDATE '.inst('groupe').' SET groupe_Delai_suppression_jour=' . format_sql('groupe_Delai_suppression_jour', $mf_initialisation['groupe_Delai_suppression_jour']) . ';', true);
        }

        if ( isset($liste_colonnes['groupe_Suppression_active']) )
        {
            if ( typeMyql2Sql($liste_colonnes['groupe_Suppression_active']['Type'])!='BOOL' )
            {
                executer_requete_mysql('ALTER TABLE '.inst('groupe').' CHANGE groupe_Suppression_active groupe_Suppression_active BOOL;', true);
            }
            unset($liste_colonnes['groupe_Suppression_active']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('groupe').' ADD groupe_Suppression_active BOOL;', true);
            executer_requete_mysql('UPDATE '.inst('groupe').' SET groupe_Suppression_active=' . format_sql('groupe_Suppression_active', $mf_initialisation['groupe_Suppression_active']) . ';', true);
        }

        if ( isset($liste_colonnes['Code_campagne']) )
        {
            unset($liste_colonnes['Code_campagne']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('groupe').' ADD Code_campagne int NOT NULL;', true);
        }

        if ( isset($liste_colonnes['mf_signature']) )
        {
            unset($liste_colonnes['mf_signature']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('groupe').' ADD mf_signature VARCHAR(255);', true);
            executer_requete_mysql('ALTER TABLE '.inst('groupe').' ADD INDEX( mf_signature );', true);
        }

        if ( isset($liste_colonnes['mf_cle_unique']) )
        {
            unset($liste_colonnes['mf_cle_unique']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('groupe').' ADD mf_cle_unique VARCHAR(255);', true);
            executer_requete_mysql('ALTER TABLE '.inst('groupe').' ADD INDEX( mf_cle_unique );', true);
        }

        if ( isset($liste_colonnes['mf_date_creation']) )
        {
            unset($liste_colonnes['mf_date_creation']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('groupe').' ADD mf_date_creation DATETIME;', true);
            executer_requete_mysql('ALTER TABLE '.inst('groupe').' ADD INDEX( mf_date_creation );', true);
        }

        if ( isset($liste_colonnes['mf_date_modification']) )
        {
            unset($liste_colonnes['mf_date_modification']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('groupe').' ADD mf_date_modification DATETIME;', true);
            executer_requete_mysql('ALTER TABLE '.inst('groupe').' ADD INDEX( mf_date_modification );', true);
        }

        unset($liste_colonnes['Code_groupe']);

        foreach ($liste_colonnes as $field => $value)
        {
            executer_requete_mysql('ALTER TABLE '.inst('groupe').' DROP COLUMN '.$field.';', true);
        }

    }

    public function mf_ajouter($groupe_Nom, $groupe_Description, $groupe_Logo_Fichier, $groupe_Effectif, $groupe_Actif, $groupe_Date_creation, $groupe_Delai_suppression_jour, $groupe_Suppression_active, $Code_campagne, $force=false)
    {
        $Code_groupe = 0;
        $code_erreur = 0;
        $Code_campagne = round($Code_campagne);
        $groupe_Actif = round($groupe_Actif);
        $groupe_Date_creation = format_datetime($groupe_Date_creation);
        $groupe_Delai_suppression_jour = round($groupe_Delai_suppression_jour);
        Hook_groupe::pre_controller($groupe_Nom, $groupe_Description, $groupe_Logo_Fichier, $groupe_Effectif, $groupe_Actif, $groupe_Date_creation, $groupe_Delai_suppression_jour, $groupe_Suppression_active, $Code_campagne);
        if (!$force)
        {
            if (!self::$maj_droits_ajouter_en_cours)
            {
                self::$maj_droits_ajouter_en_cours = true;
                Hook_groupe::hook_actualiser_les_droits_ajouter($Code_campagne);
                self::$maj_droits_ajouter_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['groupe__AJOUTER']) ) $code_erreur = REFUS_GROUPE__AJOUTER;
        elseif ( !$this->mf_tester_existance_Code_campagne($Code_campagne) ) $code_erreur = ERR_GROUPE__AJOUTER__CODE_CAMPAGNE_INEXISTANT;
        elseif ( CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_campagne', $Code_campagne) ) $code_erreur = ACCES_CODE_CAMPAGNE_REFUSE;
        elseif ( !Hook_groupe::autorisation_ajout($groupe_Nom, $groupe_Description, $groupe_Logo_Fichier, $groupe_Effectif, $groupe_Actif, $groupe_Date_creation, $groupe_Delai_suppression_jour, $groupe_Suppression_active, $Code_campagne) ) $code_erreur = REFUS_GROUPE__AJOUT_BLOQUEE;
        else
        {
            Hook_groupe::data_controller($groupe_Nom, $groupe_Description, $groupe_Logo_Fichier, $groupe_Effectif, $groupe_Actif, $groupe_Date_creation, $groupe_Delai_suppression_jour, $groupe_Suppression_active, $Code_campagne);
            $mf_signature = text_sql(Hook_groupe::calcul_signature($groupe_Nom, $groupe_Description, $groupe_Logo_Fichier, $groupe_Effectif, $groupe_Actif, $groupe_Date_creation, $groupe_Delai_suppression_jour, $groupe_Suppression_active, $Code_campagne));
            $mf_cle_unique = text_sql(Hook_groupe::calcul_cle_unique($groupe_Nom, $groupe_Description, $groupe_Logo_Fichier, $groupe_Effectif, $groupe_Actif, $groupe_Date_creation, $groupe_Delai_suppression_jour, $groupe_Suppression_active, $Code_campagne));
            $groupe_Nom = text_sql($groupe_Nom);
            $groupe_Description = text_sql($groupe_Description);
            $groupe_Logo_Fichier = text_sql($groupe_Logo_Fichier);
            $groupe_Effectif = ($groupe_Effectif==1 ? 1 : 0);
            $groupe_Actif = round($groupe_Actif);
            $groupe_Date_creation = format_datetime($groupe_Date_creation);
            $groupe_Delai_suppression_jour = round($groupe_Delai_suppression_jour);
            $groupe_Suppression_active = ($groupe_Suppression_active==1 ? 1 : 0);
            $requete = "INSERT INTO ".inst('groupe')." ( mf_signature, mf_cle_unique, mf_date_creation, mf_date_modification, groupe_Nom, groupe_Description, groupe_Logo_Fichier, groupe_Effectif, groupe_Actif, groupe_Date_creation, groupe_Delai_suppression_jour, groupe_Suppression_active, Code_campagne ) VALUES ( '$mf_signature', '$mf_cle_unique', '".get_now()."', '".get_now()."', '$groupe_Nom', '$groupe_Description', '$groupe_Logo_Fichier', $groupe_Effectif, $groupe_Actif, ".( $groupe_Date_creation!='' ? "'$groupe_Date_creation'" : 'NULL' ).", $groupe_Delai_suppression_jour, $groupe_Suppression_active, $Code_campagne );";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql($requete, true);
            $Code_groupe = requete_mysql_insert_id();
            if ($Code_groupe==0)
            {
                $code_erreur = ERR_GROUPE__AJOUTER__AJOUT_REFUSE;
                self::$cache_db->reprendre($cle);
            }
            else
            {
                self::$cache_db->clear();
                self::$cache_db->reprendre($cle);
                Hook_groupe::ajouter( $Code_groupe );
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
        return array('code_erreur' => $code_erreur, 'Code_groupe' => $Code_groupe, 'callback' => ( $code_erreur==0 ? Hook_groupe::callback_post($Code_groupe) : null ));
    }

    public function mf_creer($Code_campagne, $force=false)
    {
        global $mf_initialisation, $mf_droits_defaut;
        $mf_droits_defaut["groupe__AJOUTER"] = $mf_droits_defaut["groupe__CREER"];
        $groupe_Nom = $mf_initialisation['groupe_Nom'];
        $groupe_Description = $mf_initialisation['groupe_Description'];
        $groupe_Logo_Fichier = $mf_initialisation['groupe_Logo_Fichier'];
        $groupe_Effectif = $mf_initialisation['groupe_Effectif'];
        $groupe_Actif = $mf_initialisation['groupe_Actif'];
        $groupe_Date_creation = $mf_initialisation['groupe_Date_creation'];
        $groupe_Delai_suppression_jour = $mf_initialisation['groupe_Delai_suppression_jour'];
        $groupe_Suppression_active = $mf_initialisation['groupe_Suppression_active'];
        return $this->mf_ajouter($groupe_Nom, $groupe_Description, $groupe_Logo_Fichier, $groupe_Effectif, $groupe_Actif, $groupe_Date_creation, $groupe_Delai_suppression_jour, $groupe_Suppression_active, $Code_campagne, $force);
    }

    public function mf_ajouter_2($ligne, $force=false) // array('colonne1' => 'valeur1',  [...] )
    {
        global $mf_initialisation;
        $Code_campagne = (isset($ligne['Code_campagne'])?round($ligne['Code_campagne']):0);
        $groupe_Nom = (isset($ligne['groupe_Nom'])?$ligne['groupe_Nom']:$mf_initialisation['groupe_Nom']);
        $groupe_Description = (isset($ligne['groupe_Description'])?$ligne['groupe_Description']:$mf_initialisation['groupe_Description']);
        $groupe_Logo_Fichier = (isset($ligne['groupe_Logo_Fichier'])?$ligne['groupe_Logo_Fichier']:$mf_initialisation['groupe_Logo_Fichier']);
        $groupe_Effectif = (isset($ligne['groupe_Effectif'])?$ligne['groupe_Effectif']:$mf_initialisation['groupe_Effectif']);
        $groupe_Actif = (isset($ligne['groupe_Actif'])?$ligne['groupe_Actif']:$mf_initialisation['groupe_Actif']);
        $groupe_Date_creation = (isset($ligne['groupe_Date_creation'])?$ligne['groupe_Date_creation']:$mf_initialisation['groupe_Date_creation']);
        $groupe_Delai_suppression_jour = (isset($ligne['groupe_Delai_suppression_jour'])?$ligne['groupe_Delai_suppression_jour']:$mf_initialisation['groupe_Delai_suppression_jour']);
        $groupe_Suppression_active = (isset($ligne['groupe_Suppression_active'])?$ligne['groupe_Suppression_active']:$mf_initialisation['groupe_Suppression_active']);
        return $this->mf_ajouter($groupe_Nom, $groupe_Description, $groupe_Logo_Fichier, $groupe_Effectif, $groupe_Actif, $groupe_Date_creation, $groupe_Delai_suppression_jour, $groupe_Suppression_active, $Code_campagne, $force);
    }

    public function mf_ajouter_3($lignes) // array( array( 'colonne1' => 'valeur1', 'colonne2' => 'valeur2',  [...] ), [...] )
    {
        global $mf_initialisation;
        $code_erreur = 0;
        $values = '';
        foreach ($lignes as $ligne)
        {
            $Code_campagne = (isset($ligne['Code_campagne'])?round($ligne['Code_campagne']):0);
            $groupe_Nom = text_sql(isset($ligne['groupe_Nom'])?$ligne['groupe_Nom']:$mf_initialisation['groupe_Nom']);
            $groupe_Description = text_sql(isset($ligne['groupe_Description'])?$ligne['groupe_Description']:$mf_initialisation['groupe_Description']);
            $groupe_Logo_Fichier = text_sql(isset($ligne['groupe_Logo_Fichier'])?$ligne['groupe_Logo_Fichier']:$mf_initialisation['groupe_Logo_Fichier']);
            $groupe_Effectif = (isset($ligne['groupe_Effectif'])?$ligne['groupe_Effectif']:$mf_initialisation['groupe_Effectif']==1 ? 1 : 0);
            $groupe_Actif = round(isset($ligne['groupe_Actif'])?$ligne['groupe_Actif']:$mf_initialisation['groupe_Actif']);
            $groupe_Date_creation = format_datetime(isset($ligne['groupe_Date_creation'])?$ligne['groupe_Date_creation']:$mf_initialisation['groupe_Date_creation']);
            $groupe_Delai_suppression_jour = round(isset($ligne['groupe_Delai_suppression_jour'])?$ligne['groupe_Delai_suppression_jour']:$mf_initialisation['groupe_Delai_suppression_jour']);
            $groupe_Suppression_active = (isset($ligne['groupe_Suppression_active'])?$ligne['groupe_Suppression_active']:$mf_initialisation['groupe_Suppression_active']==1 ? 1 : 0);
            if ($Code_campagne != 0)
            {
                $values.=($values!="" ? "," : "")."('$groupe_Nom', '$groupe_Description', '$groupe_Logo_Fichier', $groupe_Effectif, $groupe_Actif, ".( $groupe_Date_creation!='' ? "'$groupe_Date_creation'" : 'NULL' ).", $groupe_Delai_suppression_jour, $groupe_Suppression_active, $Code_campagne)";
            }
        }
        if ($values!='')
        {
            $requete = "INSERT INTO ".inst('groupe')." ( groupe_Nom, groupe_Description, groupe_Logo_Fichier, groupe_Effectif, groupe_Actif, groupe_Date_creation, groupe_Delai_suppression_jour, groupe_Suppression_active, Code_campagne ) VALUES $values;";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            $n = requete_mysqli_affected_rows();
            if ($n < count($lignes))
            {
                $code_erreur = ERR_GROUPE__AJOUTER_3__ECHEC_AJOUT;
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

    public function mf_modifier($Code_groupe, $groupe_Nom, $groupe_Description, $groupe_Logo_Fichier, $groupe_Effectif, $groupe_Actif, $groupe_Date_creation, $groupe_Delai_suppression_jour, $groupe_Suppression_active, $Code_campagne=0, $force=false)
    {
        $code_erreur = 0;
        $Code_groupe = round($Code_groupe);
        $Code_campagne = round($Code_campagne);
        $groupe_Actif = round($groupe_Actif);
        $groupe_Date_creation = format_datetime($groupe_Date_creation);
        $groupe_Delai_suppression_jour = round($groupe_Delai_suppression_jour);
        Hook_groupe::pre_controller($groupe_Nom, $groupe_Description, $groupe_Logo_Fichier, $groupe_Effectif, $groupe_Actif, $groupe_Date_creation, $groupe_Delai_suppression_jour, $groupe_Suppression_active, $Code_campagne, $Code_groupe);
        if (!$force)
        {
            if (!self::$maj_droits_modifier_en_cours)
            {
                self::$maj_droits_modifier_en_cours = true;
                Hook_groupe::hook_actualiser_les_droits_modifier($Code_groupe);
                self::$maj_droits_modifier_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['groupe__MODIFIER']) ) $code_erreur = REFUS_GROUPE__MODIFIER;
        elseif ( !$this->mf_tester_existance_Code_groupe($Code_groupe) ) $code_erreur = ERR_GROUPE__MODIFIER__CODE_GROUPE_INEXISTANT;
        elseif ( $Code_campagne!=0 && !$this->mf_tester_existance_Code_campagne($Code_campagne) ) $code_erreur = ERR_GROUPE__MODIFIER__CODE_CAMPAGNE_INEXISTANT;
        elseif ( CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_groupe', $Code_groupe) ) $code_erreur = ACCES_CODE_GROUPE_REFUSE;
        elseif ( $Code_campagne!=0 && CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_campagne', $Code_campagne) ) $code_erreur = ACCES_CODE_CAMPAGNE_REFUSE;
        elseif ( !Hook_groupe::autorisation_modification($Code_groupe, $groupe_Nom, $groupe_Description, $groupe_Logo_Fichier, $groupe_Effectif, $groupe_Actif, $groupe_Date_creation, $groupe_Delai_suppression_jour, $groupe_Suppression_active, $Code_campagne) ) $code_erreur = REFUS_GROUPE__MODIFICATION_BLOQUEE;
        else
        {
            Hook_groupe::data_controller($groupe_Nom, $groupe_Description, $groupe_Logo_Fichier, $groupe_Effectif, $groupe_Actif, $groupe_Date_creation, $groupe_Delai_suppression_jour, $groupe_Suppression_active, $Code_campagne, $Code_groupe);
            $groupe = $this->mf_get_2( $Code_groupe, array('autocompletion' => false, 'masquer_mdp' => false) );
            $mf_colonnes_a_modifier=[];
            $bool__groupe_Nom = false; if ( $groupe_Nom!=$groupe['groupe_Nom'] ) { Hook_groupe::data_controller__groupe_Nom($groupe['groupe_Nom'], $groupe_Nom, $Code_groupe); if ( $groupe_Nom!=$groupe['groupe_Nom'] ) { $mf_colonnes_a_modifier[] = 'groupe_Nom=' . format_sql('groupe_Nom', $groupe_Nom); $bool__groupe_Nom = true; } }
            $bool__groupe_Description = false; if ( $groupe_Description!=$groupe['groupe_Description'] ) { Hook_groupe::data_controller__groupe_Description($groupe['groupe_Description'], $groupe_Description, $Code_groupe); if ( $groupe_Description!=$groupe['groupe_Description'] ) { $mf_colonnes_a_modifier[] = 'groupe_Description=' . format_sql('groupe_Description', $groupe_Description); $bool__groupe_Description = true; } }
            $bool__groupe_Logo_Fichier = false; if ( $groupe_Logo_Fichier!=$groupe['groupe_Logo_Fichier'] ) { Hook_groupe::data_controller__groupe_Logo_Fichier($groupe['groupe_Logo_Fichier'], $groupe_Logo_Fichier, $Code_groupe); if ( $groupe_Logo_Fichier!=$groupe['groupe_Logo_Fichier'] ) { $mf_colonnes_a_modifier[] = 'groupe_Logo_Fichier=' . format_sql('groupe_Logo_Fichier', $groupe_Logo_Fichier); $bool__groupe_Logo_Fichier = true; } }
            $bool__groupe_Effectif = false; if ( $groupe_Effectif!=$groupe['groupe_Effectif'] ) { Hook_groupe::data_controller__groupe_Effectif($groupe['groupe_Effectif'], $groupe_Effectif, $Code_groupe); if ( $groupe_Effectif!=$groupe['groupe_Effectif'] ) { $mf_colonnes_a_modifier[] = 'groupe_Effectif=' . format_sql('groupe_Effectif', $groupe_Effectif); $bool__groupe_Effectif = true; } }
            $bool__groupe_Actif = false; if ( $groupe_Actif!=$groupe['groupe_Actif'] ) { Hook_groupe::data_controller__groupe_Actif($groupe['groupe_Actif'], $groupe_Actif, $Code_groupe); if ( $groupe_Actif!=$groupe['groupe_Actif'] ) { $mf_colonnes_a_modifier[] = 'groupe_Actif=' . format_sql('groupe_Actif', $groupe_Actif); $bool__groupe_Actif = true; } }
            $bool__groupe_Date_creation = false; if ( $groupe_Date_creation!=$groupe['groupe_Date_creation'] ) { Hook_groupe::data_controller__groupe_Date_creation($groupe['groupe_Date_creation'], $groupe_Date_creation, $Code_groupe); if ( $groupe_Date_creation!=$groupe['groupe_Date_creation'] ) { $mf_colonnes_a_modifier[] = 'groupe_Date_creation=' . format_sql('groupe_Date_creation', $groupe_Date_creation); $bool__groupe_Date_creation = true; } }
            $bool__groupe_Delai_suppression_jour = false; if ( $groupe_Delai_suppression_jour!=$groupe['groupe_Delai_suppression_jour'] ) { Hook_groupe::data_controller__groupe_Delai_suppression_jour($groupe['groupe_Delai_suppression_jour'], $groupe_Delai_suppression_jour, $Code_groupe); if ( $groupe_Delai_suppression_jour!=$groupe['groupe_Delai_suppression_jour'] ) { $mf_colonnes_a_modifier[] = 'groupe_Delai_suppression_jour=' . format_sql('groupe_Delai_suppression_jour', $groupe_Delai_suppression_jour); $bool__groupe_Delai_suppression_jour = true; } }
            $bool__groupe_Suppression_active = false; if ( $groupe_Suppression_active!=$groupe['groupe_Suppression_active'] ) { Hook_groupe::data_controller__groupe_Suppression_active($groupe['groupe_Suppression_active'], $groupe_Suppression_active, $Code_groupe); if ( $groupe_Suppression_active!=$groupe['groupe_Suppression_active'] ) { $mf_colonnes_a_modifier[] = 'groupe_Suppression_active=' . format_sql('groupe_Suppression_active', $groupe_Suppression_active); $bool__groupe_Suppression_active = true; } }
            $bool__Code_campagne = false; if ( $Code_campagne!=0 && $Code_campagne!=$groupe['Code_campagne'] ) { Hook_groupe::data_controller__Code_campagne($groupe['Code_campagne'], $Code_campagne, $Code_groupe); if ( $Code_campagne!=0 && $Code_campagne!=$groupe['Code_campagne'] ) { $mf_colonnes_a_modifier[] = 'Code_campagne=' . $Code_campagne; $bool__Code_campagne = true; } }
            if (count($mf_colonnes_a_modifier)>0) {
                $mf_signature = text_sql(Hook_groupe::calcul_signature($groupe_Nom, $groupe_Description, $groupe_Logo_Fichier, $groupe_Effectif, $groupe_Actif, $groupe_Date_creation, $groupe_Delai_suppression_jour, $groupe_Suppression_active, $Code_campagne));
                $mf_cle_unique = text_sql(Hook_groupe::calcul_cle_unique($groupe_Nom, $groupe_Description, $groupe_Logo_Fichier, $groupe_Effectif, $groupe_Actif, $groupe_Date_creation, $groupe_Delai_suppression_jour, $groupe_Suppression_active, $Code_campagne));
                $mf_colonnes_a_modifier[] = 'mf_signature=\'' . $mf_signature . '\'';
                $mf_colonnes_a_modifier[] = 'mf_cle_unique=\'' . $mf_cle_unique . '\'';
                $mf_colonnes_a_modifier[] = 'mf_date_modification=\'' . get_now() . '\'';
                $requete = 'UPDATE '.inst('groupe').' SET ' . enumeration($mf_colonnes_a_modifier) . ' WHERE Code_groupe = ' . $Code_groupe . ';';
                $cle = md5($requete).salt(10);
                self::$cache_db->pause($cle);
                executer_requete_mysql( $requete , true);
                if ( requete_mysqli_affected_rows()==0 )
                {
                    $code_erreur = ERR_GROUPE__MODIFIER__AUCUN_CHANGEMENT;
                    self::$cache_db->reprendre($cle);
                }
                else
                {
                    self::$cache_db->clear();
                    self::$cache_db->reprendre($cle);
                    Hook_groupe::modifier($Code_groupe, $bool__groupe_Nom, $bool__groupe_Description, $bool__groupe_Logo_Fichier, $bool__groupe_Effectif, $bool__groupe_Actif, $bool__groupe_Date_creation, $bool__groupe_Delai_suppression_jour, $bool__groupe_Suppression_active, $bool__Code_campagne);
                }
            }
            else
            {
                $code_erreur = ERR_GROUPE__MODIFIER__AUCUN_CHANGEMENT;
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
        return array('code_erreur' => $code_erreur, 'callback' => ( $code_erreur == 0 ? Hook_groupe::callback_put($Code_groupe) : null ));
    }

    public function mf_modifier_2($lignes, $force=false) // array( $Code_groupe => array('colonne1' => 'valeur1',  [...] ) )
    {
        $code_erreur = 0;
        foreach ( $lignes as $Code_groupe => $colonnes )
        {
            if ( $code_erreur==0 )
            {
                $Code_groupe = round($Code_groupe);
                $groupe = $this->mf_get_2($Code_groupe, array('autocompletion' => false));
                if (!$force)
                {
                    if (!self::$maj_droits_modifier_en_cours)
                    {
                        self::$maj_droits_modifier_en_cours = true;
                        Hook_groupe::hook_actualiser_les_droits_modifier($Code_groupe);
                        self::$maj_droits_modifier_en_cours = false;
                    }
                }
                $Code_campagne = ( isset($colonnes['Code_campagne']) && ( $force || mf_matrice_droits(['api_modifier_ref__groupe__Code_campagne', 'groupe__MODIFIER']) ) ? $colonnes['Code_campagne'] : (isset($groupe['Code_campagne']) ? $groupe['Code_campagne'] : 0 ));
                $groupe_Nom = ( isset($colonnes['groupe_Nom']) && ( $force || mf_matrice_droits(['api_modifier__groupe_Nom', 'groupe__MODIFIER']) ) ? $colonnes['groupe_Nom'] : ( isset($groupe['groupe_Nom']) ? $groupe['groupe_Nom'] : '' ) );
                $groupe_Description = ( isset($colonnes['groupe_Description']) && ( $force || mf_matrice_droits(['api_modifier__groupe_Description', 'groupe__MODIFIER']) ) ? $colonnes['groupe_Description'] : ( isset($groupe['groupe_Description']) ? $groupe['groupe_Description'] : '' ) );
                $groupe_Logo_Fichier = ( isset($colonnes['groupe_Logo_Fichier']) && ( $force || mf_matrice_droits(['api_modifier__groupe_Logo_Fichier', 'groupe__MODIFIER']) ) ? $colonnes['groupe_Logo_Fichier'] : ( isset($groupe['groupe_Logo_Fichier']) ? $groupe['groupe_Logo_Fichier'] : '' ) );
                $groupe_Effectif = ( isset($colonnes['groupe_Effectif']) && ( $force || mf_matrice_droits(['api_modifier__groupe_Effectif', 'groupe__MODIFIER']) ) ? $colonnes['groupe_Effectif'] : ( isset($groupe['groupe_Effectif']) ? $groupe['groupe_Effectif'] : '' ) );
                $groupe_Actif = ( isset($colonnes['groupe_Actif']) && ( $force || mf_matrice_droits(['api_modifier__groupe_Actif', 'groupe__MODIFIER']) ) ? $colonnes['groupe_Actif'] : ( isset($groupe['groupe_Actif']) ? $groupe['groupe_Actif'] : '' ) );
                $groupe_Date_creation = ( isset($colonnes['groupe_Date_creation']) && ( $force || mf_matrice_droits(['api_modifier__groupe_Date_creation', 'groupe__MODIFIER']) ) ? $colonnes['groupe_Date_creation'] : ( isset($groupe['groupe_Date_creation']) ? $groupe['groupe_Date_creation'] : '' ) );
                $groupe_Delai_suppression_jour = ( isset($colonnes['groupe_Delai_suppression_jour']) && ( $force || mf_matrice_droits(['api_modifier__groupe_Delai_suppression_jour', 'groupe__MODIFIER']) ) ? $colonnes['groupe_Delai_suppression_jour'] : ( isset($groupe['groupe_Delai_suppression_jour']) ? $groupe['groupe_Delai_suppression_jour'] : '' ) );
                $groupe_Suppression_active = ( isset($colonnes['groupe_Suppression_active']) && ( $force || mf_matrice_droits(['api_modifier__groupe_Suppression_active', 'groupe__MODIFIER']) ) ? $colonnes['groupe_Suppression_active'] : ( isset($groupe['groupe_Suppression_active']) ? $groupe['groupe_Suppression_active'] : '' ) );
                $retour = $this->mf_modifier($Code_groupe, $groupe_Nom, $groupe_Description, $groupe_Logo_Fichier, $groupe_Effectif, $groupe_Actif, $groupe_Date_creation, $groupe_Delai_suppression_jour, $groupe_Suppression_active, $Code_campagne, true);
                if ( $retour['code_erreur']!=0 && $retour['code_erreur'] != ERR_GROUPE__MODIFIER__AUCUN_CHANGEMENT )
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

    public function mf_modifier_3($lignes) // array( $Code_groupe => array('colonne1' => 'valeur1',  [...] ) )
    {
        $code_erreur = 0;
        $modifs = false;

        // transformation des lignes en colonnes
        $valeurs_en_colonnes=array();
        $indices_par_colonne=array();
        $liste_valeurs_indexees=array();
        foreach ( $lignes as $Code_groupe => $colonnes )
        {
            foreach ($colonnes as $colonne => $valeur)
            {
                if ( $colonne=='groupe_Nom' || $colonne=='groupe_Description' || $colonne=='groupe_Logo_Fichier' || $colonne=='groupe_Effectif' || $colonne=='groupe_Actif' || $colonne=='groupe_Date_creation' || $colonne=='groupe_Delai_suppression_jour' || $colonne=='groupe_Suppression_active' || $colonne=='Code_campagne' )
                {
                    $valeurs_en_colonnes[$colonne][$Code_groupe]=$valeur;
                    $indices_par_colonne[$colonne][]=$Code_groupe;
                    $liste_valeurs_indexees[$colonne][''.$valeur][]=$Code_groupe;
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
                $modification_sql = $colonne . ' = CASE Code_groupe';
                foreach ( $valeurs as $Code_groupe => $valeur )
                {
                    $modification_sql.=' WHEN ' . $Code_groupe . ' THEN ' . format_sql($colonne, $valeur);
                }
                $modification_sql.=' END';
                $perimetre = Sql_Format_Liste($indices_par_colonne[$colonne]);
                executer_requete_mysql('UPDATE ' . inst('groupe') . ' SET ' . $modification_sql . ' WHERE Code_groupe IN ' . $perimetre . ';', true);
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
                    executer_requete_mysql('UPDATE ' . inst('groupe') . ' SET ' . $colonne . ' = ' . format_sql($colonne, $valeur) . ' WHERE Code_groupe IN ' . $perimetre . ';', true);
                    if ( requete_mysqli_affected_rows()!=0 )
                    {
                        $modifs = true;
                    }
                }
            }
        }

        if ( ! $modifs && $code_erreur==0 )
        {
            $code_erreur = ERR_GROUPE__MODIFIER_3__AUCUN_CHANGEMENT;
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

    public function mf_modifier_4( $Code_campagne, $data, $options = array( 'cond_mysql' => array() ) ) // $data = array('colonne1' => 'valeur1', ... )
    {
        $code_erreur = 0;
        $Code_campagne = round($Code_campagne);
        $mf_colonnes_a_modifier=[];
        if ( isset($data['groupe_Nom']) ) { $mf_colonnes_a_modifier[] = 'groupe_Nom = ' . format_sql('groupe_Nom', $data['groupe_Nom']); }
        if ( isset($data['groupe_Description']) ) { $mf_colonnes_a_modifier[] = 'groupe_Description = ' . format_sql('groupe_Description', $data['groupe_Description']); }
        if ( isset($data['groupe_Logo_Fichier']) ) { $mf_colonnes_a_modifier[] = 'groupe_Logo_Fichier = ' . format_sql('groupe_Logo_Fichier', $data['groupe_Logo_Fichier']); }
        if ( isset($data['groupe_Effectif']) ) { $mf_colonnes_a_modifier[] = 'groupe_Effectif = ' . format_sql('groupe_Effectif', $data['groupe_Effectif']); }
        if ( isset($data['groupe_Actif']) ) { $mf_colonnes_a_modifier[] = 'groupe_Actif = ' . format_sql('groupe_Actif', $data['groupe_Actif']); }
        if ( isset($data['groupe_Date_creation']) ) { $mf_colonnes_a_modifier[] = 'groupe_Date_creation = ' . format_sql('groupe_Date_creation', $data['groupe_Date_creation']); }
        if ( isset($data['groupe_Delai_suppression_jour']) ) { $mf_colonnes_a_modifier[] = 'groupe_Delai_suppression_jour = ' . format_sql('groupe_Delai_suppression_jour', $data['groupe_Delai_suppression_jour']); }
        if ( isset($data['groupe_Suppression_active']) ) { $mf_colonnes_a_modifier[] = 'groupe_Suppression_active = ' . format_sql('groupe_Suppression_active', $data['groupe_Suppression_active']); }
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

            $requete = 'UPDATE ' . inst('groupe') . ' SET ' . enumeration($mf_colonnes_a_modifier) . " WHERE 1".( $Code_campagne!=0 ? " AND Code_campagne=$Code_campagne" : "" )."$argument_cond;";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_GROUPE__MODIFIER_4__AUCUN_CHANGEMENT;
            }
            else
            {
                self::$cache_db->clear();
            }
            self::$cache_db->reprendre($cle);
        }
        return array('code_erreur' => $code_erreur);
    }

    public function mf_supprimer($Code_groupe, $force=false)
    {
        $code_erreur = 0;
        $Code_groupe = round($Code_groupe);
        if (!$force)
        {
            if (!self::$maj_droits_supprimer_en_cours)
            {
                self::$maj_droits_supprimer_en_cours = true;
                Hook_groupe::hook_actualiser_les_droits_supprimer($Code_groupe);
                self::$maj_droits_supprimer_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['groupe__SUPPRIMER']) ) $code_erreur = REFUS_GROUPE__SUPPRIMER;
        elseif ( !$this->mf_tester_existance_Code_groupe($Code_groupe) ) $code_erreur = ERR_GROUPE__SUPPRIMER_2__CODE_GROUPE_INEXISTANT;
        elseif ( CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_groupe', $Code_groupe) ) $code_erreur = ACCES_CODE_GROUPE_REFUSE;
        elseif ( !Hook_groupe::autorisation_suppression($Code_groupe) ) $code_erreur = REFUS_GROUPE__SUPPRESSION_BLOQUEE;
        else
        {
            $copie__groupe = $this->mf_get($Code_groupe, array('autocompletion' => false));
            $this->supprimer_donnes_en_cascade("groupe", array($Code_groupe));
            $requete = "DELETE IGNORE FROM ".inst('groupe')." WHERE Code_groupe=$Code_groupe;";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_GROUPE__SUPPRIMER__REFUSEE;
                self::$cache_db->reprendre($cle);
            }
            else
            {
                self::$cache_db->clear();
                self::$cache_db->reprendre($cle);
                Hook_groupe::supprimer($copie__groupe);
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

    public function mf_supprimer_2($liste_Code_groupe, $force=false)
    {
        $code_erreur=0;
        $copie__liste_groupe = $this->mf_lister_2($liste_Code_groupe, array('autocompletion' => false));
        $liste_Code_groupe=array();
        foreach ( $copie__liste_groupe as $copie__groupe )
        {
            $Code_groupe = $copie__groupe['Code_groupe'];
            if (!$force)
            {
                if (!self::$maj_droits_supprimer_en_cours)
                {
                    self::$maj_droits_supprimer_en_cours = true;
                    Hook_groupe::hook_actualiser_les_droits_supprimer($Code_groupe);
                    self::$maj_droits_supprimer_en_cours = false;
                }
            }
            if ( !$force && !mf_matrice_droits(['groupe__SUPPRIMER']) ) $code_erreur = REFUS_GROUPE__SUPPRIMER;
            elseif ( !Hook_groupe::autorisation_suppression($Code_groupe) ) $code_erreur = REFUS_GROUPE__SUPPRESSION_BLOQUEE;
            {
                $liste_Code_groupe[] = $Code_groupe;
            }
        }
        if ( $code_erreur==0 && count($liste_Code_groupe)>0 )
        {
            $this->supprimer_donnes_en_cascade("groupe", $liste_Code_groupe);
            $requete = "DELETE IGNORE FROM ".inst('groupe')." WHERE Code_groupe IN ".Sql_Format_Liste($liste_Code_groupe).";";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_GROUPE__SUPPRIMER_2__REFUSEE;
                self::$cache_db->reprendre($cle);
            }
            else
            {
                self::$cache_db->clear();
                self::$cache_db->reprendre($cle);
                Hook_groupe::supprimer_2($copie__liste_groupe);
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

    public function mf_supprimer_3($liste_Code_groupe)
    {
        $code_erreur=0;
        if ( count($liste_Code_groupe)>0 )
        {
            $this->supprimer_donnes_en_cascade("groupe", $liste_Code_groupe);
            $requete = "DELETE IGNORE FROM ".inst('groupe')." WHERE Code_groupe IN ".Sql_Format_Liste($liste_Code_groupe).";";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_GROUPE__SUPPRIMER_3__REFUSEE;
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
        if ( ! $contexte_parent && $mf_contexte['Code_groupe']!=0 )
        {
            $groupe = $this->mf_get( $mf_contexte['Code_groupe'], $options);
            return array( $groupe['Code_groupe'] => $groupe );
        }
        else
        {
            return $this->mf_lister(isset($est_charge['campagne']) ? $mf_contexte['Code_campagne'] : 0, $options);
        }
    }

    public function mf_lister($Code_campagne=0, $options = array( 'cond_mysql' => array(), 'tris' => array(), 'limit' => array(), 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ))
    {
        $cle = "groupe__lister";
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

        // tris
        $argument_tris = '';
        if ( ! isset($options['tris']) )
        {
            $options['tris']=array();
        }
        if ( count($options['tris'])==0 )
        {
            global $mf_tri_defaut_table;
            if ( isset($mf_tri_defaut_table['groupe']) )
            {
                $options['tris'] = $mf_tri_defaut_table['groupe'];
            }
        }
        foreach ($options['tris'] as $colonne => $tri)
        {
            if ( $colonne != 'groupe_Description' )
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
                    if ( strpos($argument_cond, 'groupe_Nom')!==false ) { $liste_colonnes_a_indexer['groupe_Nom'] = 'groupe_Nom'; }
                    if ( strpos($argument_cond, 'groupe_Logo_Fichier')!==false ) { $liste_colonnes_a_indexer['groupe_Logo_Fichier'] = 'groupe_Logo_Fichier'; }
                    if ( strpos($argument_cond, 'groupe_Effectif')!==false ) { $liste_colonnes_a_indexer['groupe_Effectif'] = 'groupe_Effectif'; }
                    if ( strpos($argument_cond, 'groupe_Actif')!==false ) { $liste_colonnes_a_indexer['groupe_Actif'] = 'groupe_Actif'; }
                    if ( strpos($argument_cond, 'groupe_Date_creation')!==false ) { $liste_colonnes_a_indexer['groupe_Date_creation'] = 'groupe_Date_creation'; }
                    if ( strpos($argument_cond, 'groupe_Delai_suppression_jour')!==false ) { $liste_colonnes_a_indexer['groupe_Delai_suppression_jour'] = 'groupe_Delai_suppression_jour'; }
                    if ( strpos($argument_cond, 'groupe_Suppression_active')!==false ) { $liste_colonnes_a_indexer['groupe_Suppression_active'] = 'groupe_Suppression_active'; }
                }
                if ( isset($options['tris']) )
                {
                    if ( isset($options['tris']['groupe_Nom']) ) { $liste_colonnes_a_indexer['groupe_Nom'] = 'groupe_Nom'; }
                    if ( isset($options['tris']['groupe_Logo_Fichier']) ) { $liste_colonnes_a_indexer['groupe_Logo_Fichier'] = 'groupe_Logo_Fichier'; }
                    if ( isset($options['tris']['groupe_Effectif']) ) { $liste_colonnes_a_indexer['groupe_Effectif'] = 'groupe_Effectif'; }
                    if ( isset($options['tris']['groupe_Actif']) ) { $liste_colonnes_a_indexer['groupe_Actif'] = 'groupe_Actif'; }
                    if ( isset($options['tris']['groupe_Date_creation']) ) { $liste_colonnes_a_indexer['groupe_Date_creation'] = 'groupe_Date_creation'; }
                    if ( isset($options['tris']['groupe_Delai_suppression_jour']) ) { $liste_colonnes_a_indexer['groupe_Delai_suppression_jour'] = 'groupe_Delai_suppression_jour'; }
                    if ( isset($options['tris']['groupe_Suppression_active']) ) { $liste_colonnes_a_indexer['groupe_Suppression_active'] = 'groupe_Suppression_active'; }
                }
                if ( count($liste_colonnes_a_indexer)>0 )
                {
                    if ( ! $mf_liste_requete_index = self::$cache_db->read('groupe__index') )
                    {
                        $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('groupe').'`;', false);
                        $mf_liste_requete_index = array();
                        while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                        {
                            $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                        }
                        mysqli_free_result($res_requete_index);
                        self::$cache_db->write('groupe__index', $mf_liste_requete_index);
                    }
                    foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                    {
                        if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                    }
                    if ( count($liste_colonnes_a_indexer) > 0 )
                    {
                        self::$cache_db->pause('groupe__index');
                        foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                        {
                            executer_requete_mysql('ALTER TABLE `'.inst('groupe').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                        }
                        self::$cache_db->clear();
                        self::$cache_db->reprendre('groupe__index');
                    }
                }

                $liste = array();
                $liste_groupe_pas_a_jour = array();
                if ($toutes_colonnes)
                {
                    $colonnes='Code_groupe, groupe_Nom, groupe_Description, groupe_Logo_Fichier, groupe_Effectif, groupe_Actif, groupe_Date_creation, groupe_Delai_suppression_jour, groupe_Suppression_active, Code_campagne';
                }
                else
                {
                    $colonnes='Code_groupe, groupe_Nom, groupe_Logo_Fichier, groupe_Effectif, groupe_Actif, groupe_Date_creation, groupe_Delai_suppression_jour, groupe_Suppression_active, Code_campagne';
                }
                $res_requete = executer_requete_mysql("SELECT $colonnes FROM ".inst('groupe')." WHERE 1{$argument_cond}".( $Code_campagne!=0 ? " AND Code_campagne=$Code_campagne" : "" )."{$argument_tris}{$argument_limit};", false);
                while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
                {
                    $liste[$row_requete['Code_groupe']]=$row_requete;
                    if ( $maj && ! Hook_groupe::est_a_jour( $row_requete ) )
                    {
                        $liste_groupe_pas_a_jour[$row_requete['Code_groupe']] = $row_requete;
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
                Hook_groupe::mettre_a_jour( $liste_groupe_pas_a_jour );
            }
        }

        foreach ($liste as $elem)
        {
            if ( $controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_groupe', $elem['Code_groupe']) )
            {
                unset($liste[$elem['Code_groupe']]);
            }
            else
            {
                if (!self::$auto_completion && $autocompletion)
                {
                    self::$auto_completion = true;
                    Hook_groupe::completion($liste[$elem['Code_groupe']]);
                    self::$auto_completion = false;
                }
            }
        }

        return $liste;
    }

    public function mf_lister_2($liste_Code_groupe, $options = array( 'cond_mysql' => array(), 'tris' => array(), 'limit' => array(), 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ))
    {
        if ( count($liste_Code_groupe)>0 )
        {
            $cle = "groupe__mf_lister_2_".Sql_Format_Liste($liste_Code_groupe);

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
                if ( isset($mf_tri_defaut_table['groupe']) )
                {
                    $options['tris'] = $mf_tri_defaut_table['groupe'];
                }
            }
            foreach ($options['tris'] as $colonne => $tri)
            {
                if ( $colonne != 'groupe_Description' )
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
                        if ( strpos($argument_cond, 'groupe_Nom')!==false ) { $liste_colonnes_a_indexer['groupe_Nom'] = 'groupe_Nom'; }
                        if ( strpos($argument_cond, 'groupe_Logo_Fichier')!==false ) { $liste_colonnes_a_indexer['groupe_Logo_Fichier'] = 'groupe_Logo_Fichier'; }
                        if ( strpos($argument_cond, 'groupe_Effectif')!==false ) { $liste_colonnes_a_indexer['groupe_Effectif'] = 'groupe_Effectif'; }
                        if ( strpos($argument_cond, 'groupe_Actif')!==false ) { $liste_colonnes_a_indexer['groupe_Actif'] = 'groupe_Actif'; }
                        if ( strpos($argument_cond, 'groupe_Date_creation')!==false ) { $liste_colonnes_a_indexer['groupe_Date_creation'] = 'groupe_Date_creation'; }
                        if ( strpos($argument_cond, 'groupe_Delai_suppression_jour')!==false ) { $liste_colonnes_a_indexer['groupe_Delai_suppression_jour'] = 'groupe_Delai_suppression_jour'; }
                        if ( strpos($argument_cond, 'groupe_Suppression_active')!==false ) { $liste_colonnes_a_indexer['groupe_Suppression_active'] = 'groupe_Suppression_active'; }
                    }
                    if ( isset($options['tris']) )
                    {
                        if ( isset($options['tris']['groupe_Nom']) ) { $liste_colonnes_a_indexer['groupe_Nom'] = 'groupe_Nom'; }
                        if ( isset($options['tris']['groupe_Logo_Fichier']) ) { $liste_colonnes_a_indexer['groupe_Logo_Fichier'] = 'groupe_Logo_Fichier'; }
                        if ( isset($options['tris']['groupe_Effectif']) ) { $liste_colonnes_a_indexer['groupe_Effectif'] = 'groupe_Effectif'; }
                        if ( isset($options['tris']['groupe_Actif']) ) { $liste_colonnes_a_indexer['groupe_Actif'] = 'groupe_Actif'; }
                        if ( isset($options['tris']['groupe_Date_creation']) ) { $liste_colonnes_a_indexer['groupe_Date_creation'] = 'groupe_Date_creation'; }
                        if ( isset($options['tris']['groupe_Delai_suppression_jour']) ) { $liste_colonnes_a_indexer['groupe_Delai_suppression_jour'] = 'groupe_Delai_suppression_jour'; }
                        if ( isset($options['tris']['groupe_Suppression_active']) ) { $liste_colonnes_a_indexer['groupe_Suppression_active'] = 'groupe_Suppression_active'; }
                    }
                    if ( count($liste_colonnes_a_indexer)>0 )
                    {
                        if ( ! $mf_liste_requete_index = self::$cache_db->read('groupe__index') )
                        {
                            $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('groupe').'`;', false);
                            $mf_liste_requete_index = array();
                            while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                            {
                                $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                            }
                            mysqli_free_result($res_requete_index);
                            self::$cache_db->write('groupe__index', $mf_liste_requete_index);
                        }
                        foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                        {
                            if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                        }
                        if ( count($liste_colonnes_a_indexer) > 0 )
                        {
                            self::$cache_db->pause('groupe__index');
                            foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                            {
                                executer_requete_mysql('ALTER TABLE `'.inst('groupe').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                            }
                            self::$cache_db->clear();
                            self::$cache_db->reprendre('groupe__index');
                        }
                    }

                    $liste = array();
                    $liste_groupe_pas_a_jour = array();
                    if ($toutes_colonnes)
                    {
                        $colonnes='Code_groupe, groupe_Nom, groupe_Description, groupe_Logo_Fichier, groupe_Effectif, groupe_Actif, groupe_Date_creation, groupe_Delai_suppression_jour, groupe_Suppression_active, Code_campagne';
                    }
                    else
                    {
                        $colonnes='Code_groupe, groupe_Nom, groupe_Logo_Fichier, groupe_Effectif, groupe_Actif, groupe_Date_creation, groupe_Delai_suppression_jour, groupe_Suppression_active, Code_campagne';
                    }
                    $res_requete = executer_requete_mysql("SELECT $colonnes FROM ".inst('groupe')." WHERE 1{$argument_cond} AND Code_groupe IN ".Sql_Format_Liste($liste_Code_groupe)."{$argument_tris}{$argument_limit};", false);
                    while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
                    {
                        $liste[$row_requete['Code_groupe']]=$row_requete;
                        if ( $maj && ! Hook_groupe::est_a_jour( $row_requete ) )
                        {
                            $liste_groupe_pas_a_jour[$row_requete['Code_groupe']] = $row_requete;
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
                    Hook_groupe::mettre_a_jour( $liste_groupe_pas_a_jour );
                }
            }

            foreach ($liste as $elem)
            {
                if ( $controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_groupe', $elem['Code_groupe']) )
                {
                    unset($liste[$elem['Code_groupe']]);
                }
                else
                {
                    if (!self::$auto_completion && $autocompletion)
                    {
                        self::$auto_completion = true;
                        Hook_groupe::completion($liste[$elem['Code_groupe']]);
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

    public function mf_get($Code_groupe, $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ])
    {
        $Code_groupe = round($Code_groupe);
        $retour = array();
        if ( ! CONTROLE_ACCES_DONNEES_DEFAUT || Hook_mf_systeme::controle_acces_donnees('Code_groupe', $Code_groupe) )
        {
            $cle = 'groupe__get_'.$Code_groupe;

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
                        $colonnes='Code_groupe, groupe_Nom, groupe_Description, groupe_Logo_Fichier, groupe_Effectif, groupe_Actif, groupe_Date_creation, groupe_Delai_suppression_jour, groupe_Suppression_active, Code_campagne';
                    }
                    else
                    {
                        $colonnes='Code_groupe, groupe_Nom, groupe_Logo_Fichier, groupe_Effectif, groupe_Actif, groupe_Date_creation, groupe_Delai_suppression_jour, groupe_Suppression_active, Code_campagne';
                    }
                    $res_requete = executer_requete_mysql('SELECT ' . $colonnes . ' FROM ' . inst('groupe') . ' WHERE Code_groupe = ' . $Code_groupe . ';', false);
                    if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
                    {
                        $retour=$row_requete;
                        if ( $maj && ! Hook_groupe::est_a_jour( $row_requete ) )
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
                    Hook_groupe::mettre_a_jour( array( $row_requete['Code_groupe'] => $row_requete ) );
                }
            }
            if ( isset( $retour['Code_groupe'] ) )
            {
                if (!self::$auto_completion && $autocompletion)
                {
                    self::$auto_completion = true;
                    Hook_groupe::completion($retour);
                    self::$auto_completion = false;
                }
            }
        }
        return $retour;
    }

    public function mf_get_last($Code_campagne=0, $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ])
    {
        $cle = "groupe__get_last";
        $Code_campagne = round($Code_campagne);
        $cle.='_' . $Code_campagne;
        if ( ! $retour = self::$cache_db->read($cle) )
        {
            $Code_groupe = 0;
            $res_requete = executer_requete_mysql('SELECT Code_groupe FROM ' . inst('groupe') . " WHERE 1".( $Code_campagne!=0 ? " AND Code_campagne=$Code_campagne" : "" )." ORDER BY mf_date_creation DESC, Code_groupe DESC LIMIT 0 , 1;", false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $Code_groupe = $row_requete['Code_groupe'];
            }
            mysqli_free_result($res_requete);
            $retour = $this->mf_get($Code_groupe, $options);
            self::$cache_db->write($cle, $retour);
        }
        return $retour;
    }

    public function mf_get_2($Code_groupe, $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ])
    {
        $Code_groupe = round($Code_groupe);
        $retour = array();
        $cle = 'groupe__get_'.$Code_groupe;

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
                $colonnes='Code_groupe, groupe_Nom, groupe_Description, groupe_Logo_Fichier, groupe_Effectif, groupe_Actif, groupe_Date_creation, groupe_Delai_suppression_jour, groupe_Suppression_active, Code_campagne';
            }
            else
            {
                $colonnes='Code_groupe, groupe_Nom, groupe_Logo_Fichier, groupe_Effectif, groupe_Actif, groupe_Date_creation, groupe_Delai_suppression_jour, groupe_Suppression_active, Code_campagne';
            }
            $res_requete = executer_requete_mysql('SELECT ' . $colonnes . " FROM ".inst('groupe')." WHERE Code_groupe = $Code_groupe;", false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $retour=$row_requete;
            }
            mysqli_free_result($res_requete);
            self::$cache_db->write($cle, $retour);
        }
        if ( isset( $retour['Code_groupe'] ) )
        {
            if (!self::$auto_completion && $autocompletion)
            {
                self::$auto_completion = true;
                Hook_groupe::completion($retour);
                self::$auto_completion = false;
            }
        }
        return $retour;
    }

    public function mf_prec_et_suiv($Code_groupe, $Code_campagne=0, $options = array( 'cond_mysql' => array(), 'tris' => array(), 'limit' => array(), 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ))
    {
        $Code_groupe = round($Code_groupe);
        $liste = $this->mf_lister($Code_campagne, $options);
        return prec_suiv($liste, $Code_groupe);
    }

    public function mf_compter($Code_campagne=0, $options = array( 'cond_mysql' => array() ))
    {
        $cle = 'groupe__compter';
        $Code_campagne = round($Code_campagne);
        $cle.='_{'.$Code_campagne.'}';

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
                if ( ! $mf_liste_requete_index = self::$cache_db->read('groupe__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('groupe').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    self::$cache_db->write('groupe__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    self::$cache_db->pause('groupe__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('groupe').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    self::$cache_db->clear();
                    self::$cache_db->reprendre('groupe__index');
                }
            }

            $res_requete = executer_requete_mysql("SELECT count(Code_groupe) as nb FROM ".inst('groupe')." WHERE 1{$argument_cond}".( $Code_campagne!=0 ? " AND Code_campagne=$Code_campagne" : "" ).";", false);
            $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC);
            mysqli_free_result($res_requete);
            $nb = round($row_requete['nb']);
            self::$cache_db->write($cle, $nb);
        }
        return $nb;
    }

    public function mfi_compter( $interface, $options = array( 'cond_mysql' => array() ) )
    {
        $Code_campagne = isset($interface['Code_campagne']) ? round($interface['Code_campagne']) : 0;
        return $this->mf_compter( $Code_campagne, $options );
    }

    public function mf_liste_Code_groupe($Code_campagne=0, $options = array( 'cond_mysql' => array() ))
    {
        return $this->get_liste_Code_groupe($Code_campagne, $options);
    }

    public function mf_convertir_Code_groupe_vers_Code_campagne( $Code_groupe )
    {
        return $this->Code_groupe_vers_Code_campagne( $Code_groupe );
    }

    public function mf_liste_Code_campagne_vers_liste_Code_groupe( $liste_Code_campagne, $options = array( 'cond_mysql' => array() ) )
    {
        return $this->liste_Code_campagne_vers_liste_Code_groupe( $liste_Code_campagne, $options );
    }

    public function mf_liste_Code_groupe_vers_liste_Code_campagne( $liste_Code_groupe, $options = array( 'cond_mysql' => array() ) )
    {
        return $this->groupe__liste_Code_groupe_vers_liste_Code_campagne( $liste_Code_groupe, $options );
    }

    public function mf_get_liste_tables_enfants()
    {
        return $this->get_liste_tables_enfants( 'groupe' );
    }

    public function mf_get_liste_tables_parents()
    {
        return array('Code_campagne');
    }

    public function mf_search_groupe_Nom( $groupe_Nom, $Code_campagne=0 )
    {
        return $this->rechercher_groupe_Nom( $groupe_Nom, $Code_campagne );
    }

    public function mf_search_groupe_Logo_Fichier( $groupe_Logo_Fichier, $Code_campagne=0 )
    {
        return $this->rechercher_groupe_Logo_Fichier( $groupe_Logo_Fichier, $Code_campagne );
    }

    public function mf_search_groupe_Effectif( $groupe_Effectif, $Code_campagne=0 )
    {
        return $this->rechercher_groupe_Effectif( $groupe_Effectif, $Code_campagne );
    }

    public function mf_search_groupe_Actif( $groupe_Actif, $Code_campagne=0 )
    {
        return $this->rechercher_groupe_Actif( $groupe_Actif, $Code_campagne );
    }

    public function mf_search_groupe_Date_creation( $groupe_Date_creation, $Code_campagne=0 )
    {
        return $this->rechercher_groupe_Date_creation( $groupe_Date_creation, $Code_campagne );
    }

    public function mf_search_groupe_Delai_suppression_jour( $groupe_Delai_suppression_jour, $Code_campagne=0 )
    {
        return $this->rechercher_groupe_Delai_suppression_jour( $groupe_Delai_suppression_jour, $Code_campagne );
    }

    public function mf_search_groupe_Suppression_active( $groupe_Suppression_active, $Code_campagne=0 )
    {
        return $this->rechercher_groupe_Suppression_active( $groupe_Suppression_active, $Code_campagne );
    }

    public function mf_search__colonne( $colonne_db, $recherche, $Code_campagne=0 )
    {
        switch ($colonne_db) {
            case 'groupe_Nom': return $this->mf_search_groupe_Nom( $recherche, $Code_campagne ); break;
            case 'groupe_Logo_Fichier': return $this->mf_search_groupe_Logo_Fichier( $recherche, $Code_campagne ); break;
            case 'groupe_Effectif': return $this->mf_search_groupe_Effectif( $recherche, $Code_campagne ); break;
            case 'groupe_Actif': return $this->mf_search_groupe_Actif( $recherche, $Code_campagne ); break;
            case 'groupe_Date_creation': return $this->mf_search_groupe_Date_creation( $recherche, $Code_campagne ); break;
            case 'groupe_Delai_suppression_jour': return $this->mf_search_groupe_Delai_suppression_jour( $recherche, $Code_campagne ); break;
            case 'groupe_Suppression_active': return $this->mf_search_groupe_Suppression_active( $recherche, $Code_campagne ); break;
        }
    }

    public function mf_get_next_id()
    {
        $res_requete = executer_requete_mysql('SELECT AUTO_INCREMENT as next_id FROM INFORMATION_SCHEMA.TABLES WHERE table_name = \'groupe\';', false);
        $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC);
        mysqli_free_result($res_requete);
        return round($row_requete['next_id']);
    }

    public function mf_search($ligne) // array('colonne1' => 'valeur1',  [...] )
    {
        global $mf_initialisation;
        $Code_campagne = (isset($ligne['Code_campagne'])?round($ligne['Code_campagne']):0);
        $groupe_Nom = (isset($ligne['groupe_Nom'])?$ligne['groupe_Nom']:$mf_initialisation['groupe_Nom']);
        $groupe_Description = (isset($ligne['groupe_Description'])?$ligne['groupe_Description']:$mf_initialisation['groupe_Description']);
        $groupe_Logo_Fichier = (isset($ligne['groupe_Logo_Fichier'])?$ligne['groupe_Logo_Fichier']:$mf_initialisation['groupe_Logo_Fichier']);
        $groupe_Effectif = (isset($ligne['groupe_Effectif'])?$ligne['groupe_Effectif']:$mf_initialisation['groupe_Effectif']);
        $groupe_Actif = (isset($ligne['groupe_Actif'])?$ligne['groupe_Actif']:$mf_initialisation['groupe_Actif']);
        $groupe_Date_creation = (isset($ligne['groupe_Date_creation'])?$ligne['groupe_Date_creation']:$mf_initialisation['groupe_Date_creation']);
        $groupe_Delai_suppression_jour = (isset($ligne['groupe_Delai_suppression_jour'])?$ligne['groupe_Delai_suppression_jour']:$mf_initialisation['groupe_Delai_suppression_jour']);
        $groupe_Suppression_active = (isset($ligne['groupe_Suppression_active'])?$ligne['groupe_Suppression_active']:$mf_initialisation['groupe_Suppression_active']);
        $groupe_Actif = round($groupe_Actif);
        $groupe_Date_creation = format_datetime($groupe_Date_creation);
        $groupe_Delai_suppression_jour = round($groupe_Delai_suppression_jour);
        Hook_groupe::pre_controller($groupe_Nom, $groupe_Description, $groupe_Logo_Fichier, $groupe_Effectif, $groupe_Actif, $groupe_Date_creation, $groupe_Delai_suppression_jour, $groupe_Suppression_active, $Code_campagne);
        $mf_cle_unique = Hook_groupe::calcul_cle_unique($groupe_Nom, $groupe_Description, $groupe_Logo_Fichier, $groupe_Effectif, $groupe_Actif, $groupe_Date_creation, $groupe_Delai_suppression_jour, $groupe_Suppression_active, $Code_campagne);
        $res_requete = executer_requete_mysql('SELECT Code_groupe FROM ' . inst('groupe') . ' WHERE mf_cle_unique = \''.$mf_cle_unique.'\'', false);
        if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
        {
            $r = round($row_requete['Code_groupe']);
        }
        else
        {
            $r = false;
        }
        mysqli_free_result($res_requete);
        return $r;
    }

}
