<?php

/**
 * Api controller
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Trick;
use AppBundle\Entity\Comment;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * ApiController
 */
class ApiController extends Controller
{
    /**
     * Get comments with Ajax
     * @access public
     * @param Request $request
     * @param int $trickId
     * @param int $nbComments
     * @Route(
     *     "/api/comments/{trickId}/{nbComments}",
     *     name="st_api_comments",
     *     requirements={"trickId"="\d+", "nbComments"="\d+"},
     *     methods={"GET"}
     * )
     * 
     * @return JsonResponse
     */
    public function getCommentsAction(Request $request, $trickId, $nbComments)
    {
        if (!$request->isXmlHttpRequest()) {
            throw $this->createNotFoundException();
        }

        $page = ceil($nbComments / Comment::COMMENT_PER_PAGE + 1);
        $comments = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository(Comment::class)
            ->getComments($trickId, $page, Comment::COMMENT_PER_PAGE);

        $datas = [];

        foreach ($comments as $comment) {
            $user = $comment->getUser();

            if ($this->getParameter('kernel.environment') == 'test') {
                $imgSrc = $user->getImage()->getUploadWebTestThumbPath();
            } else {
                $imgSrc = $user->getImage()->getUploadWebThumbPath();
            }
            
            $data = [
                'imgSrc' => $imgSrc,
                'author' => $user->getFirstName() .' '. $user->getName(),
                'content' => $comment->getContent(),
                'date' => $comment->getAddAt()->format('d-m-Y \a\t H\hi\m\i\n s\s')
            ];

            $datas[] = $data;
        }

        return new JsonResponse($datas);
    }

    /**
     * Delete a Trick with Ajax
     * @access public
     * @param Request $request
     * @param string $slug
     * @Route(
     *     "/api/trick/{slug}/delete",
     *     name="st_api_trick_delete",
     *     requirements={"slug"="[a-z0-9-]{2,80}"},
     *     methods={"DELETE"}
     * )
     * 
     * @return JsonResponse
     */
    public function deleteTrickAction(Request $request, $slug)
    {
        if (!$request->isXmlHttpRequest()) {
            throw $this->createNotFoundException();
        }

        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            $response = [
                'result' => false,
                'message' => 'You are not authenticating !'
            ];
            return new JsonResponse($response);
        }

        $manager = $this->getDoctrine()->getManager();

        $trick = $manager->getRepository(Trick::class)->getTrick($slug);

        if ($trick == null) {
            throw $this->createNotFoundException();
        }

        $manager->remove($trick);
        $manager->flush();

        $response = [
            'result' => true,
            'message' => 'Success ! Trick was deleted !'
        ];

        return new JsonResponse($response);
    }
}