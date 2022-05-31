<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CollectionSubcategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=CollectionSubcategoryRepository::class)
 */
class CollectionSubcategory
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
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity=CollectionCategory::class, inversedBy="collectionSubcategories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity=CollectionEdition::class, mappedBy="subcategory", orphanRemoval=true)
     */
    private $collectionEditions;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

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

    public function getCategory(): ?CollectionCategory
    {
        return $this->category;
    }

    public function setCategory(?CollectionCategory $category): self
    {
        $this->category = $category;

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
            $collectionEdition->setSubcategory($this);
        }

        return $this;
    }

    public function removeCollectionEdition(CollectionEdition $collectionEdition): self
    {
        if ($this->collectionEditions->removeElement($collectionEdition)) {
            // set the owning side to null (unless already changed)
            if ($collectionEdition->getSubcategory() === $this) {
                $collectionEdition->setSubcategory(null);
            }
        }

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
}
