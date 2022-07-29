<?php

namespace App\Entity;

use App\Repository\PaymentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiResource;

#[ORM\Entity(repositoryClass: PaymentRepository::class)]
#[ApiResource(
    collectionOperations: [],
    itemOperations: [
        'get' => ['security' => 'is_granted("ROLE_STATS")'],
    ],
)]
class Payment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[
        Assert\NotBlank(
            message : 'payment.name.NotBlank',
        ),
        Assert\Length([
            'min' => 2,
            'max' => 50,
            'minMessage' => 'payment.name.MinLength',
            'maxMessage' => 'payment.name.MaxLength',
        ]),
    ]
    private ?string $name = null;

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
}
