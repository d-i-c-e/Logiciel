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

    static function pre_controller(&$a_liste_contact_joueur_Date_creation, $Code_liste_contacts, $Code_joueur)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_ajouter($Code_liste_contacts=0, $Code_joueur=0)
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

    static function autorisation_ajout($a_liste_contact_joueur_Date_creation, $Code_liste_contacts, $Code_joueur)
    {
        return true;
    }

    static function data_controller(&$a_liste_contact_joueur_Date_creation, $Code_liste_contacts, $Code_joueur)
    {
        // ici le code
    }

    static function ajouter($Code_liste_contacts, $Code_joueur)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_modifier($Code_liste_contacts=0, $Code_joueur=0)
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

    static function autorisation_modification($Code_liste_contacts, $Code_joueur, $a_liste_contact_joueur_Date_creation__new)
    {
        return true;
    }

    static function data_controller__a_liste_contact_joueur_Date_creation($old, &$new, $Code_liste_contacts, $Code_joueur)
    {
        // ici le code
    }

    /*
     * modifier : $Code_...,  permettent de se référer à la données modifiée
     * les autres paramètres booléens ($modif...) permettent d'identifier les champs qui ont été modifiés
     */
    static function modifier($Code_liste_contacts, $Code_joueur, $bool__a_liste_contact_joueur_Date_creation)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_supprimer($Code_liste_contacts=0, $Code_joueur=0)
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

    static function autorisation_suppression($Code_liste_contacts, $Code_joueur)
    {
        return true;
    }

    static function supprimer($copie__liste_a_liste_contact_joueur)
    {
        // ici le code
    }

    static function completion(&$donnees)
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

    static function callback_post($Code_liste_contacts, $Code_joueur)
    {
        return null;
    }

    static function callback_put($Code_liste_contacts, $Code_joueur)
    {
        return null;
    }

}
