<?php

class Hook_a_carte_objet{

    static function initialisation() // première instanciation
    {
        // ici le code
    }

    static function actualisation() // à chaque instanciation
    {
        // ici le code
    }

    static function pre_controller($Code_carte, $Code_objet)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_ajouter($Code_carte=0, $Code_objet=0)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['a_carte_objet__AJOUTER']
         * $mf_droits_defaut['a_carte_objet__CREER'] // actualisation uniquement pour l'affichage
         *
         */
        // ici le code
    }

    static function autorisation_ajout($Code_carte, $Code_objet)
    {
        return true;
    }

    static function data_controller($Code_carte, $Code_objet)
    {
        // ici le code
    }

    static function ajouter($Code_carte, $Code_objet)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_supprimer($Code_carte=0, $Code_objet=0)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['a_carte_objet__SUPPRIMER']
         *
         */
        // Ici le code
        if ($mf_droits_defaut['a_carte_objet__SUPPRIMER'])
        {
            // Ici le code
        }
    }

    static function autorisation_suppression($Code_carte, $Code_objet)
    {
        return true;
    }

    static function supprimer($copie__liste_a_carte_objet)
    {
        // ici le code
    }

    static function completion(&$donnees)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_carte']
         * $donnees['Code_objet']
         */
        // ici le code
    }

    // API callbacks
    // -------------------

    static function callback_post($Code_carte, $Code_objet)
    {
        return null;
    }

    static function callback_put($Code_carte, $Code_objet)
    {
        return null;
    }

}
