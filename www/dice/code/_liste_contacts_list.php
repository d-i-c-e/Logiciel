<?php

    /* Actualisation des droits */
    Hook_liste_contacts::hook_actualiser_les_droits_ajouter(mf_Code_joueur());

    $table_liste_contacts = new liste_contacts();

    /* liste */
        $liste = $table_liste_contacts->mf_lister_contexte();
        $tab = new Tableau($liste, "");
        $tab->desactiver_pagination();
        $tab->ajouter_ref_Colonne_Code("Code_liste_contacts");
        $tab->set_ligne_selectionnee('Code_liste_contacts', mf_Code_liste_contacts());
        $tab->modifier_code_action("apercu_liste_contacts");
        $tab->ajouter_colonne('liste_contacts_Nom', false, '');
        if (!isset($est_charge['joueur']))
        {
            $tab->ajouter_colonne('Code_joueur', true, '');
        }
        $trans['{tableau_liste_contacts}']=$tab->generer_code();

    /* boutons */
        if ($mf_droits_defaut['liste_contacts__AJOUTER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_AJOUTER_PREC . get_nom_colonne('bouton_ajouter_liste_contacts') . BOUTON_LIBELLE_AJOUTER_SUIV, get_nom_page_courante().'?act=ajouter_liste_contacts&Code_joueur='.$Code_joueur.'', 'lien', 'bouton_ajouter_liste_contacts');
        }
        $trans['{bouton_ajouter_liste_contacts}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_ajouter_liste_contacts', BOUTON_CLASSE_AJOUTER) : '';
        if ($mf_droits_defaut['liste_contacts__CREER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_AJOUTER_PREC . get_nom_colonne('bouton_creer_liste_contacts') . BOUTON_LIBELLE_AJOUTER_SUIV, get_nom_page_courante().'?act=creer_liste_contacts&Code_joueur='.$Code_joueur.'', 'lien', 'bouton_creer_liste_contacts');
        }
        $trans['{bouton_creer_liste_contacts}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_creer_liste_contacts', BOUTON_CLASSE_AJOUTER) : '';
