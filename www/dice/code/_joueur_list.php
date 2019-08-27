<?php

    /* Actualisation des droits */
    Hook_joueur::hook_actualiser_les_droits_ajouter();

    $table_joueur = new joueur();

    /* liste */
        $liste = $table_joueur->mf_lister_contexte();
        $tab = new Tableau($liste, "");
        $tab->desactiver_pagination();
        $tab->ajouter_ref_Colonne_Code("Code_joueur");
        $tab->set_ligne_selectionnee('Code_joueur', mf_Code_joueur());
        $tab->modifier_code_action("apercu_joueur");
        $tab->ajouter_colonne('joueur_Email', false, '');
        $tab->ajouter_colonne('joueur_Identifiant', false, '');
        /* debut developpement */
//         $tab->ajouter_colonne_fichier('joueur_Avatar_Fichier', '');
        /* fin developpement */
        $tab->ajouter_colonne('joueur_Date_naissance', false, 'date');
        $tab->ajouter_colonne('joueur_Date_inscription', false, 'date_heure');
        $tab->ajouter_colonne('joueur_Administrateur', true, '');
        $trans['{tableau_joueur}']=$tab->generer_code();

    /* boutons */
        if ($mf_droits_defaut['joueur__AJOUTER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_AJOUTER_PREC . get_nom_colonne('bouton_ajouter_joueur') . BOUTON_LIBELLE_AJOUTER_SUIV, get_nom_page_courante().'?act=ajouter_joueur', 'lien', 'bouton_ajouter_joueur');
        }
        $trans['{bouton_ajouter_joueur}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_ajouter_joueur', BOUTON_CLASSE_AJOUTER) : '';
