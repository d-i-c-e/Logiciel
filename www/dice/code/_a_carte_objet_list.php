<?php

    /* Actualisation des droits */
    Hook_a_carte_objet::hook_actualiser_les_droits_ajouter(mf_Code_carte(), mf_Code_objet());
    Hook_a_carte_objet::hook_actualiser_les_droits_supprimer(mf_Code_carte(), mf_Code_objet());

    $table_a_carte_objet = new a_carte_objet();

    /* liste */
        $liste = $table_a_carte_objet->mf_lister_contexte();
        $tab = new Tableau($liste, '');
        $tab->desactiver_pagination();
        if (!isset($est_charge['carte']))
        {
            $tab->ajouter_colonne('Code_carte', true, '');
        }
        $tab->ajouter_ref_Colonne_Code('Code_carte');
        if (!isset($est_charge['objet']))
        {
            $tab->ajouter_colonne('Code_objet', true, '');
        }
        $tab->ajouter_ref_Colonne_Code('Code_objet');
        // $tab->modifier_code_action('apercu_a_carte_objet');
        if ($mf_droits_defaut['a_carte_objet__SUPPRIMER'])
        {
            $tab->ajouter_colonne_bouton('supprimer_a_carte_objet', BOUTON_LIBELLE_SUPPRIMER_PREC . get_nom_colonne('bouton_supprimer_a_carte_objet') . BOUTON_LIBELLE_SUPPRIMER_SUIV );
        }
        $trans['{tableau_a_carte_objet}']=$tab->generer_code();

    /* boutons */
        if ($mf_droits_defaut['a_carte_objet__AJOUTER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_AJOUTER_PREC . get_nom_colonne('bouton_ajouter_a_carte_objet') . BOUTON_LIBELLE_AJOUTER_SUIV , get_nom_page_courante().'?act=ajouter_a_carte_objet&Code_carte='.$Code_carte.'&Code_objet='.$Code_objet.'', 'lien', 'bouton_ajouter_a_carte_objet');
        }
        $trans['{bouton_ajouter_a_carte_objet}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_ajouter_a_carte_objet', BOUTON_CLASSE_AJOUTER) : '';
