<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

    #[ORM\Entity]
    #[ORM\Table(name:"editeur")]
    #[ApiResource]

class Editeur
{
   #[ORM\Column(name:"edit_id", type:"integer", nullable:false)]
   #[ORM\Id]
   #[ORM\GeneratedValue(strategy:"IDENTITY")]

    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }
  #[ORM\Column(name:"edit_nom", type:"string", length:50, nullable:false)]
  #[Assert\NotBlank]
  #[Assert\Regex(
     pattern: "/\d/",
     match:false,
     message:"Le nom ne doit pas contenir des chiffres")]
  #[Groups(["livre:read", "livre:item"])]

    private $nom;

   #[ORM\OneToMany(targetEntity:"App\Entity\Livre", mappedBy:"editeur")]

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
            $livre->setEditeur($this);
        }

        return $this;
    }

    public function removeLivre(Livre $livre): self
    {
        if ($this->livres->contains($livre)) {
            $this->livres->removeElement($livre);
            // set the owning side to null (unless already changed)
            if ($livre->getEditeur() === $this) {
                $livre->setEditeur(null);
            }
        }

        return $this;
    }

    public function __toString(){
        // to show the name of the Editor in the select
        return $this->nom;
        // to show the id of the Editor in the select
        // return $this->id;
    }
        
}
