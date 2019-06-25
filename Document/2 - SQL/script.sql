
DROP TABLE IF EXISTS joueur ;

CREATE TABLE joueur (Code_joueur int AUTO_INCREMENT NOT NULL,
joueur_Email VARCHAR,
joueur_Identifiant VARCHAR,
joueur_Password VARCHAR,
joueur_Avatar_Fichier VARCHAR,
joueur_Date_naissance DATE,
joueur_Date_inscription DATETIME,
PRIMARY KEY (Code_joueur) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS message ;

CREATE TABLE message (Code_message int AUTO_INCREMENT NOT NULL,
message_Texte TEXT,
message_Date DATETIME,
Code_messagerie int NOT NULL,
Code_joueur int NOT NULL,
PRIMARY KEY (Code_message) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS parametre ;

CREATE TABLE parametre (Code_parametre int AUTO_INCREMENT NOT NULL,
parametre_Libelle VARCHAR,
parametre_Valeur INT,
parametre_Activable BOOL,
parametre_Actif BOOL,
PRIMARY KEY (Code_parametre) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS groupe ;

CREATE TABLE groupe (Code_groupe int AUTO_INCREMENT NOT NULL,
groupe_Nom VARCHAR,
groupe_Description TEXT,
groupe_Logo_Fichier VARCHAR,
groupe_Effectif BOOL,
groupe_Actif INT,
groupe_Date_creation DATETIME,
groupe_Delai_suppression_jour INT,
groupe_Suppression_active BOOL,
Code_campagne int NOT NULL,
PRIMARY KEY (Code_groupe) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS personnage ;

CREATE TABLE personnage (Code_personnage int AUTO_INCREMENT NOT NULL,
personnage_Fichier_Fichier VARCHAR,
personnage_Conservation BOOL,
Code_joueur int NOT NULL,
Code_groupe int NOT NULL,
PRIMARY KEY (Code_personnage) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS campagne ;

CREATE TABLE campagne (Code_campagne int AUTO_INCREMENT NOT NULL,
campagne_Nom VARCHAR,
campagne_Description TEXT,
campagne_Image_Fichier VARCHAR,
campagne_Nombre_joueur INT,
campagne_Nombre_mj INT,
PRIMARY KEY (Code_campagne) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS tag_campagne ;

CREATE TABLE tag_campagne (Code_tag_campagne int AUTO_INCREMENT NOT NULL,
tag_campagne_Libelle VARCHAR,
PRIMARY KEY (Code_tag_campagne) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS carte ;

CREATE TABLE carte (Code_carte int AUTO_INCREMENT NOT NULL,
carte_Nom VARCHAR,
carte_Hauteur INT,
carte_Largeur INT,
carte_Fichier VARCHAR,
Code_groupe int NOT NULL,
PRIMARY KEY (Code_carte) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS objet ;

CREATE TABLE objet (Code_objet int AUTO_INCREMENT NOT NULL,
objet_Libelle VARCHAR,
objet_Image_Fichier VARCHAR,
Code_type int NOT NULL,
PRIMARY KEY (Code_objet) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS type ;

CREATE TABLE type (Code_type int AUTO_INCREMENT NOT NULL,
type_Libelle VARCHAR,
Code_ressource int NOT NULL,
PRIMARY KEY (Code_type) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS ressource ;

CREATE TABLE ressource (Code_ressource int AUTO_INCREMENT NOT NULL,
ressource_Nom VARCHAR,
PRIMARY KEY (Code_ressource) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS tag_ressource ;

CREATE TABLE tag_ressource (Code_tag_ressource int AUTO_INCREMENT NOT NULL,
tag_ressource_Libelle VARCHAR,
PRIMARY KEY (Code_tag_ressource) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS messagerie ;

CREATE TABLE messagerie (Code_messagerie int AUTO_INCREMENT NOT NULL,
messagerie_Nom VARCHAR,
Code_joueur int,
PRIMARY KEY (Code_messagerie) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS liste_contacts ;

CREATE TABLE liste_contacts (Code_liste_contacts int AUTO_INCREMENT NOT NULL,
liste_contacts_Nom VARCHAR,
Code_joueur int NOT NULL,
PRIMARY KEY (Code_liste_contacts) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS a_joueur_parametre ;

CREATE TABLE a_joueur_parametre (Code_joueur int AUTO_INCREMENT NOT NULL,
Code_parametre int NOT NULL,
PRIMARY KEY (Code_joueur,
 Code_parametre) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS a_candidature_joueur_groupe ;

CREATE TABLE a_candidature_joueur_groupe (Code_joueur int AUTO_INCREMENT NOT NULL,
Code_groupe int NOT NULL,
a_candidature_joueur_groupe_Message TEXT,
a_candidature_joueur_groupe_Date_envoi DATETIME,
PRIMARY KEY (Code_joueur,
 Code_groupe) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS a_membre_joueur_groupe ;

CREATE TABLE a_membre_joueur_groupe (Code_groupe int AUTO_INCREMENT NOT NULL,
Code_joueur int NOT NULL,
a_membre_joueur_groupe_Surnom VARCHAR,
a_membre_joueur_groupe_Grade INT,
a_membre_joueur_groupe_Date_adhesion DATETIME,
PRIMARY KEY (Code_groupe,
 Code_joueur) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS a_invitation_joueur_groupe ;

CREATE TABLE a_invitation_joueur_groupe (Code_joueur int AUTO_INCREMENT NOT NULL,
Code_groupe int NOT NULL,
a_invitation_joueur_groupe_Message TEXT,
a_invitation_joueur_groupe_Date_envoi DATETIME,
PRIMARY KEY (Code_joueur,
 Code_groupe) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS a_carte_objet ;

CREATE TABLE a_carte_objet (Code_carte int AUTO_INCREMENT NOT NULL,
Code_objet int NOT NULL,
PRIMARY KEY (Code_carte,
 Code_objet) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS a_campagne_tag_campagne ;

CREATE TABLE a_campagne_tag_campagne (Code_tag_campagne int AUTO_INCREMENT NOT NULL,
Code_campagne int NOT NULL,
PRIMARY KEY (Code_tag_campagne,
 Code_campagne) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS a_ressource_tag_ressource ;

CREATE TABLE a_ressource_tag_ressource (Code_tag_ressource int AUTO_INCREMENT NOT NULL,
Code_ressource int NOT NULL,
PRIMARY KEY (Code_tag_ressource,
 Code_ressource) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS a_liste_contact_joueur ;

CREATE TABLE a_liste_contact_joueur (Code_liste_contacts int AUTO_INCREMENT NOT NULL,
Code_joueur int NOT NULL,
a_liste_contact_joueur_Date_creation DATETIME,
PRIMARY KEY (Code_liste_contacts,
 Code_joueur) ) ENGINE=InnoDB;

