<?php

namespace Dart\Library\Craft\StorageProvider\Adapter;

use craft\flysystem\base\FlysystemFs;
use League\Flysystem\FilesystemAdapter;

class DigitalOceanS3Adapter extends FlysystemFs {

    protected function createAdapter(): FilesystemAdapter
    {
        // TODO: Implement createAdapter() method.
    }

    protected function invalidateCdnPath(string $path): bool
    {
        // TODO: Implement invalidateCdnPath() method.
    }
}