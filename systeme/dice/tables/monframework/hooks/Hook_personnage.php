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

    static function pre_controller(string &$personnage_Fichier_Fichier, bool &$personnage_Conservation, int &$Code_joueur, int &$Code_groupe, ?int $Code_personnage=null)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_ajouter(?int $Code_joueur=null, ?int $Code_groupe=null)
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

    static function autorisation_ajout(string $personnage_Fichier_Fichier, bool $personnage_Conservation, int $Code_joueur, int $Code_groupe)
    {
        return true;
    }

    static function data_controller(string &$personnage_Fichier_Fichier, bool &$personnage_Conservation, int &$Code_joueur, int &$Code_groupe, ?int $Code_personnage=null)
    {
        // ici le code
    }

    static function calcul_signature(string $personnage_Fichier_Fichier, bool $personnage_Conservation, int $Code_joueur, int $Code_groupe)
    {
        return md5($personnage_Fichier_Fichier.'-'.$personnage_Conservation.'-'.$Code_joueur.'-'.$Code_groupe);
    }

    static function calcul_cle_unique(string $personnage_Fichier_Fichier, bool $personnage_Conservation, int $Code_joueur, int $Code_groupe)
    {
        // La méthode POST de l'API REST utilise cette fonction pour en déduire l'unicité de la données. Dans le cas contraire, la données est alors mise à jour
        // Attention au risque de collision
        return $Code_groupe.'.'.$Code_joueur.'.'.sha1($personnage_Fichier_Fichier.'.'.$personnage_Conservation);
    }

    static function ajouter(int $Code_personnage)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_modifier(?int $Code_personnage=null)
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
        $db = new DB();
        $personnage = $db -> personnage() -> mf_get($Code_personnage);
        if (get_joueur_courant(MF_JOUEUR__ID) == $personnage[MF_PERSONNAGE_CODE_JOUEUR]) {
            $mf_droits_defaut['api_modifier__personnage_Fichier_Fichier'] = true;
        }
    }

    static function autorisation_modification(int $Code_personnage, string $personnage_Fichier_Fichier__new, bool $personnage_Conservation__new, int $Code_joueur__new, int $Code_groupe__new)
    {
        return true;
    }

    static function data_controller__personnage_Fichier_Fichier(string $old, string &$new, int $Code_personnage)
    {
        // ici le code
    }

    static function data_controller__personnage_Conservation(bool $old, bool &$new, int $Code_personnage)
    {
        // ici le code
    }

    static function data_controller__Code_joueur(int $old, int &$new, int $Code_personnage)
    {
        // ici le code
    }

    static function data_controller__Code_groupe(int $old, int &$new, int $Code_personnage)
    {
        // ici le code
    }

    /*
     * modifier : $Code_personnage permet de se référer à la données modifiée
     * les autres paramètres booléens ($modif...) permettent d'identifier les champs qui ont été modifiés
     */
    static function modifier(int $Code_personnage, bool $bool__personnage_Fichier_Fichier, bool $bool__personnage_Conservation, bool $bool__Code_joueur, bool $bool__Code_groupe)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_supprimer(?int $Code_personnage=null)
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

    static function autorisation_suppression(int $Code_personnage)
    {
        return true;
    }

    static function supprimer(array $copie__personnage)
    {
        // ici le code
    }

    static function supprimer_2(array $copie__liste_personnage)
    {
        foreach ($copie__liste_personnage as &$copie__personnage)
        {
            self::supprimer($copie__personnage);
        }
        unset($copie__personnage);
    }

    static function est_a_jour(array &$donnees)
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

    static function mettre_a_jour(array $liste_personnage)
    {
        // ici le code
    }

    static function completion(array &$donnees)
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

    static function callback_post(int $Code_personnage)
    {
        return null;
    }

    static function callback_put(int $Code_personnage)
    {
        return null;
    }

}
