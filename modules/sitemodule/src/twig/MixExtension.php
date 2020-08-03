<?php

namespace modules\sitemodule\twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Twig extension for the Laravel Mix component.
 *
 * @author Anas Mazouni <hello@stormix.co>
 */
class MixExtension extends AbstractExtension
{
    protected $publicDir;
    protected $baseDir;
    protected $manifestName;
    protected $manifest;

    public function __construct($publicDir = "/web", $manifestName = 'mix-manifest.json')
    {
        $this->baseDir = CRAFT_BASE_PATH;
        $this->publicDir = $publicDir;
        $this->manifestName = $manifestName;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('mix', [$this, 'getVersionedFilePath']),
        ];
    }

    /**
     * Gets the public url/path to a versioned Mix file.
     *
     * @param string $file
     *
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    public function getVersionedFilePath($file)
    {
        $manifest = $this->getManifest();

        if (!isset($manifest[$file])) {
            throw new \InvalidArgumentException("File {$file} not defined in asset manifest.");
        }

        //Only return the file path relative to the public folder (e.g css/style.css) and not (/public/css/style)
        return str_replace($this->publicDir, '', $manifest[$file]);
    }

    /**
     * Returns the manifest file content as array.
     *
     * @return array
     */
    protected function getManifest()
    {
        if (null === $this->manifest) {
            $manifestPath = $this->baseDir."/$this->publicDir/".$this->manifestName;
            $this->manifest = json_decode(file_get_contents($manifestPath), true);
        }

        return $this->manifest;
    }

    public function getName()
    {
        return 'Mix';
    }
}