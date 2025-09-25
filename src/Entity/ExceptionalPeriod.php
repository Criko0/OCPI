<?php

namespace App\Entity;

use App\Repository\ExceptionalPeriodRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Reference: https://github.com/ocpi/ocpi/blob/release-2.2.1-bugfixes/mod_locations.asciidoc#1411-exceptionalperiod-class
 */
#[ORM\Entity(repositoryClass: ExceptionalPeriodRepository::class)]
class ExceptionalPeriod
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(options: ['comment' => 'Begin of the exception. In UTC, time_zone field can be used to convert to local time.'])]
    private \DateTimeImmutable $periodBegin;

    #[ORM\Column(options: ['comment' => 'End of the exception. In UTC, time_zone field can be used to convert to local time.'])]
    private \DateTimeImmutable $periodEnd;

    #[ORM\ManyToOne(inversedBy: 'exceptionalOpenings')]
    #[ORM\JoinColumn(nullable: false)]
    private Hours $hours;

    public function __construct(
        \DateTimeImmutable $periodBegin,
        \DateTimeImmutable $periodEnd,
        Hours $hours,
    ) {
        $this->periodBegin = $periodBegin;
        $this->periodEnd = $periodEnd;
        $this->hours = $hours;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPeriodBegin(): \DateTimeImmutable
    {
        return $this->periodBegin;
    }

    public function setPeriodBegin(\DateTimeImmutable $periodBegin): static
    {
        $this->periodBegin = $periodBegin;

        return $this;
    }

    public function getPeriodEnd(): \DateTimeImmutable
    {
        return $this->periodEnd;
    }

    public function setPeriodEnd(\DateTimeImmutable $periodEnd): static
    {
        $this->periodEnd = $periodEnd;

        return $this;
    }

    public function getHours(): Hours
    {
        return $this->hours;
    }

    public function setHours(Hours $hours): static
    {
        $this->hours = $hours;

        return $this;
    }
}
