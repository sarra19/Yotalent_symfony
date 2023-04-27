<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Contrat
 *
 * @ORM\Table(name="contrat", indexes={@ORM\Index(name="IdEST", columns={"idEST"})})
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
     * @ORM\Column(name="nomC", type="string", length=255, nullable=false)
     * @Assert\Length(min=5)
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z]+$/",
     *     message="Le nom ne doit contenir que des lettres"
     * )
     */
    private $nomc;

    
    /**
     * @ORM\Column(name="DateDC", type="string", length=255, nullable=false)
     * @Assert\Date
     */
    private $datedc;

     /**
     * @ORM\Column(name="DateFC", type="string", length=255, nullable=false)
     * @Assert\Date
     * @Assert\Expression(
     *     "this.getDatedc() < this.getDatefc()",
     *     message="La date de fin doit être après la date de début"
     * )
     */
    private $datefc;

    /**
     * @var \Espacetalent
     *
     * @ORM\ManyToOne(targetEntity="Espacetalent")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idEST", referencedColumnName="idEST")
     * })
     */
    private $idest;

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

    public function getDatedc(): ?string
    {
        return $this->datedc;
    }

    public function setDatedc(string $datedc): self
    {
        $this->datedc = $datedc;

        return $this;
    }

    public function getDatefc(): ?string
    {
        return $this->datefc;
    }

    public function setDatefc(string $datefc): self
    {
        $this->datefc = $datefc;

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
    public function __toString(): string
    {
        return $this->nomc;
    }

}
