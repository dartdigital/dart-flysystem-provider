<?php

namespace Dart\Library\Craft\FlysystemProvider\Models;

use craft\base\Model;
use craft\flysystem\base\FlysystemFs;

class StorageProviderSettings extends Model
{
    public array $adapterConfigs;

    public function getAvailableConfigHandles(): array
    {
        return array_keys($this->adapterConfigs);
    }

    public function getAdapterForConfig(string $selectedConfig): FlysystemFs | null
    {
        return $this->adapterConfigs[$selectedConfig] ?? null;
    }
}