<?php

namespace Dart\Library\Craft\StorageProvider\Exceptions;

use Throwable;

class CraftStorageProviderException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}