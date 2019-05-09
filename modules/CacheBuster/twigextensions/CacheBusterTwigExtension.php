<?php
/**
 * test module for Craft CMS 3.x
 *
 * test
 *
 * @link      test.nl
 * @copyright Copyright (c) 2018 test
 */

namespace modules\cachebuster\twigextensions;

use modules\testmodule\TestModule;

use Craft;

/**
 * Twig can be extended in many ways; you can add extra tags, filters, tests, operators,
 * global variables, and functions. You can even extend the parser itself with
 * node visitors.
 *
 * http://twig.sensiolabs.org/doc/advanced.html
 *
 * @author    test
 * @package   TestModule
 * @since     1.0.0
 */
class CacheBusterTwigExtension extends \Twig_Extension
{
    // Public Methods
    // =========================================================================

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'CacheBuster';
    }

    /**
     * Returns an array of Twig filters, used in Twig templates via:
     *
     *
     * @return array
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('bustThatCache', [$this, 'bustThatCache']),
        ];
    }

    /**
     * Our function called via Twig; it can do anything you want
     *
     * @param null $text
     *
     * @return string
     */
    public function bustThatCache($file = null)
    {
        // If not in production always return random time-based number
        if(CRAFT_ENVIRONMENT !== 'production') {
            return $file . '?v=' . time();
        }

        $packageJson = CRAFT_BASE_PATH . '/package.json';

        // Assert we have something to read the file from
        if(! file_exists($packageJson)) return $file;

        $packageJson = json_decode(file_get_contents($packageJson), true);

        // Make sure version is set
        $version = $packageJson['version'] ?? '1.0.0';

        return $file . "?v=$version";
    }
}
