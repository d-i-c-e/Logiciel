
public class Messagerie {

    // key
    private int code_messagerie;

    // dependences
    private int code_joueur;

    // informations

    public Messagerie() { }

    public Messagerie( int code_messagerie,  int code_joueur ) {
        this.code_messagerie = code_messagerie;
        this.code_joueur = code_joueur;
    }

    public int get_code_messagerie() { return this.code_messagerie; }
    public int get_code_joueur() { return this.code_joueur; }

    public void set_code_joueur( int code_joueur ) { this.code_joueur = code_joueur; }

}
