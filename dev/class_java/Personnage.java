
public class Personnage {

    // key
    private int code_personnage;

    // dependences
    private int code_joueur;
    private int code_groupe;

    // informations
    private String personnage_Fichier_Fichier;
    private boolean personnage_Conservation;

    public Personnage() { }

    public Personnage( int code_personnage,  int code_joueur,  int code_groupe,  String personnage_Fichier_Fichier,  boolean personnage_Conservation ) {
        this.code_personnage = code_personnage;
        this.code_joueur = code_joueur;
        this.code_groupe = code_groupe;
        this.personnage_Fichier_Fichier = personnage_Fichier_Fichier;
        this.personnage_Conservation = personnage_Conservation;
    }

    public int get_code_personnage() { return this.code_personnage; }
    public int get_code_joueur() { return this.code_joueur; }
    public int get_code_groupe() { return this.code_groupe; }
    public String get_personnage_Fichier_Fichier() { return this.personnage_Fichier_Fichier; }
    public boolean get_personnage_Conservation() { return this.personnage_Conservation; }

    public void set_code_joueur( int code_joueur ) { this.code_joueur = code_joueur; }
    public void set_code_groupe( int code_groupe ) { this.code_groupe = code_groupe; }
    public void set_personnage_Fichier_Fichier( String personnage_Fichier_Fichier ) { this.personnage_Fichier_Fichier = personnage_Fichier_Fichier; }
    public void set_personnage_Conservation( boolean personnage_Conservation ) { this.personnage_Conservation = personnage_Conservation; }

}
