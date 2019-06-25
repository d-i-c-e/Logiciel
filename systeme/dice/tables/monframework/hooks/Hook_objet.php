<?php

class Hook_objet{

    static function initialisation() // première instanciation
    {
        // ici le code
    }

    static function actualisation() // à chaque instanciation
    {
        // ici le code
    }

    static function pre_controller(string &$objet_Libelle, string &$objet_Image_Fichier, int &$Code_type, ?int $Code_objet=null)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_ajouter(?int $Code_type=null)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['objet__AJOUTER']
         * $mf_droits_defaut['objet__CREER'] // actualisation uniquement pour l'affichage
         *
         */
        // ici le code
    }

    static function autorisation_ajout(string $objet_Libelle, string $objet_Image_Fichier, int $Code_type)
    {
        return true;
    }

    static function data_controller(string &$objet_Libelle, string &$objet_Image_Fichier, int &$Code_type, ?int $Code_objet=null)
    {
        // ici le code
    }

    static function calcul_signature(string $objet_Libelle, string $objet_Image_Fichier, int $Code_type)
    {
        return md5($objet_Libelle.'-'.$objet_Image_Fichier.'-'.$Code_type);
    }

    static function calcul_cle_unique(string $objet_Libelle, string $objet_Image_Fichier, int $Code_type)
    {
        // La méthode POST de l'API REST utilise cette fonction pour en déduire l'unicité de la données. Dans le cas contraire, la données est alors mise à jour
        // Attention au risque de collision
        return $Code_type.'.'.sha1($objet_Libelle.'.'.$objet_Image_Fichier);
    }

    static function ajouter(int $Code_objet)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_modifier(?int $Code_objet=null)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['objet__MODIFIER']
         *
         * $mf_droits_defaut['api_modifier__objet_Libelle']
         * $mf_droits_defaut['api_modifier__objet_Image_Fichier']
         *
         * $mf_droits_defaut['api_modifier_ref__objet__Code_type']
         *
         */
        // ici le code
    }

    static function autorisation_modification(int $Code_objet, string $objet_Libelle__new, string $objet_Image_Fichier__new, int $Code_type__new)
    {
        return true;
    }

    static function data_controller__objet_Libelle(string $old, string &$new, int $Code_objet)
    {
        // ici le code
    }

    static function data_controller__objet_Image_Fichier(string $old, string &$new, int $Code_objet)
    {
        // ici le code
    }

    static function data_controller__Code_type(int $old, int &$new, int $Code_objet)
    {
        // ici le code
    }

    /*
     * modifier : $Code_objet permet de se référer à la données modifiée
     * les autres paramètres booléens ($modif...) permettent d'identifier les champs qui ont été modifiés
     */
    static function modifier(int $Code_objet, bool $bool__objet_Libelle, bool $bool__objet_Image_Fichier, bool $bool__Code_type)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_supprimer(?int $Code_objet=null)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['objet__SUPPRIMER']
         *
         */
        // Ici le code
        if ($Code_objet!=0 && $mf_droits_defaut['objet__SUPPRIMER'])
        {
            // Ici le code
        }
    }

    static function autorisation_suppression(int $Code_objet)
    {
        return true;
    }

    static function supprimer(array $copie__objet)
    {
        // ici le code
    }

    static function supprimer_2(array $copie__liste_objet)
    {
        foreach ($copie__liste_objet as &$copie__objet)
        {
            self::supprimer($copie__objet);
        }
        unset($copie__objet);
    }

    static function est_a_jour(array &$donnees)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_objet']
         * $donnees['Code_type']
         * $donnees['objet_Libelle']
         * $donnees['objet_Image_Fichier']
         */
        return true;
    }

    static function mettre_a_jour(array $liste_objet)
    {
        // ici le code
    }

    static function completion(array &$donnees)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_objet']
         * $donnees['Code_type']
         * $donnees['objet_Libelle']
         * $donnees['objet_Image_Fichier']
         */
        // ici le code
    }

    // API callbacks
    // -------------------

    static function callback_post(int $Code_objet)
    {
        return null;
    }

    static function callback_put(int $Code_objet)
    {
        return null;
    }

}
