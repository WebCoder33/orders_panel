<?php

namespace App\Tests\Entity\Person;

use App\Entity\Person\Contacts;
use App\Entity\Address;
use App\Entity\Person\Person;
use PHPUnit\Framework\TestCase;

/**
 * Class PersonTest
 * @package App\Tests\Util
 */
class PersonTest extends TestCase
{
    public function testCreateObject()
    {
        $object = new Person();
        $object->setContacts($contacts = new Contacts())
            ->setAddress($address = new Address())
            ->setComment($comment = 'comment');

        $resultContact = $object->getContacts();
        $resultAddress = $object->getAddress();
        $resultComment = $object->getComment();

        $this->assertSame($contacts, $resultContact);
        $this->assertSame($address, $resultAddress);
        $this->assertSame($comment, $resultComment);
    }

    public function testEmptyObject()
    {
        $object = new Person();

        $this->assertNull($object->getId());
        $this->assertNull($object->getComment());
        $this->assertNull($object->getContacts());
        $this->assertNull($object->getAddress());
    }
}

