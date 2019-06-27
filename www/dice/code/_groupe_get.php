<?php

    /* Actualisation des droits */
    Hook_groupe::hook_actualiser_les_droits_modifier($groupe['Code_groupe']);
    Hook_groupe::hook_actualiser_les_droits_supprimer($groupe['Code_groupe']);

    /* boutons */
        if ($mf_droits_defaut['groupe__MODIFIER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_groupe') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_groupe&Code_groupe='.$Code_groupe, 'lien', 'bouton_modifier_groupe');
        }
        $trans['{bouton_modifier_groupe}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_groupe') : '';
        if ($mf_droits_defaut['groupe__SUPPRIMER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_SUPPRIMER_PREC . get_nom_colonne('bouton_supprimer_groupe') . BOUTON_LIBELLE_SUPPRIMER_SUIV, get_nom_page_courante().'?act=supprimer_groupe&Code_groupe='.$Code_groupe, 'lien', 'bouton_supprimer_groupe');
        }
        $trans['{bouton_supprimer_groupe}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_supprimer_groupe', BOUTON_CLASSE_SUPPRIMER) : '';

        // groupe_Nom
        if ( $mf_droits_defaut['api_modifier__groupe_Nom'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_groupe_Nom') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_groupe_Nom&Code_groupe='.$Code_groupe, 'lien', 'bouton_modifier_groupe_Nom');
        }
        $trans['{bouton_modifier_groupe_Nom}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_groupe_Nom') : '';

        // groupe_Description
        if ( $mf_droits_defaut['api_modifier__groupe_Description'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_groupe_Description') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_groupe_Description&Code_groupe='.$Code_groupe, 'lien', 'bouton_modifier_groupe_Description');
        }
        $trans['{bouton_modifier_groupe_Description}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_groupe_Description') : '';

        // groupe_Logo_Fichier
        if ( $mf_droits_defaut['api_modifier__groupe_Logo_Fichier'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_groupe_Logo_Fichier') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_groupe_Logo_Fichier&Code_groupe='.$Code_groupe, 'lien', 'bouton_modifier_groupe_Logo_Fichier');
        }
        $trans['{bouton_modifier_groupe_Logo_Fichier}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_groupe_Logo_Fichier') : '';

        // groupe_Effectif
        if ( $mf_droits_defaut['api_modifier__groupe_Effectif'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_groupe_Effectif') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_groupe_Effectif&Code_groupe='.$Code_groupe, 'lien', 'bouton_modifier_groupe_Effectif');
        }
        $trans['{bouton_modifier_groupe_Effectif}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_groupe_Effectif') : '';

        // groupe_Actif
        if ( $mf_droits_defaut['api_modifier__groupe_Actif'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_groupe_Actif') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_groupe_Actif&Code_groupe='.$Code_groupe, 'lien', 'bouton_modifier_groupe_Actif');
        }
        $trans['{bouton_modifier_groupe_Actif}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_groupe_Actif') : '';

        // groupe_Date_creation
        if ( $mf_droits_defaut['api_modifier__groupe_Date_creation'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_groupe_Date_creation') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_groupe_Date_creation&Code_groupe='.$Code_groupe, 'lien', 'bouton_modifier_groupe_Date_creation');
        }
        $trans['{bouton_modifier_groupe_Date_creation}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_groupe_Date_creation') : '';

        // groupe_Delai_suppression_jour
        if ( $mf_droits_defaut['api_modifier__groupe_Delai_suppression_jour'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_groupe_Delai_suppression_jour') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_groupe_Delai_suppression_jour&Code_groupe='.$Code_groupe, 'lien', 'bouton_modifier_groupe_Delai_suppression_jour');
        }
        $trans['{bouton_modifier_groupe_Delai_suppression_jour}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_groupe_Delai_suppression_jour') : '';

        // groupe_Suppression_active
        if ( $mf_droits_defaut['api_modifier__groupe_Suppression_active'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_groupe_Suppression_active') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_groupe_Suppression_active&Code_groupe='.$Code_groupe, 'lien', 'bouton_modifier_groupe_Suppression_active');
        }
        $trans['{bouton_modifier_groupe_Suppression_active}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_groupe_Suppression_active') : '';

        // Code_campagne
        if ( $mf_droits_defaut['api_modifier_ref__groupe__Code_campagne'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_groupe__Code_campagne') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_groupe__Code_campagne&Code_groupe='.$Code_groupe, 'lien', 'bouton_modifier_groupe__Code_campagne');
        }
        $trans['{bouton_modifier_groupe__Code_campagne}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_groupe__Code_campagne') : '';

    /* prec_et_suiv */
    if ( $table_groupe->mf_compter((isset($est_charge['campagne']) ? $mf_contexte['Code_campagne'] : 0))<100 )
    {
        $liste_groupe = $table_groupe->mf_lister_contexte();
        // prec
        $prec_et_suiv = prec_suiv($liste_groupe, $groupe['Code_groupe']);
        $prec=['link'=>'', 'title'=>''];
        $suiv=['link'=>'', 'title'=>''];
        if (isset($prec_et_suiv['prec']['Code_groupe']))
        {
            $prec['link'] = get_nom_page_courante().'?act=apercu_groupe&Code_groupe='.$prec_et_suiv['prec']['Code_groupe'];
            $prec['title'] = htmlspecialchars(get_titre_ligne_table('groupe', $prec_et_suiv['prec']));
        }
        // suiv
        if (isset($prec_et_suiv['suiv']['Code_groupe']))
        {
            $suiv['link'] = get_nom_page_courante().'?act=apercu_groupe&Code_groupe='.$prec_et_suiv['suiv']['Code_groupe'];
            $suiv['title'] = htmlspecialchars(get_titre_ligne_table('groupe', $prec_et_suiv['suiv']));
        }
        $trans['{pager_groupe}'] = get_code_pager($prec, $suiv);
    }
    else
    {
        $trans['{pager_groupe}'] = '';
    }

    /* groupe_Nom */
        if ( $mf_droits_defaut['api_modifier__groupe_Nom'] )
            $trans['{groupe_Nom}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_groupe' => $groupe['Code_groupe']) , 'DB_name' => 'groupe_Nom' , 'valeur_initiale' => $groupe['groupe_Nom'] ]);
        else
            $trans['{groupe_Nom}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_groupe' => $groupe['Code_groupe']) , 'DB_name' => 'groupe_Nom' , 'valeur_initiale' => $groupe['groupe_Nom'] ]);

    /* groupe_Description */
        if ( $mf_droits_defaut['api_modifier__groupe_Description'] )
            $trans['{groupe_Description}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_groupe' => $groupe['Code_groupe']) , 'DB_name' => 'groupe_Description' , 'valeur_initiale' => $groupe['groupe_Description'] ]);
        else
            $trans['{groupe_Description}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_groupe' => $groupe['Code_groupe']) , 'DB_name' => 'groupe_Description' , 'valeur_initiale' => $groupe['groupe_Description'] , 'class' => 'text' ]);

    /* groupe_Logo_Fichier */
        if ( $mf_droits_defaut['api_modifier__groupe_Logo_Fichier'] )
            $trans['{groupe_Logo_Fichier}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_groupe' => $groupe['Code_groupe']) , 'DB_name' => 'groupe_Logo_Fichier' , 'valeur_initiale' => $groupe['groupe_Logo_Fichier'] ]);
        else
            $trans['{groupe_Logo_Fichier}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_groupe' => $groupe['Code_groupe']) , 'DB_name' => 'groupe_Logo_Fichier' , 'valeur_initiale' => $groupe['groupe_Logo_Fichier'] ]);

    /* groupe_Effectif */
        if ( $mf_droits_defaut['api_modifier__groupe_Effectif'] )
            $trans['{groupe_Effectif}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_groupe' => $groupe['Code_groupe']) , 'DB_name' => 'groupe_Effectif' , 'valeur_initiale' => $groupe['groupe_Effectif'] ]);
        else
            $trans['{groupe_Effectif}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_groupe' => $groupe['Code_groupe']) , 'DB_name' => 'groupe_Effectif' , 'valeur_initiale' => $groupe['groupe_Effectif'] ]);

    /* groupe_Actif */
        if ( $mf_droits_defaut['api_modifier__groupe_Actif'] )
            $trans['{groupe_Actif}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_groupe' => $groupe['Code_groupe']) , 'DB_name' => 'groupe_Actif' , 'valeur_initiale' => $groupe['groupe_Actif'], 'class' => 'button' ]);
        else
            $trans['{groupe_Actif}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_groupe' => $groupe['Code_groupe']) , 'DB_name' => 'groupe_Actif' , 'valeur_initiale' => $groupe['groupe_Actif'] ]);

    /* groupe_Date_creation */
        if ( $mf_droits_defaut['api_modifier__groupe_Date_creation'] )
            $trans['{groupe_Date_creation}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_groupe' => $groupe['Code_groupe']) , 'DB_name' => 'groupe_Date_creation' , 'valeur_initiale' => $groupe['groupe_Date_creation'] ]);
        else
            $trans['{groupe_Date_creation}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_groupe' => $groupe['Code_groupe']) , 'DB_name' => 'groupe_Date_creation' , 'valeur_initiale' => $groupe['groupe_Date_creation'] ]);

    /* groupe_Delai_suppression_jour */
        if ( $mf_droits_defaut['api_modifier__groupe_Delai_suppression_jour'] )
            $trans['{groupe_Delai_suppression_jour}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_groupe' => $groupe['Code_groupe']) , 'DB_name' => 'groupe_Delai_suppression_jour' , 'valeur_initiale' => $groupe['groupe_Delai_suppression_jour'] ]);
        else
            $trans['{groupe_Delai_suppression_jour}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_groupe' => $groupe['Code_groupe']) , 'DB_name' => 'groupe_Delai_suppression_jour' , 'valeur_initiale' => $groupe['groupe_Delai_suppression_jour'] ]);

    /* groupe_Suppression_active */
        if ( $mf_droits_defaut['api_modifier__groupe_Suppression_active'] )
            $trans['{groupe_Suppression_active}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_groupe' => $groupe['Code_groupe']) , 'DB_name' => 'groupe_Suppression_active' , 'valeur_initiale' => $groupe['groupe_Suppression_active'], 'class' => 'button' ]);
        else
            $trans['{groupe_Suppression_active}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_groupe' => $groupe['Code_groupe']) , 'DB_name' => 'groupe_Suppression_active' , 'valeur_initiale' => $groupe['groupe_Suppression_active'] ]);

    /* Code_campagne */
        if ( $mf_droits_defaut['api_modifier_ref__groupe__Code_campagne'] )
            $trans['{Code_campagne}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_groupe' => $groupe['Code_groupe']) , 'DB_name' => 'Code_campagne' , 'valeur_initiale' => $groupe['Code_campagne'] , 'nom_table' => 'groupe' ]);
        else
            $trans['{Code_campagne}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_groupe' => $groupe['Code_groupe']) , 'DB_name' => 'Code_campagne' , 'valeur_initiale' => $groupe['Code_campagne'] , 'nom_table' => 'groupe' ]);

