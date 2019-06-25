<?php

/*
    +------------------------------+
    |  NE PAS MODIFIER CE FICHIER  |
    +------------------------------+
*/

class a_candidature_joueur_groupe_monframework extends entite_monframework
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
            include_once __DIR__ . '/../../erreurs/erreurs__a_candidature_joueur_groupe.php';
            self::$initialisation = false;
            Hook_a_candidature_joueur_groupe::initialisation();
            self::$cache_db = new Mf_Cachedb('a_candidature_joueur_groupe');
        }
        if (!self::$actualisation_en_cours)
        {
            self::$actualisation_en_cours=true;
            Hook_a_candidature_joueur_groupe::actualisation();
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

        if ( ! test_si_table_existe(inst('a_candidature_joueur_groupe')) )
        {
            executer_requete_mysql('CREATE TABLE '.inst('a_candidature_joueur_groupe').' (Code_joueur INT NOT NULL, Code_groupe INT NOT NULL, PRIMARY KEY (Code_joueur, Code_groupe)) ENGINE=MyISAM;', true);
        }

        $liste_colonnes = lister_les_colonnes(inst('a_candidature_joueur_groupe'));

        if ( isset($liste_colonnes['a_candidature_joueur_groupe_Message']) )
        {
            if ( typeMyql2Sql($liste_colonnes['a_candidature_joueur_groupe_Message']['Type'])!='TEXT' )
            {
                executer_requete_mysql('ALTER TABLE '.inst('a_candidature_joueur_groupe').' CHANGE a_candidature_joueur_groupe_Message a_candidature_joueur_groupe_Message TEXT;', true);
            }
            unset($liste_colonnes['a_candidature_joueur_groupe_Message']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('a_candidature_joueur_groupe').' ADD a_candidature_joueur_groupe_Message TEXT;', true);
            executer_requete_mysql('UPDATE '.inst('a_candidature_joueur_groupe').' SET a_candidature_joueur_groupe_Message=' . format_sql('a_candidature_joueur_groupe_Message', $mf_initialisation['a_candidature_joueur_groupe_Message']) . ';', true);
        }

        if ( isset($liste_colonnes['a_candidature_joueur_groupe_Date_envoi']) )
        {
            if ( typeMyql2Sql($liste_colonnes['a_candidature_joueur_groupe_Date_envoi']['Type'])!='DATETIME' )
            {
                executer_requete_mysql('ALTER TABLE '.inst('a_candidature_joueur_groupe').' CHANGE a_candidature_joueur_groupe_Date_envoi a_candidature_joueur_groupe_Date_envoi DATETIME;', true);
            }
            unset($liste_colonnes['a_candidature_joueur_groupe_Date_envoi']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('a_candidature_joueur_groupe').' ADD a_candidature_joueur_groupe_Date_envoi DATETIME;', true);
            executer_requete_mysql('UPDATE '.inst('a_candidature_joueur_groupe').' SET a_candidature_joueur_groupe_Date_envoi=' . format_sql('a_candidature_joueur_groupe_Date_envoi', $mf_initialisation['a_candidature_joueur_groupe_Date_envoi']) . ';', true);
        }

        unset($liste_colonnes['Code_joueur']);
        unset($liste_colonnes['Code_groupe']);

        foreach ($liste_colonnes as $field => $value)
        {
            executer_requete_mysql('ALTER TABLE '.inst('a_candidature_joueur_groupe').' DROP COLUMN '.$field.';', true);
        }

    }

    public function mfi_ajouter_auto(array $interface)
    {
        if (isset($interface['Code_joueur'])) { $liste_Code_joueur = array($interface['Code_joueur']); }
        elseif (isset($interface['liste_Code_joueur'])) { $liste_Code_joueur = $interface['liste_Code_joueur']; }
        else { $liste_Code_joueur = $this->get_liste_Code_joueur(); }
        if (isset($interface['Code_groupe'])) { $liste_Code_groupe = array($interface['Code_groupe']); }
        elseif (isset($interface['liste_Code_groupe'])) { $liste_Code_groupe = $interface['liste_Code_groupe']; }
        else { $liste_Code_groupe = $this->get_liste_Code_groupe(); }
        $liste_a_candidature_joueur_groupe = array();
        foreach ($liste_Code_joueur as $Code_joueur)
        {
            foreach ($liste_Code_groupe as $Code_groupe)
            {
                $liste_a_candidature_joueur_groupe[] = array('Code_joueur'=>$Code_joueur,'Code_groupe'=>$Code_groupe);
            }
        }
        if (isset($interface['a_candidature_joueur_groupe_Message'])) { foreach ($liste_a_candidature_joueur_groupe as &$a_candidature_joueur_groupe) { $a_candidature_joueur_groupe['a_candidature_joueur_groupe_Message'] = $interface['a_candidature_joueur_groupe_Message']; } unset($a_candidature_joueur_groupe); }
        if (isset($interface['a_candidature_joueur_groupe_Date_envoi'])) { foreach ($liste_a_candidature_joueur_groupe as &$a_candidature_joueur_groupe) { $a_candidature_joueur_groupe['a_candidature_joueur_groupe_Date_envoi'] = $interface['a_candidature_joueur_groupe_Date_envoi']; } unset($a_candidature_joueur_groupe); }
        return $this->mf_ajouter_3($liste_a_candidature_joueur_groupe);
    }

    public function mfi_supprimer_auto(array $interface)
    {
        if (isset($interface['Code_joueur'])) { $liste_Code_joueur = array($interface['Code_joueur']); }
        elseif (isset($interface['liste_Code_joueur'])) { $liste_Code_joueur = $interface['liste_Code_joueur']; }
        else { $liste_Code_joueur = $this->get_liste_Code_joueur(); }
        if (isset($interface['Code_groupe'])) { $liste_Code_groupe = array($interface['Code_groupe']); }
        elseif (isset($interface['liste_Code_groupe'])) { $liste_Code_groupe = $interface['liste_Code_groupe']; }
        else { $liste_Code_groupe = $this->get_liste_Code_groupe(); }
        foreach ($liste_Code_joueur as $Code_joueur)
        {
            foreach ($liste_Code_groupe as $Code_groupe)
            {
                $this->mf_supprimer_2($Code_joueur, $Code_groupe);
            }
        }
    }

    public function mf_ajouter(int $Code_joueur, int $Code_groupe, string $a_candidature_joueur_groupe_Message, string $a_candidature_joueur_groupe_Date_envoi, ?bool $force=null)
    {
        if ( $force===null ) { $force=false; }
        $code_erreur = 0;
        $Code_joueur = round($Code_joueur);
        $Code_groupe = round($Code_groupe);
        $a_candidature_joueur_groupe_Date_envoi = format_datetime($a_candidature_joueur_groupe_Date_envoi);
        Hook_a_candidature_joueur_groupe::pre_controller($a_candidature_joueur_groupe_Message, $a_candidature_joueur_groupe_Date_envoi, $Code_joueur, $Code_groupe);
        if (!$force)
        {
            if (!self::$maj_droits_ajouter_en_cours)
            {
                self::$maj_droits_ajouter_en_cours = true;
                Hook_a_candidature_joueur_groupe::hook_actualiser_les_droits_ajouter($Code_joueur, $Code_groupe);
                self::$maj_droits_ajouter_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['a_candidature_joueur_groupe__AJOUTER']) ) $code_erreur = REFUS_A_CANDIDATURE_JOUEUR_GROUPE__AJOUTER;
        elseif ( !$this->mf_tester_existance_Code_joueur($Code_joueur) ) $code_erreur = ERR_A_CANDIDATURE_JOUEUR_GROUPE__AJOUTER__CODE_JOUEUR_INEXISTANT;
        elseif ( !$this->mf_tester_existance_Code_groupe($Code_groupe) ) $code_erreur = ERR_A_CANDIDATURE_JOUEUR_GROUPE__AJOUTER__CODE_GROUPE_INEXISTANT;
        elseif ( $this->mf_tester_existance_a_candidature_joueur_groupe( $Code_joueur, $Code_groupe ) ) $code_erreur = ERR_A_CANDIDATURE_JOUEUR_GROUPE__AJOUTER__DOUBLON;
        elseif ( CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_joueur', $Code_joueur) ) $code_erreur = ACCES_CODE_JOUEUR_REFUSE;
        elseif ( CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_groupe', $Code_groupe) ) $code_erreur = ACCES_CODE_GROUPE_REFUSE;
        elseif ( !Hook_a_candidature_joueur_groupe::autorisation_ajout($a_candidature_joueur_groupe_Message, $a_candidature_joueur_groupe_Date_envoi, $Code_joueur, $Code_groupe) ) $code_erreur = REFUS_A_CANDIDATURE_JOUEUR_GROUPE__AJOUT_BLOQUEE;
        else
        {
            Hook_a_candidature_joueur_groupe::data_controller($a_candidature_joueur_groupe_Message, $a_candidature_joueur_groupe_Date_envoi, $Code_joueur, $Code_groupe);
            $a_candidature_joueur_groupe_Message = text_sql($a_candidature_joueur_groupe_Message);
            $a_candidature_joueur_groupe_Date_envoi = format_datetime($a_candidature_joueur_groupe_Date_envoi);
            $requete = 'INSERT INTO '.inst('a_candidature_joueur_groupe')." ( a_candidature_joueur_groupe_Message, a_candidature_joueur_groupe_Date_envoi, Code_joueur, Code_groupe ) VALUES ( '$a_candidature_joueur_groupe_Message', ".( $a_candidature_joueur_groupe_Date_envoi!='' ? "'$a_candidature_joueur_groupe_Date_envoi'" : 'NULL' ).", $Code_joueur, $Code_groupe );";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql($requete, true);
            $n = requete_mysqli_affected_rows();
            if ($n==0)
            {
                $code_erreur = ERR_A_CANDIDATURE_JOUEUR_GROUPE__AJOUTER__REFUSE;
                self::$cache_db->reprendre($cle);
            }
            else
            {
                self::$cache_db->clear();
                self::$cache_db->reprendre($cle);
                Hook_a_candidature_joueur_groupe::ajouter($Code_joueur, $Code_groupe);
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
        return array('code_erreur' => $code_erreur, 'callback' => ( $code_erreur==0 ? Hook_a_candidature_joueur_groupe::callback_post($Code_joueur, $Code_groupe) : null ));
    }

    public function mf_ajouter_2(array $ligne, ?bool $force=null) // array('colonne1' => 'valeur1',  [...] )
    {
        if ( $force===null ) { $force=false; }
        global $mf_initialisation;
        $Code_joueur = (int)(isset($ligne['Code_joueur'])?round($ligne['Code_joueur']):get_joueur_courant('Code_joueur'));
        $Code_groupe = (int)(isset($ligne['Code_groupe'])?round($ligne['Code_groupe']):0);
        $a_candidature_joueur_groupe_Message = (string)(isset($ligne['a_candidature_joueur_groupe_Message'])?$ligne['a_candidature_joueur_groupe_Message']:$mf_initialisation['a_candidature_joueur_groupe_Message']);
        $a_candidature_joueur_groupe_Date_envoi = (string)(isset($ligne['a_candidature_joueur_groupe_Date_envoi'])?$ligne['a_candidature_joueur_groupe_Date_envoi']:$mf_initialisation['a_candidature_joueur_groupe_Date_envoi']);
        return $this->mf_ajouter($Code_joueur, $Code_groupe, $a_candidature_joueur_groupe_Message, $a_candidature_joueur_groupe_Date_envoi, $force);
    }

    public function mf_ajouter_3(array $lignes) // array( array( 'colonne1' => 'valeur1', 'colonne2' => 'valeur2',  [...] ), [...] )
    {
        global $mf_initialisation;
        $code_erreur = 0;
        $values = '';
        foreach ($lignes as $ligne)
        {
            $Code_joueur = (isset($ligne['Code_joueur'])?round($ligne['Code_joueur']):0);
            $Code_groupe = (isset($ligne['Code_groupe'])?round($ligne['Code_groupe']):0);
            $a_candidature_joueur_groupe_Message = text_sql(isset($ligne['a_candidature_joueur_groupe_Message'])?$ligne['a_candidature_joueur_groupe_Message']:$mf_initialisation['a_candidature_joueur_groupe_Message']);
            $a_candidature_joueur_groupe_Date_envoi = format_datetime(isset($ligne['a_candidature_joueur_groupe_Date_envoi'])?$ligne['a_candidature_joueur_groupe_Date_envoi']:$mf_initialisation['a_candidature_joueur_groupe_Date_envoi']);
            if ($Code_joueur != 0)
            {
                if ($Code_groupe != 0)
                {
                    $values.=($values!='' ? ',' : '')."('$a_candidature_joueur_groupe_Message', ".( $a_candidature_joueur_groupe_Date_envoi!='' ? "'$a_candidature_joueur_groupe_Date_envoi'" : 'NULL' ).", $Code_joueur, $Code_groupe)";
                }
            }
        }
        if ($values!='')
        {
            $requete = "INSERT INTO ".inst('a_candidature_joueur_groupe')." ( a_candidature_joueur_groupe_Message, a_candidature_joueur_groupe_Date_envoi, Code_joueur, Code_groupe ) VALUES $values;";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            $n = requete_mysqli_affected_rows();
            if ($n < count($lignes))
            {
                $code_erreur = ERR_A_CANDIDATURE_JOUEUR_GROUPE__AJOUTER_3__ECHEC_AJOUT;
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

    public function mf_modifier(int $Code_joueur, int $Code_groupe, string $a_candidature_joueur_groupe_Message, string $a_candidature_joueur_groupe_Date_envoi, ?bool $force=null)
    {
        if ( $force===null ) { $force=false; }
        $code_erreur = 0;
        $Code_joueur = round($Code_joueur);
        $Code_groupe = round($Code_groupe);
        $a_candidature_joueur_groupe_Date_envoi = format_datetime($a_candidature_joueur_groupe_Date_envoi);
        Hook_a_candidature_joueur_groupe::pre_controller($a_candidature_joueur_groupe_Message, $a_candidature_joueur_groupe_Date_envoi, $Code_joueur, $Code_groupe);
        if (!$force)
        {
            if (!self::$maj_droits_modifier_en_cours)
            {
                self::$maj_droits_modifier_en_cours = true;
                Hook_a_candidature_joueur_groupe::hook_actualiser_les_droits_modifier($Code_joueur, $Code_groupe);
                self::$maj_droits_modifier_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['a_candidature_joueur_groupe__MODIFIER']) ) $code_erreur = REFUS_A_CANDIDATURE_JOUEUR_GROUPE__MODIFIER;
        elseif ( !$this->mf_tester_existance_Code_joueur($Code_joueur) ) $code_erreur = ERR_A_CANDIDATURE_JOUEUR_GROUPE__MODIFIER__CODE_JOUEUR_INEXISTANT;
        elseif ( !$this->mf_tester_existance_Code_groupe($Code_groupe) ) $code_erreur = ERR_A_CANDIDATURE_JOUEUR_GROUPE__MODIFIER__CODE_GROUPE_INEXISTANT;
        elseif ( !$this->mf_tester_existance_a_candidature_joueur_groupe( $Code_joueur, $Code_groupe ) ) $code_erreur = ERR_A_CANDIDATURE_JOUEUR_GROUPE__MODIFIER__INEXISTANT;
        elseif ( CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_joueur', $Code_joueur) ) $code_erreur = ACCES_CODE_JOUEUR_REFUSE;
        elseif ( CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_groupe', $Code_groupe) ) $code_erreur = ACCES_CODE_GROUPE_REFUSE;
        elseif ( !Hook_a_candidature_joueur_groupe::autorisation_modification($Code_joueur, $Code_groupe, $a_candidature_joueur_groupe_Message, $a_candidature_joueur_groupe_Date_envoi) ) $code_erreur = REFUS_A_CANDIDATURE_JOUEUR_GROUPE__MODIFICATION_BLOQUEE;
        else
        {
            Hook_a_candidature_joueur_groupe::data_controller($a_candidature_joueur_groupe_Message, $a_candidature_joueur_groupe_Date_envoi, $Code_joueur, $Code_groupe);
            $a_candidature_joueur_groupe = $this->mf_get_2( $Code_joueur, $Code_groupe, array('autocompletion' => false) );
            $mf_colonnes_a_modifier=[];
            $bool__a_candidature_joueur_groupe_Message = false; if ( $a_candidature_joueur_groupe_Message!=$a_candidature_joueur_groupe['a_candidature_joueur_groupe_Message'] ) { Hook_a_candidature_joueur_groupe::data_controller__a_candidature_joueur_groupe_Message($a_candidature_joueur_groupe['a_candidature_joueur_groupe_Message'], $a_candidature_joueur_groupe_Message, $Code_joueur, $Code_groupe); if ( $a_candidature_joueur_groupe_Message!=$a_candidature_joueur_groupe['a_candidature_joueur_groupe_Message'] ) { $mf_colonnes_a_modifier[] = 'a_candidature_joueur_groupe_Message=' . format_sql('a_candidature_joueur_groupe_Message', $a_candidature_joueur_groupe_Message); $bool__a_candidature_joueur_groupe_Message = true; } }
            $bool__a_candidature_joueur_groupe_Date_envoi = false; if ( $a_candidature_joueur_groupe_Date_envoi!=$a_candidature_joueur_groupe['a_candidature_joueur_groupe_Date_envoi'] ) { Hook_a_candidature_joueur_groupe::data_controller__a_candidature_joueur_groupe_Date_envoi($a_candidature_joueur_groupe['a_candidature_joueur_groupe_Date_envoi'], $a_candidature_joueur_groupe_Date_envoi, $Code_joueur, $Code_groupe); if ( $a_candidature_joueur_groupe_Date_envoi!=$a_candidature_joueur_groupe['a_candidature_joueur_groupe_Date_envoi'] ) { $mf_colonnes_a_modifier[] = 'a_candidature_joueur_groupe_Date_envoi=' . format_sql('a_candidature_joueur_groupe_Date_envoi', $a_candidature_joueur_groupe_Date_envoi); $bool__a_candidature_joueur_groupe_Date_envoi = true; } }
            if (count($mf_colonnes_a_modifier)>0) {
                $requete = 'UPDATE ' . inst('a_candidature_joueur_groupe') . ' SET ' . enumeration($mf_colonnes_a_modifier) . " WHERE Code_joueur=$Code_joueur AND Code_groupe=$Code_groupe;";
                $cle = md5($requete).salt(10);
                self::$cache_db->pause($cle);
                executer_requete_mysql($requete, true);
                if ( requete_mysqli_affected_rows()==0 )
                {
                    $code_erreur = ERR_A_CANDIDATURE_JOUEUR_GROUPE__MODIFIER__AUCUN_CHANGEMENT;
                    self::$cache_db->reprendre($cle);
                }
                else
                {
                    self::$cache_db->clear();
                    self::$cache_db->reprendre($cle);
                    Hook_a_candidature_joueur_groupe::modifier($Code_joueur, $Code_groupe, $bool__a_candidature_joueur_groupe_Message, $bool__a_candidature_joueur_groupe_Date_envoi);
                }
            }
            else
            {
                $code_erreur = ERR_A_CANDIDATURE_JOUEUR_GROUPE__MODIFIER__AUCUN_CHANGEMENT;
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
        return array('code_erreur' => $code_erreur, 'callback' => ( $code_erreur == 0 ? Hook_a_candidature_joueur_groupe::callback_put($Code_joueur, $Code_groupe) : null ));
    }

    public function mf_modifier_2(array $lignes, ?bool $force=null) // array( array('Code_' => $Code, ..., 'colonne1' => 'valeur1', [...] ), [...] )
    {
        if ( $force===null ) { $force=false; }
        $code_erreur = 0;
        foreach ( $lignes as $colonnes )
        {
            if ( $code_erreur==0 )
            {
                $Code_joueur = ( isset($colonnes['Code_joueur']) ? $colonnes['Code_joueur'] : 0 );
                $Code_groupe = ( isset($colonnes['Code_groupe']) ? $colonnes['Code_groupe'] : 0 );
                $a_candidature_joueur_groupe = $this->mf_get_2($Code_joueur, $Code_groupe, array('autocompletion' => false));
                if (!$force)
                {
                    if (!self::$maj_droits_modifier_en_cours)
                    {
                        self::$maj_droits_modifier_en_cours = true;
                        Hook_a_candidature_joueur_groupe::hook_actualiser_les_droits_modifier($Code_joueur, $Code_groupe);
                        self::$maj_droits_modifier_en_cours = false;
                    }
                }
                $a_candidature_joueur_groupe_Message = ( isset($colonnes['a_candidature_joueur_groupe_Message']) && ( $force || mf_matrice_droits(['api_modifier__a_candidature_joueur_groupe_Message', 'a_candidature_joueur_groupe__MODIFIER']) ) ? $colonnes['a_candidature_joueur_groupe_Message'] : ( isset($a_candidature_joueur_groupe['a_candidature_joueur_groupe_Message']) ? $a_candidature_joueur_groupe['a_candidature_joueur_groupe_Message'] : '' ) );
                $a_candidature_joueur_groupe_Date_envoi = ( isset($colonnes['a_candidature_joueur_groupe_Date_envoi']) && ( $force || mf_matrice_droits(['api_modifier__a_candidature_joueur_groupe_Date_envoi', 'a_candidature_joueur_groupe__MODIFIER']) ) ? $colonnes['a_candidature_joueur_groupe_Date_envoi'] : ( isset($a_candidature_joueur_groupe['a_candidature_joueur_groupe_Date_envoi']) ? $a_candidature_joueur_groupe['a_candidature_joueur_groupe_Date_envoi'] : '' ) );
                $retour = $this->mf_modifier($Code_joueur, $Code_groupe, $a_candidature_joueur_groupe_Message, $a_candidature_joueur_groupe_Date_envoi, true);
                if ( $retour['code_erreur']!=0 && $retour['code_erreur'] != ERR_A_CANDIDATURE_JOUEUR_GROUPE__MODIFIER__AUCUN_CHANGEMENT )
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

    public function mf_modifier_3(array $lignes) // array( array('Code_' => $Code, ..., 'colonne1' => 'valeur1', [...] ), [...] )
    {
        $code_erreur = 0;
        $modifs = false;

        // transformation des lignes en colonnes
        $valeurs_en_colonnes=array();
        $indices_par_colonne=array();
        foreach ( $lignes as $colonnes )
        {
            foreach ($colonnes as $colonne => $valeur)
            {
                if ( $colonne=='a_candidature_joueur_groupe_Message' || $colonne=='a_candidature_joueur_groupe_Date_envoi' )
                {
                    if ( isset($colonnes['Code_joueur']) && isset($colonnes['Code_groupe']) )
                    {
                        $valeurs_en_colonnes[$colonne]['Code_joueur='.$colonnes['Code_joueur'] . ' AND ' . 'Code_groupe='.$colonnes['Code_groupe']]=$valeur;
                        $liste_valeurs_indexees[$colonne][''.$valeur][]='Code_joueur='.$colonnes['Code_joueur'] . ' AND ' . 'Code_groupe='.$colonnes['Code_groupe'];
                    }
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
                $perimetre = '';
                $modification_sql = 'CASE';
                foreach ( $valeurs as $conditions => $valeur )
                {
                    $modification_sql.= ' WHEN ' . $conditions . ' THEN ' . format_sql($colonne, $valeur);
                    $perimetre.= ( $perimetre!='' ? ' OR ' : '' ) . $conditions;
                }
                $modification_sql.= ' END';
                executer_requete_mysql('UPDATE ' . inst('a_candidature_joueur_groupe') . ' SET ' . $colonne . ' = ' . $modification_sql . ' WHERE ' . $perimetre . ';', true);
                if ( requete_mysqli_affected_rows()!=0 )
                {
                    $modifs = true;
                }
            }
            else
            {
                foreach ( $liste_valeurs_indexees[$colonne] as $valeur => $indices_par_valeur )
                {
                    $perimetre = '';
                    foreach ( $indices_par_valeur as $conditions )
                    {
                        $perimetre.= ( $perimetre!='' ? ' OR ' : '' ) . $conditions;
                    }
                    executer_requete_mysql('UPDATE ' . inst('a_candidature_joueur_groupe') . ' SET ' . $colonne . ' = ' . format_sql($colonne, $valeur) . ' WHERE ' . $perimetre . ';', true);
                    if ( requete_mysqli_affected_rows()!=0 )
                    {
                        $modifs = true;
                    }
                }
            }
        }

        if ( ! $modifs && $code_erreur==0 )
        {
            $code_erreur = ERR_A_CANDIDATURE_JOUEUR_GROUPE__MODIFIER_3__AUCUN_CHANGEMENT;
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

    public function mf_modifier_4(int $Code_joueur, int $Code_groupe, array $data, ?array $options = null ) // $data = array('colonne1' => 'valeur1', ... ) / $options = [ 'cond_mysql' => [], 'limit' => 0 ]
    {
        if ( $options===null ) { $options=[]; }
        $code_erreur = 0;
        $Code_joueur = round($Code_joueur);
        $Code_groupe = round($Code_groupe);
        $mf_colonnes_a_modifier=[];
        if ( isset($data['a_candidature_joueur_groupe_Message']) ) { $mf_colonnes_a_modifier[] = 'a_candidature_joueur_groupe_Message = ' . format_sql('a_candidature_joueur_groupe_Message', $data['a_candidature_joueur_groupe_Message']); }
        if ( isset($data['a_candidature_joueur_groupe_Date_envoi']) ) { $mf_colonnes_a_modifier[] = 'a_candidature_joueur_groupe_Date_envoi = ' . format_sql('a_candidature_joueur_groupe_Date_envoi', $data['a_candidature_joueur_groupe_Date_envoi']); }
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

            $requete = 'UPDATE ' . inst('a_candidature_joueur_groupe') . ' SET ' . enumeration($mf_colonnes_a_modifier) . " WHERE 1".( $Code_joueur!=0 ? " AND Code_joueur=$Code_joueur" : "" )."".( $Code_groupe!=0 ? " AND Code_groupe=$Code_groupe" : "" )."$argument_cond" . ( $limit>0 ? ' LIMIT ' . $limit : '' ) . ";";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_A_CANDIDATURE_JOUEUR_GROUPE__MODIFIER_4__AUCUN_CHANGEMENT;
            }
            else
            {
                self::$cache_db->clear();
            }
            self::$cache_db->reprendre($cle);
        }
        return array('code_erreur' => $code_erreur);
    }

    public function mf_supprimer(?int $Code_joueur=null, ?int $Code_groupe=null, ?bool $force=null)
    {
        if ( $force===null ) { $force=false; }
        $code_erreur = 0;
        $Code_joueur = round($Code_joueur);
        $Code_groupe = round($Code_groupe);
        $copie__liste_a_candidature_joueur_groupe = $this->mf_lister($Code_joueur, $Code_groupe, array('autocompletion' => false));
        $liste_Code_joueur = array();
        $liste_Code_groupe = array();
        foreach ( $copie__liste_a_candidature_joueur_groupe as $copie__a_candidature_joueur_groupe )
        {
            $Code_joueur = $copie__a_candidature_joueur_groupe['Code_joueur'];
            $Code_groupe = $copie__a_candidature_joueur_groupe['Code_groupe'];
            if (!$force)
            {
                if (!self::$maj_droits_supprimer_en_cours)
                {
                    self::$maj_droits_supprimer_en_cours = true;
                    Hook_a_candidature_joueur_groupe::hook_actualiser_les_droits_supprimer($Code_joueur, $Code_groupe);
                    self::$maj_droits_supprimer_en_cours = false;
                }
            }
            if ( !$force && !mf_matrice_droits(['a_candidature_joueur_groupe__SUPPRIMER']) ) $code_erreur = REFUS_A_CANDIDATURE_JOUEUR_GROUPE__SUPPRIMER;
            elseif ( !Hook_a_candidature_joueur_groupe::autorisation_suppression($Code_joueur, $Code_groupe) ) $code_erreur = REFUS_A_CANDIDATURE_JOUEUR_GROUPE__SUPPRESSION_BLOQUEE;
            {
                $liste_Code_joueur[] = $Code_joueur;
                $liste_Code_groupe[] = $Code_groupe;
            }
        }
        if ( $code_erreur==0 && count($liste_Code_joueur)>0 && count($liste_Code_groupe)>0 )
        {
            $requete = "DELETE IGNORE FROM ".inst('a_candidature_joueur_groupe')." WHERE Code_joueur IN ".Sql_Format_Liste($liste_Code_joueur)." AND Code_groupe IN ".Sql_Format_Liste($liste_Code_groupe).";";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_A_CANDIDATURE_JOUEUR_GROUPE__SUPPRIMER__REFUSE;
                self::$cache_db->reprendre($cle);
            }
            else
            {
                self::$cache_db->clear();
                self::$cache_db->reprendre($cle);
                Hook_a_candidature_joueur_groupe::supprimer($copie__liste_a_candidature_joueur_groupe);
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

    public function mf_supprimer_2(?int $Code_joueur=null, ?int $Code_groupe=null)
    {
        $code_erreur = 0;
        $Code_joueur = round($Code_joueur);
        $Code_groupe = round($Code_groupe);
        $copie__liste_a_candidature_joueur_groupe = $this->mf_lister_2($Code_joueur, $Code_groupe, array('autocompletion' => false));
        $requete = 'DELETE IGNORE FROM ' . inst('a_candidature_joueur_groupe') . " WHERE 1".( $Code_joueur!=0 ? " AND Code_joueur=$Code_joueur" : "" )."".( $Code_groupe!=0 ? " AND Code_groupe=$Code_groupe" : "" ).";";
        $cle = md5($requete).salt(10);
        self::$cache_db->pause($cle);
        executer_requete_mysql( $requete , true);
        if ( requete_mysqli_affected_rows()==0 )
        {
            $code_erreur = ERR_A_CANDIDATURE_JOUEUR_GROUPE__SUPPRIMER_2__REFUSE;
            self::$cache_db->reprendre($cle);
        }
        else
        {
            self::$cache_db->clear();
            self::$cache_db->reprendre($cle);
            Hook_a_candidature_joueur_groupe::supprimer($copie__liste_a_candidature_joueur_groupe);
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

    public function mf_lister_contexte(?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        global $mf_contexte, $est_charge;
        return $this->mf_lister(isset($est_charge['joueur']) ? $mf_contexte['Code_joueur'] : 0, isset($est_charge['groupe']) ? $mf_contexte['Code_groupe'] : 0, $options);
    }

    public function mf_lister(?int $Code_joueur=null, ?int $Code_groupe=null, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $liste = $this->mf_lister_2($Code_joueur, $Code_groupe, $options);

        // controle_acces_donnees
        $controle_acces_donnees = CONTROLE_ACCES_DONNEES_DEFAUT;
        if (isset($options['controle_acces_donnees']))
        {
            $controle_acces_donnees = ( $options['controle_acces_donnees']==true );
        }

        foreach ($liste as $key => $elem)
        {
            if ( $controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_joueur', $elem['Code_joueur']) || $controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_groupe', $elem['Code_groupe']) )
            {
                unset($liste[$key]);
            }
        }

        return $liste;
    }

    public function mf_lister_2(?int $Code_joueur=null, ?int $Code_groupe=null, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cle = "a_candidature_joueur_groupe__lister";
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
            if ( isset($mf_tri_defaut_table['a_candidature_joueur_groupe']) )
            {
                $options['tris'] = $mf_tri_defaut_table['a_candidature_joueur_groupe'];
            }
        }
        foreach ($options['tris'] as $colonne => $tri)
        {
            if ( $colonne != 'a_candidature_joueur_groupe_Message' )
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

        if ( ! $liste = self::$cache_db->read($cle) )
        {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ( $argument_cond!='' )
            {
                if ( strpos($argument_cond, 'a_candidature_joueur_groupe_Date_envoi')!==false ) { $liste_colonnes_a_indexer['a_candidature_joueur_groupe_Date_envoi'] = 'a_candidature_joueur_groupe_Date_envoi'; }
            }
            if ( isset($options['tris']) )
            {
                if ( isset($options['tris']['a_candidature_joueur_groupe_Date_envoi']) ) { $liste_colonnes_a_indexer['a_candidature_joueur_groupe_Date_envoi'] = 'a_candidature_joueur_groupe_Date_envoi'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = self::$cache_db->read('a_candidature_joueur_groupe__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('a_candidature_joueur_groupe').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    self::$cache_db->write('a_candidature_joueur_groupe__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    self::$cache_db->pause('a_candidature_joueur_groupe__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('a_candidature_joueur_groupe').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    self::$cache_db->clear();
                    self::$cache_db->reprendre('a_candidature_joueur_groupe__index');
                }
            }

            $liste = array();
            if ($toutes_colonnes)
            {
                $colonnes='a_candidature_joueur_groupe_Message, a_candidature_joueur_groupe_Date_envoi, Code_joueur, Code_groupe';
            }
            else
            {
                $colonnes='a_candidature_joueur_groupe_Date_envoi, Code_joueur, Code_groupe';
            }
            $res_requete = executer_requete_mysql('SELECT ' . $colonnes . ' FROM '.inst('a_candidature_joueur_groupe')." WHERE 1{$argument_cond}".( $Code_joueur!=0 ? " AND Code_joueur=$Code_joueur" : "" )."".( $Code_groupe!=0 ? " AND Code_groupe=$Code_groupe" : "" )."{$argument_tris}{$argument_limit};", false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                mf_formatage_db_type_php($row_requete);
                $liste[$row_requete['Code_joueur'].'-'.$row_requete['Code_groupe']] = $row_requete;
            }
            mysqli_free_result($res_requete);
            if (count($options['tris'])==1)
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
            self::$cache_db->write($cle, $liste);
        }
        foreach ($liste as &$element)
        {
            if (!self::$auto_completion && $autocompletion)
            {
                self::$auto_completion = true;
                Hook_a_candidature_joueur_groupe::completion($element);
                self::$auto_completion = false;
            }
        }
        unset($element);
        return $liste;
    }

    public function mf_get(int $Code_joueur, int $Code_groupe, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cle = "a_candidature_joueur_groupe__get";
        $Code_joueur = round($Code_joueur);
        $cle.="_{$Code_joueur}";
        $Code_groupe = round($Code_groupe);
        $cle.="_{$Code_groupe}";
        $retour = array();
        if ( ! CONTROLE_ACCES_DONNEES_DEFAUT || Hook_mf_systeme::controle_acces_donnees('Code_joueur', $Code_joueur) && Hook_mf_systeme::controle_acces_donnees('Code_groupe', $Code_groupe) )
        {

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
                    $colonnes='a_candidature_joueur_groupe_Message, a_candidature_joueur_groupe_Date_envoi, Code_joueur, Code_groupe';
                }
                else
                {
                    $colonnes='a_candidature_joueur_groupe_Date_envoi, Code_joueur, Code_groupe';
                }
                $res_requete = executer_requete_mysql('SELECT ' . $colonnes . " FROM ".inst('a_candidature_joueur_groupe')." WHERE Code_joueur=$Code_joueur AND Code_groupe=$Code_groupe;", false);
                if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
                {
                    $retour = $row_requete;
                }
                mysqli_free_result($res_requete);
                self::$cache_db->write($cle, $retour);
            }
            if ( isset( $retour['Code_joueur'] ) )
            {
                if (!self::$auto_completion && $autocompletion)
                {
                    self::$auto_completion = true;
                    Hook_a_candidature_joueur_groupe::completion($retour);
                    self::$auto_completion = false;
                }
            }
        }
        return $retour;
    }

    public function mf_get_2(int $Code_joueur, int $Code_groupe, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cle = "a_candidature_joueur_groupe__get";
        $Code_joueur = round($Code_joueur);
        $cle.="_{$Code_joueur}";
        $Code_groupe = round($Code_groupe);
        $cle.="_{$Code_groupe}";

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

        $retour = array();
        if ( ! $retour = self::$cache_db->read($cle) )
        {
            if ($toutes_colonnes)
            {
                $colonnes='a_candidature_joueur_groupe_Message, a_candidature_joueur_groupe_Date_envoi, Code_joueur, Code_groupe';
            }
            else
            {
                $colonnes='a_candidature_joueur_groupe_Date_envoi, Code_joueur, Code_groupe';
            }
            $res_requete = executer_requete_mysql('SELECT ' . $colonnes . " FROM ".inst('a_candidature_joueur_groupe')." WHERE Code_joueur=$Code_joueur AND Code_groupe=$Code_groupe;", false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $retour = $row_requete;
            }
            mysqli_free_result($res_requete);
            self::$cache_db->write($cle, $retour);
        }
        if ( isset( $retour['Code_joueur'] ) )
        {
            if (!self::$auto_completion && $autocompletion)
            {
                self::$auto_completion = true;
                Hook_a_candidature_joueur_groupe::completion($retour);
                self::$auto_completion = false;
            }
        }
        return $retour;
    }

    public function mf_compter(?int $Code_joueur=null, ?int $Code_groupe=null, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cle = 'a_candidature_joueur_groupe__compter';
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
                if ( strpos($argument_cond, 'a_candidature_joueur_groupe_Date_envoi')!==false ) { $liste_colonnes_a_indexer['a_candidature_joueur_groupe_Date_envoi'] = 'a_candidature_joueur_groupe_Date_envoi'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = self::$cache_db->read('a_candidature_joueur_groupe__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('a_candidature_joueur_groupe').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    self::$cache_db->write('a_candidature_joueur_groupe__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    self::$cache_db->pause('a_candidature_joueur_groupe__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('a_candidature_joueur_groupe').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    self::$cache_db->clear();
                    self::$cache_db->reprendre('a_candidature_joueur_groupe__index');
                }
            }

            $res_requete = executer_requete_mysql("SELECT COUNT(CONCAT(Code_joueur,'|',Code_groupe)) as nb FROM ".inst('a_candidature_joueur_groupe')." WHERE 1{$argument_cond}".( $Code_joueur!=0 ? " AND Code_joueur=$Code_joueur" : "" )."".( $Code_groupe!=0 ? " AND Code_groupe=$Code_groupe" : "" ).";", false);
            $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC);
            mysqli_free_result($res_requete);
            $nb = (int) $row_requete['nb'];
            self::$cache_db->write($cle, $nb);
        }
        return $nb;
    }

    public function mf_liste_Code_joueur_vers_liste_Code_groupe( array $liste_Code_joueur, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ( $options===null ) { $options=[]; }
        return $this->a_candidature_joueur_groupe_liste_Code_joueur_vers_liste_Code_groupe( $liste_Code_joueur , $options );
    }

    public function mf_liste_Code_groupe_vers_liste_Code_joueur( array $liste_Code_groupe, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ( $options===null ) { $options=[]; }
        return $this->a_candidature_joueur_groupe_liste_Code_groupe_vers_liste_Code_joueur( $liste_Code_groupe , $options );
    }

}
