<?php

class Hook_a_ressource_tag_ressource{

    static function initialisation() // première instanciation
    {
        // ici le code
    }

    static function actualisation() // à chaque instanciation
    {
        // ici le code
    }

    static function pre_controller(int $Code_tag_ressource, int $Code_ressource)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_ajouter(?int $Code_tag_ressource=null, ?int $Code_ressource=null)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['a_ressource_tag_ressource__AJOUTER']
         * $mf_droits_defaut['a_ressource_tag_ressource__CREER'] // actualisation uniquement pour l'affichage
         *
         */
        // ici le code
    }

    static function autorisation_ajout(int $Code_tag_ressource, int $Code_ressource)
    {
        return true;
    }

    static function data_controller(int $Code_tag_ressource, int $Code_ressource)
    {
        // ici le code
    }

    static function ajouter(int $Code_tag_ressource, int $Code_ressource)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_supprimer(?int $Code_tag_ressource=null, ?int $Code_ressource=null)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['a_ressource_tag_ressource__SUPPRIMER']
         *
         */
        // Ici le code
        if ($mf_droits_defaut['a_ressource_tag_ressource__SUPPRIMER'])
        {
            // Ici le code
        }
    }

    static function autorisation_suppression(int $Code_tag_ressource, int $Code_ressource)
    {
        return true;
    }

    static function supprimer(array $copie__liste_a_ressource_tag_ressource)
    {
        // ici le code
    }

    static function completion(array &$donnees)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_tag_ressource']
         * $donnees['Code_ressource']
         */
        // ici le code
    }

    // API callbacks
    // -------------------

    static function callback_post(int $Code_tag_ressource, int $Code_ressource)
    {
        return null;
    }

    static function callback_put(int $Code_tag_ressource, int $Code_ressource)
    {
        return null;
    }

}
