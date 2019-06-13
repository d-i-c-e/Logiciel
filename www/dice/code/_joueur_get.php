<?php

    /* Actualisation des droits */
    Hook_joueur::hook_actualiser_les_droits_modifier($joueur['Code_joueur']);
    Hook_joueur::hook_actualiser_les_droits_supprimer($joueur['Code_joueur']);

    /* boutons */
        if ($mf_droits_defaut['joueur__MODIFIER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_joueur') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_joueur&Code_joueur='.$Code_joueur, 'lien', 'bouton_modifier_joueur');
        }
        $trans['{bouton_modifier_joueur}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_joueur') : '';
        if ($mf_droits_defaut['joueur__MODIFIER_PWD'])
        {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_MODIFIER_PWD_PREC . get_nom_colonne('bouton_modpwd_joueur') . BOUTON_LIBELLE_MODIFIER_PWD_SUIV, get_nom_page_courante().'?act=modpwd&Code_joueur='.$Code_joueur, 'lien', 'bouton_modpwd_joueur');
        }
        $trans['{bouton_modpwd_joueur}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modpwd_joueur') : '';
        if ($mf_droits_defaut['joueur__SUPPRIMER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_SUPPRIMER_PREC . get_nom_colonne('bouton_supprimer_joueur') . BOUTON_LIBELLE_SUPPRIMER_SUIV, get_nom_page_courante().'?act=supprimer_joueur&Code_joueur='.$Code_joueur, 'lien', 'bouton_supprimer_joueur');
        }
        $trans['{bouton_supprimer_joueur}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_supprimer_joueur', BOUTON_CLASSE_SUPPRIMER) : '';

        // joueur_Email
        if ( $mf_droits_defaut['api_modifier__joueur_Email'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_joueur_Email') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_joueur_Email&Code_joueur='.$Code_joueur, 'lien', 'bouton_modifier_joueur_Email');
        }
        $trans['{bouton_modifier_joueur_Email}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_joueur_Email') : '';

        // joueur_Identifiant
        if ( $mf_droits_defaut['api_modifier__joueur_Identifiant'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_joueur_Identifiant') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_joueur_Identifiant&Code_joueur='.$Code_joueur, 'lien', 'bouton_modifier_joueur_Identifiant');
        }
        $trans['{bouton_modifier_joueur_Identifiant}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_joueur_Identifiant') : '';

        // joueur_Password
        if ( $mf_droits_defaut['api_modifier__joueur_Password'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_joueur_Password') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_joueur_Password&Code_joueur='.$Code_joueur, 'lien', 'bouton_modifier_joueur_Password');
        }
        $trans['{bouton_modifier_joueur_Password}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_joueur_Password') : '';

        // joueur_Avatar_Fichier
        if ( $mf_droits_defaut['api_modifier__joueur_Avatar_Fichier'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_joueur_Avatar_Fichier') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_joueur_Avatar_Fichier&Code_joueur='.$Code_joueur, 'lien', 'bouton_modifier_joueur_Avatar_Fichier');
        }
        $trans['{bouton_modifier_joueur_Avatar_Fichier}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_joueur_Avatar_Fichier') : '';

        // joueur_Date_naissance
        if ( $mf_droits_defaut['api_modifier__joueur_Date_naissance'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_joueur_Date_naissance') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_joueur_Date_naissance&Code_joueur='.$Code_joueur, 'lien', 'bouton_modifier_joueur_Date_naissance');
        }
        $trans['{bouton_modifier_joueur_Date_naissance}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_joueur_Date_naissance') : '';

        // joueur_Date_inscription
        if ( $mf_droits_defaut['api_modifier__joueur_Date_inscription'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_joueur_Date_inscription') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_joueur_Date_inscription&Code_joueur='.$Code_joueur, 'lien', 'bouton_modifier_joueur_Date_inscription');
        }
        $trans['{bouton_modifier_joueur_Date_inscription}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_joueur_Date_inscription') : '';

    /* prec_et_suiv */
    if ( $table_joueur->mf_compter()<100 )
    {
        $liste_joueur = $table_joueur->mf_lister_contexte();
        // prec
        $prec_et_suiv = prec_suiv($liste_joueur, $joueur['Code_joueur']);
        $prec=['link'=>'', 'title'=>''];
        $suiv=['link'=>'', 'title'=>''];
        if (isset($prec_et_suiv['prec']['Code_joueur']))
        {
            $prec['link'] = get_nom_page_courante().'?act=apercu_joueur&Code_joueur='.$prec_et_suiv['prec']['Code_joueur'];
            $prec['title'] = htmlspecialchars(get_titre_ligne_table('joueur', $prec_et_suiv['prec']));
        }
        // suiv
        if (isset($prec_et_suiv['suiv']['Code_joueur']))
        {
            $suiv['link'] = get_nom_page_courante().'?act=apercu_joueur&Code_joueur='.$prec_et_suiv['suiv']['Code_joueur'];
            $suiv['title'] = htmlspecialchars(get_titre_ligne_table('joueur', $prec_et_suiv['suiv']));
        }
        $trans['{pager_joueur}'] = get_code_pager($prec, $suiv);
    }
    else
    {
        $trans['{pager_joueur}'] = '';
    }

    /* joueur_Email */
        if ( $mf_droits_defaut['api_modifier__joueur_Email'] )
            $trans['{joueur_Email}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_joueur' => $joueur['Code_joueur']) , 'DB_name' => 'joueur_Email' , 'valeur_initiale' => $joueur['joueur_Email'] ]);
        else
            $trans['{joueur_Email}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_joueur' => $joueur['Code_joueur']) , 'DB_name' => 'joueur_Email' , 'valeur_initiale' => $joueur['joueur_Email'] ]);

    /* joueur_Identifiant */
        if ( $mf_droits_defaut['api_modifier__joueur_Identifiant'] )
            $trans['{joueur_Identifiant}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_joueur' => $joueur['Code_joueur']) , 'DB_name' => 'joueur_Identifiant' , 'valeur_initiale' => $joueur['joueur_Identifiant'] ]);
        else
            $trans['{joueur_Identifiant}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_joueur' => $joueur['Code_joueur']) , 'DB_name' => 'joueur_Identifiant' , 'valeur_initiale' => $joueur['joueur_Identifiant'] ]);

    /* joueur_Password */
        $trans['{joueur_Password}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_joueur' => $joueur['Code_joueur']) , 'DB_name' => 'joueur_Password' , 'valeur_initiale' => $trans['{bouton_modpwd_joueur}'] , 'class' => 'html' , 'maj_auto' => false ]);

    /* joueur_Avatar_Fichier */
        if ( $mf_droits_defaut['api_modifier__joueur_Avatar_Fichier'] )
            $trans['{joueur_Avatar_Fichier}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_joueur' => $joueur['Code_joueur']) , 'DB_name' => 'joueur_Avatar_Fichier' , 'valeur_initiale' => $joueur['joueur_Avatar_Fichier'] ]);
        else
            $trans['{joueur_Avatar_Fichier}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_joueur' => $joueur['Code_joueur']) , 'DB_name' => 'joueur_Avatar_Fichier' , 'valeur_initiale' => $joueur['joueur_Avatar_Fichier'] ]);

    /* joueur_Date_naissance */
        if ( $mf_droits_defaut['api_modifier__joueur_Date_naissance'] )
            $trans['{joueur_Date_naissance}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_joueur' => $joueur['Code_joueur']) , 'DB_name' => 'joueur_Date_naissance' , 'valeur_initiale' => $joueur['joueur_Date_naissance'] ]);
        else
            $trans['{joueur_Date_naissance}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_joueur' => $joueur['Code_joueur']) , 'DB_name' => 'joueur_Date_naissance' , 'valeur_initiale' => $joueur['joueur_Date_naissance'] ]);

    /* joueur_Date_inscription */
        if ( $mf_droits_defaut['api_modifier__joueur_Date_inscription'] )
            $trans['{joueur_Date_inscription}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_joueur' => $joueur['Code_joueur']) , 'DB_name' => 'joueur_Date_inscription' , 'valeur_initiale' => $joueur['joueur_Date_inscription'] ]);
        else
            $trans['{joueur_Date_inscription}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_joueur' => $joueur['Code_joueur']) , 'DB_name' => 'joueur_Date_inscription' , 'valeur_initiale' => $joueur['joueur_Date_inscription'] ]);

