<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Repository\ReclamationRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ReclamationRepository::class)]
#[ORM\Table(name: 'reclamation')]
class Reclamation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', nullable: false)]
    #[Assert\NotBlank(message: "Le message est obligatoire.")]
    #[Assert\Length(
        min: 10,
        max: 255,
        minMessage: "Le message doit contenir au moins {{ limit }} caractères.",
        maxMessage: "Le message ne peut pas dépasser {{ limit }} caractères."
    )]
    private ?string $message = null;

    #[ORM\Column(type: 'string', nullable: false)]
    #[Assert\NotBlank(message: "Le chemin de l'image est obligatoire.")]
    private ?string $image = null;

    #[ORM\Column(type: 'string', nullable: false)]
    #[Assert\NotBlank(message: "Le mot de passe est obligatoire.")]
    private ?string $pass = null;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class, inversedBy: 'reclamations')]
    #[ORM\JoinColumn(name: 'id_user', referencedColumnName: 'id')]
    #[Assert\NotBlank(message: "L'utilisateur est obligatoire.")]
    private ?Utilisateur $utilisateur = null;

    #[ORM\ManyToOne(targetEntity: Evenement::class, inversedBy: 'reclamations')]
    #[ORM\JoinColumn(name: 'id_evenement', referencedColumnName: 'id')]
    #[Assert\NotBlank(message: "L'événement est obligatoire.")]
    private ?Evenement $evenement = null;

    #[ORM\Column(type: 'string', nullable: true)]
    #[Assert\Choice(
        choices: ['en attente', 'traitée', 'rejetée'],
        message: "Veuillez sélectionner un statut valide (en attente, traitée, rejetée)."
    )]
    private ?string $statut = null;

    #[ORM\OneToMany(targetEntity: SuiviReclamation::class, mappedBy: 'reclamation')]
    private Collection $suiviReclamations;

    public function __construct()
    {
        $this->suiviReclamations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;
        return $this;
    }

    public function getPass(): ?string
    {
        return $this->pass;
    }

    public function setPass(string $pass): self
    {
        $this->pass = $pass;
        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;
        return $this;
    }

    public function getEvenement(): ?Evenement
    {
        return $this->evenement;
    }

    public function setEvenement(?Evenement $evenement): self
    {
        $this->evenement = $evenement;
        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): self
    {
        $this->statut = $statut;
        return $this;
    }

    /**
     * @return Collection<int, SuiviReclamation>
     */
    public function getSuiviReclamations(): Collection
    {
        if (!$this->suiviReclamations instanceof Collection) {
            $this->suiviReclamations = new ArrayCollection();
        }
        return $this->suiviReclamations;
    }

    public function addSuiviReclamation(SuiviReclamation $suiviReclamation): self
    {
        if (!$this->getSuiviReclamations()->contains($suiviReclamation)) {
            $this->getSuiviReclamations()->add($suiviReclamation);
        }
        return $this;
    }

    public function removeSuiviReclamation(SuiviReclamation $suiviReclamation): self
    {
        $this->getSuiviReclamations()->removeElement($suiviReclamation);
        return $this;
    }
}