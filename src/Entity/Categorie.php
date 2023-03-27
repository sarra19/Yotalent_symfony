<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Categorie
 *
 * @ORM\Table(name="categorie")
 * @ORM\Entity
 */
class Categorie
{
    /**
     * @var int
     *
     * @ORM\Column(name="idCat", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcat;

   /**
     * @var string
     *
     * @ORM\Column(name="nomCat", type="string", length=255, nullable=false)
     * @Assert\NotBlank
     * @Assert\Length(min=4)
     * @Assert\Regex(
     *      pattern="/^[a-zA-Z]+$/",
     *      message="Le nom de la catégorie doit contenir uniquement des lettres"
     * )
     */
    private $nomcat;

    public function getIdcat(): ?int
    {
        return $this->idcat;
    }

    public function getNomcat(): ?string
    {
        return $this->nomcat;
    }

    public function setNomcat(string $nomcat): self
    {
        $this->nomcat = $nomcat;

        return $this;
    }

    public function __toString(): string
    {
        return $this->nomcat;
    }
}
