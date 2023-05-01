<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     */
    private $hour;

    /**
     * @var string
     *
     * @ORM\Column(name="nomActivite", type="string", length=255, nullable=false)
     */
    private $nomactivite;

    /**
     * @var string
     *
     * @ORM\Column(name="datePL", type="string", length=255, nullable=false)
     */
    private $datepl;

    /**
     * @var \Evenement
     *
     * @ORM\ManyToOne(targetEntity="Evenement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idEv", referencedColumnName="idEv")
     * })
     */
    private $idev;


}
