<?php

/**
 * Token Generator
 */

namespace AppBundle\Generator;

/**
 * TokenGenerator
 */
class TokenGenerator
{
    /**
     * Generate a ramdom token code
     * @access public
     * @param int $length
     * 
     * @return string
     */
    public function generate($length)
    {
        $length = $length / 2;
        $tokenCode = bin2hex(random_bytes($length));

        return $tokenCode;
    }
}