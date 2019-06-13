<?php

class Hook_personnage{

    static function initialisation() // première instanciation
    {
        // ici le code
    }

    static function actualisation() // à chaque instanciation
    {
        // ici le code
    }

    static function pre_controller(&$personnage_Fichier_Fichier, &$personnage_Conservation, &$Code_joueur, &$Code_groupe, $Code_personnage=0)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_ajouter($Code_joueur=0, $Code_groupe=0)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['personnage__AJOUTER']
         * $mf_droits_defaut['personnage__CREER'] // actualisation uniquement pour l'affichage
         *
         */
        // ici le code
    }

    static function autorisation_ajout($personnage_Fichier_Fichier, $personnage_Conservation, $Code_joueur, $Code_groupe)
    {
        return true;
    }

    static function data_controller(&$personnage_Fichier_Fichier, &$personnage_Conservation, &$Code_joueur, &$Code_groupe, $Code_personnage=0)
    {
        // ici le code
    }

    static function calcul_signature($personnage_Fichier_Fichier, $personnage_Conservation, $Code_joueur, $Code_groupe)
    {
        return md5($personnage_Fichier_Fichier.'-'.$personnage_Conservation.'-'.$Code_joueur.'-'.$Code_groupe);
    }

    static function calcul_cle_unique($personnage_Fichier_Fichier, $personnage_Conservation, $Code_joueur, $Code_groupe)
    {
        // La méthode POST de l'API REST utilise cette fonction pour en déduire l'unicité de la données. Dans le cas contraire, la données est alors mise à jour
        // Attention au risque de collision
        return $Code_groupe.'.'.$Code_joueur.'.'.sha1($personnage_Fichier_Fichier.'.'.$personnage_Conservation);
    }

    static function ajouter($Code_personnage)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_modifier($Code_personnage=0)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['personnage__MODIFIER']
         *
         * $mf_droits_defaut['api_modifier__personnage_Fichier_Fichier']
         * $mf_droits_defaut['api_modifier__personnage_Conservation']
         *
         * $mf_droits_defaut['api_modifier_ref__personnage__Code_joueur']
         * $mf_droits_defaut['api_modifier_ref__personnage__Code_groupe']
         *
         */
        // ici le code
    }

    static function autorisation_modification($Code_personnage, $personnage_Fichier_Fichier__new, $personnage_Conservation__new, $Code_joueur__new, $Code_groupe__new)
    {
        return true;
    }

    static function data_controller__personnage_Fichier_Fichier($old, &$new, $Code_personnage)
    {
        // ici le code
    }

    static function data_controller__personnage_Conservation($old, &$new, $Code_personnage)
    {
        // ici le code
    }

    static function data_controller__Code_joueur($old, &$new, $Code_personnage)
    {
        // ici le code
    }

    static function data_controller__Code_groupe($old, &$new, $Code_personnage)
    {
        // ici le code
    }

    /*
     * modifier : $Code_match_foot permet de se référer à la données modifiée
     * les autres paramètres booléens ($modif...) permettent d'identifier les champs qui ont été modifiés
     */
    static function modifier($Code_personnage, $bool__personnage_Fichier_Fichier, $bool__personnage_Conservation, $bool__Code_joueur, $bool__Code_groupe)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_supprimer($Code_personnage=0)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['personnage__SUPPRIMER']
         *
         */
        // Ici le code
        if ($Code_personnage!=0 && $mf_droits_defaut['personnage__SUPPRIMER'])
        {
            // Ici le code
        }
    }

    static function autorisation_suppression($Code_personnage)
    {
        return true;
    }

    static function supprimer($copie__personnage)
    {
        // ici le code
    }

    static function supprimer_2($copie__liste_personnage)
    {
        foreach ($copie__liste_personnage as &$copie__personnage)
        {
            self::supprimer($copie__personnage);
        }
        unset($copie__personnage);
    }

    static function est_a_jour(&$donnees)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_personnage']
         * $donnees['Code_joueur']
         * $donnees['Code_groupe']
         * $donnees['personnage_Fichier_Fichier']
         * $donnees['personnage_Conservation']
         */
        return true;
    }

    static function mettre_a_jour($liste_personnage)
    {
        // ici le code
    }

    static function completion(&$donnees)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_personnage']
         * $donnees['Code_joueur']
         * $donnees['Code_groupe']
         * $donnees['personnage_Fichier_Fichier']
         * $donnees['personnage_Conservation']
         */
        // ici le code
    }

    // API callbacks
    // -------------------

    static function callback_post($Code_personnage)
    {
        return null;
    }

    static function callback_put($Code_personnage)
    {
        return null;
    }

}
