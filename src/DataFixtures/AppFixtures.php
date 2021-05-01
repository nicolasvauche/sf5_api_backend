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
        $faker = Faker\Factory::create( 'fr_FR' );

        $posts = array();
        for( $i = 0; $i < 10; $i ++ ) {
            $posts[ $i ] = new Post();
            $posts[ $i ]->setTitle( $faker->sentence )
                        ->setImage( 'https://picsum.photos/1280/790?random=' . rand(1, 99) )
                        ->setContent( $faker->paragraph );

            $manager->persist( $posts[ $i ] );
        }
        $manager->flush();

        $user = new User();
        $user->setName( 'Utilisateur test' )
             ->setApiToken( $this->encoder->encodePassword( $user, 'test' ) )
             ->setRoles( [ 'ROLE_USER' ] )
             ->setIsValid( true );
        $manager->persist( $user );
        $manager->flush();
    }
}
