<?php

use craft\helpers\App;
use Dart\Library\Craft\FlysystemProvider\Adapter\CloudflareR2Adapter;
use Dart\Library\Craft\FlysystemProvider\Adapter\DigitalOceanS3Adapter;
use Dart\Library\Craft\FlysystemProvider\Adapter\FlysystemAdapter;
use Dart\Library\Craft\FlysystemProvider\Adapter\GoogleCloudStorageAdapter;
use Dart\Library\Craft\FlysystemProvider\Adapter\LocalAdapter;
use Dart\Library\Craft\FlysystemProvider\Adapter\S3Adapter;
use Google\Cloud\Storage\StorageClient;
use League\Flysystem\Ftp\FtpConnectionOptions;
use League\Flysystem\Ftp\FtpAdapter;

return [
    '*' => [
        'adapterConfigs' => [
            #'<anyName>' => new <*>Adapter(
            #    any Adapter which extends craft\flysystem\base\FlysystemFs
            #    [...]
            #),
            'digitalOcean' => new DigitalOceanS3Adapter(
                accessKeyId: App::parseEnv('$DIGITAL_OCEAN_KEY_ID'),
                secretAccessKey: App::parseEnv('$DIGITAL_OCEAN_SECRET_ACCESS_KEY'),
                region: App::parseEnv('$DIGITAL_OCEAN_REGION'),
                bucket: App::parseEnv('$DIGITAL_OCEAN_BUCKET'),
            ),
            'googleCloudStorage' => new GoogleCloudStorageAdapter(
                storageClient: new StorageClient([
                    'projectId' => App::parseEnv('$GOOGLE_CLOUD_STORAGE_PROJECT_ID'),
                    'keyFilePath' => App::parseEnv('$GOOGLE_CLOUD_STORAGE_KEY_FILE_PATH'),
                ]),
                bucket: App::parseEnv('$GOOGLE_CLOUD_STORAGE_BUCKET'),
            ),
            'cloudflareR2' => new CloudflareR2Adapter(
                accountId: App::parseEnv('$CLOUDFLARE_R2_ACCOUNT_ID'),
                accessKeyId: App::parseEnv('$CLOUDFLARE_R2_ACCESS_KEY_ID'),
                secretAccessKey: App::parseEnv('$CLOUDFLARE_R2_SECRET_ACCESS_KEY'),
                bucket: App::parseEnv('$CLOUDFLARE_R2_BUCKET'),
                eu: App::parseBooleanEnv('$CLOUDFLARE_R2_EU_ENABLED'),
            ),
            'commonS3' => new S3Adapter(
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
            'customFlysystem' => new FlysystemAdapter(
                # use all Flysystem Adapters here or write your own 🥳: https://flysystem.thephpleague.com/docs/
                # filesystemAdapter: new League\Flysystem\Local\LocalFilesystemAdapter('/var/www/html/web/local')
                # filesystemAdapter: new League\Flysystem\InMemory\InMemoryFilesystemAdapter();
                filesystemAdapter: new FtpAdapter(
                    FtpConnectionOptions::fromArray([
                        'host' => App::parseEnv('$FTP_HOST'),
                        'root' => App::parseEnv('$FTP_ROOT'),
                        'username' => App::parseEnv('$FTP_USERNAME'),
                        'password' => App::parseEnv('$FTP_PASSWORD'),
                        'port' => (int)App::parseEnv('$FTP_PORT'),
                    ])
                )
            ),
        ],
    ],
    'dev' => [
        'adapterConfigs' => [
            'digitalOcean' => new LocalAdapter(
                location: App::parseEnv('$LOCAL_STORAGE_LOCATION') . '/digitalOcean'
            ),
            'googleCloudStorage' => new LocalAdapter(
                location: App::parseEnv('$LOCAL_STORAGE_LOCATION') . '/googleCloudStorage'
            ),
            'cloudflareR2' => new LocalAdapter(
                location: App::parseEnv('$LOCAL_STORAGE_LOCATION') . '/cloudflareR2'
            ),
            'commonS3' => new LocalAdapter(
                location: App::parseEnv('$LOCAL_STORAGE_LOCATION') . '/commonS3'
            ),
            'customFlysystem' => new LocalAdapter(
                location: App::parseEnv('$LOCAL_STORAGE_LOCATION') . '/customFlysystem'
            ),
        ],
    ],
];