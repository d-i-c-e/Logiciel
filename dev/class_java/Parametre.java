
public class Parametre {

    // key
    private int code_parametre;

    // dependences

    // informations
    private String parametre_Libelle;
    private boolean parametre_Activable;

    public Parametre() { }

    public Parametre( int code_parametre,  String parametre_Libelle,  boolean parametre_Activable ) {
        this.code_parametre = code_parametre;
        this.parametre_Libelle = parametre_Libelle;
        this.parametre_Activable = parametre_Activable;
    }

    public int get_code_parametre() { return this.code_parametre; }
    public String get_parametre_Libelle() { return this.parametre_Libelle; }
    public boolean get_parametre_Activable() { return this.parametre_Activable; }

    public void set_parametre_Libelle( String parametre_Libelle ) { this.parametre_Libelle = parametre_Libelle; }
    public void set_parametre_Activable( boolean parametre_Activable ) { this.parametre_Activable = parametre_Activable; }

}
