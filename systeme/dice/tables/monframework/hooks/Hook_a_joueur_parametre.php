<?php

class Hook_a_joueur_parametre{

    static function initialisation() // première instanciation
    {
        // ici le code
    }

    static function actualisation() // à chaque instanciation
    {
        // ici le code
    }

    static function pre_controller($Code_joueur, $Code_parametre)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_ajouter($Code_joueur=0, $Code_parametre=0)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['a_joueur_parametre__AJOUTER']
         * $mf_droits_defaut['a_joueur_parametre__CREER'] // actualisation uniquement pour l'affichage
         *
         */
        // ici le code
    }

    static function autorisation_ajout($Code_joueur, $Code_parametre)
    {
        return true;
    }

    static function data_controller($Code_joueur, $Code_parametre)
    {
        // ici le code
    }

    static function ajouter($Code_joueur, $Code_parametre)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_supprimer($Code_joueur=0, $Code_parametre=0)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['a_joueur_parametre__SUPPRIMER']
         *
         */
        // Ici le code
        if ($mf_droits_defaut['a_joueur_parametre__SUPPRIMER'])
        {
            // Ici le code
        }
    }

    static function autorisation_suppression($Code_joueur, $Code_parametre)
    {
        return true;
    }

    static function supprimer($copie__liste_a_joueur_parametre)
    {
        // ici le code
    }

    static function completion(&$donnees)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_joueur']
         * $donnees['Code_parametre']
         */
        // ici le code
    }

    // API callbacks
    // -------------------

    static function callback_post($Code_joueur, $Code_parametre)
    {
        return null;
    }

    static function callback_put($Code_joueur, $Code_parametre)
    {
        return null;
    }

}
