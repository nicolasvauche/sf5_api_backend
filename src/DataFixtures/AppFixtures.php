<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Post;
use Faker;

class AppFixtures
    extends Fixture
{

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
    }
}
