<?php

namespace DesignPatterns\Behavioral\Specification\User;

class UserIsProcessOwner implements UserSpecification
{
    /**
     * @var ProcessRepository
     */
    private $processRepository;

    /**
     * @var string
     */
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
