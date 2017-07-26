<?php

namespace DesignPatterns\Behavioral\Specification\User;

class IsProcessDesigner implements UserSpecification
{
    /**
     * @var IsAdministrator
     */
    private $adminSpecification;

    /**
     * @var IsProcessOwner
     */
    private $processOwnerSpecification;

    public function __construct(IsAdministrator $adminSpecification, IsProcessOwner $processOwnerSpecification)
    {
        $this->adminSpecification = $adminSpecification;
        $this->processOwnerSpecification = $processOwnerSpecification;
    }

    public function isSatisfiedBy(User $user): bool
    {
        return $this->adminSpecification->isSatisfiedBy($user)
            || $this->processOwnerSpecification->isSatisfiedBy($user);
    }
}
