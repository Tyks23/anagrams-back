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
            $wordArr = $this->parseTxtDocument($documentLocation);
            foreach($wordArr as $word){
                $this->create($word, $request->user_id);
            }
            unlink($documentLocation);
            //peale parsimist kustuta fail
            //pead saama dokumendi kätte uplodas austast-> jooksutama läbi parseTxtdocument -> panema sõna+numbri+user_id 'words' andmebaasi
            //Storage::disk('local')->put($document, 'Contents');
        } else {
            echo 'no';
        }
        //echo 'has file? ' . $request->hasFile('wordss.txt') ? 'yes' : 'no' . PHP_EOL;
        // storage/app/word.txt:
        //echo 'submission handeled' . $request;  
    }


    protected function parseTxtDocument($document)
    {
        $wordArr = array();
        $handle = fopen($document, "r");
        if ($handle) {
            while (($line = fgets($handle)) != false) {    

                utf8_decode($line);
                //word validation maybe should be function?
                $line = str_replace(array("\r", "\n"), '', $line);
                if(preg_match("/^[a-zäöäü-]+$/", $line, $match))
                {
                    //echo $line . " length is " . strlen($line);
                    //echo $line . " " .  $this->calculateWordValue($line);
                    array_push($wordArr, array("word"=>$line, "value"=>(new WordParseService)->calculateWordValue($line), "length" => strlen($line)));
                }       
            }
            fclose($handle);
        }
        return $wordArr;
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
