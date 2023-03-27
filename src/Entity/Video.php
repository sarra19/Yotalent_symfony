<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Video
 *
 * @ORM\Table(name="video", indexes={@ORM\Index(name="idEST", columns={"idEST"})})
 * @ORM\Entity
 */
class Video
{
    /**
     * @var int
     *
     * @ORM\Column(name="idVid", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idvid;

     /**
     * @var string
     *
     * @ORM\Column(name="nomVid", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Le nom de la vidéo est obligatoire.")
     * @Assert\Length(
     *      min = 5,
     *      max = 255,
     *      minMessage = "Le nom de la vidéo doit contenir au moins {{ limit }} caractères.",
     *      maxMessage = "Le nom de la vidéo ne doit pas dépasser {{ limit }} caractères."
     * )
     */
    private $nomvid;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=false)
     */
    private $url;

    /**
     * @var \Espacetalent
     *
     * @ORM\ManyToOne(targetEntity="Espacetalent")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idEST", referencedColumnName="idEST")
     * })
     */
    private $idest;

    public function getIdvid(): ?int
    {
        return $this->idvid;
    }

    public function getNomvid(): ?string
    {
        return $this->nomvid;
    }

    public function setNomvid(string $nomvid): self
    {
        $this->nomvid = $nomvid;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

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


}
