<?php

    if ($mf_action=='apercu_a_campagne_tag_campagne' && $_GET['act']!='ajouter_a_campagne_tag_campagne' && $_GET['act']!='supprimer_a_campagne_tag_campagne')
    {

        if (isset($Code_tag_campagne) && $Code_tag_campagne!=0 && isset($Code_campagne) && $Code_campagne!=0)
        {
            $a_campagne_tag_campagne = $table_a_campagne_tag_campagne->mf_get($Code_tag_campagne, $Code_campagne, array( 'autocompletion' => true ));
        }

        if (isset($a_campagne_tag_campagne['Code_tag_campagne']))
        {

            $fil_ariane->ajouter_titre(get_titre_ligne_table('a_campagne_tag_campagne', $a_campagne_tag_campagne), get_nom_page_courante().'?act=apercu_a_campagne_tag_campagne&Code_tag_campagne='.$Code_tag_campagne.'&Code_campagne='.$Code_campagne.'');

            if ( ! MULTI_BLOCS ) { $code_html = ''; }

            include __DIR__ . '/_a_campagne_tag_campagne_get.php';

            $code_html.=recuperer_gabarit('main/section.html', array(
                '{fonction}'  => 'apercu',
                '{nom_table}' => 'a_campagne_tag_campagne',
                '{titre}'     => htmlspecialchars(get_titre_ligne_table('a_campagne_tag_campagne', $a_campagne_tag_campagne)),
                '{contenu}'   => recuperer_gabarit('a_campagne_tag_campagne/bloc_apercu.html', $trans),
            ));

        }

    }
    else
    {

        /* debut developpement */
//         include __DIR__ . '/_a_campagne_tag_campagne_list.php';

//         $code_html.=recuperer_gabarit('main/section.html', array(
//             '{fonction}'  => 'lister',
//             '{nom_table}' => 'a_campagne_tag_campagne',
//             '{titre}'     => htmlspecialchars(get_nom_colonne('libelle_liste_a_campagne_tag_campagne')),
//             '{contenu}'   => recuperer_gabarit('a_campagne_tag_campagne/bloc_lister.html', $trans),
//         ));
        /* fin developpement */

    }

    if ($mf_action=="ajouter_a_campagne_tag_campagne")
    {

        $form = new Formulaire('', $mess);
        if (!isset($est_charge['tag_campagne']))
        {
            $form->ajouter_select(lister_cles($lang_standard['Code_tag_campagne_']), "Code_tag_campagne", ( isset($_POST['Code_tag_campagne']) ? $_POST['Code_tag_campagne'] : 0 ), true);
        }
        if (!isset($est_charge['campagne']))
        {
            $form->ajouter_select(lister_cles($lang_standard['Code_campagne_']), "Code_campagne", ( isset($_POST['Code_campagne']) ? $_POST['Code_campagne'] : 0 ), true);
        }

        $code_html.=recuperer_gabarit('a_campagne_tag_campagne/form_add_a_campagne_tag_campagne.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_add_a_campagne_tag_campagne')), false, true);

    }
    elseif ($mf_action=="supprimer_a_campagne_tag_campagne")
    {

        $a_campagne_tag_campagne = $table_a_campagne_tag_campagne->mf_get($Code_tag_campagne, $Code_campagne, array( 'autocompletion' => true ));
        if ( isset($a_campagne_tag_campagne['Code_tag_campagne']) )
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_select(array(0, 1), 'Supprimer', FORM_SUPPR_DEFAUT, true);
            $form->activer_picto_suppression();

            $code_html.=recuperer_gabarit('a_campagne_tag_campagne/form_delete_a_campagne_tag_campagne.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_delete_a_campagne_tag_campagne')), false, true);

        }

    }
