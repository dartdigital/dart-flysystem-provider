<?php

use craft\helpers\App;
use Dart\Library\Craft\StorageProvider\Adapter\LocalAdapter;
use Dart\Library\Craft\StorageProvider\Adapter\S3Adapter;

return [
    '*' => [
        'adapterConfigs' => [
            'main' => new S3Adapter(
                args: [
                    'endpoint' => App::parseEnv('$S3_HOST'),
                    'use_path_style_endpoint' => App::parseBooleanEnv('$S3_USE_PATH_STYLE_ENDPOINT'),
                    'credentials' => [
                        'key' => App::parseEnv('$S3_KEY'),
                        'secret' => App::parseEnv('$S3_SECRET'),
                    ],
                ],
                bucket: App::parseEnv('$S3_BUCKET')
            ),
            'videos' => new S3Adapter(
                args: [
                    'endpoint' => App::parseEnv('$S3_HOST'),
                    'use_path_style_endpoint' => App::parseBooleanEnv('$S3_USE_PATH_STYLE_ENDPOINT'),
                    'credentials' => [
                        'key' => App::parseEnv('$S3_KEY'),
                        'secret' => App::parseEnv('$S3_SECRET'),
                    ],
                ],
                bucket: App::parseEnv('$S3_BUCKET')
            ),
        ],
    ],
    'dev' => [
        'adapterConfigs' => [
            'main' => new LocalAdapter(
                location: App::parseEnv('$LOCAL_STORAGE_LOCATION')
            ),
            'videos' => new LocalAdapter(
                location: App::parseEnv('$LOCAL_STORAGE_LOCATION')
            ),
        ],
    ],
];