<?php

namespace AppBundle\Slugger;

class Slugger
{
    public function slugify($value)
    {
        $slug = strtolower($value);
        $slug = preg_replace('/ /', '-', $value);

        return $slug;
    }
}