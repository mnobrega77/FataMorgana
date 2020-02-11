<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;


/**
 * @ORM\Entity(repositoryClass="App\Repository\LivreRepository")
 * @ORM\Table(name="livre")
 * @ApiResource(
 *      collectionOperations={"get"={"normalization_context"={"groups"="livre:read"}}},
 *      attributes={
 *          "formats"={"jsonld", "json", "html", "csv"={"text/csv"}}
 *     }      
 * )
 * @ApiFilter(SearchFilter::class, properties={"titre": "partial"})
 */

class Livre
{
   
    /**
     * @ORM\Column(name="lvr_id", type="string", length=10, nullable=false, unique=true)
     * @ORM\Id
     * @Assert\NotBlank
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
        return $this;
    }
    /**
     * @ORM\Column(name="lvr_ref", type="string", length=30, nullable=false)
     * @Assert\NotBlank
     * @Groups("livre:read")
     */
    private $ref;

    public function getRef(): ?string
    {
        return $this->ref;
    }

    public function setRef(string $ref): self
    {
        $this->ref = $ref;
        return $this;
    }

    /**
     * @ORM\Column(name="lvr_detail", type="string", length=200, nullable=false)
     * @Groups("livre:read")
     */
    private $detail;

    public function getDetail(): ?string
    {
        return $this->detail;
    }

    public function setDetail(string $detail): self
    {
        $this->detail = $detail;
        return $this;
    }

    /**
     * @ORM\Column(name="lvr_titre", type="string", length=150, nullable=false)
     * @Assert\NotBlank
     * @Groups("livre:read")
     */
    private $titre;

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
     * @ORM\Column(name="lvr_resume", type="text", nullable=false)
     * @Groups("livre:read")
     */
    private $resume;

    public function getResume(): ?string 
    {
        return $this->resume;
    }
    public function setResume(string $resume): self 
    {
        $this->resume = $resume;
        return $this;
    }

    /**
     * @ORM\Column(name="lvr_prachat", type="float", precision=10, scale=8, nullable=false)
     * @Assert\NotBlank
     * @Assert\Positive
     * @Groups("livre:read")
     */
    private $prachat;

    public function getPrachat(): ?float 
    {
        return $this->prachat;
    }
    public function setPrachat(float $prachat): self 
    {
        $this->prachat = $prachat;
        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prachat*2;
    }

    /**
     * @ORM\Column(name="lvr_photo", type="string", length=200, nullable=true)
    
     */
    private $image;

    public function getImage(): ?string 
    {
        return $this->image;
    }
    public function setImage(string $image): self 
    {
        $this->image = $image;
        return $this;
    }

    
    /**
     * @ORM\Column(name="lvr_stock", type="integer", nullable=false)
     * @Assert\NotBlank
     * @Assert\PositiveOrZero
     * @Groups("livre:read")
     */
    private $stock;

    public function getStock(): ?int 
    {
        return $this->stock;
    }
    public function setStock(int $stock): self 
    {
        $this->stock = $stock;
        return $this;
    }

    /**
     * @ORM\Column(name="lvr_date_edition", type="date", nullable=false)
     * @Groups("livre:read")
     */
    private $dateEdition;

    
    /**
     * @var \SousCategorie
     
     * @ORM\ManyToOne(targetEntity="App\Entity\SousCategorie", inversedBy="livres")
     * @ORM\JoinColumn(name="scat_id", referencedColumnName="scat_id", nullable=false)
     * @Groups("livre:read")
     */
    private $souscategorie;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Auteur", inversedBy="livres")
     * @ORM\JoinColumn(name="aut_id", referencedColumnName="aut_id", nullable=false)
     * @Groups("livre:read")
     */
    private $auteur;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Editeur", inversedBy="livres", fetch="EAGER")
     * @ORM\JoinColumn(name="edit_id", referencedColumnName="edit_id", nullable=false)
     * 
     */
    private $editeur;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Fournisseur", inversedBy="livres", fetch="EAGER")
     * @ORM\JoinColumn(name="four_id", referencedColumnName="four_id", nullable=false)
     *
     */
    private $fournisseur;

    

    public function getDateEdition(): ?\DateTimeInterface
    {
        return $this->dateEdition;
    }
    public function setDateEdition(\DateTimeInterface $dateEdition): self 
    {
        $this->dateEdition = $dateEdition;
        return $this;
    }

    public function getSouscategorie(): ?SousCategorie
    {
        return $this->souscategorie;
    }

    public function setSouscategorie(?SousCategorie $souscategorie): self
    {
        $this->souscategorie = $souscategorie;

        return $this;
    }

    public function getAuteur(): ?Auteur
    {
        return $this->auteur;
    }

    public function setAuteur(?Auteur $auteur): self
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function getEditeur(): ?Editeur
    {
        return $this->editeur;
    }

    public function setEditeur(?Editeur $editeur): self
    {
        $this->editeur = $editeur;

        return $this;
    }

    public function getFournisseur(): ?Fournisseur
    {
        return $this->fournisseur;
    }

    public function setFournisseur(?Fournisseur $fournisseur): self
    {
        $this->fournisseur = $fournisseur;

        return $this;
    }

    
    public function __toString(){
        // to show the name of the Author in the select
        return $this->auteur->getNom();
        // to show the id in the select
        // return $this->id;
    }

}

