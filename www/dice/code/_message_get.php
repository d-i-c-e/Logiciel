<?php

    /* Actualisation des droits */
    Hook_message::hook_actualiser_les_droits_modifier($message['Code_message']);
    Hook_message::hook_actualiser_les_droits_supprimer($message['Code_message']);

    /* boutons */
        if ($mf_droits_defaut['message__MODIFIER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_message') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_message&Code_message='.$Code_message, 'lien', 'bouton_modifier_message');
        }
        $trans['{bouton_modifier_message}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_message') : '';
        if ($mf_droits_defaut['message__SUPPRIMER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_SUPPRIMER_PREC . get_nom_colonne('bouton_supprimer_message') . BOUTON_LIBELLE_SUPPRIMER_SUIV, get_nom_page_courante().'?act=supprimer_message&Code_message='.$Code_message, 'lien', 'bouton_supprimer_message');
        }
        $trans['{bouton_supprimer_message}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_supprimer_message', BOUTON_CLASSE_SUPPRIMER) : '';

        // message_Texte
        if ( $mf_droits_defaut['api_modifier__message_Texte'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_message_Texte') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_message_Texte&Code_message='.$Code_message, 'lien', 'bouton_modifier_message_Texte');
        }
        $trans['{bouton_modifier_message_Texte}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_message_Texte') : '';

        // message_Date
        if ( $mf_droits_defaut['api_modifier__message_Date'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_message_Date') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_message_Date&Code_message='.$Code_message, 'lien', 'bouton_modifier_message_Date');
        }
        $trans['{bouton_modifier_message_Date}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_message_Date') : '';

        // Code_messagerie
        if ( $mf_droits_defaut['api_modifier_ref__message__Code_messagerie'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_message__Code_messagerie') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_message__Code_messagerie&Code_message='.$Code_message, 'lien', 'bouton_modifier_message__Code_messagerie');
        }
        $trans['{bouton_modifier_message__Code_messagerie}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_message__Code_messagerie') : '';

        // Code_joueur
        if ( $mf_droits_defaut['api_modifier_ref__message__Code_joueur'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_message__Code_joueur') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_message__Code_joueur&Code_message='.$Code_message, 'lien', 'bouton_modifier_message__Code_joueur');
        }
        $trans['{bouton_modifier_message__Code_joueur}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_message__Code_joueur') : '';

    /* prec_et_suiv */
    if ( $table_message->mf_compter((isset($est_charge['messagerie']) ? $mf_contexte['Code_messagerie'] : 0), (isset($est_charge['joueur']) ? $mf_contexte['Code_joueur'] : 0))<100 )
    {
        $liste_message = $table_message->mf_lister_contexte();
        // prec
        $prec_et_suiv = prec_suiv($liste_message, $message['Code_message']);
        $prec=['link'=>'', 'title'=>''];
        $suiv=['link'=>'', 'title'=>''];
        if (isset($prec_et_suiv['prec']['Code_message']))
        {
            $prec['link'] = get_nom_page_courante().'?act=apercu_message&Code_message='.$prec_et_suiv['prec']['Code_message'];
            $prec['title'] = htmlspecialchars(get_titre_ligne_table('message', $prec_et_suiv['prec']));
        }
        // suiv
        if (isset($prec_et_suiv['suiv']['Code_message']))
        {
            $suiv['link'] = get_nom_page_courante().'?act=apercu_message&Code_message='.$prec_et_suiv['suiv']['Code_message'];
            $suiv['title'] = htmlspecialchars(get_titre_ligne_table('message', $prec_et_suiv['suiv']));
        }
        $trans['{pager_message}'] = get_code_pager($prec, $suiv);
    }
    else
    {
        $trans['{pager_message}'] = '';
    }

    /* message_Texte */
        if ( $mf_droits_defaut['api_modifier__message_Texte'] )
            $trans['{message_Texte}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_message' => $message['Code_message']) , 'DB_name' => 'message_Texte' , 'valeur_initiale' => $message['message_Texte'] ]);
        else
            $trans['{message_Texte}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_message' => $message['Code_message']) , 'DB_name' => 'message_Texte' , 'valeur_initiale' => $message['message_Texte'] , 'class' => 'text' ]);

    /* message_Date */
        if ( $mf_droits_defaut['api_modifier__message_Date'] )
            $trans['{message_Date}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_message' => $message['Code_message']) , 'DB_name' => 'message_Date' , 'valeur_initiale' => $message['message_Date'] ]);
        else
            $trans['{message_Date}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_message' => $message['Code_message']) , 'DB_name' => 'message_Date' , 'valeur_initiale' => $message['message_Date'] ]);

    /* Code_messagerie */
        if ( $mf_droits_defaut['api_modifier_ref__message__Code_messagerie'] )
            $trans['{Code_messagerie}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_message' => $message['Code_message']) , 'DB_name' => 'Code_messagerie' , 'valeur_initiale' => $message['Code_messagerie'] , 'nom_table' => 'message' ]);
        else
            $trans['{Code_messagerie}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_message' => $message['Code_message']) , 'DB_name' => 'Code_messagerie' , 'valeur_initiale' => $message['Code_messagerie'] , 'nom_table' => 'message' ]);

    /* Code_joueur */
        if ( $mf_droits_defaut['api_modifier_ref__message__Code_joueur'] )
            $trans['{Code_joueur}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_message' => $message['Code_message']) , 'DB_name' => 'Code_joueur' , 'valeur_initiale' => $message['Code_joueur'] , 'nom_table' => 'message' ]);
        else
            $trans['{Code_joueur}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_message' => $message['Code_message']) , 'DB_name' => 'Code_joueur' , 'valeur_initiale' => $message['Code_joueur'] , 'nom_table' => 'message' ]);

