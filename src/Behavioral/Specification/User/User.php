<?php

namespace DesignPatterns\Behavioral\Specification\User;

interface User
{
    public function hasAdminRights(): bool;

    public function getUserName(): string;
}
