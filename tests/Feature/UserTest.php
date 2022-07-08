<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{

    
    use DatabaseTransactions;

   
    protected $defaultEmail = 'test@test.ee';
    protected $defaultName = 'test';
    protected $defaultPassword = 'test1234';


    public function registerUser(): string{
        $user = [
            'email' => $this->defaultEmail,
            'name' => $this->defaultName,
            'password' => $this->defaultPassword,
        ];

        $response = $this->post('api/register', $user);
        return $response->decodeResponseJson()['token'];
    }


    public function testSuccessfulRegister(): string
    {
        $user = [
            'email' => $this->defaultEmail,
            'name' => $this->defaultName,
            'password' => $this->defaultPassword,
        ];

        $response = $this->post('api/register', $user);
        $response->assertOk(); // checks 200
        $response->assertJsonStructure(['token', 'user_id']);

        return $response->decodeResponseJson()['token'];
    }

    public function testFailedRegisterEmailTaken(): void
    {
        $this->registerUser();

        $user = [
            'email' => $this->defaultEmail,
            'name' => $this->defaultName,
            'password' => $this->defaultPassword,
        ];

        $response = $this->post('api/register', $user);
        $response->assertStatus(302); // checks 302
        
    }
    public function testFailedRegisterInvalidEmail(): void
    {
        $user = [
            'email' => 'test1test.ee',
            'name' => $this->defaultName,
            'password' => $this->defaultPassword,
        ];

        $response = $this->post('api/register', $user);
        $response->assertStatus(302);
    }
    public function testFailedRegisterInvalidName(): void
    {
        $user = [
            'email' => 'test2@test.ee',
            'name' => 'T',
            'password' => $this->defaultPassword,
        ];

        $response = $this->post('api/register', $user);
        $response->assertStatus(302);
    }
    public function testFailedRegisterInvalidPwd(): void
    {
        $user = [
            'email' => 'test2@test.ee',
            'name' => $this->defaultName,
            'password' => 'T',
        ];

        $response = $this->post('api/register', $user);
        $response->assertStatus(302);
    }


     /**
     * @depends testSuccessfulRegister
     */
    public function testSuccessfulLogin(){
        
        $this->registerUser();

        $user = [
            'email' => $this->defaultEmail,
            'password' => $this->defaultPassword,
        ];

        $response = $this->post('api/login', $user);
        $response->assertStatus(200);
    }

    public function testFailedLoginEmail(){
        
        $user = [
            'email' => 'random@ran.ee',
            'password' => $this->defaultPassword,
        ];

        $response = $this->post('api/login', $user);
        $response->assertStatus(500);
    }

    public function testFailedLoginPwd(){
        
        $user = [
            'email' => $this->defaultEmail,
            'password' => 'wrongpwd',
        ];

        $response = $this->post('api/login', $user);
        $response->assertStatus(500);
    }
    
    
    /**
     * @depends testSuccessfulRegister
     */
    public function testProfile(): void
    {

        $token = $this->registerUser();
        $response = $this->json('GET', 'api/profile', [] , ['HTTP_Authorization' => 'Bearer '. $token]);
        $response->assertStatus(200);


    }
}
