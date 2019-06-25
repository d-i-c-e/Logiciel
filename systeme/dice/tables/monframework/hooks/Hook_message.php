<?php

class Hook_message{

    static function initialisation() // première instanciation
    {
        // ici le code
    }

    static function actualisation() // à chaque instanciation
    {
        // ici le code
    }

    static function pre_controller(string &$message_Texte, string &$message_Date, int &$Code_messagerie, int &$Code_joueur, ?int $Code_message=null)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_ajouter(?int $Code_messagerie=null, ?int $Code_joueur=null)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['message__AJOUTER']
         * $mf_droits_defaut['message__CREER'] // actualisation uniquement pour l'affichage
         *
         */
        // ici le code
    }

    static function autorisation_ajout(string $message_Texte, string $message_Date, int $Code_messagerie, int $Code_joueur)
    {
        return true;
    }

    static function data_controller(string &$message_Texte, string &$message_Date, int &$Code_messagerie, int &$Code_joueur, ?int $Code_message=null)
    {
        // ici le code
    }

    static function calcul_signature(string $message_Texte, string $message_Date, int $Code_messagerie, int $Code_joueur)
    {
        return md5($message_Texte.'-'.$message_Date.'-'.$Code_messagerie.'-'.$Code_joueur);
    }

    static function calcul_cle_unique(string $message_Texte, string $message_Date, int $Code_messagerie, int $Code_joueur)
    {
        // La méthode POST de l'API REST utilise cette fonction pour en déduire l'unicité de la données. Dans le cas contraire, la données est alors mise à jour
        // Attention au risque de collision
        return $Code_joueur.'.'.$Code_messagerie.'.'.sha1($message_Texte.'.'.$message_Date);
    }

    static function ajouter(int $Code_message)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_modifier(?int $Code_message=null)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['message__MODIFIER']
         *
         * $mf_droits_defaut['api_modifier__message_Texte']
         * $mf_droits_defaut['api_modifier__message_Date']
         *
         * $mf_droits_defaut['api_modifier_ref__message__Code_messagerie']
         * $mf_droits_defaut['api_modifier_ref__message__Code_joueur']
         *
         */
        // ici le code
    }

    static function autorisation_modification(int $Code_message, string $message_Texte__new, string $message_Date__new, int $Code_messagerie__new, int $Code_joueur__new)
    {
        return true;
    }

    static function data_controller__message_Texte(string $old, string &$new, int $Code_message)
    {
        // ici le code
    }

    static function data_controller__message_Date(string $old, string &$new, int $Code_message)
    {
        // ici le code
    }

    static function data_controller__Code_messagerie(int $old, int &$new, int $Code_message)
    {
        // ici le code
    }

    static function data_controller__Code_joueur(int $old, int &$new, int $Code_message)
    {
        // ici le code
    }

    /*
     * modifier : $Code_message permet de se référer à la données modifiée
     * les autres paramètres booléens ($modif...) permettent d'identifier les champs qui ont été modifiés
     */
    static function modifier(int $Code_message, bool $bool__message_Texte, bool $bool__message_Date, bool $bool__Code_messagerie, bool $bool__Code_joueur)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_supprimer(?int $Code_message=null)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['message__SUPPRIMER']
         *
         */
        // Ici le code
        if ($Code_message!=0 && $mf_droits_defaut['message__SUPPRIMER'])
        {
            // Ici le code
        }
    }

    static function autorisation_suppression(int $Code_message)
    {
        return true;
    }

    static function supprimer(array $copie__message)
    {
        // ici le code
    }

    static function supprimer_2(array $copie__liste_message)
    {
        foreach ($copie__liste_message as &$copie__message)
        {
            self::supprimer($copie__message);
        }
        unset($copie__message);
    }

    static function est_a_jour(array &$donnees)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_message']
         * $donnees['Code_messagerie']
         * $donnees['Code_joueur']
         * $donnees['message_Texte']
         * $donnees['message_Date']
         */
        return true;
    }

    static function mettre_a_jour(array $liste_message)
    {
        // ici le code
    }

    static function completion(array &$donnees)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_message']
         * $donnees['Code_messagerie']
         * $donnees['Code_joueur']
         * $donnees['message_Texte']
         * $donnees['message_Date']
         */
        // ici le code
    }

    // API callbacks
    // -------------------

    static function callback_post(int $Code_message)
    {
        return null;
    }

    static function callback_put(int $Code_message)
    {
        return null;
    }

}
