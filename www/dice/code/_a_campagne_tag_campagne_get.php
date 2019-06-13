<?php

    /* Actualisation des droits */
    Hook_a_campagne_tag_campagne::hook_actualiser_les_droits_supprimer();

    /* boutons */
        if ($mf_droits_defaut['a_campagne_tag_campagne__SUPPRIMER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_SUPPRIMER_PREC . get_nom_colonne('bouton_supprimer_a_campagne_tag_campagne') . BOUTON_LIBELLE_SUPPRIMER_SUIV, get_nom_page_courante().'?act=supprimer_a_campagne_tag_campagne&Code_tag_campagne='.$Code_tag_campagne.'&Code_campagne='.$Code_campagne.'', 'lien', 'bouton_supprimer_a_campagne_tag_campagne');
        }
        $trans['{bouton_supprimer_a_campagne_tag_campagne}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_supprimer_a_campagne_tag_campagne', BOUTON_CLASSE_SUPPRIMER) : '';

    /* prec_et_suiv */
        $liste_a_campagne_tag_campagne = $table_a_campagne_tag_campagne->mf_lister_contexte();
        // prec
        $prec_et_suiv = prec_suiv($liste_a_campagne_tag_campagne, $a_campagne_tag_campagne['Code_tag_campagne'].'-'.$a_campagne_tag_campagne['Code_campagne']);
        $prec=['link'=>'', 'title'=>''];
        $suiv=['link'=>'', 'title'=>''];
        if (isset($prec_et_suiv['prec']['Code_tag_campagne']))
        {
            $prec['link'] = get_nom_page_courante().'?act=apercu_a_campagne_tag_campagne&Code_tag_campagne='.$prec_et_suiv['prec']['Code_tag_campagne'].'&Code_campagne='.$prec_et_suiv['prec']['Code_campagne'].'';
            $prec['title'] = htmlspecialchars(get_titre_ligne_table('a_campagne_tag_campagne', $prec_et_suiv['prec']));
        }
        // suiv
        if (isset($prec_et_suiv['suiv']['Code_tag_campagne']))
        {
            $suiv['link'] = get_nom_page_courante().'?act=apercu_a_campagne_tag_campagne&Code_tag_campagne='.$prec_et_suiv['suiv']['Code_tag_campagne'].'&Code_campagne='.$prec_et_suiv['suiv']['Code_campagne'].'';
            $suiv['title'] = htmlspecialchars(get_titre_ligne_table('a_campagne_tag_campagne', $prec_et_suiv['suiv']));
        }
        $trans['{pager_a_campagne_tag_campagne}'] = get_code_pager($prec, $suiv);

    /* Code_tag_campagne */
        $trans['{Code_tag_campagne}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_tag_campagne'=>$a_campagne_tag_campagne['Code_tag_campagne'], 'Code_campagne'=>$a_campagne_tag_campagne['Code_campagne']) , 'DB_name' => 'Code_tag_campagne' , 'valeur_initiale' => $a_campagne_tag_campagne['Code_tag_campagne'] ]);

    /* Code_campagne */
        $trans['{Code_campagne}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_tag_campagne'=>$a_campagne_tag_campagne['Code_tag_campagne'], 'Code_campagne'=>$a_campagne_tag_campagne['Code_campagne']) , 'DB_name' => 'Code_campagne' , 'valeur_initiale' => $a_campagne_tag_campagne['Code_campagne'] ]);

