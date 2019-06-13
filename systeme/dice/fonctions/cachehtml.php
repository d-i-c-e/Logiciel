<?php

class Cachehtml
{

    private $dossier_cache;
    private $cache_cle;
    private $cat;
    private $compression_html;

    private function set_cache_cle($cle)
    {
        $this->cache_cle = $this->dossier_cache.md5(( isset($_SERVER['HTTPS']) ? 1 : 0 ).'_'.$_SERVER['SERVER_NAME'].'_'.$_SERVER['REQUEST_URI'].'_'.$this->cat.'_'.$cle);
    }

    function __construct($cat='', $dossier_cache='1') //Possibilité de catégoriser les pages ...
    {
        $this->dossier_cache = __DIR__ . '/../cache/';
        if (!file_exists($this->dossier_cache))
        {
            mkdir($this->dossier_cache);
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
            mkdir($this->dossier_cache);
        }
        $this->cat = $cat;
        $this->compression_html = false;
    }

    function activer_compression_html()
    {
        if (MODE_PROD)
        {
            $this->compression_html = true;
        }
    }

    function start($cle='', $duree=DUREE_CACHE_MINUTES)
    {
        $this->set_cache_cle($cle);
        if ( file_exists($this->cache_cle) )
        {
            if ( time() - filemtime($this->cache_cle)<$duree*60 )
            {
                $r = readfile($this->cache_cle);
                if ($r!==false)
                {
                    return true;
                }
            }
        }
        ob_start();
        return false;
    }

    function end()
    {
        $content = ob_get_clean();
        if ( $this->compression_html )
        {
            // suppression des tabulations
            $content = str_replace("\t", ' ', $content);
            // réduction des doubles espaces
            $d1 = 0;
            $d2 = strlen($content);
            while ($d1!=$d2)
            {
                $d1 = $d2;
                $content = str_replace('  ', ' ', $content);
                $d2 = strlen($content);
            }
            // suppression des retours à la lignes inutiles
            $content = str_replace("\r\n", "\n", $content);
            $content = str_replace("\n ", "\n", $content);
            $d1 = 0;
            $d2 = strlen($content);
            while ($d1!=$d2)
            {
                $d1 = $d2;
                $content = str_replace("\n\n", "\n", $content);
                $d2 = strlen($content);
            }
        }
        if ( MODE_PROD )
        {
            file_put_contents($this->cache_cle, $content);
        }
        else
        {
            global $desactivation_actualisation_outils_developpeur;
            if (!isset($desactivation_actualisation_outils_developpeur) || ! $desactivation_actualisation_outils_developpeur)
            {
                mise_a_jour_fichier_developpeur();
            }
        }
        echo $content;
    }

    function clear() //sppression differée
    {
        $files = glob($this->dossier_cache.'*');
        $fichier_a_suppression = true;
        while ( $fichier_a_suppression )
        {
            $fichier_a_suppression = false;
            foreach ( $files as $file )
            {
                $r = unlink($file);
                if ($r===false)
                {
                    $fichier_a_suppression = true;
                }
            }
        }
        clearstatcache();
    }

    function clear_current_page($cle='')
    {
        $this->set_cache_cle($cle);
        @unlink($this->cache_cle);
        clearstatcache();
    }

}
