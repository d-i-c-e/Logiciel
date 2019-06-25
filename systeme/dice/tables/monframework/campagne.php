<?php

/*
    +------------------------------+
    |  NE PAS MODIFIER CE FICHIER  |
    +------------------------------+
*/

class campagne_monframework extends entite_monframework
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
            include_once __DIR__ . '/../../erreurs/erreurs__campagne.php';
            self::$initialisation = false;
            Hook_campagne::initialisation();
            self::$cache_db = new Mf_Cachedb('campagne');
        }
        if (!self::$actualisation_en_cours)
        {
            self::$actualisation_en_cours=true;
            Hook_campagne::actualisation();
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

        if ( ! test_si_table_existe(inst('campagne')) )
        {
            executer_requete_mysql('CREATE TABLE '.inst('campagne').'(Code_campagne INT AUTO_INCREMENT NOT NULL, PRIMARY KEY (Code_campagne)) ENGINE=MyISAM;', true);
        }

        $liste_colonnes = lister_les_colonnes(inst('campagne'));

        if ( isset($liste_colonnes['campagne_Nom']) )
        {
            if ( typeMyql2Sql($liste_colonnes['campagne_Nom']['Type'])!='VARCHAR' )
            {
                executer_requete_mysql('ALTER TABLE '.inst('campagne').' CHANGE campagne_Nom campagne_Nom VARCHAR(255);', true);
            }
            unset($liste_colonnes['campagne_Nom']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('campagne').' ADD campagne_Nom VARCHAR(255);', true);
            executer_requete_mysql('UPDATE '.inst('campagne').' SET campagne_Nom=' . format_sql('campagne_Nom', $mf_initialisation['campagne_Nom']) . ';', true);
        }

        if ( isset($liste_colonnes['campagne_Description']) )
        {
            if ( typeMyql2Sql($liste_colonnes['campagne_Description']['Type'])!='TEXT' )
            {
                executer_requete_mysql('ALTER TABLE '.inst('campagne').' CHANGE campagne_Description campagne_Description TEXT;', true);
            }
            unset($liste_colonnes['campagne_Description']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('campagne').' ADD campagne_Description TEXT;', true);
            executer_requete_mysql('UPDATE '.inst('campagne').' SET campagne_Description=' . format_sql('campagne_Description', $mf_initialisation['campagne_Description']) . ';', true);
        }

        if ( isset($liste_colonnes['campagne_Image_Fichier']) )
        {
            if ( typeMyql2Sql($liste_colonnes['campagne_Image_Fichier']['Type'])!='VARCHAR' )
            {
                executer_requete_mysql('ALTER TABLE '.inst('campagne').' CHANGE campagne_Image_Fichier campagne_Image_Fichier VARCHAR(255);', true);
            }
            unset($liste_colonnes['campagne_Image_Fichier']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('campagne').' ADD campagne_Image_Fichier VARCHAR(255);', true);
            executer_requete_mysql('UPDATE '.inst('campagne').' SET campagne_Image_Fichier=' . format_sql('campagne_Image_Fichier', $mf_initialisation['campagne_Image_Fichier']) . ';', true);
        }

        if ( isset($liste_colonnes['campagne_Nombre_joueur']) )
        {
            if ( typeMyql2Sql($liste_colonnes['campagne_Nombre_joueur']['Type'])!='INT' )
            {
                executer_requete_mysql('ALTER TABLE '.inst('campagne').' CHANGE campagne_Nombre_joueur campagne_Nombre_joueur INT;', true);
            }
            unset($liste_colonnes['campagne_Nombre_joueur']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('campagne').' ADD campagne_Nombre_joueur INT;', true);
            executer_requete_mysql('UPDATE '.inst('campagne').' SET campagne_Nombre_joueur=' . format_sql('campagne_Nombre_joueur', $mf_initialisation['campagne_Nombre_joueur']) . ';', true);
        }

        if ( isset($liste_colonnes['campagne_Nombre_mj']) )
        {
            if ( typeMyql2Sql($liste_colonnes['campagne_Nombre_mj']['Type'])!='INT' )
            {
                executer_requete_mysql('ALTER TABLE '.inst('campagne').' CHANGE campagne_Nombre_mj campagne_Nombre_mj INT;', true);
            }
            unset($liste_colonnes['campagne_Nombre_mj']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('campagne').' ADD campagne_Nombre_mj INT;', true);
            executer_requete_mysql('UPDATE '.inst('campagne').' SET campagne_Nombre_mj=' . format_sql('campagne_Nombre_mj', $mf_initialisation['campagne_Nombre_mj']) . ';', true);
        }

        if ( isset($liste_colonnes['mf_signature']) )
        {
            unset($liste_colonnes['mf_signature']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('campagne').' ADD mf_signature VARCHAR(255);', true);
            executer_requete_mysql('ALTER TABLE '.inst('campagne').' ADD INDEX( mf_signature );', true);
        }

        if ( isset($liste_colonnes['mf_cle_unique']) )
        {
            unset($liste_colonnes['mf_cle_unique']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('campagne').' ADD mf_cle_unique VARCHAR(255);', true);
            executer_requete_mysql('ALTER TABLE '.inst('campagne').' ADD INDEX( mf_cle_unique );', true);
        }

        if ( isset($liste_colonnes['mf_date_creation']) )
        {
            unset($liste_colonnes['mf_date_creation']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('campagne').' ADD mf_date_creation DATETIME;', true);
            executer_requete_mysql('ALTER TABLE '.inst('campagne').' ADD INDEX( mf_date_creation );', true);
        }

        if ( isset($liste_colonnes['mf_date_modification']) )
        {
            unset($liste_colonnes['mf_date_modification']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('campagne').' ADD mf_date_modification DATETIME;', true);
            executer_requete_mysql('ALTER TABLE '.inst('campagne').' ADD INDEX( mf_date_modification );', true);
        }

        unset($liste_colonnes['Code_campagne']);

        foreach ($liste_colonnes as $field => $value)
        {
            executer_requete_mysql('ALTER TABLE '.inst('campagne').' DROP COLUMN '.$field.';', true);
        }

    }

    public function mf_ajouter(string $campagne_Nom, string $campagne_Description, string $campagne_Image_Fichier, int $campagne_Nombre_joueur, int $campagne_Nombre_mj, ?bool $force=false)
    {
        if ( $force===null ) { $force=false; }
        $Code_campagne = 0;
        $code_erreur = 0;
        $campagne_Nombre_joueur = round($campagne_Nombre_joueur);
        $campagne_Nombre_mj = round($campagne_Nombre_mj);
        Hook_campagne::pre_controller($campagne_Nom, $campagne_Description, $campagne_Image_Fichier, $campagne_Nombre_joueur, $campagne_Nombre_mj);
        if (!$force)
        {
            if (!self::$maj_droits_ajouter_en_cours)
            {
                self::$maj_droits_ajouter_en_cours = true;
                Hook_campagne::hook_actualiser_les_droits_ajouter();
                self::$maj_droits_ajouter_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['campagne__AJOUTER']) ) $code_erreur = REFUS_CAMPAGNE__AJOUTER;
        elseif ( !Hook_campagne::autorisation_ajout($campagne_Nom, $campagne_Description, $campagne_Image_Fichier, $campagne_Nombre_joueur, $campagne_Nombre_mj) ) $code_erreur = REFUS_CAMPAGNE__AJOUT_BLOQUEE;
        else
        {
            Hook_campagne::data_controller($campagne_Nom, $campagne_Description, $campagne_Image_Fichier, $campagne_Nombre_joueur, $campagne_Nombre_mj);
            $mf_signature = text_sql(Hook_campagne::calcul_signature($campagne_Nom, $campagne_Description, $campagne_Image_Fichier, $campagne_Nombre_joueur, $campagne_Nombre_mj));
            $mf_cle_unique = text_sql(Hook_campagne::calcul_cle_unique($campagne_Nom, $campagne_Description, $campagne_Image_Fichier, $campagne_Nombre_joueur, $campagne_Nombre_mj));
            $campagne_Nom = text_sql($campagne_Nom);
            $campagne_Description = text_sql($campagne_Description);
            $campagne_Image_Fichier = text_sql($campagne_Image_Fichier);
            $campagne_Nombre_joueur = round($campagne_Nombre_joueur);
            $campagne_Nombre_mj = round($campagne_Nombre_mj);
            $requete = "INSERT INTO ".inst('campagne')." ( mf_signature, mf_cle_unique, mf_date_creation, mf_date_modification, campagne_Nom, campagne_Description, campagne_Image_Fichier, campagne_Nombre_joueur, campagne_Nombre_mj ) VALUES ( '$mf_signature', '$mf_cle_unique', '".get_now()."', '".get_now()."', '$campagne_Nom', '$campagne_Description', '$campagne_Image_Fichier', $campagne_Nombre_joueur, $campagne_Nombre_mj );";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql($requete, true);
            $Code_campagne = requete_mysql_insert_id();
            if ($Code_campagne==0)
            {
                $code_erreur = ERR_CAMPAGNE__AJOUTER__AJOUT_REFUSE;
                self::$cache_db->reprendre($cle);
            }
            else
            {
                self::$cache_db->clear();
                self::$cache_db->reprendre($cle);
                Hook_campagne::ajouter( $Code_campagne );
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
        return array('code_erreur' => $code_erreur, 'Code_campagne' => $Code_campagne, 'callback' => ( $code_erreur==0 ? Hook_campagne::callback_post($Code_campagne) : null ));
    }

    public function mf_creer(?bool $force=null)
    {
        if ( $force===null ) { $force=false; }
        global $mf_initialisation, $mf_droits_defaut;
        $mf_droits_defaut["campagne__AJOUTER"] = $mf_droits_defaut["campagne__CREER"];
        $campagne_Nom = $mf_initialisation['campagne_Nom'];
        $campagne_Description = $mf_initialisation['campagne_Description'];
        $campagne_Image_Fichier = $mf_initialisation['campagne_Image_Fichier'];
        $campagne_Nombre_joueur = $mf_initialisation['campagne_Nombre_joueur'];
        $campagne_Nombre_mj = $mf_initialisation['campagne_Nombre_mj'];
        return $this->mf_ajouter($campagne_Nom, $campagne_Description, $campagne_Image_Fichier, $campagne_Nombre_joueur, $campagne_Nombre_mj, $force);
    }

    public function mf_ajouter_2(array $ligne, bool $force=null) // array('colonne1' => 'valeur1',  [...] )
    {
        if ( $force===null ) { $force=false; }
        global $mf_initialisation;
        $campagne_Nom = (string)(isset($ligne['campagne_Nom'])?$ligne['campagne_Nom']:$mf_initialisation['campagne_Nom']);
        $campagne_Description = (string)(isset($ligne['campagne_Description'])?$ligne['campagne_Description']:$mf_initialisation['campagne_Description']);
        $campagne_Image_Fichier = (string)(isset($ligne['campagne_Image_Fichier'])?$ligne['campagne_Image_Fichier']:$mf_initialisation['campagne_Image_Fichier']);
        $campagne_Nombre_joueur = (int)(isset($ligne['campagne_Nombre_joueur'])?$ligne['campagne_Nombre_joueur']:$mf_initialisation['campagne_Nombre_joueur']);
        $campagne_Nombre_mj = (int)(isset($ligne['campagne_Nombre_mj'])?$ligne['campagne_Nombre_mj']:$mf_initialisation['campagne_Nombre_mj']);
        return $this->mf_ajouter($campagne_Nom, $campagne_Description, $campagne_Image_Fichier, $campagne_Nombre_joueur, $campagne_Nombre_mj, $force);
    }

    public function mf_ajouter_3(array $lignes) // array( array( 'colonne1' => 'valeur1', 'colonne2' => 'valeur2',  [...] ), [...] )
    {
        global $mf_initialisation;
        $code_erreur = 0;
        $values = '';
        foreach ($lignes as $ligne)
        {
            $campagne_Nom = text_sql(isset($ligne['campagne_Nom'])?$ligne['campagne_Nom']:$mf_initialisation['campagne_Nom']);
            $campagne_Description = text_sql(isset($ligne['campagne_Description'])?$ligne['campagne_Description']:$mf_initialisation['campagne_Description']);
            $campagne_Image_Fichier = text_sql(isset($ligne['campagne_Image_Fichier'])?$ligne['campagne_Image_Fichier']:$mf_initialisation['campagne_Image_Fichier']);
            $campagne_Nombre_joueur = round(isset($ligne['campagne_Nombre_joueur'])?$ligne['campagne_Nombre_joueur']:$mf_initialisation['campagne_Nombre_joueur']);
            $campagne_Nombre_mj = round(isset($ligne['campagne_Nombre_mj'])?$ligne['campagne_Nombre_mj']:$mf_initialisation['campagne_Nombre_mj']);
            $values.=($values!="" ? "," : "")."('$campagne_Nom', '$campagne_Description', '$campagne_Image_Fichier', $campagne_Nombre_joueur, $campagne_Nombre_mj)";
        }
        if ($values!='')
        {
            $requete = "INSERT INTO ".inst('campagne')." ( campagne_Nom, campagne_Description, campagne_Image_Fichier, campagne_Nombre_joueur, campagne_Nombre_mj ) VALUES $values;";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            $n = requete_mysqli_affected_rows();
            if ($n < count($lignes))
            {
                $code_erreur = ERR_CAMPAGNE__AJOUTER_3__ECHEC_AJOUT;
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

    public function mf_modifier( int $Code_campagne, string $campagne_Nom, string $campagne_Description, string $campagne_Image_Fichier, int $campagne_Nombre_joueur, int $campagne_Nombre_mj, ?bool $force=null)
    {
        if ( $force===null ) { $force=false; }
        $code_erreur = 0;
        $Code_campagne = round($Code_campagne);
        $campagne_Nombre_joueur = round($campagne_Nombre_joueur);
        $campagne_Nombre_mj = round($campagne_Nombre_mj);
        Hook_campagne::pre_controller($campagne_Nom, $campagne_Description, $campagne_Image_Fichier, $campagne_Nombre_joueur, $campagne_Nombre_mj, $Code_campagne);
        if (!$force)
        {
            if (!self::$maj_droits_modifier_en_cours)
            {
                self::$maj_droits_modifier_en_cours = true;
                Hook_campagne::hook_actualiser_les_droits_modifier($Code_campagne);
                self::$maj_droits_modifier_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['campagne__MODIFIER']) ) $code_erreur = REFUS_CAMPAGNE__MODIFIER;
        elseif ( !$this->mf_tester_existance_Code_campagne($Code_campagne) ) $code_erreur = ERR_CAMPAGNE__MODIFIER__CODE_CAMPAGNE_INEXISTANT;
        elseif ( CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_campagne', $Code_campagne) ) $code_erreur = ACCES_CODE_CAMPAGNE_REFUSE;
        elseif ( !Hook_campagne::autorisation_modification($Code_campagne, $campagne_Nom, $campagne_Description, $campagne_Image_Fichier, $campagne_Nombre_joueur, $campagne_Nombre_mj) ) $code_erreur = REFUS_CAMPAGNE__MODIFICATION_BLOQUEE;
        else
        {
            Hook_campagne::data_controller($campagne_Nom, $campagne_Description, $campagne_Image_Fichier, $campagne_Nombre_joueur, $campagne_Nombre_mj, $Code_campagne);
            $campagne = $this->mf_get_2( $Code_campagne, array('autocompletion' => false, 'masquer_mdp' => false) );
            $mf_colonnes_a_modifier=[];
            $bool__campagne_Nom = false; if ( $campagne_Nom!=$campagne['campagne_Nom'] ) { Hook_campagne::data_controller__campagne_Nom($campagne['campagne_Nom'], $campagne_Nom, $Code_campagne); if ( $campagne_Nom!=$campagne['campagne_Nom'] ) { $mf_colonnes_a_modifier[] = 'campagne_Nom=' . format_sql('campagne_Nom', $campagne_Nom); $bool__campagne_Nom = true; } }
            $bool__campagne_Description = false; if ( $campagne_Description!=$campagne['campagne_Description'] ) { Hook_campagne::data_controller__campagne_Description($campagne['campagne_Description'], $campagne_Description, $Code_campagne); if ( $campagne_Description!=$campagne['campagne_Description'] ) { $mf_colonnes_a_modifier[] = 'campagne_Description=' . format_sql('campagne_Description', $campagne_Description); $bool__campagne_Description = true; } }
            $bool__campagne_Image_Fichier = false; if ( $campagne_Image_Fichier!=$campagne['campagne_Image_Fichier'] ) { Hook_campagne::data_controller__campagne_Image_Fichier($campagne['campagne_Image_Fichier'], $campagne_Image_Fichier, $Code_campagne); if ( $campagne_Image_Fichier!=$campagne['campagne_Image_Fichier'] ) { $mf_colonnes_a_modifier[] = 'campagne_Image_Fichier=' . format_sql('campagne_Image_Fichier', $campagne_Image_Fichier); $bool__campagne_Image_Fichier = true; } }
            $bool__campagne_Nombre_joueur = false; if ( $campagne_Nombre_joueur!=$campagne['campagne_Nombre_joueur'] ) { Hook_campagne::data_controller__campagne_Nombre_joueur($campagne['campagne_Nombre_joueur'], $campagne_Nombre_joueur, $Code_campagne); if ( $campagne_Nombre_joueur!=$campagne['campagne_Nombre_joueur'] ) { $mf_colonnes_a_modifier[] = 'campagne_Nombre_joueur=' . format_sql('campagne_Nombre_joueur', $campagne_Nombre_joueur); $bool__campagne_Nombre_joueur = true; } }
            $bool__campagne_Nombre_mj = false; if ( $campagne_Nombre_mj!=$campagne['campagne_Nombre_mj'] ) { Hook_campagne::data_controller__campagne_Nombre_mj($campagne['campagne_Nombre_mj'], $campagne_Nombre_mj, $Code_campagne); if ( $campagne_Nombre_mj!=$campagne['campagne_Nombre_mj'] ) { $mf_colonnes_a_modifier[] = 'campagne_Nombre_mj=' . format_sql('campagne_Nombre_mj', $campagne_Nombre_mj); $bool__campagne_Nombre_mj = true; } }
            if (count($mf_colonnes_a_modifier)>0) {
                $mf_signature = text_sql(Hook_campagne::calcul_signature($campagne_Nom, $campagne_Description, $campagne_Image_Fichier, $campagne_Nombre_joueur, $campagne_Nombre_mj));
                $mf_cle_unique = text_sql(Hook_campagne::calcul_cle_unique($campagne_Nom, $campagne_Description, $campagne_Image_Fichier, $campagne_Nombre_joueur, $campagne_Nombre_mj));
                $mf_colonnes_a_modifier[] = 'mf_signature=\'' . $mf_signature . '\'';
                $mf_colonnes_a_modifier[] = 'mf_cle_unique=\'' . $mf_cle_unique . '\'';
                $mf_colonnes_a_modifier[] = 'mf_date_modification=\'' . get_now() . '\'';
                $requete = 'UPDATE '.inst('campagne').' SET ' . enumeration($mf_colonnes_a_modifier) . ' WHERE Code_campagne = ' . $Code_campagne . ';';
                $cle = md5($requete).salt(10);
                self::$cache_db->pause($cle);
                executer_requete_mysql( $requete , true);
                if ( requete_mysqli_affected_rows()==0 )
                {
                    $code_erreur = ERR_CAMPAGNE__MODIFIER__AUCUN_CHANGEMENT;
                    self::$cache_db->reprendre($cle);
                }
                else
                {
                    self::$cache_db->clear();
                    self::$cache_db->reprendre($cle);
                    Hook_campagne::modifier($Code_campagne, $bool__campagne_Nom, $bool__campagne_Description, $bool__campagne_Image_Fichier, $bool__campagne_Nombre_joueur, $bool__campagne_Nombre_mj);
                }
            }
            else
            {
                $code_erreur = ERR_CAMPAGNE__MODIFIER__AUCUN_CHANGEMENT;
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
        return array('code_erreur' => $code_erreur, 'callback' => ( $code_erreur == 0 ? Hook_campagne::callback_put($Code_campagne) : null ));
    }

    public function mf_modifier_2(array $lignes, ?bool $force=null) // array( $Code_campagne => array('colonne1' => 'valeur1',  [...] ) )
    {
        if ( $force===null ) { $force=false; }
        $code_erreur = 0;
        foreach ( $lignes as $Code_campagne => $colonnes )
        {
            if ( $code_erreur==0 )
            {
                $Code_campagne = (int)round($Code_campagne);
                $campagne = $this->mf_get_2($Code_campagne, array('autocompletion' => false));
                if (!$force)
                {
                    if (!self::$maj_droits_modifier_en_cours)
                    {
                        self::$maj_droits_modifier_en_cours = true;
                        Hook_campagne::hook_actualiser_les_droits_modifier($Code_campagne);
                        self::$maj_droits_modifier_en_cours = false;
                    }
                }
                $campagne_Nom = (string)( isset($colonnes['campagne_Nom']) && ( $force || mf_matrice_droits(['api_modifier__campagne_Nom', 'campagne__MODIFIER']) ) ? $colonnes['campagne_Nom'] : ( isset($campagne['campagne_Nom']) ? $campagne['campagne_Nom'] : '' ) );
                $campagne_Description = (string)( isset($colonnes['campagne_Description']) && ( $force || mf_matrice_droits(['api_modifier__campagne_Description', 'campagne__MODIFIER']) ) ? $colonnes['campagne_Description'] : ( isset($campagne['campagne_Description']) ? $campagne['campagne_Description'] : '' ) );
                $campagne_Image_Fichier = (string)( isset($colonnes['campagne_Image_Fichier']) && ( $force || mf_matrice_droits(['api_modifier__campagne_Image_Fichier', 'campagne__MODIFIER']) ) ? $colonnes['campagne_Image_Fichier'] : ( isset($campagne['campagne_Image_Fichier']) ? $campagne['campagne_Image_Fichier'] : '' ) );
                $campagne_Nombre_joueur = (int)( isset($colonnes['campagne_Nombre_joueur']) && ( $force || mf_matrice_droits(['api_modifier__campagne_Nombre_joueur', 'campagne__MODIFIER']) ) ? $colonnes['campagne_Nombre_joueur'] : ( isset($campagne['campagne_Nombre_joueur']) ? $campagne['campagne_Nombre_joueur'] : '' ) );
                $campagne_Nombre_mj = (int)( isset($colonnes['campagne_Nombre_mj']) && ( $force || mf_matrice_droits(['api_modifier__campagne_Nombre_mj', 'campagne__MODIFIER']) ) ? $colonnes['campagne_Nombre_mj'] : ( isset($campagne['campagne_Nombre_mj']) ? $campagne['campagne_Nombre_mj'] : '' ) );
                $retour = $this->mf_modifier($Code_campagne, $campagne_Nom, $campagne_Description, $campagne_Image_Fichier, $campagne_Nombre_joueur, $campagne_Nombre_mj, true);
                if ( $retour['code_erreur']!=0 && $retour['code_erreur'] != ERR_CAMPAGNE__MODIFIER__AUCUN_CHANGEMENT )
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

    public function mf_modifier_3(array $lignes) // array( $Code_campagne => array('colonne1' => 'valeur1',  [...] ) )
    {
        $code_erreur = 0;
        $modifs = false;

        // transformation des lignes en colonnes
        $valeurs_en_colonnes=array();
        $indices_par_colonne=array();
        $liste_valeurs_indexees=array();
        foreach ( $lignes as $Code_campagne => $colonnes )
        {
            foreach ($colonnes as $colonne => $valeur)
            {
                if ( $colonne=='campagne_Nom' || $colonne=='campagne_Description' || $colonne=='campagne_Image_Fichier' || $colonne=='campagne_Nombre_joueur' || $colonne=='campagne_Nombre_mj' )
                {
                    $valeurs_en_colonnes[$colonne][$Code_campagne]=$valeur;
                    $indices_par_colonne[$colonne][]=$Code_campagne;
                    $liste_valeurs_indexees[$colonne][''.$valeur][]=$Code_campagne;
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
                $modification_sql = $colonne . ' = CASE Code_campagne';
                foreach ( $valeurs as $Code_campagne => $valeur )
                {
                    $modification_sql.=' WHEN ' . $Code_campagne . ' THEN ' . format_sql($colonne, $valeur);
                }
                $modification_sql.=' END';
                $perimetre = Sql_Format_Liste($indices_par_colonne[$colonne]);
                executer_requete_mysql('UPDATE ' . inst('campagne') . ' SET ' . $modification_sql . ' WHERE Code_campagne IN ' . $perimetre . ';', true);
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
                    executer_requete_mysql('UPDATE ' . inst('campagne') . ' SET ' . $colonne . ' = ' . format_sql($colonne, $valeur) . ' WHERE Code_campagne IN ' . $perimetre . ';', true);
                    if ( requete_mysqli_affected_rows()!=0 )
                    {
                        $modifs = true;
                    }
                }
            }
        }

        if ( ! $modifs && $code_erreur==0 )
        {
            $code_erreur = ERR_CAMPAGNE__MODIFIER_3__AUCUN_CHANGEMENT;
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
        if ( isset($data['campagne_Nom']) ) { $mf_colonnes_a_modifier[] = 'campagne_Nom = ' . format_sql('campagne_Nom', $data['campagne_Nom']); }
        if ( isset($data['campagne_Description']) ) { $mf_colonnes_a_modifier[] = 'campagne_Description = ' . format_sql('campagne_Description', $data['campagne_Description']); }
        if ( isset($data['campagne_Image_Fichier']) ) { $mf_colonnes_a_modifier[] = 'campagne_Image_Fichier = ' . format_sql('campagne_Image_Fichier', $data['campagne_Image_Fichier']); }
        if ( isset($data['campagne_Nombre_joueur']) ) { $mf_colonnes_a_modifier[] = 'campagne_Nombre_joueur = ' . format_sql('campagne_Nombre_joueur', $data['campagne_Nombre_joueur']); }
        if ( isset($data['campagne_Nombre_mj']) ) { $mf_colonnes_a_modifier[] = 'campagne_Nombre_mj = ' . format_sql('campagne_Nombre_mj', $data['campagne_Nombre_mj']); }
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

            $requete = 'UPDATE ' . inst('campagne') . ' SET ' . enumeration($mf_colonnes_a_modifier) . " WHERE 1$argument_cond" . ( $limit>0 ? ' LIMIT ' . $limit : '' ) . ";";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_CAMPAGNE__MODIFIER_4__AUCUN_CHANGEMENT;
            }
            else
            {
                self::$cache_db->clear();
            }
            self::$cache_db->reprendre($cle);
        }
        return array('code_erreur' => $code_erreur);
    }

    public function mf_supprimer( int $Code_campagne, ?bool $force=null )
    {
        if ( $force===null ) { $force=false; }
        $code_erreur = 0;
        $Code_campagne = round($Code_campagne);
        if (!$force)
        {
            if (!self::$maj_droits_supprimer_en_cours)
            {
                self::$maj_droits_supprimer_en_cours = true;
                Hook_campagne::hook_actualiser_les_droits_supprimer($Code_campagne);
                self::$maj_droits_supprimer_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['campagne__SUPPRIMER']) ) $code_erreur = REFUS_CAMPAGNE__SUPPRIMER;
        elseif ( !$this->mf_tester_existance_Code_campagne($Code_campagne) ) $code_erreur = ERR_CAMPAGNE__SUPPRIMER_2__CODE_CAMPAGNE_INEXISTANT;
        elseif ( CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_campagne', $Code_campagne) ) $code_erreur = ACCES_CODE_CAMPAGNE_REFUSE;
        elseif ( !Hook_campagne::autorisation_suppression($Code_campagne) ) $code_erreur = REFUS_CAMPAGNE__SUPPRESSION_BLOQUEE;
        else
        {
            $copie__campagne = $this->mf_get($Code_campagne, array('autocompletion' => false));
            $this->supprimer_donnes_en_cascade("campagne", array($Code_campagne));
            $requete = "DELETE IGNORE FROM ".inst('campagne')." WHERE Code_campagne=$Code_campagne;";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_CAMPAGNE__SUPPRIMER__REFUSEE;
                self::$cache_db->reprendre($cle);
            }
            else
            {
                self::$cache_db->clear();
                self::$cache_db->reprendre($cle);
                Hook_campagne::supprimer($copie__campagne);
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

    public function mf_supprimer_2(array $liste_Code_campagne, ?bool $force=null)
    {
        if ( $force===null ) { $force=false; }
        $code_erreur=0;
        $copie__liste_campagne = $this->mf_lister_2($liste_Code_campagne, array('autocompletion' => false));
        $liste_Code_campagne=array();
        foreach ( $copie__liste_campagne as $copie__campagne )
        {
            $Code_campagne = $copie__campagne['Code_campagne'];
            if (!$force)
            {
                if (!self::$maj_droits_supprimer_en_cours)
                {
                    self::$maj_droits_supprimer_en_cours = true;
                    Hook_campagne::hook_actualiser_les_droits_supprimer($Code_campagne);
                    self::$maj_droits_supprimer_en_cours = false;
                }
            }
            if ( !$force && !mf_matrice_droits(['campagne__SUPPRIMER']) ) $code_erreur = REFUS_CAMPAGNE__SUPPRIMER;
            elseif ( !Hook_campagne::autorisation_suppression($Code_campagne) ) $code_erreur = REFUS_CAMPAGNE__SUPPRESSION_BLOQUEE;
            {
                $liste_Code_campagne[] = $Code_campagne;
            }
        }
        if ( $code_erreur==0 && count($liste_Code_campagne)>0 )
        {
            $this->supprimer_donnes_en_cascade("campagne", $liste_Code_campagne);
            $requete = "DELETE IGNORE FROM ".inst('campagne')." WHERE Code_campagne IN ".Sql_Format_Liste($liste_Code_campagne).";";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_CAMPAGNE__SUPPRIMER_2__REFUSEE;
                self::$cache_db->reprendre($cle);
            }
            else
            {
                self::$cache_db->clear();
                self::$cache_db->reprendre($cle);
                Hook_campagne::supprimer_2($copie__liste_campagne);
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

    public function mf_supprimer_3(array $liste_Code_campagne)
    {
        $code_erreur=0;
        if ( count($liste_Code_campagne)>0 )
        {
            $this->supprimer_donnes_en_cascade("campagne", $liste_Code_campagne);
            $requete = "DELETE IGNORE FROM ".inst('campagne')." WHERE Code_campagne IN ".Sql_Format_Liste($liste_Code_campagne).";";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_CAMPAGNE__SUPPRIMER_3__REFUSEE;
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
        if ( ! $contexte_parent && $mf_contexte['Code_campagne']!=0 )
        {
            $campagne = $this->mf_get( $mf_contexte['Code_campagne'], $options);
            return array( $campagne['Code_campagne'] => $campagne );
        }
        else
        {
            return $this->mf_lister($options);
        }
    }

    public function mf_lister(?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cle = "campagne__lister";

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
            if ( isset($mf_tri_defaut_table['campagne']) )
            {
                $options['tris'] = $mf_tri_defaut_table['campagne'];
            }
        }
        foreach ($options['tris'] as $colonne => $tri)
        {
            if ( $colonne != 'campagne_Description' )
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
                    if ( strpos($argument_cond, 'campagne_Nom')!==false ) { $liste_colonnes_a_indexer['campagne_Nom'] = 'campagne_Nom'; }
                    if ( strpos($argument_cond, 'campagne_Image_Fichier')!==false ) { $liste_colonnes_a_indexer['campagne_Image_Fichier'] = 'campagne_Image_Fichier'; }
                    if ( strpos($argument_cond, 'campagne_Nombre_joueur')!==false ) { $liste_colonnes_a_indexer['campagne_Nombre_joueur'] = 'campagne_Nombre_joueur'; }
                    if ( strpos($argument_cond, 'campagne_Nombre_mj')!==false ) { $liste_colonnes_a_indexer['campagne_Nombre_mj'] = 'campagne_Nombre_mj'; }
                }
                if ( isset($options['tris']) )
                {
                    if ( isset($options['tris']['campagne_Nom']) ) { $liste_colonnes_a_indexer['campagne_Nom'] = 'campagne_Nom'; }
                    if ( isset($options['tris']['campagne_Image_Fichier']) ) { $liste_colonnes_a_indexer['campagne_Image_Fichier'] = 'campagne_Image_Fichier'; }
                    if ( isset($options['tris']['campagne_Nombre_joueur']) ) { $liste_colonnes_a_indexer['campagne_Nombre_joueur'] = 'campagne_Nombre_joueur'; }
                    if ( isset($options['tris']['campagne_Nombre_mj']) ) { $liste_colonnes_a_indexer['campagne_Nombre_mj'] = 'campagne_Nombre_mj'; }
                }
                if ( count($liste_colonnes_a_indexer)>0 )
                {
                    if ( ! $mf_liste_requete_index = self::$cache_db->read('campagne__index') )
                    {
                        $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('campagne').'`;', false);
                        $mf_liste_requete_index = array();
                        while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                        {
                            $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                        }
                        mysqli_free_result($res_requete_index);
                        self::$cache_db->write('campagne__index', $mf_liste_requete_index);
                    }
                    foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                    {
                        if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                    }
                    if ( count($liste_colonnes_a_indexer) > 0 )
                    {
                        self::$cache_db->pause('campagne__index');
                        foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                        {
                            executer_requete_mysql('ALTER TABLE `'.inst('campagne').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                        }
                        self::$cache_db->clear();
                        self::$cache_db->reprendre('campagne__index');
                    }
                }

                $liste = array();
                $liste_campagne_pas_a_jour = array();
                if ($toutes_colonnes)
                {
                    $colonnes='Code_campagne, campagne_Nom, campagne_Description, campagne_Image_Fichier, campagne_Nombre_joueur, campagne_Nombre_mj';
                }
                else
                {
                    $colonnes='Code_campagne, campagne_Nom, campagne_Image_Fichier, campagne_Nombre_joueur, campagne_Nombre_mj';
                }
                $res_requete = executer_requete_mysql("SELECT $colonnes FROM ".inst('campagne')." WHERE 1{$argument_cond}{$argument_tris}{$argument_limit};", false);
                while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
                {
                    mf_formatage_db_type_php($row_requete);
                    $liste[$row_requete['Code_campagne']] = $row_requete;
                    if ( $maj && ! Hook_campagne::est_a_jour( $row_requete ) )
                    {
                        $liste_campagne_pas_a_jour[$row_requete['Code_campagne']] = $row_requete;
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
                Hook_campagne::mettre_a_jour( $liste_campagne_pas_a_jour );
            }
        }

        foreach ($liste as $elem)
        {
            if ( $controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_campagne', $elem['Code_campagne']) )
            {
                unset($liste[$elem['Code_campagne']]);
            }
            else
            {
                if (!self::$auto_completion && $autocompletion)
                {
                    self::$auto_completion = true;
                    Hook_campagne::completion($liste[$elem['Code_campagne']]);
                    self::$auto_completion = false;
                }
            }
        }

        return $liste;
    }

    public function mf_lister_2(array $liste_Code_campagne, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        if ( count($liste_Code_campagne)>0 )
        {
            $cle = "campagne__mf_lister_2_".Sql_Format_Liste($liste_Code_campagne);

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
                if ( isset($mf_tri_defaut_table['campagne']) )
                {
                    $options['tris'] = $mf_tri_defaut_table['campagne'];
                }
            }
            foreach ($options['tris'] as $colonne => $tri)
            {
                if ( $colonne != 'campagne_Description' )
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
                        if ( strpos($argument_cond, 'campagne_Nom')!==false ) { $liste_colonnes_a_indexer['campagne_Nom'] = 'campagne_Nom'; }
                        if ( strpos($argument_cond, 'campagne_Image_Fichier')!==false ) { $liste_colonnes_a_indexer['campagne_Image_Fichier'] = 'campagne_Image_Fichier'; }
                        if ( strpos($argument_cond, 'campagne_Nombre_joueur')!==false ) { $liste_colonnes_a_indexer['campagne_Nombre_joueur'] = 'campagne_Nombre_joueur'; }
                        if ( strpos($argument_cond, 'campagne_Nombre_mj')!==false ) { $liste_colonnes_a_indexer['campagne_Nombre_mj'] = 'campagne_Nombre_mj'; }
                    }
                    if ( isset($options['tris']) )
                    {
                        if ( isset($options['tris']['campagne_Nom']) ) { $liste_colonnes_a_indexer['campagne_Nom'] = 'campagne_Nom'; }
                        if ( isset($options['tris']['campagne_Image_Fichier']) ) { $liste_colonnes_a_indexer['campagne_Image_Fichier'] = 'campagne_Image_Fichier'; }
                        if ( isset($options['tris']['campagne_Nombre_joueur']) ) { $liste_colonnes_a_indexer['campagne_Nombre_joueur'] = 'campagne_Nombre_joueur'; }
                        if ( isset($options['tris']['campagne_Nombre_mj']) ) { $liste_colonnes_a_indexer['campagne_Nombre_mj'] = 'campagne_Nombre_mj'; }
                    }
                    if ( count($liste_colonnes_a_indexer)>0 )
                    {
                        if ( ! $mf_liste_requete_index = self::$cache_db->read('campagne__index') )
                        {
                            $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('campagne').'`;', false);
                            $mf_liste_requete_index = array();
                            while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                            {
                                $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                            }
                            mysqli_free_result($res_requete_index);
                            self::$cache_db->write('campagne__index', $mf_liste_requete_index);
                        }
                        foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                        {
                            if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                        }
                        if ( count($liste_colonnes_a_indexer) > 0 )
                        {
                            self::$cache_db->pause('campagne__index');
                            foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                            {
                                executer_requete_mysql('ALTER TABLE `'.inst('campagne').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                            }
                            self::$cache_db->clear();
                            self::$cache_db->reprendre('campagne__index');
                        }
                    }

                    $liste = array();
                    $liste_campagne_pas_a_jour = array();
                    if ($toutes_colonnes)
                    {
                        $colonnes='Code_campagne, campagne_Nom, campagne_Description, campagne_Image_Fichier, campagne_Nombre_joueur, campagne_Nombre_mj';
                    }
                    else
                    {
                        $colonnes='Code_campagne, campagne_Nom, campagne_Image_Fichier, campagne_Nombre_joueur, campagne_Nombre_mj';
                    }
                    $res_requete = executer_requete_mysql("SELECT $colonnes FROM ".inst('campagne')." WHERE 1{$argument_cond} AND Code_campagne IN ".Sql_Format_Liste($liste_Code_campagne)."{$argument_tris}{$argument_limit};", false);
                    while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
                    {
                        mf_formatage_db_type_php($row_requete);
                        $liste[$row_requete['Code_campagne']] = $row_requete;
                        if ( $maj && ! Hook_campagne::est_a_jour( $row_requete ) )
                        {
                            $liste_campagne_pas_a_jour[$row_requete['Code_campagne']] = $row_requete;
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
                    Hook_campagne::mettre_a_jour( $liste_campagne_pas_a_jour );
                }
            }

            foreach ($liste as $elem)
            {
                if ( $controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_campagne', $elem['Code_campagne']) )
                {
                    unset($liste[$elem['Code_campagne']]);
                }
                else
                {
                    if (!self::$auto_completion && $autocompletion)
                    {
                        self::$auto_completion = true;
                        Hook_campagne::completion($liste[$elem['Code_campagne']]);
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

    public function mf_get(int $Code_campagne, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $Code_campagne = round($Code_campagne);
        $retour = array();
        if ( ! CONTROLE_ACCES_DONNEES_DEFAUT || Hook_mf_systeme::controle_acces_donnees('Code_campagne', $Code_campagne) )
        {
            $cle = 'campagne__get_'.$Code_campagne;

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
                        $colonnes='Code_campagne, campagne_Nom, campagne_Description, campagne_Image_Fichier, campagne_Nombre_joueur, campagne_Nombre_mj';
                    }
                    else
                    {
                        $colonnes='Code_campagne, campagne_Nom, campagne_Image_Fichier, campagne_Nombre_joueur, campagne_Nombre_mj';
                    }
                    $res_requete = executer_requete_mysql('SELECT ' . $colonnes . ' FROM ' . inst('campagne') . ' WHERE Code_campagne = ' . $Code_campagne . ';', false);
                    if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
                    {
                        mf_formatage_db_type_php($row_requete);
                        $retour = $row_requete;
                        if ( $maj && ! Hook_campagne::est_a_jour( $row_requete ) )
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
                    Hook_campagne::mettre_a_jour( array( $row_requete['Code_campagne'] => $row_requete ) );
                }
            }
            if ( isset( $retour['Code_campagne'] ) )
            {
                if (!self::$auto_completion && $autocompletion)
                {
                    self::$auto_completion = true;
                    Hook_campagne::completion($retour);
                    self::$auto_completion = false;
                }
            }
        }
        return $retour;
    }

    public function mf_get_last(?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cle = "campagne__get_last";
        if ( ! $retour = self::$cache_db->read($cle) )
        {
            $Code_campagne = 0;
            $res_requete = executer_requete_mysql('SELECT Code_campagne FROM ' . inst('campagne') . " WHERE 1 ORDER BY mf_date_creation DESC, Code_campagne DESC LIMIT 0 , 1;", false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $Code_campagne = $row_requete['Code_campagne'];
            }
            mysqli_free_result($res_requete);
            $retour = $this->mf_get($Code_campagne, $options);
            self::$cache_db->write($cle, $retour);
        }
        return $retour;
    }

    public function mf_get_2(int $Code_campagne, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $Code_campagne = round($Code_campagne);
        $retour = array();
        $cle = 'campagne__get_'.$Code_campagne;

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
                $colonnes='Code_campagne, campagne_Nom, campagne_Description, campagne_Image_Fichier, campagne_Nombre_joueur, campagne_Nombre_mj';
            }
            else
            {
                $colonnes='Code_campagne, campagne_Nom, campagne_Image_Fichier, campagne_Nombre_joueur, campagne_Nombre_mj';
            }
            $res_requete = executer_requete_mysql('SELECT ' . $colonnes . " FROM ".inst('campagne')." WHERE Code_campagne = $Code_campagne;", false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                mf_formatage_db_type_php($row_requete);
                $retour = $row_requete;
            }
            mysqli_free_result($res_requete);
            self::$cache_db->write($cle, $retour);
        }
        if ( isset( $retour['Code_campagne'] ) )
        {
            if (!self::$auto_completion && $autocompletion)
            {
                self::$auto_completion = true;
                Hook_campagne::completion($retour);
                self::$auto_completion = false;
            }
        }
        return $retour;
    }

    public function mf_prec_et_suiv( int $Code_campagne, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $Code_campagne = round($Code_campagne);
        $liste = $this->mf_lister($options);
        return prec_suiv($liste, $Code_campagne);
    }

    public function mf_compter(?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cle = 'campagne__compter';

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
                if ( strpos($argument_cond, 'campagne_Nom')!==false ) { $liste_colonnes_a_indexer['campagne_Nom'] = 'campagne_Nom'; }
                if ( strpos($argument_cond, 'campagne_Image_Fichier')!==false ) { $liste_colonnes_a_indexer['campagne_Image_Fichier'] = 'campagne_Image_Fichier'; }
                if ( strpos($argument_cond, 'campagne_Nombre_joueur')!==false ) { $liste_colonnes_a_indexer['campagne_Nombre_joueur'] = 'campagne_Nombre_joueur'; }
                if ( strpos($argument_cond, 'campagne_Nombre_mj')!==false ) { $liste_colonnes_a_indexer['campagne_Nombre_mj'] = 'campagne_Nombre_mj'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = self::$cache_db->read('campagne__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('campagne').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    self::$cache_db->write('campagne__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    self::$cache_db->pause('campagne__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('campagne').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    self::$cache_db->clear();
                    self::$cache_db->reprendre('campagne__index');
                }
            }

            $res_requete = executer_requete_mysql('SELECT count(Code_campagne) as nb FROM ' . inst('campagne')." WHERE 1{$argument_cond};", false);
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

    public function mf_liste_Code_campagne(?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ( $options===null ) { $options=[]; }
        return $this->get_liste_Code_campagne($options);
    }

    public function mf_get_liste_tables_enfants()
    {
        return $this->get_liste_tables_enfants( 'campagne' );
    }

    public function mf_get_liste_tables_parents()
    {
        return array();
    }

    public function mf_search_campagne_Nom( string $campagne_Nom )
    {
        return $this->rechercher_campagne_Nom( $campagne_Nom );
    }

    public function mf_search_campagne_Image_Fichier( string $campagne_Image_Fichier )
    {
        return $this->rechercher_campagne_Image_Fichier( $campagne_Image_Fichier );
    }

    public function mf_search_campagne_Nombre_joueur( int $campagne_Nombre_joueur )
    {
        return $this->rechercher_campagne_Nombre_joueur( $campagne_Nombre_joueur );
    }

    public function mf_search_campagne_Nombre_mj( int $campagne_Nombre_mj )
    {
        return $this->rechercher_campagne_Nombre_mj( $campagne_Nombre_mj );
    }

    public function mf_search__colonne( string $colonne_db, $recherche )
    {
        switch ($colonne_db) {
            case 'campagne_Nom': return $this->mf_search_campagne_Nom( $recherche ); break;
            case 'campagne_Image_Fichier': return $this->mf_search_campagne_Image_Fichier( $recherche ); break;
            case 'campagne_Nombre_joueur': return $this->mf_search_campagne_Nombre_joueur( $recherche ); break;
            case 'campagne_Nombre_mj': return $this->mf_search_campagne_Nombre_mj( $recherche ); break;
        }
    }

    public function mf_get_next_id()
    {
        $res_requete = executer_requete_mysql('SELECT AUTO_INCREMENT as next_id FROM INFORMATION_SCHEMA.TABLES WHERE table_name = \'campagne\';', false);
        $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC);
        mysqli_free_result($res_requete);
        return round($row_requete['next_id']);
    }

    public function mf_search(array $ligne) // array('colonne1' => 'valeur1',  [...] )
    {
        global $mf_initialisation;
        $campagne_Nom = (string)(isset($ligne['campagne_Nom'])?$ligne['campagne_Nom']:$mf_initialisation['campagne_Nom']);
        $campagne_Description = (string)(isset($ligne['campagne_Description'])?$ligne['campagne_Description']:$mf_initialisation['campagne_Description']);
        $campagne_Image_Fichier = (string)(isset($ligne['campagne_Image_Fichier'])?$ligne['campagne_Image_Fichier']:$mf_initialisation['campagne_Image_Fichier']);
        $campagne_Nombre_joueur = (int)(isset($ligne['campagne_Nombre_joueur'])?$ligne['campagne_Nombre_joueur']:$mf_initialisation['campagne_Nombre_joueur']);
        $campagne_Nombre_mj = (int)(isset($ligne['campagne_Nombre_mj'])?$ligne['campagne_Nombre_mj']:$mf_initialisation['campagne_Nombre_mj']);
        $campagne_Nombre_joueur = round($campagne_Nombre_joueur);
        $campagne_Nombre_mj = round($campagne_Nombre_mj);
        Hook_campagne::pre_controller($campagne_Nom, $campagne_Description, $campagne_Image_Fichier, $campagne_Nombre_joueur, $campagne_Nombre_mj);
        $mf_cle_unique = Hook_campagne::calcul_cle_unique($campagne_Nom, $campagne_Description, $campagne_Image_Fichier, $campagne_Nombre_joueur, $campagne_Nombre_mj);
        $res_requete = executer_requete_mysql('SELECT Code_campagne FROM ' . inst('campagne') . ' WHERE mf_cle_unique = \''.$mf_cle_unique.'\'', false);
        if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
        {
            $r = round($row_requete['Code_campagne']);
        }
        else
        {
            $r = false;
        }
        mysqli_free_result($res_requete);
        return $r;
    }

}
