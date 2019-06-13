
public class Campagne {

    // key
    private int code_campagne;

    // dependences

    // informations
    private String campagne_Nom;
    private String campagne_Description;
    private String campagne_Image_Fichier;
    private int campagne_Nombre_joueur;
    private int campagne_Nombre_mj;

    public Campagne() { }

    public Campagne( int code_campagne,  String campagne_Nom,  String campagne_Description,  String campagne_Image_Fichier,  int campagne_Nombre_joueur,  int campagne_Nombre_mj ) {
        this.code_campagne = code_campagne;
        this.campagne_Nom = campagne_Nom;
        this.campagne_Description = campagne_Description;
        this.campagne_Image_Fichier = campagne_Image_Fichier;
        this.campagne_Nombre_joueur = campagne_Nombre_joueur;
        this.campagne_Nombre_mj = campagne_Nombre_mj;
    }

    public int get_code_campagne() { return this.code_campagne; }
    public String get_campagne_Nom() { return this.campagne_Nom; }
    public String get_campagne_Description() { return this.campagne_Description; }
    public String get_campagne_Image_Fichier() { return this.campagne_Image_Fichier; }
    public int get_campagne_Nombre_joueur() { return this.campagne_Nombre_joueur; }
    public int get_campagne_Nombre_mj() { return this.campagne_Nombre_mj; }

    public void set_campagne_Nom( String campagne_Nom ) { this.campagne_Nom = campagne_Nom; }
    public void set_campagne_Description( String campagne_Description ) { this.campagne_Description = campagne_Description; }
    public void set_campagne_Image_Fichier( String campagne_Image_Fichier ) { this.campagne_Image_Fichier = campagne_Image_Fichier; }
    public void set_campagne_Nombre_joueur( int campagne_Nombre_joueur ) { this.campagne_Nombre_joueur = campagne_Nombre_joueur; }
    public void set_campagne_Nombre_mj( int campagne_Nombre_mj ) { this.campagne_Nombre_mj = campagne_Nombre_mj; }

}
