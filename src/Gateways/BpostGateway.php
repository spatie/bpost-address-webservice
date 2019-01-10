<?php

namespace Spatie\BpostAddressWebservice\Gateways;

use GuzzleHttp\Client;
use Spatie\BpostAddressWebservice\Gateway;
use Spatie\BpostAddressWebservice\Requests\ValidateAddressesRequest;
use Spatie\BpostAddressWebservice\Responses\ValidateAddressesResponse;
use Spatie\BpostAddressWebservice\AddressValidatorResult;
use Spatie\BpostAddressWebservice\ValidateAddressResponse;

class BpostGateway implements Gateway
{
    /** @var \GuzzleHttp\Client */
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://webservices-pub.bpost.be/ws/ExternalMailingAddressProofingCSREST_v1/',
        ]);
    }

    public function validateAddresses(ValidateAddressesRequest $validateAddressesRequest): ValidateAddressesResponse
    {
        $response = $this->client->request('POST', 'address/validateAddresses', [
            'json' => $validateAddressesRequest->getBody(),
        ]);

        $responseBody = json_decode((string) $response->getBody(), true);

        $validationResults = $responseBody['ValidateAddressesResponse']['ValidatedAddressResultList']['ValidatedAddressResult'] ?? [];

        return ValidateAddressResponse::fromResponse(
            $validationResults,
            $validateAddressesRequest
        );
        // return array_map(function (array $validationResult) use ($addresses) {
        //     return AddressValidatorResult::fromResponse(
        //         $validationResult,
        //         $validateAddressesRequest->getAddressWithId($validationResult['@id'])
        //     );
        // }, $validationResults);
    }
}
