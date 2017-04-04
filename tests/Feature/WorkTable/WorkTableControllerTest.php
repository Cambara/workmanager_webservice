<?php

namespace Tests\Feature\WorkTable;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class WorkTableControllerTest extends TestCase
{
    use WithoutMiddleware;
    use DatabaseTransactions;
    
    /**
     * @return void
     */ 
    public function test_add_worktable()
    {
        $u = ['email' => 'test.unit@test.com', 'password' => '123456', 'name' => 'Test', 'fk_user_types' => 1];
        $user = \App\User::create($u);
        $b = ['cnpj' => '89.366.245/0001-40','company_name' => 'Test Unit ltda', 'nickname' => 'Test Unit'];
        $business = \App\Business::create($b);

        \Auth::login($user,true);
        
        $workTable = ['fk_business' => $business->id, 'time_begin' => '2017-04-03 08:00:00',
            'time_end' => '2017-04-03 17:00:00', 'time_lunch' => '01:00:00', 'tasks' => 'teste tasks'];

        $this->json('POST','/api/worktable',$workTable)
            ->assertStatus(200)
            ->assertJsonFragment(['time_begin' => '2017-04-03 08:00:00','time_end' => '2017-04-03 17:00:00', 
                'time_lunch' => '01:00:00', 'tasks' => 'teste tasks']);
    }

    /**
    * @return void
    */
    public function test_add_worktable_when_time_end_greater_than_time_begin()
    {
        $u = ['email' => 'test.unit@test.com', 'password' => '123456', 'name' => 'Test', 'fk_user_types' => 1];
        $user = \App\User::create($u);
        $b = ['cnpj' => '89.366.245/0001-40','company_name' => 'Test Unit ltda', 'nickname' => 'Test Unit'];
        $business = \App\Business::create($b);
        
        \Auth::login($user,true);
        
        $workTable = ['fk_business' => $business->id, 'time_begin' => '2017-04-03 17:00:00',
            'time_end' => '2017-04-03 08:00:00', 'time_lunch' => '01:00:00', 'tasks' => 'teste tasks'];

        $this->json('POST','/api/worktable',$workTable)
            ->assertStatus(400)
            ->assertJsonFragment(['time_end']);        
    }

    /**
    * @return void
    */
    public function test_add_worktable_when_no_pass_params()
    {
        $u = ['email' => 'test.unit@test.com', 'password' => '123456', 'name' => 'Test', 'fk_user_types' => 1];
        $user = \App\User::create($u);
        $b = ['cnpj' => '89.366.245/0001-40','company_name' => 'Test Unit ltda', 'nickname' => 'Test Unit'];
        $business = \App\Business::create($b);

        $workTable = [];

        \Auth::login($user,true);

        $this->json('POST','/api/worktable',$workTable)
            ->assertStatus(400)
            ->assertJsonFragment(['time_end']);        
    }
}