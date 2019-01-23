<?php

namespace Spatie\BpostAddressWebservice\Responses;

use GuzzleHttp\Psr7\Response;
use Spatie\BpostAddressWebservice\Address;
use Spatie\BpostAddressWebservice\Error;
use Spatie\BpostAddressWebservice\Requests\ValidateAddressesRequest;
use Spatie\BpostAddressWebservice\ValidatedAddress;
use Spatie\BpostAddressWebservice\Warning;

class ValidateAddressesResponse
{
    /** @var string */
    private $error;

    /** @var string */
    private $validatedAddresses = [];

    private function __construct()
    {
    }

    public function validatedAddresses(): array
    {
        return $this->validatedAddresses;
    }

    public static function fromResponseBody(array $responseBody, array $originalAddresses): ValidateAddressesResponse
    {
        $validationResults = $responseBody['ValidateAddressesResponse']['ValidatedAddressResultList']['ValidatedAddressResult'] ?? [];

        $validateAddressResponse = new self();

        $validateAddressResponse->validatedAddresses = array_map(function (array $validationResult) use ($originalAddresses) {
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

            return new ValidatedAddress(
                Address::fromResponse($validationResult['ValidatedAddressList']['ValidatedAddress'][0] ?? []),
                $originalAddresses[$validationResult['@id']],
                $errors,
                $warnings
            );
        }, $validationResults);

        return $validateAddressResponse;
    }
}
