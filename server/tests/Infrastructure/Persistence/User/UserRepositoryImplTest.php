<?php
declare(strict_types=1);

namespace Tests\Infrastructure\Persistence\User;

use App\Domain\User\User;
use App\Domain\User\UserNotFoundException;
use App\Domain\User\UserRepository;
use App\Infrastructure\Persistence\User\UserRepositoryImpl;
use ReflectionClass;
use Tests\DataBaseSetUp;
use Tests\TestCase;

class UserRepositoryImplTest extends TestCase
{
    private UserRepository $userRepository;

    public function __construct()
    {
        parent::__construct();
        DataBaseSetUp::up();
        $this->userRepository = new UserRepositoryImpl();
    }

    public function testDbConnection()
    {
        $reflection = new ReflectionClass(UserRepositoryImpl::class);
        $property = $reflection->getProperty("db");
        $obj = new UserRepositoryImpl();

        $property->setAccessible(true);
        $this->assertNotNull($property->getValue($obj));
    }

    public function testFindAll()
    {
        $this->assertNotEmpty($this->userRepository->findAll());
    }

    public function testFindUserOfId()
    {
        $userFound = $this->userRepository->findUserOfId(1);
        $user = new User('user1', 'user1@mail.com', 'User One', 'placeholderpassword');
        $this->assertEquals(json_encode($user), json_encode($userFound));
    }

    public function testFindUserOfIdThrowsNotFoundException()
    {
        $this->expectException(UserNotFoundException::class);
        $this->userRepository->findUserOfId(9999999);
    }
}