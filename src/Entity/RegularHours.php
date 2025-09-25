<?php

namespace App\Entity;

use App\Repository\RegularHoursRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RegularHoursRepository::class)]
class RegularHours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(options: ['comment' => 'Number of day in the week, from Monday (1) till Sunday (7)'])]
    private int $weekday;

    #[ORM\Column(length: 5, options: ['comment' => 'Begin of the regular period, in local time, given in hours and minutes. Must be in 24h format with leading zeros. Example: "18:15". Hour/Minute separator: ":" Regex: ([0-1][0-9]|2[0-3]):[0-5][0-9].'])]
    private string $periodBegin;

    #[ORM\Column(length: 5, options: ['comment' => 'End of the regular period, in local time, syntax as for period_begin. Must be later than period_begin.'])]
    private string $periodEnd;

    #[ORM\ManyToOne(inversedBy: 'regularHours')]
    #[ORM\JoinColumn(nullable: false)]
    private Hours $hours;

    public function __construct(
        int $weekday,
        string $periodBegin,
        string $periodEnd,
        Hours $hours,
    ) {
        $this->weekday = $weekday;
        $this->periodBegin = $periodBegin;
        $this->periodEnd = $periodEnd;
        $this->hours = $hours;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWeekday(): int
    {
        return $this->weekday;
    }

    public function setWeekday(int $weekday): static
    {
        $this->weekday = $weekday;

        return $this;
    }

    public function getPeriodBegin(): string
    {
        return $this->periodBegin;
    }

    public function setPeriodBegin(string $periodBegin): static
    {
        $this->periodBegin = $periodBegin;

        return $this;
    }

    public function getPeriodEnd(): string
    {
        return $this->periodEnd;
    }

    public function setPeriodEnd(string $periodEnd): static
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
