namespace App\Services;

class WordParsingService extends Service
{
    protected $letterValueArray = array(
        2 => 'a', 3 => 'b', 5 => 'c', 7 => 'd',
        11 => 'e', 13 => 'f', 17 => 'g', 19 => 'h',
        23 => 'i', 29 => 'j', 31 => 'k', 37 => 'l',
        41 => 'm', 43 => 'n', 47 => 'o', 53 => 'p',
        59 => 'q', 61 => 'r', 67 => 's', 71 => 't',
        73 => 'u', 79 => 'v', 83 => 'w', 89 => 'x',
        97 => 'y', 101 => 'z', 103 => 'õ', 107 => 'ä',
        109 => 'ö', 113 => 'ü', 1 => '-'
    );

    private function calculateWordValue($word)
    {
        $wordValue = 1;
        $wordArr = str_split(strtolower(utf8_decode($word)));

        for ($i = 0; $i < count($wordArr); $i++) {    
            $wordValue *= array_search(utf8_encode($wordArr[$i]), $this->letterValueArray);
        }
        
        return $wordValue;
    }
}