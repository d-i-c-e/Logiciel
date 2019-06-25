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

    static function pre_controller(int $Code_carte, int $Code_objet)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_ajouter(?int $Code_carte=null, ?int $Code_objet=null)
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

    static function autorisation_ajout(int $Code_carte, int $Code_objet)
    {
        return true;
    }

    static function data_controller(int $Code_carte, int $Code_objet)
    {
        // ici le code
    }

    static function ajouter(int $Code_carte, int $Code_objet)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_supprimer(?int $Code_carte=null, ?int $Code_objet=null)
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

    static function autorisation_suppression(int $Code_carte, int $Code_objet)
    {
        return true;
    }

    static function supprimer(array $copie__liste_a_carte_objet)
    {
        // ici le code
    }

    static function completion(array &$donnees)
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

    static function callback_post(int $Code_carte, int $Code_objet)
    {
        return null;
    }

    static function callback_put(int $Code_carte, int $Code_objet)
    {
        return null;
    }

}
