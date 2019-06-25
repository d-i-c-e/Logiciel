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

    static function pre_controller(string &$liste_contacts_Nom, int &$Code_joueur, ?int $Code_liste_contacts=null)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_ajouter(?int $Code_joueur=null)
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

    static function autorisation_ajout(string $liste_contacts_Nom, int $Code_joueur)
    {
        return true;
    }

    static function data_controller(string &$liste_contacts_Nom, int &$Code_joueur, ?int $Code_liste_contacts=null)
    {
        // ici le code
    }

    static function calcul_signature(string $liste_contacts_Nom, int $Code_joueur)
    {
        return md5($liste_contacts_Nom.'-'.$Code_joueur);
    }

    static function calcul_cle_unique(string $liste_contacts_Nom, int $Code_joueur)
    {
        // La méthode POST de l'API REST utilise cette fonction pour en déduire l'unicité de la données. Dans le cas contraire, la données est alors mise à jour
        // Attention au risque de collision
        return $Code_joueur.'.'.sha1($liste_contacts_Nom);
    }

    static function ajouter(int $Code_liste_contacts)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_modifier(?int $Code_liste_contacts=null)
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

    static function autorisation_modification(int $Code_liste_contacts, string $liste_contacts_Nom__new, int $Code_joueur__new)
    {
        return true;
    }

    static function data_controller__liste_contacts_Nom(string $old, string &$new, int $Code_liste_contacts)
    {
        // ici le code
    }

    static function data_controller__Code_joueur(int $old, int &$new, int $Code_liste_contacts)
    {
        // ici le code
    }

    /*
     * modifier : $Code_liste_contacts permet de se référer à la données modifiée
     * les autres paramètres booléens ($modif...) permettent d'identifier les champs qui ont été modifiés
     */
    static function modifier(int $Code_liste_contacts, bool $bool__liste_contacts_Nom, bool $bool__Code_joueur)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_supprimer(?int $Code_liste_contacts=null)
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

    static function autorisation_suppression(int $Code_liste_contacts)
    {
        return true;
    }

    static function supprimer(array $copie__liste_contacts)
    {
        // ici le code
    }

    static function supprimer_2(array $copie__liste_liste_contacts)
    {
        foreach ($copie__liste_liste_contacts as &$copie__liste_contacts)
        {
            self::supprimer($copie__liste_contacts);
        }
        unset($copie__liste_contacts);
    }

    static function est_a_jour(array &$donnees)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_liste_contacts']
         * $donnees['Code_joueur']
         * $donnees['liste_contacts_Nom']
         */
        return true;
    }

    static function mettre_a_jour(array $liste_liste_contacts)
    {
        // ici le code
    }

    static function completion(array &$donnees)
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

    static function callback_post(int $Code_liste_contacts)
    {
        return null;
    }

    static function callback_put(int $Code_liste_contacts)
    {
        return null;
    }

}
