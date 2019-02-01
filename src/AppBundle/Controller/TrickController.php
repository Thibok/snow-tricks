<?php

/**
 * Controller of Community package
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Trick;
use AppBundle\Form\TrickType;
use AppBundle\ParamChecker\CaptchaChecker;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Trick Controller
 */
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
     * @param CaptchaChecker $captchaChecker
     * @Route("/tricks/add", name="st_add_trick")
     * 
     * @return mixed Response | RedirectResponse
     */
    public function addAction(Request $request, CaptchaChecker $captchaChecker)
    {
        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('st_login');
        }

        $trick = new Trick;
        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $captchaChecker->check() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $trick->setUser($this->getUser());
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

    /**
     * Edit a trick
     * @access public
     * @param Request $request
     * @Route("/tricks/details/{slug}/update", name="st_edit_trick", requirements={"slug"="[a-z0-9-]{2,80}"})
     * 
     * @return void
     */
    public function editAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $trick = $em->getRepository(Trick::class)->getTrick($slug);
        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return;
        }

        return $this->render('community/edit_trick.html.twig', array('form' => $form->createView(), 'trick' => $trick));
    }

    /**
     * Delete a trick
     * @access public
     * @param Request $request
     * @Route("/tricks/details/{slug}/delete", name="st_delete_trick", requirements={"slug"="[a-z0-9-]{2,80}"})
     * 
     * @return void
     */
    public function deleteAction(Request $request)
    {
        return new Response('Ok');
    }
}