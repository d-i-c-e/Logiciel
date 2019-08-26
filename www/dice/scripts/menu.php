<?php

$pages_menu=array();

$pages_menu['Mon menu'][]=array( 'adresse' => 'joueur.php', 'nom' => 'joueur' );
$pages_menu['Mon menu'][]=array( 'adresse' => 'groupe.php', 'nom' => 'groupe' );
$pages_menu['Mon menu'][]=array( 'adresse' => 'personnage.php', 'nom' => 'personnage' );

$pages_menu['Paramétrage'][]=array( 'adresse' => 'campagne.php', 'nom' => 'Campagne' );
$pages_menu['Paramétrage'][]=array( 'adresse' => 'parametre.php', 'nom' => 'Paramètre' );
// $pages_menu['Mon menu'][]=array( 'adresse' => 'parametre_valeur.php', 'nom' => 'parametre_valeur' );
$pages_menu['Paramétrage'][]=array( 'adresse' => 'ressource.php', 'nom' => 'Ressources' );
// $pages_menu['Mon menu'][]=array( 'adresse' => 'objet.php', 'nom' => 'objet' );
// $pages_menu['Mon menu'][]=array( 'adresse' => 'type.php', 'nom' => 'type' );
// $pages_menu['Paramétrage'][]=array( 'adresse' => 'messagerie.php', 'nom' => 'Messagerie' );
// $pages_menu['Paramétrage'][]=array( 'adresse' => 'liste_contacts.php', 'nom' => 'Liste de contact' );

// $pages_menu['Mon menu'][]=array( 'adresse' => 'message.php', 'nom' => 'message' );
// $pages_menu['Mon menu'][]=array( 'adresse' => 'carte.php', 'nom' => 'carte' );
// $pages_menu['Mon menu'][]=array( 'adresse' => 'a_joueur_parametre.php', 'nom' => 'a_joueur_parametre' );
// $pages_menu['Mon menu'][]=array( 'adresse' => 'a_candidature_joueur_groupe.php', 'nom' => 'a_candidature_joueur_groupe' );
// $pages_menu['Mon menu'][]=array( 'adresse' => 'a_membre_joueur_groupe.php', 'nom' => 'a_membre_joueur_groupe' );
// $pages_menu['Mon menu'][]=array( 'adresse' => 'a_invitation_joueur_groupe.php', 'nom' => 'a_invitation_joueur_groupe' );
// $pages_menu['Mon menu'][]=array( 'adresse' => 'a_carte_objet.php', 'nom' => 'a_carte_objet' );
// $pages_menu['Mon menu'][]=array( 'adresse' => 'a_liste_contact_joueur.php', 'nom' => 'a_liste_contact_joueur' );

/* Tag des éléments (campagne / ressource) */
$pages_menu['Tags'][]=array( 'adresse' => 'tag_campagne.php', 'nom' => 'Tags des campagnes' );
// $pages_menu['Mon menu'][]=array( 'adresse' => 'a_campagne_tag_campagne.php', 'nom' => 'a_campagne_tag_campagne' );
$pages_menu['Tags'][]=array( 'adresse' => 'tag_ressource.php', 'nom' => 'Tags des ressources' );
// $pages_menu['Mon menu'][]=array( 'adresse' => 'a_ressource_tag_ressource.php', 'nom' => 'a_ressource_tag_ressource' );

function generer_menu_principal()
{
    global $pages_menu, $fil_ariane;
    $code_menu = '<nav><ul id="navigation">';
    foreach ( $pages_menu as $rubrique => $liste )
    {
        $code_menu.= '<li><span class="categorie_menu">'.$rubrique.'</span><ul>';
        foreach ( $liste as $value )
        {
            $code_menu.= '<li class="'.(get_nom_page_courante()==$value['adresse'] ? 'active' : '').'"><a href="'.$value['adresse'].'">'.htmlspecialchars($value['nom']).'</a></li>';
            if ( get_nom_page_courante()==$value['adresse'] )
            {
                $fil_ariane->ajouter_titre( $value['nom'], $value['adresse'] );
            }
        }
        $code_menu.= '</ul></li>';
    }
    $code_menu.= '</ul></nav>';
    return $code_menu;
}

function generer_menu_principal_bootstrap()
{
    global $pages_menu, $fil_ariane;
    $code_menu = '';
    $code_menu.= '<ul class="nav navbar-nav">';
    foreach ( $pages_menu as $rubrique => $liste )
    {
        if ( count($liste)>1 )
        {
            $active = false;
            foreach ( $liste as $value )
            {
                if (get_nom_page_courante()==$value['adresse'])
                {
                    $active = true;
                }
            }
            $code_menu.= '<li class="dropdown'.( $active ? ' active' : '' ).'">';
            $code_menu.= '<a class="dropdown-toggle" data-toggle="dropdown" href="#">'.htmlspecialchars($rubrique).'<span class="caret"></span></a>';
            $code_menu.= '<ul class="dropdown-menu">';
        }
        foreach ( $liste as $value )
        {
            $code_menu.= '<li class="'.(get_nom_page_courante()==$value['adresse'] ? 'active' : '').'"><a href="'.$value['adresse'].'">'.htmlspecialchars($value['nom']).'</a></li>';
            if ( get_nom_page_courante()==$value['adresse'] )
            {
                $fil_ariane->ajouter_titre( $value['nom'], $value['adresse'] );
            }
        }
        if ( count($liste)>1 )
        {
            $code_menu.= '</ul>';
            $code_menu.= '</li>';
        }
    }
    $code_menu.= '</ul>';
    $code_menu.= '<ul class="nav navbar-nav navbar-right">';
    if ( isset($_SESSION[PREFIXE_SESSION]['token']) ) {
        $db = new DB();
        $code_menu.= '<li class="dropdown">';
        $code_menu.= '<a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-user"></span> ' . htmlspecialchars(get_titre_ligne_table('joueur', get_joueur_courant())) . ( get_instance()!=0 ? ' <i>' . htmlspecialchars( '(' . get_titre_ligne_table(TABLE_INSTANCE, $db -> mf_table(TABLE_INSTANCE) -> mf_get_2(get_instance()) ) . ')' ) . '</i>' : '' ) . '<span class="caret"></span></a>';
        $code_menu.= '<ul class="dropdown-menu">';
        $code_menu.= '<li><a href=joueur.php?act=apercu_joueur&Code_joueur='.get_joueur_courant('Code_joueur').'><span class="glyphicon glyphicon-cog"></span> Mon compte</a></li>';
        $code_menu.= '<li><a href="?act=deconnexion"><span class="glyphicon glyphicon-log-out"></span> Déconnexion</a></li>';
        $code_menu.= '<li><a href="#" onclick="Fullscreen();"><span class="glyphicon glyphicon-fullscreen"></span> Page en pleine écran</a>';
        $code_menu.= '<li><a href="?act=vider_cache"><span class="glyphicon glyphicon-flash"></span> Vider le cache</a></li>';
        $code_menu.= '</ul>';
        $code_menu.= '</li>';
    }
    $code_menu.= '<script>';
    $code_menu.= 'var mode_full_screen=false;';
    $code_menu.= 'function Fullscreen() {
      var elem = document.documentElement;
      if (mode_full_screen)
      {
        if (elem.requestFullscreen) {
          document.exitFullscreen();
        } else if (elem.webkitRequestFullscreen) {
          document.webkitExitFullscreen();
        } else if (elem.mozRequestFullScreen) {
          document.mozCancelFullScreen();
        } else if (elem.msRequestFullscreen) {
          document.msExitFullscreen();
        }
        mode_full_screen = false;
      }
      else
      {
        if (elem.requestFullscreen) {
          elem.requestFullscreen();
        } else if (elem.msRequestFullscreen) {
          elem.msRequestFullscreen();
        } else if (elem.mozRequestFullScreen) {
          elem.mozRequestFullScreen();
        } else if (elem.webkitRequestFullscreen) {
          elem.webkitRequestFullscreen();
        }
        mode_full_screen = true;
      }
    }';
    $code_menu.= '</script>';
    $code_menu.= '</li>';
    $code_menu.= '</ul>';
    return $code_menu;
}

function generer_menu_bandeau()
{
    global $pages_menu;
    $l = [1=>12, 2=>6, 3=>4, 4=>3];
    $c = count($pages_menu);
    $n = ( isset($l[$c]) ? $l[$c] : 2 );
    $code_menu = '';
    $code_menu.= '<div class="row">';
    foreach ( $pages_menu as $rubrique => $liste )
    {
        $code_menu.= '<div class="col-sm-'.$n.'">'.htmlspecialchars($rubrique).'<ul>';
        foreach ( $liste as $value )
        {
            $code_menu.= '<li><a href="'.$value['adresse'].'">'.htmlspecialchars($value['nom']).'</a></li>';
        }
        $code_menu.= '</ul></div>';
    }
    $code_menu.= '</div>';
    return $code_menu;
}
if (USE_BOOTSTRAP) echo generer_menu_principal_bootstrap(); else  echo generer_menu_principal();
