<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\NormalizerIntertace;
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
    #[Groups("voyages")]
    private $idvoy;

    /**
     * @ORM\Column(name="dateDVoy", type="string", length=255, nullable=false)
     * @Assert\Date
     */
    #[Groups("voyages")]
    private $datedvoy;

    /**
     * @ORM\Column(name="dateRVoy", type="string", length=255, nullable=false)
     * @Assert\Date
     * @Assert\Expression(
     *     "this.getDatedvoy() < this.getDatervoy()",
     *     message="La date de fin doit être après la date de début"
     * )
     */
    #[Groups("voyages")]
    private $datervoy;

    /**
     * @ORM\Column(name="destination", type="string", length=255, nullable=false)
     * @Assert\Length(min=5)
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z]+$/",
     *     message="Le destination ne doit contenir que des lettres"
     * )
     */
    #[Groups("voyages")]
    private $destination;

    /**
     * @var \Contrat
     *
     * @ORM\ManyToOne(targetEntity="Contrat")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idC", referencedColumnName="idC")
     * })
     */
    #[Groups("voyages")]
    private $idc;

    public function getIdvoy(): ?int
    {
        return $this->idvoy;
    }

    public function getDatedvoy(): ?string
    {
        return $this->datedvoy;
    }

    public function setDatedvoy(string $datedvoy): self
    {
        $this->datedvoy = $datedvoy;

        return $this;
    }

    public function getDatervoy(): ?string
    {
        return $this->datervoy;
    }

    public function setDatervoy(string $datervoy): self
    {
        $this->datervoy = $datervoy;

        return $this;
    }

    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function setDestination(?string $destination): self
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
    public function __toString(): string
    {
        return $this->destination;
    }


}