
public class AJoueurParametre {

    // dependences
    private int code_joueur;
    private int code_parametre;

    // informations
    private int a_joueur_parametre_Valeur_choisie;
    private boolean a_joueur_parametre_Actif;

    public AJoueurParametre() { }

    public AJoueurParametre(  int code_joueur,  int code_parametre,  int a_joueur_parametre_Valeur_choisie,  boolean a_joueur_parametre_Actif ) {
        this.code_joueur = code_joueur;
        this.code_parametre = code_parametre;
        this.a_joueur_parametre_Valeur_choisie = a_joueur_parametre_Valeur_choisie;
        this.a_joueur_parametre_Actif = a_joueur_parametre_Actif;
    }

    public int get_code_joueur() { return this.code_joueur; }
    public int get_code_parametre() { return this.code_parametre; }
    public int get_a_joueur_parametre_Valeur_choisie() { return this.a_joueur_parametre_Valeur_choisie; }
    public boolean get_a_joueur_parametre_Actif() { return this.a_joueur_parametre_Actif; }

    public void set_a_joueur_parametre_Valeur_choisie( int a_joueur_parametre_Valeur_choisie ) { this.a_joueur_parametre_Valeur_choisie = a_joueur_parametre_Valeur_choisie; }
    public void set_a_joueur_parametre_Actif( boolean a_joueur_parametre_Actif ) { this.a_joueur_parametre_Actif = a_joueur_parametre_Actif; }

}
