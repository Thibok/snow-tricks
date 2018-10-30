<?php

/**
 * Controller of Security package
 */

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use AppBundle\ParamChecker\CaptchaChecker;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
        $user = new User;

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        return $this->render('community/registration.html.twig', array('form' => $form->createView()));
    }
}
