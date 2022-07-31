<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\OrderedRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OrderedRepository::class)]
class Ordered
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[
        Assert\NotBlank(
            message : 'ordered.creationAt.NotBlank',
        ),
        Assert\LessThanOrEqual(
            'today',
            message : 'ordered.creationAt.LessThanOrEqual',
        ),
    ]
    private ?\DateTimeInterface $creationAt = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[
        Assert\NotNull(
            message : 'ordered.status.NotNull',
        ),
    ]
    private ?Status $status = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[
        Assert\NotNull(
            message : 'ordered.payment.NotNull',
        ),
    ]
    private ?Payment $payment = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[
        Assert\NotNull(
            message : 'ordered.billingAdress.NotNull',
        ),
    ]
    private ?Adress $billingAdress = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[
        Assert\NotNull(
            message : 'ordered.bag.NotNull',
        ),
    ]
    private ?Bag $bag = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreationAt(): ?\DateTimeInterface
    {
        return $this->creationAt;
    }

    public function setCreationAt(\DateTimeInterface $creationAt): self
    {
        $this->creationAt = $creationAt;

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getPayment(): ?Payment
    {
        return $this->payment;
    }

    public function setPayment(?Payment $payment): self
    {
        $this->payment = $payment;

        return $this;
    }

    public function getBillingAdress(): ?Adress
    {
        return $this->billingAdress;
    }

    public function setBillingAdress(?Adress $billingAdress): self
    {
        $this->billingAdress = $billingAdress;

        return $this;
    }

    public function getBag(): ?Bag
    {
        return $this->bag;
    }

    public function setBag(Bag $bag): self
    {
        $this->bag = $bag;

        return $this;
    }
}
