<?php

namespace App\Entity;

use App\Repository\PhotoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiResource;

#[ORM\Entity(repositoryClass: PhotoRepository::class)]
class Photo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    #[
        Assert\NotBlank(
            message : 'photo.name.NotBlank',
        ),
        Assert\Length([
            'min' => 2,
            'max' => 60,
            'minMessage' => 'photo.name.MinLength',
            'maxMessage' => 'photo.name.MaxLength',
        ]),
    ]
    private ?string $name = null;

    #[ORM\Column]
    #[
        Assert\NotNull(
            message : 'photo.isMajor.NotNull',
        ),
    ]
    private ?bool $isMajor = false;

    #[ORM\ManyToOne(inversedBy: 'photos')]
    private ?Product $product = null;

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

    public function isIsMajor(): ?bool
    {
        return $this->isMajor;
    }

    public function setIsMajor(bool $isMajor): self
    {
        $this->isMajor = $isMajor;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }
}
