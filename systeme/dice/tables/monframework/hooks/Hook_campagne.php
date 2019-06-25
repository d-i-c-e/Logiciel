<?php

class Hook_campagne{

    static function initialisation() // première instanciation
    {
        // ici le code
    }

    static function actualisation() // à chaque instanciation
    {
        // ici le code
    }

    static function pre_controller(string &$campagne_Nom, string &$campagne_Description, string &$campagne_Image_Fichier, int &$campagne_Nombre_joueur, int &$campagne_Nombre_mj, ?int $Code_campagne=null)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_ajouter()
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['campagne__AJOUTER']
         * $mf_droits_defaut['campagne__CREER'] // actualisation uniquement pour l'affichage
         *
         */
        // ici le code
    }

    static function autorisation_ajout(string $campagne_Nom, string $campagne_Description, string $campagne_Image_Fichier, int $campagne_Nombre_joueur, int $campagne_Nombre_mj)
    {
        return true;
    }

    static function data_controller(string &$campagne_Nom, string &$campagne_Description, string &$campagne_Image_Fichier, int &$campagne_Nombre_joueur, int &$campagne_Nombre_mj, ?int $Code_campagne=null)
    {
        // ici le code
    }

    static function calcul_signature(string $campagne_Nom, string $campagne_Description, string $campagne_Image_Fichier, int $campagne_Nombre_joueur, int $campagne_Nombre_mj)
    {
        return md5($campagne_Nom.'-'.$campagne_Description.'-'.$campagne_Image_Fichier.'-'.$campagne_Nombre_joueur.'-'.$campagne_Nombre_mj);
    }

    static function calcul_cle_unique(string $campagne_Nom, string $campagne_Description, string $campagne_Image_Fichier, int $campagne_Nombre_joueur, int $campagne_Nombre_mj)
    {
        // La méthode POST de l'API REST utilise cette fonction pour en déduire l'unicité de la données. Dans le cas contraire, la données est alors mise à jour
        // Attention au risque de collision
        return sha1($campagne_Nom.'.'.$campagne_Description.'.'.$campagne_Image_Fichier.'.'.$campagne_Nombre_joueur.'.'.$campagne_Nombre_mj);
    }

    static function ajouter(int $Code_campagne)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_modifier(?int $Code_campagne=null)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['campagne__MODIFIER']
         *
         * $mf_droits_defaut['api_modifier__campagne_Nom']
         * $mf_droits_defaut['api_modifier__campagne_Description']
         * $mf_droits_defaut['api_modifier__campagne_Image_Fichier']
         * $mf_droits_defaut['api_modifier__campagne_Nombre_joueur']
         * $mf_droits_defaut['api_modifier__campagne_Nombre_mj']
         *
         */
        // ici le code
    }

    static function autorisation_modification(int $Code_campagne, string $campagne_Nom__new, string $campagne_Description__new, string $campagne_Image_Fichier__new, int $campagne_Nombre_joueur__new, int $campagne_Nombre_mj__new)
    {
        return true;
    }

    static function data_controller__campagne_Nom(string $old, string &$new, int $Code_campagne)
    {
        // ici le code
    }

    static function data_controller__campagne_Description(string $old, string &$new, int $Code_campagne)
    {
        // ici le code
    }

    static function data_controller__campagne_Image_Fichier(string $old, string &$new, int $Code_campagne)
    {
        // ici le code
    }

    static function data_controller__campagne_Nombre_joueur(int $old, int &$new, int $Code_campagne)
    {
        // ici le code
    }

    static function data_controller__campagne_Nombre_mj(int $old, int &$new, int $Code_campagne)
    {
        // ici le code
    }

    /*
     * modifier : $Code_campagne permet de se référer à la données modifiée
     * les autres paramètres booléens ($modif...) permettent d'identifier les champs qui ont été modifiés
     */
    static function modifier(int $Code_campagne, bool $bool__campagne_Nom, bool $bool__campagne_Description, bool $bool__campagne_Image_Fichier, bool $bool__campagne_Nombre_joueur, bool $bool__campagne_Nombre_mj)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_supprimer(?int $Code_campagne=null)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['campagne__SUPPRIMER']
         *
         */
        // Ici le code
        if ($Code_campagne!=0 && $mf_droits_defaut['campagne__SUPPRIMER'])
        {
            $table_groupe = new groupe();
            $mf_droits_defaut['campagne__SUPPRIMER'] = $table_groupe->mfi_compter(array('Code_campagne'=>$Code_campagne))==0;
        }
    }

    static function autorisation_suppression(int $Code_campagne)
    {
        return true;
    }

    static function supprimer(array $copie__campagne)
    {
        // ici le code
    }

    static function supprimer_2(array $copie__liste_campagne)
    {
        foreach ($copie__liste_campagne as &$copie__campagne)
        {
            self::supprimer($copie__campagne);
        }
        unset($copie__campagne);
    }

    static function est_a_jour(array &$donnees)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_campagne']
         * $donnees['campagne_Nom']
         * $donnees['campagne_Description']
         * $donnees['campagne_Image_Fichier']
         * $donnees['campagne_Nombre_joueur']
         * $donnees['campagne_Nombre_mj']
         */
        return true;
    }

    static function mettre_a_jour(array $liste_campagne)
    {
        // ici le code
    }

    static function completion(array &$donnees)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_campagne']
         * $donnees['campagne_Nom']
         * $donnees['campagne_Description']
         * $donnees['campagne_Image_Fichier']
         * $donnees['campagne_Nombre_joueur']
         * $donnees['campagne_Nombre_mj']
         */
        // ici le code
    }

    // API callbacks
    // -------------------

    static function callback_post(int $Code_campagne)
    {
        return null;
    }

    static function callback_put(int $Code_campagne)
    {
        return null;
    }

}
