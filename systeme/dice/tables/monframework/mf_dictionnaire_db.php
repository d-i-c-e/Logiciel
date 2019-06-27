<?php

$mf_dictionnaire_db['Code_joueur']=array('type'=>'INT', 'entite'=>'joueur');
$mf_dictionnaire_db['joueur_Email']=array('type'=>'VARCHAR', 'entite'=>'joueur');
$mf_dictionnaire_db['joueur_Identifiant']=array('type'=>'VARCHAR', 'entite'=>'joueur');
$mf_dictionnaire_db['joueur_Password']=array('type'=>'PASSWORD', 'entite'=>'joueur');
$mf_dictionnaire_db['joueur_Avatar_Fichier']=array('type'=>'VARCHAR', 'entite'=>'joueur');
$mf_dictionnaire_db['joueur_Date_naissance']=array('type'=>'DATE', 'entite'=>'joueur');
$mf_dictionnaire_db['joueur_Date_inscription']=array('type'=>'DATETIME', 'entite'=>'joueur');
$mf_dictionnaire_db['joueur_Administrateur']=array('type'=>'BOOL', 'entite'=>'joueur');
$mf_dictionnaire_db['Code_message']=array('type'=>'INT', 'entite'=>'message');
$mf_dictionnaire_db['message_Texte']=array('type'=>'TEXT', 'entite'=>'message');
$mf_dictionnaire_db['message_Date']=array('type'=>'DATETIME', 'entite'=>'message');
$mf_dictionnaire_db['Code_parametre']=array('type'=>'INT', 'entite'=>'parametre');
$mf_dictionnaire_db['parametre_Libelle']=array('type'=>'VARCHAR', 'entite'=>'parametre');
$mf_dictionnaire_db['parametre_Activable']=array('type'=>'BOOL', 'entite'=>'parametre');
$mf_dictionnaire_db['Code_groupe']=array('type'=>'INT', 'entite'=>'groupe');
$mf_dictionnaire_db['groupe_Nom']=array('type'=>'VARCHAR', 'entite'=>'groupe');
$mf_dictionnaire_db['groupe_Description']=array('type'=>'TEXT', 'entite'=>'groupe');
$mf_dictionnaire_db['groupe_Logo_Fichier']=array('type'=>'VARCHAR', 'entite'=>'groupe');
$mf_dictionnaire_db['groupe_Effectif']=array('type'=>'INT', 'entite'=>'groupe');
$mf_dictionnaire_db['groupe_Actif']=array('type'=>'BOOL', 'entite'=>'groupe');
$mf_dictionnaire_db['groupe_Date_creation']=array('type'=>'DATETIME', 'entite'=>'groupe');
$mf_dictionnaire_db['groupe_Delai_suppression_jour']=array('type'=>'INT', 'entite'=>'groupe');
$mf_dictionnaire_db['groupe_Suppression_active']=array('type'=>'BOOL', 'entite'=>'groupe');
$mf_dictionnaire_db['Code_personnage']=array('type'=>'INT', 'entite'=>'personnage');
$mf_dictionnaire_db['personnage_Fichier_Fichier']=array('type'=>'VARCHAR', 'entite'=>'personnage');
$mf_dictionnaire_db['personnage_Conservation']=array('type'=>'BOOL', 'entite'=>'personnage');
$mf_dictionnaire_db['Code_campagne']=array('type'=>'INT', 'entite'=>'campagne');
$mf_dictionnaire_db['campagne_Nom']=array('type'=>'VARCHAR', 'entite'=>'campagne');
$mf_dictionnaire_db['campagne_Description']=array('type'=>'TEXT', 'entite'=>'campagne');
$mf_dictionnaire_db['campagne_Image_Fichier']=array('type'=>'VARCHAR', 'entite'=>'campagne');
$mf_dictionnaire_db['campagne_Nombre_joueur']=array('type'=>'INT', 'entite'=>'campagne');
$mf_dictionnaire_db['campagne_Nombre_mj']=array('type'=>'INT', 'entite'=>'campagne');
$mf_dictionnaire_db['Code_tag_campagne']=array('type'=>'INT', 'entite'=>'tag_campagne');
$mf_dictionnaire_db['tag_campagne_Libelle']=array('type'=>'VARCHAR', 'entite'=>'tag_campagne');
$mf_dictionnaire_db['Code_carte']=array('type'=>'INT', 'entite'=>'carte');
$mf_dictionnaire_db['carte_Nom']=array('type'=>'VARCHAR', 'entite'=>'carte');
$mf_dictionnaire_db['carte_Hauteur']=array('type'=>'INT', 'entite'=>'carte');
$mf_dictionnaire_db['carte_Largeur']=array('type'=>'INT', 'entite'=>'carte');
$mf_dictionnaire_db['carte_Fichier']=array('type'=>'VARCHAR', 'entite'=>'carte');
$mf_dictionnaire_db['Code_objet']=array('type'=>'INT', 'entite'=>'objet');
$mf_dictionnaire_db['objet_Libelle']=array('type'=>'VARCHAR', 'entite'=>'objet');
$mf_dictionnaire_db['objet_Image_Fichier']=array('type'=>'VARCHAR', 'entite'=>'objet');
$mf_dictionnaire_db['Code_type']=array('type'=>'INT', 'entite'=>'type');
$mf_dictionnaire_db['type_Libelle']=array('type'=>'VARCHAR', 'entite'=>'type');
$mf_dictionnaire_db['Code_ressource']=array('type'=>'INT', 'entite'=>'ressource');
$mf_dictionnaire_db['ressource_Nom']=array('type'=>'VARCHAR', 'entite'=>'ressource');
$mf_dictionnaire_db['Code_tag_ressource']=array('type'=>'INT', 'entite'=>'tag_ressource');
$mf_dictionnaire_db['tag_ressource_Libelle']=array('type'=>'VARCHAR', 'entite'=>'tag_ressource');
$mf_dictionnaire_db['Code_messagerie']=array('type'=>'INT', 'entite'=>'messagerie');
$mf_dictionnaire_db['messagerie_Nom']=array('type'=>'VARCHAR', 'entite'=>'messagerie');
$mf_dictionnaire_db['Code_liste_contacts']=array('type'=>'INT', 'entite'=>'liste_contacts');
$mf_dictionnaire_db['liste_contacts_Nom']=array('type'=>'VARCHAR', 'entite'=>'liste_contacts');
$mf_dictionnaire_db['Code_parametre_valeur']=array('type'=>'INT', 'entite'=>'parametre_valeur');
$mf_dictionnaire_db['parametre_valeur_Libelle']=array('type'=>'VARCHAR', 'entite'=>'parametre_valeur');
$mf_dictionnaire_db['a_joueur_parametre_Valeur_choisie']=array('type'=>'INT', 'entite'=>'a_joueur_parametre');
$mf_dictionnaire_db['a_joueur_parametre_Actif']=array('type'=>'BOOL', 'entite'=>'a_joueur_parametre');
$mf_dictionnaire_db['a_candidature_joueur_groupe_Message']=array('type'=>'TEXT', 'entite'=>'a_candidature_joueur_groupe');
$mf_dictionnaire_db['a_candidature_joueur_groupe_Date_envoi']=array('type'=>'DATETIME', 'entite'=>'a_candidature_joueur_groupe');
$mf_dictionnaire_db['a_membre_joueur_groupe_Surnom']=array('type'=>'VARCHAR', 'entite'=>'a_membre_joueur_groupe');
$mf_dictionnaire_db['a_membre_joueur_groupe_Grade']=array('type'=>'INT', 'entite'=>'a_membre_joueur_groupe');
$mf_dictionnaire_db['a_membre_joueur_groupe_Date_adhesion']=array('type'=>'DATETIME', 'entite'=>'a_membre_joueur_groupe');
$mf_dictionnaire_db['a_invitation_joueur_groupe_Message']=array('type'=>'TEXT', 'entite'=>'a_invitation_joueur_groupe');
$mf_dictionnaire_db['a_invitation_joueur_groupe_Date_envoi']=array('type'=>'DATETIME', 'entite'=>'a_invitation_joueur_groupe');
$mf_dictionnaire_db['a_liste_contact_joueur_Date_creation']=array('type'=>'DATETIME', 'entite'=>'a_liste_contact_joueur');
