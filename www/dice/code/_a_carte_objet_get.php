<?php

    /* Actualisation des droits */
    Hook_a_carte_objet::hook_actualiser_les_droits_supprimer();

    /* boutons */
        if ($mf_droits_defaut['a_carte_objet__SUPPRIMER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_SUPPRIMER_PREC . get_nom_colonne('bouton_supprimer_a_carte_objet') . BOUTON_LIBELLE_SUPPRIMER_SUIV, get_nom_page_courante().'?act=supprimer_a_carte_objet&Code_carte='.$Code_carte.'&Code_objet='.$Code_objet.'', 'lien', 'bouton_supprimer_a_carte_objet');
        }
        $trans['{bouton_supprimer_a_carte_objet}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_supprimer_a_carte_objet', BOUTON_CLASSE_SUPPRIMER) : '';

    /* prec_et_suiv */
        $liste_a_carte_objet = $table_a_carte_objet->mf_lister_contexte();
        // prec
        $prec_et_suiv = prec_suiv($liste_a_carte_objet, $a_carte_objet['Code_carte'].'-'.$a_carte_objet['Code_objet']);
        $prec=['link'=>'', 'title'=>''];
        $suiv=['link'=>'', 'title'=>''];
        if (isset($prec_et_suiv['prec']['Code_carte']))
        {
            $prec['link'] = get_nom_page_courante().'?act=apercu_a_carte_objet&Code_carte='.$prec_et_suiv['prec']['Code_carte'].'&Code_objet='.$prec_et_suiv['prec']['Code_objet'].'';
            $prec['title'] = htmlspecialchars(get_titre_ligne_table('a_carte_objet', $prec_et_suiv['prec']));
        }
        // suiv
        if (isset($prec_et_suiv['suiv']['Code_carte']))
        {
            $suiv['link'] = get_nom_page_courante().'?act=apercu_a_carte_objet&Code_carte='.$prec_et_suiv['suiv']['Code_carte'].'&Code_objet='.$prec_et_suiv['suiv']['Code_objet'].'';
            $suiv['title'] = htmlspecialchars(get_titre_ligne_table('a_carte_objet', $prec_et_suiv['suiv']));
        }
        $trans['{pager_a_carte_objet}'] = get_code_pager($prec, $suiv);

    /* Code_carte */
        $trans['{Code_carte}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_carte'=>$a_carte_objet['Code_carte'], 'Code_objet'=>$a_carte_objet['Code_objet']) , 'DB_name' => 'Code_carte' , 'valeur_initiale' => $a_carte_objet['Code_carte'] ]);

    /* Code_objet */
        $trans['{Code_objet}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_carte'=>$a_carte_objet['Code_carte'], 'Code_objet'=>$a_carte_objet['Code_objet']) , 'DB_name' => 'Code_objet' , 'valeur_initiale' => $a_carte_objet['Code_objet'] ]);

