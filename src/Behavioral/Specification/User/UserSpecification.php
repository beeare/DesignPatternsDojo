<?php

namespace DesignPatterns\Behavioral\Specification\User;

interface UserSpecification
{
    public function isSatisfiedBy(User $user): bool;
}
