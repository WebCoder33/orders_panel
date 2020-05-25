<?php

namespace App\Tests\Entity\Person;

use App\Entity\Person\Contacts;
use PHPUnit\Framework\TestCase;

/**
 * Class ContactsTest
 * @package App\Tests\Entity\Person
 */
class ContactsTest extends TestCase
{
    public function testCreateObject()
    {
        $object = new Contacts();
        $object->setLastName($lastName = 'lastName')
            ->setFirstName($firstName = 'firstName')
            ->setPatronymic($patronymic = 'patronymic')
            ->setPhone($phone = 'phone');

        $resultLastName = $object->getLastName();
        $resultFirstName = $object->getFirstName();
        $resultPatronymic = $object->getPatronymic();
        $resultPhone = $object->getPhone();

        $this->assertSame($lastName, $resultLastName);
        $this->assertSame($firstName, $resultFirstName);
        $this->assertSame($patronymic, $resultPatronymic);
        $this->assertSame($phone, $resultPhone);
    }

    public function testEmptyObject()
    {
        $object = new Contacts();

        $this->assertNull($object->getId());
        $this->assertNull($object->getLastName());
        $this->assertNull($object->getFirstName());
        $this->assertNull($object->getPatronymic());
        $this->assertNull($object->getPhone());
    }
}
