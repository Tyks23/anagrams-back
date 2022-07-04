<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Word;




class WordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

     protected $letterValueArray = array(
        2 => 'a', 3 => 'b', 5 => 'c', 7 => 'd',
        11 => 'e', 13 => 'f', 17 => 'g', 19 => 'h',
        23 => 'i', 29 => 'j', 31 => 'k', 37 => 'l',
        41 => 'm', 43 => 'n', 47 => 'o', 53 => 'p',
        59 => 'q', 61 => 'r', 67 => 's', 71 => 't',
        73 => 'u', 79 => 'v', 83 => 'w', 89 => 'x',
        97 => 'y', 101 => 'z'
    );


    protected function handleSubmission(Request $request)
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
                $this->create($word);
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

    private function calculateWordValue($word)
    {
        
        $wordValue = 0;
        $wordArr = str_split(strtolower(utf8_decode($word)));

        for ($i = 0; $i < count($wordArr); $i++) {
            $wordValue += array_search($wordArr[$i], $this->letterValueArray);
        }

        return $wordValue;
    }

    protected function parseTxtDocument($document)
    {
        $wordArr = array();
        $handle = fopen($document, "r");
        if ($handle) {
            while (($line = fgets($handle)) != false) {
               
                utf8_decode($line);
                $line = str_replace(array("\r", "\n"), '', $line);
                //echo $line . " " .  $this->calculateWordValue($line);
                array_push($wordArr, array("word"=>$line, "value"=>$this->calculateWordValue($line)));
            }
            fclose($handle);
        }
        return $wordArr;
    }

    protected function create(array $data)
    {
        return Word::create([
            'word' => $data['word'],
            'value' => $data['value'],
            'user_id' => 1
            //how get user_id hmmmm
        ]);
    }


}
