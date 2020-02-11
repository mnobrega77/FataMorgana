<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SousCategorieRepository"))
 * @ORM\Table(name="souscategorie")
 */

class SousCategorie
{
    /**
     * @ORM\Column(name="scat_id", type="string", length=6, nullable=false, unique=true)
     * @ORM\Id()
     * @Groups("livre:read")
     */
    private $id;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;
        return $id;
    }
    /**
     * @ORM\Column(name="scat_nom", type="string", length=50, nullable=false)
     * @Groups("livre:read")
     */
    private $nom;

    /**
     * @var \Categorie
     * 
     * @ORM\ManyToOne(targetEntity="App\Entity\Categorie", inversedBy="sousCategories")
     * @ORM\JoinColumn(name="cat_id", referencedColumnName="cat_id", nullable=false)
     */
    private $categorie;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Livre", mappedBy="souscategorie")
     */
    private $livres;

    public function __construct()
    {
        $this->livres = new ArrayCollection();
    }



    public function getNom(): ?string{
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $nom;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Collection|Livre[]
     */
    public function getLivres(): Collection
    {
        return $this->livres;
    }

    public function addLivre(Livre $livre): self
    {
        if (!$this->livres->contains($livre)) {
            $this->livres[] = $livre;
            $livre->setSouscategorie($this);
        }

        return $this;
    }

    public function removeLivre(Livre $livre): self
    {
        if ($this->livres->contains($livre)) {
            $this->livres->removeElement($livre);
            // set the owning side to null (unless already changed)
            if ($livre->getSouscategorie() === $this) {
                $livre->setSouscategorie(null);
            }
        }

        return $this;
    }

    public function __toString(){
        // to show the name of the SousCategorie in the select
        return $this->nom;
        // to show the id of the Categoie in the select
        // return $this->id;
    }
}
