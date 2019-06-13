
public class AInvitationJoueurGroupe {

    // dependences
    private int code_joueur;
    private int code_groupe;

    // informations
    private String a_invitation_joueur_groupe_Message;
    private String a_invitation_joueur_groupe_Date_envoi;

    public AInvitationJoueurGroupe() { }

    public AInvitationJoueurGroupe(  int code_joueur,  int code_groupe,  String a_invitation_joueur_groupe_Message,  String a_invitation_joueur_groupe_Date_envoi ) {
        this.code_joueur = code_joueur;
        this.code_groupe = code_groupe;
        this.a_invitation_joueur_groupe_Message = a_invitation_joueur_groupe_Message;
        this.a_invitation_joueur_groupe_Date_envoi = a_invitation_joueur_groupe_Date_envoi;
    }

    public int get_code_joueur() { return this.code_joueur; }
    public int get_code_groupe() { return this.code_groupe; }
    public String get_a_invitation_joueur_groupe_Message() { return this.a_invitation_joueur_groupe_Message; }
    public String get_a_invitation_joueur_groupe_Date_envoi() { return this.a_invitation_joueur_groupe_Date_envoi; }

    public void set_a_invitation_joueur_groupe_Message( String a_invitation_joueur_groupe_Message ) { this.a_invitation_joueur_groupe_Message = a_invitation_joueur_groupe_Message; }
    public void set_a_invitation_joueur_groupe_Date_envoi( String a_invitation_joueur_groupe_Date_envoi ) { this.a_invitation_joueur_groupe_Date_envoi = a_invitation_joueur_groupe_Date_envoi; }

}
