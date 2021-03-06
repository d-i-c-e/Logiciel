<?php

    /* Actualisation des droits */
    Hook_a_joueur_parametre::hook_actualiser_les_droits_ajouter(mf_Code_joueur(), mf_Code_parametre());
    Hook_a_joueur_parametre::hook_actualiser_les_droits_modifier(mf_Code_joueur(), mf_Code_parametre());
    Hook_a_joueur_parametre::hook_actualiser_les_droits_supprimer(mf_Code_joueur(), mf_Code_parametre());

    $table_a_joueur_parametre = new a_joueur_parametre();

    /* liste */
        $liste = $table_a_joueur_parametre->mf_lister_contexte();
        $tab = new Tableau($liste, '');
        $tab->desactiver_pagination();
        if (!isset($est_charge['joueur']))
        {
            $tab->ajouter_colonne('Code_joueur', true, '');
        }
        $tab->ajouter_ref_Colonne_Code('Code_joueur');
        if (!isset($est_charge['parametre']))
        {
            $tab->ajouter_colonne('Code_parametre', true, '');
        }
        $tab->ajouter_ref_Colonne_Code('Code_parametre');
        $tab->modifier_code_action('apercu_a_joueur_parametre');
        $tab->ajouter_colonne('a_joueur_parametre_Valeur_choisie', false, '');
        $tab->ajouter_colonne('a_joueur_parametre_Actif', true, '');
        if ($mf_droits_defaut['a_joueur_parametre__SUPPRIMER'])
        {
            $tab->ajouter_colonne_bouton('supprimer_a_joueur_parametre', BOUTON_LIBELLE_SUPPRIMER_PREC . get_nom_colonne('bouton_supprimer_a_joueur_parametre') . BOUTON_LIBELLE_SUPPRIMER_SUIV );
        }
        $trans['{tableau_a_joueur_parametre}']=$tab->generer_code();

    /* boutons */
        if ($mf_droits_defaut['a_joueur_parametre__AJOUTER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_AJOUTER_PREC . get_nom_colonne('bouton_ajouter_a_joueur_parametre') . BOUTON_LIBELLE_AJOUTER_SUIV , get_nom_page_courante().'?act=ajouter_a_joueur_parametre&Code_joueur='.$Code_joueur.'&Code_parametre='.$Code_parametre.'', 'lien', 'bouton_ajouter_a_joueur_parametre');
        }
        $trans['{bouton_ajouter_a_joueur_parametre}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_ajouter_a_joueur_parametre', BOUTON_CLASSE_AJOUTER) : '';
