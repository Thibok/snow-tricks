<?php

/**
 * Token Generator
 */

namespace Tests\AppBundle\Generator;

use PHPUnit\Framework\TestCase;
use AppBundle\Generator\TokenGenerator;

/**
 * TokenGeneratorTest
 * @coversDefaultClass \AppBundle\Generator\TokenGenerator
 */
class TokenGeneratorTest extends TestCase
{
    /**
     * Test generate method of TokenGenerator
     * @access public
     * @covers ::generate
     *
     * @return string
     */
    public function testGenerate()
    {
        $generator = new TokenGenerator;

        $code = $generator->generate(80);

        $this->assertSame(80, strlen($code));
    }
}