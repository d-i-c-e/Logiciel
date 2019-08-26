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

    static function pre_controller(string &$type_Libelle, int &$Code_ressource, ?int $Code_type=null)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_ajouter(?int $Code_ressource=null)
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
        if (est_administrateur()) {
            $mf_droits_defaut['type__AJOUTER'] = true;
        }
    }

    static function autorisation_ajout(string $type_Libelle, int $Code_ressource)
    {
        return true;
    }

    static function data_controller(string &$type_Libelle, int &$Code_ressource, ?int $Code_type=null)
    {
        // ici le code
    }

    static function calcul_signature(string $type_Libelle, int $Code_ressource)
    {
        return md5($type_Libelle.'-'.$Code_ressource);
    }

    static function calcul_cle_unique(string $type_Libelle, int $Code_ressource)
    {
        // La méthode POST de l'API REST utilise cette fonction pour en déduire l'unicité de la données. Dans le cas contraire, la données est alors mise à jour
        // Attention au risque de collision
        return $Code_ressource.'.'.sha1($type_Libelle);
    }

    static function ajouter(int $Code_type)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_modifier(?int $Code_type=null)
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
        if (est_administrateur()) {
            $mf_droits_defaut['api_modifier__type_Libelle'] = true;
        }
    }

    static function autorisation_modification(int $Code_type, string $type_Libelle__new, int $Code_ressource__new)
    {
        return true;
    }

    static function data_controller__type_Libelle(string $old, string &$new, int $Code_type)
    {
        // ici le code
    }

    static function data_controller__Code_ressource(int $old, int &$new, int $Code_type)
    {
        // ici le code
    }

    /*
     * modifier : $Code_type permet de se référer à la données modifiée
     * les autres paramètres booléens ($modif...) permettent d'identifier les champs qui ont été modifiés
     */
    static function modifier(int $Code_type, bool $bool__type_Libelle, bool $bool__Code_ressource)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_supprimer(?int $Code_type=null)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['type__SUPPRIMER']
         *
         */
        // Ici le code
        if (est_administrateur()) {
            $mf_droits_defaut['type__SUPPRIMER'] = true;
        }
        if ($Code_type!=0 && $mf_droits_defaut['type__SUPPRIMER'])
        {
            $table_objet = new objet();
            $mf_droits_defaut['type__SUPPRIMER'] = $table_objet->mfi_compter(array('Code_type'=>$Code_type))==0;
        }
    }

    static function autorisation_suppression(int $Code_type)
    {
        return true;
    }

    static function supprimer(array $copie__type)
    {
        // ici le code
    }

    static function supprimer_2(array $copie__liste_type)
    {
        foreach ($copie__liste_type as &$copie__type)
        {
            self::supprimer($copie__type);
        }
        unset($copie__type);
    }

    static function est_a_jour(array &$donnees)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_type']
         * $donnees['Code_ressource']
         * $donnees['type_Libelle']
         */
        return true;
    }

    static function mettre_a_jour(array $liste_type)
    {
        // ici le code
    }

    static function completion(array &$donnees)
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

    static function callback_post(int $Code_type)
    {
        return null;
    }

    static function callback_put(int $Code_type)
    {
        return null;
    }

}
