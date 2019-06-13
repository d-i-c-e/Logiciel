<?php

    /* Actualisation des droits */
    Hook_a_campagne_tag_campagne::hook_actualiser_les_droits_ajouter(mf_Code_tag_campagne(), mf_Code_campagne());
    Hook_a_campagne_tag_campagne::hook_actualiser_les_droits_supprimer(mf_Code_tag_campagne(), mf_Code_campagne());

    $table_a_campagne_tag_campagne = new a_campagne_tag_campagne();

    /* liste */
        $liste = $table_a_campagne_tag_campagne->mf_lister_contexte();
        $tab = new Tableau($liste, '');
        $tab->desactiver_pagination();
        if (!isset($est_charge['tag_campagne']))
        {
            $tab->ajouter_colonne('Code_tag_campagne', true, '');
        }
        $tab->ajouter_ref_Colonne_Code('Code_tag_campagne');
        if (!isset($est_charge['campagne']))
        {
            $tab->ajouter_colonne('Code_campagne', true, '');
        }
        $tab->ajouter_ref_Colonne_Code('Code_campagne');
        // $tab->modifier_code_action('apercu_a_campagne_tag_campagne');
        if ($mf_droits_defaut['a_campagne_tag_campagne__SUPPRIMER'])
        {
            $tab->ajouter_colonne_bouton('supprimer_a_campagne_tag_campagne', BOUTON_LIBELLE_SUPPRIMER_PREC . get_nom_colonne('bouton_supprimer_a_campagne_tag_campagne') . BOUTON_LIBELLE_SUPPRIMER_SUIV );
        }
        $trans['{tableau_a_campagne_tag_campagne}']=$tab->generer_code();

    /* boutons */
        if ($mf_droits_defaut['a_campagne_tag_campagne__AJOUTER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_AJOUTER_PREC . get_nom_colonne('bouton_ajouter_a_campagne_tag_campagne') . BOUTON_LIBELLE_AJOUTER_SUIV , get_nom_page_courante().'?act=ajouter_a_campagne_tag_campagne&Code_tag_campagne='.$Code_tag_campagne.'&Code_campagne='.$Code_campagne.'', 'lien', 'bouton_ajouter_a_campagne_tag_campagne');
        }
        $trans['{bouton_ajouter_a_campagne_tag_campagne}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_ajouter_a_campagne_tag_campagne', BOUTON_CLASSE_AJOUTER) : '';
