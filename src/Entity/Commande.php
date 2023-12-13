<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

 #[ORM\Entity(repositoryClass:"App\Repository\CommandeRepository")]
 #[ORM\Table(name:"commande")]

class Commande
{
   #[ORM\Id]
   #[ORM\GeneratedValue]
   #[ORM\Column(name:"cmmd_id", type:"integer")]
    private $id;

   #[ORM\Column(name:"cmmd_date", type:"date")]
    private $date;

    #[ORM\Column(name:"cmmd_adfact", type:"string", length:200)]
    private $adFacture;

    #[ORM\Column(name:"cmmd_cpfact", type:"string", length:10)]
    private $cpFacture;

    #[ORM\Column(name:"cmmd_villefact", type:"string", length:50)]
    private $villeFacture;

   #[ORM\Column(name:"cmmd_adlivr", type:"string", length:200)]
    private $adLivr;

    #[ORM\Column(name:"cmmd_cplivr", type:"string", length:10)]
    private $cpLivr;

    #[ORM\Column(name:"cmmd_villelivr", type:"string", length:50)]
    private $villeLivr;

    #[ORM\Column(name:"cmmd_obs", type:"string", length:150, nullable:true)]
    private $cmmdObs;

    #[ORM\ManyToOne(targetEntity:"App\Entity\Client", inversedBy:"commandes")]
    #[ORM\JoinColumn(name:"cli_id", referencedColumnName:"cli_id", nullable:false)]
    private $cliId;

    #[ORM\OneToMany(targetEntity:"App\Entity\Contient", mappedBy:"cmmdId", orphanRemoval:true)]
    private $contients;

   #[ORM\OneToOne(targetEntity:"App\Entity\Facture", cascade:["persist", "remove"])]
    #[ORM\JoinColumn(name:"fact_id", referencedColumnName:"fact_id", nullable:false)]
    private $factId;

    public function __construct()
    {
        $this->contients = new ArrayCollection();
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

    public function getAdFacture(): ?string
    {
        return $this->adFacture;
    }

    public function setAdFacture(string $adFacture): self
    {
        $this->adFacture = $adFacture;

        return $this;
    }

    public function getCpFacture(): ?string
    {
        return $this->cpFacture;
    }

    public function setCpFacture(string $cpFacture): self
    {
        $this->cpFacture = $cpFacture;

        return $this;
    }

    public function getVilleFacture(): ?string
    {
        return $this->villeFacture;
    }

    public function setVilleFacture(string $villeFacture): self
    {
        $this->villeFacture = $villeFacture;

        return $this;
    }

    public function getAdLivr(): ?string
    {
        return $this->adLivr;
    }

    public function setAdLivr(string $adLivr): self
    {
        $this->adLivr = $adLivr;

        return $this;
    }

    public function getCpLivr(): ?string
    {
        return $this->cpLivr;
    }

    public function setCpLivr(string $cpLivr): self
    {
        $this->cpLivr = $cpLivr;

        return $this;
    }

    public function getVilleLivr(): ?string
    {
        return $this->villeLivr;
    }

    public function setVilleLivr(string $villeLivr): self
    {
        $this->villeLivr = $villeLivr;

        return $this;
    }

    public function getCmmdObs(): ?string
    {
        return $this->cmmdObs;
    }

    public function setCmmdObs(?string $cmmdObs): self
    {
        $this->cmmdObs = $cmmdObs;

        return $this;
    }

    public function getCliId(): ?Client
    {
        return $this->cliId;
    }

    public function setCliId(?Client $cliId): self
    {
        $this->cliId = $cliId;

        return $this;
    }

    /**
     * @return Collection|Contient[]
     */
    public function getContients(): Collection
    {
        return $this->contients;
    }

    public function addContient(Contient $contient): self
    {
        if (!$this->contients->contains($contient)) {
            $this->contients[] = $contient;
            $contient->setCmmdId($this);
        }

        return $this;
    }

    public function removeContient(Contient $contient): self
    {
        if ($this->contients->contains($contient)) {
            $this->contients->removeElement($contient);
            // set the owning side to null (unless already changed)
            if ($contient->getCmmdId() === $this) {
                $contient->setCmmdId(null);
            }
        }

        return $this;
    }

    public function getFactId(): ?Facture
    {
        return $this->factId;
    }

    public function setFactId(?Facture $factId): self
    {
        $this->factId = $factId;

        return $this;
    }
}
