<?php

/*
    +------------------------------+
    |  NE PAS MODIFIER CE FICHIER  |
    +------------------------------+
*/

class messagerie_monframework extends entite_monframework
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
            include_once __DIR__ . '/../../erreurs/erreurs__messagerie.php';
            self::$initialisation = false;
            Hook_messagerie::initialisation();
            self::$cache_db = new Mf_Cachedb('messagerie');
        }
        if (!self::$actualisation_en_cours)
        {
            self::$actualisation_en_cours=true;
            Hook_messagerie::actualisation();
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

        if ( ! test_si_table_existe(inst('messagerie')) )
        {
            executer_requete_mysql('CREATE TABLE '.inst('messagerie').'(Code_messagerie INT AUTO_INCREMENT NOT NULL, PRIMARY KEY (Code_messagerie)) ENGINE=MyISAM;', true);
        }

        $liste_colonnes = lister_les_colonnes(inst('messagerie'));

        if ( isset($liste_colonnes['messagerie_Nom']) )
        {
            if ( typeMyql2Sql($liste_colonnes['messagerie_Nom']['Type'])!='VARCHAR' )
            {
                executer_requete_mysql('ALTER TABLE '.inst('messagerie').' CHANGE messagerie_Nom messagerie_Nom VARCHAR(255);', true);
            }
            unset($liste_colonnes['messagerie_Nom']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('messagerie').' ADD messagerie_Nom VARCHAR(255);', true);
            executer_requete_mysql('UPDATE '.inst('messagerie').' SET messagerie_Nom=' . format_sql('messagerie_Nom', $mf_initialisation['messagerie_Nom']) . ';', true);
        }

        if ( isset($liste_colonnes['Code_joueur']) )
        {
            unset($liste_colonnes['Code_joueur']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('messagerie').' ADD Code_joueur int NOT NULL;', true);
        }

        if ( isset($liste_colonnes['mf_signature']) )
        {
            unset($liste_colonnes['mf_signature']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('messagerie').' ADD mf_signature VARCHAR(255);', true);
            executer_requete_mysql('ALTER TABLE '.inst('messagerie').' ADD INDEX( mf_signature );', true);
        }

        if ( isset($liste_colonnes['mf_cle_unique']) )
        {
            unset($liste_colonnes['mf_cle_unique']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('messagerie').' ADD mf_cle_unique VARCHAR(255);', true);
            executer_requete_mysql('ALTER TABLE '.inst('messagerie').' ADD INDEX( mf_cle_unique );', true);
        }

        if ( isset($liste_colonnes['mf_date_creation']) )
        {
            unset($liste_colonnes['mf_date_creation']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('messagerie').' ADD mf_date_creation DATETIME;', true);
            executer_requete_mysql('ALTER TABLE '.inst('messagerie').' ADD INDEX( mf_date_creation );', true);
        }

        if ( isset($liste_colonnes['mf_date_modification']) )
        {
            unset($liste_colonnes['mf_date_modification']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('messagerie').' ADD mf_date_modification DATETIME;', true);
            executer_requete_mysql('ALTER TABLE '.inst('messagerie').' ADD INDEX( mf_date_modification );', true);
        }

        unset($liste_colonnes['Code_messagerie']);

        foreach ($liste_colonnes as $field => $value)
        {
            executer_requete_mysql('ALTER TABLE '.inst('messagerie').' DROP COLUMN '.$field.';', true);
        }

    }

    public function mf_ajouter(string $messagerie_Nom, int $Code_joueur, ?bool $force=false)
    {
        if ( $force===null ) { $force=false; }
        $Code_messagerie = 0;
        $code_erreur = 0;
        $Code_joueur = round($Code_joueur);
        Hook_messagerie::pre_controller($messagerie_Nom, $Code_joueur);
        if (!$force)
        {
            if (!self::$maj_droits_ajouter_en_cours)
            {
                self::$maj_droits_ajouter_en_cours = true;
                Hook_messagerie::hook_actualiser_les_droits_ajouter($Code_joueur);
                self::$maj_droits_ajouter_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['messagerie__AJOUTER']) ) $code_erreur = REFUS_MESSAGERIE__AJOUTER;
        elseif ( !$this->mf_tester_existance_Code_joueur($Code_joueur) ) $code_erreur = ERR_MESSAGERIE__AJOUTER__CODE_JOUEUR_INEXISTANT;
        elseif ( CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_joueur', $Code_joueur) ) $code_erreur = ACCES_CODE_JOUEUR_REFUSE;
        elseif ( !Hook_messagerie::autorisation_ajout($messagerie_Nom, $Code_joueur) ) $code_erreur = REFUS_MESSAGERIE__AJOUT_BLOQUEE;
        else
        {
            Hook_messagerie::data_controller($messagerie_Nom, $Code_joueur);
            $mf_signature = text_sql(Hook_messagerie::calcul_signature($messagerie_Nom, $Code_joueur));
            $mf_cle_unique = text_sql(Hook_messagerie::calcul_cle_unique($messagerie_Nom, $Code_joueur));
            $messagerie_Nom = text_sql($messagerie_Nom);
            $requete = "INSERT INTO ".inst('messagerie')." ( mf_signature, mf_cle_unique, mf_date_creation, mf_date_modification, messagerie_Nom, Code_joueur ) VALUES ( '$mf_signature', '$mf_cle_unique', '".get_now()."', '".get_now()."', '$messagerie_Nom', $Code_joueur );";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql($requete, true);
            $Code_messagerie = requete_mysql_insert_id();
            if ($Code_messagerie==0)
            {
                $code_erreur = ERR_MESSAGERIE__AJOUTER__AJOUT_REFUSE;
                self::$cache_db->reprendre($cle);
            }
            else
            {
                self::$cache_db->clear();
                self::$cache_db->reprendre($cle);
                Hook_messagerie::ajouter( $Code_messagerie );
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
        return array('code_erreur' => $code_erreur, 'Code_messagerie' => $Code_messagerie, 'callback' => ( $code_erreur==0 ? Hook_messagerie::callback_post($Code_messagerie) : null ));
    }

    public function mf_creer(int $Code_joueur, ?bool $force=null)
    {
        if ( $force===null ) { $force=false; }
        global $mf_initialisation, $mf_droits_defaut;
        $mf_droits_defaut["messagerie__AJOUTER"] = $mf_droits_defaut["messagerie__CREER"];
        $messagerie_Nom = $mf_initialisation['messagerie_Nom'];
        return $this->mf_ajouter($messagerie_Nom, $Code_joueur, $force);
    }

    public function mf_ajouter_2(array $ligne, bool $force=null) // array('colonne1' => 'valeur1',  [...] )
    {
        if ( $force===null ) { $force=false; }
        global $mf_initialisation;
        $Code_joueur = (int)(isset($ligne['Code_joueur'])?round($ligne['Code_joueur']):get_joueur_courant('Code_joueur'));
        $messagerie_Nom = (string)(isset($ligne['messagerie_Nom'])?$ligne['messagerie_Nom']:$mf_initialisation['messagerie_Nom']);
        return $this->mf_ajouter($messagerie_Nom, $Code_joueur, $force);
    }

    public function mf_ajouter_3(array $lignes) // array( array( 'colonne1' => 'valeur1', 'colonne2' => 'valeur2',  [...] ), [...] )
    {
        global $mf_initialisation;
        $code_erreur = 0;
        $values = '';
        foreach ($lignes as $ligne)
        {
            $Code_joueur = (int)(isset($ligne['Code_joueur'])?round($ligne['Code_joueur']):0);
            $messagerie_Nom = text_sql(isset($ligne['messagerie_Nom'])?$ligne['messagerie_Nom']:$mf_initialisation['messagerie_Nom']);
            if ($Code_joueur != 0)
            {
                $values.=($values!="" ? "," : "")."('$messagerie_Nom', $Code_joueur)";
            }
        }
        if ($values!='')
        {
            $requete = "INSERT INTO ".inst('messagerie')." ( messagerie_Nom, Code_joueur ) VALUES $values;";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            $n = requete_mysqli_affected_rows();
            if ($n < count($lignes))
            {
                $code_erreur = ERR_MESSAGERIE__AJOUTER_3__ECHEC_AJOUT;
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

    public function mf_modifier( int $Code_messagerie, string $messagerie_Nom, ?int $Code_joueur=null, ?bool $force=null)
    {
        if ( $force===null ) { $force=false; }
        $code_erreur = 0;
        $Code_messagerie = round($Code_messagerie);
        $Code_joueur = round($Code_joueur);
        Hook_messagerie::pre_controller($messagerie_Nom, $Code_joueur, $Code_messagerie);
        if (!$force)
        {
            if (!self::$maj_droits_modifier_en_cours)
            {
                self::$maj_droits_modifier_en_cours = true;
                Hook_messagerie::hook_actualiser_les_droits_modifier($Code_messagerie);
                self::$maj_droits_modifier_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['messagerie__MODIFIER']) ) $code_erreur = REFUS_MESSAGERIE__MODIFIER;
        elseif ( !$this->mf_tester_existance_Code_messagerie($Code_messagerie) ) $code_erreur = ERR_MESSAGERIE__MODIFIER__CODE_MESSAGERIE_INEXISTANT;
        elseif ( $Code_joueur!=0 && !$this->mf_tester_existance_Code_joueur($Code_joueur) ) $code_erreur = ERR_MESSAGERIE__MODIFIER__CODE_JOUEUR_INEXISTANT;
        elseif ( CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_messagerie', $Code_messagerie) ) $code_erreur = ACCES_CODE_MESSAGERIE_REFUSE;
        elseif ( $Code_joueur!=0 && CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_joueur', $Code_joueur) ) $code_erreur = ACCES_CODE_JOUEUR_REFUSE;
        elseif ( !Hook_messagerie::autorisation_modification($Code_messagerie, $messagerie_Nom, $Code_joueur) ) $code_erreur = REFUS_MESSAGERIE__MODIFICATION_BLOQUEE;
        else
        {
            Hook_messagerie::data_controller($messagerie_Nom, $Code_joueur, $Code_messagerie);
            $messagerie = $this->mf_get_2( $Code_messagerie, array('autocompletion' => false, 'masquer_mdp' => false) );
            $mf_colonnes_a_modifier=[];
            $bool__messagerie_Nom = false; if ( $messagerie_Nom!=$messagerie['messagerie_Nom'] ) { Hook_messagerie::data_controller__messagerie_Nom($messagerie['messagerie_Nom'], $messagerie_Nom, $Code_messagerie); if ( $messagerie_Nom!=$messagerie['messagerie_Nom'] ) { $mf_colonnes_a_modifier[] = 'messagerie_Nom=' . format_sql('messagerie_Nom', $messagerie_Nom); $bool__messagerie_Nom = true; } }
            $bool__Code_joueur = false; if ( $Code_joueur!=0 && $Code_joueur!=$messagerie['Code_joueur'] ) { Hook_messagerie::data_controller__Code_joueur($messagerie['Code_joueur'], $Code_joueur, $Code_messagerie); if ( $Code_joueur!=0 && $Code_joueur!=$messagerie['Code_joueur'] ) { $mf_colonnes_a_modifier[] = 'Code_joueur=' . $Code_joueur; $bool__Code_joueur = true; } }
            if (count($mf_colonnes_a_modifier)>0) {
                $mf_signature = text_sql(Hook_messagerie::calcul_signature($messagerie_Nom, $Code_joueur));
                $mf_cle_unique = text_sql(Hook_messagerie::calcul_cle_unique($messagerie_Nom, $Code_joueur));
                $mf_colonnes_a_modifier[] = 'mf_signature=\'' . $mf_signature . '\'';
                $mf_colonnes_a_modifier[] = 'mf_cle_unique=\'' . $mf_cle_unique . '\'';
                $mf_colonnes_a_modifier[] = 'mf_date_modification=\'' . get_now() . '\'';
                $requete = 'UPDATE '.inst('messagerie').' SET ' . enumeration($mf_colonnes_a_modifier) . ' WHERE Code_messagerie = ' . $Code_messagerie . ';';
                $cle = md5($requete).salt(10);
                self::$cache_db->pause($cle);
                executer_requete_mysql( $requete , true);
                if ( requete_mysqli_affected_rows()==0 )
                {
                    $code_erreur = ERR_MESSAGERIE__MODIFIER__AUCUN_CHANGEMENT;
                    self::$cache_db->reprendre($cle);
                }
                else
                {
                    self::$cache_db->clear();
                    self::$cache_db->reprendre($cle);
                    Hook_messagerie::modifier($Code_messagerie, $bool__messagerie_Nom, $bool__Code_joueur);
                }
            }
            else
            {
                $code_erreur = ERR_MESSAGERIE__MODIFIER__AUCUN_CHANGEMENT;
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
        return array('code_erreur' => $code_erreur, 'callback' => ( $code_erreur == 0 ? Hook_messagerie::callback_put($Code_messagerie) : null ));
    }

    public function mf_modifier_2(array $lignes, ?bool $force=null) // array( $Code_messagerie => array('colonne1' => 'valeur1',  [...] ) )
    {
        if ( $force===null ) { $force=false; }
        $code_erreur = 0;
        foreach ( $lignes as $Code_messagerie => $colonnes )
        {
            if ( $code_erreur==0 )
            {
                $Code_messagerie = (int)round($Code_messagerie);
                $messagerie = $this->mf_get_2($Code_messagerie, array('autocompletion' => false));
                if (!$force)
                {
                    if (!self::$maj_droits_modifier_en_cours)
                    {
                        self::$maj_droits_modifier_en_cours = true;
                        Hook_messagerie::hook_actualiser_les_droits_modifier($Code_messagerie);
                        self::$maj_droits_modifier_en_cours = false;
                    }
                }
                $Code_joueur = ( isset($colonnes['Code_joueur']) && ( $force || mf_matrice_droits(['api_modifier_ref__messagerie__Code_joueur', 'messagerie__MODIFIER']) ) ? $colonnes['Code_joueur'] : (isset($messagerie['Code_joueur']) ? $messagerie['Code_joueur'] : 0 ));
                $messagerie_Nom = (string)( isset($colonnes['messagerie_Nom']) && ( $force || mf_matrice_droits(['api_modifier__messagerie_Nom', 'messagerie__MODIFIER']) ) ? $colonnes['messagerie_Nom'] : ( isset($messagerie['messagerie_Nom']) ? $messagerie['messagerie_Nom'] : '' ) );
                $retour = $this->mf_modifier($Code_messagerie, $messagerie_Nom, $Code_joueur, true);
                if ( $retour['code_erreur']!=0 && $retour['code_erreur'] != ERR_MESSAGERIE__MODIFIER__AUCUN_CHANGEMENT )
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

    public function mf_modifier_3(array $lignes) // array( $Code_messagerie => array('colonne1' => 'valeur1',  [...] ) )
    {
        $code_erreur = 0;
        $modifs = false;

        // transformation des lignes en colonnes
        $valeurs_en_colonnes=array();
        $indices_par_colonne=array();
        $liste_valeurs_indexees=array();
        foreach ( $lignes as $Code_messagerie => $colonnes )
        {
            foreach ($colonnes as $colonne => $valeur)
            {
                if ( $colonne=='messagerie_Nom' || $colonne=='Code_joueur' )
                {
                    $valeurs_en_colonnes[$colonne][$Code_messagerie]=$valeur;
                    $indices_par_colonne[$colonne][]=$Code_messagerie;
                    $liste_valeurs_indexees[$colonne][''.$valeur][]=$Code_messagerie;
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
                $modification_sql = $colonne . ' = CASE Code_messagerie';
                foreach ( $valeurs as $Code_messagerie => $valeur )
                {
                    $modification_sql.=' WHEN ' . $Code_messagerie . ' THEN ' . format_sql($colonne, $valeur);
                }
                $modification_sql.=' END';
                $perimetre = Sql_Format_Liste($indices_par_colonne[$colonne]);
                executer_requete_mysql('UPDATE ' . inst('messagerie') . ' SET ' . $modification_sql . ' WHERE Code_messagerie IN ' . $perimetre . ';', true);
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
                    executer_requete_mysql('UPDATE ' . inst('messagerie') . ' SET ' . $colonne . ' = ' . format_sql($colonne, $valeur) . ' WHERE Code_messagerie IN ' . $perimetre . ';', true);
                    if ( requete_mysqli_affected_rows()!=0 )
                    {
                        $modifs = true;
                    }
                }
            }
        }

        if ( ! $modifs && $code_erreur==0 )
        {
            $code_erreur = ERR_MESSAGERIE__MODIFIER_3__AUCUN_CHANGEMENT;
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

    public function mf_modifier_4( int $Code_joueur, array $data, ?array $options = null /* $options = array( 'cond_mysql' => array(), 'limit' => 0 ) */ ) // $data = array('colonne1' => 'valeur1', ... )
    {
        if ( $options===null ) { $force=[]; }
        $code_erreur = 0;
        $Code_joueur = round($Code_joueur);
        $mf_colonnes_a_modifier=[];
        if ( isset($data['messagerie_Nom']) ) { $mf_colonnes_a_modifier[] = 'messagerie_Nom = ' . format_sql('messagerie_Nom', $data['messagerie_Nom']); }
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

            $requete = 'UPDATE ' . inst('messagerie') . ' SET ' . enumeration($mf_colonnes_a_modifier) . " WHERE 1".( $Code_joueur!=0 ? " AND Code_joueur=$Code_joueur" : "" )."$argument_cond" . ( $limit>0 ? ' LIMIT ' . $limit : '' ) . ";";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_MESSAGERIE__MODIFIER_4__AUCUN_CHANGEMENT;
            }
            else
            {
                self::$cache_db->clear();
            }
            self::$cache_db->reprendre($cle);
        }
        return array('code_erreur' => $code_erreur);
    }

    public function mf_supprimer( int $Code_messagerie, ?bool $force=null )
    {
        if ( $force===null ) { $force=false; }
        $code_erreur = 0;
        $Code_messagerie = round($Code_messagerie);
        if (!$force)
        {
            if (!self::$maj_droits_supprimer_en_cours)
            {
                self::$maj_droits_supprimer_en_cours = true;
                Hook_messagerie::hook_actualiser_les_droits_supprimer($Code_messagerie);
                self::$maj_droits_supprimer_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['messagerie__SUPPRIMER']) ) $code_erreur = REFUS_MESSAGERIE__SUPPRIMER;
        elseif ( !$this->mf_tester_existance_Code_messagerie($Code_messagerie) ) $code_erreur = ERR_MESSAGERIE__SUPPRIMER_2__CODE_MESSAGERIE_INEXISTANT;
        elseif ( CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_messagerie', $Code_messagerie) ) $code_erreur = ACCES_CODE_MESSAGERIE_REFUSE;
        elseif ( !Hook_messagerie::autorisation_suppression($Code_messagerie) ) $code_erreur = REFUS_MESSAGERIE__SUPPRESSION_BLOQUEE;
        else
        {
            $copie__messagerie = $this->mf_get($Code_messagerie, array('autocompletion' => false));
            $this->supprimer_donnes_en_cascade("messagerie", array($Code_messagerie));
            $requete = "DELETE IGNORE FROM ".inst('messagerie')." WHERE Code_messagerie=$Code_messagerie;";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_MESSAGERIE__SUPPRIMER__REFUSEE;
                self::$cache_db->reprendre($cle);
            }
            else
            {
                self::$cache_db->clear();
                self::$cache_db->reprendre($cle);
                Hook_messagerie::supprimer($copie__messagerie);
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

    public function mf_supprimer_2(array $liste_Code_messagerie, ?bool $force=null)
    {
        if ( $force===null ) { $force=false; }
        $code_erreur=0;
        $copie__liste_messagerie = $this->mf_lister_2($liste_Code_messagerie, array('autocompletion' => false));
        $liste_Code_messagerie=array();
        foreach ( $copie__liste_messagerie as $copie__messagerie )
        {
            $Code_messagerie = $copie__messagerie['Code_messagerie'];
            if (!$force)
            {
                if (!self::$maj_droits_supprimer_en_cours)
                {
                    self::$maj_droits_supprimer_en_cours = true;
                    Hook_messagerie::hook_actualiser_les_droits_supprimer($Code_messagerie);
                    self::$maj_droits_supprimer_en_cours = false;
                }
            }
            if ( !$force && !mf_matrice_droits(['messagerie__SUPPRIMER']) ) $code_erreur = REFUS_MESSAGERIE__SUPPRIMER;
            elseif ( !Hook_messagerie::autorisation_suppression($Code_messagerie) ) $code_erreur = REFUS_MESSAGERIE__SUPPRESSION_BLOQUEE;
            {
                $liste_Code_messagerie[] = $Code_messagerie;
            }
        }
        if ( $code_erreur==0 && count($liste_Code_messagerie)>0 )
        {
            $this->supprimer_donnes_en_cascade("messagerie", $liste_Code_messagerie);
            $requete = "DELETE IGNORE FROM ".inst('messagerie')." WHERE Code_messagerie IN ".Sql_Format_Liste($liste_Code_messagerie).";";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_MESSAGERIE__SUPPRIMER_2__REFUSEE;
                self::$cache_db->reprendre($cle);
            }
            else
            {
                self::$cache_db->clear();
                self::$cache_db->reprendre($cle);
                Hook_messagerie::supprimer_2($copie__liste_messagerie);
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

    public function mf_supprimer_3(array $liste_Code_messagerie)
    {
        $code_erreur=0;
        if ( count($liste_Code_messagerie)>0 )
        {
            $this->supprimer_donnes_en_cascade("messagerie", $liste_Code_messagerie);
            $requete = "DELETE IGNORE FROM ".inst('messagerie')." WHERE Code_messagerie IN ".Sql_Format_Liste($liste_Code_messagerie).";";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_MESSAGERIE__SUPPRIMER_3__REFUSEE;
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
        if ( ! $contexte_parent && $mf_contexte['Code_messagerie']!=0 )
        {
            $messagerie = $this->mf_get( $mf_contexte['Code_messagerie'], $options);
            return array( $messagerie['Code_messagerie'] => $messagerie );
        }
        else
        {
            return $this->mf_lister(isset($est_charge['joueur']) ? $mf_contexte['Code_joueur'] : 0, $options);
        }
    }

    public function mf_lister(?int $Code_joueur=null, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cle = "messagerie__lister";
        $Code_joueur = round($Code_joueur);
        $cle.="_{$Code_joueur}";

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
            if ( isset($mf_tri_defaut_table['messagerie']) )
            {
                $options['tris'] = $mf_tri_defaut_table['messagerie'];
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
                    if ( strpos($argument_cond, 'messagerie_Nom')!==false ) { $liste_colonnes_a_indexer['messagerie_Nom'] = 'messagerie_Nom'; }
                }
                if ( isset($options['tris']) )
                {
                    if ( isset($options['tris']['messagerie_Nom']) ) { $liste_colonnes_a_indexer['messagerie_Nom'] = 'messagerie_Nom'; }
                }
                if ( count($liste_colonnes_a_indexer)>0 )
                {
                    if ( ! $mf_liste_requete_index = self::$cache_db->read('messagerie__index') )
                    {
                        $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('messagerie').'`;', false);
                        $mf_liste_requete_index = array();
                        while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                        {
                            $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                        }
                        mysqli_free_result($res_requete_index);
                        self::$cache_db->write('messagerie__index', $mf_liste_requete_index);
                    }
                    foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                    {
                        if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                    }
                    if ( count($liste_colonnes_a_indexer) > 0 )
                    {
                        self::$cache_db->pause('messagerie__index');
                        foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                        {
                            executer_requete_mysql('ALTER TABLE `'.inst('messagerie').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                        }
                        self::$cache_db->clear();
                        self::$cache_db->reprendre('messagerie__index');
                    }
                }

                $liste = array();
                $liste_messagerie_pas_a_jour = array();
                if ($toutes_colonnes)
                {
                    $colonnes='Code_messagerie, messagerie_Nom, Code_joueur';
                }
                else
                {
                    $colonnes='Code_messagerie, messagerie_Nom, Code_joueur';
                }
                $res_requete = executer_requete_mysql("SELECT $colonnes FROM ".inst('messagerie')." WHERE 1{$argument_cond}".( $Code_joueur!=0 ? " AND Code_joueur=$Code_joueur" : "" )."{$argument_tris}{$argument_limit};", false);
                while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
                {
                    mf_formatage_db_type_php($row_requete);
                    $liste[$row_requete['Code_messagerie']] = $row_requete;
                    if ( $maj && ! Hook_messagerie::est_a_jour( $row_requete ) )
                    {
                        $liste_messagerie_pas_a_jour[$row_requete['Code_messagerie']] = $row_requete;
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
                Hook_messagerie::mettre_a_jour( $liste_messagerie_pas_a_jour );
            }
        }

        foreach ($liste as $elem)
        {
            if ( $controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_messagerie', $elem['Code_messagerie']) )
            {
                unset($liste[$elem['Code_messagerie']]);
            }
            else
            {
                if (!self::$auto_completion && $autocompletion)
                {
                    self::$auto_completion = true;
                    Hook_messagerie::completion($liste[$elem['Code_messagerie']]);
                    self::$auto_completion = false;
                }
            }
        }

        return $liste;
    }

    public function mf_lister_2(array $liste_Code_messagerie, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        if ( count($liste_Code_messagerie)>0 )
        {
            $cle = "messagerie__mf_lister_2_".Sql_Format_Liste($liste_Code_messagerie);

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
                if ( isset($mf_tri_defaut_table['messagerie']) )
                {
                    $options['tris'] = $mf_tri_defaut_table['messagerie'];
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
                        if ( strpos($argument_cond, 'messagerie_Nom')!==false ) { $liste_colonnes_a_indexer['messagerie_Nom'] = 'messagerie_Nom'; }
                    }
                    if ( isset($options['tris']) )
                    {
                        if ( isset($options['tris']['messagerie_Nom']) ) { $liste_colonnes_a_indexer['messagerie_Nom'] = 'messagerie_Nom'; }
                    }
                    if ( count($liste_colonnes_a_indexer)>0 )
                    {
                        if ( ! $mf_liste_requete_index = self::$cache_db->read('messagerie__index') )
                        {
                            $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('messagerie').'`;', false);
                            $mf_liste_requete_index = array();
                            while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                            {
                                $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                            }
                            mysqli_free_result($res_requete_index);
                            self::$cache_db->write('messagerie__index', $mf_liste_requete_index);
                        }
                        foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                        {
                            if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                        }
                        if ( count($liste_colonnes_a_indexer) > 0 )
                        {
                            self::$cache_db->pause('messagerie__index');
                            foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                            {
                                executer_requete_mysql('ALTER TABLE `'.inst('messagerie').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                            }
                            self::$cache_db->clear();
                            self::$cache_db->reprendre('messagerie__index');
                        }
                    }

                    $liste = array();
                    $liste_messagerie_pas_a_jour = array();
                    if ($toutes_colonnes)
                    {
                        $colonnes='Code_messagerie, messagerie_Nom, Code_joueur';
                    }
                    else
                    {
                        $colonnes='Code_messagerie, messagerie_Nom, Code_joueur';
                    }
                    $res_requete = executer_requete_mysql("SELECT $colonnes FROM ".inst('messagerie')." WHERE 1{$argument_cond} AND Code_messagerie IN ".Sql_Format_Liste($liste_Code_messagerie)."{$argument_tris}{$argument_limit};", false);
                    while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
                    {
                        mf_formatage_db_type_php($row_requete);
                        $liste[$row_requete['Code_messagerie']] = $row_requete;
                        if ( $maj && ! Hook_messagerie::est_a_jour( $row_requete ) )
                        {
                            $liste_messagerie_pas_a_jour[$row_requete['Code_messagerie']] = $row_requete;
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
                    Hook_messagerie::mettre_a_jour( $liste_messagerie_pas_a_jour );
                }
            }

            foreach ($liste as $elem)
            {
                if ( $controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_messagerie', $elem['Code_messagerie']) )
                {
                    unset($liste[$elem['Code_messagerie']]);
                }
                else
                {
                    if (!self::$auto_completion && $autocompletion)
                    {
                        self::$auto_completion = true;
                        Hook_messagerie::completion($liste[$elem['Code_messagerie']]);
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

    public function mf_get(int $Code_messagerie, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $Code_messagerie = round($Code_messagerie);
        $retour = array();
        if ( ! CONTROLE_ACCES_DONNEES_DEFAUT || Hook_mf_systeme::controle_acces_donnees('Code_messagerie', $Code_messagerie) )
        {
            $cle = 'messagerie__get_'.$Code_messagerie;

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
                        $colonnes='Code_messagerie, messagerie_Nom, Code_joueur';
                    }
                    else
                    {
                        $colonnes='Code_messagerie, messagerie_Nom, Code_joueur';
                    }
                    $res_requete = executer_requete_mysql('SELECT ' . $colonnes . ' FROM ' . inst('messagerie') . ' WHERE Code_messagerie = ' . $Code_messagerie . ';', false);
                    if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
                    {
                        mf_formatage_db_type_php($row_requete);
                        $retour = $row_requete;
                        if ( $maj && ! Hook_messagerie::est_a_jour( $row_requete ) )
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
                    Hook_messagerie::mettre_a_jour( array( $row_requete['Code_messagerie'] => $row_requete ) );
                }
            }
            if ( isset( $retour['Code_messagerie'] ) )
            {
                if (!self::$auto_completion && $autocompletion)
                {
                    self::$auto_completion = true;
                    Hook_messagerie::completion($retour);
                    self::$auto_completion = false;
                }
            }
        }
        return $retour;
    }

    public function mf_get_last(?int $Code_joueur=null, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cle = "messagerie__get_last";
        $Code_joueur = round($Code_joueur);
        $cle.='_' . $Code_joueur;
        if ( ! $retour = self::$cache_db->read($cle) )
        {
            $Code_messagerie = 0;
            $res_requete = executer_requete_mysql('SELECT Code_messagerie FROM ' . inst('messagerie') . " WHERE 1".( $Code_joueur!=0 ? " AND Code_joueur=$Code_joueur" : "" )." ORDER BY mf_date_creation DESC, Code_messagerie DESC LIMIT 0 , 1;", false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $Code_messagerie = $row_requete['Code_messagerie'];
            }
            mysqli_free_result($res_requete);
            $retour = $this->mf_get($Code_messagerie, $options);
            self::$cache_db->write($cle, $retour);
        }
        return $retour;
    }

    public function mf_get_2(int $Code_messagerie, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $Code_messagerie = round($Code_messagerie);
        $retour = array();
        $cle = 'messagerie__get_'.$Code_messagerie;

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
                $colonnes='Code_messagerie, messagerie_Nom, Code_joueur';
            }
            else
            {
                $colonnes='Code_messagerie, messagerie_Nom, Code_joueur';
            }
            $res_requete = executer_requete_mysql('SELECT ' . $colonnes . " FROM ".inst('messagerie')." WHERE Code_messagerie = $Code_messagerie;", false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                mf_formatage_db_type_php($row_requete);
                $retour = $row_requete;
            }
            mysqli_free_result($res_requete);
            self::$cache_db->write($cle, $retour);
        }
        if ( isset( $retour['Code_messagerie'] ) )
        {
            if (!self::$auto_completion && $autocompletion)
            {
                self::$auto_completion = true;
                Hook_messagerie::completion($retour);
                self::$auto_completion = false;
            }
        }
        return $retour;
    }

    public function mf_prec_et_suiv( int $Code_messagerie, ?int $Code_joueur=null, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $Code_messagerie = round($Code_messagerie);
        $liste = $this->mf_lister($Code_joueur, $options);
        return prec_suiv($liste, $Code_messagerie);
    }

    public function mf_compter(?int $Code_joueur=null, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cle = 'messagerie__compter';
        $Code_joueur = round($Code_joueur);
        $cle.='_{'.$Code_joueur.'}';

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
                if ( strpos($argument_cond, 'messagerie_Nom')!==false ) { $liste_colonnes_a_indexer['messagerie_Nom'] = 'messagerie_Nom'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = self::$cache_db->read('messagerie__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('messagerie').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    self::$cache_db->write('messagerie__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    self::$cache_db->pause('messagerie__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('messagerie').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    self::$cache_db->clear();
                    self::$cache_db->reprendre('messagerie__index');
                }
            }

            $res_requete = executer_requete_mysql('SELECT count(Code_messagerie) as nb FROM ' . inst('messagerie')." WHERE 1{$argument_cond}".( $Code_joueur!=0 ? " AND Code_joueur=$Code_joueur" : "" ).";", false);
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
        $Code_joueur = isset($interface['Code_joueur']) ? round($interface['Code_joueur']) : 0;
        return $this->mf_compter( $Code_joueur, $options );
    }

    public function mf_liste_Code_messagerie(?int $Code_joueur=null, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ( $options===null ) { $options=[]; }
        return $this->get_liste_Code_messagerie($Code_joueur, $options);
    }

    public function mf_convertir_Code_messagerie_vers_Code_joueur( int $Code_messagerie )
    {
        return $this->Code_messagerie_vers_Code_joueur( $Code_messagerie );
    }

    public function mf_liste_Code_joueur_vers_liste_Code_messagerie( array $liste_Code_joueur, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ( $options===null ) { $options=[]; }
        return $this->liste_Code_joueur_vers_liste_Code_messagerie( $liste_Code_joueur, $options );
    }

    public function mf_liste_Code_messagerie_vers_liste_Code_joueur( array $liste_Code_messagerie, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ( $options===null ) { $options=[]; }
        return $this->messagerie__liste_Code_messagerie_vers_liste_Code_joueur( $liste_Code_messagerie, $options );
    }

    public function mf_get_liste_tables_enfants()
    {
        return $this->get_liste_tables_enfants( 'messagerie' );
    }

    public function mf_get_liste_tables_parents()
    {
        return array('Code_joueur');
    }

    public function mf_search_messagerie_Nom( string $messagerie_Nom, ?int $Code_joueur=null )
    {
        return $this->rechercher_messagerie_Nom( $messagerie_Nom, $Code_joueur );
    }

    public function mf_search__colonne( string $colonne_db, $recherche, ?int $Code_joueur=null )
    {
        switch ($colonne_db) {
            case 'messagerie_Nom': return $this->mf_search_messagerie_Nom( $recherche, $Code_joueur ); break;
        }
    }

    public function mf_get_next_id()
    {
        $res_requete = executer_requete_mysql('SELECT AUTO_INCREMENT as next_id FROM INFORMATION_SCHEMA.TABLES WHERE table_name = \'messagerie\';', false);
        $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC);
        mysqli_free_result($res_requete);
        return round($row_requete['next_id']);
    }

    public function mf_search(array $ligne) // array('colonne1' => 'valeur1',  [...] )
    {
        global $mf_initialisation;
        $Code_joueur = (int)(isset($ligne['Code_joueur'])?round($ligne['Code_joueur']):get_joueur_courant('Code_joueur'));
        $messagerie_Nom = (string)(isset($ligne['messagerie_Nom'])?$ligne['messagerie_Nom']:$mf_initialisation['messagerie_Nom']);
        Hook_messagerie::pre_controller($messagerie_Nom, $Code_joueur);
        $mf_cle_unique = Hook_messagerie::calcul_cle_unique($messagerie_Nom, $Code_joueur);
        $res_requete = executer_requete_mysql('SELECT Code_messagerie FROM ' . inst('messagerie') . ' WHERE mf_cle_unique = \''.$mf_cle_unique.'\'', false);
        if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
        {
            $r = round($row_requete['Code_messagerie']);
        }
        else
        {
            $r = false;
        }
        mysqli_free_result($res_requete);
        return $r;
    }

}
