<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Repository\SupportRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SupportRepository::class)]
#[ORM\Table(name: 'support')]
class Support
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', nullable: true)]
    #[Assert\Length(
        max: 255,
        maxMessage: "L’URL ne peut pas dépasser {{ limit }} caractères."
    )]
    #[Assert\Url(message: "Veuillez entrer une URL valide (ex. https://example.com).")]
    private ?string $url = null;

    #[ORM\Column(type: 'string', nullable: false)]
    #[Assert\NotBlank(message: "Le type est obligatoire.")]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: "Le type doit contenir au moins {{ limit }} caractères.",
        maxMessage: "Le type ne peut pas dépasser {{ limit }} caractères."
    )]
    #[Assert\Choice(
        choices: ['image', 'video', 'document'],
        message: "Le type doit être 'image', 'video' ou 'document'."
    )]
    private ?string $type = null;

    #[ORM\ManyToOne(targetEntity: Evenement::class, inversedBy: 'supports')]
    #[ORM\JoinColumn(name: 'id_evenement_associe', referencedColumnName: 'id', nullable: true)]
    private ?Evenement $evenement = null;

    #[ORM\Column(type: 'string', nullable: false)]
    #[Assert\NotBlank(message: "Le titre est obligatoire.")]
    #[Assert\Length(
        min: 2,
        max: 100,
        minMessage: "Le titre doit contenir au moins {{ limit }} caractères.",
        maxMessage: "Le titre ne peut pas dépasser {{ limit }} caractères."
    )]
    private ?string $titre = null;

    #[ORM\OneToMany(targetEntity: Supportpermission::class, mappedBy: 'support')]
    private Collection $supportpermissions;

    public function __construct()
    {
        $this->supportpermissions = new ArrayCollection();
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

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;
        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;
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

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;
        return $this;
    }

    /**
     * @return Collection<int, Supportpermission>
     */
    public function getSupportpermissions(): Collection
    {
        if (!$this->supportpermissions instanceof Collection) {
            $this->supportpermissions = new ArrayCollection();
        }
        return $this->supportpermissions;
    }

    public function addSupportpermission(Supportpermission $supportpermission): self
    {
        if (!$this->getSupportpermissions()->contains($supportpermission)) {
            $this->getSupportpermissions()->add($supportpermission);
        }
        return $this;
    }

    public function removeSupportpermission(Supportpermission $supportpermission): self
    {
        $this->getSupportpermissions()->removeElement($supportpermission);
        return $this;
    }
}