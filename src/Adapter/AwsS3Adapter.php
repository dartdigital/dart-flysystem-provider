<?php

namespace Dart\Library\Craft\FlysystemProvider\Adapter;

use Aws\S3\S3Client;
use craft\flysystem\base\FlysystemFs;
use League\Flysystem\AwsS3V3\AwsS3V3Adapter;
use League\Flysystem\FilesystemAdapter;

class AwsS3Adapter extends FlysystemFs {

    public function __construct(
        public array $args,
        public string $bucket,
    ) {
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
        return false;
    }
}