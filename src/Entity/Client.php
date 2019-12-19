<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 */
class Client
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="cli_id", type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="cli_nom", type="string", length=30)
     */
    private $nom;

    /**
     * @ORM\Column(name="cli_prenom", type="string", length=30)
     */
    private $prenom;

    /**
     * @ORM\Column(name="cli_ad", type="string", length=50)
     */
    private $adresse;

    /**
     * @ORM\Column(name="cli_cp", type="string", length=10)
     */
    private $cp;

    /**
     * @ORM\Column(name="cli_ville", type="string", length=20)
     */
    private $ville;

    /**
     * @ORM\Column(name="cli_tel", type="string", length=20)
     */
    private $tel;

    /**
     * @ORM\Column(name="cli_type", type="string", length=4, nullable=true)
     */
    private $type;

    /**
     * @ORM\Column(name="cli_coeff", type="float", nullable=true)
     */
    private $coeff;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="client", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="user_id", nullable=false)
     */
    private $userId;

    /**
     * @ORM\Column(name="comm_ref", type="string", length=6, nullable=true)
     */
    private $commRef;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCp(): ?string
    {
        return $this->cp;
    }

    public function setCp(string $cp): self
    {
        $this->cp = $cp;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): self
    {
        $this->tel = $tel;

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

    public function getCoeff(): ?float
    {
        return $this->coeff;
    }

    public function setCoeff(?float $coeff): self
    {
        $this->coeff = $coeff;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->userId;
    }

    public function setUserId(User $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getCommRef(): ?string
    {
        return $this->commRef;
    }

    public function setCommRef(?string $commRef): self
    {
        $this->commRef = $commRef;

        return $this;
    }
}
