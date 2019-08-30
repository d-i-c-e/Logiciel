<?php

class Hook_campagne{

    static function initialisation() // première instanciation
    {
        // ici le code
        definir_colonne_completion('campagne', 'campagne_Auto_completion_tag_campagne', 'VARCHAR', '');
    }

    static function actualisation() // à chaque instanciation
    {
        // ici le code
    }

    static function pre_controller(string &$campagne_Nom, string &$campagne_Description, string &$campagne_Image_Fichier, int &$campagne_Nombre_joueur, int &$campagne_Nombre_mj, ?int $Code_campagne=null)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_ajouter()
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['campagne__AJOUTER']
         * $mf_droits_defaut['campagne__CREER'] // actualisation uniquement pour l'affichage
         *
         */
        // ici le code
        if (est_administrateur()) {
            $mf_droits_defaut['campagne__AJOUTER'] = true;
        }
    }

    static function autorisation_ajout(string $campagne_Nom, string $campagne_Description, string $campagne_Image_Fichier, int $campagne_Nombre_joueur, int $campagne_Nombre_mj)
    {
        return true;
    }

    static function data_controller(string &$campagne_Nom, string &$campagne_Description, string &$campagne_Image_Fichier, int &$campagne_Nombre_joueur, int &$campagne_Nombre_mj, ?int $Code_campagne=null)
    {
        // ici le code
    }

    static function calcul_signature(string $campagne_Nom, string $campagne_Description, string $campagne_Image_Fichier, int $campagne_Nombre_joueur, int $campagne_Nombre_mj)
    {
        return md5($campagne_Nom.'-'.$campagne_Description.'-'.$campagne_Image_Fichier.'-'.$campagne_Nombre_joueur.'-'.$campagne_Nombre_mj);
    }

    static function calcul_cle_unique(string $campagne_Nom, string $campagne_Description, string $campagne_Image_Fichier, int $campagne_Nombre_joueur, int $campagne_Nombre_mj)
    {
        // La méthode POST de l'API REST utilise cette fonction pour en déduire l'unicité de la données. Dans le cas contraire, la données est alors mise à jour
        // Attention au risque de collision
        return sha1($campagne_Nom.'.'.$campagne_Description.'.'.$campagne_Image_Fichier.'.'.$campagne_Nombre_joueur.'.'.$campagne_Nombre_mj);
    }

    static function ajouter(int $Code_campagne)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_modifier(?int $Code_campagne=null)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['campagne__MODIFIER']
         *
         * $mf_droits_defaut['api_modifier__campagne_Nom']
         * $mf_droits_defaut['api_modifier__campagne_Description']
         * $mf_droits_defaut['api_modifier__campagne_Image_Fichier']
         * $mf_droits_defaut['api_modifier__campagne_Nombre_joueur']
         * $mf_droits_defaut['api_modifier__campagne_Nombre_mj']
         *
         */
        // ici le code
        if (est_administrateur()) {
            $mf_droits_defaut['api_modifier__campagne_Nom'] = true;
            $mf_droits_defaut['api_modifier__campagne_Description'] = true;
            $mf_droits_defaut['api_modifier__campagne_Image_Fichier'] = true;
            $mf_droits_defaut['api_modifier__campagne_Nombre_joueur'] = true;
            $mf_droits_defaut['api_modifier__campagne_Nombre_mj'] = true;
        }
    }

    static function autorisation_modification(int $Code_campagne, string $campagne_Nom__new, string $campagne_Description__new, string $campagne_Image_Fichier__new, int $campagne_Nombre_joueur__new, int $campagne_Nombre_mj__new)
    {
        return true;
    }

    static function data_controller__campagne_Nom(string $old, string &$new, int $Code_campagne)
    {
        // ici le code
    }

    static function data_controller__campagne_Description(string $old, string &$new, int $Code_campagne)
    {
        // ici le code
    }

    static function data_controller__campagne_Image_Fichier(string $old, string &$new, int $Code_campagne)
    {
        // ici le code
    }

    static function data_controller__campagne_Nombre_joueur(int $old, int &$new, int $Code_campagne)
    {
        // ici le code
    }

    static function data_controller__campagne_Nombre_mj(int $old, int &$new, int $Code_campagne)
    {
        // ici le code
    }

    /*
     * modifier : $Code_campagne permet de se référer à la données modifiée
     * les autres paramètres booléens ($modif...) permettent d'identifier les champs qui ont été modifiés
     */
    static function modifier(int $Code_campagne, bool $bool__campagne_Nom, bool $bool__campagne_Description, bool $bool__campagne_Image_Fichier, bool $bool__campagne_Nombre_joueur, bool $bool__campagne_Nombre_mj)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_supprimer(?int $Code_campagne=null)
    {
        global $mf_droits_defaut;
        /*
         * Droits disponibles :
         *
         * $mf_droits_defaut['campagne__SUPPRIMER']
         *
         */
        // Ici le code
        if (est_administrateur()) {
            $mf_droits_defaut['campagne__SUPPRIMER'] = true;
        }
        if ($Code_campagne!=0 && $mf_droits_defaut['campagne__SUPPRIMER'])
        {
            $table_groupe = new groupe();
            $mf_droits_defaut['campagne__SUPPRIMER'] = $table_groupe->mfi_compter(array('Code_campagne'=>$Code_campagne))==0;
        }
    }

    static function autorisation_suppression(int $Code_campagne)
    {
        return true;
    }

    static function supprimer(array $copie__campagne)
    {
        // ici le code
    }

    static function supprimer_2(array $copie__liste_campagne)
    {
        foreach ($copie__liste_campagne as &$copie__campagne)
        {
            self::supprimer($copie__campagne);
        }
        unset($copie__campagne);
    }

    static function est_a_jour(array &$donnees)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_campagne']
         * $donnees['campagne_Nom']
         * $donnees['campagne_Description']
         * $donnees['campagne_Image_Fichier']
         * $donnees['campagne_Nombre_joueur']
         * $donnees['campagne_Nombre_mj']
         */
        return true;
    }

    static function mettre_a_jour(array $liste_campagne)
    {
        // ici le code
    }

    static function completion(array &$donnees)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_campagne']
         * $donnees['campagne_Nom']
         * $donnees['campagne_Description']
         * $donnees['campagne_Image_Fichier']
         * $donnees['campagne_Nombre_joueur']
         * $donnees['campagne_Nombre_mj']
         */
        // ici le code
        $db = new DB();
        
        // auto complétion tag
        $requete_tag_campagne = mf_get_value_session('requete_tag_campagne', '');
        $donnees['campagne_Auto_completion_tag_campagne'] = '';
        if ($requete_tag_campagne!='')
        {
            $liste_tag_campagne = explode(' ', $requete_tag_campagne);
            $sql = [];
            foreach ($liste_tag_campagne as $tag_campagne) {
                $sql[] = MF_TAG_CAMPAGNE_LIBELLE . ' LIKE \'%' . text_sql($tag_campagne) . '%\'';
            }
            $liste_mots_cles_tag_campagne = $db -> tag_campagne()->mf_lister([OPTION_COND_MYSQL=>$sql]);
            $i = 0;
            foreach ($liste_mots_cles_tag_campagne as $mots_cles_tag_campagne) {
                if ($i < NB_MAXI_PROPO_AUTO_COMPLETE) {
                    $t = htmlspecialchars($mots_cles_tag_campagne[MF_TAG_CAMPAGNE_LIBELLE]);
                    $cache = new Cache('id');
                    $id = $cache->read('requete_tag_campagne', 9999);
                    var_dump('<pre>'); var_dump($id); var_dump('</pre>');
                    $donnees['campagne_Auto_completion_tag_campagne'] .= '<button type="button" class="btn btn btn-info btn-sm" style="width: 100%; white-space: normal;" onclick="$(\'#form_dyn_' . $id . '\').val(this.innerHTML);maj_form_dyn_' . $id . '();set_autocomplete(0);">' . $t . '</button>';
                    $i++;
                }
            }
            if (count($liste_mots_cles_tag_campagne) > NB_MAXI_PROPO_AUTO_COMPLETE) {
                $i = count($liste_mots_cles_tag_campagne) - NB_MAXI_PROPO_AUTO_COMPLETE;
                $donnees['campagne_Auto_completion_tag_campagne'] .= '<button type="button" class="btn btn-primary btn-sm disabled" style="width: 100%; white-space: normal;"> + ' . $i . ' autre' . ($i>1 ? 's' : '') . ' résultat' . ($i>1 ? 's' : '') . '</button>';
            }
        }
        $donnees['campagne_Auto_completion_tag_campagne'] = '<div style="position: absolute; background-color: white; z-index: 1;">' . $donnees['campagne_Auto_completion_tag_campagne'] . '</div>';
        
    }

    // API callbacks
    // -------------------

    static function callback_post(int $Code_campagne)
    {
        return null;
    }

    static function callback_put(int $Code_campagne)
    {
        return null;
    }

}
