<?php

namespace Dart\Library\Craft\FlysystemProvider\Adapter;

use craft\flysystem\base\FlysystemFs;
use Google\Cloud\Storage\StorageClient;
use League\Flysystem\FilesystemAdapter;
use League\Flysystem\GoogleCloudStorage\GoogleCloudStorageAdapter as FlysystemGoogleCloudStorageAdapter;

class GoogleCloudStorageAdapter extends FlysystemFs {

    public function __construct(
        public StorageClient $storageClient,
        public string $bucket,
        public string $optionalPrefix = '',
    ) {
        parent::__construct();
    }

    #[\Override] protected function createAdapter(): FilesystemAdapter
    {
        $googleStorageBucket = $this->storageClient->bucket($this->bucket);
        return new FlysystemGoogleCloudStorageAdapter($googleStorageBucket, $this->optionalPrefix);
    }

    #[\Override] protected function invalidateCdnPath(string $path): bool
    {
        return false;
    }
}