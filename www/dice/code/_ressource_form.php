<?php

    if ($mf_action=='apercu_ressource' || $mf_action<>'' && $Code_ressource!=0)
    {

        $ressource = $table_ressource->mf_get($Code_ressource, array( 'autocompletion' => true ));

        if (isset($ressource['Code_ressource']))
        {

            $fil_ariane->ajouter_titre(get_titre_ligne_table('ressource', $ressource), get_nom_page_courante().'?act=apercu_ressource&Code_ressource='.$Code_ressource);

            $menu_a_droite->raz_boutons();

            if ( ! MULTI_BLOCS ) { $code_html = ''; }

            include __DIR__ . '/_ressource_get.php';

            $code_html.= recuperer_gabarit('main/section.html', array(
                '{fonction}'  => 'apercu',
                '{nom_table}' => 'ressource',
                '{titre}'     => strip_tags(htmlspecialchars_decode(get_titre_ligne_table('ressource', $ressource)), ''),
                '{contenu}'   => recuperer_gabarit('ressource/bloc_apercu.html', $trans),
            ));

        }

    }
    else
    {

        include __DIR__ . '/_ressource_list.php';

        $code_html.=recuperer_gabarit('main/section.html', array(
            '{fonction}'  => 'lister',
            '{nom_table}' => 'ressource',
            '{titre}'     => htmlspecialchars(get_nom_colonne('libelle_liste_ressource')),
            '{contenu}'   => recuperer_gabarit('ressource/bloc_lister.html', $trans),
        ));

    }

    if ($mf_action=="ajouter_ressource")
    {

        $form = new Formulaire('', $mess);
        $form->ajouter_input("ressource_Nom", ( isset($_POST['ressource_Nom']) ? $_POST['ressource_Nom'] : $mf_initialisation['ressource_Nom'] ), true);

        $code_html.=recuperer_gabarit('ressource/form_add_ressource.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_add_ressource')), false, true);

    }
    elseif ($mf_action=="modifier_ressource")
    {

        $ressource = $table_ressource->mf_get($Code_ressource, array( 'autocompletion' => true ));
        if (isset($ressource['Code_ressource']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("ressource_Nom", ( isset($_POST['ressource_Nom']) ? $_POST['ressource_Nom'] : $ressource['ressource_Nom'] ), true);

            $code_html.=recuperer_gabarit('ressource/form_edit_ressource.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_ressource')), false, true);

        }

    }
    elseif ($mf_action=='modifier_ressource_Nom')
    {

        $ressource = $table_ressource->mf_get($Code_ressource, array( 'autocompletion' => true ));
        if (isset($ressource['Code_ressource']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("ressource_Nom", ( isset($_POST['ressource_Nom']) ? $_POST['ressource_Nom'] : $ressource['ressource_Nom'] ), true);

            $code_html.=recuperer_gabarit('ressource/form_edit_ressource_Nom.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_ressource_Nom')), false, true);

        }

    }
    elseif ($mf_action=="supprimer_ressource")
    {

        $ressource = $table_ressource->mf_get($Code_ressource, array( 'autocompletion' => true ));
        if ( isset($ressource['Code_ressource']) )
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_select(array(0, 1), 'Supprimer', FORM_SUPPR_DEFAUT, true);
            $form->activer_picto_suppression();

            $code_html.=recuperer_gabarit('ressource/form_delete_ressource.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_delete_ressource')), false, true);

        }

    }

