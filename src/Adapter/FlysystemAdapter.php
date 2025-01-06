<?php

namespace Dart\Library\Craft\FlysystemProvider\Adapter;

use craft\flysystem\base\FlysystemFs;
use League\Flysystem\FilesystemAdapter;

class FlysystemAdapter extends FlysystemFs {

    public function __construct(
        public FilesystemAdapter $filesystemAdapter,
    ) {
        parent::__construct();
    }

    #[\Override] protected function createAdapter(): FilesystemAdapter
    {
        return $this->filesystemAdapter;
    }

    #[\Override] protected function invalidateCdnPath(string $path): bool
    {
        return true;
    }
}