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

    static function pre_controller(&$message_Texte, &$message_Date, &$Code_messagerie, &$Code_joueur, $Code_message=0)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_ajouter($Code_messagerie=0, $Code_joueur=0)
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

    static function autorisation_ajout($message_Texte, $message_Date, $Code_messagerie, $Code_joueur)
    {
        return true;
    }

    static function data_controller(&$message_Texte, &$message_Date, &$Code_messagerie, &$Code_joueur, $Code_message=0)
    {
        // ici le code
    }

    static function calcul_signature($message_Texte, $message_Date, $Code_messagerie, $Code_joueur)
    {
        return md5($message_Texte.'-'.$message_Date.'-'.$Code_messagerie.'-'.$Code_joueur);
    }

    static function calcul_cle_unique($message_Texte, $message_Date, $Code_messagerie, $Code_joueur)
    {
        // La méthode POST de l'API REST utilise cette fonction pour en déduire l'unicité de la données. Dans le cas contraire, la données est alors mise à jour
        // Attention au risque de collision
        return $Code_joueur.'.'.$Code_messagerie.'.'.sha1($message_Texte.'.'.$message_Date);
    }

    static function ajouter($Code_message)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_modifier($Code_message=0)
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

    static function autorisation_modification($Code_message, $message_Texte__new, $message_Date__new, $Code_messagerie__new, $Code_joueur__new)
    {
        return true;
    }

    static function data_controller__message_Texte($old, &$new, $Code_message)
    {
        // ici le code
    }

    static function data_controller__message_Date($old, &$new, $Code_message)
    {
        // ici le code
    }

    static function data_controller__Code_messagerie($old, &$new, $Code_message)
    {
        // ici le code
    }

    static function data_controller__Code_joueur($old, &$new, $Code_message)
    {
        // ici le code
    }

    /*
     * modifier : $Code_match_foot permet de se référer à la données modifiée
     * les autres paramètres booléens ($modif...) permettent d'identifier les champs qui ont été modifiés
     */
    static function modifier($Code_message, $bool__message_Texte, $bool__message_Date, $bool__Code_messagerie, $bool__Code_joueur)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_supprimer($Code_message=0)
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

    static function autorisation_suppression($Code_message)
    {
        return true;
    }

    static function supprimer($copie__message)
    {
        // ici le code
    }

    static function supprimer_2($copie__liste_message)
    {
        foreach ($copie__liste_message as &$copie__message)
        {
            self::supprimer($copie__message);
        }
        unset($copie__message);
    }

    static function est_a_jour(&$donnees)
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

    static function mettre_a_jour($liste_message)
    {
        // ici le code
    }

    static function completion(&$donnees)
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

    static function callback_post($Code_message)
    {
        return null;
    }

    static function callback_put($Code_message)
    {
        return null;
    }

}
