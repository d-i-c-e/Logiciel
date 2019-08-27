<?php

    /* Actualisation des droits */
    Hook_objet::hook_actualiser_les_droits_ajouter(mf_Code_type());

    $table_objet = new objet();

    /* liste */
        $liste = $table_objet->mf_lister_contexte();
        $tab = new Tableau($liste, "");
        $tab->desactiver_pagination();
        $tab->ajouter_ref_Colonne_Code("Code_objet");
        $tab->set_ligne_selectionnee('Code_objet', mf_Code_objet());
        $tab->modifier_code_action("apercu_objet");
        $tab->ajouter_colonne('objet_Libelle', false, '');
        /* debut developpement */
//         $tab->ajouter_colonne_fichier('objet_Image_Fichier', '');
        /* fin developpement */
        if (!isset($est_charge['type']))
        {
            $tab->ajouter_colonne('Code_type', true, '');
        }
        $trans['{tableau_objet}']=$tab->generer_code();

    /* boutons */
        if ($mf_droits_defaut['objet__AJOUTER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_AJOUTER_PREC . get_nom_colonne('bouton_ajouter_objet') . BOUTON_LIBELLE_AJOUTER_SUIV, get_nom_page_courante().'?act=ajouter_objet&Code_type='.$Code_type.'', 'lien', 'bouton_ajouter_objet');
        }
        $trans['{bouton_ajouter_objet}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_ajouter_objet', BOUTON_CLASSE_AJOUTER) : '';
        if ($mf_droits_defaut['objet__CREER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_AJOUTER_PREC . get_nom_colonne('bouton_creer_objet') . BOUTON_LIBELLE_AJOUTER_SUIV, get_nom_page_courante().'?act=creer_objet&Code_type='.$Code_type.'', 'lien', 'bouton_creer_objet');
        }
        $trans['{bouton_creer_objet}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_creer_objet', BOUTON_CLASSE_AJOUTER) : '';
