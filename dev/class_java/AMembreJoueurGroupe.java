
public class AMembreJoueurGroupe {

    // dependences
    private int code_groupe;
    private int code_joueur;

    // informations
    private String a_membre_joueur_groupe_Surnom;
    private int a_membre_joueur_groupe_Grade;
    private String a_membre_joueur_groupe_Date_adhesion;

    public AMembreJoueurGroupe() { }

    public AMembreJoueurGroupe(  int code_groupe,  int code_joueur,  String a_membre_joueur_groupe_Surnom,  int a_membre_joueur_groupe_Grade,  String a_membre_joueur_groupe_Date_adhesion ) {
        this.code_groupe = code_groupe;
        this.code_joueur = code_joueur;
        this.a_membre_joueur_groupe_Surnom = a_membre_joueur_groupe_Surnom;
        this.a_membre_joueur_groupe_Grade = a_membre_joueur_groupe_Grade;
        this.a_membre_joueur_groupe_Date_adhesion = a_membre_joueur_groupe_Date_adhesion;
    }

    public int get_code_groupe() { return this.code_groupe; }
    public int get_code_joueur() { return this.code_joueur; }
    public String get_a_membre_joueur_groupe_Surnom() { return this.a_membre_joueur_groupe_Surnom; }
    public int get_a_membre_joueur_groupe_Grade() { return this.a_membre_joueur_groupe_Grade; }
    public String get_a_membre_joueur_groupe_Date_adhesion() { return this.a_membre_joueur_groupe_Date_adhesion; }

    public void set_a_membre_joueur_groupe_Surnom( String a_membre_joueur_groupe_Surnom ) { this.a_membre_joueur_groupe_Surnom = a_membre_joueur_groupe_Surnom; }
    public void set_a_membre_joueur_groupe_Grade( int a_membre_joueur_groupe_Grade ) { this.a_membre_joueur_groupe_Grade = a_membre_joueur_groupe_Grade; }
    public void set_a_membre_joueur_groupe_Date_adhesion( String a_membre_joueur_groupe_Date_adhesion ) { this.a_membre_joueur_groupe_Date_adhesion = a_membre_joueur_groupe_Date_adhesion; }

}
