<?php

namespace App\Entity;

use App\Enum\ImageCategoryEnum;
use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Reference: https://github.com/ocpi/ocpi/blob/release-2.2.1-bugfixes/mod_locations.asciidoc#1415-image-class.
 */
#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, options: ['comment' => 'URL from where the image data can be fetched through a web browser.'])]
    private string $url;

    #[ORM\Column(length: 255, nullable: true, options: ['comment' => 'URL from where a thumbnail of the image can be fetched through a webbrowser.'])]
    private ?string $thumbnail = null;

    #[ORM\Column(enumType: ImageCategoryEnum::class, options: ['comment' => 'Describes what the image is used for.'])]
    private ImageCategoryEnum $category;

    #[ORM\Column(length: 4, options: ['comment' => 'Image type like: gif, jpeg, png, svg.'])]
    private string $type;

    #[ORM\Column(nullable: true, options: ['comment' => 'Width of the full scale image.'])]
    private ?int $width = null;

    #[ORM\Column(nullable: true, options: ['comment' => 'Height of the full scale image.'])]
    private ?int $height = null;

    #[ORM\ManyToOne(inversedBy: 'images')]
    private ?Location $location = null;

    #[ORM\OneToOne(mappedBy: 'logo', cascade: ['persist', 'remove'])]
    private ?BusinessDetails $businessDetails = null;

    public function __construct(
        string $url,
        ImageCategoryEnum $category,
        string $type,
    ) {
        $this->url = $url;
        $this->category = $category;
        $this->type = $type;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getThumbnail(): string
    {
        return $this->thumbnail;
    }

    public function setThumbnail(?string $thumbnail): static
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    public function getCategory(): ImageCategoryEnum
    {
        return $this->category;
    }

    public function setCategory(ImageCategoryEnum $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function setWidth(?int $width): static
    {
        $this->width = $width;

        return $this;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function setHeight(?int $height): static
    {
        $this->height = $height;

        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getBusinessDetails(): ?BusinessDetails
    {
        return $this->businessDetails;
    }

    public function setBusinessDetails(?BusinessDetails $businessDetails): static
    {
        // unset the owning side of the relation if necessary
        if (null === $businessDetails && null !== $this->businessDetails) {
            $this->businessDetails->setLogo(null);
        }

        // set the owning side of the relation if necessary
        if (null !== $businessDetails && $businessDetails->getLogo() !== $this) {
            $businessDetails->setLogo($this);
        }

        $this->businessDetails = $businessDetails;

        return $this;
    }
}
