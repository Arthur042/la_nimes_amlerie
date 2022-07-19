<?php

namespace App\Entity;

use App\Repository\OrderedRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderedRepository::class)]
class Ordered
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $creationAt = null;

    #[ORM\OneToOne(mappedBy: 'ordered', cascade: ['persist', 'remove'])]
    private ?Bag $bag = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Status $status = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Payment $payment = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Adress $billingAdress = null;

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

    public function getBag(): ?Bag
    {
        return $this->bag;
    }

    public function setBag(?Bag $bag): self
    {
        // unset the owning side of the relation if necessary
        if ($bag === null && $this->bag !== null) {
            $this->bag->setOrdered(null);
        }

        // set the owning side of the relation if necessary
        if ($bag !== null && $bag->getOrdered() !== $this) {
            $bag->setOrdered($this);
        }

        $this->bag = $bag;

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
}
