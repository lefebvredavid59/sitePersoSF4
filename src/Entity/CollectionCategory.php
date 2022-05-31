<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CollectionCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ApiResource(
 *     collectionOperations={"get"},
 *     itemOperations={"get"}
 * )
 * @ORM\Entity(repositoryClass=CollectionCategoryRepository::class)
 */
class CollectionCategory
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
     * @ORM\OneToMany(targetEntity=CollectionSubcategory::class, mappedBy="category", orphanRemoval=true)
     */
    private $collectionSubcategories;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

    public function __construct()
    {
        $this->collectionSubcategories = new ArrayCollection();
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

    /**
     * @return Collection|CollectionSubcategory[]
     */
    public function getCollectionSubcategories(): Collection
    {
        return $this->collectionSubcategories;
    }

    public function addCollectionSubcategory(CollectionSubcategory $collectionSubcategory): self
    {
        if (!$this->collectionSubcategories->contains($collectionSubcategory)) {
            $this->collectionSubcategories[] = $collectionSubcategory;
            $collectionSubcategory->setCategory($this);
        }

        return $this;
    }

    public function removeCollectionSubcategory(CollectionSubcategory $collectionSubcategory): self
    {
        if ($this->collectionSubcategories->removeElement($collectionSubcategory)) {
            // set the owning side to null (unless already changed)
            if ($collectionSubcategory->getCategory() === $this) {
                $collectionSubcategory->setCategory(null);
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

    public function __toString()
    {
        return $this->getName();
    }
}
