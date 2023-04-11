<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;
/**
 * Ticket
 *
 * @ORM\Table(name="ticket", indexes={@ORM\Index(name="idEv", columns={"idEv"})})
 * @ORM\Entity
 */
class Ticket
{
    /**
     * @var int
     *
     * @ORM\Column(name="idT", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idt;

/**
 * @var int|null
 *
 * @ORM\Column(name="prixt", type="integer", nullable=true)
 * @Assert\LessThanOrEqual(
 *      value = 50,
 *      message = "Le prix ne doit pas dépasser 50."
 * )
 * @NotBlank(message = "il faut saisir le prix de ticket.")
 */
private $prixt;

   /**
 * @var string|null
 *
 * @ORM\Column(name="nomEv", type="string", length=255)
 */
private $nomev;
    /**
     * @var bool
     *
     * @ORM\Column(name="etat", type="boolean", nullable=false)
     */
    private $etat;

    /**
     * @var \Evenement
     *
     * @ORM\ManyToOne(targetEntity="Evenement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idEv", referencedColumnName="idEv")
     * })
     */
    private $idev;





    

    public function getIdt(): ?int
    {
        return $this->idt;
    }

    public function getPrixt(): ?int
    {
        return $this->prixt;
    }
    public function setPrixt(int $prixt): self
    {
        
        $this->prixt = $prixt;
    
        return $this;
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

    public function isEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(bool $etat): self
    {
        $this->etat = $etat;

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
    public function __toString()
    {
        return $this->idt;
    }
   

}
