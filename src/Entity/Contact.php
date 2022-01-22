<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContactRepository::class)
 */
class Contact
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Contact_Name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Email_Contact;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Subject_Contact;

    /**
     * @ORM\Column(type="text")
     */
    private $Message_Contact;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContactName(): ?string
    {
        return $this->Contact_Name;
    }

    public function setContactName(string $Contact_Name): self
    {
        $this->Contact_Name = $Contact_Name;

        return $this;
    }

    public function getEmailContact(): ?string
    {
        return $this->Email_Contact;
    }

    public function setEmailContact(string $Email_Contact): self
    {
        $this->Email_Contact = $Email_Contact;

        return $this;
    }

    public function getSubjectContact(): ?string
    {
        return $this->Subject_Contact;
    }

    public function setSubjectContact(string $Subject_Contact): self
    {
        $this->Subject_Contact = $Subject_Contact;

        return $this;
    }

    public function getMessageContact(): ?string
    {
        return $this->Message_Contact;
    }

    public function setMessageContact(string $Message_Contact): self
    {
        $this->Message_Contact = $Message_Contact;

        return $this;
    }
}
