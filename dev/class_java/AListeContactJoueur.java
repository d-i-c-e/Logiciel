
public class AListeContactJoueur {

    // dependences
    private int code_liste_contacts;
    private int code_joueur;

    // informations
    private String a_liste_contact_joueur_Date_creation;

    public AListeContactJoueur() { }

    public AListeContactJoueur(  int code_liste_contacts,  int code_joueur,  String a_liste_contact_joueur_Date_creation ) {
        this.code_liste_contacts = code_liste_contacts;
        this.code_joueur = code_joueur;
        this.a_liste_contact_joueur_Date_creation = a_liste_contact_joueur_Date_creation;
    }

    public int get_code_liste_contacts() { return this.code_liste_contacts; }
    public int get_code_joueur() { return this.code_joueur; }
    public String get_a_liste_contact_joueur_Date_creation() { return this.a_liste_contact_joueur_Date_creation; }

    public void set_a_liste_contact_joueur_Date_creation( String a_liste_contact_joueur_Date_creation ) { this.a_liste_contact_joueur_Date_creation = a_liste_contact_joueur_Date_creation; }

}
