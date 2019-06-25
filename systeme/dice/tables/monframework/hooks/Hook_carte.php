<?php

class Hook_carte{

    static function initialisation() // première instanciation
    {
        // ici le code
    }

    static function actualisation() // à chaque instanciation
    {
        // ici le code
    }

    static function pre_controller(string &$carte_Nom, int &$carte_Hauteur, int &$carte_Largeur, string &$carte_Fichier, int &$Code_groupe, ?int $Code_carte=null)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_ajouter(?int $Code_groupe=null)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['carte__AJOUTER']
         * $mf_droits_defaut['carte__CREER'] // actualisation uniquement pour l'affichage
         *
         */
        // ici le code
    }

    static function autorisation_ajout(string $carte_Nom, int $carte_Hauteur, int $carte_Largeur, string $carte_Fichier, int $Code_groupe)
    {
        return true;
    }

    static function data_controller(string &$carte_Nom, int &$carte_Hauteur, int &$carte_Largeur, string &$carte_Fichier, int &$Code_groupe, ?int $Code_carte=null)
    {
        // ici le code
    }

    static function calcul_signature(string $carte_Nom, int $carte_Hauteur, int $carte_Largeur, string $carte_Fichier, int $Code_groupe)
    {
        return md5($carte_Nom.'-'.$carte_Hauteur.'-'.$carte_Largeur.'-'.$carte_Fichier.'-'.$Code_groupe);
    }

    static function calcul_cle_unique(string $carte_Nom, int $carte_Hauteur, int $carte_Largeur, string $carte_Fichier, int $Code_groupe)
    {
        // La méthode POST de l'API REST utilise cette fonction pour en déduire l'unicité de la données. Dans le cas contraire, la données est alors mise à jour
        // Attention au risque de collision
        return $Code_groupe.'.'.sha1($carte_Nom.'.'.$carte_Hauteur.'.'.$carte_Largeur.'.'.$carte_Fichier);
    }

    static function ajouter(int $Code_carte)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_modifier(?int $Code_carte=null)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['carte__MODIFIER']
         *
         * $mf_droits_defaut['api_modifier__carte_Nom']
         * $mf_droits_defaut['api_modifier__carte_Hauteur']
         * $mf_droits_defaut['api_modifier__carte_Largeur']
         * $mf_droits_defaut['api_modifier__carte_Fichier']
         *
         * $mf_droits_defaut['api_modifier_ref__carte__Code_groupe']
         *
         */
        // ici le code
    }

    static function autorisation_modification(int $Code_carte, string $carte_Nom__new, int $carte_Hauteur__new, int $carte_Largeur__new, string $carte_Fichier__new, int $Code_groupe__new)
    {
        return true;
    }

    static function data_controller__carte_Nom(string $old, string &$new, int $Code_carte)
    {
        // ici le code
    }

    static function data_controller__carte_Hauteur(int $old, int &$new, int $Code_carte)
    {
        // ici le code
    }

    static function data_controller__carte_Largeur(int $old, int &$new, int $Code_carte)
    {
        // ici le code
    }

    static function data_controller__carte_Fichier(string $old, string &$new, int $Code_carte)
    {
        // ici le code
    }

    static function data_controller__Code_groupe(int $old, int &$new, int $Code_carte)
    {
        // ici le code
    }

    /*
     * modifier : $Code_carte permet de se référer à la données modifiée
     * les autres paramètres booléens ($modif...) permettent d'identifier les champs qui ont été modifiés
     */
    static function modifier(int $Code_carte, bool $bool__carte_Nom, bool $bool__carte_Hauteur, bool $bool__carte_Largeur, bool $bool__carte_Fichier, bool $bool__Code_groupe)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_supprimer(?int $Code_carte=null)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['carte__SUPPRIMER']
         *
         */
        // Ici le code
        if ($Code_carte!=0 && $mf_droits_defaut['carte__SUPPRIMER'])
        {
            // Ici le code
        }
    }

    static function autorisation_suppression(int $Code_carte)
    {
        return true;
    }

    static function supprimer(array $copie__carte)
    {
        // ici le code
    }

    static function supprimer_2(array $copie__liste_carte)
    {
        foreach ($copie__liste_carte as &$copie__carte)
        {
            self::supprimer($copie__carte);
        }
        unset($copie__carte);
    }

    static function est_a_jour(array &$donnees)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_carte']
         * $donnees['Code_groupe']
         * $donnees['carte_Nom']
         * $donnees['carte_Hauteur']
         * $donnees['carte_Largeur']
         * $donnees['carte_Fichier']
         */
        return true;
    }

    static function mettre_a_jour(array $liste_carte)
    {
        // ici le code
    }

    static function completion(array &$donnees)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_carte']
         * $donnees['Code_groupe']
         * $donnees['carte_Nom']
         * $donnees['carte_Hauteur']
         * $donnees['carte_Largeur']
         * $donnees['carte_Fichier']
         */
        // ici le code
    }

    // API callbacks
    // -------------------

    static function callback_post(int $Code_carte)
    {
        return null;
    }

    static function callback_put(int $Code_carte)
    {
        return null;
    }

}
