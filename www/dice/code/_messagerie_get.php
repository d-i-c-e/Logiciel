<?php

    /* Actualisation des droits */
    Hook_messagerie::hook_actualiser_les_droits_modifier($messagerie['Code_messagerie']);
    Hook_messagerie::hook_actualiser_les_droits_supprimer($messagerie['Code_messagerie']);

    /* boutons */
        if ($mf_droits_defaut['messagerie__MODIFIER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_messagerie') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_messagerie&Code_messagerie='.$Code_messagerie, 'lien', 'bouton_modifier_messagerie');
        }
        $trans['{bouton_modifier_messagerie}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_messagerie') : '';
        if ($mf_droits_defaut['messagerie__SUPPRIMER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_SUPPRIMER_PREC . get_nom_colonne('bouton_supprimer_messagerie') . BOUTON_LIBELLE_SUPPRIMER_SUIV, get_nom_page_courante().'?act=supprimer_messagerie&Code_messagerie='.$Code_messagerie, 'lien', 'bouton_supprimer_messagerie');
        }
        $trans['{bouton_supprimer_messagerie}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_supprimer_messagerie', BOUTON_CLASSE_SUPPRIMER) : '';

        // Code_joueur
        if ( $mf_droits_defaut['api_modifier_ref__messagerie__Code_joueur'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_messagerie__Code_joueur') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_messagerie__Code_joueur&Code_messagerie='.$Code_messagerie, 'lien', 'bouton_modifier_messagerie__Code_joueur');
        }
        $trans['{bouton_modifier_messagerie__Code_joueur}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_messagerie__Code_joueur') : '';

    /* prec_et_suiv */
    if ( $table_messagerie->mf_compter((isset($est_charge['joueur']) ? $mf_contexte['Code_joueur'] : 0))<100 )
    {
        $liste_messagerie = $table_messagerie->mf_lister_contexte();
        // prec
        $prec_et_suiv = prec_suiv($liste_messagerie, $messagerie['Code_messagerie']);
        $prec=['link'=>'', 'title'=>''];
        $suiv=['link'=>'', 'title'=>''];
        if (isset($prec_et_suiv['prec']['Code_messagerie']))
        {
            $prec['link'] = get_nom_page_courante().'?act=apercu_messagerie&Code_messagerie='.$prec_et_suiv['prec']['Code_messagerie'];
            $prec['title'] = htmlspecialchars(get_titre_ligne_table('messagerie', $prec_et_suiv['prec']));
        }
        // suiv
        if (isset($prec_et_suiv['suiv']['Code_messagerie']))
        {
            $suiv['link'] = get_nom_page_courante().'?act=apercu_messagerie&Code_messagerie='.$prec_et_suiv['suiv']['Code_messagerie'];
            $suiv['title'] = htmlspecialchars(get_titre_ligne_table('messagerie', $prec_et_suiv['suiv']));
        }
        $trans['{pager_messagerie}'] = get_code_pager($prec, $suiv);
    }
    else
    {
        $trans['{pager_messagerie}'] = '';
    }

    /* Code_joueur */
        if ( $mf_droits_defaut['api_modifier_ref__messagerie__Code_joueur'] )
            $trans['{Code_joueur}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_messagerie' => $messagerie['Code_messagerie']) , 'DB_name' => 'Code_joueur' , 'valeur_initiale' => $messagerie['Code_joueur'] , 'nom_table' => 'messagerie' ]);
        else
            $trans['{Code_joueur}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_messagerie' => $messagerie['Code_messagerie']) , 'DB_name' => 'Code_joueur' , 'valeur_initiale' => $messagerie['Code_joueur'] , 'nom_table' => 'messagerie' ]);

