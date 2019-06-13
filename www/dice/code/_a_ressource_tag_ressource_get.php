<?php

    /* Actualisation des droits */
    Hook_a_ressource_tag_ressource::hook_actualiser_les_droits_supprimer();

    /* boutons */
        if ($mf_droits_defaut['a_ressource_tag_ressource__SUPPRIMER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_SUPPRIMER_PREC . get_nom_colonne('bouton_supprimer_a_ressource_tag_ressource') . BOUTON_LIBELLE_SUPPRIMER_SUIV, get_nom_page_courante().'?act=supprimer_a_ressource_tag_ressource&Code_tag_ressource='.$Code_tag_ressource.'&Code_ressource='.$Code_ressource.'', 'lien', 'bouton_supprimer_a_ressource_tag_ressource');
        }
        $trans['{bouton_supprimer_a_ressource_tag_ressource}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_supprimer_a_ressource_tag_ressource', BOUTON_CLASSE_SUPPRIMER) : '';

    /* prec_et_suiv */
        $liste_a_ressource_tag_ressource = $table_a_ressource_tag_ressource->mf_lister_contexte();
        // prec
        $prec_et_suiv = prec_suiv($liste_a_ressource_tag_ressource, $a_ressource_tag_ressource['Code_tag_ressource'].'-'.$a_ressource_tag_ressource['Code_ressource']);
        $prec=['link'=>'', 'title'=>''];
        $suiv=['link'=>'', 'title'=>''];
        if (isset($prec_et_suiv['prec']['Code_tag_ressource']))
        {
            $prec['link'] = get_nom_page_courante().'?act=apercu_a_ressource_tag_ressource&Code_tag_ressource='.$prec_et_suiv['prec']['Code_tag_ressource'].'&Code_ressource='.$prec_et_suiv['prec']['Code_ressource'].'';
            $prec['title'] = htmlspecialchars(get_titre_ligne_table('a_ressource_tag_ressource', $prec_et_suiv['prec']));
        }
        // suiv
        if (isset($prec_et_suiv['suiv']['Code_tag_ressource']))
        {
            $suiv['link'] = get_nom_page_courante().'?act=apercu_a_ressource_tag_ressource&Code_tag_ressource='.$prec_et_suiv['suiv']['Code_tag_ressource'].'&Code_ressource='.$prec_et_suiv['suiv']['Code_ressource'].'';
            $suiv['title'] = htmlspecialchars(get_titre_ligne_table('a_ressource_tag_ressource', $prec_et_suiv['suiv']));
        }
        $trans['{pager_a_ressource_tag_ressource}'] = get_code_pager($prec, $suiv);

    /* Code_tag_ressource */
        $trans['{Code_tag_ressource}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_tag_ressource'=>$a_ressource_tag_ressource['Code_tag_ressource'], 'Code_ressource'=>$a_ressource_tag_ressource['Code_ressource']) , 'DB_name' => 'Code_tag_ressource' , 'valeur_initiale' => $a_ressource_tag_ressource['Code_tag_ressource'] ]);

    /* Code_ressource */
        $trans['{Code_ressource}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_tag_ressource'=>$a_ressource_tag_ressource['Code_tag_ressource'], 'Code_ressource'=>$a_ressource_tag_ressource['Code_ressource']) , 'DB_name' => 'Code_ressource' , 'valeur_initiale' => $a_ressource_tag_ressource['Code_ressource'] ]);

