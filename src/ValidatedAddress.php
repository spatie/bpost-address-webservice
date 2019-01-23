<?php

namespace Spatie\BpostAddressWebservice;

/**
 * @property string streetName
 * @property string streetNumber
 * @property string boxNumber
 * @property string postalCode
 * @property string municipalityName
 * @property string country
 */
class ValidatedAddress
{
    /** @var \Spatie\BpostAddressWebservice\Address */
    private $validatedAddress;

    /** @var \Spatie\BpostAddressWebservice\Address */
    private $originalAddress;

    /** @var \Spatie\BpostAddressWebservice\Error[] */
    private $errors;

    /** @var \Spatie\BpostAddressWebservice\Warning[] */
    private $warnings;

    public function __construct(
        Address $validatedAddress,
        Address $originalAddress,
        array $errors,
        array $warnings
    ) {
        $this->validatedAddress = $validatedAddress;
        $this->originalAddress = $originalAddress;
        $this->errors = $errors;
        $this->warnings = $warnings;
    }

    public function hasErrors(): bool
    {
        return count($this->errors) > 0;
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function hasWarnings(): bool
    {
        return count($this->warnings) > 0;
    }

    public function warnings(): array
    {
        return $this->warnings;
    }

    public function hasIssues(): bool
    {
        return $this->hasWarnings() || $this->hasErrors();
    }

    public function issues(): array
    {
        return array_merge($this->warnings, $this->errors);
    }

    public function originalAddress(): Address
    {
        return $this->originalAddress;
    }

    public function toArray(): array
    {
        return $this->validatedAddress->toArray();
    }

    public function __get(string $key): string
    {
        return $this->toArray()[$key];
    }
}
