<?php

namespace Spatie\BpostAddressWebservice\Tests\Mocks;

use PHPUnit\Framework\TestCase;
use Spatie\BpostAddressWebservice\Gateway;
use Spatie\BpostAddressWebservice\Requests\ValidateAddressesRequest;
use Spatie\BpostAddressWebservice\Responses\ValidateAddressesResponse;

class FakeGateway implements Gateway
{
    /** @var \Spatie\BpostAddressWebservice\Requests\ValidateAddressesRequest */
    protected $lastRequest;

    public function validateAddresses(ValidateAddressesRequest $validateAddressesRequest): ValidateAddressesResponse
    {
        $this->lastRequest = $validateAddressesRequest;

        return new ValidateAddressesResponse([], $validateAddressesRequest->addresses());
    }

    public function assertReceivedOptions(array $options)
    {
        if (! $this->lastRequest) {
            TestCase::fail("There haven't been any requests yet");
        }

        TestCase::assertEquals(
            $options,
            $this->lastRequest->getBody()['ValidateAddressesRequest']['ValidateAddressOptions']
        );
    }
}
