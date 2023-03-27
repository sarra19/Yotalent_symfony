<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints as CustomAssert;
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
 *  * @Assert\NotBlank(message="Invalid time format. The value should be in the format HH:MM (24-hour clock)")
 * @Assert\Regex(
 *     pattern="/^([01]\d|2[0-3]):([0-5]\d)$/",
 *     message="Invalid time format. The value should be in the format HH:MM (24-hour clock)."
 * )
 */
private $hour;

    /**
     * @var string
     *
     * @ORM\Column(name="nomactivite", type="string", length=255, nullable=false)
     */
    #[Assert\Length(min:5)]
    #[Assert\Length(max:20)]
    #[Assert\NotBlank (message:"veuillez saisir nomactivite de planning ")]
    private $nomactivite;
  // ...

   // ...

    /**
     * @var string
     *
     * @ORM\Column(name="datepl", type="string", nullable=false)
     * @Assert\NotBlank( message="The date of the planning must be after 2023-03-23.")
     * @Assert\NotBlank( message="The date format must be YYYY-MM-DD.")
     * @Assert\Regex(
 *     pattern="/^\d{4}-\d{2}-\d{2}$/",
 *     message="The date format must be YYYY-MM-DD"
 * )
     * @Assert\GreaterThan("2023-03-23", message="The date of the planning must be after 2023-03-23.")
     */
  
    private $datepl;

    // ...
     
   

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
