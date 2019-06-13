<?php

    /* Actualisation des droits */
    Hook_a_ressource_tag_ressource::hook_actualiser_les_droits_ajouter(mf_Code_tag_ressource(), mf_Code_ressource());
    Hook_a_ressource_tag_ressource::hook_actualiser_les_droits_supprimer(mf_Code_tag_ressource(), mf_Code_ressource());

    $table_a_ressource_tag_ressource = new a_ressource_tag_ressource();

    /* liste */
        $liste = $table_a_ressource_tag_ressource->mf_lister_contexte();
        $tab = new Tableau($liste, '');
        $tab->desactiver_pagination();
        if (!isset($est_charge['tag_ressource']))
        {
            $tab->ajouter_colonne('Code_tag_ressource', true, '');
        }
        $tab->ajouter_ref_Colonne_Code('Code_tag_ressource');
        if (!isset($est_charge['ressource']))
        {
            $tab->ajouter_colonne('Code_ressource', true, '');
        }
        $tab->ajouter_ref_Colonne_Code('Code_ressource');
        // $tab->modifier_code_action('apercu_a_ressource_tag_ressource');
        if ($mf_droits_defaut['a_ressource_tag_ressource__SUPPRIMER'])
        {
            $tab->ajouter_colonne_bouton('supprimer_a_ressource_tag_ressource', BOUTON_LIBELLE_SUPPRIMER_PREC . get_nom_colonne('bouton_supprimer_a_ressource_tag_ressource') . BOUTON_LIBELLE_SUPPRIMER_SUIV );
        }
        $trans['{tableau_a_ressource_tag_ressource}']=$tab->generer_code();

    /* boutons */
        if ($mf_droits_defaut['a_ressource_tag_ressource__AJOUTER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_AJOUTER_PREC . get_nom_colonne('bouton_ajouter_a_ressource_tag_ressource') . BOUTON_LIBELLE_AJOUTER_SUIV , get_nom_page_courante().'?act=ajouter_a_ressource_tag_ressource&Code_tag_ressource='.$Code_tag_ressource.'&Code_ressource='.$Code_ressource.'', 'lien', 'bouton_ajouter_a_ressource_tag_ressource');
        }
        $trans['{bouton_ajouter_a_ressource_tag_ressource}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_ajouter_a_ressource_tag_ressource', BOUTON_CLASSE_AJOUTER) : '';
