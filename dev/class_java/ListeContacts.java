
public class ListeContacts {

    // key
    private int code_liste_contacts;

    // dependences
    private int code_joueur;

    // informations
    private String liste_contacts_Nom;

    public ListeContacts() { }

    public ListeContacts( int code_liste_contacts,  int code_joueur,  String liste_contacts_Nom ) {
        this.code_liste_contacts = code_liste_contacts;
        this.code_joueur = code_joueur;
        this.liste_contacts_Nom = liste_contacts_Nom;
    }

    public int get_code_liste_contacts() { return this.code_liste_contacts; }
    public int get_code_joueur() { return this.code_joueur; }
    public String get_liste_contacts_Nom() { return this.liste_contacts_Nom; }

    public void set_code_joueur( int code_joueur ) { this.code_joueur = code_joueur; }
    public void set_liste_contacts_Nom( String liste_contacts_Nom ) { this.liste_contacts_Nom = liste_contacts_Nom; }

}
