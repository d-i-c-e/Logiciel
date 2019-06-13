<?php

    /* Actualisation des droits */
    Hook_personnage::hook_actualiser_les_droits_modifier($personnage['Code_personnage']);
    Hook_personnage::hook_actualiser_les_droits_supprimer($personnage['Code_personnage']);

    /* boutons */
        if ($mf_droits_defaut['personnage__MODIFIER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_personnage') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_personnage&Code_personnage='.$Code_personnage, 'lien', 'bouton_modifier_personnage');
        }
        $trans['{bouton_modifier_personnage}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_personnage') : '';
        if ($mf_droits_defaut['personnage__SUPPRIMER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_SUPPRIMER_PREC . get_nom_colonne('bouton_supprimer_personnage') . BOUTON_LIBELLE_SUPPRIMER_SUIV, get_nom_page_courante().'?act=supprimer_personnage&Code_personnage='.$Code_personnage, 'lien', 'bouton_supprimer_personnage');
        }
        $trans['{bouton_supprimer_personnage}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_supprimer_personnage', BOUTON_CLASSE_SUPPRIMER) : '';

        // personnage_Fichier_Fichier
        if ( $mf_droits_defaut['api_modifier__personnage_Fichier_Fichier'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_personnage_Fichier_Fichier') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_personnage_Fichier_Fichier&Code_personnage='.$Code_personnage, 'lien', 'bouton_modifier_personnage_Fichier_Fichier');
        }
        $trans['{bouton_modifier_personnage_Fichier_Fichier}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_personnage_Fichier_Fichier') : '';

        // personnage_Conservation
        if ( $mf_droits_defaut['api_modifier__personnage_Conservation'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_personnage_Conservation') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_personnage_Conservation&Code_personnage='.$Code_personnage, 'lien', 'bouton_modifier_personnage_Conservation');
        }
        $trans['{bouton_modifier_personnage_Conservation}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_personnage_Conservation') : '';

        // Code_joueur
        if ( $mf_droits_defaut['api_modifier_ref__personnage__Code_joueur'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_personnage__Code_joueur') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_personnage__Code_joueur&Code_personnage='.$Code_personnage, 'lien', 'bouton_modifier_personnage__Code_joueur');
        }
        $trans['{bouton_modifier_personnage__Code_joueur}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_personnage__Code_joueur') : '';

        // Code_groupe
        if ( $mf_droits_defaut['api_modifier_ref__personnage__Code_groupe'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_personnage__Code_groupe') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_personnage__Code_groupe&Code_personnage='.$Code_personnage, 'lien', 'bouton_modifier_personnage__Code_groupe');
        }
        $trans['{bouton_modifier_personnage__Code_groupe}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_personnage__Code_groupe') : '';

    /* prec_et_suiv */
    if ( $table_personnage->mf_compter((isset($est_charge['joueur']) ? $mf_contexte['Code_joueur'] : 0), (isset($est_charge['groupe']) ? $mf_contexte['Code_groupe'] : 0))<100 )
    {
        $liste_personnage = $table_personnage->mf_lister_contexte();
        // prec
        $prec_et_suiv = prec_suiv($liste_personnage, $personnage['Code_personnage']);
        $prec=['link'=>'', 'title'=>''];
        $suiv=['link'=>'', 'title'=>''];
        if (isset($prec_et_suiv['prec']['Code_personnage']))
        {
            $prec['link'] = get_nom_page_courante().'?act=apercu_personnage&Code_personnage='.$prec_et_suiv['prec']['Code_personnage'];
            $prec['title'] = htmlspecialchars(get_titre_ligne_table('personnage', $prec_et_suiv['prec']));
        }
        // suiv
        if (isset($prec_et_suiv['suiv']['Code_personnage']))
        {
            $suiv['link'] = get_nom_page_courante().'?act=apercu_personnage&Code_personnage='.$prec_et_suiv['suiv']['Code_personnage'];
            $suiv['title'] = htmlspecialchars(get_titre_ligne_table('personnage', $prec_et_suiv['suiv']));
        }
        $trans['{pager_personnage}'] = get_code_pager($prec, $suiv);
    }
    else
    {
        $trans['{pager_personnage}'] = '';
    }

    /* personnage_Fichier_Fichier */
        if ( $mf_droits_defaut['api_modifier__personnage_Fichier_Fichier'] )
            $trans['{personnage_Fichier_Fichier}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_personnage' => $personnage['Code_personnage']) , 'DB_name' => 'personnage_Fichier_Fichier' , 'valeur_initiale' => $personnage['personnage_Fichier_Fichier'] ]);
        else
            $trans['{personnage_Fichier_Fichier}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_personnage' => $personnage['Code_personnage']) , 'DB_name' => 'personnage_Fichier_Fichier' , 'valeur_initiale' => $personnage['personnage_Fichier_Fichier'] ]);

    /* personnage_Conservation */
        if ( $mf_droits_defaut['api_modifier__personnage_Conservation'] )
            $trans['{personnage_Conservation}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_personnage' => $personnage['Code_personnage']) , 'DB_name' => 'personnage_Conservation' , 'valeur_initiale' => $personnage['personnage_Conservation'], 'class' => 'button' ]);
        else
            $trans['{personnage_Conservation}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_personnage' => $personnage['Code_personnage']) , 'DB_name' => 'personnage_Conservation' , 'valeur_initiale' => $personnage['personnage_Conservation'] ]);

    /* Code_joueur */
        if ( $mf_droits_defaut['api_modifier_ref__personnage__Code_joueur'] )
            $trans['{Code_joueur}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_personnage' => $personnage['Code_personnage']) , 'DB_name' => 'Code_joueur' , 'valeur_initiale' => $personnage['Code_joueur'] , 'nom_table' => 'personnage' ]);
        else
            $trans['{Code_joueur}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_personnage' => $personnage['Code_personnage']) , 'DB_name' => 'Code_joueur' , 'valeur_initiale' => $personnage['Code_joueur'] , 'nom_table' => 'personnage' ]);

    /* Code_groupe */
        if ( $mf_droits_defaut['api_modifier_ref__personnage__Code_groupe'] )
            $trans['{Code_groupe}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_personnage' => $personnage['Code_personnage']) , 'DB_name' => 'Code_groupe' , 'valeur_initiale' => $personnage['Code_groupe'] , 'nom_table' => 'personnage' ]);
        else
            $trans['{Code_groupe}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_personnage' => $personnage['Code_personnage']) , 'DB_name' => 'Code_groupe' , 'valeur_initiale' => $personnage['Code_groupe'] , 'nom_table' => 'personnage' ]);

