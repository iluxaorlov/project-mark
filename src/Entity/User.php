<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * @UniqueEntity("username", message="Пользователь с таким именем уже существует")
 */
class User implements UserInterface
{
    /**
     * @var string|null
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="App\Service\CustomIdGenerator")
     * @ORM\Column(name="id", type="string", nullable=false, unique=true)
     */
    private ?string $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="username", type="string", nullable=false, unique=true)
     * @Assert\NotBlank(message="Введите имя пользователя")
     */
    private ?string $username;

    /**
     * @var string|null
     *
     * @ORM\Column(name="password", type="string", nullable=false)
     * @Assert\NotBlank(message="Введите пароль")
     */
    private ?string $password;

    /**
     * @var Collection|null
     *
     * @ORM\OneToMany(targetEntity="Post", mappedBy="user")
     */
    private ?Collection $posts;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string|null $id
     */
    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string|null $username
     */
    public function setUsername(?string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     */
    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return Collection|null
     */
    public function getPosts(): ?Collection
    {
        return $this->posts;
    }

    /**
     * @param Collection|null $posts
     */
    public function setPosts(?Collection $posts): void
    {
        $this->posts = $posts;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return [
            'ROLE_USER',
        ];
    }

    public function getSalt()
    {
    }

    public function eraseCredentials()
    {
    }
}
