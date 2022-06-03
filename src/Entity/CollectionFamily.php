<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CollectionFamilyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=CollectionFamilyRepository::class)
 */
class CollectionFamily
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
    private $name;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(type="string", length=128,unique=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @ORM\ManyToOne(targetEntity=CollectionSubcategory::class, inversedBy="collectionFamilies")
     * @ORM\JoinColumn(nullable=false)
     */
    private $subcategory;

    /**
     * @ORM\OneToMany(targetEntity=CollectionEdition::class, mappedBy="family", orphanRemoval=true)
     */
    private $collectionEditions;

    public function __construct()
    {
        $this->collectionEditions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getSubcategory(): ?CollectionSubcategory
    {
        return $this->subcategory;
    }

    public function setSubcategory(?CollectionSubcategory $subcategory): self
    {
        $this->subcategory = $subcategory;

        return $this;
    }

    /**
     * @return Collection|CollectionEdition[]
     */
    public function getCollectionEditions(): Collection
    {
        return $this->collectionEditions;
    }

    public function addCollectionEdition(CollectionEdition $collectionEdition): self
    {
        if (!$this->collectionEditions->contains($collectionEdition)) {
            $this->collectionEditions[] = $collectionEdition;
            $collectionEdition->setFamily($this);
        }

        return $this;
    }

    public function removeCollectionEdition(CollectionEdition $collectionEdition): self
    {
        if ($this->collectionEditions->removeElement($collectionEdition)) {
            // set the owning side to null (unless already changed)
            if ($collectionEdition->getFamily() === $this) {
                $collectionEdition->setFamily(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
