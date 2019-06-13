<?php

class Mf_Cachedb
{

    private $dossier_cache;
    private $name;
    private $commande_vider_cache;
    private $commande_vider_cache_en_cours;
    private $commande_pause;

    private function initialisation_cache()
    {
        if ( file_exists( $this->commande_vider_cache ) && !file_exists( $this->commande_vider_cache_en_cours ) && !$this->etat_pause() ) //si commande clear, on supprime les donnees en cache
        {

            $files = glob($this->dossier_cache.'*');

            file_put_contents( $this->commande_vider_cache_en_cours, '1' );
            $files_2 = glob( $this->commande_vider_cache_en_cours );
            $file_commande_vider_cache_en_cours = '';
            foreach ( $files_2 as $file )
            {
                $file_commande_vider_cache_en_cours = $file;
            }

            $erreur_suppression = false;
            foreach ( $files as $file )
            {
                if ( $file!=$file_commande_vider_cache_en_cours && strpos($file, '/pause')===false )
                {
                    if ( ! @unlink($file) )
                    {
                        $erreur_suppression = true;
                    }
                }
            }

            if ( $erreur_suppression )
            {
                clearstatcache();
                $this->clear();
            }

            if ( $file_commande_vider_cache_en_cours!='' )
            {
                @unlink( $file_commande_vider_cache_en_cours );
            }
            clearstatcache();

        }
    }

    function __construct($name)
    {
        $this->dossier_cache = __DIR__ . '/cache/';
        if (!file_exists($this->dossier_cache))
        {
            mkdir($this->dossier_cache);
        }
        if (TABLE_INSTANCE!='')
        {
            if ($name!=TABLE_INSTANCE)
            {
                $instance = 'inst_'.get_instance();
                $this->dossier_cache.= $instance.'/';
                if (!file_exists($this->dossier_cache))
                {
                    mkdir($this->dossier_cache);
                }
            }
        }
        $this->dossier_cache.= $name.'/';
        if (!file_exists($this->dossier_cache))
        {
            mkdir($this->dossier_cache);
        }
        $this->name = $name;
        $this->commande_vider_cache = $this->dossier_cache.'commande_vider_cache';
        $this->commande_vider_cache_en_cours = $this->dossier_cache.'commande_vider_cache_en_cours';
        $this->commande_pause = $this->dossier_cache.'pause';
    }

    function read($cle)
    {
        global $mf_cache_volatil;
        if ( $mf_cache_volatil->is_set($this->name, $cle) )
        {
            return $mf_cache_volatil->get($this->name, $cle);
        }
        else
        {
            $this->initialisation_cache();
            if ( $this->cache_etat_ok() )
            {
                $filename = $this->dossier_cache.md5($cle);
                if ( file_exists($filename) )
                {
                    $r = @file_get_contents( $filename );
                    if ($r!==false)
                    {
                        $mf_cache_volatil->set( $this->name, $cle, unserialize($r) );
                        return $mf_cache_volatil->get( $this->name, $cle );
                    }
                }
            }
        }
        return false;
    }

    function write($cle, $variable)
    {
        global $mf_cache_volatil;
        $this->initialisation_cache();
        if ( $this->cache_etat_ok() )
        {
            $filename = $this->dossier_cache.md5($cle);
            file_put_contents($filename, serialize($variable));
            $mf_cache_volatil->set($this->name, $cle, $variable);
        }
    }

    function clear() //sppression differee
    {
        global $mf_cache_volatil;
        if ( ! file_exists( $this->commande_vider_cache ) )
        {
            $ecrire_commande = true;
            while ($ecrire_commande)
            {
                $ecrire_commande = false;
                $r = file_put_contents( $this->commande_vider_cache , '1' );
                if ($r===false)
                {
                    $ecrire_commande = true;
                }
            }
        }
        $mf_cache_volatil->clear($this->name);
    }

    private function cache_etat_ok()
    {
        return ( !file_exists( $this->commande_vider_cache ) && !file_exists( $this->commande_vider_cache_en_cours ) && !$this->etat_pause() );
    }

    function pause($cle)
    {
        $r = file_put_contents( $this->commande_pause.'.'.$cle, '1' );
    }

    function reprendre($cle)
    {
        while ( file_exists( $this->commande_pause.'.'.$cle ) )
        {
            if ( ! @unlink( $this->commande_pause.'.'.$cle ) )
            {
                usleep(50000); // tempo de 0.05s
                clearstatcache();
            }
        }
    }

    private function etat_pause()
    {
        $files = glob( $this->commande_pause.'.*' );
        foreach ( $files as $file )
        {
            return true;
        }
        return false;
    }

}
