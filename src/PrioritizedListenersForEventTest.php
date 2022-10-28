<?php

namespace League\Event;

use PHPUnit\Framework\TestCase;

class PrioritizedListenersForEventTest extends TestCase
{
    public function testOneTimeListener(): void
    {
        $group = new PrioritizedListenersForEvent();
        $group->addListener(function () {
            return 1;
        }, 1);
        $group->addListener(function () {
            return 2;
        }, 2);
        $group->addListener(new OneTimeListener(function () {
            return 3;
        }), 3);
        $listener1 = $group->getListeners();
        $this->assertCount(3, $listener1);
        $this->assertEquals([null, 2, 1], self::inspectListener($listener1));

        $group->addListener(function () {
            return 4;
        }, 4);
        $listener2 = $group->getListeners();
        $this->assertCount(3, $listener2);
        $this->assertEquals([4, 2, 1], self::inspectListener($listener2));
    }

    public static function inspectListener(iterable $listeners): array
    {
        $event = new \stdClass();
        $ret = [];
        foreach ($listeners as $listener) {
            $ret[] = $listener($event);
        }

        return $ret;
    }
}
