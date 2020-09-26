<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="auteur")
 * @ApiResource()
 */

class Auteur
{
    /**
     * @ORM\Column(name="aut_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Assert\NotBlank
     */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $id;
    }
    /**
     * @ORM\Column(name="aut_nom", type="string", length=50, nullable=false)
     * @Assert\NotBlank
     * @Groups({"livre:read", "livre:item"})
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Livre", mappedBy="auteur", orphanRemoval=true)
     * @Assert\NotBlank
     * @Assert\Regex(
     * pattern ="/\d/"),
     * match=false,
     * message="Le nom ne doit pas contenir des chiffres"
     */
    private $livres;

    public function __construct()
    {
        $this->livres = new ArrayCollection();
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
            $livre->setAuteur($this);
        }

        return $this;
    }

    public function removeLivre(Livre $livre): self
    {
        if ($this->livres->contains($livre)) {
            $this->livres->removeElement($livre);
            // set the owning side to null (unless already changed)
            if ($livre->getAuteur() === $this) {
                $livre->setAuteur(null);
            }
        }

        return $this;
    }

    public function __toString(){
        // to show the name of the Author in the select
        return $this->nom;
        // to show the id in the select
        // return $this->id;
    }

        
}
