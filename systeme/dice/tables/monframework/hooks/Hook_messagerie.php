<?php

class Hook_messagerie{

    static function initialisation() // première instanciation
    {
        // ici le code
    }

    static function actualisation() // à chaque instanciation
    {
        // ici le code
    }

    static function pre_controller(string &$messagerie_Nom, int &$Code_joueur, ?int $Code_messagerie=null)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_ajouter(?int $Code_joueur=null)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['messagerie__AJOUTER']
         * $mf_droits_defaut['messagerie__CREER'] // actualisation uniquement pour l'affichage
         *
         */
        // ici le code
    }

    static function autorisation_ajout(string $messagerie_Nom, int $Code_joueur)
    {
        return true;
    }

    static function data_controller(string &$messagerie_Nom, int &$Code_joueur, ?int $Code_messagerie=null)
    {
        // ici le code
    }

    static function calcul_signature(string $messagerie_Nom, int $Code_joueur)
    {
        return md5($messagerie_Nom.'-'.$Code_joueur);
    }

    static function calcul_cle_unique(string $messagerie_Nom, int $Code_joueur)
    {
        // La méthode POST de l'API REST utilise cette fonction pour en déduire l'unicité de la données. Dans le cas contraire, la données est alors mise à jour
        // Attention au risque de collision
        return $Code_joueur.'.'.sha1($messagerie_Nom);
    }

    static function ajouter(int $Code_messagerie)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_modifier(?int $Code_messagerie=null)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['messagerie__MODIFIER']
         *
         * $mf_droits_defaut['api_modifier__messagerie_Nom']
         *
         * $mf_droits_defaut['api_modifier_ref__messagerie__Code_joueur']
         *
         */
        // ici le code
    }

    static function autorisation_modification(int $Code_messagerie, string $messagerie_Nom__new, int $Code_joueur__new)
    {
        return true;
    }

    static function data_controller__messagerie_Nom(string $old, string &$new, int $Code_messagerie)
    {
        // ici le code
    }

    static function data_controller__Code_joueur(int $old, int &$new, int $Code_messagerie)
    {
        // ici le code
    }

    /*
     * modifier : $Code_messagerie permet de se référer à la données modifiée
     * les autres paramètres booléens ($modif...) permettent d'identifier les champs qui ont été modifiés
     */
    static function modifier(int $Code_messagerie, bool $bool__messagerie_Nom, bool $bool__Code_joueur)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_supprimer(?int $Code_messagerie=null)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['messagerie__SUPPRIMER']
         *
         */
        // Ici le code
        if ($Code_messagerie!=0 && $mf_droits_defaut['messagerie__SUPPRIMER'])
        {
            $table_message = new message();
            $mf_droits_defaut['messagerie__SUPPRIMER'] = $table_message->mfi_compter(array('Code_messagerie'=>$Code_messagerie))==0;
        }
    }

    static function autorisation_suppression(int $Code_messagerie)
    {
        return true;
    }

    static function supprimer(array $copie__messagerie)
    {
        // ici le code
    }

    static function supprimer_2(array $copie__liste_messagerie)
    {
        foreach ($copie__liste_messagerie as &$copie__messagerie)
        {
            self::supprimer($copie__messagerie);
        }
        unset($copie__messagerie);
    }

    static function est_a_jour(array &$donnees)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_messagerie']
         * $donnees['Code_joueur']
         * $donnees['messagerie_Nom']
         */
        return true;
    }

    static function mettre_a_jour(array $liste_messagerie)
    {
        // ici le code
    }

    static function completion(array &$donnees)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_messagerie']
         * $donnees['Code_joueur']
         * $donnees['messagerie_Nom']
         */
        // ici le code
    }

    // API callbacks
    // -------------------

    static function callback_post(int $Code_messagerie)
    {
        return null;
    }

    static function callback_put(int $Code_messagerie)
    {
        return null;
    }

}
