<?php

namespace DesignPatterns\Behavioral\Specification\User;

interface ProcessRepository
{
    public function process(string $processName): self;

    public function hasOwner(string $userName): bool;
}
