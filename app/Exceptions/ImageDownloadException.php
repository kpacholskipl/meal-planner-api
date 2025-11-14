<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class ImageDownloadException extends Exception
{
    public function __construct(
        string $message = "Failed to download image",
        int $code = 0,
        ?Throwable $previous = null,
        protected ?string $url = null
    ) {
        parent::__construct($message, $code, $previous);
    }
    
    public function getUrl(): ?string
    {
        return $this->url;
    }
}
