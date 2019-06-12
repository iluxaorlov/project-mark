<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity("nickname", message="Пользователь с таким именем уже существует")
 */
class User implements UserInterface
{
    /**
     * @var string
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="App\Service\Generator")
     * @ORM\Column(type="integer", nullable=false)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
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
     * @ORM\Column(type="string", nullable=true)
     */
    private $password;

    /**
     * @var string
     *
     * @Assert\Length(min="8", minMessage="Пароль должен содержать не менее восьми символов")
     * @Assert\NotBlank(message="Введите пароль")
     */
    private $plainPassword;

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
     * @param string $fullName
     */
    public function setFullName(string $fullName): void
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
     * @param string $about
     */
    public function setAbout(string $about): void
    {
        $this->about = $about;
    }

    /**
     * @return string
     */
    public function getPassword(): string
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
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     */
    public function setPlainPassword(string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;
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

    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }
}