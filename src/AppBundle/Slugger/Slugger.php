<?php

namespace AppBundle\Slugger;

class Slugger
{
    public function slugify($value)
    {
        $valueLower = strtolower($value);
        $slug = preg_replace('/ /', '-', $valueLower);

        return $slug;
    }
}