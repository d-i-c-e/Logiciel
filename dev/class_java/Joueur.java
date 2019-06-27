
public class Joueur {

    // key
    private int code_joueur;

    // dependences

    // informations
    private String joueur_Email;
    private String joueur_Identifiant;
    private String joueur_Password;
    private String joueur_Avatar_Fichier;
    private String joueur_Date_naissance;
    private String joueur_Date_inscription;
    private boolean joueur_Administrateur;

    public Joueur() { }

    public Joueur( int code_joueur,  String joueur_Email,  String joueur_Identifiant,  String joueur_Password,  String joueur_Avatar_Fichier,  String joueur_Date_naissance,  String joueur_Date_inscription,  boolean joueur_Administrateur ) {
        this.code_joueur = code_joueur;
        this.joueur_Email = joueur_Email;
        this.joueur_Identifiant = joueur_Identifiant;
        this.joueur_Password = joueur_Password;
        this.joueur_Avatar_Fichier = joueur_Avatar_Fichier;
        this.joueur_Date_naissance = joueur_Date_naissance;
        this.joueur_Date_inscription = joueur_Date_inscription;
        this.joueur_Administrateur = joueur_Administrateur;
    }

    public int get_code_joueur() { return this.code_joueur; }
    public String get_joueur_Email() { return this.joueur_Email; }
    public String get_joueur_Identifiant() { return this.joueur_Identifiant; }
    public String get_joueur_Password() { return this.joueur_Password; }
    public String get_joueur_Avatar_Fichier() { return this.joueur_Avatar_Fichier; }
    public String get_joueur_Date_naissance() { return this.joueur_Date_naissance; }
    public String get_joueur_Date_inscription() { return this.joueur_Date_inscription; }
    public boolean get_joueur_Administrateur() { return this.joueur_Administrateur; }

    public void set_joueur_Email( String joueur_Email ) { this.joueur_Email = joueur_Email; }
    public void set_joueur_Identifiant( String joueur_Identifiant ) { this.joueur_Identifiant = joueur_Identifiant; }
    public void set_joueur_Password( String joueur_Password ) { this.joueur_Password = joueur_Password; }
    public void set_joueur_Avatar_Fichier( String joueur_Avatar_Fichier ) { this.joueur_Avatar_Fichier = joueur_Avatar_Fichier; }
    public void set_joueur_Date_naissance( String joueur_Date_naissance ) { this.joueur_Date_naissance = joueur_Date_naissance; }
    public void set_joueur_Date_inscription( String joueur_Date_inscription ) { this.joueur_Date_inscription = joueur_Date_inscription; }
    public void set_joueur_Administrateur( boolean joueur_Administrateur ) { this.joueur_Administrateur = joueur_Administrateur; }

}
