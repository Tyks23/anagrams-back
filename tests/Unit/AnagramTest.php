<?php

namespace Tests\Unit;

use App\Services\WordParseService;
use PHPUnit\Framework\TestCase;

use function PHPSTORM_META\map;

class AnagramTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    public function testWordValueCalculator(): void
    {
        $service=(new WordParseService);

        $this->assertEquals($service->calculateWordValue('käis'), 5111497.0);
        $this->assertEquals($service->calculateWordValue('käis'), $service->calculateWordValue('käsi'));

        $this->assertEquals($service->calculateWordValue('automaatne'), 2683319581624.0);
        $this->assertEquals($service->calculateWordValue('automaatne'), $service->calculateWordValue('automaante'));

        $this->assertEquals($service->calculateWordValue('koer'), 977647.0);
        $this->assertEquals($service->calculateWordValue('koer'), $service->calculateWordValue('erok'));
        
        $this->assertEquals($service->calculateWordValue('su-per'), 173938633.0);
        $this->assertEquals($service->calculateWordValue('su-per'), $service->calculateWordValue('usrep'));

    }
}
