<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Trick;
use AppBundle\Form\TrickType;
use AppBundle\ParamChecker\CaptchaChecker;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TrickController extends Controller
{
    /**
     * @Route("/", name="st_index")
     */
    public function indexAction()
    {
        return $this->render('community/index.html.twig');
    }

    /**
     * Add a trick
     * @access public
     * @param Request $request
     * @Route("/tricks/add", name="st_add_trick")
     * 
     * @return void
     * 
     */
    public function addAction(Request $request, CaptchaChecker $captchaChecker)
    {
        $trick = new Trick;
        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $captchaChecker->check() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($trick);

            try {
                $em->flush();
                $this->addFlash('notice', 'Success ! Trick was added !');
            } catch(ORMException $e) {
                $this->addFlash('error', 'An error has occurred');
            }

            return $this->redirectToRoute('st_index');
        }

        return $this->render('community/add_trick.html.twig', array('form' => $form->createView()));
    }
}