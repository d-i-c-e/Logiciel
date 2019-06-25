Option Explicit

Dim mf_token As String

Function connexion(ByVal mf_login As String, ByVal mf_pwd As String) As Boolean
    requete.nettoyage
    mf_login = requete.convert_encode_url(mf_login)
    mf_pwd = requete.convert_encode_url(mf_pwd)
    requete.requete_serveur "connexion.php?mf_login=" & mf_login & "&mf_pwd=" & mf_pwd & "&vue=tableau"
    requete.vider_le_cache
    connexion = requete.retour_ok()
    If connexion Then
        mf_token = requete.Cells(2, 2)
    End If
End Function

Function deconnexion() As Boolean
    Code_utilisateur = parametres.get_Code_utilisateur
    utilisateur_cle_de_connexion = parametres.get_utilisateur_cle_de_connexion()
    requete.requete_serveur "deconnexion.php?mf_token=" & mf_token & "&vue=tableau"
    requete.vider_le_cache
    requete.nettoyage
End Function

'   +--------+
'   | joueur |
'   +--------+

Function joueur__ajouter(ByVal joueur_Email As String, ByVal joueur_Identifiant As String, ByVal joueur_Password As String, ByVal joueur_Avatar_Fichier As String, ByVal joueur_Date_naissance As String, ByVal joueur_Date_inscription As String) As Long
    joueur_Email = requete.convert_encode_url(joueur_Email)
    joueur_Identifiant = requete.convert_encode_url(joueur_Identifiant)
    joueur_Password = requete.convert_encode_url(joueur_Password)
    joueur_Avatar_Fichier = requete.convert_encode_url(joueur_Avatar_Fichier)
    joueur_Date_naissance = requete.convert_encode_url(joueur_Date_naissance)
    joueur_Date_inscription = requete.convert_encode_url(joueur_Date_inscription)
    requete.requete_serveur "joueur/ajouter.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&joueur_Email=" & joueur_Email & "&joueur_Identifiant=" & joueur_Identifiant & "&joueur_Password=" & joueur_Password & "&joueur_Avatar_Fichier=" & joueur_Avatar_Fichier & "&joueur_Date_naissance=" & joueur_Date_naissance & "&joueur_Date_inscription=" & joueur_Date_inscription
    joueur__ajouter = requete.retour_ok()
End Function

Function joueur__modifier(ByVal Code_joueur As String, ByVal joueur_Email As String, ByVal joueur_Identifiant As String, ByVal joueur_Password As String, ByVal joueur_Avatar_Fichier As String, ByVal joueur_Date_naissance As String, ByVal joueur_Date_inscription As String) As Long
    Code_joueur = requete.convert_encode_url(Code_joueur)
    joueur_Email = requete.convert_encode_url(joueur_Email)
    joueur_Identifiant = requete.convert_encode_url(joueur_Identifiant)
    joueur_Password = requete.convert_encode_url(joueur_Password)
    joueur_Avatar_Fichier = requete.convert_encode_url(joueur_Avatar_Fichier)
    joueur_Date_naissance = requete.convert_encode_url(joueur_Date_naissance)
    joueur_Date_inscription = requete.convert_encode_url(joueur_Date_inscription)
    requete.requete_serveur "joueur/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_joueur=" & Code_joueur & "&joueur_Email=" & joueur_Email & "&joueur_Identifiant=" & joueur_Identifiant & "&joueur_Password=" & joueur_Password & "&joueur_Avatar_Fichier=" & joueur_Avatar_Fichier & "&joueur_Date_naissance=" & joueur_Date_naissance & "&joueur_Date_inscription=" & joueur_Date_inscription
    joueur__modifier = requete.retour_ok()
End Function

Function joueur__modifier__joueur_Email(ByVal Code_joueur As String, ByVal joueur_Email As String) As Long
    Code_joueur = requete.convert_encode_url(Code_joueur)
    joueur_Email = requete.convert_encode_url(joueur_Email)
    requete.requete_serveur "joueur/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_joueur=" & Code_joueur & "&joueur_Email=" & joueur_Email
    joueur__modifier__joueur_Email = requete.retour_ok()
End Function

Function joueur__modifier__joueur_Identifiant(ByVal Code_joueur As String, ByVal joueur_Identifiant As String) As Long
    Code_joueur = requete.convert_encode_url(Code_joueur)
    joueur_Identifiant = requete.convert_encode_url(joueur_Identifiant)
    requete.requete_serveur "joueur/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_joueur=" & Code_joueur & "&joueur_Identifiant=" & joueur_Identifiant
    joueur__modifier__joueur_Identifiant = requete.retour_ok()
End Function

Function joueur__modifier__joueur_Password(ByVal Code_joueur As String, ByVal joueur_Password As String) As Long
    Code_joueur = requete.convert_encode_url(Code_joueur)
    joueur_Password = requete.convert_encode_url(joueur_Password)
    requete.requete_serveur "joueur/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_joueur=" & Code_joueur & "&joueur_Password=" & joueur_Password
    joueur__modifier__joueur_Password = requete.retour_ok()
End Function

Function joueur__modifier__joueur_Avatar_Fichier(ByVal Code_joueur As String, ByVal joueur_Avatar_Fichier As String) As Long
    Code_joueur = requete.convert_encode_url(Code_joueur)
    joueur_Avatar_Fichier = requete.convert_encode_url(joueur_Avatar_Fichier)
    requete.requete_serveur "joueur/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_joueur=" & Code_joueur & "&joueur_Avatar_Fichier=" & joueur_Avatar_Fichier
    joueur__modifier__joueur_Avatar_Fichier = requete.retour_ok()
End Function

Function joueur__modifier__joueur_Date_naissance(ByVal Code_joueur As String, ByVal joueur_Date_naissance As String) As Long
    Code_joueur = requete.convert_encode_url(Code_joueur)
    joueur_Date_naissance = requete.convert_encode_url(joueur_Date_naissance)
    requete.requete_serveur "joueur/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_joueur=" & Code_joueur & "&joueur_Date_naissance=" & joueur_Date_naissance
    joueur__modifier__joueur_Date_naissance = requete.retour_ok()
End Function

Function joueur__modifier__joueur_Date_inscription(ByVal Code_joueur As String, ByVal joueur_Date_inscription As String) As Long
    Code_joueur = requete.convert_encode_url(Code_joueur)
    joueur_Date_inscription = requete.convert_encode_url(joueur_Date_inscription)
    requete.requete_serveur "joueur/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_joueur=" & Code_joueur & "&joueur_Date_inscription=" & joueur_Date_inscription
    joueur__modifier__joueur_Date_inscription = requete.retour_ok()
End Function

Function joueur__supprimer(ByVal Code_joueur As String) As Long
    Code_joueur = requete.convert_encode_url(Code_joueur)
    requete.requete_serveur "joueur/supprimer.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_joueur=" & Code_joueur
    joueur__supprimer = requete.retour_ok()
End Function

Function joueur__lister() As Long
    requete.requete_serveur "joueur/lister.php?" & "vue=tableau" & "&mf_token=" & mf_token
    joueur__lister = requete.retour_ok()
End Function

'   +---------+
'   | message |
'   +---------+

Function message__ajouter(ByVal Code_messagerie As String, ByVal Code_joueur As String, ByVal message_Texte As String, ByVal message_Date As String) As Long
    message_Texte = requete.convert_encode_url(message_Texte)
    message_Date = requete.convert_encode_url(message_Date)
    Code_messagerie = requete.convert_encode_url(Code_messagerie)
    Code_joueur = requete.convert_encode_url(Code_joueur)
    requete.requete_serveur "message/ajouter.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_messagerie=" & Code_messagerie & "&Code_joueur=" & Code_joueur & "&message_Texte=" & message_Texte & "&message_Date=" & message_Date
    message__ajouter = requete.retour_ok()
End Function

Function message__modifier(ByVal Code_message As String, ByVal Code_messagerie As String, ByVal Code_joueur As String, ByVal message_Texte As String, ByVal message_Date As String) As Long
    Code_message = requete.convert_encode_url(Code_message)
    message_Texte = requete.convert_encode_url(message_Texte)
    message_Date = requete.convert_encode_url(message_Date)
    Code_messagerie = requete.convert_encode_url(Code_messagerie)
    Code_joueur = requete.convert_encode_url(Code_joueur)
    requete.requete_serveur "message/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_message=" & Code_message & "&Code_messagerie=" & Code_messagerie & "&Code_joueur=" & Code_joueur & "&message_Texte=" & message_Texte & "&message_Date=" & message_Date
    message__modifier = requete.retour_ok()
End Function

Function message__modifier__message_Texte(ByVal Code_message As String, ByVal message_Texte As String) As Long
    Code_message = requete.convert_encode_url(Code_message)
    message_Texte = requete.convert_encode_url(message_Texte)
    requete.requete_serveur "message/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_message=" & Code_message & "&message_Texte=" & message_Texte
    message__modifier__message_Texte = requete.retour_ok()
End Function

Function message__modifier__message_Date(ByVal Code_message As String, ByVal message_Date As String) As Long
    Code_message = requete.convert_encode_url(Code_message)
    message_Date = requete.convert_encode_url(message_Date)
    requete.requete_serveur "message/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_message=" & Code_message & "&message_Date=" & message_Date
    message__modifier__message_Date = requete.retour_ok()
End Function

Function message__modifier__Code_messagerie(ByVal Code_message As String, ByVal Code_messagerie As String) As Long
    Code_message = requete.convert_encode_url(Code_message)
    Code_messagerie = requete.convert_encode_url(Code_messagerie)
    requete.requete_serveur "message/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_message=" & Code_message & "&Code_messagerie=" & Code_messagerie
    message__modifier__message_Texte = requete.retour_ok()
End Function

Function message__modifier__Code_joueur(ByVal Code_message As String, ByVal Code_joueur As String) As Long
    Code_message = requete.convert_encode_url(Code_message)
    Code_joueur = requete.convert_encode_url(Code_joueur)
    requete.requete_serveur "message/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_message=" & Code_message & "&Code_joueur=" & Code_joueur
    message__modifier__message_Date = requete.retour_ok()
End Function

Function message__supprimer(ByVal Code_message As String) As Long
    Code_message = requete.convert_encode_url(Code_message)
    requete.requete_serveur "message/supprimer.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_message=" & Code_message
    message__supprimer = requete.retour_ok()
End Function

Function message__lister(ByVal Code_messagerie As String, ByVal Code_joueur As String) As Long
    Code_messagerie = requete.convert_encode_url(Code_messagerie)
    Code_joueur = requete.convert_encode_url(Code_joueur)
    requete.requete_serveur "message/lister.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_messagerie=" & Code_messagerie & "&Code_joueur=" & Code_joueur
    message__lister = requete.retour_ok()
End Function

'   +-----------+
'   | parametre |
'   +-----------+

Function parametre__ajouter(ByVal parametre_Libelle As String, ByVal parametre_Valeur As String, ByVal parametre_Activable As String, ByVal parametre_Actif As String) As Long
    parametre_Libelle = requete.convert_encode_url(parametre_Libelle)
    parametre_Valeur = requete.convert_encode_url(parametre_Valeur)
    parametre_Activable = requete.convert_encode_url(parametre_Activable)
    parametre_Actif = requete.convert_encode_url(parametre_Actif)
    requete.requete_serveur "parametre/ajouter.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&parametre_Libelle=" & parametre_Libelle & "&parametre_Valeur=" & parametre_Valeur & "&parametre_Activable=" & parametre_Activable & "&parametre_Actif=" & parametre_Actif
    parametre__ajouter = requete.retour_ok()
End Function

Function parametre__modifier(ByVal Code_parametre As String, ByVal parametre_Libelle As String, ByVal parametre_Valeur As String, ByVal parametre_Activable As String, ByVal parametre_Actif As String) As Long
    Code_parametre = requete.convert_encode_url(Code_parametre)
    parametre_Libelle = requete.convert_encode_url(parametre_Libelle)
    parametre_Valeur = requete.convert_encode_url(parametre_Valeur)
    parametre_Activable = requete.convert_encode_url(parametre_Activable)
    parametre_Actif = requete.convert_encode_url(parametre_Actif)
    requete.requete_serveur "parametre/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_parametre=" & Code_parametre & "&parametre_Libelle=" & parametre_Libelle & "&parametre_Valeur=" & parametre_Valeur & "&parametre_Activable=" & parametre_Activable & "&parametre_Actif=" & parametre_Actif
    parametre__modifier = requete.retour_ok()
End Function

Function parametre__modifier__parametre_Libelle(ByVal Code_parametre As String, ByVal parametre_Libelle As String) As Long
    Code_parametre = requete.convert_encode_url(Code_parametre)
    parametre_Libelle = requete.convert_encode_url(parametre_Libelle)
    requete.requete_serveur "parametre/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_parametre=" & Code_parametre & "&parametre_Libelle=" & parametre_Libelle
    parametre__modifier__parametre_Libelle = requete.retour_ok()
End Function

Function parametre__modifier__parametre_Valeur(ByVal Code_parametre As String, ByVal parametre_Valeur As String) As Long
    Code_parametre = requete.convert_encode_url(Code_parametre)
    parametre_Valeur = requete.convert_encode_url(parametre_Valeur)
    requete.requete_serveur "parametre/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_parametre=" & Code_parametre & "&parametre_Valeur=" & parametre_Valeur
    parametre__modifier__parametre_Valeur = requete.retour_ok()
End Function

Function parametre__modifier__parametre_Activable(ByVal Code_parametre As String, ByVal parametre_Activable As String) As Long
    Code_parametre = requete.convert_encode_url(Code_parametre)
    parametre_Activable = requete.convert_encode_url(parametre_Activable)
    requete.requete_serveur "parametre/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_parametre=" & Code_parametre & "&parametre_Activable=" & parametre_Activable
    parametre__modifier__parametre_Activable = requete.retour_ok()
End Function

Function parametre__modifier__parametre_Actif(ByVal Code_parametre As String, ByVal parametre_Actif As String) As Long
    Code_parametre = requete.convert_encode_url(Code_parametre)
    parametre_Actif = requete.convert_encode_url(parametre_Actif)
    requete.requete_serveur "parametre/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_parametre=" & Code_parametre & "&parametre_Actif=" & parametre_Actif
    parametre__modifier__parametre_Actif = requete.retour_ok()
End Function

Function parametre__supprimer(ByVal Code_parametre As String) As Long
    Code_parametre = requete.convert_encode_url(Code_parametre)
    requete.requete_serveur "parametre/supprimer.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_parametre=" & Code_parametre
    parametre__supprimer = requete.retour_ok()
End Function

Function parametre__lister() As Long
    requete.requete_serveur "parametre/lister.php?" & "vue=tableau" & "&mf_token=" & mf_token
    parametre__lister = requete.retour_ok()
End Function

'   +--------+
'   | groupe |
'   +--------+

Function groupe__ajouter(ByVal Code_campagne As String, ByVal groupe_Nom As String, ByVal groupe_Description As String, ByVal groupe_Logo_Fichier As String, ByVal groupe_Effectif As String, ByVal groupe_Actif As String, ByVal groupe_Date_creation As String, ByVal groupe_Delai_suppression_jour As String, ByVal groupe_Suppression_active As String) As Long
    groupe_Nom = requete.convert_encode_url(groupe_Nom)
    groupe_Description = requete.convert_encode_url(groupe_Description)
    groupe_Logo_Fichier = requete.convert_encode_url(groupe_Logo_Fichier)
    groupe_Effectif = requete.convert_encode_url(groupe_Effectif)
    groupe_Actif = requete.convert_encode_url(groupe_Actif)
    groupe_Date_creation = requete.convert_encode_url(groupe_Date_creation)
    groupe_Delai_suppression_jour = requete.convert_encode_url(groupe_Delai_suppression_jour)
    groupe_Suppression_active = requete.convert_encode_url(groupe_Suppression_active)
    Code_campagne = requete.convert_encode_url(Code_campagne)
    requete.requete_serveur "groupe/ajouter.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_campagne=" & Code_campagne & "&groupe_Nom=" & groupe_Nom & "&groupe_Description=" & groupe_Description & "&groupe_Logo_Fichier=" & groupe_Logo_Fichier & "&groupe_Effectif=" & groupe_Effectif & "&groupe_Actif=" & groupe_Actif & "&groupe_Date_creation=" & groupe_Date_creation & "&groupe_Delai_suppression_jour=" & groupe_Delai_suppression_jour & "&groupe_Suppression_active=" & groupe_Suppression_active
    groupe__ajouter = requete.retour_ok()
End Function

Function groupe__modifier(ByVal Code_groupe As String, ByVal Code_campagne As String, ByVal groupe_Nom As String, ByVal groupe_Description As String, ByVal groupe_Logo_Fichier As String, ByVal groupe_Effectif As String, ByVal groupe_Actif As String, ByVal groupe_Date_creation As String, ByVal groupe_Delai_suppression_jour As String, ByVal groupe_Suppression_active As String) As Long
    Code_groupe = requete.convert_encode_url(Code_groupe)
    groupe_Nom = requete.convert_encode_url(groupe_Nom)
    groupe_Description = requete.convert_encode_url(groupe_Description)
    groupe_Logo_Fichier = requete.convert_encode_url(groupe_Logo_Fichier)
    groupe_Effectif = requete.convert_encode_url(groupe_Effectif)
    groupe_Actif = requete.convert_encode_url(groupe_Actif)
    groupe_Date_creation = requete.convert_encode_url(groupe_Date_creation)
    groupe_Delai_suppression_jour = requete.convert_encode_url(groupe_Delai_suppression_jour)
    groupe_Suppression_active = requete.convert_encode_url(groupe_Suppression_active)
    Code_campagne = requete.convert_encode_url(Code_campagne)
    requete.requete_serveur "groupe/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_groupe=" & Code_groupe & "&Code_campagne=" & Code_campagne & "&groupe_Nom=" & groupe_Nom & "&groupe_Description=" & groupe_Description & "&groupe_Logo_Fichier=" & groupe_Logo_Fichier & "&groupe_Effectif=" & groupe_Effectif & "&groupe_Actif=" & groupe_Actif & "&groupe_Date_creation=" & groupe_Date_creation & "&groupe_Delai_suppression_jour=" & groupe_Delai_suppression_jour & "&groupe_Suppression_active=" & groupe_Suppression_active
    groupe__modifier = requete.retour_ok()
End Function

Function groupe__modifier__groupe_Nom(ByVal Code_groupe As String, ByVal groupe_Nom As String) As Long
    Code_groupe = requete.convert_encode_url(Code_groupe)
    groupe_Nom = requete.convert_encode_url(groupe_Nom)
    requete.requete_serveur "groupe/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_groupe=" & Code_groupe & "&groupe_Nom=" & groupe_Nom
    groupe__modifier__groupe_Nom = requete.retour_ok()
End Function

Function groupe__modifier__groupe_Description(ByVal Code_groupe As String, ByVal groupe_Description As String) As Long
    Code_groupe = requete.convert_encode_url(Code_groupe)
    groupe_Description = requete.convert_encode_url(groupe_Description)
    requete.requete_serveur "groupe/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_groupe=" & Code_groupe & "&groupe_Description=" & groupe_Description
    groupe__modifier__groupe_Description = requete.retour_ok()
End Function

Function groupe__modifier__groupe_Logo_Fichier(ByVal Code_groupe As String, ByVal groupe_Logo_Fichier As String) As Long
    Code_groupe = requete.convert_encode_url(Code_groupe)
    groupe_Logo_Fichier = requete.convert_encode_url(groupe_Logo_Fichier)
    requete.requete_serveur "groupe/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_groupe=" & Code_groupe & "&groupe_Logo_Fichier=" & groupe_Logo_Fichier
    groupe__modifier__groupe_Logo_Fichier = requete.retour_ok()
End Function

Function groupe__modifier__groupe_Effectif(ByVal Code_groupe As String, ByVal groupe_Effectif As String) As Long
    Code_groupe = requete.convert_encode_url(Code_groupe)
    groupe_Effectif = requete.convert_encode_url(groupe_Effectif)
    requete.requete_serveur "groupe/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_groupe=" & Code_groupe & "&groupe_Effectif=" & groupe_Effectif
    groupe__modifier__groupe_Effectif = requete.retour_ok()
End Function

Function groupe__modifier__groupe_Actif(ByVal Code_groupe As String, ByVal groupe_Actif As String) As Long
    Code_groupe = requete.convert_encode_url(Code_groupe)
    groupe_Actif = requete.convert_encode_url(groupe_Actif)
    requete.requete_serveur "groupe/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_groupe=" & Code_groupe & "&groupe_Actif=" & groupe_Actif
    groupe__modifier__groupe_Actif = requete.retour_ok()
End Function

Function groupe__modifier__groupe_Date_creation(ByVal Code_groupe As String, ByVal groupe_Date_creation As String) As Long
    Code_groupe = requete.convert_encode_url(Code_groupe)
    groupe_Date_creation = requete.convert_encode_url(groupe_Date_creation)
    requete.requete_serveur "groupe/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_groupe=" & Code_groupe & "&groupe_Date_creation=" & groupe_Date_creation
    groupe__modifier__groupe_Date_creation = requete.retour_ok()
End Function

Function groupe__modifier__groupe_Delai_suppression_jour(ByVal Code_groupe As String, ByVal groupe_Delai_suppression_jour As String) As Long
    Code_groupe = requete.convert_encode_url(Code_groupe)
    groupe_Delai_suppression_jour = requete.convert_encode_url(groupe_Delai_suppression_jour)
    requete.requete_serveur "groupe/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_groupe=" & Code_groupe & "&groupe_Delai_suppression_jour=" & groupe_Delai_suppression_jour
    groupe__modifier__groupe_Delai_suppression_jour = requete.retour_ok()
End Function

Function groupe__modifier__groupe_Suppression_active(ByVal Code_groupe As String, ByVal groupe_Suppression_active As String) As Long
    Code_groupe = requete.convert_encode_url(Code_groupe)
    groupe_Suppression_active = requete.convert_encode_url(groupe_Suppression_active)
    requete.requete_serveur "groupe/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_groupe=" & Code_groupe & "&groupe_Suppression_active=" & groupe_Suppression_active
    groupe__modifier__groupe_Suppression_active = requete.retour_ok()
End Function

Function groupe__modifier__Code_campagne(ByVal Code_groupe As String, ByVal Code_campagne As String) As Long
    Code_groupe = requete.convert_encode_url(Code_groupe)
    Code_campagne = requete.convert_encode_url(Code_campagne)
    requete.requete_serveur "groupe/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_groupe=" & Code_groupe & "&Code_campagne=" & Code_campagne
    groupe__modifier__groupe_Nom = requete.retour_ok()
End Function

Function groupe__supprimer(ByVal Code_groupe As String) As Long
    Code_groupe = requete.convert_encode_url(Code_groupe)
    requete.requete_serveur "groupe/supprimer.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_groupe=" & Code_groupe
    groupe__supprimer = requete.retour_ok()
End Function

Function groupe__lister(ByVal Code_campagne As String) As Long
    Code_campagne = requete.convert_encode_url(Code_campagne)
    requete.requete_serveur "groupe/lister.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_campagne=" & Code_campagne
    groupe__lister = requete.retour_ok()
End Function

'   +------------+
'   | personnage |
'   +------------+

Function personnage__ajouter(ByVal Code_joueur As String, ByVal Code_groupe As String, ByVal personnage_Fichier_Fichier As String, ByVal personnage_Conservation As String) As Long
    personnage_Fichier_Fichier = requete.convert_encode_url(personnage_Fichier_Fichier)
    personnage_Conservation = requete.convert_encode_url(personnage_Conservation)
    Code_joueur = requete.convert_encode_url(Code_joueur)
    Code_groupe = requete.convert_encode_url(Code_groupe)
    requete.requete_serveur "personnage/ajouter.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_joueur=" & Code_joueur & "&Code_groupe=" & Code_groupe & "&personnage_Fichier_Fichier=" & personnage_Fichier_Fichier & "&personnage_Conservation=" & personnage_Conservation
    personnage__ajouter = requete.retour_ok()
End Function

Function personnage__modifier(ByVal Code_personnage As String, ByVal Code_joueur As String, ByVal Code_groupe As String, ByVal personnage_Fichier_Fichier As String, ByVal personnage_Conservation As String) As Long
    Code_personnage = requete.convert_encode_url(Code_personnage)
    personnage_Fichier_Fichier = requete.convert_encode_url(personnage_Fichier_Fichier)
    personnage_Conservation = requete.convert_encode_url(personnage_Conservation)
    Code_joueur = requete.convert_encode_url(Code_joueur)
    Code_groupe = requete.convert_encode_url(Code_groupe)
    requete.requete_serveur "personnage/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_personnage=" & Code_personnage & "&Code_joueur=" & Code_joueur & "&Code_groupe=" & Code_groupe & "&personnage_Fichier_Fichier=" & personnage_Fichier_Fichier & "&personnage_Conservation=" & personnage_Conservation
    personnage__modifier = requete.retour_ok()
End Function

Function personnage__modifier__personnage_Fichier_Fichier(ByVal Code_personnage As String, ByVal personnage_Fichier_Fichier As String) As Long
    Code_personnage = requete.convert_encode_url(Code_personnage)
    personnage_Fichier_Fichier = requete.convert_encode_url(personnage_Fichier_Fichier)
    requete.requete_serveur "personnage/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_personnage=" & Code_personnage & "&personnage_Fichier_Fichier=" & personnage_Fichier_Fichier
    personnage__modifier__personnage_Fichier_Fichier = requete.retour_ok()
End Function

Function personnage__modifier__personnage_Conservation(ByVal Code_personnage As String, ByVal personnage_Conservation As String) As Long
    Code_personnage = requete.convert_encode_url(Code_personnage)
    personnage_Conservation = requete.convert_encode_url(personnage_Conservation)
    requete.requete_serveur "personnage/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_personnage=" & Code_personnage & "&personnage_Conservation=" & personnage_Conservation
    personnage__modifier__personnage_Conservation = requete.retour_ok()
End Function

Function personnage__modifier__Code_joueur(ByVal Code_personnage As String, ByVal Code_joueur As String) As Long
    Code_personnage = requete.convert_encode_url(Code_personnage)
    Code_joueur = requete.convert_encode_url(Code_joueur)
    requete.requete_serveur "personnage/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_personnage=" & Code_personnage & "&Code_joueur=" & Code_joueur
    personnage__modifier__personnage_Fichier_Fichier = requete.retour_ok()
End Function

Function personnage__modifier__Code_groupe(ByVal Code_personnage As String, ByVal Code_groupe As String) As Long
    Code_personnage = requete.convert_encode_url(Code_personnage)
    Code_groupe = requete.convert_encode_url(Code_groupe)
    requete.requete_serveur "personnage/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_personnage=" & Code_personnage & "&Code_groupe=" & Code_groupe
    personnage__modifier__personnage_Conservation = requete.retour_ok()
End Function

Function personnage__supprimer(ByVal Code_personnage As String) As Long
    Code_personnage = requete.convert_encode_url(Code_personnage)
    requete.requete_serveur "personnage/supprimer.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_personnage=" & Code_personnage
    personnage__supprimer = requete.retour_ok()
End Function

Function personnage__lister(ByVal Code_joueur As String, ByVal Code_groupe As String) As Long
    Code_joueur = requete.convert_encode_url(Code_joueur)
    Code_groupe = requete.convert_encode_url(Code_groupe)
    requete.requete_serveur "personnage/lister.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_joueur=" & Code_joueur & "&Code_groupe=" & Code_groupe
    personnage__lister = requete.retour_ok()
End Function

'   +----------+
'   | campagne |
'   +----------+

Function campagne__ajouter(ByVal campagne_Nom As String, ByVal campagne_Description As String, ByVal campagne_Image_Fichier As String, ByVal campagne_Nombre_joueur As String, ByVal campagne_Nombre_mj As String) As Long
    campagne_Nom = requete.convert_encode_url(campagne_Nom)
    campagne_Description = requete.convert_encode_url(campagne_Description)
    campagne_Image_Fichier = requete.convert_encode_url(campagne_Image_Fichier)
    campagne_Nombre_joueur = requete.convert_encode_url(campagne_Nombre_joueur)
    campagne_Nombre_mj = requete.convert_encode_url(campagne_Nombre_mj)
    requete.requete_serveur "campagne/ajouter.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&campagne_Nom=" & campagne_Nom & "&campagne_Description=" & campagne_Description & "&campagne_Image_Fichier=" & campagne_Image_Fichier & "&campagne_Nombre_joueur=" & campagne_Nombre_joueur & "&campagne_Nombre_mj=" & campagne_Nombre_mj
    campagne__ajouter = requete.retour_ok()
End Function

Function campagne__modifier(ByVal Code_campagne As String, ByVal campagne_Nom As String, ByVal campagne_Description As String, ByVal campagne_Image_Fichier As String, ByVal campagne_Nombre_joueur As String, ByVal campagne_Nombre_mj As String) As Long
    Code_campagne = requete.convert_encode_url(Code_campagne)
    campagne_Nom = requete.convert_encode_url(campagne_Nom)
    campagne_Description = requete.convert_encode_url(campagne_Description)
    campagne_Image_Fichier = requete.convert_encode_url(campagne_Image_Fichier)
    campagne_Nombre_joueur = requete.convert_encode_url(campagne_Nombre_joueur)
    campagne_Nombre_mj = requete.convert_encode_url(campagne_Nombre_mj)
    requete.requete_serveur "campagne/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_campagne=" & Code_campagne & "&campagne_Nom=" & campagne_Nom & "&campagne_Description=" & campagne_Description & "&campagne_Image_Fichier=" & campagne_Image_Fichier & "&campagne_Nombre_joueur=" & campagne_Nombre_joueur & "&campagne_Nombre_mj=" & campagne_Nombre_mj
    campagne__modifier = requete.retour_ok()
End Function

Function campagne__modifier__campagne_Nom(ByVal Code_campagne As String, ByVal campagne_Nom As String) As Long
    Code_campagne = requete.convert_encode_url(Code_campagne)
    campagne_Nom = requete.convert_encode_url(campagne_Nom)
    requete.requete_serveur "campagne/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_campagne=" & Code_campagne & "&campagne_Nom=" & campagne_Nom
    campagne__modifier__campagne_Nom = requete.retour_ok()
End Function

Function campagne__modifier__campagne_Description(ByVal Code_campagne As String, ByVal campagne_Description As String) As Long
    Code_campagne = requete.convert_encode_url(Code_campagne)
    campagne_Description = requete.convert_encode_url(campagne_Description)
    requete.requete_serveur "campagne/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_campagne=" & Code_campagne & "&campagne_Description=" & campagne_Description
    campagne__modifier__campagne_Description = requete.retour_ok()
End Function

Function campagne__modifier__campagne_Image_Fichier(ByVal Code_campagne As String, ByVal campagne_Image_Fichier As String) As Long
    Code_campagne = requete.convert_encode_url(Code_campagne)
    campagne_Image_Fichier = requete.convert_encode_url(campagne_Image_Fichier)
    requete.requete_serveur "campagne/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_campagne=" & Code_campagne & "&campagne_Image_Fichier=" & campagne_Image_Fichier
    campagne__modifier__campagne_Image_Fichier = requete.retour_ok()
End Function

Function campagne__modifier__campagne_Nombre_joueur(ByVal Code_campagne As String, ByVal campagne_Nombre_joueur As String) As Long
    Code_campagne = requete.convert_encode_url(Code_campagne)
    campagne_Nombre_joueur = requete.convert_encode_url(campagne_Nombre_joueur)
    requete.requete_serveur "campagne/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_campagne=" & Code_campagne & "&campagne_Nombre_joueur=" & campagne_Nombre_joueur
    campagne__modifier__campagne_Nombre_joueur = requete.retour_ok()
End Function

Function campagne__modifier__campagne_Nombre_mj(ByVal Code_campagne As String, ByVal campagne_Nombre_mj As String) As Long
    Code_campagne = requete.convert_encode_url(Code_campagne)
    campagne_Nombre_mj = requete.convert_encode_url(campagne_Nombre_mj)
    requete.requete_serveur "campagne/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_campagne=" & Code_campagne & "&campagne_Nombre_mj=" & campagne_Nombre_mj
    campagne__modifier__campagne_Nombre_mj = requete.retour_ok()
End Function

Function campagne__supprimer(ByVal Code_campagne As String) As Long
    Code_campagne = requete.convert_encode_url(Code_campagne)
    requete.requete_serveur "campagne/supprimer.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_campagne=" & Code_campagne
    campagne__supprimer = requete.retour_ok()
End Function

Function campagne__lister() As Long
    requete.requete_serveur "campagne/lister.php?" & "vue=tableau" & "&mf_token=" & mf_token
    campagne__lister = requete.retour_ok()
End Function

'   +--------------+
'   | tag_campagne |
'   +--------------+

Function tag_campagne__ajouter(ByVal tag_campagne_Libelle As String) As Long
    tag_campagne_Libelle = requete.convert_encode_url(tag_campagne_Libelle)
    requete.requete_serveur "tag_campagne/ajouter.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&tag_campagne_Libelle=" & tag_campagne_Libelle
    tag_campagne__ajouter = requete.retour_ok()
End Function

Function tag_campagne__modifier(ByVal Code_tag_campagne As String, ByVal tag_campagne_Libelle As String) As Long
    Code_tag_campagne = requete.convert_encode_url(Code_tag_campagne)
    tag_campagne_Libelle = requete.convert_encode_url(tag_campagne_Libelle)
    requete.requete_serveur "tag_campagne/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_tag_campagne=" & Code_tag_campagne & "&tag_campagne_Libelle=" & tag_campagne_Libelle
    tag_campagne__modifier = requete.retour_ok()
End Function

Function tag_campagne__modifier__tag_campagne_Libelle(ByVal Code_tag_campagne As String, ByVal tag_campagne_Libelle As String) As Long
    Code_tag_campagne = requete.convert_encode_url(Code_tag_campagne)
    tag_campagne_Libelle = requete.convert_encode_url(tag_campagne_Libelle)
    requete.requete_serveur "tag_campagne/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_tag_campagne=" & Code_tag_campagne & "&tag_campagne_Libelle=" & tag_campagne_Libelle
    tag_campagne__modifier__tag_campagne_Libelle = requete.retour_ok()
End Function

Function tag_campagne__supprimer(ByVal Code_tag_campagne As String) As Long
    Code_tag_campagne = requete.convert_encode_url(Code_tag_campagne)
    requete.requete_serveur "tag_campagne/supprimer.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_tag_campagne=" & Code_tag_campagne
    tag_campagne__supprimer = requete.retour_ok()
End Function

Function tag_campagne__lister() As Long
    requete.requete_serveur "tag_campagne/lister.php?" & "vue=tableau" & "&mf_token=" & mf_token
    tag_campagne__lister = requete.retour_ok()
End Function

'   +-------+
'   | carte |
'   +-------+

Function carte__ajouter(ByVal Code_groupe As String, ByVal carte_Nom As String, ByVal carte_Hauteur As String, ByVal carte_Largeur As String, ByVal carte_Fichier As String) As Long
    carte_Nom = requete.convert_encode_url(carte_Nom)
    carte_Hauteur = requete.convert_encode_url(carte_Hauteur)
    carte_Largeur = requete.convert_encode_url(carte_Largeur)
    carte_Fichier = requete.convert_encode_url(carte_Fichier)
    Code_groupe = requete.convert_encode_url(Code_groupe)
    requete.requete_serveur "carte/ajouter.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_groupe=" & Code_groupe & "&carte_Nom=" & carte_Nom & "&carte_Hauteur=" & carte_Hauteur & "&carte_Largeur=" & carte_Largeur & "&carte_Fichier=" & carte_Fichier
    carte__ajouter = requete.retour_ok()
End Function

Function carte__modifier(ByVal Code_carte As String, ByVal Code_groupe As String, ByVal carte_Nom As String, ByVal carte_Hauteur As String, ByVal carte_Largeur As String, ByVal carte_Fichier As String) As Long
    Code_carte = requete.convert_encode_url(Code_carte)
    carte_Nom = requete.convert_encode_url(carte_Nom)
    carte_Hauteur = requete.convert_encode_url(carte_Hauteur)
    carte_Largeur = requete.convert_encode_url(carte_Largeur)
    carte_Fichier = requete.convert_encode_url(carte_Fichier)
    Code_groupe = requete.convert_encode_url(Code_groupe)
    requete.requete_serveur "carte/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_carte=" & Code_carte & "&Code_groupe=" & Code_groupe & "&carte_Nom=" & carte_Nom & "&carte_Hauteur=" & carte_Hauteur & "&carte_Largeur=" & carte_Largeur & "&carte_Fichier=" & carte_Fichier
    carte__modifier = requete.retour_ok()
End Function

Function carte__modifier__carte_Nom(ByVal Code_carte As String, ByVal carte_Nom As String) As Long
    Code_carte = requete.convert_encode_url(Code_carte)
    carte_Nom = requete.convert_encode_url(carte_Nom)
    requete.requete_serveur "carte/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_carte=" & Code_carte & "&carte_Nom=" & carte_Nom
    carte__modifier__carte_Nom = requete.retour_ok()
End Function

Function carte__modifier__carte_Hauteur(ByVal Code_carte As String, ByVal carte_Hauteur As String) As Long
    Code_carte = requete.convert_encode_url(Code_carte)
    carte_Hauteur = requete.convert_encode_url(carte_Hauteur)
    requete.requete_serveur "carte/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_carte=" & Code_carte & "&carte_Hauteur=" & carte_Hauteur
    carte__modifier__carte_Hauteur = requete.retour_ok()
End Function

Function carte__modifier__carte_Largeur(ByVal Code_carte As String, ByVal carte_Largeur As String) As Long
    Code_carte = requete.convert_encode_url(Code_carte)
    carte_Largeur = requete.convert_encode_url(carte_Largeur)
    requete.requete_serveur "carte/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_carte=" & Code_carte & "&carte_Largeur=" & carte_Largeur
    carte__modifier__carte_Largeur = requete.retour_ok()
End Function

Function carte__modifier__carte_Fichier(ByVal Code_carte As String, ByVal carte_Fichier As String) As Long
    Code_carte = requete.convert_encode_url(Code_carte)
    carte_Fichier = requete.convert_encode_url(carte_Fichier)
    requete.requete_serveur "carte/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_carte=" & Code_carte & "&carte_Fichier=" & carte_Fichier
    carte__modifier__carte_Fichier = requete.retour_ok()
End Function

Function carte__modifier__Code_groupe(ByVal Code_carte As String, ByVal Code_groupe As String) As Long
    Code_carte = requete.convert_encode_url(Code_carte)
    Code_groupe = requete.convert_encode_url(Code_groupe)
    requete.requete_serveur "carte/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_carte=" & Code_carte & "&Code_groupe=" & Code_groupe
    carte__modifier__carte_Nom = requete.retour_ok()
End Function

Function carte__supprimer(ByVal Code_carte As String) As Long
    Code_carte = requete.convert_encode_url(Code_carte)
    requete.requete_serveur "carte/supprimer.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_carte=" & Code_carte
    carte__supprimer = requete.retour_ok()
End Function

Function carte__lister(ByVal Code_groupe As String) As Long
    Code_groupe = requete.convert_encode_url(Code_groupe)
    requete.requete_serveur "carte/lister.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_groupe=" & Code_groupe
    carte__lister = requete.retour_ok()
End Function

'   +-------+
'   | objet |
'   +-------+

Function objet__ajouter(ByVal Code_type As String, ByVal objet_Libelle As String, ByVal objet_Image_Fichier As String) As Long
    objet_Libelle = requete.convert_encode_url(objet_Libelle)
    objet_Image_Fichier = requete.convert_encode_url(objet_Image_Fichier)
    Code_type = requete.convert_encode_url(Code_type)
    requete.requete_serveur "objet/ajouter.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_type=" & Code_type & "&objet_Libelle=" & objet_Libelle & "&objet_Image_Fichier=" & objet_Image_Fichier
    objet__ajouter = requete.retour_ok()
End Function

Function objet__modifier(ByVal Code_objet As String, ByVal Code_type As String, ByVal objet_Libelle As String, ByVal objet_Image_Fichier As String) As Long
    Code_objet = requete.convert_encode_url(Code_objet)
    objet_Libelle = requete.convert_encode_url(objet_Libelle)
    objet_Image_Fichier = requete.convert_encode_url(objet_Image_Fichier)
    Code_type = requete.convert_encode_url(Code_type)
    requete.requete_serveur "objet/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_objet=" & Code_objet & "&Code_type=" & Code_type & "&objet_Libelle=" & objet_Libelle & "&objet_Image_Fichier=" & objet_Image_Fichier
    objet__modifier = requete.retour_ok()
End Function

Function objet__modifier__objet_Libelle(ByVal Code_objet As String, ByVal objet_Libelle As String) As Long
    Code_objet = requete.convert_encode_url(Code_objet)
    objet_Libelle = requete.convert_encode_url(objet_Libelle)
    requete.requete_serveur "objet/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_objet=" & Code_objet & "&objet_Libelle=" & objet_Libelle
    objet__modifier__objet_Libelle = requete.retour_ok()
End Function

Function objet__modifier__objet_Image_Fichier(ByVal Code_objet As String, ByVal objet_Image_Fichier As String) As Long
    Code_objet = requete.convert_encode_url(Code_objet)
    objet_Image_Fichier = requete.convert_encode_url(objet_Image_Fichier)
    requete.requete_serveur "objet/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_objet=" & Code_objet & "&objet_Image_Fichier=" & objet_Image_Fichier
    objet__modifier__objet_Image_Fichier = requete.retour_ok()
End Function

Function objet__modifier__Code_type(ByVal Code_objet As String, ByVal Code_type As String) As Long
    Code_objet = requete.convert_encode_url(Code_objet)
    Code_type = requete.convert_encode_url(Code_type)
    requete.requete_serveur "objet/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_objet=" & Code_objet & "&Code_type=" & Code_type
    objet__modifier__objet_Libelle = requete.retour_ok()
End Function

Function objet__supprimer(ByVal Code_objet As String) As Long
    Code_objet = requete.convert_encode_url(Code_objet)
    requete.requete_serveur "objet/supprimer.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_objet=" & Code_objet
    objet__supprimer = requete.retour_ok()
End Function

Function objet__lister(ByVal Code_type As String) As Long
    Code_type = requete.convert_encode_url(Code_type)
    requete.requete_serveur "objet/lister.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_type=" & Code_type
    objet__lister = requete.retour_ok()
End Function

'   +------+
'   | type |
'   +------+

Function type__ajouter(ByVal Code_ressource As String, ByVal type_Libelle As String) As Long
    type_Libelle = requete.convert_encode_url(type_Libelle)
    Code_ressource = requete.convert_encode_url(Code_ressource)
    requete.requete_serveur "type/ajouter.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_ressource=" & Code_ressource & "&type_Libelle=" & type_Libelle
    type__ajouter = requete.retour_ok()
End Function

Function type__modifier(ByVal Code_type As String, ByVal Code_ressource As String, ByVal type_Libelle As String) As Long
    Code_type = requete.convert_encode_url(Code_type)
    type_Libelle = requete.convert_encode_url(type_Libelle)
    Code_ressource = requete.convert_encode_url(Code_ressource)
    requete.requete_serveur "type/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_type=" & Code_type & "&Code_ressource=" & Code_ressource & "&type_Libelle=" & type_Libelle
    type__modifier = requete.retour_ok()
End Function

Function type__modifier__type_Libelle(ByVal Code_type As String, ByVal type_Libelle As String) As Long
    Code_type = requete.convert_encode_url(Code_type)
    type_Libelle = requete.convert_encode_url(type_Libelle)
    requete.requete_serveur "type/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_type=" & Code_type & "&type_Libelle=" & type_Libelle
    type__modifier__type_Libelle = requete.retour_ok()
End Function

Function type__modifier__Code_ressource(ByVal Code_type As String, ByVal Code_ressource As String) As Long
    Code_type = requete.convert_encode_url(Code_type)
    Code_ressource = requete.convert_encode_url(Code_ressource)
    requete.requete_serveur "type/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_type=" & Code_type & "&Code_ressource=" & Code_ressource
    type__modifier__type_Libelle = requete.retour_ok()
End Function

Function type__supprimer(ByVal Code_type As String) As Long
    Code_type = requete.convert_encode_url(Code_type)
    requete.requete_serveur "type/supprimer.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_type=" & Code_type
    type__supprimer = requete.retour_ok()
End Function

Function type__lister(ByVal Code_ressource As String) As Long
    Code_ressource = requete.convert_encode_url(Code_ressource)
    requete.requete_serveur "type/lister.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_ressource=" & Code_ressource
    type__lister = requete.retour_ok()
End Function

'   +-----------+
'   | ressource |
'   +-----------+

Function ressource__ajouter(ByVal ressource_Nom As String) As Long
    ressource_Nom = requete.convert_encode_url(ressource_Nom)
    requete.requete_serveur "ressource/ajouter.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&ressource_Nom=" & ressource_Nom
    ressource__ajouter = requete.retour_ok()
End Function

Function ressource__modifier(ByVal Code_ressource As String, ByVal ressource_Nom As String) As Long
    Code_ressource = requete.convert_encode_url(Code_ressource)
    ressource_Nom = requete.convert_encode_url(ressource_Nom)
    requete.requete_serveur "ressource/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_ressource=" & Code_ressource & "&ressource_Nom=" & ressource_Nom
    ressource__modifier = requete.retour_ok()
End Function

Function ressource__modifier__ressource_Nom(ByVal Code_ressource As String, ByVal ressource_Nom As String) As Long
    Code_ressource = requete.convert_encode_url(Code_ressource)
    ressource_Nom = requete.convert_encode_url(ressource_Nom)
    requete.requete_serveur "ressource/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_ressource=" & Code_ressource & "&ressource_Nom=" & ressource_Nom
    ressource__modifier__ressource_Nom = requete.retour_ok()
End Function

Function ressource__supprimer(ByVal Code_ressource As String) As Long
    Code_ressource = requete.convert_encode_url(Code_ressource)
    requete.requete_serveur "ressource/supprimer.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_ressource=" & Code_ressource
    ressource__supprimer = requete.retour_ok()
End Function

Function ressource__lister() As Long
    requete.requete_serveur "ressource/lister.php?" & "vue=tableau" & "&mf_token=" & mf_token
    ressource__lister = requete.retour_ok()
End Function

'   +---------------+
'   | tag_ressource |
'   +---------------+

Function tag_ressource__ajouter(ByVal tag_ressource_Libelle As String) As Long
    tag_ressource_Libelle = requete.convert_encode_url(tag_ressource_Libelle)
    requete.requete_serveur "tag_ressource/ajouter.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&tag_ressource_Libelle=" & tag_ressource_Libelle
    tag_ressource__ajouter = requete.retour_ok()
End Function

Function tag_ressource__modifier(ByVal Code_tag_ressource As String, ByVal tag_ressource_Libelle As String) As Long
    Code_tag_ressource = requete.convert_encode_url(Code_tag_ressource)
    tag_ressource_Libelle = requete.convert_encode_url(tag_ressource_Libelle)
    requete.requete_serveur "tag_ressource/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_tag_ressource=" & Code_tag_ressource & "&tag_ressource_Libelle=" & tag_ressource_Libelle
    tag_ressource__modifier = requete.retour_ok()
End Function

Function tag_ressource__modifier__tag_ressource_Libelle(ByVal Code_tag_ressource As String, ByVal tag_ressource_Libelle As String) As Long
    Code_tag_ressource = requete.convert_encode_url(Code_tag_ressource)
    tag_ressource_Libelle = requete.convert_encode_url(tag_ressource_Libelle)
    requete.requete_serveur "tag_ressource/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_tag_ressource=" & Code_tag_ressource & "&tag_ressource_Libelle=" & tag_ressource_Libelle
    tag_ressource__modifier__tag_ressource_Libelle = requete.retour_ok()
End Function

Function tag_ressource__supprimer(ByVal Code_tag_ressource As String) As Long
    Code_tag_ressource = requete.convert_encode_url(Code_tag_ressource)
    requete.requete_serveur "tag_ressource/supprimer.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_tag_ressource=" & Code_tag_ressource
    tag_ressource__supprimer = requete.retour_ok()
End Function

Function tag_ressource__lister() As Long
    requete.requete_serveur "tag_ressource/lister.php?" & "vue=tableau" & "&mf_token=" & mf_token
    tag_ressource__lister = requete.retour_ok()
End Function

'   +------------+
'   | messagerie |
'   +------------+

Function messagerie__ajouter(ByVal Code_joueur As String, ByVal messagerie_Nom As String) As Long
    messagerie_Nom = requete.convert_encode_url(messagerie_Nom)
    Code_joueur = requete.convert_encode_url(Code_joueur)
    requete.requete_serveur "messagerie/ajouter.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_joueur=" & Code_joueur & "&messagerie_Nom=" & messagerie_Nom
    messagerie__ajouter = requete.retour_ok()
End Function

Function messagerie__modifier(ByVal Code_messagerie As String, ByVal Code_joueur As String, ByVal messagerie_Nom As String) As Long
    Code_messagerie = requete.convert_encode_url(Code_messagerie)
    messagerie_Nom = requete.convert_encode_url(messagerie_Nom)
    Code_joueur = requete.convert_encode_url(Code_joueur)
    requete.requete_serveur "messagerie/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_messagerie=" & Code_messagerie & "&Code_joueur=" & Code_joueur & "&messagerie_Nom=" & messagerie_Nom
    messagerie__modifier = requete.retour_ok()
End Function

Function messagerie__modifier__messagerie_Nom(ByVal Code_messagerie As String, ByVal messagerie_Nom As String) As Long
    Code_messagerie = requete.convert_encode_url(Code_messagerie)
    messagerie_Nom = requete.convert_encode_url(messagerie_Nom)
    requete.requete_serveur "messagerie/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_messagerie=" & Code_messagerie & "&messagerie_Nom=" & messagerie_Nom
    messagerie__modifier__messagerie_Nom = requete.retour_ok()
End Function

Function messagerie__modifier__Code_joueur(ByVal Code_messagerie As String, ByVal Code_joueur As String) As Long
    Code_messagerie = requete.convert_encode_url(Code_messagerie)
    Code_joueur = requete.convert_encode_url(Code_joueur)
    requete.requete_serveur "messagerie/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_messagerie=" & Code_messagerie & "&Code_joueur=" & Code_joueur
    messagerie__modifier__messagerie_Nom = requete.retour_ok()
End Function

Function messagerie__supprimer(ByVal Code_messagerie As String) As Long
    Code_messagerie = requete.convert_encode_url(Code_messagerie)
    requete.requete_serveur "messagerie/supprimer.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_messagerie=" & Code_messagerie
    messagerie__supprimer = requete.retour_ok()
End Function

Function messagerie__lister(ByVal Code_joueur As String) As Long
    Code_joueur = requete.convert_encode_url(Code_joueur)
    requete.requete_serveur "messagerie/lister.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_joueur=" & Code_joueur
    messagerie__lister = requete.retour_ok()
End Function

'   +----------------+
'   | liste_contacts |
'   +----------------+

Function liste_contacts__ajouter(ByVal Code_joueur As String, ByVal liste_contacts_Nom As String) As Long
    liste_contacts_Nom = requete.convert_encode_url(liste_contacts_Nom)
    Code_joueur = requete.convert_encode_url(Code_joueur)
    requete.requete_serveur "liste_contacts/ajouter.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_joueur=" & Code_joueur & "&liste_contacts_Nom=" & liste_contacts_Nom
    liste_contacts__ajouter = requete.retour_ok()
End Function

Function liste_contacts__modifier(ByVal Code_liste_contacts As String, ByVal Code_joueur As String, ByVal liste_contacts_Nom As String) As Long
    Code_liste_contacts = requete.convert_encode_url(Code_liste_contacts)
    liste_contacts_Nom = requete.convert_encode_url(liste_contacts_Nom)
    Code_joueur = requete.convert_encode_url(Code_joueur)
    requete.requete_serveur "liste_contacts/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_liste_contacts=" & Code_liste_contacts & "&Code_joueur=" & Code_joueur & "&liste_contacts_Nom=" & liste_contacts_Nom
    liste_contacts__modifier = requete.retour_ok()
End Function

Function liste_contacts__modifier__liste_contacts_Nom(ByVal Code_liste_contacts As String, ByVal liste_contacts_Nom As String) As Long
    Code_liste_contacts = requete.convert_encode_url(Code_liste_contacts)
    liste_contacts_Nom = requete.convert_encode_url(liste_contacts_Nom)
    requete.requete_serveur "liste_contacts/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_liste_contacts=" & Code_liste_contacts & "&liste_contacts_Nom=" & liste_contacts_Nom
    liste_contacts__modifier__liste_contacts_Nom = requete.retour_ok()
End Function

Function liste_contacts__modifier__Code_joueur(ByVal Code_liste_contacts As String, ByVal Code_joueur As String) As Long
    Code_liste_contacts = requete.convert_encode_url(Code_liste_contacts)
    Code_joueur = requete.convert_encode_url(Code_joueur)
    requete.requete_serveur "liste_contacts/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_liste_contacts=" & Code_liste_contacts & "&Code_joueur=" & Code_joueur
    liste_contacts__modifier__liste_contacts_Nom = requete.retour_ok()
End Function

Function liste_contacts__supprimer(ByVal Code_liste_contacts As String) As Long
    Code_liste_contacts = requete.convert_encode_url(Code_liste_contacts)
    requete.requete_serveur "liste_contacts/supprimer.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_liste_contacts=" & Code_liste_contacts
    liste_contacts__supprimer = requete.retour_ok()
End Function

Function liste_contacts__lister(ByVal Code_joueur As String) As Long
    Code_joueur = requete.convert_encode_url(Code_joueur)
    requete.requete_serveur "liste_contacts/lister.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_joueur=" & Code_joueur
    liste_contacts__lister = requete.retour_ok()
End Function

'   +--------------------+
'   | a_joueur_parametre |
'   +--------------------+

Function a_joueur_parametre__ajouter(ByVal Code_joueur As String, ByVal Code_parametre As String) As Long
    Code_joueur = requete.convert_encode_url(Code_joueur)
    Code_parametre = requete.convert_encode_url(Code_parametre)
    requete.requete_serveur "a_joueur_parametre/ajouter.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_joueur=" & Code_joueur & "&Code_parametre=" & Code_parametre
    a_joueur_parametre__ajouter = requete.retour_ok()
End Function

Function a_joueur_parametre__modifier(ByVal Code_joueur As String, ByVal Code_parametre As String) As Long
    Code_a_joueur_parametre = requete.convert_encode_url(Code_a_joueur_parametre)
    Code_joueur = requete.convert_encode_url(Code_joueur)
    Code_parametre = requete.convert_encode_url(Code_parametre)
    requete.requete_serveur "a_joueur_parametre/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_joueur=" & Code_joueur & "&Code_parametre=" & Code_parametre
    a_joueur_parametre__modifier = requete.retour_ok()
End Function

Function a_joueur_parametre__supprimer(ByVal Code_joueur As String, ByVal Code_parametre As String) As Long
    Code_joueur = requete.convert_encode_url(Code_joueur)
    Code_parametre = requete.convert_encode_url(Code_parametre)
    requete.requete_serveur "a_joueur_parametre/supprimer.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_joueur=" & Code_joueur & "&Code_parametre=" & Code_parametre
    a_joueur_parametre__supprimer = requete.retour_ok()
End Function

Function a_joueur_parametre__lister(ByVal Code_joueur As String, ByVal Code_parametre As String) As Long
    Code_joueur = requete.convert_encode_url(Code_joueur)
    Code_parametre = requete.convert_encode_url(Code_parametre)
    requete.requete_serveur "a_joueur_parametre/lister.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_joueur=" & Code_joueur & "&Code_parametre=" & Code_parametre
    a_joueur_parametre__lister = requete.retour_ok()
End Function

'   +-----------------------------+
'   | a_candidature_joueur_groupe |
'   +-----------------------------+

Function a_candidature_joueur_groupe__ajouter(ByVal Code_joueur As String, ByVal Code_groupe As String, ByVal a_candidature_joueur_groupe_Message As String, ByVal a_candidature_joueur_groupe_Date_envoi As String) As Long
    a_candidature_joueur_groupe_Message = requete.convert_encode_url(a_candidature_joueur_groupe_Message)
    a_candidature_joueur_groupe_Date_envoi = requete.convert_encode_url(a_candidature_joueur_groupe_Date_envoi)
    Code_joueur = requete.convert_encode_url(Code_joueur)
    Code_groupe = requete.convert_encode_url(Code_groupe)
    requete.requete_serveur "a_candidature_joueur_groupe/ajouter.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_joueur=" & Code_joueur & "&Code_groupe=" & Code_groupe & "&a_candidature_joueur_groupe_Message=" & a_candidature_joueur_groupe_Message & "&a_candidature_joueur_groupe_Date_envoi=" & a_candidature_joueur_groupe_Date_envoi
    a_candidature_joueur_groupe__ajouter = requete.retour_ok()
End Function

Function a_candidature_joueur_groupe__modifier(ByVal Code_joueur As String, ByVal Code_groupe As String, ByVal a_candidature_joueur_groupe_Message As String, ByVal a_candidature_joueur_groupe_Date_envoi As String) As Long
    Code_a_candidature_joueur_groupe = requete.convert_encode_url(Code_a_candidature_joueur_groupe)
    a_candidature_joueur_groupe_Message = requete.convert_encode_url(a_candidature_joueur_groupe_Message)
    a_candidature_joueur_groupe_Date_envoi = requete.convert_encode_url(a_candidature_joueur_groupe_Date_envoi)
    Code_joueur = requete.convert_encode_url(Code_joueur)
    Code_groupe = requete.convert_encode_url(Code_groupe)
    requete.requete_serveur "a_candidature_joueur_groupe/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_joueur=" & Code_joueur & "&Code_groupe=" & Code_groupe & "&a_candidature_joueur_groupe_Message=" & a_candidature_joueur_groupe_Message & "&a_candidature_joueur_groupe_Date_envoi=" & a_candidature_joueur_groupe_Date_envoi
    a_candidature_joueur_groupe__modifier = requete.retour_ok()
End Function

Function a_candidature_joueur_groupe__modifier__a_candidature_joueur_groupe_Message(ByVal Code_joueur As String, ByVal Code_groupe As String, ByVal a_candidature_joueur_groupe_Message As String) As Long
    Code_joueur = requete.convert_encode_url(Code_joueur)
    Code_groupe = requete.convert_encode_url(Code_groupe)
    a_candidature_joueur_groupe_Message = requete.convert_encode_url(a_candidature_joueur_groupe_Message)
    requete.requete_serveur "a_candidature_joueur_groupe/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_joueur=" & Code_joueur & "&Code_groupe=" & Code_groupe & "&a_candidature_joueur_groupe_Message=" & a_candidature_joueur_groupe_Message
    a_candidature_joueur_groupe__modifier__a_candidature_joueur_groupe_Message = requete.retour_ok()
End Function

Function a_candidature_joueur_groupe__modifier__a_candidature_joueur_groupe_Date_envoi(ByVal Code_joueur As String, ByVal Code_groupe As String, ByVal a_candidature_joueur_groupe_Date_envoi As String) As Long
    Code_joueur = requete.convert_encode_url(Code_joueur)
    Code_groupe = requete.convert_encode_url(Code_groupe)
    a_candidature_joueur_groupe_Date_envoi = requete.convert_encode_url(a_candidature_joueur_groupe_Date_envoi)
    requete.requete_serveur "a_candidature_joueur_groupe/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_joueur=" & Code_joueur & "&Code_groupe=" & Code_groupe & "&a_candidature_joueur_groupe_Date_envoi=" & a_candidature_joueur_groupe_Date_envoi
    a_candidature_joueur_groupe__modifier__a_candidature_joueur_groupe_Date_envoi = requete.retour_ok()
End Function

Function a_candidature_joueur_groupe__supprimer(ByVal Code_joueur As String, ByVal Code_groupe As String) As Long
    Code_joueur = requete.convert_encode_url(Code_joueur)
    Code_groupe = requete.convert_encode_url(Code_groupe)
    requete.requete_serveur "a_candidature_joueur_groupe/supprimer.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_joueur=" & Code_joueur & "&Code_groupe=" & Code_groupe
    a_candidature_joueur_groupe__supprimer = requete.retour_ok()
End Function

Function a_candidature_joueur_groupe__lister(ByVal Code_joueur As String, ByVal Code_groupe As String) As Long
    Code_joueur = requete.convert_encode_url(Code_joueur)
    Code_groupe = requete.convert_encode_url(Code_groupe)
    requete.requete_serveur "a_candidature_joueur_groupe/lister.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_joueur=" & Code_joueur & "&Code_groupe=" & Code_groupe
    a_candidature_joueur_groupe__lister = requete.retour_ok()
End Function

'   +------------------------+
'   | a_membre_joueur_groupe |
'   +------------------------+

Function a_membre_joueur_groupe__ajouter(ByVal Code_groupe As String, ByVal Code_joueur As String, ByVal a_membre_joueur_groupe_Surnom As String, ByVal a_membre_joueur_groupe_Grade As String, ByVal a_membre_joueur_groupe_Date_adhesion As String) As Long
    a_membre_joueur_groupe_Surnom = requete.convert_encode_url(a_membre_joueur_groupe_Surnom)
    a_membre_joueur_groupe_Grade = requete.convert_encode_url(a_membre_joueur_groupe_Grade)
    a_membre_joueur_groupe_Date_adhesion = requete.convert_encode_url(a_membre_joueur_groupe_Date_adhesion)
    Code_groupe = requete.convert_encode_url(Code_groupe)
    Code_joueur = requete.convert_encode_url(Code_joueur)
    requete.requete_serveur "a_membre_joueur_groupe/ajouter.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_groupe=" & Code_groupe & "&Code_joueur=" & Code_joueur & "&a_membre_joueur_groupe_Surnom=" & a_membre_joueur_groupe_Surnom & "&a_membre_joueur_groupe_Grade=" & a_membre_joueur_groupe_Grade & "&a_membre_joueur_groupe_Date_adhesion=" & a_membre_joueur_groupe_Date_adhesion
    a_membre_joueur_groupe__ajouter = requete.retour_ok()
End Function

Function a_membre_joueur_groupe__modifier(ByVal Code_groupe As String, ByVal Code_joueur As String, ByVal a_membre_joueur_groupe_Surnom As String, ByVal a_membre_joueur_groupe_Grade As String, ByVal a_membre_joueur_groupe_Date_adhesion As String) As Long
    Code_a_membre_joueur_groupe = requete.convert_encode_url(Code_a_membre_joueur_groupe)
    a_membre_joueur_groupe_Surnom = requete.convert_encode_url(a_membre_joueur_groupe_Surnom)
    a_membre_joueur_groupe_Grade = requete.convert_encode_url(a_membre_joueur_groupe_Grade)
    a_membre_joueur_groupe_Date_adhesion = requete.convert_encode_url(a_membre_joueur_groupe_Date_adhesion)
    Code_groupe = requete.convert_encode_url(Code_groupe)
    Code_joueur = requete.convert_encode_url(Code_joueur)
    requete.requete_serveur "a_membre_joueur_groupe/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_groupe=" & Code_groupe & "&Code_joueur=" & Code_joueur & "&a_membre_joueur_groupe_Surnom=" & a_membre_joueur_groupe_Surnom & "&a_membre_joueur_groupe_Grade=" & a_membre_joueur_groupe_Grade & "&a_membre_joueur_groupe_Date_adhesion=" & a_membre_joueur_groupe_Date_adhesion
    a_membre_joueur_groupe__modifier = requete.retour_ok()
End Function

Function a_membre_joueur_groupe__modifier__a_membre_joueur_groupe_Surnom(ByVal Code_groupe As String, ByVal Code_joueur As String, ByVal a_membre_joueur_groupe_Surnom As String) As Long
    Code_groupe = requete.convert_encode_url(Code_groupe)
    Code_joueur = requete.convert_encode_url(Code_joueur)
    a_membre_joueur_groupe_Surnom = requete.convert_encode_url(a_membre_joueur_groupe_Surnom)
    requete.requete_serveur "a_membre_joueur_groupe/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_groupe=" & Code_groupe & "&Code_joueur=" & Code_joueur & "&a_membre_joueur_groupe_Surnom=" & a_membre_joueur_groupe_Surnom
    a_membre_joueur_groupe__modifier__a_membre_joueur_groupe_Surnom = requete.retour_ok()
End Function

Function a_membre_joueur_groupe__modifier__a_membre_joueur_groupe_Grade(ByVal Code_groupe As String, ByVal Code_joueur As String, ByVal a_membre_joueur_groupe_Grade As String) As Long
    Code_groupe = requete.convert_encode_url(Code_groupe)
    Code_joueur = requete.convert_encode_url(Code_joueur)
    a_membre_joueur_groupe_Grade = requete.convert_encode_url(a_membre_joueur_groupe_Grade)
    requete.requete_serveur "a_membre_joueur_groupe/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_groupe=" & Code_groupe & "&Code_joueur=" & Code_joueur & "&a_membre_joueur_groupe_Grade=" & a_membre_joueur_groupe_Grade
    a_membre_joueur_groupe__modifier__a_membre_joueur_groupe_Grade = requete.retour_ok()
End Function

Function a_membre_joueur_groupe__modifier__a_membre_joueur_groupe_Date_adhesion(ByVal Code_groupe As String, ByVal Code_joueur As String, ByVal a_membre_joueur_groupe_Date_adhesion As String) As Long
    Code_groupe = requete.convert_encode_url(Code_groupe)
    Code_joueur = requete.convert_encode_url(Code_joueur)
    a_membre_joueur_groupe_Date_adhesion = requete.convert_encode_url(a_membre_joueur_groupe_Date_adhesion)
    requete.requete_serveur "a_membre_joueur_groupe/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_groupe=" & Code_groupe & "&Code_joueur=" & Code_joueur & "&a_membre_joueur_groupe_Date_adhesion=" & a_membre_joueur_groupe_Date_adhesion
    a_membre_joueur_groupe__modifier__a_membre_joueur_groupe_Date_adhesion = requete.retour_ok()
End Function

Function a_membre_joueur_groupe__supprimer(ByVal Code_groupe As String, ByVal Code_joueur As String) As Long
    Code_groupe = requete.convert_encode_url(Code_groupe)
    Code_joueur = requete.convert_encode_url(Code_joueur)
    requete.requete_serveur "a_membre_joueur_groupe/supprimer.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_groupe=" & Code_groupe & "&Code_joueur=" & Code_joueur
    a_membre_joueur_groupe__supprimer = requete.retour_ok()
End Function

Function a_membre_joueur_groupe__lister(ByVal Code_groupe As String, ByVal Code_joueur As String) As Long
    Code_groupe = requete.convert_encode_url(Code_groupe)
    Code_joueur = requete.convert_encode_url(Code_joueur)
    requete.requete_serveur "a_membre_joueur_groupe/lister.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_groupe=" & Code_groupe & "&Code_joueur=" & Code_joueur
    a_membre_joueur_groupe__lister = requete.retour_ok()
End Function

'   +----------------------------+
'   | a_invitation_joueur_groupe |
'   +----------------------------+

Function a_invitation_joueur_groupe__ajouter(ByVal Code_joueur As String, ByVal Code_groupe As String, ByVal a_invitation_joueur_groupe_Message As String, ByVal a_invitation_joueur_groupe_Date_envoi As String) As Long
    a_invitation_joueur_groupe_Message = requete.convert_encode_url(a_invitation_joueur_groupe_Message)
    a_invitation_joueur_groupe_Date_envoi = requete.convert_encode_url(a_invitation_joueur_groupe_Date_envoi)
    Code_joueur = requete.convert_encode_url(Code_joueur)
    Code_groupe = requete.convert_encode_url(Code_groupe)
    requete.requete_serveur "a_invitation_joueur_groupe/ajouter.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_joueur=" & Code_joueur & "&Code_groupe=" & Code_groupe & "&a_invitation_joueur_groupe_Message=" & a_invitation_joueur_groupe_Message & "&a_invitation_joueur_groupe_Date_envoi=" & a_invitation_joueur_groupe_Date_envoi
    a_invitation_joueur_groupe__ajouter = requete.retour_ok()
End Function

Function a_invitation_joueur_groupe__modifier(ByVal Code_joueur As String, ByVal Code_groupe As String, ByVal a_invitation_joueur_groupe_Message As String, ByVal a_invitation_joueur_groupe_Date_envoi As String) As Long
    Code_a_invitation_joueur_groupe = requete.convert_encode_url(Code_a_invitation_joueur_groupe)
    a_invitation_joueur_groupe_Message = requete.convert_encode_url(a_invitation_joueur_groupe_Message)
    a_invitation_joueur_groupe_Date_envoi = requete.convert_encode_url(a_invitation_joueur_groupe_Date_envoi)
    Code_joueur = requete.convert_encode_url(Code_joueur)
    Code_groupe = requete.convert_encode_url(Code_groupe)
    requete.requete_serveur "a_invitation_joueur_groupe/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_joueur=" & Code_joueur & "&Code_groupe=" & Code_groupe & "&a_invitation_joueur_groupe_Message=" & a_invitation_joueur_groupe_Message & "&a_invitation_joueur_groupe_Date_envoi=" & a_invitation_joueur_groupe_Date_envoi
    a_invitation_joueur_groupe__modifier = requete.retour_ok()
End Function

Function a_invitation_joueur_groupe__modifier__a_invitation_joueur_groupe_Message(ByVal Code_joueur As String, ByVal Code_groupe As String, ByVal a_invitation_joueur_groupe_Message As String) As Long
    Code_joueur = requete.convert_encode_url(Code_joueur)
    Code_groupe = requete.convert_encode_url(Code_groupe)
    a_invitation_joueur_groupe_Message = requete.convert_encode_url(a_invitation_joueur_groupe_Message)
    requete.requete_serveur "a_invitation_joueur_groupe/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_joueur=" & Code_joueur & "&Code_groupe=" & Code_groupe & "&a_invitation_joueur_groupe_Message=" & a_invitation_joueur_groupe_Message
    a_invitation_joueur_groupe__modifier__a_invitation_joueur_groupe_Message = requete.retour_ok()
End Function

Function a_invitation_joueur_groupe__modifier__a_invitation_joueur_groupe_Date_envoi(ByVal Code_joueur As String, ByVal Code_groupe As String, ByVal a_invitation_joueur_groupe_Date_envoi As String) As Long
    Code_joueur = requete.convert_encode_url(Code_joueur)
    Code_groupe = requete.convert_encode_url(Code_groupe)
    a_invitation_joueur_groupe_Date_envoi = requete.convert_encode_url(a_invitation_joueur_groupe_Date_envoi)
    requete.requete_serveur "a_invitation_joueur_groupe/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_joueur=" & Code_joueur & "&Code_groupe=" & Code_groupe & "&a_invitation_joueur_groupe_Date_envoi=" & a_invitation_joueur_groupe_Date_envoi
    a_invitation_joueur_groupe__modifier__a_invitation_joueur_groupe_Date_envoi = requete.retour_ok()
End Function

Function a_invitation_joueur_groupe__supprimer(ByVal Code_joueur As String, ByVal Code_groupe As String) As Long
    Code_joueur = requete.convert_encode_url(Code_joueur)
    Code_groupe = requete.convert_encode_url(Code_groupe)
    requete.requete_serveur "a_invitation_joueur_groupe/supprimer.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_joueur=" & Code_joueur & "&Code_groupe=" & Code_groupe
    a_invitation_joueur_groupe__supprimer = requete.retour_ok()
End Function

Function a_invitation_joueur_groupe__lister(ByVal Code_joueur As String, ByVal Code_groupe As String) As Long
    Code_joueur = requete.convert_encode_url(Code_joueur)
    Code_groupe = requete.convert_encode_url(Code_groupe)
    requete.requete_serveur "a_invitation_joueur_groupe/lister.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_joueur=" & Code_joueur & "&Code_groupe=" & Code_groupe
    a_invitation_joueur_groupe__lister = requete.retour_ok()
End Function

'   +---------------+
'   | a_carte_objet |
'   +---------------+

Function a_carte_objet__ajouter(ByVal Code_carte As String, ByVal Code_objet As String) As Long
    Code_carte = requete.convert_encode_url(Code_carte)
    Code_objet = requete.convert_encode_url(Code_objet)
    requete.requete_serveur "a_carte_objet/ajouter.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_carte=" & Code_carte & "&Code_objet=" & Code_objet
    a_carte_objet__ajouter = requete.retour_ok()
End Function

Function a_carte_objet__modifier(ByVal Code_carte As String, ByVal Code_objet As String) As Long
    Code_a_carte_objet = requete.convert_encode_url(Code_a_carte_objet)
    Code_carte = requete.convert_encode_url(Code_carte)
    Code_objet = requete.convert_encode_url(Code_objet)
    requete.requete_serveur "a_carte_objet/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_carte=" & Code_carte & "&Code_objet=" & Code_objet
    a_carte_objet__modifier = requete.retour_ok()
End Function

Function a_carte_objet__supprimer(ByVal Code_carte As String, ByVal Code_objet As String) As Long
    Code_carte = requete.convert_encode_url(Code_carte)
    Code_objet = requete.convert_encode_url(Code_objet)
    requete.requete_serveur "a_carte_objet/supprimer.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_carte=" & Code_carte & "&Code_objet=" & Code_objet
    a_carte_objet__supprimer = requete.retour_ok()
End Function

Function a_carte_objet__lister(ByVal Code_carte As String, ByVal Code_objet As String) As Long
    Code_carte = requete.convert_encode_url(Code_carte)
    Code_objet = requete.convert_encode_url(Code_objet)
    requete.requete_serveur "a_carte_objet/lister.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_carte=" & Code_carte & "&Code_objet=" & Code_objet
    a_carte_objet__lister = requete.retour_ok()
End Function

'   +-------------------------+
'   | a_campagne_tag_campagne |
'   +-------------------------+

Function a_campagne_tag_campagne__ajouter(ByVal Code_tag_campagne As String, ByVal Code_campagne As String) As Long
    Code_tag_campagne = requete.convert_encode_url(Code_tag_campagne)
    Code_campagne = requete.convert_encode_url(Code_campagne)
    requete.requete_serveur "a_campagne_tag_campagne/ajouter.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_tag_campagne=" & Code_tag_campagne & "&Code_campagne=" & Code_campagne
    a_campagne_tag_campagne__ajouter = requete.retour_ok()
End Function

Function a_campagne_tag_campagne__modifier(ByVal Code_tag_campagne As String, ByVal Code_campagne As String) As Long
    Code_a_campagne_tag_campagne = requete.convert_encode_url(Code_a_campagne_tag_campagne)
    Code_tag_campagne = requete.convert_encode_url(Code_tag_campagne)
    Code_campagne = requete.convert_encode_url(Code_campagne)
    requete.requete_serveur "a_campagne_tag_campagne/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_tag_campagne=" & Code_tag_campagne & "&Code_campagne=" & Code_campagne
    a_campagne_tag_campagne__modifier = requete.retour_ok()
End Function

Function a_campagne_tag_campagne__supprimer(ByVal Code_tag_campagne As String, ByVal Code_campagne As String) As Long
    Code_tag_campagne = requete.convert_encode_url(Code_tag_campagne)
    Code_campagne = requete.convert_encode_url(Code_campagne)
    requete.requete_serveur "a_campagne_tag_campagne/supprimer.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_tag_campagne=" & Code_tag_campagne & "&Code_campagne=" & Code_campagne
    a_campagne_tag_campagne__supprimer = requete.retour_ok()
End Function

Function a_campagne_tag_campagne__lister(ByVal Code_tag_campagne As String, ByVal Code_campagne As String) As Long
    Code_tag_campagne = requete.convert_encode_url(Code_tag_campagne)
    Code_campagne = requete.convert_encode_url(Code_campagne)
    requete.requete_serveur "a_campagne_tag_campagne/lister.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_tag_campagne=" & Code_tag_campagne & "&Code_campagne=" & Code_campagne
    a_campagne_tag_campagne__lister = requete.retour_ok()
End Function

'   +---------------------------+
'   | a_ressource_tag_ressource |
'   +---------------------------+

Function a_ressource_tag_ressource__ajouter(ByVal Code_tag_ressource As String, ByVal Code_ressource As String) As Long
    Code_tag_ressource = requete.convert_encode_url(Code_tag_ressource)
    Code_ressource = requete.convert_encode_url(Code_ressource)
    requete.requete_serveur "a_ressource_tag_ressource/ajouter.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_tag_ressource=" & Code_tag_ressource & "&Code_ressource=" & Code_ressource
    a_ressource_tag_ressource__ajouter = requete.retour_ok()
End Function

Function a_ressource_tag_ressource__modifier(ByVal Code_tag_ressource As String, ByVal Code_ressource As String) As Long
    Code_a_ressource_tag_ressource = requete.convert_encode_url(Code_a_ressource_tag_ressource)
    Code_tag_ressource = requete.convert_encode_url(Code_tag_ressource)
    Code_ressource = requete.convert_encode_url(Code_ressource)
    requete.requete_serveur "a_ressource_tag_ressource/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_tag_ressource=" & Code_tag_ressource & "&Code_ressource=" & Code_ressource
    a_ressource_tag_ressource__modifier = requete.retour_ok()
End Function

Function a_ressource_tag_ressource__supprimer(ByVal Code_tag_ressource As String, ByVal Code_ressource As String) As Long
    Code_tag_ressource = requete.convert_encode_url(Code_tag_ressource)
    Code_ressource = requete.convert_encode_url(Code_ressource)
    requete.requete_serveur "a_ressource_tag_ressource/supprimer.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_tag_ressource=" & Code_tag_ressource & "&Code_ressource=" & Code_ressource
    a_ressource_tag_ressource__supprimer = requete.retour_ok()
End Function

Function a_ressource_tag_ressource__lister(ByVal Code_tag_ressource As String, ByVal Code_ressource As String) As Long
    Code_tag_ressource = requete.convert_encode_url(Code_tag_ressource)
    Code_ressource = requete.convert_encode_url(Code_ressource)
    requete.requete_serveur "a_ressource_tag_ressource/lister.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_tag_ressource=" & Code_tag_ressource & "&Code_ressource=" & Code_ressource
    a_ressource_tag_ressource__lister = requete.retour_ok()
End Function

'   +------------------------+
'   | a_liste_contact_joueur |
'   +------------------------+

Function a_liste_contact_joueur__ajouter(ByVal Code_liste_contacts As String, ByVal Code_joueur As String, ByVal a_liste_contact_joueur_Date_creation As String) As Long
    a_liste_contact_joueur_Date_creation = requete.convert_encode_url(a_liste_contact_joueur_Date_creation)
    Code_liste_contacts = requete.convert_encode_url(Code_liste_contacts)
    Code_joueur = requete.convert_encode_url(Code_joueur)
    requete.requete_serveur "a_liste_contact_joueur/ajouter.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_liste_contacts=" & Code_liste_contacts & "&Code_joueur=" & Code_joueur & "&a_liste_contact_joueur_Date_creation=" & a_liste_contact_joueur_Date_creation
    a_liste_contact_joueur__ajouter = requete.retour_ok()
End Function

Function a_liste_contact_joueur__modifier(ByVal Code_liste_contacts As String, ByVal Code_joueur As String, ByVal a_liste_contact_joueur_Date_creation As String) As Long
    Code_a_liste_contact_joueur = requete.convert_encode_url(Code_a_liste_contact_joueur)
    a_liste_contact_joueur_Date_creation = requete.convert_encode_url(a_liste_contact_joueur_Date_creation)
    Code_liste_contacts = requete.convert_encode_url(Code_liste_contacts)
    Code_joueur = requete.convert_encode_url(Code_joueur)
    requete.requete_serveur "a_liste_contact_joueur/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_liste_contacts=" & Code_liste_contacts & "&Code_joueur=" & Code_joueur & "&a_liste_contact_joueur_Date_creation=" & a_liste_contact_joueur_Date_creation
    a_liste_contact_joueur__modifier = requete.retour_ok()
End Function

Function a_liste_contact_joueur__modifier__a_liste_contact_joueur_Date_creation(ByVal Code_liste_contacts As String, ByVal Code_joueur As String, ByVal a_liste_contact_joueur_Date_creation As String) As Long
    Code_liste_contacts = requete.convert_encode_url(Code_liste_contacts)
    Code_joueur = requete.convert_encode_url(Code_joueur)
    a_liste_contact_joueur_Date_creation = requete.convert_encode_url(a_liste_contact_joueur_Date_creation)
    requete.requete_serveur "a_liste_contact_joueur/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_liste_contacts=" & Code_liste_contacts & "&Code_joueur=" & Code_joueur & "&a_liste_contact_joueur_Date_creation=" & a_liste_contact_joueur_Date_creation
    a_liste_contact_joueur__modifier__a_liste_contact_joueur_Date_creation = requete.retour_ok()
End Function

Function a_liste_contact_joueur__supprimer(ByVal Code_liste_contacts As String, ByVal Code_joueur As String) As Long
    Code_liste_contacts = requete.convert_encode_url(Code_liste_contacts)
    Code_joueur = requete.convert_encode_url(Code_joueur)
    requete.requete_serveur "a_liste_contact_joueur/supprimer.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_liste_contacts=" & Code_liste_contacts & "&Code_joueur=" & Code_joueur
    a_liste_contact_joueur__supprimer = requete.retour_ok()
End Function

Function a_liste_contact_joueur__lister(ByVal Code_liste_contacts As String, ByVal Code_joueur As String) As Long
    Code_liste_contacts = requete.convert_encode_url(Code_liste_contacts)
    Code_joueur = requete.convert_encode_url(Code_joueur)
    requete.requete_serveur "a_liste_contact_joueur/lister.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_liste_contacts=" & Code_liste_contacts & "&Code_joueur=" & Code_joueur
    a_liste_contact_joueur__lister = requete.retour_ok()
End Function

