<?php

class Cache
{

    private $dossier_cache;
    private $prefixe;

    function __construct($dossier_cache='100', $sous_dossier='all') //Possibilité de catégoriser les pages ...
    {
        $this->dossier_cache = __DIR__ . '/../cache/';
        if (!file_exists($this->dossier_cache))
        {
            @mkdir($this->dossier_cache);
        }
        if (TABLE_INSTANCE!='')
        {
            $instance = 'inst_'.get_instance();
            $this->dossier_cache.= $instance.'/';
            if (!file_exists($this->dossier_cache))
            {
                @mkdir($this->dossier_cache);
            }
        }
        $this->dossier_cache.= $dossier_cache.'/';
        if (!file_exists($this->dossier_cache))
        {
            @mkdir($this->dossier_cache);
        }
        $this->prefixe = md5($sous_dossier);
    }

    function read($cle, $duree=DUREE_CACHE_MINUTES)
    {
        $filename = $this->dossier_cache . $this->prefixe . md5(''.$cle).'';
        if ( file_exists($filename) && ( time() - filemtime($filename)<$duree*60 ) )
        {
            return unserialize(file_get_contents($filename));
        }
        return false;
    }

    function write($cle, $variable)
    {
        if ( MODE_PROD )
        {
            $filename = $this->dossier_cache . $this->prefixe . md5(''.$cle).'';
            file_put_contents($filename, serialize($variable));
        }
    }

    function clear()
    {
        $files = glob($this->dossier_cache.'*');
        foreach ( $files as $file )
        {
            unlink($file);
        }
    }

    function get_adress($cle)
    {
        $filename = $this->dossier_cache.md5(''.$cle).'';
        return $filename;
    }
}
