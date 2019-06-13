
public class Type {

    // key
    private int code_type;

    // dependences
    private int code_ressource;

    // informations
    private String type_Libelle;

    public Type() { }

    public Type( int code_type,  int code_ressource,  String type_Libelle ) {
        this.code_type = code_type;
        this.code_ressource = code_ressource;
        this.type_Libelle = type_Libelle;
    }

    public int get_code_type() { return this.code_type; }
    public int get_code_ressource() { return this.code_ressource; }
    public String get_type_Libelle() { return this.type_Libelle; }

    public void set_code_ressource( int code_ressource ) { this.code_ressource = code_ressource; }
    public void set_type_Libelle( String type_Libelle ) { this.type_Libelle = type_Libelle; }

}
