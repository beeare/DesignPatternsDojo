<?php

namespace DesignPatterns\Behavioral\Specification\User;

class IsAdministrator implements UserSpecification
{
    public function isSatisfiedBy(User $user): bool
    {
        return $user->hasAdminRights();
    }
}
