<?php
declare(strict_types=1);

namespace Tests\Application\Command;

use Common\Domain\ValueObject\Exception\InvalidUuidException;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Tests\Mock\Application\Command\StubCreateBlogPostCommand;
use Tests\Mock\Application\Command\StubCreateBlogPostCommandHandler;
use Tests\Mock\Domain\Aggregate\StubBlogPost;
use Tests\Mock\Domain\Repository\StubBlogPostRepository;

final class CommandHandlerTest extends TestCase
{
    /**
     * @throws InvalidUuidException
     * @throws Exception
     */
    public function testCase1(): void
    {
        $repository = $this->getMockBuilder(StubBlogPostRepository::class)
            ->onlyMethods(['save'])
            ->getMock();

        // Настраиваем ожидание на вызов метода save
        $repository->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(StubBlogPost::class));
        // ADD EVENT BUS
        $commandHandler = new StubCreateBlogPostCommandHandler(
            $repository,
        );
        $commandHandler->handle(new StubCreateBlogPostCommand(
            title: 'Blog Post Title',
            description: 'Blog Post Description'
        ));
        $this->assertTrue(true);
    }
}