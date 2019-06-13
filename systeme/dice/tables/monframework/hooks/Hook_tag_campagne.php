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

    static function pre_controller(&$tag_campagne_Libelle, $Code_tag_campagne=0)
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

    static function autorisation_ajout($tag_campagne_Libelle)
    {
        return true;
    }

    static function data_controller(&$tag_campagne_Libelle, $Code_tag_campagne=0)
    {
        // ici le code
    }

    static function calcul_signature($tag_campagne_Libelle)
    {
        return md5($tag_campagne_Libelle);
    }

    static function calcul_cle_unique($tag_campagne_Libelle)
    {
        // La méthode POST de l'API REST utilise cette fonction pour en déduire l'unicité de la données. Dans le cas contraire, la données est alors mise à jour
        // Attention au risque de collision
        return sha1($tag_campagne_Libelle);
    }

    static function ajouter($Code_tag_campagne)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_modifier($Code_tag_campagne=0)
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

    static function autorisation_modification($Code_tag_campagne, $tag_campagne_Libelle__new)
    {
        return true;
    }

    static function data_controller__tag_campagne_Libelle($old, &$new, $Code_tag_campagne)
    {
        // ici le code
    }

    /*
     * modifier : $Code_match_foot permet de se référer à la données modifiée
     * les autres paramètres booléens ($modif...) permettent d'identifier les champs qui ont été modifiés
     */
    static function modifier($Code_tag_campagne, $bool__tag_campagne_Libelle)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_supprimer($Code_tag_campagne=0)
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

    static function autorisation_suppression($Code_tag_campagne)
    {
        return true;
    }

    static function supprimer($copie__tag_campagne)
    {
        // ici le code
    }

    static function supprimer_2($copie__liste_tag_campagne)
    {
        foreach ($copie__liste_tag_campagne as &$copie__tag_campagne)
        {
            self::supprimer($copie__tag_campagne);
        }
        unset($copie__tag_campagne);
    }

    static function est_a_jour(&$donnees)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_tag_campagne']
         * $donnees['tag_campagne_Libelle']
         */
        return true;
    }

    static function mettre_a_jour($liste_tag_campagne)
    {
        // ici le code
    }

    static function completion(&$donnees)
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

    static function callback_post($Code_tag_campagne)
    {
        return null;
    }

    static function callback_put($Code_tag_campagne)
    {
        return null;
    }

}
