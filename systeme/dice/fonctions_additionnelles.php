<?php

function est_administrateur()
{
    $db = new DB();
    return ($db -> joueur() -> mf_compter() == 0 || get_joueur_courant(MF_JOUEUR_ADMINISTRATEUR) != null && get_joueur_courant(MF_JOUEUR_ADMINISTRATEUR) == 1);
}
