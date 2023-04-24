<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Remboursement
 *
 * @ORM\Table(name="remboursement", indexes={@ORM\Index(name="prixT", columns={"prixT"}), @ORM\Index(name="idP", columns={"idP"})})
 * @ORM\Entity
 */
class Remboursement
{
    /**
     * @var int
     *
     * @ORM\Column(name="idRem", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idrem;

    /**
     * @var string
     *
     * @ORM\Column(name="dateRem", type="string", length=255, nullable=false)
     */
    private $daterem;

    /**
     * @var \Ticket
     *
     * @ORM\ManyToOne(targetEntity="Ticket")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="prixT", referencedColumnName="idT")
     * })
     */
    private $prixt;

    /**
     * @var \Participation
     *
     * @ORM\ManyToOne(targetEntity="Participation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idP", referencedColumnName="idP")
     * })
     */
    private $idp;

    public function getIdrem(): ?int
    {
        return $this->idrem;
    }

    public function getDaterem(): ?string
    {
        return $this->daterem;
    }

    public function setDaterem(string $daterem): self
    {
        $this->daterem = $daterem;

        return $this;
    }

    public function getPrixt(): ?Ticket
    {
        return $this->prixt;
    }

    public function setPrixt(?Ticket $prixt): self
    {
        $this->prixt = $prixt;

        return $this;
    }

    public function getIdp(): ?Participation
    {
        return $this->idp;
    }

    public function setIdp(?Participation $idp): self
    {
        $this->idp = $idp;

        return $this;
    }


}
