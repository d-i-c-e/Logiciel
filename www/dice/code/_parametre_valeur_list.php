<?php

    /* Actualisation des droits */
    Hook_parametre_valeur::hook_actualiser_les_droits_ajouter(mf_Code_parametre());

    $table_parametre_valeur = new parametre_valeur();

    /* liste */
        $liste = $table_parametre_valeur->mf_lister_contexte();
        $tab = new Tableau($liste, "");
        $tab->desactiver_pagination();
        $tab->ajouter_ref_Colonne_Code("Code_parametre_valeur");
        $tab->set_ligne_selectionnee('Code_parametre_valeur', mf_Code_parametre_valeur());
        $tab->modifier_code_action("apercu_parametre_valeur");
        $tab->ajouter_colonne('parametre_valeur_Libelle', false, '');
        if (!isset($est_charge['parametre']))
        {
            $tab->ajouter_colonne('Code_parametre', true, '');
        }
        $trans['{tableau_parametre_valeur}']=$tab->generer_code();

    /* boutons */
        if ($mf_droits_defaut['parametre_valeur__AJOUTER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_AJOUTER_PREC . get_nom_colonne('bouton_ajouter_parametre_valeur') . BOUTON_LIBELLE_AJOUTER_SUIV, get_nom_page_courante().'?act=ajouter_parametre_valeur&Code_parametre='.$Code_parametre.'', 'lien', 'bouton_ajouter_parametre_valeur');
        }
        $trans['{bouton_ajouter_parametre_valeur}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_ajouter_parametre_valeur', BOUTON_CLASSE_AJOUTER) : '';
        if ($mf_droits_defaut['parametre_valeur__CREER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_AJOUTER_PREC . get_nom_colonne('bouton_creer_parametre_valeur') . BOUTON_LIBELLE_AJOUTER_SUIV, get_nom_page_courante().'?act=creer_parametre_valeur&Code_parametre='.$Code_parametre.'', 'lien', 'bouton_creer_parametre_valeur');
        }
        $trans['{bouton_creer_parametre_valeur}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_creer_parametre_valeur', BOUTON_CLASSE_AJOUTER) : '';
