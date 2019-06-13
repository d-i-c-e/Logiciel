<?php

class Hook_liste_contacts{

    static function initialisation() // première instanciation
    {
        // ici le code
    }

    static function actualisation() // à chaque instanciation
    {
        // ici le code
    }

    static function pre_controller(&$liste_contacts_Nom, &$Code_joueur, $Code_liste_contacts=0)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_ajouter($Code_joueur=0)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['liste_contacts__AJOUTER']
         * $mf_droits_defaut['liste_contacts__CREER'] // actualisation uniquement pour l'affichage
         *
         */
        // ici le code
    }

    static function autorisation_ajout($liste_contacts_Nom, $Code_joueur)
    {
        return true;
    }

    static function data_controller(&$liste_contacts_Nom, &$Code_joueur, $Code_liste_contacts=0)
    {
        // ici le code
    }

    static function calcul_signature($liste_contacts_Nom, $Code_joueur)
    {
        return md5($liste_contacts_Nom.'-'.$Code_joueur);
    }

    static function calcul_cle_unique($liste_contacts_Nom, $Code_joueur)
    {
        // La méthode POST de l'API REST utilise cette fonction pour en déduire l'unicité de la données. Dans le cas contraire, la données est alors mise à jour
        // Attention au risque de collision
        return $Code_joueur.'.'.sha1($liste_contacts_Nom);
    }

    static function ajouter($Code_liste_contacts)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_modifier($Code_liste_contacts=0)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['liste_contacts__MODIFIER']
         *
         * $mf_droits_defaut['api_modifier__liste_contacts_Nom']
         *
         * $mf_droits_defaut['api_modifier_ref__liste_contacts__Code_joueur']
         *
         */
        // ici le code
    }

    static function autorisation_modification($Code_liste_contacts, $liste_contacts_Nom__new, $Code_joueur__new)
    {
        return true;
    }

    static function data_controller__liste_contacts_Nom($old, &$new, $Code_liste_contacts)
    {
        // ici le code
    }

    static function data_controller__Code_joueur($old, &$new, $Code_liste_contacts)
    {
        // ici le code
    }

    /*
     * modifier : $Code_match_foot permet de se référer à la données modifiée
     * les autres paramètres booléens ($modif...) permettent d'identifier les champs qui ont été modifiés
     */
    static function modifier($Code_liste_contacts, $bool__liste_contacts_Nom, $bool__Code_joueur)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_supprimer($Code_liste_contacts=0)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['liste_contacts__SUPPRIMER']
         *
         */
        // Ici le code
        if ($Code_liste_contacts!=0 && $mf_droits_defaut['liste_contacts__SUPPRIMER'])
        {
            // Ici le code
        }
    }

    static function autorisation_suppression($Code_liste_contacts)
    {
        return true;
    }

    static function supprimer($copie__liste_contacts)
    {
        // ici le code
    }

    static function supprimer_2($copie__liste_liste_contacts)
    {
        foreach ($copie__liste_liste_contacts as &$copie__liste_contacts)
        {
            self::supprimer($copie__liste_contacts);
        }
        unset($copie__liste_contacts);
    }

    static function est_a_jour(&$donnees)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_liste_contacts']
         * $donnees['Code_joueur']
         * $donnees['liste_contacts_Nom']
         */
        return true;
    }

    static function mettre_a_jour($liste_liste_contacts)
    {
        // ici le code
    }

    static function completion(&$donnees)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_liste_contacts']
         * $donnees['Code_joueur']
         * $donnees['liste_contacts_Nom']
         */
        // ici le code
    }

    // API callbacks
    // -------------------

    static function callback_post($Code_liste_contacts)
    {
        return null;
    }

    static function callback_put($Code_liste_contacts)
    {
        return null;
    }

}
