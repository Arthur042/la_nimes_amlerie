<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Product::class)]
    private Collection $products;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'parentCategory')]
    private ?self $subCategory = null;

    #[ORM\OneToMany(mappedBy: 'subCategory', targetEntity: self::class)]
    private Collection $parentCategory;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->parentCategory = new ArrayCollection();
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

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setCategory($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getCategory() === $this) {
                $product->setCategory(null);
            }
        }

        return $this;
    }

    public function getSubCategory(): ?self
    {
        return $this->subCategory;
    }

    public function setSubCategory(?self $subCategory): self
    {
        $this->subCategory = $subCategory;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getParentCategory(): Collection
    {
        return $this->parentCategory;
    }

    public function addParentCategory(self $parentCategory): self
    {
        if (!$this->parentCategory->contains($parentCategory)) {
            $this->parentCategory[] = $parentCategory;
            $parentCategory->setSubCategory($this);
        }

        return $this;
    }

    public function removeParentCategory(self $parentCategory): self
    {
        if ($this->parentCategory->removeElement($parentCategory)) {
            // set the owning side to null (unless already changed)
            if ($parentCategory->getSubCategory() === $this) {
                $parentCategory->setSubCategory(null);
            }
        }

        return $this;
    }
}
