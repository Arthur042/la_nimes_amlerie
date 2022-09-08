<?php

namespace App\Entity;

use App\Repository\BagRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use DateTime;
use Symfony\Component\Validator\Constraints as Assert;
use App\Enum\PanierStatusEnum;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BagRepository::class)]
class Bag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[
        Assert\NotBlank(
            message : 'bag.createdAt.NotBlank',
        ),
        Assert\LessThanOrEqual(
            'today',
            message : 'bag.createdAt.LessThanOrEqual',
        ),
    ]
    private ?\DateTimeInterface $creationAt = null;

    #[ORM\ManyToOne(cascade: ['persist', 'remove'], inversedBy: 'bags')]
    #[ORM\JoinColumn(nullable: true, onDelete: "SET NULL")]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'bag', targetEntity: Contain::class)]
    #[ORM\JoinColumn(onDelete: "CASCADE")]
    private Collection $contains;

    #[ORM\Column]
    #[
         Assert\NotBlank(
             message : 'bag.status.NotBlank',
         ),
        Assert\Choice(
            callback: [PanierStatusEnum::class,'getValues'],
            message: 'bag.status.Choice',
        ),
    ]
    private int $status = PanierStatusEnum::ENCOURS;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->contains = new ArrayCollection();
        $this->setCreationAt(new DateTime());
    }

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Contain>
     */
    public function getContains(): Collection
    {
        return $this->contains;
    }

    public function addContain(Contain $contain): self
    {
        if (!$this->contains->contains($contain)) {
            $this->contains[] = $contain;
            $contain->setBag($this);
        }

        return $this;
    }

    public function removeContain(Contain $contain): self
    {
        if ($this->contains->removeElement($contain)) {
            // set the owning side to null (unless already changed)
            if ($contain->getBag() === $this) {
                $contain->setBag(null);
            }
        }

        return $this;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        if(!PanierStatusEnum::isValid($status)){
            throw new \InvalidArgumentException('mauvais status donné');
        }
        $this->status = $status;

        return $this;
    }
}
