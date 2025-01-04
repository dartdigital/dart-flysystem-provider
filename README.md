# Craft Flysystem Storage

> ⚠️ WARNING: Beta-Version!

A Craft CMS plugin that provides a flexible file storage system. It allows you to use different storage solutions depending on the environment, such as local file storage during development and Amazon S3 in production.

## Features

- **Environment-Specific Storage**: Store files locally or in the cloud (e.g., S3) depending on your environment.
- **Seamless Craft CMS Integration**: Easy to integrate into existing Craft projects.
- **Flexible and Extensible**: Customizable for various storage requirements.

---

## Installation

### Install:  
`composer require dartdigital/craft-flysystem-storage`

### Config
```
// config/craft-storage-provider.php
<?php

use craft\helpers\App;
use Dart\Library\Craft\StorageProvider\Config\Model\LocalAdapterConfig;
use Dart\Library\Craft\StorageProvider\Config\Model\S3AdapterConfig;
use Dart\Library\Craft\StorageProvider\Config\Model\S3ClientConfig;
use Dart\Library\Craft\StorageProvider\Config\Model\S3Credentials;
use Dart\Library\Craft\StorageProvider\Enums\AvailableAdapter;

return [
    '*' => [
        'adapter' => AvailableAdapter::S3,
        's3Settings' => new S3AdapterConfig(
            clientConfig: new S3ClientConfig(
                host: App::parseEnv('$S3_HOST'),
                usePathStyleEndpoint: App::parseBooleanEnv('$S3_USE_PATH_STYLE_ENDPOINT'),
                credentials: new S3Credentials(
                    key: App::parseEnv('$S3_KEY'),
                    secret: App::parseEnv('$S3_SECRET'),
                ),
            ),
            bucket: App::parseEnv('$S3_BUCKET')
        ),
    ],
    'dev' => [
        'adapter' => AvailableAdapter::LOCAL,
        'localSettings' => new LocalAdapterConfig(
            location: App::parseEnv('$LOCAL_STORAGE_LOCATION')
        ),
    ],
];
```

This configuration file defines the storage adapter settings for the Craft Storage Provider plugin. It supports multiple environments, allowing for flexible storage solutions such as using local storage in development and Amazon S3 in production.


Environment Variables for S3
```
BASIS_URL= # Optional: Basis URL for public access to Filesystem. 
S3_HOST= # The host endpoint for the S3-compatible service.
S3_USE_PATH_STYLE_ENDPOINT= # Boolean to toggle path-style endpoints (e.g., MinIO compatibility).
S3_KEY= # Access key for the S3 service.
S3_SECRET= # Secret key for the S3 service.
S3_BUCKET= # Name of the S3 bucket to store files.
```

Environment Variables for Local Storage
	`$LOCAL_STORAGE_LOCATION`: Directory path for storing files locally.


# Local Development

Prerequisites
- Docker Compose: To set up a simple local development environment.

## Setup

Follow these steps to set up the local development environment:

```
docker compose --profile dev up
docker compose exec webserver composer install

docker compose exec webserver cp .env.example.dev .env

docker compose exec webserver php craft setup/app-id
docker compose exec webserver php craft setup/security-key

docker compose exec webserver php craft setup # Configure all default values.
```

Open:
http://localhost

## Minio (S3) Setup

Go to: http://localhost:9001/login
Username: admin
Password: minio-admin

- create Bucket
- create Access Key
- make Bucket public available

## Testing Plugin Changes

Make changes to the code in the src directory. Run the following command to reflect the changes in the CMS:

```
docker compose exec webserver composer update
```

# License

This plugin is licensed under the MIT License.

# Support

If you have any questions or encounter issues, please open an Issue in this repository! 🎉

