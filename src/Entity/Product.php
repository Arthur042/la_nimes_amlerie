<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    #[
        Assert\NotBlank(
            message : 'product.title.NotBlank',
        ),
        Assert\Length([
            'min' => 2,
            'max' => 30,
            'minMessage' => 'product.title.MinLength',
            'maxMessage' => 'product.title.MaxLength',
        ]),
    ]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    #[
        Assert\NotBlank(
            message : 'product.description.NotBlank',
        ),
    ]
    private ?string $littleDescription = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $fullDescription = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 6, scale: 2)]
    #[
        Assert\NotBlank(
            message : 'product.price.NotBlank',
        ),
        Assert\GreaterThan(
            0,
            message : 'product.price.GreaterThan',
        ),
    ]
    private ?string $priceHt = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 3, scale: 2)]
    #[
        Assert\NotBlank(
            message : 'product.tva.NotBlank',
        ),
        Assert\GreaterThan(
            0,
            message : 'product.tva.GreaterThan',
        ),
        Assert\LessThan(
            100,
            message : 'product.tva.LessThan',
        ),
    ]
    private ?string $tva = null;

    #[ORM\Column(nullable: true)]
    #[
        Assert\GreaterThan(
            0,
            message : 'product.quantity.GreaterThan',
        ),
    ]
    private ?int $quantity = null;

    #[ORM\Column]
    #[
        Assert\NotNull(
            message : 'product.isAvailable.NotNull',
        ),
    ]
    private ?bool $isAvailable = false;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    #[
        Assert\NotNull(
            message : 'product.category.NotNull',
        ),
    ]
    private ?Category $category = null;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: Photo::class)]
    private Collection $photos;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    #[
        Assert\NotNull(
            message : 'product.mark.NotNull',
        ),
    ]
    private ?Mark $mark = null;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: Comment::class)]
    private Collection $comments;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->photos = new ArrayCollection();
        $this->bags = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getLittleDescription(): ?string
    {
        return $this->littleDescription;
    }

    public function setLittleDescription(string $littleDescription): self
    {
        $this->littleDescription = $littleDescription;

        return $this;
    }

    public function getFullDescription(): ?string
    {
        return $this->fullDescription;
    }

    public function setFullDescription(?string $fullDescription): self
    {
        $this->fullDescription = $fullDescription;

        return $this;
    }

    public function getPriceHt(): ?string
    {
        return $this->priceHt;
    }

    public function setPriceHt(string $priceHt): self
    {
        $this->priceHt = $priceHt;

        return $this;
    }

    public function getTva(): ?string
    {
        return $this->tva;
    }

    public function setTva(string $tva): self
    {
        $this->tva = $tva;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function isIsAvailable(): ?bool
    {
        return $this->isAvailable;
    }

    public function setIsAvailable(bool $isAvailable): self
    {
        $this->isAvailable = $isAvailable;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, Photo>
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photo $photo): self
    {
        if (!$this->photos->contains($photo)) {
            $this->photos[] = $photo;
            $photo->setProduct($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): self
    {
        if ($this->photos->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getProduct() === $this) {
                $photo->setProduct(null);
            }
        }

        return $this;
    }

    public function getMark(): ?Mark
    {
        return $this->mark;
    }

    public function setMark(?Mark $mark): self
    {
        $this->mark = $mark;

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setProduct($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getProduct() === $this) {
                $comment->setProduct(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
