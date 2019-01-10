<?php

namespace Spatie\BpostAddressWebservice;

use GuzzleHttp\Psr7\Response;
use Spatie\BpostAddressWebservice\Requests\ValidateAddressesRequest;

class ValidateAddressesResponse
{
    /** @var \Spatie\BpostAddressWebservice\Address */
    protected $validatedAddress;

    /** @var \Spatie\BpostAddressWebservice\Address */
    protected $originalAddress;

    /** @var \Spatie\BpostAddressWebservice\Warning[] */
    protected $warnings;

    /** @var \Spatie\BpostAddressWebservice\Error[] */
    protected $errors;

    public function __construct(
        Address $validatedAddress,
        Address $originalAddress,
        array $warnings,
        array $errors
    ) {
        $this->validatedAddress = $validatedAddress;
        $this->originalAddress = $originalAddress;
        $this->warnings = $warnings;
        $this->errors = $errors;
    }

    public static function fromResponse(array $response, ValidateAddressesRequest $validateAddressesRequest): array
    {
        $this->validatedAddress = Address::fromResponse(
            $validationResult['ValidatedAddressList']['ValidatedAddress'][0]
        );

        $this->originalAddress = $originalAddress;

        $errors = [];
        $warnings = [];

        foreach ($validationResult['Error'] ?? [] as $error) {
            if ($error['ErrorSeverity'] === 'warning') {
                $warnings[] = new Warning($error['ErrorCode'], $error['ComponentRef']);
            }

            if ($error['ErrorSeverity'] === 'error') {
                $errors[] = new Error($error['ErrorCode'], $error['ComponentRef']);
            }
        }

        return new static($validatedAddress, $originalAddress, $warnings, $errors);
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
}
