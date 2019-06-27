<?php

/*
    +------------------------------+
    |  NE PAS MODIFIER CE FICHIER  |
    +------------------------------+
*/

class DB
{

    private $joueur=null;
    private $message=null;
    private $parametre=null;
    private $groupe=null;
    private $personnage=null;
    private $campagne=null;
    private $tag_campagne=null;
    private $carte=null;
    private $objet=null;
    private $type=null;
    private $ressource=null;
    private $tag_ressource=null;
    private $messagerie=null;
    private $liste_contacts=null;
    private $parametre_valeur=null;
    private $a_joueur_parametre=null;
    private $a_candidature_joueur_groupe=null;
    private $a_membre_joueur_groupe=null;
    private $a_invitation_joueur_groupe=null;
    private $a_carte_objet=null;
    private $a_campagne_tag_campagne=null;
    private $a_ressource_tag_ressource=null;
    private $a_liste_contact_joueur=null;

    function __construct() {}

    function joueur() { if ( $this->joueur==null ) { $this->joueur = new joueur(); } return $this->joueur; }
    function message() { if ( $this->message==null ) { $this->message = new message(); } return $this->message; }
    function parametre() { if ( $this->parametre==null ) { $this->parametre = new parametre(); } return $this->parametre; }
    function groupe() { if ( $this->groupe==null ) { $this->groupe = new groupe(); } return $this->groupe; }
    function personnage() { if ( $this->personnage==null ) { $this->personnage = new personnage(); } return $this->personnage; }
    function campagne() { if ( $this->campagne==null ) { $this->campagne = new campagne(); } return $this->campagne; }
    function tag_campagne() { if ( $this->tag_campagne==null ) { $this->tag_campagne = new tag_campagne(); } return $this->tag_campagne; }
    function carte() { if ( $this->carte==null ) { $this->carte = new carte(); } return $this->carte; }
    function objet() { if ( $this->objet==null ) { $this->objet = new objet(); } return $this->objet; }
    function type() { if ( $this->type==null ) { $this->type = new type(); } return $this->type; }
    function ressource() { if ( $this->ressource==null ) { $this->ressource = new ressource(); } return $this->ressource; }
    function tag_ressource() { if ( $this->tag_ressource==null ) { $this->tag_ressource = new tag_ressource(); } return $this->tag_ressource; }
    function messagerie() { if ( $this->messagerie==null ) { $this->messagerie = new messagerie(); } return $this->messagerie; }
    function liste_contacts() { if ( $this->liste_contacts==null ) { $this->liste_contacts = new liste_contacts(); } return $this->liste_contacts; }
    function parametre_valeur() { if ( $this->parametre_valeur==null ) { $this->parametre_valeur = new parametre_valeur(); } return $this->parametre_valeur; }
    function a_joueur_parametre() { if ( $this->a_joueur_parametre==null ) { $this->a_joueur_parametre = new a_joueur_parametre(); } return $this->a_joueur_parametre; }
    function a_candidature_joueur_groupe() { if ( $this->a_candidature_joueur_groupe==null ) { $this->a_candidature_joueur_groupe = new a_candidature_joueur_groupe(); } return $this->a_candidature_joueur_groupe; }
    function a_membre_joueur_groupe() { if ( $this->a_membre_joueur_groupe==null ) { $this->a_membre_joueur_groupe = new a_membre_joueur_groupe(); } return $this->a_membre_joueur_groupe; }
    function a_invitation_joueur_groupe() { if ( $this->a_invitation_joueur_groupe==null ) { $this->a_invitation_joueur_groupe = new a_invitation_joueur_groupe(); } return $this->a_invitation_joueur_groupe; }
    function a_carte_objet() { if ( $this->a_carte_objet==null ) { $this->a_carte_objet = new a_carte_objet(); } return $this->a_carte_objet; }
    function a_campagne_tag_campagne() { if ( $this->a_campagne_tag_campagne==null ) { $this->a_campagne_tag_campagne = new a_campagne_tag_campagne(); } return $this->a_campagne_tag_campagne; }
    function a_ressource_tag_ressource() { if ( $this->a_ressource_tag_ressource==null ) { $this->a_ressource_tag_ressource = new a_ressource_tag_ressource(); } return $this->a_ressource_tag_ressource; }
    function a_liste_contact_joueur() { if ( $this->a_liste_contact_joueur==null ) { $this->a_liste_contact_joueur = new a_liste_contact_joueur(); } return $this->a_liste_contact_joueur; }

    static function mf_raz_instance() {
        joueur::mf_raz_instance();
        message::mf_raz_instance();
        parametre::mf_raz_instance();
        groupe::mf_raz_instance();
        personnage::mf_raz_instance();
        campagne::mf_raz_instance();
        tag_campagne::mf_raz_instance();
        carte::mf_raz_instance();
        objet::mf_raz_instance();
        type::mf_raz_instance();
        ressource::mf_raz_instance();
        tag_ressource::mf_raz_instance();
        messagerie::mf_raz_instance();
        liste_contacts::mf_raz_instance();
        parametre_valeur::mf_raz_instance();
        a_joueur_parametre::mf_raz_instance();
        a_candidature_joueur_groupe::mf_raz_instance();
        a_membre_joueur_groupe::mf_raz_instance();
        a_invitation_joueur_groupe::mf_raz_instance();
        a_carte_objet::mf_raz_instance();
        a_campagne_tag_campagne::mf_raz_instance();
        a_ressource_tag_ressource::mf_raz_instance();
        a_liste_contact_joueur::mf_raz_instance();
    }

    function mf_table($nom_table) {
        switch ($nom_table) {
            case 'joueur': return $this->joueur(); break;
            case 'message': return $this->message(); break;
            case 'parametre': return $this->parametre(); break;
            case 'groupe': return $this->groupe(); break;
            case 'personnage': return $this->personnage(); break;
            case 'campagne': return $this->campagne(); break;
            case 'tag_campagne': return $this->tag_campagne(); break;
            case 'carte': return $this->carte(); break;
            case 'objet': return $this->objet(); break;
            case 'type': return $this->type(); break;
            case 'ressource': return $this->ressource(); break;
            case 'tag_ressource': return $this->tag_ressource(); break;
            case 'messagerie': return $this->messagerie(); break;
            case 'liste_contacts': return $this->liste_contacts(); break;
            case 'parametre_valeur': return $this->parametre_valeur(); break;
            case 'a_joueur_parametre': return $this->a_joueur_parametre(); break;
            case 'a_candidature_joueur_groupe': return $this->a_candidature_joueur_groupe(); break;
            case 'a_membre_joueur_groupe': return $this->a_membre_joueur_groupe(); break;
            case 'a_invitation_joueur_groupe': return $this->a_invitation_joueur_groupe(); break;
            case 'a_carte_objet': return $this->a_carte_objet(); break;
            case 'a_campagne_tag_campagne': return $this->a_campagne_tag_campagne(); break;
            case 'a_ressource_tag_ressource': return $this->a_ressource_tag_ressource(); break;
            case 'a_liste_contact_joueur': return $this->a_liste_contact_joueur(); break;
        }
    }

}
