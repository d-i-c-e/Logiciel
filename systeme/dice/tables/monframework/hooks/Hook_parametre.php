<?php

class Hook_parametre{

    static function initialisation() // première instanciation
    {
        // ici le code
    }

    static function actualisation() // à chaque instanciation
    {
        // ici le code
    }

    static function pre_controller(&$parametre_Libelle, &$parametre_Valeur, &$parametre_Activable, &$parametre_Actif, $Code_parametre=0)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_ajouter()
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['parametre__AJOUTER']
         * $mf_droits_defaut['parametre__CREER'] // actualisation uniquement pour l'affichage
         *
         */
        // ici le code
    }

    static function autorisation_ajout($parametre_Libelle, $parametre_Valeur, $parametre_Activable, $parametre_Actif)
    {
        return true;
    }

    static function data_controller(&$parametre_Libelle, &$parametre_Valeur, &$parametre_Activable, &$parametre_Actif, $Code_parametre=0)
    {
        // ici le code
    }

    static function calcul_signature($parametre_Libelle, $parametre_Valeur, $parametre_Activable, $parametre_Actif)
    {
        return md5($parametre_Libelle.'-'.$parametre_Valeur.'-'.$parametre_Activable.'-'.$parametre_Actif);
    }

    static function calcul_cle_unique($parametre_Libelle, $parametre_Valeur, $parametre_Activable, $parametre_Actif)
    {
        // La méthode POST de l'API REST utilise cette fonction pour en déduire l'unicité de la données. Dans le cas contraire, la données est alors mise à jour
        // Attention au risque de collision
        return sha1($parametre_Libelle.'.'.$parametre_Valeur.'.'.$parametre_Activable.'.'.$parametre_Actif);
    }

    static function ajouter($Code_parametre)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_modifier($Code_parametre=0)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['parametre__MODIFIER']
         *
         * $mf_droits_defaut['api_modifier__parametre_Libelle']
         * $mf_droits_defaut['api_modifier__parametre_Valeur']
         * $mf_droits_defaut['api_modifier__parametre_Activable']
         * $mf_droits_defaut['api_modifier__parametre_Actif']
         *
         */
        // ici le code
    }

    static function autorisation_modification($Code_parametre, $parametre_Libelle__new, $parametre_Valeur__new, $parametre_Activable__new, $parametre_Actif__new)
    {
        return true;
    }

    static function data_controller__parametre_Libelle($old, &$new, $Code_parametre)
    {
        // ici le code
    }

    static function data_controller__parametre_Valeur($old, &$new, $Code_parametre)
    {
        // ici le code
    }

    static function data_controller__parametre_Activable($old, &$new, $Code_parametre)
    {
        // ici le code
    }

    static function data_controller__parametre_Actif($old, &$new, $Code_parametre)
    {
        // ici le code
    }

    /*
     * modifier : $Code_match_foot permet de se référer à la données modifiée
     * les autres paramètres booléens ($modif...) permettent d'identifier les champs qui ont été modifiés
     */
    static function modifier($Code_parametre, $bool__parametre_Libelle, $bool__parametre_Valeur, $bool__parametre_Activable, $bool__parametre_Actif)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_supprimer($Code_parametre=0)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['parametre__SUPPRIMER']
         *
         */
        // Ici le code
        if ($Code_parametre!=0 && $mf_droits_defaut['parametre__SUPPRIMER'])
        {
            // Ici le code
        }
    }

    static function autorisation_suppression($Code_parametre)
    {
        return true;
    }

    static function supprimer($copie__parametre)
    {
        // ici le code
    }

    static function supprimer_2($copie__liste_parametre)
    {
        foreach ($copie__liste_parametre as &$copie__parametre)
        {
            self::supprimer($copie__parametre);
        }
        unset($copie__parametre);
    }

    static function est_a_jour(&$donnees)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_parametre']
         * $donnees['parametre_Libelle']
         * $donnees['parametre_Valeur']
         * $donnees['parametre_Activable']
         * $donnees['parametre_Actif']
         */
        return true;
    }

    static function mettre_a_jour($liste_parametre)
    {
        // ici le code
    }

    static function completion(&$donnees)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_parametre']
         * $donnees['parametre_Libelle']
         * $donnees['parametre_Valeur']
         * $donnees['parametre_Activable']
         * $donnees['parametre_Actif']
         */
        // ici le code
    }

    // API callbacks
    // -------------------

    static function callback_post($Code_parametre)
    {
        return null;
    }

    static function callback_put($Code_parametre)
    {
        return null;
    }

}
