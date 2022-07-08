<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\File;

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


    public function registerUser()
    {
        $user = [
            'email' => $this->defaultEmail,
            'name' => $this->defaultName,
            'password' => $this->defaultPassword,
        ];

        return $this->post('api/register', $user)->decodeResponseJson();
    }


    public function testSuccessfulWordbaseUpload(): void
    {
        $registerResponse = $this->registerUser();
        $resourcePath = 'public\uploads\testwordCopy.txt';

        File::copy(resource_path('public\uploads\testwordOriginal.txt'), resource_path($resourcePath));

        $file = [
            'file' => new \Illuminate\Http\UploadedFile(resource_path($resourcePath), 'testwordCopy.txt', null, null, true),
            'user_id' => $registerResponse['user_id']
        ];

        $response = $this->json('POST', 'api/uploadWordbase', $file, [ 'HTTP_Authorization' => 'Bearer ' . $registerResponse['token'], 'Accept' => 'application/json']);
        //$this->post('api/uploadWordbase', $file);
        $response->assertOk(); // checks 200
    } 
}
