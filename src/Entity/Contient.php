<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContientRepository")
 * @ORM\Table(name="contient")
 */
class Contient
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     *  @ORM\Column(name = "id", type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Livre")
     * @ORM\JoinColumn(name="lvr_id", referencedColumnName="lvr_id", nullable=false)
     */
    private $lvrId;

    /**
     * @ORM\Column(name = "lvr_prunitHT", type="float")
     */
    private $lvrPrunitHT;

    /**
     * @ORM\Column(name = "cmmd_qte", type="integer")
     */
    private $cmmdQte;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Commande", inversedBy="contients")
     * @ORM\JoinColumn(name = "cmmd_id", referencedColumnName="cmmd_id", nullable=false)
     */
    private $cmmdId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getLvrId(): ?Livre
    {
        return $this->lvrId;
    }

    public function setLvrId(?Livre $lvrId): self
    {
        $this->lvrId = $lvrId;

        return $this;
    }

    public function getLvrPrunitHT(): ?float
    {
        return $this->lvrPrunitHT;
    }

    public function setLvrPrunitHT(float $lvrPrunitHT): self
    {
        $this->lvrPrunitHT = $lvrPrunitHT;

        return $this;
    }

    public function getCmmdQte(): ?int
    {
        return $this->cmmdQte;
    }

    public function setCmmdQte(int $cmmdQte): self
    {
        $this->cmmdQte = $cmmdQte;

        return $this;
    }

    public function getCmmdId(): ?Commande
    {
        return $this->cmmdId;
    }

    public function setCmmdId(?Commande $cmmdId): self
    {
        $this->cmmdId = $cmmdId;

        return $this;
    }
}
