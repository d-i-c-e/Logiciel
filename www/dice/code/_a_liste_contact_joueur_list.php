<?php

    /* Actualisation des droits */
    Hook_a_liste_contact_joueur::hook_actualiser_les_droits_ajouter(mf_Code_liste_contacts(), mf_Code_joueur());
    Hook_a_liste_contact_joueur::hook_actualiser_les_droits_modifier(mf_Code_liste_contacts(), mf_Code_joueur());
    Hook_a_liste_contact_joueur::hook_actualiser_les_droits_supprimer(mf_Code_liste_contacts(), mf_Code_joueur());

    $table_a_liste_contact_joueur = new a_liste_contact_joueur();

    /* liste */
        $liste = $table_a_liste_contact_joueur->mf_lister_contexte();
        $tab = new Tableau($liste, '');
        $tab->desactiver_pagination();
        if (!isset($est_charge['liste_contacts']))
        {
            $tab->ajouter_colonne('Code_liste_contacts', true, '');
        }
        $tab->ajouter_ref_Colonne_Code('Code_liste_contacts');
        if (!isset($est_charge['joueur']))
        {
            $tab->ajouter_colonne('Code_joueur', true, '');
        }
        $tab->ajouter_ref_Colonne_Code('Code_joueur');
        $tab->modifier_code_action('apercu_a_liste_contact_joueur');
        $tab->ajouter_colonne('a_liste_contact_joueur_Date_creation', false, 'date_heure');
        if ($mf_droits_defaut['a_liste_contact_joueur__SUPPRIMER'])
        {
            $tab->ajouter_colonne_bouton('supprimer_a_liste_contact_joueur', BOUTON_LIBELLE_SUPPRIMER_PREC . get_nom_colonne('bouton_supprimer_a_liste_contact_joueur') . BOUTON_LIBELLE_SUPPRIMER_SUIV );
        }
        $trans['{tableau_a_liste_contact_joueur}']=$tab->generer_code();

    /* boutons */
        if ($mf_droits_defaut['a_liste_contact_joueur__AJOUTER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_AJOUTER_PREC . get_nom_colonne('bouton_ajouter_a_liste_contact_joueur') . BOUTON_LIBELLE_AJOUTER_SUIV , get_nom_page_courante().'?act=ajouter_a_liste_contact_joueur&Code_liste_contacts='.$Code_liste_contacts.'&Code_joueur='.$Code_joueur.'', 'lien', 'bouton_ajouter_a_liste_contact_joueur');
        }
        $trans['{bouton_ajouter_a_liste_contact_joueur}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_ajouter_a_liste_contact_joueur', BOUTON_CLASSE_AJOUTER) : '';
