<?php

namespace App\Service;

class RegistrationDeadline
{
    private readonly \DateTimeImmutable $deadline;

    public function __construct(string $applicationDeadline)
    {
        $this->deadline = new \DateTimeImmutable($applicationDeadline);
    }

    public function isClosed(): bool
    {
        return new \DateTimeImmutable() >= $this->deadline;
    }

    public function getDeadline(): \DateTimeImmutable
    {
        return $this->deadline;
    }
}
