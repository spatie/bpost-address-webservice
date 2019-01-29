<?php

namespace Spatie\BpostAddressWebservice\Gateways;

use GuzzleHttp\Client;
use Spatie\BpostAddressWebservice\Requests\ValidateAddressesRequest;
use Spatie\BpostAddressWebservice\Responses\ValidateAddressesResponse;

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

        return new ValidateAddressesResponse(
            json_decode((string) $response->getBody(), true),
            $validateAddressesRequest->addresses()
        );
    }
}
