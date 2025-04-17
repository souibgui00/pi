<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Repository\UtilisateurRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
#[ORM\Table(name: 'utilisateur')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 50, nullable: false)]
    #[Assert\NotBlank(message: "Le nom est obligatoire.")]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: "Le nom doit contenir au moins {{ limit }} caractères.",
        maxMessage: "Le nom ne peut pas dépasser {{ limit }} caractères."
    )]
    private ?string $nom = null;

    #[ORM\Column(type: 'string', length: 50, nullable: false)]
    #[Assert\NotBlank(message: "Le prénom est obligatoire.")]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: "Le prénom doit contenir au moins {{ limit }} caractères.",
        maxMessage: "Le prénom ne peut pas dépasser {{ limit }} caractères."
    )]
    private ?string $prenom = null;

    #[ORM\Column(type: 'json', nullable: false)]
    #[Assert\NotBlank(message: "Le rôle est obligatoire.")]
    #[Assert\Choice(
        choices: ['ROLE_ADMIN', 'ROLE_USER', 'ROLE_MODERATOR'],
        multiple: true,
        message: "Le rôle doit être 'ROLE_ADMIN', 'ROLE_USER' ou 'ROLE_MODERATOR'."
    )]
    private array $role = ['ROLE_USER'];

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private ?string $mot_de_passe = null;

    #[ORM\Column(type: 'string', length: 50, nullable: false)]
    #[Assert\NotBlank(message: "La nationalité est obligatoire.")]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: "La nationalité doit contenir au moins {{ limit }} caractères.",
        maxMessage: "La nationalité ne peut pas dépasser {{ limit }} caractères."
    )]
    private ?string $nationalite = null;

    #[ORM\Column(type: 'string', length: 20, nullable: false)]
    #[Assert\NotBlank(message: "Le genre est obligatoire.")]
    #[Assert\Choice(
        choices: ['Homme', 'Femme', 'Autre'],
        message: "Le genre doit être 'Homme', 'Femme' ou 'Autre'."
    )]
    private ?string $genre = null;

    #[ORM\Column(type: 'string', length: 180, nullable: false)]
    #[Assert\NotBlank(message: "L’email est obligatoire.")]
    #[Assert\Email(message: "Veuillez entrer un email valide.")]
    #[Assert\Length(
        max: 180,
        maxMessage: "L’email ne peut pas dépasser {{ limit }} caractères."
    )]
    private ?string $email = null;

    #[ORM\Column(type: 'boolean', nullable: false)]
    #[Assert\NotBlank(message: "La permission est obligatoire.")]
    private ?bool $permission = null;

    #[ORM\Column(type: 'boolean', nullable: false, options: ['default' => true])]
    #[Assert\NotBlank(message: "Le statut est obligatoire.")]
    private bool $statut = true;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $verification_token = null;

    #[ORM\Column(type: 'boolean', nullable: false)]
    #[Assert\NotBlank(message: "Le statut de vérification est obligatoire.")]
    private ?bool $is_verified = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $resetToken = null;

    #[ORM\OneToMany(mappedBy: 'utilisateur', targetEntity: ContratSponsoring::class, cascade: ['remove'])]
    private Collection $contratSponsorings;

    #[ORM\OneToMany(mappedBy: 'utilisateur', targetEntity: Participation::class, cascade: ['remove'])]
    private Collection $participations;

    #[ORM\OneToMany(mappedBy: 'utilisateur', targetEntity: Produitsponsoring::class, cascade: ['remove'])]
    private Collection $produitsponsorings;

    #[ORM\OneToMany(mappedBy: 'utilisateur', targetEntity: Reclamation::class, cascade: ['remove'])]
    private Collection $reclamations;

    #[ORM\OneToOne(mappedBy: 'utilisateur', targetEntity: Profil::class, cascade: ['persist', 'remove'])]
    private ?Profil $profil = null;

    public function __construct()
    {
        $this->contratSponsorings = new ArrayCollection();
        $this->participations = new ArrayCollection();
        $this->produitsponsorings = new ArrayCollection();
        $this->reclamations = new ArrayCollection();
    }

    public function getRoles(): array
    {
        $roles = $this->role;
        if (empty($roles)) {
            $roles[] = 'ROLE_USER';
        }
        return array_unique($roles);
    }

    public function getPassword(): ?string
    {
        return $this->mot_de_passe;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function eraseCredentials(): void
    {
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;
        return $this;
    }

    public function getRole(): array
    {
        return $this->role;
    }

    public function setRole(array $role): self
    {
        $this->role = $role;
        return $this;
    }

    public function getMotDePasse(): ?string
    {
        return $this->mot_de_passe;
    }

    public function setMotDePasse(string $mot_de_passe): self
    {
        $this->mot_de_passe = $mot_de_passe;
        return $this;
    }

    public function getNationalite(): ?string
    {
        return $this->nationalite;
    }

    public function setNationalite(string $nationalite): self
    {
        $this->nationalite = $nationalite;
        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getPermission(): ?bool
    {
        return $this->permission;
    }

    public function setPermission(bool $permission): self
    {
        $this->permission = $permission;
        return $this;
    }

    public function getStatut(): bool
    {
        return $this->statut;
    }

    public function setStatut(bool $statut): self
    {
        $this->statut = $statut;
        return $this;
    }

    public function getVerificationToken(): ?string
    {
        return $this->verification_token;
    }

    public function setVerificationToken(?string $verification_token): self
    {
        $this->verification_token = $verification_token;
        return $this;
    }

    public function isVerified(): ?bool
    {
        return $this->is_verified;
    }

    public function setIsVerified(bool $is_verified): self
    {
        $this->is_verified = $is_verified;
        return $this;
    }

    public function getResetToken(): ?string
    {
        return $this->resetToken;
    }

    public function setResetToken(?string $resetToken): self
    {
        $this->resetToken = $resetToken;
        return $this;
    }

    /**
     * @return Collection<int, ContratSponsoring>
     */
    public function getContratSponsorings(): Collection
    {
        return $this->contratSponsorings;
    }

    public function addContratSponsoring(ContratSponsoring $contratSponsoring): self
    {
        if (!$this->contratSponsorings->contains($contratSponsoring)) {
            $this->contratSponsorings->add($contratSponsoring);
            $contratSponsoring->setUtilisateur($this);
        }
        return $this;
    }

    public function removeContratSponsoring(ContratSponsoring $contratSponsoring): self
    {
        if ($this->contratSponsorings->removeElement($contratSponsoring)) {
            if ($contratSponsoring->getUtilisateur() === $this) {
                $contratSponsoring->setUtilisateur(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, Participation>
     */
    public function getParticipations(): Collection
    {
        return $this->participations;
    }

    public function addParticipation(Participation $participation): self
    {
        if (!$this->participations->contains($participation)) {
            $this->participations->add($participation);
            $participation->setUtilisateur($this);
        }
        return $this;
    }

    public function removeParticipation(Participation $participation): self
    {
        if ($this->participations->removeElement($participation)) {
            if ($participation->getUtilisateur() === $this) {
                $participation->setUtilisateur(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, Produitsponsoring>
     */
    public function getProduitsponsorings(): Collection
    {
        return $this->produitsponsorings;
    }

    public function addProduitsponsoring(Produitsponsoring $produitsponsoring): self
    {
        if (!$this->produitsponsorings->contains($produitsponsoring)) {
            $this->produitsponsorings->add($produitsponsoring);
            $produitsponsoring->setUtilisateur($this);
        }
        return $this;
    }

    public function removeProduitsponsoring(Produitsponsoring $produitsponsoring): self
    {
        if ($this->produitsponsorings->removeElement($produitsponsoring)) {
            if ($produitsponsoring->getUtilisateur() === $this) {
                $produitsponsoring->setUtilisateur(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, Reclamation>
     */
    public function getReclamations(): Collection
    {
        return $this->reclamations;
    }

    public function addReclamation(Reclamation $reclamation): self
    {
        if (!$this->reclamations->contains($reclamation)) {
            $this->reclamations->add($reclamation);
            $reclamation->setUtilisateur($this);
        }
        return $this;
    }

    public function removeReclamation(Reclamation $reclamation): self
    {
        if ($this->reclamations->removeElement($reclamation)) {
            if ($reclamation->getUtilisateur() === $this) {
                $reclamation->setUtilisateur(null);
            }
        }
        return $this;
    }

    public function getProfil(): ?Profil
    {
        return $this->profil;
    }

    public function setProfil(?Profil $profil): self
    {
        $this->profil = $profil;
        if ($profil && $profil->getUtilisateur() !== $this) {
            $profil->setUtilisateur($this);
        }
        return $this;
    }
}