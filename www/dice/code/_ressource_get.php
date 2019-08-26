<?php

    /* Actualisation des droits */
    Hook_ressource::hook_actualiser_les_droits_modifier($ressource['Code_ressource']);
    Hook_ressource::hook_actualiser_les_droits_supprimer($ressource['Code_ressource']);

    /* boutons */
        if ($mf_droits_defaut['ressource__MODIFIER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_ressource') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_ressource&Code_ressource='.$Code_ressource, 'lien', 'bouton_modifier_ressource');
        }
        $trans['{bouton_modifier_ressource}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_ressource') : '';
        if ($mf_droits_defaut['ressource__SUPPRIMER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_SUPPRIMER_PREC . get_nom_colonne('bouton_supprimer_ressource') . BOUTON_LIBELLE_SUPPRIMER_SUIV, get_nom_page_courante().'?act=supprimer_ressource&Code_ressource='.$Code_ressource, 'lien', 'bouton_supprimer_ressource');
        }
        $trans['{bouton_supprimer_ressource}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_supprimer_ressource', BOUTON_CLASSE_SUPPRIMER) : '';

        // ressource_Nom
        if ( $mf_droits_defaut['api_modifier__ressource_Nom'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_ressource_Nom') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_ressource_Nom&Code_ressource='.$Code_ressource, 'lien', 'bouton_modifier_ressource_Nom');
        }
        $trans['{bouton_modifier_ressource_Nom}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_ressource_Nom') : '';

    /* prec_et_suiv */
    if ( $table_ressource->mf_compter()<100 )
    {
        $liste_ressource = $table_ressource->mf_lister_contexte();
        // prec
        $prec_et_suiv = prec_suiv($liste_ressource, $ressource['Code_ressource']);
        $prec=['link'=>'', 'title'=>''];
        $suiv=['link'=>'', 'title'=>''];
        if (isset($prec_et_suiv['prec']['Code_ressource']))
        {
            $prec['link'] = get_nom_page_courante().'?act=apercu_ressource&Code_ressource='.$prec_et_suiv['prec']['Code_ressource'];
            $prec['title'] = htmlspecialchars(get_titre_ligne_table('ressource', $prec_et_suiv['prec']));
        }
        // suiv
        if (isset($prec_et_suiv['suiv']['Code_ressource']))
        {
            $suiv['link'] = get_nom_page_courante().'?act=apercu_ressource&Code_ressource='.$prec_et_suiv['suiv']['Code_ressource'];
            $suiv['title'] = htmlspecialchars(get_titre_ligne_table('ressource', $prec_et_suiv['suiv']));
        }
        $trans['{pager_ressource}'] = get_code_pager($prec, $suiv);
    }
    else
    {
        $trans['{pager_ressource}'] = '';
    }

    /* ressource_Nom */
        if ( $mf_droits_defaut['api_modifier__ressource_Nom'] )
            $trans['{ressource_Nom}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_ressource' => $ressource['Code_ressource']) , 'DB_name' => 'ressource_Nom' , 'valeur_initiale' => $ressource['ressource_Nom'] ]);
        else
            $trans['{ressource_Nom}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_ressource' => $ressource['Code_ressource']) , 'DB_name' => 'ressource_Nom' , 'valeur_initiale' => $ressource['ressource_Nom'] ]);


/* debut developpement */
    include __DIR__ . '/_a_ressource_tag_ressource_list.php';
    include __DIR__ . '/_type_list.php';
