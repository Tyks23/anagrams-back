<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class WordTest extends TestCase
{

    use DatabaseTransactions;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    protected $defaultEmail = 'test@test.ee';
    protected $defaultName = 'test';
    protected $defaultPassword = 'test1234';

    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function registerUser(): string{
        $user = [
            'email' => $this->defaultEmail,
            'name' => $this->defaultName,
            'password' => $this->defaultPassword,
        ];

        $response = $this->post('api/register', $user);
        return $response->decodeResponseJson()['user_id'];
    }

   
    public function testSuccessfulWordbaseUpload(): void 
    {
        $user_id = $this->registerUser();

        $file = [
            'file' => new \Illuminate\Http\UploadedFile(resource_path('public\uploads\testword.txt'), 'testword.txt', null, null, true),
            'user_id' => $this->$user_id,
        ];



        $response = $this->post('api/findAnagrams', $file);
        $response->assertOk(); // checks 200
    }

      /**
     * @depends testSuccessfulWordbaseUpload
     */
    public function testSuccessfulFindAnagram(): void
    {

    }
}
