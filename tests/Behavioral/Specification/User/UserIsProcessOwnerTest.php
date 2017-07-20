<?php

namespace DesignPatterns\Behavioral\Specification\User;

use Mockery as m;
use PHPUnit\Framework\TestCase;

class UserIsProcessOwnerTest extends TestCase
{
    use m\Adapter\Phpunit\MockeryPHPUnitIntegration;

    /** @var ProcessRepository | m\MockInterface */
    private $processRepository;
    private $processName;

    /** @var UserSpecification */
    private $specification;

    protected function setUp()
    {
        $this->processRepository = m::mock('DesignPatterns\Behavioral\Specification\User\ProcessRepository');
        $this->processName = 'myFirstProcess';
        $this->specification = new UserIsProcessOwner($this->processRepository, $this->processName);
    }

    /**
     * @test
     */
    public function isNotSatisfiedForNonProcessOwner()
    {
        /** @var User | m\MockInterface $nonOwner */
        $nonOwner = m::mock('DesignPatterns\Behavioral\Specification\User\User');
        $nonOwner->shouldReceive('getUserName')->once()->andReturn('aNonOwner');

        $this->processRepository->shouldReceive('process')->withArgs([$this->processName])->andReturnSelf();
        $this->processRepository->shouldReceive('hasOwner')->withArgs(['aNonOwner'])->andReturn(false);

        $this->assertFalse($this->specification->isSatisfiedBy($nonOwner));
    }

    /**
     * @test
     */
    public function isSatisfiedForProcessOwner()
    {
        /** @var User | m\MockInterface $owner */
        $owner = m::mock('DesignPatterns\Behavioral\Specification\User\User');
        $owner->shouldReceive('getUserName')->once()->andReturn('anOwner');

        $this->processRepository->shouldReceive('process')->withArgs([$this->processName])->andReturnSelf();
        $this->processRepository->shouldReceive('hasOwner')->withArgs(['anOwner'])->andReturn(true);

        $this->assertTrue($this->specification->isSatisfiedBy($owner));
    }
}
