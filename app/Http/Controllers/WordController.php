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

    $destinationPath = 'uploads';
        
        $fileKey = 'file';
        if ($request->hasFile($fileKey)) {
            $document = $request->file($fileKey);    
            $documentName = $document->getClientOriginalName();
            $documentLocation = $destinationPath . "/" . $documentName;
            $document->move($destinationPath, $documentName);       
            $wordArr = (new WordParseService)->parseTxtDocument($documentLocation);
            foreach($wordArr as $word){
                $this->create($word, $request->user_id);
            }
            unlink($documentLocation);
            //peale parsimist kustuta fail
            //pead saama dokumendi kätte uplodas austast-> jooksutama läbi parseTxtdocument -> panema sõna+numbri+user_id 'words' andmebaasi
            //Storage::disk('local')->put($document, 'Contents');
        } else {
            echo 'Request does not contain file';
        }
        //echo 'has file? ' . $request->hasFile('wordss.txt') ? 'yes' : 'no' . PHP_EOL;
        // storage/app/word.txt:
        //echo 'submission handeled' . $request;  
    }


    protected function create(array $data, $user_id)
    {
        return Word::create([
            'word' => $data['word'],
            'value' => $data['value'],
            'user_id' => $user_id,
            'length' => $data['length']
            //how get user_id hmmmm
        ]);
    }
}
