<?php

namespace DesignPatterns\Behavioral\Specification\User;

class IsMemberOfRole implements UserSpecification
{
    private $roleRepository;
    private $roleName;

    public function __construct(RoleRepository $roleRepository, string $roleName)
    {
        $this->roleRepository = $roleRepository;
        $this->roleName = $roleName;
    }

    public function isSatisfiedBy(User $user): bool
    {
        return $this->roleRepository->role($this->roleName)->hasMember($user->getUserName());
    }
}
