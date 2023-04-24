<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Video
 *
 * @ORM\Table(name="video")
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
     */
    private $nomvid;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=false)
     */
    private $url;

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


}
