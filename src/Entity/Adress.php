<?php

namespace App\Entity;

use App\Repository\AdressRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;


#[ORM\Entity(repositoryClass: AdressRepository::class)]
class Adress
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[
        Assert\NotBlank(
            message : 'adress.line.NotBlank',
        ),
        Assert\Length([
            'min' => 2,
            'minMessage' => 'adress.line.Length.min',
            'max' => 100,
            'maxMessage' => 'adress.line.Length.max'
        ])
    ]
    private ?string $line1 = null;

    #[ORM\Column(length: 100, nullable: true)]
    #[
        Assert\Length([
            'min' => 2,
            'minMessage' => 'adress.line.Length.min',
            'max' => 100,
            'maxMessage' => 'adress.line.Length.max'
        ])
    ]
    private ?string $line2 = null;

    #[ORM\Column(length: 100, nullable: true)]
    #[
        Assert\Length([
            'min' => 2,
            'minMessage' => 'adress.line.Length.min',
            'max' => 100,
            'maxMessage' => 'adress.line.Length.max'
        ])
    ]
    private ?string $line3 = null;

    #[ORM\Column(length: 10)]
    #[
        Assert\NotBlank(
            message : "adress.postalCode.NotBlank"
        ),
        Assert\Length([
            'min' => 2,
            'minMessage' => "adress.postalCode.Length.min",
            'max' => 10,
            'maxMessage' => "adress.postalCode.Length.max"
        ])
    ]
    private ?string $postalCode = null;

    #[ORM\Column(length: 100)]
    #[
        Assert\NotBlank(
            message : "adress.city.NotBlank"
        ),
        Assert\Length([
            'min' => 2,
            'minMessage' => "adress.city.Length.min",
            'max' => 100,
            'maxMessage' => "adress.city.Length.max"
        ])
    ]
    private ?string $city = null;

    #[ORM\OneToMany(mappedBy: 'adress', targetEntity: User::class)]
    private Collection $users;

    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phoneNumber = null;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLine1(): ?string
    {
        return $this->line1;
    }

    public function setLine1(string $line1): self
    {
        $this->line1 = $line1;

        return $this;
    }

    public function getLine2(): ?string
    {
        return $this->line2;
    }

    public function setLine2(?string $line2): self
    {
        $this->line2 = $line2;

        return $this;
    }

    public function getLine3(): ?string
    {
        return $this->line3;
    }

    public function setLine3(?string $line3): self
    {
        $this->line3 = $line3;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setAdress($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getAdress() === $this) {
                $user->setAdress(null);
            }
        }

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }
}
