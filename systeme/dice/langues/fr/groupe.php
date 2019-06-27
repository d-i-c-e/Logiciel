<?php

$lang_standard['Code_groupe'] = 'Groupe';

$lang_standard['groupe_Nom'] = 'Nom';
$lang_standard['groupe_Description'] = 'Description';
$lang_standard['groupe_Logo_Fichier'] = 'Logo';
$lang_standard['groupe_Effectif'] = 'Effectif';
$lang_standard['groupe_Actif'] = 'Actif';
$lang_standard['groupe_Actif_'] = array( 1 => 'Oui', 0 => 'Non' );
$lang_standard['groupe_Date_creation'] = 'Date  de création';
$lang_standard['groupe_Delai_suppression_jour'] = 'Délai de suppression ( en jour )';
$lang_standard['groupe_Suppression_active'] = 'Activer la suppression';
$lang_standard['groupe_Suppression_active_'] = array( 1 => 'Oui', 0 => 'Non' );

$lang_standard['bouton_ajouter_groupe'] = 'Ajouter';
$lang_standard['bouton_creer_groupe'] = 'Créer';
$lang_standard['bouton_modifier_groupe'] = 'Modifier';
$lang_standard['bouton_supprimer_groupe'] = 'Supprimer';
$lang_standard['bouton_modifier_groupe_Nom'] = 'Modifier';
$lang_standard['bouton_modifier_groupe_Description'] = 'Modifier';
$lang_standard['bouton_modifier_groupe_Logo_Fichier'] = 'Modifier';
$lang_standard['bouton_modifier_groupe_Effectif'] = 'Modifier';
$lang_standard['bouton_modifier_groupe_Actif'] = 'Modifier';
$lang_standard['bouton_modifier_groupe_Date_creation'] = 'Modifier';
$lang_standard['bouton_modifier_groupe_Delai_suppression_jour'] = 'Modifier';
$lang_standard['bouton_modifier_groupe_Suppression_active'] = 'Modifier';
$lang_standard['bouton_modifier_groupe__Code_campagne'] = 'Modifier';

$lang_standard['form_add_groupe'] = 'Ajouter un groupe';
$lang_standard['form_edit_groupe'] = 'form_edit_groupe';
$lang_standard['form_delete_groupe'] = 'form_delete_groupe';

$mf_titre_ligne_table['groupe'] = '{groupe_Nom}';

$mf_tri_defaut_table['groupe'] = array( 'groupe_Nom' => 'ASC' );

$lang_standard['libelle_liste_groupe'] = 'Liste des groupes';

$mf_initialisation['groupe_Nom'] = '';
$mf_initialisation['groupe_Description'] = '';
$mf_initialisation['groupe_Logo_Fichier'] = '';
$mf_initialisation['groupe_Effectif'] = 0;
$mf_initialisation['groupe_Actif'] = 0;
$mf_initialisation['groupe_Date_creation'] = '';
$mf_initialisation['groupe_Delai_suppression_jour'] = 0;
$mf_initialisation['groupe_Suppression_active'] = 0;

// code_erreur

$mf_libelle_erreur[REFUS_GROUPE__AJOUTER] = 'REFUS_groupe__AJOUTER';
$mf_libelle_erreur[ERR_GROUPE__AJOUTER__CODE_CAMPAGNE_INEXISTANT] = 'ERR_groupe__AJOUTER__Code_campagne_INEXISTANT';
$mf_libelle_erreur[ACCES_CODE_CAMPAGNE_REFUSE] = 'Tentative d\'accès \'Code_campagne\' non autorisé';
$mf_libelle_erreur[REFUS_GROUPE__AJOUT_BLOQUEE] = 'REFUS_groupe__AJOUT_BLOQUEE';
$mf_libelle_erreur[ERR_GROUPE__AJOUTER__AJOUT_REFUSE] = 'ERR_groupe__AJOUTER__AJOUT_REFUSE';
$mf_libelle_erreur[ERR_GROUPE__AJOUTER_3__ECHEC_AJOUT] = 'ERR_groupe__AJOUTER_3__ECHEC_AJOUT';
$mf_libelle_erreur[ERR_GROUPE__MODIFIER__CODE_GROUPE_INEXISTANT] = 'ERR_groupe__MODIFIER__Code_groupe_INEXISTANT';
$mf_libelle_erreur[REFUS_GROUPE__MODIFIER] = 'REFUS_groupe__MODIFIER';
$mf_libelle_erreur[ERR_GROUPE__MODIFIER__CODE_CAMPAGNE_INEXISTANT] = 'ERR_groupe__MODIFIER__Code_campagne_INEXISTANT';
$mf_libelle_erreur[ACCES_CODE_GROUPE_REFUSE] = 'Tentative d\'accès \'Code_groupe\' non autorisé';
$mf_libelle_erreur[REFUS_GROUPE__MODIFICATION_BLOQUEE] = 'REFUS_groupe__MODIFICATION_BLOQUEE';
$mf_libelle_erreur[ERR_GROUPE__MODIFIER__AUCUN_CHANGEMENT] = 'ERR_groupe__MODIFIER__AUCUN_CHANGEMENT';
$mf_libelle_erreur[ERR_GROUPE__MODIFIER_3__AUCUN_CHANGEMENT] = 'ERR_groupe__MODIFIER_3__AUCUN_CHANGEMENT';
$mf_libelle_erreur[ERR_GROUPE__MODIFIER_4__AUCUN_CHANGEMENT] = 'ERR_groupe__MODIFIER_4__AUCUN_CHANGEMENT';
$mf_libelle_erreur[ERR_GROUPE__SUPPRIMER_2__CODE_GROUPE_INEXISTANT] = 'ERR_groupe__SUPPRIMER_2__Code_groupe_INEXISTANT';
$mf_libelle_erreur[REFUS_GROUPE__SUPPRIMER] = 'REFUS_groupe__SUPPRIMER';
$mf_libelle_erreur[REFUS_GROUPE__SUPPRESSION_BLOQUEE] = 'REFUS_groupe__SUPPRESSION_BLOQUEE';
$mf_libelle_erreur[ERR_GROUPE__SUPPRIMER__REFUSEE] = 'ERR_groupe__SUPPRIMER__REFUSEE';
$mf_libelle_erreur[ERR_GROUPE__SUPPRIMER_2__REFUSEE] = 'ERR_groupe__SUPPRIMER_2__REFUSEE';
$mf_libelle_erreur[ERR_GROUPE__SUPPRIMER_3__REFUSEE] = 'ERR_groupe__SUPPRIMER_3__REFUSEE';
