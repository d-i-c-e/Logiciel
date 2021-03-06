<?php

    /* Actualisation des droits */
    Hook_a_invitation_joueur_groupe::hook_actualiser_les_droits_ajouter(mf_Code_joueur(), mf_Code_groupe());
    Hook_a_invitation_joueur_groupe::hook_actualiser_les_droits_modifier(mf_Code_joueur(), mf_Code_groupe());
    Hook_a_invitation_joueur_groupe::hook_actualiser_les_droits_supprimer(mf_Code_joueur(), mf_Code_groupe());

    $table_a_invitation_joueur_groupe = new a_invitation_joueur_groupe();

    /* liste */
        $liste = $table_a_invitation_joueur_groupe->mf_lister_contexte();
        $tab = new Tableau($liste, '');
        $tab->desactiver_pagination();
        if (!isset($est_charge['joueur']))
        {
            $tab->ajouter_colonne('Code_joueur', true, '');
        }
        $tab->ajouter_ref_Colonne_Code('Code_joueur');
        if (!isset($est_charge['groupe']))
        {
            $tab->ajouter_colonne('Code_groupe', true, '');
        }
        $tab->ajouter_ref_Colonne_Code('Code_groupe');
        $tab->modifier_code_action('apercu_a_invitation_joueur_groupe');
        // $tab->ajouter_colonne('a_invitation_joueur_groupe_Message', false, '');
        $tab->ajouter_colonne('a_invitation_joueur_groupe_Date_envoi', false, 'date_heure');
        if ($mf_droits_defaut['a_invitation_joueur_groupe__SUPPRIMER'])
        {
            $tab->ajouter_colonne_bouton('supprimer_a_invitation_joueur_groupe', BOUTON_LIBELLE_SUPPRIMER_PREC . get_nom_colonne('bouton_supprimer_a_invitation_joueur_groupe') . BOUTON_LIBELLE_SUPPRIMER_SUIV );
        }
        $trans['{tableau_a_invitation_joueur_groupe}']=$tab->generer_code();

    /* boutons */
        if ($mf_droits_defaut['a_invitation_joueur_groupe__AJOUTER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_AJOUTER_PREC . get_nom_colonne('bouton_ajouter_a_invitation_joueur_groupe') . BOUTON_LIBELLE_AJOUTER_SUIV , get_nom_page_courante().'?act=ajouter_a_invitation_joueur_groupe&Code_joueur='.$Code_joueur.'&Code_groupe='.$Code_groupe.'', 'lien', 'bouton_ajouter_a_invitation_joueur_groupe');
        }
        $trans['{bouton_ajouter_a_invitation_joueur_groupe}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_ajouter_a_invitation_joueur_groupe', BOUTON_CLASSE_AJOUTER) : '';
