<?php

namespace App\Dto;

class OcpiResponseDto
{
    /**
     * @param array<mixed>|object|string|null $data
     */
    public function __construct(
        private int $status_code,
        private string $status_message,
        private array|object|string|null $data = null,
    ) {
    }

    public function getStatusCode(): int
    {
        return $this->status_code;
    }

    public function setStatusCode(int $status_code): self
    {
        $this->status_code = $status_code;

        return $this;
    }

    public function getStatusMessage(): string
    {
        return $this->status_message;
    }

    public function setStatusMessage(string $status_message): self
    {
        $this->status_message = $status_message;

        return $this;
    }

    /**
     * @return array<mixed>|object|string|null $data
     */
    public function getData(): array|object|string|null
    {
        return $this->data;
    }

    /**
     * @param array<mixed>|object|string|null $data
     */
    public function setData(array|object|string|null $data): self
    {
        $this->data = $data;

        return $this;
    }
}
