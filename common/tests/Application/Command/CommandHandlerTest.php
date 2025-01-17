<?php
declare(strict_types=1);

namespace Tests\Application\Command;

use Common\Application\Outbox\Outbox;
use Common\Domain\ValueObject\Exception\InvalidUuidException;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Tests\Mock\Application\Command\StubCreateBlogPostCommand;
use Tests\Mock\Application\Command\StubCreateBlogPostCommandHandler;
use Tests\Mock\Domain\Repository\StubBlogPostRepository;

final class CommandHandlerTest extends TestCase
{
    /**
     * @throws InvalidUuidException
     * @throws Exception
     */
    public function testCase1(): void
    {
        // ADD EVENT BUS
        $commandHandler = new StubCreateBlogPostCommandHandler(
            new StubBlogPostRepository(),
            new InboxMessageStorage(),
        );
        $commandHandler->handle(new StubCreateBlogPostCommand(
            title: 'Blog Post Title',
            description: 'Blog Post Description'
        ));
        $this->assertTrue(true);
    }
}