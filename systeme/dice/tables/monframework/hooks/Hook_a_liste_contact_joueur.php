<?php

class Hook_a_liste_contact_joueur{

    static function initialisation() // première instanciation
    {
        // ici le code
    }

    static function actualisation() // à chaque instanciation
    {
        // ici le code
    }

    static function pre_controller(string &$a_liste_contact_joueur_Date_creation, int $Code_liste_contacts, int $Code_joueur)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_ajouter(?int $Code_liste_contacts=null, ?int $Code_joueur=null)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['a_liste_contact_joueur__AJOUTER']
         * $mf_droits_defaut['a_liste_contact_joueur__CREER'] // actualisation uniquement pour l'affichage
         *
         */
        // ici le code
    }

    static function autorisation_ajout(string $a_liste_contact_joueur_Date_creation, int $Code_liste_contacts, int $Code_joueur)
    {
        return true;
    }

    static function data_controller(string &$a_liste_contact_joueur_Date_creation, int $Code_liste_contacts, int $Code_joueur)
    {
        // ici le code
    }

    static function ajouter(int $Code_liste_contacts, int $Code_joueur)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_modifier(?int $Code_liste_contacts=null, ?int $Code_joueur=null)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['a_liste_contact_joueur__MODIFIER']
         *
         * $mf_droits_defaut['api_modifier__a_liste_contact_joueur_Date_creation']
         *
         */
        // ici le code
    }

    static function autorisation_modification(int $Code_liste_contacts, int $Code_joueur, string $a_liste_contact_joueur_Date_creation__new)
    {
        return true;
    }

    static function data_controller__a_liste_contact_joueur_Date_creation(string $old, string &$new, int $Code_liste_contacts, int $Code_joueur)
    {
        // ici le code
    }

    /*
     * modifier : $Code_...,  permettent de se référer à la données modifiée
     * les autres paramètres booléens ($modif...) permettent d'identifier les champs qui ont été modifiés
     */
    static function modifier(int $Code_liste_contacts, int $Code_joueur, bool $bool__a_liste_contact_joueur_Date_creation)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_supprimer(?int $Code_liste_contacts=null, ?int $Code_joueur=null)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['a_liste_contact_joueur__SUPPRIMER']
         *
         */
        // Ici le code
        if ($mf_droits_defaut['a_liste_contact_joueur__SUPPRIMER'])
        {
            // Ici le code
        }
    }

    static function autorisation_suppression(int $Code_liste_contacts, int $Code_joueur)
    {
        return true;
    }

    static function supprimer(array $copie__liste_a_liste_contact_joueur)
    {
        // ici le code
    }

    static function completion(array &$donnees)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_liste_contacts']
         * $donnees['Code_joueur']
         * $donnees['a_liste_contact_joueur_Date_creation']
         */
        // ici le code
    }

    // API callbacks
    // -------------------

    static function callback_post(int $Code_liste_contacts, int $Code_joueur)
    {
        return null;
    }

    static function callback_put(int $Code_liste_contacts, int $Code_joueur)
    {
        return null;
    }

}
