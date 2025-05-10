<?php

namespace App\DataFixtures;

use App\Factory\AnimeFactory;
use App\Factory\MovieFactory;
use App\Factory\GenreFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        GenreFactory::createMany(10);
        AnimeFactory::createMany(10);
        MovieFactory::createMany(10);
        $manager->flush();
    }
}
