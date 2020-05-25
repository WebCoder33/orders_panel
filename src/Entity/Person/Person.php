<?php

namespace App\Entity\Person;

use App\Entity\Order;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Person\PersonRepository")
 * @ORM\Table(name="`person`")
 */
class Person extends Order
{
    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Person\Contacts", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    protected $contacts;

    public function getContacts(): ?Contacts
    {
        return $this->contacts;
    }

    public function setContacts(Contacts $contacts): self
    {
        if(isset($this->contacts)) {
            $this->contacts->setLastName($contacts->getLastName());
            $this->contacts->setFirstName($contacts->getFirstName());
            $this->contacts->setPatronymic($contacts->getPatronymic());
            $this->contacts->setPhone($contacts->getPhone());
        } else {
            $this->contacts=$contacts;
        }
        return $this;
    }
}
