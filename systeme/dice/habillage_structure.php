<?php

// HABILLAGE BOUTONS

define('BOUTON_LIBELLE_AJOUTER_PREC', '<span class="glyphicon glyphicon-plus"></span> ');
define('BOUTON_LIBELLE_AJOUTER_SUIV', '');
define('BOUTON_CLASSE_AJOUTER', 'btn btn-success');

define('BOUTON_LIBELLE_MODIFIER_PREC', '<span class="glyphicon glyphicon-pencil"></span> ');
define('BOUTON_LIBELLE_MODIFIER_SUIV', '');
define('BOUTON_LIBELLE_MODIFIER_PWD_PREC', '<span class="glyphicon glyphicon-lock"></span> ');
define('BOUTON_LIBELLE_MODIFIER_PWD_SUIV', '');
define('BOUTON_CLASSE_MODIFIER', 'btn btn-default');

define('BOUTON_LIBELLE_SUPPRIMER_PREC', '<span class=""glyphicon glyphicon-trash""></span> ');
define('BOUTON_LIBELLE_SUPPRIMER_SUIV', '');
define('BOUTON_CLASSE_SUPPRIMER', 'btn btn-danger');

function get_code_pager($prec, $suiv)
{
    if ( VERSION_BOOTSTRAP==3 )
    {
        return '<nav aria-label="navigation"><ul class="pager"><li class="previous'.( $prec['link']=='' ? ' disabled' : '' ).'"><a'.( $prec['link']!='' ? ' href="'.$prec['link'].'"' : '' ).' title="'.$prec['title'].'">'.get_nom_colonne('mf_precedent').'</a></li><li class="next'.( $suiv['link']=='' ? ' disabled' : '' ).'"><a'.( $suiv['link']!='' ? ' href="'.$suiv['link'].'"' : '' ).' title="'.$suiv['title'].'">'.get_nom_colonne('mf_suivant').'</a></li></ul></nav>';
    }
    elseif ( VERSION_BOOTSTRAP==4 )
    {
        $code = '';
        $code.= '<div class="row"><div class="col text-left">';
        $code.= '<a href="'.$prec['link'].'" class="btn btn-outline-secondary btn-sm'.( $prec['link']=='' ? ' disabled' : '' ).'" role="button" aria-pressed="true" title="'.$prec['title'].'">'.get_nom_colonne('mf_precedent').'</a>';
        $code.= '</div><div class="col text-right">';
        $code.= '<a href="'.$suiv['link'].'" class="btn btn-outline-secondary btn-sm'.( $suiv['link']=='' ? ' disabled' : '' ).'" role="button" aria-pressed="true" title="'.$suiv['title'].'">'.get_nom_colonne('mf_suivant').'</a>';
        $code.= '</div></div>';
        return $code;
    }
    else
    {
        return 'Version ' . VERSION_BOOTSTRAP . ' non supportée';
    }
}
