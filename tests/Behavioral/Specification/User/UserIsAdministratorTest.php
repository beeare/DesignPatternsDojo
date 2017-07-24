<?php

namespace DesignPatterns\Behavioral\Specification\User;

use Mockery as m;
use PHPUnit\Framework\TestCase;

class UserIsAdministratorTest extends TestCase
{
    use m\Adapter\Phpunit\MockeryPHPUnitIntegration;

    /** @var UserSpecification */
    private $specification;

    protected function setUp()
    {
        $this->specification = new IsAdministrator();
    }

    /**
     * @test
     */
    public function isNotSatisfiedForNonAdmin()
    {
        /** @var User | m\MockInterface $nonAdmin */
        $nonAdmin = m::mock('DesignPatterns\Behavioral\Specification\User\User');
        $nonAdmin->shouldReceive('hasAdminRights')->once()->andReturn(false);

        $this->assertFalse($this->specification->isSatisfiedBy($nonAdmin));
    }

    /**
     * @test
     */
    public function isSatisfiedForAdmin()
    {
        /** @var User | m\MockInterface $admin */
        $admin = m::mock('DesignPatterns\Behavioral\Specification\User\User');
        $admin->shouldReceive('hasAdminRights')->once()->andReturn(true);

        $this->assertTrue($this->specification->isSatisfiedBy($admin));
    }
}
