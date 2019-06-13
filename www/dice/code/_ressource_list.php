<?php

    /* Actualisation des droits */
    Hook_ressource::hook_actualiser_les_droits_ajouter();

    $table_ressource = new ressource();

    /* liste */
        $liste = $table_ressource->mf_lister_contexte();
        $tab = new Tableau($liste, "");
        $tab->desactiver_pagination();
        $tab->ajouter_ref_Colonne_Code("Code_ressource");
        $tab->set_ligne_selectionnee('Code_ressource', mf_Code_ressource());
        $tab->modifier_code_action("apercu_ressource");
        $tab->ajouter_colonne('ressource_Nom', false, '');
        $trans['{tableau_ressource}']=$tab->generer_code();

    /* boutons */
        if ($mf_droits_defaut['ressource__AJOUTER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_AJOUTER_PREC . get_nom_colonne('bouton_ajouter_ressource') . BOUTON_LIBELLE_AJOUTER_SUIV, get_nom_page_courante().'?act=ajouter_ressource', 'lien', 'bouton_ajouter_ressource');
        }
        $trans['{bouton_ajouter_ressource}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_ajouter_ressource', BOUTON_CLASSE_AJOUTER) : '';
        if ($mf_droits_defaut['ressource__CREER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_AJOUTER_PREC . get_nom_colonne('bouton_creer_ressource') . BOUTON_LIBELLE_AJOUTER_SUIV, get_nom_page_courante().'?act=creer_ressource', 'lien', 'bouton_creer_ressource');
        }
        $trans['{bouton_creer_ressource}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_creer_ressource', BOUTON_CLASSE_AJOUTER) : '';
