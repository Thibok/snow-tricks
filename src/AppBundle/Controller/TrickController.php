<?php

/**
 * Controller of Community package
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Trick;
use AppBundle\Entity\Comment;
use AppBundle\Form\TrickType;
use AppBundle\Form\CommentType;
use AppBundle\Handler\CommentHandler;
use AppBundle\ParamChecker\CaptchaChecker;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Trick Controller
 */
class TrickController extends Controller
{
    /**
     * @Route("/", name="st_index")
     */
    public function indexAction(Request $request)
    {
        $tricks = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository(Trick::class)
            ->getTricks(1, 10);

        return $this->render('community/index.html.twig', array('tricks' => $tricks));
    }

    /**
     * Add a trick
     * @access public
     * @param Request $request
     * @param CaptchaChecker $captchaChecker
     * @Route("/tricks/add", name="st_add_trick")
     * @Security("has_role('ROLE_MEMBER')")
     * 
     * @return mixed Response | RedirectResponse
     */
    public function addAction(Request $request, CaptchaChecker $captchaChecker)
    {
        $trick = new Trick;
        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $captchaChecker->check() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $trick->setUser($this->getUser());
            $manager->persist($trick);

            try {
                $manager->flush();
                $this->addFlash('notice', 'Success ! Trick was added !');
            } catch(ORMException $e) {
                $this->addFlash('error', 'An error has occurred');
            }

            return $this->redirectToRoute('st_index');
        }

        return $this->render('community/add_trick.html.twig', array('form' => $form->createView(), 'trick' => $trick));
    }

    /**
     * View a Trick with comments or add a comment
     * @access public
     * @param Request $request
     * @param Trick $trick
     * @param CommentHandler $commentHandler
     * @Route("/tricks/details/{slug}", name="st_view_trick", requirements={"slug"="[a-z0-9-]{2,80}"})
     * @ParamConverter("trick")
     * 
     * @return Response
     */
    public function viewAction(Request $request, Trick $trick, CommentHandler $commentHandler)
    {
        $comment = new Comment;
        $form = $this->createForm(CommentType::class, $comment);
        $manager = $this->getDoctrine()->getManager();

        $comments = $manager
            ->getRepository(Comment::class)
            ->getComments($trick->getId(), 1, Comment::COMMENT_PER_PAGE)
        ;

        if ($this->isGranted('IS_AUTHENTICATED_FULLY') && $commentHandler->validateForm($form, $request)) {
            $comment->setTrick($trick)->setUser($this->getUser());
            $manager->persist($comment);

            try {
                $manager->flush();
                $this->addFlash('notice', 'Success ! Comment was added !');
            } catch(ORMException $e) {
                $this->addFlash('error', 'An error has occurred');
            }
        }

        return $this->render(
            'community/view_trick.html.twig',
            array('trick' => $trick, 'form' => $form->createView(), 'comments' => $comments)
        );
    }

    /**
     * Edit a trick
     * @access public
     * @param Request $request
     * @param CaptchaChecker $captchaChecker
     * @param Trick $trick
     * @Route("/tricks/details/{slug}/update", name="st_edit_trick", requirements={"slug"="[a-z0-9-]{2,80}"})
     * @ParamConverter("trick")
     * @Security("has_role('ROLE_MEMBER')")
     * 
     * @return mixed Response | RedirectResponse
     */
    public function editAction(Request $request, CaptchaChecker $captchaChecker, Trick $trick)
    {
        $manager = $this->getDoctrine()->getManager();

        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $captchaChecker->check() && $form->isValid()) {
            foreach ($trick->getImages() as $image) {
                if ($image->getId() == null) {
                    $manager->persist($image);
                }
            }

            foreach ($trick->getVideos() as $video) {
                if ($video->getId() == null) {
                    $manager->persist($video);
                }
            }

            try {
                $manager->flush();
                $this->addFlash('notice', 'Success ! Trick was updated !');
            } catch(ORMException $e) {
                $this->addFlash('error', 'An error has occurred');
            }

            return $this->redirectToRoute('st_index');
        }

        return $this->render('community/edit_trick.html.twig', array('form' => $form->createView(), 'trick' => $trick));
    }

    /**
     * Delete a trick
     * @access public
     * @param Trick $trick
     * @Route("/tricks/details/{slug}/delete", name="st_delete_trick", requirements={"slug"="[a-z0-9-]{2,80}"})
     * @ParamConverter("trick")
     * @Security("has_role('ROLE_MEMBER')")
     * 
     * @return RedirectResponse
     */
    public function deleteAction(Trick $trick)
    {
        $manager = $this->getDoctrine()->getManager();

        $manager->remove($trick);

        try {
            $manager->flush();
            $this->addFlash('notice', 'Success ! Trick was deleted !');
        } catch(ORMException $e) {
            $this->addFlash('error', 'An error has occurred');
        }

        return $this->redirectToRoute('st_index');
    }
}