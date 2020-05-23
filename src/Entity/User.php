<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * @UniqueEntity("nickname", message="Пользователь с таким именем уже существует")
 */
class User implements UserInterface
{
    /**
     * @var string|null
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="App\Service\CustomIdGenerator")
     * @ORM\Column(name="id", type="string", nullable=false, unique=true)
     */
    private ?string $id;

    /**
     * @var string|null
     * @ORM\Column(name="nickname", type="string", nullable=false, unique=true)
     * @Assert\NotBlank(message="Введите имя пользователя")
     * @Assert\Regex("/^\w+$/", message="Имя пользователя может содержать только буквы латинского алфавита и знак нижнего подчеркивания")
     */
    private ?string $nickname;

    /**
     * @var string|null
     * @ORM\Column(name="full_name", type="string", nullable=true)
     */
    private ?string $fullName;

    /**
     * @var string|null
     * @ORM\Column(name="about", type="string", nullable=true)
     */
    private ?string $about;

    /**
     * @var string|null
     * @ORM\Column(name="password", type="string", nullable=false)
     * @Assert\NotBlank(message="Введите пароль")
     */
    private ?string $password;

    /**
     * @var Collection|null
     * @ORM\ManyToMany(targetEntity="User", mappedBy="subscriptions")
     */
    private ?Collection $subscribers;

    /**
     * @var Collection|null
     * @ORM\ManyToMany(targetEntity="User", inversedBy="subscribers")
     * @ORM\JoinTable(name="subscription",
     *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="subscription_user_id", referencedColumnName="id")}
     *     )
     */
    private ?Collection $subscriptions;

    /**
     * @var Collection|null
     * @ORM\OneToMany(targetEntity="Post", mappedBy="user")
     * @ORM\OrderBy({"createdAt" = "desc"})
     */
    private ?Collection $posts;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
        $this->subscribers = new ArrayCollection();
        $this->subscriptions = new ArrayCollection();
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
     * @param string|null $nickname
     */
    public function setNickname(?string $nickname): void
    {
        $this->nickname = $nickname ? strtolower(trim($nickname)) : $nickname;
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
        $this->fullName = $fullName ? trim($fullName) : $fullName;
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
        $this->about = $about ? preg_replace('/[\r\n]+/', '<br>', trim($about)) : $about;
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
    public function getSubscribers(): ?Collection
    {
        return $this->subscribers;
    }

    /**
     * @param Collection|null $subscribers
     */
    public function setSubscribers(?Collection $subscribers): void
    {
        $this->subscribers = $subscribers;
    }

    /**
     * @return Collection|null
     */
    public function getSubscriptions(): ?Collection
    {
        return $this->subscriptions;
    }

    /**
     * @param Collection|null $subscriptions
     */
    public function setSubscriptions(?Collection $subscriptions): void
    {
        $this->subscriptions = $subscriptions;
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
