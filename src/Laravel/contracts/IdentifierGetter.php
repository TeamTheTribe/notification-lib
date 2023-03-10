<?php

namespace TheTribe\NotificationMS\Laravel\Contracts;

interface IdentifierGetter
{
    /**
     * @return string the authenticated user sharpid
     */
    public function get(): string;
}