<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Espacetalent
 *
 * @ORM\Table(name="espacetalent", indexes={@ORM\Index(name="idU", columns={"idU"}), @ORM\Index(name="idCat", columns={"idCat"})})
 * @ORM\Entity
 */
class Espacetalent
{
    /**
     * @var int
     *
     * @ORM\Column(name="idEST", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idest;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Le nom de username est obligatoire.")
     * @Assert\Length(
     *      min = 5,
     *      max = 255,
     *      minMessage = "Le nom de  username doit contenir au moins {{ limit }} caractères.",
     *      maxMessage = "Le nom de  username ne doit pas dépasser {{ limit }} caractères."
     * )
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=false)
     */
    private $image;

   /**
 * @var int
 *
 * @ORM\Column(name="nbVotes", type="integer", nullable=false)
 * @Assert\PositiveOrZero(message="The number of votes must be a positive integer or zero.")
 */
private $nbvotes;


    /**
 * @var \Categorie
 *
 * @ORM\ManyToOne(targetEntity="Categorie")
 * @ORM\JoinColumns({
 *   @ORM\JoinColumn(name="idCat", referencedColumnName="idCat")
 * })
 * @Assert\NotNull(message="The category must not be null.")
 */
private $idcat;


   /**
 * @var \User
 *
 * @ORM\ManyToOne(targetEntity="User")
 * @ORM\JoinColumns({
 *   @ORM\JoinColumn(name="idU", referencedColumnName="id")
 * })
 * @Assert\NotNull(message="The user must not be null.")
 */
private $idu;


    public function getIdest(): ?int
    {
        return $this->idest;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
       
        $this->username = $username;
    
        return $this;
    }
    

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
       
        $this->image = $image;
    
        return $this;
    }
    

    public function getNbvotes(): ?int
    {
        return $this->nbvotes;
    }

    public function setNbvotes(int $nbvotes): self
{
    

    $this->nbvotes = $nbvotes;

    return $this;
}

    public function getIdcat(): ?Categorie
    {
        return $this->idcat;
    }

    public function setIdcat(?Categorie $idcat): self
    {
      
    
        $this->idcat = $idcat;
    
        return $this;
    }
    

    public function getIdu(): ?User
    {
        return $this->idu;
    }

    public function setIdu(?User $idu): self
{
    // Check that the user is not null
    if (null === $idu) {
        throw new \InvalidArgumentException('The user cannot be null.');
    }

    $this->idu = $idu;

    return $this;
}
    public function __toString(): string
    {
        return $this->username;
    }

}
