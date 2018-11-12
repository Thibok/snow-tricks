<?php

/**
 * Controller of Security package
 */

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Entity\Token;
use AppBundle\Form\UserType;
use Doctrine\ORM\ORMException;
use AppBundle\ParamChecker\CaptchaChecker;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Security Controller
 */
class SecurityController extends Controller
{
    /**
     * @Route("/registration", name="registration")
     */
    public function registrationAction(Request $request, CaptchaChecker $captchaChecker)
    {
        $user = new User;

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($captchaChecker->check() && $form->isValid()) {
                $token = new Token;
                $token->setType('registration');
                $user->setToken($token);

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                
                try {
                    $em->flush();
                    $this->addFlash('notice', 'Registration Success !');
                    $this->addFlash('notice', 'A confirmation link has been sent to you by email');
                    $this->redirectToRoute('registration');
                } catch(ORMException $e) {
                    $this->addFlash('error', 'An error has occurred');
                    $this->redirectToRoute('registration');
                }
            }
        }

        return $this->render('community/registration.html.twig', array('form' => $form->createView()));
    }
}
