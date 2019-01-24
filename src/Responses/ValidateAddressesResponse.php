<?php

namespace Spatie\BpostAddressWebservice\Responses;

use Spatie\BpostAddressWebservice\Address;
use Spatie\BpostAddressWebservice\Error;
use Spatie\BpostAddressWebservice\Requests\ValidateAddressesRequest;
use Spatie\BpostAddressWebservice\ValidatedAddress;
use Spatie\BpostAddressWebservice\Warning;

class ValidateAddressesResponse
{
    /** @var array */
    private $responseBody = [];

    /** @var \Spatie\BpostAddressWebservice\Address */
    private $originalAddresses = [];

    public function __construct(array $responseBody, array $originalAddresses)
    {
        $this->responseBody = $responseBody;

        $this->originalAddresses = $originalAddresses;
    }

    public function validatedAddresses(): array
    {
        $validationResults = $this->responseBody['ValidateAddressesResponse']['ValidatedAddressResultList']['ValidatedAddressResult'] ?? [];

        return array_map(function (array $validationResult) {
            $errors = [];
            $warnings = [];

            foreach ($validationResult['Error'] ?? [] as $error) {
                if ($error['ErrorSeverity'] === 'warning') {
                    $warnings[] = new Warning($error['ErrorCode'], lcfirst($error['ComponentRef']));
                }

                if ($error['ErrorSeverity'] === 'error') {
                    $errors[] = new Error($error['ErrorCode'], lcfirst($error['ComponentRef']));
                }
            }

            return new ValidatedAddress(
                Address::fromResponse($validationResult['ValidatedAddressList']['ValidatedAddress'][0] ?? []),
                $this->originalAddresses[$validationResult['@id']],
                $errors,
                $warnings
            );
        }, $validationResults);
    }

    public function responseBody() : array
    {
        return $this->responseBody;
    }
}
