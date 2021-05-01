<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Post;
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures
    extends Fixture
{
    private $encoder;

    public function __construct( UserPasswordEncoderInterface $encoder )
    {
        $this->encoder = $encoder;
    }

    public function load( ObjectManager $manager )
    {
        // Faker
        $faker = Faker\Factory::create( 'fr_FR' );

        // Posts
        $posts = array();
        for( $i = 0; $i < 10; $i ++ ) {
            $posts[ $i ] = new Post();
            $posts[ $i ]->setTitle( $faker->sentence )
                        ->setImage( 'https://picsum.photos/1280/790?random=' . rand(1, 99) )
                        ->setContent( $faker->paragraph );

            $manager->persist( $posts[ $i ] );
        }
        $manager->flush();

        // Users
        $user1 = new User();
        $user1->setName( 'Utilisateur test' )
             ->setApiToken( $this->encoder->encodePassword( $user1, 'test' ) )
             ->setRoles( [ 'ROLE_USER' ] )
             ->setIsValid( true );
        $manager->persist( $user1 );

        $user2 = new User();
        $user2->setName( 'Administrateur' )
              ->setApiToken( $this->encoder->encodePassword( $user2, 'test' ) )
              ->setRoles( [ 'ROLE_ADMIN' ] )
              ->setIsValid( true );
        $manager->persist( $user2 );
        $manager->flush();
    }
}
