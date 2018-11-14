<?php

namespace AppBundle\Generator;

class TokenGenerator
{
    public function generate($length)
    {
        $length = $length / 2;
        $tokenCode = bin2hex(random_bytes($length));

        return $tokenCode;
    }
}