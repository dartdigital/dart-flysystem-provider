<?php
/**
 * Yii Application Config
 *
 * Edit this file at your own risk!
 *
 * The array returned by this file will get merged with
 * vendor/craftcms/cms/src/config/app.php and app.[web|console].php, when
 * Craft's bootstrap script is defining the configuration for the entire
 * application.
 *
 * You can define custom modules and system components, and even override the
 * built-in system components.
 *
 * If you want to modify the application config for *only* web requests or
 * *only* console requests, create an app.web.php or app.console.php file in
 * your config/ folder, alongside this one.
 * 
 * Read more about application configuration:
 * https://craftcms.com/docs/4.x/config/app.html
 */

use craft\helpers\App;
use craft\log\MonologTarget;
use Dart\Library\Craft\StorageProvider\Filesystem\CraftFlysystemStorage;
use Psr\Log\LogLevel;
use yii\log\FileTarget;

return [
    'id' => App::env('CRAFT_APP_ID') ?: 'CraftCMS',
    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => MonologTarget::class,
                    'name' => 'craft-storage-provider',
                    'extractExceptionTrace' => !App::devMode(),
                    'allowLineBreaks' => App::devMode(),
                    'level' => App::devMode() ? LogLevel::INFO : LogLevel::WARNING,
                    'categories' => ['filesystem'],
                    'logContext' => false,
                ],
            ],
        ]
    ]
];
