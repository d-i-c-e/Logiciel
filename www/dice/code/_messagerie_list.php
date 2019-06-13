<?php

    /* Actualisation des droits */
    Hook_messagerie::hook_actualiser_les_droits_ajouter(mf_Code_joueur());

    $table_messagerie = new messagerie();

    /* liste */
        $liste = $table_messagerie->mf_lister_contexte();
        $tab = new Tableau($liste, "");
        $tab->desactiver_pagination();
        $tab->ajouter_ref_Colonne_Code("Code_messagerie");
        $tab->set_ligne_selectionnee('Code_messagerie', mf_Code_messagerie());
        $tab->modifier_code_action("apercu_messagerie");
        if (!isset($est_charge['joueur']))
        {
            $tab->ajouter_colonne('Code_joueur', true, '');
        }
        $trans['{tableau_messagerie}']=$tab->generer_code();

    /* boutons */
        if ($mf_droits_defaut['messagerie__AJOUTER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_AJOUTER_PREC . get_nom_colonne('bouton_ajouter_messagerie') . BOUTON_LIBELLE_AJOUTER_SUIV, get_nom_page_courante().'?act=ajouter_messagerie&Code_joueur='.$Code_joueur.'', 'lien', 'bouton_ajouter_messagerie');
        }
        $trans['{bouton_ajouter_messagerie}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_ajouter_messagerie', BOUTON_CLASSE_AJOUTER) : '';
        if ($mf_droits_defaut['messagerie__CREER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_AJOUTER_PREC . get_nom_colonne('bouton_creer_messagerie') . BOUTON_LIBELLE_AJOUTER_SUIV, get_nom_page_courante().'?act=creer_messagerie&Code_joueur='.$Code_joueur.'', 'lien', 'bouton_creer_messagerie');
        }
        $trans['{bouton_creer_messagerie}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_creer_messagerie', BOUTON_CLASSE_AJOUTER) : '';
