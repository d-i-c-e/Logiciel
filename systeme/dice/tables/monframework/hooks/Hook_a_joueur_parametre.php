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

    static function pre_controller(int $Code_joueur, int $Code_parametre)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_ajouter(?int $Code_joueur=null, ?int $Code_parametre=null)
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

    static function autorisation_ajout(int $Code_joueur, int $Code_parametre)
    {
        return true;
    }

    static function data_controller(int $Code_joueur, int $Code_parametre)
    {
        // ici le code
    }

    static function ajouter(int $Code_joueur, int $Code_parametre)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_supprimer(?int $Code_joueur=null, ?int $Code_parametre=null)
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

    static function autorisation_suppression(int $Code_joueur, int $Code_parametre)
    {
        return true;
    }

    static function supprimer(array $copie__liste_a_joueur_parametre)
    {
        // ici le code
    }

    static function completion(array &$donnees)
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

    static function callback_post(int $Code_joueur, int $Code_parametre)
    {
        return null;
    }

    static function callback_put(int $Code_joueur, int $Code_parametre)
    {
        return null;
    }

}
