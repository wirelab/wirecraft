<?php
/**
 * Site module for Craft CMS 3.x
 *
 * Custom site module
 *
 * @link      https://wirelab107.com
 * @copyright Copyright (c) 2019 wirelab107
 */

namespace modules\sitemodule;

use craft\events\RegisterUrlRulesEvent;
use craft\helpers\UrlHelper;
use craft\services\Plugins;
use craft\web\UrlManager;
use modules\sitemodule\services\Helper;
use modules\sitemodule\twig\MixExtension;
use modules\sitemodule\variables\SiteVariable;

use Craft;
use craft\events\RegisterTemplateRootsEvent;
use craft\events\TemplateEvent;
use craft\i18n\PhpMessageSource;
use craft\web\twig\variables\CraftVariable;
use craft\web\View;

use yii\base\Event;
use yii\base\InvalidConfigException;
use yii\base\Module;
use yii\web\Cookie;

/**
 * Class SiteModule
 *
 * @author    wirelab107
 * @package   SiteModule
 * @since     1.0.0
 *
 * @property Helper helper
 */
class SiteModule extends Module
{
    /**
     * @var SiteModule
     */
    public static $instance;

    /**
     * @inheritdoc
     */
    public function __construct($id, $parent = null, array $config = [])
    {
        Craft::setAlias('@modules/sitemodule', $this->getBasePath());

        if(Craft::$app->getRequest()->isConsoleRequest) {
            $this->controllerNamespace = 'modules\sitemodule\console\controllers';
        } else {
            $this->controllerNamespace = 'modules\sitemodule\controllers';
        }

        // Translation category
        $i18n = Craft::$app->getI18n();
        /** @noinspection UnSafeIsSetOverArrayInspection */
        if (!isset($i18n->translations[$id]) && !isset($i18n->translations[$id.'*'])) {
            $i18n->translations[$id] = [
                'class' => PhpMessageSource::class,
                'sourceLanguage' => 'en-US',
                'basePath' => '@modules/sitemodule/translations',
                'forceTranslation' => true,
                'allowOverrides' => true,
            ];
        }

        // Base template directory
        Event::on(View::class, View::EVENT_REGISTER_CP_TEMPLATE_ROOTS, function (RegisterTemplateRootsEvent $e) {
            if (is_dir($baseDir = $this->getBasePath().DIRECTORY_SEPARATOR.'templates')) {
                $e->roots[$this->id] = $baseDir;
            }
        });

        // Set this as the global instance of this module class
        static::setInstance($this);

        parent::__construct($id, $parent, $config);
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$instance = $this;

        // Register our components
        $this->setComponents([
            'helper' => [
                'class' => Helper::class,
            ]
        ]);

        // Register our variables
        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('site', SiteVariable::class);
            }
        );

        // Include template roots
        Event::on(View::class, View::EVENT_REGISTER_SITE_TEMPLATE_ROOTS, function (RegisterTemplateRootsEvent $e) {
            if (is_dir($baseDir = $this->getBasePath().DIRECTORY_SEPARATOR.'templates')) {
                $e->roots[$this->id] = $baseDir;
            }
        });

        $this->_registerTwigExtensions();
        $this->_registerRoutes();
        $this->_protectStaging();
    }

    private function _registerRoutes(): void
    {
        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_SITE_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
                $event->rules['api/cookies'] = 'site-module/cookie/consent';
                $event->rules['utils/staging_access'] = 'site-module/access/form';
//                $event->rules['utils/staging_access/answer'] = 'site-module/access/answer';
            }
        );
    }

    private function _registerTwigExtensions()
    {
        if(!Craft::$app->request->getIsSiteRequest()) return;
        Craft::$app->view->registerTwigExtension(new MixExtension());
    }

    private function _protectStaging()
    {
        Event::on(Plugins::class, Plugins::EVENT_AFTER_LOAD_PLUGINS, function(Event $event) {
            $request = Craft::$app->getRequest();
            $configService = Craft::$app->getConfig();
            $user = Craft::$app->getUser()->getIdentity();
            $token = $request->getToken();
            $stagingPassword = $configService->general->stagingPassword;

            // Only enable on staging and if password was set
//            if($configService->env !== 'staging' || $stagingPassword === null) {
//                return;
//            }

            // Console and Live Preview requests are fine. Also check for cross-site preview tokens
            if ($request->getIsConsoleRequest() || ($request->getIsLivePreview() || $token !== null || $request->getIsPreview())) {
                return;
            }

            // Only site requests are blocked and for guests
            if (!$request->getIsSiteRequest() || $user) {
                return;
            }

            $url = $request->getAbsoluteUrl();
            $cookie = $request->getCookies()->get('stagingAccess');
            $loginPath = UrlHelper::siteUrl('utils/staging_access');
            $urlPassword = $request->get('stagingPassword');

            // Check for the site access cookie, and check we're not causing a loop
            if ($cookie != '' || stripos($url, $loginPath) !== false) {
                return;
            }

            // Token doesnt exist or doesn't match staging
            if($urlPassword !== $stagingPassword) {
                Craft::$app->getSession()->set('redirect', $url);

                Craft::$app->getResponse()->redirect($loginPath);
                Craft::$app->end();
            }

            // Everything checks out
            $cookie = new Cookie();
            $cookie->name = 'stagingAccess';
            $cookie->value = true;
            $cookie->expire = time() + 3600;

            Craft::$app->getResponse()->getCookies()->add($cookie);
        });

    }
}
