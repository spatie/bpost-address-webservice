<?php

namespace Spatie\BpostAddressWebservice\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Spatie\BpostAddressWebservice\Address;
use Spatie\BpostAddressWebservice\AddressValidator;
use Spatie\BpostAddressWebservice\ValidatedAddress;
use Spatie\BpostAddressWebservice\Exceptions\TooManyAddresses;
use Spatie\BpostAddressWebservice\Tests\Mocks\FakeGateway;

class AddressValidatorTest extends TestCase
{
    /** @test */
    public function it_doesnt_validate_more_than_100_addresses()
    {
        $addresses = array_map(function() {
            return Address::create([
                'streetName' => 'Samberstraat',
                'streetNumber' => '69',
                'boxNumber' => '',
                'postalCode' => '2060',
                'municipalityName' => 'Antwerpen',
                'country' => 'BELGIE',
            ]);
        }, range(1, 101));

        $this->expectException(TooManyAddresses::class);

        AddressValidator::create()->validateMany($addresses);
    }

    /** @test */
    public function it_passes_options_to_the_request()
    {
        $fakeGateway = new FakeGateway();

        $addressValidator = (new AddressValidator($fakeGateway))->withOptions([
            AddressValidator::OPTION_INCLUDE_LIST_OF_BOXES => true,
            AddressValidator::OPTION_INCLUDE_NUMBER_OF_BOXES => true,
        ]);

        $addressValidator->validateMany([
            Address::create([
                'streetName' => 'Samberstraat',
                'streetNumber' => '69',
                'boxNumber' => '',
                'postalCode' => '2060',
                'municipalityName' => 'Antwerpen',
                'country' => 'BELGIE',
            ])
        ]);

        $fakeGateway->assertReceivedOptions([
            AddressValidator::OPTION_INCLUDE_LIST_OF_BOXES => true,
            AddressValidator::OPTION_INCLUDE_NUMBER_OF_BOXES => true,
        ]);
    }
}
