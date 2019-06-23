<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\PostRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_USER")
 */
class MainController extends AbstractController
{
    private const LIMIT = 64;

    /**
     * @param Request $request
     * @param PostRepository $postRepository
     * @return Response
     *
     * @Route("/", name="index")
     */
    public function index(Request $request, PostRepository $postRepository)
    {
        // post request
        if ($request->isXmlHttpRequest()) {
            $offset = $request->get('offset');

            if (!$offset) {
                // if there's no offset then return response with code 400
                throw new HttpException(400);
            }

            /** @var User $currentUser */
            $currentUser = $this->getUser();
            $following = $currentUser->getFollowing();

            $posts = $postRepository->findPosts(
                $currentUser,
                $following,
                self::LIMIT,
                $offset
            );

            if (!$posts) {
                // if there's no posts then return response with code 204
                throw new HttpException(204);
            }

            // return response with list of posts
            return $this->render('post/post.html.twig', [
                'posts' => $posts
            ]);
        }

        /** @var User $currentUser */
        $currentUser = $this->getUser();
        $following = $currentUser->getFollowing();

        $posts = $postRepository->findPosts(
            $currentUser,
            $following,
            self::LIMIT
        );

        // render index page
        return $this->render('main/index.html.twig', [
            'posts' => $posts
        ]);
    }
}