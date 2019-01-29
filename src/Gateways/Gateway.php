<?php

namespace Spatie\BpostAddressWebservice\Gateways;

use Spatie\BpostAddressWebservice\Requests\ValidateAddressesRequest;
use Spatie\BpostAddressWebservice\Responses\ValidateAddressesResponse;

interface Gateway
{
    public function validateAddresses(ValidateAddressesRequest $validateAddressesRequest): ValidateAddressesResponse;
}
