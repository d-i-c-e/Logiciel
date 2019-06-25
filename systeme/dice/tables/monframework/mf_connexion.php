<?php

$joueur_courant = null;

function get_joueur_courant(?string $colonne=null)
{
    global $joueur_courant;
    if ( $colonne===null )
    {
        return $joueur_courant;
    }
    elseif ( isset($joueur_courant[$colonne]) )
    {
        return $joueur_courant[$colonne];
    }
    else
    {
        return null;
    }
}

class Mf_Connexion extends joueur_monframework
{

    private $dossier_sessions;
    private $dossier_new_pwd;
    private $mode_api;

    function __construct($mode_api=false)
    {
        if ( $mode_api )
        {
            $this->dossier_sessions = __DIR__.'/mf_connexion.sessions_api/';
        }
        else
        {
            $this->dossier_sessions = __DIR__.'/mf_connexion.sessions/';
        }
        if ( ! file_exists($this->dossier_sessions) )
        {
            mkdir( $this->dossier_sessions );
        }
        $this->dossier_new_pwd = __DIR__.'/mf_connexion.new_pwd/';
        if ( ! file_exists($this->dossier_new_pwd) )
        {
            mkdir( $this->dossier_new_pwd );
        }
        if ( TABLE_INSTANCE != '' )
        {
            $instance = 'inst_'.get_instance();
            $this->dossier_sessions.= $instance . '/';
            $this->dossier_new_pwd.= $instance . '/';
        }
        if ( ! file_exists($this->dossier_sessions) )
        {
            mkdir( $this->dossier_sessions );
        }
        if ( ! file_exists($this->dossier_new_pwd) )
        {
            mkdir( $this->dossier_new_pwd );
        }
        $this->mode_api = $mode_api;
        self::$cache_db = new Mf_Cachedb('joueur');
    }

    private function ip_autorise()
    {
        global $ADRESSES_IP_AUTORISES;
        if (count($ADRESSES_IP_AUTORISES)==0)
        {
            return true;
        }
        else
        {
            $ip_utilisateur = get_ip();
            foreach ($ADRESSES_IP_AUTORISES as $IP)
            {
                if ($ip_utilisateur==$IP)
                {
                    return true;
                }
            }
        }
        $adresse_fichier_log = get_dossier_data('adresses_ip_refusees').'adresses_ip_refusees_'.substr(get_now(), 0, 10).'.txt';
        $fichier_log = fopen($adresse_fichier_log, 'a+');
        fputs($fichier_log, get_now().' : \''.get_ip().'\''."\r\n");
        fclose($fichier_log);
        return false;
    }

    function connexion($identifiant, $joueur_Password)
    {
        if ( $this->mf_compter()==0 && $this->ip_autorise() )
        {
            return true;
        }
        global $now;
        $Code_joueur=$this->rechercher_joueur_Identifiant($identifiant);
        if ( ACTIVER_CONNEXION_EMAIL && $Code_joueur==0 )
        {
            $Code_joueur=$this->rechercher_joueur_Email($identifiant);
        }
        if ($Code_joueur!=0)
        {
            if ( ! Hook_mf_systeme::autoriser_connexion($Code_joueur) )
            {
                sleep(1);
                return false;
            }
            $joueur = $this->mf_get_connexion($Code_joueur, array('autocompletion' => false));
            $salt=substr($joueur['joueur_Password'], strrpos($joueur['joueur_Password'], ':')+1);
            $joueur_Password=md5($joueur_Password.$salt).':'.$salt;
            if ( $joueur_Password == $joueur['joueur_Password'] && $this->ip_autorise() )
            {
                $token=salt_minuscules(128).$Code_joueur;
                $session = array(
                    'Code_joueur' => $Code_joueur,
                    'token' => $token,
                    'date_connexion' => $now,
                    'derniere_activite' => $now,
                    'nb_requetes' => 1,
                );
                $filename_session = $this->dossier_sessions.'session_'.$Code_joueur;
                file_put_contents($filename_session, serialize($session));
                $this->est_connecte($token);
                Hook_mf_systeme::script_connexion($Code_joueur);
                return $token;
            }
        }
        sleep(1);
        return false;
    }

    function est_connecte($token)
    {
        if ( $this->mf_compter()==0 && $this->ip_autorise() )
        {
            return true;
        }
        global $now, $joueur_courant;
        $Code_joueur = round(substr($token,128));
        $memoire_initialisation = self::$initialisation; // pour ne pas appeler le constructeur
        self::$initialisation = false;
        $joueur = $this->mf_get_connexion($Code_joueur, array('autocompletion' => false));
        self::$initialisation = $memoire_initialisation;
        if (isset($joueur['Code_joueur']))
        {
            $filename_session = "{$this->dossier_sessions}session_{$Code_joueur}";
            if ( file_exists($filename_session) ) // si la session existe
            {
                $session = unserialize(file_get_contents($filename_session));
                if ( $session['token']==$token && $this->ip_autorise() )
                {
                    $session['nb_requetes']++;
                    $session['derniere_activite']=$now;
                    file_put_contents($filename_session, serialize($session));
                    $joueur_courant = $joueur;
                    return true;
                }
            }
        }
        if ( $this->mode_api )
        {
            sleep(1);
        }
        return false;
    }

    function regenerer_mot_de_passe($joueur_Identifiant, $joueur_Email)
    {
        sleep(1);
        $code_erreur = 4; // Echec de génération d'un lien par email
        $Code_joueur = $this->rechercher_joueur_Identifiant($joueur_Identifiant);
        if ( $Code_joueur!=0 )
        {
            $joueur = $this->mf_get_connexion($Code_joueur);
            if ( $joueur['joueur_Email']==$joueur_Email )
            {
                $token = salt_minuscules(128).$Code_joueur;
                $new_pwd = array(
                    'Code_joueur' => $Code_joueur,
                    'token' => $token,
                    'date' => get_now(),
                );
                $filename_new_pwd = $this->dossier_new_pwd . 'new_pwd_' . $Code_joueur;
                file_put_contents( $filename_new_pwd , serialize($new_pwd) );
                if ( sendemail($joueur_Email, 'Demande de nouveau mot de passe du ' . format_datetime_fr(get_now()), 'Bonjour,<br><br>Suite à votre demande, voici un lien qui vous permet de générer un nouveau mot de passe :<ul><li><a href="' . ADRESSE_SITE . 'mf_new_pwd?token=' . $token . ( TABLE_INSTANCE != '' ? '&mf_instance=' . get_instance() : '' ) . '" target="_blank">Modifier votre mot de passe</a></li></ul><br><i>Ce lien est valable 30 minutes ou jusqu\'à la génération d\'un nouveau mot de passe</i><br><br>Cordialement') )
                {
                    $code_erreur = 0;
                }
            }
        }
        if ( $code_erreur!=0 )
        {
            global $mf_message_erreur_personalise, $mf_libelle_erreur;
            if ($mf_message_erreur_personalise!='')
            {
                $mf_libelle_erreur[$code_erreur]=$mf_message_erreur_personalise;
                $mf_message_erreur_personalise='';
            }
        }
        return array('code_erreur' => $code_erreur);
    }

    function regenerer_mot_de_passe_email($joueur_Email)
    {
        sleep(1);
        $code_erreur = 4; // Echec de génération d'un lien par email
        $Code_joueur = $this->rechercher_joueur_Email($joueur_Email);
        if ( $Code_joueur!=0 )
        {
            $token = salt_minuscules(128).$Code_joueur;
            $new_pwd = array(
                'Code_joueur' => $Code_joueur,
                'token' => $token,
                'date' => get_now(),
            );
            $filename_new_pwd = $this->dossier_new_pwd . 'new_pwd_' . $Code_joueur;
            file_put_contents( $filename_new_pwd , serialize($new_pwd) );
            if ( sendemail($joueur_Email, 'Demande de nouveau mot de passe du ' . format_datetime_fr(get_now()), 'Bonjour,<br><br>Suite à votre demande, voici un lien qui vous permet de générer un nouveau mot de passe :<ul><li><a href="' . ADRESSE_SITE . 'mf_new_pwd.php?token=' . $token . ( TABLE_INSTANCE != '' ? '&mf_instance=' . get_instance() : '' ) . '" target="_blank">Modifier votre mot de passe</a></li></ul><br><i>Ce lien est valable 30 minutes ou jusqu\'à la génération d\'un nouveau mot de passe</i><br><br>Cordialement') )
            {
                $code_erreur = 0;
            }
        }
        if ( $code_erreur!=0 )
        {
            global $mf_message_erreur_personalise, $mf_libelle_erreur;
            if ($mf_message_erreur_personalise!='')
            {
                $mf_libelle_erreur[$code_erreur]=$mf_message_erreur_personalise;
                $mf_message_erreur_personalise='';
            }
        }
        return array('code_erreur' => $code_erreur);
    }

    function modifier_mdp_oublie($token, $joueur_Password)
    {
        $r = array('code_erreur' => 7); // Refus du changement de mot de passe. Veuillez réitérer votre demande.
        $Code_joueur = substr($token, 128);
        $filename_new_pwd = $this->dossier_new_pwd . 'new_pwd_' . $Code_joueur;
        if ( file_exists($filename_new_pwd) ) // si la session existe
        {
            $new_pwd = unserialize(file_get_contents($filename_new_pwd));
            if ( $new_pwd['token']==$token && $this->ip_autorise() && datetime_ajouter_time($new_pwd['date'], '00:30:00') > get_now() )
            {
                if ($this->mf_tester_existance_Code_joueur($Code_joueur))
                {
                    $r = $this->mf_modifier_3(array($Code_joueur=>array('joueur_Password'=>$joueur_Password)));
                }
            }
            unlink($filename_new_pwd);
        }
        return $r;
    }

    function deconnexion($token)
    {
        $Code_joueur = round(substr($token,128));
        $joueur = $this->mf_get_connexion($Code_joueur, array('autocompletion' => false));
        if (isset($joueur['Code_joueur']))
        {
            $filename_session = "{$this->dossier_sessions}session_{$Code_joueur}";
            if ( file_exists($filename_session) ) // si la session existe
            {
                Hook_mf_systeme::script_deconnexion($Code_joueur);
                unlink($filename_session);
            }
            global $utilisateur_courant;
            $utilisateur_courant = null;
        }
    }

    function changer_mot_de_passe($Code_joueur, $joueur_Password_old, $joueur_Password_new, $joueur_Password_verif)
    {
        $code_erreur = 3; // Echec de modification de mot de passe
        $Code_joueur = round($Code_joueur);
        $joueur = $this->mf_get_connexion($Code_joueur, array('autocompletion' => false));
        if (isset($joueur['Code_joueur']))
        {
            $salt=substr($joueur['joueur_Password'], strrpos($joueur['joueur_Password'], ':')+1);
            $joueur_Password_old=md5($joueur_Password_old.$salt).':'.$salt;
            if ( $joueur_Password_old == $joueur['joueur_Password'] )
            {
                if ( $joueur_Password_new == $joueur_Password_verif )
                {
                    $retour = $this->mf_modifier_2(array($Code_joueur=>array('joueur_Password'=>$joueur_Password_new)));
                    $code_erreur = $retour['code_erreur'];
                }
            }
            else
            {
                sleep(1);
            }
        }
        if ( $code_erreur!=0 )
        {
            global $mf_message_erreur_personalise, $mf_libelle_erreur;
            if ($mf_message_erreur_personalise!='')
            {
                $mf_libelle_erreur[$code_erreur]=$mf_message_erreur_personalise;
                $mf_message_erreur_personalise='';
            }
        }
        return array('code_erreur' => $code_erreur);
    }

    function forcer_mot_de_passe($Code_joueur, $joueur_Password)
    {
        global $mf_droits_defaut;
        return $this->mf_modifier_2(array($Code_joueur=>array('joueur_Password'=>$joueur_Password)));
    }

    function raz_mot_de_passe_droit_admin($Code_joueur, $joueur_Password)
    {
        global $mf_droits_defaut;
        return $this->mf_modifier_3(array($Code_joueur=>array('joueur_Password'=>$joueur_Password)));
    }

    function inscription($joueur_Identifiant, $joueur_Password, $joueur_Password__verif, $joueur_Email, $joueur_Email__verif)
    {
        $retour = ['code_erreur' => 0, 'Code_joueur' => 0];
        if ( $joueur_Password != $joueur_Password__verif ) $retour['code_erreur'] = 5;
        elseif ( $joueur_Email != $joueur_Email__verif ) $retour['code_erreur'] = 6;
        else
        {
            $retour = $this->mf_ajouter_2([
                'joueur_Identifiant' => $joueur_Identifiant,
                'joueur_Password' => $joueur_Password,
                'joueur_Email' => $joueur_Email,
            ], true);
        }
        if ( $retour['code_erreur']!=0 )
        {
            sleep(1);
        }
        return $retour;
    }

    function nb_sessions_actives()
    {
        $time = time();
        $i = 0;
        $files = glob($this->dossier_sessions.'*');
        foreach ( $files as $file )
        {
            if ( $time - filemtime($file)<3600 )
            {
                $i++;
            }
        }
        return $i;
    }

}
