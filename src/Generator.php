<?php
declare(strict_types=1);

namespace League\Event;

class Generator implements GeneratorInterface
{
    use GeneratorTrait {
        addEvent as public;
    }
}
