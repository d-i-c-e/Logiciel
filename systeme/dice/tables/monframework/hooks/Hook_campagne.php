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

    static function pre_controller(&$campagne_Nom, &$campagne_Description, &$campagne_Image_Fichier, &$campagne_Nombre_joueur, &$campagne_Nombre_mj, $Code_campagne=0)
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

    static function autorisation_ajout($campagne_Nom, $campagne_Description, $campagne_Image_Fichier, $campagne_Nombre_joueur, $campagne_Nombre_mj)
    {
        return true;
    }

    static function data_controller(&$campagne_Nom, &$campagne_Description, &$campagne_Image_Fichier, &$campagne_Nombre_joueur, &$campagne_Nombre_mj, $Code_campagne=0)
    {
        // ici le code
    }

    static function calcul_signature($campagne_Nom, $campagne_Description, $campagne_Image_Fichier, $campagne_Nombre_joueur, $campagne_Nombre_mj)
    {
        return md5($campagne_Nom.'-'.$campagne_Description.'-'.$campagne_Image_Fichier.'-'.$campagne_Nombre_joueur.'-'.$campagne_Nombre_mj);
    }

    static function calcul_cle_unique($campagne_Nom, $campagne_Description, $campagne_Image_Fichier, $campagne_Nombre_joueur, $campagne_Nombre_mj)
    {
        // La méthode POST de l'API REST utilise cette fonction pour en déduire l'unicité de la données. Dans le cas contraire, la données est alors mise à jour
        // Attention au risque de collision
        return sha1($campagne_Nom.'.'.$campagne_Description.'.'.$campagne_Image_Fichier.'.'.$campagne_Nombre_joueur.'.'.$campagne_Nombre_mj);
    }

    static function ajouter($Code_campagne)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_modifier($Code_campagne=0)
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

    static function autorisation_modification($Code_campagne, $campagne_Nom__new, $campagne_Description__new, $campagne_Image_Fichier__new, $campagne_Nombre_joueur__new, $campagne_Nombre_mj__new)
    {
        return true;
    }

    static function data_controller__campagne_Nom($old, &$new, $Code_campagne)
    {
        // ici le code
    }

    static function data_controller__campagne_Description($old, &$new, $Code_campagne)
    {
        // ici le code
    }

    static function data_controller__campagne_Image_Fichier($old, &$new, $Code_campagne)
    {
        // ici le code
    }

    static function data_controller__campagne_Nombre_joueur($old, &$new, $Code_campagne)
    {
        // ici le code
    }

    static function data_controller__campagne_Nombre_mj($old, &$new, $Code_campagne)
    {
        // ici le code
    }

    /*
     * modifier : $Code_match_foot permet de se référer à la données modifiée
     * les autres paramètres booléens ($modif...) permettent d'identifier les champs qui ont été modifiés
     */
    static function modifier($Code_campagne, $bool__campagne_Nom, $bool__campagne_Description, $bool__campagne_Image_Fichier, $bool__campagne_Nombre_joueur, $bool__campagne_Nombre_mj)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_supprimer($Code_campagne=0)
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

    static function autorisation_suppression($Code_campagne)
    {
        return true;
    }

    static function supprimer($copie__campagne)
    {
        // ici le code
    }

    static function supprimer_2($copie__liste_campagne)
    {
        foreach ($copie__liste_campagne as &$copie__campagne)
        {
            self::supprimer($copie__campagne);
        }
        unset($copie__campagne);
    }

    static function est_a_jour(&$donnees)
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

    static function mettre_a_jour($liste_campagne)
    {
        // ici le code
    }

    static function completion(&$donnees)
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

    static function callback_post($Code_campagne)
    {
        return null;
    }

    static function callback_put($Code_campagne)
    {
        return null;
    }

}
