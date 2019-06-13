<?php

    /* Actualisation des droits */
    Hook_carte::hook_actualiser_les_droits_modifier($carte['Code_carte']);
    Hook_carte::hook_actualiser_les_droits_supprimer($carte['Code_carte']);

    /* boutons */
        if ($mf_droits_defaut['carte__MODIFIER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_carte') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_carte&Code_carte='.$Code_carte, 'lien', 'bouton_modifier_carte');
        }
        $trans['{bouton_modifier_carte}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_carte') : '';
        if ($mf_droits_defaut['carte__SUPPRIMER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_SUPPRIMER_PREC . get_nom_colonne('bouton_supprimer_carte') . BOUTON_LIBELLE_SUPPRIMER_SUIV, get_nom_page_courante().'?act=supprimer_carte&Code_carte='.$Code_carte, 'lien', 'bouton_supprimer_carte');
        }
        $trans['{bouton_supprimer_carte}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_supprimer_carte', BOUTON_CLASSE_SUPPRIMER) : '';

        // carte_Nom
        if ( $mf_droits_defaut['api_modifier__carte_Nom'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_carte_Nom') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_carte_Nom&Code_carte='.$Code_carte, 'lien', 'bouton_modifier_carte_Nom');
        }
        $trans['{bouton_modifier_carte_Nom}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_carte_Nom') : '';

        // carte_Hauteur
        if ( $mf_droits_defaut['api_modifier__carte_Hauteur'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_carte_Hauteur') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_carte_Hauteur&Code_carte='.$Code_carte, 'lien', 'bouton_modifier_carte_Hauteur');
        }
        $trans['{bouton_modifier_carte_Hauteur}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_carte_Hauteur') : '';

        // carte_Largeur
        if ( $mf_droits_defaut['api_modifier__carte_Largeur'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_carte_Largeur') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_carte_Largeur&Code_carte='.$Code_carte, 'lien', 'bouton_modifier_carte_Largeur');
        }
        $trans['{bouton_modifier_carte_Largeur}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_carte_Largeur') : '';

        // carte_Fichier
        if ( $mf_droits_defaut['api_modifier__carte_Fichier'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_carte_Fichier') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_carte_Fichier&Code_carte='.$Code_carte, 'lien', 'bouton_modifier_carte_Fichier');
        }
        $trans['{bouton_modifier_carte_Fichier}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_carte_Fichier') : '';

        // Code_groupe
        if ( $mf_droits_defaut['api_modifier_ref__carte__Code_groupe'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_carte__Code_groupe') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_carte__Code_groupe&Code_carte='.$Code_carte, 'lien', 'bouton_modifier_carte__Code_groupe');
        }
        $trans['{bouton_modifier_carte__Code_groupe}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_carte__Code_groupe') : '';

    /* prec_et_suiv */
    if ( $table_carte->mf_compter((isset($est_charge['groupe']) ? $mf_contexte['Code_groupe'] : 0))<100 )
    {
        $liste_carte = $table_carte->mf_lister_contexte();
        // prec
        $prec_et_suiv = prec_suiv($liste_carte, $carte['Code_carte']);
        $prec=['link'=>'', 'title'=>''];
        $suiv=['link'=>'', 'title'=>''];
        if (isset($prec_et_suiv['prec']['Code_carte']))
        {
            $prec['link'] = get_nom_page_courante().'?act=apercu_carte&Code_carte='.$prec_et_suiv['prec']['Code_carte'];
            $prec['title'] = htmlspecialchars(get_titre_ligne_table('carte', $prec_et_suiv['prec']));
        }
        // suiv
        if (isset($prec_et_suiv['suiv']['Code_carte']))
        {
            $suiv['link'] = get_nom_page_courante().'?act=apercu_carte&Code_carte='.$prec_et_suiv['suiv']['Code_carte'];
            $suiv['title'] = htmlspecialchars(get_titre_ligne_table('carte', $prec_et_suiv['suiv']));
        }
        $trans['{pager_carte}'] = get_code_pager($prec, $suiv);
    }
    else
    {
        $trans['{pager_carte}'] = '';
    }

    /* carte_Nom */
        if ( $mf_droits_defaut['api_modifier__carte_Nom'] )
            $trans['{carte_Nom}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_carte' => $carte['Code_carte']) , 'DB_name' => 'carte_Nom' , 'valeur_initiale' => $carte['carte_Nom'] ]);
        else
            $trans['{carte_Nom}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_carte' => $carte['Code_carte']) , 'DB_name' => 'carte_Nom' , 'valeur_initiale' => $carte['carte_Nom'] ]);

    /* carte_Hauteur */
        if ( $mf_droits_defaut['api_modifier__carte_Hauteur'] )
            $trans['{carte_Hauteur}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_carte' => $carte['Code_carte']) , 'DB_name' => 'carte_Hauteur' , 'valeur_initiale' => $carte['carte_Hauteur'] ]);
        else
            $trans['{carte_Hauteur}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_carte' => $carte['Code_carte']) , 'DB_name' => 'carte_Hauteur' , 'valeur_initiale' => $carte['carte_Hauteur'] ]);

    /* carte_Largeur */
        if ( $mf_droits_defaut['api_modifier__carte_Largeur'] )
            $trans['{carte_Largeur}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_carte' => $carte['Code_carte']) , 'DB_name' => 'carte_Largeur' , 'valeur_initiale' => $carte['carte_Largeur'] ]);
        else
            $trans['{carte_Largeur}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_carte' => $carte['Code_carte']) , 'DB_name' => 'carte_Largeur' , 'valeur_initiale' => $carte['carte_Largeur'] ]);

    /* carte_Fichier */
        if ( $mf_droits_defaut['api_modifier__carte_Fichier'] )
            $trans['{carte_Fichier}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_carte' => $carte['Code_carte']) , 'DB_name' => 'carte_Fichier' , 'valeur_initiale' => $carte['carte_Fichier'] ]);
        else
            $trans['{carte_Fichier}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_carte' => $carte['Code_carte']) , 'DB_name' => 'carte_Fichier' , 'valeur_initiale' => $carte['carte_Fichier'] ]);

    /* Code_groupe */
        if ( $mf_droits_defaut['api_modifier_ref__carte__Code_groupe'] )
            $trans['{Code_groupe}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_carte' => $carte['Code_carte']) , 'DB_name' => 'Code_groupe' , 'valeur_initiale' => $carte['Code_groupe'] , 'nom_table' => 'carte' ]);
        else
            $trans['{Code_groupe}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_carte' => $carte['Code_carte']) , 'DB_name' => 'Code_groupe' , 'valeur_initiale' => $carte['Code_groupe'] , 'nom_table' => 'carte' ]);

