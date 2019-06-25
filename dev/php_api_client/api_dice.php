<?php

class Api_dice {

    private $url_api;
    private $mf_token='';
    private $mf_id='';
    private $mf_num_error=0;
    private $mf_errot_lib='';
    private $mf_connector_token='';
    private $mf_instance=0;

    public function __construct($url_api, $mf_connector_token='', $mf_instance=0)
    {
        $this->url_api = $url_api;
        $this->mf_connector_token = $mf_connector_token;
        $this->mf_instance = $mf_instance;
    }

    public function get($appel_api) {
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $this->url_api.$appel_api );
        curl_setopt( $ch, CURLOPT_COOKIESESSION, true );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        $r = json_decode(curl_exec($ch), true);
        $this->mf_num_error = $r['error']['number'];
        curl_close( $ch );
        return $r['data'];
    }

    public function post($appel_api, $data) {
        $ch = curl_init($this->url_api.$appel_api);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $r = json_decode(curl_exec($ch), true);
        $this->mf_num_error = $r['error']['number'];
        curl_close($ch);
        return $r['data'];
    }

    public function put($appel_api, $data) {
        $ch = curl_init($this->url_api.$appel_api);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $r = json_decode(curl_exec($ch), true);
        $this->mf_num_error = $r['error']['number'];
        curl_close($ch);
        return $r['data'];
    }

    public function delete($appel_api) {
        $ch = curl_init($this->url_api.$appel_api);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $r = json_decode(curl_exec($ch), true );
        curl_close($ch);
        $this->mf_num_error = $r['error']['number'];
        return $r['data'];
    }

    public function connexion($mf_login, $mf_pwd) {
        $r = $this->post('mf_connexion', ['mf_login'=>$mf_login, 'mf_pwd'=>$mf_pwd]);
        if ( $r['error']['number']==0 ) {
            $this->mf_token = $r['data']['mf_token'];
            $this->mf_id = $r['data']['id'];
            return $this->mf_id;
        }
        else
        {
            $this->mf_num_error = $r['error']['number'];
        }
        return false;
    }

    public function get_id_connexion() {
        return $this->mf_id;
    }

    public function get_num_error() {
        return $this->mf_num_error;
    }

    // +--------+
    // | joueur |
    // +--------+

    public function joueur__get($Code_joueur) {
        return $this->get('joueur/'.$Code_joueur.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function joueur__get_all() {
        $requete = '';
        return $this->get($requete . 'joueur?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function joueur__add($joueur_Email, $joueur_Identifiant, $joueur_Password, $joueur_Avatar_Fichier, $joueur_Date_naissance, $joueur_Date_inscription) {
        $data = [
            'joueur_Email' => $joueur_Email,
            'joueur_Identifiant' => $joueur_Identifiant,
            'joueur_Password' => $joueur_Password,
            'joueur_Avatar_Fichier' => $joueur_Avatar_Fichier,
            'joueur_Date_naissance' => $joueur_Date_naissance,
            'joueur_Date_inscription' => $joueur_Date_inscription,
        ];
        return $this->post('joueur?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function joueur__edit($Code_joueur, $joueur_Email, $joueur_Identifiant, $joueur_Password, $joueur_Avatar_Fichier, $joueur_Date_naissance, $joueur_Date_inscription) {
        $data = [
            'joueur_Email' => $joueur_Email,
            'joueur_Identifiant' => $joueur_Identifiant,
            'joueur_Password' => $joueur_Password,
            'joueur_Avatar_Fichier' => $joueur_Avatar_Fichier,
            'joueur_Date_naissance' => $joueur_Date_naissance,
            'joueur_Date_inscription' => $joueur_Date_inscription,
        ];
        return $this->put('joueur/'.$Code_joueur.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function joueur__edit__joueur_Email($Code_joueur, $joueur_Email) {
        $data = ['joueur_Email' => $joueur_Email ];
        return $this->put('joueur/'.$Code_joueur.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function joueur__edit__joueur_Identifiant($Code_joueur, $joueur_Identifiant) {
        $data = ['joueur_Identifiant' => $joueur_Identifiant ];
        return $this->put('joueur/'.$Code_joueur.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function joueur__edit__joueur_Password($Code_joueur, $joueur_Password) {
        $data = ['joueur_Password' => $joueur_Password ];
        return $this->put('joueur/'.$Code_joueur.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function joueur__edit__joueur_Avatar_Fichier($Code_joueur, $joueur_Avatar_Fichier) {
        $data = ['joueur_Avatar_Fichier' => $joueur_Avatar_Fichier ];
        return $this->put('joueur/'.$Code_joueur.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function joueur__edit__joueur_Date_naissance($Code_joueur, $joueur_Date_naissance) {
        $data = ['joueur_Date_naissance' => $joueur_Date_naissance ];
        return $this->put('joueur/'.$Code_joueur.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function joueur__edit__joueur_Date_inscription($Code_joueur, $joueur_Date_inscription) {
        $data = ['joueur_Date_inscription' => $joueur_Date_inscription ];
        return $this->put('joueur/'.$Code_joueur.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function joueur__delete($Code_joueur) {
        return $this->delete('joueur/'.$Code_joueur.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    // +---------+
    // | message |
    // +---------+

    public function message__get($Code_message) {
        return $this->get('message/'.$Code_message.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function message__get_all(?int $Code_messagerie=null, ?int $Code_joueur=null) {
        $requete = '';
        $Code_messagerie = (int) $Code_messagerie;
        if ($Code_messagerie != 0) { $requete.= 'messagerie/' . $Code_messagerie . '/'; }
        $Code_joueur = (int) $Code_joueur;
        if ($Code_joueur != 0) { $requete.= 'joueur/' . $Code_joueur . '/'; }
        return $this->get($requete . 'message?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function message__add($Code_messagerie, $Code_joueur, $message_Texte, $message_Date) {
        $data = [
            'message_Texte' => $message_Texte,
            'message_Date' => $message_Date,
            'Code_messagerie' => $Code_messagerie,
            'Code_joueur' => $Code_joueur,
        ];
        return $this->post('message?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function message__edit($Code_message, $Code_messagerie, $Code_joueur, $message_Texte, $message_Date) {
        $data = [
            'message_Texte' => $message_Texte,
            'message_Date' => $message_Date,
            'Code_messagerie' => $Code_messagerie,
            'Code_joueur' => $Code_joueur,
        ];
        return $this->put('message/'.$Code_message.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function message__edit__message_Texte($Code_message, $message_Texte) {
        $data = ['message_Texte' => $message_Texte ];
        return $this->put('message/'.$Code_message.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function message__edit__message_Date($Code_message, $message_Date) {
        $data = ['message_Date' => $message_Date ];
        return $this->put('message/'.$Code_message.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function message__edit__messagerie($Code_message, $messagerie) {
        $data = ['messagerie' => $messagerie ];
        return $this->put('message/'.$Code_message.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function message__edit__joueur($Code_message, $joueur) {
        $data = ['joueur' => $joueur ];
        return $this->put('message/'.$Code_message.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function message__delete($Code_message) {
        return $this->delete('message/'.$Code_message.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    // +-----------+
    // | parametre |
    // +-----------+

    public function parametre__get($Code_parametre) {
        return $this->get('parametre/'.$Code_parametre.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function parametre__get_all() {
        $requete = '';
        return $this->get($requete . 'parametre?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function parametre__add($parametre_Libelle, $parametre_Valeur, $parametre_Activable, $parametre_Actif) {
        $data = [
            'parametre_Libelle' => $parametre_Libelle,
            'parametre_Valeur' => $parametre_Valeur,
            'parametre_Activable' => $parametre_Activable,
            'parametre_Actif' => $parametre_Actif,
        ];
        return $this->post('parametre?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function parametre__edit($Code_parametre, $parametre_Libelle, $parametre_Valeur, $parametre_Activable, $parametre_Actif) {
        $data = [
            'parametre_Libelle' => $parametre_Libelle,
            'parametre_Valeur' => $parametre_Valeur,
            'parametre_Activable' => $parametre_Activable,
            'parametre_Actif' => $parametre_Actif,
        ];
        return $this->put('parametre/'.$Code_parametre.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function parametre__edit__parametre_Libelle($Code_parametre, $parametre_Libelle) {
        $data = ['parametre_Libelle' => $parametre_Libelle ];
        return $this->put('parametre/'.$Code_parametre.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function parametre__edit__parametre_Valeur($Code_parametre, $parametre_Valeur) {
        $data = ['parametre_Valeur' => $parametre_Valeur ];
        return $this->put('parametre/'.$Code_parametre.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function parametre__edit__parametre_Activable($Code_parametre, $parametre_Activable) {
        $data = ['parametre_Activable' => $parametre_Activable ];
        return $this->put('parametre/'.$Code_parametre.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function parametre__edit__parametre_Actif($Code_parametre, $parametre_Actif) {
        $data = ['parametre_Actif' => $parametre_Actif ];
        return $this->put('parametre/'.$Code_parametre.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function parametre__delete($Code_parametre) {
        return $this->delete('parametre/'.$Code_parametre.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    // +--------+
    // | groupe |
    // +--------+

    public function groupe__get($Code_groupe) {
        return $this->get('groupe/'.$Code_groupe.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function groupe__get_all(?int $Code_campagne=null) {
        $requete = '';
        $Code_campagne = (int) $Code_campagne;
        if ($Code_campagne != 0) { $requete.= 'campagne/' . $Code_campagne . '/'; }
        return $this->get($requete . 'groupe?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function groupe__add($Code_campagne, $groupe_Nom, $groupe_Description, $groupe_Logo_Fichier, $groupe_Effectif, $groupe_Actif, $groupe_Date_creation, $groupe_Delai_suppression_jour, $groupe_Suppression_active) {
        $data = [
            'groupe_Nom' => $groupe_Nom,
            'groupe_Description' => $groupe_Description,
            'groupe_Logo_Fichier' => $groupe_Logo_Fichier,
            'groupe_Effectif' => $groupe_Effectif,
            'groupe_Actif' => $groupe_Actif,
            'groupe_Date_creation' => $groupe_Date_creation,
            'groupe_Delai_suppression_jour' => $groupe_Delai_suppression_jour,
            'groupe_Suppression_active' => $groupe_Suppression_active,
            'Code_campagne' => $Code_campagne,
        ];
        return $this->post('groupe?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function groupe__edit($Code_groupe, $Code_campagne, $groupe_Nom, $groupe_Description, $groupe_Logo_Fichier, $groupe_Effectif, $groupe_Actif, $groupe_Date_creation, $groupe_Delai_suppression_jour, $groupe_Suppression_active) {
        $data = [
            'groupe_Nom' => $groupe_Nom,
            'groupe_Description' => $groupe_Description,
            'groupe_Logo_Fichier' => $groupe_Logo_Fichier,
            'groupe_Effectif' => $groupe_Effectif,
            'groupe_Actif' => $groupe_Actif,
            'groupe_Date_creation' => $groupe_Date_creation,
            'groupe_Delai_suppression_jour' => $groupe_Delai_suppression_jour,
            'groupe_Suppression_active' => $groupe_Suppression_active,
            'Code_campagne' => $Code_campagne,
        ];
        return $this->put('groupe/'.$Code_groupe.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function groupe__edit__groupe_Nom($Code_groupe, $groupe_Nom) {
        $data = ['groupe_Nom' => $groupe_Nom ];
        return $this->put('groupe/'.$Code_groupe.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function groupe__edit__groupe_Description($Code_groupe, $groupe_Description) {
        $data = ['groupe_Description' => $groupe_Description ];
        return $this->put('groupe/'.$Code_groupe.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function groupe__edit__groupe_Logo_Fichier($Code_groupe, $groupe_Logo_Fichier) {
        $data = ['groupe_Logo_Fichier' => $groupe_Logo_Fichier ];
        return $this->put('groupe/'.$Code_groupe.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function groupe__edit__groupe_Effectif($Code_groupe, $groupe_Effectif) {
        $data = ['groupe_Effectif' => $groupe_Effectif ];
        return $this->put('groupe/'.$Code_groupe.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function groupe__edit__groupe_Actif($Code_groupe, $groupe_Actif) {
        $data = ['groupe_Actif' => $groupe_Actif ];
        return $this->put('groupe/'.$Code_groupe.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function groupe__edit__groupe_Date_creation($Code_groupe, $groupe_Date_creation) {
        $data = ['groupe_Date_creation' => $groupe_Date_creation ];
        return $this->put('groupe/'.$Code_groupe.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function groupe__edit__groupe_Delai_suppression_jour($Code_groupe, $groupe_Delai_suppression_jour) {
        $data = ['groupe_Delai_suppression_jour' => $groupe_Delai_suppression_jour ];
        return $this->put('groupe/'.$Code_groupe.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function groupe__edit__groupe_Suppression_active($Code_groupe, $groupe_Suppression_active) {
        $data = ['groupe_Suppression_active' => $groupe_Suppression_active ];
        return $this->put('groupe/'.$Code_groupe.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function groupe__edit__campagne($Code_groupe, $campagne) {
        $data = ['campagne' => $campagne ];
        return $this->put('groupe/'.$Code_groupe.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function groupe__delete($Code_groupe) {
        return $this->delete('groupe/'.$Code_groupe.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    // +------------+
    // | personnage |
    // +------------+

    public function personnage__get($Code_personnage) {
        return $this->get('personnage/'.$Code_personnage.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function personnage__get_all(?int $Code_joueur=null, ?int $Code_groupe=null) {
        $requete = '';
        $Code_joueur = (int) $Code_joueur;
        if ($Code_joueur != 0) { $requete.= 'joueur/' . $Code_joueur . '/'; }
        $Code_groupe = (int) $Code_groupe;
        if ($Code_groupe != 0) { $requete.= 'groupe/' . $Code_groupe . '/'; }
        return $this->get($requete . 'personnage?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function personnage__add($Code_joueur, $Code_groupe, $personnage_Fichier_Fichier, $personnage_Conservation) {
        $data = [
            'personnage_Fichier_Fichier' => $personnage_Fichier_Fichier,
            'personnage_Conservation' => $personnage_Conservation,
            'Code_joueur' => $Code_joueur,
            'Code_groupe' => $Code_groupe,
        ];
        return $this->post('personnage?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function personnage__edit($Code_personnage, $Code_joueur, $Code_groupe, $personnage_Fichier_Fichier, $personnage_Conservation) {
        $data = [
            'personnage_Fichier_Fichier' => $personnage_Fichier_Fichier,
            'personnage_Conservation' => $personnage_Conservation,
            'Code_joueur' => $Code_joueur,
            'Code_groupe' => $Code_groupe,
        ];
        return $this->put('personnage/'.$Code_personnage.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function personnage__edit__personnage_Fichier_Fichier($Code_personnage, $personnage_Fichier_Fichier) {
        $data = ['personnage_Fichier_Fichier' => $personnage_Fichier_Fichier ];
        return $this->put('personnage/'.$Code_personnage.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function personnage__edit__personnage_Conservation($Code_personnage, $personnage_Conservation) {
        $data = ['personnage_Conservation' => $personnage_Conservation ];
        return $this->put('personnage/'.$Code_personnage.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function personnage__edit__joueur($Code_personnage, $joueur) {
        $data = ['joueur' => $joueur ];
        return $this->put('personnage/'.$Code_personnage.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function personnage__edit__groupe($Code_personnage, $groupe) {
        $data = ['groupe' => $groupe ];
        return $this->put('personnage/'.$Code_personnage.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function personnage__delete($Code_personnage) {
        return $this->delete('personnage/'.$Code_personnage.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    // +----------+
    // | campagne |
    // +----------+

    public function campagne__get($Code_campagne) {
        return $this->get('campagne/'.$Code_campagne.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function campagne__get_all() {
        $requete = '';
        return $this->get($requete . 'campagne?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function campagne__add($campagne_Nom, $campagne_Description, $campagne_Image_Fichier, $campagne_Nombre_joueur, $campagne_Nombre_mj) {
        $data = [
            'campagne_Nom' => $campagne_Nom,
            'campagne_Description' => $campagne_Description,
            'campagne_Image_Fichier' => $campagne_Image_Fichier,
            'campagne_Nombre_joueur' => $campagne_Nombre_joueur,
            'campagne_Nombre_mj' => $campagne_Nombre_mj,
        ];
        return $this->post('campagne?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function campagne__edit($Code_campagne, $campagne_Nom, $campagne_Description, $campagne_Image_Fichier, $campagne_Nombre_joueur, $campagne_Nombre_mj) {
        $data = [
            'campagne_Nom' => $campagne_Nom,
            'campagne_Description' => $campagne_Description,
            'campagne_Image_Fichier' => $campagne_Image_Fichier,
            'campagne_Nombre_joueur' => $campagne_Nombre_joueur,
            'campagne_Nombre_mj' => $campagne_Nombre_mj,
        ];
        return $this->put('campagne/'.$Code_campagne.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function campagne__edit__campagne_Nom($Code_campagne, $campagne_Nom) {
        $data = ['campagne_Nom' => $campagne_Nom ];
        return $this->put('campagne/'.$Code_campagne.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function campagne__edit__campagne_Description($Code_campagne, $campagne_Description) {
        $data = ['campagne_Description' => $campagne_Description ];
        return $this->put('campagne/'.$Code_campagne.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function campagne__edit__campagne_Image_Fichier($Code_campagne, $campagne_Image_Fichier) {
        $data = ['campagne_Image_Fichier' => $campagne_Image_Fichier ];
        return $this->put('campagne/'.$Code_campagne.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function campagne__edit__campagne_Nombre_joueur($Code_campagne, $campagne_Nombre_joueur) {
        $data = ['campagne_Nombre_joueur' => $campagne_Nombre_joueur ];
        return $this->put('campagne/'.$Code_campagne.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function campagne__edit__campagne_Nombre_mj($Code_campagne, $campagne_Nombre_mj) {
        $data = ['campagne_Nombre_mj' => $campagne_Nombre_mj ];
        return $this->put('campagne/'.$Code_campagne.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function campagne__delete($Code_campagne) {
        return $this->delete('campagne/'.$Code_campagne.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    // +--------------+
    // | tag_campagne |
    // +--------------+

    public function tag_campagne__get($Code_tag_campagne) {
        return $this->get('tag_campagne/'.$Code_tag_campagne.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function tag_campagne__get_all() {
        $requete = '';
        return $this->get($requete . 'tag_campagne?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function tag_campagne__add($tag_campagne_Libelle) {
        $data = [
            'tag_campagne_Libelle' => $tag_campagne_Libelle,
        ];
        return $this->post('tag_campagne?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function tag_campagne__edit($Code_tag_campagne, $tag_campagne_Libelle) {
        $data = [
            'tag_campagne_Libelle' => $tag_campagne_Libelle,
        ];
        return $this->put('tag_campagne/'.$Code_tag_campagne.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function tag_campagne__edit__tag_campagne_Libelle($Code_tag_campagne, $tag_campagne_Libelle) {
        $data = ['tag_campagne_Libelle' => $tag_campagne_Libelle ];
        return $this->put('tag_campagne/'.$Code_tag_campagne.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function tag_campagne__delete($Code_tag_campagne) {
        return $this->delete('tag_campagne/'.$Code_tag_campagne.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    // +-------+
    // | carte |
    // +-------+

    public function carte__get($Code_carte) {
        return $this->get('carte/'.$Code_carte.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function carte__get_all(?int $Code_groupe=null) {
        $requete = '';
        $Code_groupe = (int) $Code_groupe;
        if ($Code_groupe != 0) { $requete.= 'groupe/' . $Code_groupe . '/'; }
        return $this->get($requete . 'carte?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function carte__add($Code_groupe, $carte_Nom, $carte_Hauteur, $carte_Largeur, $carte_Fichier) {
        $data = [
            'carte_Nom' => $carte_Nom,
            'carte_Hauteur' => $carte_Hauteur,
            'carte_Largeur' => $carte_Largeur,
            'carte_Fichier' => $carte_Fichier,
            'Code_groupe' => $Code_groupe,
        ];
        return $this->post('carte?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function carte__edit($Code_carte, $Code_groupe, $carte_Nom, $carte_Hauteur, $carte_Largeur, $carte_Fichier) {
        $data = [
            'carte_Nom' => $carte_Nom,
            'carte_Hauteur' => $carte_Hauteur,
            'carte_Largeur' => $carte_Largeur,
            'carte_Fichier' => $carte_Fichier,
            'Code_groupe' => $Code_groupe,
        ];
        return $this->put('carte/'.$Code_carte.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function carte__edit__carte_Nom($Code_carte, $carte_Nom) {
        $data = ['carte_Nom' => $carte_Nom ];
        return $this->put('carte/'.$Code_carte.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function carte__edit__carte_Hauteur($Code_carte, $carte_Hauteur) {
        $data = ['carte_Hauteur' => $carte_Hauteur ];
        return $this->put('carte/'.$Code_carte.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function carte__edit__carte_Largeur($Code_carte, $carte_Largeur) {
        $data = ['carte_Largeur' => $carte_Largeur ];
        return $this->put('carte/'.$Code_carte.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function carte__edit__carte_Fichier($Code_carte, $carte_Fichier) {
        $data = ['carte_Fichier' => $carte_Fichier ];
        return $this->put('carte/'.$Code_carte.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function carte__edit__groupe($Code_carte, $groupe) {
        $data = ['groupe' => $groupe ];
        return $this->put('carte/'.$Code_carte.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function carte__delete($Code_carte) {
        return $this->delete('carte/'.$Code_carte.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    // +-------+
    // | objet |
    // +-------+

    public function objet__get($Code_objet) {
        return $this->get('objet/'.$Code_objet.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function objet__get_all(?int $Code_type=null) {
        $requete = '';
        $Code_type = (int) $Code_type;
        if ($Code_type != 0) { $requete.= 'type/' . $Code_type . '/'; }
        return $this->get($requete . 'objet?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function objet__add($Code_type, $objet_Libelle, $objet_Image_Fichier) {
        $data = [
            'objet_Libelle' => $objet_Libelle,
            'objet_Image_Fichier' => $objet_Image_Fichier,
            'Code_type' => $Code_type,
        ];
        return $this->post('objet?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function objet__edit($Code_objet, $Code_type, $objet_Libelle, $objet_Image_Fichier) {
        $data = [
            'objet_Libelle' => $objet_Libelle,
            'objet_Image_Fichier' => $objet_Image_Fichier,
            'Code_type' => $Code_type,
        ];
        return $this->put('objet/'.$Code_objet.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function objet__edit__objet_Libelle($Code_objet, $objet_Libelle) {
        $data = ['objet_Libelle' => $objet_Libelle ];
        return $this->put('objet/'.$Code_objet.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function objet__edit__objet_Image_Fichier($Code_objet, $objet_Image_Fichier) {
        $data = ['objet_Image_Fichier' => $objet_Image_Fichier ];
        return $this->put('objet/'.$Code_objet.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function objet__edit__type($Code_objet, $type) {
        $data = ['type' => $type ];
        return $this->put('objet/'.$Code_objet.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function objet__delete($Code_objet) {
        return $this->delete('objet/'.$Code_objet.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    // +------+
    // | type |
    // +------+

    public function type__get($Code_type) {
        return $this->get('type/'.$Code_type.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function type__get_all(?int $Code_ressource=null) {
        $requete = '';
        $Code_ressource = (int) $Code_ressource;
        if ($Code_ressource != 0) { $requete.= 'ressource/' . $Code_ressource . '/'; }
        return $this->get($requete . 'type?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function type__add($Code_ressource, $type_Libelle) {
        $data = [
            'type_Libelle' => $type_Libelle,
            'Code_ressource' => $Code_ressource,
        ];
        return $this->post('type?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function type__edit($Code_type, $Code_ressource, $type_Libelle) {
        $data = [
            'type_Libelle' => $type_Libelle,
            'Code_ressource' => $Code_ressource,
        ];
        return $this->put('type/'.$Code_type.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function type__edit__type_Libelle($Code_type, $type_Libelle) {
        $data = ['type_Libelle' => $type_Libelle ];
        return $this->put('type/'.$Code_type.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function type__edit__ressource($Code_type, $ressource) {
        $data = ['ressource' => $ressource ];
        return $this->put('type/'.$Code_type.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function type__delete($Code_type) {
        return $this->delete('type/'.$Code_type.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    // +-----------+
    // | ressource |
    // +-----------+

    public function ressource__get($Code_ressource) {
        return $this->get('ressource/'.$Code_ressource.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function ressource__get_all() {
        $requete = '';
        return $this->get($requete . 'ressource?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function ressource__add($ressource_Nom) {
        $data = [
            'ressource_Nom' => $ressource_Nom,
        ];
        return $this->post('ressource?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function ressource__edit($Code_ressource, $ressource_Nom) {
        $data = [
            'ressource_Nom' => $ressource_Nom,
        ];
        return $this->put('ressource/'.$Code_ressource.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function ressource__edit__ressource_Nom($Code_ressource, $ressource_Nom) {
        $data = ['ressource_Nom' => $ressource_Nom ];
        return $this->put('ressource/'.$Code_ressource.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function ressource__delete($Code_ressource) {
        return $this->delete('ressource/'.$Code_ressource.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    // +---------------+
    // | tag_ressource |
    // +---------------+

    public function tag_ressource__get($Code_tag_ressource) {
        return $this->get('tag_ressource/'.$Code_tag_ressource.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function tag_ressource__get_all() {
        $requete = '';
        return $this->get($requete . 'tag_ressource?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function tag_ressource__add($tag_ressource_Libelle) {
        $data = [
            'tag_ressource_Libelle' => $tag_ressource_Libelle,
        ];
        return $this->post('tag_ressource?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function tag_ressource__edit($Code_tag_ressource, $tag_ressource_Libelle) {
        $data = [
            'tag_ressource_Libelle' => $tag_ressource_Libelle,
        ];
        return $this->put('tag_ressource/'.$Code_tag_ressource.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function tag_ressource__edit__tag_ressource_Libelle($Code_tag_ressource, $tag_ressource_Libelle) {
        $data = ['tag_ressource_Libelle' => $tag_ressource_Libelle ];
        return $this->put('tag_ressource/'.$Code_tag_ressource.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function tag_ressource__delete($Code_tag_ressource) {
        return $this->delete('tag_ressource/'.$Code_tag_ressource.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    // +------------+
    // | messagerie |
    // +------------+

    public function messagerie__get($Code_messagerie) {
        return $this->get('messagerie/'.$Code_messagerie.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function messagerie__get_all(?int $Code_joueur=null) {
        $requete = '';
        $Code_joueur = (int) $Code_joueur;
        if ($Code_joueur != 0) { $requete.= 'joueur/' . $Code_joueur . '/'; }
        return $this->get($requete . 'messagerie?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function messagerie__add($Code_joueur, $messagerie_Nom) {
        $data = [
            'messagerie_Nom' => $messagerie_Nom,
            'Code_joueur' => $Code_joueur,
        ];
        return $this->post('messagerie?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function messagerie__edit($Code_messagerie, $Code_joueur, $messagerie_Nom) {
        $data = [
            'messagerie_Nom' => $messagerie_Nom,
            'Code_joueur' => $Code_joueur,
        ];
        return $this->put('messagerie/'.$Code_messagerie.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function messagerie__edit__messagerie_Nom($Code_messagerie, $messagerie_Nom) {
        $data = ['messagerie_Nom' => $messagerie_Nom ];
        return $this->put('messagerie/'.$Code_messagerie.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function messagerie__edit__joueur($Code_messagerie, $joueur) {
        $data = ['joueur' => $joueur ];
        return $this->put('messagerie/'.$Code_messagerie.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function messagerie__delete($Code_messagerie) {
        return $this->delete('messagerie/'.$Code_messagerie.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    // +----------------+
    // | liste_contacts |
    // +----------------+

    public function liste_contacts__get($Code_liste_contacts) {
        return $this->get('liste_contacts/'.$Code_liste_contacts.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function liste_contacts__get_all(?int $Code_joueur=null) {
        $requete = '';
        $Code_joueur = (int) $Code_joueur;
        if ($Code_joueur != 0) { $requete.= 'joueur/' . $Code_joueur . '/'; }
        return $this->get($requete . 'liste_contacts?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function liste_contacts__add($Code_joueur, $liste_contacts_Nom) {
        $data = [
            'liste_contacts_Nom' => $liste_contacts_Nom,
            'Code_joueur' => $Code_joueur,
        ];
        return $this->post('liste_contacts?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function liste_contacts__edit($Code_liste_contacts, $Code_joueur, $liste_contacts_Nom) {
        $data = [
            'liste_contacts_Nom' => $liste_contacts_Nom,
            'Code_joueur' => $Code_joueur,
        ];
        return $this->put('liste_contacts/'.$Code_liste_contacts.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function liste_contacts__edit__liste_contacts_Nom($Code_liste_contacts, $liste_contacts_Nom) {
        $data = ['liste_contacts_Nom' => $liste_contacts_Nom ];
        return $this->put('liste_contacts/'.$Code_liste_contacts.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function liste_contacts__edit__joueur($Code_liste_contacts, $joueur) {
        $data = ['joueur' => $joueur ];
        return $this->put('liste_contacts/'.$Code_liste_contacts.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function liste_contacts__delete($Code_liste_contacts) {
        return $this->delete('liste_contacts/'.$Code_liste_contacts.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    // +--------------------+
    // | a_joueur_parametre |
    // +--------------------+

    public function a_joueur_parametre__get($Code_joueur, $Code_parametre) {
        return $this->get('a_joueur_parametre/'.$Code_joueur.'-'.$Code_parametre.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function a_joueur_parametre__get_all(?int $Code_joueur=null, ?int $Code_parametre=null) {
        $requete = '';
        $Code_joueur = (int) $Code_joueur;
        if ($Code_joueur != 0) { $requete.= 'joueur/' . $Code_joueur . '/'; }
        $Code_parametre = (int) $Code_parametre;
        if ($Code_parametre != 0) { $requete.= 'parametre/' . $Code_parametre . '/'; }
        return $this->get($requete . 'a_joueur_parametre?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function a_joueur_parametre__add($Code_joueur, $Code_parametre) {
        $data = [
            'Code_joueur' => $Code_joueur,
            'Code_parametre' => $Code_parametre,
        ];
        return $this->post('a_joueur_parametre?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function a_joueur_parametre__edit($Code_joueur, $Code_parametre) {
        $data = [
        ];
        return $this->put('a_joueur_parametre/'.$Code_joueur.'-'.$Code_parametre.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function a_joueur_parametre__delete($Code_joueur, $Code_parametre) {
        return $this->delete('a_joueur_parametre/'.$Code_joueur.'-'.$Code_parametre.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    // +-----------------------------+
    // | a_candidature_joueur_groupe |
    // +-----------------------------+

    public function a_candidature_joueur_groupe__get($Code_joueur, $Code_groupe) {
        return $this->get('a_candidature_joueur_groupe/'.$Code_joueur.'-'.$Code_groupe.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function a_candidature_joueur_groupe__get_all(?int $Code_joueur=null, ?int $Code_groupe=null) {
        $requete = '';
        $Code_joueur = (int) $Code_joueur;
        if ($Code_joueur != 0) { $requete.= 'joueur/' . $Code_joueur . '/'; }
        $Code_groupe = (int) $Code_groupe;
        if ($Code_groupe != 0) { $requete.= 'groupe/' . $Code_groupe . '/'; }
        return $this->get($requete . 'a_candidature_joueur_groupe?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function a_candidature_joueur_groupe__add($Code_joueur, $Code_groupe, $a_candidature_joueur_groupe_Message, $a_candidature_joueur_groupe_Date_envoi) {
        $data = [
            'a_candidature_joueur_groupe_Message' => $a_candidature_joueur_groupe_Message,
            'a_candidature_joueur_groupe_Date_envoi' => $a_candidature_joueur_groupe_Date_envoi,
            'Code_joueur' => $Code_joueur,
            'Code_groupe' => $Code_groupe,
        ];
        return $this->post('a_candidature_joueur_groupe?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function a_candidature_joueur_groupe__edit($Code_joueur, $Code_groupe, $a_candidature_joueur_groupe_Message, $a_candidature_joueur_groupe_Date_envoi) {
        $data = [
            'a_candidature_joueur_groupe_Message' => $a_candidature_joueur_groupe_Message,
            'a_candidature_joueur_groupe_Date_envoi' => $a_candidature_joueur_groupe_Date_envoi,
        ];
        return $this->put('a_candidature_joueur_groupe/'.$Code_joueur.'-'.$Code_groupe.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function a_candidature_joueur_groupe__edit__a_candidature_joueur_groupe_Message($Code_joueur, $Code_groupe, $a_candidature_joueur_groupe_Message) {
        $data = ['a_candidature_joueur_groupe_Message' => $a_candidature_joueur_groupe_Message ];
        return $this->put('a_candidature_joueur_groupe/'.$Code_joueur.'-'.$Code_groupe.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function a_candidature_joueur_groupe__edit__a_candidature_joueur_groupe_Date_envoi($Code_joueur, $Code_groupe, $a_candidature_joueur_groupe_Date_envoi) {
        $data = ['a_candidature_joueur_groupe_Date_envoi' => $a_candidature_joueur_groupe_Date_envoi ];
        return $this->put('a_candidature_joueur_groupe/'.$Code_joueur.'-'.$Code_groupe.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function a_candidature_joueur_groupe__delete($Code_joueur, $Code_groupe) {
        return $this->delete('a_candidature_joueur_groupe/'.$Code_joueur.'-'.$Code_groupe.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    // +------------------------+
    // | a_membre_joueur_groupe |
    // +------------------------+

    public function a_membre_joueur_groupe__get($Code_groupe, $Code_joueur) {
        return $this->get('a_membre_joueur_groupe/'.$Code_groupe.'-'.$Code_joueur.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function a_membre_joueur_groupe__get_all(?int $Code_groupe=null, ?int $Code_joueur=null) {
        $requete = '';
        $Code_groupe = (int) $Code_groupe;
        if ($Code_groupe != 0) { $requete.= 'groupe/' . $Code_groupe . '/'; }
        $Code_joueur = (int) $Code_joueur;
        if ($Code_joueur != 0) { $requete.= 'joueur/' . $Code_joueur . '/'; }
        return $this->get($requete . 'a_membre_joueur_groupe?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function a_membre_joueur_groupe__add($Code_groupe, $Code_joueur, $a_membre_joueur_groupe_Surnom, $a_membre_joueur_groupe_Grade, $a_membre_joueur_groupe_Date_adhesion) {
        $data = [
            'a_membre_joueur_groupe_Surnom' => $a_membre_joueur_groupe_Surnom,
            'a_membre_joueur_groupe_Grade' => $a_membre_joueur_groupe_Grade,
            'a_membre_joueur_groupe_Date_adhesion' => $a_membre_joueur_groupe_Date_adhesion,
            'Code_groupe' => $Code_groupe,
            'Code_joueur' => $Code_joueur,
        ];
        return $this->post('a_membre_joueur_groupe?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function a_membre_joueur_groupe__edit($Code_groupe, $Code_joueur, $a_membre_joueur_groupe_Surnom, $a_membre_joueur_groupe_Grade, $a_membre_joueur_groupe_Date_adhesion) {
        $data = [
            'a_membre_joueur_groupe_Surnom' => $a_membre_joueur_groupe_Surnom,
            'a_membre_joueur_groupe_Grade' => $a_membre_joueur_groupe_Grade,
            'a_membre_joueur_groupe_Date_adhesion' => $a_membre_joueur_groupe_Date_adhesion,
        ];
        return $this->put('a_membre_joueur_groupe/'.$Code_groupe.'-'.$Code_joueur.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function a_membre_joueur_groupe__edit__a_membre_joueur_groupe_Surnom($Code_groupe, $Code_joueur, $a_membre_joueur_groupe_Surnom) {
        $data = ['a_membre_joueur_groupe_Surnom' => $a_membre_joueur_groupe_Surnom ];
        return $this->put('a_membre_joueur_groupe/'.$Code_groupe.'-'.$Code_joueur.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function a_membre_joueur_groupe__edit__a_membre_joueur_groupe_Grade($Code_groupe, $Code_joueur, $a_membre_joueur_groupe_Grade) {
        $data = ['a_membre_joueur_groupe_Grade' => $a_membre_joueur_groupe_Grade ];
        return $this->put('a_membre_joueur_groupe/'.$Code_groupe.'-'.$Code_joueur.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function a_membre_joueur_groupe__edit__a_membre_joueur_groupe_Date_adhesion($Code_groupe, $Code_joueur, $a_membre_joueur_groupe_Date_adhesion) {
        $data = ['a_membre_joueur_groupe_Date_adhesion' => $a_membre_joueur_groupe_Date_adhesion ];
        return $this->put('a_membre_joueur_groupe/'.$Code_groupe.'-'.$Code_joueur.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function a_membre_joueur_groupe__delete($Code_groupe, $Code_joueur) {
        return $this->delete('a_membre_joueur_groupe/'.$Code_groupe.'-'.$Code_joueur.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    // +----------------------------+
    // | a_invitation_joueur_groupe |
    // +----------------------------+

    public function a_invitation_joueur_groupe__get($Code_joueur, $Code_groupe) {
        return $this->get('a_invitation_joueur_groupe/'.$Code_joueur.'-'.$Code_groupe.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function a_invitation_joueur_groupe__get_all(?int $Code_joueur=null, ?int $Code_groupe=null) {
        $requete = '';
        $Code_joueur = (int) $Code_joueur;
        if ($Code_joueur != 0) { $requete.= 'joueur/' . $Code_joueur . '/'; }
        $Code_groupe = (int) $Code_groupe;
        if ($Code_groupe != 0) { $requete.= 'groupe/' . $Code_groupe . '/'; }
        return $this->get($requete . 'a_invitation_joueur_groupe?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function a_invitation_joueur_groupe__add($Code_joueur, $Code_groupe, $a_invitation_joueur_groupe_Message, $a_invitation_joueur_groupe_Date_envoi) {
        $data = [
            'a_invitation_joueur_groupe_Message' => $a_invitation_joueur_groupe_Message,
            'a_invitation_joueur_groupe_Date_envoi' => $a_invitation_joueur_groupe_Date_envoi,
            'Code_joueur' => $Code_joueur,
            'Code_groupe' => $Code_groupe,
        ];
        return $this->post('a_invitation_joueur_groupe?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function a_invitation_joueur_groupe__edit($Code_joueur, $Code_groupe, $a_invitation_joueur_groupe_Message, $a_invitation_joueur_groupe_Date_envoi) {
        $data = [
            'a_invitation_joueur_groupe_Message' => $a_invitation_joueur_groupe_Message,
            'a_invitation_joueur_groupe_Date_envoi' => $a_invitation_joueur_groupe_Date_envoi,
        ];
        return $this->put('a_invitation_joueur_groupe/'.$Code_joueur.'-'.$Code_groupe.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function a_invitation_joueur_groupe__edit__a_invitation_joueur_groupe_Message($Code_joueur, $Code_groupe, $a_invitation_joueur_groupe_Message) {
        $data = ['a_invitation_joueur_groupe_Message' => $a_invitation_joueur_groupe_Message ];
        return $this->put('a_invitation_joueur_groupe/'.$Code_joueur.'-'.$Code_groupe.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function a_invitation_joueur_groupe__edit__a_invitation_joueur_groupe_Date_envoi($Code_joueur, $Code_groupe, $a_invitation_joueur_groupe_Date_envoi) {
        $data = ['a_invitation_joueur_groupe_Date_envoi' => $a_invitation_joueur_groupe_Date_envoi ];
        return $this->put('a_invitation_joueur_groupe/'.$Code_joueur.'-'.$Code_groupe.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function a_invitation_joueur_groupe__delete($Code_joueur, $Code_groupe) {
        return $this->delete('a_invitation_joueur_groupe/'.$Code_joueur.'-'.$Code_groupe.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    // +---------------+
    // | a_carte_objet |
    // +---------------+

    public function a_carte_objet__get($Code_carte, $Code_objet) {
        return $this->get('a_carte_objet/'.$Code_carte.'-'.$Code_objet.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function a_carte_objet__get_all(?int $Code_carte=null, ?int $Code_objet=null) {
        $requete = '';
        $Code_carte = (int) $Code_carte;
        if ($Code_carte != 0) { $requete.= 'carte/' . $Code_carte . '/'; }
        $Code_objet = (int) $Code_objet;
        if ($Code_objet != 0) { $requete.= 'objet/' . $Code_objet . '/'; }
        return $this->get($requete . 'a_carte_objet?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function a_carte_objet__add($Code_carte, $Code_objet) {
        $data = [
            'Code_carte' => $Code_carte,
            'Code_objet' => $Code_objet,
        ];
        return $this->post('a_carte_objet?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function a_carte_objet__edit($Code_carte, $Code_objet) {
        $data = [
        ];
        return $this->put('a_carte_objet/'.$Code_carte.'-'.$Code_objet.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function a_carte_objet__delete($Code_carte, $Code_objet) {
        return $this->delete('a_carte_objet/'.$Code_carte.'-'.$Code_objet.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    // +-------------------------+
    // | a_campagne_tag_campagne |
    // +-------------------------+

    public function a_campagne_tag_campagne__get($Code_tag_campagne, $Code_campagne) {
        return $this->get('a_campagne_tag_campagne/'.$Code_tag_campagne.'-'.$Code_campagne.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function a_campagne_tag_campagne__get_all(?int $Code_tag_campagne=null, ?int $Code_campagne=null) {
        $requete = '';
        $Code_tag_campagne = (int) $Code_tag_campagne;
        if ($Code_tag_campagne != 0) { $requete.= 'tag_campagne/' . $Code_tag_campagne . '/'; }
        $Code_campagne = (int) $Code_campagne;
        if ($Code_campagne != 0) { $requete.= 'campagne/' . $Code_campagne . '/'; }
        return $this->get($requete . 'a_campagne_tag_campagne?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function a_campagne_tag_campagne__add($Code_tag_campagne, $Code_campagne) {
        $data = [
            'Code_tag_campagne' => $Code_tag_campagne,
            'Code_campagne' => $Code_campagne,
        ];
        return $this->post('a_campagne_tag_campagne?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function a_campagne_tag_campagne__edit($Code_tag_campagne, $Code_campagne) {
        $data = [
        ];
        return $this->put('a_campagne_tag_campagne/'.$Code_tag_campagne.'-'.$Code_campagne.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function a_campagne_tag_campagne__delete($Code_tag_campagne, $Code_campagne) {
        return $this->delete('a_campagne_tag_campagne/'.$Code_tag_campagne.'-'.$Code_campagne.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    // +---------------------------+
    // | a_ressource_tag_ressource |
    // +---------------------------+

    public function a_ressource_tag_ressource__get($Code_tag_ressource, $Code_ressource) {
        return $this->get('a_ressource_tag_ressource/'.$Code_tag_ressource.'-'.$Code_ressource.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function a_ressource_tag_ressource__get_all(?int $Code_tag_ressource=null, ?int $Code_ressource=null) {
        $requete = '';
        $Code_tag_ressource = (int) $Code_tag_ressource;
        if ($Code_tag_ressource != 0) { $requete.= 'tag_ressource/' . $Code_tag_ressource . '/'; }
        $Code_ressource = (int) $Code_ressource;
        if ($Code_ressource != 0) { $requete.= 'ressource/' . $Code_ressource . '/'; }
        return $this->get($requete . 'a_ressource_tag_ressource?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function a_ressource_tag_ressource__add($Code_tag_ressource, $Code_ressource) {
        $data = [
            'Code_tag_ressource' => $Code_tag_ressource,
            'Code_ressource' => $Code_ressource,
        ];
        return $this->post('a_ressource_tag_ressource?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function a_ressource_tag_ressource__edit($Code_tag_ressource, $Code_ressource) {
        $data = [
        ];
        return $this->put('a_ressource_tag_ressource/'.$Code_tag_ressource.'-'.$Code_ressource.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function a_ressource_tag_ressource__delete($Code_tag_ressource, $Code_ressource) {
        return $this->delete('a_ressource_tag_ressource/'.$Code_tag_ressource.'-'.$Code_ressource.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    // +------------------------+
    // | a_liste_contact_joueur |
    // +------------------------+

    public function a_liste_contact_joueur__get($Code_liste_contacts, $Code_joueur) {
        return $this->get('a_liste_contact_joueur/'.$Code_liste_contacts.'-'.$Code_joueur.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function a_liste_contact_joueur__get_all(?int $Code_liste_contacts=null, ?int $Code_joueur=null) {
        $requete = '';
        $Code_liste_contacts = (int) $Code_liste_contacts;
        if ($Code_liste_contacts != 0) { $requete.= 'liste_contacts/' . $Code_liste_contacts . '/'; }
        $Code_joueur = (int) $Code_joueur;
        if ($Code_joueur != 0) { $requete.= 'joueur/' . $Code_joueur . '/'; }
        return $this->get($requete . 'a_liste_contact_joueur?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function a_liste_contact_joueur__add($Code_liste_contacts, $Code_joueur, $a_liste_contact_joueur_Date_creation) {
        $data = [
            'a_liste_contact_joueur_Date_creation' => $a_liste_contact_joueur_Date_creation,
            'Code_liste_contacts' => $Code_liste_contacts,
            'Code_joueur' => $Code_joueur,
        ];
        return $this->post('a_liste_contact_joueur?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function a_liste_contact_joueur__edit($Code_liste_contacts, $Code_joueur, $a_liste_contact_joueur_Date_creation) {
        $data = [
            'a_liste_contact_joueur_Date_creation' => $a_liste_contact_joueur_Date_creation,
        ];
        return $this->put('a_liste_contact_joueur/'.$Code_liste_contacts.'-'.$Code_joueur.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function a_liste_contact_joueur__edit__a_liste_contact_joueur_Date_creation($Code_liste_contacts, $Code_joueur, $a_liste_contact_joueur_Date_creation) {
        $data = ['a_liste_contact_joueur_Date_creation' => $a_liste_contact_joueur_Date_creation ];
        return $this->put('a_liste_contact_joueur/'.$Code_liste_contacts.'-'.$Code_joueur.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function a_liste_contact_joueur__delete($Code_liste_contacts, $Code_joueur) {
        return $this->delete('a_liste_contact_joueur/'.$Code_liste_contacts.'-'.$Code_joueur.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

}
