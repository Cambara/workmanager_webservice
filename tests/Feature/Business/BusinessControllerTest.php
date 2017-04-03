<?php

namespace Tests\Feature\ApiAuth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BusinessControllerTest extends TestCase
{
    use WithoutMiddleware;
    use DatabaseTransactions;
    
    /**
     * @return void
     */
    public function test_add_business()
    {
        $business = ['cnpj' => '89.366.245/0001-40','company_name' => 'Test Unit ltda', 'nickname' => 'Test Unit'];
        $this->json('POST','/api/business',$business)
            ->assertStatus(200)
            ->assertJsonFragment($business);        
    }

    /**
    * @return void
    */
    public function test_add_business_with_invalidate_cnpj()
    {
        $business = ['cnpj' => '89.366.245/0001-41','company_name' => 'Test Unit ltda', 'nickname' => 'Test Unit'];
        $this->json('POST','/api/business',$business)
            ->assertStatus(400)
            ->assertJsonFragment(['cnpj']);           
    }

    /**
    * @return void
    */ 
    public function test_update_business()
    {
        $b = ['cnpj' => '89.366.245/0001-40','company_name' => 'Test Unit ltda', 'nickname' => 'Test Unit'];
        $business = \App\Business::create($b);

        $upB = ['cnpj' => '54.727.113/0001-12','company_name' => 'Test Unit 2 ltda', 'nickname' => 'Test Unit 2'];
        
        $this->json('PUT','/api/business/'.$business->id, $upB)
            ->assertStatus(200)
            ->assertJsonFragment($upB);
    }

    /**
    * @return void
    */ 
    public function test_update_business_not_change_cnpj()
    {
        $b = ['cnpj' => '89.366.245/0001-40','company_name' => 'Test Unit ltda', 'nickname' => 'Test Unit'];
        $business = \App\Business::create($b);

        $upB = ['cnpj' => '89.366.245/0001-40','company_name' => 'Test Unit 2 ltda', 'nickname' => 'Test Unit 2'];
        
        $this->json('PUT','/api/business/'.$business->id, $upB)
            ->assertStatus(200)
            ->assertJsonFragment($upB);
    }

    /**
    * @return void
    */ 
    public function test_update_business_if_exist_cnpj()
    {
        $b = ['cnpj' => '89.366.245/0001-40','company_name' => 'Test Unit ltda', 'nickname' => 'Test Unit'];
        $business = \App\Business::create($b);

        $upB = ['cnpj' => '54.727.113/0001-12','company_name' => 'Test Unit 2 ltda', 'nickname' => 'Test Unit 2'];
        \App\Business::create($upB);        

        $this->json('PUT','/api/business/'.$business->id, $upB)
            ->assertStatus(400)
            ->assertJsonFragment(['cnpj']);
    }
}