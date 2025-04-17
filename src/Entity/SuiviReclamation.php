<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Repository\SuiviReclamationRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SuiviReclamationRepository::class)]
#[ORM\Table(name: 'suivi_reclamation')]
class SuiviReclamation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', nullable: false)]
    #[Assert\NotBlank(message: "Le statut est obligatoire.")]
    #[Assert\Length(
        max: 50,
        maxMessage: "Le statut ne peut pas dépasser {{ limit }} caractères."
    )]
    #[Assert\Choice(
        choices: ['en attente', 'en cours', 'résolu'],
        message: "Le statut doit être 'en attente', 'en cours' ou 'résolu'."
    )]
    private ?string $status = null;

    #[ORM\Column(type: 'string', nullable: false)]
    #[Assert\NotBlank(message: "Le commentaire est obligatoire.")]
    #[Assert\Length(
        min: 5,
        max: 1000,
        minMessage: "Le commentaire doit contenir au moins {{ limit }} caractères.",
        maxMessage: "Le commentaire ne peut pas dépasser {{ limit }} caractères."
    )]
    private ?string $commentaire = null;

    #[ORM\ManyToOne(targetEntity: Reclamation::class, inversedBy: 'suiviReclamations')]
    #[ORM\JoinColumn(name: 'id_reclamation', referencedColumnName: 'id')]
    #[Assert\NotBlank(message: "La réclamation est obligatoire.")]
    private ?Reclamation $reclamation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): self
    {
        $this->commentaire = $commentaire;
        return $this;
    }

    public function getReclamation(): ?Reclamation
    {
        return $this->reclamation;
    }

    public function setReclamation(?Reclamation $reclamation): self
    {
        $this->reclamation = $reclamation;
        return $this;
    }
}