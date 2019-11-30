<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    private const LIMIT = 64;

    /**
     * @param Request $request
     * @param UserRepository $userRepository
     * @throws HttpException
     * @return Response
     *
     * @Route("/search", name="search")
     * @IsGranted("ROLE_USER")
     */
    public function search(Request $request, UserRepository $userRepository)
    {
        // post request
        if ($request->isMethod('POST')) {
            $query = $request->get('query');
            // if request haven't offset then offset is zero
            $offset = $request->get('offset') ?? 0;
            $users = $userRepository->search(
                $query,
                self::LIMIT,
                $offset
            );

            if (!$users) {
                // if there's no results then return response with code 204
                throw new HttpException(204);
            }

            // return response with list of users
            return $this->render('user/user.html.twig', [
                'users' => $users
            ]);
        }

        // render search page
        return $this->render('search/search.html.twig');
    }
}