
public class ParametreValeur {

    // key
    private int code_parametre_valeur;

    // dependences
    private int code_parametre;

    // informations
    private String parametre_valeur_Libelle;

    public ParametreValeur() { }

    public ParametreValeur( int code_parametre_valeur,  int code_parametre,  String parametre_valeur_Libelle ) {
        this.code_parametre_valeur = code_parametre_valeur;
        this.code_parametre = code_parametre;
        this.parametre_valeur_Libelle = parametre_valeur_Libelle;
    }

    public int get_code_parametre_valeur() { return this.code_parametre_valeur; }
    public int get_code_parametre() { return this.code_parametre; }
    public String get_parametre_valeur_Libelle() { return this.parametre_valeur_Libelle; }

    public void set_code_parametre( int code_parametre ) { this.code_parametre = code_parametre; }
    public void set_parametre_valeur_Libelle( String parametre_valeur_Libelle ) { this.parametre_valeur_Libelle = parametre_valeur_Libelle; }

}
