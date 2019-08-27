<?php

class Hook_groupe{

    static function initialisation() // première instanciation
    {
        // ici le code
    }

    static function actualisation() // à chaque instanciation
    {
        // ici le code
    }

    static function pre_controller(string &$groupe_Nom, string &$groupe_Description, string &$groupe_Logo_Fichier, int &$groupe_Effectif, bool &$groupe_Actif, string &$groupe_Date_creation, int &$groupe_Delai_suppression_jour, bool &$groupe_Suppression_active, int &$Code_campagne, ?int $Code_groupe=null)
    {
        // ici le code
        $db = new DB();
        if ($Code_groupe == 0) {
            $groupe_Actif = true;
            $groupe_Date_creation = get_now();
            $groupe_Delai_suppression_jour = 0;
            $groupe_Suppression_active = false;
            $groupe_Effectif = 1;
        } else {
            $groupe_Effectif = $db -> a_membre_joueur_groupe() -> mf_compter($Code_groupe, 0);
        }
    }

    static function hook_actualiser_les_droits_ajouter(?int $Code_campagne=null)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['groupe__AJOUTER']
         * $mf_droits_defaut['groupe__CREER'] // actualisation uniquement pour l'affichage
         *
         */
        // ici le code
    }

    static function autorisation_ajout(string $groupe_Nom, string $groupe_Description, string $groupe_Logo_Fichier, int $groupe_Effectif, bool $groupe_Actif, string $groupe_Date_creation, int $groupe_Delai_suppression_jour, bool $groupe_Suppression_active, int $Code_campagne)
    {
        return true;
    }

    static function data_controller(string &$groupe_Nom, string &$groupe_Description, string &$groupe_Logo_Fichier, int &$groupe_Effectif, bool &$groupe_Actif, string &$groupe_Date_creation, int &$groupe_Delai_suppression_jour, bool &$groupe_Suppression_active, int &$Code_campagne, ?int $Code_groupe=null)
    {
        // ici le code
    }

    static function calcul_signature(string $groupe_Nom, string $groupe_Description, string $groupe_Logo_Fichier, int $groupe_Effectif, bool $groupe_Actif, string $groupe_Date_creation, int $groupe_Delai_suppression_jour, bool $groupe_Suppression_active, int $Code_campagne)
    {
        return md5($groupe_Nom.'-'.$groupe_Description.'-'.$groupe_Logo_Fichier.'-'.$groupe_Effectif.'-'.$groupe_Actif.'-'.$groupe_Date_creation.'-'.$groupe_Delai_suppression_jour.'-'.$groupe_Suppression_active.'-'.$Code_campagne);
    }

    static function calcul_cle_unique(string $groupe_Nom, string $groupe_Description, string $groupe_Logo_Fichier, int $groupe_Effectif, bool $groupe_Actif, string $groupe_Date_creation, int $groupe_Delai_suppression_jour, bool $groupe_Suppression_active, int $Code_campagne)
    {
        // La méthode POST de l'API REST utilise cette fonction pour en déduire l'unicité de la données. Dans le cas contraire, la données est alors mise à jour
        // Attention au risque de collision
        return $Code_campagne.'.'.sha1($groupe_Nom.'.'.$groupe_Description.'.'.$groupe_Logo_Fichier.'.'.$groupe_Effectif.'.'.$groupe_Actif.'.'.$groupe_Date_creation.'.'.$groupe_Delai_suppression_jour.'.'.$groupe_Suppression_active);
    }

    static function ajouter(int $Code_groupe)
    {
        // ici le code
        $db = new DB();
        $db -> a_membre_joueur_groupe() -> mf_ajouter($Code_groupe, get_joueur_courant(MF_JOUEUR__ID), '', 'ADMIN', get_now());
    }

    static function hook_actualiser_les_droits_modifier(?int $Code_groupe=null)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['groupe__MODIFIER']
         *
         * $mf_droits_defaut['api_modifier__groupe_Nom']
         * $mf_droits_defaut['api_modifier__groupe_Description']
         * $mf_droits_defaut['api_modifier__groupe_Logo_Fichier']
         * $mf_droits_defaut['api_modifier__groupe_Effectif']
         * $mf_droits_defaut['api_modifier__groupe_Actif']
         * $mf_droits_defaut['api_modifier__groupe_Date_creation']
         * $mf_droits_defaut['api_modifier__groupe_Delai_suppression_jour']
         * $mf_droits_defaut['api_modifier__groupe_Suppression_active']
         *
         * $mf_droits_defaut['api_modifier_ref__groupe__Code_campagne']
         *
         */
        // ici le code
    }

    static function autorisation_modification(int $Code_groupe, string $groupe_Nom__new, string $groupe_Description__new, string $groupe_Logo_Fichier__new, int $groupe_Effectif__new, bool $groupe_Actif__new, string $groupe_Date_creation__new, int $groupe_Delai_suppression_jour__new, bool $groupe_Suppression_active__new, int $Code_campagne__new)
    {
        return true;
    }

    static function data_controller__groupe_Nom(string $old, string &$new, int $Code_groupe)
    {
        // ici le code
    }

    static function data_controller__groupe_Description(string $old, string &$new, int $Code_groupe)
    {
        // ici le code
    }

    static function data_controller__groupe_Logo_Fichier(string $old, string &$new, int $Code_groupe)
    {
        // ici le code
    }

    static function data_controller__groupe_Effectif(int $old, int &$new, int $Code_groupe)
    {
        // ici le code
    }

    static function data_controller__groupe_Actif(bool $old, bool &$new, int $Code_groupe)
    {
        // ici le code
    }

    static function data_controller__groupe_Date_creation(string $old, string &$new, int $Code_groupe)
    {
        // ici le code
    }

    static function data_controller__groupe_Delai_suppression_jour(int $old, int &$new, int $Code_groupe)
    {
        // ici le code
    }

    static function data_controller__groupe_Suppression_active(bool $old, bool &$new, int $Code_groupe)
    {
        // ici le code
    }

    static function data_controller__Code_campagne(int $old, int &$new, int $Code_groupe)
    {
        // ici le code
    }

    /*
     * modifier : $Code_groupe permet de se référer à la données modifiée
     * les autres paramètres booléens ($modif...) permettent d'identifier les champs qui ont été modifiés
     */
    static function modifier(int $Code_groupe, bool $bool__groupe_Nom, bool $bool__groupe_Description, bool $bool__groupe_Logo_Fichier, bool $bool__groupe_Effectif, bool $bool__groupe_Actif, bool $bool__groupe_Date_creation, bool $bool__groupe_Delai_suppression_jour, bool $bool__groupe_Suppression_active, bool $bool__Code_campagne)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_supprimer(?int $Code_groupe=null)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['groupe__SUPPRIMER']
         *
         */
        // Ici le code
        if ($Code_groupe!=0 && $mf_droits_defaut['groupe__SUPPRIMER'])
        {
            $table_personnage = new personnage();
            $table_carte = new carte();
            $mf_droits_defaut['groupe__SUPPRIMER'] = $table_personnage->mfi_compter(array('Code_groupe'=>$Code_groupe))==0 && $table_carte->mfi_compter(array('Code_groupe'=>$Code_groupe))==0;
        }
    }

    static function autorisation_suppression(int $Code_groupe)
    {
        return true;
    }

    static function supprimer(array $copie__groupe)
    {
        // ici le code
    }

    static function supprimer_2(array $copie__liste_groupe)
    {
        foreach ($copie__liste_groupe as &$copie__groupe)
        {
            self::supprimer($copie__groupe);
        }
        unset($copie__groupe);
    }

    static function est_a_jour(array &$donnees)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_groupe']
         * $donnees['Code_campagne']
         * $donnees['groupe_Nom']
         * $donnees['groupe_Description']
         * $donnees['groupe_Logo_Fichier']
         * $donnees['groupe_Effectif']
         * $donnees['groupe_Actif']
         * $donnees['groupe_Date_creation']
         * $donnees['groupe_Delai_suppression_jour']
         * $donnees['groupe_Suppression_active']
         */
        return true;
    }

    static function mettre_a_jour(array $liste_groupe)
    {
        // ici le code
    }

    static function completion(array &$donnees)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_groupe']
         * $donnees['Code_campagne']
         * $donnees['groupe_Nom']
         * $donnees['groupe_Description']
         * $donnees['groupe_Logo_Fichier']
         * $donnees['groupe_Effectif']
         * $donnees['groupe_Actif']
         * $donnees['groupe_Date_creation']
         * $donnees['groupe_Delai_suppression_jour']
         * $donnees['groupe_Suppression_active']
         */
        // ici le code
    }

    // API callbacks
    // -------------------

    static function callback_post(int $Code_groupe)
    {
        return null;
    }

    static function callback_put(int $Code_groupe)
    {
        return null;
    }

}
