<?php

    /* Actualisation des droits */
    Hook_personnage::hook_actualiser_les_droits_ajouter(mf_Code_joueur(), mf_Code_groupe());

    $table_personnage = new personnage();

    /* liste */
        $liste = $table_personnage->mf_lister_contexte();
        $tab = new Tableau($liste, "");
        $tab->desactiver_pagination();
        $tab->ajouter_ref_Colonne_Code("Code_personnage");
        $tab->set_ligne_selectionnee('Code_personnage', mf_Code_personnage());
        $tab->modifier_code_action("apercu_personnage");
        $tab->ajouter_colonne_fichier('personnage_Fichier_Fichier', '');
        $tab->ajouter_colonne('personnage_Conservation', true, '');
        if (!isset($est_charge['joueur']))
        {
            $tab->ajouter_colonne('Code_joueur', true, '');
        }
        if (!isset($est_charge['groupe']))
        {
            $tab->ajouter_colonne('Code_groupe', true, '');
        }
        $trans['{tableau_personnage}']=$tab->generer_code();

    /* boutons */
        if ($mf_droits_defaut['personnage__AJOUTER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_AJOUTER_PREC . get_nom_colonne('bouton_ajouter_personnage') . BOUTON_LIBELLE_AJOUTER_SUIV, get_nom_page_courante().'?act=ajouter_personnage&Code_joueur='.$Code_joueur.'&Code_groupe='.$Code_groupe.'', 'lien', 'bouton_ajouter_personnage');
        }
        $trans['{bouton_ajouter_personnage}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_ajouter_personnage', BOUTON_CLASSE_AJOUTER) : '';
        if ($mf_droits_defaut['personnage__CREER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_AJOUTER_PREC . get_nom_colonne('bouton_creer_personnage') . BOUTON_LIBELLE_AJOUTER_SUIV, get_nom_page_courante().'?act=creer_personnage&Code_joueur='.$Code_joueur.'&Code_groupe='.$Code_groupe.'', 'lien', 'bouton_creer_personnage');
        }
        $trans['{bouton_creer_personnage}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_creer_personnage', BOUTON_CLASSE_AJOUTER) : '';
