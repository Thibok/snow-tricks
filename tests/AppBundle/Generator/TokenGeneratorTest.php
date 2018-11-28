<?php

namespace Tests\AppBundle\Generator;

use PHPUnit\Framework\TestCase;
use AppBundle\Generator\TokenGenerator;

class TokenGeneratorTest extends TestCase
{
    public function testGenerate()
    {
        $generator = new TokenGenerator;

        $code = $generator->generate(80);

        $this->assertSame(80, strlen($code));
    }
}