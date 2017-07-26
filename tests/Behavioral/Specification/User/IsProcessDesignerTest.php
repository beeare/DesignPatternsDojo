<?php

namespace DesignPatterns\Behavioral\Specification\User;

use Mockery as m;
use PHPUnit\Framework\TestCase;

class IsProcessDesignerTest extends TestCase
{
    use m\Adapter\Phpunit\MockeryPHPUnitIntegration;

    /** @var ProcessRepository | m\MockInterface */
    private $processRepository;
    private $processName;

    /** @var UserSpecification */
    private $specification;

    protected function setUp()
    {
        $adminSpecification = new IsAdministrator();

        $this->processRepository = m::mock('DesignPatterns\Behavioral\Specification\User\ProcessRepository');
        $this->processName = 'myFirstProcess';
        $processOwnerSpecification = new IsProcessOwner($this->processRepository, $this->processName);

        $this->specification = new IsProcessDesigner($adminSpecification, $processOwnerSpecification);
    }

    /**
     * @test
     */
    public function isNotSatisfiedForNeitherAdminNorNonProcessOwner()
    {
        /** @var User | m\MockInterface $user */
        $user = m::mock('DesignPatterns\Behavioral\Specification\User\User');
        $user->shouldReceive('getUserName')->once()->andReturn('aNonOwner');
        $user->shouldReceive('hasAdminRights')->once()->andReturn(false);

        $this->processRepository->shouldReceive('process')->withArgs([$this->processName])->andReturnSelf();
        $this->processRepository->shouldReceive('hasOwner')->withArgs(['aNonOwner'])->andReturn(false);

        $this->assertFalse($this->specification->isSatisfiedBy($user));
    }

    /**
     * @test
     */
    public function isSatisfiedForAdmin()
    {
        /** @var User | m\MockInterface $user */
        $user = m::mock('DesignPatterns\Behavioral\Specification\User\User');
        $user->shouldReceive('hasAdminRights')->once()->andReturn(true);

        $this->assertTrue($this->specification->isSatisfiedBy($user));
    }

    /**
     * @test
     */
    public function isSatisfiedForProcessOwner()
    {
        /** @var User | m\MockInterface $user */
        $user = m::mock('DesignPatterns\Behavioral\Specification\User\User');
        $user->shouldReceive('getUserName')->once()->andReturn('anOwner');
        $user->shouldReceive('hasAdminRights')->once()->andReturn(false);

        $this->processRepository->shouldReceive('process')->withArgs([$this->processName])->andReturnSelf();
        $this->processRepository->shouldReceive('hasOwner')->withArgs(['anOwner'])->andReturn(true);

        $this->assertTrue($this->specification->isSatisfiedBy($user));
    }
}
