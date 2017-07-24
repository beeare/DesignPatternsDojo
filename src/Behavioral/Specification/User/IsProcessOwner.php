<?php

namespace DesignPatterns\Behavioral\Specification\User;

class IsProcessOwner implements UserSpecification
{
    private $processRepository;
    private $processName;

    public function __construct(ProcessRepository $processRepository, string $processName)
    {
        $this->processRepository = $processRepository;
        $this->processName = $processName;
    }

    public function isSatisfiedBy(User $user): bool
    {
        return $this->processRepository->process($this->processName)->hasOwner($user->getUserName());
    }
}
