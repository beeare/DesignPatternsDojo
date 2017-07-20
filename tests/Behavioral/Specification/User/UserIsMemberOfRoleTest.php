<?php

namespace DesignPatterns\Behavioral\Specification\User;

use Mockery as m;
use PHPUnit\Framework\TestCase;

class UserIsMemberOfRoleTest extends TestCase
{
    use m\Adapter\Phpunit\MockeryPHPUnitIntegration;

    /** @var RoleRepository | m\MockInterface */
    private $roleRepository;
    private $roleName;

    /** @var UserSpecification */
    private $specification;

    protected function setUp()
    {
        $this->roleRepository = m::mock('DesignPatterns\Behavioral\Specification\User\RoleRepository');
        $this->roleName = 'myRole';
        $this->specification = new UserIsMemberOfRole($this->roleRepository, $this->roleName);
    }

    /**
     * @test
     */
    public function isNotSatisfiedForNonMemberOfRole()
    {
        /** @var User | m\MockInterface $nonMember */
        $nonMember = m::mock('DesignPatterns\Behavioral\Specification\User\User');
        $nonMember->shouldReceive('getUserName')->once()->andReturn('aNonMember');

        $this->roleRepository->shouldReceive('role')->withArgs([$this->roleName])->andReturnSelf();
        $this->roleRepository->shouldReceive('hasMember')->withArgs(['aNonMember'])->andReturn(false);

        $this->assertFalse($this->specification->isSatisfiedBy($nonMember));
    }

    /**
     * @test
     */
    public function isSatisfiedForMemberOfRole()
    {
        /** @var User | m\MockInterface $member */
        $member = m::mock('DesignPatterns\Behavioral\Specification\User\User');
        $member->shouldReceive('getUserName')->once()->andReturn('aMember');

        $this->roleRepository->shouldReceive('role')->withArgs([$this->roleName])->andReturnSelf();
        $this->roleRepository->shouldReceive('hasMember')->withArgs(['aMember'])->andReturn(true);

        $this->assertTrue($this->specification->isSatisfiedBy($member));
    }
}
