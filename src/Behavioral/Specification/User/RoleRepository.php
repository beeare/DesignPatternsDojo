<?php

namespace DesignPatterns\Behavioral\Specification\User;

interface RoleRepository
{
    public function role(string $roleName): self;

    public function hasMember(string $userName): bool;
}
