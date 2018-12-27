<?php

namespace Spatie\BpostAddressWebservice\Tests;

use PHPUnit\Framework\TestCase;
use Spatie\BpostAddressWebservice\Address;
use Spatie\BpostAddressWebservice\AddressValidator;

class AddressValidatorTest extends TestCase
{
    /** @test */
    public function it_validates_an_address()
    {
        $addressValidator = AddressValidator::create();

        $validationResult = $addressValidator->validate([
            Address::create([
                'street_name' => 'Samberstraat',
                'street_number' => '69',
                'box_number' => 'D',
                'postal_code' => '2060',
                'municipality_name' => 'Antwerpen',
                'country' => 'BE',
            ]),
            Address::create([
                'street_name' => 'Keizer Karelstraat',
                'street_number' => '87',
                'box_number' => '101',
                'postal_code' => '9000',
                'municipality_name' => 'Gent',
                'country' => 'BE',
            ]),
        ]);

        dd($validationResult);
    }
}
