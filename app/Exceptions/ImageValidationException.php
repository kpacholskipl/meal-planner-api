<?php

declare(strict_types=1);

namespace App\Exceptions;

class ImageValidationException extends \RuntimeException
{
    public function __construct(
        string $message = "Image validation failed",
        int $code = 400,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
