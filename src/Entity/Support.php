<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use App\Repository\SupportRepository;

#[ORM\Entity(repositoryClass: SupportRepository::class)]
#[ORM\Table(name: 'support')]
class Support
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

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $url = null;

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;
        return $this;
    }

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $type = null;

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;
        return $this;
    }

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $id_evenementAssocie = null;

    public function getId_evenementAssocie(): ?int
    {
        return $this->id_evenementAssocie;
    }

    public function setId_evenementAssocie(?int $id_evenementAssocie): self
    {
        $this->id_evenementAssocie = $id_evenementAssocie;
        return $this;
    }

    #[ORM\Column(type: 'string', nullable: false)]
    private ?string $titre = null;

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;
        return $this;
    }

    #[ORM\OneToMany(targetEntity: Supportpermission::class, mappedBy: 'support')]
    private Collection $supportpermissions;

    public function __construct()
    {
        $this->supportpermissions = new ArrayCollection();
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

    public function getIdEvenementAssocie(): ?int
    {
        return $this->id_evenementAssocie;
    }

    public function setIdEvenementAssocie(?int $id_evenementAssocie): static
    {
        $this->id_evenementAssocie = $id_evenementAssocie;

        return $this;
    }

}
