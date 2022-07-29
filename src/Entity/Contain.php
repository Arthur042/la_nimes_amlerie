<?php

namespace App\Entity;

use App\Repository\ContainRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiResource;

#[ORM\Entity(repositoryClass: ContainRepository::class)]
#[ApiResource(
    collectionOperations: [],
    itemOperations: [
        'get' => ['security' => 'is_granted("ROLE_STATS")'],
    ],
)]
class Contain
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column]
    #[
        Assert\NotBlank(
            message : 'contain.quantity.NotBlank',
        ),
    ]
    private ?int $quantity = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[
        Assert\NotNull(
            message : 'contain.product.NotNull',
        ),
    ]
    private ?Product $products = null;

    #[ORM\ManyToOne(inversedBy: 'contains')]
    #[ORM\JoinColumn(nullable: false)]
    #[
        Assert\NotNull(
            message : 'contain.bag.NotNull',
        ),
    ]
    private ?Bag $bag = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 6, scale: 2)]
    #[
        Assert\NotBlank(
            message : 'contain.price.NotBlank',
        ),
        Assert\GreaterThan(
            0,
            message : 'contain.price.GreaterThan',
        ),
    ]
    private ?string $unitPrice = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 3, scale: 2)]
    #[
        Assert\NotBlank(
            message : 'contain.tva.NotBlank',
        ),
        Assert\LessThan(
            1,
            message : 'contain.tva.LessThan',
        ),
        Assert\GreaterThanOrEqual(
            0,
            message : 'contain.tva.GreaterThanOrEqual',
        ),
    ]
    private ?string $tva = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getProducts(): ?Product
    {
        return $this->products;
    }

    public function setProducts(?Product $products): self
    {
        $this->products = $products;

        return $this;
    }

    public function getBag(): ?Bag
    {
        return $this->bag;
    }

    public function setBag(?Bag $bag): self
    {
        $this->bag = $bag;

        return $this;
    }

    public function getUnitPrice(): ?string
    {
        return $this->unitPrice;
    }

    public function setUnitPrice(string $unitPrice): self
    {
        $this->unitPrice = $unitPrice;

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
}
