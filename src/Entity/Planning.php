<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Planning
 *
 * @ORM\Table(name="planning", indexes={@ORM\Index(name="idEv", columns={"idEv"})})
 * @ORM\Entity
 */
class Planning
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
     * @var string
     *
     * @ORM\Column(name="hour", type="string", length=255, nullable=false)
     */
    private $hour;

    /**
     * @var string
     *
     * @ORM\Column(name="nomActivite", type="string", length=255, nullable=false)
     */
    private $nomactivite;

    /**
     * @var string
     *
     * @ORM\Column(name="datePL", type="string", length=255, nullable=false)
     */
    private $datepl;

    /**
     * @var \Evenement
     *
     * @ORM\ManyToOne(targetEntity="Evenement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idEv", referencedColumnName="idEv")
     * })
     */
    private $idev;

    public function getIdp(): ?int
    {
        return $this->idp;
    }

    public function getHour(): ?string
    {
        return $this->hour;
    }

    public function setHour(string $hour): self
    {
        $this->hour = $hour;

        return $this;
    }

    public function getNomactivite(): ?string
    {
        return $this->nomactivite;
    }

    public function setNomactivite(string $nomactivite): self
    {
        $this->nomactivite = $nomactivite;

        return $this;
    }

    public function getDatepl(): ?string
    {
        return $this->datepl;
    }

    public function setDatepl(string $datepl): self
    {
        $this->datepl = $datepl;

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


}
