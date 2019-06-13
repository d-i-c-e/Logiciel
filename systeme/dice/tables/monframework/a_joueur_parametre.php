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
        if ( ! test_si_table_existe(inst('a_joueur_parametre')) )
        {
            executer_requete_mysql('CREATE TABLE '.inst('a_joueur_parametre').' (Code_joueur INT NOT NULL, Code_parametre INT NOT NULL, PRIMARY KEY (Code_joueur, Code_parametre)) ENGINE=MyISAM;', true);
        }

        $liste_colonnes = lister_les_colonnes(inst('a_joueur_parametre'));

        unset($liste_colonnes['Code_joueur']);
        unset($liste_colonnes['Code_parametre']);

        foreach ($liste_colonnes as $field => $value)
        {
            executer_requete_mysql('ALTER TABLE '.inst('a_joueur_parametre').' DROP COLUMN '.$field.';', true);
        }

    }

    public function mfi_ajouter_auto($interface)
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
        return $this->mf_ajouter_3($liste_a_joueur_parametre);
    }

    public function mfi_supprimer_auto($interface)
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

    public function mf_ajouter($Code_joueur, $Code_parametre, $force=false)
    {
        $code_erreur = 0;
        $Code_joueur = round($Code_joueur);
        $Code_parametre = round($Code_parametre);
        Hook_a_joueur_parametre::pre_controller($Code_joueur, $Code_parametre);
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
        elseif ( !Hook_a_joueur_parametre::autorisation_ajout($Code_joueur, $Code_parametre) ) $code_erreur = REFUS_A_JOUEUR_PARAMETRE__AJOUT_BLOQUEE;
        else
        {
            Hook_a_joueur_parametre::data_controller($Code_joueur, $Code_parametre);
            $requete = 'INSERT INTO '.inst('a_joueur_parametre')." ( Code_joueur, Code_parametre ) VALUES ( $Code_joueur, $Code_parametre );";
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

    public function mf_ajouter_2($ligne, $force=false) // array('colonne1' => 'valeur1',  [...] )
    {
        global $mf_initialisation;
        $Code_joueur = (isset($ligne['Code_joueur'])?round($ligne['Code_joueur']):get_joueur_courant('Code_joueur'));
        $Code_parametre = (isset($ligne['Code_parametre'])?round($ligne['Code_parametre']):0);
        return $this->mf_ajouter($Code_joueur, $Code_parametre, $force);
    }

    public function mf_ajouter_3($lignes) // array( array( 'colonne1' => 'valeur1', 'colonne2' => 'valeur2',  [...] ), [...] )
    {
        global $mf_initialisation;
        $code_erreur = 0;
        $values = '';
        foreach ($lignes as $ligne)
        {
            $Code_joueur = (isset($ligne['Code_joueur'])?round($ligne['Code_joueur']):0);
            $Code_parametre = (isset($ligne['Code_parametre'])?round($ligne['Code_parametre']):0);
            if ($Code_joueur != 0)
            {
                if ($Code_parametre != 0)
                {
                    $values.=($values!='' ? ',' : '')."($Code_joueur, $Code_parametre)";
                }
            }
        }
        if ($values!='')
        {
            $requete = "INSERT INTO ".inst('a_joueur_parametre')." ( Code_joueur, Code_parametre ) VALUES $values;";
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

    public function mf_supprimer($Code_joueur=0, $Code_parametre=0, $force=false)
    {
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

    public function mf_supprimer_2($Code_joueur=0, $Code_parametre=0)
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

    public function mf_lister_contexte($options = array( 'cond_mysql' => array(), 'tris' => array(), 'limit' => array(), 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ))
    {
        global $mf_contexte, $est_charge;
        return $this->mf_lister(isset($est_charge['joueur']) ? $mf_contexte['Code_joueur'] : 0, isset($est_charge['parametre']) ? $mf_contexte['Code_parametre'] : 0, $options);
    }

    public function mf_lister($Code_joueur=0, $Code_parametre=0, $options = array( 'cond_mysql' => array(), 'tris' => array(), 'limit' => array(), 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ))
    {
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

    public function mf_lister_2($Code_joueur=0, $Code_parametre=0, $options = array( 'cond_mysql' => array(), 'tris' => array(), 'limit' => array(), 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ))
    {
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
            }
            if ( isset($options['tris']) )
            {
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
                $colonnes='Code_joueur, Code_parametre';
            }
            else
            {
                $colonnes='Code_joueur, Code_parametre';
            }
            $res_requete = executer_requete_mysql('SELECT ' . $colonnes . ' FROM '.inst('a_joueur_parametre')." WHERE 1{$argument_cond}".( $Code_joueur!=0 ? " AND Code_joueur=$Code_joueur" : "" )."".( $Code_parametre!=0 ? " AND Code_parametre=$Code_parametre" : "" )."{$argument_tris}{$argument_limit};", false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                $liste[$row_requete['Code_joueur'].'-'.$row_requete['Code_parametre']]=$row_requete;
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

    public function mf_get($Code_joueur, $Code_parametre, $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ])
    {
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
                    $colonnes='Code_joueur, Code_parametre';
                }
                else
                {
                    $colonnes='Code_joueur, Code_parametre';
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

    public function mf_get_2($Code_joueur, $Code_parametre, $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ])
    {
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
                $colonnes='Code_joueur, Code_parametre';
            }
            else
            {
                $colonnes='Code_joueur, Code_parametre';
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

    public function mf_compter($Code_joueur=0, $Code_parametre=0, $options = array( 'cond_mysql' => array() ))
    {
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
            $nb = round($row_requete['nb']);
            self::$cache_db->write($cle, $nb);
        }
        return $nb;
    }

    public function mf_liste_Code_joueur_vers_liste_Code_parametre( $liste_Code_joueur, $options = array( 'cond_mysql' => array() ))
    {
        return $this->a_joueur_parametre_liste_Code_joueur_vers_liste_Code_parametre( $liste_Code_joueur , $options );
    }

    public function mf_liste_Code_parametre_vers_liste_Code_joueur( $liste_Code_parametre, $options = array( 'cond_mysql' => array() ))
    {
        return $this->a_joueur_parametre_liste_Code_parametre_vers_liste_Code_joueur( $liste_Code_parametre , $options );
    }

}
