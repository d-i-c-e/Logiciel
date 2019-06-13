<?php

/*
    +------------------------------+
    |  NE PAS MODIFIER CE FICHIER  |
    +------------------------------+
*/

class carte_monframework extends entite_monframework
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
            include_once __DIR__ . '/../../erreurs/erreurs__carte.php';
            self::$initialisation = false;
            Hook_carte::initialisation();
            self::$cache_db = new Mf_Cachedb('carte');
        }
        if (!self::$actualisation_en_cours)
        {
            self::$actualisation_en_cours=true;
            Hook_carte::actualisation();
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

        if ( ! test_si_table_existe(inst('carte')) )
        {
            executer_requete_mysql('CREATE TABLE '.inst('carte').'(Code_carte INT AUTO_INCREMENT NOT NULL, PRIMARY KEY (Code_carte)) ENGINE=MyISAM;', true);
        }

        $liste_colonnes = lister_les_colonnes(inst('carte'));

        if ( isset($liste_colonnes['carte_Nom']) )
        {
            if ( typeMyql2Sql($liste_colonnes['carte_Nom']['Type'])!='VARCHAR' )
            {
                executer_requete_mysql('ALTER TABLE '.inst('carte').' CHANGE carte_Nom carte_Nom VARCHAR(255);', true);
            }
            unset($liste_colonnes['carte_Nom']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('carte').' ADD carte_Nom VARCHAR(255);', true);
            executer_requete_mysql('UPDATE '.inst('carte').' SET carte_Nom=' . format_sql('carte_Nom', $mf_initialisation['carte_Nom']) . ';', true);
        }

        if ( isset($liste_colonnes['carte_Hauteur']) )
        {
            if ( typeMyql2Sql($liste_colonnes['carte_Hauteur']['Type'])!='INT' )
            {
                executer_requete_mysql('ALTER TABLE '.inst('carte').' CHANGE carte_Hauteur carte_Hauteur INT;', true);
            }
            unset($liste_colonnes['carte_Hauteur']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('carte').' ADD carte_Hauteur INT;', true);
            executer_requete_mysql('UPDATE '.inst('carte').' SET carte_Hauteur=' . format_sql('carte_Hauteur', $mf_initialisation['carte_Hauteur']) . ';', true);
        }

        if ( isset($liste_colonnes['carte_Largeur']) )
        {
            if ( typeMyql2Sql($liste_colonnes['carte_Largeur']['Type'])!='INT' )
            {
                executer_requete_mysql('ALTER TABLE '.inst('carte').' CHANGE carte_Largeur carte_Largeur INT;', true);
            }
            unset($liste_colonnes['carte_Largeur']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('carte').' ADD carte_Largeur INT;', true);
            executer_requete_mysql('UPDATE '.inst('carte').' SET carte_Largeur=' . format_sql('carte_Largeur', $mf_initialisation['carte_Largeur']) . ';', true);
        }

        if ( isset($liste_colonnes['carte_Fichier']) )
        {
            if ( typeMyql2Sql($liste_colonnes['carte_Fichier']['Type'])!='VARCHAR' )
            {
                executer_requete_mysql('ALTER TABLE '.inst('carte').' CHANGE carte_Fichier carte_Fichier VARCHAR(255);', true);
            }
            unset($liste_colonnes['carte_Fichier']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('carte').' ADD carte_Fichier VARCHAR(255);', true);
            executer_requete_mysql('UPDATE '.inst('carte').' SET carte_Fichier=' . format_sql('carte_Fichier', $mf_initialisation['carte_Fichier']) . ';', true);
        }

        if ( isset($liste_colonnes['Code_groupe']) )
        {
            unset($liste_colonnes['Code_groupe']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('carte').' ADD Code_groupe int NOT NULL;', true);
        }

        if ( isset($liste_colonnes['mf_signature']) )
        {
            unset($liste_colonnes['mf_signature']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('carte').' ADD mf_signature VARCHAR(255);', true);
            executer_requete_mysql('ALTER TABLE '.inst('carte').' ADD INDEX( mf_signature );', true);
        }

        if ( isset($liste_colonnes['mf_cle_unique']) )
        {
            unset($liste_colonnes['mf_cle_unique']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('carte').' ADD mf_cle_unique VARCHAR(255);', true);
            executer_requete_mysql('ALTER TABLE '.inst('carte').' ADD INDEX( mf_cle_unique );', true);
        }

        if ( isset($liste_colonnes['mf_date_creation']) )
        {
            unset($liste_colonnes['mf_date_creation']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('carte').' ADD mf_date_creation DATETIME;', true);
            executer_requete_mysql('ALTER TABLE '.inst('carte').' ADD INDEX( mf_date_creation );', true);
        }

        if ( isset($liste_colonnes['mf_date_modification']) )
        {
            unset($liste_colonnes['mf_date_modification']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('carte').' ADD mf_date_modification DATETIME;', true);
            executer_requete_mysql('ALTER TABLE '.inst('carte').' ADD INDEX( mf_date_modification );', true);
        }

        unset($liste_colonnes['Code_carte']);

        foreach ($liste_colonnes as $field => $value)
        {
            executer_requete_mysql('ALTER TABLE '.inst('carte').' DROP COLUMN '.$field.';', true);
        }

    }

    public function mf_ajouter($carte_Nom, $carte_Hauteur, $carte_Largeur, $carte_Fichier, $Code_groupe, $force=false)
    {
        $Code_carte = 0;
        $code_erreur = 0;
        $Code_groupe = round($Code_groupe);
        $carte_Hauteur = round($carte_Hauteur);
        $carte_Largeur = round($carte_Largeur);
        Hook_carte::pre_controller($carte_Nom, $carte_Hauteur, $carte_Largeur, $carte_Fichier, $Code_groupe);
        if (!$force)
        {
            if (!self::$maj_droits_ajouter_en_cours)
            {
                self::$maj_droits_ajouter_en_cours = true;
                Hook_carte::hook_actualiser_les_droits_ajouter($Code_groupe);
                self::$maj_droits_ajouter_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['carte__AJOUTER']) ) $code_erreur = REFUS_CARTE__AJOUTER;
        elseif ( !$this->mf_tester_existance_Code_groupe($Code_groupe) ) $code_erreur = ERR_CARTE__AJOUTER__CODE_GROUPE_INEXISTANT;
        elseif ( CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_groupe', $Code_groupe) ) $code_erreur = ACCES_CODE_GROUPE_REFUSE;
        elseif ( !Hook_carte::autorisation_ajout($carte_Nom, $carte_Hauteur, $carte_Largeur, $carte_Fichier, $Code_groupe) ) $code_erreur = REFUS_CARTE__AJOUT_BLOQUEE;
        else
        {
            Hook_carte::data_controller($carte_Nom, $carte_Hauteur, $carte_Largeur, $carte_Fichier, $Code_groupe);
            $mf_signature = text_sql(Hook_carte::calcul_signature($carte_Nom, $carte_Hauteur, $carte_Largeur, $carte_Fichier, $Code_groupe));
            $mf_cle_unique = text_sql(Hook_carte::calcul_cle_unique($carte_Nom, $carte_Hauteur, $carte_Largeur, $carte_Fichier, $Code_groupe));
            $carte_Nom = text_sql($carte_Nom);
            $carte_Hauteur = round($carte_Hauteur);
            $carte_Largeur = round($carte_Largeur);
            $carte_Fichier = text_sql($carte_Fichier);
            $requete = "INSERT INTO ".inst('carte')." ( mf_signature, mf_cle_unique, mf_date_creation, mf_date_modification, carte_Nom, carte_Hauteur, carte_Largeur, carte_Fichier, Code_groupe ) VALUES ( '$mf_signature', '$mf_cle_unique', '".get_now()."', '".get_now()."', '$carte_Nom', $carte_Hauteur, $carte_Largeur, '$carte_Fichier', $Code_groupe );";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql($requete, true);
            $Code_carte = requete_mysql_insert_id();
            if ($Code_carte==0)
            {
                $code_erreur = ERR_CARTE__AJOUTER__AJOUT_REFUSE;
                self::$cache_db->reprendre($cle);
            }
            else
            {
                self::$cache_db->clear();
                self::$cache_db->reprendre($cle);
                Hook_carte::ajouter( $Code_carte );
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
        return array('code_erreur' => $code_erreur, 'Code_carte' => $Code_carte, 'callback' => ( $code_erreur==0 ? Hook_carte::callback_post($Code_carte) : null ));
    }

    public function mf_creer($Code_groupe, $force=false)
    {
        global $mf_initialisation, $mf_droits_defaut;
        $mf_droits_defaut["carte__AJOUTER"] = $mf_droits_defaut["carte__CREER"];
        $carte_Nom = $mf_initialisation['carte_Nom'];
        $carte_Hauteur = $mf_initialisation['carte_Hauteur'];
        $carte_Largeur = $mf_initialisation['carte_Largeur'];
        $carte_Fichier = $mf_initialisation['carte_Fichier'];
        return $this->mf_ajouter($carte_Nom, $carte_Hauteur, $carte_Largeur, $carte_Fichier, $Code_groupe, $force);
    }

    public function mf_ajouter_2($ligne, $force=false) // array('colonne1' => 'valeur1',  [...] )
    {
        global $mf_initialisation;
        $Code_groupe = (isset($ligne['Code_groupe'])?round($ligne['Code_groupe']):0);
        $carte_Nom = (isset($ligne['carte_Nom'])?$ligne['carte_Nom']:$mf_initialisation['carte_Nom']);
        $carte_Hauteur = (isset($ligne['carte_Hauteur'])?$ligne['carte_Hauteur']:$mf_initialisation['carte_Hauteur']);
        $carte_Largeur = (isset($ligne['carte_Largeur'])?$ligne['carte_Largeur']:$mf_initialisation['carte_Largeur']);
        $carte_Fichier = (isset($ligne['carte_Fichier'])?$ligne['carte_Fichier']:$mf_initialisation['carte_Fichier']);
        return $this->mf_ajouter($carte_Nom, $carte_Hauteur, $carte_Largeur, $carte_Fichier, $Code_groupe, $force);
    }

    public function mf_ajouter_3($lignes) // array( array( 'colonne1' => 'valeur1', 'colonne2' => 'valeur2',  [...] ), [...] )
    {
        global $mf_initialisation;
        $code_erreur = 0;
        $values = '';
        foreach ($lignes as $ligne)
        {
            $Code_groupe = (isset($ligne['Code_groupe'])?round($ligne['Code_groupe']):0);
            $carte_Nom = text_sql(isset($ligne['carte_Nom'])?$ligne['carte_Nom']:$mf_initialisation['carte_Nom']);
            $carte_Hauteur = round(isset($ligne['carte_Hauteur'])?$ligne['carte_Hauteur']:$mf_initialisation['carte_Hauteur']);
            $carte_Largeur = round(isset($ligne['carte_Largeur'])?$ligne['carte_Largeur']:$mf_initialisation['carte_Largeur']);
            $carte_Fichier = text_sql(isset($ligne['carte_Fichier'])?$ligne['carte_Fichier']:$mf_initialisation['carte_Fichier']);
            if ($Code_groupe != 0)
            {
                $values.=($values!="" ? "," : "")."('$carte_Nom', $carte_Hauteur, $carte_Largeur, '$carte_Fichier', $Code_groupe)";
            }
        }
        if ($values!='')
        {
            $requete = "INSERT INTO ".inst('carte')." ( carte_Nom, carte_Hauteur, carte_Largeur, carte_Fichier, Code_groupe ) VALUES $values;";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            $n = requete_mysqli_affected_rows();
            if ($n < count($lignes))
            {
                $code_erreur = ERR_CARTE__AJOUTER_3__ECHEC_AJOUT;
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

    public function mf_modifier($Code_carte, $carte_Nom, $carte_Hauteur, $carte_Largeur, $carte_Fichier, $Code_groupe=0, $force=false)
    {
        $code_erreur = 0;
        $Code_carte = round($Code_carte);
        $Code_groupe = round($Code_groupe);
        $carte_Hauteur = round($carte_Hauteur);
        $carte_Largeur = round($carte_Largeur);
        Hook_carte::pre_controller($carte_Nom, $carte_Hauteur, $carte_Largeur, $carte_Fichier, $Code_groupe, $Code_carte);
        if (!$force)
        {
            if (!self::$maj_droits_modifier_en_cours)
            {
                self::$maj_droits_modifier_en_cours = true;
                Hook_carte::hook_actualiser_les_droits_modifier($Code_carte);
                self::$maj_droits_modifier_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['carte__MODIFIER']) ) $code_erreur = REFUS_CARTE__MODIFIER;
        elseif ( !$this->mf_tester_existance_Code_carte($Code_carte) ) $code_erreur = ERR_CARTE__MODIFIER__CODE_CARTE_INEXISTANT;
        elseif ( $Code_groupe!=0 && !$this->mf_tester_existance_Code_groupe($Code_groupe) ) $code_erreur = ERR_CARTE__MODIFIER__CODE_GROUPE_INEXISTANT;
        elseif ( CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_carte', $Code_carte) ) $code_erreur = ACCES_CODE_CARTE_REFUSE;
        elseif ( $Code_groupe!=0 && CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_groupe', $Code_groupe) ) $code_erreur = ACCES_CODE_GROUPE_REFUSE;
        elseif ( !Hook_carte::autorisation_modification($Code_carte, $carte_Nom, $carte_Hauteur, $carte_Largeur, $carte_Fichier, $Code_groupe) ) $code_erreur = REFUS_CARTE__MODIFICATION_BLOQUEE;
        else
        {
            Hook_carte::data_controller($carte_Nom, $carte_Hauteur, $carte_Largeur, $carte_Fichier, $Code_groupe, $Code_carte);
            $carte = $this->mf_get_2( $Code_carte, array('autocompletion' => false, 'masquer_mdp' => false) );
            $mf_colonnes_a_modifier=[];
            $bool__carte_Nom = false; if ( $carte_Nom!=$carte['carte_Nom'] ) { Hook_carte::data_controller__carte_Nom($carte['carte_Nom'], $carte_Nom, $Code_carte); if ( $carte_Nom!=$carte['carte_Nom'] ) { $mf_colonnes_a_modifier[] = 'carte_Nom=' . format_sql('carte_Nom', $carte_Nom); $bool__carte_Nom = true; } }
            $bool__carte_Hauteur = false; if ( $carte_Hauteur!=$carte['carte_Hauteur'] ) { Hook_carte::data_controller__carte_Hauteur($carte['carte_Hauteur'], $carte_Hauteur, $Code_carte); if ( $carte_Hauteur!=$carte['carte_Hauteur'] ) { $mf_colonnes_a_modifier[] = 'carte_Hauteur=' . format_sql('carte_Hauteur', $carte_Hauteur); $bool__carte_Hauteur = true; } }
            $bool__carte_Largeur = false; if ( $carte_Largeur!=$carte['carte_Largeur'] ) { Hook_carte::data_controller__carte_Largeur($carte['carte_Largeur'], $carte_Largeur, $Code_carte); if ( $carte_Largeur!=$carte['carte_Largeur'] ) { $mf_colonnes_a_modifier[] = 'carte_Largeur=' . format_sql('carte_Largeur', $carte_Largeur); $bool__carte_Largeur = true; } }
            $bool__carte_Fichier = false; if ( $carte_Fichier!=$carte['carte_Fichier'] ) { Hook_carte::data_controller__carte_Fichier($carte['carte_Fichier'], $carte_Fichier, $Code_carte); if ( $carte_Fichier!=$carte['carte_Fichier'] ) { $mf_colonnes_a_modifier[] = 'carte_Fichier=' . format_sql('carte_Fichier', $carte_Fichier); $bool__carte_Fichier = true; } }
            $bool__Code_groupe = false; if ( $Code_groupe!=0 && $Code_groupe!=$carte['Code_groupe'] ) { Hook_carte::data_controller__Code_groupe($carte['Code_groupe'], $Code_groupe, $Code_carte); if ( $Code_groupe!=0 && $Code_groupe!=$carte['Code_groupe'] ) { $mf_colonnes_a_modifier[] = 'Code_groupe=' . $Code_groupe; $bool__Code_groupe = true; } }
            if (count($mf_colonnes_a_modifier)>0) {
                $mf_signature = text_sql(Hook_carte::calcul_signature($carte_Nom, $carte_Hauteur, $carte_Largeur, $carte_Fichier, $Code_groupe));
                $mf_cle_unique = text_sql(Hook_carte::calcul_cle_unique($carte_Nom, $carte_Hauteur, $carte_Largeur, $carte_Fichier, $Code_groupe));
                $mf_colonnes_a_modifier[] = 'mf_signature=\'' . $mf_signature . '\'';
                $mf_colonnes_a_modifier[] = 'mf_cle_unique=\'' . $mf_cle_unique . '\'';
                $mf_colonnes_a_modifier[] = 'mf_date_modification=\'' . get_now() . '\'';
                $requete = 'UPDATE '.inst('carte').' SET ' . enumeration($mf_colonnes_a_modifier) . ' WHERE Code_carte = ' . $Code_carte . ';';
                $cle = md5($requete).salt(10);
                self::$cache_db->pause($cle);
                executer_requete_mysql( $requete , true);
                if ( requete_mysqli_affected_rows()==0 )
                {
                    $code_erreur = ERR_CARTE__MODIFIER__AUCUN_CHANGEMENT;
                    self::$cache_db->reprendre($cle);
                }
                else
                {
                    self::$cache_db->clear();
                    self::$cache_db->reprendre($cle);
                    Hook_carte::modifier($Code_carte, $bool__carte_Nom, $bool__carte_Hauteur, $bool__carte_Largeur, $bool__carte_Fichier, $bool__Code_groupe);
                }
            }
            else
            {
                $code_erreur = ERR_CARTE__MODIFIER__AUCUN_CHANGEMENT;
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
        return array('code_erreur' => $code_erreur, 'callback' => ( $code_erreur == 0 ? Hook_carte::callback_put($Code_carte) : null ));
    }

    public function mf_modifier_2($lignes, $force=false) // array( $Code_carte => array('colonne1' => 'valeur1',  [...] ) )
    {
        $code_erreur = 0;
        foreach ( $lignes as $Code_carte => $colonnes )
        {
            if ( $code_erreur==0 )
            {
                $Code_carte = round($Code_carte);
                $carte = $this->mf_get_2($Code_carte, array('autocompletion' => false));
                if (!$force)
                {
                    if (!self::$maj_droits_modifier_en_cours)
                    {
                        self::$maj_droits_modifier_en_cours = true;
                        Hook_carte::hook_actualiser_les_droits_modifier($Code_carte);
                        self::$maj_droits_modifier_en_cours = false;
                    }
                }
                $Code_groupe = ( isset($colonnes['Code_groupe']) && ( $force || mf_matrice_droits(['api_modifier_ref__carte__Code_groupe', 'carte__MODIFIER']) ) ? $colonnes['Code_groupe'] : (isset($carte['Code_groupe']) ? $carte['Code_groupe'] : 0 ));
                $carte_Nom = ( isset($colonnes['carte_Nom']) && ( $force || mf_matrice_droits(['api_modifier__carte_Nom', 'carte__MODIFIER']) ) ? $colonnes['carte_Nom'] : ( isset($carte['carte_Nom']) ? $carte['carte_Nom'] : '' ) );
                $carte_Hauteur = ( isset($colonnes['carte_Hauteur']) && ( $force || mf_matrice_droits(['api_modifier__carte_Hauteur', 'carte__MODIFIER']) ) ? $colonnes['carte_Hauteur'] : ( isset($carte['carte_Hauteur']) ? $carte['carte_Hauteur'] : '' ) );
                $carte_Largeur = ( isset($colonnes['carte_Largeur']) && ( $force || mf_matrice_droits(['api_modifier__carte_Largeur', 'carte__MODIFIER']) ) ? $colonnes['carte_Largeur'] : ( isset($carte['carte_Largeur']) ? $carte['carte_Largeur'] : '' ) );
                $carte_Fichier = ( isset($colonnes['carte_Fichier']) && ( $force || mf_matrice_droits(['api_modifier__carte_Fichier', 'carte__MODIFIER']) ) ? $colonnes['carte_Fichier'] : ( isset($carte['carte_Fichier']) ? $carte['carte_Fichier'] : '' ) );
                $retour = $this->mf_modifier($Code_carte, $carte_Nom, $carte_Hauteur, $carte_Largeur, $carte_Fichier, $Code_groupe, true);
                if ( $retour['code_erreur']!=0 && $retour['code_erreur'] != ERR_CARTE__MODIFIER__AUCUN_CHANGEMENT )
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

    public function mf_modifier_3($lignes) // array( $Code_carte => array('colonne1' => 'valeur1',  [...] ) )
    {
        $code_erreur = 0;
        $modifs = false;

        // transformation des lignes en colonnes
        $valeurs_en_colonnes=array();
        $indices_par_colonne=array();
        $liste_valeurs_indexees=array();
        foreach ( $lignes as $Code_carte => $colonnes )
        {
            foreach ($colonnes as $colonne => $valeur)
            {
                if ( $colonne=='carte_Nom' || $colonne=='carte_Hauteur' || $colonne=='carte_Largeur' || $colonne=='carte_Fichier' || $colonne=='Code_groupe' )
                {
                    $valeurs_en_colonnes[$colonne][$Code_carte]=$valeur;
                    $indices_par_colonne[$colonne][]=$Code_carte;
                    $liste_valeurs_indexees[$colonne][''.$valeur][]=$Code_carte;
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
                $modification_sql = $colonne . ' = CASE Code_carte';
                foreach ( $valeurs as $Code_carte => $valeur )
                {
                    $modification_sql.=' WHEN ' . $Code_carte . ' THEN ' . format_sql($colonne, $valeur);
                }
                $modification_sql.=' END';
                $perimetre = Sql_Format_Liste($indices_par_colonne[$colonne]);
                executer_requete_mysql('UPDATE ' . inst('carte') . ' SET ' . $modification_sql . ' WHERE Code_carte IN ' . $perimetre . ';', true);
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
                    executer_requete_mysql('UPDATE ' . inst('carte') . ' SET ' . $colonne . ' = ' . format_sql($colonne, $valeur) . ' WHERE Code_carte IN ' . $perimetre . ';', true);
                    if ( requete_mysqli_affected_rows()!=0 )
                    {
                        $modifs = true;
                    }
                }
            }
        }

        if ( ! $modifs && $code_erreur==0 )
        {
            $code_erreur = ERR_CARTE__MODIFIER_3__AUCUN_CHANGEMENT;
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

    public function mf_modifier_4( $Code_groupe, $data, $options = array( 'cond_mysql' => array() ) ) // $data = array('colonne1' => 'valeur1', ... )
    {
        $code_erreur = 0;
        $Code_groupe = round($Code_groupe);
        $mf_colonnes_a_modifier=[];
        if ( isset($data['carte_Nom']) ) { $mf_colonnes_a_modifier[] = 'carte_Nom = ' . format_sql('carte_Nom', $data['carte_Nom']); }
        if ( isset($data['carte_Hauteur']) ) { $mf_colonnes_a_modifier[] = 'carte_Hauteur = ' . format_sql('carte_Hauteur', $data['carte_Hauteur']); }
        if ( isset($data['carte_Largeur']) ) { $mf_colonnes_a_modifier[] = 'carte_Largeur = ' . format_sql('carte_Largeur', $data['carte_Largeur']); }
        if ( isset($data['carte_Fichier']) ) { $mf_colonnes_a_modifier[] = 'carte_Fichier = ' . format_sql('carte_Fichier', $data['carte_Fichier']); }
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

            $requete = 'UPDATE ' . inst('carte') . ' SET ' . enumeration($mf_colonnes_a_modifier) . " WHERE 1".( $Code_groupe!=0 ? " AND Code_groupe=$Code_groupe" : "" )."$argument_cond;";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_CARTE__MODIFIER_4__AUCUN_CHANGEMENT;
            }
            else
            {
                self::$cache_db->clear();
            }
            self::$cache_db->reprendre($cle);
        }
        return array('code_erreur' => $code_erreur);
    }

    public function mf_supprimer($Code_carte, $force=false)
    {
        $code_erreur = 0;
        $Code_carte = round($Code_carte);
        if (!$force)
        {
            if (!self::$maj_droits_supprimer_en_cours)
            {
                self::$maj_droits_supprimer_en_cours = true;
                Hook_carte::hook_actualiser_les_droits_supprimer($Code_carte);
                self::$maj_droits_supprimer_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['carte__SUPPRIMER']) ) $code_erreur = REFUS_CARTE__SUPPRIMER;
        elseif ( !$this->mf_tester_existance_Code_carte($Code_carte) ) $code_erreur = ERR_CARTE__SUPPRIMER_2__CODE_CARTE_INEXISTANT;
        elseif ( CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_carte', $Code_carte) ) $code_erreur = ACCES_CODE_CARTE_REFUSE;
        elseif ( !Hook_carte::autorisation_suppression($Code_carte) ) $code_erreur = REFUS_CARTE__SUPPRESSION_BLOQUEE;
        else
        {
            $copie__carte = $this->mf_get($Code_carte, array('autocompletion' => false));
            $this->supprimer_donnes_en_cascade("carte", array($Code_carte));
            $requete = "DELETE IGNORE FROM ".inst('carte')." WHERE Code_carte=$Code_carte;";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_CARTE__SUPPRIMER__REFUSEE;
                self::$cache_db->reprendre($cle);
            }
            else
            {
                self::$cache_db->clear();
                self::$cache_db->reprendre($cle);
                Hook_carte::supprimer($copie__carte);
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

    public function mf_supprimer_2($liste_Code_carte, $force=false)
    {
        $code_erreur=0;
        $copie__liste_carte = $this->mf_lister_2($liste_Code_carte, array('autocompletion' => false));
        $liste_Code_carte=array();
        foreach ( $copie__liste_carte as $copie__carte )
        {
            $Code_carte = $copie__carte['Code_carte'];
            if (!$force)
            {
                if (!self::$maj_droits_supprimer_en_cours)
                {
                    self::$maj_droits_supprimer_en_cours = true;
                    Hook_carte::hook_actualiser_les_droits_supprimer($Code_carte);
                    self::$maj_droits_supprimer_en_cours = false;
                }
            }
            if ( !$force && !mf_matrice_droits(['carte__SUPPRIMER']) ) $code_erreur = REFUS_CARTE__SUPPRIMER;
            elseif ( !Hook_carte::autorisation_suppression($Code_carte) ) $code_erreur = REFUS_CARTE__SUPPRESSION_BLOQUEE;
            {
                $liste_Code_carte[] = $Code_carte;
            }
        }
        if ( $code_erreur==0 && count($liste_Code_carte)>0 )
        {
            $this->supprimer_donnes_en_cascade("carte", $liste_Code_carte);
            $requete = "DELETE IGNORE FROM ".inst('carte')." WHERE Code_carte IN ".Sql_Format_Liste($liste_Code_carte).";";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_CARTE__SUPPRIMER_2__REFUSEE;
                self::$cache_db->reprendre($cle);
            }
            else
            {
                self::$cache_db->clear();
                self::$cache_db->reprendre($cle);
                Hook_carte::supprimer_2($copie__liste_carte);
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

    public function mf_supprimer_3($liste_Code_carte)
    {
        $code_erreur=0;
        if ( count($liste_Code_carte)>0 )
        {
            $this->supprimer_donnes_en_cascade("carte", $liste_Code_carte);
            $requete = "DELETE IGNORE FROM ".inst('carte')." WHERE Code_carte IN ".Sql_Format_Liste($liste_Code_carte).";";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_CARTE__SUPPRIMER_3__REFUSEE;
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
        if ( ! $contexte_parent && $mf_contexte['Code_carte']!=0 )
        {
            $carte = $this->mf_get( $mf_contexte['Code_carte'], $options);
            return array( $carte['Code_carte'] => $carte );
        }
        else
        {
            return $this->mf_lister(isset($est_charge['groupe']) ? $mf_contexte['Code_groupe'] : 0, $options);
        }
    }

    public function mf_lister($Code_groupe=0, $options = array( 'cond_mysql' => array(), 'tris' => array(), 'limit' => array(), 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ))
    {
        $cle = "carte__lister";
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
            if ( isset($mf_tri_defaut_table['carte']) )
            {
                $options['tris'] = $mf_tri_defaut_table['carte'];
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
                    if ( strpos($argument_cond, 'carte_Nom')!==false ) { $liste_colonnes_a_indexer['carte_Nom'] = 'carte_Nom'; }
                    if ( strpos($argument_cond, 'carte_Hauteur')!==false ) { $liste_colonnes_a_indexer['carte_Hauteur'] = 'carte_Hauteur'; }
                    if ( strpos($argument_cond, 'carte_Largeur')!==false ) { $liste_colonnes_a_indexer['carte_Largeur'] = 'carte_Largeur'; }
                    if ( strpos($argument_cond, 'carte_Fichier')!==false ) { $liste_colonnes_a_indexer['carte_Fichier'] = 'carte_Fichier'; }
                }
                if ( isset($options['tris']) )
                {
                    if ( isset($options['tris']['carte_Nom']) ) { $liste_colonnes_a_indexer['carte_Nom'] = 'carte_Nom'; }
                    if ( isset($options['tris']['carte_Hauteur']) ) { $liste_colonnes_a_indexer['carte_Hauteur'] = 'carte_Hauteur'; }
                    if ( isset($options['tris']['carte_Largeur']) ) { $liste_colonnes_a_indexer['carte_Largeur'] = 'carte_Largeur'; }
                    if ( isset($options['tris']['carte_Fichier']) ) { $liste_colonnes_a_indexer['carte_Fichier'] = 'carte_Fichier'; }
                }
                if ( count($liste_colonnes_a_indexer)>0 )
                {
                    if ( ! $mf_liste_requete_index = self::$cache_db->read('carte__index') )
                    {
                        $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('carte').'`;', false);
                        $mf_liste_requete_index = array();
                        while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                        {
                            $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                        }
                        mysqli_free_result($res_requete_index);
                        self::$cache_db->write('carte__index', $mf_liste_requete_index);
                    }
                    foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                    {
                        if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                    }
                    if ( count($liste_colonnes_a_indexer) > 0 )
                    {
                        self::$cache_db->pause('carte__index');
                        foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                        {
                            executer_requete_mysql('ALTER TABLE `'.inst('carte').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                        }
                        self::$cache_db->clear();
                        self::$cache_db->reprendre('carte__index');
                    }
                }

                $liste = array();
                $liste_carte_pas_a_jour = array();
                if ($toutes_colonnes)
                {
                    $colonnes='Code_carte, carte_Nom, carte_Hauteur, carte_Largeur, carte_Fichier, Code_groupe';
                }
                else
                {
                    $colonnes='Code_carte, carte_Nom, carte_Hauteur, carte_Largeur, carte_Fichier, Code_groupe';
                }
                $res_requete = executer_requete_mysql("SELECT $colonnes FROM ".inst('carte')." WHERE 1{$argument_cond}".( $Code_groupe!=0 ? " AND Code_groupe=$Code_groupe" : "" )."{$argument_tris}{$argument_limit};", false);
                while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
                {
                    $liste[$row_requete['Code_carte']]=$row_requete;
                    if ( $maj && ! Hook_carte::est_a_jour( $row_requete ) )
                    {
                        $liste_carte_pas_a_jour[$row_requete['Code_carte']] = $row_requete;
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
                Hook_carte::mettre_a_jour( $liste_carte_pas_a_jour );
            }
        }

        foreach ($liste as $elem)
        {
            if ( $controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_carte', $elem['Code_carte']) )
            {
                unset($liste[$elem['Code_carte']]);
            }
            else
            {
                if (!self::$auto_completion && $autocompletion)
                {
                    self::$auto_completion = true;
                    Hook_carte::completion($liste[$elem['Code_carte']]);
                    self::$auto_completion = false;
                }
            }
        }

        return $liste;
    }

    public function mf_lister_2($liste_Code_carte, $options = array( 'cond_mysql' => array(), 'tris' => array(), 'limit' => array(), 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ))
    {
        if ( count($liste_Code_carte)>0 )
        {
            $cle = "carte__mf_lister_2_".Sql_Format_Liste($liste_Code_carte);

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
                if ( isset($mf_tri_defaut_table['carte']) )
                {
                    $options['tris'] = $mf_tri_defaut_table['carte'];
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
                        if ( strpos($argument_cond, 'carte_Nom')!==false ) { $liste_colonnes_a_indexer['carte_Nom'] = 'carte_Nom'; }
                        if ( strpos($argument_cond, 'carte_Hauteur')!==false ) { $liste_colonnes_a_indexer['carte_Hauteur'] = 'carte_Hauteur'; }
                        if ( strpos($argument_cond, 'carte_Largeur')!==false ) { $liste_colonnes_a_indexer['carte_Largeur'] = 'carte_Largeur'; }
                        if ( strpos($argument_cond, 'carte_Fichier')!==false ) { $liste_colonnes_a_indexer['carte_Fichier'] = 'carte_Fichier'; }
                    }
                    if ( isset($options['tris']) )
                    {
                        if ( isset($options['tris']['carte_Nom']) ) { $liste_colonnes_a_indexer['carte_Nom'] = 'carte_Nom'; }
                        if ( isset($options['tris']['carte_Hauteur']) ) { $liste_colonnes_a_indexer['carte_Hauteur'] = 'carte_Hauteur'; }
                        if ( isset($options['tris']['carte_Largeur']) ) { $liste_colonnes_a_indexer['carte_Largeur'] = 'carte_Largeur'; }
                        if ( isset($options['tris']['carte_Fichier']) ) { $liste_colonnes_a_indexer['carte_Fichier'] = 'carte_Fichier'; }
                    }
                    if ( count($liste_colonnes_a_indexer)>0 )
                    {
                        if ( ! $mf_liste_requete_index = self::$cache_db->read('carte__index') )
                        {
                            $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('carte').'`;', false);
                            $mf_liste_requete_index = array();
                            while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                            {
                                $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                            }
                            mysqli_free_result($res_requete_index);
                            self::$cache_db->write('carte__index', $mf_liste_requete_index);
                        }
                        foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                        {
                            if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                        }
                        if ( count($liste_colonnes_a_indexer) > 0 )
                        {
                            self::$cache_db->pause('carte__index');
                            foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                            {
                                executer_requete_mysql('ALTER TABLE `'.inst('carte').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                            }
                            self::$cache_db->clear();
                            self::$cache_db->reprendre('carte__index');
                        }
                    }

                    $liste = array();
                    $liste_carte_pas_a_jour = array();
                    if ($toutes_colonnes)
                    {
                        $colonnes='Code_carte, carte_Nom, carte_Hauteur, carte_Largeur, carte_Fichier, Code_groupe';
                    }
                    else
                    {
                        $colonnes='Code_carte, carte_Nom, carte_Hauteur, carte_Largeur, carte_Fichier, Code_groupe';
                    }
                    $res_requete = executer_requete_mysql("SELECT $colonnes FROM ".inst('carte')." WHERE 1{$argument_cond} AND Code_carte IN ".Sql_Format_Liste($liste_Code_carte)."{$argument_tris}{$argument_limit};", false);
                    while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
                    {
                        $liste[$row_requete['Code_carte']]=$row_requete;
                        if ( $maj && ! Hook_carte::est_a_jour( $row_requete ) )
                        {
                            $liste_carte_pas_a_jour[$row_requete['Code_carte']] = $row_requete;
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
                    Hook_carte::mettre_a_jour( $liste_carte_pas_a_jour );
                }
            }

            foreach ($liste as $elem)
            {
                if ( $controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_carte', $elem['Code_carte']) )
                {
                    unset($liste[$elem['Code_carte']]);
                }
                else
                {
                    if (!self::$auto_completion && $autocompletion)
                    {
                        self::$auto_completion = true;
                        Hook_carte::completion($liste[$elem['Code_carte']]);
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

    public function mf_get($Code_carte, $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ])
    {
        $Code_carte = round($Code_carte);
        $retour = array();
        if ( ! CONTROLE_ACCES_DONNEES_DEFAUT || Hook_mf_systeme::controle_acces_donnees('Code_carte', $Code_carte) )
        {
            $cle = 'carte__get_'.$Code_carte;

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
                        $colonnes='Code_carte, carte_Nom, carte_Hauteur, carte_Largeur, carte_Fichier, Code_groupe';
                    }
                    else
                    {
                        $colonnes='Code_carte, carte_Nom, carte_Hauteur, carte_Largeur, carte_Fichier, Code_groupe';
                    }
                    $res_requete = executer_requete_mysql('SELECT ' . $colonnes . ' FROM ' . inst('carte') . ' WHERE Code_carte = ' . $Code_carte . ';', false);
                    if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
                    {
                        $retour=$row_requete;
                        if ( $maj && ! Hook_carte::est_a_jour( $row_requete ) )
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
                    Hook_carte::mettre_a_jour( array( $row_requete['Code_carte'] => $row_requete ) );
                }
            }
            if ( isset( $retour['Code_carte'] ) )
            {
                if (!self::$auto_completion && $autocompletion)
                {
                    self::$auto_completion = true;
                    Hook_carte::completion($retour);
                    self::$auto_completion = false;
                }
            }
        }
        return $retour;
    }

    public function mf_get_last($Code_groupe=0, $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ])
    {
        $cle = "carte__get_last";
        $Code_groupe = round($Code_groupe);
        $cle.='_' . $Code_groupe;
        if ( ! $retour = self::$cache_db->read($cle) )
        {
            $Code_carte = 0;
            $res_requete = executer_requete_mysql('SELECT Code_carte FROM ' . inst('carte') . " WHERE 1".( $Code_groupe!=0 ? " AND Code_groupe=$Code_groupe" : "" )." ORDER BY mf_date_creation DESC, Code_carte DESC LIMIT 0 , 1;", false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $Code_carte = $row_requete['Code_carte'];
            }
            mysqli_free_result($res_requete);
            $retour = $this->mf_get($Code_carte, $options);
            self::$cache_db->write($cle, $retour);
        }
        return $retour;
    }

    public function mf_get_2($Code_carte, $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ])
    {
        $Code_carte = round($Code_carte);
        $retour = array();
        $cle = 'carte__get_'.$Code_carte;

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
                $colonnes='Code_carte, carte_Nom, carte_Hauteur, carte_Largeur, carte_Fichier, Code_groupe';
            }
            else
            {
                $colonnes='Code_carte, carte_Nom, carte_Hauteur, carte_Largeur, carte_Fichier, Code_groupe';
            }
            $res_requete = executer_requete_mysql('SELECT ' . $colonnes . " FROM ".inst('carte')." WHERE Code_carte = $Code_carte;", false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $retour=$row_requete;
            }
            mysqli_free_result($res_requete);
            self::$cache_db->write($cle, $retour);
        }
        if ( isset( $retour['Code_carte'] ) )
        {
            if (!self::$auto_completion && $autocompletion)
            {
                self::$auto_completion = true;
                Hook_carte::completion($retour);
                self::$auto_completion = false;
            }
        }
        return $retour;
    }

    public function mf_prec_et_suiv($Code_carte, $Code_groupe=0, $options = array( 'cond_mysql' => array(), 'tris' => array(), 'limit' => array(), 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ))
    {
        $Code_carte = round($Code_carte);
        $liste = $this->mf_lister($Code_groupe, $options);
        return prec_suiv($liste, $Code_carte);
    }

    public function mf_compter($Code_groupe=0, $options = array( 'cond_mysql' => array() ))
    {
        $cle = 'carte__compter';
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
                if ( strpos($argument_cond, 'carte_Nom')!==false ) { $liste_colonnes_a_indexer['carte_Nom'] = 'carte_Nom'; }
                if ( strpos($argument_cond, 'carte_Hauteur')!==false ) { $liste_colonnes_a_indexer['carte_Hauteur'] = 'carte_Hauteur'; }
                if ( strpos($argument_cond, 'carte_Largeur')!==false ) { $liste_colonnes_a_indexer['carte_Largeur'] = 'carte_Largeur'; }
                if ( strpos($argument_cond, 'carte_Fichier')!==false ) { $liste_colonnes_a_indexer['carte_Fichier'] = 'carte_Fichier'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = self::$cache_db->read('carte__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('carte').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    self::$cache_db->write('carte__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    self::$cache_db->pause('carte__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('carte').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    self::$cache_db->clear();
                    self::$cache_db->reprendre('carte__index');
                }
            }

            $res_requete = executer_requete_mysql("SELECT count(Code_carte) as nb FROM ".inst('carte')." WHERE 1{$argument_cond}".( $Code_groupe!=0 ? " AND Code_groupe=$Code_groupe" : "" ).";", false);
            $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC);
            mysqli_free_result($res_requete);
            $nb = round($row_requete['nb']);
            self::$cache_db->write($cle, $nb);
        }
        return $nb;
    }

    public function mfi_compter( $interface, $options = array( 'cond_mysql' => array() ) )
    {
        $Code_groupe = isset($interface['Code_groupe']) ? round($interface['Code_groupe']) : 0;
        return $this->mf_compter( $Code_groupe, $options );
    }

    public function mf_liste_Code_carte($Code_groupe=0, $options = array( 'cond_mysql' => array() ))
    {
        return $this->get_liste_Code_carte($Code_groupe, $options);
    }

    public function mf_convertir_Code_carte_vers_Code_groupe( $Code_carte )
    {
        return $this->Code_carte_vers_Code_groupe( $Code_carte );
    }

    public function mf_liste_Code_groupe_vers_liste_Code_carte( $liste_Code_groupe, $options = array( 'cond_mysql' => array() ) )
    {
        return $this->liste_Code_groupe_vers_liste_Code_carte( $liste_Code_groupe, $options );
    }

    public function mf_liste_Code_carte_vers_liste_Code_groupe( $liste_Code_carte, $options = array( 'cond_mysql' => array() ) )
    {
        return $this->carte__liste_Code_carte_vers_liste_Code_groupe( $liste_Code_carte, $options );
    }

    public function mf_get_liste_tables_enfants()
    {
        return $this->get_liste_tables_enfants( 'carte' );
    }

    public function mf_get_liste_tables_parents()
    {
        return array('Code_groupe');
    }

    public function mf_search_carte_Nom( $carte_Nom, $Code_groupe=0 )
    {
        return $this->rechercher_carte_Nom( $carte_Nom, $Code_groupe );
    }

    public function mf_search_carte_Hauteur( $carte_Hauteur, $Code_groupe=0 )
    {
        return $this->rechercher_carte_Hauteur( $carte_Hauteur, $Code_groupe );
    }

    public function mf_search_carte_Largeur( $carte_Largeur, $Code_groupe=0 )
    {
        return $this->rechercher_carte_Largeur( $carte_Largeur, $Code_groupe );
    }

    public function mf_search_carte_Fichier( $carte_Fichier, $Code_groupe=0 )
    {
        return $this->rechercher_carte_Fichier( $carte_Fichier, $Code_groupe );
    }

    public function mf_search__colonne( $colonne_db, $recherche, $Code_groupe=0 )
    {
        switch ($colonne_db) {
            case 'carte_Nom': return $this->mf_search_carte_Nom( $recherche, $Code_groupe ); break;
            case 'carte_Hauteur': return $this->mf_search_carte_Hauteur( $recherche, $Code_groupe ); break;
            case 'carte_Largeur': return $this->mf_search_carte_Largeur( $recherche, $Code_groupe ); break;
            case 'carte_Fichier': return $this->mf_search_carte_Fichier( $recherche, $Code_groupe ); break;
        }
    }

    public function mf_get_next_id()
    {
        $res_requete = executer_requete_mysql('SELECT AUTO_INCREMENT as next_id FROM INFORMATION_SCHEMA.TABLES WHERE table_name = \'carte\';', false);
        $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC);
        mysqli_free_result($res_requete);
        return round($row_requete['next_id']);
    }

    public function mf_search($ligne) // array('colonne1' => 'valeur1',  [...] )
    {
        global $mf_initialisation;
        $Code_groupe = (isset($ligne['Code_groupe'])?round($ligne['Code_groupe']):0);
        $carte_Nom = (isset($ligne['carte_Nom'])?$ligne['carte_Nom']:$mf_initialisation['carte_Nom']);
        $carte_Hauteur = (isset($ligne['carte_Hauteur'])?$ligne['carte_Hauteur']:$mf_initialisation['carte_Hauteur']);
        $carte_Largeur = (isset($ligne['carte_Largeur'])?$ligne['carte_Largeur']:$mf_initialisation['carte_Largeur']);
        $carte_Fichier = (isset($ligne['carte_Fichier'])?$ligne['carte_Fichier']:$mf_initialisation['carte_Fichier']);
        $carte_Hauteur = round($carte_Hauteur);
        $carte_Largeur = round($carte_Largeur);
        Hook_carte::pre_controller($carte_Nom, $carte_Hauteur, $carte_Largeur, $carte_Fichier, $Code_groupe);
        $mf_cle_unique = Hook_carte::calcul_cle_unique($carte_Nom, $carte_Hauteur, $carte_Largeur, $carte_Fichier, $Code_groupe);
        $res_requete = executer_requete_mysql('SELECT Code_carte FROM ' . inst('carte') . ' WHERE mf_cle_unique = \''.$mf_cle_unique.'\'', false);
        if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
        {
            $r = round($row_requete['Code_carte']);
        }
        else
        {
            $r = false;
        }
        mysqli_free_result($res_requete);
        return $r;
    }

}
