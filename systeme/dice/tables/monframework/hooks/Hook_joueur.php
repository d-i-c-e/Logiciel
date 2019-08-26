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

    static function pre_controller(string &$joueur_Email, string &$joueur_Identifiant, string &$joueur_Password, string &$joueur_Avatar_Fichier, string &$joueur_Date_naissance, string &$joueur_Date_inscription, bool &$joueur_Administrateur, ?int $Code_joueur=null)
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
        if (est_administrateur()) {
            $mf_droits_defaut['joueur__AJOUTER'] = true;
        }
    }

    static function autorisation_ajout(string $joueur_Email, string $joueur_Identifiant, string $joueur_Password, string $joueur_Avatar_Fichier, string $joueur_Date_naissance, string $joueur_Date_inscription, bool $joueur_Administrateur)
    {
        return true;
    }

    static function data_controller(string &$joueur_Email, string &$joueur_Identifiant, string &$joueur_Password, string &$joueur_Avatar_Fichier, string &$joueur_Date_naissance, string &$joueur_Date_inscription, bool &$joueur_Administrateur, ?int $Code_joueur=null)
    {
        // ici le code
    }

    static function calcul_signature(string $joueur_Email, string $joueur_Identifiant, string $joueur_Password, string $joueur_Avatar_Fichier, string $joueur_Date_naissance, string $joueur_Date_inscription, bool $joueur_Administrateur)
    {
        return md5($joueur_Email.'-'.$joueur_Identifiant.'-'.$joueur_Password.'-'.$joueur_Avatar_Fichier.'-'.$joueur_Date_naissance.'-'.$joueur_Date_inscription.'-'.$joueur_Administrateur);
    }

    static function calcul_cle_unique(string $joueur_Email, string $joueur_Identifiant, string $joueur_Password, string $joueur_Avatar_Fichier, string $joueur_Date_naissance, string $joueur_Date_inscription, bool $joueur_Administrateur)
    {
        // La méthode POST de l'API REST utilise cette fonction pour en déduire l'unicité de la données. Dans le cas contraire, la données est alors mise à jour
        // Attention au risque de collision
        return sha1($joueur_Email.'.'.$joueur_Identifiant.'.'.$joueur_Password.'.'.$joueur_Avatar_Fichier.'.'.$joueur_Date_naissance.'.'.$joueur_Date_inscription.'.'.$joueur_Administrateur);
    }

    static function ajouter(int $Code_joueur)
    {
        // ici le code
        $db = new DB();
        // ajout des messageries
        // ajout des liste de contact
    }

    static function hook_actualiser_les_droits_modifier(?int $Code_joueur=null)
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
         * $mf_droits_defaut['api_modifier__joueur_Administrateur']
         *
         */
        // ici le code
        if (get_joueur_courant(MF_JOUEUR__ID) == $Code_joueur) {
            $mf_droits_defaut['joueur__MODIFIER_PWD'] = true;
            $mf_droits_defaut['api_modifier__joueur_Email'] = true;
            $mf_droits_defaut['api_modifier__joueur_Identifiant'] = true;
            $mf_droits_defaut['api_modifier__joueur_Avatar_Fichier'] = true;
        }
        if (est_administrateur() && get_joueur_courant(MF_JOUEUR__ID) != $Code_joueur) {
            $mf_droits_defaut['api_modifier__joueur_Administrateur'] = true;
        }
    }

    static function autorisation_modification(int $Code_joueur, string $joueur_Email__new, string $joueur_Identifiant__new, string $joueur_Password__new, string $joueur_Avatar_Fichier__new, string $joueur_Date_naissance__new, string $joueur_Date_inscription__new, bool $joueur_Administrateur__new)
    {
        return true;
    }

    static function data_controller__joueur_Email(string $old, string &$new, int $Code_joueur)
    {
        // ici le code
    }

    static function data_controller__joueur_Identifiant(string $old, string &$new, int $Code_joueur)
    {
        // ici le code
    }

    static function data_controller__joueur_Avatar_Fichier(string $old, string &$new, int $Code_joueur)
    {
        // ici le code
    }

    static function data_controller__joueur_Date_naissance(string $old, string &$new, int $Code_joueur)
    {
        // ici le code
    }

    static function data_controller__joueur_Date_inscription(string $old, string &$new, int $Code_joueur)
    {
        // ici le code
    }

    static function data_controller__joueur_Administrateur(bool $old, bool &$new, int $Code_joueur)
    {
        // ici le code
    }

    /*
     * modifier : $Code_joueur permet de se référer à la données modifiée
     * les autres paramètres booléens ($modif...) permettent d'identifier les champs qui ont été modifiés
     */
    static function modifier(int $Code_joueur, bool $bool__joueur_Email, bool $bool__joueur_Identifiant, bool $bool__joueur_Password, bool $bool__joueur_Avatar_Fichier, bool $bool__joueur_Date_naissance, bool $bool__joueur_Date_inscription, bool $bool__joueur_Administrateur)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_supprimer(?int $Code_joueur=null)
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

    static function autorisation_suppression(int $Code_joueur)
    {
        return true;
    }

    static function supprimer(array $copie__joueur)
    {
        // ici le code
    }

    static function supprimer_2(array $copie__liste_joueur)
    {
        foreach ($copie__liste_joueur as &$copie__joueur)
        {
            self::supprimer($copie__joueur);
        }
        unset($copie__joueur);
    }

    static function est_a_jour(array &$donnees)
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
         * $donnees['joueur_Administrateur']
         */
        return true;
    }

    static function mettre_a_jour(array $liste_joueur)
    {
        // ici le code
    }

    static function completion(array &$donnees)
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
         * $donnees['joueur_Administrateur']
         */
        // ici le code
    }

    // API callbacks
    // -------------------

    static function callback_post(int $Code_joueur)
    {
        return null;
    }

    static function callback_put(int $Code_joueur)
    {
        return null;
    }

}
