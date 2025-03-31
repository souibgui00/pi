<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use App\Repository\EvenementRepository;

#[ORM\Entity(repositoryClass: EvenementRepository::class)]
#[ORM\Table(name: 'evenement')]
class Evenement
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

    #[ORM\Column(type: 'text', nullable: false)]
    private ?string $description = null;

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    #[ORM\Column(type: 'datetime', nullable: false)]
    private ?\DateTimeInterface $date = null;

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;
        return $this;
    }

    #[ORM\Column(type: 'string', nullable: false)]
    private ?string $lieu = null;

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): self
    {
        $this->lieu = $lieu;
        return $this;
    }

    #[ORM\Column(type: 'string', nullable: false)]
    private ?string $statut = null;

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;
        return $this;
    }

    #[ORM\Column(type: 'integer', nullable: false)]
    private ?int $capacite_max = null;

    public function getCapacite_max(): ?int
    {
        return $this->capacite_max;
    }

    public function setCapacite_max(int $capacite_max): self
    {
        $this->capacite_max = $capacite_max;
        return $this;
    }

    #[ORM\Column(type: 'string', nullable: false)]
    private ?string $image = null;

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;
        return $this;
    }

    #[ORM\ManyToOne(targetEntity: Utilisateur::class, inversedBy: 'evenements')]
    #[ORM\JoinColumn(name: 'id_user', referencedColumnName: 'id')]
    private ?Utilisateur $utilisateur = null;

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;
        return $this;
    }

    #[ORM\Column(type: 'string', nullable: false)]
    private ?string $type = null;

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    #[ORM\OneToMany(targetEntity: ContratSponsoring::class, mappedBy: 'evenement')]
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

    #[ORM\OneToMany(targetEntity: Participation::class, mappedBy: 'evenement')]
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

    #[ORM\OneToMany(targetEntity: Reclamation::class, mappedBy: 'evenement')]
    private Collection $reclamations;

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

    #[ORM\OneToMany(targetEntity: Service::class, mappedBy: 'evenement')]
    private Collection $services;

    /**
     * @return Collection<int, Service>
     */
    public function getServices(): Collection
    {
        if (!$this->services instanceof Collection) {
            $this->services = new ArrayCollection();
        }
        return $this->services;
    }

    public function addService(Service $service): self
    {
        if (!$this->getServices()->contains($service)) {
            $this->getServices()->add($service);
        }
        return $this;
    }

    public function removeService(Service $service): self
    {
        $this->getServices()->removeElement($service);
        return $this;
    }

    #[ORM\OneToMany(targetEntity: Transport::class, mappedBy: 'evenement')]
    private Collection $transports;

    public function __construct()
    {
        $this->contratSponsorings = new ArrayCollection();
        $this->participations = new ArrayCollection();
        $this->reclamations = new ArrayCollection();
        $this->services = new ArrayCollection();
        $this->transports = new ArrayCollection();
    }

    /**
     * @return Collection<int, Transport>
     */
    public function getTransports(): Collection
    {
        if (!$this->transports instanceof Collection) {
            $this->transports = new ArrayCollection();
        }
        return $this->transports;
    }

    public function addTransport(Transport $transport): self
    {
        if (!$this->getTransports()->contains($transport)) {
            $this->getTransports()->add($transport);
        }
        return $this;
    }

    public function removeTransport(Transport $transport): self
    {
        $this->getTransports()->removeElement($transport);
        return $this;
    }

    public function getCapaciteMax(): ?int
    {
        return $this->capacite_max;
    }

    public function setCapaciteMax(int $capacite_max): static
    {
        $this->capacite_max = $capacite_max;

        return $this;
    }

}
