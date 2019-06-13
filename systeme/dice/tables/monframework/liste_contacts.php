<?php

/*
    +------------------------------+
    |  NE PAS MODIFIER CE FICHIER  |
    +------------------------------+
*/

class liste_contacts_monframework extends entite_monframework
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
            include_once __DIR__ . '/../../erreurs/erreurs__liste_contacts.php';
            self::$initialisation = false;
            Hook_liste_contacts::initialisation();
            self::$cache_db = new Mf_Cachedb('liste_contacts');
        }
        if (!self::$actualisation_en_cours)
        {
            self::$actualisation_en_cours=true;
            Hook_liste_contacts::actualisation();
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

        if ( ! test_si_table_existe(inst('liste_contacts')) )
        {
            executer_requete_mysql('CREATE TABLE '.inst('liste_contacts').'(Code_liste_contacts INT AUTO_INCREMENT NOT NULL, PRIMARY KEY (Code_liste_contacts)) ENGINE=MyISAM;', true);
        }

        $liste_colonnes = lister_les_colonnes(inst('liste_contacts'));

        if ( isset($liste_colonnes['liste_contacts_Nom']) )
        {
            if ( typeMyql2Sql($liste_colonnes['liste_contacts_Nom']['Type'])!='VARCHAR' )
            {
                executer_requete_mysql('ALTER TABLE '.inst('liste_contacts').' CHANGE liste_contacts_Nom liste_contacts_Nom VARCHAR(255);', true);
            }
            unset($liste_colonnes['liste_contacts_Nom']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('liste_contacts').' ADD liste_contacts_Nom VARCHAR(255);', true);
            executer_requete_mysql('UPDATE '.inst('liste_contacts').' SET liste_contacts_Nom=' . format_sql('liste_contacts_Nom', $mf_initialisation['liste_contacts_Nom']) . ';', true);
        }

        if ( isset($liste_colonnes['Code_joueur']) )
        {
            unset($liste_colonnes['Code_joueur']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('liste_contacts').' ADD Code_joueur int NOT NULL;', true);
        }

        if ( isset($liste_colonnes['mf_signature']) )
        {
            unset($liste_colonnes['mf_signature']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('liste_contacts').' ADD mf_signature VARCHAR(255);', true);
            executer_requete_mysql('ALTER TABLE '.inst('liste_contacts').' ADD INDEX( mf_signature );', true);
        }

        if ( isset($liste_colonnes['mf_cle_unique']) )
        {
            unset($liste_colonnes['mf_cle_unique']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('liste_contacts').' ADD mf_cle_unique VARCHAR(255);', true);
            executer_requete_mysql('ALTER TABLE '.inst('liste_contacts').' ADD INDEX( mf_cle_unique );', true);
        }

        if ( isset($liste_colonnes['mf_date_creation']) )
        {
            unset($liste_colonnes['mf_date_creation']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('liste_contacts').' ADD mf_date_creation DATETIME;', true);
            executer_requete_mysql('ALTER TABLE '.inst('liste_contacts').' ADD INDEX( mf_date_creation );', true);
        }

        if ( isset($liste_colonnes['mf_date_modification']) )
        {
            unset($liste_colonnes['mf_date_modification']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('liste_contacts').' ADD mf_date_modification DATETIME;', true);
            executer_requete_mysql('ALTER TABLE '.inst('liste_contacts').' ADD INDEX( mf_date_modification );', true);
        }

        unset($liste_colonnes['Code_liste_contacts']);

        foreach ($liste_colonnes as $field => $value)
        {
            executer_requete_mysql('ALTER TABLE '.inst('liste_contacts').' DROP COLUMN '.$field.';', true);
        }

    }

    public function mf_ajouter($liste_contacts_Nom, $Code_joueur, $force=false)
    {
        $Code_liste_contacts = 0;
        $code_erreur = 0;
        $Code_joueur = round($Code_joueur);
        Hook_liste_contacts::pre_controller($liste_contacts_Nom, $Code_joueur);
        if (!$force)
        {
            if (!self::$maj_droits_ajouter_en_cours)
            {
                self::$maj_droits_ajouter_en_cours = true;
                Hook_liste_contacts::hook_actualiser_les_droits_ajouter($Code_joueur);
                self::$maj_droits_ajouter_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['liste_contacts__AJOUTER']) ) $code_erreur = REFUS_LISTE_CONTACTS__AJOUTER;
        elseif ( !$this->mf_tester_existance_Code_joueur($Code_joueur) ) $code_erreur = ERR_LISTE_CONTACTS__AJOUTER__CODE_JOUEUR_INEXISTANT;
        elseif ( CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_joueur', $Code_joueur) ) $code_erreur = ACCES_CODE_JOUEUR_REFUSE;
        elseif ( !Hook_liste_contacts::autorisation_ajout($liste_contacts_Nom, $Code_joueur) ) $code_erreur = REFUS_LISTE_CONTACTS__AJOUT_BLOQUEE;
        else
        {
            Hook_liste_contacts::data_controller($liste_contacts_Nom, $Code_joueur);
            $mf_signature = text_sql(Hook_liste_contacts::calcul_signature($liste_contacts_Nom, $Code_joueur));
            $mf_cle_unique = text_sql(Hook_liste_contacts::calcul_cle_unique($liste_contacts_Nom, $Code_joueur));
            $liste_contacts_Nom = text_sql($liste_contacts_Nom);
            $requete = "INSERT INTO ".inst('liste_contacts')." ( mf_signature, mf_cle_unique, mf_date_creation, mf_date_modification, liste_contacts_Nom, Code_joueur ) VALUES ( '$mf_signature', '$mf_cle_unique', '".get_now()."', '".get_now()."', '$liste_contacts_Nom', $Code_joueur );";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql($requete, true);
            $Code_liste_contacts = requete_mysql_insert_id();
            if ($Code_liste_contacts==0)
            {
                $code_erreur = ERR_LISTE_CONTACTS__AJOUTER__AJOUT_REFUSE;
                self::$cache_db->reprendre($cle);
            }
            else
            {
                self::$cache_db->clear();
                self::$cache_db->reprendre($cle);
                Hook_liste_contacts::ajouter( $Code_liste_contacts );
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
        return array('code_erreur' => $code_erreur, 'Code_liste_contacts' => $Code_liste_contacts, 'callback' => ( $code_erreur==0 ? Hook_liste_contacts::callback_post($Code_liste_contacts) : null ));
    }

    public function mf_creer($Code_joueur, $force=false)
    {
        global $mf_initialisation, $mf_droits_defaut;
        $mf_droits_defaut["liste_contacts__AJOUTER"] = $mf_droits_defaut["liste_contacts__CREER"];
        $liste_contacts_Nom = $mf_initialisation['liste_contacts_Nom'];
        return $this->mf_ajouter($liste_contacts_Nom, $Code_joueur, $force);
    }

    public function mf_ajouter_2($ligne, $force=false) // array('colonne1' => 'valeur1',  [...] )
    {
        global $mf_initialisation;
        $Code_joueur = (isset($ligne['Code_joueur'])?round($ligne['Code_joueur']):get_joueur_courant('Code_joueur'));
        $liste_contacts_Nom = (isset($ligne['liste_contacts_Nom'])?$ligne['liste_contacts_Nom']:$mf_initialisation['liste_contacts_Nom']);
        return $this->mf_ajouter($liste_contacts_Nom, $Code_joueur, $force);
    }

    public function mf_ajouter_3($lignes) // array( array( 'colonne1' => 'valeur1', 'colonne2' => 'valeur2',  [...] ), [...] )
    {
        global $mf_initialisation;
        $code_erreur = 0;
        $values = '';
        foreach ($lignes as $ligne)
        {
            $Code_joueur = (isset($ligne['Code_joueur'])?round($ligne['Code_joueur']):0);
            $liste_contacts_Nom = text_sql(isset($ligne['liste_contacts_Nom'])?$ligne['liste_contacts_Nom']:$mf_initialisation['liste_contacts_Nom']);
            if ($Code_joueur != 0)
            {
                $values.=($values!="" ? "," : "")."('$liste_contacts_Nom', $Code_joueur)";
            }
        }
        if ($values!='')
        {
            $requete = "INSERT INTO ".inst('liste_contacts')." ( liste_contacts_Nom, Code_joueur ) VALUES $values;";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            $n = requete_mysqli_affected_rows();
            if ($n < count($lignes))
            {
                $code_erreur = ERR_LISTE_CONTACTS__AJOUTER_3__ECHEC_AJOUT;
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

    public function mf_modifier($Code_liste_contacts, $liste_contacts_Nom, $Code_joueur=0, $force=false)
    {
        $code_erreur = 0;
        $Code_liste_contacts = round($Code_liste_contacts);
        $Code_joueur = round($Code_joueur);
        Hook_liste_contacts::pre_controller($liste_contacts_Nom, $Code_joueur, $Code_liste_contacts);
        if (!$force)
        {
            if (!self::$maj_droits_modifier_en_cours)
            {
                self::$maj_droits_modifier_en_cours = true;
                Hook_liste_contacts::hook_actualiser_les_droits_modifier($Code_liste_contacts);
                self::$maj_droits_modifier_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['liste_contacts__MODIFIER']) ) $code_erreur = REFUS_LISTE_CONTACTS__MODIFIER;
        elseif ( !$this->mf_tester_existance_Code_liste_contacts($Code_liste_contacts) ) $code_erreur = ERR_LISTE_CONTACTS__MODIFIER__CODE_LISTE_CONTACTS_INEXISTANT;
        elseif ( $Code_joueur!=0 && !$this->mf_tester_existance_Code_joueur($Code_joueur) ) $code_erreur = ERR_LISTE_CONTACTS__MODIFIER__CODE_JOUEUR_INEXISTANT;
        elseif ( CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_liste_contacts', $Code_liste_contacts) ) $code_erreur = ACCES_CODE_LISTE_CONTACTS_REFUSE;
        elseif ( $Code_joueur!=0 && CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_joueur', $Code_joueur) ) $code_erreur = ACCES_CODE_JOUEUR_REFUSE;
        elseif ( !Hook_liste_contacts::autorisation_modification($Code_liste_contacts, $liste_contacts_Nom, $Code_joueur) ) $code_erreur = REFUS_LISTE_CONTACTS__MODIFICATION_BLOQUEE;
        else
        {
            Hook_liste_contacts::data_controller($liste_contacts_Nom, $Code_joueur, $Code_liste_contacts);
            $liste_contacts = $this->mf_get_2( $Code_liste_contacts, array('autocompletion' => false, 'masquer_mdp' => false) );
            $mf_colonnes_a_modifier=[];
            $bool__liste_contacts_Nom = false; if ( $liste_contacts_Nom!=$liste_contacts['liste_contacts_Nom'] ) { Hook_liste_contacts::data_controller__liste_contacts_Nom($liste_contacts['liste_contacts_Nom'], $liste_contacts_Nom, $Code_liste_contacts); if ( $liste_contacts_Nom!=$liste_contacts['liste_contacts_Nom'] ) { $mf_colonnes_a_modifier[] = 'liste_contacts_Nom=' . format_sql('liste_contacts_Nom', $liste_contacts_Nom); $bool__liste_contacts_Nom = true; } }
            $bool__Code_joueur = false; if ( $Code_joueur!=0 && $Code_joueur!=$liste_contacts['Code_joueur'] ) { Hook_liste_contacts::data_controller__Code_joueur($liste_contacts['Code_joueur'], $Code_joueur, $Code_liste_contacts); if ( $Code_joueur!=0 && $Code_joueur!=$liste_contacts['Code_joueur'] ) { $mf_colonnes_a_modifier[] = 'Code_joueur=' . $Code_joueur; $bool__Code_joueur = true; } }
            if (count($mf_colonnes_a_modifier)>0) {
                $mf_signature = text_sql(Hook_liste_contacts::calcul_signature($liste_contacts_Nom, $Code_joueur));
                $mf_cle_unique = text_sql(Hook_liste_contacts::calcul_cle_unique($liste_contacts_Nom, $Code_joueur));
                $mf_colonnes_a_modifier[] = 'mf_signature=\'' . $mf_signature . '\'';
                $mf_colonnes_a_modifier[] = 'mf_cle_unique=\'' . $mf_cle_unique . '\'';
                $mf_colonnes_a_modifier[] = 'mf_date_modification=\'' . get_now() . '\'';
                $requete = 'UPDATE '.inst('liste_contacts').' SET ' . enumeration($mf_colonnes_a_modifier) . ' WHERE Code_liste_contacts = ' . $Code_liste_contacts . ';';
                $cle = md5($requete).salt(10);
                self::$cache_db->pause($cle);
                executer_requete_mysql( $requete , true);
                if ( requete_mysqli_affected_rows()==0 )
                {
                    $code_erreur = ERR_LISTE_CONTACTS__MODIFIER__AUCUN_CHANGEMENT;
                    self::$cache_db->reprendre($cle);
                }
                else
                {
                    self::$cache_db->clear();
                    self::$cache_db->reprendre($cle);
                    Hook_liste_contacts::modifier($Code_liste_contacts, $bool__liste_contacts_Nom, $bool__Code_joueur);
                }
            }
            else
            {
                $code_erreur = ERR_LISTE_CONTACTS__MODIFIER__AUCUN_CHANGEMENT;
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
        return array('code_erreur' => $code_erreur, 'callback' => ( $code_erreur == 0 ? Hook_liste_contacts::callback_put($Code_liste_contacts) : null ));
    }

    public function mf_modifier_2($lignes, $force=false) // array( $Code_liste_contacts => array('colonne1' => 'valeur1',  [...] ) )
    {
        $code_erreur = 0;
        foreach ( $lignes as $Code_liste_contacts => $colonnes )
        {
            if ( $code_erreur==0 )
            {
                $Code_liste_contacts = round($Code_liste_contacts);
                $liste_contacts = $this->mf_get_2($Code_liste_contacts, array('autocompletion' => false));
                if (!$force)
                {
                    if (!self::$maj_droits_modifier_en_cours)
                    {
                        self::$maj_droits_modifier_en_cours = true;
                        Hook_liste_contacts::hook_actualiser_les_droits_modifier($Code_liste_contacts);
                        self::$maj_droits_modifier_en_cours = false;
                    }
                }
                $Code_joueur = ( isset($colonnes['Code_joueur']) && ( $force || mf_matrice_droits(['api_modifier_ref__liste_contacts__Code_joueur', 'liste_contacts__MODIFIER']) ) ? $colonnes['Code_joueur'] : (isset($liste_contacts['Code_joueur']) ? $liste_contacts['Code_joueur'] : 0 ));
                $liste_contacts_Nom = ( isset($colonnes['liste_contacts_Nom']) && ( $force || mf_matrice_droits(['api_modifier__liste_contacts_Nom', 'liste_contacts__MODIFIER']) ) ? $colonnes['liste_contacts_Nom'] : ( isset($liste_contacts['liste_contacts_Nom']) ? $liste_contacts['liste_contacts_Nom'] : '' ) );
                $retour = $this->mf_modifier($Code_liste_contacts, $liste_contacts_Nom, $Code_joueur, true);
                if ( $retour['code_erreur']!=0 && $retour['code_erreur'] != ERR_LISTE_CONTACTS__MODIFIER__AUCUN_CHANGEMENT )
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

    public function mf_modifier_3($lignes) // array( $Code_liste_contacts => array('colonne1' => 'valeur1',  [...] ) )
    {
        $code_erreur = 0;
        $modifs = false;

        // transformation des lignes en colonnes
        $valeurs_en_colonnes=array();
        $indices_par_colonne=array();
        $liste_valeurs_indexees=array();
        foreach ( $lignes as $Code_liste_contacts => $colonnes )
        {
            foreach ($colonnes as $colonne => $valeur)
            {
                if ( $colonne=='liste_contacts_Nom' || $colonne=='Code_joueur' )
                {
                    $valeurs_en_colonnes[$colonne][$Code_liste_contacts]=$valeur;
                    $indices_par_colonne[$colonne][]=$Code_liste_contacts;
                    $liste_valeurs_indexees[$colonne][''.$valeur][]=$Code_liste_contacts;
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
                $modification_sql = $colonne . ' = CASE Code_liste_contacts';
                foreach ( $valeurs as $Code_liste_contacts => $valeur )
                {
                    $modification_sql.=' WHEN ' . $Code_liste_contacts . ' THEN ' . format_sql($colonne, $valeur);
                }
                $modification_sql.=' END';
                $perimetre = Sql_Format_Liste($indices_par_colonne[$colonne]);
                executer_requete_mysql('UPDATE ' . inst('liste_contacts') . ' SET ' . $modification_sql . ' WHERE Code_liste_contacts IN ' . $perimetre . ';', true);
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
                    executer_requete_mysql('UPDATE ' . inst('liste_contacts') . ' SET ' . $colonne . ' = ' . format_sql($colonne, $valeur) . ' WHERE Code_liste_contacts IN ' . $perimetre . ';', true);
                    if ( requete_mysqli_affected_rows()!=0 )
                    {
                        $modifs = true;
                    }
                }
            }
        }

        if ( ! $modifs && $code_erreur==0 )
        {
            $code_erreur = ERR_LISTE_CONTACTS__MODIFIER_3__AUCUN_CHANGEMENT;
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

    public function mf_modifier_4( $Code_joueur, $data, $options = array( 'cond_mysql' => array() ) ) // $data = array('colonne1' => 'valeur1', ... )
    {
        $code_erreur = 0;
        $Code_joueur = round($Code_joueur);
        $mf_colonnes_a_modifier=[];
        if ( isset($data['liste_contacts_Nom']) ) { $mf_colonnes_a_modifier[] = 'liste_contacts_Nom = ' . format_sql('liste_contacts_Nom', $data['liste_contacts_Nom']); }
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

            $requete = 'UPDATE ' . inst('liste_contacts') . ' SET ' . enumeration($mf_colonnes_a_modifier) . " WHERE 1".( $Code_joueur!=0 ? " AND Code_joueur=$Code_joueur" : "" )."$argument_cond;";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_LISTE_CONTACTS__MODIFIER_4__AUCUN_CHANGEMENT;
            }
            else
            {
                self::$cache_db->clear();
            }
            self::$cache_db->reprendre($cle);
        }
        return array('code_erreur' => $code_erreur);
    }

    public function mf_supprimer($Code_liste_contacts, $force=false)
    {
        $code_erreur = 0;
        $Code_liste_contacts = round($Code_liste_contacts);
        if (!$force)
        {
            if (!self::$maj_droits_supprimer_en_cours)
            {
                self::$maj_droits_supprimer_en_cours = true;
                Hook_liste_contacts::hook_actualiser_les_droits_supprimer($Code_liste_contacts);
                self::$maj_droits_supprimer_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['liste_contacts__SUPPRIMER']) ) $code_erreur = REFUS_LISTE_CONTACTS__SUPPRIMER;
        elseif ( !$this->mf_tester_existance_Code_liste_contacts($Code_liste_contacts) ) $code_erreur = ERR_LISTE_CONTACTS__SUPPRIMER_2__CODE_LISTE_CONTACTS_INEXISTANT;
        elseif ( CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_liste_contacts', $Code_liste_contacts) ) $code_erreur = ACCES_CODE_LISTE_CONTACTS_REFUSE;
        elseif ( !Hook_liste_contacts::autorisation_suppression($Code_liste_contacts) ) $code_erreur = REFUS_LISTE_CONTACTS__SUPPRESSION_BLOQUEE;
        else
        {
            $copie__liste_contacts = $this->mf_get($Code_liste_contacts, array('autocompletion' => false));
            $this->supprimer_donnes_en_cascade("liste_contacts", array($Code_liste_contacts));
            $requete = "DELETE IGNORE FROM ".inst('liste_contacts')." WHERE Code_liste_contacts=$Code_liste_contacts;";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_LISTE_CONTACTS__SUPPRIMER__REFUSEE;
                self::$cache_db->reprendre($cle);
            }
            else
            {
                self::$cache_db->clear();
                self::$cache_db->reprendre($cle);
                Hook_liste_contacts::supprimer($copie__liste_contacts);
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

    public function mf_supprimer_2($liste_Code_liste_contacts, $force=false)
    {
        $code_erreur=0;
        $copie__liste_liste_contacts = $this->mf_lister_2($liste_Code_liste_contacts, array('autocompletion' => false));
        $liste_Code_liste_contacts=array();
        foreach ( $copie__liste_liste_contacts as $copie__liste_contacts )
        {
            $Code_liste_contacts = $copie__liste_contacts['Code_liste_contacts'];
            if (!$force)
            {
                if (!self::$maj_droits_supprimer_en_cours)
                {
                    self::$maj_droits_supprimer_en_cours = true;
                    Hook_liste_contacts::hook_actualiser_les_droits_supprimer($Code_liste_contacts);
                    self::$maj_droits_supprimer_en_cours = false;
                }
            }
            if ( !$force && !mf_matrice_droits(['liste_contacts__SUPPRIMER']) ) $code_erreur = REFUS_LISTE_CONTACTS__SUPPRIMER;
            elseif ( !Hook_liste_contacts::autorisation_suppression($Code_liste_contacts) ) $code_erreur = REFUS_LISTE_CONTACTS__SUPPRESSION_BLOQUEE;
            {
                $liste_Code_liste_contacts[] = $Code_liste_contacts;
            }
        }
        if ( $code_erreur==0 && count($liste_Code_liste_contacts)>0 )
        {
            $this->supprimer_donnes_en_cascade("liste_contacts", $liste_Code_liste_contacts);
            $requete = "DELETE IGNORE FROM ".inst('liste_contacts')." WHERE Code_liste_contacts IN ".Sql_Format_Liste($liste_Code_liste_contacts).";";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_LISTE_CONTACTS__SUPPRIMER_2__REFUSEE;
                self::$cache_db->reprendre($cle);
            }
            else
            {
                self::$cache_db->clear();
                self::$cache_db->reprendre($cle);
                Hook_liste_contacts::supprimer_2($copie__liste_liste_contacts);
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

    public function mf_supprimer_3($liste_Code_liste_contacts)
    {
        $code_erreur=0;
        if ( count($liste_Code_liste_contacts)>0 )
        {
            $this->supprimer_donnes_en_cascade("liste_contacts", $liste_Code_liste_contacts);
            $requete = "DELETE IGNORE FROM ".inst('liste_contacts')." WHERE Code_liste_contacts IN ".Sql_Format_Liste($liste_Code_liste_contacts).";";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_LISTE_CONTACTS__SUPPRIMER_3__REFUSEE;
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
        if ( ! $contexte_parent && $mf_contexte['Code_liste_contacts']!=0 )
        {
            $liste_contacts = $this->mf_get( $mf_contexte['Code_liste_contacts'], $options);
            return array( $liste_contacts['Code_liste_contacts'] => $liste_contacts );
        }
        else
        {
            return $this->mf_lister(isset($est_charge['joueur']) ? $mf_contexte['Code_joueur'] : 0, $options);
        }
    }

    public function mf_lister($Code_joueur=0, $options = array( 'cond_mysql' => array(), 'tris' => array(), 'limit' => array(), 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ))
    {
        $cle = "liste_contacts__lister";
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
            if ( isset($mf_tri_defaut_table['liste_contacts']) )
            {
                $options['tris'] = $mf_tri_defaut_table['liste_contacts'];
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
                    if ( strpos($argument_cond, 'liste_contacts_Nom')!==false ) { $liste_colonnes_a_indexer['liste_contacts_Nom'] = 'liste_contacts_Nom'; }
                }
                if ( isset($options['tris']) )
                {
                    if ( isset($options['tris']['liste_contacts_Nom']) ) { $liste_colonnes_a_indexer['liste_contacts_Nom'] = 'liste_contacts_Nom'; }
                }
                if ( count($liste_colonnes_a_indexer)>0 )
                {
                    if ( ! $mf_liste_requete_index = self::$cache_db->read('liste_contacts__index') )
                    {
                        $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('liste_contacts').'`;', false);
                        $mf_liste_requete_index = array();
                        while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                        {
                            $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                        }
                        mysqli_free_result($res_requete_index);
                        self::$cache_db->write('liste_contacts__index', $mf_liste_requete_index);
                    }
                    foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                    {
                        if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                    }
                    if ( count($liste_colonnes_a_indexer) > 0 )
                    {
                        self::$cache_db->pause('liste_contacts__index');
                        foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                        {
                            executer_requete_mysql('ALTER TABLE `'.inst('liste_contacts').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                        }
                        self::$cache_db->clear();
                        self::$cache_db->reprendre('liste_contacts__index');
                    }
                }

                $liste = array();
                $liste_liste_contacts_pas_a_jour = array();
                if ($toutes_colonnes)
                {
                    $colonnes='Code_liste_contacts, liste_contacts_Nom, Code_joueur';
                }
                else
                {
                    $colonnes='Code_liste_contacts, liste_contacts_Nom, Code_joueur';
                }
                $res_requete = executer_requete_mysql("SELECT $colonnes FROM ".inst('liste_contacts')." WHERE 1{$argument_cond}".( $Code_joueur!=0 ? " AND Code_joueur=$Code_joueur" : "" )."{$argument_tris}{$argument_limit};", false);
                while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
                {
                    $liste[$row_requete['Code_liste_contacts']]=$row_requete;
                    if ( $maj && ! Hook_liste_contacts::est_a_jour( $row_requete ) )
                    {
                        $liste_liste_contacts_pas_a_jour[$row_requete['Code_liste_contacts']] = $row_requete;
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
                Hook_liste_contacts::mettre_a_jour( $liste_liste_contacts_pas_a_jour );
            }
        }

        foreach ($liste as $elem)
        {
            if ( $controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_liste_contacts', $elem['Code_liste_contacts']) )
            {
                unset($liste[$elem['Code_liste_contacts']]);
            }
            else
            {
                if (!self::$auto_completion && $autocompletion)
                {
                    self::$auto_completion = true;
                    Hook_liste_contacts::completion($liste[$elem['Code_liste_contacts']]);
                    self::$auto_completion = false;
                }
            }
        }

        return $liste;
    }

    public function mf_lister_2($liste_Code_liste_contacts, $options = array( 'cond_mysql' => array(), 'tris' => array(), 'limit' => array(), 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ))
    {
        if ( count($liste_Code_liste_contacts)>0 )
        {
            $cle = "liste_contacts__mf_lister_2_".Sql_Format_Liste($liste_Code_liste_contacts);

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
                if ( isset($mf_tri_defaut_table['liste_contacts']) )
                {
                    $options['tris'] = $mf_tri_defaut_table['liste_contacts'];
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
                        if ( strpos($argument_cond, 'liste_contacts_Nom')!==false ) { $liste_colonnes_a_indexer['liste_contacts_Nom'] = 'liste_contacts_Nom'; }
                    }
                    if ( isset($options['tris']) )
                    {
                        if ( isset($options['tris']['liste_contacts_Nom']) ) { $liste_colonnes_a_indexer['liste_contacts_Nom'] = 'liste_contacts_Nom'; }
                    }
                    if ( count($liste_colonnes_a_indexer)>0 )
                    {
                        if ( ! $mf_liste_requete_index = self::$cache_db->read('liste_contacts__index') )
                        {
                            $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('liste_contacts').'`;', false);
                            $mf_liste_requete_index = array();
                            while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                            {
                                $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                            }
                            mysqli_free_result($res_requete_index);
                            self::$cache_db->write('liste_contacts__index', $mf_liste_requete_index);
                        }
                        foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                        {
                            if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                        }
                        if ( count($liste_colonnes_a_indexer) > 0 )
                        {
                            self::$cache_db->pause('liste_contacts__index');
                            foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                            {
                                executer_requete_mysql('ALTER TABLE `'.inst('liste_contacts').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                            }
                            self::$cache_db->clear();
                            self::$cache_db->reprendre('liste_contacts__index');
                        }
                    }

                    $liste = array();
                    $liste_liste_contacts_pas_a_jour = array();
                    if ($toutes_colonnes)
                    {
                        $colonnes='Code_liste_contacts, liste_contacts_Nom, Code_joueur';
                    }
                    else
                    {
                        $colonnes='Code_liste_contacts, liste_contacts_Nom, Code_joueur';
                    }
                    $res_requete = executer_requete_mysql("SELECT $colonnes FROM ".inst('liste_contacts')." WHERE 1{$argument_cond} AND Code_liste_contacts IN ".Sql_Format_Liste($liste_Code_liste_contacts)."{$argument_tris}{$argument_limit};", false);
                    while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
                    {
                        $liste[$row_requete['Code_liste_contacts']]=$row_requete;
                        if ( $maj && ! Hook_liste_contacts::est_a_jour( $row_requete ) )
                        {
                            $liste_liste_contacts_pas_a_jour[$row_requete['Code_liste_contacts']] = $row_requete;
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
                    Hook_liste_contacts::mettre_a_jour( $liste_liste_contacts_pas_a_jour );
                }
            }

            foreach ($liste as $elem)
            {
                if ( $controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_liste_contacts', $elem['Code_liste_contacts']) )
                {
                    unset($liste[$elem['Code_liste_contacts']]);
                }
                else
                {
                    if (!self::$auto_completion && $autocompletion)
                    {
                        self::$auto_completion = true;
                        Hook_liste_contacts::completion($liste[$elem['Code_liste_contacts']]);
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

    public function mf_get($Code_liste_contacts, $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ])
    {
        $Code_liste_contacts = round($Code_liste_contacts);
        $retour = array();
        if ( ! CONTROLE_ACCES_DONNEES_DEFAUT || Hook_mf_systeme::controle_acces_donnees('Code_liste_contacts', $Code_liste_contacts) )
        {
            $cle = 'liste_contacts__get_'.$Code_liste_contacts;

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
                        $colonnes='Code_liste_contacts, liste_contacts_Nom, Code_joueur';
                    }
                    else
                    {
                        $colonnes='Code_liste_contacts, liste_contacts_Nom, Code_joueur';
                    }
                    $res_requete = executer_requete_mysql('SELECT ' . $colonnes . ' FROM ' . inst('liste_contacts') . ' WHERE Code_liste_contacts = ' . $Code_liste_contacts . ';', false);
                    if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
                    {
                        $retour=$row_requete;
                        if ( $maj && ! Hook_liste_contacts::est_a_jour( $row_requete ) )
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
                    Hook_liste_contacts::mettre_a_jour( array( $row_requete['Code_liste_contacts'] => $row_requete ) );
                }
            }
            if ( isset( $retour['Code_liste_contacts'] ) )
            {
                if (!self::$auto_completion && $autocompletion)
                {
                    self::$auto_completion = true;
                    Hook_liste_contacts::completion($retour);
                    self::$auto_completion = false;
                }
            }
        }
        return $retour;
    }

    public function mf_get_last($Code_joueur=0, $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ])
    {
        $cle = "liste_contacts__get_last";
        $Code_joueur = round($Code_joueur);
        $cle.='_' . $Code_joueur;
        if ( ! $retour = self::$cache_db->read($cle) )
        {
            $Code_liste_contacts = 0;
            $res_requete = executer_requete_mysql('SELECT Code_liste_contacts FROM ' . inst('liste_contacts') . " WHERE 1".( $Code_joueur!=0 ? " AND Code_joueur=$Code_joueur" : "" )." ORDER BY mf_date_creation DESC, Code_liste_contacts DESC LIMIT 0 , 1;", false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $Code_liste_contacts = $row_requete['Code_liste_contacts'];
            }
            mysqli_free_result($res_requete);
            $retour = $this->mf_get($Code_liste_contacts, $options);
            self::$cache_db->write($cle, $retour);
        }
        return $retour;
    }

    public function mf_get_2($Code_liste_contacts, $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ])
    {
        $Code_liste_contacts = round($Code_liste_contacts);
        $retour = array();
        $cle = 'liste_contacts__get_'.$Code_liste_contacts;

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
                $colonnes='Code_liste_contacts, liste_contacts_Nom, Code_joueur';
            }
            else
            {
                $colonnes='Code_liste_contacts, liste_contacts_Nom, Code_joueur';
            }
            $res_requete = executer_requete_mysql('SELECT ' . $colonnes . " FROM ".inst('liste_contacts')." WHERE Code_liste_contacts = $Code_liste_contacts;", false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $retour=$row_requete;
            }
            mysqli_free_result($res_requete);
            self::$cache_db->write($cle, $retour);
        }
        if ( isset( $retour['Code_liste_contacts'] ) )
        {
            if (!self::$auto_completion && $autocompletion)
            {
                self::$auto_completion = true;
                Hook_liste_contacts::completion($retour);
                self::$auto_completion = false;
            }
        }
        return $retour;
    }

    public function mf_prec_et_suiv($Code_liste_contacts, $Code_joueur=0, $options = array( 'cond_mysql' => array(), 'tris' => array(), 'limit' => array(), 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ))
    {
        $Code_liste_contacts = round($Code_liste_contacts);
        $liste = $this->mf_lister($Code_joueur, $options);
        return prec_suiv($liste, $Code_liste_contacts);
    }

    public function mf_compter($Code_joueur=0, $options = array( 'cond_mysql' => array() ))
    {
        $cle = 'liste_contacts__compter';
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
                if ( strpos($argument_cond, 'liste_contacts_Nom')!==false ) { $liste_colonnes_a_indexer['liste_contacts_Nom'] = 'liste_contacts_Nom'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = self::$cache_db->read('liste_contacts__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('liste_contacts').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    self::$cache_db->write('liste_contacts__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    self::$cache_db->pause('liste_contacts__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('liste_contacts').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    self::$cache_db->clear();
                    self::$cache_db->reprendre('liste_contacts__index');
                }
            }

            $res_requete = executer_requete_mysql("SELECT count(Code_liste_contacts) as nb FROM ".inst('liste_contacts')." WHERE 1{$argument_cond}".( $Code_joueur!=0 ? " AND Code_joueur=$Code_joueur" : "" ).";", false);
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
        return $this->mf_compter( $Code_joueur, $options );
    }

    public function mf_liste_Code_liste_contacts($Code_joueur=0, $options = array( 'cond_mysql' => array() ))
    {
        return $this->get_liste_Code_liste_contacts($Code_joueur, $options);
    }

    public function mf_convertir_Code_liste_contacts_vers_Code_joueur( $Code_liste_contacts )
    {
        return $this->Code_liste_contacts_vers_Code_joueur( $Code_liste_contacts );
    }

    public function mf_liste_Code_joueur_vers_liste_Code_liste_contacts( $liste_Code_joueur, $options = array( 'cond_mysql' => array() ) )
    {
        return $this->liste_Code_joueur_vers_liste_Code_liste_contacts( $liste_Code_joueur, $options );
    }

    public function mf_liste_Code_liste_contacts_vers_liste_Code_joueur( $liste_Code_liste_contacts, $options = array( 'cond_mysql' => array() ) )
    {
        return $this->liste_contacts__liste_Code_liste_contacts_vers_liste_Code_joueur( $liste_Code_liste_contacts, $options );
    }

    public function mf_get_liste_tables_enfants()
    {
        return $this->get_liste_tables_enfants( 'liste_contacts' );
    }

    public function mf_get_liste_tables_parents()
    {
        return array('Code_joueur');
    }

    public function mf_search_liste_contacts_Nom( $liste_contacts_Nom, $Code_joueur=0 )
    {
        return $this->rechercher_liste_contacts_Nom( $liste_contacts_Nom, $Code_joueur );
    }

    public function mf_search__colonne( $colonne_db, $recherche, $Code_joueur=0 )
    {
        switch ($colonne_db) {
            case 'liste_contacts_Nom': return $this->mf_search_liste_contacts_Nom( $recherche, $Code_joueur ); break;
        }
    }

    public function mf_get_next_id()
    {
        $res_requete = executer_requete_mysql('SELECT AUTO_INCREMENT as next_id FROM INFORMATION_SCHEMA.TABLES WHERE table_name = \'liste_contacts\';', false);
        $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC);
        mysqli_free_result($res_requete);
        return round($row_requete['next_id']);
    }

    public function mf_search($ligne) // array('colonne1' => 'valeur1',  [...] )
    {
        global $mf_initialisation;
        $Code_joueur = (isset($ligne['Code_joueur'])?round($ligne['Code_joueur']):get_joueur_courant('Code_joueur'));
        $liste_contacts_Nom = (isset($ligne['liste_contacts_Nom'])?$ligne['liste_contacts_Nom']:$mf_initialisation['liste_contacts_Nom']);
        Hook_liste_contacts::pre_controller($liste_contacts_Nom, $Code_joueur);
        $mf_cle_unique = Hook_liste_contacts::calcul_cle_unique($liste_contacts_Nom, $Code_joueur);
        $res_requete = executer_requete_mysql('SELECT Code_liste_contacts FROM ' . inst('liste_contacts') . ' WHERE mf_cle_unique = \''.$mf_cle_unique.'\'', false);
        if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
        {
            $r = round($row_requete['Code_liste_contacts']);
        }
        else
        {
            $r = false;
        }
        mysqli_free_result($res_requete);
        return $r;
    }

}
