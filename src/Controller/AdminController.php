<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class AdminController
    extends AbstractController
{

    /**
     * @Route("/admin", name="api_admin", methods={"GET"})
     */
    public function index( PostRepository $postRepository, SerializerInterface $serializer ): Response
    {
        $posts     = $postRepository->findBy( [], [ 'id' => 'DESC' ] );
        $postsJson = $serializer->serialize( $posts, 'json' );

        return new JsonResponse( $postsJson, 200, [], true );
    }

    /**
     * @Route("/admin/post/add", name="api_admin_post_add", methods={"POST"})
     */
    public function addPost( Request $request, EntityManagerInterface $manager, SerializerInterface $serializer )
    {
        $postData = [
            'title'   => $request->request->get( 'title' ),
            'content' => $request->request->get( 'content' ),
        ];

        $post = new Post();
        $post->setTitle( $postData['title'] )
             ->setImage( 'https://picsum.photos/1280/790?random=' . rand( 1, 99 ) )
             ->setContent( $postData['content'] );
        $manager->persist( $post );
        $manager->flush();

        $postJson = $serializer->serialize( $post, 'json' );

        return new JsonResponse( $postJson, 200, [], true );
    }
}
