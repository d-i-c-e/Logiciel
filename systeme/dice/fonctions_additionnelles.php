<?php

function est_administrateur()
{
    $db = new DB();
    return ($db -> joueur() -> mf_compter() == 0 || get_joueur_courant(MF_JOUEUR_ADMINISTRATEUR) != null && get_joueur_courant(MF_JOUEUR_ADMINISTRATEUR) == 1);
}

function est_admin_groupe($Code_groupe)
{
    $db = new DB();
    $membre = $db -> a_membre_joueur_groupe() -> mf_get($Code_groupe, get_joueur_courant(MF_JOUEUR__ID));
    return $membre[MF_A_MEMBRE_JOUEUR_GROUPE_GRADE] == 'ADMIN';
}
