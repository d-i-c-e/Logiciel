<?php

    /* Actualisation des droits */
    Hook_parametre_valeur::hook_actualiser_les_droits_modifier($parametre_valeur['Code_parametre_valeur']);
    Hook_parametre_valeur::hook_actualiser_les_droits_supprimer($parametre_valeur['Code_parametre_valeur']);

    /* boutons */
        if ($mf_droits_defaut['parametre_valeur__MODIFIER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_parametre_valeur') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_parametre_valeur&Code_parametre_valeur='.$Code_parametre_valeur, 'lien', 'bouton_modifier_parametre_valeur');
        }
        $trans['{bouton_modifier_parametre_valeur}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_parametre_valeur') : '';
        if ($mf_droits_defaut['parametre_valeur__SUPPRIMER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_SUPPRIMER_PREC . get_nom_colonne('bouton_supprimer_parametre_valeur') . BOUTON_LIBELLE_SUPPRIMER_SUIV, get_nom_page_courante().'?act=supprimer_parametre_valeur&Code_parametre_valeur='.$Code_parametre_valeur, 'lien', 'bouton_supprimer_parametre_valeur');
        }
        $trans['{bouton_supprimer_parametre_valeur}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_supprimer_parametre_valeur', BOUTON_CLASSE_SUPPRIMER) : '';

        // parametre_valeur_Libelle
        if ( $mf_droits_defaut['api_modifier__parametre_valeur_Libelle'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_parametre_valeur_Libelle') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_parametre_valeur_Libelle&Code_parametre_valeur='.$Code_parametre_valeur, 'lien', 'bouton_modifier_parametre_valeur_Libelle');
        }
        $trans['{bouton_modifier_parametre_valeur_Libelle}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_parametre_valeur_Libelle') : '';

        // Code_parametre
        if ( $mf_droits_defaut['api_modifier_ref__parametre_valeur__Code_parametre'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_parametre_valeur__Code_parametre') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_parametre_valeur__Code_parametre&Code_parametre_valeur='.$Code_parametre_valeur, 'lien', 'bouton_modifier_parametre_valeur__Code_parametre');
        }
        $trans['{bouton_modifier_parametre_valeur__Code_parametre}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_parametre_valeur__Code_parametre') : '';

    /* prec_et_suiv */
    if ( $table_parametre_valeur->mf_compter((isset($est_charge['parametre']) ? $mf_contexte['Code_parametre'] : 0))<100 )
    {
        $liste_parametre_valeur = $table_parametre_valeur->mf_lister_contexte();
        // prec
        $prec_et_suiv = prec_suiv($liste_parametre_valeur, $parametre_valeur['Code_parametre_valeur']);
        $prec=['link'=>'', 'title'=>''];
        $suiv=['link'=>'', 'title'=>''];
        if (isset($prec_et_suiv['prec']['Code_parametre_valeur']))
        {
            $prec['link'] = get_nom_page_courante().'?act=apercu_parametre_valeur&Code_parametre_valeur='.$prec_et_suiv['prec']['Code_parametre_valeur'];
            $prec['title'] = htmlspecialchars(get_titre_ligne_table('parametre_valeur', $prec_et_suiv['prec']));
        }
        // suiv
        if (isset($prec_et_suiv['suiv']['Code_parametre_valeur']))
        {
            $suiv['link'] = get_nom_page_courante().'?act=apercu_parametre_valeur&Code_parametre_valeur='.$prec_et_suiv['suiv']['Code_parametre_valeur'];
            $suiv['title'] = htmlspecialchars(get_titre_ligne_table('parametre_valeur', $prec_et_suiv['suiv']));
        }
        $trans['{pager_parametre_valeur}'] = get_code_pager($prec, $suiv);
    }
    else
    {
        $trans['{pager_parametre_valeur}'] = '';
    }

    /* parametre_valeur_Libelle */
        if ( $mf_droits_defaut['api_modifier__parametre_valeur_Libelle'] )
            $trans['{parametre_valeur_Libelle}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_parametre_valeur' => $parametre_valeur['Code_parametre_valeur']) , 'DB_name' => 'parametre_valeur_Libelle' , 'valeur_initiale' => $parametre_valeur['parametre_valeur_Libelle'] ]);
        else
            $trans['{parametre_valeur_Libelle}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_parametre_valeur' => $parametre_valeur['Code_parametre_valeur']) , 'DB_name' => 'parametre_valeur_Libelle' , 'valeur_initiale' => $parametre_valeur['parametre_valeur_Libelle'] ]);

    /* Code_parametre */
        if ( $mf_droits_defaut['api_modifier_ref__parametre_valeur__Code_parametre'] )
            $trans['{Code_parametre}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_parametre_valeur' => $parametre_valeur['Code_parametre_valeur']) , 'DB_name' => 'Code_parametre' , 'valeur_initiale' => $parametre_valeur['Code_parametre'] , 'nom_table' => 'parametre_valeur' ]);
        else
            $trans['{Code_parametre}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_parametre_valeur' => $parametre_valeur['Code_parametre_valeur']) , 'DB_name' => 'Code_parametre' , 'valeur_initiale' => $parametre_valeur['Code_parametre'] , 'nom_table' => 'parametre_valeur' ]);

