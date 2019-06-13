<?php

class Hook_type{

    static function initialisation() // première instanciation
    {
        // ici le code
    }

    static function actualisation() // à chaque instanciation
    {
        // ici le code
    }

    static function pre_controller(&$type_Libelle, &$Code_ressource, $Code_type=0)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_ajouter($Code_ressource=0)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['type__AJOUTER']
         * $mf_droits_defaut['type__CREER'] // actualisation uniquement pour l'affichage
         *
         */
        // ici le code
    }

    static function autorisation_ajout($type_Libelle, $Code_ressource)
    {
        return true;
    }

    static function data_controller(&$type_Libelle, &$Code_ressource, $Code_type=0)
    {
        // ici le code
    }

    static function calcul_signature($type_Libelle, $Code_ressource)
    {
        return md5($type_Libelle.'-'.$Code_ressource);
    }

    static function calcul_cle_unique($type_Libelle, $Code_ressource)
    {
        // La méthode POST de l'API REST utilise cette fonction pour en déduire l'unicité de la données. Dans le cas contraire, la données est alors mise à jour
        // Attention au risque de collision
        return $Code_ressource.'.'.sha1($type_Libelle);
    }

    static function ajouter($Code_type)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_modifier($Code_type=0)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['type__MODIFIER']
         *
         * $mf_droits_defaut['api_modifier__type_Libelle']
         *
         * $mf_droits_defaut['api_modifier_ref__type__Code_ressource']
         *
         */
        // ici le code
    }

    static function autorisation_modification($Code_type, $type_Libelle__new, $Code_ressource__new)
    {
        return true;
    }

    static function data_controller__type_Libelle($old, &$new, $Code_type)
    {
        // ici le code
    }

    static function data_controller__Code_ressource($old, &$new, $Code_type)
    {
        // ici le code
    }

    /*
     * modifier : $Code_match_foot permet de se référer à la données modifiée
     * les autres paramètres booléens ($modif...) permettent d'identifier les champs qui ont été modifiés
     */
    static function modifier($Code_type, $bool__type_Libelle, $bool__Code_ressource)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_supprimer($Code_type=0)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['type__SUPPRIMER']
         *
         */
        // Ici le code
        if ($Code_type!=0 && $mf_droits_defaut['type__SUPPRIMER'])
        {
            $table_objet = new objet();
            $mf_droits_defaut['type__SUPPRIMER'] = $table_objet->mfi_compter(array('Code_type'=>$Code_type))==0;
        }
    }

    static function autorisation_suppression($Code_type)
    {
        return true;
    }

    static function supprimer($copie__type)
    {
        // ici le code
    }

    static function supprimer_2($copie__liste_type)
    {
        foreach ($copie__liste_type as &$copie__type)
        {
            self::supprimer($copie__type);
        }
        unset($copie__type);
    }

    static function est_a_jour(&$donnees)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_type']
         * $donnees['Code_ressource']
         * $donnees['type_Libelle']
         */
        return true;
    }

    static function mettre_a_jour($liste_type)
    {
        // ici le code
    }

    static function completion(&$donnees)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_type']
         * $donnees['Code_ressource']
         * $donnees['type_Libelle']
         */
        // ici le code
    }

    // API callbacks
    // -------------------

    static function callback_post($Code_type)
    {
        return null;
    }

    static function callback_put($Code_type)
    {
        return null;
    }

}
