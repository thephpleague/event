<?php

namespace League\Event;

interface HasEventNameInterface
{
    /**
     * @return string
     */
    public function getName();
}