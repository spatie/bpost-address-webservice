<?php

namespace Spatie\BpostAddressWebservice;

abstract class Issue
{
    /** @var string */
    protected $message;

    /** @var string */
    protected $attribute;

    public function __construct(string $message, string $attribute)
    {
        $this->message = $message;
        $this->attribute = $attribute;
    }

    public function message(): string
    {
        return $this->message;
    }

    public function attribute(): string
    {
        return $this->attribute;
    }
}
