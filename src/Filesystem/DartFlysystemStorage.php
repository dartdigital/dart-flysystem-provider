<?php

namespace Dart\Library\Craft\StorageProvider\Filesystem;

use Craft;
use craft\flysystem\base\FlysystemFs;
use Dart\Library\Craft\StorageProvider\Plugin;
use Dart\Library\Craft\StorageProvider\Exceptions\CraftStorageProviderException;
use Dart\Library\Craft\StorageProvider\Models\StorageProviderSettings;
use League\Flysystem\FilesystemAdapter;
use Override;

class DartFlysystemStorage extends FlysystemFs
{
    private StorageProviderSettings $settings;

    public string $configurationHandle = '';

    /**
     * @throws CraftStorageProviderException
     * @param array<string|int, mixed> $config
     */
    public function __construct(
        array $config = []
    )
    {
        Craft::info(
            message: "initializing CraftFlysystemStorage",
            category: 'filesystem'
        );

        $settings = Plugin::getInstance()?->getSettings();
        if ($settings instanceof StorageProviderSettings) {
            $this->settings = $settings;
        } else {
            Craft::error(
                message: 'Invalid settings',
                category: 'filesystem'
            );
            throw new CraftStorageProviderException(
                message: 'Invalid settings'
            );
        }
        parent::__construct($config);
    }

    /**
     * @inheritDoc
     */
    #[Override] protected function createAdapter(): FilesystemAdapter
    {
        return  $this->settings->getAdapterForConfig($this->configurationHandle)->createAdapter();
    }

    /**
     * @inheritDoc
     */
    #[Override] protected function invalidateCdnPath(string $path): bool
    {
        Craft::info(
            message: "invalidating CDN path: $path",
            category: 'filesystem'
        );
        return true;
    }

    /**
     * @inheritdoc
     */
    public function getSettingsHtml(): ?string
    {
        return Craft::$app->getView()->renderTemplate('craft-storage-provider/settings', ['filesystems' => $this->settings->getAvailableConfigHandles(), 'fs' => $this]);
    }
}