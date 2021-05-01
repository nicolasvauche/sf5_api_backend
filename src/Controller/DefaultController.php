<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class DefaultController
    extends AbstractController
{

    /**
     * @Route("/api", name="api_index", methods={"GET"})
     */
    public function index( PostRepository $postRepository, SerializerInterface $serializer ): Response
    {
        $posts     = $postRepository->findBy( [], [ 'id' => 'DESC' ] );
        $postsJson = $serializer->serialize( $posts, 'json' );

        return new JsonResponse( $postsJson, 200, [], true );
    }
}
