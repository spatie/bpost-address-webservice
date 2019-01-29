<?php

namespace Spatie\BpostAddressWebservice\Exceptions;

use Exception;

class CouldNotValidateAddress extends Exception
{
    public static function tooManyAddresses(array $address, int $maximum): self
    {
        $addressCount = count($address);

        return new static("{$addressCount} given to validate. The maximum is {$maximum}. Provide less addresses to validate.");
    }
}
