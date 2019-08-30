<?php

class Hook_mf_systeme{

    static function initialisation()
    {
        // Script qui s'exécute à chaque appel de dblayer_light
        // script ici
    }

    /*
     * Fonction qui s'exécute toutes les DELAI_EXECUTION_WORKER secondes si le site est en charge.
     */
    static function worker()
    {
        // script ici
    }

    static function controle_acces_donnees(string $code, string $valeur)
    {
        // règles à géfinir ...
        return true;
    }

    static function autoriser_connexion(int $Code_joueur)
    {
        // script ici ...
        return true;
    }

    static function script_connexion(int $Code_joueur)
    {
        // script ici ...
    }

    static function script_deconnexion(int $Code_joueur)
    {
        // script ici ...
    }

    /*
     * Règles d'accès aux fichiers
     */
    static function est_fichier_public(string $n)
    {
        // Si vrai, tout le monde a accès au fichier, connecté ou non. $n est le nom du fichier
        return false;
    }

    static function controle_acces_fichier(string $n)
    {
        // Dans le cas ou le fichier n'est pas public, $n est le nom du fichier et permet de gérer des accès plus précis
        return true;
    }

    static function controle_parametres_session(string $name_session, &$value)
    {
        switch ($name_session)
        {
            case 'requete_tag_campagne':
                $value = substr($value, 0, 255);
                break;
            case 'requete_campagne':
                $value = substr($value, 0, 255);
                break;
            case 'requete_tag_ressource':
                $value = substr($value, 0, 255);
                break;
            case 'requete_ressource':
                $value = substr($value, 0, 255);
                break;
            default:
                $value = null;
                break;
        }
    }

}
