<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CollectionSubcategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


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
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(type="string", length=128,unique=true)
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity=CollectionCategory::class, inversedBy="collectionSubcategories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @ORM\OneToMany(targetEntity=CollectionFamily::class, mappedBy="subcategory", orphanRemoval=true)
     */
    private $collectionFamilies;

    public function __construct()
    {
        $this->collectionFamilies = new ArrayCollection();
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

    /**
     * @return Collection|CollectionFamily[]
     */
    public function getCollectionFamilies(): Collection
    {
        return $this->collectionFamilies;
    }

    public function addCollectionFamily(CollectionFamily $collectionFamily): self
    {
        if (!$this->collectionFamilies->contains($collectionFamily)) {
            $this->collectionFamilies[] = $collectionFamily;
            $collectionFamily->setSubcategory($this);
        }

        return $this;
    }

    public function removeCollectionFamily(CollectionFamily $collectionFamily): self
    {
        if ($this->collectionFamilies->removeElement($collectionFamily)) {
            // set the owning side to null (unless already changed)
            if ($collectionFamily->getSubcategory() === $this) {
                $collectionFamily->setSubcategory(null);
            }
        }

        return $this;
    }
}
