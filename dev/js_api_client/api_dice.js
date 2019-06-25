
// Paramètres

var API_ADDRESS = "";
var l = "" + window.location;
if (l.indexOf("localhost")>-1) { API_ADDRESS = "http://localhost/dice/www/dice/api.rest/"; }
else { API_ADDRESS = "..."; }
const PERIODE_EXECUTION = 100; // (en millisecondes)
var mf_instance = 0; // instance
var auth = "main"; // utilisation de l'instance courante du navigateur.

// Algorithme

function execution_passe() {
    // ici le code
}

// -----------------------------------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------------------------

function worker() {
    execution_passe();
    setTimeout(worker, PERIODE_EXECUTION);
}

$(function(){worker();});

var chrono_promesse = 0;
var collection_promesses = [];
var nb_requetes_en_cours = 0;

function ajouter_action(type, methode, data) {
    nb_requetes_en_cours++;
    var num_promesse = ++chrono_promesse;
    $.ajax({
        url: API_ADDRESS + methode,
        type: type,
        dataType: 'json',
        contentType: 'application/json',
        processData: true,
        headers : {'Content-Type' : 'application/x-www-form-urlencoded; charset=UTF-8'},
        data: data,
        success: function (data) {
            collection_promesses[num_promesse] = data;
            nb_requetes_en_cours--;
        },
        error: function(){
            collection_promesses[num_promesse] = false;
            nb_requetes_en_cours--;
        }
    });
    return num_promesse;
}

function promesse(num_promesse) {
    if ( collection_promesses[num_promesse] ) {
        var $p = collection_promesses[num_promesse];
        collection_promesses[num_promesse] = false;
        return $p;
    } else {
        return false;
    }
}

// Functions api

var mf_token = "";

var id_promesse__connexion = 0;
function connexion(mf_login, mf_pwd) { id_promesse__connexion = ajouter_action( "POST", "mf_connexion?mf_instance=" + mf_instance, JSON.stringify( { mf_login: mf_login, mf_pwd: mf_pwd } ) ); }
function r__connexion() { var r = promesse(id_promesse__connexion); if ( r ) { mf_token = r['data']['mf_token']; } return r; }

var id_promesse__inscription = 0;
function inscription(mf_login, mf_pwd, mf_pwd_2, mf_email, mf_email_2) { id_promesse__inscription = ajouter_action( "POST", "mf_inscription?mf_instance=" + mf_instance, JSON.stringify( { mf_login: mf_login, mf_pwd: mf_pwd, mf_pwd_2: mf_pwd_2, mf_email: mf_email, mf_email_2: mf_email_2 } ) ); }
function r__inscription() { return promesse(id_promesse__inscription); }

var id_promesse__maj_mdp = 0;
function maj_mdp(Code_joueur, mf_current_pwd, mf_new_pwd, mf_conf_pwd) { id_promesse__maj_mdp = ajouter_action( "PUT", "mf_change_password/" + Code_joueur + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify( { mf_current_pwd: mf_current_pwd, mf_new_pwd: mf_new_pwd, mf_conf_pwd: mf_conf_pwd } ) ); }
function r__maj_mdp() { return promesse(id_promesse__maj_mdp); }

var id_promesse__demande_nouv_mdp = 0;
function demande_nouv_mdp(mf_login, mf_email) { id_promesse__demande_nouv_mdp = ajouter_action( "POST", "mf_new_password?mf_instance=" + mf_instance, JSON.stringify( { mf_login: mf_login, mf_email: mf_email } ) ); }
function r__demande_nouv_mdp() { return promesse(id_promesse__demande_nouv_mdp); }

// +--------+
// | joueur |
// +--------+

var id_promesse__joueur__get = 0;
var ref_promesse__joueur__get = '';
function joueur__get(Code_joueur, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__joueur__get = ref; id_promesse__joueur__get = ajouter_action( "GET", "joueur/" + Code_joueur + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__joueur__get(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__joueur__get == ref ) { return promesse(id_promesse__joueur__get); } else { return false; } }

var id_promesse__joueur__get_all = 0;
var ref_promesse__joueur__get_all = '';
function joueur__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__joueur__get_all = ref; id_promesse__joueur__get_all = ajouter_action( "GET", "joueur?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__joueur__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__joueur__get_all == ref ) { return promesse(id_promesse__joueur__get_all); } else { return false; } }

/*
  json_data = {
    joueur_Email: …,
    joueur_Identifiant: …,
    joueur_Password: …,
    joueur_Avatar_Fichier: …,
    joueur_Date_naissance: …,
    joueur_Date_inscription: …,
  }
*/
var id_promesse__joueur__post = 0;
var ref_promesse__joueur__post = '';
function joueur__post(json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__joueur__post = ref; id_promesse__joueur__post = ajouter_action( "POST", "joueur?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__joueur__post(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__joueur__post == ref ) { return promesse(id_promesse__joueur__post); } else { return false; } }

/*
  json_data = {
    joueur_Email: …,
    joueur_Identifiant: …,
    joueur_Password: …,
    joueur_Avatar_Fichier: …,
    joueur_Date_naissance: …,
    joueur_Date_inscription: …,
  }
*/
var id_promesse__joueur__put = 0;
var ref_promesse__joueur__put = '';
function joueur__put(Code_joueur, json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__joueur__put = ref; id_promesse__joueur__put = ajouter_action( "PUT", "joueur/" + Code_joueur + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__joueur__put(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__joueur__put == ref ) { return promesse(id_promesse__joueur__put); } else { return false; } }

var id_promesse__joueur__delete = 0;
var ref_promesse__joueur__delete = '';
function joueur__delete(Code_joueur, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__joueur__delete = ref; id_promesse__joueur__delete = ajouter_action( "DELETE", "joueur/" + Code_joueur + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth ); }
function r__joueur__delete(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__joueur__delete == ref ) { return promesse(id_promesse__joueur__delete); } else { return false; } }

// +---------+
// | message |
// +---------+

var id_promesse__message__get = 0;
var ref_promesse__message__get = '';
function message__get(Code_message, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__message__get = ref; id_promesse__message__get = ajouter_action( "GET", "message/" + Code_message + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__message__get(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__message__get == ref ) { return promesse(id_promesse__message__get); } else { return false; } }

var id_promesse__message__get_all = 0;
var ref_promesse__message__get_all = '';
function message__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__message__get_all = ref; id_promesse__message__get_all = ajouter_action( "GET", "message?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__message__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__message__get_all == ref ) { return promesse(id_promesse__message__get_all); } else { return false; } }

/*
  json_data = {
    message_Texte: …,
    message_Date: …,
    Code_messagerie: …,
    Code_joueur: …,
  }
*/
var id_promesse__message__post = 0;
var ref_promesse__message__post = '';
function message__post(json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__message__post = ref; id_promesse__message__post = ajouter_action( "POST", "message?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__message__post(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__message__post == ref ) { return promesse(id_promesse__message__post); } else { return false; } }

/*
  json_data = {
    message_Texte: …,
    message_Date: …,
    Code_messagerie: …,
    Code_joueur: …,
  }
*/
var id_promesse__message__put = 0;
var ref_promesse__message__put = '';
function message__put(Code_message, json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__message__put = ref; id_promesse__message__put = ajouter_action( "PUT", "message/" + Code_message + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__message__put(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__message__put == ref ) { return promesse(id_promesse__message__put); } else { return false; } }

var id_promesse__message__delete = 0;
var ref_promesse__message__delete = '';
function message__delete(Code_message, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__message__delete = ref; id_promesse__message__delete = ajouter_action( "DELETE", "message/" + Code_message + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth ); }
function r__message__delete(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__message__delete == ref ) { return promesse(id_promesse__message__delete); } else { return false; } }

// +-----------+
// | parametre |
// +-----------+

var id_promesse__parametre__get = 0;
var ref_promesse__parametre__get = '';
function parametre__get(Code_parametre, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__parametre__get = ref; id_promesse__parametre__get = ajouter_action( "GET", "parametre/" + Code_parametre + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__parametre__get(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__parametre__get == ref ) { return promesse(id_promesse__parametre__get); } else { return false; } }

var id_promesse__parametre__get_all = 0;
var ref_promesse__parametre__get_all = '';
function parametre__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__parametre__get_all = ref; id_promesse__parametre__get_all = ajouter_action( "GET", "parametre?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__parametre__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__parametre__get_all == ref ) { return promesse(id_promesse__parametre__get_all); } else { return false; } }

/*
  json_data = {
    parametre_Libelle: …,
    parametre_Valeur: …,
    parametre_Activable: …,
    parametre_Actif: …,
  }
*/
var id_promesse__parametre__post = 0;
var ref_promesse__parametre__post = '';
function parametre__post(json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__parametre__post = ref; id_promesse__parametre__post = ajouter_action( "POST", "parametre?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__parametre__post(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__parametre__post == ref ) { return promesse(id_promesse__parametre__post); } else { return false; } }

/*
  json_data = {
    parametre_Libelle: …,
    parametre_Valeur: …,
    parametre_Activable: …,
    parametre_Actif: …,
  }
*/
var id_promesse__parametre__put = 0;
var ref_promesse__parametre__put = '';
function parametre__put(Code_parametre, json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__parametre__put = ref; id_promesse__parametre__put = ajouter_action( "PUT", "parametre/" + Code_parametre + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__parametre__put(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__parametre__put == ref ) { return promesse(id_promesse__parametre__put); } else { return false; } }

var id_promesse__parametre__delete = 0;
var ref_promesse__parametre__delete = '';
function parametre__delete(Code_parametre, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__parametre__delete = ref; id_promesse__parametre__delete = ajouter_action( "DELETE", "parametre/" + Code_parametre + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth ); }
function r__parametre__delete(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__parametre__delete == ref ) { return promesse(id_promesse__parametre__delete); } else { return false; } }

// +--------+
// | groupe |
// +--------+

var id_promesse__groupe__get = 0;
var ref_promesse__groupe__get = '';
function groupe__get(Code_groupe, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__groupe__get = ref; id_promesse__groupe__get = ajouter_action( "GET", "groupe/" + Code_groupe + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__groupe__get(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__groupe__get == ref ) { return promesse(id_promesse__groupe__get); } else { return false; } }

var id_promesse__groupe__get_all = 0;
var ref_promesse__groupe__get_all = '';
function groupe__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__groupe__get_all = ref; id_promesse__groupe__get_all = ajouter_action( "GET", "groupe?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__groupe__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__groupe__get_all == ref ) { return promesse(id_promesse__groupe__get_all); } else { return false; } }

/*
  json_data = {
    groupe_Nom: …,
    groupe_Description: …,
    groupe_Logo_Fichier: …,
    groupe_Effectif: …,
    groupe_Actif: …,
    groupe_Date_creation: …,
    groupe_Delai_suppression_jour: …,
    groupe_Suppression_active: …,
    Code_campagne: …,
  }
*/
var id_promesse__groupe__post = 0;
var ref_promesse__groupe__post = '';
function groupe__post(json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__groupe__post = ref; id_promesse__groupe__post = ajouter_action( "POST", "groupe?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__groupe__post(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__groupe__post == ref ) { return promesse(id_promesse__groupe__post); } else { return false; } }

/*
  json_data = {
    groupe_Nom: …,
    groupe_Description: …,
    groupe_Logo_Fichier: …,
    groupe_Effectif: …,
    groupe_Actif: …,
    groupe_Date_creation: …,
    groupe_Delai_suppression_jour: …,
    groupe_Suppression_active: …,
    Code_campagne: …,
  }
*/
var id_promesse__groupe__put = 0;
var ref_promesse__groupe__put = '';
function groupe__put(Code_groupe, json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__groupe__put = ref; id_promesse__groupe__put = ajouter_action( "PUT", "groupe/" + Code_groupe + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__groupe__put(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__groupe__put == ref ) { return promesse(id_promesse__groupe__put); } else { return false; } }

var id_promesse__groupe__delete = 0;
var ref_promesse__groupe__delete = '';
function groupe__delete(Code_groupe, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__groupe__delete = ref; id_promesse__groupe__delete = ajouter_action( "DELETE", "groupe/" + Code_groupe + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth ); }
function r__groupe__delete(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__groupe__delete == ref ) { return promesse(id_promesse__groupe__delete); } else { return false; } }

// +------------+
// | personnage |
// +------------+

var id_promesse__personnage__get = 0;
var ref_promesse__personnage__get = '';
function personnage__get(Code_personnage, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__personnage__get = ref; id_promesse__personnage__get = ajouter_action( "GET", "personnage/" + Code_personnage + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__personnage__get(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__personnage__get == ref ) { return promesse(id_promesse__personnage__get); } else { return false; } }

var id_promesse__personnage__get_all = 0;
var ref_promesse__personnage__get_all = '';
function personnage__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__personnage__get_all = ref; id_promesse__personnage__get_all = ajouter_action( "GET", "personnage?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__personnage__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__personnage__get_all == ref ) { return promesse(id_promesse__personnage__get_all); } else { return false; } }

/*
  json_data = {
    personnage_Fichier_Fichier: …,
    personnage_Conservation: …,
    Code_joueur: …,
    Code_groupe: …,
  }
*/
var id_promesse__personnage__post = 0;
var ref_promesse__personnage__post = '';
function personnage__post(json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__personnage__post = ref; id_promesse__personnage__post = ajouter_action( "POST", "personnage?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__personnage__post(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__personnage__post == ref ) { return promesse(id_promesse__personnage__post); } else { return false; } }

/*
  json_data = {
    personnage_Fichier_Fichier: …,
    personnage_Conservation: …,
    Code_joueur: …,
    Code_groupe: …,
  }
*/
var id_promesse__personnage__put = 0;
var ref_promesse__personnage__put = '';
function personnage__put(Code_personnage, json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__personnage__put = ref; id_promesse__personnage__put = ajouter_action( "PUT", "personnage/" + Code_personnage + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__personnage__put(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__personnage__put == ref ) { return promesse(id_promesse__personnage__put); } else { return false; } }

var id_promesse__personnage__delete = 0;
var ref_promesse__personnage__delete = '';
function personnage__delete(Code_personnage, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__personnage__delete = ref; id_promesse__personnage__delete = ajouter_action( "DELETE", "personnage/" + Code_personnage + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth ); }
function r__personnage__delete(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__personnage__delete == ref ) { return promesse(id_promesse__personnage__delete); } else { return false; } }

// +----------+
// | campagne |
// +----------+

var id_promesse__campagne__get = 0;
var ref_promesse__campagne__get = '';
function campagne__get(Code_campagne, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__campagne__get = ref; id_promesse__campagne__get = ajouter_action( "GET", "campagne/" + Code_campagne + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__campagne__get(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__campagne__get == ref ) { return promesse(id_promesse__campagne__get); } else { return false; } }

var id_promesse__campagne__get_all = 0;
var ref_promesse__campagne__get_all = '';
function campagne__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__campagne__get_all = ref; id_promesse__campagne__get_all = ajouter_action( "GET", "campagne?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__campagne__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__campagne__get_all == ref ) { return promesse(id_promesse__campagne__get_all); } else { return false; } }

/*
  json_data = {
    campagne_Nom: …,
    campagne_Description: …,
    campagne_Image_Fichier: …,
    campagne_Nombre_joueur: …,
    campagne_Nombre_mj: …,
  }
*/
var id_promesse__campagne__post = 0;
var ref_promesse__campagne__post = '';
function campagne__post(json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__campagne__post = ref; id_promesse__campagne__post = ajouter_action( "POST", "campagne?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__campagne__post(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__campagne__post == ref ) { return promesse(id_promesse__campagne__post); } else { return false; } }

/*
  json_data = {
    campagne_Nom: …,
    campagne_Description: …,
    campagne_Image_Fichier: …,
    campagne_Nombre_joueur: …,
    campagne_Nombre_mj: …,
  }
*/
var id_promesse__campagne__put = 0;
var ref_promesse__campagne__put = '';
function campagne__put(Code_campagne, json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__campagne__put = ref; id_promesse__campagne__put = ajouter_action( "PUT", "campagne/" + Code_campagne + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__campagne__put(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__campagne__put == ref ) { return promesse(id_promesse__campagne__put); } else { return false; } }

var id_promesse__campagne__delete = 0;
var ref_promesse__campagne__delete = '';
function campagne__delete(Code_campagne, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__campagne__delete = ref; id_promesse__campagne__delete = ajouter_action( "DELETE", "campagne/" + Code_campagne + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth ); }
function r__campagne__delete(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__campagne__delete == ref ) { return promesse(id_promesse__campagne__delete); } else { return false; } }

// +--------------+
// | tag_campagne |
// +--------------+

var id_promesse__tag_campagne__get = 0;
var ref_promesse__tag_campagne__get = '';
function tag_campagne__get(Code_tag_campagne, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__tag_campagne__get = ref; id_promesse__tag_campagne__get = ajouter_action( "GET", "tag_campagne/" + Code_tag_campagne + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__tag_campagne__get(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__tag_campagne__get == ref ) { return promesse(id_promesse__tag_campagne__get); } else { return false; } }

var id_promesse__tag_campagne__get_all = 0;
var ref_promesse__tag_campagne__get_all = '';
function tag_campagne__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__tag_campagne__get_all = ref; id_promesse__tag_campagne__get_all = ajouter_action( "GET", "tag_campagne?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__tag_campagne__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__tag_campagne__get_all == ref ) { return promesse(id_promesse__tag_campagne__get_all); } else { return false; } }

/*
  json_data = {
    tag_campagne_Libelle: …,
  }
*/
var id_promesse__tag_campagne__post = 0;
var ref_promesse__tag_campagne__post = '';
function tag_campagne__post(json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__tag_campagne__post = ref; id_promesse__tag_campagne__post = ajouter_action( "POST", "tag_campagne?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__tag_campagne__post(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__tag_campagne__post == ref ) { return promesse(id_promesse__tag_campagne__post); } else { return false; } }

/*
  json_data = {
    tag_campagne_Libelle: …,
  }
*/
var id_promesse__tag_campagne__put = 0;
var ref_promesse__tag_campagne__put = '';
function tag_campagne__put(Code_tag_campagne, json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__tag_campagne__put = ref; id_promesse__tag_campagne__put = ajouter_action( "PUT", "tag_campagne/" + Code_tag_campagne + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__tag_campagne__put(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__tag_campagne__put == ref ) { return promesse(id_promesse__tag_campagne__put); } else { return false; } }

var id_promesse__tag_campagne__delete = 0;
var ref_promesse__tag_campagne__delete = '';
function tag_campagne__delete(Code_tag_campagne, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__tag_campagne__delete = ref; id_promesse__tag_campagne__delete = ajouter_action( "DELETE", "tag_campagne/" + Code_tag_campagne + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth ); }
function r__tag_campagne__delete(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__tag_campagne__delete == ref ) { return promesse(id_promesse__tag_campagne__delete); } else { return false; } }

// +-------+
// | carte |
// +-------+

var id_promesse__carte__get = 0;
var ref_promesse__carte__get = '';
function carte__get(Code_carte, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__carte__get = ref; id_promesse__carte__get = ajouter_action( "GET", "carte/" + Code_carte + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__carte__get(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__carte__get == ref ) { return promesse(id_promesse__carte__get); } else { return false; } }

var id_promesse__carte__get_all = 0;
var ref_promesse__carte__get_all = '';
function carte__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__carte__get_all = ref; id_promesse__carte__get_all = ajouter_action( "GET", "carte?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__carte__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__carte__get_all == ref ) { return promesse(id_promesse__carte__get_all); } else { return false; } }

/*
  json_data = {
    carte_Nom: …,
    carte_Hauteur: …,
    carte_Largeur: …,
    carte_Fichier: …,
    Code_groupe: …,
  }
*/
var id_promesse__carte__post = 0;
var ref_promesse__carte__post = '';
function carte__post(json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__carte__post = ref; id_promesse__carte__post = ajouter_action( "POST", "carte?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__carte__post(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__carte__post == ref ) { return promesse(id_promesse__carte__post); } else { return false; } }

/*
  json_data = {
    carte_Nom: …,
    carte_Hauteur: …,
    carte_Largeur: …,
    carte_Fichier: …,
    Code_groupe: …,
  }
*/
var id_promesse__carte__put = 0;
var ref_promesse__carte__put = '';
function carte__put(Code_carte, json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__carte__put = ref; id_promesse__carte__put = ajouter_action( "PUT", "carte/" + Code_carte + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__carte__put(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__carte__put == ref ) { return promesse(id_promesse__carte__put); } else { return false; } }

var id_promesse__carte__delete = 0;
var ref_promesse__carte__delete = '';
function carte__delete(Code_carte, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__carte__delete = ref; id_promesse__carte__delete = ajouter_action( "DELETE", "carte/" + Code_carte + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth ); }
function r__carte__delete(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__carte__delete == ref ) { return promesse(id_promesse__carte__delete); } else { return false; } }

// +-------+
// | objet |
// +-------+

var id_promesse__objet__get = 0;
var ref_promesse__objet__get = '';
function objet__get(Code_objet, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__objet__get = ref; id_promesse__objet__get = ajouter_action( "GET", "objet/" + Code_objet + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__objet__get(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__objet__get == ref ) { return promesse(id_promesse__objet__get); } else { return false; } }

var id_promesse__objet__get_all = 0;
var ref_promesse__objet__get_all = '';
function objet__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__objet__get_all = ref; id_promesse__objet__get_all = ajouter_action( "GET", "objet?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__objet__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__objet__get_all == ref ) { return promesse(id_promesse__objet__get_all); } else { return false; } }

/*
  json_data = {
    objet_Libelle: …,
    objet_Image_Fichier: …,
    Code_type: …,
  }
*/
var id_promesse__objet__post = 0;
var ref_promesse__objet__post = '';
function objet__post(json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__objet__post = ref; id_promesse__objet__post = ajouter_action( "POST", "objet?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__objet__post(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__objet__post == ref ) { return promesse(id_promesse__objet__post); } else { return false; } }

/*
  json_data = {
    objet_Libelle: …,
    objet_Image_Fichier: …,
    Code_type: …,
  }
*/
var id_promesse__objet__put = 0;
var ref_promesse__objet__put = '';
function objet__put(Code_objet, json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__objet__put = ref; id_promesse__objet__put = ajouter_action( "PUT", "objet/" + Code_objet + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__objet__put(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__objet__put == ref ) { return promesse(id_promesse__objet__put); } else { return false; } }

var id_promesse__objet__delete = 0;
var ref_promesse__objet__delete = '';
function objet__delete(Code_objet, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__objet__delete = ref; id_promesse__objet__delete = ajouter_action( "DELETE", "objet/" + Code_objet + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth ); }
function r__objet__delete(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__objet__delete == ref ) { return promesse(id_promesse__objet__delete); } else { return false; } }

// +------+
// | type |
// +------+

var id_promesse__type__get = 0;
var ref_promesse__type__get = '';
function type__get(Code_type, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__type__get = ref; id_promesse__type__get = ajouter_action( "GET", "type/" + Code_type + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__type__get(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__type__get == ref ) { return promesse(id_promesse__type__get); } else { return false; } }

var id_promesse__type__get_all = 0;
var ref_promesse__type__get_all = '';
function type__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__type__get_all = ref; id_promesse__type__get_all = ajouter_action( "GET", "type?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__type__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__type__get_all == ref ) { return promesse(id_promesse__type__get_all); } else { return false; } }

/*
  json_data = {
    type_Libelle: …,
    Code_ressource: …,
  }
*/
var id_promesse__type__post = 0;
var ref_promesse__type__post = '';
function type__post(json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__type__post = ref; id_promesse__type__post = ajouter_action( "POST", "type?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__type__post(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__type__post == ref ) { return promesse(id_promesse__type__post); } else { return false; } }

/*
  json_data = {
    type_Libelle: …,
    Code_ressource: …,
  }
*/
var id_promesse__type__put = 0;
var ref_promesse__type__put = '';
function type__put(Code_type, json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__type__put = ref; id_promesse__type__put = ajouter_action( "PUT", "type/" + Code_type + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__type__put(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__type__put == ref ) { return promesse(id_promesse__type__put); } else { return false; } }

var id_promesse__type__delete = 0;
var ref_promesse__type__delete = '';
function type__delete(Code_type, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__type__delete = ref; id_promesse__type__delete = ajouter_action( "DELETE", "type/" + Code_type + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth ); }
function r__type__delete(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__type__delete == ref ) { return promesse(id_promesse__type__delete); } else { return false; } }

// +-----------+
// | ressource |
// +-----------+

var id_promesse__ressource__get = 0;
var ref_promesse__ressource__get = '';
function ressource__get(Code_ressource, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__ressource__get = ref; id_promesse__ressource__get = ajouter_action( "GET", "ressource/" + Code_ressource + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__ressource__get(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__ressource__get == ref ) { return promesse(id_promesse__ressource__get); } else { return false; } }

var id_promesse__ressource__get_all = 0;
var ref_promesse__ressource__get_all = '';
function ressource__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__ressource__get_all = ref; id_promesse__ressource__get_all = ajouter_action( "GET", "ressource?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__ressource__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__ressource__get_all == ref ) { return promesse(id_promesse__ressource__get_all); } else { return false; } }

/*
  json_data = {
    ressource_Nom: …,
  }
*/
var id_promesse__ressource__post = 0;
var ref_promesse__ressource__post = '';
function ressource__post(json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__ressource__post = ref; id_promesse__ressource__post = ajouter_action( "POST", "ressource?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__ressource__post(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__ressource__post == ref ) { return promesse(id_promesse__ressource__post); } else { return false; } }

/*
  json_data = {
    ressource_Nom: …,
  }
*/
var id_promesse__ressource__put = 0;
var ref_promesse__ressource__put = '';
function ressource__put(Code_ressource, json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__ressource__put = ref; id_promesse__ressource__put = ajouter_action( "PUT", "ressource/" + Code_ressource + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__ressource__put(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__ressource__put == ref ) { return promesse(id_promesse__ressource__put); } else { return false; } }

var id_promesse__ressource__delete = 0;
var ref_promesse__ressource__delete = '';
function ressource__delete(Code_ressource, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__ressource__delete = ref; id_promesse__ressource__delete = ajouter_action( "DELETE", "ressource/" + Code_ressource + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth ); }
function r__ressource__delete(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__ressource__delete == ref ) { return promesse(id_promesse__ressource__delete); } else { return false; } }

// +---------------+
// | tag_ressource |
// +---------------+

var id_promesse__tag_ressource__get = 0;
var ref_promesse__tag_ressource__get = '';
function tag_ressource__get(Code_tag_ressource, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__tag_ressource__get = ref; id_promesse__tag_ressource__get = ajouter_action( "GET", "tag_ressource/" + Code_tag_ressource + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__tag_ressource__get(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__tag_ressource__get == ref ) { return promesse(id_promesse__tag_ressource__get); } else { return false; } }

var id_promesse__tag_ressource__get_all = 0;
var ref_promesse__tag_ressource__get_all = '';
function tag_ressource__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__tag_ressource__get_all = ref; id_promesse__tag_ressource__get_all = ajouter_action( "GET", "tag_ressource?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__tag_ressource__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__tag_ressource__get_all == ref ) { return promesse(id_promesse__tag_ressource__get_all); } else { return false; } }

/*
  json_data = {
    tag_ressource_Libelle: …,
  }
*/
var id_promesse__tag_ressource__post = 0;
var ref_promesse__tag_ressource__post = '';
function tag_ressource__post(json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__tag_ressource__post = ref; id_promesse__tag_ressource__post = ajouter_action( "POST", "tag_ressource?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__tag_ressource__post(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__tag_ressource__post == ref ) { return promesse(id_promesse__tag_ressource__post); } else { return false; } }

/*
  json_data = {
    tag_ressource_Libelle: …,
  }
*/
var id_promesse__tag_ressource__put = 0;
var ref_promesse__tag_ressource__put = '';
function tag_ressource__put(Code_tag_ressource, json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__tag_ressource__put = ref; id_promesse__tag_ressource__put = ajouter_action( "PUT", "tag_ressource/" + Code_tag_ressource + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__tag_ressource__put(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__tag_ressource__put == ref ) { return promesse(id_promesse__tag_ressource__put); } else { return false; } }

var id_promesse__tag_ressource__delete = 0;
var ref_promesse__tag_ressource__delete = '';
function tag_ressource__delete(Code_tag_ressource, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__tag_ressource__delete = ref; id_promesse__tag_ressource__delete = ajouter_action( "DELETE", "tag_ressource/" + Code_tag_ressource + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth ); }
function r__tag_ressource__delete(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__tag_ressource__delete == ref ) { return promesse(id_promesse__tag_ressource__delete); } else { return false; } }

// +------------+
// | messagerie |
// +------------+

var id_promesse__messagerie__get = 0;
var ref_promesse__messagerie__get = '';
function messagerie__get(Code_messagerie, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__messagerie__get = ref; id_promesse__messagerie__get = ajouter_action( "GET", "messagerie/" + Code_messagerie + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__messagerie__get(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__messagerie__get == ref ) { return promesse(id_promesse__messagerie__get); } else { return false; } }

var id_promesse__messagerie__get_all = 0;
var ref_promesse__messagerie__get_all = '';
function messagerie__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__messagerie__get_all = ref; id_promesse__messagerie__get_all = ajouter_action( "GET", "messagerie?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__messagerie__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__messagerie__get_all == ref ) { return promesse(id_promesse__messagerie__get_all); } else { return false; } }

/*
  json_data = {
    messagerie_Nom: …,
    Code_joueur: …,
  }
*/
var id_promesse__messagerie__post = 0;
var ref_promesse__messagerie__post = '';
function messagerie__post(json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__messagerie__post = ref; id_promesse__messagerie__post = ajouter_action( "POST", "messagerie?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__messagerie__post(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__messagerie__post == ref ) { return promesse(id_promesse__messagerie__post); } else { return false; } }

/*
  json_data = {
    messagerie_Nom: …,
    Code_joueur: …,
  }
*/
var id_promesse__messagerie__put = 0;
var ref_promesse__messagerie__put = '';
function messagerie__put(Code_messagerie, json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__messagerie__put = ref; id_promesse__messagerie__put = ajouter_action( "PUT", "messagerie/" + Code_messagerie + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__messagerie__put(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__messagerie__put == ref ) { return promesse(id_promesse__messagerie__put); } else { return false; } }

var id_promesse__messagerie__delete = 0;
var ref_promesse__messagerie__delete = '';
function messagerie__delete(Code_messagerie, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__messagerie__delete = ref; id_promesse__messagerie__delete = ajouter_action( "DELETE", "messagerie/" + Code_messagerie + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth ); }
function r__messagerie__delete(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__messagerie__delete == ref ) { return promesse(id_promesse__messagerie__delete); } else { return false; } }

// +----------------+
// | liste_contacts |
// +----------------+

var id_promesse__liste_contacts__get = 0;
var ref_promesse__liste_contacts__get = '';
function liste_contacts__get(Code_liste_contacts, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__liste_contacts__get = ref; id_promesse__liste_contacts__get = ajouter_action( "GET", "liste_contacts/" + Code_liste_contacts + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__liste_contacts__get(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__liste_contacts__get == ref ) { return promesse(id_promesse__liste_contacts__get); } else { return false; } }

var id_promesse__liste_contacts__get_all = 0;
var ref_promesse__liste_contacts__get_all = '';
function liste_contacts__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__liste_contacts__get_all = ref; id_promesse__liste_contacts__get_all = ajouter_action( "GET", "liste_contacts?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__liste_contacts__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__liste_contacts__get_all == ref ) { return promesse(id_promesse__liste_contacts__get_all); } else { return false; } }

/*
  json_data = {
    liste_contacts_Nom: …,
    Code_joueur: …,
  }
*/
var id_promesse__liste_contacts__post = 0;
var ref_promesse__liste_contacts__post = '';
function liste_contacts__post(json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__liste_contacts__post = ref; id_promesse__liste_contacts__post = ajouter_action( "POST", "liste_contacts?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__liste_contacts__post(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__liste_contacts__post == ref ) { return promesse(id_promesse__liste_contacts__post); } else { return false; } }

/*
  json_data = {
    liste_contacts_Nom: …,
    Code_joueur: …,
  }
*/
var id_promesse__liste_contacts__put = 0;
var ref_promesse__liste_contacts__put = '';
function liste_contacts__put(Code_liste_contacts, json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__liste_contacts__put = ref; id_promesse__liste_contacts__put = ajouter_action( "PUT", "liste_contacts/" + Code_liste_contacts + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__liste_contacts__put(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__liste_contacts__put == ref ) { return promesse(id_promesse__liste_contacts__put); } else { return false; } }

var id_promesse__liste_contacts__delete = 0;
var ref_promesse__liste_contacts__delete = '';
function liste_contacts__delete(Code_liste_contacts, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__liste_contacts__delete = ref; id_promesse__liste_contacts__delete = ajouter_action( "DELETE", "liste_contacts/" + Code_liste_contacts + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth ); }
function r__liste_contacts__delete(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__liste_contacts__delete == ref ) { return promesse(id_promesse__liste_contacts__delete); } else { return false; } }

// +--------------------+
// | a_joueur_parametre |
// +--------------------+

var id_promesse__a_joueur_parametre__get = 0;
var ref_promesse__a_joueur_parametre__get = '';
function a_joueur_parametre__get(Code_joueur, Code_parametre, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_joueur_parametre__get = ref; id_promesse__a_joueur_parametre__get = ajouter_action( "GET", "a_joueur_parametre/" + Code_joueur + '-' + Code_parametre + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__a_joueur_parametre__get(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_joueur_parametre__get == ref ) { return promesse(id_promesse__a_joueur_parametre__get); } else { return false; } }

var id_promesse__a_joueur_parametre__get_all = 0;
var ref_promesse__a_joueur_parametre__get_all = '';
function a_joueur_parametre__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_joueur_parametre__get_all = ref; id_promesse__a_joueur_parametre__get_all = ajouter_action( "GET", "a_joueur_parametre?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__a_joueur_parametre__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_joueur_parametre__get_all == ref ) { return promesse(id_promesse__a_joueur_parametre__get_all); } else { return false; } }

/*
  json_data = {
    Code_joueur: …,
    Code_parametre: …,
  }
*/
var id_promesse__a_joueur_parametre__post = 0;
var ref_promesse__a_joueur_parametre__post = '';
function a_joueur_parametre__post(json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_joueur_parametre__post = ref; id_promesse__a_joueur_parametre__post = ajouter_action( "POST", "a_joueur_parametre?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__a_joueur_parametre__post(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_joueur_parametre__post == ref ) { return promesse(id_promesse__a_joueur_parametre__post); } else { return false; } }

/*
  json_data = {
  }
*/
var id_promesse__a_joueur_parametre__put = 0;
var ref_promesse__a_joueur_parametre__put = '';
function a_joueur_parametre__put(Code_joueur, Code_parametre, json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_joueur_parametre__put = ref; id_promesse__a_joueur_parametre__put = ajouter_action( "PUT", "a_joueur_parametre/" + Code_joueur + '-' + Code_parametre + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__a_joueur_parametre__put(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_joueur_parametre__put == ref ) { return promesse(id_promesse__a_joueur_parametre__put); } else { return false; } }

var id_promesse__a_joueur_parametre__delete = 0;
var ref_promesse__a_joueur_parametre__delete = '';
function a_joueur_parametre__delete(Code_joueur, Code_parametre, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_joueur_parametre__delete = ref; id_promesse__a_joueur_parametre__delete = ajouter_action( "DELETE", "a_joueur_parametre/" + Code_joueur + '-' + Code_parametre + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth ); }
function r__a_joueur_parametre__delete(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_joueur_parametre__delete == ref ) { return promesse(id_promesse__a_joueur_parametre__delete); } else { return false; } }

// +-----------------------------+
// | a_candidature_joueur_groupe |
// +-----------------------------+

var id_promesse__a_candidature_joueur_groupe__get = 0;
var ref_promesse__a_candidature_joueur_groupe__get = '';
function a_candidature_joueur_groupe__get(Code_joueur, Code_groupe, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_candidature_joueur_groupe__get = ref; id_promesse__a_candidature_joueur_groupe__get = ajouter_action( "GET", "a_candidature_joueur_groupe/" + Code_joueur + '-' + Code_groupe + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__a_candidature_joueur_groupe__get(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_candidature_joueur_groupe__get == ref ) { return promesse(id_promesse__a_candidature_joueur_groupe__get); } else { return false; } }

var id_promesse__a_candidature_joueur_groupe__get_all = 0;
var ref_promesse__a_candidature_joueur_groupe__get_all = '';
function a_candidature_joueur_groupe__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_candidature_joueur_groupe__get_all = ref; id_promesse__a_candidature_joueur_groupe__get_all = ajouter_action( "GET", "a_candidature_joueur_groupe?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__a_candidature_joueur_groupe__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_candidature_joueur_groupe__get_all == ref ) { return promesse(id_promesse__a_candidature_joueur_groupe__get_all); } else { return false; } }

/*
  json_data = {
    a_candidature_joueur_groupe_Message: …,
    a_candidature_joueur_groupe_Date_envoi: …,
    Code_joueur: …,
    Code_groupe: …,
  }
*/
var id_promesse__a_candidature_joueur_groupe__post = 0;
var ref_promesse__a_candidature_joueur_groupe__post = '';
function a_candidature_joueur_groupe__post(json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_candidature_joueur_groupe__post = ref; id_promesse__a_candidature_joueur_groupe__post = ajouter_action( "POST", "a_candidature_joueur_groupe?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__a_candidature_joueur_groupe__post(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_candidature_joueur_groupe__post == ref ) { return promesse(id_promesse__a_candidature_joueur_groupe__post); } else { return false; } }

/*
  json_data = {
    a_candidature_joueur_groupe_Message: …,
    a_candidature_joueur_groupe_Date_envoi: …,
  }
*/
var id_promesse__a_candidature_joueur_groupe__put = 0;
var ref_promesse__a_candidature_joueur_groupe__put = '';
function a_candidature_joueur_groupe__put(Code_joueur, Code_groupe, json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_candidature_joueur_groupe__put = ref; id_promesse__a_candidature_joueur_groupe__put = ajouter_action( "PUT", "a_candidature_joueur_groupe/" + Code_joueur + '-' + Code_groupe + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__a_candidature_joueur_groupe__put(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_candidature_joueur_groupe__put == ref ) { return promesse(id_promesse__a_candidature_joueur_groupe__put); } else { return false; } }

var id_promesse__a_candidature_joueur_groupe__delete = 0;
var ref_promesse__a_candidature_joueur_groupe__delete = '';
function a_candidature_joueur_groupe__delete(Code_joueur, Code_groupe, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_candidature_joueur_groupe__delete = ref; id_promesse__a_candidature_joueur_groupe__delete = ajouter_action( "DELETE", "a_candidature_joueur_groupe/" + Code_joueur + '-' + Code_groupe + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth ); }
function r__a_candidature_joueur_groupe__delete(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_candidature_joueur_groupe__delete == ref ) { return promesse(id_promesse__a_candidature_joueur_groupe__delete); } else { return false; } }

// +------------------------+
// | a_membre_joueur_groupe |
// +------------------------+

var id_promesse__a_membre_joueur_groupe__get = 0;
var ref_promesse__a_membre_joueur_groupe__get = '';
function a_membre_joueur_groupe__get(Code_groupe, Code_joueur, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_membre_joueur_groupe__get = ref; id_promesse__a_membre_joueur_groupe__get = ajouter_action( "GET", "a_membre_joueur_groupe/" + Code_groupe + '-' + Code_joueur + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__a_membre_joueur_groupe__get(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_membre_joueur_groupe__get == ref ) { return promesse(id_promesse__a_membre_joueur_groupe__get); } else { return false; } }

var id_promesse__a_membre_joueur_groupe__get_all = 0;
var ref_promesse__a_membre_joueur_groupe__get_all = '';
function a_membre_joueur_groupe__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_membre_joueur_groupe__get_all = ref; id_promesse__a_membre_joueur_groupe__get_all = ajouter_action( "GET", "a_membre_joueur_groupe?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__a_membre_joueur_groupe__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_membre_joueur_groupe__get_all == ref ) { return promesse(id_promesse__a_membre_joueur_groupe__get_all); } else { return false; } }

/*
  json_data = {
    a_membre_joueur_groupe_Surnom: …,
    a_membre_joueur_groupe_Grade: …,
    a_membre_joueur_groupe_Date_adhesion: …,
    Code_groupe: …,
    Code_joueur: …,
  }
*/
var id_promesse__a_membre_joueur_groupe__post = 0;
var ref_promesse__a_membre_joueur_groupe__post = '';
function a_membre_joueur_groupe__post(json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_membre_joueur_groupe__post = ref; id_promesse__a_membre_joueur_groupe__post = ajouter_action( "POST", "a_membre_joueur_groupe?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__a_membre_joueur_groupe__post(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_membre_joueur_groupe__post == ref ) { return promesse(id_promesse__a_membre_joueur_groupe__post); } else { return false; } }

/*
  json_data = {
    a_membre_joueur_groupe_Surnom: …,
    a_membre_joueur_groupe_Grade: …,
    a_membre_joueur_groupe_Date_adhesion: …,
  }
*/
var id_promesse__a_membre_joueur_groupe__put = 0;
var ref_promesse__a_membre_joueur_groupe__put = '';
function a_membre_joueur_groupe__put(Code_groupe, Code_joueur, json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_membre_joueur_groupe__put = ref; id_promesse__a_membre_joueur_groupe__put = ajouter_action( "PUT", "a_membre_joueur_groupe/" + Code_groupe + '-' + Code_joueur + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__a_membre_joueur_groupe__put(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_membre_joueur_groupe__put == ref ) { return promesse(id_promesse__a_membre_joueur_groupe__put); } else { return false; } }

var id_promesse__a_membre_joueur_groupe__delete = 0;
var ref_promesse__a_membre_joueur_groupe__delete = '';
function a_membre_joueur_groupe__delete(Code_groupe, Code_joueur, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_membre_joueur_groupe__delete = ref; id_promesse__a_membre_joueur_groupe__delete = ajouter_action( "DELETE", "a_membre_joueur_groupe/" + Code_groupe + '-' + Code_joueur + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth ); }
function r__a_membre_joueur_groupe__delete(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_membre_joueur_groupe__delete == ref ) { return promesse(id_promesse__a_membre_joueur_groupe__delete); } else { return false; } }

// +----------------------------+
// | a_invitation_joueur_groupe |
// +----------------------------+

var id_promesse__a_invitation_joueur_groupe__get = 0;
var ref_promesse__a_invitation_joueur_groupe__get = '';
function a_invitation_joueur_groupe__get(Code_joueur, Code_groupe, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_invitation_joueur_groupe__get = ref; id_promesse__a_invitation_joueur_groupe__get = ajouter_action( "GET", "a_invitation_joueur_groupe/" + Code_joueur + '-' + Code_groupe + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__a_invitation_joueur_groupe__get(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_invitation_joueur_groupe__get == ref ) { return promesse(id_promesse__a_invitation_joueur_groupe__get); } else { return false; } }

var id_promesse__a_invitation_joueur_groupe__get_all = 0;
var ref_promesse__a_invitation_joueur_groupe__get_all = '';
function a_invitation_joueur_groupe__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_invitation_joueur_groupe__get_all = ref; id_promesse__a_invitation_joueur_groupe__get_all = ajouter_action( "GET", "a_invitation_joueur_groupe?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__a_invitation_joueur_groupe__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_invitation_joueur_groupe__get_all == ref ) { return promesse(id_promesse__a_invitation_joueur_groupe__get_all); } else { return false; } }

/*
  json_data = {
    a_invitation_joueur_groupe_Message: …,
    a_invitation_joueur_groupe_Date_envoi: …,
    Code_joueur: …,
    Code_groupe: …,
  }
*/
var id_promesse__a_invitation_joueur_groupe__post = 0;
var ref_promesse__a_invitation_joueur_groupe__post = '';
function a_invitation_joueur_groupe__post(json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_invitation_joueur_groupe__post = ref; id_promesse__a_invitation_joueur_groupe__post = ajouter_action( "POST", "a_invitation_joueur_groupe?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__a_invitation_joueur_groupe__post(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_invitation_joueur_groupe__post == ref ) { return promesse(id_promesse__a_invitation_joueur_groupe__post); } else { return false; } }

/*
  json_data = {
    a_invitation_joueur_groupe_Message: …,
    a_invitation_joueur_groupe_Date_envoi: …,
  }
*/
var id_promesse__a_invitation_joueur_groupe__put = 0;
var ref_promesse__a_invitation_joueur_groupe__put = '';
function a_invitation_joueur_groupe__put(Code_joueur, Code_groupe, json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_invitation_joueur_groupe__put = ref; id_promesse__a_invitation_joueur_groupe__put = ajouter_action( "PUT", "a_invitation_joueur_groupe/" + Code_joueur + '-' + Code_groupe + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__a_invitation_joueur_groupe__put(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_invitation_joueur_groupe__put == ref ) { return promesse(id_promesse__a_invitation_joueur_groupe__put); } else { return false; } }

var id_promesse__a_invitation_joueur_groupe__delete = 0;
var ref_promesse__a_invitation_joueur_groupe__delete = '';
function a_invitation_joueur_groupe__delete(Code_joueur, Code_groupe, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_invitation_joueur_groupe__delete = ref; id_promesse__a_invitation_joueur_groupe__delete = ajouter_action( "DELETE", "a_invitation_joueur_groupe/" + Code_joueur + '-' + Code_groupe + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth ); }
function r__a_invitation_joueur_groupe__delete(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_invitation_joueur_groupe__delete == ref ) { return promesse(id_promesse__a_invitation_joueur_groupe__delete); } else { return false; } }

// +---------------+
// | a_carte_objet |
// +---------------+

var id_promesse__a_carte_objet__get = 0;
var ref_promesse__a_carte_objet__get = '';
function a_carte_objet__get(Code_carte, Code_objet, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_carte_objet__get = ref; id_promesse__a_carte_objet__get = ajouter_action( "GET", "a_carte_objet/" + Code_carte + '-' + Code_objet + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__a_carte_objet__get(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_carte_objet__get == ref ) { return promesse(id_promesse__a_carte_objet__get); } else { return false; } }

var id_promesse__a_carte_objet__get_all = 0;
var ref_promesse__a_carte_objet__get_all = '';
function a_carte_objet__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_carte_objet__get_all = ref; id_promesse__a_carte_objet__get_all = ajouter_action( "GET", "a_carte_objet?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__a_carte_objet__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_carte_objet__get_all == ref ) { return promesse(id_promesse__a_carte_objet__get_all); } else { return false; } }

/*
  json_data = {
    Code_carte: …,
    Code_objet: …,
  }
*/
var id_promesse__a_carte_objet__post = 0;
var ref_promesse__a_carte_objet__post = '';
function a_carte_objet__post(json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_carte_objet__post = ref; id_promesse__a_carte_objet__post = ajouter_action( "POST", "a_carte_objet?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__a_carte_objet__post(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_carte_objet__post == ref ) { return promesse(id_promesse__a_carte_objet__post); } else { return false; } }

/*
  json_data = {
  }
*/
var id_promesse__a_carte_objet__put = 0;
var ref_promesse__a_carte_objet__put = '';
function a_carte_objet__put(Code_carte, Code_objet, json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_carte_objet__put = ref; id_promesse__a_carte_objet__put = ajouter_action( "PUT", "a_carte_objet/" + Code_carte + '-' + Code_objet + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__a_carte_objet__put(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_carte_objet__put == ref ) { return promesse(id_promesse__a_carte_objet__put); } else { return false; } }

var id_promesse__a_carte_objet__delete = 0;
var ref_promesse__a_carte_objet__delete = '';
function a_carte_objet__delete(Code_carte, Code_objet, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_carte_objet__delete = ref; id_promesse__a_carte_objet__delete = ajouter_action( "DELETE", "a_carte_objet/" + Code_carte + '-' + Code_objet + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth ); }
function r__a_carte_objet__delete(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_carte_objet__delete == ref ) { return promesse(id_promesse__a_carte_objet__delete); } else { return false; } }

// +-------------------------+
// | a_campagne_tag_campagne |
// +-------------------------+

var id_promesse__a_campagne_tag_campagne__get = 0;
var ref_promesse__a_campagne_tag_campagne__get = '';
function a_campagne_tag_campagne__get(Code_tag_campagne, Code_campagne, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_campagne_tag_campagne__get = ref; id_promesse__a_campagne_tag_campagne__get = ajouter_action( "GET", "a_campagne_tag_campagne/" + Code_tag_campagne + '-' + Code_campagne + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__a_campagne_tag_campagne__get(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_campagne_tag_campagne__get == ref ) { return promesse(id_promesse__a_campagne_tag_campagne__get); } else { return false; } }

var id_promesse__a_campagne_tag_campagne__get_all = 0;
var ref_promesse__a_campagne_tag_campagne__get_all = '';
function a_campagne_tag_campagne__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_campagne_tag_campagne__get_all = ref; id_promesse__a_campagne_tag_campagne__get_all = ajouter_action( "GET", "a_campagne_tag_campagne?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__a_campagne_tag_campagne__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_campagne_tag_campagne__get_all == ref ) { return promesse(id_promesse__a_campagne_tag_campagne__get_all); } else { return false; } }

/*
  json_data = {
    Code_tag_campagne: …,
    Code_campagne: …,
  }
*/
var id_promesse__a_campagne_tag_campagne__post = 0;
var ref_promesse__a_campagne_tag_campagne__post = '';
function a_campagne_tag_campagne__post(json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_campagne_tag_campagne__post = ref; id_promesse__a_campagne_tag_campagne__post = ajouter_action( "POST", "a_campagne_tag_campagne?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__a_campagne_tag_campagne__post(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_campagne_tag_campagne__post == ref ) { return promesse(id_promesse__a_campagne_tag_campagne__post); } else { return false; } }

/*
  json_data = {
  }
*/
var id_promesse__a_campagne_tag_campagne__put = 0;
var ref_promesse__a_campagne_tag_campagne__put = '';
function a_campagne_tag_campagne__put(Code_tag_campagne, Code_campagne, json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_campagne_tag_campagne__put = ref; id_promesse__a_campagne_tag_campagne__put = ajouter_action( "PUT", "a_campagne_tag_campagne/" + Code_tag_campagne + '-' + Code_campagne + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__a_campagne_tag_campagne__put(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_campagne_tag_campagne__put == ref ) { return promesse(id_promesse__a_campagne_tag_campagne__put); } else { return false; } }

var id_promesse__a_campagne_tag_campagne__delete = 0;
var ref_promesse__a_campagne_tag_campagne__delete = '';
function a_campagne_tag_campagne__delete(Code_tag_campagne, Code_campagne, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_campagne_tag_campagne__delete = ref; id_promesse__a_campagne_tag_campagne__delete = ajouter_action( "DELETE", "a_campagne_tag_campagne/" + Code_tag_campagne + '-' + Code_campagne + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth ); }
function r__a_campagne_tag_campagne__delete(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_campagne_tag_campagne__delete == ref ) { return promesse(id_promesse__a_campagne_tag_campagne__delete); } else { return false; } }

// +---------------------------+
// | a_ressource_tag_ressource |
// +---------------------------+

var id_promesse__a_ressource_tag_ressource__get = 0;
var ref_promesse__a_ressource_tag_ressource__get = '';
function a_ressource_tag_ressource__get(Code_tag_ressource, Code_ressource, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_ressource_tag_ressource__get = ref; id_promesse__a_ressource_tag_ressource__get = ajouter_action( "GET", "a_ressource_tag_ressource/" + Code_tag_ressource + '-' + Code_ressource + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__a_ressource_tag_ressource__get(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_ressource_tag_ressource__get == ref ) { return promesse(id_promesse__a_ressource_tag_ressource__get); } else { return false; } }

var id_promesse__a_ressource_tag_ressource__get_all = 0;
var ref_promesse__a_ressource_tag_ressource__get_all = '';
function a_ressource_tag_ressource__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_ressource_tag_ressource__get_all = ref; id_promesse__a_ressource_tag_ressource__get_all = ajouter_action( "GET", "a_ressource_tag_ressource?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__a_ressource_tag_ressource__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_ressource_tag_ressource__get_all == ref ) { return promesse(id_promesse__a_ressource_tag_ressource__get_all); } else { return false; } }

/*
  json_data = {
    Code_tag_ressource: …,
    Code_ressource: …,
  }
*/
var id_promesse__a_ressource_tag_ressource__post = 0;
var ref_promesse__a_ressource_tag_ressource__post = '';
function a_ressource_tag_ressource__post(json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_ressource_tag_ressource__post = ref; id_promesse__a_ressource_tag_ressource__post = ajouter_action( "POST", "a_ressource_tag_ressource?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__a_ressource_tag_ressource__post(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_ressource_tag_ressource__post == ref ) { return promesse(id_promesse__a_ressource_tag_ressource__post); } else { return false; } }

/*
  json_data = {
  }
*/
var id_promesse__a_ressource_tag_ressource__put = 0;
var ref_promesse__a_ressource_tag_ressource__put = '';
function a_ressource_tag_ressource__put(Code_tag_ressource, Code_ressource, json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_ressource_tag_ressource__put = ref; id_promesse__a_ressource_tag_ressource__put = ajouter_action( "PUT", "a_ressource_tag_ressource/" + Code_tag_ressource + '-' + Code_ressource + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__a_ressource_tag_ressource__put(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_ressource_tag_ressource__put == ref ) { return promesse(id_promesse__a_ressource_tag_ressource__put); } else { return false; } }

var id_promesse__a_ressource_tag_ressource__delete = 0;
var ref_promesse__a_ressource_tag_ressource__delete = '';
function a_ressource_tag_ressource__delete(Code_tag_ressource, Code_ressource, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_ressource_tag_ressource__delete = ref; id_promesse__a_ressource_tag_ressource__delete = ajouter_action( "DELETE", "a_ressource_tag_ressource/" + Code_tag_ressource + '-' + Code_ressource + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth ); }
function r__a_ressource_tag_ressource__delete(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_ressource_tag_ressource__delete == ref ) { return promesse(id_promesse__a_ressource_tag_ressource__delete); } else { return false; } }

// +------------------------+
// | a_liste_contact_joueur |
// +------------------------+

var id_promesse__a_liste_contact_joueur__get = 0;
var ref_promesse__a_liste_contact_joueur__get = '';
function a_liste_contact_joueur__get(Code_liste_contacts, Code_joueur, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_liste_contact_joueur__get = ref; id_promesse__a_liste_contact_joueur__get = ajouter_action( "GET", "a_liste_contact_joueur/" + Code_liste_contacts + '-' + Code_joueur + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__a_liste_contact_joueur__get(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_liste_contact_joueur__get == ref ) { return promesse(id_promesse__a_liste_contact_joueur__get); } else { return false; } }

var id_promesse__a_liste_contact_joueur__get_all = 0;
var ref_promesse__a_liste_contact_joueur__get_all = '';
function a_liste_contact_joueur__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_liste_contact_joueur__get_all = ref; id_promesse__a_liste_contact_joueur__get_all = ajouter_action( "GET", "a_liste_contact_joueur?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__a_liste_contact_joueur__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_liste_contact_joueur__get_all == ref ) { return promesse(id_promesse__a_liste_contact_joueur__get_all); } else { return false; } }

/*
  json_data = {
    a_liste_contact_joueur_Date_creation: …,
    Code_liste_contacts: …,
    Code_joueur: …,
  }
*/
var id_promesse__a_liste_contact_joueur__post = 0;
var ref_promesse__a_liste_contact_joueur__post = '';
function a_liste_contact_joueur__post(json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_liste_contact_joueur__post = ref; id_promesse__a_liste_contact_joueur__post = ajouter_action( "POST", "a_liste_contact_joueur?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__a_liste_contact_joueur__post(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_liste_contact_joueur__post == ref ) { return promesse(id_promesse__a_liste_contact_joueur__post); } else { return false; } }

/*
  json_data = {
    a_liste_contact_joueur_Date_creation: …,
  }
*/
var id_promesse__a_liste_contact_joueur__put = 0;
var ref_promesse__a_liste_contact_joueur__put = '';
function a_liste_contact_joueur__put(Code_liste_contacts, Code_joueur, json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_liste_contact_joueur__put = ref; id_promesse__a_liste_contact_joueur__put = ajouter_action( "PUT", "a_liste_contact_joueur/" + Code_liste_contacts + '-' + Code_joueur + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__a_liste_contact_joueur__put(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_liste_contact_joueur__put == ref ) { return promesse(id_promesse__a_liste_contact_joueur__put); } else { return false; } }

var id_promesse__a_liste_contact_joueur__delete = 0;
var ref_promesse__a_liste_contact_joueur__delete = '';
function a_liste_contact_joueur__delete(Code_liste_contacts, Code_joueur, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_liste_contact_joueur__delete = ref; id_promesse__a_liste_contact_joueur__delete = ajouter_action( "DELETE", "a_liste_contact_joueur/" + Code_liste_contacts + '-' + Code_joueur + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth ); }
function r__a_liste_contact_joueur__delete(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_liste_contact_joueur__delete == ref ) { return promesse(id_promesse__a_liste_contact_joueur__delete); } else { return false; } }

