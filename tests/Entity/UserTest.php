<?php

namespace App\Tests\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\User;

/**
 * Class UserTest
 * @package App\Tests\Entity
 */
class UserTest extends TestCase
{
    public function testCreateObject()
    {
        $object = new User();
        $object->setRoles($roles = ['ROLE_USER'])
            ->setEmail($email = 'email')
            ->setUsername($username = 'username')
            ->setPassword($password = 'password')
            ->setFullName($fullName = 'fullName')
            ->setIsActive($isActive = true);

        $resultRoles = $object->getRoles();
        $resultEmail = $object->getEmail();
        $resultUsername = $object->getUsername();
        $resultPassword = $object->getPassword();
        $resultFullName = $object->getFullName();
        $resultIsActive = $object->getIsActive();

        $this->assertSame($roles, $resultRoles);
        $this->assertIsArray($resultRoles);
        $this->assertSame($email, $resultEmail);
        $this->assertSame($username, $resultUsername);
        $this->assertSame($password, $resultPassword);
        $this->assertSame($fullName, $resultFullName);
        $this->assertIsBool($resultIsActive);
    }

    public function testEmptyObject()
    {
        $object = new User();

        $this->assertNull($object->getId());
        $this->assertNull($object->getSalt());
        $this->assertContains('ROLE_USER', $object->getRoles());
        $this->assertNull($object->getEmail());
        $this->assertEmpty($object->getUsername());
        $this->assertEmpty($object->getPassword());
        $this->assertNull($object->getFullName());
    }
}
