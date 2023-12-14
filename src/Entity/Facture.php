<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass:"App\Repository\FactureRepository")]

class Facture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name:"fact_id", type:"integer")]

    private $id;

    #[ORM\Column(name :"fact_date", type:"date")]

    private $date;

    #[ORM\Column(name :"fact_totalHT", type:"float")]

    private $totalHT;

    #[ORM\Column(name :"fact_tva", type:"float")]

    private $tva;

    #[ORM\Column(name :"fact_reduc", type:"float", nullable:true)]
    private $reduc;

    #[ORM\Column(name :"fact_totalTTC", type:"float")]

    private $totalTTC;

    #[ORM\OneToOne(targetEntity:"App\Entity\Commande",inversedBy: "factId")]
    #[ORM\JoinColumn(name:"cmmd_id", referencedColumnName:"cmmd_id", nullable:false)]
    private $commande;

    /**
     * @return mixed
     */
    public function getCommande()
    {
        return $this->commande;
    }

    /**
     * @param mixed $commande
     */
    public function setCommande($commande): void
    {
        $this->commande = $commande;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTotalHT(): ?float
    {
        return $this->totalHT;
    }

    public function setTotalHT(float $totalHT): self
    {
        $this->totalHT = $totalHT;

        return $this;
    }

    public function getTva(): ?float
    {
        return $this->tva;
    }

    public function setTva(float $tva): self
    {
        $this->tva = $tva;

        return $this;
    }

    public function getReduc(): ?float
    {
        return $this->reduc;
    }

    public function setReduc(?float $reduc): self
    {
        $this->reduc = $reduc;

        return $this;
    }

    public function getTotalTTC(): ?float
    {
        return $this->totalTTC;
    }

    public function setTotalTTC(float $totalTTC): self
    {
        $this->totalTTC = $totalTTC;

        return $this;
    }
}
