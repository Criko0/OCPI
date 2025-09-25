<?php

namespace App\Entity;

use App\Repository\DisplayTextRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Reference: https://github.com/ocpi/ocpi/blob/release-2.2.1-bugfixes/types.asciidoc#types_displaytext_class.
 */
#[ORM\Entity(repositoryClass: DisplayTextRepository::class)]
class DisplayText
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 2, options: ['comment' => 'Language Code ISO 639-1.'])]
    private string $language;

    #[ORM\Column(length: 512, options: ['comment' => 'Text to be displayed to a end user. No markup, html etc. allowed.'])]
    private string $text;

    public function __construct(
        string $language,
        string $text,
    ) {
        $this->language = $language;
        $this->text = $text;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function setLanguage(string $language): static
    {
        $this->language = $language;

        return $this;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): static
    {
        $this->text = $text;

        return $this;
    }
}
