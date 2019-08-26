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

    static function pre_controller(string &$ressource_Nom, ?int $Code_ressource=null)
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
        if (est_administrateur()) {
            $mf_droits_defaut['ressource__AJOUTER'] = true;
        }
    }

    static function autorisation_ajout(string $ressource_Nom)
    {
        return true;
    }

    static function data_controller(string &$ressource_Nom, ?int $Code_ressource=null)
    {
        // ici le code
    }

    static function calcul_signature(string $ressource_Nom)
    {
        return md5($ressource_Nom);
    }

    static function calcul_cle_unique(string $ressource_Nom)
    {
        // La méthode POST de l'API REST utilise cette fonction pour en déduire l'unicité de la données. Dans le cas contraire, la données est alors mise à jour
        // Attention au risque de collision
        return sha1($ressource_Nom);
    }

    static function ajouter(int $Code_ressource)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_modifier(?int $Code_ressource=null)
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
        if (est_administrateur()) {
            $mf_droits_defaut['api_modifier__ressource_Nom'] = true;
        }
    }

    static function autorisation_modification(int $Code_ressource, string $ressource_Nom__new)
    {
        return true;
    }

    static function data_controller__ressource_Nom(string $old, string &$new, int $Code_ressource)
    {
        // ici le code
    }

    /*
     * modifier : $Code_ressource permet de se référer à la données modifiée
     * les autres paramètres booléens ($modif...) permettent d'identifier les champs qui ont été modifiés
     */
    static function modifier(int $Code_ressource, bool $bool__ressource_Nom)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_supprimer(?int $Code_ressource=null)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['ressource__SUPPRIMER']
         *
         */
        // Ici le code
        if (est_administrateur()) {
            $mf_droits_defaut['ressource__SUPPRIMER'] = true;
        }
        if ($Code_ressource!=0 && $mf_droits_defaut['ressource__SUPPRIMER'])
        {
            $table_type = new type();
            $mf_droits_defaut['ressource__SUPPRIMER'] = $table_type->mfi_compter(array('Code_ressource'=>$Code_ressource))==0;
        }
    }

    static function autorisation_suppression(int $Code_ressource)
    {
        return true;
    }

    static function supprimer(array $copie__ressource)
    {
        // ici le code
    }

    static function supprimer_2(array $copie__liste_ressource)
    {
        foreach ($copie__liste_ressource as &$copie__ressource)
        {
            self::supprimer($copie__ressource);
        }
        unset($copie__ressource);
    }

    static function est_a_jour(array &$donnees)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_ressource']
         * $donnees['ressource_Nom']
         */
        return true;
    }

    static function mettre_a_jour(array $liste_ressource)
    {
        // ici le code
    }

    static function completion(array &$donnees)
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

    static function callback_post(int $Code_ressource)
    {
        return null;
    }

    static function callback_put(int $Code_ressource)
    {
        return null;
    }

}
