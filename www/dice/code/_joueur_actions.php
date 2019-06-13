<?php

    $est_charge['joueur'] = 1;

/*
    +-----------+
    |  Ajouter  |
    +-----------+
*/
    if ( $mf_action=='ajouter_joueur' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $mf_add = [];
        if ( isset( $_POST['joueur_Email'] ) ) { $mf_add['joueur_Email'] = $_POST['joueur_Email']; }
        if ( isset( $_POST['joueur_Identifiant'] ) ) { $mf_add['joueur_Identifiant'] = $_POST['joueur_Identifiant']; }
        if ( isset( $_POST['joueur_Password'] ) ) { $mf_add['joueur_Password'] = $_POST['joueur_Password']; }
        if ( isset( $_FILES['joueur_Avatar_Fichier'] ) ) { $fichier = new Fichier(); $mf_add['joueur_Avatar_Fichier'] = $fichier->importer($_FILES['joueur_Avatar_Fichier']); }
        if ( isset( $_POST['joueur_Date_naissance'] ) ) { $mf_add['joueur_Date_naissance'] = $_POST['joueur_Date_naissance']; }
        if ( isset( $_POST['joueur_Date_inscription'] ) ) { $mf_add['joueur_Date_inscription'] = $_POST['joueur_Date_inscription']; }
        $retour = $table_joueur->mf_ajouter_2($mf_add);
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = "apercu_joueur";
            $Code_joueur =  $retour['Code_joueur'];
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

/*
    +------------+
    |  Modifier  |
    +------------+
*/
    if ( $mf_action=="modifier_joueur" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $mf_update = [];
        if ( isset( $_POST['joueur_Email'] ) ) { $mf_update['joueur_Email'] = $_POST['joueur_Email']; }
        if ( isset( $_POST['joueur_Identifiant'] ) ) { $mf_update['joueur_Identifiant'] = $_POST['joueur_Identifiant']; }
        // if ( isset( $_POST['joueur_Password'] ) ) { $mf_update['joueur_Password'] = $_POST['joueur_Password']; }
        if ( isset( $_FILES['joueur_Avatar_Fichier'] ) ) { $fichier = new Fichier(); $mf_update['joueur_Avatar_Fichier'] = $fichier->importer($_FILES['joueur_Avatar_Fichier']); }
        if ( isset( $_POST['joueur_Date_naissance'] ) ) { $mf_update['joueur_Date_naissance'] = $_POST['joueur_Date_naissance']; }
        if ( isset( $_POST['joueur_Date_inscription'] ) ) { $mf_update['joueur_Date_inscription'] = $_POST['joueur_Date_inscription']; }
        $retour = $table_joueur->mf_modifier_2( [ $Code_joueur => $mf_update ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_joueur';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_joueur_Email' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $joueur_Email = $_POST['joueur_Email'];
        $retour = $table_joueur->mf_modifier_2( [ $Code_joueur => [ 'joueur_Email' => $joueur_Email ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_joueur';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_joueur_Identifiant' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $joueur_Identifiant = $_POST['joueur_Identifiant'];
        $retour = $table_joueur->mf_modifier_2( [ $Code_joueur => [ 'joueur_Identifiant' => $joueur_Identifiant ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_joueur';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_joueur_Avatar_Fichier' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $fichier = new Fichier();
        $joueur_Avatar_Fichier = $fichier->importer($_FILES['joueur_Avatar_Fichier']);
        if ($joueur_Avatar_Fichier=='') { $temp = $table_joueur->mf_get($Code_joueur); $joueur_Avatar_Fichier = $temp['joueur_Avatar_Fichier']; }
        $retour = $table_joueur->mf_modifier_2( [ $Code_joueur => [ 'joueur_Avatar_Fichier' => $joueur_Avatar_Fichier ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_joueur';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_joueur_Date_naissance' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $joueur_Date_naissance = $_POST['joueur_Date_naissance'];
        $retour = $table_joueur->mf_modifier_2( [ $Code_joueur => [ 'joueur_Date_naissance' => $joueur_Date_naissance ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_joueur';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_joueur_Date_inscription' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $joueur_Date_inscription = $_POST['joueur_Date_inscription'];
        $retour = $table_joueur->mf_modifier_2( [ $Code_joueur => [ 'joueur_Date_inscription' => $joueur_Date_inscription ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_joueur';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

/*
    +----------------------------+
    |  Modifier le mot de passe  |
    +----------------------------+
*/
    if ( $mf_action=="modpwd" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $joueur_Password_old=$_POST["joueur_Password_old"];
        $joueur_Password_new=$_POST["joueur_Password_new"];
        $joueur_Password_verif=$_POST["joueur_Password_verif"];
        $retour = $mf_connexion->changer_mot_de_passe($Code_joueur, $joueur_Password_old, $joueur_Password_new, $joueur_Password_verif);
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = "apercu_joueur";
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

/*
    +-------------+
    |  Supprimer  |
    +-------------+
*/
    if ( $mf_action=="supprimer_joueur" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $Supprimer = round($_POST["Supprimer"]);
        if ($Supprimer==1)
        {
            $retour = $table_joueur->mf_supprimer($Code_joueur);
            if ( $retour['code_erreur']==0 )
            {
                $mf_action = "-";
                $cache->clear();
                $Code_joueur = 0;
            }
            else
            {
                $cache->clear_current_page();
            }
        }
        else
        {
            $mf_action = "apercu_joueur";
            $cache->clear_current_page();
        }
    }
