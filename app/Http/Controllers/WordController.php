<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Word;
use App\Services\WordParseService;

class WordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    protected function uploadWordbase(Request $request)
    {
        $fileKey = 'file';
        
        if ($request->hasFile($fileKey)) {
            $document = $request->file($fileKey);
            $wordArr = (new WordParseService)->parseTxtDocument($document->getRealPath());
            foreach ($wordArr as $word) {
                
                $this->create($word, $request->user_id);
            }
            unlink($document->getRealPath());
        } else {
            return response('Request does not contain valid file', 400);
        }
    }
    protected function create(array $data, int $userId)
    {
        return Word::create([
            'word' => $data['word'],
            'value' => $data['value'],
            'user_id' => $userId,
            'length' => $data['length']
        ]);
    }
}
