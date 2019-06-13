<?php

    if ($mf_action=='apercu_tag_ressource' || $mf_action<>'' && $Code_tag_ressource!=0)
    {

        $tag_ressource = $table_tag_ressource->mf_get($Code_tag_ressource, array( 'autocompletion' => true ));

        if (isset($tag_ressource['Code_tag_ressource']))
        {

            $fil_ariane->ajouter_titre(get_titre_ligne_table('tag_ressource', $tag_ressource), get_nom_page_courante().'?act=apercu_tag_ressource&Code_tag_ressource='.$Code_tag_ressource);

            $menu_a_droite->raz_boutons();

            if ( ! MULTI_BLOCS ) { $code_html = ''; }

            include __DIR__ . '/_tag_ressource_get.php';

            $code_html.= recuperer_gabarit('main/section.html', array(
                '{fonction}'  => 'apercu',
                '{nom_table}' => 'tag_ressource',
                '{titre}'     => strip_tags(htmlspecialchars_decode(get_titre_ligne_table('tag_ressource', $tag_ressource)), ''),
                '{contenu}'   => recuperer_gabarit('tag_ressource/bloc_apercu.html', $trans),
            ));

        }

    }
    else
    {

        include __DIR__ . '/_tag_ressource_list.php';

        $code_html.=recuperer_gabarit('main/section.html', array(
            '{fonction}'  => 'lister',
            '{nom_table}' => 'tag_ressource',
            '{titre}'     => htmlspecialchars(get_nom_colonne('libelle_liste_tag_ressource')),
            '{contenu}'   => recuperer_gabarit('tag_ressource/bloc_lister.html', $trans),
        ));

    }

    if ($mf_action=="ajouter_tag_ressource")
    {

        $form = new Formulaire('', $mess);
        $form->ajouter_input("tag_ressource_Libelle", ( isset($_POST['tag_ressource_Libelle']) ? $_POST['tag_ressource_Libelle'] : $mf_initialisation['tag_ressource_Libelle'] ), true);

        $code_html.=recuperer_gabarit('tag_ressource/form_add_tag_ressource.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_add_tag_ressource')), false, true);

    }
    elseif ($mf_action=="modifier_tag_ressource")
    {

        $tag_ressource = $table_tag_ressource->mf_get($Code_tag_ressource, array( 'autocompletion' => true ));
        if (isset($tag_ressource['Code_tag_ressource']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("tag_ressource_Libelle", ( isset($_POST['tag_ressource_Libelle']) ? $_POST['tag_ressource_Libelle'] : $tag_ressource['tag_ressource_Libelle'] ), true);

            $code_html.=recuperer_gabarit('tag_ressource/form_edit_tag_ressource.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_tag_ressource')), false, true);

        }

    }
    elseif ($mf_action=='modifier_tag_ressource_Libelle')
    {

        $tag_ressource = $table_tag_ressource->mf_get($Code_tag_ressource, array( 'autocompletion' => true ));
        if (isset($tag_ressource['Code_tag_ressource']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("tag_ressource_Libelle", ( isset($_POST['tag_ressource_Libelle']) ? $_POST['tag_ressource_Libelle'] : $tag_ressource['tag_ressource_Libelle'] ), true);

            $code_html.=recuperer_gabarit('tag_ressource/form_edit_tag_ressource_Libelle.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_tag_ressource_Libelle')), false, true);

        }

    }
    elseif ($mf_action=="supprimer_tag_ressource")
    {

        $tag_ressource = $table_tag_ressource->mf_get($Code_tag_ressource, array( 'autocompletion' => true ));
        if ( isset($tag_ressource['Code_tag_ressource']) )
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_select(array(0, 1), 'Supprimer', FORM_SUPPR_DEFAUT, true);
            $form->activer_picto_suppression();

            $code_html.=recuperer_gabarit('tag_ressource/form_delete_tag_ressource.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_delete_tag_ressource')), false, true);

        }

    }

