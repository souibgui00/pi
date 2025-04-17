<?php
namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TransportRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TransportRepository::class)]
#[ORM\Table(name: 'transport')]
class Transport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'date', nullable: false)]
    #[Assert\NotBlank(message: "La date est obligatoire.")]
    #[Assert\GreaterThanOrEqual(
        value: 'today',
        message: "La date doit être aujourd’hui ou dans le futur."
    )]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: 'time', nullable: false)]
    #[Assert\NotBlank(message: "L’heure de départ est obligatoire.")]
    private ?\DateTime $heureDepart = null;

    #[ORM\Column(type: 'string', nullable: false)]
    #[Assert\NotBlank(message: "Le point de départ est obligatoire.")]
    #[Assert\Length(
        min: 2,
        max: 100,
        minMessage: "Le point de départ doit contenir au moins {{ limit }} caractères.",
        maxMessage: "Le point de départ ne peut pas dépasser {{ limit }} caractères."
    )]
    private ?string $pointDepart = null;

    #[ORM\Column(type: 'string', nullable: false)]
    #[Assert\NotBlank(message: "La destination est obligatoire.")]
    #[Assert\Length(
        min: 2,
        max: 100,
        minMessage: "La destination doit contenir au moins {{ limit }} caractères.",
        maxMessage: "La destination ne peut pas dépasser {{ limit }} caractères."
    )]
    private ?string $destination = null;

    #[ORM\Column(type: 'string', nullable: false)]
    #[Assert\NotBlank(message: "Le véhicule est obligatoire.")]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: "Le véhicule doit contenir au moins {{ limit }} caractères.",
        maxMessage: "Le véhicule ne peut pas dépasser {{ limit }} caractères."
    )]
    private ?string $vehicule = null;

    #[ORM\ManyToOne(targetEntity: Evenement::class, inversedBy: 'transports')]
    #[ORM\JoinColumn(name: 'id_evenementAssocie', referencedColumnName: 'id')]
    #[Assert\NotBlank(message: "L’événement est obligatoire.")]
    private ?Evenement $evenement = null;

    #[ORM\ManyToOne(targetEntity: Service::class, inversedBy: 'transports')]
    #[ORM\JoinColumn(name: 'id_service', referencedColumnName: 'id')]
    #[Assert\NotBlank(message: "Le service est obligatoire.")]
    private ?Service $service = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;
        return $this;
    }

    public function getHeureDepart(): ?\DateTime
    {
        return $this->heureDepart;
    }

    public function setHeureDepart(\DateTime $heureDepart): self
    {
        $this->heureDepart = $heureDepart;
        return $this;
    }

    public function getPointDepart(): ?string
    {
        return $this->pointDepart;
    }

    public function setPointDepart(string $pointDepart): self
    {
        $this->pointDepart = $pointDepart;
        return $this;
    }

    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function setDestination(string $destination): self
    {
        $this->destination = $destination;
        return $this;
    }

    public function getVehicule(): ?string
    {
        return $this->vehicule;
    }

    public function setVehicule(string $vehicule): self
    {
        $this->vehicule = $vehicule;
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

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): self
    {
        $this->service = $service;
        return $this;
    }
}