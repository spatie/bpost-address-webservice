<?php

namespace Spatie\BpostAddressWebservice;

class ValidatedAddress
{
    /** @var \Spatie\BpostAddressWebservice\Address */
    protected $validatedAddress;

    /** @var \Spatie\BpostAddressWebservice\Address */
    public $originalAddress;

    /** @var \Spatie\BpostAddressWebservice\Warning[] */
    public $warnings;

    /** @var \Spatie\BpostAddressWebservice\Error[] */
    public $errors;

    public function __get(string $key)
    {

    }
}
