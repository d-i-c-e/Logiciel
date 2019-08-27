<?php

    /* Actualisation des droits */
    Hook_groupe::hook_actualiser_les_droits_ajouter(mf_Code_campagne());

    $table_groupe = new groupe();

    /* liste */
        $liste = $table_groupe->mf_lister_contexte();
        $tab = new Tableau($liste, "");
        $tab->desactiver_pagination();
        $tab->ajouter_ref_Colonne_Code("Code_groupe");
        $tab->set_ligne_selectionnee('Code_groupe', mf_Code_groupe());
        $tab->modifier_code_action("apercu_groupe");
        $tab->ajouter_colonne('groupe_Nom', false, '');
        /* debut developpement */
//         $tab->ajouter_colonne('groupe_Description', false, '');
//         $tab->ajouter_colonne_fichier('groupe_Logo_Fichier', '');
        /* fin developpement */
        $tab->ajouter_colonne('groupe_Effectif', false, '');
        $tab->ajouter_colonne('groupe_Actif', true, '');
        $tab->ajouter_colonne('groupe_Date_creation', false, 'date_heure');
        $tab->ajouter_colonne('groupe_Delai_suppression_jour', false, '');
        $tab->ajouter_colonne('groupe_Suppression_active', true, '');
        if (!isset($est_charge['campagne']))
        {
            $tab->ajouter_colonne('Code_campagne', true, '');
        }
        $trans['{tableau_groupe}']=$tab->generer_code();

    /* boutons */
        if ($mf_droits_defaut['groupe__AJOUTER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_AJOUTER_PREC . get_nom_colonne('bouton_ajouter_groupe') . BOUTON_LIBELLE_AJOUTER_SUIV, get_nom_page_courante().'?act=ajouter_groupe&Code_campagne='.$Code_campagne.'', 'lien', 'bouton_ajouter_groupe');
        }
        $trans['{bouton_ajouter_groupe}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_ajouter_groupe', BOUTON_CLASSE_AJOUTER) : '';
        if ($mf_droits_defaut['groupe__CREER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_AJOUTER_PREC . get_nom_colonne('bouton_creer_groupe') . BOUTON_LIBELLE_AJOUTER_SUIV, get_nom_page_courante().'?act=creer_groupe&Code_campagne='.$Code_campagne.'', 'lien', 'bouton_creer_groupe');
        }
        $trans['{bouton_creer_groupe}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_creer_groupe', BOUTON_CLASSE_AJOUTER) : '';
