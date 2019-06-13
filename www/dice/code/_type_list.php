<?php

    /* Actualisation des droits */
    Hook_type::hook_actualiser_les_droits_ajouter(mf_Code_ressource());

    $table_type = new type();

    /* liste */
        $liste = $table_type->mf_lister_contexte();
        $tab = new Tableau($liste, "");
        $tab->desactiver_pagination();
        $tab->ajouter_ref_Colonne_Code("Code_type");
        $tab->set_ligne_selectionnee('Code_type', mf_Code_type());
        $tab->modifier_code_action("apercu_type");
        $tab->ajouter_colonne('type_Libelle', false, '');
        if (!isset($est_charge['ressource']))
        {
            $tab->ajouter_colonne('Code_ressource', true, '');
        }
        $trans['{tableau_type}']=$tab->generer_code();

    /* boutons */
        if ($mf_droits_defaut['type__AJOUTER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_AJOUTER_PREC . get_nom_colonne('bouton_ajouter_type') . BOUTON_LIBELLE_AJOUTER_SUIV, get_nom_page_courante().'?act=ajouter_type&Code_ressource='.$Code_ressource.'', 'lien', 'bouton_ajouter_type');
        }
        $trans['{bouton_ajouter_type}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_ajouter_type', BOUTON_CLASSE_AJOUTER) : '';
        if ($mf_droits_defaut['type__CREER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_AJOUTER_PREC . get_nom_colonne('bouton_creer_type') . BOUTON_LIBELLE_AJOUTER_SUIV, get_nom_page_courante().'?act=creer_type&Code_ressource='.$Code_ressource.'', 'lien', 'bouton_creer_type');
        }
        $trans['{bouton_creer_type}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_creer_type', BOUTON_CLASSE_AJOUTER) : '';
