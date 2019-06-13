<?php

    /* Actualisation des droits */
    Hook_carte::hook_actualiser_les_droits_ajouter(mf_Code_groupe());

    $table_carte = new carte();

    /* liste */
        $liste = $table_carte->mf_lister_contexte();
        $tab = new Tableau($liste, "");
        $tab->desactiver_pagination();
        $tab->ajouter_ref_Colonne_Code("Code_carte");
        $tab->set_ligne_selectionnee('Code_carte', mf_Code_carte());
        $tab->modifier_code_action("apercu_carte");
        $tab->ajouter_colonne('carte_Nom', false, '');
        $tab->ajouter_colonne('carte_Hauteur', false, '');
        $tab->ajouter_colonne('carte_Largeur', false, '');
        $tab->ajouter_colonne_fichier('carte_Fichier', '');
        if (!isset($est_charge['groupe']))
        {
            $tab->ajouter_colonne('Code_groupe', true, '');
        }
        $trans['{tableau_carte}']=$tab->generer_code();

    /* boutons */
        if ($mf_droits_defaut['carte__AJOUTER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_AJOUTER_PREC . get_nom_colonne('bouton_ajouter_carte') . BOUTON_LIBELLE_AJOUTER_SUIV, get_nom_page_courante().'?act=ajouter_carte&Code_groupe='.$Code_groupe.'', 'lien', 'bouton_ajouter_carte');
        }
        $trans['{bouton_ajouter_carte}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_ajouter_carte', BOUTON_CLASSE_AJOUTER) : '';
        if ($mf_droits_defaut['carte__CREER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_AJOUTER_PREC . get_nom_colonne('bouton_creer_carte') . BOUTON_LIBELLE_AJOUTER_SUIV, get_nom_page_courante().'?act=creer_carte&Code_groupe='.$Code_groupe.'', 'lien', 'bouton_creer_carte');
        }
        $trans['{bouton_creer_carte}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_creer_carte', BOUTON_CLASSE_AJOUTER) : '';
