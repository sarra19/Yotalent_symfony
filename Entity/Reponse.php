<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * Reponse
 *
 * @ORM\Table(name="reponse", indexes={@ORM\Index(name="id_reclamation", columns={"id_reclamation"})})
 * @ORM\Entity(repositoryClass=ReponseRepository::class)
 */
class Reponse
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_reponse", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups("post:read")
     */
    #[Assert\NotBlank(message:" *Champ Obligatoire")]
    #[Assert\Length(min:5,minMessage:" *idReponse ne contient pas le minimum des caractères.")]
    private $idReponse;

    /**
     * @var string
     *
     * @ORM\Column(name="reponse", type="string", length=255, nullable=false)
     * @Groups("post:read")
     */
    #[Assert\NotBlank(message:" *Champ Obligatoire")]
    #[Assert\Length(min:5,minMessage:" *reponse ne contient pas le minimum des caractères.")]
    private $reponse;

    /**
     * @var \Reclamation
     *
     * @ORM\ManyToOne(targetEntity="Reclamation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_reclamation", referencedColumnName="id_reclamation")
     * })
     * @Groups("post:read")
     */
    #[Assert\NotBlank(message:" *Champ Obligatoire")]
    #[Assert\Length(min:5,minMessage:" *id ne contient pas le minimum des caractères.")]
    private $idReclamation;

    public function getIdReponse(): ?int
    {
        return $this->idReponse;
    }

    public function getReponse(): ?string
    {
        return $this->reponse;
    }

    public function setReponse(string $reponse): self
    {
        $this->reponse = $reponse;

        return $this;
    }

    public function getIdReclamation(): ?Reclamation
    {
        return $this->idReclamation;
    }

    public function setIdReclamation(?Reclamation $idReclamation): self
    {
        $this->idReclamation = $idReclamation;

        return $this;
    }


}
