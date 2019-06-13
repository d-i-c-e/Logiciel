
public class Objet {

    // key
    private int code_objet;

    // dependences
    private int code_type;

    // informations
    private String objet_Libelle;
    private String objet_Image_Fichier;

    public Objet() { }

    public Objet( int code_objet,  int code_type,  String objet_Libelle,  String objet_Image_Fichier ) {
        this.code_objet = code_objet;
        this.code_type = code_type;
        this.objet_Libelle = objet_Libelle;
        this.objet_Image_Fichier = objet_Image_Fichier;
    }

    public int get_code_objet() { return this.code_objet; }
    public int get_code_type() { return this.code_type; }
    public String get_objet_Libelle() { return this.objet_Libelle; }
    public String get_objet_Image_Fichier() { return this.objet_Image_Fichier; }

    public void set_code_type( int code_type ) { this.code_type = code_type; }
    public void set_objet_Libelle( String objet_Libelle ) { this.objet_Libelle = objet_Libelle; }
    public void set_objet_Image_Fichier( String objet_Image_Fichier ) { this.objet_Image_Fichier = objet_Image_Fichier; }

}
