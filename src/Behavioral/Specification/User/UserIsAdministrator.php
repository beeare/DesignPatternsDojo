<?php

namespace DesignPatterns\Behavioral\Specification\User;

class UserIsAdministrator implements UserSpecification
{
    public function isSatisfiedBy(User $user): bool
    {
        return $user->hasAdminRights();
    }
}
