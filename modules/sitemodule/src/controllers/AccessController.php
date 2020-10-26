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
class AccessController extends Controller
{
    protected $allowAnonymous = ['form'];

    public function actionForm()
    {
        $view = $this->getView();
        $view->setTemplateMode($view::TEMPLATE_MODE_CP);

        $redirect = Craft::$app->getSession()->get('redirect');

        $data['redirect'] = $redirect ?? '/';

        $this->renderTemplate('site-module/staging_access', $data);
    }
}