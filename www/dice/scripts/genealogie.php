<?php

/*
    +------------------------------+
    |  NE PAS MODIFIER CE FICHIER  |
    +------------------------------+
*/

if ($Code_joueur==0 && $Code_liste_contacts!=0 && isset($table_liste_contacts)) $Code_joueur = $table_liste_contacts->mf_convertir_Code_liste_contacts_vers_Code_joueur($Code_liste_contacts);
if ($Code_messagerie==0 && $Code_message!=0 && isset($table_message)) $Code_messagerie = $table_message->mf_convertir_Code_message_vers_Code_messagerie($Code_message);
if ($Code_joueur==0 && $Code_messagerie!=0 && isset($table_messagerie)) $Code_joueur = $table_messagerie->mf_convertir_Code_messagerie_vers_Code_joueur($Code_messagerie);
if ($Code_type==0 && $Code_objet!=0 && isset($table_objet)) $Code_type = $table_objet->mf_convertir_Code_objet_vers_Code_type($Code_objet);
if ($Code_ressource==0 && $Code_type!=0 && isset($table_type)) $Code_ressource = $table_type->mf_convertir_Code_type_vers_Code_ressource($Code_type);
if ($Code_groupe==0 && $Code_carte!=0 && isset($table_carte)) $Code_groupe = $table_carte->mf_convertir_Code_carte_vers_Code_groupe($Code_carte);
if ($Code_groupe==0 && $Code_personnage!=0 && isset($table_personnage)) $Code_groupe = $table_personnage->mf_convertir_Code_personnage_vers_Code_groupe($Code_personnage);
if ($Code_joueur==0 && $Code_personnage!=0 && isset($table_personnage)) $Code_joueur = $table_personnage->mf_convertir_Code_personnage_vers_Code_joueur($Code_personnage);
if ($Code_campagne==0 && $Code_groupe!=0 && isset($table_groupe)) $Code_campagne = $table_groupe->mf_convertir_Code_groupe_vers_Code_campagne($Code_groupe);
if ($Code_joueur==0 && $Code_message!=0 && isset($table_message)) $Code_joueur = $table_message->mf_convertir_Code_message_vers_Code_joueur($Code_message);

$mf_contexte = array();
$mf_contexte['Code_joueur'] = $Code_joueur;
$mf_contexte['Code_message'] = $Code_message;
$mf_contexte['Code_parametre'] = $Code_parametre;
$mf_contexte['Code_groupe'] = $Code_groupe;
$mf_contexte['Code_personnage'] = $Code_personnage;
$mf_contexte['Code_campagne'] = $Code_campagne;
$mf_contexte['Code_tag_campagne'] = $Code_tag_campagne;
$mf_contexte['Code_carte'] = $Code_carte;
$mf_contexte['Code_objet'] = $Code_objet;
$mf_contexte['Code_type'] = $Code_type;
$mf_contexte['Code_ressource'] = $Code_ressource;
$mf_contexte['Code_tag_ressource'] = $Code_tag_ressource;
$mf_contexte['Code_messagerie'] = $Code_messagerie;
$mf_contexte['Code_liste_contacts'] = $Code_liste_contacts;
