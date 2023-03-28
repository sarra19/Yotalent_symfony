<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Vote
 *
 * @ORM\Table(name="vote", indexes={@ORM\Index(name="idEV", columns={"idEV"}), @ORM\Index(name="idEST", columns={"idEST"}), @ORM\Index(name="idU", columns={"idU"})})
 * @ORM\Entity
 */
class Vote
{
    /**
     * @var int
     *
     * @ORM\Column(name="idV", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idv;

    /**
     * @var int
     *
     * @ORM\Column(name="nbrV", type="integer", nullable=false)
     */
    private $nbrv;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateV", type="date", nullable=false)
     */
    private $datev;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idU", referencedColumnName="id")
     * })
     */
    private $idu;

    /**
     * @var \Evenement
     *
     * @ORM\ManyToOne(targetEntity="Evenement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idEV", referencedColumnName="idEv")
     * })
     */
    private $idev;

    /**
     * @var \Espacetalent
     *
     * @ORM\ManyToOne(targetEntity="Espacetalent")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idEST", referencedColumnName="idEST")
     * })
     */
    private $idest;

    public function getIdv(): ?int
    {
        return $this->idv;
    }

    public function getNbrv(): ?int
    {
        return $this->nbrv;
    }

    public function setNbrv(int $nbrv): self
    {
        $this->nbrv = $nbrv;

        return $this;
    }

    public function getDatev(): ?\DateTimeInterface
    {
        return $this->datev;
    }

    public function setDatev(\DateTimeInterface $datev): self
    {
        $this->datev = $datev;

        return $this;
    }

    public function getIdu(): ?User
    {
        return $this->idu;
    }

    public function setIdu(?User $idu): self
    {
        $this->idu = $idu;

        return $this;
    }

    public function getIdev(): ?Evenement
    {
        return $this->idev;
    }

    public function setIdev(?Evenement $idev): self
    {
        $this->idev = $idev;

        return $this;
    }

    public function getIdest(): ?Espacetalent
    {
        return $this->idest;
    }

    public function setIdest(?Espacetalent $idest): self
    {
        $this->idest = $idest;

        return $this;
    }


}
