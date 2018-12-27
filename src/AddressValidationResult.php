<?php

namespace Spatie\BpostAddressWebservice;

use GuzzleHttp\Psr7\Response;

class AddressValidationResult
{
    /** @var \Spatie\BpostAddressWebservice\Warning[] */
    protected $warnings;

    /** @var \Spatie\BpostAddressWebservice\Error[] */
    protected $errors;

    /** @var \Spatie\BpostAddressWebservice\Address */
    protected $validatedAddress;

    /** @var \Spatie\BpostAddressWebservice\Address */
    protected $originalAddress;

    public function __construct(array $validationResult, Address $originalAddress)
    {
        [$this->warnings, $this->errors] = $this->parseErrors($validationResult['Error'] ?? []);

        $this->validatedAddress = Address::createFromBpostArray($validationResult['ValidatedAddressList']['ValidatedAddress'][0]);

        $this->originalAddress = $originalAddress;
    }

    public function originalAddress(): Address
    {
        return $this->originalAddress;
    }

    public function validatedAddress(): Address
    {
        return $this->validatedAddress;
    }

    public function issues(): array
    {
        return array_merge($warnings, $errors);
    }

    public function hasIssues(): bool
    {
        return ! (empty($this->warnings) && empty($this->errors));
    }

    public function warnings(): array
    {
        return $this->warnings;
    }

    public function hasWarnings(): bool
    {
        return ! empty($this->warnings);
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function hasErrors(): bool
    {
        return ! empty($this->errors);
    }

    protected function parseErrors(array $errorsInResponse): array
    {
        $warnings = [];
        $errors = [];

        foreach ($errorsInResponse as $error) {
            if ($error['ErrorSeverity'] === 'warning') {
                $warnings[] = new Warning($error['ErrorCode'], $error['ComponentRef']);
            }

            if ($error['ErrorSeverity'] === 'error') {
                $errors[] = new Error($error['ErrorCode'], $error['ComponentRef']);
            }
        }

        return [$warnings, $errors];
    }
}
