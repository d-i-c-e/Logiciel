<?php

    if ($mf_action=='apercu_message' || $mf_action<>'' && $Code_message!=0)
    {

        $message = $table_message->mf_get($Code_message, array( 'autocompletion' => true ));

        if (isset($message['Code_message']))
        {

            $fil_ariane->ajouter_titre(get_titre_ligne_table('message', $message), get_nom_page_courante().'?act=apercu_message&Code_message='.$Code_message);

            $menu_a_droite->raz_boutons();

            if ( ! MULTI_BLOCS ) { $code_html = ''; }

            include __DIR__ . '/_message_get.php';

            $code_html.= recuperer_gabarit('main/section.html', array(
                '{fonction}'  => 'apercu',
                '{nom_table}' => 'message',
                '{titre}'     => strip_tags(htmlspecialchars_decode(get_titre_ligne_table('message', $message)), ''),
                '{contenu}'   => recuperer_gabarit('message/bloc_apercu.html', $trans),
            ));

        }

    }
    else
    {

        include __DIR__ . '/_message_list.php';

        $code_html.=recuperer_gabarit('main/section.html', array(
            '{fonction}'  => 'lister',
            '{nom_table}' => 'message',
            '{titre}'     => htmlspecialchars(get_nom_colonne('libelle_liste_message')),
            '{contenu}'   => recuperer_gabarit('message/bloc_lister.html', $trans),
        ));

    }

    if ($mf_action=="ajouter_message")
    {

        $form = new Formulaire('', $mess);
        $form->ajouter_textarea("message_Texte", ( isset($_POST['message_Texte']) ? $_POST['message_Texte'] : $mf_initialisation['message_Texte'] ), true);
        $form->ajouter_input("message_Date", ( isset($_POST['message_Date']) ? $_POST['message_Date'] : $mf_initialisation['message_Date'] ), true);
        if (!isset($est_charge['messagerie']))
        {
            $form->ajouter_select(lister_cles($lang_standard['Code_messagerie_']), "Code_messagerie", ( isset($_POST['Code_messagerie']) ? $_POST['Code_messagerie'] : 0 ), true);
        }
        if (!isset($est_charge['joueur']))
        {
            $form->ajouter_select(lister_cles($lang_standard['Code_joueur_']), "Code_joueur", ( isset($_POST['Code_joueur']) ? $_POST['Code_joueur'] : 0 ), true);
        }

        $code_html.=recuperer_gabarit('message/form_add_message.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_add_message')), false, true);

    }
    elseif ($mf_action=="modifier_message")
    {

        $message = $table_message->mf_get($Code_message, array( 'autocompletion' => true ));
        if (isset($message['Code_message']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_textarea("message_Texte", ( isset($_POST['message_Texte']) ? $_POST['message_Texte'] : $message['message_Texte'] ), true);
            $form->ajouter_input("message_Date", ( isset($_POST['message_Date']) ? $_POST['message_Date'] : $message['message_Date'] ), true);
            if (!isset($est_charge['messagerie']))
            {
                $form->ajouter_select(lister_cles($lang_standard['Code_messagerie_']), "Code_messagerie", ( isset($_POST['Code_messagerie']) ? $_POST['Code_messagerie'] : $message['Code_messagerie'] ), true);
            }
            if (!isset($est_charge['joueur']))
            {
                $form->ajouter_select(lister_cles($lang_standard['Code_joueur_']), "Code_joueur", ( isset($_POST['Code_joueur']) ? $_POST['Code_joueur'] : $message['Code_joueur'] ), true);
            }

            $code_html.=recuperer_gabarit('message/form_edit_message.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_message')), false, true);

        }

    }
    elseif ($mf_action=='modifier_message_Texte')
    {

        $message = $table_message->mf_get($Code_message, array( 'autocompletion' => true ));
        if (isset($message['Code_message']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_textarea("message_Texte", ( isset($_POST['message_Texte']) ? $_POST['message_Texte'] : $message['message_Texte'] ), true);

            $code_html.=recuperer_gabarit('message/form_edit_message_Texte.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_message_Texte')), false, true);

        }

    }
    elseif ($mf_action=='modifier_message_Date')
    {

        $message = $table_message->mf_get($Code_message, array( 'autocompletion' => true ));
        if (isset($message['Code_message']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("message_Date", ( isset($_POST['message_Date']) ? $_POST['message_Date'] : $message['message_Date'] ), true);

            $code_html.=recuperer_gabarit('message/form_edit_message_Date.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_message_Date')), false, true);

        }

    }
    elseif ($mf_action=='modifier_message__Code_messagerie')
    {

        $message = $table_message->mf_get($Code_message, array( 'autocompletion' => true ));
        if (isset($message['Code_message']))
        {

            $form = new Formulaire('', $mess);
            if (!isset($est_charge['messagerie']))
            {
                $form->ajouter_select(lister_cles($lang_standard['Code_messagerie_']), "Code_messagerie", ( isset($_POST['Code_messagerie']) ? $_POST['Code_messagerie'] : $message['Code_messagerie'] ), true);
            }

            $code_html.=recuperer_gabarit('message/form_edit__Code_messagerie.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_message__Code_messagerie')), false, true);

        }

    }
    elseif ($mf_action=='modifier_message__Code_joueur')
    {

        $message = $table_message->mf_get($Code_message, array( 'autocompletion' => true ));
        if (isset($message['Code_message']))
        {

            $form = new Formulaire('', $mess);
            if (!isset($est_charge['joueur']))
            {
                $form->ajouter_select(lister_cles($lang_standard['Code_joueur_']), "Code_joueur", ( isset($_POST['Code_joueur']) ? $_POST['Code_joueur'] : $message['Code_joueur'] ), true);
            }

            $code_html.=recuperer_gabarit('message/form_edit__Code_joueur.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_message__Code_joueur')), false, true);

        }

    }
    elseif ($mf_action=="supprimer_message")
    {

        $message = $table_message->mf_get($Code_message, array( 'autocompletion' => true ));
        if ( isset($message['Code_message']) )
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_select(array(0, 1), 'Supprimer', FORM_SUPPR_DEFAUT, true);
            $form->activer_picto_suppression();

            $code_html.=recuperer_gabarit('message/form_delete_message.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_delete_message')), false, true);

        }

    }

