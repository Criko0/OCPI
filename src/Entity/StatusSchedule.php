<?php

namespace App\Entity;

use App\Enum\StatusEnum;
use App\Repository\StatusScheduleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatusScheduleRepository::class)]
class StatusSchedule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(options: ['comment' => 'Begin of the scheduled period.'])]
    private \DateTimeImmutable $periodBegin;

    #[ORM\Column(nullable: true, options: ['comment' => 'End of the scheduled period, if known.'])]
    private ?\DateTimeImmutable $periodEnd = null;

    #[ORM\Column(enumType: StatusEnum::class, options: ['comment' => 'Status value during the scheduled period.'])]
    private StatusEnum $status;

    #[ORM\ManyToOne(inversedBy: 'statusSchedule')]
    #[ORM\JoinColumn(nullable: false)]
    private Evse $evse;

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

    public function getPeriodEnd(): ?\DateTimeImmutable
    {
        return $this->periodEnd;
    }

    public function setPeriodEnd(?\DateTimeImmutable $periodEnd): static
    {
        $this->periodEnd = $periodEnd;

        return $this;
    }

    public function getStatus(): StatusEnum
    {
        return $this->status;
    }

    public function setStatus(StatusEnum $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getEvse(): Evse
    {
        return $this->evse;
    }

    public function setEvse(Evse $evse): static
    {
        $this->evse = $evse;

        return $this;
    }
}
