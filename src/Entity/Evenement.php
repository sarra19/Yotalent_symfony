<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Evenement
 *
 * @ORM\Table(name="evenement")
 * @ORM\Entity
 */
class Evenement
{
    /**
     * @var int
     *
     * @ORM\Column(name="idEv", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idev;

    /**
     * @var string
     *
     * @ORM\Column(name="nomEv", type="string", length=255, nullable=false)
     */
    private $nomev;

    /**
     * @var string
     *
     * @ORM\Column(name="dateDEv", type="string", length=255, nullable=false)
     */
    private $datedev;

    /**
     * @var string
     *
     * @ORM\Column(name="dateFEv", type="string", length=255, nullable=false)
     */
    private $datefev;

    /**
     * @var string
     *
     * @ORM\Column(name="localisation", type="string", length=255, nullable=false)
     */
    private $localisation;

    public function getIdev(): ?int
    {
        return $this->idev;
    }

    public function getNomev(): ?string
    {
        return $this->nomev;
    }

    public function setNomev(string $nomev): self
    {
        $this->nomev = $nomev;

        return $this;
    }

    public function getDatedev(): ?string
    {
        return $this->datedev;
    }

    public function setDatedev(string $datedev): self
    {
        $this->datedev = $datedev;

        return $this;
    }

    public function getDatefev(): ?string
    {
        return $this->datefev;
    }

    public function setDatefev(string $datefev): self
    {
        $this->datefev = $datefev;

        return $this;
    }

    public function getLocalisation(): ?string
    {
        return $this->localisation;
    }

    public function setLocalisation(string $localisation): self
    {
        $this->localisation = $localisation;

        return $this;
    }


}
