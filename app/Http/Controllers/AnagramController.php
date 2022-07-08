<?php

namespace App\Http\Controllers;
use App\Models\Word;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\WordParseService;

class AnagramController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    

    protected function findAnagrams(Request $request) 
    {
        $request->word = str_replace(' ', '', $request->word);
        $words = DB::table('words')
                //->where('word', '=', 'dog')
                ->select('word')
                ->where('value', '=', (new WordParseService)->calculateWordValue($request->word))
                ->where('user_id', '=', $request->user_id)
                ->where('length', '=', strlen($request->word))
                ->distinct()
                ->get();

        return $words;
    }
}
