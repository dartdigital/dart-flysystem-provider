<?php

namespace Dart\Library\Craft\StorageProvider\Adapter;

use Aws\S3\S3Client;
use craft\flysystem\base\FlysystemFs;
use League\Flysystem\AwsS3V3\AwsS3V3Adapter;
use League\Flysystem\FilesystemAdapter;

class S3Adapter extends FlysystemFs {

    public function __construct(
        public array $args,
        public string $bucket,
    ) {
        // Set some default's for cleaner config.
        $this->args['region'] = $this->args['region'] ?? 'us-east-1';
        $this->args['version'] = $this->args['version'] ?? 'latest';

        parent::__construct();
    }

    #[\Override] protected function createAdapter(): FilesystemAdapter
    {
        return new AwsS3V3Adapter(
            new S3Client($this->args),
            $this->bucket
        );
    }

    #[\Override] protected function invalidateCdnPath(string $path): bool
    {
        return true;
    }
}