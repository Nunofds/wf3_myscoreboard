<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass:UserRepository::class)]
#[UniqueEntity(fields:['pseudo'], message:'Ce pseudo est déjà')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
#[ORM\GeneratedValue]
#[ORM\Column(type:'integer')]
private $id;

#[ORM\Column(type:'string', length:180, unique:true)]
private $pseudo;

#[ORM\Column(type:'json')]
private $roles = [];

#[ORM\Column(type:'string')]
private $password;

#[ORM\OneToOne(inversedBy: 'user', targetEntity: Player::class, cascade: ['persist', 'remove'])]
private $player;

function getId(): ?int
    {
    return $this->id;
}

function getPseudo(): ?string
    {
    return $this->pseudo;
}

function setPseudo(string $pseudo): self
    {
    $this->pseudo = $pseudo;

    return $this;
}

/**
 * A visual identifier that represents this user.
 *
 * @see UserInterface
 */
function getUserIdentifier(): string
    {
    return (string) $this->pseudo;
}

/**
 * @see UserInterface
 */
function getRoles(): array
{
    $roles = $this->roles;
    // guarantee every user at least has ROLE_USER
    $roles[] = 'ROLE_USER';

    return array_unique($roles);
}

function setRoles(array $roles): self
    {
    $this->roles = $roles;

    return $this;
}

/**
 * @see PasswordAuthenticatedUserInterface
 */
function getPassword(): string
    {
    return $this->password;
}

function setPassword(string $password): self
    {
    $this->password = $password;

    return $this;
}

/**
 * @see UserInterface
 */
function eraseCredentials()
    {
    // If you store any temporary, sensitive data on the user, clear it here
    // $this->plainPassword = null;
}

public function getPlayer(): ?Player
{
    return $this->player;
}

public function setPlayer(?Player $player): self
{
    $this->player = $player;

    return $this;
}
}
