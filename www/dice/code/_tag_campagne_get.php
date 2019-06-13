<?php

    /* Actualisation des droits */
    Hook_tag_campagne::hook_actualiser_les_droits_modifier($tag_campagne['Code_tag_campagne']);
    Hook_tag_campagne::hook_actualiser_les_droits_supprimer($tag_campagne['Code_tag_campagne']);

    /* boutons */
        if ($mf_droits_defaut['tag_campagne__MODIFIER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_tag_campagne') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_tag_campagne&Code_tag_campagne='.$Code_tag_campagne, 'lien', 'bouton_modifier_tag_campagne');
        }
        $trans['{bouton_modifier_tag_campagne}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_tag_campagne') : '';
        if ($mf_droits_defaut['tag_campagne__SUPPRIMER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_SUPPRIMER_PREC . get_nom_colonne('bouton_supprimer_tag_campagne') . BOUTON_LIBELLE_SUPPRIMER_SUIV, get_nom_page_courante().'?act=supprimer_tag_campagne&Code_tag_campagne='.$Code_tag_campagne, 'lien', 'bouton_supprimer_tag_campagne');
        }
        $trans['{bouton_supprimer_tag_campagne}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_supprimer_tag_campagne', BOUTON_CLASSE_SUPPRIMER) : '';

        // tag_campagne_Libelle
        if ( $mf_droits_defaut['api_modifier__tag_campagne_Libelle'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_tag_campagne_Libelle') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_tag_campagne_Libelle&Code_tag_campagne='.$Code_tag_campagne, 'lien', 'bouton_modifier_tag_campagne_Libelle');
        }
        $trans['{bouton_modifier_tag_campagne_Libelle}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_tag_campagne_Libelle') : '';

    /* prec_et_suiv */
    if ( $table_tag_campagne->mf_compter()<100 )
    {
        $liste_tag_campagne = $table_tag_campagne->mf_lister_contexte();
        // prec
        $prec_et_suiv = prec_suiv($liste_tag_campagne, $tag_campagne['Code_tag_campagne']);
        $prec=['link'=>'', 'title'=>''];
        $suiv=['link'=>'', 'title'=>''];
        if (isset($prec_et_suiv['prec']['Code_tag_campagne']))
        {
            $prec['link'] = get_nom_page_courante().'?act=apercu_tag_campagne&Code_tag_campagne='.$prec_et_suiv['prec']['Code_tag_campagne'];
            $prec['title'] = htmlspecialchars(get_titre_ligne_table('tag_campagne', $prec_et_suiv['prec']));
        }
        // suiv
        if (isset($prec_et_suiv['suiv']['Code_tag_campagne']))
        {
            $suiv['link'] = get_nom_page_courante().'?act=apercu_tag_campagne&Code_tag_campagne='.$prec_et_suiv['suiv']['Code_tag_campagne'];
            $suiv['title'] = htmlspecialchars(get_titre_ligne_table('tag_campagne', $prec_et_suiv['suiv']));
        }
        $trans['{pager_tag_campagne}'] = get_code_pager($prec, $suiv);
    }
    else
    {
        $trans['{pager_tag_campagne}'] = '';
    }

    /* tag_campagne_Libelle */
        if ( $mf_droits_defaut['api_modifier__tag_campagne_Libelle'] )
            $trans['{tag_campagne_Libelle}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_tag_campagne' => $tag_campagne['Code_tag_campagne']) , 'DB_name' => 'tag_campagne_Libelle' , 'valeur_initiale' => $tag_campagne['tag_campagne_Libelle'] ]);
        else
            $trans['{tag_campagne_Libelle}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_tag_campagne' => $tag_campagne['Code_tag_campagne']) , 'DB_name' => 'tag_campagne_Libelle' , 'valeur_initiale' => $tag_campagne['tag_campagne_Libelle'] ]);

