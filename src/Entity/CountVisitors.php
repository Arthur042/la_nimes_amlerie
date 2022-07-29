<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CountVisitorsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CountVisitorsRepository::class)]
#[ApiResource(
    collectionOperations: [
        'get',
    ],
    itemOperations: [
        'get',
    ],
)]
class CountVisitors
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $connectionAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getConnectionAt(): ?\DateTimeInterface
    {
        return $this->connectionAt;
    }

    public function setConnectionAt(\DateTimeInterface $connectionAt): self
    {
        $this->connectionAt = $connectionAt;

        return $this;
    }
}
