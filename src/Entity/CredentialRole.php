<?php

namespace App\Entity;

use App\Enum\RoleEnum;
use App\Repository\CredentialRoleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Reference: https://github.com/ocpi/ocpi/blob/release-2.2.1-bugfixes/credentials.asciidoc#credentials_credentials_role_class.
 */
#[ORM\Entity(repositoryClass: CredentialRoleRepository::class)]
class CredentialRole
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(enumType: RoleEnum::class)]
    private RoleEnum $role;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private BusinessDetails $businessDetails;

    #[ORM\Column(length: 3, options: ['comment' => 'CPO, eMSP (or other role) ID of this party (following the ISO-15118 standard).'])]
    private string $partyId;

    #[ORM\Column(length: 2, options: ['comment' => 'ISO-3166 alpha-2 country code of the country this party is operating in.'])]
    private string $countryCode;

    #[ORM\ManyToOne(inversedBy: 'roles')]
    #[ORM\JoinColumn(nullable: false)]
    private Credential $credential;

    public function __construct(
        RoleEnum $role,
        BusinessDetails $businessDetails,
        string $partyId,
        string $countryCode,
        Credential $credential,
    ) {
        $this->role = $role;
        $this->businessDetails = $businessDetails;
        $this->partyId = $partyId;
        $this->countryCode = $countryCode;
        $this->credential = $credential;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRole(): RoleEnum
    {
        return $this->role;
    }

    public function setRole(RoleEnum $role): static
    {
        $this->role = $role;

        return $this;
    }

    public function getPartyId(): string
    {
        return $this->partyId;
    }

    public function setPartyId(string $partyId): static
    {
        $this->partyId = $partyId;

        return $this;
    }

    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    public function setCountryCode(string $countryCode): static
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    public function getBusinessDetails(): BusinessDetails
    {
        return $this->businessDetails;
    }

    public function setBusinessDetails(BusinessDetails $businessDetails): static
    {
        $this->businessDetails = $businessDetails;

        return $this;
    }

    public function getCredential(): Credential
    {
        return $this->credential;
    }

    public function setCredential(Credential $credential): static
    {
        $this->credential = $credential;

        return $this;
    }
}
