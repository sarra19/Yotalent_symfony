<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user", indexes={@ORM\Index(name="role", columns={"idRole"})})
 * @ORM\Entity
 */
class User
{
    /**
     * @var int
     *
     * @ORM\Column(name="idU", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idu;

    /**
     * @var string
     *
     * @ORM\Column(name="nomU", type="string", length=255, nullable=false)
     */
    private $nomu;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="motpass", type="string", length=255, nullable=false)
     */
    private $motpass;

    /**
     * @var \Role
     *
     * @ORM\ManyToOne(targetEntity="Role")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idRole", referencedColumnName="idRole")
     * })
     */
    private $idrole;

    public function getIdu(): ?int
    {
        return $this->idu;
    }

    public function getNomu(): ?string
    {
        return $this->nomu;
    }

    public function setNomu(string $nomu): self
    {
        $this->nomu = $nomu;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getMotpass(): ?string
    {
        return $this->motpass;
    }

    public function setMotpass(string $motpass): self
    {
        $this->motpass = $motpass;

        return $this;
    }

    public function getIdrole(): ?Role
    {
        return $this->idrole;
    }

    public function setIdrole(?Role $idrole): self
    {
        $this->idrole = $idrole;

        return $this;
    }


}
