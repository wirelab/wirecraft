<?php
/**
 * Site module for Craft CMS 3.x
 *
 * Custom site module
 *
 * @link      https://wirelab107.com
 * @copyright Copyright (c) 2019 wirelab107
 */

namespace modules\sitemodule\console\controllers;

use craft\helpers\Console;
use craft\helpers\StringHelper;
use PWGen\PWGen;
use yii\console\ExitCode;
use yii\console\Controller;
use Craft;

class SetupController extends Controller {

    /**
     * Generates a password for staging environments
     *
     * @return int
     */
    public function actionStagingPassword()
    {
        if(Craft::$app->getConfig()->env !== 'staging') {
            $this->stderr('The current environment is not set to staging, check .env config');
        }

        $this->stdout('Generating a staging password... ' . PHP_EOL, Console::FG_YELLOW);
        $factory = new PWGen();
        $password = $factory->generate();

        if (!$this->_setEnvVar('STAGING_PASSWORD', $password)) {
            return ExitCode::UNSPECIFIED_ERROR;
        }

        $this->stdout("done staging password is: ({$password})" . PHP_EOL, Console::FG_YELLOW);

        return ExitCode::OK;
    }

    private function _setEnvVar($name, $value)
    {
        try {
            Craft::$app->getConfig()->setDotEnvVar($name, $value);
            return true;
        } catch (\Throwable $e) {
            $this->stderr("Unable to set {$name}: {$e->getMessage()}" . PHP_EOL, Console::FG_RED);
            return false;
        }
    }
}