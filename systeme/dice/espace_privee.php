<?php

include __DIR__ . '/dblayer.php';

$mf_connexion = new Mf_Connexion();
$menu_a_droite = new Menu_a_droite();
$fil_ariane = new Fil_Ariane('Accueil', '');
$trans = array();

if (isset($_GET['act'])) { $mf_action = $_GET['act']; } else { $mf_action = ''; }
$mdp_oublie = isset($_GET['mdp_oublie']) ? $_GET['mdp_oublie'] : 0 ;

/*
 +-------------+
 |  connexion  |
 +-------------+
 */

$mess_2 = '';
if ( $mf_action=='connexion' && isset($_POST['validation_formulaire']) && $mdp_oublie==0 )
{
    if ( ACTIVER_CONNEXION_EMAIL )
    {
        $mf_connexion_login_email = $_POST['mf_connexion_login_email'];
    }
    else
    {
        $mf_connexion_login_email = $_POST['mf_connexion_login'];
    }
    $mf_connexion_mdp = $_POST['mf_connexion_mdp'];
    if ( $token = $mf_connexion->connexion($mf_connexion_login_email, $mf_connexion_mdp) )
    {
        $_SESSION[PREFIXE_SESSION]['token'] = $token;
    }
    else
    {
        $mess_2 = 'Erreur dans vos informations d\'identification';
    }
}

/*
 +-------------------------------------+
 |  regénérer un nouveau mot de passe  |
 +-------------------------------------+
 */

if ( $mf_action=='connexion' && isset($_POST['validation_formulaire']) && $mdp_oublie==1 )
{
    if ( ACTIVER_CONNEXION_EMAIL )
    {
        $mf_connexion_email = $_POST['mf_connexion_email'];
        if ( $mf_connexion->regenerer_mot_de_passe_email($mf_connexion_email)['code_erreur']==0 )
        {
            $mess_2 = 'Une procédure de réinitialisation de mot de passe vous a été envoyée par email.';
            $mdp_oublie = 0;
        }
        else
        {
            $mess_2 = 'Vous n\'avez pas été reconnu';
        }
    }
    else
    {
        $mf_connexion_login = $_POST['mf_connexion_login'];
        $mf_connexion_email = $_POST['mf_connexion_email'];
        if ( $mf_connexion->regenerer_mot_de_passe($mf_connexion_login, $mf_connexion_email)['code_erreur']==0 )
        {
            $mess_2 = 'Une procédure de réinitialisation de mot de passe vous a été envoyée par email.';
            $mdp_oublie = 0;
        }
        else
        {
            $mess_2 = 'Vous n\'avez pas été reconnu';
        }
    }
    $cache = new Cachehtml();
    $cache->clear();
}

/*
 +-----------------------------------+
 |  Inscription d'un nouveau compte  |
 +-----------------------------------+
 */

$mess_3 = '';
if ( ACTIVER_FORMULAIRE_INSCRIPTION && $mf_action=='inscription' && isset($_POST['validation_formulaire']) )
{
    $mf_inscription_login = $_POST['mf_inscription_login'];
    $mf_inscription_mdp = $_POST['mf_inscription_mdp'];
    $mf_inscription_mdp_conf = $_POST['mf_inscription_mdp_conf'];
    $mf_inscription_email = $_POST['mf_inscription_email'];
    $mf_inscription_email_conf = $_POST['mf_inscription_email_conf'];
    if ( TABLE_INSTANCE != '' ) // si une instance est paramétrée, alors, la création correspond à la création d'une nouvelle instance.
    {
        new_instance();
        $mf_connexion = new Mf_Connexion(); // La nouvelle instance doit être chargée
    }
    $code_erreur = $mf_connexion->inscription($mf_inscription_login, $mf_inscription_mdp, $mf_inscription_mdp_conf, $mf_inscription_email, $mf_inscription_email_conf)['code_erreur'];
    if ( $code_erreur==0 )
    {
        $mess_3 = 'Votre inscription à bien été prise en compte.';
        $mdp_oublie = 0;
        // tentative de connexion
        if ( $token = $mf_connexion->connexion($mf_inscription_login, $mf_inscription_mdp) )
        {
            $_SESSION[PREFIXE_SESSION]['token'] = $token;
        }
    }
    else
    {
        $mess_3 = ( (isset($mf_libelle_erreur[$code_erreur]) ? $mf_libelle_erreur[$code_erreur] : 'ERREUR N_'.$code_erreur ) );
    }
    $cache = new Cachehtml();
    $cache->clear();
}

/*
 +---------------+
 |  deconnexion  |
 +---------------+
 */

if ( $mf_action=='deconnexion' )
{
    if (isset($_SESSION[PREFIXE_SESSION]['token']))
    {
        $token = $_SESSION[PREFIXE_SESSION]['token'];
        $mf_connexion->deconnexion($token);
    }
}

/*
 +-------------------+
 |  test si connect  |
 +-------------------+
 */

if (isset($_SESSION[PREFIXE_SESSION]['token']))
{
    if ( ! $mf_connexion->est_connecte($_SESSION[PREFIXE_SESSION]['token']) )
    {
        unset($_SESSION[PREFIXE_SESSION]['token']);
    }
}

session_write_close();

if ( ! isset($_SESSION[PREFIXE_SESSION]['token']) )
{

    $cache = new Cachehtml();

    if ( !$cache->start('connexion') )
    {

        ob_start(); include 'scripts/css.php'; $css = ob_get_clean();
        ob_start(); include 'scripts/js.php'; $js = ob_get_clean();
        ob_start(); include 'scripts/menu.php'; $menu = ob_get_clean();

        $mess = ( (isset($retour) && $retour['code_erreur']>0) ? (isset($mf_libelle_erreur[$retour['code_erreur']]) ? $mf_libelle_erreur[$retour['code_erreur']] : 'ERREUR N_'.$retour['code_erreur'] ) : '' );
        if ($mess_2!='')
        {
            $mess = $mess_2;
        }

        $code_html='';

        $fil_ariane = new Fil_Ariane('ESPACE PRIVE', '');

        if ( $mdp_oublie==1 )
        {
            $form = new Formulaire('', $mess);
            if ( ACTIVER_CONNEXION_EMAIL )
            {
                $form->ajouter_input('mf_connexion_email', isset($_POST['mf_connexion_email']) ? $_POST['mf_connexion_email'] : '', true, 'text');
            }
            else
            {
                $form->ajouter_input('mf_connexion_login', isset($_POST['mf_connexion_login']) ? $_POST['mf_connexion_login'] : '', true, 'text');
                $form->ajouter_input('mf_connexion_email', isset($_POST['mf_connexion_email']) ? $_POST['mf_connexion_email'] : '', true, 'text');
            }
            if ( TABLE_INSTANCE != '' )
            {
                $liste_instance = $db->mf_table(TABLE_INSTANCE)->mf_lister();
                foreach ($liste_instance as $key => $instance)
                {
                    $lang_standard['mf_instance_'][$key] = get_titre_ligne_table('__instance', $instance);
                }
                $form->ajouter_select(lister_cles($liste_instance), 'mf_instance', get_instance(), false);
            }
            $form->set_action('?act=connexion&mdp_oublie=1');
            $form->set_libelle_bouton(get_nom_colonne('mv_validation_form_nouveau_mdp'));
            $form->activer_picto_forget_password();
            $form->desactiver_le_mode_inline();
            $code_html.=$form->generer_BS4_Forms().'<p style="text-align: center; margin-top: 40px; font-style: italic;"><a style="text-decoration: none; color: gray;" href="?mdp_oublie=0">'.get_nom_colonne('mv_lien_vers_connexion').'</a></p>';
        }
        else
        {
            $form = new Formulaire('', $mess);
            if ( ACTIVER_CONNEXION_EMAIL )
            {
                $form->ajouter_input('mf_connexion_login_email', '', true, 'text');
            }
            else
            {
                $form->ajouter_input('mf_connexion_login', '', true, 'text');
            }
            $form->ajouter_input('mf_connexion_mdp', '', true, 'password');
            if ( TABLE_INSTANCE != '' )
            {
                $liste_instance = $db->mf_table(TABLE_INSTANCE)->mf_lister();
                foreach ($liste_instance as $key => $instance)
                {
                    $lang_standard['mf_instance_'][$key] = get_titre_ligne_table('__instance', $instance);
                }
                $form->ajouter_select(lister_cles($liste_instance), 'mf_instance', get_instance(), false);
            }
            $form->set_action('?act=connexion');
            $form->set_libelle_bouton(get_nom_colonne('mv_validation_form_connexion'));
            $form->activer_picto_connexion();
            $form->desactiver_le_mode_inline();
            $code_html.=$form->generer_BS4_Forms().'<p style="text-align: center; margin-top: 40px; font-style: italic;"><a style="text-decoration: none; color: gray;" href="?mdp_oublie=1">'.get_nom_colonne('mv_lien_vers_nouveau_mdp').'</a></p>';
        }

        $code_html_formulaire_inscription = '';
        if ( ACTIVER_FORMULAIRE_INSCRIPTION )
        {
            $form = new Formulaire('', $mess_3);
            $form->ajouter_input('mf_inscription_login', ( isset($_POST['mf_inscription_login']) ? $_POST['mf_inscription_login'] : '' ), true, 'text');
            $form->ajouter_input('mf_inscription_mdp', ( isset($_POST['mf_inscription_mdp']) ? $_POST['mf_inscription_mdp'] : '' ), true, 'password');
            $form->ajouter_input('mf_inscription_mdp_conf', ( isset($_POST['mf_inscription_mdp_conf']) ? $_POST['mf_inscription_mdp_conf'] : '' ), true, 'password');
            $form->ajouter_input('mf_inscription_email', ( isset($_POST['mf_inscription_email']) ? $_POST['mf_inscription_email'] : '' ), true, 'email');
            $form->ajouter_input('mf_inscription_email_conf', ( isset($_POST['mf_inscription_email_conf']) ? $_POST['mf_inscription_email_conf'] : '' ), true, 'email');
            $form->set_action('?act=inscription');
            $form->set_libelle_bouton(get_nom_colonne('mv_validation_form_inscription'));
            $form->activer_picto_connexion();
            $form->desactiver_le_mode_inline();
            $code_html_formulaire_inscription = $form->generer_BS4_Forms();
        }

        echo recuperer_gabarit('main/page_connexion.html', array(
            '{titre_page}' => 'Connexion',
            '{css}' => $css,
            '{js}' => $js,
            '{menu_principal}' => $menu,
            '{fil_ariane}' => $fil_ariane->generer_code(),
            '{sections}' => $code_html,
            '{formulaire_inscription}' => $code_html_formulaire_inscription,
            '{menu_secondaire}' => $menu_a_droite->generer_code(),
            '{script_end}' => generer_script_maj_auto(),
            '{header}' => recuperer_gabarit('main/header.html',array()),
            '{footer}' => recuperer_gabarit('main/footer.html',array())
        ), true);

        $cache->end();

    }

    fermeture_connexion_db();

    exit;

}

if ( $mf_action == 'vider_cache' )
{
    //cache
    if ( is_dir( __DIR__ . '/cache/' ) )
    {
        rrmdir( __DIR__ . '/cache/' );
    }
    //cache_systeme
    if ( is_dir( __DIR__ . '/cache_systeme/' ) )
    {
        rrmdir( __DIR__ . '/cache_systeme/' );
    }
    //tables/monframework/cache
    if ( is_dir( __DIR__ . '/tables/monframework/cache/' ) )
    {
        rrmdir( __DIR__ . '/tables/monframework/cache/' );
    }
    //tables/monframework/mf_connexion.sessions
    if ( is_dir( __DIR__ . '/tables/monframework/mf_connexion.sessions/' ) )
    {
        rrmdir( __DIR__ . '/tables/monframework/mf_connexion.sessions/' );
    }
    //tables/monframework/mf_connexion.sessions_api
    if ( is_dir( __DIR__ . '/tables/monframework/mf_connexion.sessions_api/' ) )
    {
        rrmdir( __DIR__ . '/tables/monframework/mf_connexion.sessions_api/' );
    }
    //tables/monframework/mf_connexion.new_pwd
    if ( is_dir( __DIR__ . '/tables/monframework/mf_connexion.new_pwd/' ) )
    {
        rrmdir( __DIR__ . '/tables/monframework/mf_connexion.new_pwd/' );
    }
    exit;
}

$cache = new Cachehtml( ( isset($joueur_courant['Code_joueur']) ? $joueur_courant['Code_joueur'] : 0 ) . '-' . mf_get_trace_session() );
$cache->activer_compression_html();

$menu_a_droite->set_texte_bouton_deconnexion(htmlspecialchars(get_titre_ligne_table('joueur', $joueur_courant)).', <i>déconnexion</i>');
