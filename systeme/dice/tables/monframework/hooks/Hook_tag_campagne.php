<?php

class Hook_tag_campagne{

    static function initialisation() // première instanciation
    {
        // ici le code
    }

    static function actualisation() // à chaque instanciation
    {
        // ici le code
    }

    static function pre_controller(string &$tag_campagne_Libelle, ?int $Code_tag_campagne=null)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_ajouter()
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['tag_campagne__AJOUTER']
         * $mf_droits_defaut['tag_campagne__CREER'] // actualisation uniquement pour l'affichage
         *
         */
        // ici le code
    }

    static function autorisation_ajout(string $tag_campagne_Libelle)
    {
        return true;
    }

    static function data_controller(string &$tag_campagne_Libelle, ?int $Code_tag_campagne=null)
    {
        // ici le code
    }

    static function calcul_signature(string $tag_campagne_Libelle)
    {
        return md5($tag_campagne_Libelle);
    }

    static function calcul_cle_unique(string $tag_campagne_Libelle)
    {
        // La méthode POST de l'API REST utilise cette fonction pour en déduire l'unicité de la données. Dans le cas contraire, la données est alors mise à jour
        // Attention au risque de collision
        return sha1($tag_campagne_Libelle);
    }

    static function ajouter(int $Code_tag_campagne)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_modifier(?int $Code_tag_campagne=null)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['tag_campagne__MODIFIER']
         *
         * $mf_droits_defaut['api_modifier__tag_campagne_Libelle']
         *
         */
        // ici le code
    }

    static function autorisation_modification(int $Code_tag_campagne, string $tag_campagne_Libelle__new)
    {
        return true;
    }

    static function data_controller__tag_campagne_Libelle(string $old, string &$new, int $Code_tag_campagne)
    {
        // ici le code
    }

    /*
     * modifier : $Code_tag_campagne permet de se référer à la données modifiée
     * les autres paramètres booléens ($modif...) permettent d'identifier les champs qui ont été modifiés
     */
    static function modifier(int $Code_tag_campagne, bool $bool__tag_campagne_Libelle)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_supprimer(?int $Code_tag_campagne=null)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['tag_campagne__SUPPRIMER']
         *
         */
        // Ici le code
        if ($Code_tag_campagne!=0 && $mf_droits_defaut['tag_campagne__SUPPRIMER'])
        {
            // Ici le code
        }
    }

    static function autorisation_suppression(int $Code_tag_campagne)
    {
        return true;
    }

    static function supprimer(array $copie__tag_campagne)
    {
        // ici le code
    }

    static function supprimer_2(array $copie__liste_tag_campagne)
    {
        foreach ($copie__liste_tag_campagne as &$copie__tag_campagne)
        {
            self::supprimer($copie__tag_campagne);
        }
        unset($copie__tag_campagne);
    }

    static function est_a_jour(array &$donnees)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_tag_campagne']
         * $donnees['tag_campagne_Libelle']
         */
        return true;
    }

    static function mettre_a_jour(array $liste_tag_campagne)
    {
        // ici le code
    }

    static function completion(array &$donnees)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_tag_campagne']
         * $donnees['tag_campagne_Libelle']
         */
        // ici le code
    }

    // API callbacks
    // -------------------

    static function callback_post(int $Code_tag_campagne)
    {
        return null;
    }

    static function callback_put(int $Code_tag_campagne)
    {
        return null;
    }

}
