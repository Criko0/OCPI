<?php

namespace App\Entity;

use App\Repository\HoursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Reference: https://github.com/ocpi/ocpi/blob/release-2.2.1-bugfixes/mod_locations.asciidoc#1414-hours-class.
 */
#[ORM\Entity(repositoryClass: HoursRepository::class)]
class Hours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private bool $twentyfourseven;

    /**
     * @var Collection<array-key, RegularHours>
     */
    #[ORM\OneToMany(targetEntity: RegularHours::class, mappedBy: 'hours', orphanRemoval: true)]
    private Collection $regularHours;

    /**
     * @var Collection<array-key, ExceptionalPeriod>
     */
    #[ORM\OneToMany(targetEntity: ExceptionalPeriod::class, mappedBy: 'hours', orphanRemoval: true)]
    private Collection $exceptionalOpenings;

    /**
     * @var Collection<array-key, ExceptionalPeriod>
     */
    #[ORM\OneToMany(targetEntity: ExceptionalPeriod::class, mappedBy: 'hours', orphanRemoval: true)]
    private Collection $exceptionalClosing;

    public function __construct(
        bool $twentyfourseven,
    ) {
        $this->twentyfourseven = $twentyfourseven;
        $this->regularHours = new ArrayCollection();
        $this->exceptionalOpenings = new ArrayCollection();
        $this->exceptionalClosing = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isTwentyfourseven(): bool
    {
        return $this->twentyfourseven;
    }

    public function setTwentyfourseven(bool $twentyfourseven): static
    {
        $this->twentyfourseven = $twentyfourseven;

        return $this;
    }

    /**
     * @return Collection<array-key, RegularHours>
     */
    public function getRegularHours(): Collection
    {
        return $this->regularHours;
    }

    public function addRegularHour(RegularHours $regularHour): static
    {
        if (!$this->regularHours->contains($regularHour)) {
            $this->regularHours->add($regularHour);
            $regularHour->setHours($this);
        }

        return $this;
    }

    public function removeRegularHour(RegularHours $regularHour): static
    {
        $this->regularHours->removeElement($regularHour);

        return $this;
    }

    /**
     * @return Collection<array-key, ExceptionalPeriod>
     */
    public function getExceptionalOpenings(): Collection
    {
        return $this->exceptionalOpenings;
    }

    public function addExceptionalOpening(ExceptionalPeriod $exceptionalOpening): static
    {
        if (!$this->exceptionalOpenings->contains($exceptionalOpening)) {
            $this->exceptionalOpenings->add($exceptionalOpening);
            $exceptionalOpening->setHours($this);
        }

        return $this;
    }

    public function removeExceptionalOpening(ExceptionalPeriod $exceptionalOpening): static
    {
        $this->exceptionalOpenings->removeElement($exceptionalOpening);

        return $this;
    }

    /**
     * @return Collection<array-key, ExceptionalPeriod>
     */
    public function getExceptionalClosing(): Collection
    {
        return $this->exceptionalClosing;
    }

    public function addExceptionalClosing(ExceptionalPeriod $exceptionalClosing): static
    {
        if (!$this->exceptionalClosing->contains($exceptionalClosing)) {
            $this->exceptionalClosing->add($exceptionalClosing);
            $exceptionalClosing->setHours($this);
        }

        return $this;
    }

    public function removeExceptionalClosing(ExceptionalPeriod $exceptionalClosing): static
    {
        $this->exceptionalClosing->removeElement($exceptionalClosing);

        return $this;
    }
}
