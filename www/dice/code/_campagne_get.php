<?php

    /* Actualisation des droits */
    Hook_campagne::hook_actualiser_les_droits_modifier($campagne['Code_campagne']);
    Hook_campagne::hook_actualiser_les_droits_supprimer($campagne['Code_campagne']);

    /* boutons */
        if ($mf_droits_defaut['campagne__MODIFIER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_campagne') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_campagne&Code_campagne='.$Code_campagne, 'lien', 'bouton_modifier_campagne');
        }
        $trans['{bouton_modifier_campagne}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_campagne') : '';
        if ($mf_droits_defaut['campagne__SUPPRIMER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_SUPPRIMER_PREC . get_nom_colonne('bouton_supprimer_campagne') . BOUTON_LIBELLE_SUPPRIMER_SUIV, get_nom_page_courante().'?act=supprimer_campagne&Code_campagne='.$Code_campagne, 'lien', 'bouton_supprimer_campagne');
        }
        $trans['{bouton_supprimer_campagne}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_supprimer_campagne', BOUTON_CLASSE_SUPPRIMER) : '';

        // campagne_Nom
        if ( $mf_droits_defaut['api_modifier__campagne_Nom'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_campagne_Nom') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_campagne_Nom&Code_campagne='.$Code_campagne, 'lien', 'bouton_modifier_campagne_Nom');
        }
        $trans['{bouton_modifier_campagne_Nom}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_campagne_Nom') : '';

        // campagne_Description
        if ( $mf_droits_defaut['api_modifier__campagne_Description'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_campagne_Description') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_campagne_Description&Code_campagne='.$Code_campagne, 'lien', 'bouton_modifier_campagne_Description');
        }
        $trans['{bouton_modifier_campagne_Description}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_campagne_Description') : '';

        // campagne_Image_Fichier
        if ( $mf_droits_defaut['api_modifier__campagne_Image_Fichier'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_campagne_Image_Fichier') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_campagne_Image_Fichier&Code_campagne='.$Code_campagne, 'lien', 'bouton_modifier_campagne_Image_Fichier');
        }
        $trans['{bouton_modifier_campagne_Image_Fichier}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_campagne_Image_Fichier') : '';

        // campagne_Nombre_joueur
        if ( $mf_droits_defaut['api_modifier__campagne_Nombre_joueur'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_campagne_Nombre_joueur') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_campagne_Nombre_joueur&Code_campagne='.$Code_campagne, 'lien', 'bouton_modifier_campagne_Nombre_joueur');
        }
        $trans['{bouton_modifier_campagne_Nombre_joueur}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_campagne_Nombre_joueur') : '';

        // campagne_Nombre_mj
        if ( $mf_droits_defaut['api_modifier__campagne_Nombre_mj'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_campagne_Nombre_mj') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_campagne_Nombre_mj&Code_campagne='.$Code_campagne, 'lien', 'bouton_modifier_campagne_Nombre_mj');
        }
        $trans['{bouton_modifier_campagne_Nombre_mj}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_campagne_Nombre_mj') : '';

    /* prec_et_suiv */
    if ( $table_campagne->mf_compter()<100 )
    {
        $liste_campagne = $table_campagne->mf_lister_contexte();
        // prec
        $prec_et_suiv = prec_suiv($liste_campagne, $campagne['Code_campagne']);
        $prec=['link'=>'', 'title'=>''];
        $suiv=['link'=>'', 'title'=>''];
        if (isset($prec_et_suiv['prec']['Code_campagne']))
        {
            $prec['link'] = get_nom_page_courante().'?act=apercu_campagne&Code_campagne='.$prec_et_suiv['prec']['Code_campagne'];
            $prec['title'] = htmlspecialchars(get_titre_ligne_table('campagne', $prec_et_suiv['prec']));
        }
        // suiv
        if (isset($prec_et_suiv['suiv']['Code_campagne']))
        {
            $suiv['link'] = get_nom_page_courante().'?act=apercu_campagne&Code_campagne='.$prec_et_suiv['suiv']['Code_campagne'];
            $suiv['title'] = htmlspecialchars(get_titre_ligne_table('campagne', $prec_et_suiv['suiv']));
        }
        $trans['{pager_campagne}'] = get_code_pager($prec, $suiv);
    }
    else
    {
        $trans['{pager_campagne}'] = '';
    }

    /* campagne_Nom */
        if ( $mf_droits_defaut['api_modifier__campagne_Nom'] )
            $trans['{campagne_Nom}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_campagne' => $campagne['Code_campagne']) , 'DB_name' => 'campagne_Nom' , 'valeur_initiale' => $campagne['campagne_Nom'] ]);
        else
            $trans['{campagne_Nom}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_campagne' => $campagne['Code_campagne']) , 'DB_name' => 'campagne_Nom' , 'valeur_initiale' => $campagne['campagne_Nom'] ]);

    /* campagne_Description */
        if ( $mf_droits_defaut['api_modifier__campagne_Description'] )
            $trans['{campagne_Description}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_campagne' => $campagne['Code_campagne']) , 'DB_name' => 'campagne_Description' , 'valeur_initiale' => $campagne['campagne_Description'] ]);
        else
            $trans['{campagne_Description}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_campagne' => $campagne['Code_campagne']) , 'DB_name' => 'campagne_Description' , 'valeur_initiale' => $campagne['campagne_Description'] , 'class' => 'text' ]);

    /* campagne_Image_Fichier */
        /* debut developpement */
            $trans['{campagne_Image_Fichier}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_campagne' => $campagne['Code_campagne']) , 'DB_name' => 'campagne_Image_Fichier' , 'valeur_initiale' => get_image($campagne['campagne_Image_Fichier'], 300, 300, false) , 'class' => 'html' , 'maj_auto' => false ]);
        /* fin developpement */

    /* campagne_Nombre_joueur */
        if ( $mf_droits_defaut['api_modifier__campagne_Nombre_joueur'] )
            $trans['{campagne_Nombre_joueur}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_campagne' => $campagne['Code_campagne']) , 'DB_name' => 'campagne_Nombre_joueur' , 'valeur_initiale' => $campagne['campagne_Nombre_joueur'] ]);
        else
            $trans['{campagne_Nombre_joueur}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_campagne' => $campagne['Code_campagne']) , 'DB_name' => 'campagne_Nombre_joueur' , 'valeur_initiale' => $campagne['campagne_Nombre_joueur'] ]);

    /* campagne_Nombre_mj */
        if ( $mf_droits_defaut['api_modifier__campagne_Nombre_mj'] )
            $trans['{campagne_Nombre_mj}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_campagne' => $campagne['Code_campagne']) , 'DB_name' => 'campagne_Nombre_mj' , 'valeur_initiale' => $campagne['campagne_Nombre_mj'] ]);
        else
            $trans['{campagne_Nombre_mj}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_campagne' => $campagne['Code_campagne']) , 'DB_name' => 'campagne_Nombre_mj' , 'valeur_initiale' => $campagne['campagne_Nombre_mj'] ]);


/* debut developpement */
            include __DIR__ . '/_a_campagne_tag_campagne_list.php';
