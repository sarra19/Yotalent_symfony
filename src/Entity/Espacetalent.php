<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Espacetalent
 *
 * @ORM\Table(name="espacetalent", indexes={@ORM\Index(name="idC", columns={"idC"}), @ORM\Index(name="idU", columns={"idU"}), @ORM\Index(name="idVid", columns={"idVid"}), @ORM\Index(name="idCat", columns={"idCat"})})
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
     * @ORM\Column(name="titre", type="string", length=255, nullable=false)
     */
    private $titre;

    /**
     * @var \Categorie
     *
     * @ORM\ManyToOne(targetEntity="Categorie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idCat", referencedColumnName="idCat")
     * })
     */
    private $idcat;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idU", referencedColumnName="id")
     * })
     */
    private $idu;

    /**
     * @var \Contrat
     *
     * @ORM\ManyToOne(targetEntity="Contrat")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idC", referencedColumnName="idC")
     * })
     */
    private $idc;

    /**
     * @var \Video
     *
     * @ORM\ManyToOne(targetEntity="Video")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idVid", referencedColumnName="idVid")
     * })
     */
    private $idvid;

    public function getIdest(): ?int
    {
        return $this->idest;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

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
        $this->idu = $idu;

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

    public function getIdvid(): ?Video
    {
        return $this->idvid;
    }

    public function setIdvid(?Video $idvid): self
    {
        $this->idvid = $idvid;

        return $this;
    }


}
