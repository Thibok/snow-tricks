<?php

/**
 * Slugger (Service)
 */

namespace AppBundle\Slugger;

/**
 * Slugger
 */
class Slugger
{
    /**
     * Convert string to slug (url)
     * @access public
     * @param string $value
     * 
     * @return string
     */
    public function slugify($value)
    {
        $valueLower = strtolower($value);
        $slug = preg_replace('/ /', '-', $valueLower);

        return $slug;
    }
}