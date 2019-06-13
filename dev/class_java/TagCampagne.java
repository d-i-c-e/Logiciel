
public class TagCampagne {

    // key
    private int code_tag_campagne;

    // dependences

    // informations
    private String tag_campagne_Libelle;

    public TagCampagne() { }

    public TagCampagne( int code_tag_campagne,  String tag_campagne_Libelle ) {
        this.code_tag_campagne = code_tag_campagne;
        this.tag_campagne_Libelle = tag_campagne_Libelle;
    }

    public int get_code_tag_campagne() { return this.code_tag_campagne; }
    public String get_tag_campagne_Libelle() { return this.tag_campagne_Libelle; }

    public void set_tag_campagne_Libelle( String tag_campagne_Libelle ) { this.tag_campagne_Libelle = tag_campagne_Libelle; }

}
