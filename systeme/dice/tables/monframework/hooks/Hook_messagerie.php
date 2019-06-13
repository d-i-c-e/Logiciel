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

    static function pre_controller(&$Code_joueur, $Code_messagerie=0)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_ajouter($Code_joueur=0)
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

    static function autorisation_ajout($Code_joueur)
    {
        return true;
    }

    static function data_controller(&$Code_joueur, $Code_messagerie=0)
    {
        // ici le code
    }

    static function calcul_signature($Code_joueur)
    {
        return md5($Code_joueur);
    }

    static function calcul_cle_unique($Code_joueur)
    {
        // La méthode POST de l'API REST utilise cette fonction pour en déduire l'unicité de la données. Dans le cas contraire, la données est alors mise à jour
        // Attention au risque de collision
        return $Code_joueur;
    }

    static function ajouter($Code_messagerie)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_modifier($Code_messagerie=0)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['messagerie__MODIFIER']
         *
         * $mf_droits_defaut['api_modifier_ref__messagerie__Code_joueur']
         *
         */
        // ici le code
    }

    static function autorisation_modification($Code_messagerie, $Code_joueur__new)
    {
        return true;
    }

    static function data_controller__Code_joueur($old, &$new, $Code_messagerie)
    {
        // ici le code
    }

    /*
     * modifier : $Code_match_foot permet de se référer à la données modifiée
     * les autres paramètres booléens ($modif...) permettent d'identifier les champs qui ont été modifiés
     */
    static function modifier($Code_messagerie, $bool__Code_joueur)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_supprimer($Code_messagerie=0)
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

    static function autorisation_suppression($Code_messagerie)
    {
        return true;
    }

    static function supprimer($copie__messagerie)
    {
        // ici le code
    }

    static function supprimer_2($copie__liste_messagerie)
    {
        foreach ($copie__liste_messagerie as &$copie__messagerie)
        {
            self::supprimer($copie__messagerie);
        }
        unset($copie__messagerie);
    }

    static function est_a_jour(&$donnees)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_messagerie']
         * $donnees['Code_joueur']
         */
        return true;
    }

    static function mettre_a_jour($liste_messagerie)
    {
        // ici le code
    }

    static function completion(&$donnees)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_messagerie']
         * $donnees['Code_joueur']
         */
        // ici le code
    }

    // API callbacks
    // -------------------

    static function callback_post($Code_messagerie)
    {
        return null;
    }

    static function callback_put($Code_messagerie)
    {
        return null;
    }

}
