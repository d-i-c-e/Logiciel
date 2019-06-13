<?php

    /* Actualisation des droits */
    Hook_message::hook_actualiser_les_droits_ajouter(mf_Code_messagerie(), mf_Code_joueur());

    $table_message = new message();

    /* liste */
        $liste = $table_message->mf_lister_contexte();
        $tab = new Tableau($liste, "");
        $tab->desactiver_pagination();
        $tab->ajouter_ref_Colonne_Code("Code_message");
        $tab->set_ligne_selectionnee('Code_message', mf_Code_message());
        $tab->modifier_code_action("apercu_message");
        // $tab->ajouter_colonne('message_Texte', false, '');
        $tab->ajouter_colonne('message_Date', false, 'date_heure');
        if (!isset($est_charge['messagerie']))
        {
            $tab->ajouter_colonne('Code_messagerie', true, '');
        }
        if (!isset($est_charge['joueur']))
        {
            $tab->ajouter_colonne('Code_joueur', true, '');
        }
        $trans['{tableau_message}']=$tab->generer_code();

    /* boutons */
        if ($mf_droits_defaut['message__AJOUTER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_AJOUTER_PREC . get_nom_colonne('bouton_ajouter_message') . BOUTON_LIBELLE_AJOUTER_SUIV, get_nom_page_courante().'?act=ajouter_message&Code_messagerie='.$Code_messagerie.'&Code_joueur='.$Code_joueur.'', 'lien', 'bouton_ajouter_message');
        }
        $trans['{bouton_ajouter_message}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_ajouter_message', BOUTON_CLASSE_AJOUTER) : '';
        if ($mf_droits_defaut['message__CREER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_AJOUTER_PREC . get_nom_colonne('bouton_creer_message') . BOUTON_LIBELLE_AJOUTER_SUIV, get_nom_page_courante().'?act=creer_message&Code_messagerie='.$Code_messagerie.'&Code_joueur='.$Code_joueur.'', 'lien', 'bouton_creer_message');
        }
        $trans['{bouton_creer_message}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_creer_message', BOUTON_CLASSE_AJOUTER) : '';
