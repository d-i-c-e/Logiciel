<?php

/*
    +------------------------------+
    |  NE PAS MODIFIER CE FICHIER  |
    +------------------------------+
*/

$Code_joueur = ( isset($_GET['Code_joueur']) ? round($_GET['Code_joueur']) : 0 );
$Code_message = ( isset($_GET['Code_message']) ? round($_GET['Code_message']) : 0 );
$Code_parametre = ( isset($_GET['Code_parametre']) ? round($_GET['Code_parametre']) : 0 );
$Code_groupe = ( isset($_GET['Code_groupe']) ? round($_GET['Code_groupe']) : 0 );
$Code_personnage = ( isset($_GET['Code_personnage']) ? round($_GET['Code_personnage']) : 0 );
$Code_campagne = ( isset($_GET['Code_campagne']) ? round($_GET['Code_campagne']) : 0 );
$Code_tag_campagne = ( isset($_GET['Code_tag_campagne']) ? round($_GET['Code_tag_campagne']) : 0 );
$Code_carte = ( isset($_GET['Code_carte']) ? round($_GET['Code_carte']) : 0 );
$Code_objet = ( isset($_GET['Code_objet']) ? round($_GET['Code_objet']) : 0 );
$Code_type = ( isset($_GET['Code_type']) ? round($_GET['Code_type']) : 0 );
$Code_ressource = ( isset($_GET['Code_ressource']) ? round($_GET['Code_ressource']) : 0 );
$Code_tag_ressource = ( isset($_GET['Code_tag_ressource']) ? round($_GET['Code_tag_ressource']) : 0 );
$Code_messagerie = ( isset($_GET['Code_messagerie']) ? round($_GET['Code_messagerie']) : 0 );
$Code_liste_contacts = ( isset($_GET['Code_liste_contacts']) ? round($_GET['Code_liste_contacts']) : 0 );

require __DIR__ . '/genealogie.php';

function mf_Code_joueur() { global $mf_contexte; return $mf_contexte['Code_joueur']; }
function mf_Code_message() { global $mf_contexte; return $mf_contexte['Code_message']; }
function mf_Code_parametre() { global $mf_contexte; return $mf_contexte['Code_parametre']; }
function mf_Code_groupe() { global $mf_contexte; return $mf_contexte['Code_groupe']; }
function mf_Code_personnage() { global $mf_contexte; return $mf_contexte['Code_personnage']; }
function mf_Code_campagne() { global $mf_contexte; return $mf_contexte['Code_campagne']; }
function mf_Code_tag_campagne() { global $mf_contexte; return $mf_contexte['Code_tag_campagne']; }
function mf_Code_carte() { global $mf_contexte; return $mf_contexte['Code_carte']; }
function mf_Code_objet() { global $mf_contexte; return $mf_contexte['Code_objet']; }
function mf_Code_type() { global $mf_contexte; return $mf_contexte['Code_type']; }
function mf_Code_ressource() { global $mf_contexte; return $mf_contexte['Code_ressource']; }
function mf_Code_tag_ressource() { global $mf_contexte; return $mf_contexte['Code_tag_ressource']; }
function mf_Code_messagerie() { global $mf_contexte; return $mf_contexte['Code_messagerie']; }
function mf_Code_liste_contacts() { global $mf_contexte; return $mf_contexte['Code_liste_contacts']; }
