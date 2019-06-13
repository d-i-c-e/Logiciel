<?php

class Hook_ressource{

    static function initialisation() // première instanciation
    {
        // ici le code
    }

    static function actualisation() // à chaque instanciation
    {
        // ici le code
    }

    static function pre_controller(&$ressource_Nom, $Code_ressource=0)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_ajouter()
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['ressource__AJOUTER']
         * $mf_droits_defaut['ressource__CREER'] // actualisation uniquement pour l'affichage
         *
         */
        // ici le code
    }

    static function autorisation_ajout($ressource_Nom)
    {
        return true;
    }

    static function data_controller(&$ressource_Nom, $Code_ressource=0)
    {
        // ici le code
    }

    static function calcul_signature($ressource_Nom)
    {
        return md5($ressource_Nom);
    }

    static function calcul_cle_unique($ressource_Nom)
    {
        // La méthode POST de l'API REST utilise cette fonction pour en déduire l'unicité de la données. Dans le cas contraire, la données est alors mise à jour
        // Attention au risque de collision
        return sha1($ressource_Nom);
    }

    static function ajouter($Code_ressource)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_modifier($Code_ressource=0)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['ressource__MODIFIER']
         *
         * $mf_droits_defaut['api_modifier__ressource_Nom']
         *
         */
        // ici le code
    }

    static function autorisation_modification($Code_ressource, $ressource_Nom__new)
    {
        return true;
    }

    static function data_controller__ressource_Nom($old, &$new, $Code_ressource)
    {
        // ici le code
    }

    /*
     * modifier : $Code_match_foot permet de se référer à la données modifiée
     * les autres paramètres booléens ($modif...) permettent d'identifier les champs qui ont été modifiés
     */
    static function modifier($Code_ressource, $bool__ressource_Nom)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_supprimer($Code_ressource=0)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['ressource__SUPPRIMER']
         *
         */
        // Ici le code
        if ($Code_ressource!=0 && $mf_droits_defaut['ressource__SUPPRIMER'])
        {
            $table_type = new type();
            $mf_droits_defaut['ressource__SUPPRIMER'] = $table_type->mfi_compter(array('Code_ressource'=>$Code_ressource))==0;
        }
    }

    static function autorisation_suppression($Code_ressource)
    {
        return true;
    }

    static function supprimer($copie__ressource)
    {
        // ici le code
    }

    static function supprimer_2($copie__liste_ressource)
    {
        foreach ($copie__liste_ressource as &$copie__ressource)
        {
            self::supprimer($copie__ressource);
        }
        unset($copie__ressource);
    }

    static function est_a_jour(&$donnees)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_ressource']
         * $donnees['ressource_Nom']
         */
        return true;
    }

    static function mettre_a_jour($liste_ressource)
    {
        // ici le code
    }

    static function completion(&$donnees)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_ressource']
         * $donnees['ressource_Nom']
         */
        // ici le code
    }

    // API callbacks
    // -------------------

    static function callback_post($Code_ressource)
    {
        return null;
    }

    static function callback_put($Code_ressource)
    {
        return null;
    }

}
