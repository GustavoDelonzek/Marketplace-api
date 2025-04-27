<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

abstract class BaseApiException extends Exception
{
    protected string $defaultMessage;
    protected int $defaultStatusCode;

    public function __construct(string $message = null)
    {
        $this->defaultMessage = $message ?? $this->getDefaultMessage();
        $this->defaultStatusCode = $this->getDefaultStatusCode();

        parent::__construct($this->defaultMessage, $this->defaultStatusCode);
    }

    abstract protected function getDefaultMessage(): string;
    abstract protected function getDefaultStatusCode(): int;

    public function render():JsonResponse
    {
        return response()->json([
            'message' => $this->defaultMessage
        ], $this->defaultStatusCode);
    }


}
