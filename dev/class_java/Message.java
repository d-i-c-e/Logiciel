
public class Message {

    // key
    private int code_message;

    // dependences
    private int code_messagerie;
    private int code_joueur;

    // informations
    private String message_Texte;
    private String message_Date;

    public Message() { }

    public Message( int code_message,  int code_messagerie,  int code_joueur,  String message_Texte,  String message_Date ) {
        this.code_message = code_message;
        this.code_messagerie = code_messagerie;
        this.code_joueur = code_joueur;
        this.message_Texte = message_Texte;
        this.message_Date = message_Date;
    }

    public int get_code_message() { return this.code_message; }
    public int get_code_messagerie() { return this.code_messagerie; }
    public int get_code_joueur() { return this.code_joueur; }
    public String get_message_Texte() { return this.message_Texte; }
    public String get_message_Date() { return this.message_Date; }

    public void set_code_messagerie( int code_messagerie ) { this.code_messagerie = code_messagerie; }
    public void set_code_joueur( int code_joueur ) { this.code_joueur = code_joueur; }
    public void set_message_Texte( String message_Texte ) { this.message_Texte = message_Texte; }
    public void set_message_Date( String message_Date ) { this.message_Date = message_Date; }

}
