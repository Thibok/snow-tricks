<?php

/**
 * Controller of Community package
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Trick;
use AppBundle\Entity\Comment;
use AppBundle\Form\TrickType;
use AppBundle\Form\CommentType;
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
     * View a Trick with comments
     * @access public
     * @param Request $request
     * @param Trick $trick
     * @Route("/tricks/details/{slug}", name="st_view_trick", requirements={"slug"="[a-z0-9-]{2,80}"})
     * @ParamConverter("trick")
     * 
     * @return void
     */
    public function viewAction(Request $request, Trick $trick)
    {
        $comment = new Comment;
        $form = $this->createForm(CommentType::class, $comment);

        $comments = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository(Comment::class)
            ->getComments($trick->getId(), 1, Comment::COMMENT_PER_PAGE);

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
     * @return void
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