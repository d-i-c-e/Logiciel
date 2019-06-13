<?php

    /* Actualisation des droits */
    Hook_objet::hook_actualiser_les_droits_modifier($objet['Code_objet']);
    Hook_objet::hook_actualiser_les_droits_supprimer($objet['Code_objet']);

    /* boutons */
        if ($mf_droits_defaut['objet__MODIFIER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_objet') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_objet&Code_objet='.$Code_objet, 'lien', 'bouton_modifier_objet');
        }
        $trans['{bouton_modifier_objet}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_objet') : '';
        if ($mf_droits_defaut['objet__SUPPRIMER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_SUPPRIMER_PREC . get_nom_colonne('bouton_supprimer_objet') . BOUTON_LIBELLE_SUPPRIMER_SUIV, get_nom_page_courante().'?act=supprimer_objet&Code_objet='.$Code_objet, 'lien', 'bouton_supprimer_objet');
        }
        $trans['{bouton_supprimer_objet}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_supprimer_objet', BOUTON_CLASSE_SUPPRIMER) : '';

        // objet_Libelle
        if ( $mf_droits_defaut['api_modifier__objet_Libelle'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_objet_Libelle') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_objet_Libelle&Code_objet='.$Code_objet, 'lien', 'bouton_modifier_objet_Libelle');
        }
        $trans['{bouton_modifier_objet_Libelle}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_objet_Libelle') : '';

        // objet_Image_Fichier
        if ( $mf_droits_defaut['api_modifier__objet_Image_Fichier'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_objet_Image_Fichier') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_objet_Image_Fichier&Code_objet='.$Code_objet, 'lien', 'bouton_modifier_objet_Image_Fichier');
        }
        $trans['{bouton_modifier_objet_Image_Fichier}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_objet_Image_Fichier') : '';

        // Code_type
        if ( $mf_droits_defaut['api_modifier_ref__objet__Code_type'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_objet__Code_type') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_objet__Code_type&Code_objet='.$Code_objet, 'lien', 'bouton_modifier_objet__Code_type');
        }
        $trans['{bouton_modifier_objet__Code_type}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_objet__Code_type') : '';

    /* prec_et_suiv */
    if ( $table_objet->mf_compter((isset($est_charge['type']) ? $mf_contexte['Code_type'] : 0))<100 )
    {
        $liste_objet = $table_objet->mf_lister_contexte();
        // prec
        $prec_et_suiv = prec_suiv($liste_objet, $objet['Code_objet']);
        $prec=['link'=>'', 'title'=>''];
        $suiv=['link'=>'', 'title'=>''];
        if (isset($prec_et_suiv['prec']['Code_objet']))
        {
            $prec['link'] = get_nom_page_courante().'?act=apercu_objet&Code_objet='.$prec_et_suiv['prec']['Code_objet'];
            $prec['title'] = htmlspecialchars(get_titre_ligne_table('objet', $prec_et_suiv['prec']));
        }
        // suiv
        if (isset($prec_et_suiv['suiv']['Code_objet']))
        {
            $suiv['link'] = get_nom_page_courante().'?act=apercu_objet&Code_objet='.$prec_et_suiv['suiv']['Code_objet'];
            $suiv['title'] = htmlspecialchars(get_titre_ligne_table('objet', $prec_et_suiv['suiv']));
        }
        $trans['{pager_objet}'] = get_code_pager($prec, $suiv);
    }
    else
    {
        $trans['{pager_objet}'] = '';
    }

    /* objet_Libelle */
        if ( $mf_droits_defaut['api_modifier__objet_Libelle'] )
            $trans['{objet_Libelle}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_objet' => $objet['Code_objet']) , 'DB_name' => 'objet_Libelle' , 'valeur_initiale' => $objet['objet_Libelle'] ]);
        else
            $trans['{objet_Libelle}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_objet' => $objet['Code_objet']) , 'DB_name' => 'objet_Libelle' , 'valeur_initiale' => $objet['objet_Libelle'] ]);

    /* objet_Image_Fichier */
        if ( $mf_droits_defaut['api_modifier__objet_Image_Fichier'] )
            $trans['{objet_Image_Fichier}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_objet' => $objet['Code_objet']) , 'DB_name' => 'objet_Image_Fichier' , 'valeur_initiale' => $objet['objet_Image_Fichier'] ]);
        else
            $trans['{objet_Image_Fichier}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_objet' => $objet['Code_objet']) , 'DB_name' => 'objet_Image_Fichier' , 'valeur_initiale' => $objet['objet_Image_Fichier'] ]);

    /* Code_type */
        if ( $mf_droits_defaut['api_modifier_ref__objet__Code_type'] )
            $trans['{Code_type}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_objet' => $objet['Code_objet']) , 'DB_name' => 'Code_type' , 'valeur_initiale' => $objet['Code_type'] , 'nom_table' => 'objet' ]);
        else
            $trans['{Code_type}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_objet' => $objet['Code_objet']) , 'DB_name' => 'Code_type' , 'valeur_initiale' => $objet['Code_type'] , 'nom_table' => 'objet' ]);

