<?php

namespace Spatie\BpostAddressWebservice\Tests\Unit\Requests;

use PHPUnit\Framework\TestCase;
use Spatie\Snapshots\MatchesSnapshots;
use Spatie\BpostAddressWebservice\Address;
use Spatie\BpostAddressWebservice\AddressValidator;
use Spatie\BpostAddressWebservice\Requests\ValidateAddressesRequest;

class ValidateAddressRequestTest extends TestCase
{
    use MatchesSnapshots;

    /** @test */
    public function it_creates_a_request_body_with_an_array_of_addresses()
    {
        $validateAddressesRequest = new ValidateAddressesRequest([
            Address::create([
                'streetName' => 'Samberstraat',
                'streetNumber' => '69',
                'boxNumber' => 'D',
                'postalCode' => '2060',
                'municipalityName' => 'Antwerpen',
                'country' => 'BELGIE',
            ]),
        ], [
            AddressValidator::OPTION_INCLUDE_SUFFIX_LIST => true,
        ]);

        $this->assertMatchesJsonSnapshot(
            json_encode($validateAddressesRequest->getBody())
        );
    }

    /** @test */
    public function addresses_can_be_retrieved_from_the_request()
    {
        $addresses = [
            Address::create([
                'streetName' => 'Samberstraat',
                'streetNumber' => '69',
                'boxNumber' => 'D',
                'postalCode' => '2060',
                'municipalityName' => 'Antwerpen',
                'country' => 'BELGIE',
            ]),
        ];

        $validateAddressesRequest = new ValidateAddressesRequest($addresses, []);

        $this->assertEquals($addresses, $validateAddressesRequest->addresses());
    }
}
