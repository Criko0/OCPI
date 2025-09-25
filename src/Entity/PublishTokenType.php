<?php

namespace App\Entity;

use App\Enum\TokenTypeEnum;
use App\Repository\PublishTokenTypeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PublishTokenTypeRepository::class)]
class PublishTokenType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 36, nullable: true, options: ['comment' => 'Unique ID by which this Token can be identified.'])]
    private ?string $uid = null;

    #[ORM\Column(nullable: true, enumType: TokenTypeEnum::class, options: ['comment' => 'Type of the token.'])]
    private ?TokenTypeEnum $type = null;

    #[ORM\Column(length: 64, nullable: true, options: ['comment' => 'Visual readable number/identification as printed on the Token (RFID card).'])]
    private ?string $visualNumber = null;

    #[ORM\Column(length: 64, nullable: true, options: ['comment' => 'Issuing company, most of the times the name of the company printed on the token (RFID card), not necessarily the eMSP.'])]
    private ?string $issuer = null;

    #[ORM\Column(length: 36, nullable: true, options: ['comment' => 'This ID groups a couple of tokens. This can be used to make two or more tokens work as one.'])]
    private ?string $groupId = null;

    #[ORM\ManyToOne(inversedBy: 'publishAllowedTo')]
    #[ORM\JoinColumn(nullable: false)]
    private Location $location;

    public function __construct(
        Location $location,
    ) {
        $this->location = $location;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUid(): ?string
    {
        return $this->uid;
    }

    public function setUid(?string $uid): static
    {
        $this->uid = $uid;

        return $this;
    }

    public function getType(): ?TokenTypeEnum
    {
        return $this->type;
    }

    public function setType(?TokenTypeEnum $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getVisualNumber(): ?string
    {
        return $this->visualNumber;
    }

    public function setVisualNumber(?string $visualNumber): static
    {
        $this->visualNumber = $visualNumber;

        return $this;
    }

    public function getIssuer(): ?string
    {
        return $this->issuer;
    }

    public function setIssuer(?string $issuer): static
    {
        $this->issuer = $issuer;

        return $this;
    }

    public function getGroupId(): ?string
    {
        return $this->groupId;
    }

    public function setGroupId(?string $groupId): static
    {
        $this->groupId = $groupId;

        return $this;
    }

    public function getLocation(): Location
    {
        return $this->location;
    }

    public function setLocation(Location $location): static
    {
        $this->location = $location;

        return $this;
    }
}
