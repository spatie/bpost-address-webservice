<?php

namespace Spatie\BpostAddressWebservice;

/**
 * @property string streetName
 * @property string streetNumber
 * @property string boxNumber
 * @property string postalCode
 * @property string municipalityName
 * @property string country
 * @property array issues
 */
class ValidatedAddress
{
    /** @var \Spatie\BpostAddressWebservice\Address */
    public $validatedAddress;

    /** @var \Spatie\BpostAddressWebservice\Address */
    public $originalAddress;

    /** @var \Spatie\BpostAddressWebservice\Issues\Error[] */
    public $errors;

    /** @var \Spatie\BpostAddressWebservice\Issues\Warning[] */
    public $warnings;

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

    public function __get(string $key)
    {
        if ($key === 'issues') {
            return $this->issues;
        }

        return $this->toArray()[$key];
    }

    public function hasErrors(): bool
    {
        return count($this->errors) > 0;
    }

    public function hasWarnings(): bool
    {
        return count($this->warnings) > 0;
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
}
