
public class Groupe {

    // key
    private int code_groupe;

    // dependences
    private int code_campagne;

    // informations
    private String groupe_Nom;
    private String groupe_Description;
    private String groupe_Logo_Fichier;
    private boolean groupe_Effectif;
    private int groupe_Actif;
    private String groupe_Date_creation;
    private int groupe_Delai_suppression_jour;
    private boolean groupe_Suppression_active;

    public Groupe() { }

    public Groupe( int code_groupe,  int code_campagne,  String groupe_Nom,  String groupe_Description,  String groupe_Logo_Fichier,  boolean groupe_Effectif,  int groupe_Actif,  String groupe_Date_creation,  int groupe_Delai_suppression_jour,  boolean groupe_Suppression_active ) {
        this.code_groupe = code_groupe;
        this.code_campagne = code_campagne;
        this.groupe_Nom = groupe_Nom;
        this.groupe_Description = groupe_Description;
        this.groupe_Logo_Fichier = groupe_Logo_Fichier;
        this.groupe_Effectif = groupe_Effectif;
        this.groupe_Actif = groupe_Actif;
        this.groupe_Date_creation = groupe_Date_creation;
        this.groupe_Delai_suppression_jour = groupe_Delai_suppression_jour;
        this.groupe_Suppression_active = groupe_Suppression_active;
    }

    public int get_code_groupe() { return this.code_groupe; }
    public int get_code_campagne() { return this.code_campagne; }
    public String get_groupe_Nom() { return this.groupe_Nom; }
    public String get_groupe_Description() { return this.groupe_Description; }
    public String get_groupe_Logo_Fichier() { return this.groupe_Logo_Fichier; }
    public boolean get_groupe_Effectif() { return this.groupe_Effectif; }
    public int get_groupe_Actif() { return this.groupe_Actif; }
    public String get_groupe_Date_creation() { return this.groupe_Date_creation; }
    public int get_groupe_Delai_suppression_jour() { return this.groupe_Delai_suppression_jour; }
    public boolean get_groupe_Suppression_active() { return this.groupe_Suppression_active; }

    public void set_code_campagne( int code_campagne ) { this.code_campagne = code_campagne; }
    public void set_groupe_Nom( String groupe_Nom ) { this.groupe_Nom = groupe_Nom; }
    public void set_groupe_Description( String groupe_Description ) { this.groupe_Description = groupe_Description; }
    public void set_groupe_Logo_Fichier( String groupe_Logo_Fichier ) { this.groupe_Logo_Fichier = groupe_Logo_Fichier; }
    public void set_groupe_Effectif( boolean groupe_Effectif ) { this.groupe_Effectif = groupe_Effectif; }
    public void set_groupe_Actif( int groupe_Actif ) { this.groupe_Actif = groupe_Actif; }
    public void set_groupe_Date_creation( String groupe_Date_creation ) { this.groupe_Date_creation = groupe_Date_creation; }
    public void set_groupe_Delai_suppression_jour( int groupe_Delai_suppression_jour ) { this.groupe_Delai_suppression_jour = groupe_Delai_suppression_jour; }
    public void set_groupe_Suppression_active( boolean groupe_Suppression_active ) { this.groupe_Suppression_active = groupe_Suppression_active; }

}
