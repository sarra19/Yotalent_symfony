<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Contrat
 *
 * @ORM\Table(name="contrat")
 * @ORM\Entity
 */
class Contrat
{
    /**
     * @var int
     *
     * @ORM\Column(name="idC", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idc;

    /**
     * @var string
     *
     * @ORM\Column(name="nomC", type="string", length=255, nullable=false)
     */
    private $nomc;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateDC", type="date", nullable=false)
     */
    private $datedc;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateFC", type="date", nullable=false)
     */
    private $datefc;

    public function getIdc(): ?int
    {
        return $this->idc;
    }

    public function getNomc(): ?string
    {
        return $this->nomc;
    }

    public function setNomc(string $nomc): self
    {
        $this->nomc = $nomc;

        return $this;
    }

    public function getDatedc(): ?\DateTimeInterface
    {
        return $this->datedc;
    }

    public function setDatedc(\DateTimeInterface $datedc): self
    {
        $this->datedc = $datedc;

        return $this;
    }

    public function getDatefc(): ?\DateTimeInterface
    {
        return $this->datefc;
    }

    public function setDatefc(\DateTimeInterface $datefc): self
    {
        $this->datefc = $datefc;

        return $this;
    }


}
