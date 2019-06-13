
public class TagRessource {

    // key
    private int code_tag_ressource;

    // dependences

    // informations
    private String tag_ressource_Libelle;

    public TagRessource() { }

    public TagRessource( int code_tag_ressource,  String tag_ressource_Libelle ) {
        this.code_tag_ressource = code_tag_ressource;
        this.tag_ressource_Libelle = tag_ressource_Libelle;
    }

    public int get_code_tag_ressource() { return this.code_tag_ressource; }
    public String get_tag_ressource_Libelle() { return this.tag_ressource_Libelle; }

    public void set_tag_ressource_Libelle( String tag_ressource_Libelle ) { this.tag_ressource_Libelle = tag_ressource_Libelle; }

}
