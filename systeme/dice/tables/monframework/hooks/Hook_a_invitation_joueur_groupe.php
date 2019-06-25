<?php

class Hook_a_invitation_joueur_groupe{

    static function initialisation() // première instanciation
    {
        // ici le code
    }

    static function actualisation() // à chaque instanciation
    {
        // ici le code
    }

    static function pre_controller(string &$a_invitation_joueur_groupe_Message, string &$a_invitation_joueur_groupe_Date_envoi, int $Code_joueur, int $Code_groupe)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_ajouter(?int $Code_joueur=null, ?int $Code_groupe=null)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['a_invitation_joueur_groupe__AJOUTER']
         * $mf_droits_defaut['a_invitation_joueur_groupe__CREER'] // actualisation uniquement pour l'affichage
         *
         */
        // ici le code
    }

    static function autorisation_ajout(string $a_invitation_joueur_groupe_Message, string $a_invitation_joueur_groupe_Date_envoi, int $Code_joueur, int $Code_groupe)
    {
        return true;
    }

    static function data_controller(string &$a_invitation_joueur_groupe_Message, string &$a_invitation_joueur_groupe_Date_envoi, int $Code_joueur, int $Code_groupe)
    {
        // ici le code
    }

    static function ajouter(int $Code_joueur, int $Code_groupe)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_modifier(?int $Code_joueur=null, ?int $Code_groupe=null)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['a_invitation_joueur_groupe__MODIFIER']
         *
         * $mf_droits_defaut['api_modifier__a_invitation_joueur_groupe_Message']
         * $mf_droits_defaut['api_modifier__a_invitation_joueur_groupe_Date_envoi']
         *
         */
        // ici le code
    }

    static function autorisation_modification(int $Code_joueur, int $Code_groupe, string $a_invitation_joueur_groupe_Message__new, string $a_invitation_joueur_groupe_Date_envoi__new)
    {
        return true;
    }

    static function data_controller__a_invitation_joueur_groupe_Message(string $old, string &$new, int $Code_joueur, int $Code_groupe)
    {
        // ici le code
    }

    static function data_controller__a_invitation_joueur_groupe_Date_envoi(string $old, string &$new, int $Code_joueur, int $Code_groupe)
    {
        // ici le code
    }

    /*
     * modifier : $Code_...,  permettent de se référer à la données modifiée
     * les autres paramètres booléens ($modif...) permettent d'identifier les champs qui ont été modifiés
     */
    static function modifier(int $Code_joueur, int $Code_groupe, bool $bool__a_invitation_joueur_groupe_Message, bool $bool__a_invitation_joueur_groupe_Date_envoi)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_supprimer(?int $Code_joueur=null, ?int $Code_groupe=null)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['a_invitation_joueur_groupe__SUPPRIMER']
         *
         */
        // Ici le code
        if ($mf_droits_defaut['a_invitation_joueur_groupe__SUPPRIMER'])
        {
            // Ici le code
        }
    }

    static function autorisation_suppression(int $Code_joueur, int $Code_groupe)
    {
        return true;
    }

    static function supprimer(array $copie__liste_a_invitation_joueur_groupe)
    {
        // ici le code
    }

    static function completion(array &$donnees)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_joueur']
         * $donnees['Code_groupe']
         * $donnees['a_invitation_joueur_groupe_Message']
         * $donnees['a_invitation_joueur_groupe_Date_envoi']
         */
        // ici le code
    }

    // API callbacks
    // -------------------

    static function callback_post(int $Code_joueur, int $Code_groupe)
    {
        return null;
    }

    static function callback_put(int $Code_joueur, int $Code_groupe)
    {
        return null;
    }

}
