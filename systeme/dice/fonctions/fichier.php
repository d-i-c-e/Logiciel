<?php

class Fichier
{

    private $dossier_fichiers;
    private $filtre;

    function __construct($filtre='')
    {
        /*
         * application/pdf
         * image/
         * image/png
         * image/png image/jpeg image/jpg
         * ...
         */
        $this->dossier_fichiers = __DIR__ . '/../../../fichiers/';
        if (!file_exists($this->dossier_fichiers))
        {
            mkdir($this->dossier_fichiers);
        }
        $this->dossier_fichiers = $this->dossier_fichiers.NOM_PROJET.'/';
        if (!file_exists($this->dossier_fichiers))
        {
            mkdir($this->dossier_fichiers);
        }
        if (TABLE_INSTANCE!='')
        {
            $instance = 'inst_'.get_instance();
            $this->dossier_fichiers.= $instance.'/';
            if (!file_exists($this->dossier_fichiers))
            {
                mkdir($this->dossier_fichiers);
            }
        }
        $this->filtre = $filtre;
    }

    function importer($file)
    {
        if ( stripos(' '.$this->filtre, ' '.substr( $file['type'], 0, strlen($this->filtre) )) !== false ) {
            $extension = strtolower( strrchr($file['name'], '.') );
            $nom = 'f_' . salt_minuscules(100) . $extension;
            while ( file_exists( $this->dossier_fichiers.$nom ) )
            {
                $nom = 'f_' . salt_minuscules(100) . $extension;
            }
            $resultat = move_uploaded_file( $file['tmp_name'], $this->dossier_fichiers.$nom );
            if (!$resultat) {
                $nom = '';
            }
        }
        else
        {
            $nom = '';
        }
        return $nom;
    }

    function importer_depuis_fichier($adresse)
    {
        $extension = strtolower( strrchr($adresse, '.') );
        $nom = 'f_' . salt_minuscules(100) . $extension;
        while ( file_exists( $this->dossier_fichiers.$nom ) )
        {
            $nom = 'f_' . salt_minuscules(100) . $extension;
        }
        $resultat = copy( $adresse, $this->dossier_fichiers.$nom );
        if (!$resultat) {
            $nom = '';
        }
        return $nom;
    }

    function set( $contenu , $filename='' , $extension='' )
    {
        if ( $filename=='' )
        {
            $filename = 'f_' . salt_minuscules(100) . $extension;
            while ( file_exists( $this->dossier_fichiers.$filename ) )
            {
                $filename = 'f_' . salt_minuscules(100) . $extension;
            }
        }
        file_put_contents( $this->dossier_fichiers . $filename , $contenu );
        return $filename;
    }

    function get($nom)
    {
        if ($nom!='')
        {
            $filename = $this->dossier_fichiers.$nom;
            if ( file_exists($filename) )
            {
                return file_get_contents($filename);
            }
        }
        return false;
    }

    function get_extention($nom)
    {
        $p = strrpos($nom, '.');
        if ($p>0) $ext = strtolower(substr($nom, $p+1)); else  $ext = 'null'; //https://www.freeformatter.com/mime-types-list.html
        return $ext;
    }

    function get_adresse($nom)
    {
        $filename = $this->dossier_fichiers.$nom;
        return $filename;
    }

    function supprimer()
    {

    }

    function get_mine_type($ext)
    {
        switch ($ext) {
            case 'ppt': return 'application/vnd.ms-powerpoint'; break;
            case 'pptx': return 'application/vnd.openxmlformats-officedocument.presentationml.presentation'; break;
            case 'pptm': return 'application/vnd.ms-powerpoint.presentation.macroenabled.12'; break;
            case 'pdf': return 'application/pdf'; break;
            default: return false; break;
        }
    }

}
