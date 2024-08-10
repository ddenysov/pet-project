<?php

namespace Tests\Application\Event;


use Common\Application\Serializer\Event\EventSerializer;
use Common\Domain\ValueObject\Uuid;
use PHPUnit\Framework\TestCase;
use Tests\Application\Event\Stub\StubEvent;

final class EventSerializerTest extends TestCase
{
    public function testCase1(): void
    {
        $serializer = new EventSerializer();
        $name       = 'tests.application.event.stub.stub_event';

        /**
         * @var StubEvent $event
         */
        $event = $serializer->deserialize($name, [
            'id'           => Uuid::create()->toString(),
            'aggregate_id' => Uuid::create()->toString(),
            'userName'     => 'ololo',
            'password'     => 'trololo',
        ]);

        $this->assertEquals(StubEvent::class, get_class($event));
        $this->assertEquals('ololo', $event->getUserName()->toString());
        $this->assertEquals($name, $event->getName());
    }
}