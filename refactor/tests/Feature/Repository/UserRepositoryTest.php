<?php

namespace Tests\Feature\Repository;

use DTApi\Repository\UserRepository;
use Illuminate\Foundation\Auth\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateOrUpdateIsWorkingAsExpectedWhenNewUser()
    {
        $data = [
            'role' => 1,
            'name' => 'Test Name',
            'company_id' => 1,
            'department_id' => 1,
            'email' => 'test@example.com',
            'dob_or_orgid' => '1990-01-01',
            'phone' => '12345',
            'mobile' => '12345',
            'password' => Hash::make('password')
        ];

        $result = (new UserRepository(new User()))->createOrUpdate(null, $data);

        $this->assertNotNull($result);
        $this->assertNotNull($result->id);
        $this->assertEquals($data['name'], $result->name);
        $this->assertEquals($data['email'], $result->email);
        $this->assertNotNull($result->password);
    }

    public function testCreateOrUpdateIsWorkingAsExpectedWhenExitingUser()
    {
        $data = [
            'role' => 1,
            'name' => 'Updated Test Name',
            'company_id' => 1,
            'department_id' => 1,
            'email' => 'updatedtest@example.com',
            'dob_or_orgid' => '1990-01-01',
            'phone' => '67890',
            'mobile' => '67890',
            'password' => Hash::make('newpassword')
        ];

        $existingUser = (new UserRepository(new User()))->createOrUpdate(1, $data);

        $this->assertNotNull($existingUser);
        $this->assertEquals(1, $existingUser->id);
        $this->assertEquals($data['name'], $existingUser->name);
        $this->assertEquals($data['email'], $existingUser->email);
        $this->assertNotEquals('password', $existingUser->password);
    }
}
