<?php

class Hook_parametre{

    static function initialisation() // première instanciation
    {
        // ici le code
    }

    static function actualisation() // à chaque instanciation
    {
        // ici le code
    }

    static function pre_controller(string &$parametre_Libelle, bool &$parametre_Activable, ?int $Code_parametre=null)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_ajouter()
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['parametre__AJOUTER']
         * $mf_droits_defaut['parametre__CREER'] // actualisation uniquement pour l'affichage
         *
         */
        // ici le code
    }

    static function autorisation_ajout(string $parametre_Libelle, bool $parametre_Activable)
    {
        return true;
    }

    static function data_controller(string &$parametre_Libelle, bool &$parametre_Activable, ?int $Code_parametre=null)
    {
        // ici le code
    }

    static function calcul_signature(string $parametre_Libelle, bool $parametre_Activable)
    {
        return md5($parametre_Libelle.'-'.$parametre_Activable);
    }

    static function calcul_cle_unique(string $parametre_Libelle, bool $parametre_Activable)
    {
        // La méthode POST de l'API REST utilise cette fonction pour en déduire l'unicité de la données. Dans le cas contraire, la données est alors mise à jour
        // Attention au risque de collision
        return sha1($parametre_Libelle.'.'.$parametre_Activable);
    }

    static function ajouter(int $Code_parametre)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_modifier(?int $Code_parametre=null)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['parametre__MODIFIER']
         *
         * $mf_droits_defaut['api_modifier__parametre_Libelle']
         * $mf_droits_defaut['api_modifier__parametre_Activable']
         *
         */
        // ici le code
    }

    static function autorisation_modification(int $Code_parametre, string $parametre_Libelle__new, bool $parametre_Activable__new)
    {
        return true;
    }

    static function data_controller__parametre_Libelle(string $old, string &$new, int $Code_parametre)
    {
        // ici le code
    }

    static function data_controller__parametre_Activable(bool $old, bool &$new, int $Code_parametre)
    {
        // ici le code
    }

    /*
     * modifier : $Code_parametre permet de se référer à la données modifiée
     * les autres paramètres booléens ($modif...) permettent d'identifier les champs qui ont été modifiés
     */
    static function modifier(int $Code_parametre, bool $bool__parametre_Libelle, bool $bool__parametre_Activable)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_supprimer(?int $Code_parametre=null)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['parametre__SUPPRIMER']
         *
         */
        // Ici le code
        if ($Code_parametre!=0 && $mf_droits_defaut['parametre__SUPPRIMER'])
        {
            $table_parametre_valeur = new parametre_valeur();
            $mf_droits_defaut['parametre__SUPPRIMER'] = $table_parametre_valeur->mfi_compter(array('Code_parametre'=>$Code_parametre))==0;
        }
    }

    static function autorisation_suppression(int $Code_parametre)
    {
        return true;
    }

    static function supprimer(array $copie__parametre)
    {
        // ici le code
    }

    static function supprimer_2(array $copie__liste_parametre)
    {
        foreach ($copie__liste_parametre as &$copie__parametre)
        {
            self::supprimer($copie__parametre);
        }
        unset($copie__parametre);
    }

    static function est_a_jour(array &$donnees)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_parametre']
         * $donnees['parametre_Libelle']
         * $donnees['parametre_Activable']
         */
        return true;
    }

    static function mettre_a_jour(array $liste_parametre)
    {
        // ici le code
    }

    static function completion(array &$donnees)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_parametre']
         * $donnees['parametre_Libelle']
         * $donnees['parametre_Activable']
         */
        // ici le code
    }

    // API callbacks
    // -------------------

    static function callback_post(int $Code_parametre)
    {
        return null;
    }

    static function callback_put(int $Code_parametre)
    {
        return null;
    }

}
