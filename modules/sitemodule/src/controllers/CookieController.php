<?php
/**
 * site module for Craft CMS 3.x
 *
 * Site functionality
 *
 * @link      wirelab.nl
 * @copyright Copyright (c) 2020 Len van Essen
 */

namespace modules\sitemodule\controllers;

use Craft;
use craft\web\Controller;

/**
 * @author    Len van Essen
 * @package   SiteModule
 * @since     1.0.0
 */
class CookieController extends Controller
{
    protected $allowAnonymous = ['consent'];

    public function actionConsent()
    {
        $domain = Craft::$app->getConfig()->getGeneral()->defaultCookieDomain;
        $expire = (int) time() + (86400 * 365);
        $name = 'cconsent';
        $path = '/';
        $httpOnly = false;
        $value = Craft::$app->getRequest()->getParam('accepted');
        $sameSite = null;
        $secure = false;

        if (PHP_VERSION_ID >= 70300) {
            setcookie($name, $value, [
                'expires' => $expire,
                'path' => $path,
                'domain' => $domain,
                'secure' => true,
                'httponly' => $httpOnly,
                'samesite' => $sameSite
            ]);
        } else {
            setcookie($name, $value, $expire, $path, $domain, $secure, $httpOnly);
        }

        $_COOKIE[$name] = $value;
    }
}