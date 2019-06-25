<?php

    /* Actualisation des droits */
    Hook_a_joueur_parametre::hook_actualiser_les_droits_supprimer();

    /* boutons */
        if ($mf_droits_defaut['a_joueur_parametre__SUPPRIMER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_SUPPRIMER_PREC . get_nom_colonne('bouton_supprimer_a_joueur_parametre') . BOUTON_LIBELLE_SUPPRIMER_SUIV, get_nom_page_courante().'?act=supprimer_a_joueur_parametre&Code_joueur='.$Code_joueur.'&Code_parametre='.$Code_parametre.'', 'lien', 'bouton_supprimer_a_joueur_parametre');
        }
        $trans['{bouton_supprimer_a_joueur_parametre}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_supprimer_a_joueur_parametre', BOUTON_CLASSE_SUPPRIMER) : '';

    /* prec_et_suiv */
    if ( $table_a_joueur_parametre->mf_compter((isset($est_charge['joueur']) ? $mf_contexte['Code_joueur'] : 0), (isset($est_charge['parametre']) ? $mf_contexte['Code_parametre'] : 0))<100 )
    {
        $liste_a_joueur_parametre = $table_a_joueur_parametre->mf_lister_contexte();
        // prec
        $prec_et_suiv = prec_suiv($liste_a_joueur_parametre, $a_joueur_parametre['Code_joueur'].'-'.$a_joueur_parametre['Code_parametre']);
        $prec=['link'=>'', 'title'=>''];
        $suiv=['link'=>'', 'title'=>''];
        if (isset($prec_et_suiv['prec']['Code_joueur']))
        {
            $prec['link'] = get_nom_page_courante().'?act=apercu_a_joueur_parametre&Code_joueur='.$prec_et_suiv['prec']['Code_joueur'].'&Code_parametre='.$prec_et_suiv['prec']['Code_parametre'].'';
            $prec['title'] = htmlspecialchars(get_titre_ligne_table('a_joueur_parametre', $prec_et_suiv['prec']));
        }
        // suiv
        if (isset($prec_et_suiv['suiv']['Code_joueur']))
        {
            $suiv['link'] = get_nom_page_courante().'?act=apercu_a_joueur_parametre&Code_joueur='.$prec_et_suiv['suiv']['Code_joueur'].'&Code_parametre='.$prec_et_suiv['suiv']['Code_parametre'].'';
            $suiv['title'] = htmlspecialchars(get_titre_ligne_table('a_joueur_parametre', $prec_et_suiv['suiv']));
        }
        $trans['{pager_a_joueur_parametre}'] = get_code_pager($prec, $suiv);
    }
    else
    {
        $trans['{pager_a_joueur_parametre}'] = '';
    }

    /* Code_joueur */
        $trans['{Code_joueur}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_joueur'=>$a_joueur_parametre['Code_joueur'], 'Code_parametre'=>$a_joueur_parametre['Code_parametre']) , 'DB_name' => 'Code_joueur' , 'valeur_initiale' => $a_joueur_parametre['Code_joueur'] ]);

    /* Code_parametre */
        $trans['{Code_parametre}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_joueur'=>$a_joueur_parametre['Code_joueur'], 'Code_parametre'=>$a_joueur_parametre['Code_parametre']) , 'DB_name' => 'Code_parametre' , 'valeur_initiale' => $a_joueur_parametre['Code_parametre'] ]);

