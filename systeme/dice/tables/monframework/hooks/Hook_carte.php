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

    static function pre_controller(&$carte_Nom, &$carte_Hauteur, &$carte_Largeur, &$carte_Fichier, &$Code_groupe, $Code_carte=0)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_ajouter($Code_groupe=0)
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

    static function autorisation_ajout($carte_Nom, $carte_Hauteur, $carte_Largeur, $carte_Fichier, $Code_groupe)
    {
        return true;
    }

    static function data_controller(&$carte_Nom, &$carte_Hauteur, &$carte_Largeur, &$carte_Fichier, &$Code_groupe, $Code_carte=0)
    {
        // ici le code
    }

    static function calcul_signature($carte_Nom, $carte_Hauteur, $carte_Largeur, $carte_Fichier, $Code_groupe)
    {
        return md5($carte_Nom.'-'.$carte_Hauteur.'-'.$carte_Largeur.'-'.$carte_Fichier.'-'.$Code_groupe);
    }

    static function calcul_cle_unique($carte_Nom, $carte_Hauteur, $carte_Largeur, $carte_Fichier, $Code_groupe)
    {
        // La méthode POST de l'API REST utilise cette fonction pour en déduire l'unicité de la données. Dans le cas contraire, la données est alors mise à jour
        // Attention au risque de collision
        return $Code_groupe.'.'.sha1($carte_Nom.'.'.$carte_Hauteur.'.'.$carte_Largeur.'.'.$carte_Fichier);
    }

    static function ajouter($Code_carte)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_modifier($Code_carte=0)
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

    static function autorisation_modification($Code_carte, $carte_Nom__new, $carte_Hauteur__new, $carte_Largeur__new, $carte_Fichier__new, $Code_groupe__new)
    {
        return true;
    }

    static function data_controller__carte_Nom($old, &$new, $Code_carte)
    {
        // ici le code
    }

    static function data_controller__carte_Hauteur($old, &$new, $Code_carte)
    {
        // ici le code
    }

    static function data_controller__carte_Largeur($old, &$new, $Code_carte)
    {
        // ici le code
    }

    static function data_controller__carte_Fichier($old, &$new, $Code_carte)
    {
        // ici le code
    }

    static function data_controller__Code_groupe($old, &$new, $Code_carte)
    {
        // ici le code
    }

    /*
     * modifier : $Code_match_foot permet de se référer à la données modifiée
     * les autres paramètres booléens ($modif...) permettent d'identifier les champs qui ont été modifiés
     */
    static function modifier($Code_carte, $bool__carte_Nom, $bool__carte_Hauteur, $bool__carte_Largeur, $bool__carte_Fichier, $bool__Code_groupe)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_supprimer($Code_carte=0)
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

    static function autorisation_suppression($Code_carte)
    {
        return true;
    }

    static function supprimer($copie__carte)
    {
        // ici le code
    }

    static function supprimer_2($copie__liste_carte)
    {
        foreach ($copie__liste_carte as &$copie__carte)
        {
            self::supprimer($copie__carte);
        }
        unset($copie__carte);
    }

    static function est_a_jour(&$donnees)
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

    static function mettre_a_jour($liste_carte)
    {
        // ici le code
    }

    static function completion(&$donnees)
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

    static function callback_post($Code_carte)
    {
        return null;
    }

    static function callback_put($Code_carte)
    {
        return null;
    }

}
