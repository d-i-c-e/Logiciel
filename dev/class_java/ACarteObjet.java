
public class ACarteObjet {

    // dependences
    private int code_carte;
    private int code_objet;

    // informations

    public ACarteObjet() { }

    public ACarteObjet(  int code_carte,  int code_objet ) {
        this.code_carte = code_carte;
        this.code_objet = code_objet;
    }

    public int get_code_carte() { return this.code_carte; }
    public int get_code_objet() { return this.code_objet; }


}
