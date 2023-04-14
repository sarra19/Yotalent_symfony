<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Remboursement
 *
 * @ORM\Table(name="remboursement", indexes={@ORM\Index(name="prixT", columns={"idT"})})
 * @ORM\Entity
 *  @ORM\Entity(repositoryClass="App\Repository\RemboursementRepository")
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
     * @ORM\Column(name="dc", type="string", length=255, nullable=false)
     */
    private $dc;

    /**
     * @var int
     *
     * @ORM\Column(name="idu", type="integer", nullable=false)
     */
    private $idu;

    /**
     * @var \Ticket
     *
     * @ORM\ManyToOne(targetEntity="Ticket")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idT", referencedColumnName="idT")
     * })
     * 
     */
    private $idt;

    public function getIdrem(): ?int
    {
        return $this->idrem;
    }

    public function getDc(): ?string
    {
        return $this->dc;
    }

    public function setDc(string $dc): self
    {
        $this->dc = $dc;

        return $this;
    }

    public function getIdu(): ?int
    {
        return $this->idu;
    }

    public function setIdu(int $idu): self
    {
        $this->idu = $idu;

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


}
