<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use App\Enum\CommentNoteEnum;
use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiResource;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    #[
        Assert\NotBlank(
            message : 'comment.note.NotBlank',
        ),
        Assert\Choice(
            callback: [CommentNoteEnum::class,'getValues'],
            message: 'comment.note.Choice',
        )
    ]
    private ?int $note = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: true)]
    #[
        Assert\NotNull(
            message : 'comment.user.NotNull',
        ),
    ]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: true)]
    #[
        Assert\NotNull(
            message : 'comment.product.NotNull',
        ),
    ]
    private ?Product $product = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[
        Assert\NotBlank(
            message : 'comment.createdAt.NotBlank',
        ),
        Assert\LessThanOrEqual(
            'today',
            message : 'comment.createdAt.LessThanOrEqual',
        ),
    ]
    private ?\DateTimeInterface $creationAt = null;

    public function __construct()
    {
        $this->setCreationAt(new DateTime());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): self
    {
        $this->note = $note;

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

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
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
}
