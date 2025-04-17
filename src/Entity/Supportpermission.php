<?php
namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\SupportpermissionRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SupportpermissionRepository::class)]
#[ORM\Table(name: 'supportpermission')]
class Supportpermission
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Support::class, inversedBy: 'supportpermissions')]
    #[ORM\JoinColumn(name: 'support_id', referencedColumnName: 'id')]
    #[Assert\NotBlank(message: "Le support est obligatoire.")]
    private ?Support $support = null;

    #[ORM\Column(type: 'string', nullable: false)]
    #[Assert\NotBlank(message: "Le type de permission est obligatoire.")]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: "Le type doit contenir au moins {{ limit }} caractères.",
        maxMessage: "Le type ne peut pas dépasser {{ limit }} caractères."
    )]
    #[Assert\Choice(
        choices: ['lecture', 'écriture', 'gestion'],
        message: "Le type doit être 'lecture', 'écriture' ou 'gestion'."
    )]
    private ?string $permission_type = null;

    #[ORM\Column(type: 'string', nullable: false)]
    #[Assert\NotBlank(message: "Le rôle est obligatoire.")]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: "Le rôle doit contenir au moins {{ limit }} caractères.",
        maxMessage: "Le rôle ne peut pas dépasser {{ limit }} caractères."
    )]
    private ?string $role = null;

    #[ORM\Column(type: 'date', nullable: false)]
    #[Assert\NotBlank(message: "La date de début est obligatoire.")]
    #[Assert\GreaterThanOrEqual(
        value: 'today',
        message: "La date de début doit être aujourd’hui ou dans le futur."
    )]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: 'date', nullable: false)]
    #[Assert\NotBlank(message: "La date de fin est obligatoire.")]
    #[Assert\GreaterThanOrEqual(
        propertyPath: 'startDate',
        message: "La date de fin doit être postérieure ou égale à la date de début."
    )]
    private ?\DateTimeInterface $endDate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getSupport(): ?Support
    {
        return $this->support;
    }

    public function setSupport(?Support $support): self
    {
        $this->support = $support;
        return $this;
    }

    public function getPermissionType(): ?string
    {
        return $this->permission_type;
    }

    public function setPermissionType(string $permission_type): self
    {
        $this->permission_type = $permission_type;
        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;
        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;
        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;
        return $this;
    }
}