<?php

    /* Actualisation des droits */
    Hook_a_liste_contact_joueur::hook_actualiser_les_droits_modifier($a_liste_contact_joueur['Code_liste_contacts'], $a_liste_contact_joueur['Code_joueur']);
    Hook_a_liste_contact_joueur::hook_actualiser_les_droits_supprimer($a_liste_contact_joueur['Code_liste_contacts'], $a_liste_contact_joueur['Code_joueur']);

    /* boutons */
        if ($mf_droits_defaut['a_liste_contact_joueur__MODIFIER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_a_liste_contact_joueur') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_a_liste_contact_joueur&Code_liste_contacts='.$Code_liste_contacts.'&Code_joueur='.$Code_joueur.'', 'lien', 'bouton_modifier_a_liste_contact_joueur');
        }
        $trans['{bouton_modifier_a_liste_contact_joueur}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_a_liste_contact_joueur') : '';
        if ($mf_droits_defaut['a_liste_contact_joueur__SUPPRIMER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_SUPPRIMER_PREC . get_nom_colonne('bouton_supprimer_a_liste_contact_joueur') . BOUTON_LIBELLE_SUPPRIMER_SUIV, get_nom_page_courante().'?act=supprimer_a_liste_contact_joueur&Code_liste_contacts='.$Code_liste_contacts.'&Code_joueur='.$Code_joueur.'', 'lien', 'bouton_supprimer_a_liste_contact_joueur');
        }
        $trans['{bouton_supprimer_a_liste_contact_joueur}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_supprimer_a_liste_contact_joueur', BOUTON_CLASSE_SUPPRIMER) : '';

        // a_liste_contact_joueur_Date_creation
        if ( $mf_droits_defaut['api_modifier__a_liste_contact_joueur_Date_creation'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_a_liste_contact_joueur_Date_creation') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_a_liste_contact_joueur_Date_creation&Code_liste_contacts='.$Code_liste_contacts.'&Code_joueur='.$Code_joueur.'', 'lien', 'bouton_modifier_a_liste_contact_joueur_Date_creation');
        }
        $trans['{bouton_modifier_a_liste_contact_joueur_Date_creation}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_a_liste_contact_joueur_Date_creation') : '';

    /* prec_et_suiv */
    if ( $table_a_liste_contact_joueur->mf_compter((isset($est_charge['liste_contacts']) ? $mf_contexte['Code_liste_contacts'] : 0), (isset($est_charge['joueur']) ? $mf_contexte['Code_joueur'] : 0))<100 )
    {
        $liste_a_liste_contact_joueur = $table_a_liste_contact_joueur->mf_lister_contexte();
        // prec
        $prec_et_suiv = prec_suiv($liste_a_liste_contact_joueur, $a_liste_contact_joueur['Code_liste_contacts'].'-'.$a_liste_contact_joueur['Code_joueur']);
        $prec=['link'=>'', 'title'=>''];
        $suiv=['link'=>'', 'title'=>''];
        if (isset($prec_et_suiv['prec']['Code_liste_contacts']))
        {
            $prec['link'] = get_nom_page_courante().'?act=apercu_a_liste_contact_joueur&Code_liste_contacts='.$prec_et_suiv['prec']['Code_liste_contacts'].'&Code_joueur='.$prec_et_suiv['prec']['Code_joueur'].'';
            $prec['title'] = htmlspecialchars(get_titre_ligne_table('a_liste_contact_joueur', $prec_et_suiv['prec']));
        }
        // suiv
        if (isset($prec_et_suiv['suiv']['Code_liste_contacts']))
        {
            $suiv['link'] = get_nom_page_courante().'?act=apercu_a_liste_contact_joueur&Code_liste_contacts='.$prec_et_suiv['suiv']['Code_liste_contacts'].'&Code_joueur='.$prec_et_suiv['suiv']['Code_joueur'].'';
            $suiv['title'] = htmlspecialchars(get_titre_ligne_table('a_liste_contact_joueur', $prec_et_suiv['suiv']));
        }
        $trans['{pager_a_liste_contact_joueur}'] = get_code_pager($prec, $suiv);
    }
    else
    {
        $trans['{pager_a_liste_contact_joueur}'] = '';
    }

    /* Code_liste_contacts */
        $trans['{Code_liste_contacts}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_liste_contacts'=>$a_liste_contact_joueur['Code_liste_contacts'], 'Code_joueur'=>$a_liste_contact_joueur['Code_joueur']) , 'DB_name' => 'Code_liste_contacts' , 'valeur_initiale' => $a_liste_contact_joueur['Code_liste_contacts'] ]);

    /* Code_joueur */
        $trans['{Code_joueur}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_liste_contacts'=>$a_liste_contact_joueur['Code_liste_contacts'], 'Code_joueur'=>$a_liste_contact_joueur['Code_joueur']) , 'DB_name' => 'Code_joueur' , 'valeur_initiale' => $a_liste_contact_joueur['Code_joueur'] ]);

    /* a_liste_contact_joueur_Date_creation */
        if ( $mf_droits_defaut['api_modifier__a_liste_contact_joueur_Date_creation'] )
            $trans['{a_liste_contact_joueur_Date_creation}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_liste_contacts'=>$a_liste_contact_joueur['Code_liste_contacts'], 'Code_joueur'=>$a_liste_contact_joueur['Code_joueur']) , 'DB_name' => 'a_liste_contact_joueur_Date_creation' , 'valeur_initiale' => $a_liste_contact_joueur['a_liste_contact_joueur_Date_creation'] ]);
        else
            $trans['{a_liste_contact_joueur_Date_creation}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_liste_contacts'=>$a_liste_contact_joueur['Code_liste_contacts'], 'Code_joueur'=>$a_liste_contact_joueur['Code_joueur']) , 'DB_name' => 'a_liste_contact_joueur_Date_creation' , 'valeur_initiale' => $a_liste_contact_joueur['a_liste_contact_joueur_Date_creation'] ]);

