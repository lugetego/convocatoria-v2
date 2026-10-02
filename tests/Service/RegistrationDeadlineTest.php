<?php

namespace App\Tests\Service;

use App\Service\RegistrationDeadline;
use PHPUnit\Framework\TestCase;

class RegistrationDeadlineTest extends TestCase
{
    public function testIsClosedWhenDeadlineIsInThePast(): void
    {
        $deadline = new RegistrationDeadline('2000-01-01');

        self::assertTrue($deadline->isClosed());
    }

    public function testIsNotClosedWhenDeadlineIsInTheFuture(): void
    {
        $deadline = new RegistrationDeadline('2999-12-31');

        self::assertFalse($deadline->isClosed());
    }
}
