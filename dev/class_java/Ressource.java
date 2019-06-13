
public class Ressource {

    // key
    private int code_ressource;

    // dependences

    // informations
    private String ressource_Nom;

    public Ressource() { }

    public Ressource( int code_ressource,  String ressource_Nom ) {
        this.code_ressource = code_ressource;
        this.ressource_Nom = ressource_Nom;
    }

    public int get_code_ressource() { return this.code_ressource; }
    public String get_ressource_Nom() { return this.ressource_Nom; }

    public void set_ressource_Nom( String ressource_Nom ) { this.ressource_Nom = ressource_Nom; }

}
