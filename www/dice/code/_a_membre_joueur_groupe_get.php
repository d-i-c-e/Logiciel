<?php

    /* Actualisation des droits */
    Hook_a_membre_joueur_groupe::hook_actualiser_les_droits_modifier($a_membre_joueur_groupe['Code_groupe'], $a_membre_joueur_groupe['Code_joueur']);
    Hook_a_membre_joueur_groupe::hook_actualiser_les_droits_supprimer($a_membre_joueur_groupe['Code_groupe'], $a_membre_joueur_groupe['Code_joueur']);

    /* boutons */
        if ($mf_droits_defaut['a_membre_joueur_groupe__MODIFIER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_a_membre_joueur_groupe') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_a_membre_joueur_groupe&Code_groupe='.$Code_groupe.'&Code_joueur='.$Code_joueur.'', 'lien', 'bouton_modifier_a_membre_joueur_groupe');
        }
        $trans['{bouton_modifier_a_membre_joueur_groupe}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_a_membre_joueur_groupe') : '';
        if ($mf_droits_defaut['a_membre_joueur_groupe__SUPPRIMER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_SUPPRIMER_PREC . get_nom_colonne('bouton_supprimer_a_membre_joueur_groupe') . BOUTON_LIBELLE_SUPPRIMER_SUIV, get_nom_page_courante().'?act=supprimer_a_membre_joueur_groupe&Code_groupe='.$Code_groupe.'&Code_joueur='.$Code_joueur.'', 'lien', 'bouton_supprimer_a_membre_joueur_groupe');
        }
        $trans['{bouton_supprimer_a_membre_joueur_groupe}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_supprimer_a_membre_joueur_groupe', BOUTON_CLASSE_SUPPRIMER) : '';

        // a_membre_joueur_groupe_Surnom
        if ( $mf_droits_defaut['api_modifier__a_membre_joueur_groupe_Surnom'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_a_membre_joueur_groupe_Surnom') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_a_membre_joueur_groupe_Surnom&Code_groupe='.$Code_groupe.'&Code_joueur='.$Code_joueur.'', 'lien', 'bouton_modifier_a_membre_joueur_groupe_Surnom');
        }
        $trans['{bouton_modifier_a_membre_joueur_groupe_Surnom}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_a_membre_joueur_groupe_Surnom') : '';

        // a_membre_joueur_groupe_Grade
        if ( $mf_droits_defaut['api_modifier__a_membre_joueur_groupe_Grade'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_a_membre_joueur_groupe_Grade') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_a_membre_joueur_groupe_Grade&Code_groupe='.$Code_groupe.'&Code_joueur='.$Code_joueur.'', 'lien', 'bouton_modifier_a_membre_joueur_groupe_Grade');
        }
        $trans['{bouton_modifier_a_membre_joueur_groupe_Grade}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_a_membre_joueur_groupe_Grade') : '';

        // a_membre_joueur_groupe_Date_adhesion
        if ( $mf_droits_defaut['api_modifier__a_membre_joueur_groupe_Date_adhesion'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_a_membre_joueur_groupe_Date_adhesion') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_a_membre_joueur_groupe_Date_adhesion&Code_groupe='.$Code_groupe.'&Code_joueur='.$Code_joueur.'', 'lien', 'bouton_modifier_a_membre_joueur_groupe_Date_adhesion');
        }
        $trans['{bouton_modifier_a_membre_joueur_groupe_Date_adhesion}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_a_membre_joueur_groupe_Date_adhesion') : '';

    /* prec_et_suiv */
    if ( $table_a_membre_joueur_groupe->mf_compter((isset($est_charge['groupe']) ? $mf_contexte['Code_groupe'] : 0), (isset($est_charge['joueur']) ? $mf_contexte['Code_joueur'] : 0))<100 )
    {
        $liste_a_membre_joueur_groupe = $table_a_membre_joueur_groupe->mf_lister_contexte();
        // prec
        $prec_et_suiv = prec_suiv($liste_a_membre_joueur_groupe, $a_membre_joueur_groupe['Code_groupe'].'-'.$a_membre_joueur_groupe['Code_joueur']);
        $prec=['link'=>'', 'title'=>''];
        $suiv=['link'=>'', 'title'=>''];
        if (isset($prec_et_suiv['prec']['Code_groupe']))
        {
            $prec['link'] = get_nom_page_courante().'?act=apercu_a_membre_joueur_groupe&Code_groupe='.$prec_et_suiv['prec']['Code_groupe'].'&Code_joueur='.$prec_et_suiv['prec']['Code_joueur'].'';
            $prec['title'] = htmlspecialchars(get_titre_ligne_table('a_membre_joueur_groupe', $prec_et_suiv['prec']));
        }
        // suiv
        if (isset($prec_et_suiv['suiv']['Code_groupe']))
        {
            $suiv['link'] = get_nom_page_courante().'?act=apercu_a_membre_joueur_groupe&Code_groupe='.$prec_et_suiv['suiv']['Code_groupe'].'&Code_joueur='.$prec_et_suiv['suiv']['Code_joueur'].'';
            $suiv['title'] = htmlspecialchars(get_titre_ligne_table('a_membre_joueur_groupe', $prec_et_suiv['suiv']));
        }
        $trans['{pager_a_membre_joueur_groupe}'] = get_code_pager($prec, $suiv);
    }
    else
    {
        $trans['{pager_a_membre_joueur_groupe}'] = '';
    }

    /* Code_groupe */
        $trans['{Code_groupe}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_groupe'=>$a_membre_joueur_groupe['Code_groupe'], 'Code_joueur'=>$a_membre_joueur_groupe['Code_joueur']) , 'DB_name' => 'Code_groupe' , 'valeur_initiale' => $a_membre_joueur_groupe['Code_groupe'] ]);

    /* Code_joueur */
        $trans['{Code_joueur}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_groupe'=>$a_membre_joueur_groupe['Code_groupe'], 'Code_joueur'=>$a_membre_joueur_groupe['Code_joueur']) , 'DB_name' => 'Code_joueur' , 'valeur_initiale' => $a_membre_joueur_groupe['Code_joueur'] ]);

    /* a_membre_joueur_groupe_Surnom */
        if ( $mf_droits_defaut['api_modifier__a_membre_joueur_groupe_Surnom'] )
            $trans['{a_membre_joueur_groupe_Surnom}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_groupe'=>$a_membre_joueur_groupe['Code_groupe'], 'Code_joueur'=>$a_membre_joueur_groupe['Code_joueur']) , 'DB_name' => 'a_membre_joueur_groupe_Surnom' , 'valeur_initiale' => $a_membre_joueur_groupe['a_membre_joueur_groupe_Surnom'] ]);
        else
            $trans['{a_membre_joueur_groupe_Surnom}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_groupe'=>$a_membre_joueur_groupe['Code_groupe'], 'Code_joueur'=>$a_membre_joueur_groupe['Code_joueur']) , 'DB_name' => 'a_membre_joueur_groupe_Surnom' , 'valeur_initiale' => $a_membre_joueur_groupe['a_membre_joueur_groupe_Surnom'] ]);

    /* a_membre_joueur_groupe_Grade */
        if ( $mf_droits_defaut['api_modifier__a_membre_joueur_groupe_Grade'] )
            $trans['{a_membre_joueur_groupe_Grade}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_groupe'=>$a_membre_joueur_groupe['Code_groupe'], 'Code_joueur'=>$a_membre_joueur_groupe['Code_joueur']) , 'DB_name' => 'a_membre_joueur_groupe_Grade' , 'valeur_initiale' => $a_membre_joueur_groupe['a_membre_joueur_groupe_Grade'] ]);
        else
            $trans['{a_membre_joueur_groupe_Grade}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_groupe'=>$a_membre_joueur_groupe['Code_groupe'], 'Code_joueur'=>$a_membre_joueur_groupe['Code_joueur']) , 'DB_name' => 'a_membre_joueur_groupe_Grade' , 'valeur_initiale' => $a_membre_joueur_groupe['a_membre_joueur_groupe_Grade'] ]);

    /* a_membre_joueur_groupe_Date_adhesion */
        if ( $mf_droits_defaut['api_modifier__a_membre_joueur_groupe_Date_adhesion'] )
            $trans['{a_membre_joueur_groupe_Date_adhesion}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_groupe'=>$a_membre_joueur_groupe['Code_groupe'], 'Code_joueur'=>$a_membre_joueur_groupe['Code_joueur']) , 'DB_name' => 'a_membre_joueur_groupe_Date_adhesion' , 'valeur_initiale' => $a_membre_joueur_groupe['a_membre_joueur_groupe_Date_adhesion'] ]);
        else
            $trans['{a_membre_joueur_groupe_Date_adhesion}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_groupe'=>$a_membre_joueur_groupe['Code_groupe'], 'Code_joueur'=>$a_membre_joueur_groupe['Code_joueur']) , 'DB_name' => 'a_membre_joueur_groupe_Date_adhesion' , 'valeur_initiale' => $a_membre_joueur_groupe['a_membre_joueur_groupe_Date_adhesion'] ]);

