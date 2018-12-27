<?php

namespace Spatie\BpostAddressWebservice;

class Error
{
    /** @var string */
    public $message;

    /** @var string */
    public $component;

    public function __construct(string $message, string $component)
    {
        $this->message = $message;
        $this->component = $component;
    }
}
