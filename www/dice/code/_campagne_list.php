<?php

    /* Actualisation des droits */
    Hook_campagne::hook_actualiser_les_droits_ajouter();

    $table_campagne = new campagne();

    /* liste */
        $liste = $table_campagne->mf_lister_contexte();
        $tab = new Tableau($liste, "");
        $tab->desactiver_pagination();
        $tab->ajouter_ref_Colonne_Code("Code_campagne");
        $tab->set_ligne_selectionnee('Code_campagne', mf_Code_campagne());
        $tab->modifier_code_action("apercu_campagne");
        $tab->ajouter_colonne('campagne_Nom', false, '');
        // $tab->ajouter_colonne('campagne_Description', false, '');
        $tab->ajouter_colonne_fichier('campagne_Image_Fichier', '');
        $tab->ajouter_colonne('campagne_Nombre_joueur', false, '');
        $tab->ajouter_colonne('campagne_Nombre_mj', false, '');
        $trans['{tableau_campagne}']=$tab->generer_code();

    /* boutons */
        if ($mf_droits_defaut['campagne__AJOUTER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_AJOUTER_PREC . get_nom_colonne('bouton_ajouter_campagne') . BOUTON_LIBELLE_AJOUTER_SUIV, get_nom_page_courante().'?act=ajouter_campagne', 'lien', 'bouton_ajouter_campagne');
        }
        $trans['{bouton_ajouter_campagne}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_ajouter_campagne', BOUTON_CLASSE_AJOUTER) : '';
        if ($mf_droits_defaut['campagne__CREER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_AJOUTER_PREC . get_nom_colonne('bouton_creer_campagne') . BOUTON_LIBELLE_AJOUTER_SUIV, get_nom_page_courante().'?act=creer_campagne', 'lien', 'bouton_creer_campagne');
        }
        $trans['{bouton_creer_campagne}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_creer_campagne', BOUTON_CLASSE_AJOUTER) : '';
