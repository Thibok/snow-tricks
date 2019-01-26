<?php

/**
 * Slugger Test
 */

namespace Tests\AppBundle\Slugger;

use AppBundle\Slugger\Slugger;
use PHPUnit\Framework\TestCase;

/**
 * SluggerTest
 * @coversDefaultClass \AppBundle\Slugger\Slugger
 */
class SluggerTest extends TestCase
{
    /**
     * Test slugify method of Slugger
     * @access public
     * @covers ::slugify
     *
     * @return void
     */
    public function testSlugify()
    {
        $slugger = new Slugger;

        $slug = $slugger->slugify('A GOOD NAME FOR A TRICK');

        $this->assertSame('a-good-name-for-a-trick', $slug);
    }
}