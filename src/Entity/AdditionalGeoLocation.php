<?php

namespace App\Entity;

use App\Repository\AdditionalGeoLocationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdditionalGeoLocationRepository::class)]
class AdditionalGeoLocation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10, options: ['comment' => 'Latitude of the point in decimal degree. Example: 50.770774. Decimal separator: "." Regex: -?[0-9]{1,2}\.[0-9]{5,7}'])]
    private string $latitude;

    #[ORM\Column(length: 11, options: ['comment' => 'Longitude of the point in decimal degree. Example: -126.104965. Decimal separator: "." Regex: -?[0-9]{1,3}\.[0-9]{5,7}'])]
    private string $longitude;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?DisplayText $name = null;

    #[ORM\ManyToOne(inversedBy: 'relatedLocations')]
    #[ORM\JoinColumn(nullable: false)]
    private Location $location;

    public function __construct(
        string $latitude,
        string $longitude,
        Location $location,
    ) {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->location = $location;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?DisplayText
    {
        return $this->name;
    }

    public function setName(?DisplayText $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getLatitude(): string
    {
        return $this->latitude;
    }

    public function setLatitude(string $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): string
    {
        return $this->longitude;
    }

    public function setLongitude(string $longitude): static
    {
        $this->longitude = $longitude;

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
