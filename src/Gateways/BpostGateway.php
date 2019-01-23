<?php

namespace Spatie\BpostAddressWebservice\Gateways;

use GuzzleHttp\Client;
use Spatie\BpostAddressWebservice\Gateway;
use Spatie\BpostAddressWebservice\Requests\ValidateAddressesRequest;
use Spatie\BpostAddressWebservice\Responses\ValidateAddressesResponse;
use Spatie\BpostAddressWebservice\AddressValidatorResult;
use GuzzleHttp\Exception\ClientException;

class BpostGateway implements Gateway
{
    /** @var \GuzzleHttp\Client */
    private $client;

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

        return ValidateAddressesResponse::fromResponseBody(
            json_decode((string) $response->getBody(), true),
            $validateAddressesRequest->addresses()
        );
    }
}
