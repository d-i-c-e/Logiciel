<?php

    /* Actualisation des droits */
    Hook_tag_ressource::hook_actualiser_les_droits_modifier($tag_ressource['Code_tag_ressource']);
    Hook_tag_ressource::hook_actualiser_les_droits_supprimer($tag_ressource['Code_tag_ressource']);

    /* boutons */
        if ($mf_droits_defaut['tag_ressource__MODIFIER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_tag_ressource') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_tag_ressource&Code_tag_ressource='.$Code_tag_ressource, 'lien', 'bouton_modifier_tag_ressource');
        }
        $trans['{bouton_modifier_tag_ressource}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_tag_ressource') : '';
        if ($mf_droits_defaut['tag_ressource__SUPPRIMER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_SUPPRIMER_PREC . get_nom_colonne('bouton_supprimer_tag_ressource') . BOUTON_LIBELLE_SUPPRIMER_SUIV, get_nom_page_courante().'?act=supprimer_tag_ressource&Code_tag_ressource='.$Code_tag_ressource, 'lien', 'bouton_supprimer_tag_ressource');
        }
        $trans['{bouton_supprimer_tag_ressource}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_supprimer_tag_ressource', BOUTON_CLASSE_SUPPRIMER) : '';

        // tag_ressource_Libelle
        if ( $mf_droits_defaut['api_modifier__tag_ressource_Libelle'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_tag_ressource_Libelle') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_tag_ressource_Libelle&Code_tag_ressource='.$Code_tag_ressource, 'lien', 'bouton_modifier_tag_ressource_Libelle');
        }
        $trans['{bouton_modifier_tag_ressource_Libelle}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_tag_ressource_Libelle') : '';

    /* prec_et_suiv */
    if ( $table_tag_ressource->mf_compter()<100 )
    {
        $liste_tag_ressource = $table_tag_ressource->mf_lister_contexte();
        // prec
        $prec_et_suiv = prec_suiv($liste_tag_ressource, $tag_ressource['Code_tag_ressource']);
        $prec=['link'=>'', 'title'=>''];
        $suiv=['link'=>'', 'title'=>''];
        if (isset($prec_et_suiv['prec']['Code_tag_ressource']))
        {
            $prec['link'] = get_nom_page_courante().'?act=apercu_tag_ressource&Code_tag_ressource='.$prec_et_suiv['prec']['Code_tag_ressource'];
            $prec['title'] = htmlspecialchars(get_titre_ligne_table('tag_ressource', $prec_et_suiv['prec']));
        }
        // suiv
        if (isset($prec_et_suiv['suiv']['Code_tag_ressource']))
        {
            $suiv['link'] = get_nom_page_courante().'?act=apercu_tag_ressource&Code_tag_ressource='.$prec_et_suiv['suiv']['Code_tag_ressource'];
            $suiv['title'] = htmlspecialchars(get_titre_ligne_table('tag_ressource', $prec_et_suiv['suiv']));
        }
        $trans['{pager_tag_ressource}'] = get_code_pager($prec, $suiv);
    }
    else
    {
        $trans['{pager_tag_ressource}'] = '';
    }

    /* tag_ressource_Libelle */
        if ( $mf_droits_defaut['api_modifier__tag_ressource_Libelle'] )
            $trans['{tag_ressource_Libelle}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_tag_ressource' => $tag_ressource['Code_tag_ressource']) , 'DB_name' => 'tag_ressource_Libelle' , 'valeur_initiale' => $tag_ressource['tag_ressource_Libelle'] ]);
        else
            $trans['{tag_ressource_Libelle}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_tag_ressource' => $tag_ressource['Code_tag_ressource']) , 'DB_name' => 'tag_ressource_Libelle' , 'valeur_initiale' => $tag_ressource['tag_ressource_Libelle'] ]);


/* debut developpement */
    include __DIR__ . '/_a_ressource_tag_ressource_list.php';
