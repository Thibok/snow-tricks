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
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Security Controller
 */
class SecurityController extends Controller
{
    /**
     * Registration
     * @access public
     * @param Request $request
     * @param CaptchaChecker $captchaChecker
     * @Route("/registration", name="st_registration")
     * 
     * @return mixed Response | RedirectResponse
     */
    public function registrationAction(Request $request, CaptchaChecker $captchaChecker)
    {
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('st_index');
        }

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
     * /**
     * Validation Registration
     * @access public
     * @param Request $request
     * @param string $tokenCode
     * @Route("/registration/validation/{tokenCode}", name="st_valid_registration", requirements={"tokenCode"="[a-z0-9]{80}"})
     * 
     * @return RedirectResponse
     */
    public function validRegistrationAction(Request $request, $tokenCode)
    {
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('st_index');
        }

        $em = $this->getDoctrine()->getManager();
        $token = $em->getRepository(Token::class)->getTokenWithUser($tokenCode);
        $actualDate = new \DateTime;

        if ($token == null || $token->getType() != 'registration' || $token->getExpirationDate() <= $actualDate) {
            throw $this->createNotFoundException();
        }
        
        $user = $token->getUser();
        $user->setIsActive(true);
        $em->remove($token);

        try {
            $em->flush();
            $this->addFlash('notice', 'Valid registration !');
        } catch(ORMException $e) {
            $this->addFlash('error', 'An error has occurred');
        }

        return $this->redirectToRoute('st_index');
    }

    /**
     * @Route("/login", name="st_login")
     */
    public function loginAction(AuthenticationUtils $authenticationUtils)
    {
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('st_index');
        }

        return $this->render('security/login.html.twig', array(
            'last_username' => $authenticationUtils->getLastUsername(),
            'error'         => $authenticationUtils->getLastAuthenticationError(),
        ));
    }

    /**
     * @Route("/logout", name="st_logout")
     */
    public function logoutAction() 
    {
        
    }
}
