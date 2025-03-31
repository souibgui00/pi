<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Repository\ContratSponsoringRepository;

#[ORM\Entity(repositoryClass: ContratSponsoringRepository::class)]
#[ORM\Table(name: 'contrat_sponsoring')]
class ContratSponsoring
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $montant = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class, inversedBy: 'contratSponsorings')]
    #[ORM\JoinColumn(name: 'id_utilisateur', referencedColumnName: 'id')]
    private ?Utilisateur $utilisateur = null;

    #[ORM\ManyToOne(targetEntity: Evenement::class, inversedBy: 'contratSponsorings')]
    #[ORM\JoinColumn(name: 'id_evenementAssocie', referencedColumnName: 'id')]
    private ?Evenement $evenement = null;

    #[ORM\ManyToMany(targetEntity: Produitsponsoring::class, inversedBy: 'contratSponsorings')]
    #[ORM\JoinTable(
        name: 'contrat_produit_sponsoring',
        joinColumns: [new ORM\JoinColumn(name: 'id_contrat', referencedColumnName: 'id')],
        inverseJoinColumns: [new ORM\JoinColumn(name: 'id_produit', referencedColumnName: 'id')]
    )]
    private Collection $produitsponsorings;

    public function __construct()
    {
        $this->produitsponsorings = new ArrayCollection();
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

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(?float $montant): self
    {
        $this->montant = $montant;
        return $this;
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
            $produitsponsoring->addContratSponsoring($this); // Synchronisation bidirectionnelle
        }
        return $this;
    }

    public function removeProduitsponsoring(Produitsponsoring $produitsponsoring): self
    {
        if ($this->produitsponsorings->removeElement($produitsponsoring)) {
            $produitsponsoring->removeContratSponsoring($this); // Synchronisation bidirectionnelle
        }
        return $this;
    }
}