<?php

    /* Actualisation des droits */
    Hook_tag_campagne::hook_actualiser_les_droits_ajouter();

    $table_tag_campagne = new tag_campagne();

    /* liste */
        $liste = $table_tag_campagne->mf_lister_contexte();
        $tab = new Tableau($liste, "");
        $tab->desactiver_pagination();
        $tab->ajouter_ref_Colonne_Code("Code_tag_campagne");
        $tab->set_ligne_selectionnee('Code_tag_campagne', mf_Code_tag_campagne());
        $tab->modifier_code_action("apercu_tag_campagne");
        $tab->ajouter_colonne('tag_campagne_Libelle', false, '');
        $trans['{tableau_tag_campagne}']=$tab->generer_code();

    /* boutons */
        if ($mf_droits_defaut['tag_campagne__AJOUTER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_AJOUTER_PREC . get_nom_colonne('bouton_ajouter_tag_campagne') . BOUTON_LIBELLE_AJOUTER_SUIV, get_nom_page_courante().'?act=ajouter_tag_campagne', 'lien', 'bouton_ajouter_tag_campagne');
        }
        $trans['{bouton_ajouter_tag_campagne}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_ajouter_tag_campagne', BOUTON_CLASSE_AJOUTER) : '';
        if ($mf_droits_defaut['tag_campagne__CREER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_AJOUTER_PREC . get_nom_colonne('bouton_creer_tag_campagne') . BOUTON_LIBELLE_AJOUTER_SUIV, get_nom_page_courante().'?act=creer_tag_campagne', 'lien', 'bouton_creer_tag_campagne');
        }
        $trans['{bouton_creer_tag_campagne}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_creer_tag_campagne', BOUTON_CLASSE_AJOUTER) : '';
