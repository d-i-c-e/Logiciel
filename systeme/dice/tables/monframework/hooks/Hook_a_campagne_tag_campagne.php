<?php

class Hook_a_campagne_tag_campagne{

    static function initialisation() // première instanciation
    {
        // ici le code
    }

    static function actualisation() // à chaque instanciation
    {
        // ici le code
    }

    static function pre_controller(int $Code_tag_campagne, int $Code_campagne)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_ajouter(?int $Code_tag_campagne=null, ?int $Code_campagne=null)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['a_campagne_tag_campagne__AJOUTER']
         * $mf_droits_defaut['a_campagne_tag_campagne__CREER'] // actualisation uniquement pour l'affichage
         *
         */
        // ici le code
    }

    static function autorisation_ajout(int $Code_tag_campagne, int $Code_campagne)
    {
        return true;
    }

    static function data_controller(int $Code_tag_campagne, int $Code_campagne)
    {
        // ici le code
    }

    static function ajouter(int $Code_tag_campagne, int $Code_campagne)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_supprimer(?int $Code_tag_campagne=null, ?int $Code_campagne=null)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['a_campagne_tag_campagne__SUPPRIMER']
         *
         */
        // Ici le code
        if ($mf_droits_defaut['a_campagne_tag_campagne__SUPPRIMER'])
        {
            // Ici le code
        }
    }

    static function autorisation_suppression(int $Code_tag_campagne, int $Code_campagne)
    {
        return true;
    }

    static function supprimer(array $copie__liste_a_campagne_tag_campagne)
    {
        // ici le code
    }

    static function completion(array &$donnees)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_tag_campagne']
         * $donnees['Code_campagne']
         */
        // ici le code
    }

    // API callbacks
    // -------------------

    static function callback_post(int $Code_tag_campagne, int $Code_campagne)
    {
        return null;
    }

    static function callback_put(int $Code_tag_campagne, int $Code_campagne)
    {
        return null;
    }

}
