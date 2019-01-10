<?php

namespace Spatie\BpostAddressWebservice;

abstract class Issue
{
    /** @var string */
    protected $message;

    /** @var string */
    protected $component;

    public function __construct(string $message, string $component)
    {
        $this->message = $message;
        $this->component = $component;
    }

    public function message(): string
    {
        return $this->message;
    }

    public function component(): string
    {
        return $this->component;
    }
}
