<?php

/*
    +------------------------------+
    |  NE PAS MODIFIER CE FICHIER  |
    +------------------------------+
*/

class a_joueur_parametre_monframework extends entite_monframework
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
            include_once __DIR__ . '/../../erreurs/erreurs__a_joueur_parametre.php';
            self::$initialisation = false;
            Hook_a_joueur_parametre::initialisation();
            self::$cache_db = new Mf_Cachedb('a_joueur_parametre');
        }
        if (!self::$actualisation_en_cours)
        {
            self::$actualisation_en_cours=true;
            Hook_a_joueur_parametre::actualisation();
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

        if ( ! test_si_table_existe(inst('a_joueur_parametre')) )
        {
            executer_requete_mysql('CREATE TABLE '.inst('a_joueur_parametre').' (Code_joueur INT NOT NULL, Code_parametre INT NOT NULL, PRIMARY KEY (Code_joueur, Code_parametre)) ENGINE=MyISAM;', true);
        }

        $liste_colonnes = lister_les_colonnes(inst('a_joueur_parametre'));

        if ( isset($liste_colonnes['a_joueur_parametre_Valeur_choisie']) )
        {
            if ( typeMyql2Sql($liste_colonnes['a_joueur_parametre_Valeur_choisie']['Type'])!='INT' )
            {
                executer_requete_mysql('ALTER TABLE '.inst('a_joueur_parametre').' CHANGE a_joueur_parametre_Valeur_choisie a_joueur_parametre_Valeur_choisie INT;', true);
            }
            unset($liste_colonnes['a_joueur_parametre_Valeur_choisie']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('a_joueur_parametre').' ADD a_joueur_parametre_Valeur_choisie INT;', true);
            executer_requete_mysql('UPDATE '.inst('a_joueur_parametre').' SET a_joueur_parametre_Valeur_choisie=' . format_sql('a_joueur_parametre_Valeur_choisie', $mf_initialisation['a_joueur_parametre_Valeur_choisie']) . ';', true);
        }

        if ( isset($liste_colonnes['a_joueur_parametre_Actif']) )
        {
            if ( typeMyql2Sql($liste_colonnes['a_joueur_parametre_Actif']['Type'])!='BOOL' )
            {
                executer_requete_mysql('ALTER TABLE '.inst('a_joueur_parametre').' CHANGE a_joueur_parametre_Actif a_joueur_parametre_Actif BOOL;', true);
            }
            unset($liste_colonnes['a_joueur_parametre_Actif']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('a_joueur_parametre').' ADD a_joueur_parametre_Actif BOOL;', true);
            executer_requete_mysql('UPDATE '.inst('a_joueur_parametre').' SET a_joueur_parametre_Actif=' . format_sql('a_joueur_parametre_Actif', $mf_initialisation['a_joueur_parametre_Actif']) . ';', true);
        }

        unset($liste_colonnes['Code_joueur']);
        unset($liste_colonnes['Code_parametre']);

        foreach ($liste_colonnes as $field => $value)
        {
            executer_requete_mysql('ALTER TABLE '.inst('a_joueur_parametre').' DROP COLUMN '.$field.';', true);
        }

    }

    public function mfi_ajouter_auto(array $interface)
    {
        if (isset($interface['Code_joueur'])) { $liste_Code_joueur = array($interface['Code_joueur']); }
        elseif (isset($interface['liste_Code_joueur'])) { $liste_Code_joueur = $interface['liste_Code_joueur']; }
        else { $liste_Code_joueur = $this->get_liste_Code_joueur(); }
        if (isset($interface['Code_parametre'])) { $liste_Code_parametre = array($interface['Code_parametre']); }
        elseif (isset($interface['liste_Code_parametre'])) { $liste_Code_parametre = $interface['liste_Code_parametre']; }
        else { $liste_Code_parametre = $this->get_liste_Code_parametre(); }
        $liste_a_joueur_parametre = array();
        foreach ($liste_Code_joueur as $Code_joueur)
        {
            foreach ($liste_Code_parametre as $Code_parametre)
            {
                $liste_a_joueur_parametre[] = array('Code_joueur'=>$Code_joueur,'Code_parametre'=>$Code_parametre);
            }
        }
        if (isset($interface['a_joueur_parametre_Valeur_choisie'])) { foreach ($liste_a_joueur_parametre as &$a_joueur_parametre) { $a_joueur_parametre['a_joueur_parametre_Valeur_choisie'] = $interface['a_joueur_parametre_Valeur_choisie']; } unset($a_joueur_parametre); }
        if (isset($interface['a_joueur_parametre_Actif'])) { foreach ($liste_a_joueur_parametre as &$a_joueur_parametre) { $a_joueur_parametre['a_joueur_parametre_Actif'] = $interface['a_joueur_parametre_Actif']; } unset($a_joueur_parametre); }
        return $this->mf_ajouter_3($liste_a_joueur_parametre);
    }

    public function mfi_supprimer_auto(array $interface)
    {
        if (isset($interface['Code_joueur'])) { $liste_Code_joueur = array($interface['Code_joueur']); }
        elseif (isset($interface['liste_Code_joueur'])) { $liste_Code_joueur = $interface['liste_Code_joueur']; }
        else { $liste_Code_joueur = $this->get_liste_Code_joueur(); }
        if (isset($interface['Code_parametre'])) { $liste_Code_parametre = array($interface['Code_parametre']); }
        elseif (isset($interface['liste_Code_parametre'])) { $liste_Code_parametre = $interface['liste_Code_parametre']; }
        else { $liste_Code_parametre = $this->get_liste_Code_parametre(); }
        foreach ($liste_Code_joueur as $Code_joueur)
        {
            foreach ($liste_Code_parametre as $Code_parametre)
            {
                $this->mf_supprimer_2($Code_joueur, $Code_parametre);
            }
        }
    }

    public function mf_ajouter(int $Code_joueur, int $Code_parametre, int $a_joueur_parametre_Valeur_choisie, bool $a_joueur_parametre_Actif, ?bool $force=null)
    {
        if ( $force===null ) { $force=false; }
        $code_erreur = 0;
        $Code_joueur = round($Code_joueur);
        $Code_parametre = round($Code_parametre);
        $a_joueur_parametre_Valeur_choisie = round($a_joueur_parametre_Valeur_choisie);
        Hook_a_joueur_parametre::pre_controller($a_joueur_parametre_Valeur_choisie, $a_joueur_parametre_Actif, $Code_joueur, $Code_parametre);
        if (!$force)
        {
            if (!self::$maj_droits_ajouter_en_cours)
            {
                self::$maj_droits_ajouter_en_cours = true;
                Hook_a_joueur_parametre::hook_actualiser_les_droits_ajouter($Code_joueur, $Code_parametre);
                self::$maj_droits_ajouter_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['a_joueur_parametre__AJOUTER']) ) $code_erreur = REFUS_A_JOUEUR_PARAMETRE__AJOUTER;
        elseif ( !$this->mf_tester_existance_Code_joueur($Code_joueur) ) $code_erreur = ERR_A_JOUEUR_PARAMETRE__AJOUTER__CODE_JOUEUR_INEXISTANT;
        elseif ( !$this->mf_tester_existance_Code_parametre($Code_parametre) ) $code_erreur = ERR_A_JOUEUR_PARAMETRE__AJOUTER__CODE_PARAMETRE_INEXISTANT;
        elseif ( $this->mf_tester_existance_a_joueur_parametre( $Code_joueur, $Code_parametre ) ) $code_erreur = ERR_A_JOUEUR_PARAMETRE__AJOUTER__DOUBLON;
        elseif ( CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_joueur', $Code_joueur) ) $code_erreur = ACCES_CODE_JOUEUR_REFUSE;
        elseif ( CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_parametre', $Code_parametre) ) $code_erreur = ACCES_CODE_PARAMETRE_REFUSE;
        elseif ( !Hook_a_joueur_parametre::autorisation_ajout($a_joueur_parametre_Valeur_choisie, $a_joueur_parametre_Actif, $Code_joueur, $Code_parametre) ) $code_erreur = REFUS_A_JOUEUR_PARAMETRE__AJOUT_BLOQUEE;
        else
        {
            Hook_a_joueur_parametre::data_controller($a_joueur_parametre_Valeur_choisie, $a_joueur_parametre_Actif, $Code_joueur, $Code_parametre);
            $a_joueur_parametre_Valeur_choisie = round($a_joueur_parametre_Valeur_choisie);
            $a_joueur_parametre_Actif = ($a_joueur_parametre_Actif==1 ? 1 : 0);
            $requete = 'INSERT INTO '.inst('a_joueur_parametre')." ( a_joueur_parametre_Valeur_choisie, a_joueur_parametre_Actif, Code_joueur, Code_parametre ) VALUES ( $a_joueur_parametre_Valeur_choisie, $a_joueur_parametre_Actif, $Code_joueur, $Code_parametre );";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql($requete, true);
            $n = requete_mysqli_affected_rows();
            if ($n==0)
            {
                $code_erreur = ERR_A_JOUEUR_PARAMETRE__AJOUTER__REFUSE;
                self::$cache_db->reprendre($cle);
            }
            else
            {
                self::$cache_db->clear();
                self::$cache_db->reprendre($cle);
                Hook_a_joueur_parametre::ajouter($Code_joueur, $Code_parametre);
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
        return array('code_erreur' => $code_erreur, 'callback' => ( $code_erreur==0 ? Hook_a_joueur_parametre::callback_post($Code_joueur, $Code_parametre) : null ));
    }

    public function mf_ajouter_2(array $ligne, ?bool $force=null) // array('colonne1' => 'valeur1',  [...] )
    {
        if ( $force===null ) { $force=false; }
        global $mf_initialisation;
        $Code_joueur = (int)(isset($ligne['Code_joueur'])?round($ligne['Code_joueur']):get_joueur_courant('Code_joueur'));
        $Code_parametre = (int)(isset($ligne['Code_parametre'])?round($ligne['Code_parametre']):0);
        $a_joueur_parametre_Valeur_choisie = (int)(isset($ligne['a_joueur_parametre_Valeur_choisie'])?$ligne['a_joueur_parametre_Valeur_choisie']:$mf_initialisation['a_joueur_parametre_Valeur_choisie']);
        $a_joueur_parametre_Actif = (bool)(isset($ligne['a_joueur_parametre_Actif'])?$ligne['a_joueur_parametre_Actif']:$mf_initialisation['a_joueur_parametre_Actif']);
        return $this->mf_ajouter($Code_joueur, $Code_parametre, $a_joueur_parametre_Valeur_choisie, $a_joueur_parametre_Actif, $force);
    }

    public function mf_ajouter_3(array $lignes) // array( array( 'colonne1' => 'valeur1', 'colonne2' => 'valeur2',  [...] ), [...] )
    {
        global $mf_initialisation;
        $code_erreur = 0;
        $values = '';
        foreach ($lignes as $ligne)
        {
            $Code_joueur = (isset($ligne['Code_joueur'])?round($ligne['Code_joueur']):0);
            $Code_parametre = (isset($ligne['Code_parametre'])?round($ligne['Code_parametre']):0);
            $a_joueur_parametre_Valeur_choisie = round(isset($ligne['a_joueur_parametre_Valeur_choisie'])?$ligne['a_joueur_parametre_Valeur_choisie']:$mf_initialisation['a_joueur_parametre_Valeur_choisie']);
            $a_joueur_parametre_Actif = (isset($ligne['a_joueur_parametre_Actif'])?$ligne['a_joueur_parametre_Actif']:$mf_initialisation['a_joueur_parametre_Actif']==1 ? 1 : 0);
            if ($Code_joueur != 0)
            {
                if ($Code_parametre != 0)
                {
                    $values.=($values!='' ? ',' : '')."($a_joueur_parametre_Valeur_choisie, $a_joueur_parametre_Actif, $Code_joueur, $Code_parametre)";
                }
            }
        }
        if ($values!='')
        {
            $requete = "INSERT INTO ".inst('a_joueur_parametre')." ( a_joueur_parametre_Valeur_choisie, a_joueur_parametre_Actif, Code_joueur, Code_parametre ) VALUES $values;";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            $n = requete_mysqli_affected_rows();
            if ($n < count($lignes))
            {
                $code_erreur = ERR_A_JOUEUR_PARAMETRE__AJOUTER_3__ECHEC_AJOUT;
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

    public function mf_modifier(int $Code_joueur, int $Code_parametre, int $a_joueur_parametre_Valeur_choisie, bool $a_joueur_parametre_Actif, ?bool $force=null)
    {
        if ( $force===null ) { $force=false; }
        $code_erreur = 0;
        $Code_joueur = round($Code_joueur);
        $Code_parametre = round($Code_parametre);
        $a_joueur_parametre_Valeur_choisie = round($a_joueur_parametre_Valeur_choisie);
        Hook_a_joueur_parametre::pre_controller($a_joueur_parametre_Valeur_choisie, $a_joueur_parametre_Actif, $Code_joueur, $Code_parametre);
        if (!$force)
        {
            if (!self::$maj_droits_modifier_en_cours)
            {
                self::$maj_droits_modifier_en_cours = true;
                Hook_a_joueur_parametre::hook_actualiser_les_droits_modifier($Code_joueur, $Code_parametre);
                self::$maj_droits_modifier_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['a_joueur_parametre__MODIFIER']) ) $code_erreur = REFUS_A_JOUEUR_PARAMETRE__MODIFIER;
        elseif ( !$this->mf_tester_existance_Code_joueur($Code_joueur) ) $code_erreur = ERR_A_JOUEUR_PARAMETRE__MODIFIER__CODE_JOUEUR_INEXISTANT;
        elseif ( !$this->mf_tester_existance_Code_parametre($Code_parametre) ) $code_erreur = ERR_A_JOUEUR_PARAMETRE__MODIFIER__CODE_PARAMETRE_INEXISTANT;
        elseif ( !$this->mf_tester_existance_a_joueur_parametre( $Code_joueur, $Code_parametre ) ) $code_erreur = ERR_A_JOUEUR_PARAMETRE__MODIFIER__INEXISTANT;
        elseif ( CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_joueur', $Code_joueur) ) $code_erreur = ACCES_CODE_JOUEUR_REFUSE;
        elseif ( CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_parametre', $Code_parametre) ) $code_erreur = ACCES_CODE_PARAMETRE_REFUSE;
        elseif ( !Hook_a_joueur_parametre::autorisation_modification($Code_joueur, $Code_parametre, $a_joueur_parametre_Valeur_choisie, $a_joueur_parametre_Actif) ) $code_erreur = REFUS_A_JOUEUR_PARAMETRE__MODIFICATION_BLOQUEE;
        else
        {
            Hook_a_joueur_parametre::data_controller($a_joueur_parametre_Valeur_choisie, $a_joueur_parametre_Actif, $Code_joueur, $Code_parametre);
            $a_joueur_parametre = $this->mf_get_2( $Code_joueur, $Code_parametre, array('autocompletion' => false) );
            $mf_colonnes_a_modifier=[];
            $bool__a_joueur_parametre_Valeur_choisie = false; if ( $a_joueur_parametre_Valeur_choisie!=$a_joueur_parametre['a_joueur_parametre_Valeur_choisie'] ) { Hook_a_joueur_parametre::data_controller__a_joueur_parametre_Valeur_choisie($a_joueur_parametre['a_joueur_parametre_Valeur_choisie'], $a_joueur_parametre_Valeur_choisie, $Code_joueur, $Code_parametre); if ( $a_joueur_parametre_Valeur_choisie!=$a_joueur_parametre['a_joueur_parametre_Valeur_choisie'] ) { $mf_colonnes_a_modifier[] = 'a_joueur_parametre_Valeur_choisie=' . format_sql('a_joueur_parametre_Valeur_choisie', $a_joueur_parametre_Valeur_choisie); $bool__a_joueur_parametre_Valeur_choisie = true; } }
            $bool__a_joueur_parametre_Actif = false; if ( $a_joueur_parametre_Actif!=$a_joueur_parametre['a_joueur_parametre_Actif'] ) { Hook_a_joueur_parametre::data_controller__a_joueur_parametre_Actif($a_joueur_parametre['a_joueur_parametre_Actif'], $a_joueur_parametre_Actif, $Code_joueur, $Code_parametre); if ( $a_joueur_parametre_Actif!=$a_joueur_parametre['a_joueur_parametre_Actif'] ) { $mf_colonnes_a_modifier[] = 'a_joueur_parametre_Actif=' . format_sql('a_joueur_parametre_Actif', $a_joueur_parametre_Actif); $bool__a_joueur_parametre_Actif = true; } }
            if (count($mf_colonnes_a_modifier)>0) {
                $requete = 'UPDATE ' . inst('a_joueur_parametre') . ' SET ' . enumeration($mf_colonnes_a_modifier) . " WHERE Code_joueur=$Code_joueur AND Code_parametre=$Code_parametre;";
                $cle = md5($requete).salt(10);
                self::$cache_db->pause($cle);
                executer_requete_mysql($requete, true);
                if ( requete_mysqli_affected_rows()==0 )
                {
                    $code_erreur = ERR_A_JOUEUR_PARAMETRE__MODIFIER__AUCUN_CHANGEMENT;
                    self::$cache_db->reprendre($cle);
                }
                else
                {
                    self::$cache_db->clear();
                    self::$cache_db->reprendre($cle);
                    Hook_a_joueur_parametre::modifier($Code_joueur, $Code_parametre, $bool__a_joueur_parametre_Valeur_choisie, $bool__a_joueur_parametre_Actif);
                }
            }
            else
            {
                $code_erreur = ERR_A_JOUEUR_PARAMETRE__MODIFIER__AUCUN_CHANGEMENT;
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
        return array('code_erreur' => $code_erreur, 'callback' => ( $code_erreur == 0 ? Hook_a_joueur_parametre::callback_put($Code_joueur, $Code_parametre) : null ));
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
                $Code_parametre = ( isset($colonnes['Code_parametre']) ? $colonnes['Code_parametre'] : 0 );
                $a_joueur_parametre = $this->mf_get_2($Code_joueur, $Code_parametre, array('autocompletion' => false));
                if (!$force)
                {
                    if (!self::$maj_droits_modifier_en_cours)
                    {
                        self::$maj_droits_modifier_en_cours = true;
                        Hook_a_joueur_parametre::hook_actualiser_les_droits_modifier($Code_joueur, $Code_parametre);
                        self::$maj_droits_modifier_en_cours = false;
                    }
                }
                $a_joueur_parametre_Valeur_choisie = ( isset($colonnes['a_joueur_parametre_Valeur_choisie']) && ( $force || mf_matrice_droits(['api_modifier__a_joueur_parametre_Valeur_choisie', 'a_joueur_parametre__MODIFIER']) ) ? $colonnes['a_joueur_parametre_Valeur_choisie'] : ( isset($a_joueur_parametre['a_joueur_parametre_Valeur_choisie']) ? $a_joueur_parametre['a_joueur_parametre_Valeur_choisie'] : '' ) );
                $a_joueur_parametre_Actif = ( isset($colonnes['a_joueur_parametre_Actif']) && ( $force || mf_matrice_droits(['api_modifier__a_joueur_parametre_Actif', 'a_joueur_parametre__MODIFIER']) ) ? $colonnes['a_joueur_parametre_Actif'] : ( isset($a_joueur_parametre['a_joueur_parametre_Actif']) ? $a_joueur_parametre['a_joueur_parametre_Actif'] : '' ) );
                $retour = $this->mf_modifier($Code_joueur, $Code_parametre, $a_joueur_parametre_Valeur_choisie, $a_joueur_parametre_Actif, true);
                if ( $retour['code_erreur']!=0 && $retour['code_erreur'] != ERR_A_JOUEUR_PARAMETRE__MODIFIER__AUCUN_CHANGEMENT )
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
                if ( $colonne=='a_joueur_parametre_Valeur_choisie' || $colonne=='a_joueur_parametre_Actif' )
                {
                    if ( isset($colonnes['Code_joueur']) && isset($colonnes['Code_parametre']) )
                    {
                        $valeurs_en_colonnes[$colonne]['Code_joueur='.$colonnes['Code_joueur'] . ' AND ' . 'Code_parametre='.$colonnes['Code_parametre']]=$valeur;
                        $liste_valeurs_indexees[$colonne][''.$valeur][]='Code_joueur='.$colonnes['Code_joueur'] . ' AND ' . 'Code_parametre='.$colonnes['Code_parametre'];
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
                executer_requete_mysql('UPDATE ' . inst('a_joueur_parametre') . ' SET ' . $colonne . ' = ' . $modification_sql . ' WHERE ' . $perimetre . ';', true);
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
                    executer_requete_mysql('UPDATE ' . inst('a_joueur_parametre') . ' SET ' . $colonne . ' = ' . format_sql($colonne, $valeur) . ' WHERE ' . $perimetre . ';', true);
                    if ( requete_mysqli_affected_rows()!=0 )
                    {
                        $modifs = true;
                    }
                }
            }
        }

        if ( ! $modifs && $code_erreur==0 )
        {
            $code_erreur = ERR_A_JOUEUR_PARAMETRE__MODIFIER_3__AUCUN_CHANGEMENT;
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

    public function mf_modifier_4(int $Code_joueur, int $Code_parametre, array $data, ?array $options = null ) // $data = array('colonne1' => 'valeur1', ... ) / $options = [ 'cond_mysql' => [], 'limit' => 0 ]
    {
        if ( $options===null ) { $options=[]; }
        $code_erreur = 0;
        $Code_joueur = round($Code_joueur);
        $Code_parametre = round($Code_parametre);
        $mf_colonnes_a_modifier=[];
        if ( isset($data['a_joueur_parametre_Valeur_choisie']) ) { $mf_colonnes_a_modifier[] = 'a_joueur_parametre_Valeur_choisie = ' . format_sql('a_joueur_parametre_Valeur_choisie', $data['a_joueur_parametre_Valeur_choisie']); }
        if ( isset($data['a_joueur_parametre_Actif']) ) { $mf_colonnes_a_modifier[] = 'a_joueur_parametre_Actif = ' . format_sql('a_joueur_parametre_Actif', $data['a_joueur_parametre_Actif']); }
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

            $requete = 'UPDATE ' . inst('a_joueur_parametre') . ' SET ' . enumeration($mf_colonnes_a_modifier) . " WHERE 1".( $Code_joueur!=0 ? " AND Code_joueur=$Code_joueur" : "" )."".( $Code_parametre!=0 ? " AND Code_parametre=$Code_parametre" : "" )."$argument_cond" . ( $limit>0 ? ' LIMIT ' . $limit : '' ) . ";";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_A_JOUEUR_PARAMETRE__MODIFIER_4__AUCUN_CHANGEMENT;
            }
            else
            {
                self::$cache_db->clear();
            }
            self::$cache_db->reprendre($cle);
        }
        return array('code_erreur' => $code_erreur);
    }

    public function mf_supprimer(?int $Code_joueur=null, ?int $Code_parametre=null, ?bool $force=null)
    {
        if ( $force===null ) { $force=false; }
        $code_erreur = 0;
        $Code_joueur = round($Code_joueur);
        $Code_parametre = round($Code_parametre);
        $copie__liste_a_joueur_parametre = $this->mf_lister($Code_joueur, $Code_parametre, array('autocompletion' => false));
        $liste_Code_joueur = array();
        $liste_Code_parametre = array();
        foreach ( $copie__liste_a_joueur_parametre as $copie__a_joueur_parametre )
        {
            $Code_joueur = $copie__a_joueur_parametre['Code_joueur'];
            $Code_parametre = $copie__a_joueur_parametre['Code_parametre'];
            if (!$force)
            {
                if (!self::$maj_droits_supprimer_en_cours)
                {
                    self::$maj_droits_supprimer_en_cours = true;
                    Hook_a_joueur_parametre::hook_actualiser_les_droits_supprimer($Code_joueur, $Code_parametre);
                    self::$maj_droits_supprimer_en_cours = false;
                }
            }
            if ( !$force && !mf_matrice_droits(['a_joueur_parametre__SUPPRIMER']) ) $code_erreur = REFUS_A_JOUEUR_PARAMETRE__SUPPRIMER;
            elseif ( !Hook_a_joueur_parametre::autorisation_suppression($Code_joueur, $Code_parametre) ) $code_erreur = REFUS_A_JOUEUR_PARAMETRE__SUPPRESSION_BLOQUEE;
            {
                $liste_Code_joueur[] = $Code_joueur;
                $liste_Code_parametre[] = $Code_parametre;
            }
        }
        if ( $code_erreur==0 && count($liste_Code_joueur)>0 && count($liste_Code_parametre)>0 )
        {
            $requete = "DELETE IGNORE FROM ".inst('a_joueur_parametre')." WHERE Code_joueur IN ".Sql_Format_Liste($liste_Code_joueur)." AND Code_parametre IN ".Sql_Format_Liste($liste_Code_parametre).";";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_A_JOUEUR_PARAMETRE__SUPPRIMER__REFUSE;
                self::$cache_db->reprendre($cle);
            }
            else
            {
                self::$cache_db->clear();
                self::$cache_db->reprendre($cle);
                Hook_a_joueur_parametre::supprimer($copie__liste_a_joueur_parametre);
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

    public function mf_supprimer_2(?int $Code_joueur=null, ?int $Code_parametre=null)
    {
        $code_erreur = 0;
        $Code_joueur = round($Code_joueur);
        $Code_parametre = round($Code_parametre);
        $copie__liste_a_joueur_parametre = $this->mf_lister_2($Code_joueur, $Code_parametre, array('autocompletion' => false));
        $requete = 'DELETE IGNORE FROM ' . inst('a_joueur_parametre') . " WHERE 1".( $Code_joueur!=0 ? " AND Code_joueur=$Code_joueur" : "" )."".( $Code_parametre!=0 ? " AND Code_parametre=$Code_parametre" : "" ).";";
        $cle = md5($requete).salt(10);
        self::$cache_db->pause($cle);
        executer_requete_mysql( $requete , true);
        if ( requete_mysqli_affected_rows()==0 )
        {
            $code_erreur = ERR_A_JOUEUR_PARAMETRE__SUPPRIMER_2__REFUSE;
            self::$cache_db->reprendre($cle);
        }
        else
        {
            self::$cache_db->clear();
            self::$cache_db->reprendre($cle);
            Hook_a_joueur_parametre::supprimer($copie__liste_a_joueur_parametre);
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
        return $this->mf_lister(isset($est_charge['joueur']) ? $mf_contexte['Code_joueur'] : 0, isset($est_charge['parametre']) ? $mf_contexte['Code_parametre'] : 0, $options);
    }

    public function mf_lister(?int $Code_joueur=null, ?int $Code_parametre=null, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $liste = $this->mf_lister_2($Code_joueur, $Code_parametre, $options);

        // controle_acces_donnees
        $controle_acces_donnees = CONTROLE_ACCES_DONNEES_DEFAUT;
        if (isset($options['controle_acces_donnees']))
        {
            $controle_acces_donnees = ( $options['controle_acces_donnees']==true );
        }

        foreach ($liste as $key => $elem)
        {
            if ( $controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_joueur', $elem['Code_joueur']) || $controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_parametre', $elem['Code_parametre']) )
            {
                unset($liste[$key]);
            }
        }

        return $liste;
    }

    public function mf_lister_2(?int $Code_joueur=null, ?int $Code_parametre=null, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cle = "a_joueur_parametre__lister";
        $Code_joueur = round($Code_joueur);
        $cle.="_{$Code_joueur}";
        $Code_parametre = round($Code_parametre);
        $cle.="_{$Code_parametre}";

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
            if ( isset($mf_tri_defaut_table['a_joueur_parametre']) )
            {
                $options['tris'] = $mf_tri_defaut_table['a_joueur_parametre'];
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

        if ( ! $liste = self::$cache_db->read($cle) )
        {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ( $argument_cond!='' )
            {
                if ( strpos($argument_cond, 'a_joueur_parametre_Valeur_choisie')!==false ) { $liste_colonnes_a_indexer['a_joueur_parametre_Valeur_choisie'] = 'a_joueur_parametre_Valeur_choisie'; }
                if ( strpos($argument_cond, 'a_joueur_parametre_Actif')!==false ) { $liste_colonnes_a_indexer['a_joueur_parametre_Actif'] = 'a_joueur_parametre_Actif'; }
            }
            if ( isset($options['tris']) )
            {
                if ( isset($options['tris']['a_joueur_parametre_Valeur_choisie']) ) { $liste_colonnes_a_indexer['a_joueur_parametre_Valeur_choisie'] = 'a_joueur_parametre_Valeur_choisie'; }
                if ( isset($options['tris']['a_joueur_parametre_Actif']) ) { $liste_colonnes_a_indexer['a_joueur_parametre_Actif'] = 'a_joueur_parametre_Actif'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = self::$cache_db->read('a_joueur_parametre__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('a_joueur_parametre').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    self::$cache_db->write('a_joueur_parametre__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    self::$cache_db->pause('a_joueur_parametre__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('a_joueur_parametre').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    self::$cache_db->clear();
                    self::$cache_db->reprendre('a_joueur_parametre__index');
                }
            }

            $liste = array();
            if ($toutes_colonnes)
            {
                $colonnes='a_joueur_parametre_Valeur_choisie, a_joueur_parametre_Actif, Code_joueur, Code_parametre';
            }
            else
            {
                $colonnes='a_joueur_parametre_Valeur_choisie, a_joueur_parametre_Actif, Code_joueur, Code_parametre';
            }
            $res_requete = executer_requete_mysql('SELECT ' . $colonnes . ' FROM '.inst('a_joueur_parametre')." WHERE 1{$argument_cond}".( $Code_joueur!=0 ? " AND Code_joueur=$Code_joueur" : "" )."".( $Code_parametre!=0 ? " AND Code_parametre=$Code_parametre" : "" )."{$argument_tris}{$argument_limit};", false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                mf_formatage_db_type_php($row_requete);
                $liste[$row_requete['Code_joueur'].'-'.$row_requete['Code_parametre']] = $row_requete;
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
                Hook_a_joueur_parametre::completion($element);
                self::$auto_completion = false;
            }
        }
        unset($element);
        return $liste;
    }

    public function mf_get(int $Code_joueur, int $Code_parametre, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cle = "a_joueur_parametre__get";
        $Code_joueur = round($Code_joueur);
        $cle.="_{$Code_joueur}";
        $Code_parametre = round($Code_parametre);
        $cle.="_{$Code_parametre}";
        $retour = array();
        if ( ! CONTROLE_ACCES_DONNEES_DEFAUT || Hook_mf_systeme::controle_acces_donnees('Code_joueur', $Code_joueur) && Hook_mf_systeme::controle_acces_donnees('Code_parametre', $Code_parametre) )
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
                    $colonnes='a_joueur_parametre_Valeur_choisie, a_joueur_parametre_Actif, Code_joueur, Code_parametre';
                }
                else
                {
                    $colonnes='a_joueur_parametre_Valeur_choisie, a_joueur_parametre_Actif, Code_joueur, Code_parametre';
                }
                $res_requete = executer_requete_mysql('SELECT ' . $colonnes . " FROM ".inst('a_joueur_parametre')." WHERE Code_joueur=$Code_joueur AND Code_parametre=$Code_parametre;", false);
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
                    Hook_a_joueur_parametre::completion($retour);
                    self::$auto_completion = false;
                }
            }
        }
        return $retour;
    }

    public function mf_get_2(int $Code_joueur, int $Code_parametre, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cle = "a_joueur_parametre__get";
        $Code_joueur = round($Code_joueur);
        $cle.="_{$Code_joueur}";
        $Code_parametre = round($Code_parametre);
        $cle.="_{$Code_parametre}";

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
                $colonnes='a_joueur_parametre_Valeur_choisie, a_joueur_parametre_Actif, Code_joueur, Code_parametre';
            }
            else
            {
                $colonnes='a_joueur_parametre_Valeur_choisie, a_joueur_parametre_Actif, Code_joueur, Code_parametre';
            }
            $res_requete = executer_requete_mysql('SELECT ' . $colonnes . " FROM ".inst('a_joueur_parametre')." WHERE Code_joueur=$Code_joueur AND Code_parametre=$Code_parametre;", false);
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
                Hook_a_joueur_parametre::completion($retour);
                self::$auto_completion = false;
            }
        }
        return $retour;
    }

    public function mf_compter(?int $Code_joueur=null, ?int $Code_parametre=null, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cle = 'a_joueur_parametre__compter';
        $Code_joueur = round($Code_joueur);
        $cle.='_{'.$Code_joueur.'}';
        $Code_parametre = round($Code_parametre);
        $cle.='_{'.$Code_parametre.'}';

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
                if ( strpos($argument_cond, 'a_joueur_parametre_Valeur_choisie')!==false ) { $liste_colonnes_a_indexer['a_joueur_parametre_Valeur_choisie'] = 'a_joueur_parametre_Valeur_choisie'; }
                if ( strpos($argument_cond, 'a_joueur_parametre_Actif')!==false ) { $liste_colonnes_a_indexer['a_joueur_parametre_Actif'] = 'a_joueur_parametre_Actif'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = self::$cache_db->read('a_joueur_parametre__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('a_joueur_parametre').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    self::$cache_db->write('a_joueur_parametre__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    self::$cache_db->pause('a_joueur_parametre__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('a_joueur_parametre').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    self::$cache_db->clear();
                    self::$cache_db->reprendre('a_joueur_parametre__index');
                }
            }

            $res_requete = executer_requete_mysql("SELECT COUNT(CONCAT(Code_joueur,'|',Code_parametre)) as nb FROM ".inst('a_joueur_parametre')." WHERE 1{$argument_cond}".( $Code_joueur!=0 ? " AND Code_joueur=$Code_joueur" : "" )."".( $Code_parametre!=0 ? " AND Code_parametre=$Code_parametre" : "" ).";", false);
            $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC);
            mysqli_free_result($res_requete);
            $nb = (int) $row_requete['nb'];
            self::$cache_db->write($cle, $nb);
        }
        return $nb;
    }

    public function mf_liste_Code_joueur_vers_liste_Code_parametre( array $liste_Code_joueur, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ( $options===null ) { $options=[]; }
        return $this->a_joueur_parametre_liste_Code_joueur_vers_liste_Code_parametre( $liste_Code_joueur , $options );
    }

    public function mf_liste_Code_parametre_vers_liste_Code_joueur( array $liste_Code_parametre, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ( $options===null ) { $options=[]; }
        return $this->a_joueur_parametre_liste_Code_parametre_vers_liste_Code_joueur( $liste_Code_parametre , $options );
    }

}
