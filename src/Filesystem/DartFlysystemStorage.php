<?php

namespace Dart\Library\Craft\FlysystemProvider\Filesystem;

use Craft;
use craft\flysystem\base\FlysystemFs;
use Dart\Library\Craft\FlysystemProvider\Plugin;
use Dart\Library\Craft\FlysystemProvider\Exceptions\DartStorageProviderException;
use Dart\Library\Craft\FlysystemProvider\Models\StorageProviderSettings;
use League\Flysystem\FilesystemAdapter;
use Override;

class DartFlysystemStorage extends FlysystemFs
{
    private StorageProviderSettings $settings;

    public string $configurationHandle = '';

    /**
     * @param array<string|int, mixed> $config
     *@throws DartStorageProviderException
     */
    public function __construct(
        array $config = []
    )
    {
        Craft::info(
            message: "initializing DartFlysystemProvider",
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
            throw new DartStorageProviderException(
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
        // @todo Fehlerhandling
        return  $this->settings->getAdapterForConfig($this->configurationHandle)->createAdapter();
    }

    /**
     * @inheritDoc
     */
    #[Override] protected function invalidateCdnPath(string $path): bool
    {
        // @todo Fehlerhandling
        return  $this->settings->getAdapterForConfig($this->configurationHandle)->invalidateCdnPath($path);
    }

    /**
     * @inheritdoc
     */
    public function getSettingsHtml(): ?string
    {
        return Craft::$app->getView()->renderTemplate('dart-flysystem-provider/settings', ['filesystems' => $this->settings->getAvailableConfigHandles(), 'fs' => $this]);
    }
}