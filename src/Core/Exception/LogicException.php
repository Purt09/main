<?php

namespace App\Core\Exception;

class LogicException extends \LogicException
{
    protected string $detail;
    protected ?string $help;

    public function __construct(string $message = '', string $detail = '', string $help = null, int $code = 400, \Throwable $previous = null)
    {
        $this->detail = $detail;
        $this->help = $help;
        parent::__construct($message, $code, $previous);
    }

    public function getDetail(): string
    {
        return $this->detail;
    }

    public function getHelp(): ?string
    {
        return $this->help;
    }
}
