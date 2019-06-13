<?php

    /* Actualisation des droits */
    Hook_liste_contacts::hook_actualiser_les_droits_modifier($liste_contacts['Code_liste_contacts']);
    Hook_liste_contacts::hook_actualiser_les_droits_supprimer($liste_contacts['Code_liste_contacts']);

    /* boutons */
        if ($mf_droits_defaut['liste_contacts__MODIFIER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_liste_contacts') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_liste_contacts&Code_liste_contacts='.$Code_liste_contacts, 'lien', 'bouton_modifier_liste_contacts');
        }
        $trans['{bouton_modifier_liste_contacts}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_liste_contacts') : '';
        if ($mf_droits_defaut['liste_contacts__SUPPRIMER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_SUPPRIMER_PREC . get_nom_colonne('bouton_supprimer_liste_contacts') . BOUTON_LIBELLE_SUPPRIMER_SUIV, get_nom_page_courante().'?act=supprimer_liste_contacts&Code_liste_contacts='.$Code_liste_contacts, 'lien', 'bouton_supprimer_liste_contacts');
        }
        $trans['{bouton_supprimer_liste_contacts}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_supprimer_liste_contacts', BOUTON_CLASSE_SUPPRIMER) : '';

        // liste_contacts_Nom
        if ( $mf_droits_defaut['api_modifier__liste_contacts_Nom'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_liste_contacts_Nom') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_liste_contacts_Nom&Code_liste_contacts='.$Code_liste_contacts, 'lien', 'bouton_modifier_liste_contacts_Nom');
        }
        $trans['{bouton_modifier_liste_contacts_Nom}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_liste_contacts_Nom') : '';

        // Code_joueur
        if ( $mf_droits_defaut['api_modifier_ref__liste_contacts__Code_joueur'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_liste_contacts__Code_joueur') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_liste_contacts__Code_joueur&Code_liste_contacts='.$Code_liste_contacts, 'lien', 'bouton_modifier_liste_contacts__Code_joueur');
        }
        $trans['{bouton_modifier_liste_contacts__Code_joueur}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_liste_contacts__Code_joueur') : '';

    /* prec_et_suiv */
    if ( $table_liste_contacts->mf_compter((isset($est_charge['joueur']) ? $mf_contexte['Code_joueur'] : 0))<100 )
    {
        $liste_liste_contacts = $table_liste_contacts->mf_lister_contexte();
        // prec
        $prec_et_suiv = prec_suiv($liste_liste_contacts, $liste_contacts['Code_liste_contacts']);
        $prec=['link'=>'', 'title'=>''];
        $suiv=['link'=>'', 'title'=>''];
        if (isset($prec_et_suiv['prec']['Code_liste_contacts']))
        {
            $prec['link'] = get_nom_page_courante().'?act=apercu_liste_contacts&Code_liste_contacts='.$prec_et_suiv['prec']['Code_liste_contacts'];
            $prec['title'] = htmlspecialchars(get_titre_ligne_table('liste_contacts', $prec_et_suiv['prec']));
        }
        // suiv
        if (isset($prec_et_suiv['suiv']['Code_liste_contacts']))
        {
            $suiv['link'] = get_nom_page_courante().'?act=apercu_liste_contacts&Code_liste_contacts='.$prec_et_suiv['suiv']['Code_liste_contacts'];
            $suiv['title'] = htmlspecialchars(get_titre_ligne_table('liste_contacts', $prec_et_suiv['suiv']));
        }
        $trans['{pager_liste_contacts}'] = get_code_pager($prec, $suiv);
    }
    else
    {
        $trans['{pager_liste_contacts}'] = '';
    }

    /* liste_contacts_Nom */
        if ( $mf_droits_defaut['api_modifier__liste_contacts_Nom'] )
            $trans['{liste_contacts_Nom}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_liste_contacts' => $liste_contacts['Code_liste_contacts']) , 'DB_name' => 'liste_contacts_Nom' , 'valeur_initiale' => $liste_contacts['liste_contacts_Nom'] ]);
        else
            $trans['{liste_contacts_Nom}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_liste_contacts' => $liste_contacts['Code_liste_contacts']) , 'DB_name' => 'liste_contacts_Nom' , 'valeur_initiale' => $liste_contacts['liste_contacts_Nom'] ]);

    /* Code_joueur */
        if ( $mf_droits_defaut['api_modifier_ref__liste_contacts__Code_joueur'] )
            $trans['{Code_joueur}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_liste_contacts' => $liste_contacts['Code_liste_contacts']) , 'DB_name' => 'Code_joueur' , 'valeur_initiale' => $liste_contacts['Code_joueur'] , 'nom_table' => 'liste_contacts' ]);
        else
            $trans['{Code_joueur}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_liste_contacts' => $liste_contacts['Code_liste_contacts']) , 'DB_name' => 'Code_joueur' , 'valeur_initiale' => $liste_contacts['Code_joueur'] , 'nom_table' => 'liste_contacts' ]);

