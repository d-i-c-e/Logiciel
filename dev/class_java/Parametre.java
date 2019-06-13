
public class Parametre {

    // key
    private int code_parametre;

    // dependences

    // informations
    private String parametre_Libelle;
    private int parametre_Valeur;
    private boolean parametre_Activable;
    private boolean parametre_Actif;

    public Parametre() { }

    public Parametre( int code_parametre,  String parametre_Libelle,  int parametre_Valeur,  boolean parametre_Activable,  boolean parametre_Actif ) {
        this.code_parametre = code_parametre;
        this.parametre_Libelle = parametre_Libelle;
        this.parametre_Valeur = parametre_Valeur;
        this.parametre_Activable = parametre_Activable;
        this.parametre_Actif = parametre_Actif;
    }

    public int get_code_parametre() { return this.code_parametre; }
    public String get_parametre_Libelle() { return this.parametre_Libelle; }
    public int get_parametre_Valeur() { return this.parametre_Valeur; }
    public boolean get_parametre_Activable() { return this.parametre_Activable; }
    public boolean get_parametre_Actif() { return this.parametre_Actif; }

    public void set_parametre_Libelle( String parametre_Libelle ) { this.parametre_Libelle = parametre_Libelle; }
    public void set_parametre_Valeur( int parametre_Valeur ) { this.parametre_Valeur = parametre_Valeur; }
    public void set_parametre_Activable( boolean parametre_Activable ) { this.parametre_Activable = parametre_Activable; }
    public void set_parametre_Actif( boolean parametre_Actif ) { this.parametre_Actif = parametre_Actif; }

}
