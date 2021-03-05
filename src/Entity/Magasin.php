<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MagasinRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MagasinRepository::class)
 * @ApiResource(
 *     collectionOperations={
 *         "get",
 *         "post"={"security"="is_granted('ROLE_USER')"}
 *     },
 *     itemOperations={
 *         "get",
 *         "put"={"security"="is_granted('ROLE_ADMIN')"},
 *         "delete"={"security"="is_granted('ROLE_ADMIN')"}
 *     }
 * )
 */
class Magasin
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;


    /**
     * @ORM\OneToMany(targetEntity=Commande::class, mappedBy="magasin")
     */
    private $commandes;

    /**
     * @ORM\OneToMany(targetEntity=RendezVous::class, mappedBy="magasin")
     */
    private $rendezVouses;

    /**
     * @ORM\OneToMany(targetEntity=Stock::class, mappedBy="magasin")
     */
    private $stocks;

    public function __construct()
    {
        $this->stocks = new ArrayCollection();
        $this->commandes = new ArrayCollection();
        $this->rendezVouses = new ArrayCollection();
        $this->stocks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Commande[]
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->setMagasin($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getMagasin() === $this) {
                $commande->setMagasin(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|RendezVous[]
     */
    public function getRendezVouses(): Collection
    {
        return $this->rendezVouses;
    }

    public function addRendezVouse(RendezVous $rendezVouse): self
    {
        if (!$this->rendezVouses->contains($rendezVouse)) {
            $this->rendezVouses[] = $rendezVouse;
            $rendezVouse->setMagasin($this);
        }

        return $this;
    }

    public function removeRendezVouse(RendezVous $rendezVouse): self
    {
        if ($this->rendezVouses->removeElement($rendezVouse)) {
            // set the owning side to null (unless already changed)
            if ($rendezVouse->getMagasin() === $this) {
                $rendezVouse->setMagasin(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Stock[]
     */
    public function getStocks(): Collection
    {
        return $this->stocks;
    }

    public function addStock(Stock $stocks): self
    {
        if (!$this->stocks->contains($stocks)) {
            $this->stocks[] = $stocks;
            $stocks->setMagasin($this);
        }

        return $this;
    }

    public function removeStock(Stock $stocks): self
    {
        if ($this->stocks->removeElement($stocks)) {
            // set the owning side to null (unless already changed)
            if ($stocks->getMagasin() === $this) {
                $stocks->setMagasin(null);
            }
        }

        return $this;
    }

    public function __toString() {
        return $this->name;
    }
}
