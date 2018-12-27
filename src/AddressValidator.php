<?php

namespace Spatie\BpostAddressWebservice;

use GuzzleHttp\Client;

class AddressValidator
{
    const BASE_URI = 'https://webservices-pub.bpost.be/ws/ExternalMailingAddressProofingCSREST_v1/';

    const OPTION_INCLUDE_FORMATTING = 'IncludeFormatting';
    const OPTION_INCLUDE_SUGGESTIONS = 'IncludeSuggestions';
    const OPTION_INCLUDE_SUBMITTED_ADDRESS = 'IncludeSubmittedAddress';
    const OPTION_INCLUDE_DEFAULT_GEO_LOCATION = 'IncludeDefaultGeoLocation';
    const OPTION_INCLUDE_SUFFIX_LIST = 'IncludeSuffixList';
    const OPTION_INCLUDE_NUMBER_OF_SUFFIXES = 'IncludeNumberOfSuffixes';
    const OPTION_INCLUDE_LIST_OF_BOXES = 'IncludeListOfBoxes';
    const OPTION_INCLUDE_NUMBER_OF_BOXES = 'IncludeNumberOfBoxes';

    /** @var \GuzzleHttp\Client */
    protected $client;

    /** @var array */
    protected $options = [];

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public static function create(): AddressValidator
    {
        return new static(new Client([
            'base_uri' => static::BASE_URI,
        ]));
    }

    public function withoptions(array $options): AddressValidator
    {
        $this->options = $options;

        return $this;
    }

    public function validate(array $addresses)
    {
        if (count($addresses) > 100) {
            throw new TooManyAddresses();
        }

        $addressesToValidate = array_map(function (Address $address, int $i) {
            return array_merge(
                ['@id' => $i],
                $address->ToBpostArray()
            );
        }, $addresses, array_keys($addresses));

        $requestBody = [
            'ValidateAddressesRequest' => [
                'AddressToValidateList' => [
                    'AddressToValidate' => $addressesToValidate,
                ],
                'ValidateAddressOptions' => $this->options,
            ],
        ];

        $response = $this->client
            ->request('POST', 'address/validateAddresses', [
                'json' => $requestBody,
            ]);

        $responseBody = json_decode((string) $response->getBody(), true);

        $validationResults = $responseBody['ValidateAddressesResponse']['ValidatedAddressResultList']['ValidatedAddressResult'] ?? [];

        return array_map(function (array $validationResult) use ($addresses) {
            return new AddressValidationResult(
                $validationResult,
                $addresses[$validationResult['@id']]
            );
        }, $validationResults);
    }
}
