<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Evenement
 *
 * @ORM\Table(name="evenement")
 * @ORM\Entity
 *  @ORM\Entity(repositoryClass="App\Repository\EvenementRepository")
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
     * @ORM\Column(name="nomev", type="string", length=255, nullable=false)
     */

     #[Assert\Length(min:5)]
    #[Assert\Length(max:20)]
    #[Assert\NotBlank (message:"veuillez saisir le nom de l'evenement ")]
    private $nomev;

  
    /**
     * @var \DateTimeInterface
     *
     * @ORM\Column(name="dateDEv", type="string", nullable=false)
     
     * @Assert\NotBlank(message="La date de début de l'événement est obligatoire  format must be YYYY-MM-DD.")
     * @Assert\LessThanOrEqual(propertyPath="datefev", message="La date de début de l'événement doit être antérieure ou égale à la date de fin.")
      *  @Assert\Regex(
 *     pattern="/^\d{4}-\d{2}-\d{2}$/",
 *     message="The date format must be YYYY-MM-DD"
 * )
     */
    private $datedev;

    /**
     * @var \DateTimeInterface
     *
     * @ORM\Column(name="dateFEv", type="string", nullable=false)
     * 
     * @Assert\NotBlank(message="La date de fin de l'événement est obligatoire format must be YYYY-MM-DD.")
     *  @Assert\Regex(
 *     pattern="/^\d{4}-\d{2}-\d{2}$/",
 *    
 * )
     */
    private $datefev;
     /**
     * @var string
     *
     * @ORM\Column(name="localisation", type="string", length=255, nullable=false)
     */
    #[Assert\Length(min:5)]
    #[Assert\Length(max:20)]
    #[Assert\NotBlank (message:"veuillez saisir le localisation  de l'evenement ")]
    private $localisation;

    /**
     * @var string
     *
     * @ORM\Column(name="ImageEv", type="string", length=255, nullable=false)
     */
    #[Assert\NotBlank (message:"veuillez saisir image  de l'evenement ")]
    private $imageev;

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

    public function getImageev()
    {
        return $this->imageev;
    }

    public function setImageev($imageev)
    {
        $this->imageev = $imageev;

        return $this;
    }
    public function __toString(): string
    {
        return $this->nomev;
    }
   
    
    

}
