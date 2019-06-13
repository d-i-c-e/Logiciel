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

    static function pre_controller($Code_tag_ressource, $Code_ressource)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_ajouter($Code_tag_ressource=0, $Code_ressource=0)
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

    static function autorisation_ajout($Code_tag_ressource, $Code_ressource)
    {
        return true;
    }

    static function data_controller($Code_tag_ressource, $Code_ressource)
    {
        // ici le code
    }

    static function ajouter($Code_tag_ressource, $Code_ressource)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_supprimer($Code_tag_ressource=0, $Code_ressource=0)
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

    static function autorisation_suppression($Code_tag_ressource, $Code_ressource)
    {
        return true;
    }

    static function supprimer($copie__liste_a_ressource_tag_ressource)
    {
        // ici le code
    }

    static function completion(&$donnees)
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

    static function callback_post($Code_tag_ressource, $Code_ressource)
    {
        return null;
    }

    static function callback_put($Code_tag_ressource, $Code_ressource)
    {
        return null;
    }

}
