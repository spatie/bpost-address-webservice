<?php

namespace Spatie\BpostAddressWebservice\Tests;

use PHPUnit\Framework\TestCase;
use Spatie\BpostAddressWebservice\Address;
use Spatie\BpostAddressWebservice\AddressValidator;
use Spatie\BpostAddressWebservice\ValidatedAddress;

/** @group integration */
class AddressValidatorTest extends TestCase
{
    /** @test */
    public function it_validates_addresses()
    {
        $addressValidator = AddressValidator::create();

        $validatedAddresses = $addressValidator->validate([
            Address::create([
                'streetName' => 'Samberstraat',
                'streetNumber' => '69',
                'boxNumber' => '',
                'postalCode' => '2060',
                'municipalityName' => 'Antwerpen',
                'country' => 'BELGIE',
            ]),
            Address::create([
                'streetName' => 'Samberstraat',
                'streetNumber' => '69',
                'boxNumber' => '',
                'postalCode' => '2060',
                'municipalityName' => 'Antwaarpe',
                'country' => 'BELGIE',
            ]),
            Address::create([
                'streetName' => 'Samberdreef',
                'streetNumber' => '69',
                'boxNumber' => '',
                'postalCode' => '2060',
                'municipalityName' => 'Antwerpen',
                'country' => 'BELGIE',
            ]),
        ]);

        $this->assertInstanceOf(ValidatedAddress::class, $validatedAddresses[0]);
        $this->assertInstanceOf(ValidatedAddress::class, $validatedAddresses[1]);
        $this->assertInstanceOf(ValidatedAddress::class, $validatedAddresses[2]);

        $this->assertFalse($validatedAddresses[0]->hasIssues());
        $this->assertFalse($validatedAddresses[0]->hasErrors());
        $this->assertFalse($validatedAddresses[0]->hasWarnings());
        $this->assertEquals([
            'streetName' => 'SAMBERSTRAAT',
            'streetNumber' => '69',
            'boxNumber' => '',
            'postalCode' => '2060',
            'municipalityName' => 'ANTWERPEN',
            'country' => 'BELGIE',
        ], $validatedAddresses[0]->toArray());
        $this->assertEquals([
            'streetName' => 'Samberstraat',
            'streetNumber' => '69',
            'boxNumber' => '',
            'postalCode' => '2060',
            'municipalityName' => 'Antwerpen',
            'country' => 'BELGIE',
        ], $validatedAddresses[0]->originalAddress()->toArray());

        $this->assertTrue($validatedAddresses[1]->hasIssues());
        $this->assertFalse($validatedAddresses[1]->hasErrors());
        $this->assertTrue($validatedAddresses[1]->hasWarnings());
        $this->assertEquals([
            'streetName' => 'SAMBERSTRAAT',
            'streetNumber' => '69',
            'boxNumber' => '',
            'postalCode' => '2060',
            'municipalityName' => 'ANTWERPEN',
            'country' => 'BELGIE',
        ], $validatedAddresses[1]->toArray());
        $this->assertEquals([
                'streetName' => 'Samberstraat',
                'streetNumber' => '69',
                'boxNumber' => '',
                'postalCode' => '2060',
                'municipalityName' => 'Antwaarpe',
                'country' => 'BELGIE',
        ], $validatedAddresses[1]->originalAddress()->toArray());

        $this->assertTrue($validatedAddresses[2]->hasIssues());
        $this->assertTrue($validatedAddresses[2]->hasErrors());
        $this->assertFalse($validatedAddresses[2]->hasWarnings());
        $this->assertEquals([
            'streetName' => '',
            'streetNumber' => '',
            'boxNumber' => '',
            'postalCode' => '2060',
            'municipalityName' => 'ANTWERPEN',
            'country' => 'BELGIE',
        ], $validatedAddresses[2]->toArray());
        $this->assertEquals([
                'streetName' => 'Samberdreef',
                'streetNumber' => '69',
                'boxNumber' => '',
                'postalCode' => '2060',
                'municipalityName' => 'Antwerpen',
                'country' => 'BELGIE',
        ], $validatedAddresses[2]->originalAddress()->toArray());
    }
}
