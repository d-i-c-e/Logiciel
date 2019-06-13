
public class ACampagneTagCampagne {

    // dependences
    private int code_tag_campagne;
    private int code_campagne;

    // informations

    public ACampagneTagCampagne() { }

    public ACampagneTagCampagne(  int code_tag_campagne,  int code_campagne ) {
        this.code_tag_campagne = code_tag_campagne;
        this.code_campagne = code_campagne;
    }

    public int get_code_tag_campagne() { return this.code_tag_campagne; }
    public int get_code_campagne() { return this.code_campagne; }


}
