<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Role
 *
 * @ORM\Table(name="role")
 * @ORM\Entity
 */
class Role
{
    /**
     * @var int
     *
     * @ORM\Column(name="idRole", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idrole;

    /**
     * @var string
     *
     * @ORM\Column(name="nomAdmin", type="string", length=255, nullable=false)
     */
    private $nomadmin;

    /**
     * @var string
     *
     * @ORM\Column(name="nomSociete", type="string", length=255, nullable=false)
     */
    private $nomsociete;

    /**
     * @var string
     *
     * @ORM\Column(name="nomClient", type="string", length=255, nullable=false)
     */
    private $nomclient;

    public function getIdrole(): ?int
    {
        return $this->idrole;
    }

    public function getNomadmin(): ?string
    {
        return $this->nomadmin;
    }

    public function setNomadmin(string $nomadmin): self
    {
        $this->nomadmin = $nomadmin;

        return $this;
    }

    public function getNomsociete(): ?string
    {
        return $this->nomsociete;
    }

    public function setNomsociete(string $nomsociete): self
    {
        $this->nomsociete = $nomsociete;

        return $this;
    }

    public function getNomclient(): ?string
    {
        return $this->nomclient;
    }

    public function setNomclient(string $nomclient): self
    {
        $this->nomclient = $nomclient;

        return $this;
    }


}
