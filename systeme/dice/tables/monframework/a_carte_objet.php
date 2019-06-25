<?php

/*
    +------------------------------+
    |  NE PAS MODIFIER CE FICHIER  |
    +------------------------------+
*/

class a_carte_objet_monframework extends entite_monframework
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
            include_once __DIR__ . '/../../erreurs/erreurs__a_carte_objet.php';
            self::$initialisation = false;
            Hook_a_carte_objet::initialisation();
            self::$cache_db = new Mf_Cachedb('a_carte_objet');
        }
        if (!self::$actualisation_en_cours)
        {
            self::$actualisation_en_cours=true;
            Hook_a_carte_objet::actualisation();
            self::$actualisation_en_cours=false;
        }
    }

    static function mf_raz_instance()
    {
        self::$initialisation = true;
    }

    static function initialiser_structure()
    {
        if ( ! test_si_table_existe(inst('a_carte_objet')) )
        {
            executer_requete_mysql('CREATE TABLE '.inst('a_carte_objet').' (Code_carte INT NOT NULL, Code_objet INT NOT NULL, PRIMARY KEY (Code_carte, Code_objet)) ENGINE=MyISAM;', true);
        }

        $liste_colonnes = lister_les_colonnes(inst('a_carte_objet'));

        unset($liste_colonnes['Code_carte']);
        unset($liste_colonnes['Code_objet']);

        foreach ($liste_colonnes as $field => $value)
        {
            executer_requete_mysql('ALTER TABLE '.inst('a_carte_objet').' DROP COLUMN '.$field.';', true);
        }

    }

    public function mfi_ajouter_auto(array $interface)
    {
        if (isset($interface['Code_carte'])) { $liste_Code_carte = array($interface['Code_carte']); }
        elseif (isset($interface['liste_Code_carte'])) { $liste_Code_carte = $interface['liste_Code_carte']; }
        else { $liste_Code_carte = $this->get_liste_Code_carte(); }
        if (isset($interface['Code_objet'])) { $liste_Code_objet = array($interface['Code_objet']); }
        elseif (isset($interface['liste_Code_objet'])) { $liste_Code_objet = $interface['liste_Code_objet']; }
        else { $liste_Code_objet = $this->get_liste_Code_objet(); }
        $liste_a_carte_objet = array();
        foreach ($liste_Code_carte as $Code_carte)
        {
            foreach ($liste_Code_objet as $Code_objet)
            {
                $liste_a_carte_objet[] = array('Code_carte'=>$Code_carte,'Code_objet'=>$Code_objet);
            }
        }
        return $this->mf_ajouter_3($liste_a_carte_objet);
    }

    public function mfi_supprimer_auto(array $interface)
    {
        if (isset($interface['Code_carte'])) { $liste_Code_carte = array($interface['Code_carte']); }
        elseif (isset($interface['liste_Code_carte'])) { $liste_Code_carte = $interface['liste_Code_carte']; }
        else { $liste_Code_carte = $this->get_liste_Code_carte(); }
        if (isset($interface['Code_objet'])) { $liste_Code_objet = array($interface['Code_objet']); }
        elseif (isset($interface['liste_Code_objet'])) { $liste_Code_objet = $interface['liste_Code_objet']; }
        else { $liste_Code_objet = $this->get_liste_Code_objet(); }
        foreach ($liste_Code_carte as $Code_carte)
        {
            foreach ($liste_Code_objet as $Code_objet)
            {
                $this->mf_supprimer_2($Code_carte, $Code_objet);
            }
        }
    }

    public function mf_ajouter(int $Code_carte, int $Code_objet, ?bool $force=null)
    {
        if ( $force===null ) { $force=false; }
        $code_erreur = 0;
        $Code_carte = round($Code_carte);
        $Code_objet = round($Code_objet);
        Hook_a_carte_objet::pre_controller($Code_carte, $Code_objet);
        if (!$force)
        {
            if (!self::$maj_droits_ajouter_en_cours)
            {
                self::$maj_droits_ajouter_en_cours = true;
                Hook_a_carte_objet::hook_actualiser_les_droits_ajouter($Code_carte, $Code_objet);
                self::$maj_droits_ajouter_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['a_carte_objet__AJOUTER']) ) $code_erreur = REFUS_A_CARTE_OBJET__AJOUTER;
        elseif ( !$this->mf_tester_existance_Code_carte($Code_carte) ) $code_erreur = ERR_A_CARTE_OBJET__AJOUTER__CODE_CARTE_INEXISTANT;
        elseif ( !$this->mf_tester_existance_Code_objet($Code_objet) ) $code_erreur = ERR_A_CARTE_OBJET__AJOUTER__CODE_OBJET_INEXISTANT;
        elseif ( $this->mf_tester_existance_a_carte_objet( $Code_carte, $Code_objet ) ) $code_erreur = ERR_A_CARTE_OBJET__AJOUTER__DOUBLON;
        elseif ( CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_carte', $Code_carte) ) $code_erreur = ACCES_CODE_CARTE_REFUSE;
        elseif ( CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_objet', $Code_objet) ) $code_erreur = ACCES_CODE_OBJET_REFUSE;
        elseif ( !Hook_a_carte_objet::autorisation_ajout($Code_carte, $Code_objet) ) $code_erreur = REFUS_A_CARTE_OBJET__AJOUT_BLOQUEE;
        else
        {
            Hook_a_carte_objet::data_controller($Code_carte, $Code_objet);
            $requete = 'INSERT INTO '.inst('a_carte_objet')." ( Code_carte, Code_objet ) VALUES ( $Code_carte, $Code_objet );";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql($requete, true);
            $n = requete_mysqli_affected_rows();
            if ($n==0)
            {
                $code_erreur = ERR_A_CARTE_OBJET__AJOUTER__REFUSE;
                self::$cache_db->reprendre($cle);
            }
            else
            {
                self::$cache_db->clear();
                self::$cache_db->reprendre($cle);
                Hook_a_carte_objet::ajouter($Code_carte, $Code_objet);
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
        return array('code_erreur' => $code_erreur, 'callback' => ( $code_erreur==0 ? Hook_a_carte_objet::callback_post($Code_carte, $Code_objet) : null ));
    }

    public function mf_ajouter_2(array $ligne, ?bool $force=null) // array('colonne1' => 'valeur1',  [...] )
    {
        if ( $force===null ) { $force=false; }
        global $mf_initialisation;
        $Code_carte = (int)(isset($ligne['Code_carte'])?round($ligne['Code_carte']):0);
        $Code_objet = (int)(isset($ligne['Code_objet'])?round($ligne['Code_objet']):0);
        return $this->mf_ajouter($Code_carte, $Code_objet, $force);
    }

    public function mf_ajouter_3(array $lignes) // array( array( 'colonne1' => 'valeur1', 'colonne2' => 'valeur2',  [...] ), [...] )
    {
        global $mf_initialisation;
        $code_erreur = 0;
        $values = '';
        foreach ($lignes as $ligne)
        {
            $Code_carte = (isset($ligne['Code_carte'])?round($ligne['Code_carte']):0);
            $Code_objet = (isset($ligne['Code_objet'])?round($ligne['Code_objet']):0);
            if ($Code_carte != 0)
            {
                if ($Code_objet != 0)
                {
                    $values.=($values!='' ? ',' : '')."($Code_carte, $Code_objet)";
                }
            }
        }
        if ($values!='')
        {
            $requete = "INSERT INTO ".inst('a_carte_objet')." ( Code_carte, Code_objet ) VALUES $values;";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            $n = requete_mysqli_affected_rows();
            if ($n < count($lignes))
            {
                $code_erreur = ERR_A_CARTE_OBJET__AJOUTER_3__ECHEC_AJOUT;
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

    public function mf_supprimer(?int $Code_carte=null, ?int $Code_objet=null, ?bool $force=null)
    {
        if ( $force===null ) { $force=false; }
        $code_erreur = 0;
        $Code_carte = round($Code_carte);
        $Code_objet = round($Code_objet);
        $copie__liste_a_carte_objet = $this->mf_lister($Code_carte, $Code_objet, array('autocompletion' => false));
        $liste_Code_carte = array();
        $liste_Code_objet = array();
        foreach ( $copie__liste_a_carte_objet as $copie__a_carte_objet )
        {
            $Code_carte = $copie__a_carte_objet['Code_carte'];
            $Code_objet = $copie__a_carte_objet['Code_objet'];
            if (!$force)
            {
                if (!self::$maj_droits_supprimer_en_cours)
                {
                    self::$maj_droits_supprimer_en_cours = true;
                    Hook_a_carte_objet::hook_actualiser_les_droits_supprimer($Code_carte, $Code_objet);
                    self::$maj_droits_supprimer_en_cours = false;
                }
            }
            if ( !$force && !mf_matrice_droits(['a_carte_objet__SUPPRIMER']) ) $code_erreur = REFUS_A_CARTE_OBJET__SUPPRIMER;
            elseif ( !Hook_a_carte_objet::autorisation_suppression($Code_carte, $Code_objet) ) $code_erreur = REFUS_A_CARTE_OBJET__SUPPRESSION_BLOQUEE;
            {
                $liste_Code_carte[] = $Code_carte;
                $liste_Code_objet[] = $Code_objet;
            }
        }
        if ( $code_erreur==0 && count($liste_Code_carte)>0 && count($liste_Code_objet)>0 )
        {
            $requete = "DELETE IGNORE FROM ".inst('a_carte_objet')." WHERE Code_carte IN ".Sql_Format_Liste($liste_Code_carte)." AND Code_objet IN ".Sql_Format_Liste($liste_Code_objet).";";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_A_CARTE_OBJET__SUPPRIMER__REFUSE;
                self::$cache_db->reprendre($cle);
            }
            else
            {
                self::$cache_db->clear();
                self::$cache_db->reprendre($cle);
                Hook_a_carte_objet::supprimer($copie__liste_a_carte_objet);
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

    public function mf_supprimer_2(?int $Code_carte=null, ?int $Code_objet=null)
    {
        $code_erreur = 0;
        $Code_carte = round($Code_carte);
        $Code_objet = round($Code_objet);
        $copie__liste_a_carte_objet = $this->mf_lister_2($Code_carte, $Code_objet, array('autocompletion' => false));
        $requete = 'DELETE IGNORE FROM ' . inst('a_carte_objet') . " WHERE 1".( $Code_carte!=0 ? " AND Code_carte=$Code_carte" : "" )."".( $Code_objet!=0 ? " AND Code_objet=$Code_objet" : "" ).";";
        $cle = md5($requete).salt(10);
        self::$cache_db->pause($cle);
        executer_requete_mysql( $requete , true);
        if ( requete_mysqli_affected_rows()==0 )
        {
            $code_erreur = ERR_A_CARTE_OBJET__SUPPRIMER_2__REFUSE;
            self::$cache_db->reprendre($cle);
        }
        else
        {
            self::$cache_db->clear();
            self::$cache_db->reprendre($cle);
            Hook_a_carte_objet::supprimer($copie__liste_a_carte_objet);
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
        return $this->mf_lister(isset($est_charge['carte']) ? $mf_contexte['Code_carte'] : 0, isset($est_charge['objet']) ? $mf_contexte['Code_objet'] : 0, $options);
    }

    public function mf_lister(?int $Code_carte=null, ?int $Code_objet=null, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $liste = $this->mf_lister_2($Code_carte, $Code_objet, $options);

        // controle_acces_donnees
        $controle_acces_donnees = CONTROLE_ACCES_DONNEES_DEFAUT;
        if (isset($options['controle_acces_donnees']))
        {
            $controle_acces_donnees = ( $options['controle_acces_donnees']==true );
        }

        foreach ($liste as $key => $elem)
        {
            if ( $controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_carte', $elem['Code_carte']) || $controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_objet', $elem['Code_objet']) )
            {
                unset($liste[$key]);
            }
        }

        return $liste;
    }

    public function mf_lister_2(?int $Code_carte=null, ?int $Code_objet=null, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cle = "a_carte_objet__lister";
        $Code_carte = round($Code_carte);
        $cle.="_{$Code_carte}";
        $Code_objet = round($Code_objet);
        $cle.="_{$Code_objet}";

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
            if ( isset($mf_tri_defaut_table['a_carte_objet']) )
            {
                $options['tris'] = $mf_tri_defaut_table['a_carte_objet'];
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
            }
            if ( isset($options['tris']) )
            {
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = self::$cache_db->read('a_carte_objet__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('a_carte_objet').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    self::$cache_db->write('a_carte_objet__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    self::$cache_db->pause('a_carte_objet__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('a_carte_objet').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    self::$cache_db->clear();
                    self::$cache_db->reprendre('a_carte_objet__index');
                }
            }

            $liste = array();
            if ($toutes_colonnes)
            {
                $colonnes='Code_carte, Code_objet';
            }
            else
            {
                $colonnes='Code_carte, Code_objet';
            }
            $res_requete = executer_requete_mysql('SELECT ' . $colonnes . ' FROM '.inst('a_carte_objet')." WHERE 1{$argument_cond}".( $Code_carte!=0 ? " AND Code_carte=$Code_carte" : "" )."".( $Code_objet!=0 ? " AND Code_objet=$Code_objet" : "" )."{$argument_tris}{$argument_limit};", false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                mf_formatage_db_type_php($row_requete);
                $liste[$row_requete['Code_carte'].'-'.$row_requete['Code_objet']] = $row_requete;
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
                Hook_a_carte_objet::completion($element);
                self::$auto_completion = false;
            }
        }
        unset($element);
        return $liste;
    }

    public function mf_get(int $Code_carte, int $Code_objet, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cle = "a_carte_objet__get";
        $Code_carte = round($Code_carte);
        $cle.="_{$Code_carte}";
        $Code_objet = round($Code_objet);
        $cle.="_{$Code_objet}";
        $retour = array();
        if ( ! CONTROLE_ACCES_DONNEES_DEFAUT || Hook_mf_systeme::controle_acces_donnees('Code_carte', $Code_carte) && Hook_mf_systeme::controle_acces_donnees('Code_objet', $Code_objet) )
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
                    $colonnes='Code_carte, Code_objet';
                }
                else
                {
                    $colonnes='Code_carte, Code_objet';
                }
                $res_requete = executer_requete_mysql('SELECT ' . $colonnes . " FROM ".inst('a_carte_objet')." WHERE Code_carte=$Code_carte AND Code_objet=$Code_objet;", false);
                if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
                {
                    $retour = $row_requete;
                }
                mysqli_free_result($res_requete);
                self::$cache_db->write($cle, $retour);
            }
            if ( isset( $retour['Code_carte'] ) )
            {
                if (!self::$auto_completion && $autocompletion)
                {
                    self::$auto_completion = true;
                    Hook_a_carte_objet::completion($retour);
                    self::$auto_completion = false;
                }
            }
        }
        return $retour;
    }

    public function mf_get_2(int $Code_carte, int $Code_objet, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cle = "a_carte_objet__get";
        $Code_carte = round($Code_carte);
        $cle.="_{$Code_carte}";
        $Code_objet = round($Code_objet);
        $cle.="_{$Code_objet}";

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
                $colonnes='Code_carte, Code_objet';
            }
            else
            {
                $colonnes='Code_carte, Code_objet';
            }
            $res_requete = executer_requete_mysql('SELECT ' . $colonnes . " FROM ".inst('a_carte_objet')." WHERE Code_carte=$Code_carte AND Code_objet=$Code_objet;", false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $retour = $row_requete;
            }
            mysqli_free_result($res_requete);
            self::$cache_db->write($cle, $retour);
        }
        if ( isset( $retour['Code_carte'] ) )
        {
            if (!self::$auto_completion && $autocompletion)
            {
                self::$auto_completion = true;
                Hook_a_carte_objet::completion($retour);
                self::$auto_completion = false;
            }
        }
        return $retour;
    }

    public function mf_compter(?int $Code_carte=null, ?int $Code_objet=null, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cle = 'a_carte_objet__compter';
        $Code_carte = round($Code_carte);
        $cle.='_{'.$Code_carte.'}';
        $Code_objet = round($Code_objet);
        $cle.='_{'.$Code_objet.'}';

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
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = self::$cache_db->read('a_carte_objet__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('a_carte_objet').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    self::$cache_db->write('a_carte_objet__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    self::$cache_db->pause('a_carte_objet__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('a_carte_objet').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    self::$cache_db->clear();
                    self::$cache_db->reprendre('a_carte_objet__index');
                }
            }

            $res_requete = executer_requete_mysql("SELECT COUNT(CONCAT(Code_carte,'|',Code_objet)) as nb FROM ".inst('a_carte_objet')." WHERE 1{$argument_cond}".( $Code_carte!=0 ? " AND Code_carte=$Code_carte" : "" )."".( $Code_objet!=0 ? " AND Code_objet=$Code_objet" : "" ).";", false);
            $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC);
            mysqli_free_result($res_requete);
            $nb = (int) $row_requete['nb'];
            self::$cache_db->write($cle, $nb);
        }
        return $nb;
    }

    public function mf_liste_Code_carte_vers_liste_Code_objet( array $liste_Code_carte, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ( $options===null ) { $options=[]; }
        return $this->a_carte_objet_liste_Code_carte_vers_liste_Code_objet( $liste_Code_carte , $options );
    }

    public function mf_liste_Code_objet_vers_liste_Code_carte( array $liste_Code_objet, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ( $options===null ) { $options=[]; }
        return $this->a_carte_objet_liste_Code_objet_vers_liste_Code_carte( $liste_Code_objet , $options );
    }

}
