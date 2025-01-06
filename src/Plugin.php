<?php

namespace Dart\Library\Craft\FlysystemProvider;

use Craft;
use craft\base\Model;
use craft\events\RegisterComponentTypesEvent;
use craft\services\Fs;
use Dart\Library\Craft\FlysystemProvider\Filesystem\DartFlysystemStorage;
use Dart\Library\Craft\FlysystemProvider\Models\StorageProviderSettings;
use Override;
use yii\base\Event;

class Plugin extends \craft\base\Plugin
{
    public bool $hasCpSettings = false;

    #[Override] public function init(): void
    {
        parent::init();

        Event::on(
            Fs::class,
            Fs::EVENT_REGISTER_FILESYSTEM_TYPES,
            function(RegisterComponentTypesEvent $event) {
                Craft::info('Registering DartFlysystemProvider', 'filesystem');
                $event->types[] = DartFlysystemStorage::class;
            }
        );
    }

    #[Override] protected function createSettingsModel(): ?Model
    {
        return new StorageProviderSettings();
    }
}