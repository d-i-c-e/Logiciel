<?php

define('ADRESSE_SITE', 'http://localhost/dice/www/dice/'); // Correspond a l'adresse de la page d'accueil
define('ADRESSE_API', 'http://localhost/dice/www/dice/api.rest/'); // Correspond a l'adresse de l'API
define('FIN_ADRESSE_RACINE', 'dice'); // permet l'utilisation d'un sous-domaine

define('NOM_PROJET', 'dice');
define('HTTPS_ON', false);
$ADRESSES_IP_AUTORISES = ['127.0.0.1', '::1']; // si vide, pas de restriction. Sinon, les ip autorisees
define('MODE_PROD', false);

define('TABLE_INSTANCE', '');
define('PREFIXE_DB_INSTANCE', 'zz');
define('TITRE_DB_INSTANCE', '{colonne_1} {colonne_2} ...');

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'dice');
define('DB_PORT', NULL);

define('CONNECTEUR_API_TABLE', '');              // table qui contient les connecteurs API
define('CONNECTEUR_API_COLONNE_DATE_START', ''); // date d'activation du connecteur
define('CONNECTEUR_API_COLONNE_DATE_STOP', '');  // date d'arret du connecteur
define('CONNECTEUR_API_COLONNE_TOKEN', '');      // token de connexion

define('DUREE_HISTORIQUE', 30); // duree de conservation de l'historique en jours

define('PREFIXE_SESSION', 'dice');
define('PREFIXE_COOKIE', 'dice');

define('DUREE_CACHE_MINUTES', '60'); // duree du cache html uniquement

define('DELAI_RAFRAICHISSEMENT', '5000'); // rafraichissement ajax
define('DELAI_RAFRAICHISSEMENT_COURT', '50');

define('DELAI_EXECUTION_WORKER', 60); // Delai d'execution du worker en secondes

define('BOUTON_VALIDATION_SOUS_FORMULAIRE', true);
define('BOUTON_INTEGRABLE', true);
define('NB_ELEMENTS_MAX_PAR_TABLEAU', '100');
define('FORM_SUPPR_DEFAUT', '1'); // 0 : Nom ou 1 : Oui

define('IMAGES_LARGEUR_MAXI', 1024);
define('IMAGES_HAUTEUR_MAXI', 768);
define('MODE_RETINA', false); // true : permet de prendre en charge les ecrans retina en doublant la resolution des images

define('USE_BOOTSTRAP', true);
define('VERSION_BOOTSTRAP', '3'); // 3 ou 4

define('AUTOCOMPLETION_DEFAUT', false); // false pour plus d'optimisation
define('TOUTES_COLONNES_DEFAUT', false); // false pour plus d'optimisation
define('CONTROLE_ACCES_DONNEES_DEFAUT', true); // activation du controle des acces aux donnes par defaut

define('MAIL_NOREPLY', 'exemple@exemple.com');
define('MAIL_ADMIN', 'herve.hautbois@gmail.com');

define('DUREE_CACHE_NAV_CLIENT_EN_JOURS', 100);

define('ACTIVER_FORMULAIRE_INSCRIPTION', false);
define('ACTIVER_CONNEXION_EMAIL', false);
define('MULTI_BLOCS', true);

define('MODE_DESIGN', false);

