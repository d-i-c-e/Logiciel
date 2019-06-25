<?php

/*
    +------------------------------+
    |  NE PAS MODIFIER CE FICHIER  |
    +------------------------------+
*/

class a_campagne_tag_campagne_monframework extends entite_monframework
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
            include_once __DIR__ . '/../../erreurs/erreurs__a_campagne_tag_campagne.php';
            self::$initialisation = false;
            Hook_a_campagne_tag_campagne::initialisation();
            self::$cache_db = new Mf_Cachedb('a_campagne_tag_campagne');
        }
        if (!self::$actualisation_en_cours)
        {
            self::$actualisation_en_cours=true;
            Hook_a_campagne_tag_campagne::actualisation();
            self::$actualisation_en_cours=false;
        }
    }

    static function mf_raz_instance()
    {
        self::$initialisation = true;
    }

    static function initialiser_structure()
    {
        if ( ! test_si_table_existe(inst('a_campagne_tag_campagne')) )
        {
            executer_requete_mysql('CREATE TABLE '.inst('a_campagne_tag_campagne').' (Code_tag_campagne INT NOT NULL, Code_campagne INT NOT NULL, PRIMARY KEY (Code_tag_campagne, Code_campagne)) ENGINE=MyISAM;', true);
        }

        $liste_colonnes = lister_les_colonnes(inst('a_campagne_tag_campagne'));

        unset($liste_colonnes['Code_tag_campagne']);
        unset($liste_colonnes['Code_campagne']);

        foreach ($liste_colonnes as $field => $value)
        {
            executer_requete_mysql('ALTER TABLE '.inst('a_campagne_tag_campagne').' DROP COLUMN '.$field.';', true);
        }

    }

    public function mfi_ajouter_auto(array $interface)
    {
        if (isset($interface['Code_tag_campagne'])) { $liste_Code_tag_campagne = array($interface['Code_tag_campagne']); }
        elseif (isset($interface['liste_Code_tag_campagne'])) { $liste_Code_tag_campagne = $interface['liste_Code_tag_campagne']; }
        else { $liste_Code_tag_campagne = $this->get_liste_Code_tag_campagne(); }
        if (isset($interface['Code_campagne'])) { $liste_Code_campagne = array($interface['Code_campagne']); }
        elseif (isset($interface['liste_Code_campagne'])) { $liste_Code_campagne = $interface['liste_Code_campagne']; }
        else { $liste_Code_campagne = $this->get_liste_Code_campagne(); }
        $liste_a_campagne_tag_campagne = array();
        foreach ($liste_Code_tag_campagne as $Code_tag_campagne)
        {
            foreach ($liste_Code_campagne as $Code_campagne)
            {
                $liste_a_campagne_tag_campagne[] = array('Code_tag_campagne'=>$Code_tag_campagne,'Code_campagne'=>$Code_campagne);
            }
        }
        return $this->mf_ajouter_3($liste_a_campagne_tag_campagne);
    }

    public function mfi_supprimer_auto(array $interface)
    {
        if (isset($interface['Code_tag_campagne'])) { $liste_Code_tag_campagne = array($interface['Code_tag_campagne']); }
        elseif (isset($interface['liste_Code_tag_campagne'])) { $liste_Code_tag_campagne = $interface['liste_Code_tag_campagne']; }
        else { $liste_Code_tag_campagne = $this->get_liste_Code_tag_campagne(); }
        if (isset($interface['Code_campagne'])) { $liste_Code_campagne = array($interface['Code_campagne']); }
        elseif (isset($interface['liste_Code_campagne'])) { $liste_Code_campagne = $interface['liste_Code_campagne']; }
        else { $liste_Code_campagne = $this->get_liste_Code_campagne(); }
        foreach ($liste_Code_tag_campagne as $Code_tag_campagne)
        {
            foreach ($liste_Code_campagne as $Code_campagne)
            {
                $this->mf_supprimer_2($Code_tag_campagne, $Code_campagne);
            }
        }
    }

    public function mf_ajouter(int $Code_tag_campagne, int $Code_campagne, ?bool $force=null)
    {
        if ( $force===null ) { $force=false; }
        $code_erreur = 0;
        $Code_tag_campagne = round($Code_tag_campagne);
        $Code_campagne = round($Code_campagne);
        Hook_a_campagne_tag_campagne::pre_controller($Code_tag_campagne, $Code_campagne);
        if (!$force)
        {
            if (!self::$maj_droits_ajouter_en_cours)
            {
                self::$maj_droits_ajouter_en_cours = true;
                Hook_a_campagne_tag_campagne::hook_actualiser_les_droits_ajouter($Code_tag_campagne, $Code_campagne);
                self::$maj_droits_ajouter_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['a_campagne_tag_campagne__AJOUTER']) ) $code_erreur = REFUS_A_CAMPAGNE_TAG_CAMPAGNE__AJOUTER;
        elseif ( !$this->mf_tester_existance_Code_tag_campagne($Code_tag_campagne) ) $code_erreur = ERR_A_CAMPAGNE_TAG_CAMPAGNE__AJOUTER__CODE_TAG_CAMPAGNE_INEXISTANT;
        elseif ( !$this->mf_tester_existance_Code_campagne($Code_campagne) ) $code_erreur = ERR_A_CAMPAGNE_TAG_CAMPAGNE__AJOUTER__CODE_CAMPAGNE_INEXISTANT;
        elseif ( $this->mf_tester_existance_a_campagne_tag_campagne( $Code_tag_campagne, $Code_campagne ) ) $code_erreur = ERR_A_CAMPAGNE_TAG_CAMPAGNE__AJOUTER__DOUBLON;
        elseif ( CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_tag_campagne', $Code_tag_campagne) ) $code_erreur = ACCES_CODE_TAG_CAMPAGNE_REFUSE;
        elseif ( CONTROLE_ACCES_DONNEES_DEFAUT && !Hook_mf_systeme::controle_acces_donnees('Code_campagne', $Code_campagne) ) $code_erreur = ACCES_CODE_CAMPAGNE_REFUSE;
        elseif ( !Hook_a_campagne_tag_campagne::autorisation_ajout($Code_tag_campagne, $Code_campagne) ) $code_erreur = REFUS_A_CAMPAGNE_TAG_CAMPAGNE__AJOUT_BLOQUEE;
        else
        {
            Hook_a_campagne_tag_campagne::data_controller($Code_tag_campagne, $Code_campagne);
            $requete = 'INSERT INTO '.inst('a_campagne_tag_campagne')." ( Code_tag_campagne, Code_campagne ) VALUES ( $Code_tag_campagne, $Code_campagne );";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql($requete, true);
            $n = requete_mysqli_affected_rows();
            if ($n==0)
            {
                $code_erreur = ERR_A_CAMPAGNE_TAG_CAMPAGNE__AJOUTER__REFUSE;
                self::$cache_db->reprendre($cle);
            }
            else
            {
                self::$cache_db->clear();
                self::$cache_db->reprendre($cle);
                Hook_a_campagne_tag_campagne::ajouter($Code_tag_campagne, $Code_campagne);
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
        return array('code_erreur' => $code_erreur, 'callback' => ( $code_erreur==0 ? Hook_a_campagne_tag_campagne::callback_post($Code_tag_campagne, $Code_campagne) : null ));
    }

    public function mf_ajouter_2(array $ligne, ?bool $force=null) // array('colonne1' => 'valeur1',  [...] )
    {
        if ( $force===null ) { $force=false; }
        global $mf_initialisation;
        $Code_tag_campagne = (int)(isset($ligne['Code_tag_campagne'])?round($ligne['Code_tag_campagne']):0);
        $Code_campagne = (int)(isset($ligne['Code_campagne'])?round($ligne['Code_campagne']):0);
        return $this->mf_ajouter($Code_tag_campagne, $Code_campagne, $force);
    }

    public function mf_ajouter_3(array $lignes) // array( array( 'colonne1' => 'valeur1', 'colonne2' => 'valeur2',  [...] ), [...] )
    {
        global $mf_initialisation;
        $code_erreur = 0;
        $values = '';
        foreach ($lignes as $ligne)
        {
            $Code_tag_campagne = (isset($ligne['Code_tag_campagne'])?round($ligne['Code_tag_campagne']):0);
            $Code_campagne = (isset($ligne['Code_campagne'])?round($ligne['Code_campagne']):0);
            if ($Code_tag_campagne != 0)
            {
                if ($Code_campagne != 0)
                {
                    $values.=($values!='' ? ',' : '')."($Code_tag_campagne, $Code_campagne)";
                }
            }
        }
        if ($values!='')
        {
            $requete = "INSERT INTO ".inst('a_campagne_tag_campagne')." ( Code_tag_campagne, Code_campagne ) VALUES $values;";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            $n = requete_mysqli_affected_rows();
            if ($n < count($lignes))
            {
                $code_erreur = ERR_A_CAMPAGNE_TAG_CAMPAGNE__AJOUTER_3__ECHEC_AJOUT;
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

    public function mf_supprimer(?int $Code_tag_campagne=null, ?int $Code_campagne=null, ?bool $force=null)
    {
        if ( $force===null ) { $force=false; }
        $code_erreur = 0;
        $Code_tag_campagne = round($Code_tag_campagne);
        $Code_campagne = round($Code_campagne);
        $copie__liste_a_campagne_tag_campagne = $this->mf_lister($Code_tag_campagne, $Code_campagne, array('autocompletion' => false));
        $liste_Code_tag_campagne = array();
        $liste_Code_campagne = array();
        foreach ( $copie__liste_a_campagne_tag_campagne as $copie__a_campagne_tag_campagne )
        {
            $Code_tag_campagne = $copie__a_campagne_tag_campagne['Code_tag_campagne'];
            $Code_campagne = $copie__a_campagne_tag_campagne['Code_campagne'];
            if (!$force)
            {
                if (!self::$maj_droits_supprimer_en_cours)
                {
                    self::$maj_droits_supprimer_en_cours = true;
                    Hook_a_campagne_tag_campagne::hook_actualiser_les_droits_supprimer($Code_tag_campagne, $Code_campagne);
                    self::$maj_droits_supprimer_en_cours = false;
                }
            }
            if ( !$force && !mf_matrice_droits(['a_campagne_tag_campagne__SUPPRIMER']) ) $code_erreur = REFUS_A_CAMPAGNE_TAG_CAMPAGNE__SUPPRIMER;
            elseif ( !Hook_a_campagne_tag_campagne::autorisation_suppression($Code_tag_campagne, $Code_campagne) ) $code_erreur = REFUS_A_CAMPAGNE_TAG_CAMPAGNE__SUPPRESSION_BLOQUEE;
            {
                $liste_Code_tag_campagne[] = $Code_tag_campagne;
                $liste_Code_campagne[] = $Code_campagne;
            }
        }
        if ( $code_erreur==0 && count($liste_Code_tag_campagne)>0 && count($liste_Code_campagne)>0 )
        {
            $requete = "DELETE IGNORE FROM ".inst('a_campagne_tag_campagne')." WHERE Code_tag_campagne IN ".Sql_Format_Liste($liste_Code_tag_campagne)." AND Code_campagne IN ".Sql_Format_Liste($liste_Code_campagne).";";
            $cle = md5($requete).salt(10);
            self::$cache_db->pause($cle);
            executer_requete_mysql( $requete , true);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_A_CAMPAGNE_TAG_CAMPAGNE__SUPPRIMER__REFUSE;
                self::$cache_db->reprendre($cle);
            }
            else
            {
                self::$cache_db->clear();
                self::$cache_db->reprendre($cle);
                Hook_a_campagne_tag_campagne::supprimer($copie__liste_a_campagne_tag_campagne);
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

    public function mf_supprimer_2(?int $Code_tag_campagne=null, ?int $Code_campagne=null)
    {
        $code_erreur = 0;
        $Code_tag_campagne = round($Code_tag_campagne);
        $Code_campagne = round($Code_campagne);
        $copie__liste_a_campagne_tag_campagne = $this->mf_lister_2($Code_tag_campagne, $Code_campagne, array('autocompletion' => false));
        $requete = 'DELETE IGNORE FROM ' . inst('a_campagne_tag_campagne') . " WHERE 1".( $Code_tag_campagne!=0 ? " AND Code_tag_campagne=$Code_tag_campagne" : "" )."".( $Code_campagne!=0 ? " AND Code_campagne=$Code_campagne" : "" ).";";
        $cle = md5($requete).salt(10);
        self::$cache_db->pause($cle);
        executer_requete_mysql( $requete , true);
        if ( requete_mysqli_affected_rows()==0 )
        {
            $code_erreur = ERR_A_CAMPAGNE_TAG_CAMPAGNE__SUPPRIMER_2__REFUSE;
            self::$cache_db->reprendre($cle);
        }
        else
        {
            self::$cache_db->clear();
            self::$cache_db->reprendre($cle);
            Hook_a_campagne_tag_campagne::supprimer($copie__liste_a_campagne_tag_campagne);
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
        return $this->mf_lister(isset($est_charge['tag_campagne']) ? $mf_contexte['Code_tag_campagne'] : 0, isset($est_charge['campagne']) ? $mf_contexte['Code_campagne'] : 0, $options);
    }

    public function mf_lister(?int $Code_tag_campagne=null, ?int $Code_campagne=null, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $liste = $this->mf_lister_2($Code_tag_campagne, $Code_campagne, $options);

        // controle_acces_donnees
        $controle_acces_donnees = CONTROLE_ACCES_DONNEES_DEFAUT;
        if (isset($options['controle_acces_donnees']))
        {
            $controle_acces_donnees = ( $options['controle_acces_donnees']==true );
        }

        foreach ($liste as $key => $elem)
        {
            if ( $controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_tag_campagne', $elem['Code_tag_campagne']) || $controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_campagne', $elem['Code_campagne']) )
            {
                unset($liste[$key]);
            }
        }

        return $liste;
    }

    public function mf_lister_2(?int $Code_tag_campagne=null, ?int $Code_campagne=null, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cle = "a_campagne_tag_campagne__lister";
        $Code_tag_campagne = round($Code_tag_campagne);
        $cle.="_{$Code_tag_campagne}";
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
            if ( isset($mf_tri_defaut_table['a_campagne_tag_campagne']) )
            {
                $options['tris'] = $mf_tri_defaut_table['a_campagne_tag_campagne'];
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
                if ( ! $mf_liste_requete_index = self::$cache_db->read('a_campagne_tag_campagne__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('a_campagne_tag_campagne').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    self::$cache_db->write('a_campagne_tag_campagne__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    self::$cache_db->pause('a_campagne_tag_campagne__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('a_campagne_tag_campagne').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    self::$cache_db->clear();
                    self::$cache_db->reprendre('a_campagne_tag_campagne__index');
                }
            }

            $liste = array();
            if ($toutes_colonnes)
            {
                $colonnes='Code_tag_campagne, Code_campagne';
            }
            else
            {
                $colonnes='Code_tag_campagne, Code_campagne';
            }
            $res_requete = executer_requete_mysql('SELECT ' . $colonnes . ' FROM '.inst('a_campagne_tag_campagne')." WHERE 1{$argument_cond}".( $Code_tag_campagne!=0 ? " AND Code_tag_campagne=$Code_tag_campagne" : "" )."".( $Code_campagne!=0 ? " AND Code_campagne=$Code_campagne" : "" )."{$argument_tris}{$argument_limit};", false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                mf_formatage_db_type_php($row_requete);
                $liste[$row_requete['Code_tag_campagne'].'-'.$row_requete['Code_campagne']] = $row_requete;
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
                Hook_a_campagne_tag_campagne::completion($element);
                self::$auto_completion = false;
            }
        }
        unset($element);
        return $liste;
    }

    public function mf_get(int $Code_tag_campagne, int $Code_campagne, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cle = "a_campagne_tag_campagne__get";
        $Code_tag_campagne = round($Code_tag_campagne);
        $cle.="_{$Code_tag_campagne}";
        $Code_campagne = round($Code_campagne);
        $cle.="_{$Code_campagne}";
        $retour = array();
        if ( ! CONTROLE_ACCES_DONNEES_DEFAUT || Hook_mf_systeme::controle_acces_donnees('Code_tag_campagne', $Code_tag_campagne) && Hook_mf_systeme::controle_acces_donnees('Code_campagne', $Code_campagne) )
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
                    $colonnes='Code_tag_campagne, Code_campagne';
                }
                else
                {
                    $colonnes='Code_tag_campagne, Code_campagne';
                }
                $res_requete = executer_requete_mysql('SELECT ' . $colonnes . " FROM ".inst('a_campagne_tag_campagne')." WHERE Code_tag_campagne=$Code_tag_campagne AND Code_campagne=$Code_campagne;", false);
                if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
                {
                    $retour = $row_requete;
                }
                mysqli_free_result($res_requete);
                self::$cache_db->write($cle, $retour);
            }
            if ( isset( $retour['Code_tag_campagne'] ) )
            {
                if (!self::$auto_completion && $autocompletion)
                {
                    self::$auto_completion = true;
                    Hook_a_campagne_tag_campagne::completion($retour);
                    self::$auto_completion = false;
                }
            }
        }
        return $retour;
    }

    public function mf_get_2(int $Code_tag_campagne, int $Code_campagne, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cle = "a_campagne_tag_campagne__get";
        $Code_tag_campagne = round($Code_tag_campagne);
        $cle.="_{$Code_tag_campagne}";
        $Code_campagne = round($Code_campagne);
        $cle.="_{$Code_campagne}";

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
                $colonnes='Code_tag_campagne, Code_campagne';
            }
            else
            {
                $colonnes='Code_tag_campagne, Code_campagne';
            }
            $res_requete = executer_requete_mysql('SELECT ' . $colonnes . " FROM ".inst('a_campagne_tag_campagne')." WHERE Code_tag_campagne=$Code_tag_campagne AND Code_campagne=$Code_campagne;", false);
            if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $retour = $row_requete;
            }
            mysqli_free_result($res_requete);
            self::$cache_db->write($cle, $retour);
        }
        if ( isset( $retour['Code_tag_campagne'] ) )
        {
            if (!self::$auto_completion && $autocompletion)
            {
                self::$auto_completion = true;
                Hook_a_campagne_tag_campagne::completion($retour);
                self::$auto_completion = false;
            }
        }
        return $retour;
    }

    public function mf_compter(?int $Code_tag_campagne=null, ?int $Code_campagne=null, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ( $options===null ) { $options=[]; }
        $cle = 'a_campagne_tag_campagne__compter';
        $Code_tag_campagne = round($Code_tag_campagne);
        $cle.='_{'.$Code_tag_campagne.'}';
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
            }
            if ( count($liste_colonnes_a_indexer)>0 )
            {
                if ( ! $mf_liste_requete_index = self::$cache_db->read('a_campagne_tag_campagne__index') )
                {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('a_campagne_tag_campagne').'`;', false);
                    $mf_liste_requete_index = array();
                    while ( $row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC) )
                    {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    self::$cache_db->write('a_campagne_tag_campagne__index', $mf_liste_requete_index);
                }
                foreach( $mf_liste_requete_index as $mf_colonne_indexee )
                {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if ( count($liste_colonnes_a_indexer) > 0 )
                {
                    self::$cache_db->pause('a_campagne_tag_campagne__index');
                    foreach( $liste_colonnes_a_indexer as $colonnes_a_indexer )
                    {
                        executer_requete_mysql('ALTER TABLE `'.inst('a_campagne_tag_campagne').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    self::$cache_db->clear();
                    self::$cache_db->reprendre('a_campagne_tag_campagne__index');
                }
            }

            $res_requete = executer_requete_mysql("SELECT COUNT(CONCAT(Code_tag_campagne,'|',Code_campagne)) as nb FROM ".inst('a_campagne_tag_campagne')." WHERE 1{$argument_cond}".( $Code_tag_campagne!=0 ? " AND Code_tag_campagne=$Code_tag_campagne" : "" )."".( $Code_campagne!=0 ? " AND Code_campagne=$Code_campagne" : "" ).";", false);
            $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC);
            mysqli_free_result($res_requete);
            $nb = (int) $row_requete['nb'];
            self::$cache_db->write($cle, $nb);
        }
        return $nb;
    }

    public function mf_liste_Code_tag_campagne_vers_liste_Code_campagne( array $liste_Code_tag_campagne, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ( $options===null ) { $options=[]; }
        return $this->a_campagne_tag_campagne_liste_Code_tag_campagne_vers_liste_Code_campagne( $liste_Code_tag_campagne , $options );
    }

    public function mf_liste_Code_campagne_vers_liste_Code_tag_campagne( array $liste_Code_campagne, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ( $options===null ) { $options=[]; }
        return $this->a_campagne_tag_campagne_liste_Code_campagne_vers_liste_Code_tag_campagne( $liste_Code_campagne , $options );
    }

}
