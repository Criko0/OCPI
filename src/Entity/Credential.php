<?php

namespace App\Entity;

use App\Repository\CredentialRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CredentialRepository::class)]
class Credential
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 64)]
    private string $token;

    #[ORM\Column(length: 255)]
    private string $url;

    /** @var Collection<array-key, CredentialRole> */
    #[ORM\OneToMany(targetEntity: CredentialRole::class, mappedBy: 'credential', orphanRemoval: true)]
    private Collection $roles;

    public function __construct(
        string $token,
        string $url,
    ) {
        $this->token = $token;
        $this->url = $url;
        $this->roles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function setToken(string $token): static
    {
        $this->token = $token;

        return $this;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return Collection<array-key, CredentialRole>
     */
    public function getRoles(): Collection
    {
        return $this->roles;
    }

    public function addRole(CredentialRole $role): static
    {
        if (!$this->roles->contains($role)) {
            $this->roles->add($role);
            $role->setCredential($this);
        }

        return $this;
    }

    public function removeRole(CredentialRole $role): static
    {
        $this->roles->removeElement($role);

        return $this;
    }
}
