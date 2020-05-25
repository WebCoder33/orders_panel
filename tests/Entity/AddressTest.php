<?php

namespace App\Tests\Entity;

use App\Entity\Address;
use PHPUnit\Framework\TestCase;

/**
 * Class AddressTest
 * @package App\Tests\Entity
 */
class AddressTest extends TestCase
{
    public function testCreateObject()
    {
        $object = new Address();
        $object->setCityType($cityType = 'cityType')
            ->setCity($city = 'city')
            ->setStreetType($streetType = 'streetType')
            ->setStreet($street = 'street')
            ->setHouse($house = 'house')
            ->setBuilding($building = 'building')
            ->setApartment($apartment = 'apartment');

        $resultCityType = $object->getCityType();
        $resultCity =  $object->getCity();
        $resultStreetType =  $object->getStreetType();
        $resultStreet =  $object->getStreet();
        $resultHouse =  $object->getHouse();
        $resultBuilding =  $object->getBuilding();
        $resultApartment =  $object->getApartment();

        $this->assertSame($cityType, $resultCityType);
        $this->assertSame($city, $resultCity);
        $this->assertSame($streetType, $resultStreetType);
        $this->assertSame($street, $resultStreet);
        $this->assertSame($house, $resultHouse);
        $this->assertSame($building, $resultBuilding);
        $this->assertSame($apartment, $resultApartment);
    }

    public function testEmptyObject()
    {
        $object = new Address();

        $this->assertNull($object->getId());
        $this->assertNull($object->getCityType());
        $this->assertNull($object->getCity());
        $this->assertNull($object->getStreetType());
        $this->assertNull($object->getStreet());
        $this->assertNull($object->getHouse());
        $this->assertNull($object->getBuilding());
        $this->assertNull($object->getApartment());
    }
}
