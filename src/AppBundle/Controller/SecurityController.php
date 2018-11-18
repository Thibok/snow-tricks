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
     * @Route("/registration", name="st_registration")
     */
    public function registrationAction(Request $request, CaptchaChecker $captchaChecker)
    {
        $user = new User;

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $captchaChecker->check() && $form->isValid()) {
            $token = new Token;
            $token->setType('registration');
            $user->setToken($token);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
                
            try {
                $em->flush();
                $this->addFlash('notice', 'Registration Success !');
                $this->addFlash('notice', 'A confirmation link has been sent to you by email');
            } catch(ORMException $e) {
                $this->addFlash('error', 'An error has occurred');
            }

            return $this->redirectToRoute('st_index');
        }

        return $this->render('security/registration.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/validation-registration/{token}", name="st_valid_registration", requirements={"token"="[a-z0-9]{80}"})
     */
    public function validRegistrationAction(Request $request)
    {
        return new Response('Ok');
    }

    /**
     * @Route("/login", name="st_login")
     */
    public function loginAction()
    {
        return new Response('Ok');
    }
}
