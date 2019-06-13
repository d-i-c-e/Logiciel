
public class ARessourceTagRessource {

    // dependences
    private int code_tag_ressource;
    private int code_ressource;

    // informations

    public ARessourceTagRessource() { }

    public ARessourceTagRessource(  int code_tag_ressource,  int code_ressource ) {
        this.code_tag_ressource = code_tag_ressource;
        this.code_ressource = code_ressource;
    }

    public int get_code_tag_ressource() { return this.code_tag_ressource; }
    public int get_code_ressource() { return this.code_ressource; }


}
