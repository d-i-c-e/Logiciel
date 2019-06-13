<?php

    if ($mf_action=='apercu_tag_campagne' || $mf_action<>'' && $Code_tag_campagne!=0)
    {

        $tag_campagne = $table_tag_campagne->mf_get($Code_tag_campagne, array( 'autocompletion' => true ));

        if (isset($tag_campagne['Code_tag_campagne']))
        {

            $fil_ariane->ajouter_titre(get_titre_ligne_table('tag_campagne', $tag_campagne), get_nom_page_courante().'?act=apercu_tag_campagne&Code_tag_campagne='.$Code_tag_campagne);

            $menu_a_droite->raz_boutons();

            if ( ! MULTI_BLOCS ) { $code_html = ''; }

            include __DIR__ . '/_tag_campagne_get.php';

            $code_html.= recuperer_gabarit('main/section.html', array(
                '{fonction}'  => 'apercu',
                '{nom_table}' => 'tag_campagne',
                '{titre}'     => strip_tags(htmlspecialchars_decode(get_titre_ligne_table('tag_campagne', $tag_campagne)), ''),
                '{contenu}'   => recuperer_gabarit('tag_campagne/bloc_apercu.html', $trans),
            ));

        }

    }
    else
    {

        include __DIR__ . '/_tag_campagne_list.php';

        $code_html.=recuperer_gabarit('main/section.html', array(
            '{fonction}'  => 'lister',
            '{nom_table}' => 'tag_campagne',
            '{titre}'     => htmlspecialchars(get_nom_colonne('libelle_liste_tag_campagne')),
            '{contenu}'   => recuperer_gabarit('tag_campagne/bloc_lister.html', $trans),
        ));

    }

    if ($mf_action=="ajouter_tag_campagne")
    {

        $form = new Formulaire('', $mess);
        $form->ajouter_input("tag_campagne_Libelle", ( isset($_POST['tag_campagne_Libelle']) ? $_POST['tag_campagne_Libelle'] : $mf_initialisation['tag_campagne_Libelle'] ), true);

        $code_html.=recuperer_gabarit('tag_campagne/form_add_tag_campagne.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_add_tag_campagne')), false, true);

    }
    elseif ($mf_action=="modifier_tag_campagne")
    {

        $tag_campagne = $table_tag_campagne->mf_get($Code_tag_campagne, array( 'autocompletion' => true ));
        if (isset($tag_campagne['Code_tag_campagne']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("tag_campagne_Libelle", ( isset($_POST['tag_campagne_Libelle']) ? $_POST['tag_campagne_Libelle'] : $tag_campagne['tag_campagne_Libelle'] ), true);

            $code_html.=recuperer_gabarit('tag_campagne/form_edit_tag_campagne.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_tag_campagne')), false, true);

        }

    }
    elseif ($mf_action=='modifier_tag_campagne_Libelle')
    {

        $tag_campagne = $table_tag_campagne->mf_get($Code_tag_campagne, array( 'autocompletion' => true ));
        if (isset($tag_campagne['Code_tag_campagne']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("tag_campagne_Libelle", ( isset($_POST['tag_campagne_Libelle']) ? $_POST['tag_campagne_Libelle'] : $tag_campagne['tag_campagne_Libelle'] ), true);

            $code_html.=recuperer_gabarit('tag_campagne/form_edit_tag_campagne_Libelle.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_tag_campagne_Libelle')), false, true);

        }

    }
    elseif ($mf_action=="supprimer_tag_campagne")
    {

        $tag_campagne = $table_tag_campagne->mf_get($Code_tag_campagne, array( 'autocompletion' => true ));
        if ( isset($tag_campagne['Code_tag_campagne']) )
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_select(array(0, 1), 'Supprimer', FORM_SUPPR_DEFAUT, true);
            $form->activer_picto_suppression();

            $code_html.=recuperer_gabarit('tag_campagne/form_delete_tag_campagne.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_delete_tag_campagne')), false, true);

        }

    }

