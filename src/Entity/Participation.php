<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Participation
 *
 * @ORM\Table(name="participation", indexes={@ORM\Index(name="idU", columns={"idU"}), @ORM\Index(name="idT", columns={"idT"}), @ORM\Index(name="idEv", columns={"idEv"})})
 * @ORM\Entity
 */
class Participation
{
    /**
     * @var int
     *
     * @ORM\Column(name="idP", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idp;

    /**
     * @var int
     *
     * @ORM\Column(name="nbRemb", type="integer", nullable=false)
     */
    private $nbremb;

    /**
     * @var \Ticket
     *
     * @ORM\ManyToOne(targetEntity="Ticket")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idT", referencedColumnName="idT")
     * })
     */
    private $idt;

    /**
     * @var \Evenement
     *
     * @ORM\ManyToOne(targetEntity="Evenement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idEv", referencedColumnName="idEv")
     * })
     */
    private $idev;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idU", referencedColumnName="id")
     * })
     */
    private $idu;

    public function getIdp(): ?int
    {
        return $this->idp;
    }

    public function getNbremb(): ?int
    {
        return $this->nbremb;
    }

    public function setNbremb(int $nbremb): self
    {
        $this->nbremb = $nbremb;

        return $this;
    }

    public function getIdt(): ?Ticket
    {
        return $this->idt;
    }

    public function setIdt(?Ticket $idt): self
    {
        $this->idt = $idt;

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

    public function getIdu(): ?User
    {
        return $this->idu;
    }

    public function setIdu(?User $idu): self
    {
        $this->idu = $idu;

        return $this;
    }


}
