<?php

    /* Actualisation des droits */
    Hook_type::hook_actualiser_les_droits_modifier($type['Code_type']);
    Hook_type::hook_actualiser_les_droits_supprimer($type['Code_type']);

    /* boutons */
        if ($mf_droits_defaut['type__MODIFIER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_type') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_type&Code_type='.$Code_type, 'lien', 'bouton_modifier_type');
        }
        $trans['{bouton_modifier_type}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_type') : '';
        if ($mf_droits_defaut['type__SUPPRIMER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_SUPPRIMER_PREC . get_nom_colonne('bouton_supprimer_type') . BOUTON_LIBELLE_SUPPRIMER_SUIV, get_nom_page_courante().'?act=supprimer_type&Code_type='.$Code_type, 'lien', 'bouton_supprimer_type');
        }
        $trans['{bouton_supprimer_type}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_supprimer_type', BOUTON_CLASSE_SUPPRIMER) : '';

        // type_Libelle
        if ( $mf_droits_defaut['api_modifier__type_Libelle'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_type_Libelle') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_type_Libelle&Code_type='.$Code_type, 'lien', 'bouton_modifier_type_Libelle');
        }
        $trans['{bouton_modifier_type_Libelle}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_type_Libelle') : '';

        // Code_ressource
        if ( $mf_droits_defaut['api_modifier_ref__type__Code_ressource'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_type__Code_ressource') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_type__Code_ressource&Code_type='.$Code_type, 'lien', 'bouton_modifier_type__Code_ressource');
        }
        $trans['{bouton_modifier_type__Code_ressource}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_type__Code_ressource') : '';

    /* prec_et_suiv */
    if ( $table_type->mf_compter((isset($est_charge['ressource']) ? $mf_contexte['Code_ressource'] : 0))<100 )
    {
        $liste_type = $table_type->mf_lister_contexte();
        // prec
        $prec_et_suiv = prec_suiv($liste_type, $type['Code_type']);
        $prec=['link'=>'', 'title'=>''];
        $suiv=['link'=>'', 'title'=>''];
        if (isset($prec_et_suiv['prec']['Code_type']))
        {
            $prec['link'] = get_nom_page_courante().'?act=apercu_type&Code_type='.$prec_et_suiv['prec']['Code_type'];
            $prec['title'] = htmlspecialchars(get_titre_ligne_table('type', $prec_et_suiv['prec']));
        }
        // suiv
        if (isset($prec_et_suiv['suiv']['Code_type']))
        {
            $suiv['link'] = get_nom_page_courante().'?act=apercu_type&Code_type='.$prec_et_suiv['suiv']['Code_type'];
            $suiv['title'] = htmlspecialchars(get_titre_ligne_table('type', $prec_et_suiv['suiv']));
        }
        $trans['{pager_type}'] = get_code_pager($prec, $suiv);
    }
    else
    {
        $trans['{pager_type}'] = '';
    }

    /* type_Libelle */
        if ( $mf_droits_defaut['api_modifier__type_Libelle'] )
            $trans['{type_Libelle}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_type' => $type['Code_type']) , 'DB_name' => 'type_Libelle' , 'valeur_initiale' => $type['type_Libelle'] ]);
        else
            $trans['{type_Libelle}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_type' => $type['Code_type']) , 'DB_name' => 'type_Libelle' , 'valeur_initiale' => $type['type_Libelle'] ]);

    /* Code_ressource */
        if ( $mf_droits_defaut['api_modifier_ref__type__Code_ressource'] )
            $trans['{Code_ressource}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_type' => $type['Code_type']) , 'DB_name' => 'Code_ressource' , 'valeur_initiale' => $type['Code_ressource'] , 'nom_table' => 'type' ]);
        else
            $trans['{Code_ressource}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_type' => $type['Code_type']) , 'DB_name' => 'Code_ressource' , 'valeur_initiale' => $type['Code_ressource'] , 'nom_table' => 'type' ]);

