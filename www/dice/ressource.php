<?php

include __DIR__ . '/../../systeme/dice/espace_privee.php';

if ( !$cache->start() )
{

    /* Chargement des tables */
        $table_ressource = new ressource();
        $table_tag_ressource = new a_ressource_tag_ressource();
        $table_type = new type();
        $table_objet = new objet();

    require __DIR__ . '/scripts/lecture_parametres.php';

    /* Chargement des actions */
        include __DIR__ . '/code/_ressource_actions.php';
        include __DIR__ . '/code/_a_ressource_tag_ressource_actions.php';
        include __DIR__ . '/code/_type_actions.php';
        include __DIR__ . '/code/_objet_actions.php';

    require __DIR__ . '/scripts/genealogie.php';

    ob_start(); include __DIR__ . '/scripts/css.php'; $css = ob_get_clean();
    ob_start(); include __DIR__ . '/scripts/js.php'; $js = ob_get_clean();
    ob_start(); include __DIR__ . '/scripts/menu.php'; $menu = ob_get_clean();

    $mess = ( (isset($retour) && $retour['code_erreur']>0) ? (isset($mf_libelle_erreur[$retour['code_erreur']]) ? $mf_libelle_erreur[$retour['code_erreur']] : 'ERREUR N_'.$retour['code_erreur'] ) : '' );

    $code_html = '';
    /* Chargement des forms */
        include __DIR__ . '/code/_ressource_form.php';
        if (mf_Code_ressource()) {
            include __DIR__ . '/code/_a_ressource_tag_ressource_form.php';
            include __DIR__ . '/code/_type_form.php';
            if (mf_Code_type()) {
                include __DIR__ . '/code/_objet_form.php';
            }
        }

    $menu_a_droite->ajouter_bouton_deconnexion();

    echo recuperer_gabarit('main/page.html', array(
            '{titre_page}' => 'ressource',
            '{css}' => $css,
            '{js}' => $js,
            '{menu_principal}' => $menu,
            '{fil_ariane}' => $fil_ariane->generer_code(),
            '{sections}' => $code_html,
            '{menu_secondaire}' => $menu_a_droite->generer_code(),
            '{script_end}' => generer_script_maj_auto(),
            '{header}' => recuperer_gabarit('main/header.html',array()),
            '{footer}' => recuperer_gabarit('main/footer.html',array())
    ), true);

    if (!test_action_formulaire())
    {
        $cache->end();
    }
    elseif (!MODE_PROD)
    {
        mise_a_jour_fichier_developpeur();
    }

}

fermeture_connexion_db();
