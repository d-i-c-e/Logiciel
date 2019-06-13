<?php

class Hook_joueur{

    static function initialisation() // première instanciation
    {
        // ici le code
    }

    static function actualisation() // à chaque instanciation
    {
        // ici le code
    }

    static function pre_controller(&$joueur_Email, &$joueur_Identifiant, &$joueur_Password, &$joueur_Avatar_Fichier, &$joueur_Date_naissance, &$joueur_Date_inscription, $Code_joueur=0)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_ajouter()
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['joueur__AJOUTER']
         * $mf_droits_defaut['joueur__CREER'] // actualisation uniquement pour l'affichage
         *
         */
        // ici le code
    }

    static function autorisation_ajout($joueur_Email, $joueur_Identifiant, $joueur_Password, $joueur_Avatar_Fichier, $joueur_Date_naissance, $joueur_Date_inscription)
    {
        return true;
    }

    static function data_controller(&$joueur_Email, &$joueur_Identifiant, &$joueur_Password, &$joueur_Avatar_Fichier, &$joueur_Date_naissance, &$joueur_Date_inscription, $Code_joueur=0)
    {
        // ici le code
    }

    static function calcul_signature($joueur_Email, $joueur_Identifiant, $joueur_Password, $joueur_Avatar_Fichier, $joueur_Date_naissance, $joueur_Date_inscription)
    {
        return md5($joueur_Email.'-'.$joueur_Identifiant.'-'.$joueur_Password.'-'.$joueur_Avatar_Fichier.'-'.$joueur_Date_naissance.'-'.$joueur_Date_inscription);
    }

    static function calcul_cle_unique($joueur_Email, $joueur_Identifiant, $joueur_Password, $joueur_Avatar_Fichier, $joueur_Date_naissance, $joueur_Date_inscription)
    {
        // La méthode POST de l'API REST utilise cette fonction pour en déduire l'unicité de la données. Dans le cas contraire, la données est alors mise à jour
        // Attention au risque de collision
        return sha1($joueur_Email.'.'.$joueur_Identifiant.'.'.$joueur_Password.'.'.$joueur_Avatar_Fichier.'.'.$joueur_Date_naissance.'.'.$joueur_Date_inscription);
    }

    static function ajouter($Code_joueur)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_modifier($Code_joueur=0)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['joueur__MODIFIER']
         * $mf_droits_defaut['joueur__MODIFIER_PWD']
         *
         * $mf_droits_defaut['api_modifier__joueur_Email']
         * $mf_droits_defaut['api_modifier__joueur_Identifiant']
         * $mf_droits_defaut['api_modifier__joueur_Password']
         * $mf_droits_defaut['api_modifier__joueur_Avatar_Fichier']
         * $mf_droits_defaut['api_modifier__joueur_Date_naissance']
         * $mf_droits_defaut['api_modifier__joueur_Date_inscription']
         *
         */
        // ici le code
    }

    static function autorisation_modification($Code_joueur, $joueur_Email__new, $joueur_Identifiant__new, $joueur_Password__new, $joueur_Avatar_Fichier__new, $joueur_Date_naissance__new, $joueur_Date_inscription__new)
    {
        return true;
    }

    static function data_controller__joueur_Email($old, &$new, $Code_joueur)
    {
        // ici le code
    }

    static function data_controller__joueur_Identifiant($old, &$new, $Code_joueur)
    {
        // ici le code
    }

    static function data_controller__joueur_Avatar_Fichier($old, &$new, $Code_joueur)
    {
        // ici le code
    }

    static function data_controller__joueur_Date_naissance($old, &$new, $Code_joueur)
    {
        // ici le code
    }

    static function data_controller__joueur_Date_inscription($old, &$new, $Code_joueur)
    {
        // ici le code
    }

    /*
     * modifier : $Code_match_foot permet de se référer à la données modifiée
     * les autres paramètres booléens ($modif...) permettent d'identifier les champs qui ont été modifiés
     */
    static function modifier($Code_joueur, $bool__joueur_Email, $bool__joueur_Identifiant, $bool__joueur_Password, $bool__joueur_Avatar_Fichier, $bool__joueur_Date_naissance, $bool__joueur_Date_inscription)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_supprimer($Code_joueur=0)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['joueur__SUPPRIMER']
         *
         */
        // Ici le code
        if ($Code_joueur!=0 && $mf_droits_defaut['joueur__SUPPRIMER'])
        {
            $table_message = new message();
            $table_personnage = new personnage();
            $table_messagerie = new messagerie();
            $table_liste_contacts = new liste_contacts();
            $mf_droits_defaut['joueur__SUPPRIMER'] = $table_message->mfi_compter(array('Code_joueur'=>$Code_joueur))==0 && $table_personnage->mfi_compter(array('Code_joueur'=>$Code_joueur))==0 && $table_messagerie->mfi_compter(array('Code_joueur'=>$Code_joueur))==0 && $table_liste_contacts->mfi_compter(array('Code_joueur'=>$Code_joueur))==0;
        }
    }

    static function autorisation_suppression($Code_joueur)
    {
        return true;
    }

    static function supprimer($copie__joueur)
    {
        // ici le code
    }

    static function supprimer_2($copie__liste_joueur)
    {
        foreach ($copie__liste_joueur as &$copie__joueur)
        {
            self::supprimer($copie__joueur);
        }
        unset($copie__joueur);
    }

    static function est_a_jour(&$donnees)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_joueur']
         * $donnees['joueur_Email']
         * $donnees['joueur_Identifiant']
         * $donnees['joueur_Password']
         * $donnees['joueur_Avatar_Fichier']
         * $donnees['joueur_Date_naissance']
         * $donnees['joueur_Date_inscription']
         */
        return true;
    }

    static function mettre_a_jour($liste_joueur)
    {
        // ici le code
    }

    static function completion(&$donnees)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_joueur']
         * $donnees['joueur_Email']
         * $donnees['joueur_Identifiant']
         * $donnees['joueur_Password']
         * $donnees['joueur_Avatar_Fichier']
         * $donnees['joueur_Date_naissance']
         * $donnees['joueur_Date_inscription']
         */
        // ici le code
    }

    // API callbacks
    // -------------------

    static function callback_post($Code_joueur)
    {
        return null;
    }

    static function callback_put($Code_joueur)
    {
        return null;
    }

}
