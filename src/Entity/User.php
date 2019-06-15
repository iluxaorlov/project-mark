<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Serializable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity("nickname", message="Пользователь с таким именем уже существует")
 */
class User implements UserInterface, Serializable
{
    /**
     * @var string
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="string", nullable=false)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     * @Assert\Regex(pattern="/[^register|^login|^logout|^edit|^create]/", message="Пользователь с таким именем уже существует")
     * @Assert\Regex(pattern="/[a-zA-Z0-9]+/", message="Имя пользователя должно содержать только латинские буквы или цифры")
     * @Assert\NotBlank(message="Введите имя пользователя")
     */
    private $nickname;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $fullName;

    /**
     * @var string|null
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $about;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     * @Assert\NotBlank(message="Введите пароль")
     * @Assert\Length(min="8", minMessage="Пароль должен содержать не менее {{ limit }} символов")
     */
    private $password;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Post", mappedBy="user")
     */
    private $posts;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="following")
     */
    private $followers;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="followers")
     * @ORM\JoinTable(name="follow",
     *     joinColumns={@ORM\JoinColumn(name="user", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="following", referencedColumnName="id")}
     *     )
     */
    private $following;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
        $this->followers = new ArrayCollection();
        $this->following = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    /**
     * @param string $nickname
     */
    public function setNickname(string $nickname): void
    {
        $this->nickname = $nickname;
    }

    /**
     * @return string|null
     */
    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    /**
     * @param string|null $fullName
     */
    public function setFullName(?string $fullName): void
    {
        $this->fullName = $fullName;
    }

    /**
     * @return string|null
     */
    public function getAbout(): ?string
    {
        return $this->about;
    }

    /**
     * @param string|null $about
     */
    public function setAbout(?string $about): void
    {
        $this->about = $about;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return ArrayCollection
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * @param ArrayCollection $posts
     */
    public function setPosts(ArrayCollection $posts): void
    {
        $this->posts = $posts;
    }

    /**
     * @return ArrayCollection
     */
    public function getFollowers()
    {
        return $this->followers;
    }

    /**
     * @param ArrayCollection $followers
     */
    public function setFollowers(ArrayCollection $followers): void
    {
        $this->followers = $followers;
    }

    /**
     * @return ArrayCollection
     */
    public function getFollowing()
    {
        return $this->following;
    }

    /**
     * @param ArrayCollection $following
     */
    public function setFollowing(ArrayCollection $following): void
    {
        $this->following = $following;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    /**
     * @return null
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @return null
     */
    public function eraseCredentials()
    {
        return null;
    }

    public function serialize()
    {
        return serialize([
            $this->id,
            $this->nickname,
            $this->password
        ]);
    }

    public function unserialize($serialized)
    {
        list($this->id, $this->nickname, $this->password) = unserialize($serialized);
    }
}