<?php

/**
 * Controller of Security package
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Security Controller
 */
class SecurityController extends Controller
{
    /**
     * @Route("/inscription", name="registration")
     */
    public function registrationAction(Request $request)
    {
        
    }
}
