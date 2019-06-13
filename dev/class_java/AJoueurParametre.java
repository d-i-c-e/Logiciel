
public class AJoueurParametre {

    // dependences
    private int code_joueur;
    private int code_parametre;

    // informations

    public AJoueurParametre() { }

    public AJoueurParametre(  int code_joueur,  int code_parametre ) {
        this.code_joueur = code_joueur;
        this.code_parametre = code_parametre;
    }

    public int get_code_joueur() { return this.code_joueur; }
    public int get_code_parametre() { return this.code_parametre; }


}
