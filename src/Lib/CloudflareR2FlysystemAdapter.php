<?php

namespace Dart\Library\Craft\FlysystemProvider\Lib;

use League\Flysystem\AwsS3V3\AwsS3V3Adapter;
use League\Flysystem\FileAttributes;
use League\Flysystem\Visibility;
use Override;

class CloudflareR2FlysystemAdapter extends AwsS3V3Adapter {
    #[Override] public function visibility(string $path): FileAttributes
    {
        return new FileAttributes($path, null, Visibility::PRIVATE);
    }
}