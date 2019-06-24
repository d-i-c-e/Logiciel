<?php

// +-------------------+
// | Outil développeur |
// +-------------------+

// Système
    include 'systeme/dice/constantes_systeme.php';                        // Les constantes globales
    include 'systeme/dice/fonctions_additionnelles.php';                  // Les fonctions globales
    include 'systeme/dice/tables/monframework/hooks/Hook_mf_systeme.php'; // Contrôle d'accès aux données, scripts à la connexion et à la déconnexion

// Controleur
    include 'C:\wamp64\www\dice\www\dice\joueur.php';

// joueur
    include 'systeme/dice/langues/fr/joueur.php';                     // Fichier de langue française et initialisation automatique des valeurs des colonnes
    include 'systeme/dice/droits/joueur.php';                         // Configuration des droits par défaut
    include 'systeme/dice/tables/joueur.php';                         // Ajout des fonctions personalisées liées à la table joueur
    include 'systeme/dice/tables/monframework/hooks/Hook_joueur.php'; // Evénements, data controller et completion
    include 'www/dice/code/_joueur_form.php';                         // Appels aux formulaires « ajouter », « modifier » et « supprimer ». Chargements de « _joueur_get.php » et  « _joueur_list.php »
        include 'www/dice/code/_joueur_get.php';                      // « _joueur_get.php » : Génération des éléments positiionnés dans un gabarit
        include 'www/dice/code/_joueur_list.php';                     // « _joueur_list.php » : Génération d'un tableau positiionné dans un gabarit
    include 'www/dice/code/_joueur_actions.php';                      // Récupération des données en provenance des formulaires et appels aux méthodes associées

/* Gabarits chargés :

    * C:\wamp64\www\dice\www\dice\gabarits\main\page.html
      Balise(s) : {titre_page}
                  {css}
                  {js}
                  {menu_principal}
                  {fil_ariane}
                  {sections}
                  {menu_secondaire}
                  {script_end}
                  {header}
                  {footer}


    * C:\wamp64\www\dice\www\dice\gabarits\main\footer.html
      Sans balise

    * C:\wamp64\www\dice\www\dice\gabarits\main\header.html
      Sans balise

    * C:\wamp64\www\dice\www\dice\gabarits\main\section.html
      Balise(s) : {fonction}
                  {nom_table}
                  {titre}
                  {contenu}


    * C:\wamp64\www\dice\www\dice\gabarits\joueur\bloc_lister.html
      Sans balise

*/
