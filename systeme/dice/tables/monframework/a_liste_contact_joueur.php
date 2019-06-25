<?php

/*
    +------------------------------+
    |  NE PAS MODIFIER CE FICHIER  |
    +------------------------------+
*/

class a_liste_contact_joueur_monframework extends entite_monframework
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
            include_once __DIR__ . '/../../erreurs/erreurs__a_liste_contact_joueur.php';
            self::$initialisation = false;
            Hook_a_liste_contact_joueur::initialisation();
            self::$cache_db = new Mf_Cachedb('a_liste_contact_joueur');
        }
        if (!self::$actualisation_en_cours)
        {
            self::$actualisation_en_cours=true;
            Hook_a_liste_contact_joueur::actualisation();
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

        if ( ! test_si_table_existe(inst('a_liste_contact_joueur')) )
        {
            executer_requete_mysql('CREATE TABLE '.inst('a_liste_contact_joueur').' (Code_liste_contacts INT NOT NULL, Code_joueur INT NOT NULL, PRIMARY KEY (Code_liste_contacts, Code_joueur)) ENGINE=MyISAM;', true);
        }

        $liste_colonnes = lister_les_colonnes(inst('a_liste_contact_joueur'));

        if ( isset($liste_colonnes['a_liste_contact_joueur_Date_creation']) )
        {
            if ( typeMyql2Sql($liste_colonnes['a_liste_contact_joueur_Date_creation']['Type'])!='DATETIME' )
            {
                executer_requete_mysql('ALTER TABLE '.inst('a_liste_contact_joueur').' CHANGE a_liste_contact_joueur_Date_creation a_liste_contact_joueur_Date_creation DATETIME;', true);
            }
            unset($liste_colonnes['a_liste_contact_joueur_Date_creation']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('a_liste_contact_joueur').' ADD a_liste_contact_joueur_Date_creation DATETIME;', true);
            executer_requete_mysql('UPDATE '.inst('a_liste_contact_joueur').' SET a_liste_contact_joueur_Date_creation=' . format_sql('a_liste_contact_joueur_Date_creation', $mf_initialisation['a_liste_contact_joueur_Date_creation']) . ';', true);
        }

        unset($liste_colonnes['Code_liste_contacts']);
        unset($liste_colonnes['Code_joueur']);

        foreach ($liste_colonnes as $field => $value)
        {
            executer_requete_mysql('ALTER TABLE '.inst('a_liste_contact_joueur').' DROP COLUMN '.$field.';', true);
        }

    }

    public function mfi_ajouter_auto(array $interface)
    {
        if (isset($interface['Code_liste_contacts'])) { $liste_Code_liste_contacts = array($interface['Code_liste_contacts']); }
        elseif (isset($interface['liste_Code_liste_contacts'])) { $liste_Code_liste_contacts = $interface['liste_Code_liste_contacts']; }
        else { $liste_Code_liste_contacts = $this->get_liste_Code_liste_contacts(); }
        if (isset($interface['Code_joueur'])) { $liste_Code_joueur = array($interface['Code_joueur']); }
        elseif (isset($interface['liste_Code_joueur'])) { $liste_Code_joueur = $interface['liste_Code_joueur']; }
        else { $liste_Code_joueur = $this->get_liste_Code_joueur(); }
        $liste_a_liste_contact_joueur = array();
        foreach ($liste_Code_liste_contacts as $Code_liste_contacts)
        {
            foreach ($liste_Code_joueur as $Code_joueur)
            {
                $liste_a_liste_contact_joueur[] = array('Code_liste_contacts'=>$Code_liste_contacts,'Code_joueur'=>$Code_joueur);
            }
        }
        if (isset($interface['a_liste_contact_joueur_Date_creation'])) { foreach ($liste_a_liste_contact_joueur as &$a_liste_contact_joueur) { $a_liste_contact_joueur['a_liste_contact_joueur_Date_creation'] = $interface['a_liste_contact_joueur_Date_creation']; } unset($a_liste_contact_joueur); }
        return $this->mf_ajouter_3($liste_a_liste_contact_joueur);
    }

    public function mfi_supprimer_auto(array $interface)
    {
        if (isset($interface['Code_liste_contacts'])) { $liste_Code_liste_contacts = array($interface['Code_liste_contacts']); }
        elseif (isset($interface['liste_Code_liste_contacts'])) { $liste_Code_liste_contacts = $interface['liste_Code_liste_contacts']; }
        else { $liste_Code_liste_contacts = $this->get_liste_Code_liste_contacts(); }
        if (isset($interface['Code_joueur'])) { $liste_Code_joueur = array($interface['Code_joueur']); }
        elseif (isset($interface['liste_Code_joueur'])) { $liste_Code_joueur = $interface['liste_Code_joueur']; }
        else { $liste_Code_joueur = $this->get_liste_Code_joueur(); }
        foreach ($liste_Code_liste_contacts as $Code_liste_contacts)
        {
            foreach ($liste_Code_joueur as $Code_joueur)
            {
                $this->mf_supprimer_2($Code_liste_contacts, $Code_joueur);
            }
        }
    }

    public function mf_ajouter(int $Code_liste_contacts, int $Code_joueur, string $a_liste_contact_joueur_Date_creation, ?bool $force=null)
    {
        if ( $force===null ) { $force=false; }
        $code_erreur = 0;
        $Code_liste_contacts = round($Code_liste_contacts);
        $Code_joueur = round($Code_joueur);
        $a_liste_contact_joueur_Date_creation = format_datetime($a_liste_contact_joueur_Date_creation);
        Hook_a_liste_contact_joueur::pre_controller($a_liste_contact_joueur_Date_creation, $Code_liste_contacts, $Code_joueur);
        if (!$force)
        {
            if (!self::$maj_droits_ajouter_en_cours)
            {
                self::$maj_droits_ajouter_en_cours = true;
                Hook_a_liste_contact_joueur::hook_actualiser_les_droits_ajouter($Code_liste_contacts, $Code_joueur);
                self::$maj_droits_ajouter_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['a_liste_contact_joueur__AJOUTER']) ) $code_erreur = REFUS_A_LISTE_CONTACT_JOUEUR__AJOUTER;
        elseif ( !$this->mf_tester_existance_Code_liste_contacts($Code_liste_contacts) ) $code_erreur = ERR_A_LISTE_CONTACT_JOUEUR__AJOUTER__CODE_LISTE_CONTACTS_INEXISTANT;
        elseif ( !$this->mf_tester_existance_Code_joueur($Code_joueur) ) $code_erreur = ERR_A_LISTE_CONTACT_JOUEUR__AJOUTER__CODE_JOUEUR_INEXISTANT;
        elseif ( $this->mf_tester_existance_a_liste_contact_joueur( $Code_liste_contacts, $Code_joueur ) ) $code_erreur = ERR_A_LISTE_CONTACT_JOUEUR__AJOUTER__DOUBLON;
        elseif ( CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_liste_contacts', $Code_liste_contacts) ) $code_erreur = ACCES_CODE_LISTE_CONTACTS_REFUSE;
        elseif ( CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_joueur', $Code_joueur) ) $code_erreur = ACCES_CODE_JOUEUR_REFUSE;
        elseif ( !Hook_a_liste_contact_joueur::autorisation_ajout($a_liste_contact_joueur_Date_creation, $Code_liste_contacts, $Code_joueur) ) $code_erreur = REFUS_A_LISTE_CONTACT_JOUEUR__AJOUT_BLOQUEE;
        else
        {
            Hook_a_liste_contact_joueur::data_controller($a_liste_contact_joueur_Date_creation, $Code_liste_contacts, $Code_joueur);
            $a_liste_contact_joueur_Date_creation = format_datetime($a_liste_contact_joueur_Date_creation);
            $requete = 'INSERT INTO '.inst('a_liste_contact_joueur')." ( a_liste_contact_joueur_Date_creation, Code_liste_contacts, Code_joueur ) VALUES ( ".( $a_liste_contact_joueur_Date_creation!='' ? "'$a_liste_contact_joueur_Date_creation'" : 'NULL' ).", $Code_liste_contacts, $Code_joueur );";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql($requete, true);
            $n = requete_mysqli_affected_rows();
            if ($n==0)
            {
                $code_erreur = ERR_A_LISTE_CONTACT_JOUEUR__AJOUTER__REFUSE;
                self::$cache_db->reprendre($cle);
            }
            else
            {
                self::$cache_db->clear();
                self::$cache_db->reprendre($cle);
                Hook_a_liste_contact_joueur::ajouter($Code_liste_contacts, $Code_joueur);
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
        return array('code_erreur' => $code_erreur, 'callback' => ( $code_erreur==0 ? Hook_a_liste_contact_joueur::callback_post($Code_liste_contacts, $Code_joueur) : null ));
    }

    public function mf_ajouter_2(array $ligne, ?bool $force=null) // array('colonne1' => 'valeur1',  [...] )
    {
        if ( $force===null ) { $force=false; }
        global $mf_initialisation;
        $Code_liste_contacts = (int)(isset($ligne['Code_liste_contacts'])?round($ligne['Code_liste_contacts']):0);
        $Code_joueur = (int)(isset($ligne['Code_joueur'])?round($ligne['Code_joueur']):get_joueur_courant('Code_joueur'));
        $a_liste_contact_joueur_Date_creation = (string)(isset($ligne['a_liste_contact_joueur_Date_creation'])?$ligne['a_liste_contact_joueur_Date_creation']:$mf_initialisation['a_liste_contact_joueur_Date_creation']);
        return $this->mf_ajouter($Code_liste_contacts, $Code_joueur, $a_liste_contact_joueur_Date_creation, $force);
    }

    public function mf_ajouter_3(array $lignes) // array( array( 'colonne1' => 'valeur1', 'colonne2' => 'valeur2',  [...] ), [...] )
    {
        global $mf_initialisation;
        $code_erreur = 0;
        $values = '';
        foreach ($lignes as $ligne)
        {
            $Code_liste_contacts = (isset($ligne['Code_liste_contacts'])?round($ligne['Code_liste_contacts']):0);
            $Code_joueur = (isset($ligne['Code_joueur'])?round($ligne['Code_joueur']):0);
            $a_liste_contact_joueur_Date_creation = format_datetime(isset($ligne['a_liste_contact_joueur_Date_creation'])?$ligne['a_liste_contact_joueur_Date_creation']:$mf_initialisation['a_liste_contact_joueur_Date_creation']);
            if ($Code_liste_contacts != 0)
            {
                if ($Code_joueur != 0)
                {
                    $values.=($values!='' ? ',' : '')."(".( $a_liste_contact_joueur_Date_creation!='' ? "'$a_liste_contact_joueur_Date_creation'" : 'NULL' ).", $Code_liste_contacts, $Code_joueur)";
                }
            }
        }
        if ($values!='')
        {
            $requete = "INSERT INTO ".inst('a_liste_contact_joueur')." ( a_liste_contact_joueur_Date_creation, Code_liste_contacts, Code_joueur ) VALUES $values;";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            $n = requete_mysqli_affected_rows();
            if ($n < count($lignes))
            {
                $code_erreur = ERR_A_LISTE_CONTACT_JOUEUR__AJOUTER_3__ECHEC_AJOUT;
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

    public function mf_modifier(int $Code_liste_contacts, int $Code_joueur, string $a_liste_contact_joueur_Date_creation, ?bool $force=null)
    {
        if ( $force===null ) { $force=false; }
        $code_erreur = 0;
        $Code_liste_contacts = round($Code_liste_contacts);
        $Code_joueur = round($Code_joueur);
        $a_liste_contact_joueur_Date_creation = format_datetime($a_liste_contact_joueur_Date_creation);
        Hook_a_liste_contact_joueur::pre_controller($a_liste_contact_joueur_Date_creation, $Code_liste_contacts, $Code_joueur);
        if (!$force)
        {
            if (!self::$maj_droits_modifier_en_cours)
            {
                self::$maj_droits_modifier_en_cours = true;
                Hook_a_liste_contact_joueur::hook_actualiser_les_droits_modifier($Code_liste_contacts, $Code_joueur);
                self::$maj_droits_modifier_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['a_liste_contact_joueur__MODIFIER']) ) $code_erreur = REFUS_A_LISTE_CONTACT_JOUEUR__MODIFIER;
        elseif ( !$this->mf_tester_existance_Code_liste_contacts($Code_liste_contacts) ) $code_erreur = ERR_A_LISTE_CONTACT_JOUEUR__MODIFIER__CODE_LISTE_CONTACTS_INEXISTANT;
        elseif ( !$this->mf_tester_existance_Code_joueur($Code_joueur) ) $code_erreur = ERR_A_LISTE_CONTACT_JOUEUR__MODIFIER__CODE_JOUEUR_INEXISTANT;
        elseif ( !$this->mf_tester_existance_a_liste_contact_joueur( $Code_liste_contacts, $Code_joueur ) ) $code_erreur = ERR_A_LISTE_CONTACT_JOUEUR__MODIFIER__INEXISTANT;
        elseif ( CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_liste_contacts', $Code_liste_contacts) ) $code_erreur = ACCES_CODE_LISTE_CONTACTS_REFUSE;
        elseif ( CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_joueur', $Code_joueur) ) $code_erreur = ACCES_CODE_JOUEUR_REFUSE;
        elseif ( !Hook_a_liste_contact_joueur::autorisation_modification($Code_liste_contacts, $Code_joueur, $a_liste_contact_joueur_Date_creation) ) $code_erreur = REFUS_A_LISTE_CONTACT_JOUEUR__MODIFICATION_BLOQUEE;
        else
        {
            Hook_a_liste_contact_joueur::data_controller($a_liste_contact_joueur_Date_creation, $Code_liste_contacts, $Code_joueur);
            $a_liste_contact_joueur = $this->mf_get_2( $Code_liste_contacts, $Code_joueur, array('autocompletion' => false) );
            $mf_colonnes_a_modifier=[];
            $bool__a_liste_contact_joueur_Date_creation = false; if ( $a_liste_contact_joueur_Date_creation!=$a_liste_contact_joueur['a_liste_contact_joueur_Date_creation'] ) { Hook_a_liste_contact_joueur::data_controller__a_liste_contact_joueur_Date_creation($a_liste_contact_joueur['a_liste_contact_joueur_Date_creation'], $a_liste_contact_joueur_Date_creation, $Code_liste_contacts, $Code_joueur); if ( $a_liste_contact_joueur_Date_creation!=$a_liste_contact_joueur['a_liste_contact_joueur_Date_creation'] ) { $mf_colonnes_a_modifier[] = 'a_liste_contact_joueur_Date_creation=' . format_sql('a_liste_contact_joueur_Date_creation', $a_liste_contact_joueur_Date_creation); $bool__a_liste_contact_joueur_Date_creation = true; } }
            if (count($mf_colonnes_a_modifier)>0) {
                $requete = 'UPDATE ' . inst('a_liste_contact_joueur') . ' SET ' . enumeration($mf_colonnes_a_modifier) . " WHERE Code_liste_contacts=$Code_liste_contacts AND Code_joueur=$Code_joueur;";
                $cle = md5($requete).salt(10);
                self::$cache_db->pause($cle);
                executer_requete_mysql($requete, true);
                if ( requete_mysqli_affected_rows()==0 )
                {
                    $code_erreur = ERR_A_LISTE_CONTACT_JOUEUR__MODIFIER__AUCUN_CHANGEMENT;
                    self::$cache_db->reprendre($cle);
                }
                else
                {
                    self::$cache_db->clear();
                    self::$cache_db->reprendre($cle);
                    Hook_a_liste_contact_joueur::modifier($Code_liste_contacts, $Code_joueur, $bool__a_liste_contact_joueur_Date_creation);
                }
            }
            else
            {
                $code_erreur = ERR_A_LISTE_CONTACT_JOUEUR__MODIFIER__AUCUN_CHANGEMENT;
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
        return array('code_erreur' => $code_erreur, 'callback' => ( $code_erreur == 0 ? Hook_a_liste_contact_joueur::callback_put($Code_liste_contacts, $Code_joueur) : null ));
    }

    public function mf_modifier_2(array $lignes, ?bool $force=null) // array( array('Code_' => $Code, ..., 'colonne1' => 'valeur1', [...] ), [...] )
    {
        if ( $force===null ) { $force=false; }
        $code_erreur = 0;
        foreach ( $lignes as $colonnes )
        {
            if ( $code_erreur==0 )
            {
                $Code_liste_contacts = ( isset($colonnes['Code_liste_contacts']) ? $colonnes['Code_liste_contacts'] : 0 );
                $Code_joueur = ( isset($colonnes['Code_joueur']) ? $colonnes['Code_joueur'] : 0 );
                $a_liste_contact_joueur = $this->mf_get_2($Code_liste_contacts, $Code_joueur, array('autocompletion' => false));
                if (!$force)
                {
                    if (!self::$maj_droits_modifier_en_cours)
                    {
                        self::$maj_droits_modifier_en_cours = true;
                        Hook_a_liste_contact_joueur::hook_actualiser_les_droits_modifier($Code_liste_contacts, $Code_joueur);
                        self::$maj_droits_modifier_en_cours = false;
                    }
                }
                $a_liste_contact_joueur_Date_creation = ( isset($colonnes['a_liste_contact_joueur_Date_creation']) && ( $force || mf_matrice_droits(['api_modifier__a_liste_contact_joueur_Date_creation', 'a_liste_contact_joueur__MODIFIER']) ) ? $colonnes['a_liste_contact_joueur_Date_creation'] : ( isset($a_liste_contact_joueur['a_liste_contact_joueur_Date_creation']) ? $a_liste_contact_joueur['a_liste_contact_joueur_Date_creation'] : '' ) );
                $retour = $this->mf_modifier($Code_liste_contacts, $Code_joueur, $a_liste_contact_joueur_Date_creation, true);
                if ( $retour['code_erreur']!=0 && $retour['code_erreur'] != ERR_A_LISTE_CONTACT_JOUEUR__MODIFIER__AUCUN_CHANGEMENT )
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
                if ( $colonne=='a_liste_contact_joueur_Date_creation' )
                {
                    if ( isset($colonnes['Code_liste_contacts']) && isset($colonnes['Code_joueur']) )
                    {
                        $valeurs_en_colonnes[$colonne]['Code_liste_contacts='.$colonnes['Code_liste_contacts'] . ' AND ' . 'Code_joueur='.$colonnes['Code_joueur']]=$valeur;
                        $liste_valeurs_indexees[$colonne][''.$valeur][]='Code_liste_contacts='.$colonnes['Code_liste_contacts'] . ' AND ' . 'Code_joueur='.$colonnes['Code_joueur'];
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
                executer_requete_mysql('UPDATE ' . inst('a_liste_contact_joueur') . ' SET ' . $colonne . ' = ' . $modification_sql . ' WHERE ' . $perimetre . ';', true);
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
                    executer_requete_mysql('UPDATE ' . inst('a_liste_contact_joueur') . ' SET ' . $colonne . ' = ' . format_sql($colonne, $valeur) . ' WHERE ' . $perimetre . ';', true);
                    if ( requete_mysqli_affected_rows()!=0 )
                    {
                        $modifs = true;
                    }
                }
            }
        }

        if ( ! $modifs && $code_erreur==0 )
        {
            $code_erreur = ERR_A_LISTE_CONTACT_JOUEUR__MODIFIER_3__AUCUN_CHANGEMENT;
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

    public function mf_modifier_4(int $Code_liste_contacts, int $Code_joueur, array $data, ?array $options = null ) // $data = array('colonne1' => 'valeur1', ... ) / $options = [ 'cond_mysql' => [], 'limit' => 0 ]
    {
        if ( $options===null ) { $options=[]; }
        $code_erreur = 0;
        $Code_liste_contacts = round($Code_liste_contacts);
        $Code_joueur = round($Code_joueur);
        $mf_colonnes_a_modifier=[];
        if ( isset($data['a_liste_contact_joueur_Date_creation']) ) { $mf_colonnes_a_modifier[] = 'a_liste_contact_joueur_Date_creation = ' . format_sql('a_liste_contact_joueur_Date_creation', $data['a_liste_contact_joueur_Date_creation']); }
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

            $requete = 'UPDATE ' . inst('a_liste_contact_joueur') . ' SET ' . enumeration($mf_colonnes_a_modifier) . " WHERE 1".( $Code_liste_contacts!=0 ? " AND Code_liste_contacts=$Code_liste_contacts" : "" )."".( $Code_joueur!=0 ? " AND Code_joueur=$Code_joueur" : "" )."$argument_cond" . ( $limit>0 ? ' LIMIT ' . $limit : '' ) . ";";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_A_LISTE_CONTACT_JOUEUR__MODIFIER_4__AUCUN_CHANGEMENT;
            }
            else
            {
                self::$cache_db->clear();
            }
            self::$cache_db->reprendre($cle);
        }
        return array('code_erreur' => $code_erreur);
    }

    public function mf_supprimer(?int $Code_liste_contacts=null, ?int $Code_joueur=null, ?bool $force=null)
    {
        if ( $force===null ) { $force=false; }
        $code_erreur = 0;
        $Code_liste_contacts = round($Code_liste_contacts);
        $Code_joueur = round($Code_joueur);
        $copie__liste_a_liste_contact_joueur = $this->mf_lister($Code_liste_contacts, $Code_joueur, array('autocompletion' => false));
        $liste_Code_liste_contacts = array();
        $liste_Code_joueur = array();
        foreach ( $copie__liste_a_liste_contact_joueur as $copie__a_liste_contact_joueur )
        {
            $Code_liste_contacts = $copie__a_liste_contact_joueur['Code_liste_contacts'];
            $Code_joueur = $copie__a_liste_contact_joueur['Code_joueur'];
            if (!$force)
            {
                if (!self::$maj_droits_supprimer_en_cours)
                {
                    self::$maj_droits_supprimer_en_cours = true;
                    Hook_a_liste_contact_joueur::hook_actualiser_les_droits_supprimer($Code_liste_contacts, $Code_joueur);
                    self::$maj_droits_supprimer_en_cours = false;
                }
            }
            if ( !$force && !mf_matrice_droits(['a_liste_contact_joueur__SUPPRIMER']) ) $code_erreur = REFUS_A_LISTE_CONTACT_JOUEUR__SUPPRIMER;
            elseif ( !Hook_a_liste_contact_joueur::autorisation_suppression($Code_liste_contacts, $Code_joueur) ) $code_erreur = REFUS_A_LISTE_CONTACT_JOUEUR__SUPPRESSION_BLOQUEE;
            {
                $liste_Code_liste_contacts[] = $Code_liste_contacts;
                $liste_Code_joueur[] = $Code_joueur;
            }
        }
        if ( $code_erreur==0 && count($liste_Code_liste_contacts)>0 && count($liste_Code_joueur)>0 )
        {
            $requete = "DELETE IGNORE FROM ".inst('a_liste_contact_joueur')." WHERE Code_liste_contacts IN ".Sql_Format_Liste($liste_Code_liste_contacts)." AND Code_joueur IN ".Sql_Format_Liste($liste_Code_joueur).";";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_A_LISTE_CONTACT_JOUEUR__SUPPRIMER__REFUSE;
                self::$cache_db->reprendre($cle);
            }
            else
            {
                self::$cache_db->clear();
                self::$cache_db->reprendre($cle);
                Hook_a_liste_contact_joueur::supprimer($copie__liste_a_liste_contact_joueur);
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

    public function mf_supprimer_2(?int $Code_liste_contacts=null, ?int $Code_joueur=null)
    {
        $code_erreur = 0;
        $Code_liste_contacts = round($Code_liste_contacts);
        $Code_joueur = round($Code_joueur);
        $copie__liste_a_liste_contact_joueur = $this->mf_lister_2($Code_liste_contacts, $Code_joueur, array('autocompletion' => false));
        $requete = 'DELETE IGNORE FROM ' . inst('a_liste_contact_joueur') . " WHERE 1".( $Code_liste_contacts!=0 ? " AND Code_liste_contacts=$Code_liste_contacts" : "" )."".( $Code_joueur!=0 ? " AND Code_joueur=$Code_joueur" : "" ).";";
        $cle = md5($requete).salt(10);
        self::$cache_db->pause($cle);
        executer_requete_mysql( $requete , true);
        if ( requete_mysqli_affected_rows()==0 )
        {
            $code_erreur = ERR_A_LISTE_CONTACT_JOUEUR__SUPPRIMER_2__REFUSE;
            self::$cache_db->reprendre($cle);
        }
        else
        {
            self::$cache_db->clear();
            self::$cache_db->reprendre($cle);
            Hook_a_liste_contact_joueur::supprimer($copie__liste_a_liste_contact_joueur);
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
        return $this->mf_lister(isset($est_charge['liste_contacts']) ? $mf_contexte['Code_liste_contacts'] : 0, isset($est_charge['joueur']) ? $mf_contexte['Code_joueur'] : 0, $options);
    }

    public function mf_lister(?int $Code_liste_contacts=null, ?int $Code_joueur=null, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $liste = $this->mf_lister_2($Code_liste_contacts, $Code_joueur, $options);

        // controle_acces_donnees
        $controle_acces_donnees = CONTROLE_ACCES_DONNEES_DEFAUT;
        if (isset($options['controle_acces_donnees']))
        {
            $controle_acces_donnees = ( $options['controle_acces_donnees']==true );
        }

        foreach ($liste as $key => $elem)
        {
            if ( $controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_liste_contacts', $elem['Code_liste_contacts']) || $controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_joueur', $elem['Code_joueur']) )
            {
                unset($liste[$key]);
            }
        }

        return $liste;
    }

    public function mf_lister_2(?int $Code_liste_contacts=null, ?int $Code_joueur=null, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cle = "a_liste_contact_joueur__lister";
        $Code_liste_contacts = round($Code_liste_contacts);
        $cle.="_{$Code_liste_contacts}";
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
            if ( isset($mf_tri_defaut_table['a_liste_contact_joueur']) )
            {
                $options['tris'] = $mf_tri_defaut_table['a_liste_contact_joueur'];
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
                if ( strpos($argument_cond, 'a_liste_contact_joueur_Date_creation')!==false ) { $liste_colonnes_a_indexer['a_liste_contact_joueur_Date_creation'] = 'a_liste_contact_joueur_Date_creation'; }
            }
            if ( isset($options['tris']) )
            {
                if ( isset($options['tris']['a_liste_contact_joueur_Date_creation']) ) { $liste_colonnes_a_indexer['a_liste_contact_joueur_Date_creation'] = 'a_liste_contact_joueur_Date_creation'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = self::$cache_db->read('a_liste_contact_joueur__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('a_liste_contact_joueur').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    self::$cache_db->write('a_liste_contact_joueur__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    self::$cache_db->pause('a_liste_contact_joueur__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('a_liste_contact_joueur').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    self::$cache_db->clear();
                    self::$cache_db->reprendre('a_liste_contact_joueur__index');
                }
            }

            $liste = array();
            if ($toutes_colonnes)
            {
                $colonnes='a_liste_contact_joueur_Date_creation, Code_liste_contacts, Code_joueur';
            }
            else
            {
                $colonnes='a_liste_contact_joueur_Date_creation, Code_liste_contacts, Code_joueur';
            }
            $res_requete = executer_requete_mysql('SELECT ' . $colonnes . ' FROM '.inst('a_liste_contact_joueur')." WHERE 1{$argument_cond}".( $Code_liste_contacts!=0 ? " AND Code_liste_contacts=$Code_liste_contacts" : "" )."".( $Code_joueur!=0 ? " AND Code_joueur=$Code_joueur" : "" )."{$argument_tris}{$argument_limit};", false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                mf_formatage_db_type_php($row_requete);
                $liste[$row_requete['Code_liste_contacts'].'-'.$row_requete['Code_joueur']] = $row_requete;
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
                Hook_a_liste_contact_joueur::completion($element);
                self::$auto_completion = false;
            }
        }
        unset($element);
        return $liste;
    }

    public function mf_get(int $Code_liste_contacts, int $Code_joueur, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cle = "a_liste_contact_joueur__get";
        $Code_liste_contacts = round($Code_liste_contacts);
        $cle.="_{$Code_liste_contacts}";
        $Code_joueur = round($Code_joueur);
        $cle.="_{$Code_joueur}";
        $retour = array();
        if ( ! CONTROLE_ACCES_DONNEES_DEFAUT || Hook_mf_systeme::controle_acces_donnees('Code_liste_contacts', $Code_liste_contacts) && Hook_mf_systeme::controle_acces_donnees('Code_joueur', $Code_joueur) )
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
                    $colonnes='a_liste_contact_joueur_Date_creation, Code_liste_contacts, Code_joueur';
                }
                else
                {
                    $colonnes='a_liste_contact_joueur_Date_creation, Code_liste_contacts, Code_joueur';
                }
                $res_requete = executer_requete_mysql('SELECT ' . $colonnes . " FROM ".inst('a_liste_contact_joueur')." WHERE Code_liste_contacts=$Code_liste_contacts AND Code_joueur=$Code_joueur;", false);
                if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
                {
                    $retour = $row_requete;
                }
                mysqli_free_result($res_requete);
                self::$cache_db->write($cle, $retour);
            }
            if ( isset( $retour['Code_liste_contacts'] ) )
            {
                if (!self::$auto_completion && $autocompletion)
                {
                    self::$auto_completion = true;
                    Hook_a_liste_contact_joueur::completion($retour);
                    self::$auto_completion = false;
                }
            }
        }
        return $retour;
    }

    public function mf_get_2(int $Code_liste_contacts, int $Code_joueur, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cle = "a_liste_contact_joueur__get";
        $Code_liste_contacts = round($Code_liste_contacts);
        $cle.="_{$Code_liste_contacts}";
        $Code_joueur = round($Code_joueur);
        $cle.="_{$Code_joueur}";

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
                $colonnes='a_liste_contact_joueur_Date_creation, Code_liste_contacts, Code_joueur';
            }
            else
            {
                $colonnes='a_liste_contact_joueur_Date_creation, Code_liste_contacts, Code_joueur';
            }
            $res_requete = executer_requete_mysql('SELECT ' . $colonnes . " FROM ".inst('a_liste_contact_joueur')." WHERE Code_liste_contacts=$Code_liste_contacts AND Code_joueur=$Code_joueur;", false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $retour = $row_requete;
            }
            mysqli_free_result($res_requete);
            self::$cache_db->write($cle, $retour);
        }
        if ( isset( $retour['Code_liste_contacts'] ) )
        {
            if (!self::$auto_completion && $autocompletion)
            {
                self::$auto_completion = true;
                Hook_a_liste_contact_joueur::completion($retour);
                self::$auto_completion = false;
            }
        }
        return $retour;
    }

    public function mf_compter(?int $Code_liste_contacts=null, ?int $Code_joueur=null, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cle = 'a_liste_contact_joueur__compter';
        $Code_liste_contacts = round($Code_liste_contacts);
        $cle.='_{'.$Code_liste_contacts.'}';
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
                if ( strpos($argument_cond, 'a_liste_contact_joueur_Date_creation')!==false ) { $liste_colonnes_a_indexer['a_liste_contact_joueur_Date_creation'] = 'a_liste_contact_joueur_Date_creation'; }
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = self::$cache_db->read('a_liste_contact_joueur__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('a_liste_contact_joueur').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    self::$cache_db->write('a_liste_contact_joueur__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    self::$cache_db->pause('a_liste_contact_joueur__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('a_liste_contact_joueur').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    self::$cache_db->clear();
                    self::$cache_db->reprendre('a_liste_contact_joueur__index');
                }
            }

            $res_requete = executer_requete_mysql("SELECT COUNT(CONCAT(Code_liste_contacts,'|',Code_joueur)) as nb FROM ".inst('a_liste_contact_joueur')." WHERE 1{$argument_cond}".( $Code_liste_contacts!=0 ? " AND Code_liste_contacts=$Code_liste_contacts" : "" )."".( $Code_joueur!=0 ? " AND Code_joueur=$Code_joueur" : "" ).";", false);
            $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC);
            mysqli_free_result($res_requete);
            $nb = (int) $row_requete['nb'];
            self::$cache_db->write($cle, $nb);
        }
        return $nb;
    }

    public function mf_liste_Code_liste_contacts_vers_liste_Code_joueur( array $liste_Code_liste_contacts, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ( $options===null ) { $options=[]; }
        return $this->a_liste_contact_joueur_liste_Code_liste_contacts_vers_liste_Code_joueur( $liste_Code_liste_contacts , $options );
    }

    public function mf_liste_Code_joueur_vers_liste_Code_liste_contacts( array $liste_Code_joueur, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ( $options===null ) { $options=[]; }
        return $this->a_liste_contact_joueur_liste_Code_joueur_vers_liste_Code_liste_contacts( $liste_Code_joueur , $options );
    }

}
