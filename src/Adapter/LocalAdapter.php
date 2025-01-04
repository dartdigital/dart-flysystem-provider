<?php

namespace Dart\Library\Craft\StorageProvider\Adapter;

use craft\flysystem\base\FlysystemFs;
use League\Flysystem\FilesystemAdapter;
use League\Flysystem\Local\LocalFilesystemAdapter;

class LocalAdapter extends FlysystemFs {

    public function __construct(
        public string $location
    ) {
        parent::__construct();
    }

    #[\Override] protected function createAdapter(): FilesystemAdapter
    {
        return new LocalFilesystemAdapter(
            location: $this->location
        );
    }

    #[\Override] protected function invalidateCdnPath(string $path): bool
    {
        // TODO: Implement invalidateCdnPath() method.
        return true;
    }
}