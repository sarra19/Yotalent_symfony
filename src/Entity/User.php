<?php

namespace App\Entity;

<<<<<<< HEAD
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user', 'posts:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Groups(['user', 'posts:read'])]
    private ?string $email = null;

    #[ORM\Column]
    #[Groups(['user', 'posts:read'])]
    private string $role;

    /**
     * @var string The hashed motpass
     */
    #[ORM\Column]
    #[Groups(['user', 'posts:read'])]
    private ?string $motpass = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user', 'posts:read'])]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user', 'posts:read'])]
    private ?string $image = null;


=======
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity
 */
class User
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;

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
     * @var string
     *
     * @ORM\Column(name="Role", type="string", length=255, nullable=false)
     */
    private $role;

    /**
     * @var string
     *
     * @ORM\Column(name="Image", type="string", length=255, nullable=false)
     */
    private $image;
>>>>>>> New/integ

    public function getId(): ?int
    {
        return $this->id;
    }

<<<<<<< HEAD
=======
    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

>>>>>>> New/integ
    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

<<<<<<< HEAD
    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $role = $this->role;
        // guarantee every user at least has ROLE_USER
        $role = 'ROLE_USER';
        $role = explode(',', $role);

        return array_unique($role);
    }

    public function setRoles(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
=======
    public function getMotpass(): ?string
>>>>>>> New/integ
    {
        return $this->motpass;
    }

<<<<<<< HEAD
    public function setPassword(string $motpass): self
=======
    public function setMotpass(string $motpass): self
>>>>>>> New/integ
    {
        $this->motpass = $motpass;

        return $this;
    }

<<<<<<< HEAD
    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getName(): ?string
    {
        return $this->nom;
    }

    public function setName(string $nom): self
    {
        $this->nom = $nom;
=======
    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;
>>>>>>> New/integ

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }
<<<<<<< HEAD
}
=======
    public function __toString()
    {
        return $this->nom;
    }

}
>>>>>>> New/integ
