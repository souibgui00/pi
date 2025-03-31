<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use App\Repository\UtilisateurRepository;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
#[ORM\Table(name: 'utilisateur')]
class Utilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    #[ORM\Column(type: 'string', nullable: false)]
    private ?string $nom = null;

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    #[ORM\Column(type: 'string', nullable: false)]
    private ?string $prenom = null;

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;
        return $this;
    }

    #[ORM\Column(type: 'string', nullable: false)]
    private ?string $role = null;

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;
        return $this;
    }

    #[ORM\Column(type: 'string', nullable: false)]
    private ?string $mot_de_passe = null;

    public function getMot_de_passe(): ?string
    {
        return $this->mot_de_passe;
    }

    public function setMot_de_passe(string $mot_de_passe): self
    {
        $this->mot_de_passe = $mot_de_passe;
        return $this;
    }

    #[ORM\Column(type: 'string', nullable: false)]
    private ?string $nationalite = null;

    public function getNationalite(): ?string
    {
        return $this->nationalite;
    }

    public function setNationalite(string $nationalite): self
    {
        $this->nationalite = $nationalite;
        return $this;
    }

    #[ORM\Column(type: 'string', nullable: false)]
    private ?string $genre = null;

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;
        return $this;
    }

    #[ORM\Column(type: 'string', nullable: false)]
    private ?string $email = null;

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    #[ORM\Column(type: 'boolean', nullable: true)]
    private ?bool $permission = null;

    public function isPermission(): ?bool
    {
        return $this->permission;
    }

    public function setPermission(?bool $permission): self
    {
        $this->permission = $permission;
        return $this;
    }

    #[ORM\Column(type: 'boolean', nullable: true)]
    private ?bool $statut = null;

    public function isStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(?bool $statut): self
    {
        $this->statut = $statut;
        return $this;
    }

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $verification_token = null;

    public function getVerification_token(): ?string
    {
        return $this->verification_token;
    }

    public function setVerification_token(?string $verification_token): self
    {
        $this->verification_token = $verification_token;
        return $this;
    }

    #[ORM\Column(type: 'boolean', nullable: true)]
    private ?bool $is_verified = null;

    public function is_verified(): ?bool
    {
        return $this->is_verified;
    }

    public function setIs_verified(?bool $is_verified): self
    {
        $this->is_verified = $is_verified;
        return $this;
    }

    #[ORM\OneToMany(targetEntity: ContratSponsoring::class, mappedBy: 'utilisateur')]
    private Collection $contratSponsorings;

    /**
     * @return Collection<int, ContratSponsoring>
     */
    public function getContratSponsorings(): Collection
    {
        if (!$this->contratSponsorings instanceof Collection) {
            $this->contratSponsorings = new ArrayCollection();
        }
        return $this->contratSponsorings;
    }

    public function addContratSponsoring(ContratSponsoring $contratSponsoring): self
    {
        if (!$this->getContratSponsorings()->contains($contratSponsoring)) {
            $this->getContratSponsorings()->add($contratSponsoring);
        }
        return $this;
    }

    public function removeContratSponsoring(ContratSponsoring $contratSponsoring): self
    {
        $this->getContratSponsorings()->removeElement($contratSponsoring);
        return $this;
    }

    #[ORM\OneToMany(targetEntity: Evenement::class, mappedBy: 'utilisateur')]
    private Collection $evenements;

    /**
     * @return Collection<int, Evenement>
     */
    public function getEvenements(): Collection
    {
        if (!$this->evenements instanceof Collection) {
            $this->evenements = new ArrayCollection();
        }
        return $this->evenements;
    }

    public function addEvenement(Evenement $evenement): self
    {
        if (!$this->getEvenements()->contains($evenement)) {
            $this->getEvenements()->add($evenement);
        }
        return $this;
    }

    public function removeEvenement(Evenement $evenement): self
    {
        $this->getEvenements()->removeElement($evenement);
        return $this;
    }

    #[ORM\OneToMany(targetEntity: Participation::class, mappedBy: 'utilisateur')]
    private Collection $participations;

    /**
     * @return Collection<int, Participation>
     */
    public function getParticipations(): Collection
    {
        if (!$this->participations instanceof Collection) {
            $this->participations = new ArrayCollection();
        }
        return $this->participations;
    }

    public function addParticipation(Participation $participation): self
    {
        if (!$this->getParticipations()->contains($participation)) {
            $this->getParticipations()->add($participation);
        }
        return $this;
    }

    public function removeParticipation(Participation $participation): self
    {
        $this->getParticipations()->removeElement($participation);
        return $this;
    }

    #[ORM\OneToMany(targetEntity: Produitsponsoring::class, mappedBy: 'utilisateur')]
    private Collection $produitsponsorings;

    /**
     * @return Collection<int, Produitsponsoring>
     */
    public function getProduitsponsorings(): Collection
    {
        if (!$this->produitsponsorings instanceof Collection) {
            $this->produitsponsorings = new ArrayCollection();
        }
        return $this->produitsponsorings;
    }

    public function addProduitsponsoring(Produitsponsoring $produitsponsoring): self
    {
        if (!$this->getProduitsponsorings()->contains($produitsponsoring)) {
            $this->getProduitsponsorings()->add($produitsponsoring);
        }
        return $this;
    }

    public function removeProduitsponsoring(Produitsponsoring $produitsponsoring): self
    {
        $this->getProduitsponsorings()->removeElement($produitsponsoring);
        return $this;
    }

    #[ORM\OneToMany(targetEntity: Reclamation::class, mappedBy: 'utilisateur')]
    private Collection $reclamations;

    public function __construct()
    {
        $this->contratSponsorings = new ArrayCollection();
        $this->evenements = new ArrayCollection();
        $this->participations = new ArrayCollection();
        $this->produitsponsorings = new ArrayCollection();
        $this->reclamations = new ArrayCollection();
    }

    /**
     * @return Collection<int, Reclamation>
     */
    public function getReclamations(): Collection
    {
        if (!$this->reclamations instanceof Collection) {
            $this->reclamations = new ArrayCollection();
        }
        return $this->reclamations;
    }

    public function addReclamation(Reclamation $reclamation): self
    {
        if (!$this->getReclamations()->contains($reclamation)) {
            $this->getReclamations()->add($reclamation);
        }
        return $this;
    }

    public function removeReclamation(Reclamation $reclamation): self
    {
        $this->getReclamations()->removeElement($reclamation);
        return $this;
    }

    public function getMotDePasse(): ?string
    {
        return $this->mot_de_passe;
    }

    public function setMotDePasse(string $mot_de_passe): static
    {
        $this->mot_de_passe = $mot_de_passe;

        return $this;
    }

    public function getVerificationToken(): ?string
    {
        return $this->verification_token;
    }

    public function setVerificationToken(?string $verification_token): static
    {
        $this->verification_token = $verification_token;

        return $this;
    }

    public function isVerified(): ?bool
    {
        return $this->is_verified;
    }

    public function setIsVerified(?bool $is_verified): static
    {
        $this->is_verified = $is_verified;

        return $this;
    }

}
