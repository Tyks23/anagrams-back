<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('home');
    }

    protected function calculateWordValue($word) 
    {
        $letterValueArray = array(
            2 => 'a', 3 => 'b', 5 => 'c', 7 => 'd',
            11 => 'e', 13 => 'f', 17 => 'g', 19 => 'h',
            23 => 'i', 29 => 'j', 31 => 'k', 37 => 'l',
            41 => 'm', 43 => 'n', 47 => 'o', 53 => 'p',
            59 => 'q', 61 => 'r', 67 => 's', 71 => 't',
            73 => 'u', 79 => 'v', 83 => 'w', 89 => 'x',
            97 => 'y', 101 => 'z',
        );
        $wordValue = 0;
        $wordArr = str_split(strtolower(utf8_decode($word)));
    
        for($i = 0; $i < count($wordArr); $i++)
        {
            $wordValue += array_search($wordArr[$i], $letterValueArray);
        }
        
        return $wordValue;
    }


    protected function handleSubmission(Request $request) 
    {
        $file = $request->file();
    }
}
