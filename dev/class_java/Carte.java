
public class Carte {

    // key
    private int code_carte;

    // dependences
    private int code_groupe;

    // informations
    private String carte_Nom;
    private int carte_Hauteur;
    private int carte_Largeur;
    private String carte_Fichier;

    public Carte() { }

    public Carte( int code_carte,  int code_groupe,  String carte_Nom,  int carte_Hauteur,  int carte_Largeur,  String carte_Fichier ) {
        this.code_carte = code_carte;
        this.code_groupe = code_groupe;
        this.carte_Nom = carte_Nom;
        this.carte_Hauteur = carte_Hauteur;
        this.carte_Largeur = carte_Largeur;
        this.carte_Fichier = carte_Fichier;
    }

    public int get_code_carte() { return this.code_carte; }
    public int get_code_groupe() { return this.code_groupe; }
    public String get_carte_Nom() { return this.carte_Nom; }
    public int get_carte_Hauteur() { return this.carte_Hauteur; }
    public int get_carte_Largeur() { return this.carte_Largeur; }
    public String get_carte_Fichier() { return this.carte_Fichier; }

    public void set_code_groupe( int code_groupe ) { this.code_groupe = code_groupe; }
    public void set_carte_Nom( String carte_Nom ) { this.carte_Nom = carte_Nom; }
    public void set_carte_Hauteur( int carte_Hauteur ) { this.carte_Hauteur = carte_Hauteur; }
    public void set_carte_Largeur( int carte_Largeur ) { this.carte_Largeur = carte_Largeur; }
    public void set_carte_Fichier( String carte_Fichier ) { this.carte_Fichier = carte_Fichier; }

}
