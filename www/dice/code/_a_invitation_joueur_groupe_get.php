<?php

    /* Actualisation des droits */
    Hook_a_invitation_joueur_groupe::hook_actualiser_les_droits_modifier($a_invitation_joueur_groupe['Code_joueur'], $a_invitation_joueur_groupe['Code_groupe']);
    Hook_a_invitation_joueur_groupe::hook_actualiser_les_droits_supprimer($a_invitation_joueur_groupe['Code_joueur'], $a_invitation_joueur_groupe['Code_groupe']);

    /* boutons */
        if ($mf_droits_defaut['a_invitation_joueur_groupe__MODIFIER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_a_invitation_joueur_groupe') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_a_invitation_joueur_groupe&Code_joueur='.$Code_joueur.'&Code_groupe='.$Code_groupe.'', 'lien', 'bouton_modifier_a_invitation_joueur_groupe');
        }
        $trans['{bouton_modifier_a_invitation_joueur_groupe}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_a_invitation_joueur_groupe') : '';
        if ($mf_droits_defaut['a_invitation_joueur_groupe__SUPPRIMER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_SUPPRIMER_PREC . get_nom_colonne('bouton_supprimer_a_invitation_joueur_groupe') . BOUTON_LIBELLE_SUPPRIMER_SUIV, get_nom_page_courante().'?act=supprimer_a_invitation_joueur_groupe&Code_joueur='.$Code_joueur.'&Code_groupe='.$Code_groupe.'', 'lien', 'bouton_supprimer_a_invitation_joueur_groupe');
        }
        $trans['{bouton_supprimer_a_invitation_joueur_groupe}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_supprimer_a_invitation_joueur_groupe', BOUTON_CLASSE_SUPPRIMER) : '';

        // a_invitation_joueur_groupe_Message
        if ( $mf_droits_defaut['api_modifier__a_invitation_joueur_groupe_Message'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_a_invitation_joueur_groupe_Message') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_a_invitation_joueur_groupe_Message&Code_joueur='.$Code_joueur.'&Code_groupe='.$Code_groupe.'', 'lien', 'bouton_modifier_a_invitation_joueur_groupe_Message');
        }
        $trans['{bouton_modifier_a_invitation_joueur_groupe_Message}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_a_invitation_joueur_groupe_Message') : '';

        // a_invitation_joueur_groupe_Date_envoi
        if ( $mf_droits_defaut['api_modifier__a_invitation_joueur_groupe_Date_envoi'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_a_invitation_joueur_groupe_Date_envoi') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_a_invitation_joueur_groupe_Date_envoi&Code_joueur='.$Code_joueur.'&Code_groupe='.$Code_groupe.'', 'lien', 'bouton_modifier_a_invitation_joueur_groupe_Date_envoi');
        }
        $trans['{bouton_modifier_a_invitation_joueur_groupe_Date_envoi}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_a_invitation_joueur_groupe_Date_envoi') : '';

    /* prec_et_suiv */
        $liste_a_invitation_joueur_groupe = $table_a_invitation_joueur_groupe->mf_lister_contexte();
        // prec
        $prec_et_suiv = prec_suiv($liste_a_invitation_joueur_groupe, $a_invitation_joueur_groupe['Code_joueur'].'-'.$a_invitation_joueur_groupe['Code_groupe']);
        $prec=['link'=>'', 'title'=>''];
        $suiv=['link'=>'', 'title'=>''];
        if (isset($prec_et_suiv['prec']['Code_joueur']))
        {
            $prec['link'] = get_nom_page_courante().'?act=apercu_a_invitation_joueur_groupe&Code_joueur='.$prec_et_suiv['prec']['Code_joueur'].'&Code_groupe='.$prec_et_suiv['prec']['Code_groupe'].'';
            $prec['title'] = htmlspecialchars(get_titre_ligne_table('a_invitation_joueur_groupe', $prec_et_suiv['prec']));
        }
        // suiv
        if (isset($prec_et_suiv['suiv']['Code_joueur']))
        {
            $suiv['link'] = get_nom_page_courante().'?act=apercu_a_invitation_joueur_groupe&Code_joueur='.$prec_et_suiv['suiv']['Code_joueur'].'&Code_groupe='.$prec_et_suiv['suiv']['Code_groupe'].'';
            $suiv['title'] = htmlspecialchars(get_titre_ligne_table('a_invitation_joueur_groupe', $prec_et_suiv['suiv']));
        }
        $trans['{pager_a_invitation_joueur_groupe}'] = get_code_pager($prec, $suiv);

    /* Code_joueur */
        $trans['{Code_joueur}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_joueur'=>$a_invitation_joueur_groupe['Code_joueur'], 'Code_groupe'=>$a_invitation_joueur_groupe['Code_groupe']) , 'DB_name' => 'Code_joueur' , 'valeur_initiale' => $a_invitation_joueur_groupe['Code_joueur'] ]);

    /* Code_groupe */
        $trans['{Code_groupe}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_joueur'=>$a_invitation_joueur_groupe['Code_joueur'], 'Code_groupe'=>$a_invitation_joueur_groupe['Code_groupe']) , 'DB_name' => 'Code_groupe' , 'valeur_initiale' => $a_invitation_joueur_groupe['Code_groupe'] ]);

    /* a_invitation_joueur_groupe_Message */
        if ( $mf_droits_defaut['api_modifier__a_invitation_joueur_groupe_Message'] )
            $trans['{a_invitation_joueur_groupe_Message}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_joueur'=>$a_invitation_joueur_groupe['Code_joueur'], 'Code_groupe'=>$a_invitation_joueur_groupe['Code_groupe']) , 'DB_name' => 'a_invitation_joueur_groupe_Message' , 'valeur_initiale' => $a_invitation_joueur_groupe['a_invitation_joueur_groupe_Message'] ]);
        else
            $trans['{a_invitation_joueur_groupe_Message}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_joueur'=>$a_invitation_joueur_groupe['Code_joueur'], 'Code_groupe'=>$a_invitation_joueur_groupe['Code_groupe']) , 'DB_name' => 'a_invitation_joueur_groupe_Message' , 'valeur_initiale' => $a_invitation_joueur_groupe['a_invitation_joueur_groupe_Message'] , 'class' => 'text' ]);

    /* a_invitation_joueur_groupe_Date_envoi */
        if ( $mf_droits_defaut['api_modifier__a_invitation_joueur_groupe_Date_envoi'] )
            $trans['{a_invitation_joueur_groupe_Date_envoi}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_joueur'=>$a_invitation_joueur_groupe['Code_joueur'], 'Code_groupe'=>$a_invitation_joueur_groupe['Code_groupe']) , 'DB_name' => 'a_invitation_joueur_groupe_Date_envoi' , 'valeur_initiale' => $a_invitation_joueur_groupe['a_invitation_joueur_groupe_Date_envoi'] ]);
        else
            $trans['{a_invitation_joueur_groupe_Date_envoi}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_joueur'=>$a_invitation_joueur_groupe['Code_joueur'], 'Code_groupe'=>$a_invitation_joueur_groupe['Code_groupe']) , 'DB_name' => 'a_invitation_joueur_groupe_Date_envoi' , 'valeur_initiale' => $a_invitation_joueur_groupe['a_invitation_joueur_groupe_Date_envoi'] ]);

