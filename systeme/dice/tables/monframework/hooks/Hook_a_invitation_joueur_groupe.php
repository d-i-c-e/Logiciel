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

    static function pre_controller(&$a_invitation_joueur_groupe_Message, &$a_invitation_joueur_groupe_Date_envoi, $Code_joueur, $Code_groupe)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_ajouter($Code_joueur=0, $Code_groupe=0)
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

    static function autorisation_ajout($a_invitation_joueur_groupe_Message, $a_invitation_joueur_groupe_Date_envoi, $Code_joueur, $Code_groupe)
    {
        return true;
    }

    static function data_controller(&$a_invitation_joueur_groupe_Message, &$a_invitation_joueur_groupe_Date_envoi, $Code_joueur, $Code_groupe)
    {
        // ici le code
    }

    static function ajouter($Code_joueur, $Code_groupe)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_modifier($Code_joueur=0, $Code_groupe=0)
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

    static function autorisation_modification($Code_joueur, $Code_groupe, $a_invitation_joueur_groupe_Message__new, $a_invitation_joueur_groupe_Date_envoi__new)
    {
        return true;
    }

    static function data_controller__a_invitation_joueur_groupe_Message($old, &$new, $Code_joueur, $Code_groupe)
    {
        // ici le code
    }

    static function data_controller__a_invitation_joueur_groupe_Date_envoi($old, &$new, $Code_joueur, $Code_groupe)
    {
        // ici le code
    }

    /*
     * modifier : $Code_...,  permettent de se référer à la données modifiée
     * les autres paramètres booléens ($modif...) permettent d'identifier les champs qui ont été modifiés
     */
    static function modifier($Code_joueur, $Code_groupe, $bool__a_invitation_joueur_groupe_Message, $bool__a_invitation_joueur_groupe_Date_envoi)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_supprimer($Code_joueur=0, $Code_groupe=0)
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

    static function autorisation_suppression($Code_joueur, $Code_groupe)
    {
        return true;
    }

    static function supprimer($copie__liste_a_invitation_joueur_groupe)
    {
        // ici le code
    }

    static function completion(&$donnees)
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

    static function callback_post($Code_joueur, $Code_groupe)
    {
        return null;
    }

    static function callback_put($Code_joueur, $Code_groupe)
    {
        return null;
    }

}
