<?php

namespace Tests\Feature\ApiAuth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginControllerTest extends TestCase
{
    use WithoutMiddleware;
    use DatabaseTransactions;
    /**
     * @return void
     */
    public function test_login_invalid_credentials()
    {
        $this->post('/api/guest/login',['Content-Type' => 'application/json'])
            ->assertStatus(401);        
    }

    /**
     * @return void
     */
    public function test_login()
    {
        $user = ['email' => 'test.unit@test.com','password'=> \Hash::make('123456'), 
            'name' => 'test', 'fk_user_types' => 1];
        \App\User::create($user);
        
        $this->json('POST','/api/guest/login',['email' => 'test.unit@test.com','password'=>'123456'])
            ->assertStatus(200);
    }

    /**
     * @return void
     */ 
    public function test_signup()
    {
        $user = ['email' => 'test.unit@test.com', 'password' => '123456', 'name' => 'Test'];
        $this->json('POST','/api/guest/signup',$user)
            ->assertStatus(200);
    }
}
