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

    static function pre_controller(&$groupe_Nom, &$groupe_Description, &$groupe_Logo_Fichier, &$groupe_Effectif, &$groupe_Actif, &$groupe_Date_creation, &$groupe_Delai_suppression_jour, &$groupe_Suppression_active, &$Code_campagne, $Code_groupe=0)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_ajouter($Code_campagne=0)
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

    static function autorisation_ajout($groupe_Nom, $groupe_Description, $groupe_Logo_Fichier, $groupe_Effectif, $groupe_Actif, $groupe_Date_creation, $groupe_Delai_suppression_jour, $groupe_Suppression_active, $Code_campagne)
    {
        return true;
    }

    static function data_controller(&$groupe_Nom, &$groupe_Description, &$groupe_Logo_Fichier, &$groupe_Effectif, &$groupe_Actif, &$groupe_Date_creation, &$groupe_Delai_suppression_jour, &$groupe_Suppression_active, &$Code_campagne, $Code_groupe=0)
    {
        // ici le code
    }

    static function calcul_signature($groupe_Nom, $groupe_Description, $groupe_Logo_Fichier, $groupe_Effectif, $groupe_Actif, $groupe_Date_creation, $groupe_Delai_suppression_jour, $groupe_Suppression_active, $Code_campagne)
    {
        return md5($groupe_Nom.'-'.$groupe_Description.'-'.$groupe_Logo_Fichier.'-'.$groupe_Effectif.'-'.$groupe_Actif.'-'.$groupe_Date_creation.'-'.$groupe_Delai_suppression_jour.'-'.$groupe_Suppression_active.'-'.$Code_campagne);
    }

    static function calcul_cle_unique($groupe_Nom, $groupe_Description, $groupe_Logo_Fichier, $groupe_Effectif, $groupe_Actif, $groupe_Date_creation, $groupe_Delai_suppression_jour, $groupe_Suppression_active, $Code_campagne)
    {
        // La méthode POST de l'API REST utilise cette fonction pour en déduire l'unicité de la données. Dans le cas contraire, la données est alors mise à jour
        // Attention au risque de collision
        return $Code_campagne.'.'.sha1($groupe_Nom.'.'.$groupe_Description.'.'.$groupe_Logo_Fichier.'.'.$groupe_Effectif.'.'.$groupe_Actif.'.'.$groupe_Date_creation.'.'.$groupe_Delai_suppression_jour.'.'.$groupe_Suppression_active);
    }

    static function ajouter($Code_groupe)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_modifier($Code_groupe=0)
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

    static function autorisation_modification($Code_groupe, $groupe_Nom__new, $groupe_Description__new, $groupe_Logo_Fichier__new, $groupe_Effectif__new, $groupe_Actif__new, $groupe_Date_creation__new, $groupe_Delai_suppression_jour__new, $groupe_Suppression_active__new, $Code_campagne__new)
    {
        return true;
    }

    static function data_controller__groupe_Nom($old, &$new, $Code_groupe)
    {
        // ici le code
    }

    static function data_controller__groupe_Description($old, &$new, $Code_groupe)
    {
        // ici le code
    }

    static function data_controller__groupe_Logo_Fichier($old, &$new, $Code_groupe)
    {
        // ici le code
    }

    static function data_controller__groupe_Effectif($old, &$new, $Code_groupe)
    {
        // ici le code
    }

    static function data_controller__groupe_Actif($old, &$new, $Code_groupe)
    {
        // ici le code
    }

    static function data_controller__groupe_Date_creation($old, &$new, $Code_groupe)
    {
        // ici le code
    }

    static function data_controller__groupe_Delai_suppression_jour($old, &$new, $Code_groupe)
    {
        // ici le code
    }

    static function data_controller__groupe_Suppression_active($old, &$new, $Code_groupe)
    {
        // ici le code
    }

    static function data_controller__Code_campagne($old, &$new, $Code_groupe)
    {
        // ici le code
    }

    /*
     * modifier : $Code_match_foot permet de se référer à la données modifiée
     * les autres paramètres booléens ($modif...) permettent d'identifier les champs qui ont été modifiés
     */
    static function modifier($Code_groupe, $bool__groupe_Nom, $bool__groupe_Description, $bool__groupe_Logo_Fichier, $bool__groupe_Effectif, $bool__groupe_Actif, $bool__groupe_Date_creation, $bool__groupe_Delai_suppression_jour, $bool__groupe_Suppression_active, $bool__Code_campagne)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_supprimer($Code_groupe=0)
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

    static function autorisation_suppression($Code_groupe)
    {
        return true;
    }

    static function supprimer($copie__groupe)
    {
        // ici le code
    }

    static function supprimer_2($copie__liste_groupe)
    {
        foreach ($copie__liste_groupe as &$copie__groupe)
        {
            self::supprimer($copie__groupe);
        }
        unset($copie__groupe);
    }

    static function est_a_jour(&$donnees)
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

    static function mettre_a_jour($liste_groupe)
    {
        // ici le code
    }

    static function completion(&$donnees)
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

    static function callback_post($Code_groupe)
    {
        return null;
    }

    static function callback_put($Code_groupe)
    {
        return null;
    }

}
