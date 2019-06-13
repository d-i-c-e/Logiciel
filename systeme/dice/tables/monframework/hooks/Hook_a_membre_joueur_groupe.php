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

    static function pre_controller(&$a_membre_joueur_groupe_Surnom, &$a_membre_joueur_groupe_Grade, &$a_membre_joueur_groupe_Date_adhesion, $Code_groupe, $Code_joueur)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_ajouter($Code_groupe=0, $Code_joueur=0)
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

    static function autorisation_ajout($a_membre_joueur_groupe_Surnom, $a_membre_joueur_groupe_Grade, $a_membre_joueur_groupe_Date_adhesion, $Code_groupe, $Code_joueur)
    {
        return true;
    }

    static function data_controller(&$a_membre_joueur_groupe_Surnom, &$a_membre_joueur_groupe_Grade, &$a_membre_joueur_groupe_Date_adhesion, $Code_groupe, $Code_joueur)
    {
        // ici le code
    }

    static function ajouter($Code_groupe, $Code_joueur)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_modifier($Code_groupe=0, $Code_joueur=0)
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

    static function autorisation_modification($Code_groupe, $Code_joueur, $a_membre_joueur_groupe_Surnom__new, $a_membre_joueur_groupe_Grade__new, $a_membre_joueur_groupe_Date_adhesion__new)
    {
        return true;
    }

    static function data_controller__a_membre_joueur_groupe_Surnom($old, &$new, $Code_groupe, $Code_joueur)
    {
        // ici le code
    }

    static function data_controller__a_membre_joueur_groupe_Grade($old, &$new, $Code_groupe, $Code_joueur)
    {
        // ici le code
    }

    static function data_controller__a_membre_joueur_groupe_Date_adhesion($old, &$new, $Code_groupe, $Code_joueur)
    {
        // ici le code
    }

    /*
     * modifier : $Code_...,  permettent de se référer à la données modifiée
     * les autres paramètres booléens ($modif...) permettent d'identifier les champs qui ont été modifiés
     */
    static function modifier($Code_groupe, $Code_joueur, $bool__a_membre_joueur_groupe_Surnom, $bool__a_membre_joueur_groupe_Grade, $bool__a_membre_joueur_groupe_Date_adhesion)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_supprimer($Code_groupe=0, $Code_joueur=0)
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

    static function autorisation_suppression($Code_groupe, $Code_joueur)
    {
        return true;
    }

    static function supprimer($copie__liste_a_membre_joueur_groupe)
    {
        // ici le code
    }

    static function completion(&$donnees)
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

    static function callback_post($Code_groupe, $Code_joueur)
    {
        return null;
    }

    static function callback_put($Code_groupe, $Code_joueur)
    {
        return null;
    }

}
