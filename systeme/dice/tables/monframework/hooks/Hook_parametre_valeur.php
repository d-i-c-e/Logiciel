<?php

class Hook_parametre_valeur{

    static function initialisation() // première instanciation
    {
        // ici le code
    }

    static function actualisation() // à chaque instanciation
    {
        // ici le code
    }

    static function pre_controller(string &$parametre_valeur_Libelle, int &$Code_parametre, ?int $Code_parametre_valeur=null)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_ajouter(?int $Code_parametre=null)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['parametre_valeur__AJOUTER']
         * $mf_droits_defaut['parametre_valeur__CREER'] // actualisation uniquement pour l'affichage
         *
         */
        // ici le code
        if (est_administrateur()) {
            $mf_droits_defaut['parametre_valeur__AJOUTER'] = true;
        }
    }

    static function autorisation_ajout(string $parametre_valeur_Libelle, int $Code_parametre)
    {
        return true;
    }

    static function data_controller(string &$parametre_valeur_Libelle, int &$Code_parametre, ?int $Code_parametre_valeur=null)
    {
        // ici le code
    }

    static function calcul_signature(string $parametre_valeur_Libelle, int $Code_parametre)
    {
        return md5($parametre_valeur_Libelle.'-'.$Code_parametre);
    }

    static function calcul_cle_unique(string $parametre_valeur_Libelle, int $Code_parametre)
    {
        // La méthode POST de l'API REST utilise cette fonction pour en déduire l'unicité de la données. Dans le cas contraire, la données est alors mise à jour
        // Attention au risque de collision
        return $Code_parametre.'.'.sha1($parametre_valeur_Libelle);
    }

    static function ajouter(int $Code_parametre_valeur)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_modifier(?int $Code_parametre_valeur=null)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['parametre_valeur__MODIFIER']
         *
         * $mf_droits_defaut['api_modifier__parametre_valeur_Libelle']
         *
         * $mf_droits_defaut['api_modifier_ref__parametre_valeur__Code_parametre']
         *
         */
        // ici le code
        if (est_administrateur()) {
            $mf_droits_defaut['api_modifier__parametre_valeur_Libelle'] = true;
        }
    }

    static function autorisation_modification(int $Code_parametre_valeur, string $parametre_valeur_Libelle__new, int $Code_parametre__new)
    {
        return true;
    }

    static function data_controller__parametre_valeur_Libelle(string $old, string &$new, int $Code_parametre_valeur)
    {
        // ici le code
    }

    static function data_controller__Code_parametre(int $old, int &$new, int $Code_parametre_valeur)
    {
        // ici le code
    }

    /*
     * modifier : $Code_parametre_valeur permet de se référer à la données modifiée
     * les autres paramètres booléens ($modif...) permettent d'identifier les champs qui ont été modifiés
     */
    static function modifier(int $Code_parametre_valeur, bool $bool__parametre_valeur_Libelle, bool $bool__Code_parametre)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_supprimer(?int $Code_parametre_valeur=null)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['parametre_valeur__SUPPRIMER']
         *
         */
        // Ici le code
        if (est_administrateur()) {
            $mf_droits_defaut['parametre_valeur__SUPPRIMER'] = true;
        }
        if ($Code_parametre_valeur!=0 && $mf_droits_defaut['parametre_valeur__SUPPRIMER'])
        {
            // Ici le code
        }
    }

    static function autorisation_suppression(int $Code_parametre_valeur)
    {
        return true;
    }

    static function supprimer(array $copie__parametre_valeur)
    {
        // ici le code
    }

    static function supprimer_2(array $copie__liste_parametre_valeur)
    {
        foreach ($copie__liste_parametre_valeur as &$copie__parametre_valeur)
        {
            self::supprimer($copie__parametre_valeur);
        }
        unset($copie__parametre_valeur);
    }

    static function est_a_jour(array &$donnees)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_parametre_valeur']
         * $donnees['Code_parametre']
         * $donnees['parametre_valeur_Libelle']
         */
        return true;
    }

    static function mettre_a_jour(array $liste_parametre_valeur)
    {
        // ici le code
    }

    static function completion(array &$donnees)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_parametre_valeur']
         * $donnees['Code_parametre']
         * $donnees['parametre_valeur_Libelle']
         */
        // ici le code
    }

    // API callbacks
    // -------------------

    static function callback_post(int $Code_parametre_valeur)
    {
        return null;
    }

    static function callback_put(int $Code_parametre_valeur)
    {
        return null;
    }

}
