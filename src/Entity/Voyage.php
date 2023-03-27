<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Voyage
 *
 * @ORM\Table(name="voyage", indexes={@ORM\Index(name="idC", columns={"idC"})})
 * @ORM\Entity
 */
class Voyage
{
    /**
     * @var int
     *
     * @ORM\Column(name="idVoy", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idvoy;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateDVoy", type="date", nullable=false)
     */
    private $datedvoy;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateRVoy", type="date", nullable=false)
     */
    private $datervoy;

    /**
     * @var string
     *
     * @ORM\Column(name="destination", type="string", length=255, nullable=false)
     */
    private $destination;

    /**
     * @var \Contrat
     *
     * @ORM\ManyToOne(targetEntity="Contrat")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idC", referencedColumnName="idC")
     * })
     */
    private $idc;

    public function getIdvoy(): ?int
    {
        return $this->idvoy;
    }

    public function getDatedvoy(): ?\DateTimeInterface
    {
        return $this->datedvoy;
    }

    public function setDatedvoy(\DateTimeInterface $datedvoy): self
    {
        $this->datedvoy = $datedvoy;

        return $this;
    }

    public function getDatervoy(): ?\DateTimeInterface
    {
        return $this->datervoy;
    }

    public function setDatervoy(\DateTimeInterface $datervoy): self
    {
        $this->datervoy = $datervoy;

        return $this;
    }

    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function setDestination(string $destination): self
    {
        $this->destination = $destination;

        return $this;
    }

    public function getIdc(): ?Contrat
    {
        return $this->idc;
    }

    public function setIdc(?Contrat $idc): self
    {
        $this->idc = $idc;

        return $this;
    }


}
