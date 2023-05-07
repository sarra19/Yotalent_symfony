<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Evenement
 *
 * @ORM\Table(name="evenement")
 * @ORM\Entity
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
     * @ORM\Column(name="nomEv", type="string", length=255, nullable=false)
     */
    private $nomev;

    /**
     * @var string
     *
     * @ORM\Column(name="dateDEv", type="string", length=255, nullable=false)
     */
    private $datedev;

    /**
     * @var string
     *
     * @ORM\Column(name="dateFEv", type="string", length=255, nullable=false)
     */
    private $datefev;

    /**
     * @var string
     *
     * @ORM\Column(name="localisation", type="string", length=255, nullable=false)
     */
    private $localisation;

    /**
     * @var string
     *
     * @ORM\Column(name="ImageEv", type="string", length=255, nullable=false)
     */
    private $imageev;


}
