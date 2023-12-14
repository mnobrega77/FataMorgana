<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiProperty;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
#[ORM\Table(name:"fournisseur")]
#[ApiResource]


class Fournisseur
{
    #[ORM\Column(name:"four_id", type:"integer", nullable:false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy:"IDENTITY")]
    #[Groups(["livre:read", "livre:item"])]

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
    #[ORM\Column(name:"four_nom", type:"string", length:50, nullable:false)]
    #[Assert\NotBlank]
    #[Groups(["livre:read", "livre:item"])]

    private $nom;

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    #[ORM\Column(name:"four_ad", type:"string", length:50, nullable:false)]
    #[Assert\NotBlank]

    private $adresse;

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;
        return $this;
    }
    #[ORM\Column(name:"four_contact", type:"string", length:50, nullable:false)]
    #[Assert\NotBlank]

    private $contact;

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(string $contact): self
    {
        $this->contact = $contact;
        return $this;
    }
    #[ORM\Column(name:"four_cp", type:"string", length:15, nullable:false)]
    #[Assert\NotBlank]

    private $code;

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;
        return $this;
    }

    #[ORM\Column(name:"four_ville", type:"string", length:30, nullable:false)]
    #[Assert\NotBlank]

    private $ville;

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;
        return $this;
    }

    #[ORM\Column(name:"four_tel", type:"string", length:20, nullable:false)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 8, max: 20, minMessage: "Votre numéro est trop court", maxMessage : "Le numéro dépasse la longueur admise")]
    #[Assert\Regex("/[0-9]*$/")]

    private $phone;

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;
        return $this;
    }

    #[ORM\Column(name:"four_pays", type:"string", length:30, nullable:false)]
    #[Assert\NotBlank]

    private $pays;

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): self
    {
        $this->pays = $pays;
        return $this;
    }

    #[ORM\Column(name:"four_email", type:"string", length:30, nullable:false)]
    #[Assert\NotBlank]
    #[Assert\Email(
          message : "L'adresse email '{{ value }}' n'est pas valide."
     )]

    private $email;

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    #[ORM\Column(name:"four_type", type:"string", length:6, nullable:false)]
    #[Assert\NotBlank]

    private $type;

    #[ORM\OneToMany(targetEntity:"App\Entity\Livre", mappedBy:"fournisseur")]

    private $livres;

    public function __construct()
    {
        $this->livres = new ArrayCollection();
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
            $livre->setFournisseur($this);
        }

        return $this;
    }

    public function removeLivre(Livre $livre): self
    {
        if ($this->livres->contains($livre)) {
            $this->livres->removeElement($livre);
            // set the owning side to null (unless already changed)
            if ($livre->getFournisseur() === $this) {
                $livre->setFournisseur(null);
            }
        }

        return $this;
    }

    public function __toString(){
        // to show the name in the select
        return $this->nom;
        // to show the id in the select
        // return $this->id;
    }









        
}
