<?php
/**
 * General Configuration
 *
 * All of your system's general configuration settings go in here. You can see a
 * list of the available settings in vendor/craftcms/cms/src/config/GeneralConfig.php.
 *
 * @see craft\config\GeneralConfig
 */

return [
    // Global settings
    '*' => [
        // Default Week Start Day (0 = Sunday, 1 = Monday...)
        'defaultWeekStartDay' => 1,

        // Enable CSRF Protection (recommended)
        'enableCsrfProtection' => true,

        // Whether generated URLs should omit "index.php"
        'omitScriptNameInUrls' => true,

        // Control Panel trigger word
        'cpTrigger' => 'admin',
        
        // No admin changes on anything but dev
        'allowAdminChanges' => false,

        // The secure key Craft will use for hashing and encrypting data
        'securityKey' => getenv('SECURITY_KEY'),

        'stagingPassword' => getenv('STAGING_PASSWORD'),
        
        'maxUploadFileSize' => 33554432,

        'enableGql' => false,

        'maxRevisions' => 3,

        'generateTransformsBeforePageLoad' => true,

        'requireMatchingUserAgentForSession' => false,

        'errorTemplatePrefix' => "errors/"
    ],

    // Dev environment settings
    'dev' => [
        // Base site URL
        'siteUrl' => null,

        // Dev Mode (see https://craftcms.com/support/dev-mode)
        'devMode' => true,
        
        // On dev you're allowed to make admin changes
        'allowAdminChanges' => true,

        'enableTemplateCaching' => false
    ],

    // Staging environment settings
    'staging' => [
        // Base site URL
        'siteUrl' => null,
    ],

    // Production environment settings
    'production' => [
        // Base site URL
        'siteUrl' => null,
    ],
];
