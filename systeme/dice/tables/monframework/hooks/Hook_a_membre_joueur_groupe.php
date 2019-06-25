<?php

class Hook_a_membre_joueur_groupe{

    static function initialisation() // première instanciation
    {
        // ici le code
    }

    static function actualisation() // à chaque instanciation
    {
        // ici le code
    }

    static function pre_controller(string &$a_membre_joueur_groupe_Surnom, int &$a_membre_joueur_groupe_Grade, string &$a_membre_joueur_groupe_Date_adhesion, int $Code_groupe, int $Code_joueur)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_ajouter(?int $Code_groupe=null, ?int $Code_joueur=null)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['a_membre_joueur_groupe__AJOUTER']
         * $mf_droits_defaut['a_membre_joueur_groupe__CREER'] // actualisation uniquement pour l'affichage
         *
         */
        // ici le code
    }

    static function autorisation_ajout(string $a_membre_joueur_groupe_Surnom, int $a_membre_joueur_groupe_Grade, string $a_membre_joueur_groupe_Date_adhesion, int $Code_groupe, int $Code_joueur)
    {
        return true;
    }

    static function data_controller(string &$a_membre_joueur_groupe_Surnom, int &$a_membre_joueur_groupe_Grade, string &$a_membre_joueur_groupe_Date_adhesion, int $Code_groupe, int $Code_joueur)
    {
        // ici le code
    }

    static function ajouter(int $Code_groupe, int $Code_joueur)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_modifier(?int $Code_groupe=null, ?int $Code_joueur=null)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['a_membre_joueur_groupe__MODIFIER']
         *
         * $mf_droits_defaut['api_modifier__a_membre_joueur_groupe_Surnom']
         * $mf_droits_defaut['api_modifier__a_membre_joueur_groupe_Grade']
         * $mf_droits_defaut['api_modifier__a_membre_joueur_groupe_Date_adhesion']
         *
         */
        // ici le code
    }

    static function autorisation_modification(int $Code_groupe, int $Code_joueur, string $a_membre_joueur_groupe_Surnom__new, int $a_membre_joueur_groupe_Grade__new, string $a_membre_joueur_groupe_Date_adhesion__new)
    {
        return true;
    }

    static function data_controller__a_membre_joueur_groupe_Surnom(string $old, string &$new, int $Code_groupe, int $Code_joueur)
    {
        // ici le code
    }

    static function data_controller__a_membre_joueur_groupe_Grade(int $old, int &$new, int $Code_groupe, int $Code_joueur)
    {
        // ici le code
    }

    static function data_controller__a_membre_joueur_groupe_Date_adhesion(string $old, string &$new, int $Code_groupe, int $Code_joueur)
    {
        // ici le code
    }

    /*
     * modifier : $Code_...,  permettent de se référer à la données modifiée
     * les autres paramètres booléens ($modif...) permettent d'identifier les champs qui ont été modifiés
     */
    static function modifier(int $Code_groupe, int $Code_joueur, bool $bool__a_membre_joueur_groupe_Surnom, bool $bool__a_membre_joueur_groupe_Grade, bool $bool__a_membre_joueur_groupe_Date_adhesion)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_supprimer(?int $Code_groupe=null, ?int $Code_joueur=null)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['a_membre_joueur_groupe__SUPPRIMER']
         *
         */
        // Ici le code
        if ($mf_droits_defaut['a_membre_joueur_groupe__SUPPRIMER'])
        {
            // Ici le code
        }
    }

    static function autorisation_suppression(int $Code_groupe, int $Code_joueur)
    {
        return true;
    }

    static function supprimer(array $copie__liste_a_membre_joueur_groupe)
    {
        // ici le code
    }

    static function completion(array &$donnees)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_groupe']
         * $donnees['Code_joueur']
         * $donnees['a_membre_joueur_groupe_Surnom']
         * $donnees['a_membre_joueur_groupe_Grade']
         * $donnees['a_membre_joueur_groupe_Date_adhesion']
         */
        // ici le code
    }

    // API callbacks
    // -------------------

    static function callback_post(int $Code_groupe, int $Code_joueur)
    {
        return null;
    }

    static function callback_put(int $Code_groupe, int $Code_joueur)
    {
        return null;
    }

}
