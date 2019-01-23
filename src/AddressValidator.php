<?php

namespace Spatie\BpostAddressWebservice;

use Spatie\BpostAddressWebservice\Gateways\BpostGateway;
use Spatie\BpostAddressWebservice\Requests\ValidateAddressesRequest;

class AddressValidator
{
    const OPTION_INCLUDE_FORMATTING = 'IncludeFormatting';
    const OPTION_INCLUDE_SUGGESTIONS = 'IncludeSuggestions';
    const OPTION_INCLUDE_SUBMITTED_ADDRESS = 'IncludeSubmittedAddress';
    const OPTION_INCLUDE_DEFAULT_GEO_LOCATION = 'IncludeDefaultGeoLocation';
    const OPTION_INCLUDE_SUFFIX_LIST = 'IncludeSuffixList';
    const OPTION_INCLUDE_NUMBER_OF_SUFFIXES = 'IncludeNumberOfSuffixes';
    const OPTION_INCLUDE_LIST_OF_BOXES = 'IncludeListOfBoxes';
    const OPTION_INCLUDE_NUMBER_OF_BOXES = 'IncludeNumberOfBoxes';

    /** @var \Spatie\BpostAddressWebservice\Gateway */
    private $gateway;

    /** @var array */
    private $options = [];

    public function __construct(Gateway $gateway)
    {
        $this->gateway = $gateway;
    }

    public static function create(): AddressValidator
    {
        return new static(new BpostGateway());
    }

    public function withOptions(array $options): AddressValidator
    {
        $this->options = $options;

        return $this;
    }

    public function validate(array $addresses): array
    {
        if (count($addresses) > 100) {
            throw new TooManyAddresses();
        }

        $validateAddressesResponse = $this->gateway->validateAddresses(
            new ValidateAddressesRequest($addresses, $this->options)
        );

        return $validateAddressesResponse->validatedAddresses();
    }
}
