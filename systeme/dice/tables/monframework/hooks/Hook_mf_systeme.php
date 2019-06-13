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

    static function controle_acces_donnees($code, $valeur)
    {
        // règles à géfinir ...
        return true;
    }

    static function autoriser_connexion($Code_joueur)
    {
        // script ici ...
        return true;
    }

    static function script_connexion($Code_joueur)
    {
        // script ici ...
    }

    static function script_deconnexion($Code_joueur)
    {
        // script ici ...
    }

    /*
     * Règles d'accès aux fichiers
     */
    static function est_fichier_public($n)
    {
        // Si vrai, tout le monde a accès au fichier, connecté ou non. $n est le nom du fichier
        return false;
    }

    static function controle_acces_fichier($n)
    {
        // Dans le cas ou le fichier n'est pas public, $n est le nom du fichier et permet de gérer des accès plus précis
        return true;
    }

    static function controle_parametres_session($name_session, &$value)
    {
        switch ($name_session)
        {
            case 'test':
                $value = null;
                break;
            default:
                $value = null;
                break;
        }
    }

}
