<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="entityDiscr", type="string")
 */
class Order
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Address", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $address;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment=$comment;

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): self
    {
        if(isset($this->address)) {
            $this->address->setHouse($address->getHouse());
            $this->address->setCity($address->getCity());
            $this->address->setApartment($address->getApartment());
            $this->address->setCityType($address->getCityType());
            $this->address->setStreet($address->getStreet());
            $this->address->setBuilding($address->getBuilding());
            $this->address->setStreetType($address->getStreetType());
        } else {
            $this->address=$address;
        }
        return $this;
    }
}
