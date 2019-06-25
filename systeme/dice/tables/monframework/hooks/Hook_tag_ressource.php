<?php

class Hook_tag_ressource{

    static function initialisation() // première instanciation
    {
        // ici le code
    }

    static function actualisation() // à chaque instanciation
    {
        // ici le code
    }

    static function pre_controller(string &$tag_ressource_Libelle, ?int $Code_tag_ressource=null)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_ajouter()
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['tag_ressource__AJOUTER']
         * $mf_droits_defaut['tag_ressource__CREER'] // actualisation uniquement pour l'affichage
         *
         */
        // ici le code
    }

    static function autorisation_ajout(string $tag_ressource_Libelle)
    {
        return true;
    }

    static function data_controller(string &$tag_ressource_Libelle, ?int $Code_tag_ressource=null)
    {
        // ici le code
    }

    static function calcul_signature(string $tag_ressource_Libelle)
    {
        return md5($tag_ressource_Libelle);
    }

    static function calcul_cle_unique(string $tag_ressource_Libelle)
    {
        // La méthode POST de l'API REST utilise cette fonction pour en déduire l'unicité de la données. Dans le cas contraire, la données est alors mise à jour
        // Attention au risque de collision
        return sha1($tag_ressource_Libelle);
    }

    static function ajouter(int $Code_tag_ressource)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_modifier(?int $Code_tag_ressource=null)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['tag_ressource__MODIFIER']
         *
         * $mf_droits_defaut['api_modifier__tag_ressource_Libelle']
         *
         */
        // ici le code
    }

    static function autorisation_modification(int $Code_tag_ressource, string $tag_ressource_Libelle__new)
    {
        return true;
    }

    static function data_controller__tag_ressource_Libelle(string $old, string &$new, int $Code_tag_ressource)
    {
        // ici le code
    }

    /*
     * modifier : $Code_tag_ressource permet de se référer à la données modifiée
     * les autres paramètres booléens ($modif...) permettent d'identifier les champs qui ont été modifiés
     */
    static function modifier(int $Code_tag_ressource, bool $bool__tag_ressource_Libelle)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_supprimer(?int $Code_tag_ressource=null)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['tag_ressource__SUPPRIMER']
         *
         */
        // Ici le code
        if ($Code_tag_ressource!=0 && $mf_droits_defaut['tag_ressource__SUPPRIMER'])
        {
            // Ici le code
        }
    }

    static function autorisation_suppression(int $Code_tag_ressource)
    {
        return true;
    }

    static function supprimer(array $copie__tag_ressource)
    {
        // ici le code
    }

    static function supprimer_2(array $copie__liste_tag_ressource)
    {
        foreach ($copie__liste_tag_ressource as &$copie__tag_ressource)
        {
            self::supprimer($copie__tag_ressource);
        }
        unset($copie__tag_ressource);
    }

    static function est_a_jour(array &$donnees)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_tag_ressource']
         * $donnees['tag_ressource_Libelle']
         */
        return true;
    }

    static function mettre_a_jour(array $liste_tag_ressource)
    {
        // ici le code
    }

    static function completion(array &$donnees)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_tag_ressource']
         * $donnees['tag_ressource_Libelle']
         */
        // ici le code
    }

    // API callbacks
    // -------------------

    static function callback_post(int $Code_tag_ressource)
    {
        return null;
    }

    static function callback_put(int $Code_tag_ressource)
    {
        return null;
    }

}
